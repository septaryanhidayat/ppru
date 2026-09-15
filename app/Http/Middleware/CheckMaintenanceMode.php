<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $isMaintenance = (string) Setting::get('maintenance_mode', '0') === '1';
        } catch (\Throwable $e) {
            $isMaintenance = false;
        }

        if (! $isMaintenance) {
            return $next($request);
        }

        // If user is authenticated, bypass maintenance and allow full access
        if (auth()->check()) {
            return $next($request);
        }

        // Allow essential routes for admin login, health check, and static assets
        if ($this->isExemptRoute($request)) {
            return $next($request);
        }

        // Retrieve custom maintenance messages
        $title = Setting::get('maintenance_title', 'Pemeliharaan Sistem Berkala');
        $message = Setting::get('maintenance_message', 'Mohon maaf atas ketidaknyamanannya. Website resmi Pondok Pesantren Raudhatul Ulum Sakatiga sedang dalam pemeliharaan sistem rutin untuk meningkatkan kualitas layanan dan performa. Kami akan segera kembali online.');

        return response()->view('frontend.maintenance', [
            'maintenanceTitle' => $title,
            'maintenanceMessage' => $message,
        ], 503, [
            'Retry-After' => '3600',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }

    /**
     * Check if the given request is exempt from maintenance mode.
     */
    protected function isExemptRoute(Request $request): bool
    {
        return $request->is('login') ||
            $request->is('login/*') ||
            $request->is('logout') ||
            $request->is('admin') ||
            $request->is('admin/*') ||
            $request->is('up') ||
            $request->is('build/*') ||
            $request->is('uploads/*') ||
            $request->is('favicon.ico');
    }
}
