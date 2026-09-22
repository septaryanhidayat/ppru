<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class VisitorTrackerService
{
    /**
     * Record a web visit request to visitor_logs table.
     */
    public function record(Request $request): ?VisitorLog
    {
        try {
            // Pastikan tabel visitor_logs sudah dibuat
            if (! Schema::hasTable('visitor_logs')) {
                return null;
            }

            // 1. Cek apakah tracking diaktifkan di pengaturan
            if (Setting::get('analytics_enabled', '1') === '0') {
                return null;
            }

            // 2. Abaikan kunjungan admin jika fitur diaktifkan
            if (Setting::get('analytics_ignore_admin', '1') === '1' && Auth::check()) {
                return null;
            }

            // 3. Hanya catat request GET pada halaman web publik (bukan asset / admin / healthcheck)
            if (! $request->isMethod('GET')) {
                return null;
            }

            if ($request->is('up', 'admin/*', 'api/*', 'livewire/*', 'filament/*', '_debugbar/*')) {
                return null;
            }

            $userAgent = (string) $request->userAgent();
            $ip = (string) $request->ip();
            $isBot = $this->isBot($userAgent);
            $deviceType = $this->detectDevice($userAgent, $isBot);
            $browser = $this->detectBrowser($userAgent);
            $platform = $this->detectPlatform($userAgent);
            $referer = (string) $request->headers->get('referer', '');
            $refererSource = $this->detectRefererSource($referer, $request->getHost());

            // 4. Resolusi GeoIP (Kota & Negara)
            $geo = $this->resolveGeoLocation($ip);

            // 5. Normalisasi Path & Title
            $path = '/'.ltrim($request->path(), '/');
            $url = $request->fullUrl();
            $pageTitle = $this->guessPageTitle($path);

            return VisitorLog::create([
                'ip_address' => $ip,
                'session_id' => $request->hasSession() ? $request->session()->getId() : null,
                'user_agent' => Str::limit($userAgent, 500),
                'device_type' => $deviceType,
                'browser' => $browser,
                'platform' => $platform,
                'referer' => Str::limit($referer, 500),
                'referer_source' => $refererSource,
                'url' => Str::limit($url, 500),
                'path' => Str::limit($path, 255),
                'page_title' => $pageTitle,
                'country' => $geo['country'] ?? 'Indonesia',
                'country_code' => $geo['country_code'] ?? 'ID',
                'city' => $geo['city'] ?? 'Ogan Ilir',
                'region' => $geo['region'] ?? 'Sumatera Selatan',
                'is_bot' => $isBot,
            ]);
        } catch (\Throwable $e) {
            // Pelacak tidak boleh menyebabkan kegagalan respon bagi pengunjung
            return null;
        }
    }

    /**
     * Deteksi apakah User Agent adalah bot / crawler / spider.
     */
    public function isBot(string $userAgent): bool
    {
        if (empty($userAgent)) {
            return false;
        }

        $botPatterns = [
            'bot', 'crawl', 'spider', 'slurp', 'googlebot', 'bingbot', 'yandex',
            'duckduckbot', 'baiduspider', 'yahoo', 'facebookexternalhit', 'whatsapp',
            'twitterbot', 'rogerbot', 'linkedinbot', 'embedly', 'quora link preview',
            'showyoubot', 'outbrain', 'pinterest', 'applebot', 'semrushbot', 'ahrefsbot',
            'mj12bot', 'dotbot', 'petalbot', 'bytespider', 'curl', 'wget', 'python-requests',
        ];

        $ua = strtolower($userAgent);
        foreach ($botPatterns as $pattern) {
            if (str_contains($ua, $pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Deteksi jenis perangkat.
     */
    public function detectDevice(string $userAgent, bool $isBot): string
    {
        if ($isBot) {
            return 'Bot';
        }

        $ua = strtolower($userAgent);

        if (str_contains($ua, 'tablet') || str_contains($ua, 'ipad') || str_contains($ua, 'playbook') || str_contains($ua, 'silk')) {
            return 'Tablet';
        }

        if (str_contains($ua, 'mobile') || str_contains($ua, 'android') || str_contains($ua, 'iphone') || str_contains($ua, 'ipod') || str_contains($ua, 'blackberry') || str_contains($ua, 'windows phone')) {
            return 'Mobile';
        }

        return 'Desktop';
    }

    /**
     * Deteksi browser.
     */
    public function detectBrowser(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (str_contains($ua, 'edg/') || str_contains($ua, 'edge/')) {
            return 'Edge';
        }
        if (str_contains($ua, 'samsungbrowser/')) {
            return 'Samsung Browser';
        }
        if (str_contains($ua, 'ucbrowser/')) {
            return 'UC Browser';
        }
        if (str_contains($ua, 'opr/') || str_contains($ua, 'opera/')) {
            return 'Opera';
        }
        if (str_contains($ua, 'chrome/') || str_contains($ua, 'crios/')) {
            return 'Chrome';
        }
        if (str_contains($ua, 'firefox/') || str_contains($ua, 'fxios/')) {
            return 'Firefox';
        }
        if (str_contains($ua, 'safari/') && ! str_contains($ua, 'chrome')) {
            return 'Safari';
        }

        return 'Browser Lainnya';
    }

    /**
     * Deteksi sistem operasi (platform).
     */
    public function detectPlatform(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (str_contains($ua, 'android')) {
            return 'Android';
        }
        if (str_contains($ua, 'iphone') || str_contains($ua, 'ipad') || str_contains($ua, 'ipod')) {
            return 'iOS';
        }
        if (str_contains($ua, 'windows nt 10.0') || str_contains($ua, 'windows nt 11.0')) {
            return 'Windows 10/11';
        }
        if (str_contains($ua, 'windows')) {
            return 'Windows';
        }
        if (str_contains($ua, 'macintosh') || str_contains($ua, 'mac os x')) {
            return 'macOS';
        }
        if (str_contains($ua, 'cros')) {
            return 'Chrome OS';
        }
        if (str_contains($ua, 'linux')) {
            return 'Linux';
        }

        return 'OS Lainnya';
    }

    /**
     * Deteksi sumber asal rujukan (Referer).
     */
    public function detectRefererSource(string $referer, string $currentHost): string
    {
        if (empty($referer)) {
            return 'Direct / Langsung';
        }

        $host = strtolower(parse_url($referer, PHP_URL_HOST) ?? '');

        if (empty($host) || $host === strtolower($currentHost) || str_contains($host, 'ppru.ac.id') || str_contains($host, 'localhost') || str_contains($host, '127.0.0.1')) {
            return 'Direct / Langsung';
        }

        if (str_contains($host, 'google.')) {
            return 'Google Search';
        }
        if (str_contains($host, 'bing.')) {
            return 'Bing Search';
        }
        if (str_contains($host, 'yahoo.')) {
            return 'Yahoo Search';
        }
        if (str_contains($host, 'facebook.') || str_contains($host, 'fb.me') || str_contains($host, 'fb.')) {
            return 'Facebook';
        }
        if (str_contains($host, 'instagram.')) {
            return 'Instagram';
        }
        if (str_contains($host, 'twitter.') || str_contains($host, 'x.com') || str_contains($host, 't.co')) {
            return 'Twitter / X';
        }
        if (str_contains($host, 'whatsapp.') || str_contains($host, 'wa.me')) {
            return 'WhatsApp';
        }
        if (str_contains($host, 'tiktok.')) {
            return 'TikTok';
        }
        if (str_contains($host, 'youtube.') || str_contains($host, 'youtu.be')) {
            return 'YouTube';
        }

        return $host;
    }

    /**
     * Resolusi Geografis Asal Pengunjung (Kota & Negara).
     */
    public function resolveGeoLocation(string $ip): array
    {
        // 1. IP Lokal / Private (Development / Internal)
        if (
            $ip === '127.0.0.1' || $ip === '::1' ||
            filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false
        ) {
            return [
                'country' => 'Indonesia',
                'country_code' => 'ID',
                'city' => 'Lokal / Server',
                'region' => 'Sumatera Selatan',
            ];
        }

        // 2. Cek Cloudflare header jika tersedia
        $cfCountry = $_SERVER['HTTP_CF_IPCOUNTRY'] ?? null;

        // 3. Cache hasil IP lookup selama 7 hari
        return Cache::remember('geoip_'.md5($ip), 86400 * 7, function () use ($ip, $cfCountry) {
            if (Setting::get('analytics_ip_lookup', '1') === '0') {
                return [
                    'country' => $cfCountry ?? 'Indonesia',
                    'country_code' => $cfCountry ?? 'ID',
                    'city' => 'Indonesia',
                    'region' => 'Indonesia',
                ];
            }

            try {
                $response = Http::timeout(1.2)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,regionName,city");
                if ($response->successful()) {
                    $data = $response->json();
                    if (($data['status'] ?? '') === 'success') {
                        return [
                            'country' => $data['country'] ?? 'Indonesia',
                            'country_code' => $data['countryCode'] ?? 'ID',
                            'city' => $data['city'] ?? 'Indonesia',
                            'region' => $data['regionName'] ?? 'Indonesia',
                        ];
                    }
                }
            } catch (\Throwable $e) {
                // Fallback jika API eksternal gagal
            }

            return [
                'country' => $cfCountry ?? 'Indonesia',
                'country_code' => $cfCountry ?? 'ID',
                'city' => 'Indonesia',
                'region' => 'Indonesia',
            ];
        });
    }

    /**
     * Tebak label halaman berdasarkan path URL.
     */
    protected function guessPageTitle(string $path): string
    {
        $p = trim($path, '/');
        if (empty($p)) {
            return 'Beranda';
        }

        $routes = [
            'sejarah' => 'Sejarah Sekolah',
            'visi-dan-misi' => 'Visi & Misi Sekolah',
            'tentang-kami' => 'Profil & Tentang Kami',
            'sambutan-ketua-dpd' => 'Sambutan Kepala Sekolah',
            'sambutan-kepala-sekolah' => 'Sambutan Kepala Sekolah',
            'struktur-kepengurusan' => 'Struktur Organisasi Pesantren',
            'anggota-dewan' => 'Dewan Guru & Asatidz',
            'dewan-guru' => 'Dewan Guru & Asatidz',
            'artikel' => 'Kabar & Berita Pesantren',
            'bidang' => 'Fasilitas & Sarana Kampus',
            'fasilitas' => 'Fasilitas & Sarana Kampus',
            'agenda' => 'Agenda & Kalender Akademik',
            'pengumuman' => 'Pengumuman Resmi Pesantren',
            'video' => 'Galeri Video Santri',
            'galeri' => 'Galeri Foto Kegiatan',
            'download' => 'Pusat Unduhan Berkas',
            'e-book' => 'Download Modul & E-Book',
            'hymne-mars' => 'Mars & Hymne PPRU',
            'hubungi' => 'Konsultasi & Informasi PSB',
            'donasi' => 'Infaq & Wakaf PPRU',
            'dpc' => 'Program Unggulan Pesantren',
            'program-unggulan' => 'Program Unggulan Pesantren',
        ];

        if (isset($routes[$p])) {
            return $routes[$p];
        }

        if (str_starts_with($p, 'artikel/')) {
            $slug = substr($p, 8);

            return 'Berita: '.Str::headline($slug);
        }

        if (str_starts_with($p, 'bidang/')) {
            $slug = substr($p, 7);

            return 'Bidang: '.Str::headline($slug);
        }

        return Str::headline($p);
    }

    public const DEFAULT_BASE_HITS = 53520;

    /**
     * Dapatkan total hits pengunjung secara persisten & monotonik (tidak pernah berkurang).
     */
    public static function getVisitorHits(): int
    {
        $counterFile = storage_path('app/visitor_hits.txt');
        $fileHits = 0;

        if (file_exists($counterFile)) {
            $handle = @fopen($counterFile, 'rb');
            if ($handle) {
                @flock($handle, LOCK_SH);
                $content = @stream_get_contents($handle);
                @flock($handle, LOCK_UN);
                @fclose($handle);
                $fileHits = (int) trim($content ?? '');
            }
        }

        $dbTotalHits = 0;
        $dbBaseHits = self::DEFAULT_BASE_HITS;

        try {
            if (Schema::hasTable('settings')) {
                $savedTotal = Setting::get('visitor_hits_total');
                if ($savedTotal !== null && is_numeric($savedTotal)) {
                    $dbTotalHits = (int) $savedTotal;
                }

                $savedBase = Setting::get('analytics_base_hits');
                if ($savedBase !== null && is_numeric($savedBase) && (int) $savedBase > 0) {
                    $dbBaseHits = (int) $savedBase;
                }
            }
        } catch (\Throwable) {
            // Abaikan jika migrasi
        }

        // Nilai akhir dijamin tidak pernah lebih rendah dari baseline resmi pesantren
        $finalHits = max($fileHits, $dbTotalHits, $dbBaseHits, self::DEFAULT_BASE_HITS);

        return $finalHits;
    }

    /**
     * Tambah counter pengunjung secara atomik, aman dan persisten.
     */
    public static function incrementVisitorHits(): int
    {
        $current = self::getVisitorHits();
        $next = $current + 1;

        $counterFile = storage_path('app/visitor_hits.txt');
        try {
            $dir = dirname($counterFile);
            if (! is_dir($dir)) {
                @mkdir($dir, 0755, true);
            }
            $handle = @fopen($counterFile, 'c+');
            if ($handle) {
                if (@flock($handle, LOCK_EX)) {
                    $fileContent = @stream_get_contents($handle);
                    $fileHits = (int) trim($fileContent ?? '');
                    if ($fileHits >= $next) {
                        $next = $fileHits + 1;
                    }
                    @ftruncate($handle, 0);
                    @rewind($handle);
                    @fwrite($handle, (string) $next);
                    @fflush($handle);
                    @flock($handle, LOCK_UN);
                }
                @fclose($handle);
            }
        } catch (\Throwable) {
            // Non-blocking fallback
        }

        // Simpan ke database settings dan cache
        try {
            if (Schema::hasTable('settings')) {
                Setting::updateOrCreate(
                    ['key' => 'visitor_hits_total'],
                    ['value' => (string) $next, 'group' => 'analytics']
                );
            }
        } catch (\Throwable) {
            // Abaikan jika migrasi
        }

        try {
            Cache::forever('school_visitor_hits', $next);
        } catch (\Throwable) {
            // Abaikan
        }

        return $next;
    }

    /**
     * Setel baseline counter baru jika valid dan tidak mengecilkan counter live.
     */
    public static function setBaseHits(int $newBase): int
    {
        if ($newBase <= 0) {
            return self::getVisitorHits();
        }

        $current = self::getVisitorHits();
        $final = max($current, $newBase);

        try {
            if (Schema::hasTable('settings')) {
                Setting::updateOrCreate(
                    ['key' => 'analytics_base_hits'],
                    ['value' => (string) $newBase, 'group' => 'analytics']
                );
                Setting::updateOrCreate(
                    ['key' => 'visitor_hits_total'],
                    ['value' => (string) $final, 'group' => 'analytics']
                );
            }
        } catch (\Throwable) {
            // Abaikan
        }

        $counterFile = storage_path('app/visitor_hits.txt');
        try {
            $handle = @fopen($counterFile, 'c+');
            if ($handle) {
                if (@flock($handle, LOCK_EX)) {
                    @ftruncate($handle, 0);
                    @rewind($handle);
                    @fwrite($handle, (string) $final);
                    @fflush($handle);
                    @flock($handle, LOCK_UN);
                }
                @fclose($handle);
            }
        } catch (\Throwable) {
            // Abaikan
        }

        try {
            Cache::forever('school_visitor_hits', $final);
        } catch (\Throwable) {
            // Abaikan
        }

        return $final;
    }
}
