<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\UnitPendidikan;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminUnitPendidikanController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    public function index()
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.unit_pendidikan.index', compact('units'));
    }

    public function create()
    {
        return view('admin.unit_pendidikan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'category_type' => 'required|string|max:100',
            'curriculum' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:100',
            'head_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'website_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $thumbnailPath = $validated['thumbnail'] ?? null;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'unit_pendidikan', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        }

        $baseSlug = Str::slug($validated['name']);
        $slug = $baseSlug;
        $counter = 1;
        while (UnitPendidikan::where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $unit = UnitPendidikan::create([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'] ?? null,
            'slug' => $slug,
            'category_type' => $validated['category_type'],
            'curriculum' => $validated['curriculum'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'head_name' => $validated['head_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'description' => $validated['description'] ?? '',
            'icon' => $validated['icon'] ?? 'fa-solid fa-graduation-cap',
            'thumbnail' => $thumbnailPath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'unit_pendidikan_create',
            'description' => "Menambahkan Unit Pendidikan: {$unit->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.unit-pendidikan.index')->with('success', 'Unit Pendidikan berhasil ditambahkan.');
    }

    public function edit(UnitPendidikan $unitPendidikan)
    {
        return view('admin.unit_pendidikan.edit', ['unit' => $unitPendidikan]);
    }

    public function update(Request $request, UnitPendidikan $unitPendidikan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'nullable|string|max:50',
            'category_type' => 'required|string|max:100',
            'curriculum' => 'nullable|string|max:255',
            'badge' => 'nullable|string|max:100',
            'head_name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'website_url' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $thumbnailPath = $unitPendidikan->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'unit_pendidikan', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        } elseif (! empty($validated['thumbnail'])) {
            $thumbnailPath = $validated['thumbnail'];
        }

        if ($unitPendidikan->name !== $validated['name']) {
            $baseSlug = Str::slug($validated['name']);
            $slug = $baseSlug;
            $counter = 1;
            while (UnitPendidikan::where('slug', $slug)->where('id', '!=', $unitPendidikan->id)->exists()) {
                $slug = "{$baseSlug}-{$counter}";
                $counter++;
            }
            $unitPendidikan->slug = $slug;
        }

        $unitPendidikan->update([
            'name' => $validated['name'],
            'short_name' => $validated['short_name'] ?? null,
            'category_type' => $validated['category_type'],
            'curriculum' => $validated['curriculum'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'head_name' => $validated['head_name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'website_url' => $validated['website_url'] ?? null,
            'description' => $validated['description'] ?? '',
            'icon' => $validated['icon'] ?? $unitPendidikan->icon,
            'thumbnail' => $thumbnailPath,
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'unit_pendidikan_update',
            'description' => "Memperbarui Unit Pendidikan: {$unitPendidikan->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.unit-pendidikan.index')->with('success', 'Unit Pendidikan berhasil diperbarui.');
    }

    public function destroy(Request $request, UnitPendidikan $unitPendidikan)
    {
        $name = $unitPendidikan->name;
        $unitPendidikan->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'unit_pendidikan_delete',
            'description' => "Menghapus Unit Pendidikan: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.unit-pendidikan.index')->with('success', 'Unit Pendidikan berhasil dihapus.');
    }
}
