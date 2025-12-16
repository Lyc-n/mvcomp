<?php

namespace Mvcomp\Posapp\App\Middleware;

class AuthMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['user'])) {
            // Jika request HTMX
            if (!empty($_SERVER['HTTP_HX_REQUEST'])) {
                header('HX-Redirect: /mvcomp/auth/login');
                exit;
            }

            header('Location: /mvcomp/auth/login');
            exit('Unauthorized');
        }
    }
}
