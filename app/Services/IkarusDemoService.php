<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Carbon\Carbon;

class IkarusDemoService
{
    /**
     * Get all 12 rich demo articles for IKARUS (6 Berita + 6 Tulisan Alumni).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function getDemoArticles(): array
    {
        return [
            // =========================================================================
            // BERITA & KABAR IKARUS (6 ITEM)
            // =========================================================================
            [
                'title' => 'Reuni Akbar 2026 dan Musyawarah Nasional IKARUS: Luncurkan Dana Abadi Santri Rp 1 Miliar',
                'slug' => 'reuni-akbar-2026-dan-musyawarah-nasional-ikarus-luncurkan-dana-abadi-santri',
                'rubrik' => 'berita',
                'author_name' => 'H. Rahmat Hidayat, S.Pd.I.',
                'author_title' => 'Ketua Umum PP IKARUS',
                'excerpt' => 'Konsolidasi akbar ribuan alumni lintas angkatan 1980 hingga 2025 di Kampus PPRU Sakatiga sukses meluncurkan program dana abadi dan beasiswa santri berprestasi.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Suasana haru dan penuh kehangatan menyelimuti kawasan Kampus Utama Pondok Pesantren Raudhatul Ulum Sakatiga saat ribuan alumni dari berbagai angkatan berkumpul dalam Reuni Akbar dan Musyawarah Nasional (Munas) IKARUS tahun 2026.</p>
<p>Kegiatan yang berlangsung selama dua hari ini mengusung tema <em>"Merajut Ukhuwah, Mengokohkan Khidmah untuk Kejayaan Almamater dan Kemaslahatan Ummat"</em>. Dalam musyawarah tersebut, disepakati peluncuran <strong>Program Dana Abadi IKARUS</strong> dengan target awal penghimpunan sebesar Rp 1 Miliar yang dialokasikan khusus untuk beasiswa santri yatim, dhuafa, serta santri berprestasi.</p>
<p>Mudir Pondok Pesantren Raudhatul Ulum dalam sambutannya menyampaikan rasa syukur dan bangga atas soliditas para alumni. Beliau berpesan agar alumni senantiasa menjaga nama baik almamater serta menjadi duta kebaikan dan pelopor persatuan di mana pun berada.</p>',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'is_featured' => true,
                'published_at' => '2026-03-15 08:30:00',
                'views_count' => 1240,
            ],
            [
                'title' => 'IKARUS Cabang Istimewa Timur Tengah Resmi Dilantik di Kairo Mesir',
                'slug' => 'ikarus-cabang-istimewa-timur-tengah-resmi-dilantik-di-kairo-mesir',
                'rubrik' => 'berita',
                'author_name' => 'Ustadz M. Farhan Habibi, Lc.',
                'author_title' => 'Koordinator IKARUS Mesir',
                'excerpt' => 'Pelantikan pengurus IKARUS Cabang Istimewa Timur Tengah di Kairo memperkuat jaringan pendampingan santri baru yang menempuh studi di Al-Azhar dan Timur Tengah.',
                'content' => '<p><strong>Kairo, Mesir</strong> - Ikatan Keluarga Alumni Raudhatul Ulum (IKARUS) resmi melantik jajaran kepengurusan Cabang Istimewa Timur Tengah bertempat di Wisma Nusantara Kairo. Acara ini dihadiri oleh puluhan alumni PPRU yang saat ini menempuh studi sarjana maupun pascasarjana di Universitas Al-Azhar Kairo, Universitas Islam Madinah, dan universitas di Sudan.</p>
<p>Keberadaan IKARUS Timur Tengah difokuskan untuk membantu adaptasi santri baru, penguatan bimbingan talaqqi keilmuan dengan masyayikh Al-Azhar, serta memfasilitasi komunikasi antara orang tua santri di Indonesia dengan anak-anak mereka di perantauan.</p>',
                'featured_image' => '/uploads/official/kbm-santri-0098.webp',
                'is_featured' => false,
                'published_at' => '2026-02-20 14:00:00',
                'views_count' => 890,
            ],
            [
                'title' => 'Penyaluran Bantuan Kemanusiaan dan Layanan Kesehatan Gratis oleh Tim IKARUS Peduli',
                'slug' => 'penyaluran-bantuan-kemanusiaan-dan-layanan-kesehatan-gratis-oleh-tim-ikarus-peduli',
                'rubrik' => 'berita',
                'author_name' => 'dr. M. Ridho Pratama',
                'author_title' => 'Divisi Sosial & Medis IKARUS',
                'excerpt' => 'Aksi tanggap darurat alumni PPRU bersama jejaring dokter alumni mendistribusikan ribuan paket logistik serta pengobatan cuma-cuma bagi warga terdampak banjir di bantaran sungai.',
                'content' => '<p><strong>Ogan Ilir</strong> - Tim relawan IKARUS Peduli bersama gabungan dokter dan tenaga medis alumni Pondok Pesantren Raudhatul Ulum Sakatiga turun langsung menyalurkan bantuan kemanusiaan bagi masyarakat terdampak musibah luapan air pasang di wilayah Ogan Ilir.</p>
<p>Selain menyerahkan bantuan beras, sembako, dan air bersih, tim medis alumni mendirikan posko pelayanan kesehatan darurat yang melayani lebih dari 300 warga, terutama lansia dan anak-anak. Gerakan sosial ini merupakan bagian dari pengamalan nilai khidmah pesantren kepada ummat.</p>',
                'featured_image' => '/uploads/official/upacara-santri-4680.webp',
                'is_featured' => false,
                'published_at' => '2025-11-10 10:15:00',
                'views_count' => 670,
            ],
            [
                'title' => 'Penyerahan Beasiswa Pendidikan Alumni IKARUS untuk 50 Santri Penghafal Al-Quran',
                'slug' => 'penyerahan-beasiswa-pendidikan-alumni-ikarus-untuk-50-santri-penghafal-al-quran',
                'rubrik' => 'berita',
                'author_name' => 'Ustadz Syamsuddin, M.Ag.',
                'author_title' => 'Bidang Pendidikan IKARUS',
                'excerpt' => 'Sebanyak 50 santri berprestasi kategori tahfizh Al-Quran mutqin menerima beasiswa SPP dan biaya operasional asrama dari komunitas alumni Raudhatul Ulum.',
                'content' => '<p><strong>Sakatiga</strong> - Komitmen alumni dalam mendukung kelancaran studi generasi penerus diwujudkan melalui penyerahan simbolis beasiswa pendidikan bagi 50 santri jenjang MTs, MA, SMPIT, dan SMAIT Raudhatul Ulum Sakatiga.</p>
<p>Program beasiswa ini bersumber dari iuran infaq bulanan para alumni yang telah berkarir di berbagai bidang usaha, birokrasi, dan lembaga akademis di seluruh Indonesia.</p>',
                'featured_image' => '/uploads/official/ngaji-sore.webp',
                'is_featured' => false,
                'published_at' => '2025-08-25 09:00:00',
                'views_count' => 815,
            ],
            [
                'title' => 'Silaturahmi Alumni Lintas Generasi Wilayah Jabodetabek: Kolaborasi Profesional Membangun Ummat',
                'slug' => 'silaturahmi-alumni-lintas-generasi-wilayah-jabodetabek-kolaborasi-profesional-membangun-ummat',
                'rubrik' => 'berita',
                'author_name' => 'Hendra Wijaya, S.E.',
                'author_title' => 'Koordinator Wilayah Jabodetabek',
                'excerpt' => 'Pertemuan silaturahmi alumni kawasan ibu kota dan sekitarnya menginisiasi program pendampingan magang kerja dan wirausaha bagi fresh graduate asal almamater.',
                'content' => '<p><strong>Jakarta</strong> - Lebih dari 200 alumni PPRU yang berdomisili di Jakarta, Bogor, Depok, Tangerang, dan Bekasi menghadiri Temu Akrab dan Diskusi Bisnis Keummatan di kawasan Jakarta Selatan.</p>
<p>Acara ini merumuskan terbentuknya platform <em>IKARUS Career & Mentorship Network</em> guna menghubungkan lulusan perguruan tinggi asal alumni PPRU dengan peluang karir profesional dan bimbingan kewirausahaan syariah.</p>',
                'featured_image' => '/uploads/official/drone-danau-telok-putih.webp',
                'is_featured' => false,
                'published_at' => '2024-12-05 16:30:00',
                'views_count' => 930,
            ],
            [
                'title' => 'Peluncuran Sistem Direktori Digital Alumni: Pererat Koneksi Puluhan Ribu Lulusan Sedunia',
                'slug' => 'peluncuran-sistem-direktori-digital-alumni-pererat-koneksi-puluhan-ribu-lulusan-sedunia',
                'rubrik' => 'berita',
                'author_name' => 'Fajar Nugroho, S.Kom.',
                'author_title' => 'Tim Pengembang IT IKARUS',
                'excerpt' => 'Aplikasi web dan basis data digital alumni resmi diluncurkan untuk memetakan sebaran profesi, domisili, dan potensi kolaborasi alumni Raudhatul Ulum.',
                'content' => '<p><strong>Sakatiga</strong> - Memasuki era transformasi digital, Pengurus Pusat IKARUS bekerjasama dengan tim teknologi informasi pesantren resmi merilis fitur pemutakhiran data alumni secara daring.</p>
<p>Sistem ini mempermudah pencarian jejaring alumni berdasarkan profesi, wilayah domisili, hingga angkatan kelulusan dengan tetap mengedepankan keamanan dan privasi data anggota keluarga besar almamater.</p>',
                'featured_image' => '/uploads/official/kegiatan-santri-waw1985.webp',
                'is_featured' => false,
                'published_at' => '2024-06-18 11:00:00',
                'views_count' => 745,
            ],

            // =========================================================================
            // TULISAN & OPINI ALUMNI (6 ITEM)
            // =========================================================================
            [
                'title' => 'Kiprah Alumni MARU Menempuh Studi di Universitas Al-Azhar Kairo Mesir',
                'slug' => 'kiprah-alumni-maru-menempuh-studi-di-universitas-al-azhar-kairo-mesir',
                'rubrik' => 'tulisan',
                'author_name' => 'Ustadz Ahmad Farhan, Lc.',
                'author_title' => 'Mahasiswa Pascasarjana Al-Azhar Kairo',
                'excerpt' => 'Catatan inspiratif alumni Madrasah Aliyah Raudhatul Ulum Sakatiga yang kini menempuh studi sarjana Fakultas Ushuluddin di Universitas Al-Azhar Kairo, Mesir.',
                'content' => '<p><strong>Kairo, Mesir</strong> - Perjalanan menuntut ilmu ke negeri para anbiya adalah impian banyak santri di tanah air. Bagi kami para alumni Madrasah Aliyah Raudhatul Ulum (MARU) Sakatiga, bekal bahasa Arab fusha dan pemahaman dasar kitab turots yang dipelajari selama bertahun-tahun di asrama menjadi modal berharga saat pertama kali menginjakkan kaki di Universitas Al-Azhar Kairo.</p>
<p>Alhamdulillah, berkat piagam muadalah (penyetaraan ijazah) resmi yang telah lama terjalin antara Al-Azhar Asy-Syarif dengan Pondok Pesantren Raudhatul Ulum Sakatiga, proses administrasi dan adaptasi akademik santri alumni berjalan sangat lancar. Kami dapat langsung mengikuti perkuliahan dengan para masyayikh terkemuka di masjid Al-Azhar maupun ruang kuliah universitas.</p>
<p>Belajar di Raudhatul Ulum tidak hanya membentuk kecerdasan kognitif, tetapi juga adab, kedisiplinan asrama, serta mental kemandirian yang sangat terasa manfaatnya saat hidup di perantauan Kairo. Semoga estafet ini terus berlanjut bagi adik-adik santri generasi berikutnya.</p>',
                'featured_image' => '/uploads/official/kbm-santri-0098.webp',
                'is_featured' => false,
                'published_at' => '2026-03-01 07:30:00',
                'views_count' => 1120,
            ],
            [
                'title' => 'Pengabdian Dokter Alumni PPRU di Pelosok Nusantara: Nilai Keikhlasan Menjadi Bekal Utama',
                'slug' => 'pengabdian-dokter-alumni-ppru-di-pelosok-nusantara-nilai-keikhlasan-menjadi-bekal-utama',
                'rubrik' => 'tulisan',
                'author_name' => 'dr. M. Ridho Pratama',
                'author_title' => 'Dokter Puskesmas Daerah Terpencil',
                'excerpt' => 'Kisah alumni SMAIT Raudhatul Ulum yang berkhidmah melayani kesehatan masyarakat pedalaman di perbatasan, membawa nilai akhlakul karimah pesantren.',
                'content' => '<p>Menjalani profesi medis di wilayah pedalaman dengan keterbatasan fasilitas medis menuntut lebih dari sekadar keahlian ilmu kedokteran; ia membutuhkan keikhlasan, kesabaran, dan empati kemanusiaan yang mendalam.</p>
<p>Nilai-nilai keikhlasan dan ketangguhan hidup yang ditanamkan selama menjadi santri di Raudhatul Ulum Sakatiga menjadi pegangan teguh dalam melayani masyarakat setiap hari. Pesantren mengajarkan kami bahwa ilmu apa pun yang kita miliki sejatinya adalah sarana ibadah dan pengabdian lillahi ta\'ala.</p>',
                'featured_image' => '/uploads/official/upacara-santri-4680.webp',
                'is_featured' => false,
                'published_at' => '2026-01-14 09:20:00',
                'views_count' => 860,
            ],
            [
                'title' => 'Menjaga Tradisi Literasi Turots Kitab Kuning bagi Santri di Tengah Disrupsi Era Digital',
                'slug' => 'menjaga-tradisi-literasi-turots-kitab-kuning-bagi-santri-di-tengah-disrupsi-era-digital',
                'rubrik' => 'tulisan',
                'author_name' => 'Ustadz Syamsuddin, M.Ag.',
                'author_title' => 'Dosen Studi Islam & Alumni MARU',
                'excerpt' => 'Refleksi intelektual santri alumni tentang urgensi sanad keilmuan dan metodologi kajian kitab klasik para ulama salafush sholih.',
                'content' => '<p>Di tengah banjir informasi digital dan maraknya rujukan instan di internet, tradisi literasi turots kitab kuning yang diajarkan di pondok pesantren memiliki nilai otentisitas yang tak tergantikan. Mempelajari kitab kuning bukan sekadar memahami teks gramatika nahwu dan shorof, melainkan menyerap adab talaqqi dan sanad keilmuan yang bersambung hingga Rasulullah SAW.</p>
<p>Sebagai alumni, kami mengapresiasi komitmen PPRU Sakatiga yang senantiasa mempertahankan kurikulum kajian kitab mu\'tabar sebagai salah satu pilar utama trisula keunggulan pesantren.</p>',
                'featured_image' => '/uploads/official/ngaji-sore.webp',
                'is_featured' => false,
                'published_at' => '2025-09-18 13:45:00',
                'views_count' => 740,
            ],
            [
                'title' => 'Kisah Sukses Pengusaha Muda Alumni Raudhatul Ulum: Membangun Kemandirian Ekonomi Berbasis Nilai Islam',
                'slug' => 'kisah-sukses-pengusaha-muda-alumni-raudhatul-ulum-membangun-kemandirian-ekonomi-berbasis-nilai-islam',
                'rubrik' => 'tulisan',
                'author_name' => 'Hendra Wijaya, S.E.',
                'author_title' => 'Praktisi Bisnis & Alumni PPRU',
                'excerpt' => 'Menerapkan prinsip Qadirun alal Kasbi (mandiri dalam berusaha) yang ditanamkan sejak di asrama pondok hingga sukses merintis jejaring bisnis nasional.',
                'content' => '<p>Prinsip kemandirian ekonomi atau Qadirun \'alal Kasbi adalah salah satu dari 10 Jati Diri Santri yang selalu ditekankan oleh para asatidz di Raudhatul Ulum. Berawal dari pengalaman berorganisasi di Organisasi Santri Raudhatul Ulum (OSRU) dan mengelola koperasi santri, benih kewirausahaan itu tumbuh subur.</p>
<p>Kini, dengan izin Allah SWT, jaringan usaha yang kami rintis dapat membuka lapangan kerja bagi ratusan karyawan serta menjadi mitra pengadaan bagi berbagai pondok pesantren di wilayah Sumatera Selatan.</p>',
                'featured_image' => '/uploads/official/drone-danau-telok-putih.webp',
                'is_featured' => false,
                'published_at' => '2025-05-12 10:00:00',
                'views_count' => 980,
            ],
            [
                'title' => 'Kiat Sukses Lolos Seleksi Universitas Islam Madinah: Berbagi Pengalaman untuk Santri Kelas Akhir',
                'slug' => 'kiat-sukses-lolos-seleksi-universitas-islam-madinah-berbagi-pengalaman-untuk-santri-kelas-akhir',
                'rubrik' => 'tulisan',
                'author_name' => 'Ustadz Zulkifli, Lc.',
                'author_title' => 'Alumni Fakultas Dakwah UIM',
                'excerpt' => 'Panduan persiapan berkas, penguatan tahfidzul Quran mutqin, serta tips wawancara bahasa Arab bagi calon pendaftar beasiswa perguruan tinggi luar negeri.',
                'content' => '<p>Bagi santri MARU dan SMAIT Raudhatul Ulum yang bercita-cita menimba ilmu syar\'i di Kota Nabi, Universitas Islam Madinah (UIM) menawarkan kesempatan emas. Kunci utama keberhasilan seleksi terletak pada penguasaan hafalan Al-Qur\'an yang mutqin, kelancaran berbahasa Arab aktif saat muqabalah (wawancara), serta integritas transkrip nilai akademik.</p>
<p>Melalui tulisan ini, kami membagikan panduan teknis langkah demi langkah mulai dari legalisasi dokumen, penyusunan surat rekomendasi asatidz, hingga kiat menjawab pertanyaan penguji muqabalah.</p>',
                'featured_image' => '/uploads/official/kbm-santri-0152.webp',
                'is_featured' => false,
                'published_at' => '2024-10-08 08:15:00',
                'views_count' => 1050,
            ],
            [
                'title' => 'Meneguhkan Khidmah Guru Alumni di Pelosok Desa: Jejak Langkah Dakwah Tanpa Pamrih',
                'slug' => 'meneguhkan-khidmah-guru-alumni-di-pelosok-desa-jejak-langkah-dakwah-tanpa-pamrih',
                'rubrik' => 'tulisan',
                'author_name' => 'Ustadzah Nur Hasanah, S.Pd.',
                'author_title' => 'Pendidik Madrasah Ibtidaiyah',
                'excerpt' => 'Mendidik tunas bangsa di madrasah pedesaan dengan semangat ikhlas beramal sebagaimana semboyan dan jati diri Pondok Pesantren Raudhatul Ulum Sakatiga.',
                'content' => '<p>Mengajar di madrasah ibtidaiyah pedesaan dengan segala keterbatasan sarana justru menghadirkan kedamaian batin yang luar biasa. Senyum polos anak-anak desa saat belajar membaca Al-Qur\'an dan menghafal doa harian adalah kebahagiaan sejati seorang pendidik.</p>
<p>Terima kasih kepada para kyai dan guru di Raudhatul Ulum Sakatiga yang telah meneladankan bahwa mengabdi untuk umat adalah kehormatan tertinggi bagi seorang santri.</p>',
                'featured_image' => '/uploads/official/drone-lingkungan-9941.webp',
                'is_featured' => false,
                'published_at' => '2024-03-22 15:40:00',
                'views_count' => 610,
            ],
        ];
    }

    /**
     * Seed or update all demo articles in the database.
     */
    public static function seedDemoArticles(): void
    {
        $ikarusCategory = Category::firstOrCreate(
            ['slug' => 'ikarus'],
            [
                'name' => 'IKARUS',
                'description' => 'Rubrik tulisan, opini, karya ilmiah, dan kabar kiprah Ikatan Keluarga Alumni Raudhatul Ulum (IKARUS) Sakatiga.',
                'is_active' => true,
            ]
        );

        $tagBerita = Tag::firstOrCreate(
            ['slug' => 'berita-ikarus'],
            ['name' => 'Berita IKARUS']
        );

        $tagTulisan = Tag::firstOrCreate(
            ['slug' => 'karya-alumni'],
            ['name' => 'Karya Alumni']
        );

        $author = User::where('role', 'admin')->first() ?? User::first();
        $authorId = $author ? $author->id : 1;

        foreach (self::getDemoArticles() as $data) {
            $publishedAt = Carbon::parse($data['published_at']);
            $isBerita = ($data['rubrik'] === 'berita');

            $post = Post::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'title' => $data['title'],
                    'author_name' => $data['author_name'],
                    'author_id' => $authorId,
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'featured_image' => $data['featured_image'],
                    'is_featured' => $data['is_featured'] ?? false,
                    'status' => 'publish',
                    'type' => 'post',
                    'views_count' => $data['views_count'] ?? 100,
                    'published_at' => $publishedAt,
                    'created_at' => $publishedAt,
                    'updated_at' => $publishedAt,
                ]
            );

