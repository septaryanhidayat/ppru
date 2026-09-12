<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PpdbRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPpdbController extends Controller
{
    public function index(Request $request)
    {
        $query = PpdbRegistration::latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('registration_number', 'like', "%{$search}%")
                    ->orWhere('previous_school', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $registrations = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => PpdbRegistration::count(),
            'pending' => PpdbRegistration::where('status', 'pending')->count(),
            'verified' => PpdbRegistration::where('status', 'verified')->count(),
            'accepted' => PpdbRegistration::where('status', 'accepted')->count(),
            'rejected' => PpdbRegistration::where('status', 'rejected')->count(),
        ];

        return view('admin.ppdb.index', compact('registrations', 'stats'));
    }

    public function show(PpdbRegistration $ppdb)
    {
        return view('admin.ppdb.show', compact('ppdb'));
    }

    public function updateStatus(Request $request, PpdbRegistration $ppdb)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,verified,accepted,rejected',
            'notes' => 'nullable|string|max:1000',
        ]);

        $ppdb->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'ppdb_status_update',
            'description' => "Memperbarui status pendaftaran {$ppdb->full_name} ({$ppdb->registration_number}) menjadi {$ppdb->status_label}",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return back()->with('success', "Status pendaftaran {$ppdb->full_name} berhasil diperbarui!");
    }

    public function destroy(Request $request, PpdbRegistration $ppdb)
    {
        $name = $ppdb->full_name;
        $regNumber = $ppdb->registration_number;
        $ppdb->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'ppdb_delete',
            'description' => "Menghapus data pendaftaran PPDB: {$name} ({$regNumber})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.ppdb.index')->with('success', "Data pendaftaran {$name} berhasil dihapus.");
    }

    public function print(PpdbRegistration $ppdb)
    {
        return view('admin.ppdb.print', compact('ppdb'));
    }
}
