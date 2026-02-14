<?php

define('DS', DIRECTORY_SEPARATOR);
define('ROOT_PATH', __DIR__);

// Mock $_SERVER
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['SCRIPT_NAME'] = '/index.php';

// Require core files as index.php does
require_once ROOT_PATH . '/app/core/Database.php';
require_once ROOT_PATH . '/app/core/Router.php';
require_once ROOT_PATH . '/app/core/Controller.php';
require_once ROOT_PATH . '/app/core/Model.php';
require_once ROOT_PATH . '/app/core/View.php';
require_once ROOT_PATH . '/app/core/Application.php';

// Helpers
require_once ROOT_PATH . '/app/helpers/Security.php';
require_once ROOT_PATH . '/app/helpers/Session.php';
require_once ROOT_PATH . '/app/helpers/Logger.php';
require_once ROOT_PATH . '/app/helpers/Validation.php';

// Mock Config
$config = [
    'app' => ['debug' => true],
    'database' => [
        'grocery' => ['host' => 'localhost', 'username' => 'root', 'password' => '', 'database' => 'test'],
        'inventory' => ['host' => 'localhost', 'username' => 'root', 'password' => '', 'database' => 'test'],
        'analytics' => ['host' => 'localhost', 'username' => 'root', 'password' => '', 'database' => 'test']
    ]
];

// Determine if we can instantiate Application
try {
    echo "Initializing Application...\n";
    $app = new Application();
    
    // Manually push config since we are not loading from file in this test script properly 
    // (Application::loadConfig loads from file, so we might need to ensure config files exist)
    // Actually Application loads config files.
    
    echo "Running Application...\n";
    $app->run();
    echo "Success!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
