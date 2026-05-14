<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

// Auto-create SQLite database file and run migrations on cold start
$dbPath = '/tmp/database.sqlite';
if (!file_exists($dbPath) || filesize($dbPath) === 0) {
    touch($dbPath);
    try {
        $kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('migrate', ['--force' => true]);
    } catch (\Throwable $e) {
        error_log('Migration failed: ' . $e->getMessage());
    }
}

$app->handleRequest(Request::capture());
