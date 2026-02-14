<?php
/**
 * Web Routes
 * Define all web application routes here
 */

// Router instance is provided by Application.php


// ============================================
// PUBLIC ROUTES (No Authentication Required)
// ============================================

// Home page
$router->get('/', 'HomeController@index');
$router->get('/about', 'HomeController@about');
$router->get('/contact', 'HomeController@contact');
$router->get('/language/{lang}', 'HomeController@setLanguage');

// Product routes
$router->get('/products', 'ProductController@index');
$router->get('/product/{id}','ProductController@show');
$router->get('/category/{slug}', 'ProductController@category');

// Authentication routes
$router->get('/register', 'AuthController@register');
$router->post('/register', 'AuthController@registerPost');
$router->get('/login', 'AuthController@login');
$router->post('/login', 'AuthController@loginPost');
$router->get('/logout', 'AuthController@logout');
$router->get('/forgot-password', 'AuthController@forgotPassword');
$router->post('/forgot-password', 'AuthController@forgotPasswordPost');
$router->get('/reset-password', 'AuthController@resetPassword');
$router->post('/reset-password', 'AuthController@resetPasswordPost');

// ============================================
// CUSTOMER ROUTES (Authentication Required)
// ============================================

// Cart routes
$router->get('/cart', 'CartController@index');
$router->post('/cart/add', 'CartController@add');
$router->post('/cart/update', 'CartController@update');
$router->post('/cart/remove', 'CartController@remove');

// Checkout routes
$router->get('/checkout', 'CheckoutController@index');
$router->post('/checkout/process', 'CheckoutController@process');

// Order routes
$router->get('/orders', 'OrderController@index');
$router->get('/order/{id}', 'OrderController@show');

// User account routes
$router->get('/account', 'UserController@account');
$router->get('/account/profile', 'UserController@profile');
$router->post('/account/profile/update', 'UserController@profileUpdate');
$router->get('/account/change-password', 'UserController@changePassword');
$router->post('/account/change-password', 'UserController@changePasswordPost');
$router->get('/account/addresses', 'UserController@addresses');
$router->post('/account/address/add', 'UserController@addAddress');
$router->get('/account/wishlist', 'UserController@wishlist');

// ============================================
// MANAGER ROUTES (Manager/Admin Only)
// ============================================

// Manager dashboard
$router->get('/manager', 'ManagerController@dashboard');

// Product management
$router->get('/manager/products', 'ManagerController@products');
$router->get('/manager/product/create', 'ManagerController@createProduct');
$router->post('/manager/product/create', 'ManagerController@storeProduct');
$router->get('/manager/product/{id}/edit', 'ManagerController@editProduct');
$router->post('/manager/product/{id}/update', 'ManagerController@updateProduct');
$router->post('/manager/product/{id}/delete', 'ManagerController@deleteProduct');

// Category management
$router->get('/manager/categories', 'ManagerController@categories');
$router->post('/manager/category/create', 'ManagerController@createCategory');
$router->post('/manager/category/{id}/update', 'ManagerController@updateCategory');

// Order management
$router->get('/manager/orders', 'ManagerController@orders');
$router->get('/manager/order/{id}', 'ManagerController@orderDetail');
$router->post('/manager/order/{id}/status', 'ManagerController@updateOrderStatus');

// Inventory management
$router->get('/manager/inventory', 'ManagerController@inventory');
$router->post('/manager/inventory/update', 'ManagerController@updateInventory');

// ============================================
// ADMIN ROUTES (Admin Only)
// ============================================

// Admin dashboard
$router->get('/admin', 'AdminController@dashboard');

// User management
$router->get('/admin/users', 'AdminController@users');
$router->post('/admin/user/create', 'AdminController@createUser');
$router->post('/admin/user/{id}/update', 'AdminController@updateUser');
$router->post('/admin/user/{id}/delete', 'AdminController@deleteUser');
$router->post('/admin/user/{id}/role', 'AdminController@updateUserRole');

// System settings
$router->get('/admin/settings', 'AdminController@settings');
$router->post('/admin/settings/update', 'AdminController@updateSettings');

// Analytics
$router->get('/admin/analytics', 'AdminController@analytics');
$router->get('/admin/reports', 'AdminController@reports');

// Coupons management
$router->get('/admin/coupons', 'AdminController@coupons');
$router->post('/admin/coupon/create', 'AdminController@createCoupon');
$router->post('/admin/coupon/{id}/update', 'AdminController@updateCoupon');

// Weekly Deals / Offers management
$router->get('/admin/offers', 'AdminController@offers');
$router->post('/admin/offer/create', 'AdminController@createOffer');
$router->post('/admin/offer/{id}/update', 'AdminController@updateOffer');
$router->post('/admin/offer/{id}/delete', 'AdminController@deleteOffer');

// Activity logs
$router->get('/admin/logs', 'AdminController@logs');

// Weekly Deals page for customers
$router->get('/deals', 'HomeController@deals');

// ============================================
// API ROUTES (Future REST API Support)
// ============================================

// API routes will be added here
// $router->get('/api/products', 'Api\Product@index');
// $router->get('/api/product/{id}', 'Api\Product@show');
