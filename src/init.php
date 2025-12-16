<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/App/Config.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\AdminController;
use Mvcomp\Posapp\Controllers\AuthContoller;
use Mvcomp\Posapp\Controllers\HomeControlller;
use Mvcomp\Posapp\Controllers\KasirController;

//Home Route
Route::add("GET", "/", HomeControlller::class, 'index');
//Home CRUD
Route::add("POST", "/", HomeControlller::class, 'CRUD');

//Admin Route
Route::add("GET", "/admin/panel", AdminController::class, "adminPanel");
//Admin Menu
Route::add("POST", "/admin/panel", AdminController::class, "adminPanelMenu");
//Admin CRUD
Route::add("POST", "/admin/add/user", AdminController::class, "adminCRUDUser");
Route::add("POST", "/admin/add/product", AdminController::class, "adminCRUDProduct");

//Authentication
Route::add("GET", "/auth/login", AuthContoller::class, "login");
Route::add("GET", "/auth/register", AuthContoller::class, "register");
Route::add("POST", "/auth/crud", AuthContoller::class, "CRUD");

//Kasir Route
Route::add("GET", "/kasir", KasirController::class, "index");

Route::run();