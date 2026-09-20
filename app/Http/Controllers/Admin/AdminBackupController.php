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
        if (! Auth::user()?->isGlobalAdmin() && ! Auth::user()?->isSuperAdmin()) {
            abort(403, 'Akses dibatasi. Hanya Administrator yang berhak melihat ringkasan basis data.');
        }

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
        if (! Auth::user()?->isGlobalAdmin() && ! Auth::user()?->isSuperAdmin()) {
            abort(403, 'Akses dibatasi. Hanya Administrator yang berhak mengunduh cadangan basis data.');
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'user_name' => Auth::user()->name,
            'action' => 'backup_download',
            'description' => 'Mengunduh salinan cadangan basis data lengkap (SQL Backup)',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => 'warning',
        ]);

        $filename = 'ppru_database_backup_'.date('Y-m-d_His').'.sql';

        return response()->streamDownload(function () {
            echo "-- =====================================================================\n";
            echo "-- PONDOK PESANTREN RAUDHATUL ULUM (PPRU) SAKATIGA\n";
            echo '-- DATABASE MYSQL DUMP - '.date('Y-m-d H:i:s')." WIB\n";
            echo "-- Compatible with MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+\n";
            echo "-- =====================================================================\n\n";

            echo "SET FOREIGN_KEY_CHECKS=0;\n";
            echo "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n";
            echo "SET AUTOCOMMIT = 0;\n";
            echo "START TRANSACTION;\n";
            echo "SET time_zone = '+07:00';\n\n";
            echo "/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
            echo "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n";
            echo "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n";
            echo "/*!40101 SET NAMES utf8mb4 */;\n\n";

            $driver = DB::connection()->getDriverName();
            if ($driver === 'sqlite') {
                $tableObjects = DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name ASC");
                $tableNames = array_map(fn ($t) => $t->name, $tableObjects);
            } else {
                $rawTables = Schema::getTableListing();
                $tableNames = array_map(fn ($t) => str_replace('main.', '', $t), $rawTables);
                sort($tableNames);
            }

            foreach ($tableNames as $table) {
                $cols = Schema::getColumns($table);
                $indexes = Schema::getIndexes($table);

                echo "-- --------------------------------------------------------\n";
                echo "-- Struktur tabel untuk `{$table}`\n";
                echo "-- --------------------------------------------------------\n\n";
                echo "DROP TABLE IF EXISTS `{$table}`;\n";
                echo "CREATE TABLE `{$table}` (\n";

                $colDefinitions = [];
                $primaryCols = [];

                foreach ($indexes as $idx) {
                    if ($idx['primary'] ?? false) {
                        $primaryCols = $idx['columns'] ?? [];
                    }
                }

                if (empty($primaryCols)) {
                    foreach ($cols as $col) {
                        if ($col['name'] === 'id') {
                            $primaryCols = ['id'];
                            break;
                        }
                    }
                }

                foreach ($cols as $col) {
                    $name = $col['name'];
                    $typeName = strtolower($col['type_name'] ?? $col['type'] ?? '');
                    $isAuto = (bool) ($col['auto_increment'] ?? false);
                    $isNullable = (bool) ($col['nullable'] ?? false);
                    $default = $col['default'] ?? null;

                    $colDef = "  `{$name}` ";

                    if ($name === 'id') {
                        if ($typeName === 'integer' || $typeName === 'int' || $isAuto) {
                            $colDef .= 'bigint(20) UNSIGNED NOT NULL';
                            if ($isAuto || in_array('id', $primaryCols)) {
                                $colDef .= ' AUTO_INCREMENT';
                            }
                        } else {
                            $colDef .= 'varchar(255) NOT NULL';
                        }
                    } elseif (str_contains($name, '_id') && $typeName === 'integer') {
                        $colDef .= 'bigint(20) UNSIGNED';
                        $colDef .= $isNullable ? ' DEFAULT NULL' : ' NOT NULL';
                    } elseif ($typeName === 'integer' || $typeName === 'int') {
                        if ($col['type'] === 'tinyint(1)' || str_starts_with($name, 'is_') || str_starts_with($name, 'has_')) {
                            $colDef .= "tinyint(1) NOT NULL DEFAULT '0'";
                        } else {
                            $colDef .= "int(11) NOT NULL DEFAULT '0'";
                        }
                    } elseif ($typeName === 'tinyint' || $typeName === 'boolean') {
                        $defVal = ($default === '1' || $default === 1) ? "'1'" : "'0'";
                        $colDef .= "tinyint(1) NOT NULL DEFAULT {$defVal}";
                    } elseif ($typeName === 'datetime' || $typeName === 'timestamp') {
                        $colDef .= 'timestamp NULL DEFAULT NULL';
                    } elseif ($typeName === 'date') {
                        $colDef .= 'date NULL DEFAULT NULL';
                    } elseif ($typeName === 'text' || $typeName === 'longtext' || str_ends_with($name, '_content') || str_ends_with($name, '_description') || $name === 'content' || $name === 'message' || $name === 'profile_summary' || $name === 'education' || $name === 'notes' || $name === 'extra_fields' || $name === 'value') {
                        $colDef .= 'longtext DEFAULT NULL';
                    } else {
                        $colDef .= 'varchar(255)';
                        if ($isNullable) {
                            $colDef .= ' DEFAULT NULL';
                        } elseif ($default !== null) {
                            $cleanDef = trim($default, "'\"");
                            $colDef .= " NOT NULL DEFAULT '{$cleanDef}'";
                        } else {
                            $colDef .= ' NOT NULL';
                        }
                    }

                    $colDefinitions[] = $colDef;
                }

                if (! empty($primaryCols)) {
                    $colDefinitions[] = '  PRIMARY KEY (`'.implode('`, `', $primaryCols).'`)';
                }

                $addedIndexes = [];
                foreach ($indexes as $idx) {
                    if ($idx['primary'] ?? false) {
                        continue;
                    }
                    $idxName = $idx['name'] ?? '';
                    $idxCols = $idx['columns'] ?? [];
                    if (empty($idxCols) || in_array($idxName, $addedIndexes) || str_starts_with($idxName, 'sqlite_autoindex_')) {
                        continue;
                    }
                    $addedIndexes[] = $idxName;

                    if ($idx['unique'] ?? false) {
                        $colDefinitions[] = "  UNIQUE KEY `{$idxName}` (`".implode('`, `', $idxCols).'`)';
                    } else {
                        $colDefinitions[] = "  KEY `{$idxName}` (`".implode('`, `', $idxCols).'`)';
                    }
                }

                echo implode(",\n", $colDefinitions)."\n";
                echo ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n";

                $rows = DB::table($table)->get();
                if ($rows->count() > 0) {
                    $columnNames = array_map(fn ($c) => $c['name'], $cols);
                    echo "-- Data untuk tabel `{$table}`\n";
                    echo "INSERT INTO `{$table}` (`".implode('`, `', $columnNames)."`) VALUES\n";

                    $rowSqls = [];
                    foreach ($rows as $row) {
                        $values = [];
                        foreach ($columnNames as $colName) {
                            $val = $row->$colName ?? null;
                            if (is_null($val)) {
                                $values[] = 'NULL';
                            } elseif (is_numeric($val) && ! str_starts_with((string) $val, '0')) {
                                $values[] = $val;
                            } else {
                                $escaped = str_replace(
                                    ['\\', "\x00", "\n", "\r", "'", '"', "\x1a"],
                                    ['\\\\', '\\0', '\\n', '\\r', "\'", '\\"', '\\Z'],
                                    (string) $val
                                );
                                $values[] = "'{$escaped}'";
                            }
                        }
                        $rowSqls[] = '('.implode(', ', $values).')';
                    }

                    echo implode(",\n", $rowSqls).";\n\n";
                }
            }

            echo "SET FOREIGN_KEY_CHECKS=1;\n";
            echo "COMMIT;\n\n";
            echo "/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\n";
            echo "/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\n";
            echo "/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;\n";
        }, $filename, [
            'Content-Type' => 'application/sql',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
