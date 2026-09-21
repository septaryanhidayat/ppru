<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Download;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDownloadController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
    }

    public function index()
    {
        $downloads = Download::latest()->paginate(15);

        return view('admin.downloads.index', compact('downloads'));
    }

    public function create()
    {
        return view('admin.downloads.create');
    }

    public function store(Request $request)
    {
        $allowedMimes = 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,mp3,jpg,jpeg,png,webp';
        $safeExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', '7z', 'mp3', 'jpg', 'jpeg', 'png', 'webp'];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'file' => "required_without:file_path|nullable|file|{$allowedMimes}|max:30720", // max 30MB
            'file_path' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        $filePath = $validated['file_path'] ?? '';
        $fileType = 'PDF';
        $fileSize = '1.0 MB';

        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $originalName = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($uploaded->getClientOriginalExtension());
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = Str::slug($originalName).'-'.time().'.'.$ext;

            $targetDir = public_path('uploads/downloads');
            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $uploaded->move($targetDir, $filename);
            $filePath = '/uploads/downloads/'.$filename;
            $fileType = strtoupper($ext);
            $bytes = filesize($targetDir.'/'.$filename);
            $fileSize = round($bytes / (1024 * 1024), 2).' MB';
        }

        $coverUrl = null;
        if ($request->hasFile('cover_image')) {
            $converted = $this->webpService->processUploadedFile($request->file('cover_image'), 'covers', 85, 800);
            if ($converted['success']) {
                $coverUrl = $converted['url'];
            }
        }

        $download = Download::create([
            'title' => $validated['title'],
            'category_type' => $validated['category_type'],
            'description' => $validated['description'] ?? null,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
            'cover_image' => $coverUrl,
            'download_count' => 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'download_create',
            'description' => "Menambahkan file publik download: {$download->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.downloads.index')->with('success', 'File download berhasil ditambahkan.');
    }

    public function edit(Download $download)
    {
        return view('admin.downloads.edit', compact('download'));
    }

    public function update(Request $request, Download $download)
    {
        $allowedMimes = 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar,7z,mp3,jpg,jpeg,png,webp';
        $safeExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'zip', 'rar', '7z', 'mp3', 'jpg', 'jpeg', 'png', 'webp'];

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_type' => 'required|string|max:100',
            'description' => 'nullable|string',
            'file' => "nullable|file|{$allowedMimes}|max:30720",
            'file_path' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $originalName = pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME);
            $ext = strtolower($uploaded->getClientOriginalExtension());
            if (! in_array($ext, $safeExtensions, true)) {
                $ext = 'pdf';
            }
            $filename = Str::slug($originalName).'-'.time().'.'.$ext;

            $targetDir = public_path('uploads/downloads');
            if (! is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $uploaded->move($targetDir, $filename);
            $download->file_path = '/uploads/downloads/'.$filename;
            $download->file_type = strtoupper($ext);
            $bytes = filesize($targetDir.'/'.$filename);
            $download->file_size = round($bytes / (1024 * 1024), 2).' MB';
        } elseif (! empty($validated['file_path'])) {
            $download->file_path = $validated['file_path'];
        }

        if ($request->hasFile('cover_image')) {
            $converted = $this->webpService->processUploadedFile($request->file('cover_image'), 'covers', 85, 800);
            if ($converted['success']) {
                $download->cover_image = $converted['url'];
            }
        }

        $download->title = $validated['title'];
        $download->category_type = $validated['category_type'];
        $download->description = $validated['description'] ?? $download->description;
        $download->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'download_update',
            'description' => "Memperbarui data file download: {$download->title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.downloads.index')->with('success', 'File download berhasil diperbarui.');
    }

    public function destroy(Request $request, Download $download)
    {
        $title = $download->title;
        $download->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'download_delete',
            'description' => "Menghapus file download: {$title}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.downloads.index')->with('success', 'File download berhasil dihapus.');
    }
}
