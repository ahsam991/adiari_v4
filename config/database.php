<?php
/**
 * Database Configuration
 * Multi-database setup for grocery, inventory, and analytics
 *
 * Reads from environment variables when available (production),
 * falls back to local development defaults.
 */

// Determine unix_socket: use env var if set, otherwise auto-detect local XAMPP socket
$defaultSocket = '';
$localSocket = '/Applications/XAMPP/xamppfiles/var/mysql/mysql.sock';
if (file_exists($localSocket)) {
    $defaultSocket = $localSocket;
}

return [
    // Main database - Grocery ecommerce data
    'grocery' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'port' => (int)(getenv('DB_PORT') ?: 3306),
        'unix_socket' => getenv('DB_SOCKET') ?: $defaultSocket,
        'database' => getenv('DB_NAME') ?: 'adiari_grocery',
        'username' => getenv('DB_USER') ?: 'root',
        'password' => getenv('DB_PASS') !== false ? getenv('DB_PASS') : '',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],

    // Inventory database - Stock tracking
    'inventory' => [
        'host' => getenv('DB_INVENTORY_HOST') ?: (getenv('DB_HOST') ?: 'localhost'),
        'port' => (int)(getenv('DB_INVENTORY_PORT') ?: (getenv('DB_PORT') ?: 3306)),
        'unix_socket' => getenv('DB_SOCKET') ?: $defaultSocket,
        'database' => getenv('DB_INVENTORY_NAME') ?: 'adiari_inventory',
        'username' => getenv('DB_INVENTORY_USER') ?: (getenv('DB_USER') ?: 'root'),
        'password' => getenv('DB_INVENTORY_PASS') !== false ? getenv('DB_INVENTORY_PASS') : (getenv('DB_PASS') !== false ? getenv('DB_PASS') : ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],

    // Analytics database - Reporting and metrics
    'analytics' => [
        'host' => getenv('DB_ANALYTICS_HOST') ?: (getenv('DB_HOST') ?: 'localhost'),
        'port' => (int)(getenv('DB_ANALYTICS_PORT') ?: (getenv('DB_PORT') ?: 3306)),
        'unix_socket' => getenv('DB_SOCKET') ?: $defaultSocket,
        'database' => getenv('DB_ANALYTICS_NAME') ?: 'adiari_analytics',
        'username' => getenv('DB_ANALYTICS_USER') ?: (getenv('DB_USER') ?: 'root'),
        'password' => getenv('DB_ANALYTICS_PASS') !== false ? getenv('DB_ANALYTICS_PASS') : (getenv('DB_PASS') !== false ? getenv('DB_PASS') : ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'persistent' => false,
    ],
];
