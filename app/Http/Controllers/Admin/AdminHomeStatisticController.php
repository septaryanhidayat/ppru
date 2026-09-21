<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\HomeStatistic;
use App\Services\CmsAutoHealService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminHomeStatisticController extends Controller
{
    /**
     * Display a listing of home statistics.
     */
    public function index()
    {
        CmsAutoHealService::ensureHomeStatisticsTableExists();

        $statistics = HomeStatistic::orderBy('order', 'asc')->get();

        return view('admin.home-statistics.index', compact('statistics'));
    }

    /**
     * Store a newly created statistic in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        if (! isset($validated['order']) || $validated['order'] === null) {
            $validated['order'] = (HomeStatistic::max('order') ?? 0) + 1;
        }

        $stat = HomeStatistic::create($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'create_home_statistic',
            'description' => "Menambahkan kotak statistik beranda baru: {$stat->number} ({$stat->label})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.home-statistics.index')->with('success', 'Kotak statistik beranda baru berhasil ditambahkan.');
    }

    /**
     * Update the specified statistic in storage.
     */
    public function update(Request $request, HomeStatistic $home_statistic)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'order' => 'required|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;

        $home_statistic->update($validated);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'update_home_statistic',
            'description' => "Memperbarui kotak statistik beranda: {$home_statistic->number} ({$home_statistic->label})",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.home-statistics.index')->with('success', 'Kotak statistik beranda berhasil diperbarui.');
    }

    /**
     * Remove the specified statistic from storage.
     */
    public function destroy(HomeStatistic $home_statistic)
    {
        $label = "{$home_statistic->number} - {$home_statistic->label}";
        $home_statistic->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'delete_home_statistic',
            'description' => "Menghapus kotak statistik beranda: {$label}",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status' => 'warning',
        ]);

        return redirect()->route('admin.home-statistics.index')->with('success', "Kotak statistik \"{$label}\" berhasil dihapus.");
    }

    /**
     * Toggle active status of a statistic.
     */
    public function toggle(HomeStatistic $home_statistic)
    {
        $home_statistic->is_active = ! $home_statistic->is_active;
        $home_statistic->save();

        $statusText = $home_statistic->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Kotak statistik \"{$home_statistic->label}\" berhasil {$statusText}.");
    }
}
