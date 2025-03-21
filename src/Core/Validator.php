<?php

namespace App\Core;

use App\Models\Model;
class Validator
{
    public static function validateRequired(array $data, array $requiredFields): void
    {
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new \Exception("The $field field is required.");
            }
        }
    }

    public static function validateUnique($table, $field, $value)
    {
        $model = new Model($table);
        $result = $model->all();

        foreach ($result as $record) {
            if ($record[$field] === $value) {
                throw new \Exception("$field must be unique.");
            }
        }
    }

    public static function validateInteger($value, $field): void
    {
        if (!is_numeric($value)) {
            throw new \Exception("The $field field must be an integer.");
        }
    }
}