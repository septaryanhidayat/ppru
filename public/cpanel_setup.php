<?php

use Illuminate\Contracts\Console\Kernel;

/**
 * cPanel Setup, Maintenance & Diagnostic Helper for Laravel
 * DPD PKS Ogan Ilir
 *
 * Akses: https://pksoganilir.com/cpanel_setup.php?token=PksOi2026Setup&action=status
 */

// 1. Auto-detect Laravel repository root directory
$possibleRoots = [
    __DIR__.'/..',
    dirname(__DIR__).'/repositories/pksoi',
    dirname(__DIR__).'/laravel_pksoi',
    dirname(__DIR__).'/pksoi',
    ($_SERVER['HOME'] ?? '').'/repositories/pksoi',
    ($_SERVER['HOME'] ?? '').'/laravel_pksoi',
    '/home/berandad/repositories/pksoi',
    '/home/berandad/laravel_pksoi',
    '/home/berandad/pksoi',
];

$laravelRoot = null;
foreach ($possibleRoots as $candidate) {
    if ($candidate && file_exists($candidate.'/bootstrap/app.php')) {
        $laravelRoot = realpath($candidate);
        break;
    }
}
if (! $laravelRoot) {
    $laravelRoot = realpath(__DIR__.'/..');
}

// 2. Secret Token Authentication
$secretToken = 'PksOi2026Setup';

// Parse .env directly if it exists to get custom token if defined
$envFile = $laravelRoot.'/.env';
$envVars = [];
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        if (str_contains($line, '=')) {
            [$k, $v] = explode('=', $line, 2);
            $envVars[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        }
    }
    if (! empty($envVars['CPANEL_SETUP_TOKEN'])) {
        $secretToken = $envVars['CPANEL_SETUP_TOKEN'];
    }
}

if (! isset($_GET['token']) || empty($_GET['token']) || ! hash_equals($secretToken, (string) $_GET['token'])) {
    http_response_code(403);
    echo '<!DOCTYPE html><html><body style="background:#0f172a;color:#ef4444;font-family:sans-serif;text-align:center;padding:50px;">';
    echo '<h2>403 Forbidden: Token Akses Tidak Valid!</h2>';
    echo '<p style="color:#94a3b8;">Gunakan URL: <code>cpanel_setup.php?token=PksOi2026Setup&action=status</code></p>';
    echo '</body></html>';
    exit;
}

$action = $_GET['action'] ?? 'status';
$results = [];
$hasVendor = file_exists($laravelRoot.'/vendor/autoload.php');
$hasEnv = file_exists($envFile);

// Helper function to recursively create directories and chmod
function ensureDirWritable($dir)
{
    if (! is_dir($dir)) {
        @mkdir($dir, 0775, true);
    }
    @chmod($dir, 0775);
}

