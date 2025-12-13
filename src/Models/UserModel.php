<?php

namespace Mvcomp\Posapp\Models;

use Mvcomp\Posapp\App\Database;

class UserModel
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();

        // periksa tabel ada atau tidak, jika tidak ada buat tabel
        if (!$this->checkTableExists()) {
            $this->createTableUser();
        }
    }

    public function createTableUser(): void
    {
        $sql = "CREATE TABLE IF NOT EXISTS users (
            id INT(11) AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            email VARCHAR(100) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role ENUM('admin', 'kasir', 'member', 'guest') DEFAULT 'guest',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;";
        $this->db->exec($sql);
    }

    public function deleteTableUser(): void
    {
        $sql = "DROP TABLE users";
        $this->db->exec($sql);
    }

    public function checkTableExists(): bool
    {
        $stmt = $this->db->query("SHOW TABLES LIKE 'users'");
        return $stmt->rowCount() > 0;
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }

    public function getUserById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function createUser(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO user (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', password_hash($data['password'], PASSWORD_BCRYPT));
        return $stmt->execute();
    }

    public function updateUser(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
