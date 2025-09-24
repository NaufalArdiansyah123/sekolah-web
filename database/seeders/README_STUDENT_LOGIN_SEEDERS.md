# Student Login Account Seeders

Dokumentasi untuk seeders yang membuat akun login siswa berdasarkan data yang sudah ada di tabel `students`.

## 📋 Daftar Seeders

### 1. `StudentLoginAccountSeeder.php` ⭐ **RECOMMENDED**
**Seeder lengkap dengan validasi komprehensif dan error handling yang robust.**

**Fitur:**
- ✅ Validasi prasyarat lengkap (tabel, data, role, field)
- ✅ Progress monitoring dengan progress bar
- ✅ Comprehensive error handling dan logging
- ✅ Dynamic field mapping berdasarkan database structure
- ✅ Smart email generation dengan collision detection
- ✅ Password generation (NIS atau default)
- ✅ Detailed statistics dan reporting
- ✅ Security recommendations

**Cara Penggunaan:**
```bash
php artisan db:seed --class=StudentLoginAccountSeeder
```

### 2. `SimpleStudentLoginSeeder.php` 🚀 **QUICK & EASY**
**Seeder sederhana untuk penggunaan cepat tanpa konfigurasi kompleks.**

**Fitur:**
- ✅ Setup cepat tanpa konfirmasi
- ✅ Hanya proses siswa yang belum punya akun
- ✅ Password = NIS siswa (fallback: "password")
- ✅ Email format: firstname.lastname@student.smk.sch.id
- ✅ Minimal configuration required

**Cara Penggunaan:**
```bash
php artisan db:seed --class=SimpleStudentLoginSeeder
```

### 3. `AdvancedStudentLoginSeeder.php` ⚙️ **CUSTOMIZABLE**
**Seeder advanced dengan opsi kustomisasi lengkap dan mode interaktif.**

**Fitur:**
- ✅ Interactive configuration setup
- ✅ Multiple password options (NIS, custom, random)
- ✅ Custom email domain
- ✅ Update existing accounts option
- ✅ Filter by student status
- ✅ Email verification options
- ✅ Comprehensive reporting

**Cara Penggunaan:**
```bash
php artisan db:seed --class=AdvancedStudentLoginSeeder
```

## 🔧 Konfigurasi

### Email Format
Semua seeder menggunakan format email default:
```
firstname.lastname@student.smk.sch.id
```

**Contoh:**
- Ahmad Rizki Pratama → `ahmad.rizki.pratama@student.smk.sch.id`
- Siti Nurhaliza → `siti.nurhaliza@student.smk.sch.id`

### Password Options

#### 1. NIS-based Password (Default)
```php
// Password = NIS siswa
'password' => $student->nis // contoh: "2024001"
```

#### 2. Default Password
```php
// Password = "password"
'password' => 'password'
```

#### 3. Custom Password
```php
// Password sesuai konfigurasi
'password' => $customPassword
```

### Role Assignment
Semua user otomatis mendapat role: `student`

## 📊 Data Mapping

### Dari Students ke Users
```php
// Data yang dipetakan dari tabel students ke users:
'name' => $student->name,
'email' => [generated_email],
'password' => [generated_password],
'nis' => $student->nis,
'class' => $student->class,
'phone' => $student->phone,
'address' => $student->address,
'birth_date' => $student->birth_date,
'birth_place' => $student->birth_place,
'gender' => $student->gender,
'religion' => $student->religion,
'parent_name' => $student->parent_name,
'parent_phone' => $student->parent_phone,
'status' => 'active',
'email_verified_at' => now(),
```

## 📋 Prasyarat

Sebelum menjalankan seeders, pastikan:

1. **Data siswa sudah ada:**
   ```bash
   php artisan db:seed --class=StudentSeeder
   ```

2. **Role 'student' sudah ada:**
   ```bash
   php artisan db:seed --class=RoleSeeder
   ```

3. **Database sudah di-migrate:**
   ```bash
   php artisan migrate
   ```

## 🚀 Cara Penggunaan

### Skenario 1: Quick Setup (Recommended untuk Testing)
```bash
# Gunakan seeder sederhana
php artisan db:seed --class=SimpleStudentLoginSeeder
```

### Skenario 2: Production Setup (Recommended untuk Production)
```bash
# Gunakan seeder lengkap dengan validasi
php artisan db:seed --class=StudentLoginAccountSeeder
```

