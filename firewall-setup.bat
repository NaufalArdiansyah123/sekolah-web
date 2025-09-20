@echo off
echo ========================================
echo    SETUP WINDOWS FIREWALL FOR MOBILE
echo ========================================
echo.
echo Membuka port 8000 untuk akses mobile...
echo.

REM Add firewall rule for Laravel server port 8000
netsh advfirewall firewall add rule name="Laravel Server Port 8000" dir=in action=allow protocol=TCP localport=8000

echo.
echo ========================================
echo Firewall rule berhasil ditambahkan!
echo.
echo Port 8000 sekarang terbuka untuk:
echo - TCP connections
echo - Inbound traffic
echo - All network profiles
echo.
echo Sekarang Anda bisa:
echo 1. Jalankan: start-mobile-server.bat
echo 2. Akses dari HP: http://192.168.100.101:8000
echo ========================================
echo.
pause