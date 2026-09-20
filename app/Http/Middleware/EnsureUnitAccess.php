<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUnitAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Global admins have full access
        if ($user->isGlobalAdmin() || $user->isSuperAdmin()) {
            return $next($request);
        }

        // If user is a unit admin, restrict access to global pondok settings & other units
        if ($user->isUnitAdmin()) {
            $currentRoute = $request->route()?->getName() ?? '';
            $currentPath = $request->path();

            // Disallowed route patterns for unit admins
            $disallowedPrefixes = [
                'admin/settings',
                'admin/hero-slides',
                'admin/nav-menus',
                'admin/pages',
                'admin/security',
                'admin/backup',
                'admin/users',
                'admin/quick-menus',
                'admin/bidang',
                'admin/program-unggulan',
                'admin/dpc',
                'admin/dewan',
                'admin/layanan',
                'admin/popup',
                'admin/categories',
            ];

            foreach ($disallowedPrefixes as $prefix) {
                if (str_starts_with($currentPath, $prefix)) {
                    abort(403, 'Akses dibatasi. Akun Anda hanya memiliki izin untuk mengelola unit: '.($user->unit?->name ?? 'Unit Anda').'.');
                }
            }

            // Check unit editing: only allowed to edit their own unit
            if (str_starts_with($currentPath, 'admin/unit-pendidikan')) {
                $unitParam = $request->route('unit_pendidikan');
                $targetId = is_object($unitParam) ? $unitParam->id : (int) $unitParam;

                if ($targetId && $targetId !== (int) $user->unit_pendidikan_id) {
                    abort(403, 'Anda tidak memiliki izin untuk mengelola unit pendidikan lain.');
                }
            }
        }

        return $next($request);
    }
}
