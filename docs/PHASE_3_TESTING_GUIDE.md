# 🧪 Phase 3 Testing Guide

## ADI ARI Grocery Ecommerce - Authentication System
**Complete Testing Checklist**

---

## 🚀 Quick Start

### Prerequisites
1. ✅ Database set up (Phase 2 complete)
2. ✅ Web server running (Apache/Nginx or PHP built-in server)
3. ✅ `.env` file configured with database credentials

### Start Testing Server

**Option 1: PHP Built-in Server**
```bash
cd "L:\Web media\website_adiari"
php -S localhost:8000 -t public
```

**Option 2: Open in Browser**
```
http://localhost:8000
```

---

## 📋 Test Scenarios

### ✅ Test 1: Homepage

**Steps:**
1. Open browser: `http://localhost:8000/`
2. Verify homepage loads
3. Check navigation menu
4. Click "Shop Now" button
5. Click "Sign Up Free" button (if not logged in)

**Expected Results:**
- ✅ Hero section displays
- ✅ Features section shows (Organic, Halal, Fast Delivery)
- ✅ Business info displays correctly
- ✅ Demo notice shows at bottom
- ✅ Navigation works

---

### ✅ Test 2: User Registration

**Steps:**
1. Visit: `http://localhost:8000/register`
2. Fill in form:
   - First Name: `Test`
   - Last Name: `User`
   - Email: `test@example.com`
   - Phone: `080-1234-5678`
   - Password: `test123`
   - Confirm Password: `test123`
3. Click "Create Account"

**Expected Results:**
- ✅ Form validates all fields
- ✅ Redirects to `/login` on success
- ✅ Success message: "Registration successful! Please login."
- ✅ User created in database with hashed password
- ✅ Check database: `SELECT * FROM users WHERE email='test@example.com'`

**Test Validation Errors:**
1. Leave fields empty → Shows required errors
2. Enter invalid email → Shows email format error
3. Use existing email → Shows "Email already exists"
4. Passwords don't match → Shows match error
5. Password too short (<6 chars) → Shows minimum length error

---

### ✅ Test 3: User Login

**Steps:**
1. Visit: `http://localhost:8000/login`
2. Use demo credentials:
   - Email: `admin@adiarifresh.com`
   - Password: `admin123`
3. Click "Sign In"

**Expected Results:**
- ✅ Redirects to `/admin` (admin dashboard)
- ✅ Welcome message: "Welcome back, Admin!"
- ✅ Session created (check browser dev tools → Application → Cookies)
- ✅ Last login timestamp updated in database

**Test Other Roles:**

**Manager:**
- Email: `manager@adiarifresh.com`
- Password: `manager123`
- Redirects to: `/manager`

**Customer (from Test 2):**
- Email: `test@example.com`
- Password: `test123`
- Redirects to: `/account`

**Test Login Errors:**
1. Wrong password → "Invalid email or password"
2. Non-existent email → "Invalid email or password"
3. Try wrong password 5 times → Account locked
4. Check database: `SELECT login_attempts, status FROM users WHERE email='test@example.com'`

---

### ✅ Test 4: Account Lockout

**Steps:**
1. Visit: `http://localhost:8000/login`
2. Enter correct email but wrong password
3. Repeat 5 times
4. Try to login with correct password

**Expected Results:**
- ✅ After 5 failed attempts:
  - `login_attempts` = 5 in database
  - `status` = 'locked' in database
- ✅ Login with correct password fails
- ✅ Error: "Your account is inactive. Please contact support."

**Unlock Account (Database):**
```sql
USE adiari_grocery;
UPDATE users 
SET status = 'active', login_attempts = 0 
WHERE email = 'test@example.com';
```

---

### ✅ Test 5: Forgot Password

**Steps:**
1. Visit: `http://localhost:8000/forgot-password`
2. Enter email: `admin@adiarifresh.com`
3. Click "Send Reset Instructions"
4. Copy the reset token from success message

**Expected Results:**
- ✅ Success message displays
- ✅ Reset token generated (shown in demo mode)
- ✅ Check database:
  ```sql
  SELECT password_reset_token, password_reset_expires_at 
  FROM users 
  WHERE email = 'admin@adiarifresh.com';
  ```
