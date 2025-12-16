<?php
namespace Mvcomp\Posapp\App\Middleware;

class RoleMiddleware
{
    public static function handle(string $role)
    {
        if ($_SESSION['user']['role'] !== $role) {
            http_response_code(403);
            exit('Access denied');
        }
    }
}