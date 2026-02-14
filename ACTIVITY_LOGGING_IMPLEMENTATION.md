# Activity Logging Implementation Summary

## Overview
Implemented a comprehensive dual activity logging system that records user activities both to **file system** (logs/) and **database** (user_activity table) for security auditing, analytics, and debugging purposes.

## Features Implemented

### 1. Enhanced Logger Helper (`app/helpers/Logger.php`)
- **Dual Logging**: Activities are logged to both files and database simultaneously
- **File-based Logging**: 
  - Logs stored in `logs/app.log` and `logs/activity.log`
  - Automatic log rotation at 10MB with timestamp-based backup files
  - Log levels: INFO, ERROR, WARNING, DEBUG, ACTIVITY
- **Database Logging**:
  - Stores activities in `user_activity` table (adiari_analytics database)
  - Captures: user_id, activity_type, page_url, ip_address, user_agent, session_id, metadata (JSON)
- **Toggle Feature**: Can enable/disable database logging via `$useDatabase` flag
- **Graceful Failure**: Database logging failures don't break the application

### 2. Activity Tracking Integration

#### AuthController (`app/controllers/AuthController.php`)
- **User Registration**: Logs when new users register with email and name
- **User Login**: Tracks login events with email and remember_me preference
- **User Logout**: Records logout events with user email

#### ProductController (`app/controllers/ProductController.php`)
- **Product View**: Logs when logged-in users view product details
- Captures: product_id, product_name, category

#### CartController (`app/controllers/CartController.php`)
- **Cart Add**: Tracks when users add items to cart
- Captures: product_id, product_name, quantity, price

#### CheckoutController (`app/controllers/CheckoutController.php`)
- **Order Placed**: Logs successful order completion
- Captures: order_id, total_amount, payment_method, items_count

### 3. Admin Logs Interface (`app/views/admin/logs.php`)

**Dashboard Features:**
- **Real-time Statistics**:
  - Total Activities count
  - Today's Activities count
  - Unique Users count
  - Active Sessions count

- **Advanced Filtering**:
  - Filter by Activity Type (login, logout, registration, product_view, cart_add, order_placed)
  - Filter by User ID
  - Filter by Date
  - Clear filters button

- **Data Presentation**:
  - Responsive table with color-coded activity badges
  - Expandable metadata details
  - Relative timestamps ("Just now", "5m ago", "2h ago")
  - IP address tracking
  - Page URL tracking
  - User agent information

- **Pagination**: 50 logs per page with easy navigation

### 4. Activity Types Tracked

| Activity Type | Triggered When | Metadata Captured |
|---------------|---------------|-------------------|
| `user_registered` | New user signs up | email, name |
| `user_login` | User logs in | email, remember_me |
| `user_logout` | User logs out | email |
| `product_view` | User views product details | product_id, product_name, category |
| `cart_add` | User adds item to cart | product_id, product_name, quantity, price |
| `order_placed` | User completes checkout | order_id, total_amount, payment_method, items_count |

## File Structure

```
app/
├── helpers/
│   └── Logger.php              # Enhanced with dual logging
├── controllers/
│   ├── AuthController.php      # Login/logout/register tracking
│   ├── ProductController.php   # Product view tracking
│   ├── CartController.php      # Cart operation tracking
│   ├── CheckoutController.php  # Order placement tracking
│   └── AdminController.php     # Admin logs view controller
└── views/
    └── admin/
        └── logs.php            # Admin logs interface

logs/
├── app.log                     # General application logs
└── activity.log                # User activity file logs

database/
└── migrations/
    └── 017_create_user_activity_table.sql  # Database schema
```

## Database Schema

**Table:** `user_activity` (in adiari_analytics database)

```sql
CREATE TABLE user_activity (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    activity_type VARCHAR(50),
    page_url VARCHAR(255),
    ip_address VARCHAR(45),
    user_agent VARCHAR(255),
    session_id VARCHAR(255),
    metadata JSON,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user_id (user_id),
    INDEX idx_activity_type (activity_type),
    INDEX idx_created_at (created_at)
);
```

