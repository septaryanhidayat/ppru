<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach HTTP security headers.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        // Remove server signature headers if present
        if (function_exists('header_remove') && ! headers_sent()) {
            @header_remove('X-Powered-By');
        }

        // Apply security headers
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content Security Policy (compatible with Tailwind, Alpine.js, Quill/TinyMCE, CDNs, and YouTube embeds)
        $csp = "default-src 'self' https: data:; "
            ."script-src 'self' 'unsafe-inline' 'unsafe-eval' https:; "
            ."style-src 'self' 'unsafe-inline' https:; "
            ."img-src 'self' data: https: blob:; "
            ."font-src 'self' data: https:; "
            ."frame-src 'self' https://www.youtube.com https://youtube-nocookie.com https://www.youtube-nocookie.com https://www.google.com https://maps.google.com; "
            ."connect-src 'self' https:;";
        $response->headers->set('Content-Security-Policy', $csp);

        // If request is over HTTPS, enforce HSTS (HTTP Strict Transport Security)
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }
}
