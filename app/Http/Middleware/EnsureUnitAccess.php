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

        // Super admin has full access to everything
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $currentPath = $request->path();

        // Author role: only allowed to access dashboard, posts management, and media uploads
        if ($user->role === 'author') {
            $isAuthorAllowed = in_array($currentPath, ['admin', 'admin/dashboard', 'admin/posts', 'admin/media', 'admin/profile'], true)
                || str_starts_with($currentPath, 'admin/posts/')
                || str_starts_with($currentPath, 'admin/media/');

            if (! $isAuthorAllowed) {
                abort(403, 'Akses dibatasi. Akun Penulis hanya memiliki izin untuk mengelola Berita dan Artikel.');
            }

            return $next($request);
        }

        // Editor role: allowed to manage content, but NOT system administration (settings, users, backup, security logs, migration, units)
        if ($user->role === 'editor') {
            $disallowedForEditor = [
                'admin/settings',
                'admin/backup',
                'admin/security',
                'admin/users',
                'admin/migrate',
                'admin/unit-pendidikan',
            ];

            foreach ($disallowedForEditor as $prefix) {
                if ($currentPath === $prefix || str_starts_with($currentPath, $prefix.'/')) {
                    abort(403, 'Akses dibatasi. Akun Editor tidak memiliki izin untuk konfigurasi sistem dan manajemen pengguna.');
                }
            }

            return $next($request);
        }

        // Global admin (admin pondok): full administrative access across all pondok features
        if ($user->isGlobalAdmin()) {
            return $next($request);
        }

        // Unit admin: restricted from global pondok settings, users, backups, security, and other units
        if ($user->isUnitAdmin()) {
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
                'admin/layanan',
                'admin/popup',
                'admin/categories',
                'admin/migrate',
            ];

            foreach ($disallowedPrefixes as $prefix) {
                if ($currentPath === $prefix || str_starts_with($currentPath, $prefix.'/')) {
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

            return $next($request);
        }

        return $next($request);
    }
}
