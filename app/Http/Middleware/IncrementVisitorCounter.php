<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use App\Services\VisitorTrackerService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IncrementVisitorCounter
{
    public function __construct(
        protected VisitorTrackerService $tracker
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $counterFile = storage_path('app/visitor_hits.txt');

        // Ambil base hit counter dari database Setting jika ada
        $baseHits = 12850;
        try {
            if (Schema::hasTable('settings')) {
                $baseSetting = Setting::get('analytics_base_hits');
                if ($baseSetting !== null && is_numeric($baseSetting)) {
                    $baseHits = (int) $baseSetting;
                }
            }
        } catch (\Throwable $e) {
            // Abaikan jika database sedang migrasi
        }

        if (! file_exists($counterFile)) {
            @file_put_contents($counterFile, (string) $baseHits);
        }

        $hits = (int) @file_get_contents($counterFile);
        if ($hits < $baseHits) {
            $hits = $baseHits;
        }

        // Catat kunjungan ke database & tambah counter pada request GET halaman publik
        if ($request->isMethod('GET') && ! $request->is('up', 'admin/*', 'api/*', 'livewire/*', 'filament/*')) {
            $hits++;
            @file_put_contents($counterFile, (string) $hits);

            // Rekam log analitik nyata (real visitor metadata) ke database
            $this->tracker->record($request);
        }

        // Format angka dengan titik pemisah ribuan (misal: 53.513) dan angka mentah
        View::share('visitorHits', number_format($hits, 0, ',', '.'));
        View::share('rawVisitorHits', $hits);

        return $next($request);
    }
}
