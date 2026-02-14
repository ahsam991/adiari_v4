# ADI ARI Grocery Ecommerce - Visual System Architecture

## System Overview Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                     ADI ARI GROCERY ECOMMERCE SYSTEM                 │
│                         (Phase 1 - COMPLETED)                        │
└─────────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                           WEB BROWSER                                │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │  https://adiarifresh.com  (or localhost for development)     │  │
│  └───────────────────────────────────────────────────────────────┘  │
└──────────────────────────────┬──────────────────────────────────────┘
                               │ HTTP Request
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                        APACHE WEB SERVER                             │
│  ┌───────────────────────────────────────────────────────────────┐  │
│  │                      .htaccess                                 │  │
│  │  • URL Rewriting  • Security Headers  • Caching               │  │
│  └───────────────────────────────────────────────────────────────┘  │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                     public/index.php (ENTRY POINT)                   │
│  • Loads all framework classes                                      │
│  • Initializes Application object                                   │
│  • Starts routing                                                   │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                      APPLICATION.PHP (BOOTSTRAP)                     │
│  ┌────────────────┬───────────────┬───────────────┬──────────────┐  │
│  │ Start Session  │ Load Config   │ Error Handler │ Init Database│  │
│  └────────────────┴───────────────┴───────────────┴──────────────┘  │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                       ROUTER.PHP (ROUTING SYSTEM)                    │
│  ┌────────────────────────────────────────────────────────────────┐ │
│  │  Request: /products                                            │ │
│  │  ↓                                                             │ │
│  │  Check routes/web.php                                          │ │
│  │  ↓                                                             │ │
│  │  Match: $router->get('/products', 'Product@index')            │ │
│  │  ↓                                                             │ │
│  │  Execute Middleware (if any)                                   │ │
│  │  ↓                                                             │ │
│  │  Call ProductController->index()                               │ │
│  └────────────────────────────────────────────────────────────────┘ │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
        ┌──────────────────────┼──────────────────────┐
        │                      │                      │
        ▼                      ▼                      ▼
┌──────────────┐      ┌──────────────┐      ┌──────────────┐
│  MIDDLEWARE  │      │  MIDDLEWARE  │      │  MIDDLEWARE  │
│     Auth     │      │     CSRF     │      │     Role     │
│              │      │              │      │              │
│ • Check      │      │ • Validate   │      │ • Check      │
│   logged in  │      │   tokens     │      │   permission │
└──────────────┘      └──────────────┘      └──────────────┘
        │                      │                      │
        └──────────────────────┼──────────────────────┘
                               │
                               ▼
┌─────────────────────────────────────────────────────────────────────┐
│                          CONTROLLER LAYER                            │
│  ┌────────────────┬──────────────────┬───────────────────────────┐  │
│  │ HomeController │ ProductController│ OrderController (Phase 2+)│  │
│  │ AuthController │ CartController   │ AdminController (Phase 2+)│  │
│  │ (Phase 2)      │ (Phase 2)        │ ManagerController (Phase 2+)│  │
│  └────────────────┴──────────────────┴───────────────────────────┘  │
│                                                                      │
│  Each Controller:                                                    │
│  • Handles business logic                                           │
│  • Uses Models for data                                             │
│  • Returns Views or JSON                                            │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                ┌──────────────┼──────────────┐
                │              │              │
                ▼              ▼              ▼
      ┌────────────────────────────────────────────┐
      │           MODEL LAYER                      │
      │  ┌──────────────────────────────────────┐  │
      │  │ User Model     (Phase 2)             │  │
      │  │ Product Model  (Phase 2)             │  │
      │  │ Category Model (Phase 2)             │  │
      │  │ Order Model    (Phase 2)             │  │
      │  │ Cart Model     (Phase 2)             │  │
      │  └──────────────────────────────────────┘  │
      │                                            │
      │  Each Model:                               │
      │  • CRUD operations                         │
      │  • Data validation                         │
      │  • Business rules                          │
      │  • Talks to Database                       │
      └──────────────────┬─────────────────────────┘
                         │
                         ▼
┌─────────────────────────────────────────────────────────────────────┐
│                      DATABASE.PHP (DATA LAYER)                       │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │  Multi-Database Connection Manager                           │   │
│  │  • PDO with prepared statements                              │   │
│  │  • Connection pooling                                         │   │
│  │  • Transaction support                                        │   │
│  └──────────────────────────────────────────────────────────────┘   │
└─────────────┬───────────────┬─────────────────┬─────────────────────┘
              │               │                 │
              ▼               ▼                 ▼
    ┌────────────────┐ ┌────────────────┐ ┌────────────────┐
    │   DATABASE 1   │ │   DATABASE 2   │ │   DATABASE 3   │
    │                │ │                │ │                │
    │ adiari_grocery │ │adiari_inventory│ │adiari_analytics│
    │                │ │                │ │                │
    │ • users        │ │ • product_stock│ │ • sales_data   │
    │ • products     │ │ • stock_logs   │ │ • user_activity│
    │ • categories   │ │ • warehouse    │ │ • reports      │
    │ • orders       │ │                │ │                │
    │ • cart         │ │                │ │                │
    │ • reviews      │ │                │ │                │
    └────────────────┘ └────────────────┘ └────────────────┘

