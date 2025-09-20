# 🌱 Database Seeder Documentation

## 📋 **Overview**

Seeder ini akan membuat data sample untuk sistem sekolah dengan 50 siswa beserta akun login mereka. Semua password diset menjadi "password" untuk kemudahan testing.

## 🎯 **What Will Be Created**

### **1. Roles (4 roles)**
- **Super Administrator** (ID: 1)
- **Administrator** (ID: 2) 
- **Student** (ID: 3)
- **Teacher** (ID: 4)

### **2. Admin Users (3 users)**
- **superadmin@smk.sch.id** - Super Administrator
- **admin@smk.sch.id** - Administrator  
- **guru@smk.sch.id** - Teacher Demo

### **3. Students (50 students)**
- **Kelas 10**: TKJ (10 siswa), RPL (10 siswa), DKV (5 siswa)
- **Kelas 11**: TKJ (10 siswa), RPL (10 siswa)
- **Kelas 12**: TKJ (5 siswa)

## 🚀 **How to Run**

### **Method 1: Run All Seeders**
```bash
php artisan db:seed
```

### **Method 2: Run Specific Seeders**
```bash
# Run roles first
php artisan db:seed --class=RoleSeeder

# Run admin users
php artisan db:seed --class=AdminUserSeeder

# Run students
php artisan db:seed --class=StudentSeeder
```

### **Method 3: Fresh Migration + Seed**
```bash
php artisan migrate:fresh --seed
```

## 🔑 **Login Credentials**

### **Admin Accounts**
| Email | Password | Role |
|-------|----------|------|
| superadmin@smk.sch.id | password | Super Administrator |
| admin@smk.sch.id | password | Administrator |
| guru@smk.sch.id | password | Teacher |

### **Student Accounts**
| Format | Example | Password |
|--------|---------|----------|
| firstname.lastname@student.smk.sch.id | ahmad.rizki.pratama@student.smk.sch.id | password |

### **Sample Student Logins**
```
ahmad.rizki.pratama@student.smk.sch.id / password
siti.nurhaliza@student.smk.sch.id / password
budi.santoso@student.smk.sch.id / password
dewi.sartika@student.smk.sch.id / password
eko.prasetyo@student.smk.sch.id / password
```

## 📊 **Generated Data Details**

### **Student Data Structure**
```php
[
    'name' => 'Ahmad Rizki Pratama',
    'nis' => '2024100001', // Format: Year + Grade + Sequence
    'nisn' => '0012345678', // 10 digit random
    'email' => 'ahmad.rizki.pratama@student.smk.sch.id',
    'phone' => '081234567890',
    'address' => 'Jl. Merdeka No. 45, Jakarta',
    'class' => '10 TKJ 1',
    'birth_date' => '2009-03-15', // Age appropriate for grade
    'birth_place' => 'Jakarta',
    'gender' => 'male',
    'religion' => 'Islam',
    'parent_name' => 'Bapak Ahmad Senior',
    'parent_phone' => '081987654321',
    'status' => 'active',
]
```

### **Class Distribution**
```
Kelas 10:
├── 10 TKJ 1 (5 siswa)
├── 10 TKJ 2 (5 siswa)
├── 10 RPL 1 (5 siswa)
├── 10 RPL 2 (5 siswa)
└── 10 DKV 1 (5 siswa)

Kelas 11:
├── 11 TKJ 1 (5 siswa)
├── 11 TKJ 2 (5 siswa)
├── 11 RPL 1 (5 siswa)
└── 11 RPL 2 (5 siswa)

Kelas 12:
├── 12 TKJ 1 (5 siswa)
└── 12 TKJ 2 (1 siswa)

Total: 50 siswa
```

## 🔧 **Technical Details**

### **NIS Generation Pattern**
```
Format: YYYY + GG + SSS
- YYYY: Current year (2024)
- GG: Grade (10, 11, 12)
- SSS: Sequence number (001-050)

Examples:
- 2024100001 (Kelas 10, siswa ke-1)
- 2024110026 (Kelas 11, siswa ke-26)
- 2024120046 (Kelas 12, siswa ke-46)
```

### **Email Generation**
```php
// Convert name to email
$emailName = strtolower(str_replace(' ', '.', $studentData['name']));
$email = $emailName . '@student.smk.sch.id';

// Examples:
// "Ahmad Rizki Pratama" → "ahmad.rizki.pratama@student.smk.sch.id"
// "Siti Nurhaliza" → "siti.nurhaliza@student.smk.sch.id"
```

### **Age Calculation**
```php
// Age based on grade level
$birthYear = $currentYear - (15 + ($grade - 10));
// Kelas 10 = 15 tahun (born 2009)
// Kelas 11 = 16 tahun (born 2008) 
// Kelas 12 = 17 tahun (born 2007)
```

