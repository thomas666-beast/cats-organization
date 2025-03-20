<?php

namespace App\Database;

use PDO;

class Connection
{
    private static $instance = null;

    private function __construct() {}

    public static function getInstance(): ?PDO
    {
        if (self::$instance === null) {
            $config = Config::getConfig();
            self::$instance = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['username'],
                $config['password']
            );
        }
        return self::$instance;
    }
}