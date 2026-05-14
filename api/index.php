<?php

// Fix for Laravel routing on Vercel
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Ensure required /tmp directories exist
foreach (['/tmp/views', '/tmp'] as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
    }
}

// Auto-create SQLite database file if it doesn't exist
$dbPath = '/tmp/database.sqlite';
$isNewDb = !file_exists($dbPath) || filesize($dbPath) === 0;
if ($isNewDb) {
    touch($dbPath);
}

// Boot the app
require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

// Auto-run migrations on fresh database (Vercel cold start)
if ($isNewDb) {
    try {
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('migrate', ['--force' => true, '--path' => 'database/migrations']);
    } catch (\Throwable $e) {
        // Log migration error but don't crash the request
        error_log('Migration failed: ' . $e->getMessage());
    }
}

$app->handleRequest(\Illuminate\Http\Request::capture());
