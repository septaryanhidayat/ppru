<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Category;
use App\Models\Dpc;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\QuickMenu;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SchoolDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Settings SMA IT Plus Robbani
        $settings = [
            'site_name' => 'SMA IT Plus Robbani',
            'site_tagline' => "Membina Generasi Qur'ani, Cerdas & Berkarakter",
            'site_description' => 'Website Resmi SMA IT Plus Robbani Indralaya Ogan Ilir. Sekolah Islam Terpadu berakreditasi unggul dengan kurikulum tahfidz mutqin dan sains riset modern.',
            'contact_email' => 'info@smaitplusrobbani.sch.id',
            'contact_phone' => '0821-7788-9900',
            'contact_whatsapp' => '0821-7788-9900',
            'contact_address' => 'Jl. Lintas Timur Palembang-Prabumulih KM 35, Indralaya, Kab. Ogan Ilir, Sumatera Selatan.',
            'social_facebook' => 'https://facebook.com/smaitplusrobbani',
            'social_instagram' => 'https://instagram.com/smaitplusrobbani',
            'social_youtube' => 'https://youtube.com/@smaitplusrobbani',
            'social_tiktok' => 'https://tiktok.com/@smaitplusrobbani',
            'social_twitter' => 'https://x.com/smait_robbani',
            'banner_daftar_url' => '/hubungi',
            'banner_donasi_url' => '/donasi',
            'site_logo' => '/uploads/logo-robbani.svg',
            'og_title' => "SMA IT Plus Robbani - Membina Generasi Qur'ani & Cerdas",
            'og_description' => 'Official Portal SMA IT Plus Robbani Indralaya Ogan Ilir: Informasi PPDB, Berita Prestasi, Fasilitas Kampus, Dewan Guru, dan Kurikulum Terpadu.',
            'og_image' => '/uploads/campus-robbani.jpg',
            'meta_keywords' => 'sma it plus robbani, sma it ogan ilir, sekolah islam terpadu indralaya, sma it robbani, tahfidz ogan ilir, ppdb robbani',
            'donation_bank_1_name' => 'Bank Sumsel Babel Syariah',
            'donation_bank_1_code' => '120',
            'donation_bank_1_rekening' => '801-09-00123',
            'donation_bank_1_holder' => 'YAYASAN ROBBANI OGAN ILIR',
            'donation_bank_2_name' => 'Bank Syariah Indonesia (BSI)',
            'donation_bank_2_code' => '451',
            'donation_bank_2_rekening' => '718-293-8401',
            'donation_bank_2_holder' => 'SMA IT PLUS ROBBANI INDRALAYA',
            'donation_confirm_phone' => '0821-7788-9900',
            'donation_confirm_text' => "Assalamu'alaikum Bendahara SMA IT Plus Robbani, saya telah menyalurkan donasi infaq pendidikan.",
            'donation_intro_text' => 'Salurkan infaq pembangunan sarana laboratorium sains, asrama santri, dan beasiswa dhuafa melalui rekening resmi sekolah.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Quick Menus (FontAwesome Icons Modern)
        $quickMenus = [
            ['name' => 'Sambutan', 'url' => '/sambutan-kepala-sekolah', 'icon' => 'fa-solid fa-user-tie', 'order' => 1],
            ['name' => 'Profil', 'url' => '/tentang-kami', 'icon' => 'fa-solid fa-school', 'order' => 2],
            ['name' => 'Dewan Guru', 'url' => '/dewan-guru', 'icon' => 'fa-solid fa-chalkboard-user', 'order' => 3],
            ['name' => 'Fasilitas', 'url' => '/fasilitas', 'icon' => 'fa-solid fa-layer-group', 'order' => 4],
            ['name' => 'Kabar Sekolah', 'url' => '/artikel', 'icon' => 'fa-solid fa-newspaper', 'order' => 5],
            ['name' => 'Pengumuman', 'url' => '/pengumuman', 'icon' => 'fa-solid fa-bullhorn', 'order' => 6],
            ['name' => 'Galeri Video', 'url' => '/video', 'icon' => 'fa-brands fa-youtube', 'order' => 7],
            ['name' => 'Agenda', 'url' => '/agenda', 'icon' => 'fa-solid fa-calendar-days', 'order' => 8],
        ];

        QuickMenu::truncate();
        foreach ($quickMenus as $qm) {
            QuickMenu::create(array_merge($qm, ['is_active' => true]));
        }

        // 3. Dewan Guru & GTK
        $dewanData = [
            [
                'name' => 'Drs. H. Ahmad Husen, M.Pd.I',
                'position' => 'Kepala Sekolah',
                'fraction' => 'Pimpinan Utama',
                'photo' => '/uploads/kepala-sekolah-robbani.jpg',
                'profile_summary' => 'Berpengalaman lebih dari 20 tahun dalam manajemen pendidikan Islam terpadu dan kepemimpinan sekolah berwawasan global.',
                'order' => 1,
            ],
            [
                'name' => 'Ustadz H. Salman Al-Farisi, Lc., M.Ag',
                'position' => 'Waka Bidang Keislaman & Tahfidz',
                'fraction' => 'Program Diniyah',
                'photo' => '/uploads/tahfidz-robbani.jpg',
                'profile_summary' => 'Alumni Universitas Al-Azhar Kairo dengan sanad tahfidz Al-Qur\'an 30 juz dan pembina halaqah mutqin santri.',
                'order' => 2,
            ],
            [
                'name' => 'Dra. Hj. Nurul Hidayah, M.Pd',
                'position' => 'Waka Bidang Kurikulum & Akademik',
                'fraction' => 'Kurikulum Merdeka',
                'photo' => '/uploads/library-robbani.jpg',
                'profile_summary' => 'Pakar kurikulum sains dan pengembang modul pembelajaran berdiferensiasi tingkat sekolah menengah atas.',
                'order' => 3,
            ],
            [
                'name' => 'Muhammad Ridwan, S.Pd., Gr',
                'position' => 'Waka Bidang Kesiswaan & Kedisiplinan',
                'fraction' => 'Bina Karakter',
                'photo' => '/uploads/activities-robbani.jpg',
                'profile_summary' => 'Instruktur kepanduan dan pembina pembiasaan karakter islami serta kepemimpinan santri Robbani.',
                'order' => 4,
            ],
            [
                'name' => 'Ir. Hendra Kusuma, S.T',
                'position' => 'Waka Bidang Sarana & Prasarana',
                'fraction' => 'Fasilitas & Lab',
                'photo' => '/uploads/lab-robbani.jpg',
                'profile_summary' => 'Mengawasi standardisasi laboratorium sains modern, ruang multimedia, dan sarana boarding santri.',
                'order' => 5,
            ],
            [
                'name' => 'Ahmad Fauzan, S.Si., M.Sc',
                'position' => 'Guru Biologi & Koordinator Riset Sains',
                'fraction' => 'Olimpiade Sains',
                'photo' => '/uploads/robotics-robbani.jpg',
                'profile_summary' => 'Pembimbing tim Olimpiade Sains Nasional (OSN) bidang Biologi dan Kimia peraih medali tingkat provinsi.',
                'order' => 6,
            ],
            [
                'name' => 'Ustadzah Fatimah Azzahra, S.Pd.I',
                'position' => 'Koordinator Musyrifah & Tahfidz Putri',
                'fraction' => 'Boarding Putri',
                'photo' => '/uploads/tahfidz-robbani.jpg',
                'profile_summary' => 'Hafizhah 30 juz bersanad, pengasuh asrama santriwati dan pembimbing adab yaumiyah akhwat.',
                'order' => 7,
            ],
            [
                'name' => 'Siti Khadijah, S.E',
                'position' => 'Kepala Tata Usaha & Layanan PPDB',
                'fraction' => 'Administrasi',
                'photo' => '/uploads/campus-robbani.jpg',
                'profile_summary' => 'Mengkoordinasikan pelayanan administrasi kesiswaan, kepegawaian, dan informasi pendaftaran santri baru.',
                'order' => 8,
            ],
        ];

        AnggotaDewan::truncate();
        foreach ($dewanData as $d) {
            AnggotaDewan::create(array_merge($d, ['slug' => Str::slug($d['name'])]));
        }

        // 4. Fasilitas Sekolah (Bidangs)
        $facilities = [
            [
                'name' => 'Laboratorium Sains & Bioteknologi Terpadu',
                'slug' => 'laboratorium-sains-bioteknologi',
                'description' => 'Laboratorium berstandar modern dilengkapi mikroskop digital, instrumen kimia analitis, dan peralatan fisika eksperimen untuk mendukung riset sains siswa.',
                'icon' => 'fa-solid fa-flask-vial',
                'order' => 1,
            ],
            [
                'name' => 'Islamic Boarding School & Asrama Asri',
                'slug' => 'islamic-boarding-school-asrama',
                'description' => 'Gedung asrama santri putra dan putri terpisah dengan fasilitas kamar ber-AC, kamar mandi higienis, pengawasan musyrif 24 jam, dan ruang belajar terpadu.',
                'icon' => 'fa-solid fa-hotel',
                'order' => 2,
            ],
            [
                'name' => 'Masjid Kampus & Hall Halaqah Tahfidz',
                'slug' => 'masjid-kampus-halaqah-tahfidz',
                'description' => 'Pusat pembinaan spiritual dan shalat berjamaah 5 waktu, dilengkapi ruang berhawa sejuk untuk program tasmi\' dan muraja\'ah Al-Qur\'an santri.',
                'icon' => 'fa-solid fa-mosque',
                'order' => 3,
            ],
            [
                'name' => 'Laboratorium Komputer & Digital Coding',
                'slug' => 'laboratorium-komputer-digital-coding',
                'description' => 'Ruang komputer canggih dengan koneksi internet fiber optik kecepatan tinggi untuk pembelajaran pemrograman web, multimedia grafis, dan robotika.',
                'icon' => 'fa-solid fa-laptop-code',
                'order' => 4,
            ],
            [
                'name' => 'Perpustakaan Digital & Literacy Hub',
                'slug' => 'perpustakaan-digital-literacy-hub',
                'description' => 'Menyediakan ribuan judul buku cetak dan e-book, jurnal sains internasional, kitab-kitab turats rujukan, dan sudut baca nyaman ramah siswa.',
                'icon' => 'fa-solid fa-book-open-reader',
                'order' => 5,
            ],
            [
                'name' => 'Gelanggang Olahraga & Lapangan Terbuka',
                'slug' => 'gelanggang-olahraga-lapangan-terbuka',
                'description' => 'Fasilitas olahraga mencakup lapangan basket, futsal, bulu tangkis, lintasan lari, serta area memanah (archery) sesuai sunnah Nabi SAW.',
                'icon' => 'fa-solid fa-dumbbell',
                'order' => 6,
            ],
        ];

        Bidang::truncate();
        foreach ($facilities as $fac) {
            Bidang::create(array_merge($fac, [
                'address' => 'Kampus SMA IT Plus Robbani Indralaya',
                'phone' => '0821-7788-9900',
                'email' => 'fasilitas@smaitplusrobbani.sch.id',
            ]));
        }

        // 5. Program Unggulan (Dpcs)
        $programs = [
            [
                'name' => 'Program Tahfidz Mutqin 30 Juz',
                'slug' => 'program-tahfidz-mutqin-30-juz',
                'address' => 'Kurikulum Khusus Diniyah',
                'description' => 'Bimbingan intensif menghafal Al-Qur\'an dengan metode tasmi\' berkala, muraja\'ah bertingkat, dan pengujian sanad bersama asatidz hafizh mutqin.',
                'order' => 1,
            ],
            [
                'name' => 'Kelas Olimpiade Sains & Riset Ilmiah (KSR)',
                'slug' => 'kelas-olimpiade-sains-riset-ilmiah',
                'address' => 'Pengembangan Prestasi Akademik',
                'description' => 'Pembinaan intensif persiapan OSN Matematika, Fisika, Kimia, Biologi, dan Informatika dengan silabus perguruan tinggi dan eksperimen laboratorium terapan.',
                'order' => 2,
            ],
            [
                'name' => 'Bilingual Immersion Camp (Arab & Inggris)',
                'slug' => 'bilingual-immersion-camp',
                'address' => 'Kecakapan Bahasa Internasional',
                'description' => 'Pengondisian lingkungan berbahasa Arab dan Inggris di lingkungan asrama dan kelas untuk membekali santri bersaing di kancah global.',
                'order' => 3,
            ],
            [
                'name' => 'Bimbingan Sukses PTN & Beasiswa Luar Negeri',
                'slug' => 'bimbingan-sukses-ptn-luar-negeri',
                'address' => 'Karier & Masa Depan Santri',
                'description' => 'Program pendampingan try out SNBT, bimbingan seleksi universitas di Timur Tengah (Al-Azhar, Madinah), dan persiapan beasiswa internasional.',
                'order' => 4,
            ],
            [
                'name' => 'Ekstrakurikuler Robotika & Internet of Things (IoT)',
                'slug' => 'ekstrakurikuler-robotika-iot',
                'address' => 'Teknologi & Kreativitas Digital',
                'description' => 'Melatih santri merakit sensor robotik, mikrokontroler Arduino, dan otomasi cerdas yang siap diikutsertakan dalam kompetisi nasional.',
                'order' => 5,
            ],
            [
                'name' => 'Islamic Leadership & Character Building',
                'slug' => 'islamic-leadership-character-building',
                'address' => 'Kepemimpinan Masa Depan',
                'description' => 'Latihan kepemimpinan santri melalui OSIS terpadu, kepanduan Hizbul Wathan / Pramuka, retorika dakwah khitabah, dan bakti kemasyarakatan.',
                'order' => 6,
            ],
        ];

        Dpc::truncate();
        foreach ($programs as $prog) {
            Dpc::create($prog);
        }

        // 6. Kategori Sekolah (Bersihkan Kategori Lama)
        DB::table('post_category')->delete();
        DB::table('post_tag')->delete();

        // Hapus kategori politik/lawas
        Category::whereNotIn('slug', [
            'prestasi-siswa',
            'akademik-riset',
            'tahfidz-keislaman',
            'kesiswaan-ekskul',
            'kabar-kampus',
            'agenda-pengumuman',
        ])->delete();

        $categoriesMap = [
            'prestasi-siswa' => 'Prestasi Siswa',
            'akademik-riset' => 'Akademik & Riset',
            'tahfidz-keislaman' => 'Tahfidz & Keislaman',
            'kesiswaan-ekskul' => 'Kesiswaan & Ekskul',
            'kabar-kampus' => 'Kabar Kampus',
            'agenda-pengumuman' => 'Agenda & Pengumuman',
        ];

        $categoryModels = [];
        foreach ($categoriesMap as $slug => $catName) {
            $categoryModels[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $catName, 'description' => 'Kategori '.$catName]
            );
        }

        // 7. Tags Sekolah
        Tag::whereNotIn('slug', [
            'ppdb', 'tahfidz', 'sains', 'olimpiade', 'robotika', 'beasiswa', 'ekskul', 'pramuka', 'asrama', 'riset', 'juara',
        ])->delete();

        $tagNames = [
            'ppdb' => 'PPDB',
            'tahfidz' => 'Tahfidz',
            'sains' => 'Sains',
            'olimpiade' => 'Olimpiade',
            'robotika' => 'Robotika',
            'beasiswa' => 'Beasiswa',
            'ekskul' => 'Ekskul',
            'pramuka' => 'Pramuka',
            'asrama' => 'Asrama',
            'riset' => 'Riset',
            'juara' => 'Juara',
        ];

        $tagModels = [];
        foreach ($tagNames as $slug => $tName) {
            $tagModels[$slug] = Tag::updateOrCreate(
                ['slug' => $slug],
                ['name' => $tName]
            );
        }

        // 8. Video Demo YouTube (Mengganti Video PKS Lama)
        Video::truncate();
        $demoVideos = [
            [
                'title' => 'Video Profil SMA IT Plus Robbani - Kampus Islami, Cerdas & Berkarakter',
                'slug' => 'video-profil-sma-it-plus-robbani',
                'youtube_url' => 'https://www.youtube.com/watch?v=M7lc1UVf-VE',
                'youtube_id' => 'M7lc1UVf-VE',
                'description' => 'Mengenal lebih dekat lingkungan belajar islami, kurikulum unggulan, dan fasilitas modern di SMA IT Plus Robbani Indralaya Ogan Ilir.',
            ],
            [
                'title' => 'Dokumentasi Kampus Hijau & Fasilitas Belajar Modern Santri Robbani',
                'slug' => 'fasilitas-belajar-modern-santri-robbani',
                'youtube_url' => 'https://www.youtube.com/watch?v=LXb3EKWsInQ',
                'youtube_id' => 'LXb3EKWsInQ',
                'description' => 'Suasana asri dan nyaman kampus terpadu SMA IT Plus Robbani yang menunjang kenyamanan belajar santri boarding school.',
            ],
            [
                'title' => 'Praktikum Sains & Eksperimen Laboratorium Terpadu Biologi-Kimia',
                'slug' => 'praktikum-sains-eksperimen-laboratorium',
                'youtube_url' => 'https://www.youtube.com/watch?v=EngW7tLk6R8',
                'youtube_id' => 'EngW7tLk6R8',
                'description' => 'Kegiatan eksperimen sains para santri di laboratorium modern dengan bimbingan guru dan praktisi sains.',
            ],
            [
                'title' => 'Keseruan Pembelajaran Ekstrakurikuler Robotika, Coding & IoT Santri',
                'slug' => 'ekstrakurikuler-robotika-coding-iot',
                'youtube_url' => 'https://www.youtube.com/watch?v=ScMzIvxBSi4',
                'youtube_id' => 'ScMzIvxBSi4',
                'description' => 'Santri Robbani merakit sistem otomatisasi cerdas berbasis mikrokontroler dan mikrorobotika.',
            ],
            [
                'title' => 'Suasana Halaqah Tahfidz Mutqin & Tasmi\' Al-Qur\'an Santri Robbani',
                'slug' => 'suasana-tahfidz-mutqin-tasmi-quran',
                'youtube_url' => 'https://www.youtube.com/watch?v=ysz5S6PUM-U',
                'youtube_id' => 'ysz5S6PUM-U',
                'description' => 'Lantunan ayat suci Al-Qur\'an dalam halaqah subuh dan maghrib santri tahfidz 30 juz bersama asatidz bersanad.',
            ],
            [
                'title' => 'Wisuda Akbar Tahfidz Al-Qur\'an 30 Juz & Pelepasan Santri Angkatan Ke-VIII',
                'slug' => 'wisuda-akbar-tahfidz-quran-30-juz',
                'youtube_url' => 'https://www.youtube.com/watch?v=aqz-KE-bpKQ',
                'youtube_id' => 'aqz-KE-bpKQ',
                'description' => 'Momen mengharukan wisuda para penghafal Al-Qur\'an yang siap melanjutkan pendidikan tinggi di dalam dan luar negeri.',
            ],
        ];

        foreach ($demoVideos as $v) {
            Video::create($v);
        }

        // 9. Pengumuman Resmi Sekolah
        Pengumuman::truncate();
        $announcements = [
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) SMA IT Plus Robbani TP 2026/2027 Resmi Dibuka',
                'slug' => 'ppdb-sma-it-plus-robbani-2026-2027',
                'content' => '<p>Pendaftaran Santri Baru Tahun Ajaran 2026/2027 telah dibuka untuk program Reguler dan Program Beasiswa Tahfidz. Pendaftaran dapat dilakukan secara online melalui website resmi atau langsung datang ke sekretariat kampus.</p>',
                'status' => 'publish',
                'featured_image' => '/uploads/campus-robbani.jpg',
            ],
            [
                'title' => 'Pelaksanaan Ujian Tasmi\' Al-Qur\'an 30 Juz Santri Angkatan Ke-VIII',
                'slug' => 'pelaksanaan-ujian-tasmi-quran-30-juz',
                'content' => '<p>Ujian tasmi\' bil ghaib sekali duduk akan dilaksanakan pada pekan depan di Masjid Kampus Robbani. Orang tua santri dipersilakan hadir memberikan doa restu.</p>',
                'status' => 'publish',
                'featured_image' => '/uploads/tahfidz-robbani.jpg',
            ],
            [
                'title' => 'Pengumuman Hasil Seleksi Beasiswa Prestasi Tahfidz & Sains Jalur Khusus',
                'slug' => 'hasil-seleksi-beasiswa-tahfidz-sains',
                'content' => '<p>Selamat kepada para calon santri yang dinyatakan lolos seleksi beasiswa penuh tahfidz dan sains gelombang pertama. Silakan melakukan konfirmasi registrasi ulang.</p>',
                'status' => 'publish',
                'featured_image' => '/uploads/library-robbani.jpg',
            ],
            [
                'title' => 'Jadwal Masuk Asrama & Masa Ta\'aruf Santri Madrasah (MATSAMA) 2026',
                'slug' => 'jadwal-masuk-asrama-matsama-2026',
                'content' => '<p>Seluruh santri baru diharapkan hadir di asrama sesuai jadwal yang telah ditentukan dengan membawa perlengkapan asrama dan berkas administrasi lengkap.</p>',
                'status' => 'publish',
                'featured_image' => '/uploads/activities-robbani.jpg',
            ],
        ];

        foreach ($announcements as $an) {
            Pengumuman::create($an);
        }

        // 10. Agenda Sekolah
        Agenda::truncate();
        $agendas = [
            [
                'title' => 'Wisuda Akbar Tahfidz Al-Qur\'an 30 Juz & Khotmil Kutub Angkatan VIII',
                'slug' => 'wisuda-akbar-tahfidz-angkatan-viii',
                'content' => '<p>Prosesi wisuda tahfidz akbar santri SMA IT Plus Robbani yang telah menyelesaikan tasmi\' 30 juz.</p>',
                'location' => 'Auditorium Kampus Robbani Indralaya',
                'event_date' => now()->addDays(15),
                'status' => 'publish',
                'featured_image' => '/uploads/tahfidz-robbani.jpg',
            ],
            [
                'title' => 'Simulasi Try Out SNBT & Bimbingan Khusus Menuju PTN Favorit',
                'slug' => 'simulasi-try-out-snbt-ptn',
                'content' => '<p>Uji coba simulasi komputer SNBT bekerjasama dengan lembaga bimbel nasional terakreditasi.</p>',
                'location' => 'Laboratorium Komputer Robbani',
                'event_date' => now()->addDays(25),
                'status' => 'publish',
                'featured_image' => '/uploads/library-robbani.jpg',
            ],
            [
                'title' => 'Kemah Dakwah & Latihan Dasar Kepemimpinan Santri (LDKS)',
                'slug' => 'kemah-dakwah-ldks-santri',
                'content' => '<p>Kegiatan kepanduan alam terbuka untuk melatih kemandirian, kepemimpinan, dan kerja tim santri.</p>',
                'location' => 'Bumi Perkemahan Robbani',
                'event_date' => now()->addDays(35),
                'status' => 'publish',
                'featured_image' => '/uploads/activities-robbani.jpg',
            ],
            [
                'title' => 'Parenting Akbar & Silaturahim Paguyuban Wali Santri Robbani',
                'slug' => 'parenting-akbar-wali-santri',
                'content' => '<p>Pertemuan silaturahim akbar orang tua santri bersama pakar parenting Islam dan dewan asatidz.</p>',
                'location' => 'Masjid Kampus Robbani',
                'event_date' => now()->addDays(45),
                'status' => 'publish',
                'featured_image' => '/uploads/campus-robbani.jpg',
            ],
        ];

        foreach ($agendas as $ag) {
            Agenda::create($ag);
        }

        // 11. Testimonials Sekolah
        Testimonial::truncate();
        $testimonials = [
            [
                'name' => 'H. Hendra Pratama, S.E',
                'profession' => 'Wali Murid - Orang Tua Santri Kelas XII',
                'content' => 'Alhamdulillah, putra kami tidak hanya dibina hafalan Al-Qur\'annya hingga mutqin, tetapi juga dibekali kemampuan sains dan akhlak yang mulia. SMA IT Plus Robbani benar-benar pilihan terbaik untuk masa depan generasi muda.',
                'photo' => '/uploads/kepala-sekolah-robbani.jpg',
                'status' => 'publish',
            ],
            [
                'name' => 'dr. Sarah Nurhaliza',
                'profession' => 'Alumni SMA IT Plus Robbani - Dokter Muda Alumni FK UNSRI',
                'content' => 'Fondasi disiplin ibadah, karakter leadership, dan bimbingan akademik di Robbani sangat membantu saya ketika menempuh pendidikan kedokteran. Robbani mengajarkan kami menjadi insan berprestasi yang senantiasa dekat dengan Al-Qur\'an.',
                'photo' => '/uploads/library-robbani.jpg',
                'status' => 'publish',
            ],
            [
                'name' => 'Ahmad Zaki Mubarak',
                'profession' => 'Santri Berprestasi - Peraih Medali Perunggu OSN Matematika',
                'content' => 'Belajar di SMA IT Plus Robbani sangat menyenangkan. Guru-guru membimbing dengan sabar, fasilitas laboratorium lengkap, dan suasana asramanya membuat kami fokus menghafal Al-Qur\'an sekaligus meneliti sains.',
                'photo' => '/uploads/robotics-robbani.jpg',
                'status' => 'publish',
            ],
            [
                'name' => 'Ir. Faisal Basri, M.T',
                'profession' => 'Ketua Komite Sekolah & Tokoh Pendidikan',
                'content' => 'Kerjasama antara guru, pengasuh asrama, dan orang tua santri sangat erat. Kurikulum terpadunya terbukti melahirkan lulusan berakhlak terpuji, berpikiran kritis, dan berwawasan global.',
                'photo' => '/uploads/campus-robbani.jpg',
                'status' => 'publish',
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // 12. Hapus SEMUA Post Berita PKS Lama & Isi Berita Sekolah Baru
        Post::where('type', 'post')->delete();

        $schoolPosts = [
            [
                'title' => 'Siswa SMA IT Plus Robbani Raih Medali Emas Olimpiade Sains Nasional (OSN) Biologi & Matematika',
                'slug' => 'siswa-robbani-raih-medali-emas-osn',
                'excerpt' => 'Prestasi membanggakan kembali ditorehkan santri SMA IT Plus Robbani dalam ajang bergengsi Olimpiade Sains Nasional tingkat provinsi.',
                'content' => '<p>Alhamdulillah, civitas akademika SMA IT Plus Robbani patut berbangga atas pencapaian gemilang santri pada Olimpiade Sains Nasional (OSN). Melalui pembinaan intensif di Klub Sains Robbani (KSR), dua santri berhasil membawa pulang medali emas bidang Biologi dan Matematika Terapan.</p><p>Kepala Sekolah SMA IT Plus Robbani, Drs. H. Ahmad Husen, M.Pd.I, menyampaikan apresiasi setinggi-tingginya kepada para santri dan guru pembimbing. Keberhasilan ini membuktikan bahwa perpaduan kurikulum sains modern dan nilai-nilai Islam dapat mencetak generasi yang kompetitif di kancah nasional.</p>',
                'featured_image' => '/uploads/lab-robbani.jpg',
                'category' => 'prestasi-siswa',
                'tags' => ['prestasi', 'olimpiade', 'sains', 'juara'],
                'views_count' => 1420,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Alhamdulillah, 15 Santri SMA IT Plus Robbani Tuntaskan Ujian Tasmi\' Al-Qur\'an 30 Juz Sekali Duduk',
                'slug' => '15-santri-tuntaskan-tasmi-quran-30-juz',
                'excerpt' => 'Suasana haru dan khidmat menyelimuti Masjid Kampus Robbani saat 15 santri memperdengarkan hafalan Al-Qur\'an 30 juz secara mutqin.',
                'content' => '<p>Sebanyak 15 santri SMA IT Plus Robbani berhasil menuntaskan Ujian Tasmi\' Al-Qur\'an 30 Juz Bil Ghaib sekali duduk di hadapan dewan penguji bersanad. Program tasmi\' ini merupakan puncak dari pembinaan tahfidz intensif berasrama yang dijalankan selama tiga tahun.</p><p>Para santri didampingi oleh musyrik dan orang tua yang hadir menyaksikan prosesi pengujian dari pagi hingga petang. Semoga berkah Al-Qur\'an senantiasa menyinari langkah para santri dan keluarga besar Robbani.</p>',
                'featured_image' => '/uploads/tahfidz-robbani.jpg',
                'category' => 'tahfidz-keislaman',
                'tags' => ['tahfidz', 'asrama', 'prestasi'],
                'views_count' => 2180,
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru (PPDB) SMA IT Plus Robbani TP 2026/2027 Resmi Dibuka',
                'slug' => 'ppdb-sma-it-plus-robbani-2026-resmi-dibuka',
                'excerpt' => 'SMA IT Plus Robbani membuka pendaftaran santri baru untuk jenjang SMA dengan kuota terbatas dan beasiswa jalur tahfidz.',
                'content' => '<p>Penerimaan Peserta Didik Baru (PPDB) SMA IT Plus Robbani Tahun Ajaran 2026/2027 resmi dibuka mulai hari ini. Sekolah menyediakan dua jalur utama: Jalur Reguler Berasrama dan Jalur Prestasi Beasiswa Penuh Tahfidz Al-Qur\'an minimal 10 juz.</p><p>Orang tua calon santri dapat mendaftar langsung secara online melalui portal PPDB resmi sekolah atau mengunjungi helpdesk panitia PPDB di kampus Robbani Indralaya.</p>',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'category' => 'agenda-pengumuman',
                'tags' => ['ppdb', 'beasiswa'],
                'views_count' => 3890,
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Inovasi Pembelajaran: Tim Robotika Santri Robbani Ciptakan Prototype Smart Greenhouse Berbasis IoT',
                'slug' => 'tim-robotika-robbani-ciptakan-smart-greenhouse-iot',
                'excerpt' => 'Memadukan teknologi digital dan kepedulian lingkungan, santri Robbani merancang sistem pemantauan suhu dan kelembaban tanaman otomatis.',
                'content' => '<p>Tim ekstrakurikuler Robotika dan Coding SMA IT Plus Robbani berhasil mengembangkan prototype smart greenhouse berbasis mikrokontroler ESP32 dan sensor IoT. Alat ini mampu menyiram tanaman secara otomatis dan mengirim notifikasi kondisi nutrisi tanah ke smartphone secara real-time.</p><p>Karya ini dipersiapkan untuk mengikuti ajang kompetisi sains terapan remaja tingkat nasional pada akhir semester ini.</p>',
                'featured_image' => '/uploads/robotics-robbani.jpg',
                'category' => 'akademik-riset',
                'tags' => ['robotika', 'sains', 'riset'],
                'views_count' => 1120,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Kemah Dakwah & Latihan Dasar Kepemimpinan Santri (LDKS) Robbani Bangun Karakter Tangguh',
                'slug' => 'kemah-dakwah-dan-ldks-robbani',
                'excerpt' => 'Melatih kemandirian, kepemimpinan islami, dan solidaritas ukhuwah santri di alam terbuka melalui kegiatan perkemahan tahunan.',
                'content' => '<p>Kegiatan Kemah Dakwah dan Latihan Dasar Kepemimpinan Santri (LDKS) berlangsung sukses selama tiga hari di Bumi Perkemahan Robbani. Santri dilatih bertahan hidup di alam, navigasi darat, retorika kepemimpinan, dan bakti sosial membersihkan masjid di desa sekitar.</p>',
                'featured_image' => '/uploads/activities-robbani.jpg',
                'category' => 'kesiswaan-ekskul',
                'tags' => ['ekskul', 'pramuka', 'asrama'],
                'views_count' => 980,
                'published_at' => now()->subDays(11),
            ],
            [
                'title' => 'Perpustakaan Digital Robbani Hadirkan Ribuan Koleksi Buku Sains dan Kitab Turats Rujukan',
                'slug' => 'perpustakaan-digital-robbani-hadirkan-koleksi-lengkap',
                'excerpt' => 'Mendukung iklim literasi tinggi, perpustakaan SMA IT Plus Robbani kini dilengkapi katalog digital e-library dan ruang baca multimedia.',
                'content' => '<p>Pengembangan fasilitas literasi menjadi prioritas SMA IT Plus Robbani. Perpustakaan sekolah kini terhubung dengan akses ribuan jurnal ilmiah nasional dan internasional, ensiklopedia sains modern, serta kitab-kitab turats rujukan klasik yang dapat diakses santri melalui tablet dan komputer lab.</p>',
                'featured_image' => '/uploads/library-robbani.jpg',
                'category' => 'kabar-kampus',
                'tags' => ['riset', 'sains'],
                'views_count' => 870,
                'published_at' => now()->subDays(14),
            ],
            [
                'title' => 'Santri Putri SMA IT Plus Robbani Sabet Juara Umum Lomba Khitabah Bahasa Arab & Inggris',
                'slug' => 'santri-putri-robbani-juara-umum-khitabah-bilingual',
                'excerpt' => 'Kemahiran berbicara dalam bahasa asing mengantarkan santriwati Robbani mendominasi podium juara perlombaan pidato bilingual se-Sumatera.',
                'content' => '<p>Kecakapan public speaking dalam bahasa Arab dan Inggris santriwati SMA IT Plus Robbani membuahkan hasil membanggakan dengan meraih predikat Juara Umum pada Festival Bahasa Pelajar Islam 2026. Bimbingan intensif lingkungan bilingual di asrama menjadi kunci sukses para santriwati.</p>',
                'featured_image' => '/uploads/library-robbani.jpg',
                'category' => 'prestasi-siswa',
                'tags' => ['prestasi', 'juara', 'ekskul'],
                'views_count' => 1340,
                'published_at' => now()->subDays(17),
            ],
            [
                'title' => 'Kunjungan Edukatif Santri ke Laboratorium Terpadu Universitas Sriwijaya',
                'slug' => 'kunjungan-edukatif-santri-ke-laboratorium-unsri',
                'excerpt' => 'Memperluas wawasan riset ilmiah, santri kelas XI IPA Robbani melakukan praktikum lanjutan instrumen spektroskopi di UNSRI.',
                'content' => '<p>Sebagai bagian dari pengayaan kurikulum sains terapan, rombongan santri kelas XI peminatan IPA berkunjung ke Laboratorium Sains Universitas Sriwijaya untuk mempraktikkan analisis kimia instrumen dan bioteknologi mikrobiologi modern.</p>',
                'featured_image' => '/uploads/lab-robbani.jpg',
                'category' => 'akademik-riset',
                'tags' => ['sains', 'riset'],
                'views_count' => 760,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Pekan Olahraga Sunnah: Turnamen Memanah & Beladiri Semarakkan Milad Sekolah Ke-12',
                'slug' => 'pekan-olahraga-sunnah-memanah-beladiri-milad-12',
                'excerpt' => 'Mengamalkan sunnah Rasulullah SAW dalam melatih kebugaran fisik dan konsentrasi santri lewat kompetisi panahan terpadu.',
                'content' => '<p>Peringatan Milad ke-12 SMA IT Plus Robbani diwarnai dengan Turnamen Panahan Tradisional (Horsebow & Standard Bow) antar santri dan perlombaan seni beladiri Tapak Suci / Pencak Silat. Kegiatan ini bertujuan menumbuhkan jiwa kesatria dan sportivitas santri.</p>',
                'featured_image' => '/uploads/activities-robbani.jpg',
                'category' => 'kesiswaan-ekskul',
                'tags' => ['ekskul', 'juara'],
                'views_count' => 910,
                'published_at' => now()->subDays(23),
            ],
            [
                'title' => 'Seminar Parenting Islami: Sinergi Rumah dan Sekolah Membina Generasi Qur\'ani Tangguh',
                'slug' => 'seminar-parenting-islami-sinergi-rumah-dan-sekolah',
                'excerpt' => 'Ratusan wali santri antusias mengikuti seminar pola asuh generasi Z bersama pakar psikologi keluarga Islam nasional.',
                'content' => '<p>Pendidikan karakter yang kokoh membutuhkan keselarasan antara keteladanan orang tua di rumah dan pembinaan asatidz di sekolah. Hal ini ditegaskan dalam Seminar Parenting Akbar SMA IT Plus Robbani yang dihadiri seluruh wali murid secara hybrid.</p>',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'category' => 'kabar-kampus',
                'tags' => ['asrama', 'tahfidz'],
                'views_count' => 1250,
                'published_at' => now()->subDays(26),
            ],
            [
                'title' => 'Program Sukses PTN: 94% Lulusan Angkatan VII Robbani Diterima di Perguruan Tinggi Negeri Favorit',
                'slug' => '94-persen-lulusan-robbani-diterima-ptn-favorit',
                'excerpt' => 'Hasil seleksi nasional SNBP dan SNBT mencatat rekor kelulusan santri Robbani di UI, ITB, UNSRI, IPB, serta beasiswa Al-Azhar Kairo.',
                'content' => '<p>Kabar gembira menyelimuti wisudawan Angkatan VII SMA IT Plus Robbani, di mana 94% santri berhasil menembus perguruan tinggi negeri unggulan dan universitas di Timur Tengah. Keberhasilan ini tidak terlepas dari program karantina SNBT dan bimbingan karir yang dirancang intensif sejak kelas XI.</p>',
                'featured_image' => '/uploads/library-robbani.jpg',
                'category' => 'akademik-riset',
                'tags' => ['prestasi', 'beasiswa', 'juara'],
                'views_count' => 2450,
                'published_at' => now()->subDays(29),
            ],
            [
                'title' => 'Bakti Sosial Santri Robbani: Salurkan 500 Paket Sembako dan Pengobatan Gratis untuk Dhuafa',
                'slug' => 'bakti-sosial-santri-robbani-salurkan-sembako-dhuafa',
                'excerpt' => 'Menanamkan rasa empati dan kepedulian sosial, santri Robbani terjun langsung menyalurkan bantuan kepada warga prasejahtera di sekitar kampus.',
                'content' => '<p>Santri SMA IT Plus Robbani menyelenggarakan agenda sosial kemanusiaan dengan membagikan 500 paket sembako, santunan anak yatim, dan layanan pemeriksaan kesehatan cuma-cuma bekerjasama dengan puskesmas setempat. Kegiatan ini menjadi sarana mengasah kepedulian umat.</p>',
                'featured_image' => '/uploads/activities-robbani.jpg',
                'category' => 'kabar-kampus',
                'tags' => ['ekskul', 'asrama'],
                'views_count' => 820,
                'published_at' => now()->subDays(32),
            ],
        ];

        foreach ($schoolPosts as $postData) {
            $catSlug = $postData['category'];
            $tagSlugs = $postData['tags'];
            unset($postData['category'], $postData['tags']);

            $post = Post::create(array_merge($postData, [
                'type' => 'post',
                'status' => 'publish',
            ]));

            if (isset($categoryModels[$catSlug])) {
                $post->categories()->sync([$categoryModels[$catSlug]->id]);
            }

            $tagIds = [];
            foreach ($tagSlugs as $tSlug) {
                if (isset($tagModels[$tSlug])) {
                    $tagIds[] = $tagModels[$tSlug]->id;
                }
            }
            if (! empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }
        }

        // 13. Halaman Statis Resmi Sekolah (Wipe Halaman PKS)
        Post::where('type', 'page')->whereIn('slug', [
            'sambutan-ketua-dpd',
            'visi-dan-misi',
            'tentang-kami',
            'sejarah',
            'struktur-kepengurusan',
            'donasi',
            'e-book',
            'hymne-mars-pks',
            'logo',
            'hubungi',
        ])->delete();

        $officialPages = [
            [
                'slug' => 'sambutan-kepala-sekolah',
                'title' => 'Sambutan Kepala Sekolah SMA IT Plus Robbani',
                'excerpt' => 'Sambutan resmi Kepala Sekolah SMA IT Plus Robbani, Drs. H. Ahmad Husen, M.Pd.I.',
                'featured_image' => '/uploads/kepala-sekolah-robbani.jpg',
                'content' => <<<'HTML'
<p><strong>Assalamu'alaikum Warahmatullahi Wabarakatuh,</strong></p>
<p>Alhamdulillahirabbil'alamin, segala puji dan syukur senantiasa kita panjatkan ke hadirat Allah Subhanahu Wa Ta'ala atas segala nikmat dan karunia-Nya. Shalawat beriring salam semoga selalu tercurah kepada junjungan kita Nabi Muhammad SAW, keluarga, sahabat, dan seluruh pengikutnya.</p>
<p>Selamat datang di website resmi <strong>SMA IT Plus Robbani Indralaya</strong>. Lembaga pendidikan yang hadir untuk mendidik generasi Qur'ani yang cerdas secara intelektual, kokoh spiritualnya, dan berjiwa mandiri untuk memimpin peradaban masa depan.</p>
<p>Kami memadukan Kurikulum Merdeka Kemendikbudristek dengan Kurikulum Terpadu Tahfidzul Qur'an 30 Juz dan penguatan sains-teknologi. Kami mengajak seluruh elemen masyarakat untuk bersama-sama melahirkan generasi khaira ummah yang membanggakan bangsa dan agama.</p>
<p><strong>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</strong></p>
HTML,
            ],
            [
                'slug' => 'tentang-kami',
                'title' => 'Profil Singkat SMA IT Plus Robbani',
                'excerpt' => 'Profil resmi lembaga pendidikan Islam terpadu SMA IT Plus Robbani Kabupaten Ogan Ilir.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Tentang SMA IT Plus Robbani</h3>
<p>SMA IT Plus Robbani didirikan dengan tekad melahirkan generasi muda Islam yang memiliki kedalaman spiritual, keluasan ilmu pengetahuan, dan keluhuran budi pekerti. Berlokasi di Indralaya, Kabupaten Ogan Ilir, kampus kami dirancang sebagai Islamic Boarding School yang asri dan kondusif untuk menuntut ilmu serta menghafal Al-Qur'an.</p>
HTML,
            ],
            [
                'slug' => 'visi-misi',
                'title' => 'Visi dan Misi SMA IT Plus Robbani',
                'excerpt' => 'Visi, misi, dan tujuan strategis penyelenggaraan pendidikan SMA IT Plus Robbani.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Visi Sekolah</h3>
<p><em>"Menjadi Sekolah Islam Terpadu Unggulan yang Mencetak Generasi Qur'ani, Cerdas Berakhlak Mulia, dan Berdaya Saing Global pada Tahun 2030."</em></p>
<h3>Misi Sekolah</h3>
<ol>
    <li>Menyelenggarakan pembelajaran terpadu antara kurikulum nasional dan nilai-nilai Islam.</li>
    <li>Membina santri menghafal Al-Qur'an dengan target mutqin 30 juz berstandar sanad.</li>
    <li>Mengembangkan minat dan bakat riset sains, teknologi digital, dan keterampilan abad 21.</li>
    <li>Membentuk karakter kepemimpinan, kemandirian, dan adab islami melalui kehidupan asrama.</li>
</ol>
HTML,
            ],
            [
                'slug' => 'sejarah',
                'title' => 'Sejarah SMA IT Plus Robbani',
                'excerpt' => 'Napak tilas perjalanan dan tonggak sejarah pendirian SMA IT Plus Robbani.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Sejarah Pendirian</h3>
<p>SMA IT Plus Robbani berdiri atas prakarsa para asatidz, tokoh pendidikan Islam, dan yayasan yang peduli terhadap pentingnya wadah pendidikan berkualitas bagi generasi muda di Sumatera Selatan. Sejak awal berdirinya, sekolah ini terus berkembang dengan penambahan sarana laboratorium sains modern, gedung asrama terpadu, dan masjid kampus yang megah.</p>
HTML,
            ],
            [
                'slug' => 'struktur-organisasi',
                'title' => 'Struktur Manajemen & Kepengurusan Sekolah',
                'excerpt' => 'Bagan kepemimpinan, penjaminan mutu, dan dewan asatidz SMA IT Plus Robbani.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Manajemen Sekolah</h3>
<p>Pengelolaan SMA IT Plus Robbani dijalankan secara profesional di bawah koordinasi Yayasan Pendidikan Robbani dengan komitmen transparansi, akuntabilitas, dan mutu berstandar nasional.</p>
HTML,
            ],
            [
                'slug' => 'donasi',
                'title' => 'Infaq & Wakaf Pendidikan SMA IT Plus Robbani',
                'excerpt' => 'Salurkan infaq dan sedekah jariyah Anda untuk beasiswa santri dhuafa dan sarana pendidikan Islam.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Salurkan Infaq & Wakaf Pendidikan</h3>
<p>Yayasan Robbani membuka kesempatan bagi kaum muslimin dan para dermawan untuk berinvestasi akhirat melalui infaq operasional asrama, sarana perpustakaan sains, dan dana beasiswa santri yatim penghafal Al-Qur'an.</p>
HTML,
            ],
            [
                'slug' => 'e-book',
                'title' => 'Pusat Unduhan Modul Belajar & E-Book Siswa',
                'excerpt' => 'Kumpulan buku panduan akademik, kurikulum tahfidz, dan modul pembelajaran digital santri.',
                'featured_image' => '/uploads/library-robbani.jpg',
                'content' => <<<'HTML'
<h3>Pusat E-Book dan Modul Pembelajaran</h3>
<p>Layanan unduh buku panduan kurikulum, silabus pembelajaran, petunjuk praktikum laboratorium, dan modul tahsin Al-Qur'an untuk civitas akademika dan masyarakat umum.</p>
HTML,
            ],
            [
                'slug' => 'hymne-mars',
                'title' => 'Hymne dan Mars SMA IT Plus Robbani',
                'excerpt' => 'Lirik dan rekaman audio resmi lagu kebanggaan civitas akademika SMA IT Plus Robbani.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Hymne & Mars Robbani</h3>
<p>Lagu kebanggaan yang mengobarkan semangat para santri untuk tekun menuntut ilmu, mencintai Al-Qur'an, dan berbakti kepada nusa dan bangsa.</p>
HTML,
            ],
            [
                'slug' => 'logo',
                'title' => 'Logo Resmi SMA IT Plus Robbani',
                'excerpt' => 'Identitas visual resmi, arti filosofis lambang, dan pedoman pemakaian logo SMA IT Plus Robbani.',
                'featured_image' => '/uploads/logo-robbani.svg',
                'content' => <<<'HTML'
<h3>Makna Filosofi Lambang Sekolah</h3>
<p>Lambang perisai hijau melambangkan keteguhan iman dan akhlak. Kubah dan buku Al-Qur'an terbuka melambangkan fondasi keislaman yang kukuh, sedangkan orbit atom melambangkan penguasaan ilmu pengetahuan dan sains modern.</p>
HTML,
            ],
            [
                'slug' => 'hubungi',
                'title' => 'Kontak & Informasi PPDB SMA IT Plus Robbani',
                'excerpt' => 'Hubungi kantor tata usaha, panitia PPDB, dan humas SMA IT Plus Robbani.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<h3>Layanan Informasi & Kontak Sekolah</h3>
<p>Silakan hubungi kami untuk informasi pendaftaran santri baru, kunjungan kampus, atau konsultasi program kurikulum.</p>
HTML,
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Kebijakan Privasi (Privacy Policy)',
                'excerpt' => 'Kebijakan privasi perlindungan data pengguna di portal resmi SMA IT Plus Robbani.',
                'featured_image' => '/uploads/campus-robbani.jpg',
                'content' => <<<'HTML'
<p>SMA IT Plus Robbani menghormati dan melindungi privasi setiap pengunjung website serta data calon santri yang didaftarkan melalui portal resmi ini.</p>
HTML,
            ],
        ];

        foreach ($officialPages as $p) {
            Post::updateOrCreate(
                ['slug' => $p['slug']],
                array_merge($p, [
                    'type' => 'page',
                    'status' => 'publish',
                    'meta_title' => $p['title'],
                    'meta_description' => $p['excerpt'],
                ])
            );
        }
    }
}
