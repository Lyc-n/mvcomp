<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/App/Config.php';

use Mvcomp\Posapp\App\Route;
use Mvcomp\Posapp\Controllers\ExampleController;

Route::add("GET", "/", ExampleController::class, "index");
Route::add("GET", "/hello", ExampleController::class, "hello");
Route::add("GET", "/world", ExampleController::class, "world");

Route::run();