<?php
session_start();

require_once __DIR__ . '/../vendor/autoload.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\AdminController;
use Mvcomp\Posapp\Controllers\AuthContoller;
use Mvcomp\Posapp\Controllers\HomeController;
use Mvcomp\Posapp\Controllers\KasirController;
use Mvcomp\Posapp\Controllers\PaymentController;

//Home Route
Route::add("GET", "/", HomeController::class, 'index');
Route::add("POST", "/", HomeController::class, 'CRUD');

//Admin Route
Route::add("GET", "/admin/panel", AdminController::class, "adminPanel", ['auth']);
Route::add("POST", "/admin/panel", AdminController::class, "adminPanelMenu");
Route::add("POST", "/admin/add", AdminController::class, "CRUD");

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