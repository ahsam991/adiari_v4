# Database Setup Guide - ADI ARI Grocery Ecommerce

## Step-by-Step Database Installation

---

## Prerequisites

- MySQL 5.7+ or MariaDB 10.3+
- phpMyAdmin (recommended) or MySQL command line
- Database user with CREATE DATABASE privileges

---

## Step 1: Create the Three Databases

### Option A: Using phpMyAdmin

1. Open phpMyAdmin in your browser
2. Click "New" in the left sidebar
3. Create the following databases:
   - **Database name**: `adiari_grocery`
   - **Collation**: `utf8mb4_unicode_ci`
   
4. Repeat for:
   - `adiari_inventory`
   - `adiari_analytics`

### Option B: Using MySQL Command Line

```sql
CREATE DATABASE adiari_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE adiari_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE adiari_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## Step 2: Run Migration Files (In Order!)

Navigate to: `database/migrations/`

###  adiari_grocery Database (12 tables)

Run these files in phpMyAdmin for `adiari_grocery` database:

```
001_create_users_table.sql              ✅ Users & authentication
002_create_categories_table.sql         ✅ Product categories
003_create_products_table.sql           ✅ Products
004_create_product_images_table.sql     ✅ Product images
005_create_cart_table.sql               ✅ Shopping cart
006_create_orders_table.sql             ✅ Orders
007_create_order_items_table.sql        ✅ Order line items
008_create_user_addresses_table.sql     ✅ User addresses
009_create_reviews_table.sql            ✅ Product reviews
010_create_wishlist_table.sql           ✅ Wishlist
011_create_coupons_table.sql            ✅ Discount coupons
012_create_coupon_usage_table.sql       ✅ Coupon tracking
```

### adiari_inventory Database (3 tables)

Run these files in phpMyAdmin for `adiari_inventory` database:

```
013_create_product_stock_table.sql      ✅ Stock levels
014_create_stock_logs_table.sql         ✅ Stock movements
015_create_warehouse_table.sql          ✅ Warehouse locations
```

### adiari_analytics Database (3 tables)

Run these files in phpMyAdmin for `adiari_analytics` database:

```
016_create_sales_analytics_table.sql    ✅ Sales metrics
017_create_user_activity_table.sql      ✅ User tracking
018_create_product_performance_table.sql ✅ Product analytics
```

---

## Step 3: Run Seeders (Test Data)

Navigate to: `database/seeds/`

Run in phpMyAdmin:

```
001_sample_products.sql                  ✅ Sample products & stock
```

This will create:
- **2 default users**:
  - Admin: `admin@adiarifresh.com` / password: `admin123`
  - Manager: `manager@adiarifresh.com` / password: `manager123`
  
- **8 categories**:
  - Vegetables, Fruits, Halal Meat, Dairy & Eggs, Pantry, Snacks, Beverages, Frozen Foods

- **19 sample products**:
  - 5 vegetables
  - 4 fruits
  - 3 halal meat products
  - 4 dairy products
  - 3 pantry items

- **1 warehouse**: ADI ARI Main Warehouse

- **Stock records** for all products

---

## Step 4: Update Configuration

### Edit `config/database.php` or `.env` file:

```php
'grocery' => [
    'host' => 'localhost',
    'database' => 'adiari_grocery',
    'username' => 'YOUR_DB_USERNAME',  // Change this
    'password' => 'YOUR_DB_PASSWORD',  // Change this
],

'inventory' => [
    'host' => 'localhost',
    'database' => 'adiari_inventory',
    'username' => 'YOUR_DB_USERNAME',  // Change this
    'password' => 'YOUR_DB_PASSWORD',  // Change this
],

'analytics' => [
    'host' => 'localhost',
    'database' => 'adiari_analytics',
    'username' => 'YOUR_DB_USERNAME',  // Change this
    'password' => 'YOUR_DB_PASSWORD',  // Change this
],
```

---

## Step 5: Verify Installation

### Check Tables Were Created:

**adiari_grocery (12 tables)**:
- users
- categories
- products
- product_images
- cart
- orders
- order_items
- user_addresses
- reviews
- wishlist
- coupons
- coupon_usage

**adiari_inventory (3 tables)**:
- product_stock
- stock_logs
- warehouse

**adiari_analytics (3 tables)**:
- sales_analytics
- user_activity
- product_performance

**Total: 18 tables**

---

## Step 6: Test Database Connection

Create a test file `test_db.php` in the root directory:

```php
<?php
require_once 'app/core/Database.php';

