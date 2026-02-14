<?php
/**
 * Main entry point for the application
 * All requests are routed through this file
 */

// Define application root directory
define('ROOT_PATH', dirname(__DIR__));

// Load environment variables from .env file if it exists
$envFile = ROOT_PATH . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Parse KEY=value
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            // Remove surrounding quotes (must be at least 2 chars with matching quotes)
            $len = strlen($value);
            if ($len >= 2 &&
                (($value[0] === '"' && $value[$len - 1] === '"') ||
                 ($value[0] === "'" && $value[$len - 1] === "'"))) {
                $value = substr($value, 1, -1);
            }
            // Only set valid environment variable names
            if (!empty($key) && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $key)) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }
    }
}

// Require autoloader (we'll use a simple class autoloader)
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Router.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/core/Model.php';
require_once ROOT_PATH . '/app/core/View.php';
require_once ROOT_PATH . '/app/core/Application.php';

// Require helpers
require_once ROOT_PATH . '/app/helpers/Security.php';
require_once ROOT_PATH . '/app/helpers/Session.php';
require_once ROOT_PATH . '/app/helpers/Logger.php';
require_once ROOT_PATH . '/app/helpers/Validation.php';
require_once ROOT_PATH . '/app/helpers/Language.php';
require_once ROOT_PATH . '/app/helpers/RateLimit.php';

// Set timezone
date_default_timezone_set('Asia/Tokyo');

// Initialize and run application
try {
    $app = new Application();
    // Initialize Language after session start
    Language::init();
    $app->run();
} catch (Exception $e) {
    // Log the error
    error_log("Application Error: " . $e->getMessage());
    
    // Show error (in production, show a generic error page)
    if (defined('DEBUG') && DEBUG) {
        echo "<h1>Application Error</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    } else {
        http_response_code(500);
        echo "An error occurred. Please try again later.";
    }
}
