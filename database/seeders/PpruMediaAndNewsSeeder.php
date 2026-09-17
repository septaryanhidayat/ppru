<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PpruMediaAndNewsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed / Update Videos from @tvrusakatiga (Channel: UCArMOcclte3D_jNhqq_MC2w)
        $tvruVideos = [
            [
                'title' => 'Upacara Kemerdekaan RI ke-81 di Pondok Pesantren Raudhatul Ulum Sakatiga',
                'youtube_id' => 'BG311kT-yXc',
            ],
            [
                'title' => 'Sarasehan Wali Santri Baru PPRU Sakatiga TA 2026/2027',
                'youtube_id' => 'cFXK5Of-IzQ',
            ],
            [
                'title' => 'Sarasehan & Silaturahim Wali Santri Bersama Mudir KH. Tol\'at Wafa Ahmad, Lc.',
                'youtube_id' => 'mRdb_kGhbiQ',
            ],
            [
                'title' => 'Peringatan Hari Kemerdekaan RI di Kampus Pondok Pesantren Raudhatul Ulum Sakatiga',
                'youtube_id' => 'p8B8wKu5o4c',
            ],
            [
                'title' => 'Upacara Pengibaran Bendera Merah Putih Santri & Kepanduan PPRU Sakatiga',
                'youtube_id' => 'iSL5Rw9f0ds',
            ],
            [
                'title' => 'Pertemuan & Pengarahan Pimpinan Pesantren untuk Wali Santri Baru',
                'youtube_id' => '1HpIwqboDFg',
            ],
            [
                'title' => 'Gema Kemerdekaan dan Semarak Apel Santri PPRU Sakatiga',
                'youtube_id' => 'UGc6hUcwSXk',
            ],
            [
                'title' => 'Semarak Hari Kemerdekaan dan Atraksi Seni Beladiri Santri PPRU',
                'youtube_id' => 'fvSzJDVyNCE',
            ],
        ];

        Video::truncate();
        foreach ($tvruVideos as $v) {
            Video::create([
                'title' => $v['title'],
                'slug' => Str::slug($v['title']),
                'youtube_id' => $v['youtube_id'],
                'youtube_url' => 'https://www.youtube.com/watch?v='.$v['youtube_id'],
                'description' => 'Dokumentasi video resmi dari kanal YouTube TVRU Sakatiga (@tvrusakatiga) Pondok Pesantren Raudhatul Ulum Sakatiga.',
            ]);
        }

        // 2. Ensure Categories Exist
        $categories = [
            'taujih' => 'Taujih, Tausiyah & Khutbah Jum\'at',
            'berita' => 'Berita Pondok',
            'kegiatan' => 'Kegiatan Santri',
            'prestasi-siswa' => 'Prestasi Santri & Guru',
            'akademik-riset' => 'Dirasah & Sains',
            'tahfidz-keislaman' => 'Tahfidzul Qur\'an',
            'kabar-kampus' => 'Kabar Kampus',
        ];

        $categoryModels = [];
        foreach ($categories as $slug => $name) {
            $categoryModels[$slug] = Category::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'description' => 'Kategori '.$name]
            );
        }

        // 3. Seed Posts & Articles from Instagram @ppru_sakatiga & FB pprusakatigasumsel
        $newsItems = [
            // --- BERITA UTAMA & KABAR PONDOK ---
            [
                'title' => 'Pekan Perkenalan Santri Baru (P2SB) dan Matrikulasi T.A. 2026/2027 PPRU Sakatiga Resmi Dibuka',
                'category' => 'berita',
                'image' => '/uploads/ppru-p2sb.jpg',
                'excerpt' => 'Upacara pembukaan P2SB tahun ajaran 2026/2027 berlangsung khidmat di lapangan utama Kampus A Pondok Pesantren Raudhatul Ulum Sakatiga, dihadiri seluruh santri baru, pengasuh, dan asatidz.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> — Ribuan santri baru dari berbagai penjuru nusantara resmi mengikuti upacara pembukaan Pekan Perkenalan Santri Baru (P2SB) dan Program Matrikulasi Tahun Ajaran 2026/2027 di lapangan utama Kampus A Pondok Pesantren Raudhatul Ulum (PPRU) Sakatiga.</p><p>Upacara dipimpin langsung oleh Mudir PPRU, <strong>KH. Tol\'at Wafa Ahmad, Lc.</strong> Dalam amanatnya, beliau menyampaikan bahwa pondok pesantren bukan sekadar tempat menuntut ilmu umum, melainkan kawah candradimuka kaderisasi kepribadian Islam, akhlakul karimah, kemandirian, dan penempaan 10 Jati Diri Santri Raudhatul Ulum.</p><p>"Selamat datang para mujahid dan mujahidah cilik di bumi Raudhatul Ulum Sakatiga. Niatkan langkah ananda lillahi ta\'ala, ikhlaskan hati untuk dibina dan ditempa selama 24 jam dalam lingkungan asrama yang sarat barakah ini," tutur Mudir dalam pidato sambutannya.</p><p>Kegiatan P2SB ini diisi dengan pengenalan tata tertib kepesantrenan, penguatan bahasa Arab dan Inggris, pengenalan sistem muadalah Al-Azhar, outbound kemandirian, serta pengenalan fasilitas laboratorium sains dan perpustakaan digital.</p>',
            ],
            [
                'title' => 'Haflah Milad ke-76 dan Wisuda Santri Kelas Akhir Raudhatul Ulum Berlangsung Penuh Haru',
                'category' => 'berita',
                'image' => '/uploads/ppru-haflah.webp',
                'excerpt' => 'PPRU Sakatiga menggelar resepsi kesyukuran Haflah Milad ke-76 sekaligus wisuda akbar ratusan santri kelas akhir MARU, SMAIT, MATSARU, dan SMPIT di Gedung Serbaguna Kampus A.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> — Suasana haru dan penuh rasa syukur menyelimuti wisuda akbar santri kelas akhir Pondok Pesantren Raudhatul Ulum Sakatiga yang dirangkaikan dengan peringatan Haflah Milad ke-76 berdirinya pesantren.</p><p>Ratusan wisudawan dan wisudawati dari jenjang Madrasah Aliyah Raudhatul Ulum (MARU), SMAIT Raudhatul Ulum, Madrasah Tsanawiyah (MATSARU), dan SMPIT Raudhatul Ulum secara resmi dilepas untuk melanjutkan estafet perjuangan ke jenjang pendidikan tinggi.</p><p>Mudir Pesantren bersama jajaran pimpinan Yayasan Perguruan Islam Raudhatul Ulum Sakatiga (YAPIRUS) mengalungkan selempang tanda kelulusan kepada wisudawan terbaik bidang akademik, tahfidz Qur\'an 30 juz mutqin, dan teladan kedisiplinan organisasi.</p>',
            ],
            [
                'title' => 'Pelepasan Delegasi Alumni MARU Raudhatul Ulum Sakatiga Lolos Seleksi Beasiswa Al-Azhar Kairo Mesir',
                'category' => 'berita',
                'image' => '/uploads/ppru-alazhar.webp',
                'excerpt' => 'Sebagai wujud muadalah resmi, delegasi alumni MARU Sakatiga kembali diberangkatkan menempuh studi sarjana di Universitas Al-Azhar Kairo Mesir dan Universitas Islam Madinah.',
                'content' => '<p><strong>Sakatiga</strong> — Hubungan historis dan akademis antara Pondok Pesantren Raudhatul Ulum Sakatiga dengan Al-Azhar Al-Syarif Kairo Mesir kembali terbukti nyata. Sebanyak 18 alumni Madrasah Aliyah Raudhatul Ulum (MARU) secara resmi dilepas untuk melanjutkan studi ke Universitas Al-Azhar Kairo Mesir tahun akademik ini.</p><p>Keberhasilan ini didukung oleh piagam muadalah (penyetaraan ijazah) resmi yang dimiliki MARU Sakatiga dari Al-Azhar sejak dekade 1990-an, di mana kurikulum dirasah islamiyah dan bahasa Arab fusha di PPRU diakui setara dengan kurikulum Ma\'ahid Azhariyyah Mesir.</p>',
            ],
            [
                'title' => 'Sarasehan Akbar Wali Santri Baru Bersama Mudir KH. Tol\'at Wafa Ahmad, Lc.',
                'category' => 'berita',
                'image' => '/uploads/ppru-sarasehan.webp',
                'excerpt' => 'Dialog terbuka dan sarasehan wali santri baru bersama Pimpinan Pondok Pesantren Raudhatul Ulum Sakatiga membahas sinergi pendidikan keluarga dan pesantren.',
                'content' => '<p><strong>Sakatiga</strong> — Bertempat di Aula Utama Kampus A, jajaran pimpinan Pondok Pesantren Raudhatul Ulum menggelar sarasehan akbar bersama seluruh wali santri baru yang mengantarkan putra-putrinya ke asrama.</p><p>Mudir KH. Tol\'at Wafa Ahmad, Lc. menekankan pentingnya keikhlasan orang tua saat menyerahkan anak ke pondok pesantren. "Pendidikan di pesantren adalah kemitraan lahir dan batin antara orang tua di rumah dengan para asatidz di pondok. Doa orang tua di sepertiga malam adalah bahan bakar kesuksesan santri di bilik asrama," tegas beliau.</p>',
            ],

            // --- KEGIATAN SANTRI ---
            [
                'title' => 'Ujian Terbuka Tahfidz & Khotmil Qur\'an 30 Juz Bersanad Santri MATQULARU Sakatiga',
                'category' => 'tahfidz-keislaman',
                'image' => '/uploads/ppru-tahfidz.webp',
                'excerpt' => 'Para santri cilik Madrasah Tahfizhul Qur\'an Lil Aulad (MATQULARU) sukses menjalani tasmi\' sekali duduk dan wisuda tahfidz 30 juz mutqin bersanad.',
                'content' => '<p><strong>Sakatiga</strong> — Suasana syahdu terdengar merdu saat para santri MATQULARU Sakatiga membacakan ayat-ayat suci Al-Qur\'an secara hafalan di hadapan dewan penguji dan para masyayikh bersanad.</p><p>Program khusus tahfidz MATQULARU mendidik santri sejak usia dini dengan metode talaqqi dan mudarasah intensif, sehingga mampu menuntaskan hafalan 30 juz mutqin lengkap dengan kaidah tajwid dan makharijul huruf yang fasih.</p>',
            ],
            [
                'title' => 'Perkemahan Akbar Pramuka & Pelantikan Bantara Santri Raudhatul Ulum di Bumi Perkemahan Kampus B',
                'category' => 'kegiatan',
                'image' => '/uploads/ppru-pramuka.webp',
                'excerpt' => 'Gugus Depan Gerakan Pramuka PPRU Sakatiga menggelar perkemahan akbar 3 hari 2 malam untuk mengasah kemandirian, ketangkasan, dan kebersamaan santri.',
                'content' => '<p><strong>Indralaya</strong> — Ratusan tenda berdiri rapi di Bumi Perkemahan Kampus B PPRU Sakatiga dalam rangka Perkemahan Akbar Kepanduan dan Pelantikan Penegak Bantara santri Raudhatul Ulum.</p><p>Kegiatan diisi dengan pionering, jelajah alam, pentas seni islami api unggun, dan simulasi penanggulangan bencana yang melatih kedisiplinan dan kesiapsiagaan santri di alam terbuka.</p>',
            ],
            [
                'title' => 'Muhadharah Akbar 3 Bahasa (Arab, Inggris, Indonesia): Asah Percakapan & Retorika Da\'i Muda Santri',
                'category' => 'kegiatan',
                'image' => '/uploads/ppru-muhadharah.webp',
                'excerpt' => 'Agenda mingguan muhadharah santri melatih kepercayaan diri santri berpidato dalam bahasa Arab fusha, Inggris, dan Indonesia di hadapan ribuan audiens.',
                'content' => '<p><strong>Sakatiga</strong> — Kemampuan retorika dan penguasaan bahasa asing merupakan ciri khas santri Raudhatul Ulum Sakatiga. Melalui kegiatan muhadharah (latihan berpidato) berkala, santri dilatih tampil percaya diri menyampaikan gagasan dakwah secara sistematis dan lugas.</p>',
            ],

            // --- PRESTASI SANTRI & GURU ---
            [
                'title' => 'Santri PPRU Sakatiga Raih Juara Umum Musabaqah Tilawatil & Hifzhil Qur\'an (MTQ/MHQ) Tingkat Provinsi',
                'category' => 'prestasi-siswa',
                'image' => '/uploads/ppru-mtq.webp',
                'excerpt' => 'Kafilah santri Pondok Pesantren Raudhatul Ulum Sakatiga sukses memborong piala pada ajang MTQ/MHQ tingkat Sumatera Selatan di berbagai cabang lomba.',
                'content' => '<p><strong>Palembang</strong> — Prestasi membanggakan kembali ditorehkan oleh santri-santriwati Pondok Pesantren Raudhatul Ulum Sakatiga. Pada perhelatan MTQ/MHQ Tingkat Provinsi Sumatera Selatan, delegasi PPRU sukses meraih gelar Juara Umum setelah memenangkan cabang MHQ 10 Juz, 20 Juz, dan 30 Juz Putra-Putri.</p><p>Pimpinan pesantren mengapresiasi kerja keras para pembimbing dan dedikasi santri yang terus menjaga kemurnian dan kelancaran hafalan Al-Qur\'an.</p>',
            ],
            [
                'title' => 'Siswa MARU & SMAIT Raudhatul Ulum Sabet Medali Emas Kompetisi Sains Madrasah (KSM)',
                'category' => 'prestasi-siswa',
                'image' => '/uploads/ppru-ksm.webp',
                'excerpt' => 'Integrasi sains dan nilai Islam mengantarkan santri MARU dan SMAIT RU meraih juara 1 bidang Fisika Terintegrasi dan Biologi Terintegrasi KSM.',
                'content' => '<p><strong>Ogan Ilir</strong> — Membuktikan keunggulan di bidang sains, santri Madrasah Aliyah Raudhatul Ulum (MARU) dan SMAIT Raudhatul Ulum berhasil merebut medali emas pada Kompetisi Sains Madrasah (KSM) tingkat daerah dan berhak mewakili provinsi ke tingkat nasional.</p>',
            ],
            [
                'title' => 'Delegasi Debat Bahasa Arab Santri PPRU Raih Gelar Best Speaker pada Festival Bahasa Nasional',
                'category' => 'prestasi-siswa',
                'image' => '/uploads/ppru-debat.webp',
                'excerpt' => 'Kecakapan tata bahasa dan retorika Arab fusha santri Raudhatul Ulum Sakatiga dinobatkan sebagai Best Speaker di ajang festival bahasa bergengsi.',
                'content' => '<p><strong>Yogyakarta</strong> — Tim debat bahasa Arab Pondok Pesantren Raudhatul Ulum Sakatiga kembali menorehkan prestasi gemilang di tingkat nasional. Menghadapi puluhan pesantren dan universitas ternama, delegasi santri RU sukses meraih trofi Juara 1 dan predikat Best Speaker.</p>',
            ],
            [
                'title' => 'Santriwati Raudhatul Ulum Terpilih Mewakili Sumsel pada Ajang Perkemahan Pramuka Santri Nusantara',
                'category' => 'prestasi-siswa',
                'image' => '/uploads/ppru-ppsn.webp',
                'excerpt' => 'Ketangkasan dan disiplin kepanduan pramuka santriwati Raudhatul Ulum Sakatiga membawanya lolos seleksi mewakili kontingen Sumatera Selatan.',
                'content' => '<p><strong>Indralaya</strong> — Prestasi membanggakan kembali lahir dari pangkalan Gerakan Pramuka Gudep PPRU Sakatiga. Setelah melalui seleksi ketat kecakapan kepanduan, santriwati Raudhatul Ulum terpilih menjadi bagian dari kontingen utama Provinsi Sumatera Selatan pada Perkemahan Pramuka Santri Nusantara (PPSN).</p>',
            ],

            // --- TAUJIH MUDIR & NASIHAT PIMPINAN ---
            [
                'title' => 'Taujih Mudir KH. Tol\'at Wafa Ahmad, Lc: Keikhlasan dan Kesungguhan Menuntut Ilmu di Pesantren',
                'category' => 'taujih',
                'image' => '/uploads/ppru-taujih.jpg',
                'excerpt' => '"Pondok pesantren adalah laboratorium kehidupan. Barangsiapa yang ikhlas dan bersungguh-sungguh, Allah SWT akan bukakan pintu-pintu kemudahan baginya."',
                'content' => '<p><strong>Sakatiga</strong> — Dalam pertemuan rutin bersama seluruh asatidz dan santri di Masjid Utama Kampus A, Mudir Pondok Pesantren Raudhatul Ulum, <strong>KH. Tol\'at Wafa Ahmad, Lc.</strong> menyampaikan tausiyah mendalam tentang hakikat tholabul \'ilmi di era modern.</p><blockquote><p><em>"Ilmu tidak akan didapatkan oleh jasad yang berleha-leha. Kehidupan asrama dengan segala disiplinnya adalah sarana pembentukan mental baja. Jangan pernah mengeluh dengan lelahnya belajar, karena lelahnya kebodohan jauh lebih pedih di kemudian hari,"</em> tutur beliau mengutip kalam ulama salaf.</p></blockquote><p>Beliau juga berpesan agar para santri senantiasa menjaga adab terhadap guru, memuliakan Al-Qur\'an, dan senantiasa berbakti serta mendoakan kedua orang tua yang telah berkorban demi masa depan mereka.</p>',
            ],
            [
                'title' => 'Nasihat Pimpinan: Menegakkan 10 Jati Diri Santri Raudhatul Ulum dalam Kehidupan Sehari-hari',
                'category' => 'taujih',
                'image' => '/uploads/ppru-jatidiri.webp',
                'excerpt' => 'Penanaman 10 Standar Diri Islami (SDI) sebagai kompas moral dan spiritual bagi seluruh santri dan alumni Raudhatul Ulum di manapun berada.',
                'content' => '<p><strong>Sakatiga</strong> — Pondok Pesantren Raudhatul Ulum memiliki 10 Jati Diri Santri yang menjadi ruh pendidikan:</p><ol><li><strong>Salimul Aqidah:</strong> Beraqidah lurus dan bersih dari syirik.</li><li><strong>Shahihul Ibadah:</strong> Beribadah benar sesuai tuntunan Rasulullah SAW.</li><li><strong>Matinul Khuluq:</strong> Berakhlak mulia, beradab, dan santun.</li><li><strong>Qadirun \'alal Kasbi:</strong> Mandiri dan beretos kerja tinggi.</li><li><strong>Mutsaqqoful Fikri:</strong> Berpengetahuan luas dalam ilmu syar\'i dan sains.</li><li><strong>Qowiyyul Jismi:</strong> Berbadan sehat, kuat, dan bugar.</li><li><strong>Mujahidun li Nafsihi:</strong> Mampu mengendalikan hawa nafsu.</li><li><strong>Munazzhomun fi Syu\'unihi:</strong> Berdisiplin dan tertata rapi.</li><li><strong>Haritsun \'ala Waqtihi:</strong> Menghargai dan memanfaatkan waktu.</li><li><strong>Nafi\'un li Ghairihi:</strong> Memberi manfaat seluas-luasnya bagi umat.</li></ol>',
            ],
        ];

        foreach ($newsItems as $item) {
            $slug = Str::slug($item['title']);
            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'featured_image' => $item['image'],
                    'status' => 'publish',
                    'type' => 'post',
                    'published_at' => now()->subDays(rand(1, 30)),
                    'views_count' => rand(120, 850),
                ]
            );

            if (isset($categoryModels[$item['category']])) {
                $post->categories()->sync([$categoryModels[$item['category']]->id]);
            }
        }
    }
}
