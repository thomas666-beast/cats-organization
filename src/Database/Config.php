<?php

namespace App\Database;

class Config
{
    public static function getConfig(): array
    {
        $requiredKeys = ['DB_HOST', 'DB_NAME', 'DB_USER'];

        foreach ($requiredKeys as $key) {
            if (!isset($_ENV[$key])) {
                throw new \Exception("Missing required environment variable: $key");
            }
        }

        return [
            'host' => $_ENV['DB_HOST'],
            'dbname' => $_ENV['DB_NAME'],
            'username' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASSWORD']
        ];
    }
}