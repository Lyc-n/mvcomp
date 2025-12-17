<?php

namespace Mvcomp\Posapp\Models;

use Mvcomp\Posapp\App\Database;

class OrderModel
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();

        // periksa tabel ada atau tidak, jika tidak ada buat tabel
        if (!$this->checkTableExists()) {
            $this->createTableOrders();
        }
    }

    public function createTableOrders()
    {
        $sql = "CREATE TABLE orders (
                id INT AUTO_INCREMENT PRIMARY KEY,
                table_id INT NOT NULL,
                user_id INT NULL,
                status ENUM('open', 'paid', 'cancelled') DEFAULT 'open',
                total DECIMAL(10,2) DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
        $this->db->exec($sql);
    }

    public function checkTableExists(): bool
    {
        $stmt = $this->db->query("SHOW TABLES LIKE 'orders'");
        return $stmt->rowCount() > 0;
    }
}
