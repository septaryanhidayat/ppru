<?php

namespace App\Services;

class HtmlSanitizer
{
    /**
     * Sanitize rich HTML content to prevent stored XSS attacks.
     * Preserves standard CMS formatting (p, b, i, img, a, table, h1-h6, youtube embeds)
     * while stripping script tags, javascript: URIs, and inline event handlers.
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // 1. Remove script tags and their inner contents
        $cleaned = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // 2. Remove style tags (prevent CSS injection/clickjacking in content)
        $cleaned = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', '', $cleaned);

        // 3. Remove dangerous HTML tags (applet, embed, object, meta, link, base, form)
        $cleaned = preg_replace('/<\/?(applet|object|meta|link|base|form|input|button)\b[^>]*>/is', '', $cleaned);

        // 4. Remove all inline event handlers (onclick, onerror, onload, onmouseover, etc.)
        $cleaned = preg_replace('/\s+on[a-zA-Z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/is', '', $cleaned);

        // 5. Remove javascript: and vbscript: pseudoprotocols in href or src
        $cleaned = preg_replace('/(href|src)\s*=\s*["\']\s*(?:javascript|vbscript):[^"\']*["\']/is', '', $cleaned);

        // 6. Restrict iframes only to trusted video providers (YouTube, Vimeo, Google Maps)
        $cleaned = preg_replace_callback('/<iframe\b([^>]*)>(.*?)<\/iframe>/is', function ($matches) {
            $attrs = $matches[1];
            if (preg_match('/src=["\']([^"\']+)["\']/i', $attrs, $srcMatch)) {
                $src = $srcMatch[1];
                $allowedDomains = [
                    'youtube.com',
                    'www.youtube.com',
                    'youtube-nocookie.com',
                    'www.youtube-nocookie.com',
                    'youtu.be',
                    'player.vimeo.com',
                    'google.com',
                    'maps.google.com',
                ];

                $parsedHost = parse_url($src, PHP_URL_HOST);
                if ($parsedHost) {
                    foreach ($allowedDomains as $domain) {
                        if (str_ends_with(strtolower($parsedHost), strtolower($domain)) || str_contains($src, 'google.com/maps')) {
                            return "<iframe{$attrs}></iframe>";
                        }
                    }
                }
            }

            return ''; // Discard untrusted iframes
        }, $cleaned);

        return $cleaned;
    }
}