## Usage Examples

### In Controllers (Activity Logging)
```php
// Log user login
Logger::activity($userId, 'user_login', [
    'email' => $email,
    'remember_me' => !empty($remember)
]);

// Log product view
Logger::activity($userId, 'product_view', [
    'product_id' => $productId,
    'product_name' => $productName,
    'category' => $categoryName
]);

// Log cart addition
Logger::activity($userId, 'cart_add', [
    'product_id' => $productId,
    'quantity' => $quantity,
    'price' => $price
]);
```

### General Logging (File-only)
```php
Logger::info("User updated profile", ['user_id' => $userId]);
Logger::warning("Low stock alert", ['product_id' => $productId, 'stock' => 5]);
Logger::error("Payment gateway timeout", ['order_id' => $orderId]);
Logger::debug("Cache miss", ['key' => $cacheKey]);
```

### Retrieving Logs Programmatically
```php
// Get recent activity logs
$logs = Logger::getRecentActivity(100);  // Last 100 logs

// Get logs for specific user
$userLogs = Logger::getRecentActivity(50, $userId);
```

## Testing

Run the test script to verify logging functionality:
```bash
php test_activity_logging.php
```

Expected output:
- ✓ File logs written to logs/ directory
- ✓ Activity logs written to database
- ✓ Statistics displayed (total, unique users, etc.)
- ✓ Recent logs from database shown

## Admin Interface Access

1. Login as admin user
2. Navigate to **Admin → Logs** in the sidebar
3. View real-time activity statistics
4. Apply filters to narrow down logs
5. Expand metadata to see detailed information

## Benefits

1. **Security Auditing**: Track user login/logout events, IP addresses
2. **User Behavior Analytics**: Understand product views, cart operations
3. **Debugging**: Comprehensive error and info logs with context
4. **Compliance**: Maintain audit trail for regulatory requirements
5. **Performance Monitoring**: Track activity patterns and peak times
6. **Business Intelligence**: Analyze user engagement and conversion funnels

## Configuration

### Enable/Disable Database Logging
Edit `app/helpers/Logger.php`:
```php
private static $useDatabase = true;  // Set to false to disable DB logging
```

### Adjust Log Rotation Size
Edit `app/helpers/Logger.php`:
```php
if (file_exists($logFile) && filesize($logFile) > 10485760) {  // 10MB default
    // Change to desired size in bytes
}
```

## Performance Considerations

- Database logging is non-blocking (uses try-catch)
- Failures in logging don't affect application functionality
- Logs are indexed for fast querying
- File rotation prevents disk space issues
- Pagination in admin interface prevents memory overload

## Future Enhancements

Potential additions:
- Email alerts for critical activities
- Export logs to CSV/Excel
- Advanced analytics dashboard
- Real-time activity monitoring
- Geographic tracking with IP geolocation
- Activity heatmaps by time of day
- Automated suspicious activity detection

## Maintenance

### Viewing File Logs
```bash
# View recent activity logs
tail -f logs/activity.log

# View application logs
tail -f logs/app.log

# Search for specific user activity
grep "User #123" logs/activity.log
```

### Database Cleanup
```sql
-- Delete logs older than 90 days
DELETE FROM user_activity WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);

-- Archive old logs to separate table
INSERT INTO user_activity_archive SELECT * FROM user_activity WHERE created_at < DATE_SUB(NOW(), INTERVAL 180 DAY);
```

## Summary

✅ **Dual logging system** (files + database) successfully implemented  
✅ **6 activity types** tracked across 4 controllers  
✅ **Admin interface** with filtering and statistics  
✅ **Tested and verified** with test script  
✅ **Production-ready** with graceful error handling  
✅ **Scalable** with indexing and pagination  

The activity logging system is now fully operational and ready for production use!
