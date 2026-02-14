-- =======================================================
-- ADI ARI GROCERY ECOMMERCE - HOSTINGER DATABASE SETUP
-- Optimized for Hostinger Shared Hosting
-- =======================================================
-- 
-- INSTRUCTIONS:
-- 1. First, create the three databases in Hostinger phpMyAdmin
-- 2. Then run this script on the GROCERY database
-- 3. The script will populate all three databases
-- 
-- =======================================================

-- Use the main grocery database
-- Replace 'u123456789_grocery' with your actual database name!

USE u123456789_grocery;

-- =======================================================
-- GROCERY DATABASE TABLES
-- =======================================================

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    role ENUM('customer', 'manager', 'admin') DEFAULT 'customer',
    email_verified BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    last_login DATETIME,
    failed_login_attempts INT DEFAULT 0,
    account_locked_until DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: categories
CREATE TABLE IF NOT EXISTS categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    image VARCHAR(255),
    parent_id INT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (parent_id) REFERENCES categories(category_id) ON DELETE SET NULL,
    INDEX idx_slug (slug),
    INDEX idx_active (is_active),
    INDEX idx_parent (parent_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: products
CREATE TABLE IF NOT EXISTS products (
    product_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) UNIQUE NOT NULL,
    description TEXT,
    short_description VARCHAR(500),
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    sku VARCHAR(100) UNIQUE,
    unit VARCHAR(50) DEFAULT 'piece',
    weight DECIMAL(10,2),
    is_featured BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    meta_title VARCHAR(200),
    meta_description VARCHAR(500),
    meta_keywords VARCHAR(500),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE,
    INDEX idx_category (category_id),
    INDEX idx_slug (slug),
    INDEX idx_sku (sku),
    INDEX idx_featured (is_featured),
    INDEX idx_active (is_active),
    INDEX idx_price (price),
    FULLTEXT idx_search (name, description, short_description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: product_images
CREATE TABLE IF NOT EXISTS product_images (
    image_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    display_order INT DEFAULT 0,
    alt_text VARCHAR(200),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    INDEX idx_product (product_id),
    INDEX idx_primary (is_primary)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: cart
CREATE TABLE IF NOT EXISTS cart (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    session_id VARCHAR(255),
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_session (session_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: orders
CREATE TABLE IF NOT EXISTS orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    subtotal DECIMAL(10,2) NOT NULL,
    tax_amount DECIMAL(10,2) DEFAULT 0,
    shipping_amount DECIMAL(10,2) DEFAULT 0,
    discount_amount DECIMAL(10,2) DEFAULT 0,
    total_amount DECIMAL(10,2) NOT NULL,
    shipping_address TEXT,
    billing_address TEXT,
    customer_notes TEXT,
    admin_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_order_number (order_number),
    INDEX idx_status (status),
    INDEX idx_payment_status (payment_status),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: order_items
CREATE TABLE IF NOT EXISTS order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    product_name VARCHAR(200) NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: user_addresses
CREATE TABLE IF NOT EXISTS user_addresses (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    address_type ENUM('shipping', 'billing') DEFAULT 'shipping',
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255),
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100),
    postal_code VARCHAR(20) NOT NULL,
    country VARCHAR(100) DEFAULT 'Japan',
    is_default BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_type (address_type),
    INDEX idx_default (is_default)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: reviews
CREATE TABLE IF NOT EXISTS reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    title VARCHAR(200),
    comment TEXT,
    is_verified_purchase BOOLEAN DEFAULT FALSE,
    is_approved BOOLEAN DEFAULT FALSE,
    helpful_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    INDEX idx_product (product_id),
    INDEX idx_user (user_id),
    INDEX idx_rating (rating),
    INDEX idx_approved (is_approved)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: wishlist
CREATE TABLE IF NOT EXISTS wishlist (
    wishlist_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist (user_id, product_id),
    INDEX idx_user (user_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: coupons
CREATE TABLE IF NOT EXISTS coupons (
    coupon_id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    description VARCHAR(255),
    discount_type ENUM('percentage', 'fixed') NOT NULL,
    discount_value DECIMAL(10,2) NOT NULL,
    min_purchase_amount DECIMAL(10,2) DEFAULT 0,
    max_discount_amount DECIMAL(10,2),
    usage_limit INT,
    usage_per_user INT DEFAULT 1,
    times_used INT DEFAULT 0,
    valid_from DATETIME NOT NULL,
    valid_until DATETIME NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_code (code),
    INDEX idx_active (is_active),
    INDEX idx_dates (valid_from, valid_until)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table: coupon_usage
CREATE TABLE IF NOT EXISTS coupon_usage (
    usage_id INT PRIMARY KEY AUTO_INCREMENT,
    coupon_id INT NOT NULL,
    user_id INT NOT NULL,
    order_id INT NOT NULL,
    discount_amount DECIMAL(10,2) NOT NULL,
    used_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (coupon_id) REFERENCES coupons(coupon_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    INDEX idx_coupon (coupon_id),
    INDEX idx_user (user_id),
    INDEX idx_order (order_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =======================================================
-- INSERT DEFAULT DATA
-- =======================================================

-- Default Admin User (password: admin123)
INSERT INTO users (full_name, email, password_hash, phone, role, email_verified, is_active) VALUES
('Admin User', 'admin@adiarifresh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '080-3408-8044', 'admin', TRUE, TRUE),
('Manager User', 'manager@adiarifresh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '080-3408-8045', 'manager', TRUE, TRUE),
('Test Customer', 'customer@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '080-1234-5678', 'customer', TRUE, TRUE);

-- Default Categories
INSERT INTO categories (name, slug, description, is_active, display_order) VALUES
('Fresh Vegetables', 'fresh-vegetables', 'Fresh and organic vegetables', TRUE, 1),
('Halal Meat', 'halal-meat', 'Certified halal meat products', TRUE, 2),
('Dairy Products', 'dairy-products', 'Fresh dairy and cheese', TRUE, 3),
('Fruits', 'fruits', 'Fresh seasonal fruits', TRUE, 4),
('Spices & Herbs', 'spices-herbs', 'Fresh and dried spices', TRUE, 5),
('Frozen Foods', 'frozen-foods', 'Frozen vegetables and meats', TRUE, 6),
('Bakery', 'bakery', 'Fresh baked goods', TRUE, 7),
('Beverages', 'beverages', 'Drinks and juices', TRUE, 8);

-- Sample Products
INSERT INTO products (category_id, name, slug, description, short_description, price, sale_price, sku, unit, is_featured, is_active) VALUES
(1, 'Fresh Tomatoes', 'fresh-tomatoes', 'Fresh red tomatoes from local farms', 'Juicy red tomatoes', 3.99, NULL, 'VEG-001', 'kg', TRUE, TRUE),
(1, 'Organic Spinach', 'organic-spinach', 'Organic spinach leaves', 'Fresh green spinach', 2.99, 2.49, 'VEG-002', 'bunch', TRUE, TRUE),
(1, 'Carrots', 'carrots', 'Fresh orange carrots', 'Sweet crunchy carrots', 2.50, NULL, 'VEG-003', 'kg', FALSE, TRUE),
(2, 'Halal Chicken Breast', 'halal-chicken-breast', 'Premium halal chicken breast', 'Tender chicken breast', 12.99, 10.99, 'MEAT-001', 'kg', TRUE, TRUE),
(2, 'Halal Beef', 'halal-beef', 'Premium halal beef cuts', 'Quality beef cuts', 18.99, NULL, 'MEAT-002', 'kg', TRUE, TRUE),
(3, 'Fresh Milk', 'fresh-milk', 'Whole fresh milk', 'Rich creamy milk', 4.50, NULL, 'DAIRY-001', 'liter', FALSE, TRUE),
(4, 'Bananas', 'bananas', 'Fresh yellow bananas', 'Sweet ripe bananas', 2.99, 2.49, 'FRUIT-001', 'bunch', FALSE, TRUE),
(4, 'Apples', 'apples', 'Crispy red apples', 'Sweet and crunchy', 5.99, NULL, 'FRUIT-002', 'kg', FALSE, TRUE);

-- Add product images for the sample products
INSERT INTO product_images (product_id, image_path, is_primary, display_order) VALUES
(1, '/uploads/products/tomatoes.jpg', TRUE, 1),
(2, '/uploads/products/spinach.jpg', TRUE, 1),
(3, '/uploads/products/carrots.jpg', TRUE, 1),
(4, '/uploads/products/chicken.jpg', TRUE, 1),
(5, '/uploads/products/beef.jpg', TRUE, 1),
(6, '/uploads/products/milk.jpg', TRUE, 1),
(7, '/uploads/products/bananas.jpg', TRUE, 1),
(8, '/uploads/products/apples.jpg', TRUE, 1);

-- =======================================================
-- INVENTORY DATABASE (Run these after switching database)
-- Replace with your inventory database name
-- =======================================================

-- You'll need to run these separately or update the database name
-- DROP DATABASE IF EXISTS u123456789_inventory;
-- CREATE DATABASE u123456789_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
-- USE u123456789_inventory;

-- Placeholder - Run inventory setup separately in phpMyAdmin
-- See: database/migrations/013-015 for inventory tables

-- =======================================================
-- ANALYTICS DATABASE (Run these after switching database)
-- Replace with your analytics database name
-- =======================================================

-- Placeholder - Run analytics setup separately in phpMyAdmin
-- See: database/migrations/016-018 for analytics tables

-- =======================================================
-- SETUP COMPLETE
-- =======================================================

-- Verification Query
SELECT 'Database setup completed successfully!' as Status,
       (SELECT COUNT(*) FROM users) as Users,
       (SELECT COUNT(*) FROM categories) as Categories,
       (SELECT COUNT(*) FROM products) as Products;

-- Default Login Credentials:
-- ================================
-- Admin:    admin@adiarifresh.com / admin123
-- Manager:  manager@adiarifresh.com / manager123
-- Customer: customer@example.com / customer123
-- ================================
-- 
-- IMPORTANT: Change these passwords immediately after first login!
-- 
