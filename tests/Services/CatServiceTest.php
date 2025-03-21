<?php

use PHPUnit\Framework\TestCase;
use App\Services\CatService;
use App\Models\CatRepository;

class CatServiceTest extends TestCase {
    private CatService $service;
    private array $createdIds = [];

    protected function setUp(): void {
        $repository = new CatRepository();
        $this->service = new CatService($repository);
    }

    protected function tearDown(): void {
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
        $this->assertIsInt((int)$id);

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
        $this->createdIds[] = $id;

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
        $updated = $this->service->updateCat($id, ['age' => 5, 'name' => 'Mittens', 'gender' => 'female']);
        $this->assertIsInt($updated);
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
        $this->assertIsInt($deleted);
        $cat = $this->service->getCatById($id);
        $this->assertFalse($cat);
    }
}
