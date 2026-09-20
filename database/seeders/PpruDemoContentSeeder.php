<?php

namespace Database\Seeders;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Category;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PpruDemoContentSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================================
        // 0. PURGE DUMMY RICKROLL VIDEOS
        // =========================================================================
        Video::where('youtube_id', 'dQw4w9WgXcQ')->delete();

        // =========================================================================
        // 1. DEWAN GURU (TEPAT 8 ORANG) - 2 BARIS 4 KOLOM
        // =========================================================================
        $dewanGuruList = [
            [
                'name' => 'KH. Tol\'at Wafa Ahmad, Lc.',
                'slug' => 'kh-tolat-wafa-ahmad-lc',
                'position' => 'Mudir Pondok Pesantren Raudhatul Ulum',
                'fraction' => 'Pimpinan Pesantren',
                'photo' => '/uploads/kh-tolat-wafa-ahmad.webp',
                'profile_summary' => 'Pimpinan & Pengasuh Utama Pondok Pesantren Raudhatul Ulum Sakatiga. Alumni Universitas Al-Azhar Kairo Mesir, pembina ribuan santri dan hafizh Qur\'an di seluruh pelosok nusantara.',
                'education' => 'S1 Syari\'ah Islamiyah - Universitas Al-Azhar Kairo, Mesir',
                'order' => 1,
            ],
            [
                'name' => 'Drs. KH. Karim Kasim',
                'slug' => 'drs-kh-karim-kasim',
                'position' => 'Ketua Dewan Pembina YAPIRUS',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/official/foto-mudir.webp',
                'profile_summary' => 'Ketua Dewan Pembina Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS). Dedikasi lebih dari 40 tahun dalam pembinaan akhlak, tarbiyah santri, dan pengembangan institusi pendidikan Islam terpadu.',
                'education' => 'Sarjana Pendidikan Islam & Tarbiyah',
                'order' => 2,
            ],
            [
                'name' => 'Ustadz H. Faisal Abdullah, S.T.',
                'slug' => 'ustadz-h-faisal-abdullah-st',
                'position' => 'Direktur Sarana, Prasarana & Keuangan',
                'fraction' => 'Yayasan',
                'photo' => '/uploads/official/kegiatan-santri-waw1985.webp',
                'profile_summary' => 'Mengawal modernisasi tata kelola sarana prasarana, laboratorium sains, kampus asrama terpadu, dan ekosistem digital Pondok Pesantren Raudhatul Ulum Sakatiga.',
                'education' => 'S1 Teknik Sipil & Manajemen Infrastruktur',
                'order' => 3,
            ],
            [
                'name' => 'Ustadz H. Ahmad Dailami, S.Pd.I.',
                'slug' => 'ustadz-h-ahmad-dailami-spdi',
                'position' => 'Kepala Madrasah Aliyah Raudhatul Ulum (MARU)',
                'fraction' => 'Pendidik',
                'photo' => '/uploads/official/kbm-santri-0054.webp',
                'profile_summary' => 'Memimpin jenjang Madrasah Aliyah dengan kurikulum muadalah Al-Azhar Kairo dan Kemenag. Sukses menghantarkan puluhan alumni meraih beasiswa ke Timur Tengah dan PTN ternama.',
                'education' => 'S1 Pendidikan Agama Islam & Ma\'had Aly',
                'order' => 4,
            ],
            [
                'name' => 'Ustadz Agi Gustiawan, S.Pd.',
                'slug' => 'ustadz-agi-gustiawan-spd',
                'position' => 'Kepala SMA Islam Terpadu Raudhatul Ulum',
                'fraction' => 'Pendidik',
                'photo' => '/uploads/official/kbm-santri-0098.webp',
                'profile_summary' => 'Kepala SMAIT Raudhatul Ulum. Berkomitmen memadukan kurikulum sains nasional, pembinaan karakter Islami, dan riset ilmiah remaja berprestasi hingga kancah olimpiade sains.',
                'education' => 'S1 Pendidikan Sains & Matematika',
                'order' => 5,
            ],
            [
                'name' => 'Ustadz Muhammad Syakir, M.Pd.',
                'slug' => 'ustadz-muhammad-syakir-mpd',
                'position' => 'Kepala MTs Raudhatul Ulum (MATSARU)',
                'fraction' => 'Pendidik',
                'photo' => '/uploads/official/kbm-santri-0152.webp',
                'profile_summary' => 'Kepala Madrasah Tsanawiyah Raudhatul Ulum. Berpengalaman dalam penguatan bahasa Arab-Inggris harian santri, tahsin bersanad, dan kedisiplinan asrama 24 jam.',
                'education' => 'S2 Manajemen Pendidikan Islam',
                'order' => 6,
            ],
            [
                'name' => 'Ustadzah Hj. Fatimah Azzahra, Lc., M.Ag.',
                'slug' => 'ustadzah-hj-fatimah-azzahra-lc-mag',
                'position' => 'Kepala Bagian Tahfidz & Pengasuhan Putri',
                'fraction' => 'Pendidik',
                'photo' => '/uploads/official/ngaji-sore.webp',
                'profile_summary' => 'Alumni Universitas Al-Azhar Kairo dan Pengasuh Markaz Tahfidz Putri PPRU. Telah mencetak puluhan santriwati mutqin 30 juz berakhlak Qur\'ani dan berjiwa da\'iyah.',
                'education' => 'S1 Ushuluddin Al-Azhar Mesir, S2 Studi Islam',
                'order' => 7,
            ],
            [
                'name' => 'Ustadz M. Rasyid Ridho, S.Th.I.',
                'slug' => 'ustadz-m-rasyid-ridho-sthi',
                'position' => 'Kepala Pengasuhan & Kedisiplinan Santri Putra',
                'fraction' => 'Pendidik',
                'photo' => '/uploads/official/panahan-santri.webp',
                'profile_summary' => 'Kepala Biro Pengasuhan Santri Putra (BPSP). Mengawal penegakan sunnah pondok, kepanduan, olahraga bela diri, dan penempaan mental kepemimpinan santri.',
                'education' => 'S1 Tafsir Hadits & Ilmu Al-Qur\'an',
                'order' => 8,
            ],
        ];

        AnggotaDewan::truncate();
        foreach ($dewanGuruList as $d) {
            AnggotaDewan::create($d);
        }

        // =========================================================================
        // 2. VIDEO DOKUMENTASI RESMI YOUTUBE TVRU SAKATIGA (4 KONTEN DEMO)
        // =========================================================================
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
                'title' => 'Sarasehan & Silaturahim Wali Santri Bersama Mudir KH. Tol\'at Wafa Ahmad, Lc.',
                'youtube_id' => 'mRdb_kGhbiQ',
                'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Arahan mendalam seputar sinergi pendidikan pesantren dan wali santri.',
            ],
            [
                'title' => 'Peringatan Hari Besar Islam & Kiprah Santri di Kampus Pesantren Raudhatul Ulum',
                'youtube_id' => 'p8B8wKu5o4c',
                'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga): Semarak tabligh akbar, lomba bahasa, dan kreasi santri.',
            ],
        ];

        Video::truncate();
        foreach ($tvruVideos as $v) {
            Video::create([
                'title' => $v['title'],
                'slug' => Str::slug($v['title']),
                'youtube_id' => $v['youtube_id'],
                'youtube_url' => 'https://www.youtube.com/watch?v='.$v['youtube_id'],
                'description' => $v['description'],
            ]);
        }

        // =========================================================================
        // 3. BERITA PONDOK PESANTREN (4 KONTEN DEMO)
        // =========================================================================
        $catBerita = Category::firstOrCreate(['slug' => 'berita'], ['name' => 'Berita Pondok', 'description' => 'Berita Kegiatan Pondok']);

        $beritaList = [
            [
                'title' => 'Pekan Perkenalan Santri Baru (P2SB) dan Matrikulasi T.A. 2026/2027 Resmi Dibuka',
                'image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'excerpt' => 'Upacara pembukaan P2SB tahun ajaran 2026/2027 berlangsung khidmat di lapangan utama Kampus A Pondok Pesantren Raudhatul Ulum Sakatiga.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Ribuan santri baru dari berbagai penjuru nusantara resmi mengikuti upacara pembukaan Pekan Perkenalan Santri Baru (P2SB) dan Program Matrikulasi Tahun Ajaran 2026/2027 di lapangan utama Kampus A Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga.</p><p>Upacara dipimpin langsung oleh Mudir PPRU, <strong>KH. Tol\'at Wafa Ahmad, Lc.</strong> Dalam amanatnya, beliau menyampaikan bahwa pondok pesantren adalah tempat menempa kepribadian Islam, akhlakul karimah, kemandirian, dan penempaan jati diri santri.</p><p>"Selamat datang para santri baru di bumi Raudhatul Ulum Sakatiga. Ikhlaskan hati untuk dibina dan ditempa selama 24 jam dalam lingkungan asrama yang sarat barakah ini," tutur Mudir.</p>',
            ],
            [
                'title' => 'Haflah Milad ke-76 dan Wisuda Akbar Santri Kelas Akhir Raudhatul Ulum Berlangsung Khidmat',
                'image' => '/uploads/official/upacara-santri-4680.webp',
                'excerpt' => 'PPRU Sakatiga menggelar resepsi kesyukuran Haflah Milad ke-76 sekaligus wisuda akbar ratusan santri kelas akhir MARU, SMAIT, MATSARU, dan SMPIT.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Suasana haru dan penuh rasa syukur menyelimuti wisuda akbar santri kelas akhir Pondok Pesantren Raudhatul Ulum Sakatiga yang dirangkaikan dengan peringatan Haflah Milad ke-76 berdirinya pesantren.</p><p>Ratusan wisudawan dan wisudawati secara resmi dilepas untuk melanjutkan estafet perjuangan ke jenjang pendidikan tinggi di dalam maupun luar negeri.</p>',
            ],
            [
                'title' => 'Pelepasan Delegasi Alumni MARU Raudhatul Ulum Lolos Beasiswa Universitas Al-Azhar Kairo',
                'image' => '/uploads/official/kegiatan-santri-waw1981.webp',
                'excerpt' => 'Sebanyak 18 santri alumni MARU Raudhatul Ulum Sakatiga dilepas secara resmi untuk melanjutkan studi sarjana di Universitas Al-Azhar Kairo Mesir.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Prestasi gemilang kembali ditorehkan santri Madrasah Aliyah Raudhatul Ulum (MARU) Sakatiga. Sebanyak 18 santri dinyatakan lolos seleksi beasiswa Kementerian Agama dan Muadalah Al-Azhar untuk melanjutkan kuliah di Kairo, Mesir.</p><p>Mudir Pesantren mengapresiasi kerja keras para asatidz dan mendoakan para delegasi agar menjadi ulama dan intelektual yang mumpuni bagi umat Islam.</p>',
            ],
            [
                'title' => 'Penandatanganan MoU Sinergi Riset Sains dan Teknologi Bersama Perguruan Tinggi Negeri Terkemuka',
                'image' => '/uploads/official/kbm-santri-0054.webp',
                'excerpt' => 'PPRU Sakatiga memperluas kemitraan strategis dalam pengembangan laboratorium sains terpadu dan pembinaan olimpiade sains madrasah.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Guna memperkuat keunggulan akademik di bidang sains dan teknologi, Pondok Pesantren Raudhatul Ulum Sakatiga menandatangani naskah nota kesepahaman (MoU) kemitraan riset dan pengabdian masyarakat.</p><p>Program ini mencakup pelatihan olimpiade sains, bimbingan karya tulis ilmiah santri, serta penguatan laboratorium biologi, fisika, dan komputer madrasah.</p>',
            ],
        ];

        foreach ($beritaList as $idx => $b) {
            $slug = Str::slug($b['title']);
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $b['title'],
                    'content' => $b['content'],
                    'excerpt' => $b['excerpt'],
                    'status' => 'publish',
                    'type' => 'post',
                    'is_featured' => $idx === 0,
                    'featured_image' => $b['image'],
                    'author_id' => 1,
                    'author_name' => 'Humas & Informasi PPRU',
                    'published_at' => now()->subDays($idx * 2),
                ]
            );
            $post->categories()->sync([$catBerita->id]);
        }

        // =========================================================================
        // 4. ARTIKEL & KAJIAN ILMIAH ASATIDZ (4 KONTEN DEMO)
        // =========================================================================
        $catArtikel = Category::firstOrCreate(['slug' => 'taujih'], ['name' => 'Tausiyah & Artikel Asatidz', 'description' => 'Artikel Ilmiah dan Tausiyah Keislaman']);

        $artikelList = [
            [
                'title' => 'Menumbuhkan Jiwa Kepemimpinan dan Akhlakul Karimah Melalui Tarbiyah Pesantren',
                'image' => '/uploads/official/ngaji-sore.webp',
                'excerpt' => 'Pendidikan pesantren bukan sekadar transfer of knowledge, melainkan proses internalisasi nilai-nilai keikhlasan, kesederhanaan, dan kemandirian.',
                'content' => '<p>Pondok pesantren sejak berabad-abad telah membuktikan perannya sebagai benteng peradaban umat. Di era disrupsi digital yang sarat distraksi, tarbiyah asrama selama 24 jam menjadi sarana paling efektif untuk menanamkan kedisiplinan dan akhlakul karimah.</p><p>Seorang santri dididik untuk terbiasa bangun sebelum subuh, menata asrama, membaca Al-Qur\'an, mengkaji turats, hingga memimpin organisasi santri. Dari proses inilah lahir para pemimpin bangsa yang berintegritas tinggi.</p>',
            ],
            [
                'title' => 'Pentingnya Menjaga Hafalan Al-Qur\'an (Muraja\'ah) di Tengah Kesibukan Akademik',
                'image' => '/uploads/official/drone-danau-telok-putih.webp',
                'excerpt' => 'Menghafal Al-Qur\'an adalah anugerah besar, namun menjaga dan memutqinkan hafalan adalah amanah seumur hidup yang membutuhkan keteguhan istiqamah.',
                'content' => '<p>Rasulullah ﷺ mengibaratkan hafalan Al-Qur\'an bagaikan unta yang terikat; jika terus dijaga maka ia akan tetap berada di genggaman. Kunci utama keberhasilan para santri penghafal Qur\'an di PPRU Sakatiga adalah jadwal muraja\'ah terstruktur sebelum subuh dan ba\'da maghrib.</p><p>Hafalan yang mutqin akan menerangi akal santri sehingga memudahkan mereka menyerap pelajaran eksakta dan sains modern.</p>',
            ],
            [
                'title' => 'Sinergi Kurikulum Dirasah Islamiyah Al-Azhar dan Sains Modern Menuju Indonesia Emas',
                'image' => '/uploads/official/kbm-santri-0098.webp',
                'excerpt' => 'Mengintegrasikan sains dan Al-Qur\'an secara harmonis tanpa dikotomi demi melahirkan generasi saintis Muslim yang taat beribadah.',
                'content' => '<p>Islam tidak pernah memisahkan ilmu agama dan ilmu pengetahuan umum. Di Raudhatul Ulum Sakatiga, para santri diajarkan bahwa mempelajari fisika, matematika, dan biologi adalah sarana bertadabbur atas kebesaran Allah ﷻ di alam semesta.</p><p>Dengan kurikulum muadalah Al-Azhar Kairo yang dipadukan dengan kurikulum sains terpadu, santri memiliki wawasan keislaman yang moderat (wasathiyah) sekaligus kompetensi sains global.</p>',
            ],
            [
                'title' => 'Adab Penuntut Ilmu Menurut Imam An-Nawawi: Panduan Emas Generasi Pelajar Muslim',
                'image' => '/uploads/official/kbm-santri-0152.webp',
                'excerpt' => 'Ilmu tidak akan meresap ke dalam dada yang dipenuhi kesombongan. Kerendahan hati dan kepatuhan kepada guru adalah kunci barakahnya ilmu.',
                'content' => '<p>Dalam kitab <em>At-Tibyan fi Adabi Hamalatil Qur\'an</em>, Imam An-Nawawi menekankan pentingnya membersihkan niat dalam menuntut ilmu. Seorang penuntut ilmu wajib memuliakan guru, menghargai sesama rekan belajar, dan menjauhi maksiat yang dapat meredupkan cahaya pemahaman.</p>',
            ],
        ];

        foreach ($artikelList as $idx => $a) {
            $slug = Str::slug($a['title']);
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $a['title'],
                    'content' => $a['content'],
                    'excerpt' => $a['excerpt'],
                    'status' => 'publish',
                    'type' => 'post',
                    'is_featured' => false,
                    'featured_image' => $a['image'],
                    'author_id' => 1,
                    'author_name' => 'Dewan Asatidz PPRU',
                    'published_at' => now()->subDays($idx * 3 + 1),
                ]
            );
            $post->categories()->sync([$catArtikel->id]);
        }

        // =========================================================================
        // 5. PRESTASI SANTRI (4 KONTEN DEMO)
        // =========================================================================
        $prestasiList = [
            [
                'title' => 'Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) 30 Juz Tingkat Nasional 2026',
                'image' => '/uploads/official/kegiatan-santri-waw1985.webp',
                'excerpt' => 'Santri tahfidz PPRU Sakatiga berhasil meraih podium tertinggi dalam ajang MHQ 30 Juz Tingkat Nasional yang diselenggarakan Kemenag RI.',
                'content' => '<p>Prestasi membanggakan kembali dipersembahkan santri Pondok Pesantren Raudhatul Ulum Sakatiga. Ananda Ahmad Faizul Wafa berhasil meraih <strong>Juara 1 Nasional</strong> pada cabang Musabaqah Hifdzil Qur\'an (MHQ) 30 Juz Mutqin.</p><p>Penghargaan diserahkan langsung oleh dewan juri nasional atas kelancaran hafalan, fashahah, tajwid, dan adab tilawah yang sempurna.</p>',
            ],
            [
                'title' => 'Medali Emas Olimpiade Sains Madrasah (KSM) Tingkat Provinsi Bidang Fisika Terpadu',
                'image' => '/uploads/official/kbm-santri-0098.webp',
                'excerpt' => 'Santri SMAIT Raudhatul Ulum menorehkan prestasi membanggakan dengan merebut medali emas dalam KSM Sains Madrasah.',
                'content' => '<p>Melalui persaingan ketat bersama ratusan peserta madrasah se-Sumatera Selatan, delegasi sains PPRU Sakatiga sukses membawa pulang medali emas bidang Fisika Terpadu Terintegrasi Nilai-Nilai Islam.</p>',
            ],
            [
                'title' => 'Juara Umum Kejuaraan Pencak Silat Tapak Suci Pesantren se-Sumatera 2026',
                'image' => '/uploads/official/panahan-santri.webp',
                'excerpt' => 'Kontingen Tapak Suci PPRU Sakatiga memborong 7 medali emas dan 4 medali perak, sekaligus dinobatkan sebagai Juara Umum.',
                'content' => '<p>Pendekar santri Raudhatul Ulum menunjukkan ketangkasan dan sportivitas tinggi pada Kejuaraan Seni Bela Diri Tapak Suci Antar-Pesantren. Dengan torehan 7 emas, piala bergilir juara umum sukses dipertahankan di kampus Sakatiga.</p>',
            ],
            [
                'title' => 'Juara 1 Lomba Debat Bahasa Arab (Munazarah Ilmiyah) Antar Pondok Pesantren Modern',
                'image' => '/uploads/official/kbm-santri-0054.webp',
                'excerpt' => 'Tim debat bahasa Arab santri MARU tampil memukau dengan argumen ilmiah dan kefasihan berbahasa Arab fusha tingkat tinggi.',
                'content' => '<p>Kefasihan berbahasa Arab santri PPRU Sakatiga kembali terbukti di ajang festival bahasa internasional. Tim debat santri dinobatkan sebagai Juara 1 setelah mengalahkan delegasi pesantren ternama dari berbagai wilayah.</p>',
            ],
        ];

        foreach ($prestasiList as $idx => $pr) {
            $slug = Str::slug($pr['title']);
            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $pr['title'],
                    'content' => $pr['content'],
                    'excerpt' => $pr['excerpt'],
                    'status' => 'publish',
                    'type' => 'prestasi',
                    'featured_image' => $pr['image'],
                    'author_id' => 1,
                    'author_name' => 'Biro Prestasi & Bakat Santri',
                    'published_at' => now()->subDays($idx * 4),
                ]
            );
        }

        // =========================================================================
        // 6. EKSTRAKURIKULER (4 KONTEN DEMO)
        // =========================================================================
        $ekskulList = [
            [
                'title' => 'Pramuka & Kepanduan Hizbul Wathan (HW)',
                'image' => '/uploads/official/upacara-santri-4680.webp',
                'excerpt' => 'Membentuk santri berjiwa patriotik, mandiri, disiplin, berakhlak mulia, dan siap menjadi pelopor pertolongan masyarakat.',
                'content' => '<p>Kepanduan di PPRU Sakatiga melatih kepemimpinan lapangan, ketangkasan berkemah, survival, tali-temali, dan penjelajahan alam terbuka. Seluruh santri dibina dengan nilai-nilai kepanduan Islam yang kokoh.</p>',
            ],
            [
                'title' => 'Seni Bela Diri Tapak Suci & Pencak Silat Prestasi',
                'image' => '/uploads/official/panahan-santri.webp',
                'excerpt' => 'Olahraga bela diri warisan leluhur untuk menjaga kebugaran jasmani santri, pertahanan diri, dan prestasi kejuaraan.',
                'content' => '<p>Ekskul Tapak Suci melatih jurus seni, tanding, dan pernapasan dengan bimbingan pelatih bersertifikat. Melatih mental juara tanpa meninggalkan adab rendah hati.</p>',
            ],
            [
                'title' => 'Tahsin & Jam\'iyyatul Qurra\' Wal Huffadz (JQH)',
                'image' => '/uploads/official/ngaji-sore.webp',
                'excerpt' => 'Wadah pembinaan tilawah tartil bersanad, nagham Qur\'ani, kaligrafi Islam (khat), dan pendalaman tajwid komprehensif.',
                'content' => '<p>Di bawah bimbingan asatidz qari bersanad, santri mengasah keindahan bacaan Al-Qur\'an dengan lagu-lagu tilawah klasik seperti Bayati, Hijaz, Shoba, dan Rost.</p>',
            ],
            [
                'title' => 'Klub Robotika, Coding & Sains Madrasah (Science Club)',
                'image' => '/uploads/official/kbm-santri-0098.webp',
                'excerpt' => 'Pengembangan inovasi mikrokontroler, pemrograman komputer, IoT, dan eksperimen sains aplikatif santri.',
                'content' => '<p>Santri diajarkan merakit robot transporter, pemrograman Scratch/Python, dan pemecahan masalah teknologi untuk menjawab tantangan masa depan berbasis sains.</p>',
            ],
        ];

        foreach ($ekskulList as $idx => $ek) {
            $slug = Str::slug($ek['title']);
            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $ek['title'],
                    'content' => $ek['content'],
                    'excerpt' => $ek['excerpt'],
                    'status' => 'publish',
                    'type' => 'ekskul',
                    'featured_image' => $ek['image'],
                    'author_id' => 1,
                    'author_name' => 'Bagian Kesiswaan & Ekskul',
                    'published_at' => now()->subDays($idx * 5),
                ]
            );
        }

        // =========================================================================
        // 7. TESTIMONIAL (4 KONTEN DEMO)
        // =========================================================================
        $testimonialList = [
            [
                'name' => 'Prof. Dr. H. Ahmad Dahlan, M.A.',
                'profession' => 'Tokoh Pendidikan Nasional & Guru Besar',
                'photo' => '/uploads/official/foto-mudir.webp',
                'content' => 'Pondok Pesantren Raudhatul Ulum Sakatiga konsisten membuktikan kualitasnya dalam memadukan kedalaman ilmu agama dan ketajaman sains. Santri-santrinya berakhlak mulia dan berwawasan luas.',
                'status' => 'publish',
            ],
            [
                'name' => 'Hj. Siti Aminah, S.Pd.',
                'profession' => 'Wali Santri MA Raudhatul Ulum (Alumni 2026)',
                'photo' => '/uploads/official/ngaji-sore.webp',
                'content' => 'Alhamdulillah, keputusan memondokkan anak di Raudhatul Ulum adalah keputusan terbaik keluarga kami. Anak kami lulus sebagai hafizhah 30 juz dan kini meraih beasiswa kedokteran.',
                'status' => 'publish',
            ],
            [
                'name' => 'Muhammad Rizky Pratama, S.Ked.',
                'profession' => 'Alumni PPRU - Dokter Muda & Hafizh 30 Juz',
                'photo' => '/uploads/official/kbm-santri-0054.webp',
                'content' => 'Disiplin 24 jam, kemandirian asrama, dan hafalan Qur\'an yang saya pelajari di Raudhatul Ulum menjadi fondasi tak ternilai dalam menempuh studi profesi dokter.',
                'status' => 'publish',
            ],
            [
                'name' => 'Ir. H. Bambang Irawan, M.T.',
                'profession' => 'Wali Santri SMPIT & SMAIT Raudhatul Ulum',
                'photo' => '/uploads/official/kegiatan-santri-waw1985.webp',
                'content' => 'Fasilitas kampus terpadu, lingkungan asri dan aman, serta pengasuhan asatidz yang penuh kasih sayang membuat anak-anak betah dan berkembang pesat baik akhlak maupun prestasinya.',
                'status' => 'publish',
            ],
        ];

        Testimonial::truncate();
        foreach ($testimonialList as $t) {
            Testimonial::create($t);
        }

        // =========================================================================
        // 8. AGENDA KEGIATAN (4 KONTEN DEMO)
        // =========================================================================
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

        Agenda::truncate();
        foreach ($agendaList as $ag) {
            Agenda::create([
                'title' => $ag['title'],
                'slug' => Str::slug($ag['title']),
                'event_date' => $ag['event_date'],
                'location' => $ag['location'],
                'status' => $ag['status'],
                'featured_image' => $ag['featured_image'],
                'content' => $ag['content'],
            ]);
        }

        // =========================================================================
        // 9. PENGUMUMAN RESMI & INFO (4 KONTEN DEMO)
        // =========================================================================
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

        Pengumuman::truncate();
        foreach ($pengumumanList as $p) {
            Pengumuman::create([
                'title' => $p['title'],
                'slug' => Str::slug($p['title']),
                'status' => $p['status'],
                'content' => $p['content'],
                'file_attachment' => $p['file_attachment'],
            ]);
        }
    }
}
