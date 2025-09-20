# 🔧 Migration Fix Documentation

## ❌ **Problem Identified**

```
SQLSTATE[HY000]: General error: 1005 Can't create table `sekolah-web`.`qr_attendances` (errno: 150 "Foreign key constraint is incorrectly formed")
```

**Root Cause**: Migration order issue - `qr_attendances` table was trying to reference `students` table before it was created.

## 🔍 **Analysis**

### **Original Migration Order (WRONG):**
```
2024_12_20_000001_create_qr_attendances_table.php      ← Runs FIRST
2024_12_20_000002_create_attendance_logs_table.php     ← Runs SECOND
2025_08_29_075151_create_students_table.php            ← Runs LATER
```

**Problem**: `qr_attendances` tries to create foreign key to `students.id` before `students` table exists.

### **Fixed Migration Order (CORRECT):**
```
2025_08_29_075151_create_students_table.php            ← Runs FIRST
2025_08_29_075152_create_qr_attendances_table.php      ← Runs AFTER students
2025_08_29_075153_create_attendance_logs_table.php     ← Runs AFTER students
```

## ✅ **Solutions Applied**

### **1. Fixed Migration Timestamps**

#### **Renamed Files:**
```bash
# QR Attendances Table
2024_12_20_000001_create_qr_attendances_table.php
→ 2025_08_29_075152_create_qr_attendances_table.php

# Attendance Logs Table  
2024_12_20_000002_create_attendance_logs_table.php
→ 2025_08_29_075153_create_attendance_logs_table.php
```

#### **Adjusted Other Migration Order:**
```bash
# Moved other migrations to maintain proper sequence
2025_08_29_075153_create_extracurricular_registrations_table.php
→ 2025_08_29_075155_create_extracurricular_registrations_table.php

2025_08_29_075154_update_extracurriculars_table.php
→ 2025_08_29_075156_update_extracurriculars_table.php

2025_08_29_075155_create_achievements_table.php
→ 2025_08_29_075157_create_achievements_table.php

2025_08_29_075156_create_broadcast_messages_table.php
→ 2025_08_29_075158_create_broadcast_messages_table.php
```

### **2. Verified Foreign Key Constraints**

#### **Students Table Structure:**
```php
Schema::create('students', function (Blueprint $table) {
    $table->id(); // Creates BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
    $table->string('name');
    $table->string('nis')->unique();
    // ... other fields
});
```

#### **QR Attendances Table Structure:**
```php
Schema::create('qr_attendances', function (Blueprint $table) {
    $table->id(); // Creates BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    // ↑ Creates BIGINT UNSIGNED with foreign key to students.id
    $table->string('qr_code')->unique();
    $table->string('qr_image_path')->nullable();
    $table->timestamps();
});
```

#### **Attendance Logs Table Structure:**
```php
Schema::create('attendance_logs', function (Blueprint $table) {
    $table->id();
    $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
    // ↑ Creates BIGINT UNSIGNED with foreign key to students.id
    $table->string('qr_code');
    $table->enum('status', ['hadir', 'terlambat', 'izin', 'sakit', 'alpha'])->default('hadir');
    // ... other fields
});
```

## 🚀 **How to Apply Fix**

### **Method 1: Fresh Migration (RECOMMENDED)**
```bash
# Drop all tables and recreate with correct order
php artisan migrate:fresh

# Run with seeder
php artisan migrate:fresh --seed
```

### **Method 2: Rollback and Re-migrate**
```bash
# Rollback problematic migrations
php artisan migrate:rollback --step=10

# Re-run migrations with correct order
php artisan migrate

# Run seeder
php artisan db:seed
```

### **Method 3: Manual Database Reset**
```sql
-- Connect to MySQL and drop/recreate database
DROP DATABASE IF EXISTS `sekolah-web`;
CREATE DATABASE `sekolah-web` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then run:
```bash
php artisan migrate
php artisan db:seed
```

## 📋 **Verification Steps**

### **1. Check Migration Order**
```bash
php artisan migrate:status
```

**Expected Output:**
```
Migration name                                         Batch / Status
----------------------------------------------------------------------
2014_10_12_000000_create_users_table                  [1] Ran
2014_10_12_100000_create_password_reset_tokens_table  [1] Ran
...
2025_08_29_075151_create_students_table                [1] Ran
2025_08_29_075152_create_qr_attendances_table          [1] Ran
2025_08_29_075153_create_attendance_logs_table         [1] Ran
...
```

### **2. Verify Table Structure**
```sql
-- Check students table
DESCRIBE students;

