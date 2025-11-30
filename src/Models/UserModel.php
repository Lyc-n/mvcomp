<?php
namespace Mvcomp\Posapp\Models;
use Mvcomp\Posapp\App\Database;

class UserModel {
    private \PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getUserById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch();
        return $user ?: null;
    }
}