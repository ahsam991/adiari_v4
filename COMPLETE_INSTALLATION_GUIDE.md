# ADI ARI GROCERY ECOMMERCE - COMPLETE INSTALLATION GUIDE
## All Issues Fixed & Requirements Complete

---

## 🎉 PROJECT STATUS: PRODUCTION READY

✅ **All features implemented**  
✅ **All database migrations created**  
✅ **All security measures in place**  
✅ **Sample data included**  
✅ **Complete documentation**  
✅ **Ready for deployment**

---

## 📋 WHAT'S BEEN COMPLETED

### 1. ✅ Full MVC Architecture
- Custom PHP MVC framework
- Clean separation of concerns
- Modular and maintainable code

### 2. ✅ Complete Database Schema (18 Tables)
**Grocery Database (12 tables):**
- users, categories, products, product_images
- cart, orders, order_items
- user_addresses, reviews, wishlist
- coupons, coupon_usage

**Inventory Database (3 tables):**
- warehouse, product_stock, stock_logs

**Analytics Database (3 tables):**
- sales_analytics, user_activity, product_performance

### 3. ✅ User Roles & Authentication
- **Customer**: Browse, cart, checkout, orders
- **Manager**: Products, inventory, orders management
- **Admin**: Full system control, users, analytics

### 4. ✅ E-commerce Features
- Product catalog with categories
- Shopping cart functionality
- Secure checkout process
- Order management & tracking
- User addresses & wishlist
- Product reviews
- Discount coupons

### 5. ✅ Security Features
- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention
- XSS prevention
- Input validation & sanitization
- Secure file uploads

---

## 🚀 INSTALLATION STEPS

### Prerequisites
```
✓ PHP >= 8.0
✓ MySQL >= 5.7
✓ Apache Web Server
✓ phpMyAdmin (recommended)
```

### STEP 1: Extract Project Files

Place the project folder in your web server directory:
- **XAMPP**: `C:\xampp\htdocs\adiari_website-main\`
- **WAMP**: `C:\wamp\www\adiari_website-main\`
- **LAMP**: `/var/www/html/adiari_website-main/`

### STEP 2: Database Setup (Choose One Method)

#### Method A: Complete Setup (Recommended)
```bash
# Run the complete setup script in MySQL
mysql -u root -p < database/complete_setup.sql
```

#### Method B: Manual Setup via phpMyAdmin

1. **Open phpMyAdmin**: `http://localhost/phpmyadmin`

2. **Click "SQL" tab and paste:**
```sql
CREATE DATABASE adiari_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE adiari_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE adiari_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. **Import Migrations**:
   - Select `adiari_grocery` database
   - Click "Import" → Choose files from `database/migrations/` folder
   - Import files 001-012 (in order)
   
   - Select `adiari_inventory` database
   - Import files 013-015
   
   - Select `adiari_analytics` database
   - Import files 016-018

4. **Import Sample Data**:
   - Select `adiari_grocery` database
   - Import `database/seeds/001_sample_products.sql`

### STEP 3: Configure Database Connection

Edit `config/database.php`:
```php
// Change these if needed (default works for XAMPP/WAMP)
'username' => 'root',
'password' => '',  // Add password if you have one
```

### STEP 4: Set Permissions (Linux/Mac only)

```bash
chmod -R 755 adiari_website-main/
chmod -R 777 adiari_website-main/logs/
chmod -R 777 adiari_website-main/public/uploads/
```

### STEP 5: Configure Web Server

#### For XAMPP/WAMP (Apache)
- Ensure `mod_rewrite` is enabled
- DocumentRoot should point to project folder
- The `.htaccess` file handles routing

#### For Built-in PHP Server (Development)
```bash
cd adiari_website-main
php -S localhost:8000 -t public
```

### STEP 6: Access the Application

Open your browser:
```
http://localhost/adiari_website-main/
# or
http://localhost:8000/
```

---

## 🔐 DEFAULT LOGIN CREDENTIALS

### Admin Account
```
Email: admin@adiarifresh.com
Password: admin123
Role: Full system access
```

### Manager Account
```
Email: manager@adiarifresh.com
Password: manager123
Role: Products & inventory management
```

### Customer Account
```
Email: customer@example.com
Password: customer123
Role: Shopping & orders
```

---

## 📁 PROJECT STRUCTURE

```
adiari_website-main/
├── app/
│   ├── controllers/      # Business logic (8 controllers)
│   ├── models/          # Database operations (8 models)
│   ├── views/           # UI templates (30+ views)
│   ├── core/            # Framework core classes
│   ├── middleware/      # Auth, CSRF, Role middleware
│   ├── helpers/         # Utility functions
│   └── lang/            # Multi-language support
├── config/
│   ├── app.php         # App configuration
│   └── database.php    # Database config
├── database/
│   ├── migrations/     # 18 migration files ✓
│   ├── seeds/          # Sample data ✓
│   └── complete_setup.sql  # All-in-one setup ✓
├── public/
│   ├── index.php       # Entry point
│   ├── css/            # Stylesheets
│   ├── js/             # JavaScript
│   └── uploads/        # User uploads
├── routes/
│   └── web.php         # Route definitions
├── logs/               # Application logs
└── docs/               # Documentation
```

---

## ✅ TESTING CHECKLIST

After installation, test these features:

### Customer Flow
- [ ] Register new account
- [ ] Login successfully
- [ ] Browse products
- [ ] Add items to cart
- [ ] Proceed to checkout
- [ ] Place order
- [ ] View order history
- [ ] Manage addresses
- [ ] Add to wishlist

### Manager Flow
- [ ] Login as manager
- [ ] View dashboard
- [ ] Add new product
- [ ] Edit product
- [ ] Manage categories
- [ ] Update inventory
- [ ] View orders
- [ ] Update order status

### Admin Flow
- [ ] Login as admin
- [ ] View dashboard
- [ ] Add new user
- [ ] Change user role
- [ ] View analytics
- [ ] Manage coupons
- [ ] View system logs

---

## 🐛 COMMON ISSUES & SOLUTIONS

### Issue 1: "Cannot connect to database"
**Solution**: 
```php
// Check config/database.php
'username' => 'root',
'password' => '',  // Add your MySQL password
```

### Issue 2: "404 Not Found" on all pages
**Solution**: 
```apache
# Ensure mod_rewrite is enabled
# For XAMPP: Edit httpd.conf
LoadModule rewrite_module modules/mod_rewrite.so

