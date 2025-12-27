#!/usr/bin/env php
<?php
require __DIR__ . '/../app/Support/DB.php';

$migrationsDir = __DIR__ . '/../migrations';
$files = glob($migrationsDir . '/*.sql');
if (!$files) {
    echo "No migration files found in {$migrationsDir}\n";
    exit(0);
}

usort($files, function ($a, $b) { return strcmp($a, $b); });

try {
    $pdoRoot = DB::pdoRoot();
    foreach ($files as $file) {
        echo "Applying migration: {$file}\n";
        $sql = file_get_contents($file);
        $stmts = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql)));
        foreach ($stmts as $stmt) {
            if ($stmt === '') continue;
            $pdoRoot->exec($stmt);
        }
    }
    echo "Migrations applied.\n";
} catch (Exception $e) {
    echo "Migration error: " . $e->getMessage() . "\n";
    exit(1);
}
