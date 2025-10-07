@echo off
echo Fixing storage link for images...

echo.
echo Running storage link fix script...
php fix_storage_link.php

echo.
echo Running Laravel storage link command...
php artisan storage:link

echo.
echo Clearing caches...
php artisan cache:clear
php artisan view:clear

echo.
echo Storage fix completed!
echo Please test the facilities page now.

pause