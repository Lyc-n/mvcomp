<?php
namespace Mvcomp\Posapp\App\Middleware;

class PermissionMiddleware
{
    public static function handle(string $permission)
    {
        if (!isset($_SESSION['user']['permissions']) ||
            !in_array($permission, $_SESSION['user']['permissions'])) {

            http_response_code(403);
            exit('Forbidden');
        }
    }
}