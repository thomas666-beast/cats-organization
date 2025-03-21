<?php

namespace App\Controllers;

class LocaleController
{
    public function change($locale)
    {
        $_SESSION['locale'] = $locale;
        header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/'));
        exit;
    }
}
