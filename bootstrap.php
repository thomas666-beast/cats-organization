<?php

// Start the session
session_start();

// Require Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Initialize the database connection
use App\Core\Logger;

// Load environment variables (if using a .env file)
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    throw new \Exception('.env file not found.');
}

// Initialize the database connection
use App\Database\Connection;
Connection::getInstance();


// Generate a CSRF token if it doesn't exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Create the logs directory if it doesn't exist
$logsDir = __DIR__ . '/../logs';
if (!is_dir($logsDir)) {
    mkdir($logsDir, 0755, true);
}

// Initialize the logger
$logger = new Logger();

// Set up error and exception handling
set_error_handler(function ($errno, $errstr, $errfile, $errline) use ($logger) {
    $logger->log("Error: $errstr in $errfile on line $errline");
    throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function ($exception) use ($logger) {
    $logger->log("Exception: " . $exception->getMessage());
    http_response_code(500);
    echo "An error occurred. Please try again later.";
});

function setNotification($type, $message): void
{
    $_SESSION['notifications'][] = ['type' => $type, 'message' => $message];
}

function displayNotifications(): void
{
    if (!empty($_SESSION['notifications'])) {
        foreach ($_SESSION['notifications'] as $notification) {
            echo '<div class="alert alert-' . htmlspecialchars($notification['type']) . ' alert-dismissible fade show" role="alert">'
                . htmlspecialchars($notification['message'])
                . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
                . '</div>';
        }
        // Clear notifications after displaying them
        unset($_SESSION['notifications']);
    }
}
