@echo off
REM ============================================
REM ADI ARI GROCERY ECOMMERCE
REM Windows Database Setup Script
REM ============================================

echo ========================================
echo ADI ARI GROCERY DATABASE SETUP
echo ========================================
echo.

set MYSQL="C:\xampp\mysql\bin\mysql.exe"
set PROJECT_ROOT=c:\Users\USERAS\Downloads\adiari_v4-1

if not exist %MYSQL% (
    echo ERROR: MySQL not found at %MYSQL%
    echo Please make sure XAMPP is installed at C:\xampp
    pause
    exit /b 1
)

echo Step 1: Creating databases...
echo.

%MYSQL% -u root -e "CREATE DATABASE IF NOT EXISTS adiari_grocery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
%MYSQL% -u root -e "CREATE DATABASE IF NOT EXISTS adiari_inventory CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
%MYSQL% -u root -e "CREATE DATABASE IF NOT EXISTS adiari_analytics CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

if %ERRORLEVEL% EQU 0 (
    echo   [SUCCESS] Databases created
) else (
    echo   [ERROR] Failed to create databases
    echo   Please make sure MySQL service is running in XAMPP Control Panel
    pause
    exit /b 1
)

echo.
echo Step 2: Running migrations for grocery database...
echo.

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\001_create_users_table.sql"
echo   - 001_create_users_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\002_create_categories_table.sql"
echo   - 002_create_categories_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\003_create_products_table.sql"
echo   - 003_create_products_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\004_create_product_images_table.sql"
echo   - 004_create_product_images_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\005_create_cart_table.sql"
echo   - 005_create_cart_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\006_create_orders_table.sql"
echo   - 006_create_orders_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\007_create_order_items_table.sql"
echo   - 007_create_order_items_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\008_create_user_addresses_table.sql"
echo   - 008_create_user_addresses_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\009_create_reviews_table.sql"
echo   - 009_create_reviews_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\010_create_wishlist_table.sql"
echo   - 010_create_wishlist_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\011_create_coupons_table.sql"
echo   - 011_create_coupons_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\012_create_coupon_usage_table.sql"
echo   - 012_create_coupon_usage_table.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\019_add_tax_rate_to_products.sql"
echo   - 019_add_tax_rate_to_products.sql

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\migrations\020_create_settings_table.sql"
echo   - 020_create_settings_table.sql

echo.
echo Step 3: Running migrations for inventory database...
echo.

%MYSQL% -u root adiari_inventory < "%PROJECT_ROOT%\database\migrations\013_create_product_stock_table.sql"
echo   - 013_create_product_stock_table.sql

%MYSQL% -u root adiari_inventory < "%PROJECT_ROOT%\database\migrations\014_create_stock_logs_table.sql"
echo   - 014_create_stock_logs_table.sql

%MYSQL% -u root adiari_inventory < "%PROJECT_ROOT%\database\migrations\015_create_warehouse_table.sql"
echo   - 015_create_warehouse_table.sql

echo.
echo Step 4: Running migrations for analytics database...
echo.

%MYSQL% -u root adiari_analytics < "%PROJECT_ROOT%\database\migrations\016_create_sales_analytics_table.sql"
echo   - 016_create_sales_analytics_table.sql

%MYSQL% -u root adiari_analytics < "%PROJECT_ROOT%\database\migrations\017_create_user_activity_table.sql"
echo   - 017_create_user_activity_table.sql

%MYSQL% -u root adiari_analytics < "%PROJECT_ROOT%\database\migrations\018_create_product_performance_table.sql"
echo   - 018_create_product_performance_table.sql

echo.
echo Step 5: Seeding sample data...
echo.

%MYSQL% -u root adiari_grocery < "%PROJECT_ROOT%\database\seeds\001_sample_products.sql"
echo   - Sample data seeded

echo.
echo ========================================
echo DATABASE SETUP COMPLETE!
echo ========================================
echo.
echo Default Login Credentials:
echo   Admin:    admin@adiarifresh.com / admin123
echo   Manager:  manager@adiarifresh.com / manager123
echo   Customer: customer@example.com / customer123
echo.
echo Databases Created:
echo   - adiari_grocery (12 tables)
echo   - adiari_inventory (3 tables)
echo   - adiari_analytics (3 tables)
echo.
echo Next Steps:
echo   1. Start PHP server:  C:\xampp\php\php.exe -S localhost:8000 -t public
echo   2. Open browser:      http://localhost:8000
echo.
pause
