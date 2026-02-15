<?php
/**
 * Database Configuration
 * Multi-database setup for grocery, inventory, and analytics
 */

return [
    // Main database - Grocery ecommerce data
    'grocery' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'adiari_grocery',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],

    // Inventory database - Stock tracking
    'inventory' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'adiari_inventory',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],

    // Analytics database - Reporting and metrics
    'analytics' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'adiari_analytics',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],
];
