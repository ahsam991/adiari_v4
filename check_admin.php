<?php
require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/config/database.php';

$config = require __DIR__ . '/config/database.php';
Database::init($config);

$user = Database::fetchOne("SELECT * FROM users WHERE email = ?", ['admin@adiarifresh.com']);
print_r($user);
