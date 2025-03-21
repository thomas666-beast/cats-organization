<?php

namespace App\Core;

class Translator {
    private static array $translations = [];

    public static function load($locale): void
    {
        $file = __DIR__ . '/../../lang/' . $locale . '.php';

        if (file_exists($file)) {
            self::$translations = require $file;
        } else {
            throw new \Exception("Translation file for locale '$locale' not found.");
        }
    }

    public static function trans($key, $replace = []) {
        $translation = self::$translations[$key] ?? $key;

        foreach ($replace as $placeholder => $value) {
            $translation = str_replace(":$placeholder", $value, $translation);
        }

        return $translation;
    }
}
