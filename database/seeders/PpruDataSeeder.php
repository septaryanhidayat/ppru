<?php

namespace Database\Seeders;

use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Category;
use App\Models\Dpc;
use App\Models\Page;
use App\Models\Post;
use App\Models\QuickMenu;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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

        // 2. Unit Pendidikan PPRU (8 Unit Resmi Terstruktur)
        $units = [
            // --- 1. MADRASAH ---
            [
                'name' => 'Madrasah Aliyah Raudhatul Ulum',
                'short_name' => 'MARU',
                'slug' => 'madrasah-aliyah-raudhatul-ulum',
                'category_type' => 'Madrasah',
                'curriculum' => 'Kurikulum Terpadu Gontor & Kemenag / Muadalah Al-Azhar Kairo Mesir',
                'badge' => 'Terakreditasi A & Muadalah Al-Azhar',
                'description' => 'Madrasah Aliyah (setara SMA) berasrama putra dan putri dengan kurikulum terpadu ilmu-ilmu syar\'i (Kitab Kuning), dwi-bahasa aktif (Arab & Inggris), serta sains umum. Lulusan MARU memiliki ijazah muadalah resmi yang diakui langsung di Universitas Al-Azhar Kairo Mesir dan Universitas Islam Madinah Arab Saudi.',
                'head_name' => 'Ustadz H. M. Said, S.Ag.',
                'phone' => '0812-7890-1950',
                'email' => 'maru@ppru.ac.id',
                'thumbnail' => '/uploads/campus-ppru-sakatiga.webp',
                'icon' => 'fa-solid fa-graduation-cap',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Madrasah Tsanawiyah Raudhatul Ulum',
                'short_name' => 'MATSARU',
                'slug' => 'madrasah-tsanawiyah-raudhatul-ulum',
                'category_type' => 'Madrasah',
                'curriculum' => 'Kurikulum Terpadu Gontor & Kemenag / Muadalah Al-Azhar',
                'badge' => 'Terakreditasi A',
                'description' => 'Madrasah Tsanawiyah (setara SMP) berasrama yang fokus pada peletakan pondasi aqidah shohihah, pembiasaan ibadah yaumiyah, tahfidz, dan kemampuan dasar percakapan bahasa Arab & Inggris aktif.',
                'head_name' => 'Ustadz Drs. H. Syamsuddin',
                'phone' => '0812-7890-1950',
                'email' => 'matsaru@ppru.ac.id',
                'thumbnail' => '/uploads/campus-robbani.webp',
                'icon' => 'fa-solid fa-book-open-reader',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Madrasah Ibtidaiyah Raudhatul Ulum',
                'short_name' => 'MIRU',
                'slug' => 'madrasah-ibtidaiyah-raudhatul-ulum',
                'category_type' => 'Madrasah',
                'curriculum' => 'Kurikulum Kemenag & Muatan Lokal Kepesantrenan',
                'badge' => 'Terakreditasi A',
                'description' => 'Pendidikan dasar Islam formal tingkat Ibtidaiyah (setara SD) dengan penekanan pada tartil Al-Qur\'an, pembiasaan akhlak terpuji, dan dasar-dasar ilmu umum yang kokoh sejak usia dini.',
                'head_name' => 'Ustadzah Hj. Maryam, S.Pd.I.',
                'phone' => '0812-7890-1950',
                'email' => 'miru@ppru.ac.id',
                'thumbnail' => '/uploads/activities-ppru-sakatiga.webp',
                'icon' => 'fa-solid fa-school',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Madrasah Tahfizhul Qur\'an Lil Aulad',
                'short_name' => 'MATQULARU',
                'slug' => 'madrasah-tahfizhul-quran-raudhatul-ulum',
                'category_type' => 'Madrasah',
                'curriculum' => 'Kurikulum Khusus Tahfidz 30 Juz Mutqin Bersanad & Ulumul Qur\'an',
                'badge' => 'Tahfidz Khusus Bersanad',
                'description' => 'Lembaga pendidikan khusus tahfidz Al-Qur\'an dengan metode intensif dan bimbingan masyaikh serta para huffazh bersanad untuk mencetak kader penghafal Al-Qur\'an 30 juz mutqin.',
                'head_name' => 'Ustadz H. Abdul Halim, Al-Hafizh',
                'phone' => '0812-7890-1950',
                'email' => 'tahfidz@ppru.ac.id',
                'thumbnail' => '/uploads/ppru-tahfidz.webp',
                'icon' => 'fa-solid fa-book-quran',
                'order' => 4,
                'is_active' => true,
            ],

            // --- 2. TAMAN KANAK-KANAK (TK) ---
            [
                'name' => 'Taman Kanak-Kanak Islam Raudhatul Ulum',
                'short_name' => 'TAKIRU',
                'slug' => 'taman-kanak-kanak-islam-raudhatul-ulum',
                'category_type' => 'TK Islam',
                'curriculum' => 'Pendidikan Anak Usia Dini Islami Terpadu & Sentra Qur\'ani',
                'badge' => 'PAUD & TK Islam Terdaftar',
                'description' => 'Pendidikan anak usia dini yang menyenangkan dengan pendekatan sentra Qur\'ani, pembiasaan doa dan adab harian, motorik anak, serta keceriaan belajar dalam suasana islami.',
                'head_name' => 'Ustadzah Fatimah, S.Pd.',
                'phone' => '0812-7890-1950',
                'email' => 'takiru@ppru.ac.id',
                'thumbnail' => '/uploads/ppru-jatidiri.webp',
                'icon' => 'fa-solid fa-shapes',
                'order' => 5,
                'is_active' => true,
            ],

            // --- 3. SEKOLAH ISLAM TERPADU (SIT) ---
            [
                'name' => 'SMP Islam Terpadu Raudhatul Ulum',
                'short_name' => 'SMPIT RU',
                'slug' => 'smp-islam-terpadu-raudhatul-ulum',
                'category_type' => 'Sekolah IT',
                'curriculum' => 'Kurikulum JSIT Indonesia & Kurikulum Nasional',
                'badge' => 'Terakreditasi A - JSIT',
                'description' => 'Sekolah Menengah Pertama Islam Terpadu berasrama yang unggul dalam integrasi ilmu pengetahuan, pembinaan adab santri, kemandirian kepanduan pramuka, dan eksplorasi bakat minat siswa.',
                'head_name' => 'Ustadz Ridwan, S.Pd.I.',
                'phone' => '0812-7890-1950',
                'email' => 'smpit@ppru.ac.id',
                'thumbnail' => '/uploads/lab-robbani.webp',
                'icon' => 'fa-solid fa-award',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'SMA Islam Terpadu Raudhatul Ulum',
                'short_name' => 'SMAIT RU',
                'slug' => 'sma-islam-terpadu-raudhatul-ulum',
                'category_type' => 'Sekolah IT',
                'curriculum' => 'Kurikulum JSIT Indonesia & Kurikulum Merdeka Nasional',
                'badge' => 'Terakreditasi B - JSIT',
                'description' => 'Sekolah Menengah Atas berbasis Islam Terpadu yang memadukan keunggulan sains teknologi, pembinaan karakter kepemimpinan, riset ilmiah remaja, dan tahfidzul qur\'an mutqin.',
                'head_name' => 'Ustadz Ahmad Fauzi, M.Pd.',
                'phone' => '0812-7890-1950',
                'email' => 'smait@ppru.ac.id',
                'thumbnail' => '/uploads/library-robbani.webp',
                'icon' => 'fa-solid fa-atom',
                'order' => 7,
                'is_active' => true,
            ],

            // --- 4. PERGURUAN TINGGI (INSTITUT) ---
            [
                'name' => 'Institut Agama Islam Nur Raudhatul Ulum',
                'short_name' => 'IAI NRU',
                'slug' => 'institut-agama-islam-nur-raudhatul-ulum',
                'category_type' => 'Perguruan Tinggi',
                'curriculum' => 'Kurikulum Pendidikan Tinggi Islam Kemenag RI (S1 PAI & Perbankan Syariah)',
                'badge' => 'Terakreditasi BAN-PT',
                'description' => 'Institut Agama Islam di lingkungan pesantren menyelenggarakan program Sarjana (S1) dengan keunggulan integrasi ilmu syar\'i, riset ilmiah, dan kepemimpinan dakwah.',
                'head_name' => 'Dr. H. M. Husin, M.A.',
                'phone' => '0812-7890-1950',
                'email' => 'iainru@ppru.ac.id',
                'thumbnail' => '/uploads/ppru-alazhar.webp',
                'icon' => 'fa-solid fa-graduation-cap',
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

        // 6. Purge Legacy Ishlahul Ummah Posts
        Post::where('type', 'post')->where(function ($q) {
            $q->where('title', 'like', '%ishlahul%')
                ->orWhere('content', 'like', '%ishlahul%')
                ->orWhere('title', 'like', '%ishum%')
                ->orWhere('content', 'like', '%ishum%')
                ->orWhere('title', 'like', '%prabumulih%')
                ->orWhere('title', 'like', '%agi gustiawan%');
        })->delete();

        // 7. Seed Pengurus Yayasan (YAPIRUS) & Pendidik Unit Sekolah
        AnggotaDewan::truncate();
        $dewanData = [
            // --- PENGURUS YAYASAN (YAPIRUS) & PIMPINAN PESANTREN ---
            [
                'name' => 'KH. Tol\'at Wafa Ahmad, Lc.',
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
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS).',
                'education' => 'Sarjana Pendidikan Islam',
                'order' => 2,
            ],
            [
                'name' => 'H. Faisal Abdullah, S.T.',
                'slug' => 'h-faisal-abdullah-st',
                'position' => 'Ketua Umum Pengurus YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Ketua Umum Badan Pengurus Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                'education' => 'Sarjana Teknik',
                'order' => 3,
            ],
            [
                'name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                'slug' => 'ustadz-h-ahmad-dailami-spdi',
                'position' => 'Sekretaris Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Sekretaris Umum Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                'education' => 'S1 Pendidikan Agama Islam',
                'order' => 4,
            ],
            [
                'name' => 'H. M. Husin, M.Si.',
                'slug' => 'h-m-husin-msi',
                'position' => 'Bendahara Yayasan YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Bendahara Umum Yayasan Perguruan Islam Raudhatul Ulum Sakatiga.',
                'education' => 'Magister Sains Manajemen',
                'order' => 5,
            ],
            [
                'name' => 'Ustadz H. Abdul Halim, Lc.',
                'slug' => 'ustadz-h-abdul-halim-lc',
                'position' => 'Wakil Mudir Bidang Pendidikan & Pengajaran',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Wakil Mudir PPRU membidangi kurikulum pesantren, Kemenag, dan muadalah Al-Azhar Kairo.',
                'education' => 'Alumni Universitas Al-Azhar Kairo',
                'order' => 6,
            ],
            [
                'name' => 'Ustadz H. Syamsuddin, S.Ag.',
                'slug' => 'ustadz-h-syamsuddin-sag',
                'position' => 'Wakil Mudir Bidang Kepengasuhan Santri',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Wakil Mudir PPRU membidangi kedisiplinan asrama, bahasa Arab & Inggris, dan pengasuhan santri.',
                'education' => 'Sarjana Agama',
                'order' => 7,
            ],
            [
                'name' => 'Ir. H. Ahmad Fauzi',
                'slug' => 'ir-h-ahmad-fauzi',
                'position' => 'Wakil Mudir Bidang Pembangunan & Sarana',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Wakil Mudir PPRU membidangi perencanaan fisik kampus A, B, C, sarana, dan unit usaha pesantren.',
                'education' => 'Sarjana Teknik Sipil',
                'order' => 8,
            ],

            // --- DEWAN GURU UNIT MARU ---
            [
                'name' => 'Ustadz H. M. Said, S.Ag.',
                'slug' => 'ustadz-h-m-said-sag',
                'position' => 'Kepala Madrasah Aliyah Raudhatul Ulum',
                'fraction' => 'MARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Kepala Madrasah Aliyah Raudhatul Ulum Sakatiga.',
                'education' => 'S1 IAIN Raden Fatah',
                'order' => 9,
            ],
            [
                'name' => 'Ustadz Ahmad Baihaki, Lc.',
                'slug' => 'ustadz-ahmad-baihaki-lc',
                'position' => 'Guru Dirasah Islamiyah & Bahasa Arab',
                'fraction' => 'MARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Pengajar Kitab Kuning, Balaghah, dan Nahwu Sharaf MARU.',
                'education' => 'Universitas Al-Azhar Mesir',
                'order' => 10,
            ],
            [
                'name' => 'Ustadzah Siti Rohmah, M.Pd.',
                'slug' => 'ustadzah-siti-rohmah-mpd',
                'position' => 'Guru Kimia & Biologi Terapan',
                'fraction' => 'MARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Pengajar Sains dan Koordinator Praktikum Laboratorium IPA MARU.',
                'education' => 'Magister Pendidikan Kimia Universitas Sriwijaya',
                'order' => 11,
            ],

            // --- DEWAN GURU UNIT SMAIT RU ---
            [
                'name' => 'Ustadz Ahmad Fauzi, M.Pd.',
                'slug' => 'ustadz-ahmad-fauzi-mpd',
                'position' => 'Kepala SMAIT Raudhatul Ulum',
                'fraction' => 'SMAIT RU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Kepala SMA Islam Terpadu Raudhatul Ulum Sakatiga.',
                'education' => 'Magister Pendidikan UNSRI',
                'order' => 12,
            ],
            [
                'name' => 'Ustadz Hendra Gunawan, S.Si.',
                'slug' => 'ustadz-hendra-gunawan-ssi',
                'position' => 'Guru Fisika & Pembimbing Robotika',
                'fraction' => 'SMAIT RU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Pembimbing Olimpiade Sains Nasional Fisika dan Klub Robotika Santri.',
                'education' => 'S1 Fisika MIPA',
                'order' => 13,
            ],
            [
                'name' => 'Ustadzah Nurul Hidayati, S.Pd.',
                'slug' => 'ustadzah-nurul-hidayati-spd',
                'position' => 'Guru Matematika & IT Terapan',
                'fraction' => 'SMAIT RU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Pengajar Matematika Sains Terpadu SMAIT RU.',
                'education' => 'S1 Pendidikan Matematika',
                'order' => 14,
            ],

            // --- DEWAN GURU UNIT MATSARU ---
            [
                'name' => 'Ustadz Drs. H. Syamsuddin',
                'slug' => 'ustadz-drs-h-syamsuddin',
                'position' => 'Kepala MTs Raudhatul Ulum',
                'fraction' => 'MATSARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Kepala Madrasah Tsanawiyah Raudhatul Ulum Sakatiga.',
                'education' => 'Drs. Pendidikan Islam',
                'order' => 15,
            ],
            [
                'name' => 'Ustadz Salman Al-Farisi, S.Pd.I.',
                'slug' => 'ustadz-salman-al-farisi-spdi',
                'position' => 'Guru Bahasa Arab & Pembina Disiplin Bahasa',
                'fraction' => 'MATSARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Koordinator Markaz Lughah dan Pembinaan Mufrodat MATSARU.',
                'education' => 'S1 Bahasa Arab',
                'order' => 16,
            ],

            // --- DEWAN GURU UNIT SMPIT RU ---
            [
                'name' => 'Ustadz Ridwan, S.Pd.I.',
                'slug' => 'ustadz-ridwan-spdi',
                'position' => 'Kepala SMPIT Raudhatul Ulum',
                'fraction' => 'SMPIT RU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Kepala SMP Islam Terpadu Raudhatul Ulum Sakatiga.',
                'education' => 'S1 Tarbiyah',
                'order' => 17,
            ],

            // --- DEWAN ASATIDZ UNIT MATQULARU ---
            [
                'name' => 'Ustadz H. Abdul Halim, Al-Hafizh',
                'slug' => 'ustadz-h-abdul-halim-al-hafizh',
                'position' => 'Mudir Tahfizhul Qur\'an Lil Aulad',
                'fraction' => 'MATQULARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Mudir Lembaga Tahfizhul Qur\'an Lil Aulad PPRU Sakatiga, pemegang sanad Al-Qur\'an 30 juz mutqin.',
                'education' => 'Kulliyatul Qur\'an',
                'order' => 18,
            ],
            [
                'name' => 'Ustadz Muhammad Zaki, Al-Hafizh',
                'slug' => 'ustadz-muhammad-zaki-al-hafizh',
                'position' => 'Muhaffizh 30 Juz & Pengajar Tajwid',
                'fraction' => 'MATQULARU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Pembimbing halaqah tahfidz mutqin dan tasmi\' 30 juz sekali duduk.',
                'education' => 'Tahfidzul Qur\'an Mutqin',
                'order' => 19,
            ],

            // --- DEWAN GURU UNIT MIRU ---
            [
                'name' => 'Ustadzah Hj. Maryam, S.Pd.I.',
                'slug' => 'ustadzah-hj-maryam-spdi',
                'position' => 'Kepala Madrasah Ibtidaiyah Raudhatul Ulum',
                'fraction' => 'MIRU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Kepala Madrasah Ibtidaiyah Raudhatul Ulum Sakatiga.',
                'education' => 'S1 Pendidikan Guru Madrasah Ibtidaiyah',
                'order' => 20,
            ],

            // --- DEWAN GURU UNIT TAKIRU ---
            [
                'name' => 'Ustadzah Fatimah, S.Pd.',
                'slug' => 'ustadzah-fatimah-spd',
                'position' => 'Kepala TK Islam Raudhatul Ulum',
                'fraction' => 'TAKIRU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Kepala TK Islam Raudhatul Ulum Sakatiga.',
                'education' => 'S1 PG-PAUD',
                'order' => 21,
            ],

            // --- DOSEN & PIMPINAN UNIT STITRU ---
            [
                'name' => 'Dr. H. M. Husin, M.A.',
                'slug' => 'dr-h-m-husin-ma',
                'position' => 'Ketua STIT Raudhatul Ulum',
                'fraction' => 'STITRU',
                'photo' => '/uploads/default-avatar.webp',
                'profile_summary' => 'Ketua Sekolah Tinggi Ilmu Tarbiyah Raudhatul Ulum Sakatiga.',
                'education' => 'Doktor Pendidikan Islam',
                'order' => 22,
            ],
        ];

        foreach ($dewanData as $d) {
            AnggotaDewan::create($d);
        }

        // 7. Program Unggulan (Dpc)
        $programs = [
            [
                'name' => 'Program Tahfidz Mutqin 30 Juz',
                'slug' => 'program-tahfidz-mutqin-30-juz',
                'address' => 'Kurikulum Khusus Keislaman PPRU',
                'description' => 'Bimbingan intensif membaca Al-Qur\'an dengan tartil, tahsin bersanad, dan hafalan mutqin serta program Munaqosah Tahfidz.',
                'order' => 1,
            ],
            [
                'name' => 'Bina Pribadi Islam (BPI) & Karakter Santri',
                'slug' => 'bina-pribadi-islam-bpi',
                'address' => 'Pembinaan Karakter Santri',
                'description' => 'Halaqah pekanan pembinaan adab, pembiasaan ibadah yaumiyah, dzikir ma\'tsurat, serta penanaman 10 Jati Diri Santri Raudhatul Ulum.',
                'order' => 2,
            ],
            [
                'name' => 'Kurikulum Terpadu Muadalah Al-Azhar & Nasional',
                'slug' => 'kurikulum-terpadu-muadalah-al-azhar',
                'address' => 'Integrasi Dirasah Islamiyah & Sains',
                'description' => 'Memadukan standar capaian Kurikulum Nasional dengan kurikulum Muadalah Universitas Al-Azhar Kairo Mesir.',
                'order' => 3,
            ],
            [
                'name' => 'Program Bahasa Arab & Inggris Aktif (Bilingual)',
                'slug' => 'program-bahasa-arab-inggris-bilingual',
                'address' => 'Pengembangan Bahasa Internasional',
                'description' => 'Pembiasaan muhadatsah harian, pidato 3 bahasa (Muhadharah), dan penguasaan kitab-kitab turots berbahasa Arab.',
                'order' => 4,
            ],
            [
                'name' => 'Safar Ilmiah & Rihlah Edukatif',
                'slug' => 'safar-ilmiah-rihlah-edukatif',
                'address' => 'Outdoor Learning & Wawasan Global',
                'description' => 'Pembelajaran luar kelas berbasis observasi alam, studi kampus dalam dan luar negeri, dan riset ilmiah santri.',
                'order' => 5,
            ],
            [
                'name' => 'Khidmat Dakwah & Kemasyarakatan',
                'slug' => 'khidmat-dakwah-kemasyarakatan',
                'address' => 'Kepedulian Sosial & Pengabdian Ummat',
                'description' => 'Kiprah nyata santri dalam Praktik Pengabdian Masyarakat (P2S/PPM) dan dakwah ke berbagai pelosok nusantara.',
                'order' => 6,
            ],
        ];

        Dpc::truncate();
        foreach ($programs as $prog) {
            Dpc::create($prog);
        }

        // 8. Sarana & Fasilitas Pesantren (Bidang)
        $facilities = [
            [
                'name' => 'Masjid Baitul Qur\'an & Pusat Ibadah',
                'slug' => 'masjid-baitul-quran-pusat-ibadah',
                'description' => 'Masjid representatif sebagai pusat sholat berjamaah lima waktu, halaqah tahfidz Al-Qur\'an, kajian kitab kuning, dan pembinaan ruhiyah santri.',
                'thumbnail' => '/uploads/campus-robbani.webp',
                'order' => 1,
            ],
            [
                'name' => 'Kompleks Asrama Santri Putra & Putri',
                'slug' => 'kompleks-asrama-santri',
                'description' => 'Gedung asrama bertingkat dengan kamar tidur yang nyaman, ventilasi baik, pengawasan musyrif/musyrifah 24 jam, dan lingkungan asri.',
                'thumbnail' => '/uploads/campus-robbani.webp',
                'order' => 2,
            ],
            [
                'name' => 'Laboratorium Komputer, Bahasa & IPA Terpadu',
                'slug' => 'laboratorium-komputer-bahasa-ipa',
                'description' => 'Fasilitas praktikum modern dengan perangkat komputer terkoneksi internet cepat, audio lab bahasa, dan peralatan eksperimen sains lengkap.',
                'thumbnail' => '/uploads/lab-robbani.webp',
                'order' => 3,
            ],
            [
                'name' => 'Perpustakaan & Pusat Sumber Belajar',
                'slug' => 'perpustakaan-pusat-sumber-belajar',
                'description' => 'Koleksi ribuan kitab turots klasik, buku teks pendidikan nasional, jurnal ilmiah, e-library digital, dan ruang baca ber-AC.',
                'thumbnail' => '/uploads/library-robbani.webp',
                'order' => 4,
            ],
            [
                'name' => 'Gedung Aula Serbaguna & Pusat Haflah',
                'slug' => 'gedung-aula-serbaguna',
                'description' => 'Auditorium utama tempat berlangsungnya acara resmi pesantren seperti Haflah Takhtiman, wisuda, seminar internasional, dan perlombaan.',
                'thumbnail' => '/uploads/ppru-haflah.webp',
                'order' => 5,
            ],
            [
                'name' => 'Klinik Kesehatan Pesantren (Poskestren)',
                'slug' => 'klinik-poskestren',
                'description' => 'Layanan rawat jalan dan pertolongan pertama santri dengan tenaga medis perawat dan dokter jaga, serta rujukan ke RSUD.',
                'thumbnail' => '/uploads/activities-robbani.webp',
                'order' => 6,
            ],
        ];

        Bidang::truncate();
        foreach ($facilities as $fac) {
            Bidang::create(array_merge($fac, [
                'address' => 'Kampus Pondok Pesantren Raudhatul Ulum Sakatiga, Ogan Ilir',
                'phone' => '0812-7890-1950',
                'email' => 'sekretariat@ppru.ac.id',
            ]));
        }

        // 9. Testimoni Santri & Wali Santri PPRU
        Testimonial::truncate();
        $testimonials = [
            [
                'name' => 'Eva Astuti',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Anakku bernama Abdurrosyad Fadlillah saat ini duduk di kelas XI. Alhamdulillah sekarang sudah mulai berani tampil dan mandiri, sopan santun semakin baik. Semoga dengan bimbingan dari asatidz dan ustadzah di pondok, ananda semakin percaya diri, berakhlakul karimah, dan disiplin dalam ibadah maupun belajar. Aamiin ya Rabbal \'alamin.',
                'status' => 'publish',
            ],
            [
                'name' => 'Ayu Putri',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Toby Aldinata Timothy anakku santri baru tahun ini di Pondok Pesantren Raudhatul Ulum. Pembinaan karakternya sangat terasa sejak awal masuk. Semoga yang baik menjadi semakin baik lagi dan istiqomah.',
                'status' => 'publish',
            ],
            [
                'name' => 'Evi Riani',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Putri sulungku Seren Rahmadani saat ini duduk di kelas akhir. Alhamdulillah ada perubahan yang terus positif dan signifikan, hafalannya bertambah, mandiri, dan beradab sesuai nilai-nilai santri Raudhatul Ulum.',
                'status' => 'publish',
            ],
            [
                'name' => 'Penny Cahyani',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Najwa Rizkiya Ramadhani nama putriku yang saat ini duduk di kelas akhir. Kami sangat bersyukur menyekolahkannya di Pondok Pesantren Raudhatul Ulum Sakatiga. Semoga setelah lulus ananda bisa menjadi generasi berakhlak mulia yang bermanfaat bagi umat.',
                'status' => 'publish',
            ],
            [
                'name' => 'Yulianti Widiastuti',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Anakku bernama Annisa Dhiya Abelia saat ini sudah di kelas XII. Anak semakin percaya diri, hafalan Al-Qur\'annya terus bertambah mutqin, dan selalu berhati-hati serta berpegang teguh pada nilai-nilai agama dalam kesehariannya.',
                'status' => 'publish',
            ],
            [
                'name' => 'Dora Indah',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Anakku bernama Ragil Rizgy Putra duduk di kelas XI. Saya merasa membuat pilihan yang sangat tepat menitipkan anak di Pondok Pesantren Raudhatul Ulum Sakatiga. Kekeluargaan para asatidz dan pengasuh asrama membuat kami tenang, bersama membimbing anak-anak menuju sukses dunia dan akhirat. Aamiin.',
                'status' => 'publish',
            ],
            [
                'name' => 'Suharyanti',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Abi Anggara Santriyano adalah anak laki-lakiku yang saat ini duduk di kelas XII. PPRU terus mengutamakan kualitas pendidikan agama, tahfidz, dan akhlakul karimah. Para ustadz memberikan perhatian terbaik dan mendidik sepenuh hati.',
                'status' => 'publish',
            ],
            [
                'name' => 'Sugiarti',
                'profession' => 'Alumni Pondok Pesantren Raudhatul Ulum',
                'content' => 'Setelah menempuh pendidikan di Pondok Pesantren Raudhatul Ulum, saya merasakan perubahan besar dalam hal kedisiplinan ibadah dan pergaulan. Ilmu agama dan wawasan yang didapat sangat mendalam, didukung lingkungan ukhuwah santri yang saling menyemangati dalam kebaikan.',
                'status' => 'publish',
            ],
            [
                'name' => 'Shella Destiani',
                'profession' => 'Alumni Pondok Pesantren Raudhatul Ulum',
                'content' => 'Pondok Pesantren Raudhatul Ulum memiliki lingkungan yang sangat suportif, tanpa senioritas yang merugikan. Asatidz dan dewan guru sangat peduli, membimbing kami layaknya orang tua kedua. Bekal adab, Al-Qur\'an, dan kemandirian dari pondok menjadi modal berharga bagi saya saat melanjutkan pendidikan dan berkarier.',
                'status' => 'publish',
            ],
            [
                'name' => 'Toni Siswanto dan Widyaningtyastuti',
                'profession' => 'Wali Santri Pondok Pesantren Raudhatul Ulum',
                'content' => 'Assalamu\'alaikum warahmatullahi wabarakatuh. Kami orang tua dari ananda Yunita Andini Amalia bersyukur ananda menuntut ilmu di Pondok Pesantren Raudhatul Ulum Sakatiga. Pondok mendidik santri dengan penuh kasih sayang, membekali dengan tahfidz, tahsin bersanad, bahasa Arab-Inggris, serta ilmu pengetahuan umum. Lingkungan asrama islami dan terjaga.',
                'status' => 'publish',
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // 10. Galeri Dokumentasi Foto Kegiatan Santri PPRU
        Post::where('type', 'gallery')->delete();
        $galleries = [
            ['title' => 'Haflah Takhtiman & Wisuda Akbar Santri Pondok Pesantren Raudhatul Ulum', 'img' => '/uploads/ppru-haflah.webp'],
            ['title' => 'Muhadharah 3 Bahasa: Arab, Inggris, dan Indonesia Santri PPRU', 'img' => '/uploads/ppru-muhadharah.webp'],
            ['title' => 'Kafilah Musabaqah Tilawatil Qur\'an (MTQ) Santri Raudhatul Ulum', 'img' => '/uploads/ppru-mtq.webp'],
            ['title' => 'Perkemahan Pramuka Santri Pondok Pesantren Raudhatul Ulum Sakatiga', 'img' => '/uploads/ppru-pramuka.webp'],
            ['title' => 'Kunjungan Delegasi Muadalah Universitas Al-Azhar Kairo Mesir di PPRU', 'img' => '/uploads/ppru-alazhar.webp'],
            ['title' => 'Halaqah Tahfizhul Qur\'an 30 Juz Santri MATQULARU', 'img' => '/uploads/ppru-tahfidz.webp'],
            ['title' => 'Sarasehan Asatidz & Halaqah Keilmuan Ulama Pesantren Raudhatul Ulum', 'img' => '/uploads/ppru-sarasehan.webp'],
            ['title' => 'Debat Ilmiah Bahasa Arab & Bahasa Inggris Santri PPRU', 'img' => '/uploads/ppru-debat.webp'],
            ['title' => 'Kompetisi Sains Madrasah (KSM) Santri MARU & MTs RU', 'img' => '/uploads/ppru-ksm.webp'],
            ['title' => 'Kontingen Perkemahan Pramuka Santri Nusantara (PPSN) PPRU', 'img' => '/uploads/ppru-ppsn.webp'],
            ['title' => 'Pembinaan 10 Jati Diri Santri Pondok Pesantren Raudhatul Ulum', 'img' => '/uploads/ppru-jatidiri.webp'],
            ['title' => 'Kampus Terpadu & Masjid Utama Pondok Pesantren Raudhatul Ulum Sakatiga', 'img' => '/uploads/campus-ppru-sakatiga.webp'],
            ['title' => 'Latihan Memanah & Olahraga Sunnah Santri Raudhatul Ulum', 'img' => '/uploads/activities-ppru-sakatiga.webp'],
        ];

        foreach ($galleries as $g) {
            Post::create([
                'title' => $g['title'],
                'slug' => Str::slug($g['title']),
                'content' => 'Dokumentasi kegiatan santri dan lingkungan Pondok Pesantren Raudhatul Ulum Sakatiga.',
                'featured_image' => $g['img'],
                'type' => 'gallery',
                'status' => 'publish',
            ]);
        }
    }
}
