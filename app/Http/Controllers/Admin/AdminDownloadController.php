<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminDownloadController extends Controller
{
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_type' => 'required|string|max:100',
            'file_path' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:20480', // max 20MB
        ]);

        $filePath = $validated['file_path'] ?? '';
        $fileType = 'PNG/PDF';
        $fileSize = '1.2 MB';

        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $filename = time().'_'.$uploaded->getClientOriginalName();
            $uploaded->move(public_path('uploads/downloads'), $filename);
            $filePath = '/uploads/downloads/'.$filename;
            $fileType = strtoupper($uploaded->getClientOriginalExtension());
            $bytes = filesize(public_path('uploads/downloads/'.$filename));
            $fileSize = round($bytes / (1024 * 1024), 2).' MB';
        }

        $download = Download::create([
            'title' => $validated['title'],
            'category_type' => $validated['category_type'],
            'file_path' => $filePath,
            'file_type' => $fileType,
            'file_size' => $fileSize,
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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_type' => 'required|string|max:100',
            'file_path' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:20480',
        ]);

        if ($request->hasFile('file')) {
            $uploaded = $request->file('file');
            $filename = time().'_'.$uploaded->getClientOriginalName();
            $uploaded->move(public_path('uploads/downloads'), $filename);
            $download->file_path = '/uploads/downloads/'.$filename;
            $download->file_type = strtoupper($uploaded->getClientOriginalExtension());
            $bytes = filesize(public_path('uploads/downloads/'.$filename));
            $download->file_size = round($bytes / (1024 * 1024), 2).' MB';
        } elseif (! empty($validated['file_path'])) {
            $download->file_path = $validated['file_path'];
        }

        $download->title = $validated['title'];
        $download->category_type = $validated['category_type'];
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
