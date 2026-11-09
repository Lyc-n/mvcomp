<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/../../vendor/autoload.php';

$rootPath = dirname(__DIR__, 2);

// safeLoad() tidak fatal jika file .env tidak ada (misalnya di Render).
Dotenv::createImmutable($rootPath)->safeLoad();

$appUrl = env('APP_URL') ?: env('RENDER_EXTERNAL_URL') ?: 'http://localhost:8000';
$appUrl = rtrim((string) $appUrl, '/');

$basePath = rtrim((string) env('APP_BASE_PATH', ''), '/');
if ($basePath !== '' && !str_starts_with($basePath, '/')) {
    $basePath = '/' . $basePath;
}

$baseAssets = env('BASE_ASSETS') ?: $appUrl . '/';
if (!str_ends_with((string) $baseAssets, '/')) {
    $baseAssets .= '/';
}

$_ENV['APP_URL'] = $appUrl;
$_ENV['APP_BASE_PATH'] = $basePath;
$_ENV['BASE_ASSETS'] = $baseAssets;

foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER'] as $required) {
    if (env($required) === null) {
        throw new RuntimeException("Environment variable {$required} belum diset.");
    }
}

date_default_timezone_set((string) env('APP_TIMEZONE', 'Asia/Jakarta'));
