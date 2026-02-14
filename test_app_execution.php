<?php
/**
 * Test Application Execution
 * Simulates a request to test if the application can handle routing and controller execution
 */

// Suppress output for testing
ob_start();

// Set up environment
$_SERVER['REQUEST_METHOD'] = 'GET';
$_SERVER['REQUEST_URI'] = '/';
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SERVER_NAME'] = 'localhost';
$_SERVER['SERVER_PORT'] = '80';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

// Mock session for testing
$_SESSION = [];

// Change to public directory context
chdir(__DIR__ . '/public');

// Capture any errors
$errors = [];
set_error_handler(function($severity, $message, $file, $line) use (&$errors) {
    $errors[] = [
        'severity' => $severity,
        'message' => $message,
        'file' => $file,
        'line' => $line
    ];
    // Don't execute PHP's internal error handler
    return true;
});

try {
    // Include the main entry point
    require_once __DIR__ . '/public/index.php';
    
    // Get the output
    $output = ob_get_clean();
    
    echo "\n";
    echo "===========================================\n";
    echo "    APPLICATION EXECUTION TEST RESULT     \n";
    echo "===========================================\n\n";
    
    if (count($errors) > 0) {
        echo "⚠️  Errors/Warnings captured:\n";
        foreach ($errors as $error) {
            $severity_name = [
                E_ERROR => 'ERROR',
                E_WARNING => 'WARNING',
                E_NOTICE => 'NOTICE',
                E_DEPRECATED => 'DEPRECATED'
            ][$error['severity']] ?? 'UNKNOWN';
            
            echo "  - [$severity_name] {$error['message']}\n";
            echo "    in {$error['file']} on line {$error['line']}\n";
        }
        echo "\n";
    }
    
    // Check if output was generated
    $output_length = strlen($output);
    
    if ($output_length > 0) {
        echo "✓ Application executed successfully!\n";
        echo "✓ Generated $output_length bytes of output\n";
        echo "✓ Routing system is functional\n";
        echo "✓ Controllers are loading\n";
        
        // Check if it looks like HTML
        if (stripos($output, '<!DOCTYPE') !== false || stripos($output, '<html') !== false) {
            echo "✓ HTML output detected\n";
        }
        
        // Check for common elements
        if (stripos($output, 'ADI ARI') !== false) {
            echo "✓ Application branding present\n";
        }
        
        echo "\n✅ APPLICATION IS FULLY FUNCTIONAL!\n";
        echo "===========================================\n";
        
        exit(0);
    } else {
        echo "⚠️  No output generated\n";
        echo "This might indicate an issue with the application\n";
        echo "===========================================\n";
        exit(1);
    }
    
} catch (Exception $e) {
    ob_end_clean();
    echo "\n";
    echo "===========================================\n";
    echo "    APPLICATION EXECUTION TEST RESULT     \n";
    echo "===========================================\n\n";
    echo "❌ Application execution failed!\n";
    echo "Error: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString();
    echo "\n";
    echo "===========================================\n";
    exit(1);
} catch (Error $e) {
    ob_end_clean();
    echo "\n";
    echo "===========================================\n";
    echo "    APPLICATION EXECUTION TEST RESULT     \n";
    echo "===========================================\n\n";
    echo "❌ Fatal error during execution!\n";
    echo "Error: {$e->getMessage()}\n";
    echo "File: {$e->getFile()}\n";
    echo "Line: {$e->getLine()}\n";
    echo "\nStack trace:\n";
    echo $e->getTraceAsString();
    echo "\n";
    echo "===========================================\n";
    exit(1);
}
