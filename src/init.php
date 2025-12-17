<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/App/Config.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\AdminController;
use Mvcomp\Posapp\Controllers\AuthContoller;
use Mvcomp\Posapp\Controllers\HomeControlller;
use Mvcomp\Posapp\Controllers\KasirController;
use Mvcomp\Posapp\Controllers\PaymentController;

//Home Route
Route::add("GET", "/", HomeControlller::class, 'index');
//Home CRUD
Route::add("POST", "/", HomeControlller::class, 'CRUD');

//Admin Route
Route::add("GET", "/admin/panel", AdminController::class, "adminPanel", ['auth']);
//Admin Menu
Route::add("POST", "/admin/panel", AdminController::class, "adminPanelMenu");
//Admin CRUD
Route::add("POST", "/admin/add/user", AdminController::class, "adminCRUDUser");
Route::add("POST", "/admin/add/product", AdminController::class, "adminCRUDProduct");

//Authentication
Route::add("GET", "/auth/login", AuthContoller::class, "login");
Route::add("GET", "/auth/register", AuthContoller::class, "register");
Route::add("GET", "/auth/logout", AuthContoller::class, "logout", ['auth']);
Route::add("POST", "/auth/crud", AuthContoller::class, "CRUD");

//Kasir Route
Route::add("GET", "/kasir", KasirController::class, "index");
Route::add("GET", "/kasir/pesanan", KasirController::class, "pesanan");
Route::add("POST", "/kasir", KasirController::class, "CRUD");
Route::add("POST", "/kasir/upStatus", KasirController::class, "updateOrderStatus");

//Payment
Route::add("GET", "/payment", PaymentController::class, "confirmPay", ['auth']);
Route::add("GET", "/payment/success", PaymentController::class, "success", ['auth']);

Route::run();