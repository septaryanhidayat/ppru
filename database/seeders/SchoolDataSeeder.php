<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Category;
use App\Models\Download;
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

class SchoolDataSeeder extends Seeder
{
    public function run(): void
    {
        $dataFile = __DIR__.'/data/ishum_data.json';
        $data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

        // 1. Settings SMA Islam Terpadu Ishlahul Ummah Prabumulih
        $settings = [
            'site_name' => 'SMA Islam Terpadu Ishlahul Ummah Prabumulih',
            'site_tagline' => 'Tanggap, Tangkas dan Tangguh Menuju Indonesia Emas',
            'site_description' => 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih (SMA IT Ishum). Sekolah Islam Terpadu pertama di Prabumulih yang tergabung dalam JSIT Indonesia dengan kurikulum terpadu.',
            'contact_email' => 'smaitishlahulummah2019@gmail.com',
            'contact_phone' => '0821-8268-0647',
            'contact_whatsapp' => '0821-8268-0647',
            'contact_address' => 'Jalan Sadewa RT 01 RW 03 Kelurahan Karang Raja, Kecamatan Prabumulih Timur, Kota Prabumulih, Sumatera Selatan 31111',
            'social_facebook' => 'https://facebook.com/smait.ishlahulummah.3',
            'social_instagram' => 'https://instagram.com/smait_ishum_prabumulih',
            'social_youtube' => 'https://www.youtube.com/channel/UCUJgvV-nqy89f3m8Hw2QrGg/videos',
            'social_tiktok' => 'https://tiktok.com/@smait_ishum',
            'banner_daftar_url' => '/hubungi',
            'banner_donasi_url' => '/donasi',
            'site_logo' => '/uploads/logo-ishum.png',
            'site_logo_square' => '/uploads/logo-ishum-square.png',
            'og_title' => 'SMA Islam Terpadu Ishlahul Ummah Prabumulih',
            'og_description' => 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih: Informasi PPDB, Berita & Prestasi, Profil Guru, Fasilitas, dan Kurikulum Terpadu.',
            'og_image' => '/uploads/kepsek-agi-gustiawan.jpg',
            'meta_keywords' => 'sma it ishlahul ummah prabumulih, sma it ishum, sekolah islam terpadu prabumulih, jsit prabumulih, ppdb sma it ishum, tahfidz prabumulih',
            'npsn' => '69990882',
            'akreditasi' => 'TERAKREDITASI BAN -SM',
            'no_sk_akreditasi' => '1036/BAN-SM/SK/2021',
            'sk_pendirian' => '2.16.72.04.001 (2020-10-23)',
            'sk_izin' => '0876/DPMPTSP.V/IX/2023 (2023-09-05)',
            'kepala_sekolah' => 'Agi Gustiawan, S. Pd',
            'donation_bank_1_name' => 'Bank Syariah Indonesia (BSI)',
            'donation_bank_1_code' => '451',
            'donation_bank_1_rekening' => '718-293-8401',
            'donation_bank_1_holder' => 'YAYASAN ISHLAHUL UMMAH PRABUMULIH',
            'donation_bank_2_name' => 'Bank Sumsel Babel Syariah',
            'donation_bank_2_code' => '120',
            'donation_bank_2_rekening' => '801-09-00123',
            'donation_bank_2_holder' => 'SMA IT ISHLAHUL UMMAH',
            'donation_confirm_phone' => '0821-8268-0647',
            'donation_confirm_text' => "Assalamu'alaikum Bendahara SMA IT Ishlahul Ummah, saya telah menyalurkan infaq pembangunan.",
            'donation_intro_text' => 'Salurkan infaq pembangunan sarana pendidikan, beasiswa tahfidz Qur\'an, dan pengembangan kampus SMA IT Ishlahul Ummah Prabumulih.',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // 2. Quick Menus (8 Menu Utama)
        $quickMenus = [
            ['name' => 'PPDB Online', 'url' => '/ppdb', 'icon' => 'fa-solid fa-graduation-cap', 'order' => 1],
            ['name' => 'Profil', 'url' => '/tentang-kami', 'icon' => 'fa-solid fa-school', 'order' => 2],
            ['name' => 'Dewan Guru', 'url' => '/dewan-guru', 'icon' => 'fa-solid fa-chalkboard-user', 'order' => 3],
            ['name' => 'Fasilitas', 'url' => '/fasilitas', 'icon' => 'fa-solid fa-layer-group', 'order' => 4],
            ['name' => 'Unggulan', 'url' => '/unggulan', 'icon' => 'fa-solid fa-award', 'order' => 5],
            ['name' => 'Prestasi', 'url' => '/prestasi', 'icon' => 'fa-solid fa-trophy', 'order' => 6],
            ['name' => 'Ekskul', 'url' => '/ekstrakurikuler', 'icon' => 'fa-solid fa-people-group', 'order' => 7],
            ['name' => 'Kabar Sekolah', 'url' => '/artikel', 'icon' => 'fa-solid fa-newspaper', 'order' => 8],
        ];

        QuickMenu::truncate();
        foreach ($quickMenus as $qm) {
            QuickMenu::create(array_merge($qm, ['is_active' => true]));
        }

        // 3. Dewan Guru & GTK
        AnggotaDewan::truncate();
        $gurus = $data['gurus'] ?? [
            [
                'name' => 'Agi Gustiawan, S. Pd',
                'slug' => 'agi-gustiawan-s-pd',
                'position' => 'Kepala Sekolah',
                'fraction' => 'Pimpinan Sekolah',
                'photo' => '/uploads/kepsek-agi-gustiawan.jpg',
                'profile_summary' => 'Kepala SMA Islam Terpadu Ishlahul Ummah Prabumulih. Berkomitmen mendidik generasi Qur\'ani yang tanggap, tangkas, dan tangguh menuju Indonesia Emas.',
                'education' => 'S1 Pendidikan',
                'order' => 1,
            ],
        ];

        foreach ($gurus as $g) {
            AnggotaDewan::create($g);
        }

        // 4. Fasilitas Sekolah (Bidangs)
        Bidang::truncate();
        $facilities = $data['facilities'] ?? [];
        foreach ($facilities as $fac) {
            Bidang::create(array_merge($fac, [
                'address' => 'Kampus SMA IT Ishlahul Ummah Prabumulih',
                'phone' => '0821-8268-0647',
                'email' => 'smaitishlahulummah2019@gmail.com',
            ]));
        }

        // 5. Program Unggulan (Dpcs)
        $programs = [
            [
                'name' => 'Program Tahfidz Mutqin 30 Juz',
                'slug' => 'program-tahfidz-mutqin-30-juz',
                'address' => 'Kurikulum Khusus Keislaman',
                'description' => 'Bimbingan intensif membaca Al-Qur\'an dengan tartil, tahsin bersanad, dan hafalan mutqin serta program Munaqosah TTQ kelas akhir.',
                'order' => 1,
            ],
            [
                'name' => 'Bina Pribadi Islam (BPI) & Karakter Islami',
                'slug' => 'bina-pribadi-islam-bpi',
                'address' => 'Pembinaan Karakter Santri',
                'description' => 'Halaqah pekanan pembinaan adab, pembiasaan ibadah yaumiyah, dzikir ma\'tsurat, serta penanaman akhlaqul karimah.',
                'order' => 2,
            ],
            [
                'name' => 'Kurikulum Terpadu JSIT & Kurikulum Merdeka',
                'slug' => 'kurikulum-terpadu-jsit-merdeka',
                'address' => 'Integrasi Nilai Islam & Sains',
                'description' => 'Memadukan standar capaian Kurikulum Merdeka Nasional dengan nilai-nilai Islam Terpadu berstandar JSIT Indonesia.',
                'order' => 3,
            ],
            [
                'name' => 'Program Belajar Bersama Maestro & Riset Sains',
                'slug' => 'belajar-bersama-maestro-riset',
                'address' => 'Pengembangan Akademik & Potensi',
                'description' => 'Eksplorasi bakat seni, budaya, sains dan teknologi langsung bersama tokoh dan pakar di bidangnya.',
                'order' => 4,
            ],
            [
                'name' => 'IU Safar & Outing Class Edukatif',
                'slug' => 'iu-safar-outing-class',
                'address' => 'Outdoor Learning & Wawasan',
                'description' => 'Pembelajaran luar kelas berbasis observasi alam, studi kampus, renang, dan rekreasi edukatif untuk memperluas cakrawala siswa.',
                'order' => 5,
            ],
            [
                'name' => 'IU Berkhidmat (Bakti Sosial Masyarakat)',
                'slug' => 'iu-berkhidmat-bakti-sosial',
                'address' => 'Kepedulian Sosial & Dakwah',
                'description' => 'Kiprah nyata santri dalam melayani dan memberikan kontribusi positif bagi masyarakat di Kota Prabumulih.',
                'order' => 6,
            ],
        ];

        Dpc::truncate();
        foreach ($programs as $prog) {
            Dpc::create($prog);
        }

        // 6. Categories & Tags
        DB::table('post_category')->delete();
        DB::table('post_tag')->delete();

        $categoriesMap = [
            'berita' => 'Berita',
            'prestasi-siswa' => 'Prestasi Siswa',
            'akademik-riset' => 'Akademik & Riset',
            'tahfidz-keislaman' => 'Tahfidz & Keislaman',
            'kesiswaan-ekskul' => 'Kesiswaan & Ekskul',
            'kabar-kampus' => 'Kabar Kampus',
            'opini' => 'Opini & Artikel',
        ];

        $categoryModels = [];
        foreach ($categoriesMap as $slug => $catName) {
            $categoryModels[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $catName, 'description' => 'Kategori '.$catName]
            );
        }

        $tagNames = [
            'ppdb' => 'PPDB',
            'tahfidz' => 'Tahfidz',
            'prestasi' => 'Prestasi',
            'juara' => 'Juara',
            'jsit' => 'JSIT',
            'outing-class' => 'Outing Class',
            'safar' => 'IU Safar',
            'berkhidmat' => 'IU Berkhidmat',
            'ekskul' => 'Ekskul',
            'prabumulih' => 'Prabumulih',
        ];

        $tagModels = [];
        foreach ($tagNames as $slug => $tName) {
            $tagModels[$slug] = Tag::updateOrCreate(
                ['slug' => $slug],
                ['name' => $tName]
            );
        }

        // 7. Video YouTube
        Video::truncate();
        $videos = $data['videos'] ?? [];
        foreach ($videos as $v) {
            Video::create($v);
        }

        // 8. Pengumuman
        Pengumuman::truncate();
        $pengumumen = $data['pengumumen'] ?? [];
        foreach ($pengumumen as $an) {
            Pengumuman::create($an);
        }

        // 9. Agenda Sekolah
        Agenda::truncate();
        $agendas = $data['agendas'] ?? [];
        foreach ($agendas as $ag) {
            Agenda::create($ag);
        }

        // 10. Testimonials
        Testimonial::truncate();
        $testimonials = $data['testimonials'] ?? [];
        foreach ($testimonials as $t) {
            Testimonial::create($t);
        }

        // 11. Downloads (Buku, Dokumen & Media)
        Download::truncate();
        $localDownloads = [
            [
                'title' => 'Buku Panduan & Kurikulum Tahfidz Al-Qur\'an SMA IT Ishlahul Ummah',
                'category_type' => 'E-Book',
                'file_path' => '/uploads/panduan-tahfidz-ishum.pdf',
                'file_type' => 'PDF',
                'file_size' => '2.4 MB',
                'download_count' => 342,
            ],
            [
                'title' => 'Brosur & Panduan Pendaftaran Peserta Didik Baru (PPDB) SMA IT Ishum',
                'category_type' => 'E-Book',
                'file_path' => '/uploads/panduan-ppdb-ishum.pdf',
                'file_type' => 'PDF',
                'file_size' => '1.8 MB',
                'download_count' => 512,
            ],
            [
                'title' => 'Mars Jaringan Sekolah Islam Terpadu (JSIT) Indonesia',
                'category_type' => 'Audio',
                'file_path' => '/uploads/mars-ishum.mp3',
                'file_type' => 'MP3',
                'file_size' => '3.5 MB',
                'download_count' => 420,
            ],
            [
                'title' => 'Hymne Sekolah Islam Terpadu Ishlahul Ummah',
                'category_type' => 'Audio',
                'file_path' => '/uploads/hymne-ishum.mp3',
                'file_type' => 'MP3',
                'file_size' => '4.1 MB',
                'download_count' => 298,
            ],
            [
                'title' => 'Logo Resmi SMA IT Ishlahul Ummah Prabumulih (High Resolution)',
                'category_type' => 'Logo',
                'file_path' => '/uploads/logo-ishum.png',
                'file_type' => 'PNG',
                'file_size' => '120 KB',
                'download_count' => 780,
            ],
            [
                'title' => 'Logo Lambang Ishlahul Ummah Square HD',
                'category_type' => 'Logo',
                'file_path' => '/uploads/logo-ishum-square.png',
                'file_type' => 'PNG',
                'file_size' => '85 KB',
                'download_count' => 315,
            ],
        ];

        $downloads = array_merge($localDownloads, $data['downloads'] ?? []);
        foreach ($downloads as $dw) {
            Download::create($dw);
        }

        // 12. Articles (Posts)
        Post::where('type', 'post')->delete();
        $articles = $data['articles'] ?? [];

        foreach ($articles as $postData) {
            $catSlug = $postData['category'] ?? 'kabar-kampus';
            unset($postData['category']);

            $post = Post::create(array_merge($postData, [
                'type' => 'post',
                'status' => 'publish',
            ]));

            if (isset($categoryModels[$catSlug])) {
                $post->categories()->sync([$categoryModels[$catSlug]->id]);
            }

            // Sync tags
            $selectedTags = collect($tagModels)->random(min(3, count($tagModels)))->pluck('id')->toArray();
            $post->tags()->sync($selectedTags);
        }

        // 13. Halaman Statis Resmi Sekolah
        Post::where('type', 'page')->delete();

        $officialPages = [
            [
                'slug' => 'sambutan-kepala-sekolah',
                'title' => 'Sambutan Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih',
                'excerpt' => 'Sambutan resmi Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih, Agi Gustiawan, S. Pd.',
                'featured_image' => '/uploads/kepsek-agi-gustiawan.jpg',
                'content' => <<<'HTML'
<p><strong>Selamat datang (ahlan wa sahlan) di website resmi SMA IT Ishlahul Ummah Prabumulih</strong></p>
<p>Segala puji hanya untuk Allah SWT atas segala nikmat, karunia dan hidayah-Nya. Sholawat serta salam semoga tercurahkan kepada suri tauladan kita umat Islam Muhammad Rasulullah SAW, serta para sahabat, keluarga dan pengikutnya yang setia hingga akhir zaman.</p>
<p>Generasi Z tak lepas dari perkembangan teknologi yang pesat. Segenap civitas akademik harus bisa beradaptasi dengan segala perubahan, salah satunya dengan kewajiban lembaga untuk membuat website sekolah. Alhamdulillah dengan adanya website ini semoga dapat memudahkan ayah bunda, saudara/i mengeksplor SMA IT Ishlahul Ummah lebih dekat dan lebih akurat.</p>
<p>Terimakasih kepada semua pihak yang telah mendukung terutama <strong>Ust. H. Mat Amin, S.Ag</strong> selaku Pembina Yayasan Ishlahul Ummah dan <strong>Ummi Hj. TL. Fasmawati, S.Ag</strong> selaku Ketua Yayasan Ishlahul Ummah Prabumulih serta para dewan guru, karyawan, sahabat Ishum dimanapun berada. Semoga layanan website kami dapat bermanfaat dan membantu pengunjung sekalian mendapatkan informasi yang diinginkan. Kritik dan saran kami harapkan untuk kemajuan SMA IT Ishlahul Ummah Prabumulih.</p>
<p><em>Salam mendidik sepenuh cinta.</em></p>
<p><strong>Kepala SMA IT Ishlahul Ummah</strong><br>
<strong>Agi Gustiawan, S. Pd</strong></p>
HTML,
            ],
            [
                'slug' => 'visi-dan-misi',
                'title' => 'Visi dan Misi SMA IT Ishlahul Ummah Prabumulih',
                'excerpt' => 'Visi, Misi, dan Tujuan penyelenggaraan pendidikan SMA IT Ishlahul Ummah Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>VISI SEKOLAH</h3>
<blockquote class="text-xl font-bold text-school-green my-4 p-4 border-l-4 border-school-green bg-green-50 rounded-r-lg">
“TERWUJUDNYA PESERTA DIDIK YANG TANGGAP, TANGKAS DAN TANGGUH DALAM RANGKA PERBAIKAN UMAT MENUJU INDONESIA EMAS”
</blockquote>

<h3>MISI SEKOLAH</h3>
<ol class="list-decimal pl-6 space-y-2 text-gray-700">
    <li>Menanamkan peserta didik akhlak mulia dan cara pandang kehidupan yang islami.</li>
    <li>Melatih peserta didik untuk terlibat dalam memperbaiki permasalahan di masyarakat.</li>
    <li>Menanamkan komitmen dan tanggung jawab dalam menjalankan perannya di keluarga, sekolah, dan masyarakat.</li>
</ol>

<h3 class="mt-8">TUJUAN PENDIDIKAN</h3>
<ul class="list-disc pl-6 space-y-2 text-gray-700">
    <li>Mempunyai aqidah yang lurus dan melaksanakan ibadah/kebaikan dengan kesadaran serta tanggung jawab.</li>
    <li>Mampu membaca Al-Qur'an dengan tartil serta menghafal dengan mutqin.</li>
    <li>Terbiasa bersikap santun, berakhlak mulia, berpikir kritis, mandiri dan kreatif.</li>
    <li>Berprestasi dalam kompetisi tingkat kota, provinsi, dan nasional.</li>
    <li>Mampu beradaptasi dengan perkembangan IPTEK dan IMTAQ.</li>
    <li>Menjadi penggerak dalam kebaikan di masyarakat.</li>
</ul>
HTML,
            ],
            [
                'slug' => 'tentang-kami',
                'title' => 'Profil SMA Islam Terpadu Ishlahul Ummah Prabumulih',
                'excerpt' => 'Profil resmi lembaga pendidikan Islam terpadu SMA IT Ishlahul Ummah Kota Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Profil Singkat Sekolah</h3>
<p><strong>SMA Islam Terpadu Ishlahul Ummah Prabumulih</strong> adalah lembaga pendidikan menengah atas bernafaskan Islam Terpadu pertama dan satu-satunya yang tergabung bersama <strong>JSIT (Jaringan Sekolah Islam Terpadu)</strong> di Kota Prabumulih, Sumatera Selatan.</p>
<p>Didirikan dengan tekad mempersiapkan generasi emas yang tanggap, tangkas, dan tangguh, sekolah memadukan kurikulum nasional dengan kurikulum khas keislaman seperti Tahsin-Tahfidz Al-Qur'an, Bina Pribadi Islam (BPI), dan penguatan adab Islami.</p>

<h4 class="mt-6 font-bold text-gray-900">Identitas Sekolah</h4>
<table class="w-full text-left border-collapse my-4 text-sm">
    <tr class="border-b"><td class="py-2 font-semibold w-1/3">Nama Sekolah</td><td class="py-2">SMA Islam Terpadu Ishlahul Ummah Prabumulih</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">NPSN</td><td class="py-2">69990882</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">Akreditasi</td><td class="py-2">TERAKREDITASI BAN - SM (1036/BAN-SM/SK/2021)</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">SK Pendirian</td><td class="py-2">2.16.72.04.001 (2020-10-23)</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">SK Izin Operasional</td><td class="py-2">0876/DPMPTSP.V/IX/2023 (2023-09-05)</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">Alamat Kampus</td><td class="py-2">Jalan Sadewa RT 01 RW 03 Kel. Karang Raja, Kec. Prabumulih Timur, Kota Prabumulih</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">Telepon / WhatsApp</td><td class="py-2">0821-8268-0647</td></tr>
    <tr class="border-b"><td class="py-2 font-semibold">Email</td><td class="py-2">smaitishlahulummah2019@gmail.com</td></tr>
</table>
HTML,
            ],
            [
                'slug' => 'sejarah',
                'title' => 'Sejarah SMA IT Ishlahul Ummah Prabumulih',
                'excerpt' => 'Napak tilas perjalanan dan sejarah berdirinya SMA IT Ishlahul Ummah di Kota Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Sejarah Pendirian Sekolah</h3>
<p><strong>SMA IT ISHLAHUL UMMAH PRABUMULIH</strong> berdiri pada tanggal <strong>19 Januari 2019</strong>, yang diprakarsai oleh <strong>H. Mat Amin, S.Ag</strong> selaku Pembina Yayasan dan <strong>Hj. TL. Fasmawati, S.Ag</strong> selaku Ketua Yayasan Ishlahul Ummah Prabumulih.</p>
<p>Kehadiran SMA IT Ishum menjadikannya sebagai SMA pertama dan satu-satunya yang tergabung bersama <strong>JSIT (Jaringan Sekolah Islam Terpadu)</strong> di Kota Prabumulih, melengkapi jenjang pendidikan terpadu dari tingkat dasar (SD IT) dan menengah pertama (SMP IT).</p>
<p>Pada tahun pertama berdirinya, SMA IT Ishlahul Ummah Prabumulih dipimpin oleh <strong>Ustadzah Mulyani Rahayu, S.T., M.Pd</strong> yang saat itu juga memegang amanah sebagai Kepala SMP IT Ishlahul Ummah hingga tahun kedua. Selanjutnya kepemimpinan diamanahkan kepada <strong>Ustadzah Anita Carlyna, S.IP., M.Pd</strong>, dan saat ini dipimpin oleh <strong>Ustadz Agi Gustiawan, S. Pd</strong>.</p>
<p>Dengan semangat <em>“Mendidik Sepenuh Cinta”</em>, SMA IT Ishum terus berkomitmen mencetak generasi Qur'ani yang berilmu, berakhlak mulia, dan siap memimpin perbaikan umat.</p>
HTML,
            ],
            [
                'slug' => 'struktur-organisasi',
                'title' => 'Struktur Organisasi SMA IT Ishlahul Ummah Prabumulih',
                'excerpt' => 'Bagan kepemimpinan, yayasan, dan dewan guru SMA IT Ishlahul Ummah Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Struktur Manajemen & Pengelola Yayasan</h3>
<ul class="space-y-3 text-gray-800">
    <li><strong>Pembina Yayasan Ishlahul Ummah:</strong> Ust. H. Mat Amin, S.Ag</li>
    <li><strong>Ketua Yayasan Ishlahul Ummah:</strong> Ummi Hj. TL. Fasmawati, S.Ag</li>
    <li><strong>Kepala Sekolah:</strong> Agi Gustiawan, S. Pd</li>
    <li><strong>Wakil Kepala Sekolah Bidang Kurikulum:</strong> Anita Carlyna, S.IP., M.Pd</li>
    <li><strong>Dewan Guru & Tenaga Kependidikan:</strong> Didukung oleh tenaga pendidik profesional lulusan universitas terkemuka.</li>
</ul>
HTML,
            ],
            [
                'slug' => 'donasi',
                'title' => 'Infaq & Wakaf Pembangunan SMA IT Ishlahul Ummah',
                'excerpt' => 'Salurkan infaq dan wakaf terbaik Anda untuk sarana pendidikan Islam dan beasiswa tahfidz di Kota Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Investasi Akhirat Melalui Pendidikan Islam</h3>
<p>Yayasan Ishlahul Ummah Prabumulih membuka kesempatan seluas-luasnya bagi kaum muslimin dan para dermawan untuk menyalurkan infaq dan sedekah jariyah. Dana yang terhimpun disalurkan untuk pembangunan sarana laboratorium, mushola, ruang kelas baru, dan beasiswa pendidikan santri berprestasi.</p>
HTML,
            ],
            [
                'slug' => 'e-book',
                'title' => 'E-Library & Modul Pembelajaran SMA IT Ishum',
                'excerpt' => 'Kumpulan buku pelajaran, panduan kurikulum, dan modul e-library santri SMA IT Ishum.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Pusat E-Library & Buku Digital</h3>
<p>Daftar koleksi buku pelajaran Kurikulum Merdeka, modul guru, dan bacaan islami yang dapat diakses dan diunduh oleh civitas akademika SMA IT Ishlahul Ummah Prabumulih.</p>
HTML,
            ],
            [
                'slug' => 'hymne-mars',
                'title' => 'Mars & Hymne Jaringan Sekolah Islam Terpadu',
                'excerpt' => 'Lagu mars dan hymne Sekolah Islam Terpadu kebanggaan SMA IT Ishlahul Ummah.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Mars JSIT Indonesia</h3>
<p class="italic text-gray-600">Membina tunas bangsa, beriman dan bertaqwa, cerdas berakhlak mulia...</p>
HTML,
            ],
            [
                'slug' => 'logo',
                'title' => 'Logo Resmi SMA IT Ishlahul Ummah Prabumulih',
                'excerpt' => 'Makna filosofis lambang dan logo resmi SMA Islam Terpadu Ishlahul Ummah Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Filosofi Logo SMA IT Ishlahul Ummah</h3>
<p>Logo SMA Islam Terpadu Ishlahul Ummah Prabumulih memadukan lambang perisai keimanan, kubah masjid, Al-Qur'an terbuka, dan obor semangat dengan skema warna dominan hijau Islami dan merah yang melambangkan keberanian, ketangguhan, serta cita-cita luhur menuju perbaikan umat.</p>
HTML,
            ],
            [
                'slug' => 'hubungi',
                'title' => 'Kontak & Sekretariat PPDB SMA IT Ishum',
                'excerpt' => 'Alamat dan kontak resmi sekretariat SMA Islam Terpadu Ishlahul Ummah Prabumulih.',
                'featured_image' => '/uploads/logo-ishum.png',
                'content' => <<<'HTML'
<h3>Sekretariat Sekolah & Panitia PPDB</h3>
<p>Silakan kunjungi kampus kami atau hubungi panitia PPDB untuk informasi pendaftaran peserta didik baru, jadwal seleksi, dan beasiswa.</p>
<p><strong>Alamat:</strong> Jalan Sadewa RT 01 RW 03 Kel. Karang Raja, Kec. Prabumulih Timur, Kota Prabumulih, Sumatera Selatan 31111.<br>
<strong>WhatsApp / Telp:</strong> 0821-8268-0647<br>
<strong>Email:</strong> smaitishlahulummah2019@gmail.com</p>
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
