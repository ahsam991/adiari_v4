# 🚀 Quick Start Guide - ADI ARI Grocery Ecommerce

## Getting Started with Your New eCommerce System

---

## ⚡ Phase 1 Status: COMPLETE ✅

Your custom MVC framework is ready! Here's how to get started.

---

## 1️⃣ View the Homepage (Test Installation)

### Option A: Using PHP Built-in Server (Recommended for Testing)

1. Open terminal/command prompt
2. Navigate to project directory:
   ```bash
   cd "L:\Web media\website_adiari"
   ```

3. Start PHP server:
   ```bash
   php -S localhost:8000 -t public
   ```

4. Open browser and visit:
   ```
   http://localhost:8000
   ```

### Option B: Using XAMPP/WAMP/MAMP

1. Move project to your web server directory:
   - XAMPP: `C:\xampp\htdocs\website_adiari`
   - WAMP: `C:\wamp64\www\website_adiari`

2. Access in browser:
   ```
   http://localhost/website_adiari/public/
   ```

3. *Note: You may need to configure a virtual host to point directly to `/public` folder*

---

## 2️⃣ What You'll See

When you visit the homepage, you should see:

✅ **Modern header** with ADI ARI logo  
✅ **"100% Halal Certified" badge** in green  
✅ **Hero section** with gradient and call-to-action  
✅ **Three feature cards** (Halal, Delivery, Organic)  
✅ **Category grid** (Vegetables, Fruits, Meat, Dairy)  
✅ **Green CTA section** ("Ready to Start Shopping?")  
✅ **Professional footer** with business information  

The page should be:
- ✅ Fully responsive (test on mobile size)
- ✅ Green-themed with primary color `#20df29`
- ✅ Using Work Sans font
- ✅ Material icons displaying correctly

---

## 3️⃣ Current Status & Limitations

### ✅ What Works Now:
- Homepage displays correctly
- Routing system functional
- Design system implemented
- Layout template working
- Security headers active

### ⏳ What Doesn't Work Yet (Phase 2+):
- Database not created (no products to display)
- Login/Register pages (controllers not built)
- Cart functionality (needs database)
- Product pages (needs database + models)
- Admin/Manager dashboards (Phase 6)

**This is expected!** Phase 1 is just the foundation.

---

## 4️⃣ Project Structure Overview

```
website_adiari/
├── app/               ← Your application code
│   ├── controllers/   ← Page controllers
│   ├── core/          ← Framework classes
│   ├── helpers/       ← Utility functions
│   ├── middleware/    ← Route protection
│   ├── models/        ← Database models (Phase 2)
│   └── views/         ← HTML templates
├── config/            ← Configuration files
├── public/            ← Web root (point domain here)
│   └── index.php      ← Entry point
├── routes/            ← Route definitions
└── docs/              ← Documentation
```

---

## 5️⃣ Next Steps (Phase 2 Preview)

### To Continue Development:

1. **Create the Databases**
   ```sql
   CREATE DATABASE adiari_grocery;
   CREATE DATABASE adiari_inventory;
   CREATE DATABASE adiari_analytics;
   ```

2. **Update Database Configuration**
   - Copy `.env.example` to `.env`
   - Add your MySQL credentials

3. **Create Migration Files**
   - Users table
   - Products table
   - Categories table
   - Orders table
   - etc.

4. **Build Models**
   - User model
   - Product model
   - Category model
   - etc.

5. **Implement Authentication**
   - Registration
   - Login/Logout
   - Password reset

---

## 6️⃣ Testing the Framework

