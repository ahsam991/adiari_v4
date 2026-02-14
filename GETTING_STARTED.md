# 🚀 Getting Started - ADI ARI Grocery Ecommerce

## Quick Start Guide
**Get your grocery ecommerce system running in minutes!**

---

## ✅ Prerequisites Checklist

Before starting, make sure you have:

- [x] **PHP 8.0+** installed
- [x] **MySQL 5.7+** or **MariaDB 10.3+**
- [x] **Composer** (optional, for future dependencies)
- [x] **Web browser** (Chrome, Firefox, Safari, Edge)
- [x] **Text editor** (VS Code, Sublime, etc.)

---

## 📂 Project Setup

### Step 1: Verify Project Structure

Your project should look like this:

```
L:\Web media\website_adiari\
├── app/
│   ├── controllers/       ✅ AuthController, UserController, HomeController
│   ├── core/              ✅ Application, Router, Controller, Model, etc.
│   ├── helpers/           ✅ Security, Validation, Session, etc.
│   ├── models/            ✅ User, Product, Category, Cart, Order
│   ├── middleware/        ✅ AuthMiddleware, RoleMiddleware, CSRFMiddleware
│   └── views/             ✅ auth/, user/, home/
├── config/                ✅ app.php, database.php
├── database/
│   ├── migrations/        ✅ 18 SQL files
│   └── seeds/             ✅ Sample data
├── docs/                  ✅ All documentation
├── public/                ✅ index.php, CSS, JS
├── routes/                ✅ web.php
└── storage/
    ├── logs/              Create this folder
    └── sessions/          Create this folder
```

### Step 2: Create Storage Directories

If they don't exist, create:

```bash
cd "L:\Web media\website_adiari"
mkdir storage\logs
mkdir storage\sessions
```

Or manually create:
- `L:\Web media\website_adiari\storage\logs\`
- `L:\Web media\website_adiari\storage\sessions\`

---

## 🗄 Database Setup

### Option A: Using phpMyAdmin (Recommended for Beginners)

1. **Open phpMyAdmin** in your browser (usually `http://localhost/phpmyadmin`)

2. **Create Databases:**
   - Click "New" in left sidebar
   - Create: `adiari_grocery`
   - Create: `adiari_inventory`
   - Create: `adiari_analytics`
   - Use Collation: `utf8mb4_unicode_ci`

3. **Run Migrations:**
   - Select `adiari_grocery` database
   - Click "SQL" tab
   - Open each file from `database/migrations/001-012_*.sql`
   - Copy paste content and execute (12 files)
   
   - Select `adiari_inventory` database
   - Run files `013-015_*.sql` (3 files)
   
   - Select `adiari_analytics` database
   - Run files `016-018_*.sql` (3 files)

4. **Run Seeders:**
   - Select `adiari_grocery` database
   - Run `database/seeds/001_sample_products.sql`

### Option B: Using MySQL Command Line

```bash
# Create databases
mysql -u root -p -e "CREATE DATABASE adiari_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "CREATE DATABASE adiari_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -p -e "CREATE DATABASE adiari_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Run migrations
cd "L:\Web media\website_adiari\database\migrations"
mysql -u root -p adiari_grocery < 001_create_users_table.sql
mysql -u root -p adiari_grocery < 002_create_categories_table.sql
# ... (repeat for all 18 files)

# Run seeders
cd "..\seeds"
mysql -u root -p adiari_grocery < 001_sample_products.sql
```

**For detailed instructions, see:** `docs/DATABASE_SETUP_GUIDE.md`

---

## ⚙ Configuration

### Update Database Credentials

Edit: `config/database.php`

```php
'grocery' => [
    'host' => 'localhost',
    'database' => 'adiari_grocery',
    'username' => 'YOUR_USERNAME',     // Change this!
    'password' => 'YOUR_PASSWORD',     // Change this!
],

'inventory' => [
    'host' => 'localhost',
    'database' => 'adiari_inventory',
    'username' => 'YOUR_USERNAME',     // Change this!
    'password' => 'YOUR_PASSWORD',     // Change this!
],

'analytics' => [
    'host' => 'localhost',
    'database' => 'adiari_analytics',
    'username' => 'YOUR_USERNAME',     // Change this!
    'password' => 'YOUR_PASSWORD',     // Change this!
],
```

