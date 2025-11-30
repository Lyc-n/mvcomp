<?php

if(!function_exists('asset')){
    function asset($path): string {
        $baseUrl = $_ENV['BASE_URL'] ?? '/';
        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }
}