- ✅ Token expires in 60 minutes

---

### ✅ Test 6: Reset Password

**Steps:**
1. From Test 5, copy reset token or use reset link
2. Visit: `http://localhost:8000/reset-password?token=YOUR_TOKEN`
3. Enter new password: `newpass123`
4. Confirm password: `newpass123`
5. Click "Reset Password"

**Expected Results:**
- ✅ Redirects to `/login`
- ✅ Success message: "Password reset successful!"
- ✅ Password updated in database (hashed)
- ✅ Token cleared from database
- ✅ Can login with new password
- ✅ Old password no longer works

**Test Token Expiry:**
1. Use expired token (>60 min old) → Error
2. Use same token twice → Error (already used)
3. Use invalid token → Error

---

### ✅ Test 7: User Dashboard

**Steps:**
1. Login as customer (from Test 3)
2. Visit: `http://localhost:8000/account`

**Expected Results:**
- ✅ Dashboard displays
- ✅ User initials in avatar (e.g., "TU" for Test User)
- ✅ Full name displays
- ✅ Email displays
- ✅ Role badge shows "Customer"
- ✅ Sidebar navigation works
- ✅ Account overview shows:
  - Personal information
  - Last login time
  - Email verification status
  - Account status

---

### ✅ Test 8: Edit Profile

**Steps:**
1. From dashboard, click "Edit Profile"
2. Visit: `http://localhost:8000/account/profile`
3. Change:
   - First Name: `Updated`
   - Last Name: `Name`
   - Phone: `090-9999-9999`
4. Click "Save Changes"

**Expected Results:**
- ✅ Success message: "Profile updated successfully!"
- ✅ Changes saved to database
- ✅ Session name updated to "Updated Name"
- ✅ Check top navigation shows new name
- ✅ Email field is read-only (cannot be changed)

**Test Validation:**
1. Clear first name → Required error
2. Name too short (<2 chars) → Min length error

---

### ✅ Test 9: Change Password

**Steps:**
1. From dashboard, click "Change Password"
2. Visit: `http://localhost:8000/account/change-password`
3. Enter:
   - Current Password: `test123`
   - New Password: `newtest456`
   - Confirm Password: `newtest456`
4. Click "Update Password"

**Expected Results:**
- ✅ Success message: "Password changed successfully!"
- ✅ Redirects to `/account`
- ✅ Password updated in database (hashed)
- ✅ Logout and login with new password works
- ✅ Old password no longer works

**Test Validation:**
1. Wrong current password → Error
2. Passwords don't match → Match error
3. New password too short → Min length error

---

### ✅ Test 10: Logout

**Steps:**
1. While logged in, click "Logout" in sidebar
2. Or visit: `http://localhost:8000/logout`

**Expected Results:**
- ✅ Redirects to homepage (`/`)
- ✅ Success message: "You have been logged out successfully."
- ✅ Session destroyed
- ✅ Cannot access `/account` (redirects to `/login`)
- ✅ Top navigation shows "Login" button
- ✅ Check browser cookies: session cleared

---

### ✅ Test 11: Protected Routes

**Test Without Login:**
1. Visit: `http://localhost:8000/account`

**Expected Results:**
- ✅ Redirects to `/login`
- ✅ Error message: "Please login to access your account."

**Test After Login:**
1. Login as customer
2. Visit: `http://localhost:8000/account`
- ✅ Page loads successfully

---

### ✅ Test 12: CSRF Protection

**Steps:**
1. Open login form: `http://localhost:8000/login`
2. Open browser dev tools → Elements
3. Find: `<input type="hidden" name="csrf_token" value="...">`
4. Change token value to something random
5. Submit form

**Expected Results:**
- ✅ Error: "Invalid request. Please try again."
- ✅ Redirects back to form
- ✅ Login not processed

---

### ✅ Test 13: Session Persistence

**Steps:**
1. Login successfully
2. Close browser tab
3. Reopen: `http://localhost:8000/account`

