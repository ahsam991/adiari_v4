<?php
/**
 * Database Connection Test Script
 * Test all three database connections
 * DELETE THIS FILE AFTER SUCCESSFUL DEPLOYMENT
 */

// Load configuration
require_once __DIR__ . '/config/database.php';

// Test function
function testDatabaseConnection($config, $dbName) {
    try {
        $dsn = "mysql:host={$config['host']};dbname={$config['database']};charset={$config['charset']}";
        $pdo = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Test query
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$config['database']}'");
        $result = $stmt->fetch();
        
        return [
            'success' => true,
            'tables' => $result['count'],
            'message' => "✅ Connected successfully to {$dbName}"
        ];
    } catch (PDOException $e) {
        return [
            'success' => false,
            'message' => "❌ Failed to connect to {$dbName}: " . $e->getMessage()
        ];
    }
}

$dbConfig = require __DIR__ . '/config/database.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Connection Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c5f2d;
            border-bottom: 3px solid #2c5f2d;
            padding-bottom: 10px;
        }
        .test-result {
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
            border-left: 4px solid #ddd;
        }
        .success {
            background: #d4edda;
            border-left-color: #28a745;
            color: #155724;
        }
        .error {
            background: #f8d7da;
            border-left-color: #dc3545;
            color: #721c24;
        }
        .info {
            background: #d1ecf1;
            border-left-color: #17a2b8;
            color: #0c5460;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #2c5f2d;
            color: white;
        }
        .warning {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Database Connection Test</h1>
        <p>Testing connections to all three databases...</p>
        
        <?php
        // Test Grocery Database
        $groceryTest = testDatabaseConnection($dbConfig['grocery'], 'Grocery Database');
        ?>
        <div class="test-result <?php echo $groceryTest['success'] ? 'success' : 'error'; ?>">
            <strong>Grocery Database (Main):</strong><br>
            <?php echo $groceryTest['message']; ?>
            <?php if ($groceryTest['success']): ?>
                <br>Tables found: <?php echo $groceryTest['tables']; ?>
            <?php endif; ?>
        </div>
        
        <?php
        // Test Inventory Database
        $inventoryTest = testDatabaseConnection($dbConfig['inventory'], 'Inventory Database');
        ?>
        <div class="test-result <?php echo $inventoryTest['success'] ? 'success' : 'error'; ?>">
            <strong>Inventory Database:</strong><br>
            <?php echo $inventoryTest['message']; ?>
            <?php if ($inventoryTest['success']): ?>
                <br>Tables found: <?php echo $inventoryTest['tables']; ?>
            <?php endif; ?>
        </div>
        
        <?php
        // Test Analytics Database
        $analyticsTest = testDatabaseConnection($dbConfig['analytics'], 'Analytics Database');
        ?>
        <div class="test-result <?php echo $analyticsTest['success'] ? 'success' : 'error'; ?>">
            <strong>Analytics Database:</strong><br>
            <?php echo $analyticsTest['message']; ?>
            <?php if ($analyticsTest['success']): ?>
                <br>Tables found: <?php echo $analyticsTest['tables']; ?>
            <?php endif; ?>
        </div>
        
        <?php if ($groceryTest['success'] && $inventoryTest['success'] && $analyticsTest['success']): ?>
            <div class="test-result success">
                <strong>🎉 All databases connected successfully!</strong><br>
                Your deployment is ready to go.
            </div>
        <?php else: ?>
            <div class="test-result error">
                <strong>⚠️ Some databases failed to connect</strong><br>
                Please check your .env file and database credentials.
            </div>
        <?php endif; ?>
        
        <div class="warning">
            <strong>⚠️ SECURITY WARNING:</strong><br>
            Delete this file (test-db-connection.php) immediately after testing!<br>
            This file exposes sensitive database information.
        </div>
        
        <h2>Database Configuration</h2>
        <table>
            <tr>
                <th>Database</th>
                <th>Host</th>
                <th>Database Name</th>
                <th>Status</th>
            </tr>
            <tr>
                <td>Grocery (Main)</td>
                <td><?php echo htmlspecialchars($dbConfig['grocery']['host']); ?></td>
                <td><?php echo htmlspecialchars($dbConfig['grocery']['database']); ?></td>
                <td><?php echo $groceryTest['success'] ? '✅ Connected' : '❌ Failed'; ?></td>
            </tr>
            <tr>
                <td>Inventory</td>
                <td><?php echo htmlspecialchars($dbConfig['inventory']['host']); ?></td>
                <td><?php echo htmlspecialchars($dbConfig['inventory']['database']); ?></td>
                <td><?php echo $inventoryTest['success'] ? '✅ Connected' : '❌ Failed'; ?></td>
            </tr>
            <tr>
                <td>Analytics</td>
                <td><?php echo htmlspecialchars($dbConfig['analytics']['host']); ?></td>
                <td><?php echo htmlspecialchars($dbConfig['analytics']['database']); ?></td>
                <td><?php echo $analyticsTest['success'] ? '✅ Connected' : '❌ Failed'; ?></td>
            </tr>
        </table>
    </div>
</body>
</html>
