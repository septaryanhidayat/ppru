<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Services\CmsAutoHealService;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminTestimonialController extends Controller
{
    public function __construct(protected WebpService $webpService)
    {
        CmsAutoHealService::ensureUnitPendidikanSchemaExists();
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $query = Testimonial::query();
        $hasUnitCol = Schema::hasTable('testimonials') && Schema::hasColumn('testimonials', 'unit_pendidikan_id');

        if ($user?->isUnitAdmin() && $hasUnitCol) {
            $query->where('unit_pendidikan_id', $user->unit_pendidikan_id);
        }

        $testimonials = $query->orderBy('id', 'desc')->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.testimonials.create', compact('units'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'photo' => 'nullable|string|max:255',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'unit_pendidikan_id' => 'nullable|integer|exists:unit_pendidikans,id',
            'status' => 'required|in:publish,draft',
        ]);

        $photoPath = $validated['photo'] ?? null;
        if ($request->hasFile('photo_file')) {
            $converted = $this->webpService->processUploadedFile(
                $request->file('photo_file'),
                'testimonials',
                82,
                800
            );
            if ($converted['success']) {
                $photoPath = $converted['url'];
            }
        }

        $unitId = $user?->isUnitAdmin() ? $user->unit_pendidikan_id : ($validated['unit_pendidikan_id'] ?? null);

        $testimonial = Testimonial::create([
            'name' => $validated['name'],
            'profession' => $validated['profession'] ?? '',
            'content' => $validated['content'],
            'photo' => $photoPath,
            'unit_pendidikan_id' => $unitId,
            'status' => $validated['status'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'testimonial_create',
            'description' => "Menambahkan Testimonial baru dari: {$testimonial->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil ditambahkan.');
    }

    public function edit(Request $request, Testimonial $testimonial)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && (int) $testimonial->unit_pendidikan_id !== (int) $user->unit_pendidikan_id) {
            abort(403, 'Anda hanya berhak mengelola testimoni untuk unit Anda.');
        }

        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.testimonials.edit', compact('testimonial', 'units'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && (int) $testimonial->unit_pendidikan_id !== (int) $user->unit_pendidikan_id) {
            abort(403, 'Anda hanya berhak mengelola testimoni untuk unit Anda.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profession' => 'nullable|string|max:255',
            'content' => 'required|string|max:2000',
            'photo' => 'nullable|string|max:255',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'unit_pendidikan_id' => 'nullable|integer|exists:unit_pendidikans,id',
            'status' => 'required|in:publish,draft',
        ]);

        $photoPath = $testimonial->photo;
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'testimonial_'.time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('uploads/testimonials'), $filename);
            $photoPath = '/uploads/testimonials/'.$filename;
        } elseif ($request->filled('photo')) {
            $photoPath = $validated['photo'];
        }

        $unitId = $user?->isUnitAdmin() ? $user->unit_pendidikan_id : ($validated['unit_pendidikan_id'] ?? null);

        $testimonial->update([
            'name' => $validated['name'],
            'profession' => $validated['profession'] ?? '',
            'content' => $validated['content'],
            'photo' => $photoPath,
            'unit_pendidikan_id' => $unitId,
            'status' => $validated['status'],
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'testimonial_update',
            'description' => "Memperbarui Testimonial dari: {$testimonial->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Request $request, Testimonial $testimonial)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && (int) $testimonial->unit_pendidikan_id !== (int) $user->unit_pendidikan_id) {
            abort(403, 'Anda hanya berhak menghapus testimoni unit Anda.');
        }

        $name = $testimonial->name;
        $testimonial->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'testimonial_delete',
            'description' => "Menghapus Testimonial dari: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial berhasil dihapus.');
    }
}
