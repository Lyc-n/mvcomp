<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require_once __DIR__ . '/app.php';

$capsule = new Capsule;

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false,
    PDO::MYSQL_ATTR_SSL_CA => env('DB_SSL_CA'),
    PDO::ATTR_TIMEOUT => 5,
];

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => env('DB_HOST'),
    'port'      => env('DB_PORT', 3306),
    'database'  => env('DB_NAME'),
    'username'  => env('DB_USER'),
    'password'  => env('DB_PASS'),
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
    'options'   => $options,
]);

// global usage
$capsule->setAsGlobal();
$capsule->bootEloquent();

return $capsule;
