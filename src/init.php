<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/App/Config.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\AdminController;
use Mvcomp\Posapp\Controllers\HomeControlller;

//Home Route
Route::add("GET", "/", HomeControlller::class, 'index');

//Admin Route
Route::add("GET", "/admin/panel", AdminController::class, "adminPanel");
Route::add("POST", "/admin/panel/dashboard", AdminController::class, "adminDashboard");
Route::add("POST", "/admin/panel/users", AdminController::class, "adminUsers");
Route::add("POST", "/admin/panel/products", AdminController::class, "adminProducts");
Route::add("POST", "/admin/panel/reports", AdminController::class, "adminReports");
Route::add("GET", "/admin/login", AdminController::class, "adminLogin");
Route::add("POST", "/admin/login", AdminController::class, "adminAuthenticate");
Route::add("GET", "/admin/Register", AdminController::class, "adminRegister");
Route::add("POST", "/admin/Register", AdminController::class, "adminStoreRegister");

Route::run();