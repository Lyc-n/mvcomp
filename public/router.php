<?php

// Router untuk PHP built-in server (`php -S`).
// File statis di public/ disajikan langsung; sisanya masuk ke front controller.

$path = rawurldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/');
$real = realpath(__DIR__ . $path);

if (
    $path !== '/'
    && $real !== false
    && str_starts_with($real, __DIR__ . DIRECTORY_SEPARATOR)
    && is_file($real)
) {
    $types = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'text/javascript; charset=UTF-8',
        'mjs' => 'text/javascript; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'webp' => 'image/webp',
        'gif' => 'image/gif',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'txt' => 'text/plain; charset=UTF-8',
        'pdf' => 'application/pdf',
    ];

    $ext = strtolower(pathinfo($real, PATHINFO_EXTENSION));
    $mime = $types[$ext] ?? ((new finfo(FILEINFO_MIME_TYPE))->file($real) ?: 'application/octet-stream');
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($real));
    header('Cache-Control: public, max-age=3600');
    readfile($real);
    return;
}

require __DIR__ . '/index.php';
