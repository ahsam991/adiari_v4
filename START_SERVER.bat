@echo off
TITLE ADI ARI Grocery Ecommerce - Start Server
COLOR 0A
echo.
echo ================================================
echo     ADI ARI GROCERY ECOMMERCE
echo     Development Server Launcher
echo ================================================
echo.

REM Check if XAMPP MySQL is running
echo [1/3] Checking MySQL service...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo   [OK] MySQL is running
) else (
    echo   [WARNING] MySQL is not running
    echo   Please start MySQL from XAMPP Control Panel first!
    echo.
    pause
    exit /b 1
)

echo.
echo [2/3] Starting PHP Development Server...
echo   Server URL: http://localhost:8000
echo   Document Root: public
echo.

REM Start PHP server in a new window
start "ADI ARI PHP Server" /MIN C:\xampp\php\php.exe -S localhost:8000 -t public

echo [OK] PHP server started in background
echo.
echo [3/3] Opening website in default browser...
timeout /t 2 /nobreak >nul

REM Open browser
start http://localhost:8000

echo.
echo ================================================
echo   ADI ARI GROCERY ECOMMERCE IS RUNNING!
echo ================================================
echo.
echo   Website:      http://localhost:8000
echo   Admin Panel:  http://localhost:8000/admin
echo   Manager Panel: http://localhost:8000/manager
echo.
echo   Admin Login:
echo     Email: admin@adiarifresh.com
echo     Pass:  admin123
echo.
echo   Manager Login:
echo     Email: manager@adiarifresh.com
echo     Pass:  manager123
echo.
echo   Press Ctrl+C to stop the server when done.
echo.
echo ================================================
echo.
pause
