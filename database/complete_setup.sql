-- =======================================================
-- ADI ARI GROCERY ECOMMERCE - COMPLETE DATABASE SETUP
-- This file runs all migrations in the correct order
-- =======================================================

-- =======================================================
-- STEP 1: CREATE THE THREE DATABASES
-- =======================================================

CREATE DATABASE IF NOT EXISTS adiari_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS adiari_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE IF NOT EXISTS adiari_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- =======================================================
-- STEP 2: RUN ALL MIGRATIONS FOR GROCERY DATABASE
-- =======================================================

USE adiari_grocery;

SOURCE database/migrations/001_create_users_table.sql;
SOURCE database/migrations/002_create_categories_table.sql;
SOURCE database/migrations/003_create_products_table.sql;
SOURCE database/migrations/004_create_product_images_table.sql;
SOURCE database/migrations/005_create_cart_table.sql;
SOURCE database/migrations/006_create_orders_table.sql;
SOURCE database/migrations/007_create_order_items_table.sql;
SOURCE database/migrations/008_create_user_addresses_table.sql;
SOURCE database/migrations/009_create_reviews_table.sql;
SOURCE database/migrations/010_create_wishlist_table.sql;
SOURCE database/migrations/011_create_coupons_table.sql;
SOURCE database/migrations/012_create_coupon_usage_table.sql;

-- =======================================================
-- STEP 3: RUN ALL MIGRATIONS FOR INVENTORY DATABASE
-- =======================================================

USE adiari_inventory;

SOURCE database/migrations/013_create_product_stock_table.sql;
SOURCE database/migrations/014_create_stock_logs_table.sql;
SOURCE database/migrations/015_create_warehouse_table.sql;

-- =======================================================
-- STEP 4: RUN ALL MIGRATIONS FOR ANALYTICS DATABASE
-- =======================================================

USE adiari_analytics;

SOURCE database/migrations/016_create_sales_analytics_table.sql;
SOURCE database/migrations/017_create_user_activity_table.sql;
SOURCE database/migrations/018_create_product_performance_table.sql;

-- =======================================================
-- STEP 5: SEED SAMPLE DATA
-- =======================================================

SOURCE database/seeds/001_sample_products.sql;

-- =======================================================
-- DATABASE SETUP COMPLETE!
-- =======================================================

-- Default Login Credentials:
-- Admin: admin@adiarifresh.com / admin123
-- Manager: manager@adiarifresh.com / manager123  
-- Customer: customer@example.com / customer123

-- Databases Created:
-- ✓ adiari_grocery (12 tables)
-- ✓ adiari_inventory (3 tables)
-- ✓ adiari_analytics (3 tables)

-- Sample Data:
-- ✓ 3 Users
-- ✓ 8 Categories
-- ✓ 19 Products
-- ✓ 1 Warehouse
-- ✓ 19 Stock Records
