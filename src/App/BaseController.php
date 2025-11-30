<?php
namespace Mvcomp\Posapp\App;

class BaseController{
    protected function render(string $view, array $data = []): void {
        extract($data);
        require_once __DIR__ . '/../views/templates/header.php';
        require_once __DIR__ . '/../views/' . $view . '.php';
        require_once __DIR__ . '/../views/templates/footer.php';
    }
}