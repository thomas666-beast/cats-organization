<?php

use PHPUnit\Framework\TestCase;
use App\Services\CatService;
use App\Models\CatRepository;
use App\Database\Connection;

class CatServiceTest extends TestCase {
    private $service;
    private $createdIds = []; // Track created IDs for cleanup

    protected function setUp(): void {
        // Initialize the service
        $repository = new CatRepository();
        $this->service = new CatService($repository);
    }

    protected function tearDown(): void {
        // Clean up created rows
        foreach ($this->createdIds as $id) {
            $this->service->deleteCat($id);
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

        $id = $this->service->createCat($data);
        $this->assertIsInt($id);

        // Track the created ID for cleanup
        $this->createdIds[] = $id;
    }

    public function testGetCatById() {
        $data = [
            'name' => 'Fluffy',
            'gender' => 'female',
            'age' => 2,
            'mother_id' => null
        ];

        $id = $this->service->createCat($data);
        $this->createdIds[] = $id; // Track the created ID

        $cat = $this->service->getCatById($id);

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

        $id = $this->service->createCat($data);
        $this->createdIds[] = $id; // Track the created ID

        $updated = $this->service->updateCat($id, ['age' => 5]);

        $this->assertTrue($updated);

        $cat = $this->service->getCatById($id);
        $this->assertEquals(5, $cat['age']);
    }

    public function testDeleteCat() {
        $data = [
            'name' => 'Snowball',
            'gender' => 'male',
            'age' => 1,
            'mother_id' => null
        ];

        $id = $this->service->createCat($data);
        $this->createdIds[] = $id; // Track the created ID

        $deleted = $this->service->deleteCat($id);

        $this->assertTrue($deleted);

        $cat = $this->service->getCatById($id);
        $this->assertFalse($cat);
    }
}
