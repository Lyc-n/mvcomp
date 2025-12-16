<?php
namespace Mvcomp\Posapp\App\Middleware;

class AuthMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            exit('Unauthorized');
        }
    }
}