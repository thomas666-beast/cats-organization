<?php

use App\Core\Router;
use App\Controllers\CatController;

return function (Router $router) {
    $router->add('GET', '/', CatController::class, 'index');
    $router->add('GET', '/cats', CatController::class, 'index');
    $router->add('GET', '/cats/create', CatController::class, 'create');
    $router->add('POST', '/cats/create', CatController::class, 'create');
    $router->add('GET', '/cats/edit/{id}', CatController::class, 'edit');
    $router->add('POST', '/cats/edit/{id}', CatController::class, 'edit');
    $router->add('GET', '/cats/delete/{id}', CatController::class, 'delete');
    $router->add('GET', '/cats/show/{id}', CatController::class, 'show');
    $router->add('GET', '/cats/filter', CatController::class, 'filter');
};
