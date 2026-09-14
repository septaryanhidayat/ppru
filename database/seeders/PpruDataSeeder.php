<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use App\Models\QuickMenu;
use App\Models\Setting;
use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PpruDataSeeder extends Seeder
{
    public function run(): void
    {
        // 0. Ensure Admin User
        User::updateOrCreate(
            ['email' => 'admin@ppru.ac.id'],
            [
                'name' => 'Admin PPRU Sakatiga',
                'password' => bcrypt('AdminPPRU2026!'),
                'role' => 'admin',
            ]
        );

        // 1. Settings Pondok Pesantren Raudhatul Ulum
        $settings = [
            'site_name' => 'Pondok Pesantren Raudhatul Ulum',
            'site_tagline' => 'Basis Kaderisasi Generasi Terbaik (Khoiru Ummah) yang Bermanfaat Luas dan Berdaya Saing Global',
            'site_description' => 'Official Website Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga Indralaya Ogan Ilir Sumatera Selatan. Memadukan kurikulum pesantren terpadu, Al-Qur\'an, Dwi-Bahasa (Arab & Inggris), serta Sains dan Teknologi.',
            'contact_email' => 'sekretariat@ppru.ac.id',
            'contact_phone' => '0812-7890-1950',
            'contact_whatsapp' => '0812-7890-1950',
            'contact_address' => 'Desa Sakatiga, Kecamatan Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan 30816',
            'social_facebook' => 'https://www.facebook.com/pprusakatigasumsel/?locale=id_ID',
            'social_instagram' => 'https://www.instagram.com/ppru_sakatiga/',
            'social_youtube' => 'https://www.youtube.com/@pprusakatiga',
            'social_tiktok' => 'https://www.tiktok.com/@pprusakatiga',
            'banner_daftar_url' => '/form_ppdb',
            'banner_donasi_url' => '/donasi',
            'site_logo' => '/uploads/logo-ppru-banner.png',
            'site_logo_square' => '/uploads/logo-ppru-square.png',
            'site_favicon' => '/uploads/logo-ppru-square.png',
            'og_title' => 'Pondok Pesantren Raudhatul Ulum Sakatiga Ogan Ilir',
            'og_description' => 'Pondok Pesantren Modern Terpadu berbasis Al-Qur\'an, Dwi-Bahasa (Arab & Inggris), Dirasah Islamiyah, dan Sains Teknologi.',
            'og_image' => '/uploads/logo-ppru-banner.png',
            'meta_keywords' => 'pondok pesantren raudhatul ulum, ppru sakatiga, raudhatul ulum ogan ilir, ponpes sakatiga, ppdb ppru, santri sakatiga, ma raudhatul ulum, mts raudhatul ulum, smait ru, smpit ru',
            'npsn' => '10648831',
            'akreditasi' => 'TERAKREDITASI A & MUADALAH AL-AZHAR KAIRO',
            'no_sk_akreditasi' => 'NPT.W.F.6.4.07.017.88',
            'sk_pendirian' => 'Akte Notaris Aminus Palembang No. 21.A 1966',
            'sk_izin' => 'Jawatan Pendidikan Agama Jakarta No. 12 Tahun 1950',
            'kepala_sekolah' => 'KH. Tol\'at Wafa Ahmad, Lc.',
            'donation_bank_1_name' => 'Bank Syariah Indonesia (BSI)',
            'donation_bank_1_code' => '451',
            'donation_bank_1_rekening' => '710-1950-001',
            'donation_bank_1_holder' => 'YAYASAN PERGURUAN ISLAM RAUDHATUL ULUM (YAPIRUS)',
            'donation_bank_2_name' => 'Bank Sumsel Babel Syariah',
            'donation_bank_2_code' => '120',
            'donation_bank_2_rekening' => '801-09-19500',
            'donation_bank_2_holder' => 'PONDOK PESANTREN RAUDHATUL ULUM',
            'donation_confirm_phone' => '0812-7890-1950',
            'donation_confirm_text' => "Assalamu'alaikum Bendahara Pondok Pesantren Raudhatul Ulum Sakatiga, saya telah menyalurkan infaq/wakaf pembangunan.",
            'donation_intro_text' => 'Salurkan infaq dan wakaf terbaik Anda untuk pembangunan asrama santri, sarana masjid, laboratorium, serta beasiswa tahfidz yatim & dhuafa di Pondok Pesantren Raudhatul Ulum Sakatiga.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Unit Pendidikan PPRU (8 Unit Resmi)
        $units = [
            [
                'name' => 'Madrasah Aliyah Raudhatul Ulum (MARU)',
                'short_name' => 'MARU',
                'slug' => 'madrasah-aliyah-raudhatul-ulum',
                'category_type' => 'Boarding School',
                'curriculum' => 'Kurikulum Terpadu Gontor & Kemenag / Muadalah Al-Azhar Kairo Mesir',
                'badge' => 'Terakreditasi A',
                'description' => 'Madrasah Aliyah (setara SMA) berasrama putra dan putri dengan kurikulum terpadu ilmu-ilmu syar\'i (Kitab Kuning), dwi-bahasa aktif (Arab & Inggris), serta sains umum. Lulusan MARU memiliki ijazah muadalah resmi yang diakui langsung di Universitas Al-Azhar Kairo Mesir dan Universitas Islam Madinah Arab Saudi.',
                'head_name' => 'Ustadz H. M. Said, S.Ag.',
                'phone' => '0812-7890-1950',
                'email' => 'maru@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-graduation-cap',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'SMA Islam Terpadu Raudhatul Ulum (SMAIT RU)',
                'short_name' => 'SMAIT RU',
                'slug' => 'sma-islam-terpadu-raudhatul-ulum',
                'category_type' => 'Boarding School',
                'curriculum' => 'Kurikulum JSIT Indonesia & Kurikulum Merdeka Nasional',
                'badge' => 'Terakreditasi B',
                'description' => 'Sekolah Menengah Atas berbasis Islam Terpadu yang memadukan keunggulan sains teknologi, pembinaan karakter kepemimpinan, riset ilmiah remaja, dan tahfidzul qur\'an mutqin.',
                'head_name' => 'Ustadz Ahmad Fauzi, M.Pd.',
                'phone' => '0812-7890-1950',
                'email' => 'smait@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-atom',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Madrasah Tsanawiyah Raudhatul Ulum (MATSARU)',
                'short_name' => 'MATSARU',
                'slug' => 'madrasah-tsanawiyah-raudhatul-ulum',
                'category_type' => 'Boarding School',
                'curriculum' => 'Kurikulum Terpadu Gontor & Kemenag / Muadalah Al-Azhar',
                'badge' => 'Terakreditasi A',
                'description' => 'Madrasah Tsanawiyah (setara SMP) berasrama yang fokus pada peletakan pondasi aqidah shohihah, pembiasaan ibadah yaumiyah, tahfidz, dan kemampuan dasar percakapan bahasa Arab & Inggris aktif.',
                'head_name' => 'Ustadz Drs. H. Syamsuddin',
                'phone' => '0812-7890-1950',
                'email' => 'matsaru@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-book-open-reader',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'SMP Islam Terpadu Raudhatul Ulum (SMPIT RU)',
                'short_name' => 'SMPIT RU',
                'slug' => 'smp-islam-terpadu-raudhatul-ulum',
                'category_type' => 'Boarding School',
                'curriculum' => 'Kurikulum JSIT Indonesia & Kurikulum Nasional',
                'badge' => 'Terakreditasi A',
                'description' => 'Sekolah Menengah Pertama Islam Terpadu berasrama yang unggul dalam integrasi ilmu pengetahuan, pembinaan adab santri, kemandirian kepanduan pramuka, dan eksplorasi bakat minat siswa.',
                'head_name' => 'Ustadz Ridwan, S.Pd.I.',
                'phone' => '0812-7890-1950',
                'email' => 'smpit@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-award',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Madrasah Tahfizhul Qur\'an Lil Aulad (MATQULARU)',
                'short_name' => 'MATQULARU',
                'slug' => 'madrasah-tahfizhul-quran-raudhatul-ulum',
                'category_type' => 'Tahfidz Khusus',
                'curriculum' => 'Kurikulum Khusus Tahfidz 30 Juz Mutqin Bersanad & Ulumul Qur\'an',
                'badge' => 'Program Khusus',
                'description' => 'Lembaga pendidikan khusus tahfidz Al-Qur\'an dengan metode intensif dan bimbingan masyaikh serta para huffazh bersanad untuk mencetak kader penghafal Al-Qur\'an 30 juz mutqin.',
                'head_name' => 'Ustadz H. Abdul Halim, Al-Hafizh',
                'phone' => '0812-7890-1950',
                'email' => 'tahfidz@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-book-quran',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Madrasah Ibtidaiyah Raudhatul Ulum (MIRU)',
                'short_name' => 'MIRU',
                'slug' => 'madrasah-ibtidaiyah-raudhatul-ulum',
                'category_type' => 'Fullday School',
                'curriculum' => 'Kurikulum Kemenag & Muatan Lokal Kepesantrenan',
                'badge' => 'Terakreditasi A',
                'description' => 'Pendidikan dasar Islam formal tingkat Ibtidaiyah (setara SD) dengan penekanan pada tartil Al-Qur\'an, pembiasaan akhlak terpuji, dan dasar-dasar ilmu umum yang kokoh sejak usia dini.',
                'head_name' => 'Ustadzah Hj. Maryam, S.Pd.I.',
                'phone' => '0812-7890-1950',
                'email' => 'miru@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-school',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Taman Kanak-Kanak Islam Raudhatul Ulum (TAKIRU)',
                'short_name' => 'TAKIRU',
                'slug' => 'taman-kanak-kanak-islam-raudhatul-ulum',
                'category_type' => 'Fullday School',
                'curriculum' => 'Pendidikan Anak Usia Dini Islami Terpadu',
                'badge' => 'Terdaftar Resmi',
                'description' => 'Pendidikan anak usia dini yang menyenangkan dengan pendekatan sentra Qur\'ani, pembiasaan doa dan adab harian, motorik anak, serta keceriaan belajar dalam suasana islami.',
                'head_name' => 'Ustadzah Fatimah, S.Pd.',
                'phone' => '0812-7890-1950',
                'email' => 'takiru@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-shapes',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Sekolah Tinggi Ilmu Tarbiyah / STEBIS Raudhatul Ulum',
                'short_name' => 'STITRU',
                'slug' => 'sekolah-tinggi-ilmu-tarbiyah-raudhatul-ulum',
                'category_type' => 'Perguruan Tinggi',
                'curriculum' => 'Kurikulum Pendidikan Tinggi Islam Kemenag RI (S1 PAI & Perbankan Syariah)',
                'badge' => 'Terakreditasi BAN-PT',
                'description' => 'Perguruan tinggi keagamaan Islam swasta di lingkungan pesantren menyelenggarakan program Sarjana (S1) Pendidikan Agama Islam dan Perbankan Syariah.',
                'head_name' => 'Dr. H. M. Husin, M.A.',
                'phone' => '0812-7890-1950',
                'email' => 'stitru@ppru.ac.id',
                'thumbnail' => '/uploads/logo-ppru-banner.png',
                'icon' => 'fa-solid fa-university',
                'order' => 8,
                'is_active' => true,
            ],
        ];

        UnitPendidikan::truncate();
        foreach ($units as $u) {
            UnitPendidikan::create($u);
        }

        // 3. Quick Menus (8 Menu Utama Beranda)
        $quickMenus = [
            ['name' => 'PPDB', 'url' => '/ppdb', 'icon' => 'fa-solid fa-graduation-cap', 'order' => 1],
            ['name' => 'Profil', 'url' => '/tentang-kami', 'icon' => 'fa-solid fa-landmark-dome', 'order' => 2],
            ['name' => 'Pendidikan', 'url' => '/pendidikan', 'icon' => 'fa-solid fa-building-columns', 'order' => 3],
            ['name' => 'Asatidz', 'url' => '/dewan-guru', 'icon' => 'fa-solid fa-chalkboard-user', 'order' => 4],
            ['name' => 'Sarana', 'url' => '/fasilitas', 'icon' => 'fa-solid fa-layer-group', 'order' => 5],
            ['name' => 'Unggulan', 'url' => '/unggulan', 'icon' => 'fa-solid fa-award', 'order' => 6],
            ['name' => 'Prestasi', 'url' => '/prestasi', 'icon' => 'fa-solid fa-trophy', 'order' => 7],
            ['name' => 'Kabar', 'url' => '/artikel', 'icon' => 'fa-solid fa-newspaper', 'order' => 8],
        ];

        QuickMenu::truncate();
        foreach ($quickMenus as $qm) {
            QuickMenu::create(array_merge($qm, ['is_active' => true]));
        }

        // 4. Categories
        $categoriesMap = [
            'taujih' => 'Taujih & Tausiyah',
            'berita' => 'Berita Pondok',
            'kegiatan' => 'Kegiatan Santri',
            'prestasi-siswa' => 'Prestasi Santri & Guru',
            'akademik-riset' => 'Dirasah & Sains',
            'tahfidz-keislaman' => 'Tahfidzul Qur\'an',
            'kabar-kampus' => 'Kabar Kampus',
            'opini' => 'Opini & Khazanah',
        ];

        foreach ($categoriesMap as $slug => $catName) {
            Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $catName, 'description' => 'Kategori '.$catName]
            );
        }

        // 5. Update Static Pages
        $pages = [
            [
                'title' => 'Sambutan Mudir Pondok Pesantren Raudhatul Ulum',
                'slug' => 'sambutan-kepala-sekolah',
                'content' => '<h2>Assalamu\'alaikum Warahmatullahi Wabarakatuh</h2><p>Segala puji dan syukur kita panjatkan ke hadirat Allah Subhanahu wa Ta\'ala, yang telah melimpahkan rahmat, taufiq, dan inayah-Nya kepada kita semua. Shalawat dan salam senantiasa tercurahkan kepada junjungan kita Nabi Besar Muhammad Shallallahu \'Alaihi Wasallam, keluarga, sahabat, dan pengikutnya yang setia hingga akhir zaman.</p><p>Pondok Pesantren Raudhatul Ulum Sakatiga sejak didirikannya pada tanggal 1 Agustus 1950, bertekad menjadi benteng pertahanan aqidah umat dan basis kaderisasi generasi terbaik (Khoiru Ummah). Memadukan kurikulum kepesantrenan terpadu (Pondok Modern Gontor), Kementerian Agama, serta kurikulum nasional, santri dibina selama 24 jam dalam lingkungan asrama yang asri, disiplin, dan islami.</p><p>Kami menyambut hangat para orang tua/wali santri dan masyarakat luas yang ingin bermitra bersama kami mendidik putra-putri tercinta menjadi insan yang beraqidah lurus, beribadah benar, berakhlak mulia, berilmu luas, mandiri, dan siap berkhidmat bagi umat dan bangsa.</p><p><strong>Wassalamu\'alaikum Warahmatullahi Wabarakatuh</strong><br><em>Mudir PPRU Sakatiga, KH. Tol\'at Wafa Ahmad, Lc.</em></p>',
            ],
            [
                'title' => 'Tentang Pondok Pesantren Raudhatul Ulum Sakatiga',
                'slug' => 'tentang-kami',
                'content' => '<p>Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga adalah lembaga pendidikan Islam yang dikelola oleh Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS), berlokasi di Desa Sakatiga, Kecamatan Indralaya, Kabupaten Ogan Ilir, Sumatera Selatan (sekitar 40 km dari Kota Palembang).</p><p>Berdiri di atas lahan lebih dari 60 hektar yang mencakup Kampus A, Kampus B, dan Kampus C, lingkungan PPRU tertata asri, berwawasan lingkungan, dan sangat kondusif bagi tumbuh kembang santri. Pesantren menyelenggarakan pendidikan terpadu mulai dari jenjang anak usia dini (TAKIRU), dasar (MIRU), menengah (MATSARU, MARU, SMPIT, SMAIT), program khusus Tahfidzul Qur\'an Lil Aulad (MATQULARU), hingga perguruan tinggi (STITRU).</p>',
            ],
            [
                'title' => 'Visi, Misi, dan 10 Jati Diri Santri',
                'slug' => 'visi-dan-misi',
                'content' => '<h3>VISI</h3><p><em>"Menjadi basis kaderisasi generasi terbaik (Khoiru Ummah) yang bermanfaat luas dan berdaya saing global."</em></p><h3>MISI</h3><ol><li><strong>Ta\'lim:</strong> Menyelenggarakan kegiatan pengajaran secara utuh dan terpadu untuk menyiapkan sumber daya insani yang berwawasan luas dan menguasai ilmu syar\'i serta sains teknologi.</li><li><strong>Tarbiyah:</strong> Menginternalisasi nilai-nilai Islam kepada santri untuk membentuk kepribadian berkarakter mulia, kokoh secara moral, spiritual, dan emosional.</li><li><strong>Dakwah:</strong> Melatih dan membekali santri keterampilan dakwah Islamiyah, kepekaan sosial, serta kesiapan menegakkan amar ma\'ruf nahi munkar di tengah masyarakat.</li></ol><h3>10 JATI DIRI SANTRI (SDI RAUDHATUL ULUM)</h3><ol><li>Beraqidah lurus (Salimul Aqidah)</li><li>Beribadah benar (Shahihul Ibadah)</li><li>Berakhlak mulia (Matinul Khuluq)</li><li>Berdikari / Mandiri (Qadirun \'alal Kasbi)</li><li>Berpengetahuan luas (Mutsaqqoful Fikri)</li><li>Berbadan sehat dan kuat (Qowiyyul Jismi)</li><li>Mampu mengendalikan hawa nafsu (Mujahidun li Nafsihi)</li><li>Berdisiplin tinggi (Munazzhomun fi Syu\'unihi)</li><li>Mampu mengelola waktu (Haritsun \'ala Waqtihi)</li><li>Bermanfaat bagi masyarakat (Nafi\'un li Ghairihi)</li></ol>',
            ],
            [
                'title' => 'Sejarah Perkembangan Pondok Pesantren Raudhatul Ulum',
                'slug' => 'sejarah',
                'content' => '<p>Sejarah Pondok Pesantren Raudhatul Ulum Sakatiga terbagi ke dalam tiga fase bersejarah:</p><h4>1. Era Cikal Bakal (1930 - 1950 M)</h4><p>PPRU berakar dari dua madrasah bersejarah di Sakatiga sebelum kemerdekaan RI: Madrasah Al-Falah yang didirikan pada tahun 1930 oleh KH. Bahri bin Bunga (dilanjutkan KH. Abdul Ghanie Bahri) dan Madrasah Al-Shibyan yang dirintis pada tahun 1936 oleh KH. Abd. Rahim Mandung dan KH. Abdullah Kenalim. Desa Sakatiga sejak masa itu telah masyhur dijuluki sebagai "Mekkah Kecil" di Sumatera Selatan karena banyaknya ulama asal Sakatiga yang menuntut ilmu di tanah suci Mekkah.</p><h4>2. Era Lanjutan Perjuangan (1950 - 1986 M)</h4><p>Pada 1 Agustus 1950, para tokoh dan ulama Sakatiga bersepakat menghidupkan kembali madrasah dengan mendirikan Sekolah Rakyat Islam (SRI) dan Sekolah Menengah Agama Islam (SMAI), yang kemudian disederhanakan menjadi Perguruan Islam Raudhatul Ulum Sakatiga (PIRUS) di bawah naungan YAPIRUS (Akte Notaris Aminus No. 21.A Tahun 1966).</p><h4>3. Era Modern & Boarding School (1986 - Sekarang)</h4><p>Mulai 8 Agustus 1986 di bawah kepemimpinan Mudir KH. Tol\'at Wafa Ahmad, Lc., diterapkan sistem terpadu antara kurikulum Pondok Modern Darussalam Gontor, Departemen Agama, dan Departemen Pendidikan Nasional dengan asrama penuh (boarding school). Jenjang madrasah aliyah dan tsanawiyah PPRU juga mendapatkan piagam muadalah pengakuan kesetaraan dari Universitas Al-Azhar Kairo Mesir dan Universitas Islam Madinah.</p>',
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'content' => $p['content'],
                ]
            );

            Post::updateOrCreate(
                ['slug' => $p['slug'], 'type' => 'page'],
                [
                    'title' => $p['title'],
                    'content' => $p['content'],
                    'status' => 'publish',
                    'type' => 'page',
                    'published_at' => now(),
                ]
            );
        }
    }
}
