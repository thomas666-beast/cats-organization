<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\CatController;
use App\Models\CatRepository;

class CatControllerTest extends TestCase {
    public function testIndex() {
        $repository = $this->createMock(CatRepository::class);
        $repository->method('all')->willReturn([]);

        $controller = new CatController($repository);
        $this->expectOutputRegex('/All Cats/');
        $controller->index();
    }

    public function testFilter() {
        $repository = $this->createMock(CatRepository::class);
        $repository->method('filterByAgeAndGender')->willReturn([
            ['name' => 'Whiskers', 'gender' => 'male', 'age' => 3]
        ]);

        $controller = new CatController($repository);
        $_GET = ['minAge' => 1, 'maxAge' => 5, 'gender' => 'male'];
        $this->expectOutputRegex('/Whiskers/');
        $controller->filter();
    }
}