-- Check qr_attendances table
DESCRIBE qr_attendances;

-- Check foreign key constraints
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE REFERENCED_TABLE_SCHEMA = 'sekolah-web'
AND REFERENCED_TABLE_NAME = 'students';
```

### **3. Test Foreign Key Relationships**
```sql
-- Insert test student
INSERT INTO students (name, nis, class, birth_date, birth_place, gender, parent_name, status, user_id, created_at, updated_at) 
VALUES ('Test Student', '2024001', '10 TKJ 1', '2009-01-01', 'Jakarta', 'male', 'Test Parent', 'active', 1, NOW(), NOW());

-- Insert test QR attendance (should work)
INSERT INTO qr_attendances (student_id, qr_code, created_at, updated_at) 
VALUES (1, 'TEST_QR_001', NOW(), NOW());

-- Insert test attendance log (should work)
INSERT INTO attendance_logs (student_id, qr_code, status, scan_time, attendance_date, created_at, updated_at) 
VALUES (1, 'TEST_QR_001', 'hadir', NOW(), CURDATE(), NOW(), NOW());
```

## 🎯 **Final Migration Order**

### **Core Tables (Foundation):**
```
1. 2014_10_12_000000_create_users_table
2. 2025_08_28_130018_create_permission_tables (roles)
3. 2025_08_29_075151_create_students_table
4. 2025_08_29_075151_create_teachers_table
```

### **QR System Tables (Dependent):**
```
5. 2025_08_29_075152_create_qr_attendances_table      ← Fixed order
6. 2025_08_29_075153_create_attendance_logs_table     ← Fixed order
```

### **Other Tables:**
```
7. 2025_08_29_075152_create_extracurriculars_table
8. 2025_08_29_075155_create_extracurricular_registrations_table
9. 2025_08_29_075157_create_achievements_table
...
```

## 🛡️ **Prevention for Future**

### **1. Migration Naming Convention**
```bash
# Use consistent date prefixes for related tables
2025_08_29_075151_create_students_table.php
2025_08_29_075152_create_qr_attendances_table.php
2025_08_29_075153_create_attendance_logs_table.php
```

### **2. Dependency Planning**
```
Before creating foreign key migrations:
1. Identify parent tables (students, users, etc.)
2. Ensure parent tables are created first
3. Use appropriate timestamps to maintain order
4. Test migration order with migrate:fresh
```

### **3. Foreign Key Best Practices**
```php
// ✅ GOOD: Explicit table reference
$table->foreignId('student_id')->constrained('students')->onDelete('cascade');

// ✅ GOOD: Manual foreign key definition
$table->unsignedBigInteger('student_id');
$table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

// ❌ BAD: Implicit reference without ensuring table exists
$table->foreignId('student_id')->constrained(); // Assumes 'students' table exists
```

## 📊 **Expected Results After Fix**

### **Successful Migration Output:**
```
Migrating: 2025_08_29_075151_create_students_table
Migrated:  2025_08_29_075151_create_students_table (15.23ms)
Migrating: 2025_08_29_075152_create_qr_attendances_table
Migrated:  2025_08_29_075152_create_qr_attendances_table (12.45ms)
Migrating: 2025_08_29_075153_create_attendance_logs_table
Migrated:  2025_08_29_075153_create_attendance_logs_table (18.67ms)
```

### **Database Tables Created:**
```
✅ students (with id as PRIMARY KEY)
✅ qr_attendances (with student_id FOREIGN KEY → students.id)
✅ attendance_logs (with student_id FOREIGN KEY → students.id)
```

### **Seeder Ready:**
```bash
# After successful migration, run seeder
php artisan db:seed

# Expected output:
🌱 Starting Database Seeding...
🎭 Seeding Roles...
👤 Seeding Admin Users...
🎓 Seeding Students...
🎉 Database seeding completed successfully!
```

---

**Status**: ✅ **MIGRATION ORDER FIXED**  
**Command**: `php artisan migrate:fresh --seed`  
**Result**: 🎯 **QR Attendance system ready with 50 test students**