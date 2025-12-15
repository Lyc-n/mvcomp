<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/App/Config.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\AdminController;
use Mvcomp\Posapp\Controllers\HomeControlller;
use Mvcomp\Posapp\Controllers\KasirController;

//Home Route
Route::add("GET", "/", HomeControlller::class, 'index');

//Admin Route
Route::add("GET", "/admin/panel", AdminController::class, "adminPanel");
//Admin Menu
Route::add("POST", "/admin/panel", AdminController::class, "adminPanelMenu");
//Admin CRUD
Route::add("POST", "/admin/add/user", AdminController::class, "adminCRUDUser");
Route::add("POST", "/admin/add/product", AdminController::class, "adminCRUDProduct");
//Admin Authentication
Route::add("GET", "/admin/login", AdminController::class, "adminLogin");
Route::add("POST", "/admin/login", AdminController::class, "adminAuthenticate");
Route::add("GET", "/admin/Register", AdminController::class, "adminRegister");
Route::add("POST", "/admin/Register", AdminController::class, "adminStoreRegister");

//Kasir Route
Route::add("GET", "/kasir", KasirController::class, "index");

Route::run();