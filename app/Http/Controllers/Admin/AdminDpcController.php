<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Dpc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDpcController extends Controller
{
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
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $dpc = Dpc::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'head_name' => $validated['head_name'] ?? '',
            'address' => $validated['address'] ?? '',
            'description' => $validated['description'] ?? '',
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dpc_create',
            'description' => "Menambahkan DPC Kecamatan: {$dpc->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.dpc.index')->with('success', 'DPC Kecamatan berhasil ditambahkan.');
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
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $dpc->update([
            'name' => $validated['name'],
            'head_name' => $validated['head_name'] ?? '',
            'address' => $validated['address'] ?? '',
            'description' => $validated['description'] ?? '',
            'order' => $validated['order'] ?? 0,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dpc_update',
            'description' => "Memperbarui DPC Kecamatan: {$dpc->name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.dpc.index')->with('success', 'DPC Kecamatan berhasil diperbarui.');
    }

    public function destroy(Request $request, Dpc $dpc)
    {
        $name = $dpc->name;
        $dpc->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'dpc_delete',
            'description' => "Menghapus DPC Kecamatan: {$name}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.dpc.index')->with('success', 'DPC Kecamatan berhasil dihapus.');
    }
}
