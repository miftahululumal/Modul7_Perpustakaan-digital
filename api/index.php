<?php

// Vercel hanya bisa menulis di /tmp, jadi folder penyimpanan Laravel dialihkan ke sana
$storage = '/tmp/storage';
foreach (['framework/views', 'framework/cache/data', 'framework/sessions', 'logs'] as $dir) {
    if (!is_dir("$storage/$dir")) {
        mkdir("$storage/$dir", 0777, true);
    }
}

putenv("LARAVEL_STORAGE_PATH=$storage");
$_ENV['LARAVEL_STORAGE_PATH'] = $storage;
$_ENV['VIEW_COMPILED_PATH'] = "$storage/framework/views";

// Teruskan semua permintaan ke pintu masuk Laravel yang asli
require __DIR__ . '/../public/index.php';