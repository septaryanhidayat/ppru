<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityMonitorMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->getRequestUri();
        $ip = $request->ip();

        // 1. Check for malicious webshell / sensitive file probing
        $probePatterns = [
            '/\b(wp-config\.php|alfa\.php|wso\.php|b374k\.php|c99\.php|r57\.php|eval-stdin\.php)\b/i',
            '/\b(\.env|\.git\/|web\.config|\.htaccess)\b/i',
            '/(\.\.\/|\.\.\\\)/', // Path traversal
        ];

        foreach ($probePatterns as $pattern) {
            if (preg_match($pattern, $uri)) {
                ActivityLog::create([
                    'user_id' => auth()->id(),
                    'user_name' => auth()->user()?->name ?? 'Pengunjung Tidak Dikenal',
                    'action' => 'security_probe_blocked',
                    'description' => "Upaya pemindaian file sensitif diblokir: {$uri}",
                    'ip_address' => $ip,
                    'user_agent' => $request->userAgent(),
                    'status' => 'danger',
                ]);

                abort(403, 'Akses Ditolak: Pola permintaan tidak sah terdeteksi oleh sistem keamanan SMA IT Plus Robbani.');
            }
        }

        // 2. Check for SQL Injection patterns in query parameters
        $queryString = $request->getQueryString() ?? '';
        if ($queryString) {
            $sqliPatterns = [
                '/\b(UNION(\s+ALL)?\s+SELECT)\b/i',
                '/\b(INTO(\s+OUTFILE|\s+DUMPFILE))\b/i',
                '/\b(INFORMATION_SCHEMA)\b/i',
                '/\b(BENCHMARK\s*\(|SLEEP\s*\()/i',
            ];

            foreach ($sqliPatterns as $pattern) {
                if (preg_match($pattern, urldecode($queryString))) {
                    ActivityLog::create([
                        'user_id' => auth()->id(),
                        'user_name' => auth()->user()?->name ?? 'Pengunjung Tidak Dikenal',
                        'action' => 'sqli_blocked',
                        'description' => "Upaya SQL Injection diblokir pada URL: {$uri}",
                        'ip_address' => $ip,
                        'user_agent' => $request->userAgent(),
                        'status' => 'danger',
                    ]);

                    abort(403, 'Akses Ditolak: Upaya manipulasi basis data terdeteksi dan diblokir.');
                }
            }
        }

        return $next($request);
    }
}