### Skenario 3: Custom Setup (Untuk kebutuhan khusus)
```bash
# Gunakan seeder advanced dengan konfigurasi
php artisan db:seed --class=AdvancedStudentLoginSeeder
```

## 🔍 Validasi & Testing

### Cek Hasil Seeding
```sql
-- Cek jumlah siswa vs user accounts
SELECT 
    (SELECT COUNT(*) FROM students WHERE status = 'active') as total_students,
    (SELECT COUNT(*) FROM users WHERE nis IS NOT NULL) as student_accounts;

-- Cek siswa tanpa akun login
SELECT s.name, s.nis, s.class 
FROM students s 
WHERE s.user_id IS NULL 
AND s.status = 'active';

-- Cek user dengan role student
SELECT u.name, u.email, u.nis 
FROM users u 
JOIN model_has_roles mhr ON u.id = mhr.model_id 
JOIN roles r ON mhr.role_id = r.id 
WHERE r.name = 'student';
```

### Test Login
```php
// Test login functionality
$user = User::where('email', 'ahmad.rizki@student.smk.sch.id')->first();
if (Hash::check('2024001', $user->password)) {
    echo "Login successful!";
}
```

## 🔐 Security Features

### Password Security
- **NIS-based**: Menggunakan NIS sebagai password (mudah diingat siswa)
- **Custom**: Password yang ditentukan admin
- **Random**: Password acak untuk keamanan maksimal

### Email Verification
- Email otomatis di-verify (`email_verified_at` = now())
- Bisa dikonfigurasi untuk require verification

### Account Security
- Status account = 'active'
- Role assignment otomatis
- Link dengan data student untuk audit trail

## 📊 Monitoring & Logging

### Log Files
Semua aktivitas dicatat di:
```
storage/logs/laravel.log
```

### Log Format
```json
{
    "message": "Created login account for student",
    "student_id": 1,
    "student_name": "Ahmad Rizki",
    "student_nis": "2024001",
    "user_id": 10,
    "login_email": "ahmad.rizki@student.smk.sch.id"
}
```

## 🎯 Best Practices

### 1. Backup Database
```bash
mysqldump -u username -p database_name > backup_before_seeding.sql
```

### 2. Test Environment First
```bash
# Set environment
APP_ENV=local
```

### 3. Verify Results
```bash
# Check seeding results
php artisan tinker
>>> User::role('student')->count()
>>> Student::whereNotNull('user_id')->count()
```

### 4. Distribute Credentials Securely
- Generate credential reports
- Use secure channels for distribution
- Implement password change requirement

## 🔧 Troubleshooting

### Error: "No students found"
**Solusi:**
```bash
php artisan db:seed --class=StudentSeeder
```

### Error: "Student role not found"
**Solusi:**
```bash
php artisan db:seed --class=RoleSeeder
```

### Error: "Duplicate email"
**Penyebab:** Email collision
**Solusi:** Seeder otomatis handle dengan counter (email1, email2, dst)

### Error: "Field not found"
**Penyebab:** Database structure mismatch
**Solusi:** Seeder menggunakan dynamic field checking

## 📞 Support

### Debugging Steps:
1. Check logs: `storage/logs/laravel.log`
2. Verify prerequisites
3. Test with SimpleStudentLoginSeeder first
4. Check database structure compatibility

### Common Issues:
- **Duplicate emails**: Handled automatically with counter
- **Missing fields**: Dynamic field mapping handles this
- **Role not found**: Run RoleSeeder first
- **No students**: Run StudentSeeder first

## 🎉 Success Indicators

### Seeding Berhasil Jika:
- ✅ Success rate > 95%
- ✅ Semua siswa aktif punya user account
- ✅ Login test berhasil
- ✅ Role assignment correct
- ✅ Email format consistent

### Post-Seeding Checklist:
- [ ] Test login dengan beberapa akun
- [ ] Verify role assignments
- [ ] Check email format consistency
- [ ] Validate password functionality
- [ ] Test password reset (jika ada)
- [ ] Distribute credentials to students
- [ ] Set up password change policy

---

**Dibuat untuk:** Laravel School Management System  
**Versi:** 1.0  
**Tanggal:** {{ date('Y-m-d') }}  
**Focus:** Student Login Account Creation from Student Database