**Expected Results:**
- ✅ Still logged in (session persists)
- ✅ User info displays correctly

**Note:** This depends on session configuration. Default PHP sessions expire when browser closes.

---

### ✅ Test 14: Role-Based Redirection

**After Login, Check Redirects:**

| Role | Email | Password | Redirect To |
|------|-------|----------|-------------|
| Admin | admin@adiarifresh.com | admin123 | `/admin` |
| Manager | manager@adiarifresh.com | manager123 | `/manager` |
| Customer | test@example.com | newtest456 | `/account` |

---

## 🔍 Database Verification

### Check User Creation
```sql
USE adiari_grocery;

-- View all users
SELECT id, first_name, last_name, email, role, status, created_at 
FROM users;

-- Check password is hashed
SELECT password FROM users WHERE email = 'test@example.com';
-- Should start with: $2y$12$

-- Check login attempts
SELECT email, login_attempts, last_login_at 
FROM users;
```

### Check Password Reset Tokens
```sql
SELECT email, password_reset_token, password_reset_expires_at 
FROM users 
WHERE password_reset_token IS NOT NULL;
```

---

## 🐛 Common Issues & Solutions

### Issue 1: "Class not found" Error
**Solution:**
- Check file paths in `require_once` statements
- Ensure controller files are in `app/controllers/`
- Verify class names match file names

### Issue 2: Database Connection Error
**Solution:**
- Check `.env` or `config/database.php` credentials
- Ensure MySQL is running
- Test connection: `php test_db.php`

### Issue 3: "Headers already sent" Error
**Solution:**
- Remove any whitespace before `<?php` tags
- Check for `echo` statements before redirects
- Use output buffering if needed

### Issue 4: Sessions Not Working
**Solution:**
- Check session configuration in `config/app.php`
- Ensure `storage/sessions/` directory exists and is writable
- Verify `session_start()` is called in Application.php

### Issue 5: CSRF Token Mismatch
**Solution:**
- Clear browser cache and cookies
- Check session is properly initialized
- Verify `Security::generateToken()` is working

---

## ✅ Success Criteria

Phase 3 is complete when ALL tests pass:

- [x] Homepage loads correctly
- [x] User can register
- [x] User can login
- [x] Account lockout works (5 attempts)
- [x] Password reset works
- [x] User dashboard displays
- [x] Profile editing works
- [x] Password change works
- [x] Logout works
- [x] Protected routes redirect to login
- [x] CSRF protection works
- [x] Sessions persist correctly
- [x] Role-based redirection works
- [x] Database records are correct

---

## 📊 Test Results Template

```
=== PHASE 3 TESTING RESULTS ===
Date: ______________
Tester: ______________

✅ Test 1: Homepage                [ PASS / FAIL ]
✅ Test 2: Registration            [ PASS / FAIL ]
✅ Test 3: Login                   [ PASS / FAIL ]
✅ Test 4: Account Lockout         [ PASS / FAIL ]
✅ Test 5: Forgot Password         [ PASS / FAIL ]
✅ Test 6: Reset Password          [ PASS / FAIL ]
✅ Test 7: User Dashboard          [ PASS / FAIL ]
✅ Test 8: Edit Profile            [ PASS / FAIL ]
✅ Test 9: Change Password         [ PASS / FAIL ]
✅ Test 10: Logout                 [ PASS / FAIL ]
✅ Test 11: Protected Routes       [ PASS / FAIL ]
✅ Test 12: CSRF Protection        [ PASS / FAIL ]
✅ Test 13: Session Persistence    [ PASS / FAIL ]
✅ Test 14: Role-Based Redirect    [ PASS / FAIL ]

Overall Status: [ PASS / FAIL ]

Notes:
_________________________________
_________________________________
```

---

## 🎉 Next Steps

Once all tests pass:
1. ✅ Mark Phase 3 as complete
2. ✅ Document any issues found
3. ✅ Proceed to Phase 4: Product Management

---

**Happy Testing!** 🚀

_Phase 3 Testing Guide_  
_ADI ARI Fresh Vegetables and Halal Food_  
_Last Updated: 2026-02-09_
