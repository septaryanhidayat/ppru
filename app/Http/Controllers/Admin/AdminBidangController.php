<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Bidang;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminBidangController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
    }

    public function index()
    {
        $bidangs = Bidang::orderBy('order', 'asc')->get();

        return view('admin.bidang.index', compact('bidangs'));
    }

    public function create()
    {
        return view('admin.bidang.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'icon' => 'nullable|string',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $iconPath = $validated['icon'] ?? 'fa-solid fa-school';
        if ($request->hasFile('icon_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('icon_file'), 'bidang', 90, 512);
            if ($converted['success']) {
                $iconPath = $converted['url'];
            }
        }

        $thumbnailPath = $validated['thumbnail'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'bidang', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        }

        $bidang = Bidang::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? '',
            'address' => $validated['address'] ?? '',
            'phone' => $validated['phone'] ?? '',
            'email' => $validated['email'] ?? '',
            'icon' => $iconPath,
            'thumbnail' => $thumbnailPath,
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'bidang_create',
            'description' => "Menambahkan Fasilitas & Sarana Sekolah: {$bidang->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.bidang.index')->with('success', 'Fasilitas & Sarana Sekolah berhasil ditambahkan.');
    }

    public function edit(Bidang $bidang)
    {
        return view('admin.bidang.edit', compact('bidang'));
    }

    public function update(Request $request, Bidang $bidang)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'icon' => 'nullable|string',
            'icon_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $iconPath = $bidang->icon;
        if ($request->hasFile('icon_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('icon_file'), 'bidang', 90, 512);
            if ($converted['success']) {
                $iconPath = $converted['url'];
            }
        } elseif ($request->filled('icon')) {
            $iconPath = $validated['icon'];
        }

        $thumbnailPath = $bidang->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'bidang', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        } elseif ($request->filled('thumbnail')) {
            $thumbnailPath = $validated['thumbnail'];
        }

        $bidang->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? '',
            'address' => $validated['address'] ?? '',
            'phone' => $validated['phone'] ?? '',
            'email' => $validated['email'] ?? '',
            'icon' => $iconPath,
            'thumbnail' => $thumbnailPath,
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'bidang_update',
            'description' => "Memperbarui Fasilitas & Sarana Sekolah: {$bidang->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.bidang.index')->with('success', 'Fasilitas & Sarana Sekolah berhasil diperbarui.');
    }

    public function destroy(Request $request, Bidang $bidang)
    {
        $name = $bidang->name;
        $bidang->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'bidang_delete',
            'description' => "Menghapus Fasilitas & Sarana Sekolah: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.bidang.index')->with('success', 'Fasilitas & Sarana Sekolah berhasil dihapus.');
    }
}
