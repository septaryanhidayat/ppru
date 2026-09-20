<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

$dumpFile = __DIR__.'/cpanel_school_mysql_dump.sql';
$fp = fopen($dumpFile, 'w');

fwrite($fp, "-- ==========================================================\n");
fwrite($fp, "-- PONDOK PESANTREN RAUDHATUL ULUM (PPRU) - DATABASE MYSQL EXPORT\n");
fwrite($fp, '-- Export Date: '.date('Y-m-d H:i:s')."\n");
fwrite($fp, "-- Compatible: MySQL 5.7+, MySQL 8.0+, MariaDB 10.3+\n");
fwrite($fp, "-- For cPanel phpMyAdmin Import & Git Deployments\n");
fwrite($fp, "-- ==========================================================\n\n");

fwrite($fp, "SET FOREIGN_KEY_CHECKS=0;\n");
fwrite($fp, "SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';\n");
fwrite($fp, "SET NAMES utf8mb4;\n");
fwrite($fp, "SET time_zone = '+07:00';\n\n");

$rawTables = Schema::getTableListing();
$tables = [];
foreach ($rawTables as $tName) {
    $clean = str_replace('main.', '', $tName);
    if (! str_starts_with($clean, 'sqlite_')) {
        $tables[] = $clean;
    }
}
sort($tables);