Replace `YOUR_USERNAME` and `YOUR_PASSWORD` with your MySQL credentials.

---

## 🚀 Start the Server

### Method 1: PHP Built-in Server (Easiest)

Open PowerShell or Command Prompt:

```bash
# Navigate to project
cd "L:\Web media\website_adiari"

# Start server
php -S localhost:8000 -t public
```

You should see:
```
[Sun Feb 09 00:30:00 2026] PHP 8.x.x Development Server (http://localhost:8000) started
```

**Access your site:** `http://localhost:8000`

### Method 2: XAMPP/WAMP/MAMP

1. Copy project to htdocs:
   ```
   C:\xampp\htdocs\website_adiari\
   ```

2. Configure virtual host (optional)

3. Access: `http://localhost/website_adiari/`

### Method 3: Apache/Nginx

Configure a virtual host pointing to `public/` directory.

**Example Apache vhost:**
```apache
<VirtualHost *:80>
    ServerName adiari.local
    DocumentRoot "L:/Web media/website_adiari/public"
    
    <Directory "L:/Web media/website_adiari/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Add to hosts file: `127.0.0.1 adiari.local`

---

## 🎯 Test the Installation

### 1. Visit Homepage

Open browser: `http://localhost:8000/`

**You should see:**
- ✅ Green hero section
- ✅ "Fresh Vegetables & Halal Food Delivered"
- ✅ Features section (Organic, Halal, Fast Delivery)
- ✅ Business information
- ✅ Demo notice at bottom

### 2. Test Login

Visit: `http://localhost:8000/login`

**Demo Credentials:**
- **Admin**: `admin@adiarifresh.com` / `admin123`
- **Manager**: `manager@adiarifresh.com` / `manager123`

Click "Sign In" → Should redirect to dashboard!

### 3. Test Registration

Visit: `http://localhost:8000/register`

Create a new account → Should redirect to login!

---

## 🧪 Run Full Tests

See: `docs/PHASE_3_TESTING_GUIDE.md`

Quick test checklist:
```bash
✅ http://localhost:8000/               Homepage
✅ http://localhost:8000/register       Registration
✅ http://localhost:8000/login          Login
✅ http://localhost:8000/account        User Dashboard (after login)
✅ http://localhost:8000/logout         Logout
```

---

## 📍 Available Routes

### Public Routes
- `GET /` - Homepage
- `GET /about` - About page
- `GET /contact` - Contact page
- `GET /register` - Registration form
- `POST /register` - Process registration
- `GET /login` - Login form
- `POST /login` - Process login
- `GET /forgot-password` - Forgot password form
- `POST /forgot-password` - Process forgot password
- `GET /reset-password` - Reset password form
- `POST /reset-password` - Process password reset

### Protected Routes (Login Required)
- `GET /account` - User dashboard
- `GET /account/profile` - Edit profile
- `POST /account/profile/update` - Update profile
- `GET /account/change-password` - Change password form
- `POST /account/change-password` - Process password change
- `GET /logout` - Logout

### Admin Routes (Coming in Phase 4+)
- `/admin` - Admin dashboard
- `/manager` - Manager dashboard
- `/products` - Product listing
- `/product/{id}` - Product details

---

## 🔐 Demo Accounts

### After running seeders, you have:

| Role | Email | Password | Access Level |
|------|-------|----------|--------------|
| Admin | admin@adiarifresh.com | admin123 | Full access |
| Manager | manager@adiarifresh.com | manager123 | Products, Orders, Inventory |
| Customer | (create your own) | - | Shopping, Orders |

**⚠️ IMPORTANT:** Change these passwords in production!

---

## 🐛 Troubleshooting

### Problem: "Server not found" or "Connection refused"

**Solution:**
1. Make sure server is running: `php -S localhost:8000 -t public`
2. Check you're accessing the correct URL
3. Try a different port: `php -S localhost:8080 -t public`

