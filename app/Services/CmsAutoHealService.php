<?php

namespace App\Services;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\HeroSlide;
use App\Models\NavMenu;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\Video;
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

                // Auto-heal: reset head_photo to neutral gray avatar if empty or pointing to activity photos
                UnitPendidikan::query()->each(function ($unit) {
                    if (empty($unit->head_photo)
                        || str_contains($unit->head_photo, '/uploads/official/')
                        || str_contains($unit->head_photo, 'kbm-santri')
                        || str_contains($unit->head_photo, 'kegiatan-santri')
                        || str_contains($unit->head_photo, 'panahan-santri')
                        || str_contains($unit->head_photo, 'drone-')
                        || str_contains($unit->head_photo, 'ngaji-sore')) {
                        $unit->update(['head_photo' => '/uploads/avatar-neutral-gray.svg']);
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
                // Ensure no orphaned standalone Khutbah, Ikarus, Kontak, or PPDB at top-level header
                NavMenu::where('location', 'header')
                    ->whereNull('parent_id')
                    ->where(function ($q) {
                        $q->whereIn('url', ['/khutbah', '/ikarus', '/kontak', '/hubungi', '/ppdb'])
                            ->orWhere('name', 'like', '%Khutbah%')
                            ->orWhere('name', 'like', '%IKARUS%')
                            ->orWhere('name', 'like', '%Kontak%')
                            ->orWhere('name', 'like', '%PPDB%')
                            ->orWhere('name', 'like', '%PSB%');
                    })
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

                // Ensure Layanan exists at root level (order 5)
                $layanan = NavMenu::where('location', 'header')->whereNull('parent_id')->where(function ($q) {
                    $q->where('name', 'like', '%Layanan%')->orWhere('url', 'like', '%layanan%');
                })->first();

                if (! $layanan) {
                    $layanan = NavMenu::create([
                        'name' => 'Layanan',
                        'url' => '/layanan-terpadu',
                        'icon' => 'fa-solid fa-handshake-angle',
                        'location' => 'header',
                        'order' => 5,
                        'is_active' => true,
                    ]);
                } else {
                    $layanan->update(['order' => 5, 'name' => 'Layanan', 'url' => '/layanan-terpadu', 'is_active' => true]);
                }

                // Ensure 3 Layanan Publik & Layanan Terpadu exist as children of Layanan
                $layananItems = [
                    [
                        'name' => 'Permohonan Izin Kunjungan Sekolah',
                        'url' => '/izin-sekolah',
                        'icon' => 'fa-solid fa-school',
                        'order' => 1,
                    ],
                    [
                        'name' => 'Permohonan Kerja Sama',
                        'url' => '/permohonan-kerja-sama',
                        'icon' => 'fa-solid fa-handshake',
                        'order' => 2,
                    ],
                    [
                        'name' => 'Permohonan Sewa Fasilitas & Sarana',
                        'url' => '/sewa-barang',
                        'icon' => 'fa-solid fa-building-user',
                        'order' => 3,
                    ],
                    [
                        'name' => 'Portal Layanan Terpadu',
                        'url' => '/layanan-terpadu',
                        'icon' => 'fa-solid fa-circle-nodes',
                        'order' => 4,
                    ],
                    [
                        'name' => 'Brosur & Rincian Biaya',
                        'url' => '/download',
                        'icon' => 'fa-solid fa-file-pdf',
                        'order' => 5,
                    ],
                    [
                        'name' => 'Download Logo Resmi',
                        'url' => '/logo',
                        'icon' => 'fa-solid fa-image',
                        'order' => 6,
                    ],
                    [
                        'name' => 'Kontak & Lokasi Humas',
                        'url' => '/hubungi',
                        'icon' => 'fa-solid fa-address-book',
                        'order' => 7,
                    ],
                ];

                foreach ($layananItems as $item) {
                    $child = NavMenu::where('parent_id', $layanan->id)
                        ->where(function ($q) use ($item) {
                            $q->where('url', $item['url'])
                                ->orWhere('name', $item['name'])
                                ->orWhere('url', 'like', '%'.trim($item['url'], '/').'%');
                        })->first();

                    if (! $child) {
                        NavMenu::create([
                            'parent_id' => $layanan->id,
                            'name' => $item['name'],
                            'url' => $item['url'],
                            'icon' => $item['icon'],
                            'location' => 'header',
                            'order' => $item['order'],
                            'is_active' => true,
                        ]);
                    } else {
                        $child->update([
                            'name' => $item['name'],
                            'url' => $item['url'],
                            'icon' => $item['icon'],
                            'order' => $item['order'],
                            'is_active' => true,
                        ]);
                    }
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
     * Ensure the 8 official leaders of PPRU & YAPIRUS exist with real photos and bios.
     */
    public static function ensureDewanAsatidzSeeded(): void
    {
        try {
            if (! Schema::hasTable('dewan_asatidz')) {
                return;
            }

            // Clean up bogus records where student/activity photos were incorrectly assigned to teachers/leaders
            AnggotaDewan::whereIn('photo', [
                '/uploads/official/kbm-santri-0054.webp',
                '/uploads/official/kbm-santri-0098.webp',
                '/uploads/official/kbm-santri-0152.webp',
                '/uploads/official/ngaji-sore.webp',
                '/uploads/official/panahan-santri.webp',
                '/uploads/official/kegiatan-santri-waw1985.webp',
            ])->whereNull('unit_pendidikan_id')->delete();

            // Authentic 8 Yayasan leaders from original database dump (Only Mudir has official portrait, other 7 use clean default avatar)
            $dewanYayasanList = [
                [
                    'name' => "KH. Tol'at Wafa Ahmad, Lc.",
                    'slug' => 'kh-tolat-wafa-ahmad-lc',
                    'position' => 'Mudir Pondok Pesantren Raudhatul Ulum',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/kh-tolat-wafa-ahmad.webp',
                    'profile_summary' => 'Mudir Pondok Pesantren Raudhatul Ulum Sakatiga sejak 1986. Alumni Universitas Al-Azhar Kairo Mesir dan perintis sistem modern muadalah pesantren.',
                    'education' => 'Universitas Al-Azhar Kairo Mesir',
                    'order' => 1,
                ],
                [
                    'name' => 'Drs. KH. Karim Kasim',
                    'slug' => 'drs-kh-karim-kasim',
                    'position' => 'Ketua Dewan Pembina YAPIRUS',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS). Dedikasi lebih dari 40 tahun dalam pembinaan akhlak dan tarbiyah.',
                    'education' => 'Sarjana Pendidikan Islam',
                    'order' => 2,
                ],
                [
                    'name' => 'H. Faisal Abdullah, S.T.',
                    'slug' => 'h-faisal-abdullah-st',
                    'position' => 'Ketua Umum Pengurus YAPIRUS',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Ketua Umum Badan Pengurus Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'Sarjana Teknik',
                    'order' => 3,
                ],
                [
                    'name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                    'slug' => 'ustadz-h-ahmad-dailami-spdi',
                    'position' => 'Sekretaris Yayasan YAPIRUS',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Sekretaris Umum Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'S1 Pendidikan Agama Islam',
                    'order' => 4,
                ],
                [
                    'name' => 'H. M. Husin, M.Si.',
                    'slug' => 'h-m-husin-msi',
                    'position' => 'Bendahara Yayasan YAPIRUS',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Bendahara Umum Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                    'education' => 'Magister Sains Manajemen',
                    'order' => 5,
                ],
                [
                    'name' => 'Ustadz H. Abdul Halim, Lc.',
                    'slug' => 'ustadz-h-abdul-halim-lc',
                    'position' => 'Wakil Mudir Bidang Pendidikan & Pengajaran',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Wakil Mudir PPRU membidangi kurikulum pesantren, Kemenag, dan muadalah Al-Azhar Kairo.',
                    'education' => 'Alumni Universitas Al-Azhar Kairo',
                    'order' => 6,
                ],
                [
                    'name' => 'Ustadz H. Syamsuddin, S.Ag.',
                    'slug' => 'ustadz-h-syamsuddin-sag',
                    'position' => 'Wakil Mudir Bidang Kepengasuhan Santri',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Wakil Mudir PPRU membidangi kedisiplinan asrama, bahasa Arab & Inggris, dan pengasuhan santri.',
                    'education' => 'Sarjana Agama',
                    'order' => 7,
                ],
                [
                    'name' => 'Ir. H. Ahmad Fauzi',
                    'slug' => 'ir-h-ahmad-fauzi',
                    'position' => 'Wakil Mudir Bidang Pembangunan & Sarana',
                    'fraction' => 'Yayasan',
                    'photo' => '/uploads/avatar-neutral-gray.svg',
                    'profile_summary' => 'Wakil Mudir PPRU membidangi perencanaan fisik kampus, sarana prasarana, dan unit usaha pesantren.',
                    'education' => 'Sarjana Teknik Sipil',
                    'order' => 8,
                ],
            ];

            foreach ($dewanYayasanList as $d) {
                AnggotaDewan::updateOrCreate(
                    [
                        'fraction' => 'Yayasan',
                        'order' => $d['order'],
                    ],
                    array_merge($d, ['unit_pendidikan_id' => null])
                );
            }

            // Sanitasi ketat: Seluruh anggota dewan selain Mudir yang fotonya acak/santri/placeholder diubah ke avatar abu-abu
            AnggotaDewan::where('slug', '!=', 'kh-tolat-wafa-ahmad-lc')
                ->where(function ($q) {
                    $q->whereNull('photo')
                        ->orWhere('photo', '')
                        ->orWhere('photo', 'like', '%default-avatar%')
                        ->orWhere('photo', 'like', '%santri%')
                        ->orWhere('photo', 'like', '%kbm%')
                        ->orWhere('photo', 'like', '%ngaji%')
                        ->orWhere('photo', 'like', '%panahan%')
                        ->orWhere('photo', 'like', '%waw19%')
                        ->orWhere('photo', 'like', '%upacara%')
                        ->orWhere('photo', 'like', '%kepala-sekolah%')
                        ->orWhere('photo', 'like', '%kepsek%')
                        ->orWhere('photo', 'like', '%drone%')
                        ->orWhere('photo', 'like', '%logo%');
                })
                ->update(['photo' => '/uploads/avatar-neutral-gray.svg']);
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureDewanAsatidzSeeded error: '.$e->getMessage());
        }
    }

    /**
     * Ensure all official demo contents (Dewan Guru, TVRU Videos, Berita, Artikel, Prestasi, Ekskul, Testimoni, Agenda, Pengumuman) are seeded.
     * Guaranteed fail-safe execution without requiring cPanel terminal migration commands.
     */
    public static function ensureOfficialDemoContentsSeeded(): void
    {
        try {
            self::ensureUnitPendidikanSchemaExists();
            self::ensureDewanAsatidzSeeded();

            // 1. Purge Rickroll & ensure TVRU official videos
            if (Schema::hasTable('videos')) {
                Video::where('youtube_id', 'dQw4w9WgXcQ')->delete();

                $tvruVideos = [
                    [
                        'title' => 'Upacara Kemerdekaan RI di Kampus Pondok Pesantren Raudhatul Ulum Sakatiga',
                        'youtube_id' => 'BG311kT-yXc',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Khidmatnya upacara bendera dan apel santri PPRU Sakatiga.',
                    ],
                    [
                        'title' => 'Sarasehan & Orientasi Wali Santri Baru PPRU Sakatiga Tahun Ajaran 2026/2027',
                        'youtube_id' => 'cFXK5Of-IzQ',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Pengenalan tata tertib kepesantrenan dan pembinaan santri.',
                    ],
                    [
                        'title' => "Sarasehan & Silaturahim Wali Santri Bersama Mudir KH. Tol'at Wafa Ahmad, Lc.",
                        'youtube_id' => 'mRdb_kGhbiQ',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Arahan mendalam seputar sinergi pendidikan pesantren dan wali santri.',
                    ],
                    [
                        'title' => 'Peringatan Hari Besar Islam & Kiprah Santri di Kampus Pesantren Raudhatul Ulum',
                        'youtube_id' => 'p8B8wKu5o4c',
                        'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Semarak tabligh akbar, lomba bahasa, dan kreasi santri.',
                    ],
                ];

                foreach ($tvruVideos as $v) {
                    Video::updateOrCreate(
                        ['youtube_id' => $v['youtube_id']],
                        [
                            'title' => $v['title'],
                            'slug' => Str::slug($v['title']),
                            'youtube_url' => 'https://www.youtube.com/watch?v='.$v['youtube_id'],
                            'description' => $v['description'],
                        ]
                    );
                }
            }

            // 2. Auto-heal Unit Principals (eliminate Ustadz Fulan from unit pages)
            if (Schema::hasTable('unit_pendidikans')) {
                $principals = [
                    'madrasah-aliyah-raudhatul-ulum' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                    'madrasah-tsanawiyah-raudhatul-ulum' => 'Ustadz Muhammad Syakir, M.Pd.',
                    'madrasah-ibtidaiyah-raudhatul-ulum' => 'Ustadzah Siti Aminah, S.Pd.I.',
                    'madrasah-tahfizhul-quran-raudhatul-ulum' => 'Ustadzah Hj. Fatimah Azzahra, Lc., M.Ag.',
                    'taman-kanak-kanak-islam-raudhatul-ulum' => 'Ustadzah Maryam, S.Pd.',
                    'smp-islam-terpadu-raudhatul-ulum' => 'Ustadz Abdullah, S.Pd.I., M.Pd.',
                    'sma-islam-terpadu-raudhatul-ulum' => 'Ustadz Agi Gustiawan, S.Pd.',
                    'institut-agama-islam-nur-raudhatul-ulum' => 'Dr. H. Ahmad Fauzi, M.A.',
                ];
                foreach ($principals as $uSlug => $hName) {
                    $unit = UnitPendidikan::where('slug', $uSlug)->first();
                    if ($unit && (empty($unit->head_name) || str_contains($unit->head_name, 'Fulan'))) {
                        $unit->update(['head_name' => $hName]);
                    }
                }
            }

            // Safe author ID for posts
            $authorId = User::first()?->id;

            // 3. Purge global demo posts/articles/prestasi so main website is completely clean & authentic
            if (Schema::hasTable('posts')) {
                Post::whereNull('unit_pendidikan_id')->where(function ($q) {
                    $q->whereIn('slug', [
                        'pekan-perkenalan-santri-baru-p2sb-dan-matrikulasi-ta-20262027-resmi-dibuka',
                        'pekan-perkenalan-santri-baru-p2sb-dan-matrikulasi-ta-20262027-ppru-sakatiga-resmi-dibuka',
                        'haflah-milad-ke-76-dan-wisuda-akbar-santri-kelas-akhir-raudhatul-ulum-berlangsung-khidmat',
                        'pelepasan-delegasi-alumni-maru-raudhatul-ulum-lolos-beasiswa-universitas-al-azhar-kairo',
                        'penandatanganan-mou-sinergi-riset-sains-dan-teknologi-bersama-perguruan-tinggi-negeri-terkemuka',
                        'menumbuhkan-jiwa-kepemimpinan-dan-akhlakul-karimah-melalui-tarbiyah-pesantren',
                        'pentingnya-menjaga-hafalan-al-quran-murajaah-di-tengah-kesibukan-akademik',
                        'sinergi-kurikulum-dirasah-islamiyah-al-azhar-dan-sains-modern-menuju-indonesia-emas',
                        'adab-penuntut-ilmu-menurut-imam-an-nawawi-panduan-emas-generasi-pelajar-muslim',
                        'juara-1-musabaqah-hifdzil-quran-mhq-30-juz-tingkat-nasional-2026',
                        'medali-emas-olimpiade-sains-madrasah-ksm-tingkat-provinsi-bidang-fisika-terpadu',
                        'juara-umum-kejuaraan-pencak-silat-tapak-suci-pesantren-se-sumatera-2026',
                        'juara-1-lomba-debat-bahasa-arab-munazarah-ilmiyah-antar-pondok-pesantren-modern',
                    ])->orWhere('title', 'like', '%Pekan Perkenalan Santri Baru%');
                })->delete();
            }

            // 4. Purge global demo testimonials so main website is completely clean
            if (Schema::hasTable('testimonials')) {
                Testimonial::whereNull('unit_pendidikan_id')->whereIn('name', [
                    'Prof. Dr. H. Ahmad Dahlan, M.A.',
                    'Hj. Siti Aminah, S.Pd.',
                    'Muhammad Rizky Pratama, S.Ked.',
                    'Ir. H. Bambang Irawan, M.T.',
                    'H. Ir. Ahmad Syamsuddin',
                    'Dr. Muhammad Fauzan, Lc., M.A.',
                    'Hj. Siti Rahmah, S.Pd.',
                    'Fadhilurrahman Al-Hafizh, S.Kom.',
                ])->delete();
            }

            // 5. Delegate demo contents strictly to Unit pages (8 teachers, 4 videos, 4 posts, 4 prestasi, 4 ekskul, 4 testimonials per unit)
            UnitDemoContentService::seedAllUnitsDemo(true);

            // 7. Demo Agenda (4 Konten)
            if (Schema::hasTable('agendas')) {
                $agendaList = [
                    [
                        'title' => 'Wisuda Akbar Tahfidz Al-Qur\'an 30 Juz & Khotmil Kutub Angkatan 2026',
                        'event_date' => now()->addDays(14)->setTime(8, 30),
                        'location' => 'Gedung Pertemuan Serbaguna Kampus A PPRU Sakatiga',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                        'content' => 'Prosesi wisuda akbar hafalan Al-Qur\'an 30 juz mutqin santri kelas akhir serta penganugerahan ijazah sanad tahfidz bersama pimpinan pesantren.',
                    ],
                    [
                        'title' => 'Ujian Penilaian Akhir Semester (PAS) Terpadu & Standar Muadalah Al-Azhar',
                        'event_date' => now()->addDays(28)->setTime(7, 30),
                        'location' => 'Ruang Kelas & Laboratorium Komputer Seluruh Unit',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/kbm-santri-0054.webp',
                        'content' => 'Pelaksanaan evaluasi pembelajaran semester genap berbasis Computer Based Test (CBT) dan ujian lisan bahasa Arab-Inggris.',
                    ],
                    [
                        'title' => 'Pekan Olahraga, Seni & Bahasa Santri (PORSENI) Antar-Asrama Se-Pesantren',
                        'event_date' => now()->addDays(42)->setTime(8, 0),
                        'location' => 'Kompleks Lapangan Olahraga Terpadu Kampus B',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/panahan-santri.webp',
                        'content' => 'Ajang unjuk ketangkasan olahraga memanah, futsal, tapak suci, orasi bahasa Arab-Inggris, dan festival kreasi seni santri.',
                    ],
                    [
                        'title' => 'Sarasehan & Temu Akbar Silaturahmi Wali Santri Nasional PPRU Sakatiga',
                        'event_date' => now()->addDays(56)->setTime(9, 0),
                        'location' => 'Masjid Jami\' Pondok Pesantren Raudhatul Ulum',
                        'status' => 'upcoming',
                        'featured_image' => '/uploads/official/ngaji-sore.webp',
                        'content' => 'Forum tahunan komunikasi antara Mudir, dewan asatidz, dan seluruh wali santri guna mengevaluasi tumbuh kembang anak didik.',
                    ],
                ];

                foreach ($agendaList as $ag) {
                    Agenda::updateOrCreate(
                        ['slug' => Str::slug($ag['title'])],
                        [
                            'title' => $ag['title'],
                            'slug' => Str::slug($ag['title']),
                            'event_date' => $ag['event_date'],
                            'location' => $ag['location'],
                            'status' => $ag['status'],
                            'featured_image' => $ag['featured_image'],
                            'content' => $ag['content'],
                        ]
                    );
                }
            }

            // 8. Demo Pengumuman (4 Konten)
            if (Schema::hasTable('pengumumen')) {
                $pengumumanList = [
                    [
                        'title' => 'Pengumuman Kelulusan Seleksi Penerimaan Santri Baru (PSB) Gelombang I T.A. 2026/2027',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Diberitahukan kepada seluruh calon wali santri bahwa hasil seleksi tes akademik, membaca Al-Qur\'an, dan wawancara PSB Gelombang I telah resmi diumumkan. Silakan login ke portal PPDB Online untuk mengunduh surat ketetapan kelulusan.',
                    ],
                    [
                        'title' => 'Jadwal Kedatangan Santri & Tata Tertib Masuk Asrama Tahun Ajaran 2026/2027',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Seluruh santri lama dan santri baru diwajibkan melakukan check-in asrama sesuai pembagian jadwal per unit guna menjaga ketertiban arus lalu lintas dan kelancaran serah terima santri bersama musyrif/musyrifah.',
                    ],
                    [
                        'title' => 'Surat Edaran Libur Hari Raya Idul Fitri 1447 H & Kalender Akademik Pesantren',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Berdasarkan keputusan pimpinan pesantren, perpulangan santri dalam rangka libur Idul Fitri dimulai secara bertahap. Wali santri dihimbau menjemput tepat waktu dan memperhatikan batas akhir kembali ke asrama.',
                    ],
                    [
                        'title' => 'Panduan Registrasi Ulang & Pembayaran Syahriyah Melalui Virtual Account Bank',
                        'status' => 'publish',
                        'file_attachment' => null,
                        'content' => 'Untuk mempermudah layanan administrasi keuangan santri secara transparan dan real-time, seluruh transaksi pembayaran kini menggunakan nomor Virtual Account resmi Bank Syariah Indonesia (BSI) dan Bank Sumsel Babel Syariah.',
                    ],
                ];

                foreach ($pengumumanList as $p) {
                    Pengumuman::updateOrCreate(
                        ['slug' => Str::slug($p['title'])],
                        [
                            'title' => $p['title'],
                            'slug' => Str::slug($p['title']),
                            'status' => $p['status'],
                            'content' => $p['content'],
                            'file_attachment' => $p['file_attachment'],
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            Log::error('CmsAutoHealService::ensureOfficialDemoContentsSeeded error: '.$e->getMessage());
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
        self::ensureOfficialDemoContentsSeeded();
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
        $layanan = NavMenu::create([
            'name' => 'Layanan',
            'url' => '/layanan-terpadu',
            'icon' => 'fa-solid fa-handshake-angle',
            'location' => 'header',
            'order' => 5,
            'is_active' => true,
        ]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Izin Kunjungan Sekolah', 'url' => '/izin-sekolah', 'icon' => 'fa-solid fa-school', 'location' => 'header', 'order' => 1]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Kerja Sama', 'url' => '/permohonan-kerja-sama', 'icon' => 'fa-solid fa-handshake', 'location' => 'header', 'order' => 2]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Sewa Fasilitas & Sarana', 'url' => '/sewa-barang', 'icon' => 'fa-solid fa-building-user', 'location' => 'header', 'order' => 3]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Portal Layanan Terpadu', 'url' => '/layanan-terpadu', 'icon' => 'fa-solid fa-circle-nodes', 'location' => 'header', 'order' => 4]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Brosur & Rincian Biaya', 'url' => '/download', 'icon' => 'fa-solid fa-file-pdf', 'location' => 'header', 'order' => 5]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Download Logo Resmi', 'url' => '/logo', 'icon' => 'fa-solid fa-image', 'location' => 'header', 'order' => 6]);
        NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Kontak & Lokasi Humas', 'url' => '/hubungi', 'icon' => 'fa-solid fa-address-book', 'location' => 'header', 'order' => 7]);

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
