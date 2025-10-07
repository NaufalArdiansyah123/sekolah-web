@echo off
echo Clearing Laravel caches...

php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan cache:clear

echo.
echo Regenerating autoloader...
composer dump-autoload

echo.
echo Caching for optimization...
php artisan config:cache
php artisan view:cache

echo.
echo Cache clearing completed!
echo Please refresh your browser with Ctrl+F5

pause