<?php
/**
 * ADMIN PASSWORD CHANGE SCRIPT
 * Run this ONCE after deployment to change default admin password
 * DELETE THIS FILE after changing the password!
 */

session_start();

// Load database configuration
require_once __DIR__ . '/config/database.php';
$dbConfig = require __DIR__ . '/config/database.php';

// Database connection
try {
    $dsn = "mysql:host={$dbConfig['grocery']['host']};dbname={$dbConfig['grocery']['dbname']};charset=utf8mb4";
    $pdo = new PDO($dsn, $dbConfig['grocery']['username'], $dbConfig['grocery']['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validation
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'All fields are required';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Passwords do not match';
    } elseif (strlen($newPassword) < 8) {
        $error = 'Password must be at least 8 characters';
    } else {
        // Hash the new password
        $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);
        
        // Update in database
        $stmt = $pdo->prepare("UPDATE users SET password_hash = ? WHERE email = ? AND role IN ('admin', 'manager')");
        $result = $stmt->execute([$passwordHash, $email]);
        
        if ($stmt->rowCount() > 0) {
            $success = true;
        } else {
            $error = 'User not found or not authorized';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Admin Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #2c5f2d 0%, #4a7c59 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }
        
        h1 {
            color: #2c5f2d;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 15px;
            transition: border-color 0.3s;
        }
        
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #2c5f2d;
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: #2c5f2d;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        button:hover {
            background: #1e4620;
        }
        
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }
        
        .default-credentials {
            background: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #2196f3;
        }
        
        .default-credentials h3 {
            color: #1976d2;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .default-credentials p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .warning-box {
            background: #ffebee;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
            border-left: 4px solid #f44336;
        }
        
        .warning-box strong {
            color: #c62828;
            display: block;
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔐 Change Admin Password</h1>
        <p class="subtitle">Update default passwords after deployment</p>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <strong>✅ Success!</strong><br>
                Password changed successfully!<br>
                <br>
                <strong>IMPORTANT:</strong> Delete this file (change-admin-password.php) now!
            </div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <strong>❌ Error:</strong><br>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <div class="default-credentials">
            <h3>📧 Default Admin Emails:</h3>
            <p><strong>Admin:</strong> admin@adiarifresh.com</p>
            <p><strong>Manager:</strong> manager@adiarifresh.com</p>
            <p><em>Default password for both: admin123</em></p>
        </div>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email Address</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="admin@adiarifresh.com"
                    required
                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                >
            </div>
            
            <div class="form-group">
                <label for="new_password">New Password (min 8 characters)</label>
                <input 
                    type="password" 
                    id="new_password" 
                    name="new_password" 
                    placeholder="Enter new password"
                    required
                    minlength="8"
                >
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input 
                    type="password" 
                    id="confirm_password" 
                    name="confirm_password" 
                    placeholder="Confirm new password"
                    required
                    minlength="8"
                >
            </div>
            
            <button type="submit">Change Password</button>
        </form>
        
        <div class="warning-box">
            <strong>⚠️ SECURITY WARNING</strong>
            After changing the password, DELETE this file immediately!<br>
            File path: /public_html/change-admin-password.php
        </div>
        
        <div class="footer">
            ADI ARI Fresh Vegetables & Halal Food<br>
            Deployment Security Tool
        </div>
    </div>
</body>
</html>
