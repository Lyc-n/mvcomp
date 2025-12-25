<?php

require_once __DIR__ . '/bootstrap/database.php';

$seeders = [
    __DIR__ . '/database/seeders/ProductSeeder.php',
    __DIR__ . '/database/seeders/TablesSeeder.php',
];

foreach ($seeders as $seederFile) {
    echo "Seeding: " . basename($seederFile) . "\n";
    $seeder = require $seederFile;
    $seeder();
}

echo "All seeders completed.\n";
