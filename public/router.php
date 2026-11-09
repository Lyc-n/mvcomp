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
    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($real) ?: 'application/octet-stream';
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($real));
    header('Cache-Control: public, max-age=3600');
    readfile($real);
    return;
}

require __DIR__ . '/index.php';
