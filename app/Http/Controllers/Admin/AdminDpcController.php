<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Dpc;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDpcController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
    }

    public function index()
    {
        $dpcs = Dpc::orderBy('order', 'asc')->get();

        return view('admin.dpc.index', compact('dpcs'));
    }

    public function create()
    {
        return view('admin.dpc.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'head_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $thumbnailPath = $validated['thumbnail'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'dpc', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        }

        $dpc = Dpc::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'head_name' => $validated['head_name'] ?? '',
            'address' => $validated['address'] ?? '',
            'description' => $validated['description'] ?? '',
            'thumbnail' => $thumbnailPath,
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dpc_create',
            'description' => "Menambahkan Program Unggulan Sekolah: {$dpc->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.dpc.index')->with('success', 'Program Unggulan berhasil ditambahkan.');
    }

    public function edit(Dpc $dpc)
    {
        return view('admin.dpc.edit', compact('dpc'));
    }

    public function update(Request $request, Dpc $dpc)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'head_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $thumbnailPath = $dpc->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'dpc', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        } elseif ($request->filled('thumbnail')) {
            $thumbnailPath = $validated['thumbnail'];
        }

        $dpc->update([
            'name' => $validated['name'],
            'head_name' => $validated['head_name'] ?? '',
            'address' => $validated['address'] ?? '',
            'description' => $validated['description'] ?? '',
            'thumbnail' => $thumbnailPath,
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dpc_update',
            'description' => "Memperbarui Program Unggulan Sekolah: {$dpc->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.dpc.index')->with('success', 'Program Unggulan berhasil diperbarui.');
    }

    public function destroy(Request $request, Dpc $dpc)
    {
        $name = $dpc->name;
        $dpc->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dpc_delete',
            'description' => "Menghapus Program Unggulan Sekolah: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.dpc.index')->with('success', 'Program Unggulan berhasil dihapus.');
    }
}