# AllowOverride All must be set
<Directory "C:/xampp/htdocs">
    AllowOverride All
</Directory>
```

### Issue 3: "Table doesn't exist"
**Solution**: 
```sql
# Re-run the complete setup
mysql -u root -p < database/complete_setup.sql
```

### Issue 4: "Permission denied" (Linux)
**Solution**:
```bash
sudo chmod -R 755 /var/www/html/adiari_website-main
sudo chmod -R 777 /var/www/html/adiari_website-main/logs
sudo chmod -R 777 /var/www/html/adiari_website-main/public/uploads
```

### Issue 5: Blank white page
**Solution**:
```php
// Enable error reporting in config/app.php
'debug' => true,
'display_errors' => true,
```

---

## 🔧 CONFIGURATION OPTIONS

### App Configuration (`config/app.php`)
```php
'app_name' => 'ADI ARI Fresh',
'app_url' => 'http://localhost',
'debug' => true,  // Set to false in production
'timezone' => 'Asia/Tokyo',
```

### Database Configuration (`config/database.php`)
- Already configured for multi-database architecture
- Just update username/password if needed

---

## 📊 SAMPLE DATA INCLUDED

After installation, you'll have:

### Products (19 items)
- **Vegetables**: Tomatoes, Cabbage, Carrots, Spinach, Onions
- **Fruits**: Apples, Bananas, Strawberries, Oranges
- **Halal Meat**: Chicken, Beef, Lamb
- **Dairy**: Milk, Eggs, Yogurt, Butter
- **Pantry**: Rice, Oil, Soy Sauce

### Categories (8)
- Vegetables, Fruits, Halal Meat, Dairy & Eggs
- Pantry, Snacks, Beverages, Frozen Foods

### Users (3)
- 1 Admin, 1 Manager, 1 Customer

---

## 🚀 DEPLOYMENT TO PRODUCTION

### Before Deployment:

1. **Update Configuration**:
```php
// config/app.php
'debug' => false,
'display_errors' => false,
```

2. **Change Default Passwords**:
```sql
USE adiari_grocery;
-- Generate new hash: password_hash('your_password', PASSWORD_BCRYPT)
UPDATE users SET password = '$2y$12$NEW_HASH_HERE' 
WHERE email = 'admin@adiarifresh.com';
```

3. **Update Database Credentials**:
```php
// config/database.php
'username' => 'production_user',
'password' => 'strong_password',
```

4. **Set File Permissions**:
```bash
chmod -R 755 .
chmod -R 777 logs/
chmod -R 777 public/uploads/
```

5. **Enable SSL** (Hostinger):
- Install Let's Encrypt SSL certificate
- Force HTTPS in `.htaccess`

---

## 📚 DOCUMENTATION FILES

- **README.md** - Project overview
- **QUICK_START.md** - Quick setup guide
- **GETTING_STARTED.md** - Detailed installation
- **PROJECT_COMPLETE.md** - Completion status
- **docs/DATABASE_SETUP_GUIDE.md** - Database guide
- **docs/SYSTEM_ARCHITECTURE.md** - Technical architecture
- **docs/CHANGELOG.md** - Version history

---

## 🔄 UPDATING THE SYSTEM

### Adding New Products:
1. Login as Manager
2. Go to Manager Dashboard → Products
3. Click "Add New Product"
4. Fill in details and save

### Managing Orders:
1. Login as Manager
2. Go to Manager Dashboard → Orders
3. View order details
4. Update order status

### User Management:
1. Login as Admin
2. Go to Admin Dashboard → Users
3. Add/Edit/Delete users
4. Assign roles

---

## 💡 HELPFUL COMMANDS

### Check Database Status:
```sql
SHOW DATABASES;
USE adiari_grocery;
SHOW TABLES;
SELECT COUNT(*) FROM products;
```

### Backup Database:
```bash
mysqldump -u root -p adiari_grocery > backup_grocery.sql
mysqldump -u root -p adiari_inventory > backup_inventory.sql
mysqldump -u root -p adiari_analytics > backup_analytics.sql
```

### Restore Database:
```bash
mysql -u root -p adiari_grocery < backup_grocery.sql
```

---

## 🎯 NEXT STEPS

1. ✅ Complete installation
2. ✅ Test all features
3. ✅ Add your products
4. ✅ Customize branding
5. ✅ Deploy to production
6. 🚀 Launch your store!

---

## 📞 SUPPORT & CONTACT

**Business**: ADI ARI FRESH VEGETABLES AND HALAL FOOD  
**Address**: 114-0031 Higashi Tabata 2-3-1 Otsu building 101  
**Phone**: 080-3408-8044  
**Email**: info@adiarifresh.com

---

## ✨ PROJECT COMPLETE!

**Status**: ✅ Production Ready  
**Version**: 1.0.0  
**Last Updated**: February 9, 2026  
**Developer**: Professional PHP Development Team  

**ALL REQUIREMENTS COMPLETED** 🎉

---

_Built with ❤️ for ADI ARI Fresh_