### Test Routing
Try visiting these URLs (they won't work fully yet but should demonstrate routing):

```
http://localhost:8000/              ← Homepage (works!)
http://localhost:8000/products      ← Will error (no controller yet)
http://localhost:8000/login         ← Will error (no controller yet)
http://localhost:8000/fake-page     ← Should show 404
```

### Test Security Headers
Open browser DevTools → Network tab → Refresh → Click on the main document → Check Response Headers:

You should see:
- `X-Frame-Options: SAMEORIGIN`
- `X-XSS-Protection: 1; mode=block`
- `X-Content-Type-Options: nosniff`

---

## 7️⃣ File Editing Guide

### To Add a New Page:

1. **Create Controller** (`app/controllers/YourController.php`):
   ```php
   <?php
   require_once __DIR__ . '/../core/Controller.php';
   
   class YourController extends Controller {
       public function index() {
           $data = ['title' => 'Your Page'];
           $this->view('your/index', $data);
       }
   }
   ```

2. **Create View** (`app/views/your/index.php`):
   ```html
   <div class="container mx-auto px-4 py-8">
       <h1>Your Page Content</h1>
   </div>
   ```

3. **Add Route** (`routes/web.php`):
   ```php
   $router->get('/your-page', 'Your@index');
   ```

---

## 8️⃣ Common Issues & Solutions

### Issue: "Page Not Found" for everything
**Solution**: Make sure you're accessing via `/public/` directory or configure virtual host.

### Issue: CSS/Styles not loading
**Solution**: Check the `.htaccess` file is in the root directory. Tailwind CSS is loaded from CDN.

### Issue: "Headers already sent" error
**Solution**: Make sure no PHP files have whitespace before `<?php` or after `?>`

### Issue: Database connection error (Phase 2+)
**Solution**: Update `config/database.php` with correct credentials or use `.env` file.

---

## 9️⃣ Customization Tips

### Change Primary Color:
Edit `app/views/layouts/main.php` line where Tailwind config is:
```javascript
"primary": "#20df29",  // Change this hex code
```

### Change Business Name:
Edit `config/app.php`:
```php'name' => 'YOUR BUSINESS NAME',
```

### Add New Routes:
Edit `routes/web.php` and add:
```php
$router->get('/your-url', 'Controller@method');
```

---

## 🔟 Documentation Quick Links

- **Full README**: `README.md`
- **Changelog**: `docs/CHANGELOG.md`
- **Development Log**: `docs/DEVELOPMENT_LOG.md`
- **Phase 1 Complete**: `docs/PHASE_1_COMPLETE.md`
- **This Guide**: `QUICK_START.md`

---

## 📞 Need Help?

### Project Information
- **Business**: ADI ARI FRESH VEGETABLES AND HALAL FOOD
- **Address**: 114-0031 Higashi Tabata 2-3-1 Otsu building 101
- **Phone**: 080-3408-8044

### Development Support
Check the comprehensive documentation in the `/docs` folder for detailed information about:
- Architecture decisions
- Security implementations
- Database design (Phase 2)
- API structure (future)

---

## ✅ Checklist - Am I Ready for Phase 2?

- [ ] Homepage displays correctly
- [ ] Can access `http://localhost:8000` or `http://localhost/website_adiari/public/`
- [ ] Header shows "ADI ARI" logo
- [ ] Green theme is visible
- [ ] Footer shows business information
- [ ] Page is responsive (test by resizing browser)
- [ ] No PHP errors in browser
- [ ] Security headers are present (check DevTools)

**If all checkboxes are ticked, you're ready for Phase 2!** 🎉

---

## 🎯 What's Coming in Phase 2

1. Three MySQL databases created
2. 10+ database tables with relationships
3. User authentication (register/login/logout)
4. User, Product, Category models
5. Database seeder with test data
6. Admin user account created

**Estimated Time**: 2-3 work sessions

---

## 🚀 Ready to Code!

Your foundation is solid. Time to build the application!

**Current Phase**: Phase 1 ✅ COMPLETE  
**Next Phase**: Phase 2 - Database Implementation  
**Final Goal**: Full grocery ecommerce with admin panel

---

_Happy Coding!_ 💻  
_Last Updated: February 8, 2026_
