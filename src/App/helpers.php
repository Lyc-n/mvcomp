<?php

declare(strict_types=1);

/**
 * Ambil nilai environment variable.
 *
 * Urutan pencarian: $_ENV, $_SERVER, getenv(). Ini penting karena
 * konfigurasi variables_order PHP bisa berbeda antara lokal dan container.
 */
function env(string $key, mixed $default = null): mixed
{
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    if ($value === false || $value === null) {
        return $default;
    }

    return $value;
}

function env_bool(string $key, bool $default = false): bool
{
    $value = env($key);

    if ($value === null) {
        return $default;
    }

    return filter_var($value, FILTER_VALIDATE_BOOL);
}

/**
 * URL internal aplikasi (link, redirect, action form).
 */
function base_path(string $path = ''): string
{
    $base = rtrim((string) env('APP_BASE_PATH', ''), '/');
    $path = '/' . ltrim($path, '/');

    if ($path === '/') {
        return $base === '' ? '/' : $base . '/';
    }

    return $base . $path;
}

function url(string $path = ''): string
{
    return base_path($path);
}

/**
 * URL asset statis (CSS, JS, gambar) yang selalu berada di public/.
 */
function asset(string $path = ''): string
{
    $base = rtrim((string) env('BASE_ASSETS', ''), '/');

    return $base . '/' . ltrim($path, '/');
}
