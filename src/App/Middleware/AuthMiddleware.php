<?php

namespace Mvcomp\Posapp\App\Middleware;

class AuthMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['user'])) {
            // Jika request HTMX
            if (!empty($_SERVER['HTTP_HX_REQUEST'])) {
                header('HX-Redirect: ' . url('/auth/login'));
                exit;
            }

            header('Location: ' . url('/auth/login'));
            exit('Unauthorized');
        }
    }
}