foreach ($tables as $table) {
    // Get column definitions
    $columnsInfo = DB::select("PRAGMA table_info('{$table}')");
    if (empty($columnsInfo)) {
        echo "Skipping empty info: {$table}\n";

        continue;
    }
    echo "Exporting table: {$table} (".count($columnsInfo)." cols)\n";

    fwrite($fp, "-- --------------------------------------------------------\n");
    fwrite($fp, "-- Table structure for table `{$table}`\n");
    fwrite($fp, "-- --------------------------------------------------------\n");
    fwrite($fp, "DROP TABLE IF EXISTS `{$table}`;\n");
    fwrite($fp, "CREATE TABLE `{$table}` (\n");

    $colLines = [];
    $primaryKeys = [];
    $pkCols = array_values(array_filter($columnsInfo, fn ($c) => (int) $c->pk > 0));
    $isSinglePk = count($pkCols) === 1;
    $singlePkName = $isSinglePk ? $pkCols[0]->name : null;

    foreach ($columnsInfo as $col) {
        $cName = $col->name;
        $cType = strtolower($col->type);
        $notNull = $col->notnull ? 'NOT NULL' : 'NULL';
        $dflt = $col->dflt_value;

        // Map sqlite type to MySQL
        if ($col->pk) {
            $primaryKeys[] = "`{$cName}`";
            $notNull = 'NOT NULL';
        }

        $myType = 'varchar(255)';
        $extra = '';
        $isAutoIncrement = ($isSinglePk && $cName === $singlePkName && $cName === 'id' && str_contains($cType, 'int'));

        if ($isAutoIncrement) {
            $myType = 'bigint(20) UNSIGNED';
            $extra = 'AUTO_INCREMENT';
            $notNull = 'NOT NULL';
        } elseif (str_contains($cType, 'bigint') || str_ends_with($cName, '_id')) {
            $myType = 'bigint(20) UNSIGNED';
        } elseif (str_contains($cType, 'int')) {
            $myType = 'int(11)';
        } elseif (str_contains($cType, 'tinyint') || $cType === 'boolean') {
            $myType = 'tinyint(1)';
        } elseif (str_contains($cType, 'text') || str_contains($cType, 'clob')) {
            $myType = 'longtext';
        } elseif (str_contains($cType, 'json')) {
            $myType = 'longtext';
        } elseif (str_contains($cType, 'date') && ! str_contains($cType, 'time')) {
            $myType = 'date';
        } elseif (str_contains($cType, 'time') || str_contains($cType, 'timestamp')) {
            $myType = 'timestamp';
        } elseif (str_contains($cType, 'float') || str_contains($cType, 'double') || str_contains($cType, 'decimal')) {
            $myType = 'decimal(10,2)';
        } elseif (preg_match('/varchar\((\d+)\)/i', $cType, $m)) {
            $myType = "varchar({$m[1]})";
        } else {
            $myType = 'varchar(255)';
        }

        $defaultClause = '';
        if ($extra !== 'AUTO_INCREMENT') {
            if ($dflt !== null) {
                $cleanDflt = trim($dflt, "'\"");
                if ($cleanDflt === 'CURRENT_TIMESTAMP') {
                    $defaultClause = 'DEFAULT CURRENT_TIMESTAMP';
                } elseif (is_numeric($cleanDflt)) {
                    $defaultClause = "DEFAULT {$cleanDflt}";
                } else {
                    $defaultClause = "DEFAULT '{$cleanDflt}'";
                }
            } elseif (! $col->notnull) {
                $defaultClause = 'DEFAULT NULL';
            }
        }

        $colDef = "  `{$cName}` {$myType} {$notNull}";
        if ($defaultClause) {
            $colDef .= " {$defaultClause}";
        }
        if ($extra) {
            $colDef .= " {$extra}";
        }

        $colLines[] = $colDef;
    }

    if (! empty($primaryKeys)) {
        $colLines[] = '  PRIMARY KEY ('.implode(', ', $primaryKeys).')';
    }

    $indices = DB::select("PRAGMA index_list('{$table}')");
    foreach ($indices as $idx) {
        if (str_starts_with($idx->name, 'sqlite_autoindex_')) {
            continue;
        }
        $info = DB::select("PRAGMA index_info('{$idx->name}')");
        if (empty($info)) {
            continue;
        }
        $cols = array_map(fn ($c) => "`{$c->name}`", $info);
        $idxType = $idx->unique ? 'UNIQUE KEY' : 'KEY';
        $colLines[] = "  {$idxType} `{$idx->name}` (".implode(', ', $cols).')';
    }

    fwrite($fp, implode(",\n", $colLines)."\n");
    fwrite($fp, ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;\n\n");

    // Table data
    $rows = DB::table($table)->get();
    if ($rows->count() > 0) {
        fwrite($fp, "-- Dumping data for table `{$table}`\n");
        $allCols = array_map(fn ($c) => $c->name, $columnsInfo);

        $chunks = $rows->chunk(100);
        foreach ($chunks as $chunk) {
            fwrite($fp, "INSERT INTO `{$table}` (`".implode('`, `', $allCols)."`) VALUES\n");
            $valLines = [];
            foreach ($chunk as $row) {
                $vals = [];
                foreach ($allCols as $c) {
                    $val = $row->$c ?? null;
                    if (is_null($val)) {
                        $vals[] = 'NULL';
                    } elseif (is_numeric($val) && ! str_starts_with((string) $val, '0')) {
                        $vals[] = $val;
                    } else {
                        $escaped = str_replace(
                            ['\\', "\x00", "\n", "\r", "'", '"', "\x1a"],
                            ['\\\\', '\\0', '\\n', '\\r', "\'", '\\"', '\\Z'],
                            (string) $val
                        );
                        $vals[] = "'{$escaped}'";
                    }
                }
                $valLines[] = '  ('.implode(', ', $vals).')';
            }
            fwrite($fp, implode(",\n", $valLines).";\n");
        }
        fwrite($fp, "\n");
    }
}

fwrite($fp, "SET FOREIGN_KEY_CHECKS=1;\n");
fwrite($fp, "-- ==========================================================\n");
fwrite($fp, "-- END OF DUMP\n");
fwrite($fp, "-- ==========================================================\n");

fclose($fp);

echo "Export completed successfully! Saved to: {$dumpFile} (".round(filesize($dumpFile) / 1024, 2)." KB)\n";
