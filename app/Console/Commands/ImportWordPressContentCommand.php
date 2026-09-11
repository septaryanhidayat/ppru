<?php

namespace App\Console\Commands;

use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Category;
use App\Models\Download;
use App\Models\Dpc;
use App\Models\Feedback;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\Setting;
use App\Models\Tag;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Video;
use App\Services\WebpService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ImportWordPressContentCommand extends Command
{
    protected $signature = 'app:import-wordpress-content {--xml= : Path to XML export file}';

    protected $description = 'Import 100% of WordPress content, convert all images to WebP, and populate Laravel models';

    protected WebpService $webpService;

    protected array $attachmentMap = []; // attachment_id => ['webp_url' => ..., 'original_url' => ..., 'file_path' => ...]

    protected array $urlMap = []; // old_url => new_url

    public function __construct(WebpService $webpService)
    {
        parent::__construct();
        $this->webpService = $webpService;
    }

    public function handle(): int
    {
        $xmlPath = $this->option('xml') ?: base_path('dpdpksoganilir.WordPress.2026-09-05.xml');
        $sqlPath = base_path('database/berandad_wppksoi.sql');
        $uploadsDir = base_path('BACKUP WEb LAMA/wp-content/uploads');

        if (! file_exists($xmlPath)) {
            $this->error("XML file not found at: {$xmlPath}");

            return 1;
        }

        $this->info("Loading WordPress XML: {$xmlPath}...");
        $xml = simplexml_load_file($xmlPath);
        if (! $xml) {
            $this->error('Failed to parse XML file.');

            return 1;
        }

        $this->info('Step 1: Importing Authors & Users...');
        $this->importUsers($xml);

        $this->info('Step 2: Importing Categories & Tags...');
        $this->importTaxonomies($xml);

        $this->info('Step 3: Processing Media & Converting all Images to WebP...');
        $this->processMediaAndWebp($xml, $uploadsDir);

        $this->info('Step 4: Importing Posts (Articles & News)...');
        $this->importPosts($xml);

        $this->info('Step 5: Importing Pages...');
        $this->importPages($xml);

        $this->info('Step 6: Importing Custom Post Types (Dewan, Bidang, DPC, Agenda, Pengumuman, Testimonial, Video)...');
        $this->importCustomPostTypes($xml);

        $this->info('Step 7: Importing Downloads & Feedbacks from SQL Dump...');
        $this->importSqlDumpData($sqlPath);

        $this->info('Step 8: Populating Default Website Settings...');
        $this->populateSettings();

        $this->info('=== IMPORT COMPLETED SUCCESSFULLY! ===');
        $this->info('Total Posts: '.Post::where('type', 'post')->count());
        $this->info('Total Pages: '.Post::where('type', 'page')->count());
        $this->info('Total Categories: '.Category::count());
        $this->info('Total Tags: '.Tag::count());
        $this->info('Total Agendas: '.Agenda::count());
        $this->info('Total Pengumuman: '.Pengumuman::count());
        $this->info('Total Anggota Dewan: '.AnggotaDewan::count());
        $this->info('Total Bidang: '.Bidang::count());
        $this->info('Total DPC: '.Dpc::count());
        $this->info('Total Testimonials: '.Testimonial::count());
        $this->info('Total Videos: '.Video::count());
        $this->info('Total Downloads: '.Download::count());
        $this->info('Total Feedbacks: '.Feedback::count());

        return 0;
    }

    protected function importUsers($xml): void
    {
        $wpNs = 'http://wordpress.org/export/1.2/';
        foreach ($xml->channel->children($wpNs)->author as $author) {
            $email = (string) $author->author_email;
            $login = (string) $author->author_login;
            $displayName = (string) $author->author_display_name;

            if (! $email) {
                $email = Str::slug($login).'@pksoganilir.com';
            }

            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $displayName ?: $login,
                    'password' => Hash::make('AdminPksOi2026!'),
                ]
            );
            $this->line(" - User imported: {$displayName} ({$email})");
        }
    }

    protected function importTaxonomies($xml): void
    {
        $wpNs = 'http://wordpress.org/export/1.2/';

        foreach ($xml->channel->children($wpNs)->category as $cat) {
            $name = (string) $cat->cat_name;
            $slug = (string) $cat->category_nicename;
            if ($name && $slug) {
                Category::updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );
            }
        }
        $this->line(' - Categories imported: '.Category::count());

        foreach ($xml->channel->children($wpNs)->tag as $tag) {
            $name = (string) $tag->tag_name;
            $slug = (string) $tag->tag_slug;
            if ($name && $slug) {
                Tag::updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $name]
                );
            }
        }
        $this->line(' - Tags imported: '.Tag::count());
    }

    protected function processMediaAndWebp($xml, string $uploadsDir): void
    {
        $wpNs = 'http://wordpress.org/export/1.2/';
        $destBase = public_path('uploads');
        if (! is_dir($destBase)) {
            mkdir($destBase, 0755, true);
        }

        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        $count = 0;
        $webpCount = 0;

        foreach ($xml->channel->item as $item) {
            $wp = $item->children($wpNs);
            if ((string) $wp->post_type !== 'attachment') {
                continue;
            }

            $postId = (int) $wp->post_id;
            $guid = (string) $item->guid;
            $attachedFile = '';

            foreach ($wp->postmeta as $meta) {
                if ((string) $meta->meta_key === '_wp_attached_file') {
                    $attachedFile = (string) $meta->meta_value;
                }
            }

            if (! $attachedFile && $guid) {
                // Parse relative path from GUID
                if (preg_match('/wp-content\/uploads\/(.*)$/i', $guid, $m)) {
                    $attachedFile = $m[1];
                }
            }

            if (! $attachedFile) {
                continue;
            }

            $sourcePath = $uploadsDir.'/'.$attachedFile;
            $ext = strtolower(pathinfo($attachedFile, PATHINFO_EXTENSION));
            $basePathWithoutExt = pathinfo($attachedFile, PATHINFO_DIRNAME).'/'.pathinfo($attachedFile, PATHINFO_FILENAME);
            $basePathWithoutExt = trim(str_replace('\\', '/', $basePathWithoutExt), './');

            $destRelWebp = 'uploads/'.$basePathWithoutExt.'.webp';
            $destAbsWebp = public_path($destRelWebp);

            $destRelOriginal = 'uploads/'.$attachedFile;
            $destAbsOriginal = public_path($destRelOriginal);

            // Ensure directory exists
            $dir = dirname($destAbsWebp);
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            $finalUrl = '/'.$destRelOriginal;

            // If it's an image and source file exists, convert to WebP
            if (in_array($ext, $imageExtensions) && file_exists($sourcePath)) {
                $convertRes = $this->webpService->convertToWebp($sourcePath, $destAbsWebp, 82, 1920);
                if ($convertRes['success']) {
                    $finalUrl = '/'.$destRelWebp;
                    $webpCount++;
                } else {
                    // Copy original as fallback
                    @copy($sourcePath, $destAbsOriginal);
                }
            } elseif (file_exists($sourcePath)) {
                // Non-image file (e.g. MP3, PDF): copy directly
                @copy($sourcePath, $destAbsOriginal);
                $finalUrl = '/'.$destRelOriginal;
            }

            $this->attachmentMap[$postId] = [
                'url' => $finalUrl,
                'path' => $attachedFile,
                'title' => (string) $item->title,
            ];

            // Map old WordPress URLs to new WebP/local URLs
            if ($guid) {
                $this->urlMap[$guid] = $finalUrl;
            }
            $this->urlMap['http://oganilir.pks.id/wp-content/uploads/'.$attachedFile] = $finalUrl;
            $this->urlMap['https://pksoganilir.com/wp-content/uploads/'.$attachedFile] = $finalUrl;
            $this->urlMap['/wp-content/uploads/'.$attachedFile] = $finalUrl;

            $count++;
        }

        $this->line(" - Media attachments processed: {$count} (WebP converted: {$webpCount})");
    }

    protected function cleanHtmlContent(?string $content): string
    {
        if (! $content) {
            return '';
        }

        // Replace all legacy uploads URLs with new WebP / local uploads URLs
        foreach ($this->urlMap as $oldUrl => $newUrl) {
            $content = str_replace($oldUrl, $newUrl, $content);
        }

        // General regex replace for remaining wp-content/uploads URLs to /uploads/
        $content = preg_replace('/https?:\/\/[a-zA-Z0-9\.\-_]+\/wp-content\/uploads\//i', '/uploads/', $content);
        $content = preg_replace('/\/wp-content\/uploads\//i', '/uploads/', $content);

        // Convert jpg/jpeg/png image references inside /uploads/ to .webp if corresponding webp exists
        $content = preg_replace_callback('/(\/uploads\/[a-zA-Z0-9_\-\/]+)\.(jpg|jpeg|png)/i', function ($matches) {
            $webpAbs = public_path(trim($matches[1], '/').'.webp');
            if (file_exists($webpAbs)) {
                return $matches[1].'.webp';
            }

            return $matches[0];
        }, $content);

        return $content;
    }

    protected function getThumbnailUrl($wp): ?string
    {
        $thumbId = 0;
        foreach ($wp->postmeta as $meta) {
            if ((string) $meta->meta_key === '_thumbnail_id') {
                $thumbId = (int) $meta->meta_value;
            }
        }

        if ($thumbId && isset($this->attachmentMap[$thumbId])) {
            return $this->attachmentMap[$thumbId]['url'];
        }

        return null;
    }

    protected function importPosts($xml): void
    {
        $wpNs = 'http://wordpress.org/export/1.2/';
        $contentNs = 'http://purl.org/rss/1.0/modules/content/';
        $user = User::first();
        $importedCount = 0;

        foreach ($xml->channel->item as $item) {
            $wp = $item->children($wpNs);
            if ((string) $wp->post_type !== 'post') {
                continue;
            }

            $title = (string) $item->title;
            $slug = (string) $wp->post_name ?: Str::slug($title);
            $rawContent = (string) $item->children($contentNs)->encoded;
            $excerpt = (string) $item->children('http://wordpress.org/export/1.2/excerpt/')->encoded;
            $status = (string) $wp->status === 'publish' ? 'publish' : 'draft';
            $postDate = (string) $wp->post_date;

            // Custom fields
            $metaFields = [];
            foreach ($wp->postmeta as $meta) {
                $metaFields[(string) $meta->meta_key] = (string) $meta->meta_value;
            }

            if (! empty($metaFields['isi-artikel'])) {
                $rawContent = $metaFields['isi-artikel'];
            }

            $cleanedContent = $this->cleanHtmlContent($rawContent);
            $featuredImage = $this->getThumbnailUrl($wp);

            $views = (int) ($metaFields['_ahcfree_total_views'] ?? 0);
            $metaTitle = $metaFields['_yoast_wpseo_title'] ?? $title;
            $metaDesc = $metaFields['_yoast_wpseo_metadesc'] ?? Str::limit(strip_tags($cleanedContent), 160);
            $metaKeywords = $metaFields['_yoast_wpseo_focuskw'] ?? null;

            $post = Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => $cleanedContent,
                    'excerpt' => $excerpt ?: Str::limit(strip_tags($cleanedContent), 200),
                    'status' => $status,
                    'type' => 'post',
                    'featured_image' => $featuredImage,
                    'views_count' => $views,
                    'author_id' => $user?->id,
                    'published_at' => $postDate ? Carbon::parse($postDate) : now(),
                    'meta_title' => $metaTitle,
                    'meta_description' => $metaDesc,
                    'meta_keywords' => $metaKeywords,
                ]
            );

            // Sync categories & tags
            $catIds = [];
            $tagIds = [];

            foreach ($item->category as $cat) {
                $domain = (string) $cat['domain'];
                $termSlug = (string) $cat['nicename'];

                if ($domain === 'category') {
                    $c = Category::where('slug', $termSlug)->first();
                    if ($c) {
                        $catIds[] = $c->id;
                    }
                } elseif ($domain === 'post_tag') {
                    $t = Tag::where('slug', $termSlug)->first();
                    if ($t) {
                        $tagIds[] = $t->id;
                    }
                }
            }

            if (! empty($catIds)) {
                $post->categories()->sync($catIds);
            }
            if (! empty($tagIds)) {
                $post->tags()->sync($tagIds);
            }

            $importedCount++;
        }

        $this->line(" - Posts (Articles) imported: {$importedCount}");
    }

    protected function importPages($xml): void
    {
        $wpNs = 'http://wordpress.org/export/1.2/';
        $contentNs = 'http://purl.org/rss/1.0/modules/content/';
        $user = User::first();
        $importedCount = 0;

        foreach ($xml->channel->item as $item) {
            $wp = $item->children($wpNs);
            if ((string) $wp->post_type !== 'page') {
                continue;
            }

            $title = (string) $item->title;
            $slug = (string) $wp->post_name ?: Str::slug($title);
            $rawContent = (string) $item->children($contentNs)->encoded;
            $status = (string) $wp->status === 'publish' ? 'publish' : 'draft';
            $postDate = (string) $wp->post_date;

            $featuredImage = $this->getThumbnailUrl($wp);
            $cleanedContent = $this->cleanHtmlContent($rawContent);

            Post::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'content' => $cleanedContent,
                    'excerpt' => Str::limit(strip_tags($cleanedContent), 200),
                    'status' => $status,
                    'type' => 'page',
                    'featured_image' => $featuredImage,
                    'author_id' => $user?->id,
                    'published_at' => $postDate ? Carbon::parse($postDate) : now(),
                ]
            );

            $importedCount++;
        }

        $this->line(" - Pages imported: {$importedCount}");
    }

    protected function importCustomPostTypes($xml): void
    {
        $wpNs = 'http://wordpress.org/export/1.2/';
        $contentNs = 'http://purl.org/rss/1.0/modules/content/';

        foreach ($xml->channel->item as $item) {
            $wp = $item->children($wpNs);
            $type = (string) $wp->post_type;
            $title = (string) $item->title;
            $slug = (string) $wp->post_name ?: Str::slug($title);
            $rawContent = (string) $item->children($contentNs)->encoded;
            $status = (string) $wp->status === 'publish' ? 'publish' : 'draft';
            $postDate = (string) $wp->post_date;

            $meta = [];
            foreach ($wp->postmeta as $m) {
                $meta[(string) $m->meta_key] = (string) $m->meta_value;
            }

            $featuredImage = $this->getThumbnailUrl($wp);

            if ($type === 'agenda') {
                Agenda::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'content' => $this->cleanHtmlContent($rawContent),
                        'location' => 'Kabupaten Ogan Ilir',
                        'event_date' => $postDate ? Carbon::parse($postDate) : now(),
                        'status' => $status,
                        'featured_image' => $featuredImage,
                    ]
                );
            } elseif ($type === 'pengumuman') {
                $deskripsi = $meta['deskripsi'] ?? $rawContent;
                Pengumuman::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'content' => $this->cleanHtmlContent($deskripsi),
                        'file_attachment' => $meta['lampiran'] ?? null,
                        'status' => $status,
                        'featured_image' => $featuredImage,
                    ]
                );
            } elseif ($type === 'dosen') {
                // Anggota Dewan PKS
                $jabatan = $meta['jabatan'] ?? 'Anggota Fraksi PKS DPRD OI';
                $profil = $meta['profil-singkat'] ?? $rawContent;
                AnggotaDewan::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $title,
                        'position' => $jabatan,
                        'fraction' => 'Fraksi PKS',
                        'profile_summary' => $this->cleanHtmlContent($profil),
                        'photo' => $featuredImage,
                    ]
                );
            } elseif ($type === 'fakultas') {
                // Bidang DPD
                $desc = $meta['keunggulan'] ?? $rawContent;
                Bidang::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $title,
                        'description' => $this->cleanHtmlContent($desc),
                        'address' => $meta['alamat'] ?? 'Jl. Komperta Taman Indralaya Blok C No. 05 Kel. Indralaya Mulya, Kab. Ogan Ilir',
                        'phone' => $meta['telp'] ?? '082280041658',
                        'email' => $meta['email'] ?? 'pksoganilir@gmail.com',
                        'website' => $meta['website'] ?? 'https://pksoganilir.com',
                        'thumbnail' => $featuredImage,
                    ]
                );
            } elseif ($type === 'prodi') {
                // DPC Kecamatan
                $desc = $meta['info'] ?? $rawContent;
                Dpc::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'name' => $title,
                        'description' => $this->cleanHtmlContent($desc),
                        'address' => 'Kabupaten Ogan Ilir',
                    ]
                );
            } elseif ($type === 'testimonial') {
                $testimoni = $meta['isi-testimoni'] ?? $rawContent;
                $profesi = $meta['alumni-tahun'] ?? 'Masyarakat Ogan Ilir';
                Testimonial::updateOrCreate(
                    ['name' => $title],
                    [
                        'profession' => $profesi,
                        'content' => strip_tags($testimoni),
                        'photo' => $featuredImage,
                        'status' => 'publish',
                    ]
                );
            } elseif ($type === 'video') {
                $ytUrl = $meta['url-youtube'] ?? '';
                $ytId = null;
                if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $ytUrl, $match)) {
                    $ytId = $match[1];
                }
                Video::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'title' => $title,
                        'youtube_url' => $ytUrl,
                        'youtube_id' => $ytId,
                        'description' => $this->cleanHtmlContent($rawContent),
                    ]
                );
            }
        }
    }

    protected function importSqlDumpData(string $sqlPath): void
    {
        if (! file_exists($sqlPath)) {
            $this->warn("SQL dump file not found at: {$sqlPath}. Skipping SQL-specific import.");

            return;
        }

        $fp = fopen($sqlPath, 'r');
        if (! $fp) {
            return;
        }

        $currentTable = '';
        while (($line = fgets($fp)) !== false) {
            if (str_contains($line, 'INSERT INTO `wp1pksoi_jet_cct_download`')) {
                $currentTable = 'download';

                continue;
            } elseif (str_contains($line, 'INSERT INTO `wp1pksoi_jet_cct_kritik`')) {
                $currentTable = 'kritik';

                continue;
            } elseif (str_starts_with(trim($line), 'INSERT INTO `') || str_starts_with(trim($line), '--')) {
                $currentTable = '';
            }

            if ($currentTable === 'download') {
                // (1, 'publish', 'Logo PKS', 'PNG', 3144, 14, '2023-08-26 08:02:32', '2025-09-22 10:06:01')
                if (preg_match("/\((\d+),\s*'([^']+)',\s*'([^']+)',\s*'([^']+)',\s*(\d+)/", $line, $m)) {
                    $title = $m[3];
                    $jenis = $m[4];
                    $attachId = (int) $m[5];
                    $filePath = $this->attachmentMap[$attachId]['url'] ?? ('/uploads/'.Str::slug($title).'.'.strtolower($jenis));

                    Download::updateOrCreate(
                        ['title' => $title],
                        [
                            'category_type' => in_array($jenis, ['MP3']) ? 'Lagu' : 'Dokumen',
                            'file_path' => $filePath,
                            'file_type' => $jenis,
                        ]
                    );
                }
            } elseif ($currentTable === 'kritik') {
                // (1, 'draft', 'Hi ...', 'email...', '', 'message...', 0, ...)
                if (preg_match("/\((\d+),\s*'([^']+)',\s*'([^']+)',\s*'([^']*)',\s*'([^']*)',\s*'([^']*)'/u", $line, $m)) {
                    $nama = $m[3];
                    $email = $m[4];
                    $wa = $m[5];
                    $msg = $m[6];

                    Feedback::updateOrCreate(
                        ['name' => $nama, 'email' => $email],
                        [
                            'whatsapp' => $wa,
                            'message' => strip_tags(str_replace(['\r\n', '\n'], ' ', $msg)),
                            'status' => 'read',
                        ]
                    );
                }
            }
        }
        fclose($fp);
    }

    protected function populateSettings(): void
    {
        $settings = [
            'site_name' => 'DPD PKS Ogan Ilir',
            'site_tagline' => 'Berkhidmat untuk Rakyat',
            'site_description' => 'Official Website Dewan Pengurus Daerah Partai Keadilan Sejahtera (PKS) Kabupaten Ogan Ilir.',
            'contact_email' => 'pksoganilir@gmail.com',
            'contact_phone' => '082280041658',
            'contact_whatsapp' => '082280041658',
            'contact_address' => 'Jl. Komperta Taman Indralaya Blok C No. 05 Kel. Indralaya Mulya, Kec. Indralaya, Kab. Ogan Ilir, Sumatera Selatan',
            'social_facebook' => 'https://facebook.com/dpdpksoganilir',
            'social_instagram' => 'https://instagram.com/dpdpksoganilir',
            'social_youtube' => 'https://youtube.com/@pkstvoganilir',
            'social_tiktok' => 'https://tiktok.com/@pksoganilir',
            'social_twitter' => 'https://x.com/pksoganilir',
            'banner_daftar_url' => 'https://daftar.pks.id',
            'banner_donasi_url' => '/donasi',
            'site_logo' => '/uploads/2023/08/logo-pks-ogan-ilir.webp',
        ];

        foreach ($settings as $key => $val) {
            Setting::updateOrCreate(['key' => $key], ['value' => $val, 'group' => 'general']);
        }
    }
}