// 3. Actions Handling
switch ($action) {
    case 'create_env':
        $exampleFile = $laravelRoot.'/.env.cpanel.example';
        if (! file_exists($exampleFile)) {
            $exampleFile = $laravelRoot.'/.env.production';
        }
        if (! file_exists($envFile)) {
            if (file_exists($exampleFile)) {
                if (@copy($exampleFile, $envFile)) {
                    $results['Buat .env'] = 'SUKSES: File .env berhasil dibuat dari '.basename($exampleFile);
                } else {
                    $results['Buat .env'] = 'GAGAL: Gagal menyalin file. Cek izin folder '.$laravelRoot;
                }
            } else {
                $results['Buat .env'] = 'GAGAL: File template .env.cpanel.example tidak ditemukan di '.$laravelRoot;
            }
        } else {
            $results['Buat .env'] = 'INFO: File .env sudah ada di '.$envFile;
        }
        break;

    case 'fix_storage':
        $storageDirs = [
            $laravelRoot.'/storage/app/public',
            $laravelRoot.'/storage/framework/cache/data',
            $laravelRoot.'/storage/framework/sessions',
            $laravelRoot.'/storage/framework/views',
            $laravelRoot.'/storage/logs',
            $laravelRoot.'/bootstrap/cache',
        ];
        $fixed = 0;
        foreach ($storageDirs as $d) {
            ensureDirWritable($d);
            $fixed++;
        }
        $results['Perbaiki Storage'] = "SUKSES: {$fixed} direktori storage dan cache telah dipastikan ada dan diatur izin 0775.";
        break;

    case 'extract_vendor':
        $zipCandidates = [
            $laravelRoot.'/vendor.zip',
            __DIR__.'/vendor.zip',
            dirname(__DIR__).'/vendor.zip',
        ];
        $foundZip = null;
        foreach ($zipCandidates as $zc) {
            if (file_exists($zc)) {
                $foundZip = $zc;
                break;
            }
        }
        if ($foundZip && class_exists('ZipArchive')) {
            $zip = new ZipArchive;
            if ($zip->open($foundZip) === true) {
                $zip->extractTo($laravelRoot);
                $zip->close();
                $results['Ekstrak vendor.zip'] = "SUKSES: Berhasil mengekstrak {$foundZip} ke folder {$laravelRoot}!";
                $hasVendor = file_exists($laravelRoot.'/vendor/autoload.php');
            } else {
                $results['Ekstrak vendor.zip'] = "GAGAL: Tidak dapat membuka file ZIP {$foundZip}";
            }
        } else {
            $results['Ekstrak vendor.zip'] = "File vendor.zip tidak ditemukan di {$laravelRoot}. Silakan upload file vendor.zip via cPanel File Manager.";
        }
        break;

    case 'git_pull':
    case 'git_reset':
        $commands = [
            'cd '.escapeshellarg($laravelRoot),
            'git config core.filemode false',
            'git fetch origin main',
            'git reset --hard origin/main',
            'git clean -fd',
            'git status',
        ];
        $cmd = implode(' && ', $commands).' 2>&1';
        $output = [];
        @exec($cmd, $output, $returnCode);
        $results['Git Pull & Sync'] = empty($output) ? 'Perintah dieksekusi' : implode("\n", $output);

        // Langsung sinkronkan aset public ke folder web root pksoganilir.com
        $sourcePublic = $laravelRoot.'/public';
        foreach (['/home/berandad/pksoganilir.com/public'] as $targetDir) {
            if (is_dir($targetDir) && is_dir($sourcePublic)) {
                $iterator = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($sourcePublic, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::SELF_FIRST
                );
                foreach ($iterator as $item) {
                    $subPath = $iterator->getSubPathName();
                    $target = $targetDir.'/'.$subPath;
                    if ($item->isDir()) {
                        if (! is_dir($target)) {
                            @mkdir($target, 0755, true);
                        }
                    } else {
                        @copy($item->getPathname(), $target);
                    }
                }
            }
        }

        // Jalankan clear cache jika vendor tersedia
        if ($hasVendor) {
            try {
                require_once $laravelRoot.'/vendor/autoload.php';
                $app = require_once $laravelRoot.'/bootstrap/app.php';
                $kernel = $app->make(Kernel::class);
                $results['optimize:clear'] = runArtisanCmd($kernel, 'optimize:clear');
            } catch (Throwable $e) {
                // Ignore if bootstrap fails
            }
        }
        break;

    case 'deploy_sync':
    case 'storage_link':
    case 'optimize':
    case 'clear_cache':
    case 'migrate':
        if (! $hasVendor) {
            $results['Error'] = "Perintah Artisan membutuhkan folder 'vendor/' yang berisi autoloader Laravel. Silakan jalankan 'composer install' di Terminal cPanel terlebih dahulu.";
            break;
        }

        try {
            require $laravelRoot.'/vendor/autoload.php';
            $app = require_once $laravelRoot.'/bootstrap/app.php';
            $kernel = $app->make(Kernel::class);

            function runArtisanCmd($kernel, $command, $params = [])
            {
                ob_start();
                try {
                    $kernel->call($command, $params);
                    $output = $kernel->output();
                } catch (Throwable $e) {
                    $output = 'Error: '.$e->getMessage();
                }
                ob_end_clean();

                return $output;
            }

            if ($action === 'storage_link') {
                $results['storage:link'] = runArtisanCmd($kernel, 'storage:link');
            } elseif ($action === 'optimize') {
                $results['config:cache'] = runArtisanCmd($kernel, 'config:cache');
                $results['route:cache'] = runArtisanCmd($kernel, 'route:cache');
                $results['view:cache'] = runArtisanCmd($kernel, 'view:cache');
            } elseif ($action === 'clear_cache') {
                $results['optimize:clear'] = runArtisanCmd($kernel, 'optimize:clear');
            } elseif ($action === 'migrate') {
                $results['migrate'] = runArtisanCmd($kernel, 'migrate', ['--force' => true]);
            } elseif ($action === 'deploy_sync') {
                // Ensure storage directories exist
                $storageDirs = [
                    $laravelRoot.'/storage/framework/cache/data',
                    $laravelRoot.'/storage/framework/sessions',
                    $laravelRoot.'/storage/framework/views',
                    $laravelRoot.'/storage/logs',
                    $laravelRoot.'/bootstrap/cache',
                ];
                foreach ($storageDirs as $d) {
                    ensureDirWritable($d);
                }

                $currentDir = __DIR__;
                $sourcePublic = $laravelRoot.'/public';
                $synced = 0;

                $targetDirs = array_unique([
                    $currentDir,
                    '/home/berandad/pksoganilir.com/public',
                ]);

                foreach ($targetDirs as $targetDir) {
                    if (is_dir($targetDir) && is_dir($sourcePublic)) {
                        $iterator = new RecursiveIteratorIterator(
                            new RecursiveDirectoryIterator($sourcePublic, RecursiveDirectoryIterator::SKIP_DOTS),
                            RecursiveIteratorIterator::SELF_FIRST
                        );
                        foreach ($iterator as $item) {
                            $subPath = $iterator->getSubPathName();
                            $target = $targetDir.'/'.$subPath;
                            if ($item->isDir()) {
                                if (! is_dir($target)) {
                                    @mkdir($target, 0755, true);
                                }
                            } else {
                                @copy($item->getPathname(), $target);
                                $synced++;
                            }
                        }
                    }
                }

                $results['Asset Sync'] = "Berhasil menyinkronkan {$synced} file aset dari repositori public/ ke folder web document root pksoganilir.com!";
                $results['storage:link'] = runArtisanCmd($kernel, 'storage:link');
                $results['cache:clear'] = runArtisanCmd($kernel, 'optimize:clear');
                $results['config:cache'] = runArtisanCmd($kernel, 'config:cache');
                $results['route:cache'] = runArtisanCmd($kernel, 'route:cache');
                $results['view:cache'] = runArtisanCmd($kernel, 'view:cache');
            }
        } catch (Throwable $e) {
            $results['Bootstrap Error'] = $e->getMessage().' ('.$e->getFile().':'.$e->getLine().')';
        }
        break;

    case 'status':
    default:
        $results['Host Permintaan'] = $_SERVER['HTTP_HOST'] ?? 'Tidak diketahui';
        $results['Dokumen Root ($_SERVER[DOCUMENT_ROOT])'] = $_SERVER['DOCUMENT_ROOT'] ?? 'Tidak diketahui';
        $results['Folder Aktif File (__DIR__)'] = __DIR__;
        $results['Folder di Home (/home/berandad/*)'] = implode("\n", glob('/home/berandad/*') ?: []);
        $results['Lokasi Root Laravel'] = $laravelRoot;
        $results['Versi PHP'] = PHP_VERSION.(version_compare(PHP_VERSION, '8.2.0', '>=') ? ' (OK)' : ' (TERLALU RENDAH - Butuh PHP 8.2+)');
        $results['Status vendor/'] = $hasVendor ? 'TERSEDIA (Autoloader Siap)' : 'BELUM ADA (Perlu composer install atau upload vendor.zip)';
        $results['Status file .env'] = $hasEnv ? 'TERSEDIA ('.$envFile.')' : 'BELUM ADA (Gunakan tombol Buat .env Otomatis)';

        // Test Database connection using PDO directly from .env variables
        if ($hasEnv && ! empty($envVars['DB_DATABASE'])) {
            $dbHost = $envVars['DB_HOST'] ?? '127.0.0.1';
            $dbPort = $envVars['DB_PORT'] ?? '3306';
            $dbName = $envVars['DB_DATABASE'];
            $dbUser = $envVars['DB_USERNAME'] ?? 'root';
            $dbPass = $envVars['DB_PASSWORD'] ?? '';
            try {
                $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 3,
                ]);
                $stmt = $pdo->query("SELECT count(*) FROM information_schema.tables WHERE table_schema = '{$dbName}'");
                $tableCount = $stmt->fetchColumn();
                $results['Koneksi Database MySQL'] = "SUKSES TERHUBUNG ke database '{$dbName}' ({$tableCount} tabel terdeteksi)";
            } catch (Throwable $e) {
                $results['Koneksi Database MySQL'] = 'GAGAL: '.$e->getMessage();
            }
        } else {
            $results['Koneksi Database MySQL'] = 'Menunggu konfigurasi .env';
        }

        // Storage writable check
        $storageDir = $laravelRoot.'/storage';
        $results['Folder Storage Writable'] = is_writable($storageDir) ? 'AKTIF (Bisa ditulisi)' : 'PERIKSA IZIN (Gunakan tombol Perbaiki Storage)';
        $results['Dukungan GD WebP'] = function_exists('imagewebp') ? 'AKTIF (Siap konversi gambar WebP otomatis)' : 'NON-AKTIF';
        break;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cPanel Helper & Diagnostic - DPD PKS Ogan Ilir</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; padding: 2rem 1rem; color: #e2e8f0; margin: 0; }
        .card { max-width: 800px; margin: 0 auto; background: #1e293b; border-radius: 12px; border: 1px solid #334155; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.5); padding: 2rem; }
        h1 { font-size: 1.4rem; color: #f97316; margin-top: 0; margin-bottom: 1.5rem; border-bottom: 2px solid #ea580c; padding-bottom: 0.5rem; }
        .section-title { font-size: 0.95rem; font-weight: 700; color: #cbd5e1; margin-top: 1.5rem; margin-bottom: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .nav-links { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 1.5rem; }
        .nav-links a { background: #ea580c; color: white; padding: 8px 14px; text-decoration: none; border-radius: 6px; font-size: 0.85rem; font-weight: 600; display: inline-block; transition: background 0.2s; }
        .nav-links a:hover { background: #c2410c; }
        .nav-links a.green { background: #16a34a; }
        .nav-links a.green:hover { background: #15803d; }
        .nav-links a.blue { background: #2563eb; }
        .nav-links a.blue:hover { background: #1d4ed8; }
        .nav-links a.gray { background: #475569; }
        .nav-links a.gray:hover { background: #334155; }
        .result-box { background: #020617; border: 1px solid #334155; color: #38bdf8; padding: 1.25rem; border-radius: 8px; font-family: monospace; font-size: 0.85rem; overflow-x: auto; line-height: 1.6; }
        .result-box strong { color: #f97316; }
        .warning { margin-top: 1.5rem; font-size: 0.85rem; color: #fca5a5; background: #450a0a; border: 1px solid #991b1b; padding: 1rem; border-radius: 6px; }
        .terminal-box { background: #020617; border: 1px solid #1e3a8a; padding: 1rem; border-radius: 8px; margin-top: 1rem; font-size: 0.85rem; color: #93c5fd; }
        .terminal-cmd { background: #0f172a; padding: 0.5rem; border-radius: 4px; color: #a5f3fc; font-family: monospace; margin: 0.5rem 0; word-break: break-all; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🛠️ Helper &amp; Diagnostik cPanel - DPD PKS Ogan Ilir</h1>
        
        <div class="section-title">1. Diagnostik &amp; Persiapan Awal</div>
        <div class="nav-links">
            <a href="?token=<?= $secretToken ?>&amp;action=status" class="blue">🔍 Cek Status Sistem</a>
            <a href="?token=<?= $secretToken ?>&amp;action=git_pull" class="green">⬇️ Tarik Update Git (Pull)</a>
            <a href="?token=<?= $secretToken ?>&amp;action=git_reset" style="background:#dc2626;">🔄 Bersihkan Git &amp; Reset</a>
            <?php if (! $hasEnv) { ?>
                <a href="?token=<?= $secretToken ?>&amp;action=create_env" class="green">📝 Buat File .env Otomatis</a>
            <?php } ?>
            <a href="?token=<?= $secretToken ?>&amp;action=fix_storage" class="gray">📁 Perbaiki Izin Storage (0775)</a>
            <a href="?token=<?= $secretToken ?>&amp;action=extract_vendor" class="gray">📦 Ekstrak vendor.zip</a>
        </div>

        <div class="section-title">2. Tindakan Eksekusi Laravel (Artisan)</div>
        <div class="nav-links">
            <a href="?token=<?= $secretToken ?>&amp;action=deploy_sync" class="green">⚡ Sinkron &amp; Deploy Lengkap</a>
            <a href="?token=<?= $secretToken ?>&amp;action=storage_link">🔗 Buat Storage Link</a>
            <a href="?token=<?= $secretToken ?>&amp;action=optimize">🚀 Optimasi Cache (Produksi)</a>
            <a href="?token=<?= $secretToken ?>&amp;action=clear_cache" class="gray">🧹 Bersihkan Cache</a>
            <a href="?token=<?= $secretToken ?>&amp;action=migrate" class="gray">🗄️ Migrasi Database</a>
        </div>

        <div class="result-box">
            <?php foreach ($results as $k => $v) { ?>
                <strong>[<?= htmlspecialchars($k) ?>]</strong><br>
                <?= nl2br(htmlspecialchars(trim($v))) ?><br><br>
            <?php } ?>
        </div>

        <?php if (! $hasVendor) { ?>
            <div class="terminal-box">
                <strong>💡 Solusi Folder vendor/ yang Belum Ada:</strong><br>
                Folder <code>vendor/</code> tidak ikut di-commit ke Git. Untuk memasangnya di server cPanel:<br>
                1. Buka menu <strong>Terminal</strong> di cPanel Anda.<br>
                2. Jalankan perintah berikut:
                <div class="terminal-cmd">cd <?= htmlspecialchars($laravelRoot) ?> &amp;&amp; composer install --no-dev --optimize-autoloader</div>
                <em>Alternatif tanpa terminal:</em> Zip folder <code>vendor</code> di komputer lokal Anda, upload <code>vendor.zip</code> ke folder <code><?= htmlspecialchars($laravelRoot) ?></code> melalui cPanel File Manager, lalu klik tombol <strong>Ekstrak vendor.zip</strong> di atas.
            </div>
        <?php } ?>

        <div class="warning">
            ⚠️ <strong>Keamanan:</strong> Setelah website Anda berjalan lancar di cPanel, hapus file <code>public/cpanel_setup.php</code> demi keamanan sistem produksi.
        </div>
    </div>
</body>
</html>
