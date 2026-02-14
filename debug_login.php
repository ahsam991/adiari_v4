<?php
define('ROOT_PATH', __DIR__);
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/models/User.php';
require_once __DIR__ . '/app/helpers/Security.php';
require_once __DIR__ . '/config/database.php';

$config = require __DIR__ . '/config/database.php';
Database::init($config);

$email = 'admin@adiarifresh.com';
$password = 'admin123';

echo "=== DEBUG LOGIN ===\n\n";

// Get user from database
$userModel = new User();
$user = $userModel->findByEmail($email);

if (!$user) {
    echo "ERROR: User not found with email: $email\n";
    exit;
}

echo "User found:\n";
echo "  ID: " . $user['id'] . "\n";
echo "  Email: " . $user['email'] . "\n";
echo "  Name: " . ($user['first_name'] ?? 'N/A') . " " . ($user['last_name'] ?? 'N/A') . "\n";
echo "  Role: " . $user['role'] . "\n";
echo "  Status: " . ($user['status'] ?? 'N/A') . "\n";
echo "  Password hash: " . substr($user['password'], 0, 30) . "...\n\n";

// Check if lockout_until exists
echo "Lockout fields:\n";
echo "  login_attempts: " . ($user['login_attempts'] ?? 'NOT SET') . "\n";
echo "  lockout_until: " . ($user['lockout_until'] ?? 'NOT SET') . "\n\n";

// Test password verification
echo "Testing password verification:\n";
echo "  Plain password: $password\n";
$verified = Security::verifyPassword($password, $user['password']);
echo "  Verification result: " . ($verified ? "SUCCESS" : "FAILED") . "\n\n";

if (!$verified) {
    echo "Generating new hash for comparison:\n";
    $newHash = Security::hashPassword($password);
    echo "  New hash: " . substr($newHash, 0, 30) . "...\n";
    echo "  Testing new hash: " . (Security::verifyPassword($password, $newHash) ? "SUCCESS" : "FAILED") . "\n";
}
