# 🛒 ADI ARI Fresh - eCommerce Platform v4

A modern, secure, and scalable e-commerce platform built with PHP MVC framework. Perfect for fresh produce, groceries, and specialty items.

![Status](https://img.shields.io/badge/Status-Production%20Ready-brightgreen)
![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)
![License](https://img.shields.io/badge/License-MIT-green)

---

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Configuration](#configuration)
- [Security](#security)
- [Database](#database)
- [API Routes](#api-routes)
- [Development](#development)
- [Deployment](#deployment)

---

## 🎯 Overview

**ADI ARI Fresh** is a comprehensive e-commerce platform designed for managing:
- Product inventory with stock tracking
- Multi-database architecture (grocery, inventory, analytics)
- Secure user authentication and role-based access
- Shopping cart and checkout system
- Order management and tracking
- Activity logging and analytics
- Multi-language support (English, Bengali, Japanese, Nepali)

**Current Version:** 4.0  
**Last Updated:** February 14, 2026  
**Status:** ✅ Production Ready with All Security Fixes Applied

---

## ✨ Features

### 🔐 Security
- ✅ **SQL Injection Prevention** - Parameterized queries throughout
- ✅ **XSS Protection** - Input sanitization and output escaping
- ✅ **CSRF Protection** - Token-based protection on all forms
- ✅ **Password Hashing** - bcrypt with cost factor 12
- ✅ **Session Management** - Secure session regeneration (30-min interval)
- ✅ **Rate Limiting** - Login protection (5 attempts/15 min)
- ✅ **Database Timeout** - 10-second connection timeout
- ✅ **Role-Based Access Control** - Admin, Manager, Customer roles

### 🛍️ E-Commerce
- Product catalog with categories
- Advanced search and filtering
- Stock inventory management
- Shopping cart with real-time updates
- Secure checkout process
- Order management and tracking
- Product reviews and ratings
- Wishlist functionality

### 👥 User Management
- User registration and authentication
- Profile management
- Address management
- Order history
- Activity tracking
- Admin user management

### 📊 Analytics & Reporting
- Activity logging
- Order analytics
- Sales reports
- Product performance metrics
- User behavior tracking

### 🌍 Internationalization
- Multi-language support
- Language-specific content
- Currency handling
- Locale-aware formatting

---

## 📁 Project Structure

```
adiari_v4/
├── app/
│   ├── controllers/        # Request handlers
│   │   ├── AdminController.php
│   │   ├── AuthController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── HomeController.php
│   │   ├── ManagerController.php
│   │   ├── OrderController.php
│   │   ├── ProductController.php
│   │   └── UserController.php
│   ├── models/             # Database models
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Cart.php
│   │   ├── Order.php
│   │   ├── Category.php
│   │   ├── Wishlist.php
│   │   ├── Offer.php
│   │   └── UserAddress.php
│   ├── views/              # Templates
│   │   ├── layouts/
│   │   ├── auth/
│   │   ├── products/
│   │   ├── cart/
│   │   ├── checkout/
│   │   ├── admin/
│   │   └── manager/
│   ├── core/               # Framework core
│   │   ├── Application.php
│   │   ├── Router.php
│   │   ├── Controller.php
│   │   ├── Model.php
│   │   ├── View.php
│   │   └── Database.php
│   ├── helpers/            # Utility functions
│   │   ├── Security.php
│   │   ├── Session.php
│   │   ├── Logger.php
│   │   ├── Validation.php
│   │   ├── Language.php
│   │   └── RateLimit.php
│   ├── middleware/         # Request middleware
│   │   ├── AuthMiddleware.php
│   │   ├── CSRFMiddleware.php
│   │   └── RoleMiddleware.php
│   └── lang/               # Language files
│       ├── en/
│       ├── bn/
│       ├── ja/
│       └── ne/
├── public/                 # Web root
│   ├── index.php          # Entry point
│   ├── uploads/           # User uploads
│   ├── images/
│   ├── js/
│   └── css/
├── config/                # Configuration
│   ├── app.php
│   └── database.php
├── database/              # Database setup
│   ├── complete_setup.sql
│   ├── hostinger_setup.sql
│   ├── migrations/
│   ├── patches/
│   └── seeds/
├── routes/               # Route definitions
│   └── web.php
├── logs/                 # Application logs
├── docs/                 # Documentation
├── tests/                # Test files
└── .env.example          # Environment template
```

---

## 🚀 Installation

### Requirements
- PHP 7.4 or higher
- MySQL 5.7 or MariaDB 10.3+
- Apache with mod_rewrite enabled
- Composer (optional, for future dependencies)

### Step 1: Clone Repository
```bash
git clone https://github.com/ahsam991/adiari_v4.git
cd adiari_v4
```

### Step 2: Database Setup
```bash
# Import the database schema
mysql -u root -p < database/complete_setup.sql

# Or use Hostinger setup
mysql -u root -p < database/hostinger_setup.sql
```

### Step 3: Configure Application
```bash
# Copy configuration files
cp config/app.php.example config/app.php
cp config/database.php.example config/database.php

# Edit database credentials in config/database.php
nano config/database.php
```

### Step 4: Set Permissions
```bash
chmod 755 public/
chmod 775 logs/
chmod 775 public/uploads/
```

### Step 5: Access Application
```
http://localhost/adiari_v4
```

---

## ⚙️ Configuration

### Database Configuration (`config/database.php`)
```php
return [
    'grocery' => [
        'host' => 'localhost',
        'database' => 'adiari_grocery',
        'username' => 'root',
        'password' => '',
        // ...
    ],
    'inventory' => [ /* ... */ ],
    'analytics' => [ /* ... */ ]
];
```

### Application Configuration (`config/app.php`)
```php
return [
    'app_name' => 'ADI ARI Fresh',
    'app_url' => 'http://localhost/adiari_v4',
    'debug' => false,  // Set to true in development
    'timezone' => 'Asia/Tokyo',
    // ...
];
```

---

## 🔒 Security Features

### SQL Injection Prevention
All database queries use parameterized statements with PDO prepared statements.

```php
// ✅ SAFE - Parameterized query
$query = "SELECT * FROM products WHERE id = ? LIMIT ? OFFSET ?";
$result = Database::fetchAll($query, [$id, $limit, $offset]);

// ❌ UNSAFE - String interpolation
$query = "SELECT * FROM products WHERE id = {$id}";
```

### Password Security
- bcrypt hashing with cost factor 12
- Automatic password verification
- Password reset with token validation

```php
$hashedPassword = Security::hashPassword($plainPassword);
$isValid = Security::verifyPassword($plainPassword, $hashedPassword);
```

### Session Security
- Secure session configuration
- Automatic session regeneration every 30 minutes
- HTTPOnly and Secure cookies
- SameSite cookie protection

### Rate Limiting
Prevents brute force attacks:
- **Login:** 5 attempts per 15 minutes
- **Registration:** Configurable per action
- **Session-based tracking**

```php
$rateCheck = RateLimit::check('login', $email, 5, 900);
if (!$rateCheck['allowed']) {
    // Block attempt
}
```

### CSRF Protection
All forms include CSRF tokens:
```html
<?= Security::getCsrfField() ?>
```

---

## 🗄️ Database

### Multi-Database Architecture
- **grocery** - Main e-commerce data (products, orders, users)
- **inventory** - Stock and inventory tracking
- **analytics** - User activity and metrics

### Key Tables
- `users` - User accounts and authentication
- `products` - Product catalog
- `categories` - Product categories
- `cart` - Shopping cart items
- `orders` - Customer orders
- `order_items` - Order line items
- `user_activity` - Activity logging
- `reviews` - Product reviews
- `wishlists` - User wishlists
- `offers` - Weekly deals and promotions

### Migrations
```bash
# Run all migrations
php migrate.php

# Run specific migration
php migrate.php --migration=001_create_users_table
```

---

## 📡 API Routes

### Public Routes
```
GET  /                          - Homepage
GET  /products                  - Product listing
GET  /product/{id}              - Product details
GET  /category/{slug}           - Category products
GET  /search?q={query}          - Search products
```

### Authentication
```
GET  /register                  - Registration form
POST /register                  - Submit registration
GET  /login                     - Login form
POST /login                     - Submit login
GET  /logout                    - Logout
GET  /forgot-password           - Forgot password form
POST /forgot-password           - Submit password reset
GET  /reset-password            - Reset password form
POST /reset-password            - Complete password reset
```

### Customer Routes (Authenticated)
```
GET  /cart                      - View cart
POST /cart/add                  - Add to cart
POST /cart/update               - Update cart
POST /cart/remove               - Remove from cart
GET  /checkout                  - Checkout page
POST /checkout/process          - Process order
GET  /orders                    - Order history
GET  /order/{id}                - Order details
GET  /account                   - Account page
GET  /account/profile           - Profile page
POST /account/profile/update    - Update profile
GET  /account/addresses         - Manage addresses
POST /account/address/add       - Add address
```

### Manager Routes (Admin Only)
```
GET  /manager                   - Dashboard
GET  /manager/products          - Product list
GET  /manager/product/create    - Create product form
POST /manager/product/create    - Store product
GET  /manager/product/{id}/edit - Edit product form
POST /manager/product/{id}/update - Update product
POST /manager/product/{id}/delete - Delete product
GET  /manager/categories        - Category management
GET  /manager/orders            - Order management
GET  /manager/inventory         - Inventory management
```

### Admin Routes (Admin Only)
```
GET  /admin                     - Admin dashboard
GET  /admin/users               - User management
POST /admin/user/create         - Create user
POST /admin/user/{id}/update    - Update user
POST /admin/user/{id}/delete    - Delete user
POST /admin/user/{id}/role      - Update user role
GET  /admin/offers              - Manage offers
POST /admin/offer/create        - Create offer
POST /admin/offer/{id}/update   - Update offer
POST /admin/offer/{id}/delete   - Delete offer
GET  /admin/logs                - Activity logs
GET  /admin/settings            - Settings
POST /admin/settings/update     - Update settings
```

---

## 🛠️ Development

### Running Locally
```bash
# Using PHP built-in server
cd public
php -S localhost:8000

# Then visit: http://localhost:8000
```

### Code Style
- PSR-12 coding standard
- Meaningful variable names
- Comprehensive documentation
- Type hints where applicable

### Testing
```bash
# Run tests
php vendor/bin/phpunit

# Run specific test
php vendor/bin/phpunit tests/Models/ProductTest.php
```

### Debugging
Enable debug mode in `config/app.php`:
```php
'debug' => true,
```

View logs in `logs/` directory:
```bash
tail -f logs/error.log
tail -f logs/activity.log
```

---

## 📦 Deployment

### Pre-Deployment Checklist
- [ ] Database migrations completed
- [ ] Configuration files set
- [ ] Permissions configured
- [ ] Logs directory writable
- [ ] Debug mode disabled
- [ ] SSL certificate installed

### Production Setup
```bash
# Set debug to false
sed -i "s/'debug' => true/'debug' => false/g" config/app.php

# Set proper permissions
chmod 755 public/
chmod 755 logs/
chmod 755 storage/

# Create .htaccess for Apache
cp .htaccess.example .htaccess
```

### Server Requirements
- PHP 7.4+ with extensions: PDO, MySQLi, OpenSSL, JSON
- MySQL 5.7+ or MariaDB 10.3+
- Apache 2.4+ with mod_rewrite
- 1GB minimum RAM
- 10GB storage for database

### Deployment with Git
```bash
# Clone to production server
git clone https://github.com/ahsam991/adiari_v4.git /var/www/adiari

# Set up environment
cd /var/www/adiari
cp config/database.php.example config/database.php
# Edit with production credentials
nano config/database.php

# Set permissions
chown -R www-data:www-data .
chmod 755 public/ logs/ storage/
```

---

## 📊 Recent Fixes & Improvements

### Security Enhancements (v4.0)
- ✅ Fixed SQL injection in LIMIT/OFFSET (Product.php)
- ✅ Added updateStock() method for checkout
- ✅ Improved session regeneration logic
- ✅ Added database connection timeout
- ✅ Implemented rate limiting for login
- ✅ Enhanced input validation
- ✅ Fixed View layout variable scope
- ✅ Added RateLimit helper class

See [FIXES_APPLIED.md](FIXES_APPLIED.md) for detailed information.

---

## 📝 License

This project is licensed under the MIT License - see LICENSE file for details.

---

## 👨‍💻 Authors

- **Development Team:** ADI ARI Development
- **Current Maintainer:** ahsam991

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit changes (`git commit -m 'Add amazing feature'`)
4. Push to branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📞 Support

For issues, questions, or suggestions:
1. Check existing [Issues](https://github.com/ahsam991/adiari_v4/issues)
2. Review [Documentation](docs/)
3. Contact development team

---

## 🔗 Resources

- [Installation Guide](COMPLETE_INSTALLATION_GUIDE.md)
- [Deployment Guide](README_DEPLOYMENT.md)
- [Security Fixes](FIXES_APPLIED.md)
- [Activity Logging Guide](ACTIVITY_LOGGING_USER_GUIDE.md)

---

**Last Updated:** February 14, 2026  
**Version:** 4.0 (Production Ready)
