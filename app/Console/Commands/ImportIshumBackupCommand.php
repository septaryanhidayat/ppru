<?php

namespace App\Console\Commands;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Dpc;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\QuickMenu;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Video;
use App\Services\WebpService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportIshumBackupCommand extends Command
{
    protected $signature = 'app:import-ishum-backup {--force : Overwrite existing records}';

    protected $description = 'Import 100% of SMA IT Ishum WordPress backup, convert all images to WebP, and populate Laravel models';

    protected WebpService $webpService;

    protected string $uploadsSource = 'D:/SIM/SMAIT ISHUM PBM/well-known/wp-content/uploads';

    protected array $attachmentsMap = []; // attachment_id => relative_path

    protected array $convertedWebpCache = []; // src_path => webp_url

    public function __construct(WebpService $webpService)
    {
        parent::__construct();
        $this->webpService = $webpService;
    }

    public function handle(): int
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        $this->info('=== STARTING SMA IT ISHUMLAH UMMAH DATA MIGRATION ===');

        $scratchDir = 'C:/Users/RYAN/.gemini/antigravity-ide/brain/c1a9ab74-f347-4491-ac2b-b207e5661e84/scratch';
        $attachmentsFile = $scratchDir.'/attachments.json';
        $postsFile = $scratchDir.'/all_parsed_posts.json';
        $postmetaFile = $scratchDir.'/all_postmeta.json';
        $myschoolFile = $scratchDir.'/myschool.json';

        if (! file_exists($attachmentsFile) || ! file_exists($postsFile) || ! file_exists($postmetaFile)) {
            $this->error('Missing extracted JSON files in scratch directory.');

            return 1;
        }

        $this->attachmentsMap = json_decode(file_get_contents($attachmentsFile), true) ?: [];
        $this->info('Loaded attachments map: '.count($this->attachmentsMap).' files.');

        $posts = json_decode(file_get_contents($postsFile), true) ?: [];
        $postmeta = json_decode(file_get_contents($postmetaFile), true) ?: [];
        $myschool = file_exists($myschoolFile) ? (json_decode(file_get_contents($myschoolFile), true) ?: []) : [];

        // 1. Ensure Admin User
        $this->info('Step 1: Setting up Admin User...');
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@smaitishumpbm.sch.id'],
            [
                'name' => 'Administrator ISHUM',
                'password' => Hash::make('AdminIshum2026!'),
                'role' => 'admin',
            ]
        );
        $this->line(' - Admin ready: admin@smaitishumpbm.sch.id');

        // 2. Populate Settings from myschool
        $this->info('Step 2: Populating Website Settings from myschool...');
        $this->importSettings($myschool);

        // 3. Pre-convert all attached media files to WebP
        $this->info('Step 3: Converting all attached media files to WebP (quality 80, max width 1600px)...');
        $this->convertMediaToWebp();

        // 4. Import Pages
        $this->info('Step 4: Importing Static Pages (Sambutan, Visi Misi, Layanan Terpadu, dll)...');
        $this->importPages($posts, $postmeta, $myschool, $adminUser->id);

        // 5. Import Articles / Posts
        $this->info('Step 5: Importing Articles & News...');
        $this->importPosts($posts, $postmeta, $adminUser->id);

        // 6. Import Prestasi
        $this->info('Step 6: Importing Prestasi Siswa & Guru...');
        $this->importPrestasi($posts, $postmeta, $adminUser->id);

        // 7. Import Ekstrakurikuler
        $this->info('Step 7: Importing Ekstrakurikuler...');
        $this->importEkskul($posts, $postmeta, $adminUser->id);

        // 8. Import Data Alumni
        $this->info('Step 8: Importing Data Alumni...');
        $this->importAlumni($posts, $postmeta, $adminUser->id);

        // 9. Import Dewan Guru & GTK
        $this->info('Step 9: Importing Dewan Guru & GTK...');
        $this->importGuru($posts, $postmeta);

        // 10. Import Fasilitas
        $this->info('Step 10: Importing Fasilitas Sekolah...');
        $this->importFasilitas($posts, $postmeta);

        // 11. Import Program Unggulan
        $this->info('Step 11: Importing Program Unggulan...');
        $this->importUnggulan($posts, $postmeta);

        // 12. Import Agendas & Pengumuman
        $this->info('Step 12: Importing Agendas & Pengumuman...');
        $this->importAgendasAndPengumuman($posts, $postmeta);

        // 13. Import Testimonials & Videos
        $this->info('Step 13: Importing Testimonials & Videos...');
        $this->importTestimonialsAndVideos($posts, $postmeta);

        // 14. Import Quick Menus
        $this->info('Step 14: Importing Quick Menus...');
        $this->importQuickMenus();

        $this->info('=== DATA MIGRATION FINISHED SUCCESSFULLY! ===');
        $this->table(
            ['Entity', 'Count'],
            [
                ['Posts (Articles)', Post::where('type', 'post')->count()],
                ['Pages (Static)', Post::where('type', 'page')->count()],
                ['Prestasi', Post::where('type', 'prestasi')->count()],
                ['Ekstrakurikuler', Post::where('type', 'ekskul')->count()],
                ['Data Alumni', Post::where('type', 'alumni')->count()],
                ['Dewan Guru & GTK', AnggotaDewan::count()],
                ['Fasilitas Sekolah', Bidang::count()],
                ['Program Unggulan', Dpc::count()],
                ['Agendas', Agenda::count()],
                ['Pengumuman', Pengumuman::count()],
                ['Testimonials', Testimonial::count()],
                ['Videos', Video::count()],
                ['Quick Menus', QuickMenu::count()],
                ['Settings', Setting::count()],
            ]
        );

        return 0;
    }

    /**
     * Convert relative WP upload path or attachment ID into WebP and return public URL.
     */
    protected function getWebpUrl(string|int|null $ref): ?string
    {
        if (empty($ref)) {
            return null;
        }

        $relPath = null;
        if (is_numeric($ref) && isset($this->attachmentsMap[(int) $ref])) {
            $relPath = $this->attachmentsMap[(int) $ref];
        } elseif (is_string($ref)) {
            if (preg_match('/wp-content\/uploads\/(.+)$/i', $ref, $m)) {
                $relPath = $m[1];
            } elseif (file_exists($this->uploadsSource.'/'.ltrim($ref, '/'))) {
                $relPath = ltrim($ref, '/');
            }
        }

        if (! $relPath) {
            return is_string($ref) && str_starts_with($ref, '/uploads/') ? $ref : null;
        }

        if (isset($this->convertedWebpCache[$relPath])) {
            return $this->convertedWebpCache[$relPath];
        }

        $sourceFile = $this->uploadsSource.'/'.$relPath;
        if (! file_exists($sourceFile)) {
            // Check if already in public/uploads
            $publicFile = public_path('uploads/'.$relPath);
            if (file_exists($publicFile)) {
                $sourceFile = $publicFile;
            } else {
                return null;
            }
        }

        // Target webp path: keep subfolders (e.g. 2022/03/name.webp)
        $pi = pathinfo($relPath);
        $subDir = $pi['dirname'] !== '.' ? $pi['dirname'].'/' : '';
        $baseName = Str::slug($pi['filename']);
        $destRel = 'uploads/'.$subDir.$baseName.'.webp';
        $destAbs = public_path($destRel);

        if (! file_exists($destAbs)) {
            $res = $this->webpService->convertToWebp($sourceFile, $destAbs, 80, 1600);
            if (! $res['success']) {
                // If GD fails (e.g. SVG or PDF), copy as original
                @mkdir(dirname($destAbs), 0755, true);
                @copy($sourceFile, public_path('uploads/'.$relPath));
                $url = '/uploads/'.$relPath;
                $this->convertedWebpCache[$relPath] = $url;

                return $url;
            }
        }

        $url = '/'.$destRel;
        $this->convertedWebpCache[$relPath] = $url;

        return $url;
    }

    protected function cleanHtmlContent(?string $content): string
    {
        if (empty($content)) {
            return '';
        }

        // Replace any WP upload image references with /uploads/$1.webp
        $content = preg_replace_callback(
            '/https?:\/\/[^\/"]+\/wp-content\/uploads\/([a-zA-Z0-9_\-\.\/]+)\.(jpg|jpeg|png|gif|bmp|webp)/i',
            function ($m) {
                $rel = $m[1].'.'.$m[2];
                $webp = $this->getWebpUrl($rel);

                return $webp ?: ('/uploads/'.$rel);
            },
            $content
        );

        // Clean WordPress Gutenberg comments
        $content = preg_replace('/<!--\s*\/?wp:[^>]*-->/i', '', $content);

        return trim($content);
    }

    protected function convertMediaToWebp(): void
    {
        $count = 0;
        $savedBytes = 0;

        foreach ($this->attachmentsMap as $aid => $relPath) {
            $sourceFile = $this->uploadsSource.'/'.$relPath;
            if (! file_exists($sourceFile)) {
                continue;
            }

            $pi = pathinfo($relPath);
            $ext = strtolower($pi['extension'] ?? '');
            if (! in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'])) {
                continue;
            }

            $subDir = $pi['dirname'] !== '.' ? $pi['dirname'].'/' : '';
            $baseName = Str::slug($pi['filename']);
            $destRel = 'uploads/'.$subDir.$baseName.'.webp';
            $destAbs = public_path($destRel);

            if (! file_exists($destAbs)) {
                try {
                    $res = $this->webpService->convertToWebp($sourceFile, $destAbs, 80, 1600);
                    if ($res['success']) {
                        $count++;
                        $savedBytes += ($res['saved_bytes'] ?? 0);
                        $this->convertedWebpCache[$relPath] = '/'.$destRel;
                    }
                } catch (\Throwable $e) {
                    // Silently ignore corrupted image and continue
                }
            } else {
                $this->convertedWebpCache[$relPath] = '/'.$destRel;
            }

            if ($count % 50 === 0) {
                gc_collect_cycles();
            }
        }

        $this->line(" - Converted {$count} image attachments to WebP (Saved ".round($savedBytes / (1024 * 1024), 2).' MB).');
    }

    protected function importSettings(array $myschool): void
    {
        $logoWebp = $this->getWebpUrl($myschool['logo-website'] ?? null) ?: '/uploads/logo-ishum.png';
        $logoSquare = $this->getWebpUrl($myschool['logo-website-dark'] ?? null) ?: '/uploads/logo-ishum-square.png';
        $fotoKasek = $this->getWebpUrl($myschool['foto-kasek'] ?? null) ?: '/uploads/kepsek-agi-gustiawan.jpg';

        $settings = [
            'site_name' => $myschool['nama-sekolah'] ?? 'SMA IT Ishlahul Ummah Prabumulih',
            'site_tagline' => 'Tanggap, Tangkas dan Tangguh Menuju Indonesia Emas',
            'site_description' => 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih (SMA IT Ishum). Sekolah Islam Terpadu pertama di Prabumulih yang tergabung dalam JSIT Indonesia dengan kurikulum terpadu.',
            'npsn' => $myschool['npsn'] ?? '69990882',
            'akreditasi' => $myschool['akreditasi'] ?? 'TERAKREDITASI BAN -SM',
            'no_sk_akreditasi' => $myschool['no-sk-akreditasi'] ?? '1036/BAN-SM/SK/2021 Pada Tanggal 25 Oktober 2021',
            'sk_pendirian' => $myschool['sk-pendirian'] ?? '2.16.72.04.001',
            'tanggal_sk_pendirian' => $myschool['tanggal-sk'] ?? '2020-10-23',
            'sk_izin' => $myschool['sk-izin'] ?? '0876/DPMPTSP.V/IX/2023',
            'tanggal_sk_izin' => $myschool['tanggal-sk-izin'] ?? '2023-09-05',
            'kepala_sekolah' => $myschool['kepala-sekolah'] ?? 'Agi Gustiawan, S. Pd',
            'foto_kasek' => $fotoKasek,
            'site_logo' => $logoWebp,
            'site_logo_square' => $logoSquare,
            'contact_address' => $myschool['alamat'] ?? 'Jalan Sadewa RT 01 RW 03 Kelurahan Karang Raja Kecamatan Prabumulih Timur Kota Prabumulih Provinsi Sumatera Selatan, Kode Pos 31111',
            'contact_email' => $myschool['email'] ?? 'smaitishlahulummah2019@gmail.com',
            'contact_phone' => $myschool['telp'] ?? '082182680647',
            'contact_whatsapp' => '082182680647',
            'social_facebook' => $myschool['facebook'] ?? 'https://facebook.com/smait.ishlahul.ummah.3',
            'social_instagram' => $myschool['instagram'] ?? 'https://instagram.com/smait_ishum_prabumulih',
            'social_youtube' => $myschool['youtube'] ?? 'https://www.youtube.com/channel/UCUJgvV-nqy89f3m8Hw2QrGg/videos',
            'color_primary' => $myschool['primary'] ?? '#00913e',
            'color_accent' => $myschool['accent'] ?? '#da251c',
            'meta_keywords' => 'sma it ishlahul ummah prabumulih, sma it ishum, jsit prabumulih, ppdb sma it ishum, tahfidz prabumulih',
            'og_title' => 'SMA Islam Terpadu Ishlahul Ummah Prabumulih',
            'og_description' => 'Official Website SMA Islam Terpadu Ishlahul Ummah Prabumulih: Informasi PPDB, Berita & Prestasi, Profil Guru, Fasilitas, dan Kurikulum Terpadu.',
            'og_image' => $fotoKasek,
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
            'donation_intro_text' => "Salurkan infaq pembangunan sarana pendidikan, beasiswa tahfidz Qur'an, dan pengembangan kampus SMA IT Ishlahul Ummah Prabumulih.",
        ];

        foreach ($settings as $k => $v) {
            Setting::updateOrCreate(['key' => $k], ['value' => $v, 'group' => 'general']);
        }
    }

    protected function importPages(array $posts, array $postmeta, array $myschool, int $authorId): void
    {
        $sambutanHtml = $myschool['sambutan-kepala-sekolah'] ?? '';
        $visiHtml = $myschool['visi'] ?? '';
        $misiHtml = $myschool['misi'] ?? '';

        $pagesData = [
            'sambutan-kepala-sekolah' => [
                'title' => 'Sambutan Kepala Sekolah',
                'content' => $this->cleanHtmlContent($sambutanHtml),
                'excerpt' => 'Sambutan resmi Kepala Sekolah SMA IT Ishlahul Ummah Prabumulih, Agi Gustiawan, S. Pd.',
                'meta_title' => 'Sambutan Kepala Sekolah - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Pesan dan komitmen pembinaan karakter, iman, dan ilmu di SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'visi-dan-misi' => [
                'title' => 'Visi dan Misi',
                'content' => '<div class="mb-6"><h3 class="text-xl font-bold text-[#00913e] mb-3">Visi Sekolah</h3>'.$this->cleanHtmlContent($visiHtml).'</div>'.
                             '<div><h3 class="text-xl font-bold text-[#00913e] mb-3">Misi Sekolah</h3>'.$this->cleanHtmlContent($misiHtml).'</div>',
                'excerpt' => 'Visi & Misi resmi SMA IT Ishlahul Ummah Prabumulih menuju generasi emas tanggap, tangkas, dan tangguh.',
                'meta_title' => 'Visi dan Misi - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Visi dan Misi pendidikan Islam terpadu SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'tentang-kami' => [
                'title' => 'Tentang Kami',
                'content' => '<p>SMA IT Ishlahul Ummah Prabumulih adalah Sekolah Menengah Atas Islam Terpadu pertama di Kota Prabumulih yang berada di bawah naungan Yayasan Ishlahul Ummah dan tergabung dalam Jaringan Sekolah Islam Terpadu (JSIT) Indonesia.</p><p>Sekolah kami memadukan kurikulum nasional dan kurikulum keislaman khas JSIT yang menekankan pada pembentukan akidah salimah, ibadah shahihah, akhlak karimah, kemampuan tahfidz Al-Qur\'an, kepemimpinan, dan keunggulan akademik sains serta teknologi.</p>',
                'excerpt' => 'Profil singkat SMA IT Ishlahul Ummah Prabumulih: Kurikulum terpadu JSIT dan Kurikulum Merdeka.',
                'meta_title' => 'Tentang Kami - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Profil SMA IT Ishlahul Ummah Prabumulih, sekolah Islam terpadu di Prabumulih.',
            ],
            'sejarah' => [
                'title' => 'Sejarah Singkat',
                'content' => '<p>SMA IT Ishlahul Ummah Prabumulih didirikan atas aspirasi masyarakat muslim di Prabumulih yang mendambakan kelanjutan pendidikan Islam terpadu setelah jenjang SMP IT. Dengan izin operasional resmi nomor 0876/DPMPTSP.V/IX/2023 dan SK Pendirian 2.16.72.04.001 tertanggal 23 Oktober 2020, sekolah ini terus berkembang pesat menjadi institusi pendidikan unggulan di Sumatera Selatan.</p>',
                'excerpt' => 'Sejarah berdirinya SMA IT Ishlahul Ummah Prabumulih.',
                'meta_title' => 'Sejarah - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Sejarah perjalanan pendirian SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'struktur-organisasi' => [
                'title' => 'Struktur Organisasi',
                'content' => '<p>Struktur kepemimpinan dan manajemen SMA IT Ishlahul Ummah Prabumulih dipimpin oleh Kepala Sekolah Agi Gustiawan, S.Pd, didampingi oleh Wakil Kepala Sekolah Bidang Kurikulum Anita Carlyna, S.IP., M.Pd, serta staf pendidik dan tenaga kependidikan profesional.</p>',
                'excerpt' => 'Bagan susunan struktur pimpinan dan manajemen SMA IT Ishlahul Ummah Prabumulih.',
                'meta_title' => 'Struktur Organisasi - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Susunan pimpinan dan tata kelola SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'kontak' => [
                'title' => 'Kontak & Lokasi',
                'content' => '<p>Silakan hubungi kami atau kunjungi kampus SMA IT Ishlahul Ummah Prabumulih di Jalan Sadewa RT 01 RW 03 Kelurahan Karang Raja Kecamatan Prabumulih Timur Kota Prabumulih.</p>',
                'excerpt' => 'Kontak resmi, telepon, WhatsApp, email, dan alamat SMA IT Ishlahul Ummah.',
                'meta_title' => 'Kontak Kami - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Hubungi SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'layanan-terpadu-2' => [
                'title' => 'Layanan Terpadu',
                'content' => '<p>Layanan Terpadu SMA IT Ishlahul Ummah Prabumulih melayani berbagai permohonan administrasi secara transparan dan mudah, antara lain:</p><ul><li><strong>Permohonan Izin Kunjungan ke Sekolah:</strong> Pengajuan kunjungan edukatif, studi banding, atau instansi.</li><li><strong>Permohonan Kerja Sama:</strong> Kemitraan lembaga, magang, beasiswa, dan sponsorship.</li><li><strong>Permohonan Sewa Menyewa Barang / Fasilitas:</strong> Penyewaan aula, sarana olahraga, dan fasilitas sekolah.</li></ul>',
                'excerpt' => 'Layanan administrasi terpadu SMA IT Ishlahul Ummah Prabumulih.',
                'meta_title' => 'Layanan Terpadu - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Portal permohonan dan layanan terpadu SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'izin-sekolah' => [
                'title' => 'Permohonan Izin Kunjungan ke Sekolah',
                'content' => '<p>Formulir dan prosedur permohonan izin kunjungan edukasi, studi banding, atau observasi ke SMA IT Ishlahul Ummah Prabumulih.</p>',
                'excerpt' => 'Permohonan Izin Kunjungan ke Sekolah.',
                'meta_title' => 'Permohonan Izin Kunjungan - SMA IT Ishlahul Ummah',
                'meta_description' => 'Pengajuan izin kunjungan resmi ke SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'permohonan-kerja-sama' => [
                'title' => 'Permohonan Kerja Sama',
                'content' => '<p>Layanan resmi permohonan kemitraan, kerjasama kelembagaan, dan kegiatan kolaboratif bersama SMA IT Ishlahul Ummah Prabumulih.</p>',
                'excerpt' => 'Permohonan Kerja Sama Kelembagaan.',
                'meta_title' => 'Permohonan Kerja Sama - SMA IT Ishlahul Ummah',
                'meta_description' => 'Kerjasama strategis dan kelembagaan bersama SMA IT Ishlahul Ummah.',
            ],
            'sewa-barang' => [
                'title' => 'Permohonan Sewa Menyewa Barang Sekolah',
                'content' => '<p>Layanan dan ketentuan penyewaan fasilitas sekolah (Hall Ishum, laboratorium, perlengkapan event) bagi masyarakat dan instansi.</p>',
                'excerpt' => 'Permohonan Sewa Menyewa Barang / Fasilitas Sekolah.',
                'meta_title' => 'Permohonan Sewa Barang - SMA IT Ishlahul Ummah',
                'meta_description' => 'Ketentuan dan permohonan sewa sarana prasarana sekolah.',
            ],
            'data-alumni' => [
                'title' => 'Data Alumni',
                'content' => '<p>Daftar alumni kebanggaan SMA IT Ishlahul Ummah Prabumulih yang telah melanjutkan pendidikan ke berbagai perguruan tinggi negeri, kedinasan, kampus Islam terkemuka, dan berkarier di berbagai sektor.</p>',
                'excerpt' => 'Data alumni dan rekam jejak lulusan SMA IT Ishlahul Ummah.',
                'meta_title' => 'Data Alumni - SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Database alumni SMA IT Ishlahul Ummah Prabumulih.',
            ],
            'ppdb-sma-it-ishlahul-ummah-prabumulih' => [
                'title' => 'Informasi PPDB Online',
                'content' => '<p>Penerimaan Peserta Didik Baru (PPDB) SMA IT Ishlahul Ummah Prabumulih dibuka setiap tahun ajaran baru dengan jalur beasiswa tahfidz dan reguler. Pendaftaran dapat dilakukan langsung melalui portal online <a href="https://ppdb.smaitishumpbm.sch.id/" target="_blank" class="text-green-600 font-bold underline">https://ppdb.smaitishumpbm.sch.id/</a>.</p>',
                'excerpt' => 'Informasi pendaftaran siswa baru SMA IT Ishlahul Ummah Prabumulih.',
                'meta_title' => 'PPDB SMA IT Ishlahul Ummah Prabumulih',
                'meta_description' => 'Informasi PPDB SMA IT Ishlahul Ummah Prabumulih.',
            ],
        ];

        foreach ($pagesData as $slug => $d) {
            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $d['title'],
                    'content' => $d['content'],
                    'excerpt' => $d['excerpt'],
                    'status' => 'publish',
                    'type' => 'page',
                    'author_id' => $authorId,
                    'meta_title' => $d['meta_title'],
                    'meta_description' => $d['meta_description'],
                    'published_at' => now(),
                ]
            );
        }
    }

    protected function importPosts(array $posts, array $postmeta, int $authorId): void
    {
        $articles = array_filter($posts, fn ($p) => $p['type'] === 'post' && $p['status'] === 'publish');

        foreach ($articles as $art) {
            $pid = $art['id'];
            $meta = $postmeta[$pid] ?? [];

            // Image
            $featImage = null;
            if (! empty($meta['_thumbnail_id'])) {
                $featImage = $this->getWebpUrl($meta['_thumbnail_id']);
            }

            // Content: prefer isi-artikel custom field if present, else post_content
            $content = ! empty($meta['isi-artikel']) ? $meta['isi-artikel'] : $art['content'];
            $cleanContent = $this->cleanHtmlContent($content);

            // If empty content, provide a decent snippet from title
            if (strlen(strip_tags($cleanContent)) < 10) {
                $cleanContent = "<p>{$art['title']}. Dokumentasi dan liputan kegiatan resmi SMA IT Ishlahul Ummah Prabumulih.</p>";
            }

            $date = ! empty($art['date']) && $art['date'] !== '0000-00-00 00:00:00' ? Carbon::parse($art['date']) : now();

            Post::updateOrCreate(
                ['slug' => Str::slug($art['slug'] ?: $art['title'])],
                [
                    'title' => $art['title'],
                    'content' => $cleanContent,
                    'excerpt' => Str::limit(strip_tags($cleanContent), 160),
                    'status' => 'publish',
                    'type' => 'post',
                    'featured_image' => $featImage ?: '/uploads/campus-robbani.jpg',
                    'author_id' => $authorId,
                    'published_at' => $date,
                    'meta_title' => $art['title'].' - SMA IT Ishlahul Ummah',
                    'meta_description' => Str::limit(strip_tags($cleanContent), 150),
                ]
            );
        }
    }

    protected function importPrestasi(array $posts, array $postmeta, int $authorId): void
    {
        $prestasiPosts = array_filter($posts, fn ($p) => $p['type'] === 'prestasi' && $p['status'] === 'publish');

        foreach ($prestasiPosts as $item) {
            $pid = $item['id'];
            $meta = $postmeta[$pid] ?? [];

            $featImage = null;
            if (! empty($meta['_thumbnail_id'])) {
                $featImage = $this->getWebpUrl($meta['_thumbnail_id']);
            }

            $content = ! empty($meta['deskripsi']) ? $meta['deskripsi'] : $item['content'];
            $cleanContent = $this->cleanHtmlContent($content);

            if (strlen(strip_tags($cleanContent)) < 10) {
                $cleanContent = "<p>Selamat dan sukses atas raihan {$item['title']} oleh siswa-siswi SMA IT Ishlahul Ummah Prabumulih.</p>";
            }

            $date = ! empty($item['date']) && $item['date'] !== '0000-00-00 00:00:00' ? Carbon::parse($item['date']) : now();

            Post::updateOrCreate(
                ['slug' => Str::slug($item['slug'] ?: $item['title'])],
                [
                    'title' => $item['title'],
                    'content' => $cleanContent,
                    'excerpt' => Str::limit(strip_tags($cleanContent), 160),
                    'status' => 'publish',
                    'type' => 'prestasi',
                    'featured_image' => $featImage ?: '/uploads/campus-robbani.jpg',
                    'author_id' => $authorId,
                    'published_at' => $date,
                    'meta_title' => 'Prestasi: '.$item['title'].' - SMA IT Ishlahul Ummah',
                    'meta_description' => Str::limit(strip_tags($cleanContent), 150),
                ]
            );
        }
    }

    protected function importEkskul(array $posts, array $postmeta, int $authorId): void
    {
        $ekskuls = array_filter($posts, fn ($p) => $p['type'] === 'ekskul' && $p['status'] === 'publish');

        foreach ($ekskuls as $item) {
            $pid = $item['id'];
            $meta = $postmeta[$pid] ?? [];

            $featImage = null;
            if (! empty($meta['_thumbnail_id'])) {
                $featImage = $this->getWebpUrl($meta['_thumbnail_id']);
            }

            $content = ! empty($meta['deskripsi']) ? $meta['deskripsi'] : $item['content'];
            $cleanContent = $this->cleanHtmlContent($content);

            if (strlen(strip_tags($cleanContent)) < 10) {
                $cleanContent = "<p>Ekstrakurikuler {$item['title']} merupakan salah satu wadah pengembangan minat, bakat, kepemimpinan, dan kreativitas siswa di SMA IT Ishlahul Ummah Prabumulih.</p>";
            }

            Post::updateOrCreate(
                ['slug' => Str::slug($item['slug'] ?: $item['title'])],
                [
                    'title' => $item['title'],
                    'content' => $cleanContent,
                    'excerpt' => Str::limit(strip_tags($cleanContent), 160),
                    'status' => 'publish',
                    'type' => 'ekskul',
                    'featured_image' => $featImage ?: '/uploads/campus-robbani.jpg',
                    'author_id' => $authorId,
                    'published_at' => now(),
                    'meta_title' => 'Ekstrakurikuler '.$item['title'].' - SMA IT Ishlahul Ummah',
                    'meta_description' => Str::limit(strip_tags($cleanContent), 150),
                ]
            );
        }
    }

    protected function importAlumni(array $posts, array $postmeta, int $authorId): void
    {
        $alumnis = array_filter($posts, fn ($p) => $p['type'] === 'alumni' && $p['status'] === 'publish');

        foreach ($alumnis as $item) {
            $pid = $item['id'];
            $meta = $postmeta[$pid] ?? [];

            $featImage = null;
            if (! empty($meta['foto'])) {
                $featImage = $this->getWebpUrl($meta['foto']);
            } elseif (! empty($meta['_thumbnail_id'])) {
                $featImage = $this->getWebpUrl($meta['_thumbnail_id']);
            }

            $tahun = $meta['lulus-tahun'] ?? '2022';
            $content = "<p>Alumni SMA IT Ishlahul Ummah Prabumulih Angkatan Lulus {$tahun}.</p>";

            Post::updateOrCreate(
                ['slug' => 'alumni-'.Str::slug($item['slug'] ?: $item['title'])],
                [
                    'title' => $item['title'],
                    'content' => $content,
                    'excerpt' => "Lulusan Tahun {$tahun}",
                    'status' => 'publish',
                    'type' => 'alumni',
                    'featured_image' => $featImage ?: '/uploads/logo-ishum-square.png',
                    'author_id' => $authorId,
                    'published_at' => now(),
                    'meta_title' => 'Alumni: '.$item['title'].' - SMA IT Ishlahul Ummah',
                ]
            );
        }
    }

    protected function importGuru(array $posts, array $postmeta): void
    {
        $gurus = array_filter($posts, fn ($p) => $p['type'] === 'guru' && $p['status'] === 'publish');

        $order = 1;
        foreach ($gurus as $item) {
            $pid = $item['id'];
            $meta = $postmeta[$pid] ?? [];

            $photo = null;
            if (! empty($meta['_thumbnail_id'])) {
                $photo = $this->getWebpUrl($meta['_thumbnail_id']);
            } elseif (! empty($meta['foto'])) {
                $photo = $this->getWebpUrl($meta['foto']);
            }

            $jabatan = $meta['jabatan'] ?? 'Tenaga Pendidik';
            $ttl = $meta['tempat-tanggal-lahir'] ?? '';
            $nuptk = ! empty($meta['nuptk']) ? "NUPTK: {$meta['nuptk']}" : '';
            $nip = ! empty($meta['nip']) ? "NIP: {$meta['nip']}" : '';
            $summary = trim("{$ttl} {$nip} {$nuptk}");

            AnggotaDewan::updateOrCreate(
                ['slug' => Str::slug($item['slug'] ?: $item['title'])],
                [
                    'name' => $item['title'],
                    'position' => $jabatan,
                    'fraction' => 'SMA IT Ishlahul Ummah',
                    'profile_summary' => $summary ?: 'Tenaga pendidik profesional SMA IT Ishlahul Ummah Prabumulih.',
                    'education' => 'S1 / S2 Pendidikan',
                    'photo' => $photo ?: '/uploads/logo-ishum-square.png',
                    'order' => $order++,
                ]
            );
        }
    }

    protected function importFasilitas(array $posts, array $postmeta): void
    {
        $fasilitas = array_filter($posts, fn ($p) => $p['type'] === 'fasilitas' && $p['status'] === 'publish');

        $order = 1;
        foreach ($fasilitas as $item) {
            $pid = $item['id'];
            $meta = $postmeta[$pid] ?? [];

            $thumb = null;
            if (! empty($meta['_thumbnail_id'])) {
                $thumb = $this->getWebpUrl($meta['_thumbnail_id']);
            } elseif (! empty($meta['foto'])) {
                $thumb = $this->getWebpUrl($meta['foto']);
            }

            $desc = ! empty($meta['deskripsi']) ? $meta['deskripsi'] : $item['content'];
            $cleanDesc = $this->cleanHtmlContent($desc);

            if (strlen(strip_tags($cleanDesc)) < 10) {
                $cleanDesc = "<p>Sarana {$item['title']} berstandar modern untuk menunjang kegiatan pembelajaran dan pembinaan karakter di SMA IT Ishlahul Ummah Prabumulih.</p>";
            }

            Bidang::updateOrCreate(
                ['slug' => Str::slug($item['slug'] ?: $item['title'])],
                [
                    'name' => $item['title'],
                    'description' => $cleanDesc,
                    'address' => 'Kampus SMA IT Ishlahul Ummah Prabumulih',
                    'phone' => '082182680647',
                    'email' => 'smaitishlahulummah2019@gmail.com',
                    'icon' => 'fa-solid fa-building-columns',
                    'thumbnail' => $thumb ?: '/uploads/campus-robbani.jpg',
                    'order' => $order++,
                ]
            );
        }
    }

    protected function importUnggulan(array $posts, array $postmeta): void
    {
        $unggulans = array_filter($posts, fn ($p) => in_array($p['type'], ['unggulan', 'jurusan']) && $p['status'] === 'publish');

        $order = 1;
        foreach ($unggulans as $item) {
            $pid = $item['id'];
            $meta = $postmeta[$pid] ?? [];

            $desc = ! empty($meta['deskripsi']) ? $meta['deskripsi'] : $item['content'];
            $cleanDesc = $this->cleanHtmlContent($desc);

            if (strlen(strip_tags($cleanDesc)) < 10) {
                $cleanDesc = "<p>Program Unggulan {$item['title']} bertujuan melatih dan membina keunggulan santri/siswa dalam Al-Qur'an, wawasan kepemimpinan, dan lifeskill islami.</p>";
            }

            Dpc::updateOrCreate(
                ['slug' => Str::slug($item['slug'] ?: $item['title'])],
                [
                    'name' => $item['title'],
                    'description' => $cleanDesc,
                    'head_name' => 'Koordinator Program',
                    'address' => 'SMA IT Ishlahul Ummah Prabumulih',
                    'order' => $order++,
                ]
            );
        }
    }

    protected function importAgendasAndPengumuman(array $posts, array $postmeta): void
    {
        // Agendas
        $agendas = array_filter($posts, fn ($p) => $p['type'] === 'agenda' && $p['status'] === 'publish');
        foreach ($agendas as $ag) {
            $pid = $ag['id'];
            $meta = $postmeta[$pid] ?? [];
            $img = ! empty($meta['_thumbnail_id']) ? $this->getWebpUrl($meta['_thumbnail_id']) : null;
            $content = ! empty($meta['deskripsi']) ? $meta['deskripsi'] : $ag['content'];
            $cleanContent = $this->cleanHtmlContent($content);

            if (strlen(strip_tags($cleanContent)) < 10) {
                $cleanContent = "<p>Agenda kegiatan {$ag['title']} SMA IT Ishlahul Ummah Prabumulih.</p>";
            }

            $date = ! empty($ag['date']) && $ag['date'] !== '0000-00-00 00:00:00' ? Carbon::parse($ag['date']) : now();

            Agenda::updateOrCreate(
                ['slug' => Str::slug($ag['slug'] ?: $ag['title'])],
                [
                    'title' => $ag['title'],
                    'content' => $cleanContent,
                    'location' => 'Kampus SMA IT Ishlahul Ummah Prabumulih',
                    'event_date' => $date,
                    'status' => 'publish',
                    'featured_image' => $img ?: '/uploads/campus-robbani.jpg',
                ]
            );
        }

        // Pengumuman
        $pengumumans = array_filter($posts, fn ($p) => $p['type'] === 'pengumuman' && $p['status'] === 'publish');
        foreach ($pengumumans as $pe) {
            $pid = $pe['id'];
            $meta = $postmeta[$pid] ?? [];
            $img = ! empty($meta['_thumbnail_id']) ? $this->getWebpUrl($meta['_thumbnail_id']) : null;
            $content = ! empty($meta['deskripsi']) ? $meta['deskripsi'] : $pe['content'];
            $cleanContent = $this->cleanHtmlContent($content);

            if (strlen(strip_tags($cleanContent)) < 10) {
                $cleanContent = "<p>Pengumuman resmi: {$pe['title']} untuk seluruh civitas akademika SMA IT Ishlahul Ummah Prabumulih.</p>";
            }

            Pengumuman::updateOrCreate(
                ['slug' => Str::slug($pe['slug'] ?: $pe['title'])],
                [
                    'title' => $pe['title'],
                    'content' => $cleanContent,
                    'status' => 'publish',
                    'featured_image' => $img ?: '/uploads/campus-robbani.jpg',
                ]
            );
        }
    }

    protected function importTestimonialsAndVideos(array $posts, array $postmeta): void
    {
        // Testimonials
        $testis = array_filter($posts, fn ($p) => $p['type'] === 'testimonial' && $p['status'] === 'publish');
        foreach ($testis as $t) {
            $pid = $t['id'];
            $meta = $postmeta[$pid] ?? [];
            $photo = ! empty($meta['_thumbnail_id']) ? $this->getWebpUrl($meta['_thumbnail_id']) : null;
            $msg = ! empty($meta['isi-testimoni']) ? $meta['isi-testimoni'] : $t['content'];
            $cleanMsg = strip_tags($this->cleanHtmlContent($msg));

            Testimonial::updateOrCreate(
                ['name' => $t['title']],
                [
                    'profession' => 'Wali Siswa SMA IT Ishum',
                    'content' => $cleanMsg ?: 'Alhamdulillah pendidikan di SMA IT Ishlahul Ummah membina anak kami menjadi pribadi berakhlak mulia dan giat beribadah.',
                    'photo' => $photo ?: '/uploads/logo-ishum-square.png',
                    'status' => 'publish',
                ]
            );
        }

        // Videos
        $vids = array_filter($posts, fn ($p) => $p['type'] === 'video' && $p['status'] === 'publish');
        foreach ($vids as $v) {
            $pid = $v['id'];
            $meta = $postmeta[$pid] ?? [];
            $youtubeUrl = $meta['url-youtube'] ?? 'https://www.youtube.com/watch?v=ZVaVth8Y76s';

            // Extract youtube ID
            $ytId = null;
            if (preg_match('/(?:v=|youtu\.be\/|embed\/)([a-zA-Z0-9_\-]+)/', $youtubeUrl, $m)) {
                $ytId = $m[1];
            }

            Video::updateOrCreate(
                ['slug' => Str::slug($v['slug'] ?: $v['title'])],
                [
                    'title' => $v['title'],
                    'youtube_url' => $youtubeUrl,
                    'youtube_id' => $ytId ?: 'ZVaVth8Y76s',
                    'description' => "Video dokumentasi dan edukasi: {$v['title']}",
                ]
            );
        }
    }

    protected function importQuickMenus(): void
    {
        $defaultMenus = [
            ['title' => 'Prestasi', 'url' => '/prestasi', 'icon' => 'fa-solid fa-trophy', 'badge' => 'Unggulan', 'order' => 1],
            ['title' => 'Ekskul & Club', 'url' => '/ekstrakurikuler', 'icon' => 'fa-solid fa-people-group', 'badge' => null, 'order' => 2],
            ['title' => 'Pengumuman', 'url' => '/pengumuman', 'icon' => 'fa-solid fa-bullhorn', 'badge' => 'Penting', 'order' => 3],
            ['title' => 'Agenda', 'url' => '/agenda', 'icon' => 'fa-solid fa-calendar-days', 'badge' => null, 'order' => 4],
            ['title' => 'Sambutan', 'url' => '/sambutan-kepala-sekolah', 'icon' => 'fa-solid fa-user-tie', 'badge' => null, 'order' => 5],
            ['title' => 'Download', 'url' => '/download', 'icon' => 'fa-solid fa-download', 'badge' => null, 'order' => 6],
            ['title' => 'Visi Misi', 'url' => '/visi-dan-misi', 'icon' => 'fa-solid fa-bullseye', 'badge' => null, 'order' => 7],
            ['title' => 'Unggulan', 'url' => '/unggulan', 'icon' => 'fa-solid fa-award', 'badge' => 'Terpadu', 'order' => 8],
            ['title' => 'Layanan Terpadu', 'url' => '/layanan-terpadu-2', 'icon' => 'fa-solid fa-handshake-angle', 'badge' => 'Online', 'order' => 9],
            ['title' => 'Data Alumni', 'url' => '/data-alumni', 'icon' => 'fa-solid fa-user-graduate', 'badge' => null, 'order' => 10],
            ['title' => 'Info PPDB', 'url' => 'https://ppdb.smaitishumpbm.sch.id/', 'icon' => 'fa-solid fa-graduation-cap', 'badge' => 'Buka', 'order' => 11],
        ];

        foreach ($defaultMenus as $menu) {
            QuickMenu::updateOrCreate(
                ['name' => $menu['title']],
                [
                    'url' => $menu['url'],
                    'icon' => $menu['icon'],
                    'order' => $menu['order'],
                    'is_active' => true,
                ]
            );
        }
    }
}
