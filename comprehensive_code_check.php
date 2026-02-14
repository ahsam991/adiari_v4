<?php
/**
 * Comprehensive Code Execution Check
 * Tests all code can be loaded and executed properly without errors
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

define('ROOT_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

$results = [
    'passed' => 0,
    'failed' => 0,
    'warnings' => 0,
    'tests' => []
];

function test($name, $callback) {
    global $results;
    try {
        $result = $callback();
        if ($result['status'] === 'pass') {
            $results['passed']++;
            echo "✓ PASS: $name\n";
        } elseif ($result['status'] === 'warning') {
            $results['warnings']++;
            echo "⚠ WARN: $name - {$result['message']}\n";
        } else {
            $results['failed']++;
            echo "✗ FAIL: $name - {$result['message']}\n";
        }
        $results['tests'][] = ['name' => $name, 'status' => $result['status'], 'message' => $result['message'] ?? ''];
    } catch (Exception $e) {
        $results['failed']++;
        echo "✗ FAIL: $name - Exception: {$e->getMessage()}\n";
        $results['tests'][] = ['name' => $name, 'status' => 'fail', 'message' => $e->getMessage()];
    } catch (Error $e) {
        $results['failed']++;
        echo "✗ FAIL: $name - Error: {$e->getMessage()}\n";
        $results['tests'][] = ['name' => $name, 'status' => 'fail', 'message' => $e->getMessage()];
    }
}

echo "\n=== COMPREHENSIVE CODE EXECUTION CHECK ===\n\n";

// ============================================
// 1. PHP SYNTAX CHECK FOR ALL FILES
// ============================================
echo "1. PHP SYNTAX CHECK\n";
echo "-------------------\n";

$php_files = [];
exec("find " . escapeshellarg(ROOT_PATH . '/app') . " -name '*.php' -type f", $php_files);
exec("find " . escapeshellarg(ROOT_PATH . '/config') . " -name '*.php' -type f", $config_files);
exec("find " . escapeshellarg(ROOT_PATH . '/routes') . " -name '*.php' -type f", $route_files);

$php_files = array_merge($php_files, $config_files, $route_files);

$syntax_errors = 0;
$syntax_checked = 0;

foreach ($php_files as $file) {
    $output = [];
    $return_code = 0;
    exec("php -l " . escapeshellarg($file) . " 2>&1", $output, $return_code);
    $syntax_checked++;
    
    if ($return_code !== 0) {
        $syntax_errors++;
        echo "  ✗ Syntax error in: " . str_replace(ROOT_PATH . '/', '', $file) . "\n";
    }
}

if ($syntax_errors === 0) {
    $results['passed']++;
    echo "✓ PASS: All $syntax_checked PHP files have valid syntax\n\n";
} else {
    $results['failed']++;
    echo "✗ FAIL: Found $syntax_errors syntax errors in $syntax_checked files\n\n";
}

// ============================================
// 2. CONFIGURATION FILES CHECK
// ============================================
echo "2. CONFIGURATION FILES\n";
echo "----------------------\n";

test("Load app config", function() {
    if (!file_exists(ROOT_PATH . '/config/app.php')) {
        return ['status' => 'fail', 'message' => 'config/app.php not found'];
    }
    $config = require ROOT_PATH . '/config/app.php';
    if (!is_array($config)) {
        return ['status' => 'fail', 'message' => 'Config is not an array'];
    }
    return ['status' => 'pass', 'message' => 'App config loaded'];
});

test("Load database config", function() {
    if (!file_exists(ROOT_PATH . '/config/database.php')) {
        return ['status' => 'fail', 'message' => 'config/database.php not found'];
    }
    $config = require ROOT_PATH . '/config/database.php';
    if (!is_array($config)) {
        return ['status' => 'fail', 'message' => 'Config is not an array'];
    }
    if (!isset($config['grocery']) || !isset($config['inventory']) || !isset($config['analytics'])) {
        return ['status' => 'fail', 'message' => 'Missing database configurations'];
    }
    return ['status' => 'pass', 'message' => 'Database config loaded'];
});

echo "\n";

// ============================================
// 3. CORE CLASSES CHECK
// ============================================
echo "3. CORE CLASSES\n";
echo "---------------\n";

$core_classes = [
    'Database' => 'app/core/Database.php',
    'Router' => 'app/core/Router.php',
    'Controller' => 'app/core/Controller.php',
    'Model' => 'app/core/Model.php',
    'View' => 'app/core/View.php',
    'Application' => 'app/core/Application.php'
];

foreach ($core_classes as $class => $file) {
    test("Load Core: $class", function() use ($class, $file) {
        $path = ROOT_PATH . '/' . $file;
        if (!file_exists($path)) {
            return ['status' => 'fail', 'message' => "$file not found"];
        }
        
        // Try to include the file
        require_once $path;
        
        // Check if class exists
        if (!class_exists($class, false)) {
            return ['status' => 'fail', 'message' => "Class $class not defined in file"];
        }
        
        return ['status' => 'pass', 'message' => "Class $class loaded"];
    });
}

echo "\n";

// ============================================
// 4. HELPER CLASSES CHECK
// ============================================
echo "4. HELPER CLASSES\n";
echo "-----------------\n";

$helper_classes = [
    'Security' => 'app/helpers/Security.php',
    'Session' => 'app/helpers/Session.php',
    'Logger' => 'app/helpers/Logger.php',
    'Validation' => 'app/helpers/Validation.php',
    'Language' => 'app/helpers/Language.php',
    'RateLimit' => 'app/helpers/RateLimit.php'
];

foreach ($helper_classes as $class => $file) {
    test("Load Helper: $class", function() use ($class, $file) {
        $path = ROOT_PATH . '/' . $file;
        if (!file_exists($path)) {
            return ['status' => 'fail', 'message' => "$file not found"];
        }
        
        require_once $path;
        
        if (!class_exists($class, false)) {
            return ['status' => 'fail', 'message' => "Class $class not defined"];
        }
        
        return ['status' => 'pass', 'message' => "Class $class loaded"];
    });
}

echo "\n";

// ============================================
// 5. MIDDLEWARE CLASSES CHECK
// ============================================
echo "5. MIDDLEWARE CLASSES\n";
echo "---------------------\n";

$middleware_classes = [
    'AuthMiddleware' => 'app/middleware/AuthMiddleware.php',
    'RoleMiddleware' => 'app/middleware/RoleMiddleware.php',
    'CSRFMiddleware' => 'app/middleware/CSRFMiddleware.php'
];

foreach ($middleware_classes as $class => $file) {
    test("Load Middleware: $class", function() use ($class, $file) {
        $path = ROOT_PATH . '/' . $file;
        if (!file_exists($path)) {
            return ['status' => 'fail', 'message' => "$file not found"];
        }
        
        require_once $path;
        
        if (!class_exists($class, false)) {
            return ['status' => 'fail', 'message' => "Class $class not defined"];
        }
        
        return ['status' => 'pass', 'message' => "Class $class loaded"];
    });
}

echo "\n";

// ============================================
// 6. MODEL CLASSES CHECK
// ============================================
echo "6. MODEL CLASSES\n";
echo "----------------\n";

$model_files = glob(ROOT_PATH . '/app/models/*.php');
foreach ($model_files as $file) {
    $className = basename($file, '.php');
    test("Load Model: $className", function() use ($className, $file) {
        require_once $file;
        
        if (!class_exists($className, false)) {
            return ['status' => 'fail', 'message' => "Class $className not defined"];
        }
        
        return ['status' => 'pass', 'message' => "Class $className loaded"];
    });
}

echo "\n";

// ============================================
// 7. CONTROLLER CLASSES CHECK
// ============================================
echo "7. CONTROLLER CLASSES\n";
echo "---------------------\n";

$controller_files = glob(ROOT_PATH . '/app/controllers/*.php');
foreach ($controller_files as $file) {
    $className = basename($file, '.php');
    test("Load Controller: $className", function() use ($className, $file) {
        require_once $file;
        
        if (!class_exists($className, false)) {
            return ['status' => 'fail', 'message' => "Class $className not defined"];
        }
        
        return ['status' => 'pass', 'message' => "Class $className loaded"];
    });
}

echo "\n";

// ============================================
// 8. ROUTES FILE CHECK
// ============================================
echo "8. ROUTES FILE\n";
echo "--------------\n";

test("Load routes/web.php", function() {
    $routes_file = ROOT_PATH . '/routes/web.php';
    if (!file_exists($routes_file)) {
        return ['status' => 'fail', 'message' => 'routes/web.php not found'];
    }
    
    $content = file_get_contents($routes_file);
    
    // Count routes
    preg_match_all("/\\\$router->(get|post|put|delete)/", $content, $matches);
    $route_count = count($matches[0]);
    
    if ($route_count === 0) {
        return ['status' => 'warning', 'message' => 'No routes defined'];
    }
    
    return ['status' => 'pass', 'message' => "Found $route_count routes"];
});

echo "\n";

// ============================================
// 9. VIEW FILES CHECK
// ============================================
echo "9. VIEW FILES\n";
echo "-------------\n";

$view_dirs = [
    'app/views/home',
    'app/views/auth',
    'app/views/products',
    'app/views/cart',
    'app/views/checkout',
    'app/views/orders',
    'app/views/user',
    'app/views/admin',
    'app/views/manager',
    'app/views/layouts'
];

foreach ($view_dirs as $dir) {
    test("Check view directory: $dir", function() use ($dir) {
        $path = ROOT_PATH . '/' . $dir;
        if (!is_dir($path)) {
            return ['status' => 'fail', 'message' => 'Directory not found'];
        }
        
        $view_count = count(glob($path . '/*.php'));
        
        if ($view_count === 0) {
            return ['status' => 'warning', 'message' => 'No view files found'];
        }
        
        return ['status' => 'pass', 'message' => "Found $view_count view files"];
    });
}

echo "\n";

// ============================================
// 10. LANGUAGE FILES CHECK
// ============================================
echo "10. LANGUAGE FILES\n";
echo "------------------\n";

$languages = ['en', 'bn', 'ja', 'ne'];
foreach ($languages as $lang) {
    test("Check language: $lang", function() use ($lang) {
        $lang_dir = ROOT_PATH . "/app/lang/$lang";
        if (!is_dir($lang_dir)) {
            return ['status' => 'warning', 'message' => 'Directory not found'];
        }
        
        $file_count = count(glob($lang_dir . '/*.php'));
        
        if ($file_count === 0) {
            return ['status' => 'warning', 'message' => 'No translation files'];
        }
        
        return ['status' => 'pass', 'message' => "Found $file_count translation files"];
    });
}

echo "\n";

// ============================================
// 11. PUBLIC DIRECTORY CHECK
// ============================================
echo "11. PUBLIC DIRECTORY\n";
echo "--------------------\n";

test("Check public/index.php", function() {
    $index_file = ROOT_PATH . '/public/index.php';
    if (!file_exists($index_file)) {
        return ['status' => 'fail', 'message' => 'public/index.php not found'];
    }
    
    $content = file_get_contents($index_file);
    if (strpos($content, 'Application') === false) {
        return ['status' => 'fail', 'message' => 'index.php does not bootstrap Application'];
    }
    
    return ['status' => 'pass', 'message' => 'Entry point exists and bootstraps app'];
});

test("Check public/css directory", function() {
    if (!is_dir(ROOT_PATH . '/public/css')) {
        return ['status' => 'warning', 'message' => 'CSS directory not found'];
    }
    return ['status' => 'pass', 'message' => 'CSS directory exists'];
});

test("Check public/js directory", function() {
    if (!is_dir(ROOT_PATH . '/public/js')) {
        return ['status' => 'warning', 'message' => 'JS directory not found'];
    }
    return ['status' => 'pass', 'message' => 'JS directory exists'];
});

test("Check public/uploads directory", function() {
    $uploads_dir = ROOT_PATH . '/public/uploads';
    if (!is_dir($uploads_dir)) {
        // Try to create it
        if (@mkdir($uploads_dir, 0755, true)) {
            return ['status' => 'pass', 'message' => 'Created uploads directory'];
        }
        return ['status' => 'warning', 'message' => 'Directory not found and could not be created'];
    }
    
    if (!is_writable($uploads_dir)) {
        return ['status' => 'warning', 'message' => 'Directory not writable'];
    }
    
    return ['status' => 'pass', 'message' => 'Directory exists and is writable'];
});

echo "\n";

// ============================================
// 12. LOGS DIRECTORY CHECK
// ============================================
echo "12. LOGS DIRECTORY\n";
echo "------------------\n";

test("Check logs directory", function() {
    $logs_dir = ROOT_PATH . '/logs';
    if (!is_dir($logs_dir)) {
        // Try to create it
        if (@mkdir($logs_dir, 0755, true)) {
            return ['status' => 'pass', 'message' => 'Created logs directory'];
        }
        return ['status' => 'warning', 'message' => 'Directory not found and could not be created'];
    }
    
    if (!is_writable($logs_dir)) {
        return ['status' => 'warning', 'message' => 'Directory not writable'];
    }
    
    return ['status' => 'pass', 'message' => 'Directory exists and is writable'];
});

echo "\n";

// ============================================
// 13. DATABASE DIRECTORY CHECK
// ============================================
echo "13. DATABASE DIRECTORY\n";
echo "----------------------\n";

test("Check database directory", function() {
    if (!is_dir(ROOT_PATH . '/database')) {
        return ['status' => 'warning', 'message' => 'Database directory not found'];
    }
    
    $sql_files = glob(ROOT_PATH . '/database/*.sql');
    $migration_files = glob(ROOT_PATH . '/database/migrations/*.sql');
    
    $total_files = count($sql_files) + count($migration_files);
    
    return ['status' => 'pass', 'message' => "Found $total_files SQL files"];
});

echo "\n";

// ============================================
// SUMMARY
// ============================================
echo "\n";
echo "===========================================\n";
echo "          EXECUTION CHECK SUMMARY          \n";
echo "===========================================\n";
echo "✓ Passed:   {$results['passed']}\n";
echo "⚠ Warnings: {$results['warnings']}\n";
echo "✗ Failed:   {$results['failed']}\n";
echo "-------------------------------------------\n";

$total = $results['passed'] + $results['warnings'] + $results['failed'];
$success_rate = $total > 0 ? round(($results['passed'] / $total) * 100, 2) : 0;

echo "Success Rate: $success_rate%\n";
echo "===========================================\n\n";

if ($results['failed'] === 0) {
    echo "🎉 ALL CRITICAL TESTS PASSED!\n";
    echo "Your code can execute without errors.\n";
    
    if ($results['warnings'] > 0) {
        echo "\n⚠️  There are {$results['warnings']} warnings that should be addressed.\n";
    }
} else {
    echo "❌ SOME TESTS FAILED!\n";
    echo "Please fix the failed tests before deploying.\n";
}

echo "\n";

// Exit with appropriate code
exit($results['failed'] > 0 ? 1 : 0);
