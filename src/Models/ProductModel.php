<?php

namespace Mvcomp\Posapp\Models;

use Mvcomp\Posapp\App\Database;

class ProductModel
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();

        // periksa tabel ada atau tidak, jika tidak ada buat tabel
        if (!$this->checkTableExists()) {
            $this->createTableProduct();
        }
    }

    public function createTableProduct(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS products (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            price DECIMAL(10, 2) NOT NULL,
            category ENUM('Makanan', 'Minuman', 'Cemilan') NOT NULL,
            stock INT(11) NOT NULL,
            image VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        $this->db->exec($sql);
    }

    public function checkTableExists(): bool
    {
        $stmt = $this->db->query("SHOW TABLES LIKE 'products'");
        return $stmt->rowCount() > 0;
    }

    public function getAllProducts(): array
    {
        $stmt = $this->db->query("SELECT * FROM products");
        return $stmt->fetchAll();
    }

    public function getProductById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch();
        return $product ?: null;
    }

    public function createProduct(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO products (name, description, price, stock, image) VALUES (:name, :description, :price, :stock, :image)");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':image', $data['image']);
        return $stmt->execute();
    }

    public function updateProduct(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE products SET name = :name, description = :description, price = :price, stock = :stock, image = :image WHERE id = :id");
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->bindParam(':image', $data['image']);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteProduct(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
