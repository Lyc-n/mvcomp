<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App/helpers.php';
require_once __DIR__ . '/../src/App/Config.php';

use Mvcomp\Posapp\App\Database;

$db = Database::getConnection();

$count = (int) $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
if ($count > 0) {
    fwrite(STDOUT, "Produk sudah ada ({$count}), seed produk dilewati.\n");
    exit(0);
}

$products = [
    ['Nasi Pecel', 'Nasi dengan sayur dan bumbu pecel khas Jawa.', 15000, 'makanan', 'Nasi pecel.jpg'],
    ['Nasi Ayam Bakar Rica', 'Ayam bakar bumbu rica yang pedas dan gurih.', 25000, 'makanan', 'Nasi ayam bakar rica.jpg'],
    ['Nasi Tongseng Daging', 'Tongseng daging sapi dengan kuah rempah.', 28000, 'makanan', 'Nasi tongseng daging.jpg'],
    ['Rawon', 'Sup daging sapi khas Jawa Timur dengan kluwek.', 25000, 'makanan', 'Rawon.jpg'],
    ['Soto Banjar', 'Soto ayam khas Banjar dengan aroma rempah.', 20000, 'makanan', 'Soto Banjar.jpg'],
    ['Pempek', 'Pempek ikan dengan kuah cuko.', 18000, 'makanan', 'pempek.jpg'],
    ['Klepon', 'Kue tradisional berisi gula merah.', 10000, 'kudapan', 'Klepon.jpg'],
    ['Kue Cucur', 'Kue cucur manis dengan aroma pandan.', 8000, 'kudapan', 'Kue Cucur.jpg'],
    ['Kuih Bakar Pandan', 'Kuih bakar pandan yang lembut.', 12000, 'kudapan', 'Kuih Bakar Pandan.jpg'],
    ['Es Dawet', 'Minuman tradisional dawet dengan santan.', 10000, 'minuman', 'Es Dawet.jpg'],
    ['Es Pisang Ijo', 'Es pisang ijo khas Makassar.', 15000, 'minuman', 'Es Pisang Ijo.jpg'],
    ['Es Teh', 'Es teh manis segar.', 5000, 'minuman', 'es teh.jpg'],
];

$stmt = $db->prepare(
    "INSERT INTO products (name, description, price, category, stock, image)
     VALUES (:name, :description, :price, :category, :stock, :image)"
);

foreach ($products as [$name, $description, $price, $category, $image]) {
    $stmt->execute([
        ':name' => $name,
        ':description' => $description,
        ':price' => $price,
        ':category' => $category,
        ':stock' => 50,
        ':image' => $image,
    ]);
}

fwrite(STDOUT, 'Seed produk selesai: ' . count($products) . " produk.\n");
