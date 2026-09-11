<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// 1. Auto-detect Laravel repository root directory
$possibleRoots = [
    __DIR__ . '/..',
    dirname(__DIR__) . '/repositories/pksoi',
    dirname(__DIR__) . '/laravel_pksoi',
    dirname(__DIR__) . '/pksoi',
    ($_SERVER['HOME'] ?? '') . '/repositories/pksoi',
    ($_SERVER['HOME'] ?? '') . '/laravel_pksoi',
    '/home/berandad/repositories/pksoi',
    '/home/berandad/laravel_pksoi',
    '/home/berandad/pksoi',
];

$laravelRoot = null;
foreach ($possibleRoots as $candidate) {
    if ($candidate && file_exists($candidate . '/bootstrap/app.php')) {
        $laravelRoot = realpath($candidate);
        break;
    }
}
if (!$laravelRoot) {
    $laravelRoot = realpath(__DIR__ . '/..');
}

// 2. Pre-flight checks: PHP Version, vendor/, and .env
$hasVendor = file_exists($laravelRoot . '/vendor/autoload.php');
$hasEnv = file_exists($laravelRoot . '/.env');
$phpVersion = PHP_VERSION;
$phpOk = version_compare($phpVersion, '8.2.0', '>=');

if (!$hasVendor || !$phpOk || !$hasEnv) {
    http_response_code(500);
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Setup Awal Server - DPD PKS Ogan Ilir</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; padding: 2rem 1rem; }
            .container { max-width: 720px; margin: 0 auto; background: #1e293b; border-radius: 12px; border: 1px solid #334155; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5); }
            .header { background: #ea580c; padding: 1.5rem; text-align: center; color: white; }
            .header h1 { margin: 0; font-size: 1.4rem; font-weight: 700; }
            .header p { margin: 0.5rem 0 0; opacity: 0.9; font-size: 0.9rem; }
            .body { padding: 1.75rem; }
            .item { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 1.25rem; background: #0f172a; padding: 1rem; border-radius: 8px; border-left: 4px solid #64748b; }
            .item.ok { border-left-color: #22c55e; }
            .item.err { border-left-color: #ef4444; }
            .icon { font-size: 1.2rem; }
            .item-title { font-weight: 600; margin-bottom: 0.25rem; color: #f8fafc; }
            .item-desc { font-size: 0.85rem; color: #94a3b8; line-height: 1.5; }
            .code-box { background: #020617; border: 1px solid #334155; padding: 0.75rem; border-radius: 6px; font-family: monospace; font-size: 0.85rem; color: #38bdf8; margin-top: 0.5rem; overflow-x: auto; word-break: break-all; }
            .btn { display: inline-block; background: #ea580c; color: white; text-decoration: none; padding: 0.75rem 1.25rem; border-radius: 6px; font-weight: 600; font-size: 0.9rem; margin-top: 1rem; transition: background 0.2s; text-align: center; }
            .btn:hover { background: #c2410c; }
            .actions { text-align: center; margin-top: 1.5rem; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h1>DPD PKS OGAN ILIR</h1>
                <p>Status Setup Sistem Laravel di cPanel Hosting</p>
            </div>
            <div class="body">
                <div class="item <?= $phpOk ? 'ok' : 'err' ?>">
                    <div class="icon"><?= $phpOk ? '✅' : '❌' ?></div>
                    <div>
                        <div class="item-title">Versi PHP Server: <?= htmlspecialchars($phpVersion) ?></div>
                        <div class="item-desc">
                            <?= $phpOk ? 'Versi PHP memenuhi syarat minimum Laravel (PHP 8.2+).' : 'Versi PHP terlalu rendah! Silakan ubah ke PHP 8.2, 8.3, atau 8.4 melalui menu <strong>MultiPHP Manager</strong> di cPanel.' ?>
                        </div>
                    </div>
                </div>

                <div class="item <?= $hasVendor ? 'ok' : 'err' ?>">
                    <div class="icon"><?= $hasVendor ? '✅' : '❌' ?></div>
                    <div>
                        <div class="item-title">Folder Dependencies (vendor/): <?= $hasVendor ? 'Ditemukan' : 'Belum Ada' ?></div>
                        <div class="item-desc">
                            <?php if ($hasVendor): ?>
                                Folder autoloader composer ditemukan.
                            <?php else: ?>
                                Repositori Git tidak menyertakan folder <code>vendor/</code> demi efisiensi transfer. Jalankan perintah berikut di menu <strong>Terminal</strong> cPanel Anda:
                                <div class="code-box">cd <?= htmlspecialchars($laravelRoot) ?> && composer install --no-dev --optimize-autoloader</div>
                                <span style="font-size:0.8rem;color:#cbd5e1;display:block;margin-top:4px;">Atau zip folder <code>vendor</code> dari komputer lokal Anda, upload ke folder repositori cPanel via File Manager, lalu ekstrak.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="item <?= $hasEnv ? 'ok' : 'err' ?>">
                    <div class="icon"><?= $hasEnv ? '✅' : '❌' ?></div>
                    <div>
                        <div class="item-title">File Konfigurasi (.env): <?= $hasEnv ? 'Ditemukan' : 'Belum Dibuat' ?></div>
                        <div class="item-desc">
                            <?php if ($hasEnv): ?>
                                File konfigurasi .env aktif ditemukan.
                            <?php else: ?>
                                Salin template konfigurasi cPanel ke .env dengan perintah Terminal berikut:
                                <div class="code-box">cp <?= htmlspecialchars($laravelRoot) ?>/.env.cpanel.example <?= htmlspecialchars($laravelRoot) ?>/.env</div>
                                <span style="font-size:0.8rem;color:#cbd5e1;display:block;margin-top:4px;">Atau klik tombol <strong>cPanel Setup Helper</strong> di bawah untuk membuatnya otomatis dengan 1 klik!</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="actions">
                    <a href="cpanel_setup.php?token=PksOi2026Setup&amp;action=status" class="btn">Buka cPanel Setup Helper &rarr;</a>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// 3. Maintenance mode check
if (file_exists($maintenance = $laravelRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

// 4. Register Autoloader and Bootstrap Laravel
try {
    require $laravelRoot . '/vendor/autoload.php';

    /** @var Application $app */
    $app = require_once $laravelRoot . '/bootstrap/app.php';

    $app->handleRequest(Request::capture());
} catch (\Throwable $e) {
    http_response_code(500);
    $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest');
    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode(['error' => $e->getMessage()]);
        exit;
    }
    ?>
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Error 500 - DPD PKS Ogan Ilir</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #e2e8f0; margin: 0; padding: 2rem 1rem; }
            .box { max-width: 800px; margin: 0 auto; background: #1e293b; border-radius: 12px; border: 1px solid #dc2626; padding: 2rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); }
            h2 { color: #ef4444; margin-top: 0; }
            p { color: #cbd5e1; line-height: 1.6; }
            pre { background: #020617; border: 1px solid #334155; padding: 1rem; border-radius: 8px; color: #fca5a5; overflow-x: auto; font-size: 0.85rem; font-family: monospace; }
            .tip { background: #1e3a8a; color: #93c5fd; padding: 1rem; border-radius: 8px; font-size: 0.85rem; margin-top: 1.5rem; }
        </style>
    </head>
    <body>
        <div class="box">
            <h2>⚠️ Terjadi Kesalahan Eksekusi (HTTP ERROR 500)</h2>
            <p>Aplikasi gagal dijalankan dengan pesan error berikut:</p>
            <pre><?= htmlspecialchars(get_class($e) . ': ' . $e->getMessage()) ?>&#10;&#10;Lokasi: <?= htmlspecialchars($e->getFile() . ':' . $e->getLine()) ?></pre>
            <div class="tip">
                <strong>💡 Solusi Cepat:</strong><br>
                1. Jika error terkait database (Access denied / Connection refused): pastikan kredensial DB di file <code>.env</code> sudah sesuai dengan database MySQL cPanel Anda.<br>
                2. Jika error terkait izin folder (Permission denied): buka cPanel Helper lalu klik <strong>Perbaiki Izin Folder Storage</strong>.<br>
                3. Jika error No application encryption key: pastikan baris <code>APP_KEY=base64:tfdlAwa5qi0eMQooptnBfMClNPkQ20oCj3U2UWKUSPc=</code> ada di file <code>.env</code>.
            </div>
            <p style="text-align:center;margin-top:1.5rem;">
                <a href="cpanel_setup.php?token=PksOi2026Setup&amp;action=status" style="color:#f97316;text-decoration:none;font-weight:bold;">&larr; Buka cPanel Setup Helper</a>
            </p>
        </div>
    </body>
    </html>
    <?php
    exit;
}
