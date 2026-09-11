<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class WebpService
{
    /**
     * Convert an existing image file to WebP format.
     */
    public function convertToWebp(
        string $sourcePath,
        string $destinationPath,
        int $quality = 82,
        int $maxWidth = 1920
    ): array {
        if (! file_exists($sourcePath)) {
            return [
                'success' => false,
                'error' => 'Source file does not exist: '.$sourcePath,
            ];
        }

        $imageInfo = @getimagesize($sourcePath);
        if (! $imageInfo) {
            return [
                'success' => false,
                'error' => 'Invalid image file or unsupported format: '.$sourcePath,
            ];
        }

        $mime = $imageInfo['mime'];
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];

        // Create GD image resource based on mime type
        $image = match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($sourcePath),
            'image/png' => @imagecreatefrompng($sourcePath),
            'image/webp' => @imagecreatefromwebp($sourcePath),
            'image/gif' => @imagecreatefromgif($sourcePath),
            'image/bmp', 'image/x-ms-bmp' => @imagecreatefrombmp($sourcePath),
            default => null,
        };

        if (! $image) {
            return [
                'success' => false,
                'error' => 'Failed to create GD image resource from '.$mime,
            ];
        }

        // Palette images (e.g. indexed PNG/GIF) must be converted to truecolor for WebP
        if (function_exists('imagepalettetotruecolor') && ! imageistruecolor($image)) {
            imagepalettetotruecolor($image);
        }

        // Calculate resize if wider than maxWidth
        $targetWidth = $originalWidth;
        $targetHeight = $originalHeight;

        if ($originalWidth > $maxWidth && $maxWidth > 0) {
            $ratio = $maxWidth / $originalWidth;
            $targetWidth = $maxWidth;
            $targetHeight = (int) round($originalHeight * $ratio);

            $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);

            // Handle transparency for PNG and WebP
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
            $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
            imagefilledrectangle($resizedImage, 0, 0, $targetWidth, $targetHeight, $transparent);

            imagecopyresampled(
                $resizedImage,
                $image,
                0, 0, 0, 0,
                $targetWidth,
                $targetHeight,
                $originalWidth,
                $originalHeight
            );

            imagedestroy($image);
            $image = $resizedImage;
        } else {
            // Ensure transparency preservation on original size
            imagealphablending($image, true);
            imagesavealpha($image, true);
        }

        // Ensure target directory exists
        $dir = dirname($destinationPath);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        // Save as WebP
        $saved = imagewebp($image, $destinationPath, $quality);
        imagedestroy($image);

        if (! $saved) {
            return [
                'success' => false,
                'error' => 'Failed to save WebP image to '.$destinationPath,
            ];
        }

        $originalSize = filesize($sourcePath);
        $newSize = filesize($destinationPath);

        return [
            'success' => true,
            'original_size' => $originalSize,
            'new_size' => $newSize,
            'saved_bytes' => $originalSize - $newSize,
            'destination_path' => $destinationPath,
        ];
    }

    /**
     * Process an uploaded file from HTTP request, convert to WebP, and save to public directory.
     */
    public function processUploadedFile(
        UploadedFile $file,
        string $subfolder = 'uploads',
        int $quality = 82,
        int $maxWidth = 1920
    ): array {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $slugName = Str::slug($filename) ?: 'image';
        $uniqueName = $slugName.'-'.time().'-'.Str::random(5).'.webp';

        $relativeDirectory = 'uploads/'.trim($subfolder, '/');
        $absoluteDirectory = public_path($relativeDirectory);

        if (! is_dir($absoluteDirectory)) {
            mkdir($absoluteDirectory, 0755, true);
        }

        $destinationPath = $absoluteDirectory.'/'.$uniqueName;
        $result = $this->convertToWebp($file->getRealPath(), $destinationPath, $quality, $maxWidth);

        if ($result['success']) {
            $result['url'] = '/'.$relativeDirectory.'/'.$uniqueName;
            $result['filename'] = $uniqueName;

            // Mirror file to active web document roots (cPanel separate docroot support)
            $docRootCandidates = array_filter([
                $_SERVER['DOCUMENT_ROOT'] ?? null,
            ]);

            foreach ($docRootCandidates as $docRoot) {
                if ($docRoot && is_dir($docRoot) && realpath($docRoot) !== realpath(public_path())) {
                    $targetDir = rtrim($docRoot, '/\\').'/'.$relativeDirectory;
                    if (! is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                    @copy($destinationPath, $targetDir.'/'.$uniqueName);
                }
            }
        }

        return $result;
    }
}