### Problem: "Database connection failed"

**Solution:**
1. Check MySQL is running
2. Verify credentials in `config/database.php`
3. Test connection:
   ```bash
   mysql -u root -p
   SHOW DATABASES;
   ```
4. Ensure databases exist: `adiari_grocery`, `adiari_inventory`, `adiari_analytics`

### Problem: "Table doesn't exist"

**Solution:**
1. Run all migration files in order
2. Check database: `SHOW TABLES;` in phpMyAdmin or MySQL
3. Expected: 18 tables across 3 databases

### Problem: "Class not found"

**Solution:**
1. Check file paths in controllers
2. Verify `require_once` statements
3. Ensure class names match file names

### Problem: "Headers already sent"

**Solution:**
1. Remove whitespace before `<?php` tags
2. Check for `echo` before redirects
3. Ensure no output before Session or header() calls

### Problem: "Permission denied" (storage/logs, storage/sessions)

**Solution:**
```bash
# Windows (PowerShell as Admin)
icacls "L:\Web media\website_adiari\storage" /grant Everyone:F /T

# Or manually:
# Right-click folder → Properties → Security → Edit → Add "Everyone" with Full Control
```

---

## 📚 Documentation

### Complete Documentation Available:

- **Quick Start**: `GETTING_STARTED.md` (this file)
- **Testing Guide**: `docs/PHASE_3_TESTING_GUIDE.md`
- **Database Setup**: `docs/DATABASE_SETUP_GUIDE.md`
- **Phase 3 Complete**: `docs/PHASE_3_COMPLETE.md`
- **Phase 3 Summary**: `PHASE_3_SUMMARY.md`
- **Phase 2 Complete**: `docs/PHASE_2_COMPLETE.md`
- **Phase 1 Complete**: `docs/PHASE_1_COMPLETE.md`
- **Changelog**: `docs/CHANGELOG.md`
- **Architecture**: `docs/SYSTEM_ARCHITECTURE.md`

---

## 🎯 What's Working Now

After completing Phase 1-3, you have:

✅ **Core MVC Framework** (Phase 1)
- Routing system
- Controller base class
- Model ORM
- View rendering
- Middleware support

✅ **Database Layer** (Phase 2)
- 18 tables across 3 databases
- 5 core models
- Sample data (2 users, 8 categories, 19 products)

✅ **Authentication System** (Phase 3)
- User registration
- Login/logout
- Password reset
- Account management
- Profile editing
- Password change
- CSRF protection
- Account lockout

---

## 🔄 Next Steps

### Phase 4: Product Management (Coming Next)

We'll build:
1. Product listing page
2. Product detail pages
3. Category filtering
4. Search functionality
5. Product CRUD (admin/manager)
6. Image upload
7. Category management

**Estimated Time:** 3-4 work sessions

---

## 💬 Need Help?

### Common Questions:

**Q: Can I change the port?**  
A: Yes! Use: `php -S localhost:XXXX -t public` (replace XXXX with your port)

**Q: How do I stop the server?**  
A: Press `Ctrl+C` in the terminal where server is running

**Q: Where are error logs?**  
A: Check `storage/logs/app.log`

**Q: How do I add new users?**  
A: Register at `/register` or insert into database

**Q: Can I use this in production?**  
A: Not yet! Phases 1-3 are complete. Need to complete all 8 phases for production readiness.

---

## 🎉 You're All Set!

Your ADI ARI Fresh Vegetables and Halal Food ecommerce system is now running!

**Start the server and visit:**  
`http://localhost:8000`

**Login with:**  
`admin@adiarifresh.com` / `admin123`

**Happy coding!** 🚀

---

**Business**: ADI ARI FRESH VEGETABLES AND HALAL FOOD  
**Location**: 114-0031 Higashi Tabata 2-3-1 Otsu building 101, Tokyo  
**Phone**: 080-3408-8044

---

_Last Updated: 2026-02-09_  
_Phase 3 Complete - Authentication System Ready_
