# 🔧 QR Code System Troubleshooting Guide

## ❌ Error: Class "SimpleSoftwareIO\QrCode\Facades\QrCode" not found

### 🔍 **Problem**
Package SimpleSoftwareIO QR Code tidak terinstall atau tidak terkonfigurasi dengan benar.

### ✅ **Solution Applied**
Menggunakan package **Endroid QR Code** yang sudah tersedia di composer.json.

### 📋 **Steps Taken**

#### 1. **Updated QrCodeService.php**
```php
// Before (SimpleSoftwareIO)
use SimpleSoftwareIO\QrCode\Facades\QrCode;
$qrCodeImage = QrCode::format('png')->size(300)->generate($qrCode);

// After (Endroid)
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$result = Builder::create()
    ->writer(new PngWriter())
    ->data($qrCode)
    ->size(300)
    ->build();
$qrCodeImage = $result->getString();
```

#### 2. **Created Storage Directory**
```bash
mkdir -p storage/app/public/qr-codes
chmod 755 storage/app/public/qr-codes
```

#### 3. **Updated Seeder for Testing**
- Limited to 10 students for initial testing
- Added better error handling
- Added progress tracking

## 🧪 Testing Commands

### **Test QR Code Generation**
```bash
php artisan qr:test
```

### **Generate QR Codes for Students**
```bash
php artisan db:seed --class=QrAttendanceSeeder
```

### **Check Storage Link**
```bash
php artisan storage:link
```

## 🔧 Manual Installation Steps

### **1. Install Dependencies**
```bash
composer install
```

### **2. Create Storage Directories**
```bash
mkdir -p storage/app/public/qr-codes
chmod -R 755 storage/app/public
```

### **3. Create Storage Link**
```bash
php artisan storage:link
```

### **4. Run Migrations**
```bash
php artisan migrate
```

### **5. Test QR Generation**
```bash
php artisan qr:test
```

### **6. Generate QR Codes**
```bash
php artisan db:seed --class=QrAttendanceSeeder
```

## 🔍 Common Issues & Solutions

### **Issue 1: Storage Directory Not Found**
```bash
# Create directory
mkdir -p storage/app/public/qr-codes

# Set permissions
chmod -R 755 storage/app/public
```

### **Issue 2: Storage Link Missing**
```bash
# Create storage link
php artisan storage:link

# Verify link exists
ls -la public/storage
```

### **Issue 3: Permission Denied**
```bash
# Fix permissions
sudo chown -R www-data:www-data storage/
sudo chmod -R 755 storage/
```

### **Issue 4: Endroid QR Code Not Found**
```bash
# Check if package is installed
composer show endroid/qr-code

# If not found, install it
composer require endroid/qr-code
```

## 📁 File Structure

### **Expected Directory Structure**
```
storage/
├── app/
│   └── public/
│       └── qr-codes/          # QR code images stored here
│           ├── student-1-*.png
│           ├── student-2-*.png
│           └── test-qr-*.png
└── logs/

public/
└── storage/                   # Symlink to storage/app/public
    └── qr-codes/             # Accessible via web
```

### **URL Access**
```
Local: http://localhost/sekolah-web/storage/qr-codes/filename.png
Asset: asset('storage/qr-codes/filename.png')
```

## 🧪 Testing Checklist

### **✅ Pre-Testing**
- [ ] Composer dependencies installed
- [ ] Storage directory created
- [ ] Storage link created
- [ ] Migrations run
- [ ] At least one student exists

### **✅ QR Code Generation Test**
```bash
# Test basic QR generation
php artisan qr:test

# Expected output:
# 🧪 Testing QR Code generation...
# 📝 Generating test QR code...
# ✅ Test QR code generated successfully!
# 📁 Saved to: storage/app/public/qr-codes/test-qr-*.png
```

### **✅ Student QR Generation Test**
```bash
# Test student QR generation
php artisan db:seed --class=QrAttendanceSeeder

# Expected output:
# Generating QR codes for X students...
# ✅ Generated QR code for: Student Name
# 🎉 QR code generation completed!
```

### **✅ Web Access Test**
1. Open browser
2. Go to: `http://localhost/sekolah-web/storage/qr-codes/`
3. Should see generated QR code files
4. Click on a PNG file to view QR code

## 🔧 Debug Commands

### **Check Storage Status**
```bash
# Check if storage link exists
ls -la public/storage

# Check storage permissions
ls -la storage/app/public/

# Check QR codes directory
ls -la storage/app/public/qr-codes/
```

### **Check Database**
```sql
-- Check if tables exist
SHOW TABLES LIKE '%qr%';

-- Check students
SELECT COUNT(*) FROM students WHERE status = 'active';

-- Check QR attendance records
SELECT COUNT(*) FROM qr_attendances;
```

### **Check Composer Packages**
```bash
# Check Endroid QR Code
composer show endroid/qr-code

# Check all packages
composer show | grep qr
```

## 🚨 Emergency Fixes

### **Quick Fix for Missing QR Codes**
```php
// Run in tinker: php artisan tinker
use App\Services\QrCodeService;
use App\Models\Student;

$service = new QrCodeService();
$student = Student::first();
$qr = $service->generateQrCodeForStudent($student);
echo "QR generated: " . $qr->qr_image_url;
```

### **Manual QR Code Creation**
```php
// Create QR manually
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$result = Builder::create()
    ->writer(new PngWriter())
    ->data('TEST_QR_CODE')
    ->size(300)
    ->build();

file_put_contents('test-qr.png', $result->getString());
```

## 📊 Success Indicators

### **✅ System Working Correctly**
- [ ] `php artisan qr:test` runs without errors
- [ ] QR code files created in storage/app/public/qr-codes/
- [ ] QR codes accessible via web URL
- [ ] Database records created in qr_attendances table
- [ ] Admin can generate QR codes via web interface
- [ ] Students can scan QR codes successfully

### **✅ Expected File Outputs**
```
storage/app/public/qr-codes/
├── student-1-1703123456.png    # Student QR codes
├── student-2-1703123457.png
├── test-qr-1703123458.png      # Test QR code
└── ...
```

### **✅ Expected Database Records**
```sql
-- qr_attendances table
+----+------------+---------------------------+--------------------------------+
| id | student_id | qr_code                   | qr_image_path                  |
+----+------------+---------------------------+--------------------------------+
| 1  | 1          | QR_000001_1703123456_abc  | qr-codes/student-1-1703123456.png |
| 2  | 2          | QR_000002_1703123457_def  | qr-codes/student-2-1703123457.png |
+----+------------+---------------------------+--------------------------------+
```

---

## 🎯 Next Steps After Fix

1. **Test QR Generation**: `php artisan qr:test`
2. **Generate Student QRs**: `php artisan db:seed --class=QrAttendanceSeeder`
3. **Access Admin Panel**: `/admin/qr-attendance`
4. **Test Student Scanner**: `/student/attendance/qr-scanner`
5. **Verify File Access**: Check QR codes via web URL

**Status**: 🔧 **TROUBLESHOOTING COMPLETE**  
**Solution**: ✅ **Endroid QR Code Implementation**  
**Ready for**: 🚀 **Production Testing**