// Load config
$config = require 'config/database.php';
Database::init($config);

try {
    // Test grocery database
    $conn = Database::getConnection('grocery');
    echo "✅ Connected to adiari_grocery<br>";
    
    // Test query
    $users = Database::fetchAll("SELECT * FROM users", [], 'grocery');
    echo "✅ Found " . count($users) . " users<br>";
    
    $categories = Database::fetchAll("SELECT * FROM categories", [], 'grocery');
    echo "✅ Found " . count($categories) . " categories<br>";
    
    $products = Database::fetchAll("SELECT * FROM products", [], 'grocery');
    echo "✅ Found " . count($products) . " products<br>";
    
   // Test inventory database
    $conn2 = Database::getConnection('inventory');
    echo "✅ Connected to adiari_inventory<br>";
    
    // Test analytics database
    $conn3 = Database::getConnection('analytics');
    echo "✅ Connected to adiari_analytics<br>";
    
    echo "<br>🎉 All databases connected successfully!";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
```

Run this file in your browser:
```
http://localhost:8000/test_db.php
```

You should see:
```
✅ Connected to adiari_grocery
✅ Found 2 users
✅ Found 8 categories  
✅ Found 19 products
✅ Connected to adiari_inventory
✅ Connected to adiari_analytics
🎉 All databases connected successfully!
```

**If you see this, your database setup is complete!**

---

## Database Schema Overview

### Database 1: adiari_grocery (Main Ecommerce)

```
users
├── Authentication & Profile
├── Roles (customer, manager, admin)
└── Email verification

categories
├── Product organization
└── Hierarchical (parent/child)

products
├── Product details
├── Pricing (price, sale_price)
├── Stock quantity
├── Halal certification
└── SEO fields

cart → Shopping cart items
orders → Order management
order_items → Order line items
reviews → Product reviews
wishlist → Saved products
coupons → Discount codes
```

### Database 2: adiari_inventory (Stock Management)

```
warehouse → Storage locations
product_stock → Current stock levels
stock_logs → Inventory movements
```

### Database 3: adiari_analytics (Reporting)

```
sales_analytics → Daily sales metrics
user_activity → User behavior tracking
product_performance → Product metrics
```

---

## Common Issues & Solutions

### Issue 1: "Access denied for user"
**Solution**: Check database username and password in `config/database.php`

### Issue 2: "Table already exists"
**Solution**: Drop the databases and start fresh:
```sql
DROP DATABASE adiari_grocery;
DROP DATABASE adiari_inventory;
DROP DATABASE adiari_analytics;
```
Then repeat steps 1-3.

### Issue 3: Foreign key constraint fails
**Solution**: Run migrations in the exact order specified. Dependencies must be created first.

### Issue 4: "Unknown collation: utf8mb4_unicode_ci"
**Solution**: Your MySQL version is outdated. Use `utf8_general_ci` instead or upgrade MySQL.

---

## Next Steps

After database setup is complete:

1. ✅ Test the homepage: `http://localhost:8000`
2. ✅ Login as admin: `admin@adiarifresh.com` / `admin123`
3. ✅ Start Phase 3: Authentication System

---

## Security Reminder

🔒 **IMPORTANT**: Change default admin and manager passwords immediately in production!

```sql
USE adiari_grocery;
UPDATE users SET password = '$2y$12$YOUR_NEW_HASHED_PASSWORD' WHERE email = 'admin@adiarifresh.com';
```

Generate new hash in PHP:
```php
echo password_hash('your_new_password', PASSWORD_BCRYPT, ['cost' => 12]);
```

---

**Database setup complete!** 🎉  
**Phase 2 Status**: ✅ COMPLETE

_Last Updated: 2026-02-09_
