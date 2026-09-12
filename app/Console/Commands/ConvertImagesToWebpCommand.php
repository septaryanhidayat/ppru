<?php

namespace App\Console\Commands;

use App\Services\WebpService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ConvertImagesToWebpCommand extends Command
{
    protected $signature = 'ishum:convert-webp {--force : Reconvert even if WebP already exists} {--keep-originals : Keep original image files after conversion}';

    protected $description = 'Convert all existing JPG, JPEG, and PNG images in public/uploads to WebP format with high quality and compact file size, and update database references';

    public function __construct(protected WebpService $webpService)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        $this->info('Starting WebP conversion for all existing school images...');

        $uploadsDir = public_path('uploads');
        if (! is_dir($uploadsDir)) {
            $this->error("Directory not found: {$uploadsDir}");

            return self::FAILURE;
        }

        $force = $this->option('force');
        $keepOriginals = $this->option('keep-originals');

        $rii = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($uploadsDir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::SELF_FIRST
        );

        $convertedCount = 0;
        $skippedCount = 0;
        $failedCount = 0;
        $totalSavedBytes = 0;
        $pathReplacements = []; // [old_relative_url => new_webp_relative_url]

        $imageExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'gif'];

        foreach ($rii as $file) {
            if ($file->isDir()) {
                continue;
            }

            $ext = strtolower($file->getExtension());
            if (! in_array($ext, $imageExtensions)) {
                continue;
            }

            $sourcePath = $file->getPathname();
            $pathInfo = pathinfo($sourcePath);
            $destinationPath = $pathInfo['dirname'].DIRECTORY_SEPARATOR.$pathInfo['filename'].'.webp';

            // Relative paths for URL matching
            $relOld = str_replace('\\', '/', substr($sourcePath, strlen(public_path())));
            $relOld = '/'.ltrim($relOld, '/');
            $relWebp = str_replace('\\', '/', substr($destinationPath, strlen(public_path())));
            $relWebp = '/'.ltrim($relWebp, '/');

            // Check if WebP already exists and is non-empty
            if (! $force && file_exists($destinationPath) && filesize($destinationPath) > 0) {
                $pathReplacements[$relOld] = $relWebp;
                $skippedCount++;
                if (! $keepOriginals && file_exists($sourcePath)) {
                    @unlink($sourcePath);
                }

                continue;
            }

            $originalSize = filesize($sourcePath);

            // Convert to WebP with optimal balance: quality 80, max width 1600px
            $result = $this->webpService->convertToWebp($sourcePath, $destinationPath, 80, 1600);

            if ($result['success']) {
                $convertedCount++;
                $newSize = filesize($destinationPath);
                $saved = $originalSize - $newSize;
                $totalSavedBytes += max(0, $saved);

                $pathReplacements[$relOld] = $relWebp;

                if (! $keepOriginals) {
                    @unlink($sourcePath);
                }

                if ($convertedCount % 10 === 0) {
                    $this->line(" - Converted {$convertedCount} images... (Saved so far: ".round($totalSavedBytes / (1024 * 1024), 2).' MB)');
                    gc_collect_cycles();
                }
            } else {
                $failedCount++;
                $this->warn("Failed converting {$file->getFilename()}: ".($result['error'] ?? 'Unknown error'));
            }
        }

        $this->info("Image conversion complete: {$convertedCount} converted, {$skippedCount} skipped, {$failedCount} failed.");
        $this->info('Total disk space saved: '.round($totalSavedBytes / (1024 * 1024), 2).' MB');

        // Step 2: Update all database records referencing the old file paths
        $this->info('Updating database records with new WebP paths...');
        $updatedRecords = $this->updateDatabaseReferences($pathReplacements);
        $this->info("Database update complete: {$updatedRecords} field values updated to WebP.");

        // Step 3: Ensure essential fallback images exist as WebP
        $this->ensureEssentialFallbackImages();

        $this->info('All images are now in optimized WebP format!');

        return self::SUCCESS;
    }

    /**
     * Replace old image URLs in the database with new WebP URLs.
     */
    protected function updateDatabaseReferences(array $replacements): int
    {
        if (empty($replacements)) {
            return 0;
        }

        $totalUpdated = 0;

        // 1. Posts table: featured_image
        foreach ($replacements as $old => $new) {
            $count = DB::table('posts')
                ->where('featured_image', $old)
                ->orWhere('featured_image', ltrim($old, '/'))
                ->update(['featured_image' => $new]);
            $totalUpdated += $count;
        }

        // 2. Posts table: content (inline HTML img tags)
        $posts = DB::table('posts')->whereNotNull('content')->get(['id', 'content']);
        foreach ($posts as $p) {
            $content = $p->content;
            $changed = false;
            foreach ($replacements as $old => $new) {
                if (str_contains($content, $old) || str_contains($content, ltrim($old, '/'))) {
                    $content = str_replace([$old, ltrim($old, '/')], $new, $content);
                    $changed = true;
                }
            }
            if ($changed) {
                DB::table('posts')->where('id', $p->id)->update(['content' => $content]);
                $totalUpdated++;
            }
        }

        // 3. Anggota Dewan: photo
        foreach ($replacements as $old => $new) {
            $count = DB::table('anggota_dewans')
                ->where('photo', $old)
                ->orWhere('photo', ltrim($old, '/'))
                ->update(['photo' => $new]);
            $totalUpdated += $count;
        }

        // 4. Testimonials: photo
        foreach ($replacements as $old => $new) {
            $count = DB::table('testimonials')
                ->where('photo', $old)
                ->orWhere('photo', ltrim($old, '/'))
                ->update(['photo' => $new]);
            $totalUpdated += $count;
        }

        // 5. Bidangs: icon
        foreach ($replacements as $old => $new) {
            $count = DB::table('bidangs')
                ->where('icon', $old)
                ->orWhere('icon', ltrim($old, '/'))
                ->update(['icon' => $new]);
            $totalUpdated += $count;
        }

        // 6. Quick Menus: icon
        foreach ($replacements as $old => $new) {
            $count = DB::table('quick_menus')
                ->where('icon', $old)
                ->orWhere('icon', ltrim($old, '/'))
                ->update(['icon' => $new]);
            $totalUpdated += $count;
        }

        // 7. Settings: value
        foreach ($replacements as $old => $new) {
            $count = DB::table('settings')
                ->where('value', $old)
                ->orWhere('value', ltrim($old, '/'))
                ->update(['value' => $new]);
            $totalUpdated += $count;
        }

        return $totalUpdated;
    }

    /**
     * Create WebP versions for standard system fallback assets if not present.
     */
    protected function ensureEssentialFallbackImages(): void
    {
        $fallbacks = [
            'campus-ishum.webp' => ['campus-robbani.webp', 'campus-robbani.jpg', '2023/08/logo-ishum.png'],
            'campus-robbani.webp' => ['campus-robbani.jpg', '2023/08/logo-ishum.png'],
            'kepsek-agi-gustiawan.webp' => ['kepsek-agi-gustiawan.jpg'],
            'lab-ishum.webp' => ['campus-robbani.webp', 'campus-robbani.jpg'],
            'tahfidz-ishum.webp' => ['campus-robbani.webp', 'campus-robbani.jpg'],
            'library-ishum.webp' => ['campus-robbani.webp', 'campus-robbani.jpg'],
        ];

        $uploadsDir = public_path('uploads');

        foreach ($fallbacks as $target => $sources) {
            $targetAbs = $uploadsDir.DIRECTORY_SEPARATOR.$target;
            if (file_exists($targetAbs) && filesize($targetAbs) > 0) {
                continue;
            }

            foreach ($sources as $src) {
                $srcAbs = $uploadsDir.DIRECTORY_SEPARATOR.str_replace('/', DIRECTORY_SEPARATOR, $src);
                if (file_exists($srcAbs)) {
                    if (str_ends_with(strtolower($srcAbs), '.webp')) {
                        @copy($srcAbs, $targetAbs);
                        $this->line("Copied {$src} -> {$target}");
                        break;
                    } else {
                        $res = $this->webpService->convertToWebp($srcAbs, $targetAbs, 80, 1600);
                        if ($res['success']) {
                            $this->line("Created fallback {$target} from {$src}");
                            break;
                        }
                    }
                }
            }
        }
    }
}