┌─────────────────────────────────────────────────────────────────────┐
│                            VIEW LAYER                                │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │                      VIEW.PHP (Template Engine)               │   │
│  │  • XSS Protection (escape output)                            │   │
│  │  • Layout support (layouts/main.php)                          │   │
│  │  • Partial views                                              │   │
│  │  • CSRF token helpers                                         │   │
│  └──────────────────────────────────────────────────────────────┘   │
│                             │                                        │
│                             ▼                                        │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │              app/views/                                       │   │
│  │  ┌─────────────────┐  ┌──────────────────┐                   │   │
│  │  │ layouts/        │  │ home/             │                   │   │
│  │  │ • main.php ✅   │  │ • index.php ✅   │                   │   │
│  │  │                 │  │                   │                   │   │
│  │  │                 │  │ products/ (Phase2)│                   │   │
│  │  │                 │  │ auth/ (Phase 2)   │                   │   │
│  │  │                 │  │ admin/ (Phase 2)  │                   │   │
│  │  └─────────────────┘  └──────────────────┘                   │   │
│  └──────────────────────────────────────────────────────────────┘   │
└──────────────────────────────┬──────────────────────────────────────┘
                               │
                               ▼
                    ┌──────────────────────┐
                    │   HTML + CSS + JS    │
                    │  (Sent to Browser)   │
                    └──────────────────────┘
```

## Helper & Utility Layer (Available Everywhere)

```
┌─────────────────────────────────────────────────────────────────────┐
│                     HELPER CLASSES (app/helpers/)                    │
│  ┌──────────────┬──────────────┬─────────────┬────────────────────┐ │
│  │ Security.php │ Session.php  │ Logger.php  │ Validation.php     │ │
│  ├──────────────┼──────────────┼─────────────┼────────────────────┤ │
│  │• CSRF tokens │• Get/Set     │• Info()     │• Required          │ │
│  │• Bcrypt hash │• Flash msgs  │• Error()    │• Email             │ │
│  │• XSS prevent │• Session ID  │• Warning()  │• Min/Max length    │ │
│  │• File upload │• Destroy     │• Debug()    │• Unique (DB check) │ │
│  │  validation  │• Regenerate  │• Activity() │• Exists (DB check) │ │
│  │• Sanitize    │              │• Auto rotate│• Match fields      │ │
│  └──────────────┴──────────────┴─────────────┴────────────────────┘ │
└─────────────────────────────────────────────────────────────────────┘
```

## Security Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────┐
│                        SECURITY LAYERS                               │
└─────────────────────────────────────────────────────────────────────┘

Request → │
          │  [1] .htaccess Security Headers
          │      ✓ X-Frame-Options
          │      ✓ XSS-Protection
          │      ✓ Content-Security-Policy
          │
          │  [2] Apache mod_rewrite
          │      ✓ Routes all to public/index.php
          │      ✓ Hides .env, .sql, .log files
          │
          │  [3] Session Security (Application.php)
          │      ✓ HttpOnly cookies
          │      ✓ Secure flag (HTTPS)
          │      ✓ SameSite=Lax
          │      ✓ Auto regeneration
          │
          │  [4] Middleware Layer
          │      ✓ AuthMiddleware (login check)
          │      ✓ RoleMiddleware (permission check)
          │      ✓ CSRFMiddleware (token validation)
          │
          │  [5] Controller Input Validation
          │      ✓ Validation::validate()
          │      ✓ Security::sanitize()
          │
          │  [6] Model/Database Layer
          │      ✓ Prepared statements (PDO)
          │      ✓ No raw SQL
          │      ✓ Parameter binding
          │
          │  [7] View Output Escaping
          │      ✓ View::escape() for all user data
          │      ✓ XSS prevention
          │
          ▼
Response ← │
```

## User Roles & Permissions Matrix

