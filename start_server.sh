#!/bin/bash

# Configuration
PROJECT_DIR="/Users/ahsam/Downloads/adiari_v4"
XAMPP_MYSQL_START="/Applications/XAMPP/xamppfiles/bin/mysql.server start"
XAMPP_MYSQL_CHECK="/Applications/XAMPP/xamppfiles/bin/mysqladmin ping"
PHP_CMD="php"
PORT=8000

echo "================================================"
echo "    ADI ARI GROCERY ECOMMERCE (macOS)"
echo "    Development Server Launcher"
echo "================================================"
echo ""

# Check if port 3306 is open (MySQL running)
if lsof -i :3306 > /dev/null; then
    echo "[OK] MySQL is running on port 3306"
else
    echo "[WARNING] MySQL does not seem to be running on port 3306."
    echo "Attempting to start XAMPP MySQL..."
    
    if [ -f "/Applications/XAMPP/xamppfiles/bin/mysql.server" ]; then
        echo "Please enter your password if prompted to start MySQL via sudo:"
        sudo $XAMPP_MYSQL_START
        
        # Wait for MySQL to start
        sleep 3
        
        if lsof -i :3306 > /dev/null; then
            echo "[OK] MySQL started successfully."
        else
            echo "[ERROR] Failed to start MySQL automatically."
            echo "Please open XAMPP Control Panel and start MySQL manually."
        fi
    else
        echo "[ERROR] XAMPP MySQL script not found."
        echo "Please ensure MySQL is running (via XAMPP, MAMP, or Homebrew)."
    fi
fi

echo ""
echo "[2/3] Starting PHP Development Server..."
echo "  Server URL: http://localhost:$PORT"
echo "  Document Root: public"
echo ""

# Start PHP server
$PHP_CMD -S localhost:$PORT -t public &
PHP_PID=$!

echo "[OK] PHP server started (PID: $PHP_PID)"
echo ""

# Open browser
echo "[3/3] Opening website..."
sleep 2
open "http://localhost:$PORT"

echo ""
echo "================================================"
echo "  ADI ARI GROCERY ECOMMERCE IS RUNNING!"
echo "================================================"
echo ""
echo "  Website:      http://localhost:$PORT"
echo "  Admin Panel:  http://localhost:$PORT/admin"
echo ""
echo "Press Ctrl+C to stop the server."

# Wait for PHP server to exit
wait $PHP_PID
