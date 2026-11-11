
<?php

class Database {

    public function connect(): PDO {

        $host = getenv("DB_HOST") ?: "localhost";
        $dbname = getenv("DB_NAME") ?: "task_manager";
        $username = getenv("DB_USER") ?: "root";
        $password = getenv("DB_PASSWORD");

        if ($password === false) {
            $password = "";
        }

        $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

        $connection = new PDO(
            $dsn,
            $username,
            $password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );

        return $connection;
    }
}
