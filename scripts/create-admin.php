<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/App/helpers.php';
require_once __DIR__ . '/../src/App/Config.php';

use Mvcomp\Posapp\App\Database;

$username = trim((string) env('ADMIN_USERNAME', ''));
$email = trim((string) env('ADMIN_EMAIL', ''));
$password = (string) env('ADMIN_PASSWORD', '');

if ($username === '' || $email === '' || $password === '') {
    fwrite(STDOUT, "ADMIN_USERNAME/ADMIN_EMAIL/ADMIN_PASSWORD tidak diset, seed admin dilewati.\n");
    exit(0);
}

$db = Database::getConnection();

$existing = $db->query("SELECT id FROM users WHERE role = 'admin' LIMIT 1")->fetch();
if ($existing) {
    fwrite(STDOUT, "Admin sudah ada, seed admin dilewati.\n");
    exit(0);
}

$stmt = $db->prepare(
    "INSERT INTO users (username, email, password, role)
     VALUES (:username, :email, :password, 'admin')"
);
$stmt->execute([
    ':username' => $username,
    ':email' => $email,
    ':password' => password_hash($password, PASSWORD_BCRYPT),
]);

fwrite(STDOUT, "Admin awal dibuat: {$username}\n");
