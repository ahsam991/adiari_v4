<?php
/**
 * Test Activity Logging System
 * This script tests the dual logging functionality (file + database)
 */

require_once __DIR__ . '/app/core/Database.php';
require_once __DIR__ . '/app/helpers/Logger.php';

// Start session for session_id() to work
session_start();

echo "🧪 Testing Activity Logging System\n";
echo "==================================\n\n";

// Test 1: File-based logging
echo "1. Testing file-based logging...\n";
Logger::info("Test info log message");
Logger::warning("Test warning log message");
Logger::error("Test error log message");
Logger::debug("Test debug log message");
echo "   ✓ Check logs/app.log for file logs\n\n";

// Test 2: Activity logging (dual: file + database)
echo "2. Testing activity logging (file + database)...\n";

try {
    // Test with different user IDs
    $testActivities = [
        ['user_id' => 1, 'action' => 'user_login', 'details' => ['email' => 'test@example.com']],
        ['user_id' => 1, 'action' => 'product_view', 'details' => ['product_id' => 5, 'product_name' => 'Test Product']],
        ['user_id' => 1, 'action' => 'cart_add', 'details' => ['product_id' => 5, 'quantity' => 2]],
        ['user_id' => 2, 'action' => 'user_registered', 'details' => ['email' => 'newuser@example.com']],
        ['user_id' => 2, 'action' => 'user_login', 'details' => ['email' => 'newuser@example.com']],
    ];

    foreach ($testActivities as $activity) {
        Logger::activity(
            $activity['user_id'],
            $activity['action'],
            $activity['details']
        );
        echo "   ✓ Logged: {$activity['action']} for User #{$activity['user_id']}\n";
    }

    echo "\n3. Verifying database logs...\n";
    
    // Query the database to verify logs were written
    $db = Database::getConnection('analytics');
    $stmt = $db->query("SELECT COUNT(*) as count FROM user_activity WHERE created_at >= DATE_SUB(NOW(), INTERVAL 1 MINUTE)");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "   ✓ Found {$result['count']} activity logs in database (last 1 minute)\n\n";

    // Show recent logs
    echo "4. Recent activity logs from database:\n";
    $stmt = $db->query("
        SELECT id, user_id, activity_type, page_url, ip_address, created_at 
        FROM user_activity 
        ORDER BY created_at DESC 
        LIMIT 5
    ");
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($logs as $log) {
        echo "   [{$log['created_at']}] User #{$log['user_id']} - {$log['activity_type']}\n";
    }

    echo "\n5. Getting activity statistics...\n";
    $stats = $db->query("
        SELECT 
            COUNT(*) as total,
            COUNT(DISTINCT user_id) as unique_users,
            activity_type,
            COUNT(*) as count
        FROM user_activity
        GROUP BY activity_type
        ORDER BY count DESC
        LIMIT 5
    ")->fetchAll(PDO::FETCH_ASSOC);

    echo "   Activity Type Statistics:\n";
    foreach ($stats as $stat) {
        echo "   - {$stat['activity_type']}: {$stat['count']} times\n";
    }

    echo "\n✅ Activity logging system is working!\n";
    echo "\nNext steps:\n";
    echo "1. Visit /admin/logs in your browser to see the admin interface\n";
    echo "2. User activities will be logged automatically as users interact with the site\n";
    echo "3. File logs are in logs/activity.log and logs/app.log\n";
    echo "4. Database logs are in the 'user_activity' table (adiari_analytics database)\n";

} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n";
