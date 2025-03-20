<?php

use PHPUnit\Framework\TestCase;
use App\Database\Connection;
use App\Models\Model;

class DatabaseTest extends TestCase {
    private $model;
    private $createdIds = []; // Track created IDs for cleanup

    protected function setUp(): void {
        // Initialize the database connection
        $this->model = new Model('cats');
    }

    protected function tearDown(): void {
        // Clean up created rows
        foreach ($this->createdIds as $id) {
            $this->model->delete($id);
        }
        $this->createdIds = []; // Reset the list
    }

    public function testCreateCat() {
        $data = [
            'name' => 'Whiskers',
            'gender' => 'male',
            'age' => 3,
            'mother_id' => null
        ];

        $id = $this->model->create($data);
        $this->assertIsInt($id);

        // Track the created ID for cleanup
        $this->createdIds[] = $id;
    }

    public function testFindCat() {
        $data = [
            'name' => 'Fluffy',
            'gender' => 'female',
            'age' => 2,
            'mother_id' => null
        ];

        $id = $this->model->create($data);
        $this->createdIds[] = $id; // Track the created ID

        $cat = $this->model->find($id);

        $this->assertEquals('Fluffy', $cat['name']);
        $this->assertEquals('female', $cat['gender']);
    }

    public function testUpdateCat() {
        $data = [
            'name' => 'Mittens',
            'gender' => 'female',
            'age' => 4,
            'mother_id' => null
        ];

        $id = $this->model->create($data);
        $this->createdIds[] = $id; // Track the created ID

        $updated = $this->model->update($id, ['age' => 5]);

        $this->assertEquals(1, $updated);

        $cat = $this->model->find($id);
        $this->assertEquals(5, $cat['age']);
    }

    public function testDeleteCat() {
        $data = [
            'name' => 'Snowball',
            'gender' => 'male',
            'age' => 1,
            'mother_id' => null
        ];

        $id = $this->model->create($data);
        $this->createdIds[] = $id; // Track the created ID

        $deleted = $this->model->delete($id);

        $this->assertEquals(1, $deleted);

        $cat = $this->model->find($id);
        $this->assertFalse($cat);
    }
}
