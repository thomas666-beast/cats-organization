<?php

use PHPUnit\Framework\TestCase;
use App\Database\Connection;
use App\Models\Model;

class DatabaseTest extends TestCase {
    public function testDatabaseConnection() {
        $connection = Connection::getInstance();
        $this->assertInstanceOf(\PDO::class, $connection);
    }

    public function testModelAll() {
        $model = new Model('cats');
        $cats = $model->all();
        $this->assertIsArray($cats);
    }
}
