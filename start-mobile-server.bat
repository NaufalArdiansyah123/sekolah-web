@echo off
echo ========================================
echo    STARTING LARAVEL SERVER FOR MOBILE
echo ========================================
echo.
echo IP Laptop: 192.168.100.101
echo Port: 8000
echo.
echo Akses dari HP: http://192.168.100.101:8000
echo.
echo ========================================

REM Clear Laravel cache first
echo Clearing Laravel cache...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

echo.
echo Starting Laravel server...
echo Server akan berjalan di: http://192.168.100.101:8000
echo.
echo PENTING:
echo 1. Pastikan HP dan laptop terhubung WiFi yang sama
echo 2. Buka Windows Firewall untuk port 8000
echo 3. Akses dari HP: http://192.168.100.101:8000
echo.
echo Tekan Ctrl+C untuk stop server
echo ========================================

REM Start Laravel server with host 0.0.0.0 to allow external access
php artisan serve --host=0.0.0.0 --port=8000