<?php

// Fix for Laravel routing on Vercel
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Ensure required /tmp directories exist
if (!file_exists('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// Auto-create SQLite database file if it doesn't exist
if (!file_exists('/tmp/database.sqlite')) {
    touch('/tmp/database.sqlite');
}

require __DIR__.'/../public/index.php';
