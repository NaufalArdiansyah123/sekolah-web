@echo off
echo Menjalankan script perbaikan migration...
php fix_migration.php
echo.
echo Menjalankan migration...
php artisan migrate
echo.
echo Selesai!
pause