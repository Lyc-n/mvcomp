<?php

namespace Mvcomp\Posapp\App;

class Database
{
    private static ?\PDO $connection = null;

    public static function getConnection(): \PDO
    {
        if (self::$connection === null) {
            $host = (string) env('DB_HOST');
            $port = (string) env('DB_PORT', '3306');
            $dbname = (string) env('DB_NAME');
            $username = (string) env('DB_USER');
            $password = (string) env('DB_PASSWORD', '');

            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            if (env_bool('DB_SSL')) {
                $caPath = (string) env('DB_SSL_CA', '/var/www/config/ca.pem');

                if (!is_file($caPath)) {
                    throw new \RuntimeException("CA certificate database tidak ditemukan: {$caPath}");
                }

                $options[\PDO::MYSQL_ATTR_SSL_CA] = $caPath;
                $options[\PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = env_bool('DB_SSL_VERIFY', true);
            }

            self::$connection = new \PDO($dsn, $username, $password, $options);
        }

        return self::$connection;
    }
}
