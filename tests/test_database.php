<?php

require_once __DIR__ . '/../src/Database/Database.php';

try {
    $database = new Database();

    $connection = $database->connect();

    echo "Database connection successful!" . PHP_EOL;

} catch (PDOException $e) {

    echo "Database connection failed: " . $e->getMessage() . PHP_EOL;
}