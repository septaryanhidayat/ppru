<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnggotaDewan;
use App\Models\UnitPendidikan;
use App\Services\CmsAutoHealService;
use App\Services\WebpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class AdminDewanController extends Controller
{
    protected WebpService $webpService;

    public function __construct(WebpService $webpService)
    {
        $this->webpService = $webpService;
        CmsAutoHealService::ensureUnitPendidikanSchemaExists();
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $hasUnitCol = Schema::hasTable('dewan_asatidz') && Schema::hasColumn('dewan_asatidz', 'unit_pendidikan_id');

        if ($user?->isUnitAdmin()) {
            $query = AnggotaDewan::query();
            if ($hasUnitCol) {
                $query->where('unit_pendidikan_id', $user->unit_pendidikan_id)
                    ->orWhere('fraction', $user->unit?->short_name);
            } else {
                $query->where('fraction', $user->unit?->short_name);
            }
            $dewan = $query->orderBy('order', 'asc')->get();
            $tree = null;
        } else {
            $dewan = AnggotaDewan::orderBy('order', 'asc')->get();
            $tree = AnggotaDewan::getHierarchyTree();
        }

        return view('admin.dewan.index', compact('dewan', 'tree'));
    }

    public function create()
    {
        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.dewan.create', compact('units'));
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'fraction' => 'nullable|string|max:255',
            'unit_pendidikan_id' => 'nullable|integer|exists:unit_pendidikans,id',
            'profile_summary' => 'nullable|string',
            'education' => 'nullable|string',
            'order' => 'nullable|integer',
            'photo' => 'nullable|image|max:3072',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $converted = $this->webpService->processUploadedFile($file, 'dewan', 85, 1200);
            if ($converted['success']) {
                $photoPath = $converted['url'];
            }
        }

        $unitId = $user?->isUnitAdmin() ? $user->unit_pendidikan_id : ($validated['unit_pendidikan_id'] ?? null);
        $fraction = $user?->isUnitAdmin()
            ? ($user->unit?->short_name ?: 'Dewan Guru')
            : ($validated['fraction'] ?? 'Dewan Guru & Asatidz PPRU');

        $dewan = AnggotaDewan::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'position' => $validated['position'],
            'fraction' => $fraction,
            'unit_pendidikan_id' => $unitId,
            'profile_summary' => $validated['profile_summary'] ?? '',
            'education' => $validated['education'] ?? '',
            'photo' => $photoPath ?? '/uploads/official/logo-ru-berwarna.png',
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dewan_create',
            'description' => 'Menambahkan anggota dewan guru baru: '.$dewan->name,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.dewan.index')->with('success', 'Data tenaga pendidik berhasil ditambahkan!');
    }

    public function edit(Request $request, AnggotaDewan $dewan)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin() && $dewan->unit_pendidikan_id !== $user->unit_pendidikan_id && $dewan->fraction !== $user->unit?->short_name) {
            abort(403, 'Anda hanya berhak mengelola dewan guru untuk unit Anda.');
        }

        $units = UnitPendidikan::orderBy('order', 'asc')->get();

        return view('admin.dewan.edit', compact('dewan', 'units'));
    }

    public function update(Request $request, AnggotaDewan $dewan)
    {
        $user = $request->user();
        if ($user?->isUnitAdmin()) {
            if ($dewan->unit_pendidikan_id !== $user->unit_pendidikan_id && $dewan->fraction !== $user->unit?->short_name) {
                abort(403, 'Anda hanya berhak mengelola dewan guru untuk unit Anda.');
            }
            if ($dewan->fraction === 'Yayasan') {
                abort(403, 'Pengurus Yayasan hanya dapat diubah oleh Administrator Utama.');
            }
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'fraction' => 'nullable|string|max:255',
            'unit_pendidikan_id' => 'nullable|integer|exists:unit_pendidikans,id',
            'profile_summary' => 'nullable|string',
            'education' => 'nullable|string',
            'order' => 'nullable|integer',
            'photo' => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $converted = $this->webpService->processUploadedFile($file, 'dewan', 85, 1200);
            if ($converted['success']) {
                $dewan->photo = $converted['url'];
            }
        }

        $dewan->name = $validated['name'];
        $dewan->position = $validated['position'];
        if (! $user?->isUnitAdmin()) {
            $dewan->fraction = $validated['fraction'] ?? $dewan->fraction ?? 'Dewan Guru & Asatidz PPRU';
            if ($request->has('unit_pendidikan_id')) {
                $dewan->unit_pendidikan_id = $validated['unit_pendidikan_id'] ?: null;
            }
        } else {
            $dewan->unit_pendidikan_id = $user->unit_pendidikan_id;
        }

        $dewan->profile_summary = $validated['profile_summary'] ?? '';
        $dewan->education = $validated['education'] ?? '';
        $dewan->order = $validated['order'] ?? 0;
        $dewan->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dewan_update',
            'description' => "Memperbarui data Anggota Dewan: {$dewan->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.dewan.index')->with('success', 'Data Anggota Dewan berhasil diperbarui.');
    }

    public function destroy(Request $request, AnggotaDewan $dewan)
    {
        $user = $request->user();
        if ($dewan->fraction === 'Yayasan') {
            abort(403, 'Data Pengurus Yayasan dilindungi dan tidak dapat dihapus.');
        }

        if ($user?->isUnitAdmin() && $dewan->unit_pendidikan_id !== $user->unit_pendidikan_id && $dewan->fraction !== $user->unit?->short_name) {
            abort(403, 'Anda hanya berhak mengelola dewan guru untuk unit Anda.');
        }

        $name = $dewan->name;
        $dewan->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dewan_delete',
            'description' => "Menghapus data Anggota Dewan: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.dewan.index')->with('success', 'Data Anggota Dewan berhasil dihapus.');
    }
}
