<?php
define('ROOT_PATH', __DIR__);
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/config/database.php';

$config = require __DIR__ . '/config/database.php';
Database::init($config);

$userModel = new User();
$email = 'admin@adiarifresh.com';
$password = 'admin123';

echo "Attempting to authenticate $email\n";
$user = $userModel->authenticate($email, $password);

if ($user) {
    echo "SUCCESS: Authenticated as " . $user['first_name'] . " (Role: " . $user['role'] . ")\n";
} else {
    echo "FAILURE: Authentication failed.\n";
}

