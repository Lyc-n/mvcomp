<?php

namespace Mvcomp\Posapp\App;

use Mvcomp\Posapp\App\Middleware;

class Route
{

    private static array $routes = [];

    public static function add(string $method, string $path, string $controller, string $function, array $middlewares = []): void
    {
        self::$routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'function' => $function,
            'middlewares' => $middlewares
        ];
    }

    public static function run()
    {
        $path = "/";
        $method = "GET";
        if (self::getUri() != "") {
            $path = '/' . self::getUri();
        }
        if (isset($_SERVER['REQUEST_METHOD'])) {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        foreach (self::$routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                foreach ($route['middlewares'] as $middleware) {
                    Middleware::handle($middleware);
                }
                $controller = new $route['controller']();
                $function = $route['function'];
                $params = $_GET;
                return $controller->$function($params);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
        var_dump($path);
    }

    public static function getUri()
    {
        $uri = explode('/', rtrim(strtok($_SERVER['REQUEST_URI'], '?'), '/'));
        foreach ($uri as $key => $value) {
            if ($value === "" || $value === "mvcomp" || $value === "public") {
                unset($uri[$key]);
            }
        }
        $uri = implode('/', $uri);
        return $uri;
    }
}
