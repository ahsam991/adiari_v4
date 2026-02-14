<?php
/**
 * Database Connection Handler
 * Supports multiple database connections for the grocery ecommerce system
 * Databases: adiari_grocery, adiari_inventory, adiari_analytics
 */

class Database {
    private static $connections = [];
    private static $config = null;

    /**
     * Initialize database configuration
     */
    public static function init($config) {
        self::$config = $config;
    }

    /**
     * Get database connection by name
     * @param string $dbName Database name (grocery, inventory, analytics)
     * @return PDO
     */
    public static function getConnection($dbName = 'grocery') {
        // Return existing connection if available
        if (isset(self::$connections[$dbName])) {
            return self::$connections[$dbName];
        }

        // Load configuration
        if (!self::$config) {
            self::$config = require_once __DIR__ . '/../../config/database.php';
        }

        // Validate database exists in config
        if (!isset(self::$config[$dbName])) {
            throw new Exception("Database configuration for '{$dbName}' not found");
        }

        $db = self::$config[$dbName];

        try {
            // Create PDO connection
            // Create DSN with unix socket if available, otherwise use host and port
            if (isset($db['unix_socket']) && !empty($db['unix_socket'])) {
                $dsn = "mysql:unix_socket={$db['unix_socket']};dbname={$db['database']};charset={$db['charset']}";
            } else {
                $port = $db['port'] ?? 3306;
                $dsn = "mysql:host={$db['host']};port={$port};dbname={$db['database']};charset={$db['charset']}";
            }
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTENT => $db['persistent'] ?? false,
                PDO::ATTR_TIMEOUT => 10  // 10 second connection timeout
            ];

            $pdo = new PDO($dsn, $db['username'], $db['password'], $options);
            
            // Store connection for reuse
            self::$connections[$dbName] = $pdo;

            return $pdo;

        } catch (PDOException $e) {
            // Log error
            error_log("Database Connection Error [{$dbName}]: " . $e->getMessage());
            throw new Exception("Could not connect to database: " . $e->getMessage());
        }
    }

    /**
     * Execute a prepared statement
     * @param string $query SQL query
     * @param array $params Parameters for prepared statement
     * @param string $dbName Database name
     * @return PDOStatement
     */
    public static function query($query, $params = [], $dbName = 'grocery') {
        try {
            $pdo = self::getConnection($dbName);
            $stmt = $pdo->prepare($query);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            error_log("Query Error: " . $e->getMessage() . " | Query: " . $query);
            throw new Exception("Database query failed: " . $e->getMessage());
        }
    }

    /**
     * Fetch all results
     */
    public static function fetchAll($query, $params = [], $dbName = 'grocery') {
        $stmt = self::query($query, $params, $dbName);
        return $stmt->fetchAll();
    }

    /**
     * Fetch single row
     */
    public static function fetchOne($query, $params = [], $dbName = 'grocery') {
        $stmt = self::query($query, $params, $dbName);
        return $stmt->fetch();
    }

    /**
     * Get last inserted ID
     */
    public static function lastInsertId($dbName = 'grocery') {
        return self::getConnection($dbName)->lastInsertId();
    }

    /**
     * Begin transaction
     */
    public static function beginTransaction($dbName = 'grocery') {
        return self::getConnection($dbName)->beginTransaction();
    }

    /**
     * Commit transaction
     */
    public static function commit($dbName = 'grocery') {
        return self::getConnection($dbName)->commit();
    }

    /**
     * Rollback transaction
     */
    public static function rollback($dbName = 'grocery') {
        return self::getConnection($dbName)->rollBack();
    }

    /**
     * Close all connections
     */
    public static function closeAll() {
        self::$connections = [];
    }
}
