<?php

namespace App\Services;

use App\Models\AnggotaDewan;
use App\Models\HeroSlide;
use App\Models\NavMenu;
use App\Models\UnitPendidikan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CmsAutoHealService
{
    /**
     * Ensure schema columns for multi-unit education content exist (fail-safe for cPanel).
     */
    public static function ensureUnitPendidikanSchemaExists(): void
    {
        try {
            if (Schema::hasTable('dewan_asatidz') && ! Schema::hasColumn('dewan_asatidz', 'unit_pendidikan_id')) {
                Schema::table('dewan_asatidz', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('testimonials') && ! Schema::hasColumn('testimonials', 'unit_pendidikan_id')) {
                Schema::table('testimonials', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('posts') && ! Schema::hasColumn('posts', 'unit_pendidikan_id')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('author_id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('videos') && ! Schema::hasColumn('videos', 'unit_pendidikan_id')) {
                Schema::table('videos', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('id');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'unit_pendidikan_id')) {
                Schema::table('users', function (Blueprint $table) {
                    $table->unsignedBigInteger('unit_pendidikan_id')->nullable()->after('role');
                    $table->index('unit_pendidikan_id');
                });
            }

            if (Schema::hasTable('unit_pendidikans')) {
                Schema::table('unit_pendidikans', function (Blueprint $table) {
                    if (! Schema::hasColumn('unit_pendidikans', 'sambutan')) {
                        $table->text('sambutan')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'visi')) {
                        $table->text('visi')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'misi')) {
                        $table->text('misi')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'hero_image')) {
                        $table->string('hero_image')->nullable();
                    }
                    if (! Schema::hasColumn('unit_pendidikans', 'head_photo')) {
                        $table->string('head_photo')->nullable();
                    }
                });
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureUnitPendidikanSchemaExists error: '.$e->getMessage());
        }
    }

    /**
     * Ensure nav_menus table exists and is populated with default pesantren navigation.
     */
    public static function ensureNavMenusTableExists(): void
    {
        try {
            if (! Schema::hasTable('nav_menus')) {
                Schema::create('nav_menus', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('parent_id')->nullable()->constrained('nav_menus')->nullOnDelete();
                    $table->string('name');
                    $table->string('url');
                    $table->string('icon')->nullable();
                    $table->string('location')->default('header'); // header, footer_quick, footer_info
                    $table->string('target')->default('_self'); // _self, _blank
                    $table->integer('order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }

            // If empty, seed default menu items
            if (NavMenu::count() === 0) {
                self::seedDefaultNavMenus();
            } else {
                // Ensure no orphaned standalone Khutbah or Ikarus at top-level header
                NavMenu::where('location', 'header')
                    ->whereNull('parent_id')
                    ->whereIn('url', ['/khutbah', '/ikarus'])
                    ->delete();

                // Ensure Profil dropdown contains IKARUS if missing
                $profil = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Profil')->first();
                if ($profil && ! NavMenu::where('parent_id', $profil->id)->where('url', '/ikarus')->exists()) {
                    NavMenu::create([
                        'parent_id' => $profil->id,
                        'name' => 'Ikatan Alumni (IKARUS)',
                        'url' => '/ikarus',
                        'icon' => 'fa-solid fa-user-graduate',
                        'location' => 'header',
                        'order' => 9,
                    ]);
                }

                // Ensure Informasi dropdown contains Khutbah if missing
                $info = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Informasi')->first();
                if ($info && ! NavMenu::where('parent_id', $info->id)->where('url', '/khutbah')->exists()) {
                    NavMenu::create([
                        'parent_id' => $info->id,
                        'name' => 'Khutbah Jum\'at & Tausiyah',
                        'url' => '/khutbah',
                        'icon' => 'fa-solid fa-microphone-lines',
                        'location' => 'header',
                        'order' => 6,
                    ]);
                }

                // Ensure Pendidikan dropdown contains all active unit pendidikans
                $pendidikan = NavMenu::where('location', 'header')->whereNull('parent_id')->where('name', 'Pendidikan')->first();
                if ($pendidikan && Schema::hasTable('unit_pendidikans')) {
                    $hasChildren = NavMenu::where('parent_id', $pendidikan->id)->exists();
                    if (! $hasChildren) {
                        $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();
                        foreach ($units as $u) {
                            $cleanName = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $u->name));
                            NavMenu::create([
                                'parent_id' => $pendidikan->id,
                                'name' => $cleanName,
                                'url' => '/pendidikan/'.$u->slug,
                                'icon' => 'fa-solid fa-graduation-cap',
                                'location' => 'header',
                                'order' => $u->order ?: 1,
                            ]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureNavMenusTableExists error: '.$e->getMessage());
        }
    }

    /**
     * Ensure hero_slides table exists and has default slides.
     */
    public static function ensureHeroSlidesTableExists(): void
    {
        try {
            if (! Schema::hasTable('hero_slides')) {
                Schema::create('hero_slides', function (Blueprint $table) {
                    $table->id();
                    $table->string('title');
                    $table->text('subtitle')->nullable();
                    $table->string('badge')->nullable()->default('Pondok Pesantren Raudhatul Ulum Sakatiga');
                    $table->string('image')->default('/uploads/official/drone-raudhatul-ulum.webp');
                    $table->string('btn_primary_text')->nullable()->default('Profil Singkat Pesantren');
                    $table->string('btn_primary_url')->nullable()->default('/tentang-kami');
                    $table->string('btn_secondary_text')->nullable()->default('Pendaftaran PSB');
                    $table->string('btn_secondary_url')->nullable()->default('/ppdb');
                    $table->integer('order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });
            }

            if (HeroSlide::count() === 0) {
                self::seedDefaultHeroSlides();
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureHeroSlidesTableExists error: '.$e->getMessage());
        }
    }

    /**
     * Ensure core 8 leaders of Yayasan YAPIRUS & Pesantren exist in dewan_asatidz.
     */
    public static function ensureDewanAsatidzSeeded(): void
    {
        try {
            if (! Schema::hasTable('dewan_asatidz')) {
                return;
            }

            $leaders = [
                [
                    'name' => 'Drs. KH. Karim Kasim',
                    'position' => 'Ketua Dewan Pembina YAPIRUS',
                    'fraction' => 'Yayasan',
                    'order' => 1,
                    'profile_summary' => 'Pendiri & Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'S1 IAIN Raden Fatah',
                ],
                [
                    'name' => 'H. Faisal Abdullah, S.T.',
                    'position' => 'Ketua Umum Pengurus YAPIRUS',
                    'fraction' => 'Yayasan',
                    'order' => 2,
                    'profile_summary' => 'Ketua Umum Pengurus Harian Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'S1 Teknik Universitas Sriwijaya',
                ],
                [
                    'name' => "KH. Tol'at Wafa Ahmad, Lc.",
                    'position' => 'Mudir Pondok Pesantren Raudhatul Ulum',
                    'fraction' => 'Yayasan',
                    'order' => 3,
                    'profile_summary' => 'Pimpinan Utama (Mudir Ma\'had) Pondok Pesantren Raudhatul Ulum Sakatiga sejak 1986.',
                    'education' => 'S1 Universitas Al-Azhar Kairo Mesir',
                ],
                [
                    'name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                    'position' => 'Sekretaris Yayasan YAPIRUS',
                    'fraction' => 'Yayasan',
                    'order' => 4,
                    'profile_summary' => 'Sekretaris Pengurus Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'S1 Pendidikan Islam',
                ],
                [
                    'name' => 'H. M. Husin, M.Si.',
                    'position' => 'Bendahara Yayasan YAPIRUS',
                    'fraction' => 'Yayasan',
                    'order' => 5,
                    'profile_summary' => 'Bendahara Umum Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'S2 Manajemen',
                ],
                [
                    'name' => 'Ustadz H. Abdul Halim, Lc.',
                    'position' => 'Wakil Mudir Bidang Pendidikan & Pengajaran',
                    'fraction' => 'Yayasan',
                    'order' => 6,
                    'profile_summary' => 'Wakil Mudir I Bidang Pendidikan, Kurikulum Nasional & Muadalah Al-Azhar.',
                    'education' => 'S1 Universitas Al-Azhar Kairo Mesir',
                ],
                [
                    'name' => 'Ustadz H. Syamsuddin, S.Ag.',
                    'position' => 'Wakil Mudir Bidang Kepengasuhan Santri',
                    'fraction' => 'Yayasan',
                    'order' => 7,
                    'profile_summary' => 'Wakil Mudir II Bidang Pengasuhan, Kedisiplinan Asrama & Karakter Santri.',
                    'education' => 'S1 IAIN Raden Fatah',
                ],
                [
                    'name' => 'Ir. H. Ahmad Fauzi',
                    'position' => 'Wakil Mudir Bidang Pembangunan & Sarana',
                    'fraction' => 'Yayasan',
                    'order' => 8,
                    'profile_summary' => 'Wakil Mudir III Bidang Sarana Prasarana, Infrastruktur & Aset Wakaf.',
                    'education' => 'S1 Teknik Sipil',
                ],
            ];

            foreach ($leaders as $leader) {
                $existing = AnggotaDewan::where('name', $leader['name'])->first();
                if (! $existing) {
                    AnggotaDewan::create([
                        'name' => $leader['name'],
                        'slug' => Str::slug($leader['name']),
                        'position' => $leader['position'],
                        'fraction' => $leader['fraction'],
                        'order' => $leader['order'],
                        'profile_summary' => $leader['profile_summary'],
                        'education' => $leader['education'],
                        'photo' => '/uploads/default-avatar.webp',
                    ]);
                } else {
                    $existing->update([
                        'position' => $existing->position ?: $leader['position'],
                        'fraction' => 'Yayasan',
                        'order' => $leader['order'],
                    ]);
                }
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureDewanAsatidzSeeded error: '.$e->getMessage());
        }
    }

    /**
     * Ensure all core CMS tables exist (fail-safe for cPanel).
     */
    public static function ensureAllCoreTablesExist(): void
    {
        self::ensureUnitPendidikanSchemaExists();
        self::ensureHeroSlidesTableExists();
        self::ensureNavMenusTableExists();
        self::ensureDewanAsatidzSeeded();
    }

    /**
     * Seed comprehensive default navigation for PPRU.
     */
    public static function seedDefaultNavMenus(): void
    {
        // 1. Beranda
        NavMenu::create([
            'name' => 'Beranda',
            'url' => '/',
            'icon' => 'fa-solid fa-house',
            'location' => 'header',
            'order' => 1,
            'is_active' => true,
        ]);

        // 2. Profil (Dropdown)
        $profil = NavMenu::create([
            'name' => 'Profil',
            'url' => '#',
            'icon' => 'fa-solid fa-landmark-dome',
            'location' => 'header',
            'order' => 2,
            'is_active' => true,
        ]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sambutan Mudir PPRU', 'url' => '/sambutan', 'icon' => 'fa-solid fa-user-tie', 'location' => 'header', 'order' => 1]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Profil Singkat Pesantren', 'url' => '/tentang-kami', 'icon' => 'fa-solid fa-landmark-dome', 'location' => 'header', 'order' => 2]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Visi, Misi & 10 Jati Diri', 'url' => '/visi-dan-misi', 'icon' => 'fa-solid fa-compass', 'location' => 'header', 'order' => 3]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sejarah Sejak 1930 & 1950', 'url' => '/sejarah', 'icon' => 'fa-solid fa-clock-rotate-left', 'location' => 'header', 'order' => 4]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Dewan Asatidz & Guru', 'url' => '/dewan-guru', 'icon' => 'fa-solid fa-chalkboard-user', 'location' => 'header', 'order' => 5]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Struktur Organisasi & Pengasuh', 'url' => '/struktur-organisasi', 'icon' => 'fa-solid fa-sitemap', 'location' => 'header', 'order' => 6]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sarana & Fasilitas Pondok', 'url' => '/fasilitas', 'icon' => 'fa-solid fa-layer-group', 'location' => 'header', 'order' => 7]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Program Unggulan Pesantren', 'url' => '/program-unggulan', 'icon' => 'fa-solid fa-star-and-crescent', 'location' => 'header', 'order' => 8]);
        NavMenu::create(['parent_id' => $profil->id, 'name' => 'Ikatan Alumni (IKARUS)', 'url' => '/ikarus', 'icon' => 'fa-solid fa-user-graduate', 'location' => 'header', 'order' => 9]);

        // 3. Pendidikan (Dropdown with all units)
        $pendidikan = NavMenu::create([
            'name' => 'Pendidikan',
            'url' => '/pendidikan',
            'icon' => 'fa-solid fa-building-columns',
            'location' => 'header',
            'order' => 3,
            'is_active' => true,
        ]);

        if (Schema::hasTable('unit_pendidikans')) {
            $units = UnitPendidikan::active()->orderBy('order', 'asc')->get();
            foreach ($units as $u) {
                $cleanName = trim(preg_replace('/\s*\([^)]*\)\s*$/', '', $u->name));
                NavMenu::create([
                    'parent_id' => $pendidikan->id,
                    'name' => $cleanName,
                    'url' => '/pendidikan/'.$u->slug,
                    'icon' => 'fa-solid fa-graduation-cap',
                    'location' => 'header',
                    'order' => $u->order ?: 1,
                ]);
            }
        }

        // 4. Informasi (Dropdown)
        $info = NavMenu::create([
            'name' => 'Informasi',
            'url' => '#',
            'icon' => 'fa-solid fa-newspaper',
            'location' => 'header',
            'order' => 4,
            'is_active' => true,
        ]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Berita & Kabar Pondok', 'url' => '/artikel', 'icon' => 'fa-solid fa-newspaper', 'location' => 'header', 'order' => 1]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Prestasi Santri & Guru', 'url' => '/prestasi', 'icon' => 'fa-solid fa-trophy', 'location' => 'header', 'order' => 2]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Agenda & Kalender', 'url' => '/agenda', 'icon' => 'fa-solid fa-calendar-days', 'location' => 'header', 'order' => 3]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Pengumuman Resmi', 'url' => '/pengumuman', 'icon' => 'fa-solid fa-bullhorn', 'location' => 'header', 'order' => 4]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Karya Santri & Asatidz', 'url' => '/karya-santri', 'icon' => 'fa-solid fa-feather-pointed', 'location' => 'header', 'order' => 5]);
        NavMenu::create(['parent_id' => $info->id, 'name' => 'Khutbah Jum\'at & Tausiyah', 'url' => '/khutbah', 'icon' => 'fa-solid fa-microphone-lines', 'location' => 'header', 'order' => 6]);

        // 5. Layanan
        NavMenu::create([
            'name' => 'Layanan',
            'url' => '/layanan',
            'icon' => 'fa-solid fa-handshake-angle',
            'location' => 'header',
            'order' => 5,
            'is_active' => true,
        ]);

        // 6. Kontak
        NavMenu::create([
            'name' => 'Kontak',
            'url' => '/kontak',
            'icon' => 'fa-solid fa-address-book',
            'location' => 'header',
            'order' => 6,
            'is_active' => true,
        ]);

        // 7. PSB / PPDB
        NavMenu::create([
            'name' => 'PPDB Online',
            'url' => '/ppdb',
            'icon' => 'fa-solid fa-user-plus',
            'location' => 'header',
            'order' => 7,
            'is_active' => true,
        ]);

        // Footer Menus
        NavMenu::create(['name' => 'Tentang PPRU', 'url' => '/tentang-kami', 'location' => 'footer_quick', 'order' => 1]);
        NavMenu::create(['name' => 'Unit Pendidikan', 'url' => '/pendidikan', 'location' => 'footer_quick', 'order' => 2]);
        NavMenu::create(['name' => 'Pendaftaran PPDB', 'url' => '/ppdb', 'location' => 'footer_quick', 'order' => 3]);
        NavMenu::create(['name' => 'Khutbah & Dakwah', 'url' => '/khutbah', 'location' => 'footer_quick', 'order' => 4]);
        NavMenu::create(['name' => 'Portal Alumni IKARUS', 'url' => '/ikarus', 'location' => 'footer_quick', 'order' => 5]);
        NavMenu::create(['name' => 'Pusat Unduhan', 'url' => '/unduhan', 'location' => 'footer_quick', 'order' => 6]);
        NavMenu::create(['name' => 'Layanan Pesantren', 'url' => '/layanan', 'location' => 'footer_quick', 'order' => 7]);
    }

    /**
     * Seed default hero slides.
     */
    public static function seedDefaultHeroSlides(): void
    {
        HeroSlide::create([
            'title' => 'Mencetak Generasi Ulama dan Pemimpin Umat',
            'subtitle' => 'Pondok Pesantren Raudhatul Ulum Sakatiga Ogan Ilir Sumatera Selatan memadukan kurikulum kepesantrenan, tahfizh Quran, dan sains modern sejak 1950.',
            'badge' => 'Selamat Datang di Portal Resmi PPRU',
            'image' => '/uploads/hero-slide-1.webp',
            'btn_primary_text' => 'Daftar Santri Baru (PSB)',
            'btn_primary_url' => '/ppdb',
            'btn_secondary_text' => 'Jelajahi Pesantren',
            'btn_secondary_url' => '/tentang-kami',
            'order' => 1,
            'is_active' => true,
        ]);

        HeroSlide::create([
            'title' => 'Pendidikan Islam Berkelanjutan dari Usia Dini hingga Perguruan Tinggi',
            'subtitle' => 'Menaungi 8 unit lembaga pendidikan terpadu: TK Islam, MI, MTs, MA, MATQULA, SMPIT, SMAIT, hingga Institut Agama Islam Nur Raudhatul Ulum.',
            'badge' => '8 Unit Pendidikan Terpadu',
            'image' => '/uploads/hero-slide-2.webp',
            'btn_primary_text' => 'Lihat Semua Unit',
            'btn_primary_url' => '/pendidikan',
            'btn_secondary_text' => 'Program Unggulan',
            'btn_secondary_url' => '/program-unggulan',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
