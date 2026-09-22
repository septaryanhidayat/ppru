<?php

namespace App\Http\Middleware;

use App\Services\VisitorTrackerService;
use Closure;
use Illuminate\Http\Request;
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
        // Catat kunjungan ke database & tambah counter pada request GET halaman publik
        if ($request->isMethod('GET') && ! $request->is('up', 'admin/*', 'api/*', 'livewire/*', 'filament/*', '_debugbar/*')) {
            $hits = VisitorTrackerService::incrementVisitorHits();

            // Rekam log analitik nyata (real visitor metadata) ke database
            $this->tracker->record($request);
        } else {
            $hits = VisitorTrackerService::getVisitorHits();
        }

        // Format angka dengan titik pemisah ribuan (misal: 53.521) dan angka mentah
        View::share('visitorHits', number_format($hits, 0, ',', '.'));
        View::share('rawVisitorHits', $hits);

        return $next($request);
    }
}
