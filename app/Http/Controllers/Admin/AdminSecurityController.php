<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSecurityController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::latest();

        if ($request->has('status') && in_array($request->input('status'), ['danger', 'warning', 'info'])) {
            $query->where('status', $request->input('status'));
        }

        if ($request->has('search') && ! empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        $stats = [
            'total' => ActivityLog::count(),
            'threats' => ActivityLog::where('status', 'danger')->count(),
            'warnings' => ActivityLog::where('status', 'warning')->count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
        ];

        return view('admin.security.index', compact('logs', 'stats'));
    }

    public function clear(Request $request)
    {
        if (! Auth::user()->isSuperAdmin() && ! Auth::user()->isAdmin()) {
            return back()->with('error', 'Hanya Administrator yang dapat mengosongkan log aktivitas.');
        }

        ActivityLog::where('status', 'info')->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'logs_cleared',
            'description' => 'Mengosongkan riwayat log aktivitas berkala (log keamanan/peringatan tetap tersimpan)',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        return back()->with('success', 'Riwayat log umum berhasil dibersihkan.');
    }
}
