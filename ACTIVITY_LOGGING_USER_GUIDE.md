# Activity Logging System - User Guide

## 📋 Quick Reference

### What is Activity Logging?
A comprehensive system that records all important user actions (logins, product views, cart additions, orders) in two places:
1. **File system** (`logs/` directory) - for debugging and development
2. **Database** (`user_activity` table) - for analytics and reporting

### Key Features
✅ Automatic user action tracking  
✅ Dual storage (files + database)  
✅ Advanced filtering and search  
✅ Real-time statistics dashboard  
✅ Security audit trail  
✅ JSON metadata for rich data capture  

---

## 🚀 Getting Started

### Accessing the Activity Logs

1. **Login as Admin**
   - Username: admin email
   - Password: admin password
   - Role: Must be "admin"

2. **Navigate to Logs**
   - Click "Admin" menu
   - Select "Logs" from sidebar
   - View activity dashboard

### Understanding the Dashboard

**Statistics Panel (Top)**
- **Total Activities**: Cumulative count of all logged activities
- **Today's Activities**: Activities from the current day (UTC)
- **Unique Users**: Number of distinct users who have been tracked
- **Active Sessions**: Number of current active sessions

**Activity Log Table**
| Column | Description |
|--------|-------------|
| **ID** | Unique log entry identifier |
| **User** | User ID associated with activity (Guest if not logged in) |
| **Activity** | Type of action (colored badge) |
| **Page** | URL path where activity occurred |
| **IP Address** | User's IP address at time of activity |
| **Details** | Expandable JSON metadata |
| **Time** | Relative time display ("Just now", "5m ago", etc.) |

---

## 🎨 Activity Types & Colors

| Activity Type | Color | When It Happens | What's Tracked |
|---------------|-------|---|---|
| **user_login** | 🟢 Green | User logs into account | Email, remember preference |
| **user_logout** | 🔴 Red | User logs out | Email |
| **user_registered** | 🔵 Blue | New user signs up | Email, full name |
| **product_view** | 🟣 Purple | User views product details | Product ID, name, category |
| **cart_add** | 🟡 Yellow | User adds item to shopping cart | Product, quantity, price |
| **order_placed** | 🟠 Orange | User completes order | Order ID, amount, payment method |

---

## 🔍 Filtering & Searching

### Filter by Activity Type
1. Click the "Activity Type" dropdown
2. Select specific action or "All Types"
3. Click "Apply Filters"

**Examples:**
- Track all logins: Select "user_login"
- Monitor registrations: Select "user_registered"
- Analyze product interest: Select "product_view"
- Review purchases: Select "order_placed"

### Filter by User ID
1. Enter user number in "User ID" field
2. Click "Apply Filters"
3. See all activities from that user

**Example:**
- Enter "123" to see all activities from User #123
- Shows complete user activity timeline

### Filter by Date
1. Click the date field
2. Select specific date
3. Click "Apply Filters"

**Example:**
- Select "2026-02-11" to see all activities from that day
- Helpful for investigating specific days or incidents

### Clearing Filters
Click the **"Clear"** button to reset all filters and view all logs.

---

## 📊 Metadata Details

Click **"View Details"** on any log entry to see:
- **For Login**: email address, remember-me preference
- **For Product View**: product ID, product name, category
- **For Cart Add**: product ID, quantity, price
- **For Order**: order ID, total amount, payment method, item count
- **For Registration**: email, first and last name

---

## 💡 Common Use Cases

### 1. Track Specific User Activity
**Goal**: See everything User #42 has done

**Steps:**
1. Enter "42" in User ID field
2. Click "Apply Filters"
3. View complete activity timeline for that user

**What you'll see:**
- All logins and logouts
- Products they viewed
- Items added to cart
- Orders placed

---

### 2. Monitor Login Security
**Goal**: Check for unusual login patterns

**Steps:**
1. Select "user_login" from Activity Type
2. Note patterns in times and IP addresses
3. Look for repeated failed attempts (in app logs)

**What to watch for:**
- Multiple logins from different IP addresses
- Logins at unusual times
- High frequency of logins

---

### 3. Analyze Product Interest
**Goal**: See which products are popular

**Steps:**
1. Select "product_view" from Activity Type
2. Note products with high view counts
3. Check metadata to see categories viewed most

**Insights:**
- Best performing products
- User browsing patterns
- Category preferences

---

### 4. Review Order Activity
**Goal**: Track successful purchases

**Steps:**
1. Select "order_placed" from Activity Type
2. View recent orders chronologically
3. Click "View Details" to see order amounts and methods

**Metrics:**
- Order frequency
- Average order value (in metadata)
- Popular payment methods

---

### 5. Investigate Specific Date
**Goal**: Review activity on a specific day

**Steps:**
1. Select date from calendar
2. Optionally select activity type
3. View all activities from that day

**Use cases:**
- Check activity on promotional days
- Verify server was working
- Investigate performance issues

---

