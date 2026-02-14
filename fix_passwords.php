<?php
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/config/database.php';

$config = require __DIR__ . '/config/database.php';
Database::init($config);

$admin_pass = password_hash('admin123', PASSWORD_BCRYPT, ['cost' => 12]);
$manager_pass = password_hash('manager123', PASSWORD_BCRYPT, ['cost' => 12]);

Database::query("UPDATE users SET password = ? WHERE email = ?", [$admin_pass, 'admin@adiarifresh.com']);
Database::query("UPDATE users SET password = ? WHERE email = ?", [$manager_pass, 'manager@adiarifresh.com']);

echo "Passwords updated successfully.\n";
echo "Admin hash: $admin_pass\n";
echo "Manager hash: $manager_pass\n";
