<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Agenda;
use App\Models\AnggotaDewan;
use App\Models\Bidang;
use App\Models\Download;
use App\Models\Dpc;
use App\Models\Feedback;
use App\Models\Pengumuman;
use App\Models\Post;
use App\Models\PpdbRegistration;
use App\Models\ServiceSubmission;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Models\UnitPendidikan;
use App\Models\User;
use App\Models\Video;
use App\Models\VisitorLog;
use App\Services\UnitAccountService;
use App\Services\UnitDemoContentService;
use App\Services\VisitorTrackerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Dedicated scoped dashboard for Unit Admins
        if ($user?->isUnitAdmin()) {
            $unit = $user->unit;
            $unitId = $user->unit_pendidikan_id;

            // Auto-heal and seed demo content if unit data is missing
            if ($unit) {
                UnitDemoContentService::seedUnitIfEmpty($unit);
            }

            $stats = [
                'total_posts' => Post::where('type', 'post')->where('unit_pendidikan_id', $unitId)->count(),
                'total_views' => Post::where('type', 'post')->where('unit_pendidikan_id', $unitId)->sum('views_count'),
                'total_photos' => Post::where('type', 'gallery')->where('unit_pendidikan_id', $unitId)->count(),
                'total_videos' => Video::where('unit_pendidikan_id', $unitId)->count(),
                'total_teachers' => AnggotaDewan::where('unit_pendidikan_id', $unitId)->count(),
                'total_testimonials' => Testimonial::where('unit_pendidikan_id', $unitId)->count(),
                'total_prestasi' => Post::where('type', 'prestasi')->where('unit_pendidikan_id', $unitId)->count(),
                'total_ekskul' => Post::where('type', 'ekskul')->where('unit_pendidikan_id', $unitId)->count(),
                'total_ppdb' => PpdbRegistration::where(function ($q) use ($unit) {
                    if ($unit) {
                        $q->where('program_type', 'like', "%{$unit->short_name}%")
                            ->orWhere('program_type', 'like', "%{$unit->name}%");
                    }
                })->count(),
            ];

            $recentPosts = Post::where('type', 'post')->where('unit_pendidikan_id', $unitId)->latest()->take(6)->get();
            $recentPhotos = Post::where('type', 'gallery')->where('unit_pendidikan_id', $unitId)->latest()->take(6)->get();
            $recentVideos = Video::where('unit_pendidikan_id', $unitId)->latest()->take(4)->get();
            $recentTeachers = AnggotaDewan::where('unit_pendidikan_id', $unitId)->orderBy('order', 'asc')->take(6)->get();
            $recentTestimonials = Testimonial::where('unit_pendidikan_id', $unitId)->latest()->take(4)->get();
            $recentPrestasi = Post::where('type', 'prestasi')->where('unit_pendidikan_id', $unitId)->latest()->take(4)->get();
            $recentEkskul = Post::where('type', 'ekskul')->where('unit_pendidikan_id', $unitId)->latest()->take(4)->get();

            return view('admin.dashboard', compact(
                'unit',
                'stats',
                'recentPosts',
                'recentPhotos',
                'recentVideos',
                'recentTeachers',
                'recentTestimonials',
                'recentPrestasi',
                'recentEkskul'
            ));
        }

        $hasVisitorLogs = false;
        $todayVisitors = 0;
        $todayPageviews = 0;
        $weekVisitors = 0;
        $topTodayPages = collect();
        $topTodayReferrers = collect();
        $topCities = collect();

        try {
            if (Schema::hasTable('visitor_logs')) {
                $hasVisitorLogs = true;
                $todayVisitors = VisitorLog::humans()->today()->distinct('ip_address')->count('ip_address');
                $todayPageviews = VisitorLog::humans()->today()->count();
                $weekVisitors = VisitorLog::humans()->recentDays(7)->distinct('ip_address')->count('ip_address');

                $topTodayPages = VisitorLog::humans()->today()
                    ->select('path')
                    ->selectRaw('MAX(page_title) as title, count(*) as views')
                    ->groupBy('path')
                    ->orderByDesc('views')
                    ->take(4)
                    ->get();

                $topTodayReferrers = VisitorLog::humans()->today()
                    ->select('referer_source')
                    ->selectRaw('count(*) as total')
                    ->groupBy('referer_source')
                    ->orderByDesc('total')
                    ->take(4)
                    ->get();

                $topCities = VisitorLog::humans()->recentDays(7)
                    ->whereNotNull('city')
                    ->select('city', 'region')
                    ->selectRaw('count(*) as total')
                    ->groupBy('city', 'region')
                    ->orderByDesc('total')
                    ->take(4)
                    ->get();
            }
        } catch (\Throwable $e) {
            $hasVisitorLogs = false;
        }

        $stats = [
            'total_posts' => Post::where('type', 'post')->count(),
            'total_views' => Post::where('type', 'post')->sum('views_count'),
            'visitor_hits' => VisitorTrackerService::getVisitorHits(),
            'today_visitors' => $todayVisitors,
            'today_pageviews' => $todayPageviews,
            'week_visitors' => $weekVisitors,
            'total_units' => UnitPendidikan::count(),
            'total_ppdb' => PpdbRegistration::count(),
            'total_ppdb_verified' => PpdbRegistration::where('status', 'verified')->count(),
            'total_services' => ServiceSubmission::count(),
            'pending_services' => ServiceSubmission::where('status', 'pending')->count(),
            'total_dewan' => AnggotaDewan::count(),
            'total_bidang' => Bidang::count(),
            'total_programs' => Dpc::count(),
            'total_agendas' => Agenda::count(),
            'total_pengumuman' => Pengumuman::count(),
            'total_downloads' => Download::count(),
            'total_users' => User::count(),
            'total_photos' => Post::where('type', 'gallery')->orWhere('type', 'attachment')->count(),
            'total_videos' => Video::count(),
            'total_feedbacks' => Feedback::count(),
            'unread_feedbacks' => Feedback::where('status', 'unread')->count(),
            'security_threats' => ActivityLog::where('status', 'danger')->count(),
            'security_warnings' => ActivityLog::where('status', 'warning')->count(),
        ];

        $systemInfo = [
            'official_url' => 'https://ppru.ac.id',
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'db_driver' => config('database.default'),
            'server_time' => now()->format('d M Y - H:i:s').' WIB',
            'app_env' => config('app.env'),
            'debug_mode' => config('app.debug') ? 'Enabled' : 'Disabled',
            'memory_usage' => round(memory_get_usage(true) / 1024 / 1024, 2).' MB',
        ];

        $recentPosts = Post::where('type', 'post')->latest()->take(6)->get();
        $recentLogs = ActivityLog::latest()->take(8)->get();
        $recentThreats = ActivityLog::where('status', 'danger')->latest()->take(4)->get();

        $isMaintenance = (string) Setting::get('maintenance_mode', '0') === '1';
        $maintenanceTitle = Setting::get('maintenance_title', 'Pemeliharaan Sistem Berkala');
        $maintenanceMessage = Setting::get('maintenance_message', 'Mohon maaf atas ketidaknyamanannya. Website resmi Pondok Pesantren Raudhatul Ulum Sakatiga sedang dalam pemeliharaan sistem rutin untuk meningkatkan kualitas layanan dan performa. Kami akan segera kembali online.');

        $unitAdmins = UnitAccountService::getUnitAdminsSummary();

        return view('admin.dashboard', compact(
            'stats',
            'systemInfo',
            'recentPosts',
            'recentLogs',
            'recentThreats',
            'topTodayPages',
            'topTodayReferrers',
            'topCities',
            'hasVisitorLogs',
            'isMaintenance',
            'maintenanceTitle',
            'maintenanceMessage',
            'unitAdmins'
        ));
    }

    /**
     * Aktifkan / Nonaktifkan Mode Pemeliharaan (Maintenance Mode).
     * Saat aktif, hanya admin login yang dapat menjelajahi website.
     */
    public function toggleMaintenance(Request $request)
    {
        $current = (string) Setting::get('maintenance_mode', '0');
        $newStatus = $current === '1' ? '0' : '1';

        Setting::set('maintenance_mode', $newStatus, 'system');

        if ($request->filled('maintenance_title')) {
            Setting::set('maintenance_title', $request->input('maintenance_title'), 'system');
        }
        if ($request->filled('maintenance_message')) {
            Setting::set('maintenance_message', $request->input('maintenance_message'), 'system');
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'user_name' => auth()->user()?->name ?? 'Administrator',
            'action' => 'maintenance_toggle',
            'description' => $newStatus === '1'
                ? 'Mengaktifkan Mode Maintenance (Website kini hanya bisa diakses oleh Admin yang sedang login)'
                : 'Menonaktifkan Mode Maintenance (Website kembali publik dan dapat diakses umum)',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $newStatus === '1' ? 'warning' : 'info',
        ]);

        $statusText = $newStatus === '1'
            ? 'DIAKTIFKAN. Pengunjung umum diarahkan ke halaman pemeliharaan, hanya admin login yang dapat melihat website.'
            : 'DINONAKTIFKAN. Website kini kembali normal dan dapat diakses publik.';

        return back()->with('success', "Mode Pemeliharaan (Maintenance Mode) berhasil {$statusText}");
    }

    /**
     * Jalankan migrasi database dari dashboard admin (berguna untuk hosting tanpa akses SSH).
     */
    public function runMigration()
    {
        if (! Auth::user()?->isGlobalAdmin() && ! Auth::user()?->isSuperAdmin()) {
            abort(403, 'Akses dibatasi. Hanya Administrator Pondok yang berhak menjalankan migrasi database.');
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();

            // Sync build assets if custom build target configured
            $sourceBuild = public_path('build');
            $targetDirs = [];
            foreach ($targetDirs as $targetDir) {
                if (is_dir(dirname($targetDir)) && is_dir($sourceBuild) && realpath(dirname($targetDir)) !== realpath(public_path())) {
                    if (! is_dir($targetDir)) {
                        @mkdir($targetDir, 0755, true);
                    }
                    $iterator = new \RecursiveIteratorIterator(
                        new \RecursiveDirectoryIterator($sourceBuild, \RecursiveDirectoryIterator::SKIP_DOTS),
                        \RecursiveIteratorIterator::SELF_FIRST
                    );
                    foreach ($iterator as $item) {
                        $subPath = $iterator->getSubPathName();
                        $target = $targetDir.'/'.$subPath;
                        if ($item->isDir()) {
                            if (! is_dir($target)) {
                                @mkdir($target, 0755, true);
                            }
                        } else {
                            @copy($item->getPathname(), $target);
                        }
                    }
                }
            }

            return back()->with('success', 'Migrasi database & sinkronisasi aset berhasil dijalankan! '.(trim($output) ?: 'Tabel berhasil dibuat.'));
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal menjalankan migrasi: '.$e->getMessage());
        }
    }

    /**
     * Muat ulang konten demo khusus untuk unit admin atau seluruh unit pendidikan.
     */
    public function seedUnitDemo(Request $request)
    {
        $user = $request->user();

        try {
            if ($user?->isUnitAdmin()) {
                $unit = $user->unit;
                if ($unit) {
                    UnitDemoContentService::seedSingleUnit($unit, true);

                    ActivityLog::create([
                        'user_id' => $user->id,
                        'user_name' => $user->name,
                        'action' => 'seed_unit_demo',
                        'description' => "Memuat ulang seluruh konten demo unit: {$unit->name}",
                        'ip_address' => $request->ip(),
                        'user_agent' => $request->userAgent(),
                        'status' => 'info',
                    ]);

                    return back()->with('success', "Konten demo lengkap untuk {$unit->name} berhasil dimuat ulang!");
                }
            } elseif ($user?->isSuperAdmin() || $user?->isGlobalAdmin()) {
                if ($request->filled('unit_id')) {
                    $unit = UnitPendidikan::find($request->input('unit_id'));
                    if ($unit) {
                        UnitDemoContentService::seedSingleUnit($unit, true);

                        return back()->with('success', "Konten demo untuk {$unit->name} berhasil dimuat ulang!");
                    }
                }

                UnitDemoContentService::seedAllUnitsDemo(true);

                ActivityLog::create([
                    'user_id' => $user?->id ?? 1,
                    'user_name' => $user?->name ?? 'Administrator',
                    'action' => 'seed_all_units_demo',
                    'description' => 'Memuat ulang seluruh konten demo untuk 8 unit pendidikan YAPIRUS PPRU',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'status' => 'info',
                ]);

                return back()->with('success', 'Seluruh konten demo untuk 8 unit pendidikan berhasil dimuat ulang!');
            }

            return back()->with('error', 'Gagal memuat konten demo unit.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Gagal memuat konten demo: '.$e->getMessage());
        }
    }
}