## 📁 File-Based Logs

Logs are also written to files for debugging:

### Location
```
logs/
├── app.log        # General application logs
└── activity.log   # User activity logs
```

### Viewing Logs
**Via Terminal:**
```bash
# View recent activity logs
tail -100 logs/activity.log

# View app logs
tail -100 logs/app.log

# Search for specific user
grep "User #42" logs/activity.log

# Watch logs in real-time
tail -f logs/activity.log
```

### Log Format
```
[2026-02-11 15:38:33] [ACTIVITY] User 1 performed: user_login | Context: {"email":"user@example.com"}
```

---

## 🔒 Security Considerations

### What Gets Logged
✅ User IDs (not emails) in main table  
✅ IP addresses (for security tracking)  
✅ Page URLs (not query parameters with sensitive data)  
✅ Timestamps (for audit trail)  
✅ User agent (for device tracking)  

### What Doesn't Get Logged
❌ Passwords  
❌ Credit card information  
❌ Sensitive query parameters  
❌ Email addresses (only in metadata)  

### Privacy
- Logs older than 90 days can be archived (database)
- File logs rotate at 10MB
- Access restricted to admin users only

---

## 📈 Performance Tips

### For Large Databases
1. **Archive Old Logs**
   ```sql
   DELETE FROM user_activity 
   WHERE created_at < DATE_SUB(NOW(), INTERVAL 90 DAY);
   ```

2. **Export to CSV for Analysis**
   Use admin export feature or database tools

3. **Filter Before Viewing**
   - Always use filters to narrow down results
   - Reduces load on database

### Pagination
- Logs load 50 at a time
- Navigate with page numbers at bottom
- Click page numbers to jump to specific page

---

## 🛠️ Troubleshooting

### No Activity Logs Showing
**Possible causes:**
1. Users haven't interacted with site yet
2. Filters are too restrictive
3. Database connection issue

**Solutions:**
- Click "Clear" to remove filters
- Wait for users to interact with site
- Check database connection in logs/app.log

### Logs Not Updating
**Possible causes:**
1. Database logging disabled
2. File write permissions issue
3. Session timeout

**Solutions:**
- Check Logger.php `$useDatabase` flag
- Verify logs/ directory is writable
- Create new session (logout/login)

### Missing Specific Activity
**Possible causes:**
1. Logging not implemented for that action
2. Activity is in file logs but not database

**Solutions:**
- Check logs/activity.log for file-based logs
- Verify activity type is correctly spelled

---

## 📚 Admin Developer Reference

### Getting Logs Programmatically
```php
// Get recent 100 logs
$logs = Logger::getRecentActivity(100);

// Get logs for specific user
$userLogs = Logger::getRecentActivity(50, $userId);
```

### Logging Activities
```php
// Login activity
Logger::activity($userId, 'user_login', [
    'email' => $email,
    'remember_me' => true
]);

// Custom activity
Logger::activity($userId, 'custom_action', [
    'key' => 'value',
    'nested' => ['data' => true]
]);
```

### General Logging
```php
Logger::info("Information message");
Logger::warning("Warning message");
Logger::error("Error message");
Logger::debug("Debug information");
```

---

## 🔧 Configuration

### Enable/Disable Database Logging
Edit `app/helpers/Logger.php`:
```php
private static $useDatabase = true;  // Set to false to disable
```

### Adjust Log Rotation Size
Edit `app/helpers/Logger.php`:
```php
if (file_exists($logFile) && filesize($logFile) > 10485760) {
    // Change 10485760 (10MB) to desired size in bytes
}
```

### Log Directory
Default: `logs/`  
Permissions needed: Write access (755)

---

## 📞 Support

### Common Questions

**Q: How long are logs kept?**  
A: File logs until 10MB (then rotated), Database logs indefinitely (can be archived)

**Q: Can I export logs?**  
A: Yes, use admin export feature or query database directly

**Q: Is this a security risk?**  
A: No, access is restricted to admin users only

**Q: What if logging fails?**  
A: Application continues normally, failures logged to app.log

**Q: Can I search within logs?**  
A: Use filters in admin interface or grep command-line tools

---

## 🎯 Best Practices

1. **Regular Monitoring**
   - Check logs daily for unusual activity
   - Review new user registrations
   - Monitor login patterns

2. **Performance Optimization**
   - Archive logs older than 90 days quarterly
   - Use filters to narrow queries
   - Monitor log file sizes

3. **Security Audits**
   - Review logins from new IP addresses
   - Check for suspicious activity patterns
   - Verify admin actions are logged

4. **Data Analysis**
   - Export order data to analyze trends
   - Identify popular products
   - Track user engagement metrics

---

## Summary

The Activity Logging System provides:
- 📊 Real-time activity monitoring
- 🔍 Advanced filtering and search
- 📈 Analytics and insights
- 🔒 Security and audit trails
- 🚀 Performance tracking

**Start exploring user activities now by navigating to Admin → Logs!**
