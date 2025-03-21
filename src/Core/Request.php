<?php

namespace App\Core;


class Request {

    public static function getPostData(): array {
        unset($_POST['csrf_token']);

        $sanitize = function ($value) use (&$sanitize) {
            if (is_array($value)) {
                return array_map($sanitize, $value);
            }
            return htmlspecialchars($value);
        };

        return array_map($sanitize, $_POST);
    }

    public static function generateCsrfToken()
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function validateCsrfToken(): void
    {
        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            throw new \Exception('CSRF token validation failed.');
        }
    }
}
