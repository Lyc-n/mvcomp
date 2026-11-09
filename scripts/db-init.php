<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App/helpers.php';
require_once __DIR__ . '/../src/App/Config.php';

use Mvcomp\Posapp\App\Database;

$attempts = (int) env('DB_CONNECT_ATTEMPTS', '15');
$db = null;

for ($i = 1; $i <= $attempts; $i++) {
    try {
        $db = Database::getConnection();
        break;
    } catch (Throwable $e) {
        if ($i === $attempts) {
            fwrite(STDERR, "Gagal konek database setelah {$attempts} percobaan: {$e->getMessage()}\n");
            exit(1);
        }

        fwrite(STDERR, "Database belum siap ({$i}/{$attempts}), retry 2 detik...\n");
        sleep(2);
    }
}

$statements = [
    "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'kasir', 'member', 'guest') NOT NULL DEFAULT 'guest',
        image VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_users_username (username),
        UNIQUE KEY uq_users_email (email)
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        description TEXT NULL,
        price DECIMAL(10,2) NOT NULL,
        category ENUM('makanan', 'minuman', 'kudapan') NOT NULL,
        stock INT NULL DEFAULT 0,
        image VARCHAR(255) NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS `tables` (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        qr_token VARCHAR(64) NOT NULL,
        status ENUM('available', 'occupied', 'reserved') NOT NULL DEFAULT 'available',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_tables_qr_token (qr_token)
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id VARCHAR(64) NOT NULL,
        table_id INT NULL,
        user_id INT NULL,
        status ENUM('open', 'paid', 'cancelled', 'pending') NOT NULL DEFAULT 'open',
        total DECIMAL(10,2) NOT NULL DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY uq_orders_order_id (order_id)
    ) ENGINE=InnoDB",

    "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id VARCHAR(64) NOT NULL,
        nameProduct VARCHAR(150) NOT NULL,
        priceProduct DECIMAL(10,2) NOT NULL,
        qty INT NOT NULL DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        KEY idx_order_items_order_id (order_id)
    ) ENGINE=InnoDB",
];

foreach ($statements as $sql) {
    $db->exec($sql);
}

/*
 * Migrasi ringan untuk database lama yang sudah punya tabel orders
 * tetapi belum punya order_id / status pending / order_items.
 */
$orderIdColumn = $db->query("SHOW COLUMNS FROM orders LIKE 'order_id'")->fetchAll();
if (!$orderIdColumn) {
    $db->exec("ALTER TABLE orders ADD COLUMN order_id VARCHAR(64) NULL AFTER id");
}

$orderIdIndex = $db->query("SHOW INDEX FROM orders WHERE Key_name = 'uq_orders_order_id'")->fetchAll();
if (!$orderIdIndex) {
    // Unique index hanya bisa dibuat jika data lama tidak bentrok.
    try {
        $db->exec("ALTER TABLE orders ADD UNIQUE KEY uq_orders_order_id (order_id)");
    } catch (Throwable $e) {
        fwrite(STDERR, "Peringatan: gagal membuat unique index order_id: {$e->getMessage()}\n");
    }
}

$db->exec("ALTER TABLE orders MODIFY status ENUM('open', 'paid', 'cancelled', 'pending') NOT NULL DEFAULT 'open'");

fwrite(STDOUT, "Database schema siap.\n");
