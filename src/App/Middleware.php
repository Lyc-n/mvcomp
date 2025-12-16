<?php

namespace Mvcomp\Posapp\App;

use Mvcomp\Posapp\App\Middleware\AuthMiddleware;
use Mvcomp\Posapp\App\Middleware\PermissionMiddleware;
use Mvcomp\Posapp\App\Middleware\RoleMiddleware;

class Middleware
{
    public static function handle(string $middleware)
    {
        if (str_contains($middleware, ':')) {
            [$name, $param] = explode(':', $middleware, 2);
        } else {
            $name = $middleware;
            $param = null;
        }

        switch ($name) {
            case 'auth':
                AuthMiddleware::handle();
                break;

            case 'permission':
                PermissionMiddleware::handle($param);
                break;

            default:
                throw new \Exception("Middleware {$name} tidak dikenali");
        }
    }
}
