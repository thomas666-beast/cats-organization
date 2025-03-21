<?php

namespace App\Core;

class Router {
    private array $routes = [];
    private Container $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function add($method, $uri, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function dispatch($method, $uri) {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\w+)', $route['uri']);
            $pattern = "@^$pattern$@";

            if ($route['method'] === $method && preg_match($pattern, $uri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $controller = $this->container->resolve($route['controller']);
                $action = $route['action'];
                return $controller->$action(...array_values($params));
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }
}
