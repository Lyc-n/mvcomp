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
            role ENUM('admin', 'kasir', 'member', 'guest'),
            image VARCHAR(255),
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

    public function getUserByText($txt): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username LIKE ? OR email LIKE ?");
        $like = "%{$txt}%";
        $stmt->execute([$like, $like]);
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $user;
    }

    public function findByUsernameOrEmail(string $identity): ?array
    {
        $stmt = $this->db->prepare(
            "SELECT id, username, email, password, role FROM users WHERE username = :username OR email = :email LIMIT 1"
        );

        $stmt->bindValue(':username', $identity, \PDO::PARAM_STR);
        $stmt->bindValue(':email', $identity, \PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC) ?: null;
    }



    public function getUserByRole($txt): array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role LIKE ?");
        $like = "%{$txt}%";
        $stmt->execute([$like]);
        $user = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $user;
    }

    public function createUser(array $data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
        $hashPassword = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $hashPassword);
        $stmt->bindParam(':role', $data['role']);
        return $stmt->execute();
    }

    public function updateUser(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, password = :password, role = :role WHERE id = :id");
        $stmt->bindParam(':username', $data['username']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password', $data['password']);
        $stmt->bindParam(':role', $data['role']);
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteUser(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }
}
