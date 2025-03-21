<?php

namespace App\Core;

class Container {
    private array $bindings = [];

    public function bind($key, $resolver): void
    {
        $this->bindings[$key] = $resolver;
    }

    public function resolve($key) {
        if (isset($this->bindings[$key])) {
            return call_user_func($this->bindings[$key]);
        }
        throw new \Exception("No binding found for {$key}");
    }
}
