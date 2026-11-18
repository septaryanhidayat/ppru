<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Alumni;
use App\Models\UnitPendidikan;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminAlumniController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $query = Alumni::query()->with('unitPendidikan');

        if ($user?->isUnitAdmin()) {
            $query->where('unit_pendidikan_id', $user->unit_pendidikan_id);
        } elseif ($unitId = $request->input('unit_id')) {
            $query->where('unit_pendidikan_id', $unitId);
        }

        // Filter Tahun Lulus
        $selectedYear = $request->input('year');
        if (! empty($selectedYear) && $selectedYear !== 'all') {
            $query->where('graduation_year', $selectedYear);
        }

        // Filter Gender (Segmen Putra / Putri)
        $selectedGender = $request->input('gender');
        if (in_array($selectedGender, ['putra', 'putri'])) {
            $query->where('gender', $selectedGender);
        }

        // Filter Pencarian Nama / Aktivitas
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('activity', 'like', "%{$search}%")
                    ->orWhere('bio', 'like', "%{$search}%");
            });
        }

        $counts = [
            'total' => Alumni::count(),
            'putra' => Alumni::where('gender', 'putra')->count(),
            'putri' => Alumni::where('gender', 'putri')->count(),
        ];

        // Daftar tahun kelulusan yang ada di database
        $availableYears = Alumni::select('graduation_year')
            ->distinct()
            ->orderBy('graduation_year', 'desc')
            ->pluck('graduation_year')
            ->filter()
            ->values();

        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        $alumnis = $query->orderBy('graduation_year', 'desc')
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.alumni.index', compact(
            'alumnis',
            'counts',
            'availableYears',
            'units',
            'selectedYear',
            'selectedGender'
        ));
    }

    public function create()
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();
        $currentYear = (int) date('Y');
        $yearsRange = range($currentYear, 1980);

        return view('admin.alumni.create', compact('units', 'yearsRange'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:putra,putri',
            'graduation_year' => 'required|string|max:10',
            'unit_pendidikan_id' => 'nullable|integer|exists:unit_pendidikans,id',
            'activity' => 'required|string|max:500',
            'photo' => 'nullable|image|max:3072',
            'phone' => 'nullable|string|max:50',
            'social_media' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $uploadDir = public_path('uploads/alumni');
            if (! file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = 'alumni_'.Str::slug($request->name).'_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $photoPath = '/uploads/alumni/'.$filename;
        }

        $alumni = Alumni::create([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'graduation_year' => $validated['graduation_year'],
            'unit_pendidikan_id' => $validated['unit_pendidikan_id'] ?? (Auth::user()?->isUnitAdmin() ? Auth::user()->unit_pendidikan_id : null),
            'activity' => $validated['activity'],
            'photo' => $photoPath,
            'phone' => $validated['phone'] ?? null,
            'social_media' => $validated['social_media'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'order' => $validated['order'] ?? 1,
            'is_published' => $request->has('is_published') ? (bool) $request->input('is_published') : true,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'alumni_create',
            'description' => "Menambahkan data alumni: {$alumni->name} ({$alumni->graduation_year})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.alumni.index')->with('success', "Data alumni {$alumni->name} berhasil ditambahkan.");
    }

    public function edit(Alumni $alumni)
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();
        $currentYear = (int) date('Y');
        $yearsRange = range($currentYear, 1980);

        return view('admin.alumni.edit', compact('alumni', 'units', 'yearsRange'));
    }

    public function update(Request $request, Alumni $alumni)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:putra,putri',
            'graduation_year' => 'required|string|max:10',
            'unit_pendidikan_id' => 'nullable|integer|exists:unit_pendidikans,id',
            'activity' => 'required|string|max:500',
            'photo' => 'nullable|image|max:3072',
            'phone' => 'nullable|string|max:50',
            'social_media' => 'nullable|string|max:150',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_published' => 'nullable|boolean',
        ]);

        $photoPath = $alumni->photo;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $uploadDir = public_path('uploads/alumni');
            if (! file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $filename = 'alumni_'.Str::slug($request->name).'_'.time().'.'.$file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $photoPath = '/uploads/alumni/'.$filename;
        }

        $alumni->update([
            'name' => $validated['name'],
            'gender' => $validated['gender'],
            'graduation_year' => $validated['graduation_year'],
            'unit_pendidikan_id' => $validated['unit_pendidikan_id'] ?? $alumni->unit_pendidikan_id,
            'activity' => $validated['activity'],
            'photo' => $photoPath,
            'phone' => $validated['phone'] ?? null,
            'social_media' => $validated['social_media'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'order' => $validated['order'] ?? $alumni->order,
            'is_published' => $request->has('is_published') ? (bool) $request->input('is_published') : $alumni->is_published,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'alumni_update',
            'description' => "Memperbarui data alumni: {$alumni->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('admin.alumni.index')->with('success', "Data alumni {$alumni->name} berhasil diperbarui.");
    }

    public function destroy(Alumni $alumni)
    {
        $name = $alumni->name;
        $alumni->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'alumni_delete',
            'description' => "Menghapus data alumni: {$name}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('admin.alumni.index')->with('success', "Data alumni {$name} berhasil dihapus.");
    }
}
