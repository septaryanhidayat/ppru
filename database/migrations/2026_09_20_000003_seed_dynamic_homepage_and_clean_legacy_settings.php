<?php

use App\Models\HeroSlide;
use App\Models\NavMenu;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Seed initial Hero Slides
        if (Schema::hasTable('hero_slides') && HeroSlide::count() === 0) {
            $initialSlides = [
                [
                    'title' => 'Pondok Pesantren Raudhatul Ulum',
                    'subtitle' => 'Basis Kaderisasi Generasi Terbaik (Khoiru Ummah) yang Bermanfaat Luas dan Berdaya Saing Global di Sakatiga Ogan Ilir.',
                    'badge' => 'Pondok Pesantren Raudhatul Ulum Sakatiga',
                    'image' => '/uploads/official/drone-raudhatul-ulum.webp',
                    'btn_primary_text' => 'Profil Singkat Pesantren',
                    'btn_primary_url' => '/tentang-kami',
                    'btn_secondary_text' => 'Pendaftaran PSB',
                    'btn_secondary_url' => '/ppdb',
                    'order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Penerimaan Santri Baru (PSB) 2026/2027',
                    'subtitle' => 'Mari Bergabung dengan Pesantren Modern Terpadu Berasrama: Al-Qur\'an, Dwi-Bahasa, dan Dirasah Islamiyah.',
                    'badge' => 'PSB Gelombang 1 Dibuka',
                    'image' => '/uploads/official/drone-danau-telok-putih.webp',
                    'btn_primary_text' => 'Daftar PSB Online',
                    'btn_primary_url' => '/ppdb',
                    'btn_secondary_text' => 'Brosur & Biaya',
                    'btn_secondary_url' => '/download',
                    'order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Kurikulum Terpadu & Muadalah Al-Azhar',
                    'subtitle' => 'Memadukan Kurikulum Pondok Modern Gontor, Kementerian Agama, dan Dinas Pendidikan Nasional.',
                    'badge' => 'Muadalah Al-Azhar Kairo Mesir',
                    'image' => '/uploads/official/ngaji-sore.webp',
                    'btn_primary_text' => 'Sambutan Mudir PPRU',
                    'btn_primary_url' => '/sambutan',
                    'btn_secondary_text' => 'Unit Pendidikan',
                    'btn_secondary_url' => '/pendidikan',
                    'order' => 3,
                    'is_active' => true,
                ],
            ];

            foreach ($initialSlides as $slide) {
                HeroSlide::create($slide);
            }
        }

        // 2. Seed initial Nav Menus
        if (Schema::hasTable('nav_menus') && NavMenu::count() === 0) {
            // Header: Beranda
            NavMenu::create([
                'name' => 'Beranda',
                'url' => '/',
                'icon' => 'fa-solid fa-house',
                'location' => 'header',
                'order' => 1,
            ]);

            // Header: Profil (Parent)
            $profil = NavMenu::create([
                'name' => 'Profil',
                'url' => '#',
                'icon' => 'fa-solid fa-landmark-dome',
                'location' => 'header',
                'order' => 2,
            ]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sambutan Mudir PPRU', 'url' => '/sambutan', 'icon' => 'fa-solid fa-user-tie', 'location' => 'header', 'order' => 1]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Profil Singkat Pesantren', 'url' => '/tentang-kami', 'icon' => 'fa-solid fa-landmark-dome', 'location' => 'header', 'order' => 2]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Visi, Misi & 10 Jati Diri', 'url' => '/visi-dan-misi', 'icon' => 'fa-solid fa-compass', 'location' => 'header', 'order' => 3]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sejarah Sejak 1930 & 1950', 'url' => '/sejarah', 'icon' => 'fa-solid fa-clock-rotate-left', 'location' => 'header', 'order' => 4]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Dewan Asatidz & Guru', 'url' => '/dewan-guru', 'icon' => 'fa-solid fa-chalkboard-user', 'location' => 'header', 'order' => 5]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Struktur Organisasi & Pengasuh', 'url' => '/struktur-organisasi', 'icon' => 'fa-solid fa-sitemap', 'location' => 'header', 'order' => 6]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Sarana & Fasilitas Pondok', 'url' => '/fasilitas', 'icon' => 'fa-solid fa-layer-group', 'location' => 'header', 'order' => 7]);
            NavMenu::create(['parent_id' => $profil->id, 'name' => 'Program Unggulan Pesantren', 'url' => '/program-unggulan', 'icon' => 'fa-solid fa-star-and-crescent', 'location' => 'header', 'order' => 8]);

            // Header: Pendidikan
            NavMenu::create([
                'name' => 'Pendidikan',
                'url' => '/pendidikan',
                'icon' => 'fa-solid fa-building-columns',
                'location' => 'header',
                'order' => 3,
            ]);

            // Header: Informasi (Parent)
            $info = NavMenu::create([
                'name' => 'Informasi',
                'url' => '#',
                'icon' => 'fa-solid fa-newspaper',
                'location' => 'header',
                'order' => 4,
            ]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Berita & Kabar Pondok', 'url' => '/artikel', 'icon' => 'fa-solid fa-newspaper', 'location' => 'header', 'order' => 1]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Prestasi Santri & Guru', 'url' => '/prestasi', 'icon' => 'fa-solid fa-trophy', 'location' => 'header', 'order' => 2]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Agenda & Kalender', 'url' => '/agenda', 'icon' => 'fa-solid fa-calendar-days', 'location' => 'header', 'order' => 3]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Pengumuman Resmi', 'url' => '/pengumuman', 'icon' => 'fa-solid fa-bullhorn', 'location' => 'header', 'order' => 4]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Galeri Foto Dokumentasi', 'url' => '/galeri', 'icon' => 'fa-solid fa-images', 'location' => 'header', 'order' => 5]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Video Kegiatan & Profil', 'url' => '/video', 'icon' => 'fa-brands fa-youtube', 'location' => 'header', 'order' => 6]);
            NavMenu::create(['parent_id' => $info->id, 'name' => 'Tausiyah & Khutbah Jum\'at', 'url' => '/kategori/taujih', 'icon' => 'fa-solid fa-mosque', 'location' => 'header', 'order' => 7]);

            // Header: Layanan (Parent)
            $layanan = NavMenu::create([
                'name' => 'Layanan',
                'url' => '#',
                'icon' => 'fa-solid fa-handshake-angle',
                'location' => 'header',
                'order' => 5,
            ]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Portal Layanan Terpadu', 'url' => '/layanan-terpadu', 'icon' => 'fa-solid fa-handshake-angle', 'location' => 'header', 'order' => 1]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Izin Santri', 'url' => '/izin-sekolah', 'icon' => 'fa-solid fa-id-card-clip', 'location' => 'header', 'order' => 2]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Permohonan Kerja Sama', 'url' => '/permohonan-kerja-sama', 'icon' => 'fa-solid fa-handshake', 'location' => 'header', 'order' => 3]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Sewa Fasilitas Pesantren', 'url' => '/sewa-barang', 'icon' => 'fa-solid fa-building-user', 'location' => 'header', 'order' => 4]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Brosur & Rincian Biaya', 'url' => '/download', 'icon' => 'fa-solid fa-file-pdf', 'location' => 'header', 'order' => 5]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Download Logo Resmi', 'url' => '/download/logo', 'icon' => 'fa-solid fa-image', 'location' => 'header', 'order' => 6]);
            NavMenu::create(['parent_id' => $layanan->id, 'name' => 'Kontak & Lokasi Humas', 'url' => '/hubungi', 'icon' => 'fa-solid fa-address-book', 'location' => 'header', 'order' => 7]);

            // Footer Quick Links
            $footerQuick = [
                ['name' => 'Profil Pesantren', 'url' => '/tentang-kami', 'order' => 1],
                ['name' => 'Visi & Misi', 'url' => '/visi-dan-misi', 'order' => 2],
                ['name' => 'Pendaftaran PSB', 'url' => '/ppdb', 'order' => 3],
                ['name' => 'Program Unggulan', 'url' => '/program-unggulan', 'order' => 4],
                ['name' => 'Dewan Asatidz & Guru', 'url' => '/dewan-guru', 'order' => 5],
                ['name' => 'Fasilitas & Sarana', 'url' => '/fasilitas', 'order' => 6],
                ['name' => 'Pusat Unduhan Brosur', 'url' => '/download', 'order' => 7],
                ['name' => 'Kebijakan Privasi', 'url' => '/privacy-policy', 'order' => 8],
            ];
            foreach ($footerQuick as $fq) {
                NavMenu::create(array_merge($fq, ['location' => 'footer_quick']));
            }
        }

        // 3. Default Homepage Settings (Trisula, Statistik, Infaq, PSB, Profil)
        $defaultSettings = [
            // Home Hero Badge
            'home_hero_badge' => 'Pondok Pesantren Raudhatul Ulum Sakatiga',

            // Trisula Keunggulan Santri
            'home_trisula_badge' => '3 Prioritas Utama Pembelajaran',
            'home_trisula_title' => 'Trisula Keunggulan Santri Raudhatul Ulum',
            'home_trisula_subtitle' => 'Kurikulum komprehensif yang dirancang untuk mengantarkan santri berprestasi di kancah nasional maupun dunia.',
            // Card 1
            'home_trisula_1_icon' => 'fa-solid fa-book-quran',
            'home_trisula_1_badge' => 'Prioritas I • Keagamaan & Karakter',
            'home_trisula_1_title' => 'Karakter Qur\'ani (Quranic Insight)',
            'home_trisula_1_desc' => 'Bimbingan intensif tahsin dan tahfidzul Qur\'an mutqin hingga 30 juz bersanad lewat unit khusus MATQULARU, kajian kitab kuning (turats), serta pembiasaan ibadah sunnah 24 jam dan penempaan 10 Jati Diri Santri Raudhatul Ulum.',
            'home_trisula_1_footer' => 'Target Mutqin 30 Juz & Sanad',
            // Card 2
            'home_trisula_2_icon' => 'fa-solid fa-microscope',
            'home_trisula_2_badge' => 'Prioritas II • Sains & Teknologi',
            'home_trisula_2_title' => 'Nalar Ilmiah (Scientific Insight)',
            'home_trisula_2_desc' => 'Penguatan logika berpikir kritis melalui integrasi kurikulum sains nasional, laboratorium terpadu, olimpiade riset (KSM/OSN), pengenalan literasi digital modern, coding, robotika pesantren, dan karya tulis ilmiah santri.',
            'home_trisula_2_footer' => 'Laboratorium Modern & Robotika',
            // Card 3
            'home_trisula_3_icon' => 'fa-solid fa-globe',
            'home_trisula_3_badge' => 'Prioritas III • Bahasa & Kepemimpinan',
            'home_trisula_3_title' => 'Kepemimpinan Global (Global Leadership)',
            'home_trisula_3_desc' => 'Ekosistem dwi-bahasa aktif (Arab & Inggris harian), kurikulum muadalah yang diakui resmi di Universitas Al-Azhar Kairo Mesir, organisasi kepemimpinan santri (OSPRU), kepanduan pramuka, serta kemandirian hidup berasrama 24 jam.',
            'home_trisula_3_footer' => 'Dwi-Bahasa & Muadalah Al-Azhar',

            // Statistik & Pencapaian Pesantren
            'home_stat_1_val' => '75+',
            'home_stat_1_lbl' => 'Tahun Mengabdi',
            'home_stat_1_desc' => 'Berdiri sejak 1 Agustus 1950',
            'home_stat_2_val' => '8',
            'home_stat_2_lbl' => 'Unit Pendidikan',
            'home_stat_2_desc' => 'TK hingga Perguruan Tinggi',
            'home_stat_3_val' => '3.500+',
            'home_stat_3_lbl' => 'Santri & Mahasiswa',
            'home_stat_3_desc' => 'Dari berbagai penjuru Indonesia',
            'home_stat_4_val' => '15.000+',
            'home_stat_4_lbl' => 'Alumni Berkhidmat',
            'home_stat_4_desc' => 'Kiprah dakwah di dalam & luar negeri',

            // PSB Spotlight di Beranda
            'home_psb_badge' => 'PSB T.P. 2026 / 2027 Telah Dibuka',
            'home_psb_title' => 'Penerimaan Santri Baru (PSB) Online',
            'home_psb_subtitle' => 'Bergabunglah bersama ribuan santri dari seluruh penjuru nusantara dalam lingkungan kaderisasi Islam yang unggul, disiplin, dan berwawasan global.',
            'home_psb_btn_text' => 'Daftar PSB Sekarang',
            'home_psb_btn_url' => '/ppdb',

            // Infaq & Wakaf Beranda
            'home_infaq_badge' => 'Investasi Akhirat',
            'home_infaq_title' => 'Wakaf Pembangunan & Beasiswa Penghafal Al-Qur\'an',
            'home_infaq_desc' => 'Mari alirkan pahala jariyah tanpa putus dengan berdonasi untuk perluasan sarana ibadah santri, asrama, ruang kelas, dan beasiswa santri dhuafa penghafal Al-Qur\'an di Pondok Pesantren Raudhatul Ulum Sakatiga.',
            'home_infaq_point_1' => 'Amanah & Transparan',
            'home_infaq_point_2' => 'Laporan Rutin',
            'home_infaq_point_3' => 'Rekening Resmi Yayasan (YAPIRUS)',
            'home_infaq_btn1_text' => 'Salurkan Infaq & Wakaf',
            'home_infaq_btn1_url' => '/donasi',
            'home_infaq_btn2_text' => 'Konfirmasi via WhatsApp',

            // Sambutan Mudir Beranda
            'home_sambutan_badge' => 'Kata Sambutan Mudir PPRU',
            'home_sambutan_title' => 'Mendidik Generasi Khairu Ummah, Menegakkan Risalah Islam',
            'home_sambutan_ayah' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ • كُنتُمْ خَيْرَ أُمَّةٍ أُخْرِجَتْ لِلنَّاسِ تَأْمُرُونَ بِالْمَعْرُوفِ وَتَنْهَوْنَ عَنِ الْمُنكَرِ',
            'home_sambutan_excerpt' => 'Assalamu\'alaikum Warahmatullahi Wabarakatuh. Selamat datang di website resmi Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga. Sejak dirintisnya madrasah cikal bakal pada tahun 1930 hingga resmi berdirinya pesantren pada 1 Agustus 1950, PPRU senantiasa istiqomah membina putra-putri umat dalam lingkungan asrama yang asri, disiplin, dan sarat nilai-nilai perjuangan Islam.',
        ];

        foreach ($defaultSettings as $k => $v) {
            if (! Setting::where('key', $k)->exists()) {
                Setting::set($k, $v, 'homepage');
            }
        }

        // 4. Clean up legacy terms from database (robbani, ishum, dpd)
        if (Schema::hasTable('settings')) {
            DB::table('settings')->where('key', 'social_twitter')->where('value', 'like', '%robbani%')
                ->update(['value' => 'https://x.com/pprusakatiga']);
            DB::table('settings')->where('key', 'site_address')->where('value', 'like', '%robbani%')
                ->update(['value' => 'Sakatiga, Indralaya, Ogan Ilir, Sumatera Selatan 30816']);
        }

        if (Schema::hasTable('unit_pendidikans')) {
            DB::table('unit_pendidikans')->where('thumbnail', 'like', '%robbani%')->update([
                'thumbnail' => '/uploads/official/drone-raudhatul-ulum.webp',
            ]);
        }

        if (Schema::hasTable('posts')) {
            DB::table('posts')->where('featured_image', 'like', '%robbani%')->update([
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
            ]);
            // Update slug sambutan-kepala-sekolah to sambutan-mudir if desired, or keep as sambutan-mudir alias
            DB::table('posts')->where('slug', 'sambutan-kepala-sekolah')->update([
                'title' => 'Sambutan Mudir Pondok Pesantren Raudhatul Ulum',
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No down needed for data seed/cleanup
    }
};
