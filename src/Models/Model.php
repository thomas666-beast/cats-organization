<?php

namespace App\Models;

use App\Database\Connection;
use PDO;

class Model
{
    protected string $table;
    protected ?PDO $connection = null;

    public function __construct($table) {
        $this->table = $table;
        $this->connection = Connection::getInstance();
    }

    public function all(): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM {$this->table}");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception("Database error: " . $e->getMessage());
        }
    }

    public function find($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create(array $data): false|string
    {
        $stmt = $this->connection->prepare("DESCRIBE {$this->table}");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $filteredData = array_intersect_key($data, array_flip($columns));

        $columns = implode(', ', array_keys($filteredData));
        $values = ':' . implode(', :', array_keys($filteredData));
        $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)");
        $stmt->execute($filteredData);

        return $this->connection->lastInsertId();
    }

    public function update($id, array $data): int
    {
        $filteredData = array_filter($data, fn($value) => !is_array($value));
        $set = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($filteredData)));
        $stmt = $this->connection->prepare("UPDATE {$this->table} SET $set WHERE id = :id");
        $stmt->execute(array_merge($filteredData, ['id' => $id]));

        return $stmt->rowCount();
    }

    public function delete($id): int
    {
        $stmt = $this->connection->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->rowCount();
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
