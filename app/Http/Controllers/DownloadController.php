<?php

namespace App\Http\Controllers;

use App\Models\Download;
use App\Models\Post;

class DownloadController extends Controller
{
    public function index()
    {
        $downloads = Download::orderBy('id', 'asc')->paginate(12);

        return view('frontend.download.index', compact('downloads'));
    }

    public function ebook()
    {
        $page = Post::pages()->where('slug', 'e-book')->first();
        $ebooks = Download::where('category_type', 'E-Book')->orWhere('file_type', 'PDF')->get();

        return view('frontend.download.ebook', compact('page', 'ebooks'));
    }

    public function hymneMars()
    {
        $page = Post::pages()->whereIn('slug', ['hymne-mars', 'hymne-mars-robbani'])->first();
        $audioFiles = Download::where('file_type', 'MP3')->orWhere('title', 'like', '%Mars%')->orWhere('title', 'like', '%Hymne%')->get();

        return view('frontend.download.hymne-mars', compact('page', 'audioFiles'));
    }

    public function logo()
    {
        $page = Post::pages()->where('slug', 'logo')->first();
        $logoDownloads = Download::where('title', 'like', '%Logo%')->get();

        return view('frontend.download.logo', compact('page', 'logoDownloads'));
    }

    public function downloadFile($id)
    {
        // 1. Prevent path traversal and null bytes
        if (str_contains((string) $id, '..') || str_contains((string) $id, "\0")) {
            abort(404, 'Akses unduhan tidak valid.');
        }

        $allowedExtensions = ['pdf', 'mp3', 'png', 'jpg', 'jpeg', 'webp', 'svg', 'zip', 'doc', 'docx', 'xls', 'xlsx'];
        $allowedRoots = [
            realpath(public_path('uploads')),
            realpath(storage_path('app/public')),
            realpath(public_path()),
        ];
        // Filter out false values if directories don't exist
        $allowedRoots = array_filter($allowedRoots);

        $download = is_numeric($id)
            ? Download::find($id)
            : Download::where('file_path', 'like', '%'.$id.'%')->orWhere('title', 'like', '%'.$id.'%')->first();

        if (! $download) {
            $cleanParam = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, trim((string) $id, '/\\'));
            $ext = strtolower(pathinfo($cleanParam, PATHINFO_EXTENSION));

            if (! in_array($ext, $allowedExtensions)) {
                abort(404, 'Tipe berkas tidak diizinkan.');
            }

            $candidatePaths = [
                public_path('uploads'.DIRECTORY_SEPARATOR.$cleanParam),
                public_path($cleanParam),
            ];

            foreach ($candidatePaths as $candidate) {
                if (file_exists($candidate)) {
                    $real = realpath($candidate);
                    if ($real && is_file($real)) {
                        foreach ($allowedRoots as $root) {
                            if (str_starts_with($real, $root)) {
                                return response()->download($real);
                            }
                        }
                    }
                }
            }

            // Search in subdirectories of public/uploads
            $found = glob(public_path('uploads'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.'*'.DIRECTORY_SEPARATOR.basename($cleanParam)));
            if (! empty($found) && file_exists($found[0])) {
                $real = realpath($found[0]);
                if ($real && is_file($real) && in_array(strtolower(pathinfo($real, PATHINFO_EXTENSION)), $allowedExtensions)) {
                    return response()->download($real);
                }
            }

            abort(404, 'Berkas unduhan tidak ditemukan.');
        }

        $download->increment('download_count');

        $relativePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, trim($download->file_path, '/\\'));
        $fullPath = public_path($relativePath);

        if (! file_exists($fullPath)) {
            if (file_exists(public_path('uploads'.DIRECTORY_SEPARATOR.$relativePath))) {
                $fullPath = public_path('uploads'.DIRECTORY_SEPARATOR.$relativePath);
            } elseif (file_exists(storage_path('app/public/'.$relativePath))) {
                $fullPath = storage_path('app/public/'.$relativePath);
            }
        }

        if (file_exists($fullPath)) {
            $real = realpath($fullPath);
            $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

            if (! in_array($ext, $allowedExtensions)) {
                abort(403, 'Tipe berkas tidak diizinkan untuk diunduh.');
            }

            // Ensure real path is inside allowed root
            $isAllowed = false;
            foreach ($allowedRoots as $root) {
                if ($real && str_starts_with($real, $root)) {
                    $isAllowed = true;
                    break;
                }
            }

            if (! $isAllowed) {
                abort(403, 'Akses berkas ditolak.');
            }

            $mimeType = match ($ext) {
                'pdf' => 'application/pdf',
                'mp3' => 'audio/mpeg',
                'png' => 'image/png',
                'svg' => 'image/svg+xml',
                'jpg', 'jpeg' => 'image/jpeg',
                'webp' => 'image/webp',
                'zip' => 'application/zip',
                'doc' => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                default => 'application/octet-stream',
            };

            return response()->download($real, basename($real), [
                'Content-Type' => $mimeType,
            ]);
        }

        if (filter_var($download->file_path, FILTER_VALIDATE_URL)) {
            return redirect()->away($download->file_path);
        }

        return redirect()->route('download.index')->with('error', 'File dokumen asli tidak ditemukan di server.');
    }
}
