<?php

require __DIR__ . '/../bootstrap.php';

use App\Core\Container;
use App\Core\Router;
use App\Controllers\CatController;
use App\Models\CatRepository;
use App\Services\CatService;

// Set up the dependency injection container
$container = new Container();

// Bind the CatRepository to the container
$container->bind(CatRepository::class, function () {
    return new CatRepository();
});

// Bind the CatService to the container
$container->bind(CatService::class, function () use ($container) {
    return new CatService($container->resolve(CatRepository::class));
});

// Bind the CatController to the container
$container->bind(CatController::class, function () use ($container) {
    return new CatController($container->resolve(CatService::class));
});

// Initialize the router
$router = new Router($container);

// Load routes
$routes = require __DIR__ . '/../routes/web.php';
$routes($router);

// Dispatch the request
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($method, $uri);
