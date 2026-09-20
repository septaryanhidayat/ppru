<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ProgramUnggulan;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminProgramUnggulanController extends Controller
{
    public function __construct(protected WebpService $webpService) {}

    public function index()
    {
        $programs = ProgramUnggulan::orderBy('order', 'asc')->get();

        return view('admin.program-unggulan.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.program-unggulan.create');
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
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'program-unggulan', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        }

        $program = ProgramUnggulan::create([
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
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'program_create',
            'description' => "Menambahkan program unggulan: {$program->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        $indexRoute = $request->routeIs('admin.dpc.*') || $request->is('*admin/dpc*') ? 'admin.dpc.index' : 'admin.program-unggulan.index';

        return redirect()->route($indexRoute)->with('success', 'Program unggulan santri berhasil ditambahkan.');
    }

    public function edit(Request $request, $programUnggulan)
    {
        if (! ($programUnggulan instanceof ProgramUnggulan)) {
            $programUnggulan = ProgramUnggulan::findOrFail($programUnggulan);
        }

        return view('admin.program-unggulan.edit', compact('programUnggulan'));
    }

    public function update(Request $request, $programUnggulan)
    {
        if (! ($programUnggulan instanceof ProgramUnggulan)) {
            $programUnggulan = ProgramUnggulan::findOrFail($programUnggulan);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'head_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|string',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'order' => 'nullable|integer',
        ]);

        $thumbnailPath = $programUnggulan->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            $converted = $this->webpService->processUploadedFile($request->file('thumbnail_file'), 'program-unggulan', 85, 1200);
            if ($converted['success']) {
                $thumbnailPath = $converted['url'];
            }
        } elseif (! empty($validated['thumbnail'])) {
            $thumbnailPath = $validated['thumbnail'];
        }

        $programUnggulan->update([
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
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'program_update',
            'description' => "Memperbarui program unggulan: {$programUnggulan->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        $indexRoute = $request->routeIs('admin.dpc.*') || $request->is('*admin/dpc*') ? 'admin.dpc.index' : 'admin.program-unggulan.index';

        return redirect()->route($indexRoute)->with('success', 'Program unggulan santri berhasil diperbarui.');
    }

    public function destroy(Request $request, $programUnggulan)
    {
        if (! ($programUnggulan instanceof ProgramUnggulan)) {
            $programUnggulan = ProgramUnggulan::findOrFail($programUnggulan);
        }

        $name = $programUnggulan->name;
        $programUnggulan->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name ?? 'Administrator',
            'action' => 'program_delete',
            'description' => "Menghapus program unggulan: {$name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'warning',
        ]);

        $indexRoute = request()->routeIs('admin.dpc.*') || request()->is('*admin/dpc*') ? 'admin.dpc.index' : 'admin.program-unggulan.index';

        return redirect()->route($indexRoute)->with('success', 'Program unggulan santri berhasil dihapus.');
    }
}
