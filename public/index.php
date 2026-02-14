<?php
/**
 * Main entry point for the application
 * All requests are routed through this file
 */

// Define application root directory
define('ROOT_PATH', dirname(__DIR__));

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
