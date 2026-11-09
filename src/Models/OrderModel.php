<?php

namespace Mvcomp\Posapp\Models;

use Mvcomp\Posapp\App\Database;

class OrderModel
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();

        if (!$this->checkTableExists('orders')) {
            $this->createTableOrders();
        }

        if (!$this->checkTableExists('order_items')) {
            $this->createTableOrderItems();
        }
    }

    public function createTableOrders(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id VARCHAR(64) NOT NULL UNIQUE,
                table_id INT NULL,
                user_id INT NULL,
                status ENUM('open', 'paid', 'cancelled', 'pending') DEFAULT 'open',
                total DECIMAL(10,2) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
        $this->db->exec($sql);
    }

    public function createTableOrderItems(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS order_items (
                id INT AUTO_INCREMENT PRIMARY KEY,
                order_id VARCHAR(64) NOT NULL,
                nameProduct VARCHAR(150) NOT NULL,
                priceProduct DECIMAL(10,2) NOT NULL,
                qty INT NOT NULL DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_order_items_order_id (order_id));";
        $this->db->exec($sql);
    }

    public function checkTableExists(string $table = 'orders'): bool
    {
        $allowed = ['orders', 'order_items'];
        if (!in_array($table, $allowed, true)) {
            throw new \InvalidArgumentException('Nama tabel tidak valid');
        }

        $stmt = $this->db->query("SHOW TABLES LIKE '{$table}'");
        return $stmt->rowCount() > 0;
    }
}
