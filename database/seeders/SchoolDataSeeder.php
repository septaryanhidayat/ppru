<?php

namespace Database\Seeders;

use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Category;
use App\Models\Dpc;
use App\Models\QuickMenu;
use App\Models\Setting;
use Illuminate\Database\Seeder;
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

        // 2. Quick Menus
        $quickMenus = [
            [
                'name' => 'Sambutan',
                'url' => '/sambutan-kepala-sekolah',
                'icon' => '/uploads/2025/09/ICON-Sambupatan.webp',
                'order' => 1,
            ],
            [
                'name' => 'Profil',
                'url' => '/tentang-kami',
                'icon' => '/uploads/2025/09/ICON-About.webp',
                'order' => 2,
            ],
            [
                'name' => 'Dewan Guru',
                'url' => '/dewan-guru',
                'icon' => '/uploads/2025/09/ICON-Dewan.webp',
                'order' => 3,
            ],
            [
                'name' => 'Fasilitas',
                'url' => '/fasilitas',
                'icon' => '/uploads/2025/09/ICON-Bidang.webp',
                'order' => 4,
            ],
            [
                'name' => 'Kabar Sekolah',
                'url' => '/artikel',
                'icon' => '/uploads/2025/09/ICON-Berita.webp',
                'order' => 5,
            ],
            [
                'name' => 'Pengumuman',
                'url' => '/pengumuman',
                'icon' => '/uploads/2025/09/ICON-Pengumuman.webp',
                'order' => 6,
            ],
            [
                'name' => 'Galeri Video',
                'url' => '/video',
                'icon' => '/uploads/2025/09/ICON-Video.webp',
                'order' => 7,
            ],
            [
                'name' => 'Agenda',
                'url' => '/agenda',
                'icon' => '/uploads/2025/09/ICON-Agenda.webp',
                'order' => 8,
            ],
        ];

        QuickMenu::truncate();
        foreach ($quickMenus as $qm) {
            QuickMenu::create(array_merge($qm, ['is_active' => true]));
        }

        // 3. Dewan Guru & GTK
        $dewanData = [
            [
                'name' => 'Drs. H. Ahmad Robbani, M.Pd.I',
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
                'photo' => '/uploads/lab-robbani.jpg',
                'profile_summary' => 'Pakar kurikulum sains dan pengembang modul pembelajaran berdiferensiasi tingkat sekolah menengah atas.',
                'order' => 3,
            ],
            [
                'name' => 'Muhammad Ridwan, S.Pd., Gr',
                'position' => 'Waka Bidang Kesiswaan & Kedisiplinan',
                'fraction' => 'Bina Karakter',
                'photo' => '/uploads/campus-robbani.jpg',
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
                'photo' => '/uploads/lab-robbani.jpg',
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

        // 6. Kategori Sekolah
        $categories = [
            'Prestasi Siswa',
            'Akademik & Riset',
            'Tahfidz & Keislaman',
            'Kesiswaan & Ekskul',
            'Kabar Kampus',
            'Agenda & Pengumuman',
        ];

        foreach ($categories as $catName) {
            Category::firstOrCreate(
                ['name' => $catName],
                ['slug' => Str::slug($catName), 'description' => 'Kategori '.$catName]
            );
        }
    }
}
