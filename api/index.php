<?php

// Fix for Laravel routing on Vercel
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Ensure views directory exists
if (!file_exists('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

require __DIR__.'/../public/index.php';
