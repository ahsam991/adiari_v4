# ADI ARI FRESH VEGETABLES AND HALAL FOOD
## Grocery Ecommerce Platform

### 🏢 Business Information
- **Store Name:** ADI ARI FRESH VEGETABLES AND HALAL FOOD
- **Address:** 114-0031 Higashi Tabata 2-3-1 Otsu building 101
- **Phone:** 080-3408-8044
- **Website Type:** Grocery & Halal Food Ecommerce

---

## 📋 Project Overview

A complete full-stack grocery ecommerce website built with **PHP, MySQL, and custom MVC architecture**. The system supports multi-database architecture, role-based access control, and comprehensive ecommerce workflows for ADI ARI Fresh grocery store.

### Key Features
- ✅ Custom PHP MVC Framework
- ✅ Multi-Database Architecture (Grocery, Inventory, Analytics)
- ✅ Role-Based Access Control (Customer, Manager, Admin)
- ✅ Complete Ecommerce Workflow
- ✅ Secure Authentication & Authorization
- ✅ Product & Category Management
- ✅ Shopping Cart & Checkout
- ✅ Order Tracking & Management
- ✅ Inventory Management
- ✅ Admin & Manager Dashboards
- ✅ Analytics & Reporting
- ✅ Responsive Design (Mobile & Desktop)
- ✅ SEO-Friendly URLs
- ✅ CSRF Protection & XSS Prevention
- ✅ Comprehensive Documentation

---

## 🛠 Technology Stack

### Backend
- PHP 8+
- Custom MVC Architecture
- OOP PHP
- PDO for Database
- REST API Ready

### Database
- MySQL
- phpMyAdmin
- Multi-Database Structure

### Frontend
- HTML5
- CSS3
- Bootstrap / Tailwind CSS
- JavaScript
- AJAX

### Hosting
- Apache Server
- SSL Enabled
- Hostinger Compatible

---

## 📂 Project Structure

```
adiari-grocery/
├── app/
│   ├── controllers/       # Application controllers
│   ├── models/           # Database models
│   ├── views/            # View templates
│   ├── core/             # Core framework classes
│   ├── middleware/       # Middleware (Auth, Role, CSRF)
│   ├── services/         # Business logic services
│   └── helpers/          # Helper functions
├── config/               # Configuration files
├── routes/               # Route definitions
├── database/
│   ├── migrations/       # Database migrations
│   └── seeds/            # Database seeders
├── public/
│   ├── css/              # Stylesheets
│   ├── js/               # JavaScript files
│   ├── images/           # Images
│   ├── uploads/          # User uploads
│   └── index.php         # Application entry point
├── logs/                 # Application logs
├── docs/                 # Documentation
├── .htaccess             # Apache configuration
└── .env.example          # Environment template
```

---

## 🚀 Installation Guide

### Prerequisites
- PHP >= 8.0
- MySQL >= 5.7
- Apache Web Server
- Composer (optional, for future dependencies)

### Step 1: Clone/Download Project
```bash
git clone <repository-url>
cd website_adiari
```

### Step 2: Configure Environment
```bash
# Copy environment template
cp .env.example .env

# Edit .env with your database credentials
# Update database host, username, password
```

### Step 3: Create Databases
```sql
CREATE DATABASE adiari_grocery;
CREATE DATABASE adiari_inventory;
CREATE DATABASE adiari_analytics;
```

### Step 4: Run Migrations
```bash
# Import database migrations
# Navigate to database/migrations folder
# Run each migration file in phpMyAdmin or command line
mysql -u root -p adiari_grocery < database/migrations/001_create_users_table.sql
# Repeat for all migration files
```

### Step 5: Configure Apache
```apache
# Ensure mod_rewrite is enabled
a2enmod rewrite

# Point DocumentRoot to /public folder
# Update Apache virtual host configuration
```

### Step 6: Set Permissions
```bash
# Make logs and uploads writable
chmod -R 775 logs/
chmod -R 775 public/uploads/
```

###Step 7: Access Application
```
http://localhost/
# or
http://yourdomain.com/
```

---

## 👥 User Roles

### Customer
- Register/Login
- Browse products
- Add to cart
- Checkout & place orders
- Track orders
- Manage addresses
- Wishlist
- Profile management

### Manager
- Product management
- Upload product images
- Stock management
- Category management
- Order management  
- Order status updates
- Inventory monitoring

### Admin
- User management
- Role assignment
- System configuration
- Analytics dashboard
- Coupon management
- Activity logs
- Full system control

---

## 🗄 Database Architecture

### Database 1: adiari_grocery
Main ecommerce data
- users
- categories
- products
- product_images
- cart
- orders
- order_items
- reviews
- coupons
- user_addresses
- wishlist
- payment_transactions

### Database 2: adiari_inventory
Stock tracking
- product_stock
- stock_logs
- warehouse

### Database 3: adiari_analytics
Reporting
- sales_analytics
- user_activity
- product_performance
- order_reports

---

## 🔐 Security Features

- Password hashing with bcrypt
- CSRF token protection
- SQL injection prevention (prepared statements)
- XSS prevention (output escaping)
- Input sanitization
- Secure file uploads
- Role-based access control
- Session regeneration
- Security headers (.htaccess)

---

## 📱 Responsive Design

The application is fully responsive and optimized for:
- 📱 Mobile devices
- 💻 Tablets
- 🖥 Desktop computers

Design follows modern grocery ecommerce aesthetics with:
- Clean, professional layout
- Green color scheme (fresh & organic feel)
- Easy navigation
- Quick add-to-cart functionality
- Mobile-first approach

---

## 📝 Documentation

Comprehensive documentation is maintained in the `docs/` folder:
- **CHANGELOG.md** - Version history & updates
- **DEVELOPMENT_LOG.md** - Development progress tracking
- **DATABASE_DOCUMENTATION.md** - Database schema & relationships
- **INSTALLATION_GUIDE.md** - Detailed setup instructions
- **USER_MANUAL.md** - User guides for all roles
- **API_DOCUMENTATION.md** - Future REST API documentation

---

## 🧪 Testing

The system should be tested for:
- ✅ Functional testing (all user flows)
- ✅ Security testing
- ✅ Role permission testing
- ✅ Cross-browser testing
- ✅ Mobile responsiveness
- ✅ Performance optimization

---

## 🌐 Deployment (Hostinger)

### Preparation
1. Export all databases
2. Update .env with production credentials
3. Set `debug = false` in config/app.php
4. Remove .env.example from production

### Upload
1. Upload files via FTP/File Manager
2. Point domain to `/public` folder
3. Import databases via phpMyAdmin
4. Configure SSL certificate
5. Test all functionality

---

## 🔮 Future Enhancements

- Payment gateway integration (Stripe/PayPal)
- Email notifications
- SMS notifications
- Multi-language support
- AI product recommendations
- Subscription ordering
- Mobile application backend
- Progressive Web App (PWA)

---

## 📞 Support

For support and inquiries:
- **Email:** info@adiarifresh.com
- **Phone:** 080-3408-8044

---

## 📄 License

This project is proprietary software developed for ADI ARI FRESH VEGETABLES AND HALAL FOOD.

---

## 👨‍💻 Development

**Version:** 1.0.0  
**Status:** Production Ready  
**Last Updated:** 2026-02-08

---

**Built with ❤️ for ADI ARI Fresh**

# adiari_website
