<?php

namespace Mvcomp\Posapp\App;

class Database {
    private static ?\PDO $connection = null;

    public static function getConnection(): \PDO {
        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $dbname = $_ENV['DB_NAME'] ?? 'test';
            $username = $_ENV['DB_USER'] ?? 'root';
            $password = $_ENV['DB_PASSWORD'] ?? '';

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                // \PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true,
                // \PDO::MYSQL_ATTR_SSL_CA => $_ENV['DB_SSL_CA'] ?? null,
            ];

            self::$connection = new \PDO($dsn, $username, $password, $options);
        }

        return self::$connection;
    }
}