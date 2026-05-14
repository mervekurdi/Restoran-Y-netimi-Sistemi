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
if (!file_exists($dbPath)) {
    touch($dbPath);
}

require __DIR__.'/../public/index.php';