            // Hubungkan kategori IKARUS
            $post->categories()->syncWithoutDetaching([$ikarusCategory->id]);

            // Hubungkan Tag jenis (Berita IKARUS / Karya Alumni)
            $tagId = $isBerita ? $tagBerita->id : $tagTulisan->id;
            $post->tags()->syncWithoutDetaching([$tagId]);
        }
    }

    /**
     * Ensure demo articles exist if the database has few or no IKARUS articles.
     */
    public static function seedIfEmpty(): void
    {
        $count = Post::where(function ($q) {
            $q->whereHas('categories', function ($catQ) {
                $catQ->where('slug', 'ikarus')
                    ->orWhere('name', 'like', '%ikarus%');
            })->orWhere('type', 'ikarus');
        })->count();

        if ($count < 6) {
            self::seedDemoArticles();
        }
    }

    /**
     * Find a demo article by slug, or create it if it belongs to the demo set.
     */
    public static function findOrCreateDemoArticle(string $slug): ?Post
    {
        $demos = self::getDemoArticles();
        $match = null;
        foreach ($demos as $demo) {
            if ($demo['slug'] === $slug) {
                $match = $demo;
                break;
            }
        }

        if (! $match) {
            return null;
        }

        self::seedDemoArticles();

        return Post::where('slug', $slug)->first();
    }
}
