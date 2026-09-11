<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminAnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', '7days');

        $hasVisitorLogs = false;
        try {
            $hasVisitorLogs = Schema::hasTable('visitor_logs');
        } catch (\Throwable $e) {
            $hasVisitorLogs = false;
        }

        if (! $hasVisitorLogs) {
            return view('admin.analytics.index', [
                'hasVisitorLogs' => false,
                'period' => $period,
                'totalPageviews' => 0,
                'uniqueVisitors' => 0,
                'todayPageviews' => 0,
                'todayUniques' => 0,
                'yesterdayPageviews' => 0,
                'yesterdayUniques' => 0,
                'mobilePercentage' => 0,
                'chartLabels' => [],
                'chartPageviews' => [],
                'chartUniques' => [],
                'topPages' => collect(),
                'trafficSources' => collect(),
                'topLocations' => collect(),
                'devices' => collect(),
                'browsers' => collect(),
                'platforms' => collect(),
                'recentVisits' => collect(),
                'totalBotsBlocked' => 0,
            ]);
        }

        // Query dasar (hanya pengunjung manusia asli)
        $baseQuery = VisitorLog::humans();

        switch ($period) {
            case 'today':
                $baseQuery->today();
                break;
            case '30days':
                $baseQuery->recentDays(30);
                break;
            case 'all':
                // Tanpa filter waktu
                break;
            case '7days':
            default:
                $period = '7days';
                $baseQuery->recentDays(7);
                break;
        }

        // 1. KPI Metrik Utama
        $totalPageviews = (clone $baseQuery)->count();
        $uniqueVisitors = (clone $baseQuery)->distinct('ip_address')->count('ip_address');

        $todayPageviews = VisitorLog::humans()->today()->count();
        $todayUniques = VisitorLog::humans()->today()->distinct('ip_address')->count('ip_address');

        $yesterdayPageviews = VisitorLog::humans()->yesterday()->count();
        $yesterdayUniques = VisitorLog::humans()->yesterday()->distinct('ip_address')->count('ip_address');

        // Perhitungan persentase perangkat mobile
        $mobileVisits = (clone $baseQuery)->where('device_type', 'Mobile')->count();
        $mobilePercentage = $totalPageviews > 0 ? round(($mobileVisits / $totalPageviews) * 100, 1) : 0;

        // 2. Data Grafik Tren (Chart.js)
        $chartLabels = [];
        $chartPageviews = [];
        $chartUniques = [];

        if ($period === 'today') {
            // Tren per jam untuk hari ini (00:00 - sekarang)
            $isSqlite = DB::connection()->getDriverName() === 'sqlite';
            $hourExpr = $isSqlite ? "CAST(strftime('%H', created_at) AS INTEGER)" : 'HOUR(created_at)';

            $hourlyData = VisitorLog::humans()
                ->today()
                ->selectRaw("{$hourExpr} as hour, count(*) as views")
                ->groupBy('hour')
                ->pluck('views', 'hour')
                ->toArray();

            $hourlyUniques = VisitorLog::humans()
                ->today()
                ->selectRaw("{$hourExpr} as hour, count(distinct ip_address) as uniques")
                ->groupBy('hour')
                ->pluck('uniques', 'hour')
                ->toArray();

            $currentHour = (int) now()->format('H');
            for ($h = 0; $h <= min(23, $currentHour); $h++) {
                $chartLabels[] = sprintf('%02d:00', $h);
                $chartPageviews[] = $hourlyData[$h] ?? 0;
                $chartUniques[] = $hourlyUniques[$h] ?? 0;
            }
        } else {
            // Tren per tanggal
            $daysCount = $period === '30days' ? 30 : ($period === 'all' ? 60 : 7);
            for ($i = $daysCount - 1; $i >= 0; $i--) {
                $date = now()->subDays($i)->toDateString();
                $label = now()->subDays($i)->translatedFormat('d M');
                $chartLabels[] = $label;

                $dayViews = VisitorLog::humans()->whereDate('created_at', $date)->count();
                $dayUniques = VisitorLog::humans()->whereDate('created_at', $date)->distinct('ip_address')->count('ip_address');

                $chartPageviews[] = $dayViews;
                $chartUniques[] = $dayUniques;
            }
        }

        // 3. Top Halaman & Artikel yang Sedang Tren Dibaca
        $topPages = (clone $baseQuery)
            ->select('path')
            ->selectRaw('MAX(page_title) as title, COUNT(*) as views, COUNT(DISTINCT ip_address) as unique_views')
            ->groupBy('path')
            ->orderByDesc('views')
            ->take(10)
            ->get();

        // 4. Sumber Rujukan (Traffic Sources / Referers)
        $trafficSources = (clone $baseQuery)
            ->select('referer_source')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('referer_source')
            ->orderByDesc('total')
            ->get();

        // 5. Asal Wilayah Pengunjung (Kota & Provinsi)
        $topLocations = (clone $baseQuery)
            ->select('city', 'region', 'country')
            ->selectRaw('COUNT(*) as total, COUNT(DISTINCT ip_address) as uniques')
            ->groupBy('city', 'region', 'country')
            ->orderByDesc('total')
            ->take(10)
            ->get();

        // 6. Komposisi Perangkat & Browser
        $devices = (clone $baseQuery)
            ->select('device_type')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        $browsers = (clone $baseQuery)
            ->select('browser')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        $platforms = (clone $baseQuery)
            ->select('platform')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('platform')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // 7. Riwayat Kunjungan Pengunjung Terbaru (Real-Time Feed)
        $recentVisits = VisitorLog::humans()
            ->latest()
            ->take(25)
            ->get();

        // 8. Total Bot yang Dikecualikan
        $totalBotsBlocked = VisitorLog::where('is_bot', true)->count();

        return view('admin.analytics.index', compact(
            'hasVisitorLogs',
            'period',
            'totalPageviews',
            'uniqueVisitors',
            'todayPageviews',
            'todayUniques',
            'yesterdayPageviews',
            'yesterdayUniques',
            'mobilePercentage',
            'chartLabels',
            'chartPageviews',
            'chartUniques',
            'topPages',
            'trafficSources',
            'topLocations',
            'devices',
            'browsers',
            'platforms',
            'recentVisits',
            'totalBotsBlocked'
        ));
    }

    /**
     * Bersihkan log lama agar database tetap efisien.
     */
    public function prune(Request $request)
    {
        if (! Schema::hasTable('visitor_logs')) {
            return redirect()->route('admin.analytics.index')
                ->with('error', 'Tabel visitor_logs belum dibuat di database.');
        }

        $days = (int) $request->input('days', 90);
        if ($days < 7) {
            $days = 7;
        }

        $deleted = VisitorLog::where('created_at', '<', now()->subDays($days))->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()?->name ?? 'Admin',
            'action' => 'analytics_prune',
            'description' => "Membersihkan {$deleted} log kunjungan pengunjung lebih dari {$days} hari.",
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'info',
        ]);

        return redirect()->route('admin.analytics.index')
            ->with('success', "Berhasil membersihkan {$deleted} data log lama.");
    }
}
