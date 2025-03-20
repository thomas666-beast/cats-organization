<?php

namespace App\Core;

class Logger {
    private $logFile;

    public function __construct($logFile = 'app.log') {
        // Define the logs directory path
        $logsDir = __DIR__ . '/../../logs';

        // Create the logs directory if it doesn't exist
        if (!is_dir($logsDir)) {
            mkdir($logsDir, 0755, true);
        }

        // Set the full path to the log file
        $this->logFile = $logsDir . '/' . $logFile;
    }

    public function log($message) {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message" . PHP_EOL;
        file_put_contents($this->logFile, $logMessage, FILE_APPEND);
    }
}
