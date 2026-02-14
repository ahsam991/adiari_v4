# Redirect and CSRF Fixes - Summary

## Issues Fixed

### 1. Router URL Generation (Router.php)
**Problem**: The `url()` and `redirect()` methods had inconsistent handling of base paths, causing incorrect URL generation and redirect loops.

**Fixed in**: `app/core/Router.php`
- Updated `url()` method to properly normalize base paths
- Fixed handling when running from root vs subdirectories
- Added support for external URL redirects (http://, https://)
- Ensured consistent path handling in both `url()` and `getRequestUri()`

**Changes**:
```php
// Before
public static function url($path) {
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
    return $basePath . '/' . ltrim($path, '/');
}

// After
public static function url($path) {
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $basePath = rtrim(dirname($scriptName), '/');
    
    // Normalize to empty string for root directory
    if ($basePath === '/' || $basePath === '\\') {
        $basePath = '';
    }
    
    $path = '/' . ltrim($path, '/');
    return $basePath . $path;
}
```


### 2. CSRF Validation Method Name (AuthController.php)
**Problem**: Methods were calling `validateCSRF()` (uppercase) but the actual method in Controller.php is `validateCsrf()` (camelCase), causing validation failures.

**Fixed in**: `app/controllers/AuthController.php`
- Changed all instances of `$this->validateCSRF()` to `$this->validateCsrf()`
- Affected methods: `registerPost()`, `loginPost()`, `forgotPasswordPost()`, `resetPasswordPost()`

### 3. Session Authentication Consistency
**Problem**: Mismatched session key checks across different parts of the application.

**Fixed in**: 
- `app/middleware/AuthMiddleware.php` - Changed `Session::has('user')` to `Session::isLoggedIn()`
- `app/core/Controller.php`:
  - Updated `getUser()` to construct user array from individual session keys
  - Changed `isAuthenticated()` to use `Session::isLoggedIn()`

**Session Structure**:
After login, the following session keys are set:
- `user_id` - User ID
- `user_email` - User email
- `user_name` - Full name
- `user_role` - User role (customer, manager, admin)
- `logged_in` - Boolean flag

### 4. CSRF Token Null Validation (Security.php & Product Views)
**Problem**: When adding products to cart, if no CSRF token was provided, `validateCsrfToken()` would pass `null` to `hash_equals()`, causing a fatal error.

**Fixed in**:
- `app/helpers/Security.php`:
  - Added null/empty check before `hash_equals()` call
  - Added helper methods `getCsrfField()` and `getCsrfToken()`
- `app/views/products/show.php`:
  - Added missing CSRF token field to add-to-cart form

**Changes**:
```php
// Before
public static function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

// After
public static function validateCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    // Check if provided token is valid (not null or empty)
    if (empty($token) || !is_string($token)) {
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}
```

## Testing Recommendations

1. **Test Login Flow**:
   - Navigate to `/login`
   - Enter valid credentials
   - Verify redirect to appropriate dashboard based on role:
     - Admin → `/admin`
     - Manager → `/manager`
     - Customer → `/account`

2. **Test Registration**:
   - Navigate to `/register`
   - Complete registration form
   - Verify redirect to `/login` after successful registration

3. **Test Logout**:
   - Click logout
   - Verify redirect to `/` (home page)

4. **Test Protected Routes**:
   - Try accessing `/manager` without login
   - Should redirect to `/login` with error message

5. **Test Password Reset**:
   - Navigate to `/forgot-password`
   - Submit email
   - Check redirect behavior

6. **Test Add to Cart**:
   - Navigate to any product page (e.g., `/product/1`)
   - Adjust quantity and click "Add to Cart"
   - Verify no CSRF errors occur
   - Verify redirect to cart page or success message

## Technical Details

### URL Generation
URLs are now generated consistently using:
- `Router::url('/path')` - Generates full URL with base path
- `Router::redirect('/path')` - Redirects to URL with proper base path handling

### Session Management
Authentication checks now use:
- `Session::isLoggedIn()` - Checks both `user_id` and `logged_in` flags
- `$this->getUser()` - Returns array with user data or null
- `$this->isAuthenticated()` - Returns boolean

### CSRF Protection
All POST forms should include:
```php
<?php echo Security::getCsrfField(); ?>
```

And verify using:
```php
if (!$this->validateCsrf()) {
    // Handle invalid CSRF token
}
```

## Files Modified
1. `app/core/Router.php` - URL generation and redirect logic
2. `app/core/Controller.php` - Session authentication methods
3. `app/controllers/AuthController.php` - CSRF method name fixes
4. `app/middleware/AuthMiddleware.php` - Session check consistency
5. `app/helpers/Security.php` - CSRF token validation and helper methods
6. `app/views/products/show.php` - Added CSRF token to cart form
