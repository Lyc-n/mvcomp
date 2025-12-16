<?php

namespace Mvcomp\Posapp\Models;

use Mvcomp\Posapp\App\Database;

class TableModel
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();

        // periksa tabel ada atau tidak, jika tidak ada buat tabel
        if (!$this->checkTableExists()) {
            $this->createTables();
        }
    }

    public function createTables()
    {
        $sql = "CREATE TABLE tables (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(50) NOT NULL,
                qr_token VARCHAR(64) NOT NULL UNIQUE,
                status ENUM('available', 'occupied', 'reserved') DEFAULT 'available',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP);";
        $this->db->exec($sql);
    }

    public function checkTableExists(): bool
    {
        $stmt = $this->db->query("SHOW TABLES LIKE 'tables'");
        return $stmt->rowCount() > 0;
    }

    public function getTablesById($id){
        
    }
}
