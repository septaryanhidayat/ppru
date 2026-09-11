<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
header('Content-Type: text/plain; charset=UTF-8');

echo "=== DIAGNOSTIK SERVER PKS OGAN ILIR ===\n";
echo "PHP Version: " . PHP_VERSION . "\n";
echo "Server Software: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "\n";
echo "Current Directory (__DIR__): " . __DIR__ . "\n";
echo "Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "\n";
echo "Server Name: " . ($_SERVER['SERVER_NAME'] ?? 'Unknown') . "\n";

$candidates = [
    __DIR__ . '/..',
    dirname(__DIR__) . '/repositories/pksoi',
    dirname(__DIR__) . '/laravel_pksoi',
    dirname(__DIR__) . '/pksoi',
    '/home/berandad/repositories/pksoi',
];

echo "\n--- Pengecekan Lokasi Repositori Laravel ---\n";
$foundRoot = null;
foreach ($candidates as $c) {
    $exists = file_exists($c . '/bootstrap/app.php');
    echo $c . " => " . ($exists ? "DITEMUKAN" : "TIDAK ADA") . "\n";
    if ($exists && !$foundRoot) $foundRoot = realpath($c);
}

if ($foundRoot) {
    echo "\nRoot Terdeteksi: " . $foundRoot . "\n";
    echo "vendor/autoload.php: " . (file_exists($foundRoot . '/vendor/autoload.php') ? "ADA" : "TIDAK ADA") . "\n";
    echo ".env: " . (file_exists($foundRoot . '/.env') ? "ADA" : "TIDAK ADA") . "\n";
    echo "storage is_writable: " . (is_writable($foundRoot . '/storage') ? "YA" : "TIDAK") . "\n";
    
    // Check .env DB settings
    if (file_exists($foundRoot . '/.env')) {
        $env = [];
        $lines = file($foundRoot . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#')) continue;
            if (str_contains($line, '=')) {
                [$k, $v] = explode('=', $line, 2);
                $env[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
            }
        }
        echo "DB_CONNECTION: " . ($env['DB_CONNECTION'] ?? 'none') . "\n";
        echo "DB_DATABASE: " . ($env['DB_DATABASE'] ?? 'none') . "\n";
        echo "DB_USERNAME: " . ($env['DB_USERNAME'] ?? 'none') . "\n";
        
        // Test PDO
        if (!empty($env['DB_DATABASE'])) {
            try {
                $dbHost = $env['DB_HOST'] ?? '127.0.0.1';
                $dbPort = $env['DB_PORT'] ?? '3306';
                $pdo = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$env['DB_DATABASE']};charset=utf8mb4", $env['DB_USERNAME'], $env['DB_PASSWORD'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_TIMEOUT => 3,
                ]);
                echo "MySQL Connection: SUKSES!\n";
            } catch (Exception $e) {
                echo "MySQL Connection Error: " . $e->getMessage() . "\n";
            }
        }
    }
} else {
    echo "\nPERINGATAN: Tidak dapat menemukan folder Laravel bootstrap/app.php!\n";
}
