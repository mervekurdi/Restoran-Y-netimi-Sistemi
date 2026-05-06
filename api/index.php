<?php
$appDirectory = __DIR__ . '/..';

$tempDir = '/tmp';

// Set environment variables to move Laravel storage to /tmp
putenv("APP_CONFIG_CACHE={$tempDir}/config.php");
putenv("APP_EVENTS_CACHE={$tempDir}/events.php");
putenv("APP_PACKAGES_CACHE={$tempDir}/packages.php");
putenv("APP_ROUTES_CACHE={$tempDir}/routes.php");
putenv("APP_SERVICES_CACHE={$tempDir}/services.php");
putenv("VIEW_COMPILED_PATH={$tempDir}/views");

// Use Vercel-friendly drivers
putenv("LOG_CHANNEL=stderr");
putenv("SESSION_DRIVER=cookie");
putenv("CACHE_STORE=array");

// Ensure views directory exists
if (!file_exists("{$tempDir}/views")) {
    mkdir("{$tempDir}/views", 0777, true);
}

require $appDirectory . '/public/index.php';
