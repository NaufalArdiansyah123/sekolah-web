# 🔧 DATABASE CONNECTION FIX GUIDE

## Problem
```
Error! Database configuration issue detected. The status column needs to be repaired.
```

This error indicates that Laravel cannot connect to the database or the database schema is incorrect.

## 🚀 QUICK SOLUTIONS

### Step 1: Check XAMPP MySQL Service
1. **Open XAMPP Control Panel**
2. **Start MySQL service** (click "Start" button next to MySQL)
3. **Verify MySQL is running** (should show "Running" status)

### Step 2: Run Quick Database Fix
```bash
php quick_db_fix.php
```

### Step 3: Clear Laravel Caches
```bash
php artisan config:clear
php artisan cache:clear
```

### Step 4: Test Database Connection
```bash
php test_database_connection.php
```

## 🔍 DETAILED TROUBLESHOOTING

### Check 1: XAMPP MySQL Status
- Open XAMPP Control Panel
- MySQL should show "Running" status
- If not running, click "Start"

### Check 2: Database Configuration (.env)
Your current config:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah-web6
DB_USERNAME=root
DB_PASSWORD=
```

### Check 3: Database Exists
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Check if database `sekolah-web6` exists
3. If not, create it:
   ```sql
   CREATE DATABASE `sekolah-web6` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

### Check 4: Facilities Table
1. In phpMyAdmin, select `sekolah-web6` database
2. Check if `facilities` table exists
3. If not, run migrations:
   ```bash
   php artisan migrate
   ```

### Check 5: Status Column
1. In phpMyAdmin, check `facilities` table structure
2. Look for `status` column
3. Should be: `ENUM('active','maintenance','inactive')`
4. If wrong or missing, run:
   ```sql
   ALTER TABLE facilities DROP COLUMN status;
   ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active';
   ```

## 🛠️ COMMON FIXES

### Fix 1: XAMPP Not Running
```bash
# Start XAMPP services
# Open XAMPP Control Panel
# Click "Start" for Apache and MySQL
```

### Fix 2: Database Doesn't Exist
```sql
-- In phpMyAdmin or MySQL command line:
CREATE DATABASE `sekolah-web6` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Fix 3: Tables Don't Exist
```bash
php artisan migrate
```

### Fix 4: Status Column Wrong
```sql
-- In phpMyAdmin:
ALTER TABLE facilities DROP COLUMN status;
ALTER TABLE facilities ADD COLUMN status ENUM('active', 'maintenance', 'inactive') DEFAULT 'active';
```

### Fix 5: Laravel Cache Issues
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Fix 6: Host Connection Issues
Try changing in `.env`:
```
# From:
DB_HOST=127.0.0.1

# To:
DB_HOST=localhost
```

## 🧪 TESTING

### Test 1: MySQL Connection
```bash
mysql -u root -p
# (press Enter for empty password)
SHOW DATABASES;
USE sekolah-web6;
SHOW TABLES;
```

### Test 2: Laravel Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo();
>>> DB::table('facilities')->count();
```

### Test 3: Facility Creation
Try creating a facility through the web interface.

## 📋 STEP-BY-STEP CHECKLIST

- [ ] XAMPP MySQL service is running
- [ ] Database `sekolah-web6` exists
- [ ] Laravel caches cleared
- [ ] Migrations run successfully
- [ ] `facilities` table exists
- [ ] `status` column has correct ENUM type
- [ ] Laravel can connect to database
- [ ] Facility creation works

## 🚨 IF NOTHING WORKS

### Last Resort Solutions:

1. **Recreate Database:**
   ```sql
   DROP DATABASE IF EXISTS `sekolah-web6`;
   CREATE DATABASE `sekolah-web6` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. **Fresh Migration:**
   ```bash
   php artisan migrate:fresh
   ```

3. **Check Laravel Logs:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

4. **Restart XAMPP:**
   - Stop all XAMPP services
   - Close XAMPP Control Panel
   - Restart XAMPP
   - Start Apache and MySQL

## 🎯 SUCCESS INDICATORS

You'll know it's fixed when:
- ✅ XAMPP shows MySQL as "Running"
- ✅ phpMyAdmin opens without errors
- ✅ Database `sekolah-web6` is visible
- ✅ `facilities` table exists with correct structure
- ✅ Laravel connects to database without errors
- ✅ Facility creation works in web interface

---

**Follow these steps in order and your database will be working!** 🚀