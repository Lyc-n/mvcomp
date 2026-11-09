<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/App/helpers.php';
require_once __DIR__ . '/App/Config.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\AdminController;
use Mvcomp\Posapp\Controllers\AuthContoller;
use Mvcomp\Posapp\Controllers\HomeControlller;
use Mvcomp\Posapp\Controllers\KasirController;
use Mvcomp\Posapp\Controllers\PaymentController;

if (session_status() !== PHP_SESSION_ACTIVE) {
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https';

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => base_path('/'),
        'domain' => '',
        'secure' => $isHttps,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
}

//Home Route
Route::add("GET", "/", HomeControlller::class, 'index');
//Home CRUD
Route::add("POST", "/", HomeControlller::class, 'CRUD');

//Admin Route
Route::add("GET", "/admin/panel", AdminController::class, "adminPanel", ['auth']);
//Admin Menu
Route::add("POST", "/admin/panel", AdminController::class, "adminPanelMenu", ['auth']);
//Admin CRUD
Route::add("POST", "/admin/add/user", AdminController::class, "adminCRUDUser", ['auth']);
Route::add("POST", "/admin/add/product", AdminController::class, "adminCRUDProduct", ['auth']);

//Authentication
Route::add("GET", "/auth/login", AuthContoller::class, "login");
Route::add("GET", "/auth/register", AuthContoller::class, "register");
Route::add("GET", "/auth/logout", AuthContoller::class, "logout", ['auth']);
Route::add("POST", "/auth/crud", AuthContoller::class, "CRUD");

//Kasir Route
Route::add("GET", "/kasir", KasirController::class, "index", ['auth']);
Route::add("GET", "/kasir/pesanan", KasirController::class, "pesanan", ['auth']);
Route::add("POST", "/kasir", KasirController::class, "CRUD", ['auth']);
Route::add("POST", "/kasir/upStatus", KasirController::class, "updateOrderStatus", ['auth']);

//Payment
Route::add("GET", "/payment", PaymentController::class, "confirmPay", ['auth']);
Route::add("GET", "/payment/success", PaymentController::class, "success", ['auth']);

Route::run();
