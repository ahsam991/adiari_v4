# 🚀 HOSTINGER DEPLOYMENT GUIDE
## ADI ARI Fresh Vegetables & Halal Food - Complete Production Deployment

---

## 📋 PRE-DEPLOYMENT CHECKLIST

### ✅ Requirements
- [ ] Hostinger hosting account (Business or higher recommended)
- [ ] Domain name configured
- [ ] FTP/SFTP credentials ready
- [ ] phpMyAdmin access
- [ ] SSL certificate (Free Let's Encrypt available)
- [ ] PHP 8.0+ enabled on hosting

---

## 🎯 DEPLOYMENT STEPS

### STEP 1: PREPARE YOUR HOSTINGER HOSTING

#### 1.1 Login to Hostinger Panel
1. Go to hpanel.hostinger.com
2. Login with your credentials
3. Select your website/domain

#### 1.2 Configure PHP Settings
1. Go to **Advanced** → **PHP Configuration**
2. Set PHP version to **8.0** or higher
3. Enable these extensions:
   - PDO
   - PDO_MySQL
   - mbstring
   - openssl
   - fileinfo
   - curl
4. Increase these limits:
   - `upload_max_filesize` = 20M
   - `post_max_size` = 20M
   - `max_execution_time` = 300
   - `memory_limit` = 256M

---

### STEP 2: CREATE DATABASES

#### 2.1 Access phpMyAdmin
1. In Hostinger panel, go to **Databases** → **phpMyAdmin**
2. Login with your database credentials

#### 2.2 Create Three Databases
```sql
-- Create all three databases
CREATE DATABASE u123456789_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE u123456789_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE u123456789_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**IMPORTANT:** Replace `u123456789` with your actual Hostinger database prefix!

#### 2.3 Note Your Database Details
```
Main Database:     u123456789_grocery
Inventory DB:      u123456789_inventory
Analytics DB:      u123456789_analytics
Database Host:     localhost (or provided by Hostinger)
Database Username: u123456789_dbuser (from Hostinger panel)
Database Password: [your password from Hostinger]
```

---

### STEP 3: UPLOAD FILES

#### 3.1 Using File Manager (Recommended for beginners)
1. In Hostinger panel, go to **Files** → **File Manager**
2. Navigate to `/public_html` directory
3. Upload the entire `public` folder contents to `/public_html`
4. Upload all other folders (app, config, database, routes, etc.) to `/public_html/`

**Directory Structure After Upload:**
```
/public_html/
├── app/
├── config/
├── database/
├── logs/
├── routes/
├── css/            (from public folder)
├── js/             (from public folder)
├── images/         (from public folder)
├── uploads/        (from public folder)
├── index.php       (from public folder)
├── .htaccess
└── .env
```

#### 3.2 Using FTP/SFTP (For advanced users)
```bash
# Example using FileZilla or similar FTP client
Host: ftp.yourdomain.com
Username: [from Hostinger]
Password: [from Hostinger]
Port: 21 (FTP) or 22 (SFTP)

# Upload all files to /public_html/
```

---

### STEP 4: CONFIGURE ENVIRONMENT

#### 4.1 Create .env File
1. In File Manager, navigate to `/public_html/`
2. Create a new file named `.env`
3. Add this configuration:

```env
# Application Settings
APP_NAME="ADI ARI Fresh"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database Configuration - GROCERY (Main)
DB_HOST=localhost
DB_NAME=u123456789_grocery
DB_USER=u123456789_dbuser
DB_PASS=your_database_password

# Database Configuration - INVENTORY
DB_INVENTORY_HOST=localhost
DB_INVENTORY_NAME=u123456789_inventory
DB_INVENTORY_USER=u123456789_dbuser
DB_INVENTORY_PASS=your_database_password

# Database Configuration - ANALYTICS
DB_ANALYTICS_HOST=localhost
DB_ANALYTICS_NAME=u123456789_analytics
DB_ANALYTICS_USER=u123456789_dbuser
DB_ANALYTICS_PASS=your_database_password

# Security
SESSION_LIFETIME=7200
CSRF_TOKEN_EXPIRY=3600

# File Upload
MAX_FILE_SIZE=5242880
ALLOWED_EXTENSIONS=jpg,jpeg,png,gif,webp

# Business Info
STORE_NAME="ADI ARI FRESH VEGETABLES AND HALAL FOOD"
STORE_ADDRESS="114-0031 Higashi Tabata 2-3-1 Otsu building 101"
STORE_PHONE="080-3408-8044"
STORE_EMAIL="info@adiarifresh.com"
```

**🔒 CRITICAL:** Replace all database credentials with your actual Hostinger values!

---

### STEP 5: IMPORT DATABASE

#### 5.1 Run Database Setup Script
1. Open phpMyAdmin
2. Select the `u123456789_grocery` database
3. Click **Import** tab
4. Upload and execute: `database/hostinger_setup.sql`
5. Wait for completion (should take 1-2 minutes)

#### 5.2 Verify Database Import
Check that all tables are created:

**Grocery Database (12 tables):**
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

**Inventory Database (3 tables):**
- product_stock
- stock_logs
- warehouse

**Analytics Database (3 tables):**
- sales_analytics
- user_activity
- product_performance

---

### STEP 6: SET PERMISSIONS

#### 6.1 Set Folder Permissions
Using File Manager, right-click and set permissions:

```
public_html/logs/          → 755 or 775
public_html/uploads/       → 755 or 775
public_html/.htaccess      → 644
public_html/.env           → 644 (make sure it's hidden from web)
```

#### 6.2 Create .htaccess Protection for .env
Add to `/public_html/.htaccess` (if not already present):

```apache
# Protect .env file
<Files ".env">
    Order allow,deny
    Deny from all
</Files>
```

---

### STEP 7: CONFIGURE DOMAIN & SSL

#### 7.1 Point Domain to public_html
1. In Hostinger panel, go to **Domains**
2. Ensure your domain points to `/public_html/`
3. If using subdomain, configure accordingly

#### 7.2 Enable SSL Certificate
1. Go to **Security** → **SSL**
2. Install Free Let's Encrypt SSL
3. Force HTTPS redirect

---

### STEP 8: UPDATE APPLICATION CONFIGURATION

#### 8.1 Update config/database.php
```php
<?php
return [
    // Main grocery database
    'grocery' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'dbname' => getenv('DB_NAME') ?: 'u123456789_grocery',
        'username' => getenv('DB_USER') ?: 'u123456789_dbuser',
        'password' => getenv('DB_PASS') ?: 'your_password',
        'charset' => 'utf8mb4'
    ],
    
    // Inventory database
    'inventory' => [
        'host' => getenv('DB_INVENTORY_HOST') ?: 'localhost',
        'dbname' => getenv('DB_INVENTORY_NAME') ?: 'u123456789_inventory',
        'username' => getenv('DB_INVENTORY_USER') ?: 'u123456789_dbuser',
        'password' => getenv('DB_INVENTORY_PASS') ?: 'your_password',
        'charset' => 'utf8mb4'
    ],
    
    // Analytics database
    'analytics' => [
        'host' => getenv('DB_ANALYTICS_HOST') ?: 'localhost',
        'dbname' => getenv('DB_ANALYTICS_NAME') ?: 'u123456789_analytics',
        'username' => getenv('DB_ANALYTICS_USER') ?: 'u123456789_dbuser',
        'password' => getenv('DB_ANALYTICS_PASS') ?: 'your_password',
        'charset' => 'utf8mb4'
    ]
];
```

#### 8.2 Update config/app.php
```php
<?php
return [
    'name' => getenv('APP_NAME') ?: 'ADI ARI Fresh',
    'env' => 'production',
    'debug' => false,  // MUST be false in production
    'url' => 'https://yourdomain.com',
    'timezone' => 'Asia/Tokyo',
    
    'paths' => [
        'uploads' => '/public_html/uploads/',
        'logs' => '/public_html/logs/'
    ]
];
```

---

### STEP 9: TEST THE DEPLOYMENT

#### 9.1 Basic Tests
1. **Homepage Test:**
   - Visit: `https://yourdomain.com/`
   - Should load the homepage

2. **Database Connection Test:**
   - Visit: `https://yourdomain.com/test-db-connection.php`
   - Should show "✅ All databases connected successfully"

3. **Login Test:**
   - Visit: `https://yourdomain.com/login`
   - Try default credentials:
     - Admin: `admin@adiarifresh.com` / `admin123`
     - Manager: `manager@adiarifresh.com` / `manager123`

4. **Product Page Test:**
   - Visit: `https://yourdomain.com/products`
   - Should display product listings

#### 9.2 Advanced Tests
- Add product to cart
- Complete checkout process
- Test manager product upload
- Test admin dashboard
- Test mobile responsiveness

---

### STEP 10: SECURITY HARDENING

#### 10.1 Change Default Passwords
**IMMEDIATELY** after deployment:
```php
// Run this script ONCE: /change-admin-password.php
// Then DELETE the script
```

#### 10.2 Disable Debug Mode
In `.env`:
```env
APP_DEBUG=false
```

#### 10.3 Remove Test Files
Delete these files from production:
- `test_login.php`
- `test_routing.php`
- `debug_login.php`
- `check_admin.php`
- `check_hash.php`
- `fix_passwords.php`
- `PROJECT_*.md` (all project documentation)
- `PHASE_*.md`

#### 10.4 Protect Sensitive Directories
Add to `.htaccess`:
```apache
# Deny access to sensitive directories
<DirectoryMatch "^/.*/?(config|database|logs|app)/">
    Order deny,allow
    Deny from all
</DirectoryMatch>
```

---

## 🎨 POST-DEPLOYMENT CUSTOMIZATION

### Update Store Information
1. Go to Admin Dashboard → Settings
2. Update:
   - Store name
   - Address
   - Phone number
   - Email
   - Business hours
   - Social media links

### Upload Logo & Branding
1. Prepare your logo (recommended: 200x50px PNG with transparent background)
2. Upload via Admin Dashboard → Appearance → Logo
3. Update favicon

### Configure Email Settings
1. In Hostinger panel, go to **Email Accounts**
2. Create email: `info@yourdomain.com`
3. Update email settings in admin panel

---

## 🔧 TROUBLESHOOTING

### Issue: "Database connection failed"
**Solution:**
1. Verify database credentials in `.env`
2. Check database exists in phpMyAdmin
3. Ensure database user has all privileges
4. Check database host (usually 'localhost')

### Issue: "404 Not Found" or "Page not loading"
**Solution:**
1. Check `.htaccess` file exists in `/public_html/`
2. Enable mod_rewrite in PHP settings
3. Clear browser cache
4. Check file permissions

### Issue: "500 Internal Server Error"
**Solution:**
1. Check PHP error logs in Hostinger panel
2. Verify PHP version is 8.0+
3. Check file permissions (logs and uploads folders)
4. Disable debug mode and check logs

### Issue: "Images not uploading"
**Solution:**
1. Check `uploads/` folder permissions (755 or 775)
2. Verify PHP upload settings
3. Check file size limits in PHP configuration

### Issue: "Session not working / Keep logging out"
**Solution:**
1. Check session path in PHP settings
2. Verify cookie settings in browser
3. Check HTTPS is properly configured

---

## 📊 PERFORMANCE OPTIMIZATION

### Enable Caching
Add to `.htaccess`:
```apache
# Browser Caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

### Enable Gzip Compression
Add to `.htaccess`:
```apache
# Gzip Compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css
    AddOutputFilterByType DEFLATE application/javascript application/json
</IfModule>
```

---

## 📱 MOBILE OPTIMIZATION

The site is already mobile-responsive, but verify:
1. Test on real mobile devices
2. Use Google Mobile-Friendly Test
3. Check page load speed on mobile
4. Optimize images for mobile

---

## 🔐 BACKUP STRATEGY

### Daily Backups
Set up Hostinger automatic backups:
1. Go to **Backups** in Hostinger panel
2. Enable automatic daily backups
3. Keep backups for 30 days

### Manual Backup
**Files:**
```bash
# Create archive of all files
tar -czf backup-$(date +%Y%m%d).tar.gz /public_html/
```

**Database:**
1. Go to phpMyAdmin
2. Select each database
3. Click **Export**
4. Download SQL file

---

## 📈 MONITORING

### Setup Monitoring Tools
1. **Google Analytics:** Track visitors and behavior
2. **Google Search Console:** Monitor SEO performance
3. **Uptime Monitor:** Check site availability
4. **Error Logging:** Review `/logs/app.log` regularly

---

## 🎯 LAUNCH CHECKLIST

Before going live, verify:

- [ ] All three databases created and populated
- [ ] .env file configured with correct credentials
- [ ] SSL certificate installed and HTTPS enabled
- [ ] Default admin password changed
- [ ] All test files removed
- [ ] Debug mode disabled
- [ ] File permissions set correctly
- [ ] Homepage loads correctly
- [ ] Products page displays items
- [ ] Login system works
- [ ] Cart functionality works
- [ ] Checkout process completes
- [ ] Admin dashboard accessible
- [ ] Manager dashboard accessible
- [ ] Mobile responsive design verified
- [ ] Forms submit correctly
- [ ] Email configuration tested
- [ ] Backup system in place
- [ ] Google Analytics installed

---

## 🆘 SUPPORT & RESOURCES

### Hostinger Support
- **Live Chat:** Available 24/7 in Hostinger panel
- **Knowledge Base:** support.hostinger.com
- **Email:** support@hostinger.com

### Application Support
- **Email:** info@adiarifresh.com
- **Phone:** 080-3408-8044

### Documentation
- **README.md:** General overview
- **DATABASE_SETUP_GUIDE.md:** Database details
- **SYSTEM_ARCHITECTURE.md:** Technical architecture

---

## ✅ DEPLOYMENT COMPLETE!

Your ADI ARI Fresh website should now be live and fully functional!

**Default Login Credentials:**
- **Admin:** admin@adiarifresh.com / admin123
- **Manager:** manager@adiarifresh.com / manager123
- **Customer:** customer@example.com / customer123

**🔒 IMPORTANT:** Change all default passwords immediately after first login!

---

**Last Updated:** February 9, 2026  
**Version:** 1.0.0 Production Ready

**Built with ❤️ for ADI ARI Fresh Vegetables & Halal Food**
