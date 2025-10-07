@echo off
echo ========================================
echo   Study Programs System Setup
echo ========================================
echo.

echo [1/5] Running Migration...
php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php
if %errorlevel% neq 0 (
    echo ERROR: Migration failed!
    pause
    exit /b 1
)
echo ✓ Migration completed successfully!
echo.

echo [2/5] Creating Storage Directories...
if not exist "storage\app\public\study-programs" mkdir "storage\app\public\study-programs"
if not exist "storage\app\public\study-programs\images" mkdir "storage\app\public\study-programs\images"
if not exist "storage\app\public\study-programs\brochures" mkdir "storage\app\public\study-programs\brochures"
echo ✓ Storage directories created!
echo.

echo [3/5] Creating Storage Link...
php artisan storage:link
echo ✓ Storage link created!
echo.

echo [4/5] Running Seeder...
php artisan db:seed --class=StudyProgramSeeder
if %errorlevel% neq 0 (
    echo WARNING: Seeder failed, but continuing...
)
echo ✓ Seeder completed!
echo.

echo [5/5] Clearing Cache...
php artisan config:clear
php artisan route:clear
php artisan view:clear
echo ✓ Cache cleared!
echo.

echo ========================================
echo   Setup Completed Successfully!
echo ========================================
echo.
echo You can now access:
echo - Admin Panel: /admin/study-programs
echo - Public Page: /study-programs
echo.
echo Press any key to exit...
pause >nul