```
┌─────────────────────────────────────────────────────────────────────┐
│                         ROLE HIERARCHY                               │
└─────────────────────────────────────────────────────────────────────┘

                         ┌──────────────┐
                         │    ADMIN     │ (Full Access)
                         └──────┬───────┘
                                │
                                │ Manages
                                ▼
                         ┌──────────────┐
                         │   MANAGER    │ (Product & Order Mgmt)
                         └──────┬───────┘
                                │
                                │ Serves
                                ▼
                         ┌──────────────┐
                         │   CUSTOMER   │ (Shopping & Orders)
                         └──────────────┘

PERMISSIONS:
┌─────────────────┬──────────┬──────────┬──────────┐
│ Permission      │ Customer │ Manager  │  Admin   │
├─────────────────┼──────────┼──────────┼──────────┤
│ Browse Products │    ✓     │    ✓     │    ✓     │
│ Add to Cart     │    ✓     │    ✓     │    ✓     │
│ Place Orders    │    ✓     │    ✓     │    ✓     │
│ View Own Orders │    ✓     │    ✓     │    ✓     │
│ Manage Products │    ✗     │    ✓     │    ✓     │
│ View All Orders │    ✗     │    ✓     │    ✓     │
│ Manage Inventory│    ✗     │    ✓     │    ✓     │
│ Manage Users    │    ✗     │    ✗     │    ✓     │
│ System Settings │    ✗     │    ✗     │    ✓     │
│ View Analytics  │    ✗     │    ✗     │    ✓     │
└─────────────────┴──────────┴──────────┴──────────┘
```

## Data Flow Example: Add to Cart

```
1. User clicks "Add to Cart" button
   │
   ▼
2. JavaScript sends AJAX POST request
   POST /cart/add
   Data: {product_id: 123, quantity: 2, csrf_token: "..."}
   │
   ▼
3. Router matches route → CartController@add
   │
   ▼
4. Middleware executes:
   - AuthMiddleware: Check if user logged in ✓
   - CSRFMiddleware: Validate CSRF token ✓
   │
   ▼
5. CartController->add() method:
   - Validate input (product_id, quantity)
   - Check if product exists (ProductModel)
   - Check stock availability (InventoryModel)
   - Add/update cart item (CartModel)
   - Log activity (Logger)
   │
   ▼
6. CartModel->addItem():
   - Build SQL query
   - Use prepared statement
   - Insert/update cart record
   - Return success
   │
   ▼
7. Controller returns JSON response:
   {success: true, cart_count: 3, message: "Added to cart"}
   │
   ▼
8. JavaScript updates UI:
   - Update cart count badge
   - Show success message
   - Enable checkout button
```

## Technology Stack Visualization

```
┌─────────────────────────────────────────────────────────────────────┐
│                        FRONTEND (CLIENT-SIDE)                        │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │  HTML5  │  Tailwind CSS  │  JavaScript  │  Material Icons  │   │
│  └──────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
                                   │
                                   │ HTTP/AJAX
                                   ▼
┌─────────────────────────────────────────────────────────────────────┐
│                       BACKEND (SERVER-SIDE)                          │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │               PHP 8+ (Custom MVC Framework)                   │   │
│  │  • OOP     • PDO     • Session     • Security Helpers        │   │
│  └──────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
                                   │
                                   │ PDO
                                   ▼
┌─────────────────────────────────────────────────────────────────────┐
│                         DATABASE LAYER                               │
│  ┌────────────┬────────────────┬──────────────────────────────┐     │
│  │   MySQL    │  phpMyAdmin    │  3 Separate Databases        │     │
│  └────────────┴────────────────┴──────────────────────────────┘     │
└─────────────────────────────────────────────────────────────────────┘
                                   │
                                   │ Storage
                                   ▼
┌─────────────────────────────────────────────────────────────────────┐
│                        HOSTING (HOSTINGER)                           │
│  ┌──────────────────────────────────────────────────────────────┐   │
│  │  Apache  │  SSL/HTTPS  │  Shared Hosting  │  File Storage   │   │
│  └──────────────────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────────────────┘
```

---

## Phase Implementation Roadmap

```
PHASE 1: Core MVC Framework ✅ COMPLETE
├── Custom MVC architecture
├── Security implementation
├── Routing system
├── Design system
├── Documentation
└── Demo homepage

PHASE 2: Database Implementation ⏳ NEXT
├── Create 3 databases
├── Database migrations (10+ tables)
├── Database seeds
├── Core models (User, Product, Category)
└── Admin user creation

PHASE 3: Authentication System
├── User registration
├── Login/logout
├── Password reset
├── Email verification
└── Role management

PHASE 4: Product Management
├── Product CRUD
├── Category management
├── Multi-image upload
├── Search & filtering
└── Product reviews

PHASE 5: Ecommerce Features
├── Shopping cart
├── Checkout process
├── Payment integration
├── Order management
└── Order tracking

PHASE 6: Dashboards
├── Customer dashboard
├── Manager dashboard
├── Admin dashboard
└── Analytics views

PHASE 7: Additional Features
├── Coupons & promotions
├── Wishlist
├── Email notifications
├── Inventory management
└── Reporting system

PHASE 8: Testing & Deployment
├── Security testing
├── Performance optimization
├── Cross-browser testing
├── Mobile testing
└── Hostinger deployment
```

---

**Current Status**: Phase 1 ✅ Complete  
**Next Target**: Phase 2 - Database Implementation  
**Final Goal**: Full production ecommerce system

---

_Last Updated: February 8, 2026_
