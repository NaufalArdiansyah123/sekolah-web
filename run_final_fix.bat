@echo off
echo ========================================
echo    FACILITIES TABLE FINAL FIX
echo ========================================
echo.
echo This will fix the sort_order column error
echo and update the code to handle missing columns.
echo.
pause
echo.
echo Running fix...
php final_facilities_fix.php
echo.
echo ========================================
echo Fix completed! Check the output above.
echo ========================================
pause