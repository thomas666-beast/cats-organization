<?php

require __DIR__ . '/../bootstrap.php';

use App\Controllers\LocaleController;
use App\Core\Container;
use App\Core\Router;
use App\Controllers\CatController;
use App\Models\CatRepository;
use App\Services\CatService;

$container = new Container();
$container->bind(CatRepository::class, function () {
    return new CatRepository();
});
$container->bind(CatService::class, function () use ($container) {
    return new CatService($container->resolve(CatRepository::class));
});
$container->bind(CatController::class, function () use ($container) {
    return new CatController($container->resolve(CatService::class));
});
$container->bind(LocaleController::class, function () {
    return new LocaleController();
});

$router = new Router($container);
$routes = require __DIR__ . '/../routes/web.php';
$routes($router);

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$router->dispatch($method, $uri);
