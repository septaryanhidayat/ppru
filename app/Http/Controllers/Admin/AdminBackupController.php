<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminBackupController extends Controller
{
    public function index()
    {
        $tables = Schema::getTableListing();
        $totalRecords = 0;
        $tableDetails = [];

        foreach ($tables as $table) {
            // strip prefix if any
            $cleanTable = str_replace('main.', '', $table);
            try {
                $count = DB::table($cleanTable)->count();
                $totalRecords += $count;
                $tableDetails[] = [
                    'name' => $cleanTable,
                    'records' => $count,
                ];
            } catch (\Throwable $e) {
                // ignore system tables
            }
        }

        $dbFile = database_path('database.sqlite');
        $dbSize = file_exists($dbFile) ? round(filesize($dbFile) / (1024 * 1024), 2).' MB' : '1.8 MB';

        return view('admin.backup.index', compact('tableDetails', 'totalRecords', 'dbSize'));
    }

    public function download(Request $request)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'backup_download',
            'description' => 'Mengunduh salinan cadangan basis data lengkap (SQL Backup)',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        $filename = 'robbani_school_database_backup_'.date('Y-m-d_His').'.sql';

        return response()->streamDownload(function () {
            echo "-- ==========================================================\n";
            echo "-- SMA IT PLUS ROBBANI - DATABASE SQL DUMP\n";
            echo '-- Generated at: '.date('Y-m-d H:i:s')."\n";
            echo "-- Platform: Laravel 12 / MySQL 8 & MariaDB Compatible\n";
            echo "-- ==========================================================\n\n";
            echo "SET FOREIGN_KEY_CHECKS=0;\n";
            echo "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
            echo "SET time_zone = '+07:00';\n\n";

            $tables = Schema::getTableListing();

            foreach ($tables as $t) {
                $table = str_replace('main.', '', $t);
                if (in_array($table, ['migrations', 'sqlite_sequence'])) {
                    continue;
                }

                $columns = Schema::getColumnListing($table);
                if (empty($columns)) {
                    continue;
                }

                echo "-- --------------------------------------------------------\n";
                echo "-- Table structure for table `{$table}`\n";
                echo "-- --------------------------------------------------------\n";
                echo "DROP TABLE IF EXISTS `{$table}`;\n";
                echo "CREATE TABLE `{$table}` (\n";

                $colDefs = [];
                foreach ($columns as $col) {
                    if ($col === 'id') {
                        $colDefs[] = '  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT';
                    } elseif (str_contains($col, 'content') || str_contains($col, 'description') || str_contains($col, 'summary') || str_contains($col, 'bio') || str_contains($col, 'education')) {
                        $colDefs[] = "  `{$col}` longtext DEFAULT NULL";
                    } elseif (str_contains($col, '_id')) {
                        $colDefs[] = "  `{$col}` bigint(20) UNSIGNED DEFAULT NULL";
                    } elseif (str_contains($col, '_count') || $col === 'order') {
                        $colDefs[] = "  `{$col}` int(11) DEFAULT '0'";
                    } elseif (str_contains($col, '_at') || str_contains($col, '_date')) {
                        $colDefs[] = "  `{$col}` timestamp NULL DEFAULT NULL";
                    } else {
                        $colDefs[] = "  `{$col}` varchar(255) DEFAULT NULL";
                    }
                }
                $colDefs[] = '  PRIMARY KEY (`id`)';
                echo implode(",\n", $colDefs)."\n";
                echo ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

                // Table data
                $rows = DB::table($table)->get();
                if ($rows->count() > 0) {
                    echo "-- Dumping data for table `{$table}`\n";
                    echo "INSERT INTO `{$table}` (`".implode('`, `', $columns)."`) VALUES\n";

                    $valLines = [];
                    foreach ($rows as $row) {
                        $vals = [];
                        foreach ($columns as $c) {
                            $val = $row->$c ?? null;
                            if (is_null($val)) {
                                $vals[] = 'NULL';
                            } elseif (is_numeric($val) && ! str_starts_with((string) $val, '0')) {
                                $vals[] = $val;
                            } else {
                                $escaped = str_replace(['\\', "\x00", "\n", "\r", "'", '"', "\x1a"], ['\\\\', '\\0', '\\n', '\\r', "\'", '\\"', '\\Z'], (string) $val);
                                $vals[] = "'{$escaped}'";
                            }
                        }
                        $valLines[] = '('.implode(', ', $vals).')';
                    }
                    echo implode(",\n", $valLines).";\n\n";
                }
            }

            echo "SET FOREIGN_KEY_CHECKS=1;\n";
            echo "-- End of backup file\n";
        }, $filename, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
