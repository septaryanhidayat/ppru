<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Pembersihan Simbol AI (emdash '—' dan endash '–') pada seluruh data posts & settings
        DB::statement("UPDATE posts SET content = REPLACE(REPLACE(content, '—', ' - '), '–', '-'), excerpt = REPLACE(REPLACE(excerpt, '—', ' - '), '–', '-'), title = REPLACE(REPLACE(title, '—', ' - '), '–', '-')");
        DB::statement("UPDATE settings SET value = REPLACE(REPLACE(value, '—', ' - '), '–', '-')");

        // 2. Pastikan Kategori IKARUS Tersedia
        $ikarusCategory = Category::firstOrCreate(
            ['slug' => 'ikarus'],
            [
                'name' => 'IKARUS',
                'description' => 'Rubrik tulisan, opini, karya ilmiah, dan kabar kiprah Ikatan Keluarga Alumni Raudhatul Ulum (IKARUS) Sakatiga.',
                'is_active' => true,
            ]
        );

        $author = User::where('role', 'admin')->first() ?? User::first();
        $authorId = $author ? $author->id : 1;

        // 3. Sample Demo Data IKARUS (Lengkap, Realistis, & Elegan)
        $demoArticles = [
            [
                'title' => 'Kiprah Alumni MARU Menempuh Studi di Universitas Al-Azhar Kairo Mesir',
                'slug' => 'kiprah-alumni-maru-menempuh-studi-di-universitas-al-azhar-kairo-mesir',
                'author_name' => 'Ustadz Ahmad Farhan, Lc.',
                'excerpt' => 'Catatan inspiratif alumni Madrasah Aliyah Raudhatul Ulum Sakatiga yang kini menempuh studi sarjana Fakultas Ushuluddin di Universitas Al-Azhar Kairo, Mesir.',
                'content' => '<p><strong>Kairo, Mesir</strong> - Perjalanan menuntut ilmu ke negeri para anbiya adalah impian banyak santri di tanah air. Bagi kami para alumni Madrasah Aliyah Raudhatul Ulum (MARU) Sakatiga, bekal bahasa Arab fusha dan pemahaman dasar kitab turots yang dipelajari selama bertahun-tahun di asrama menjadi modal berharga saat pertama kali menginjakkan kaki di Universitas Al-Azhar Kairo.</p>
<p>Alhamdulillah, berkat piagam muadalah (penyetaraan ijazah) resmi yang telah lama terjalin antara Al-Azhar Asy-Syarif dengan Pondok Pesantren Raudhatul Ulum Sakatiga, proses administrasi dan adaptasi akademik santri alumni berjalan sangat lancar. Kami dapat langsung mengikuti perkuliahan dengan para masyayikh terkemuka di masjid Al-Azhar maupun ruang kuliah universitas.</p>
<p>Belajar di Raudhatul Ulum tidak hanya membentuk kecerdasan kognitif, tetapi juga adab, kedisiplinan asrama, serta mental kemandirian yang sangat terasa manfaatnya saat hidup di perantauan Kairo. Semoga estafet ini terus berlanjut bagi adik-adik santri generasi berikutnya.</p>',
                'featured_image' => '/uploads/official/kbm-santri-0098.webp',
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'Membangun Sinergi Ummat: Catatan Reuni Akbar dan Musyawarah Kerja IKARUS PPRU',
                'slug' => 'membangun-sinergi-ummat-catatan-reuni-akbar-dan-musyawarah-kerja-ikarus-ppru',
                'author_name' => 'H. Rahmat Hidayat, S.Pd.I.',
                'excerpt' => 'Konsolidasi alumni lintas generasi dari angkatan 1980 hingga 2025 dalam rangka merumuskan program beasiswa santri dan dakwah berkelanjutan.',
                'content' => '<p><strong>Sakatiga, Ogan Ilir</strong> - Pertemuan akbar ribuan alumni Pondok Pesantren Raudhatul Ulum Sakatiga dari berbagai penjuru nusantara dan mancanegara menjadi momentum kebangkitan sinergi keummatan. Dalam musyawarah kerja tahunan ini, disepakati pembentukan program dana abadi alumni untuk beasiswa santri berprestasi dan yatim piatu dhuafa.</p>
<p>Mudir PPRU dalam arahannya mengingatkan bahwa kekuatan sebuah almamater pesantren tercermin dari seberapa besar kebermanfaatan para alumninya di tengah masyarakat. Keberadaan wadah IKARUS diharapkan semakin memperkokoh ukhuwah islamiyah dan kontribusi nyata dalam bidang dakwah, pendidikan, sosial, dan ekonomi umat.</p>',
                'featured_image' => '/uploads/official/drone-raudhatul-ulum.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Pengabdian Dokter Alumni PPRU di Pelosok Nusantara: Nilai Keikhlasan Menjadi Bekal Utama',
                'slug' => 'pengabdian-dokter-alumni-ppru-di-pelosok-nusantara-nilai-keikhlasan-menjadi-bekal-utama',
                'author_name' => 'dr. M. Ridho Pratama',
                'excerpt' => 'Kisah alumni SMAIT Raudhatul Ulum yang berkhidmah melayani kesehatan masyarakat pedalaman di perbatasan, membawa nilai akhlakul karimah pesantren.',
                'content' => '<p>Menjalani profesi medis di wilayah pedalaman dengan keterbatasan fasilitas medis menuntut lebih dari sekadar keahlian ilmu kedokteran; ia membutuhkan keikhlasan, kesabaran, dan empati kemanusiaan yang mendalam.</p>
<p>Nilai-nilai keikhlasan dan ketangguhan hidup yang ditanamkan selama menjadi santri di Raudhatul Ulum Sakatiga menjadi pegangan teguh dalam melayani masyarakat setiap hari. Pesantren mengajarkan kami bahwa ilmu apa pun yang kita miliki sejatinya adalah sarana ibadah dan pengabdian lillahi ta\'ala.</p>',
                'featured_image' => '/uploads/official/upacara-santri-4680.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(8),
            ],
            [
                'title' => 'Menjaga Tradisi Literasi Turots Kitab Kuning bagi Santri di Tengah Disrupsi Era Digital',
                'slug' => 'menjaga-tradisi-literasi-turots-kitab-kuning-bagi-santri-di-tengah-disrupsi-era-digital',
                'author_name' => 'Ustadz Syamsuddin, M.Ag.',
                'excerpt' => 'Refleksi intelektual santri alumni tentang urgensi sanad keilmuan dan metodologi kajian kitab klasik para ulama salafush sholih.',
                'content' => '<p>Di tengah banjir informasi digital dan maraknya rujukan instan di internet, tradisi literasi turots kitab kuning yang diajarkan di pondok pesantren memiliki nilai otentisitas yang tak tergantikan. Mempelajari kitab kuning bukan sekadar memahami teks gramatika nahwu dan shorof, melainkan menyerap adab talaqqi dan sanad keilmuan yang bersambung hingga Rasulullah SAW.</p>
<p>Sebagai alumni, kami mengapresiasi komitmen PPRU Sakatiga yang senantiasa mempertahankan kurikulum kajian kitab mu\'tabar sebagai salah satu pilar utama trisula keunggulan pesantren.</p>',
                'featured_image' => '/uploads/official/ngaji-sore.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(12),
            ],
            [
                'title' => 'Kisah Sukses Pengusaha Muda Alumni Raudhatul Ulum: Membangun Kemandirian Ekonomi Berbasis Nilai Islam',
                'slug' => 'kisah-sukses-pengusaha-muda-alumni-raudhatul-ulum-membangun-kemandirian-ekonomi-berbasis-nilai-islam',
                'author_name' => 'Hendra Wijaya, S.E.',
                'excerpt' => 'Menerapkan prinsip Qadirun alal Kasbi (mandiri dalam berusaha) yang ditanamkan sejak di asrama pondok hingga sukses merintis jejaring bisnis nasional.',
                'content' => '<p>Prinsip kemandirian ekonomi atau Qadirun \'alal Kasbi adalah salah satu dari 10 Jati Diri Santri yang selalu ditekankan oleh para asatidz di Raudhatul Ulum. Berawal dari pengalaman berorganisasi di Organisasi Santri Raudhatul Ulum (OSRU) dan mengelola koperasi santri, benih kewirausahaan itu tumbuh subur.</p>
<p>Kini, dengan izin Allah SWT, jaringan usaha yang kami rintis dapat membuka lapangan kerja bagi ratusan karyawan serta menjadi mitra pengadaan bagi berbagai pondok pesantren di wilayah Sumatera Selatan.</p>',
                'featured_image' => '/uploads/official/drone-danau-telok-putih.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(16),
            ],
            [
                'title' => 'Kiat Sukses Lolos Seleksi Universitas Islam Madinah: Berbagi Pengalaman untuk Santri Kelas Akhir',
                'slug' => 'kiat-sukses-lolos-seleksi-universitas-islam-madinah-berbagi-pengalaman-untuk-santri-kelas-akhir',
                'author_name' => 'Ustadz Zulkifli, Lc.',
                'excerpt' => 'Panduan persiapan berkas, penguatan tahfidzul Qur\'an mutqin, serta tips wawancara bahasa Arab bagi calon pendaftar beasiswa perguruan tinggi luar negeri.',
                'content' => '<p>Bagi santri MARU dan SMAIT Raudhatul Ulum yang bercita-cita menimba ilmu syar\'i di Kota Nabi, Universitas Islam Madinah (UIM) menawarkan kesempatan emas. Kunci utama keberhasilan seleksi terletak pada penguasaan hafalan Al-Qur\'an yang mutqin, kelancaran berbahasa Arab aktif saat muqabalah (wawancara), serta integritas transkrip nilai akademik.</p>
<p>Melalui tulisan ini, kami membagikan panduan teknis langkah demi langkah mulai dari legalisasi dokumen, penyusunan surat rekomendasi asatidz, hingga kiat menjawab pertanyaan penguji muqabalah.</p>',
                'featured_image' => '/uploads/official/kbm-santri-0152.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Transformasi Digital Pesantren: Perspektif Alumni Pengembang Teknologi Asal Sakatiga',
                'slug' => 'transformasi-digital-pesantren-perspektif-alumni-pengembang-teknologi-asal-sakatiga',
                'author_name' => 'Fajar Nugroho, S.Kom.',
                'excerpt' => 'Bagaimana santri modern memanfaatkan kecakapan teknologi informasi untuk syiar dakwah bil qalam dan pengembangan sistem informasi manajemen pondok.',
                'content' => '<p>Santri abad 21 dituntut tidak hanya menguasai khazanah keagamaan, namun juga fasih memanfaatkan perangkat teknologi digital sebagai wasilah dakwah. Pengembangan portal resmi, sistem informasi akademik, dan arsip digital pesantren merupakan wujud nyata kontribusi keilmuan alumni dalam memajukan almamater.</p>
<p>Komunitas Alumni IT Raudhatul Ulum siap mendampingi adik-adik santri dalam pelatihan coding, desain multimedia, dan literasi keamanan digital.</p>',
                'featured_image' => '/uploads/official/kegiatan-santri-waw1985.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(25),
            ],
            [
                'title' => 'Meneguhkan Khidmah Guru Alumni di Pelosok Desa: Jejak Langkah Dakwah Tanpa Pamrih',
                'slug' => 'meneguhkan-khidmah-guru-alumni-di-pelosok-desa-jejak-langkah-dakwah-tanpa-pamrih',
                'author_name' => 'Ustadzah Nur Hasanah, S.Pd.',
                'excerpt' => 'Mendidik tunas bangsa di madrasah pedesaan dengan semangat ikhlas beramal sebagaimana semboyan dan jati diri Pondok Pesantren Raudhatul Ulum Sakatiga.',
                'content' => '<p>Mengajar di madrasah ibtidaiyah pedesaan dengan segala keterbatasan sarana justru menghadirkan kedamaian batin yang luar biasa. Senyum polos anak-anak desa saat belajar membaca Al-Qur\'an dan menghafal doa harian adalah kebahagiaan sejati seorang pendidik.</p>
<p>Terima kasih kepada para kyai dan guru di Raudhatul Ulum Sakatiga yang telah meneladankan bahwa mengabdi untuk umat adalah kehormatan tertinggi bagi seorang santri.</p>',
                'featured_image' => '/uploads/official/drone-lingkungan-9941.webp',
                'is_featured' => false,
                'published_at' => now()->subDays(30),
            ],
        ];

        foreach ($demoArticles as $item) {
            $post = Post::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'author_name' => $item['author_name'],
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'featured_image' => $item['featured_image'],
                    'is_featured' => $item['is_featured'],
                    'published_at' => $item['published_at'],
                    'status' => 'publish',
                    'type' => 'ikarus',
                    'author_id' => $authorId,
                    'views_count' => rand(150, 850),
                ]
            );

            // Hubungkan dengan Kategori IKARUS
            if (! $post->categories()->where('categories.id', $ikarusCategory->id)->exists()) {
                $post->categories()->attach($ikarusCategory->id);
            }
        }
    }

    public function down(): void
    {
        // Biarkan data tetap ada
    }
};
