<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SyncCleanPagesAndPostsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. DAFTAR SLUG HALAMAN SAMPAH / RESIDU WORDPRESS YANG TIDAK RELEVAN
        $junkPageSlugs = [
            'sample-page',
            'beranda',         // Sudah di-handle HomeController secara dinamis
            'artikel',         // Sudah di-handle ArticleController
            'bidang',          // Sudah di-handle BidangController & tabel bidangs
            'anggota-dewan',   // Sudah di-handle DewanController & tabel dewans
            'agenda',          // Sudah di-handle InformationController & tabel agendas
            'pengumuman',      // Sudah di-handle InformationController & tabel agendas
            'fasilitas',       // Residu Elementor tak terpakai
            'testimonial',     // Sudah di-handle InformationController & tabel testimonials
            'video',           // Sudah di-handle InformationController & tabel media
            'login',           // Residu halaman login lama WP
            'download',        // Sudah di-handle DownloadController
            'galeri',          // Sudah di-handle InformationController & tabel media
            'pilihan-download',// Residu leaflet universitas sriwijaya
            'leaflet',         // Residu leaflet universitas sriwijaya
        ];

        Post::where('type', 'page')->whereIn('slug', $junkPageSlugs)->delete();

        // 2. KONTEN BERSIH, RAPI, DAN LENGKAP UNTUK SEMUA HALAMAN STATIS RESMI

        // --- A. Sambutan Ketua DPD ---
        Post::updateOrCreate(
            ['slug' => 'sambutan-ketua-dpd'],
            [
                'type' => 'page',
                'title' => 'Sambutan Ketua DPD PKS Ogan Ilir',
                'excerpt' => 'Sambutan resmi Ketua DPD Partai Keadilan Sejahtera (PKS) Kabupaten Ogan Ilir, H. Husnul Anam, S.HI.',
                'status' => 'publish',
                'featured_image' => '/uploads/2025/09/DPD-Profile-2.webp',
                'meta_title' => 'Sambutan Ketua DPD - DPD PKS Ogan Ilir',
                'meta_description' => 'Sambutan resmi Ketua DPD Partai Keadilan Sejahtera (PKS) Kabupaten Ogan Ilir, H. Husnul Anam, S.HI.',
                'content' => <<<HTML
<p><strong>Assalamu'alaikum Warahmatullahi Wabarakatuh,</strong></p>

<p>Alhamdulillah, puji dan syukur senantiasa kita panjatkan ke hadirat Allah Subhanahu Wa Ta'ala atas segala limpahan rahmat, taufik, serta karunia-Nya, sehingga kami dapat menghadirkan platform website resmi ini sebagai sarana keterbukaan informasi dan jembatan komunikasi antara Partai Keadilan Sejahtera dengan seluruh lapisan masyarakat Kabupaten Ogan Ilir tercinta.</p>

<p>Sebagai Ketua DPD PKS Kabupaten Ogan Ilir, saya, <strong>H. Husnul Anam, S.HI</strong>, menyampaikan salam hormat, apresiasi, dan terima kasih yang setinggi-tingginya kepada seluruh kader, simpatisan, tokoh masyarakat, alim ulama, serta warga Kabupaten Ogan Ilir yang terus membersamai langkah pengabdian kami.</p>

<p>Partai Keadilan Sejahtera hadir untuk mewujudkan cita-cita bangsa yang merdeka, bersatu, berdaulat, adil, dan makmur, berpijak pada nilai-nilai luhur Islam yang <em>rahmatan lil 'alamin</em>. Kami senantiasa berkomitmen untuk memperjuangkan aspirasi rakyat, mengawal keadilan sosial, mendorong kemajuan pembangunan daerah di Bumi Caram Seguguk, serta merawat keharmonisan di tengah keberagaman.</p>

<p>Melalui website resmi ini, kami berikhtiar menyajikan informasi yang transparan, akurat, dan aktual mengenai agenda kerja, kegiatan kepartaian, advokasi fraksi di legislatif, serta berbagai program pelayanan masyarakat. Kami membuka ruang seluas-luasnya bagi masyarakat untuk menyampaikan masukan, kritik konstruktif, serta aspirasi demi terwujudnya tata kelola daerah yang lebih baik.</p>

<p>Semoga media ini membawa manfaat dan keberkahan bagi kita semua. Mari bersama-sama kita kokohkan ukhuwah dan bergandengan tangan untuk kemajuan Kabupaten Ogan Ilir dan Indonesia.</p>

<p><strong>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</strong></p>

<p><br><strong>H. HUSNUL ANAM, S.HI</strong><br>
<em>Ketua DPD Partai Keadilan Sejahtera Kabupaten Ogan Ilir</em></p>
HTML
            ]
        );

        // --- B. Tentang Kami ---
        Post::updateOrCreate(
            ['slug' => 'tentang-kami'],
            [
                'type' => 'page',
                'title' => 'Tentang DPD PKS Ogan Ilir',
                'excerpt' => 'Mengenal profil, sejarah, visi misi, bidang kerja, serta kiprah DPD Partai Keadilan Sejahtera (PKS) Kabupaten Ogan Ilir.',
                'status' => 'publish',
                'featured_image' => '/uploads/2025/09/Struktur-Kepengurusan-scaled.webp',
                'meta_title' => 'Tentang Kami - DPD PKS Ogan Ilir',
                'meta_description' => 'Mengenal profil, sejarah, visi misi, bidang kerja, serta kiprah DPD Partai Keadilan Sejahtera (PKS) Kabupaten Ogan Ilir.',
                'content' => <<<HTML
<h3>Profil Singkat DPD PKS Ogan Ilir</h3>
<p>Dewan Pengurus Daerah Partai Keadilan Sejahtera (DPD PKS) Kabupaten Ogan Ilir merupakan struktur kepengurusan tingkat kabupaten yang memimpin dan mengoordinasikan gerak dakwah serta aktivitas politik PKS di seluruh wilayah Kabupaten Ogan Ilir, Sumatera Selatan.</p>

<p>Sejak pemekaran Kabupaten Ogan Ilir pada tahun 2003, PKS senantiasa hadir membersamai denyut nadi kehidupan masyarakat. Berlandaskan semangat <strong>Berkhidmat untuk Rakyat</strong>, PKS Ogan Ilir terus bertransformasi menjadi partai yang modern, mandiri, terbuka, dan inklusif bagi seluruh lapisan masyarakat.</p>

<h3>Nilai Dasar & Prinsip Perjuangan</h3>
<ul>
    <li><strong>Integritas & Moralitas:</strong> Menjunjung tinggi kejujuran, amanah, dan etika Islam dalam setiap pengambilan keputusan politik.</li>
    <li><strong>Pelayanan Tanpa Syarat:</strong> Mengedepankan kerja-kerja sosial dan kepedulian nyata kepada kaum dhuafa, yatim, lansia, dan korban bencana.</li>
    <li><strong>Kaderisasi Berkelanjutan:</strong> Membina generasi muda berakhlak mulia yang siap menjadi pemimpin bangsa yang beriman dan bertakwa.</li>
    <li><strong>Kolaborasi Kebangsaan:</strong> Bersinergi dengan pemerintah daerah, organisasi kemasyarakatan, serta seluruh elemen masyarakat demi kemajuan Ogan Ilir.</li>
</ul>

<h3>Tiga Pilar Pengabdian</h3>
<p>Dalam menjalankan roda organisasi, DPD PKS Ogan Ilir bertumpu pada tiga pilar utama:</p>
<ol>
    <li><strong>Pilar Struktur:</strong> Penguatan jaringan kepengurusan dari tingkat DPD, 16 DPC Kecamatan, hingga tingkat Ranting dan Unit Pembinaan Anggota.</li>
    <li><strong>Pilar Fraksi Legislatif:</strong> Pengawalan aspirasi rakyat melalui anggota DPRD Fraksi PKS Ogan Ilir dalam fungsi legislasi, anggaran, dan pengawasan.</li>
    <li><strong>Pilar Kader & Relawan:</strong> Ribuan kader militan yang aktif berkontribusi dalam program kemanusiaan, pemberdayaan ekonomi, pendidikan, dan pembinaan keluarga.</li>
</ol>
HTML
            ]
        );

        // --- C. Visi dan Misi ---
        Post::updateOrCreate(
            ['slug' => 'visi-dan-misi'],
            [
                'type' => 'page',
                'title' => 'Visi dan Misi PKS',
                'excerpt' => 'Visi dan Misi resmi Dewan Pengurus Daerah Partai Keadilan Sejahtera Kabupaten Ogan Ilir.',
                'status' => 'publish',
                'featured_image' => '/uploads/2025/09/Struktur-Kepengurusan-scaled.webp',
                'meta_title' => 'Visi dan Misi - DPD PKS Ogan Ilir',
                'meta_description' => 'Visi dan Misi resmi Dewan Pengurus Daerah Partai Keadilan Sejahtera Kabupaten Ogan Ilir.',
                'content' => <<<HTML
<h3>Visi Partai Keadilan Sejahtera</h3>
<blockquote>
    <p><em>"Menjadi Partai Islam rahmatan lil ‘alamin yang kokoh dan terdepan dalam melayani rakyat dan Negara Kesatuan Republik Indonesia."</em></p>
</blockquote>

<h3>Misi Utama Partai Keadilan Sejahtera</h3>
<ol>
    <li>
        <strong>Kaderisasi & Kepemimpinan Berakhlak Mulia:</strong><br>
        Meningkatkan pertumbuhan jumlah Anggota Partai dan mengokohkan integritas, solidaritas, akseptabilitas, profesionalitas untuk menghadirkan kepemimpinan bangsa yang beriman dan bertakwa serta berakhlak mulia.
    </li>
    <li>
        <strong>Soliditas Partai Modern & Terbuka:</strong><br>
        Mengokohkan soliditas Partai berskala nasional, mandiri, dan terbuka agar mampu menjalankan fungsi edukasi, advokasi, kaderisasi kepemimpinan, serta menerapkan sistem manajemen partai modern untuk meningkatkan sinergi, kinerja, dan kredibilitas.
    </li>
    <li>
        <strong>Kepeloporan Pelayanan & Ketahanan Keluarga:</strong><br>
        Meningkatkan kepeloporan Partai dalam pelayanan, pemberdayaan, dan pembelajaran terhadap ketahanan keluarga, pemuda, kepentingan masyarakat, dan lingkungan hidup, serta memperkuat kemitraan strategis di berbagai sektor pengabdian untuk meningkatkan kualitas kehidupan yang produktif, inovatif, dan patriotik.
    </li>
    <li>
        <strong>Pemenangan Pemilu & Kebijakan Publik Bersih:</strong><br>
        Memenangkan Pemilu dan meningkatkan kontribusi Partai dalam menggagas dan memperjuangkan kebijakan publik yang berpihak kepada kemakmuran rakyat, bangsa, dan negara yang bersih dari korupsi, kolusi, dan nepotisme.
    </li>
</ol>

<h3>Arah Program DPD PKS Ogan Ilir Menuju 2030</h3>
<ul>
    <li>Penguatan ketahanan keluarga melalui Rumah Keluarga Indonesia (RKI).</li>
    <li>Pemberdayaan wirausaha lokal dan UMKM melalui program Gerakan Ekonomi Mandiri.</li>
    <li>Pembinaan generasi muda melalui komunitas kepemudaan PKS Muda dan Garuda Keadilan.</li>
    <li>Pengawalan pembangunan infrastruktur pedesaan dan advokasi pelayanan kesehatan gratis bagi warga kurang mampu.</li>
</ul>
HTML
            ]
        );

        // --- D. Sejarah ---
        Post::updateOrCreate(
            ['slug' => 'sejarah'],
            [
                'type' => 'page',
                'title' => 'Sejarah Perjalanan PKS Ogan Ilir',
                'excerpt' => 'Jejak langkah pengabdian, kaderisasi, dan perjuangan politik dakwah Partai Keadilan Sejahtera di Kabupaten Ogan Ilir sejak pemekaran tahun 2003 hingga Musda VI 2025.',
                'status' => 'publish',
                'featured_image' => '/uploads/2025/09/58.webp',
                'meta_title' => 'Sejarah PKS Ogan Ilir - DPD PKS Ogan Ilir',
                'meta_description' => 'Sejarah perjalanan dan jejak pengabdian Partai Keadilan Sejahtera di Kabupaten Ogan Ilir sejak pemekaran tahun 2003 hingga Musda VI 2025.',
                'content' => <<<HTML
<h3>Jejak Perjalanan Dakwah & Kiprah Politik di Bumi Caram Seguguk</h3>

<p>Partai Keadilan Sejahtera (PKS) hadir di Kabupaten Ogan Ilir sejak awal berdirinya daerah ini sebagai kabupaten pemekaran dari Kabupaten Ogan Komering Ilir pada akhir tahun 2003. Kehadiran PKS di Ogan Ilir dirintis oleh para aktivis dakwah dan tokoh pemuda yang memiliki komitmen kuat untuk menghadirkan warna politik yang beretika, bersih, dan berorientasi pada kemaslahatan umat.</p>

<p>Pada masa awal perjuangan, struktur kepengurusan masih sangat sederhana dengan sarana dan fasilitas yang terbatas. Namun, militansi kader, kekokohan ukhuwah, serta program pelayanan sosial yang langsung menyentuh masyarakat pedesaan membuat PKS dengan cepat diterima secara hangat oleh warga Ogan Ilir.</p>

<p>Seiring berjalannya waktu, kepercayaan masyarakat Ogan Ilir kepada PKS tercermin nyata dalam perolehan kursi legislatif di DPRD Kabupaten Ogan Ilir. Dari pemilu ke pemilu, Fraksi PKS konsisten menjadi penyambung lidah rakyat, memperjuangkan anggaran pendidikan, kesehatan, serta infrastruktur pertanian yang menjadi urat nadi perekonomian daerah.</p>

<p>Momentum penting dalam dinamika internal partai ditandai dengan penyelenggaraan Musyawarah Daerah (Musda) secara berkala sebagai mekanisme konsolidasi, evaluasi, dan regenerasi kepemimpinan yang demokratis dan beradab. Setiap periode melahirkan kepengurusan baru yang membawa energi pembaharuan.</p>

<p>Terselenggaranya <strong>Musyawarah Daerah (Musda) VI pada tahun 2025</strong> menjadi tonggak sejarah penting baru. Musda VI menetapkan kepemimpinan <strong>H. Husnul Anam, S.HI</strong> sebagai Ketua DPD PKS Ogan Ilir, dengan visi strategis penguatan struktur hingga tingkat akar rumput dan penyiapan kader-kader unggul menyongsong Pemilu 2030.</p>

<p>Kini, DPD PKS Ogan Ilir telah bertransformasi menjadi kekuatan politik yang matang, solid, dan terpercaya. PKS Ogan Ilir terus memegang teguh komitmen untuk senantiasa hadir melayani, membela, dan memperjuangkan hak-hak rakyat menuju Kabupaten Ogan Ilir yang religius, sejahtera, dan bermartabat.</p>
HTML
            ]
        );

        // --- E. Struktur Kepengurusan ---
        Post::updateOrCreate(
            ['slug' => 'struktur-kepengurusan'],
            [
                'type' => 'page',
                'title' => 'Struktur Kepengurusan DPTD PKS Ogan Ilir',
                'excerpt' => 'Susunan Dewan Pimpinan Tingkat Daerah (DPTD), Bidang Kerja DPD, dan DPC se-Kabupaten Ogan Ilir periode 2025-2030.',
                'status' => 'publish',
                'featured_image' => '/uploads/2025/09/Struktur-Kepengurusan-scaled.webp',
                'meta_title' => 'Struktur Kepengurusan - DPD PKS Ogan Ilir',
                'meta_description' => 'Struktur Kepengurusan DPTD dan DPD Partai Keadilan Sejahtera Kabupaten Ogan Ilir periode 2025-2030.',
                'content' => <<<HTML
<h3>Dewan Pimpinan Tingkat Daerah (DPTD) PKS Ogan Ilir Periode 2025-2030</h3>
<p>DPTD merupakan lembaga kepemimpinan kolektif tertinggi di tingkat daerah yang terdiri atas unsur Majelis Pertimbangan Daerah (MPD), Dewan Pengurus Daerah (DPD), dan Dewan Etik Daerah (DED).</p>

<h4>1. Majelis Pertimbangan Daerah (MPD)</h4>
<ul>
    <li><strong>Ketua MPD:</strong> Salamuddin, S.Si</li>
    <li><strong>Sekretaris MPD:</strong> Hardi Aji Badarwi, S.Si</li>
</ul>

<h4>2. Dewan Pengurus Daerah (DPD)</h4>
<ul>
    <li><strong>Ketua DPD:</strong> H. HUSNUL ANAM, S.HI</li>
    <li><strong>Sekretaris DPD:</strong> Eko Priyono, S.PI</li>
    <li><strong>Bendahara DPD:</strong> Muhammad Asyhari, S.Sos</li>
    <li><strong>Ketua Bidang Kaderisasi:</strong> Ahmad Syafii, S.Pd.I</li>
</ul>

<h4>3. Dewan Etik Daerah (DED)</h4>
<ul>
    <li><strong>Ketua DED:</strong> H. Sunoto Anam</li>
    <li><strong>Sekretaris DED:</strong> H. Ahmadi Abdullah Azzim, Lc., MA.ED</li>
</ul>

<h4>Bidang-Bidang Kerja Strategis DPD PKS Ogan Ilir</h4>
<p>Untuk menunjang efektivitas pelayanan publik dan kerja kepartaian, DPD PKS Ogan Ilir didukung oleh bidang-bidang strategis:</p>
<ol>
    <li>Bidang Kaderisasi (BK)</li>
    <li>Bidang Perempuan dan Ketahanan Keluarga (BPKK)</li>
    <li>Bidang Kepemudaan (PKS Muda & Olahraga)</li>
    <li>Bidang Hubungan Masyarakat & Media (Humas)</li>
    <li>Bidang Pemenangan Pemilu dan Pilkada (BP3)</li>
    <li>Bidang Pelayanan dan Pemberdayaan Umat (BPU)</li>
    <li>Bidang Kesejahteraan Sosial (Kesos)</li>
    <li>Bidang Pemberdayaan Jaringan Ekonomi (BPJE)</li>
</ol>
HTML
            ]
        );

        // --- F. Privacy Policy ---
        Post::updateOrCreate(
            ['slug' => 'privacy-policy'],
            [
                'type' => 'page',
                'title' => 'Kebijakan Privasi (Privacy Policy)',
                'excerpt' => 'Komitmen transparansi dan perlindungan privasi data setiap pengunjung situs resmi DPD PKS Ogan Ilir.',
                'status' => 'publish',
                'featured_image' => null,
                'meta_title' => 'Kebijakan Privasi - DPD PKS Ogan Ilir',
                'meta_description' => 'Kebijakan Privasi resmi Website DPD PKS Ogan Ilir yang menjelaskan pengelolaan dan perlindungan data pengunjung.',
                'content' => <<<HTML
<h3>1. Pendahuluan</h3>
<p>DPD Partai Keadilan Sejahtera (PKS) Kabupaten Ogan Ilir berkomitmen menjaga dan menghormati privasi setiap pengunjung situs resmi kami di <strong>pksoganilir.com</strong> dan <strong>oganilir.pks.id</strong>. Kebijakan Privasi ini menjelaskan prinsip pengumpulan, penggunaan, serta perlindungan informasi pribadi yang Anda berikan saat menggunakan situs ini.</p>

<h3>2. Informasi yang Kami Kumpulkan</h3>
<p>Kami dapat mencatat data pengunjung dalam dua bentuk:</p>
<ul>
    <li><strong>Informasi yang Diberikan Sukarela:</strong> Meliputi nama lengkap, alamat email, nomor telepon/WhatsApp, dan pesan aspirasi yang dikirimkan melalui formulir kontak atau formulir masukan masyarakat.</li>
    <li><strong>Informasi Teknis Otomatis:</strong> Seperti alamat IP, jenis peramban (browser), sistem operasi, waktu akses, dan riwayat halaman yang dikunjungi untuk keperluan analitik trafik dan statistik pengunjung.</li>
</ul>

<h3>3. Penggunaan Informasi</h3>
<p>Data yang dikumpulkan semata-mata dimanfaatkan untuk keperluan:</p>
<ul>
    <li>Menanggapi aspirasi, pertanyaan, atau masukan yang diajukan oleh masyarakat.</li>
    <li>Mengirimkan informasi berkala atau pembaruan berita jika Anda mendaftar melalui fitur buletin (newsletter).</li>
    <li>Memantau performa, stabilitas server, dan meningkatkan keamanan sistem dari ancaman siber.</li>
</ul>

<h3>4. Keamanan & Kerahasiaan Data</h3>
<p>Kami menerapkan langkah-langkah keamanan teknis dan organisasional yang memadai guna melindungi informasi pribadi pengunjung dari akses tidak sah, pengubahan, pengungkapan, atau penghancuran tanpa izin. Kami tidak akan pernah menjual, menyewakan, atau memberikan data pribadi Anda kepada pihak ketiga untuk kepentingan komersial.</p>

<h3>5. Penggunaan Cookies</h3>
<p>Situs kami dapat menggunakan teknologi <em>cookies</em> untuk meningkatkan pengalaman penjelajahan dan menyimpan preferensi sesi pengunjung. Anda dapat menonaktifkan cookies kapan saja melalui pengaturan peramban internet Anda.</p>

<h3>6. Tautan ke Situs Eksternal</h3>
<p>Situs ini dapat memuat tautan menuju situs eksternal seperti portal resmi DPP PKS, akun media sosial resmi, atau situs berita. Kami tidak bertanggung jawab atas isi dan kebijakan privasi situs pihak ketiga tersebut.</p>

<h3>7. Hak Pengunjung</h3>
<p>Pengunjung berhak meminta klarifikasi, pembaharuan, atau penghapusan atas data pribadi yang pernah dikirimkan kepada kami melalui formulir kontak resmi.</p>

<h3>8. Kontak Kami</h3>
<p>Apabila Anda memiliki pertanyaan mengenai Kebijakan Privasi ini, silakan menghubungi kami melalui email resmi di <strong>pksoganilir@gmail.com</strong> atau mengunjungi Kantor DPD PKS Ogan Ilir.</p>
HTML
            ]
        );

        // --- G. Hymne & Mars PKS ---
        Post::updateOrCreate(
            ['slug' => 'hymne-mars-pks'],
            [
                'type' => 'page',
                'title' => 'Hymne & Mars PKS',
                'excerpt' => 'Lagu resmi Mars dan Hymne Partai Keadilan Sejahtera ciptaan Mohamad Sohibul Iman dan Dwiki Darmawan lengkap dengan lirik.',
                'status' => 'publish',
                'featured_image' => null,
                'meta_title' => 'Mars dan Hymne PKS - DPD PKS Ogan Ilir',
                'meta_description' => 'Lagu resmi Mars dan Hymne Partai Keadilan Sejahtera ciptaan Mohamad Sohibul Iman dan Dwiki Darmawan lengkap dengan audio dan lirik.',
                'content' => <<<HTML
<h3>MARS PKS</h3>
<p><em>Ciptaan: Mohamad Sohibul Iman & Dwiki Darmawan</em></p>

<blockquote>
<p>
Dalam Naungan Ridho Ilahi<br>
Marilah Kita terus Berjuang<br>
Dalam Bhineka Tunggal Ika<br>
Merajut Harmoni Bangsa<br><br>

Dalam Semangat untuk Berkiprah<br>
Menuju Cita-cita yang Mulia<br>
Bagai Cahaya dalam Kegelapan<br>
Menyambut Datangnya Harapan<br><br>

<strong>Reff:</strong><br>
Keadilan dan Kesejahteraan<br>
Itulah Perjuangan Kita<br>
Tegakkan Kebenaran, Wujudkan Keadilan<br>
Bagi Seluruh Rakyat Indonesia<br><br>

Bersama Kita Melangkah Pasti<br>
Mengabdi untuk Negeri Tercinta<br>
Partai Keadilan Sejahtera<br>
Bekerja Nyata untuk Bangsa!
</p>
</blockquote>

<hr>

<h3>HYMNE PKS</h3>
<p><em>Ciptaan: Mohamad Sohibul Iman & Dwiki Darmawan</em></p>

<blockquote>
<p>
Dengan Nama Allah Yang Maha Kuasa<br>
Kita Ikrarkan Janji Setia<br>
Menjaga Keutuhan Nusantara<br>
Membangun Peradaban Mulia<br><br>

PKS Rumah Perjuangan Kita<br>
Tumpuan Harapan Umat dan Bangsa<br>
Tulus Ikhlas Berkorban Jiwa Raga<br>
Demi Indonesia Sejahtera!
</p>
</blockquote>
HTML
            ]
        );

        // --- H. Logo Resmi PKS ---
        Post::updateOrCreate(
            ['slug' => 'logo'],
            [
                'type' => 'page',
                'title' => 'Logo Resmi Partai Keadilan Sejahtera',
                'excerpt' => 'Filosofi, makna lambang, dan panduan penggunaan logo resmi Partai Keadilan Sejahtera.',
                'status' => 'publish',
                'featured_image' => '/uploads/2025/09/Logo-PKS-Footer-Asli.png',
                'meta_title' => 'Logo Resmi PKS - DPD PKS Ogan Ilir',
                'meta_description' => 'Filosofi, makna lambang, dan panduan penggunaan logo resmi Partai Keadilan Sejahtera.',
                'content' => <<<HTML
<h3>Filosofi dan Makna Lambang PKS</h3>
<p>Lambang Partai Keadilan Sejahtera (PKS) berbentuk lingkaran berwarna oranye pekat yang di dalamnya memuat dua bulan sabit berwarna putih melingkupi untaian butir padi berwarna kuning emas, serta tulisan huruf balok <strong>PKS</strong> berwarna hitam di bagian bawah.</p>

<h4>Unsur-Unsur Lambang:</h4>
<ul>
    <li>
        <strong>Warna Oranye:</strong> Melambangkan kehangatan, harapan baru, optimisme, semangat muda, serta keterbukaan dalam melayani seluruh lapisan rakyat Indonesia.
    </li>
    <li>
        <strong>Dua Bulan Sabit Putih:</strong> Melambangkan kebersihan moral, kesucian niat, dan dimensi spiritualitas Islam yang <em>rahmatan lil 'alamin</em>.
    </li>
    <li>
        <strong>Untaian Butir Padi Emas:</strong> Melambangkan cita-cita keadilan sosial, kemakmuran, ketahanan pangan, dan kesejahteraan ekonomi bagi seluruh rakyat.
    </li>
    <li>
        <strong>Warna Putih & Hitam:</strong> Melambangkan ketegasan sikap moral antara yang haq dan bathil, serta komitmen transparansi dan integritas.
    </li>
</ul>

<h4>Panduan Penggunaan Logo:</h4>
<p>Logo resmi ini dapat digunakan oleh kader, media massa, mitra kolaborasi, serta masyarakat luas untuk keperluan publikasi resmi, pemberitaan, dan kegiatan yang selaras dengan nilai-nilai kepartaian tanpa mengubah proporsi, warna dasar, atau tipografi logo.</p>
HTML
            ]
        );

        // --- I. Hubungi Kami ---
        Post::updateOrCreate(
            ['slug' => 'hubungi'],
            [
                'type' => 'page',
                'title' => 'Hubungi DPD PKS Ogan Ilir',
                'excerpt' => 'Kontak resmi, alamat kantor, nomor telepon, dan formulir pengaduan aspirasi masyarakat DPD PKS Ogan Ilir.',
                'status' => 'publish',
                'featured_image' => null,
                'meta_title' => 'Hubungi Kami - DPD PKS Ogan Ilir',
                'meta_description' => 'Kontak resmi, alamat kantor, nomor telepon, dan formulir pengaduan aspirasi masyarakat DPD PKS Ogan Ilir.',
                'content' => <<<HTML
<h3>Sekretariat DPD PKS Ogan Ilir</h3>
<p>Kami menyambut hangat setiap warga yang ingin bersilaturahmi, berdiskusi, atau menyampaikan aspirasi secara langsung ke kantor kami:</p>

<ul>
    <li><strong>Alamat Kantor:</strong> Jl. Komperta Taman Indralaya Blok C No. 05 Kel. Indralaya Indah, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan (Kode Pos 30662)</li>
    <li><strong>Telepon / WhatsApp Layanan:</strong> 082382336505</li>
    <li><strong>Email Resmi:</strong> pksoganilir@gmail.com</li>
    <li><strong>Website Resmi:</strong> oganilir.pks.id & pksoganilir.com</li>
    <li><strong>Jam Operasional Sekretariat:</strong> Senin – Sabtu, Pukul 08.30 – 16.30 WIB</li>
</ul>

<h3>Layanan Pengaduan & Advokasi Aspirasi Warga</h3>
<p>Masyarakat dapat menyampaikan pengaduan terkait pelayanan publik, masalah pendidikan, bansos, jembatan/jalan rusak, atau kesehatan langsung melalui formulir kontak di website ini atau melalui saluran WhatsApp Humas DPD PKS Ogan Ilir.</p>
HTML
            ]
        );

        // --- J. Donasi ---
        Post::updateOrCreate(
            ['slug' => 'donasi'],
            [
                'type' => 'page',
                'title' => 'Donasi Perjuangan PKS Ogan Ilir',
                'excerpt' => 'Salurkan infak dan donasi terbaik Anda untuk mendukung dakwah dan pelayanan rakyat DPD PKS Ogan Ilir.',
                'status' => 'publish',
                'featured_image' => null,
                'meta_title' => 'Donasi Perjuangan - DPD PKS Ogan Ilir',
                'meta_description' => 'Salurkan infak dan donasi terbaik Anda untuk mendukung dakwah dan pelayanan rakyat DPD PKS Ogan Ilir.',
                'content' => <<<HTML
<h3>Mari Bergabung dalam Kebaikan</h3>
<p>Partai Keadilan Sejahtera mengajak seluruh simpatisan, dermawan, dan masyarakat yang memiliki visi kebaikan untuk menyalurkan infak dan donasi terbaiknya guna menopang operasional program kemanusiaan, bakti sosial, tanggap bencana, dan pemberdayaan masyarakat di Kabupaten Ogan Ilir.</p>

<h4>Alokasi Penyaluran Donasi:</h4>
<ul>
    <li>Bantuan paket pangan dan sembako untuk keluarga prasejahtera dan dhuafa.</li>
    <li>Aksi cepat tanggap bencana (banjir, kebakaran, jembatan putus di wilayah Ogan Ilir).</li>
    <li>Pemeriksaan kesehatan, pengobatan gratis, dan donor darah rutin.</li>
    <li>Pembinaan karakter, pelatihan wirausaha pemuda, dan kegiatan dakwah anak-anak/remaja.</li>
</ul>

<h4>Rekening Resmi Donasi:</h4>
<p>
    <strong>Bank:</strong> Bank Sumsel Babel Syariah / BSI<br>
    <strong>Atas Nama:</strong> DPD PKS Kabupaten Ogan Ilir<br>
    <strong>Nomor Konfirmasi WhatsApp:</strong> 082382336505
</p>

<p><em>*Catatan: Setelah melakukan transfer donasi, mohon mengirimkan bukti transfer via WhatsApp ke nomor pengurus untuk pencatatan dan penerbitan tanda terima resmi.</em></p>
HTML
            ]
        );

        // --- K. E-Book Materi Dakwah ---
        Post::updateOrCreate(
            ['slug' => 'e-book'],
            [
                'type' => 'page',
                'title' => 'E-Book & Materi Dakwah PKS',
                'excerpt' => 'Kumpulan buku digital, materi pembinaan kader, dan modul dakwah resmi Partai Keadilan Sejahtera.',
                'status' => 'publish',
                'featured_image' => null,
                'meta_title' => 'Download E-Book - DPD PKS Ogan Ilir',
                'meta_description' => 'Kumpulan buku digital dan materi dakwah resmi Partai Keadilan Sejahtera.',
                'content' => <<<HTML
<h3>Pusat Unduhan Materi Dakwah & Pembinaan</h3>
<p>DPD PKS Ogan Ilir menyediakan berbagai dokumen digital, modul pembinaan keislaman, wawasan kebangsaan, dan buku panduan kepartaian yang dapat diunduh secara bebas oleh kader, simpatisan, dan masyarakat umum.</p>

<h4>Daftar Materi yang Tersedia:</h4>
<ul>
    <li>Modul Pembinaan Anggota Dasar (Ushulul 'Isyrin, Fiqih Dakwah).</li>
    <li>Buku Panduan Rumah Keluarga Indonesia (RKI).</li>
    <li>Materi Pelatihan Kepemimpinan & Wawasan Kebangsaan.</li>
    <li>Panduan Advokasi Kebijakan Publik untuk Kader Daerah.</li>
</ul>
HTML
            ]
        );

        // 3. BERSIHKAN POST UJI COBA / DRAFT KOSONG YANG TIDAK RELEVAN
        // Post draft yang tidak memiliki isi (panjang < 30 karakter) atau post dummy uji coba
        $deletedCount = Post::where('type', 'post')
            ->where(function ($q) {
                $q->where('status', 'draft')
                    ->where(function ($inner) {
                        $inner->whereNull('content')
                            ->orWhere('content', '')
                            ->orWhere('content', 'like', '%&nbsp;%')
                            ->orWhereRaw('LENGTH(content) < 30');
                    });
            })
            ->orWhere(function ($q2) {
                $q2->whereIn('slug', ['kegiatan-a', 'nikah-massal-iksan-dan-daud', 'kegiatan-bagi-takjil', 'berbagi-sembako']);
            })
            ->delete();

        echo "Cleaned up {$deletedCount} empty/dummy posts.\n";
    }
}
