<?php

namespace App\Models;

use App\Database\Connection;
use PDO;

class Model
{
    protected string $table;
    protected ?PDO $connection;

    public function __construct($table) {
        $this->table = $table;
        $this->connection = Connection::getInstance();
    }

    public function all() {
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

    public function create(array $data) {
        // Get the table columns
        $stmt = $this->connection->prepare("DESCRIBE {$this->table}");
        $stmt->execute();
        $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Filter the data to include only valid columns
        $filteredData = array_intersect_key($data, array_flip($columns));

        // Prepare the SQL query
        $columns = implode(', ', array_keys($filteredData));
        $values = ':' . implode(', :', array_keys($filteredData));
        $stmt = $this->connection->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)");
        $stmt->execute($filteredData);

        return $this->connection->lastInsertId();
    }

    public function update($id, array $data): int
    {
        // Filter out array values (e.g., father_ids)
        $filteredData = array_filter($data, fn($value) => !is_array($value));

        // Prepare the SQL query
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
