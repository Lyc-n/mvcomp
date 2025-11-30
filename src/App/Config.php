<?php
require_once __DIR__ . '/../../vendor/autoload.php';

$rootPath = dirname(__DIR__, 2);
$dotenv = Dotenv\Dotenv::createImmutable($rootPath);
$dotenv->load();
