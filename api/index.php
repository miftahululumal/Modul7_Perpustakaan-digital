<?php

// Jangan cetak peringatan/notice ke respons, dan tahan keluaran supaya header (Location, Set-Cookie) tetap terkirim
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE & ~E_WARNING);
ob_start();

// Vercel hanya bisa menulis di /tmp, jadi folder penyimpanan Laravel dialihkan ke sana
$storage = '/tmp/storage';
foreach (['framework/views', 'framework/cache/data', 'framework/sessions', 'logs'] as $dir) {
    if (!is_dir("$storage/$dir")) {
        mkdir("$storage/$dir", 0777, true);
    }
}

$env = [
    'LARAVEL_STORAGE_PATH'  => $storage,
    'VIEW_COMPILED_PATH'    => "$storage/framework/views",
    // Cache bootstrap dialihkan ke /tmp karena folder bootstrap/cache read-only
    'APP_PACKAGES_CACHE'    => '/tmp/packages.php',
    'APP_SERVICES_CACHE'    => '/tmp/services.php',
    'APP_CONFIG_CACHE'      => '/tmp/config.php',
    'APP_ROUTES_CACHE'      => '/tmp/routes.php',
    'APP_EVENTS_CACHE'      => '/tmp/events.php',
    // Catat galat ke STDERR supaya muncul di Runtime Logs Vercel
    'LOG_CHANNEL'           => 'stderr',
];

foreach ($env as $key => $value) {
    putenv("$key=$value");
    $_ENV[$key] = $value;
    $_SERVER[$key] = $value;
}

$_SERVER['HTTPS'] = 'on';
$_SERVER['SERVER_PORT'] = 443;

// Beri tahu Laravel bahwa skrip utamanya adalah /index.php di root, supaya awalan "/api" pada URL tidak dibuang
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../public/index.php';

// Teruskan semua permintaan ke pintu masuk Laravel yang asli
require __DIR__ . '/../public/index.php';