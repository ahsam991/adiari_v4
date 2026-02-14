<?php
/**
 * Database Configuration
 * Multi-database setup for grocery, inventory, and analytics
 */

return [
    // Main database - Grocery ecommerce data
    'grocery' => [
        'host' => 'localhost',
        'port' => 3306,
        'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock',
        'database' => 'adiari_grocery',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],

    // Inventory database - Stock tracking
    'inventory' => [
        'host' => 'localhost',
        'port' => 3306,
        'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock',
        'database' => 'adiari_inventory',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],

    // Analytics database - Reporting and metrics
    'analytics' => [
        'host' => 'localhost',
        'port' => 3306,
        'unix_socket' => '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock',
        'database' => 'adiari_analytics',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],
];