## 🛡️ **Safety Features**

### **1. Transaction Safety**
```php
DB::beginTransaction();
try {
    // Create students and users
    DB::commit();
} catch (\Exception $e) {
    DB::rollback();
    throw $e;
}
```

### **2. Duplicate Prevention**
```php
// Check if user already exists
$existingUser = User::where('email', $userData['email'])->first();
if (!$existingUser) {
    // Create new user
} else {
    // Update existing user password
}
```

### **3. Error Handling**
```php
try {
    $user->roles()->attach($roleId);
} catch (\Exception $e) {
    Log::warning("Could not assign role to user {$user->id}: " . $e->getMessage());
}
```

## 📝 **Logging**

### **Success Logs**
```
[INFO] Created student: Ahmad Rizki Pratama (NIS: 2024100001) with user account
[INFO] StudentSeeder completed (students_created: 50, users_created: 50)
```

### **Error Logs**
```
[ERROR] StudentSeeder failed (error: ..., trace: ...)
[WARNING] Could not assign role to user 123: Role not found
```

## 🧪 **Testing After Seeding**

### **1. Verify Admin Login**
```bash
# Test admin login
curl -X POST http://localhost:8000/login \
  -d "email=admin@smk.sch.id&password=password"
```

### **2. Verify Student Login**
```bash
# Test student login
curl -X POST http://localhost:8000/login \
  -d "email=ahmad.rizki.pratama@student.smk.sch.id&password=password"
```

### **3. Check Database**
```sql
-- Check students count
SELECT COUNT(*) FROM students;

-- Check users count
SELECT COUNT(*) FROM users;

-- Check role assignments
SELECT u.name, u.email, r.display_name 
FROM users u 
JOIN role_user ru ON u.id = ru.user_id 
JOIN roles r ON ru.role_id = r.id;
```

## 🔄 **Re-running Seeders**

### **Safe Re-run (Updates existing)**
```bash
php artisan db:seed
```

### **Fresh Start (Deletes all data)**
```bash
php artisan migrate:fresh --seed
```

### **Specific Seeder Only**
```bash
php artisan db:seed --class=StudentSeeder
```

## 📋 **Troubleshooting**

### **Common Issues**

#### **1. Role Not Found Error**
```bash
# Make sure roles are seeded first
php artisan db:seed --class=RoleSeeder
```

#### **2. Duplicate Email Error**
```bash
# Clear existing data first
php artisan migrate:fresh
php artisan db:seed
```

#### **3. Permission Error**
```bash
# Check storage permissions
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### **4. Class Helper Error**
```bash
# Make sure ClassHelper exists
php artisan make:helper ClassHelper
```

## 🎯 **Next Steps After Seeding**

### **1. Test QR Code Generation**
```bash
# Login as admin and test auto-generate QR for students
# Go to: /admin/students/create
# Check "Auto-generate QR Code" option
```

### **2. Test Student Login**
```bash
# Login as student and test QR scanner
# Go to: /student/attendance
# Test QR code scanning functionality
```

### **3. Verify Data Integrity**
```bash
# Check if all relationships are working
# Test student-user relationship
# Test role assignments
```

## 📊 **Expected Output**

```
🌱 Starting Database Seeding...

🎭 Seeding Roles...
✅ Created role: Super Administrator
✅ Created role: Administrator  
✅ Created role: Siswa
✅ Created role: Guru
🎭 RoleSeeder completed successfully!

👤 Seeding Admin Users...
✅ Created user: Super Administrator (superadmin@smk.sch.id) with role ID 1
✅ Created user: Administrator (admin@smk.sch.id) with role ID 2
✅ Created user: Guru Demo (guru@smk.sch.id) with role ID 4
👤 AdminUserSeeder completed successfully!

🎓 Seeding Students...
✅ StudentSeeder completed successfully!
📊 Created 50 students
👤 Created 50 user accounts
🔑 All passwords set to: 'password'

🎉 Database seeding completed successfully!

📋 Summary:
   ✅ Roles created/verified
   ✅ Admin users created/updated
   ✅ 50 students created with accounts

🔑 Default Password: "password"

📧 Admin Login Credentials:
   - superadmin@smk.sch.id / password
   - admin@smk.sch.id / password
   - guru@smk.sch.id / password

👨‍🎓 Student Login Format:
   - firstname.lastname@student.smk.sch.id / password
   - Example: ahmad.rizki.pratama@student.smk.sch.id / password
```

---

**Status**: ✅ **READY TO RUN**  
**Command**: `php artisan db:seed`  
**Password**: 🔑 **"password"** (for all accounts)  
**Students**: 👥 **50 students with login accounts**