<?php

require_once __DIR__ . '/../bootstrap.php';


use App\Database\Connection;

$connection = Connection::getInstance();

echo 'Start migrations ....'.PHP_EOL;

$connection->exec("
    CREATE TABLE IF NOT EXISTS cats (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) UNIQUE NOT NULL,
        gender ENUM('male', 'female') NOT NULL,
        age INT NOT NULL,
        mother_id INT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

$connection->exec("
    CREATE TABLE IF NOT EXISTS cat_fathers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        cat_id INT NOT NULL,
        father_id INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (cat_id) REFERENCES cats(id),
        FOREIGN KEY (father_id) REFERENCES cats(id)
    )
");

echo 'Migrations has been completed.' . PHP_EOL;