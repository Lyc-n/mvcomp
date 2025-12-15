<?php

namespace Mvcomp\Posapp\App;
use Exception;

class BaseController
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        require_once __DIR__ . '/../views/templates/header.php';

        $basePath = __DIR__ . '/../views/' . $view;

        if (file_exists($basePath . '.php')) {
            require_once $basePath . '.php';
        } elseif (file_exists($basePath . '.html')) {
            require_once $basePath . '.html';
        } else {
            throw new Exception("View '{$view}' tidak ditemukan");
        }

        require_once __DIR__ . '/../views/templates/footer.php';
    }

    function isHtmxRequest(): bool
    {
        return isset($_SERVER['HTTP_HX_REQUEST'])
            && $_SERVER['HTTP_HX_REQUEST'] === 'true';
    }
}
