<?php

namespace App\Services;

use App\Models\HeroSlide;
use App\Models\NavMenu;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class CmsAutoHealService
{
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
     * Ensure all core CMS tables exist (fail-safe for cPanel).
     */
    public static function ensureAllCoreTablesExist(): void
    {
        self::ensureHeroSlidesTableExists();
        self::ensureNavMenusTableExists();
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

        // 3. Pendidikan
        NavMenu::create([
            'name' => 'Pendidikan',
            'url' => '/pendidikan',
            'icon' => 'fa-solid fa-building-columns',
            'location' => 'header',
            'order' => 3,
            'is_active' => true,
        ]);

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

        // 5. Khutbah & Dakwah (Menu Navigasi Khusus)
        NavMenu::create([
            'name' => 'Khutbah',
            'url' => '/khutbah',
            'icon' => 'fa-solid fa-microphone-lines',
            'location' => 'header',
            'order' => 5,
            'is_active' => true,
        ]);

        // 6. Portal IKARUS Alumni
        NavMenu::create([
            'name' => 'IKARUS Alumni',
            'url' => '/ikarus',
            'icon' => 'fa-solid fa-user-graduate',
            'location' => 'header',
            'order' => 6,
            'is_active' => true,
        ]);

        // 7. Layanan
        NavMenu::create([
            'name' => 'Layanan',
            'url' => '/layanan',
            'icon' => 'fa-solid fa-handshake-angle',
            'location' => 'header',
            'order' => 7,
            'is_active' => true,
        ]);

        // 8. Kontak
        NavMenu::create([
            'name' => 'Kontak',
            'url' => '/kontak',
            'icon' => 'fa-solid fa-address-book',
            'location' => 'header',
            'order' => 8,
            'is_active' => true,
        ]);

        // 9. PSB / PPDB
        NavMenu::create([
            'name' => 'PPDB Online',
            'url' => '/ppdb',
            'icon' => 'fa-solid fa-user-plus',
            'location' => 'header',
            'order' => 9,
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
