<?php

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use App\Controllers\CatController;
use App\Services\CatService;
use App\Core\Request;

class CatControllerTest extends TestCase {
    private CatController $controller;
    private MockObject $service;

    protected function setUp(): void {
        $this->service = $this->createMock(CatService::class);
        $this->controller = new CatController($this->service);
    }

    public function testIndex() {
        $this->service->method('getAllCats')->willReturn([
            ['id' => 1, 'name' => 'Whiskers', 'gender' => 'male', 'age' => 3]
        ]);

        ob_start();
        $this->controller->index();
        $output = ob_get_clean();

        $this->assertStringContainsString('Whiskers', $output);
    }

    public function testCreate() {
        $this->service->method('createCat')->willReturn(1);

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST = [
            'name' => 'Whiskers',
            'gender' => 'male',
            'age' => 3,
            'mother_id' => null,
            'csrf_token' => 'valid_token'
        ];

        Request::validateCsrfToken();

        ob_start();
        $this->controller->create();
        $output = ob_get_clean();

        $this->assertStringContainsString('Location: /cats', xdebug_get_headers()[0]);
    }
}
