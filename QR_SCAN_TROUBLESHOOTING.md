# 🔧 QR Scan Troubleshooting Guide

## ❌ Problem: "Scan berhasil tapi data tidak muncul"

### 🔍 **Possible Causes & Solutions**

#### **1. QR Code Validation Issues**

**Check if QR code exists in database:**
```bash
php artisan qr:test-scan
```

**Expected Output:**
```
📋 Available QR Codes:
+----+------------------+-------+--------------------------------+----------------+
| ID | Student          | NIS   | QR Code                        | Created        |
+----+------------------+-------+--------------------------------+----------------+
| 1  | Ahmad Rizki      | 12001 | QR_000001_1703123456_abc123... | 20/12/2024 10:30 |
+----+------------------+-------+--------------------------------+----------------+
```

**If no QR codes found:**
```bash
php artisan db:seed --class=QrAttendanceSeeder
```

#### **2. Test Specific QR Code**

```bash
php artisan qr:test-scan "QR_000001_1703123456_abc123def456"
```

**Expected Output:**
```
✅ QR Code found!
📋 QR Code Details:
   ID: 1
   QR Code: QR_000001_1703123456_abc123def456
   Student ID: 1
👤 Student Details:
   Name: Ahmad Rizki
   NIS: 12001
   Class: X-A
✅ QR Code image file exists
🧪 Testing Attendance Log Creation (Simulation):
✅ Ready to create attendance log
```

#### **3. Database Connection Issues**

**Check database tables:**
```bash
php artisan tinker
```

```php
// Check if tables exist
\DB::select("SHOW TABLES LIKE 'qr_attendances'");
\DB::select("SHOW TABLES LIKE 'attendance_logs'");

// Check QR attendance records
\App\Models\QrAttendance::count();

// Check students
\App\Models\Student::count();
```

#### **4. Route & Controller Issues**

**Check if route exists:**
```bash
php artisan route:list | grep attendance
```

**Expected routes:**
```
POST   student/attendance/scan ............. student.attendance.scan
GET    student/attendance/qr-scanner ...... student.attendance.qr-scanner
```

#### **5. JavaScript Console Errors**

**Open browser console (F12) and check for:**
- Network errors (404, 500)
- JavaScript errors
- CSRF token issues

**Common fixes:**
```html
<!-- Ensure CSRF token is present -->
<meta name="csrf-token" content="{{ csrf_token() }}">
```

#### **6. Response Data Issues**

**Check server logs:**
```bash
tail -f storage/logs/laravel.log
```

**Look for:**
- QR Scan Request logs
- QR Validation Result logs
- Attendance Log Created logs
- Error logs

#### **7. Model Relationship Issues**

**Test in tinker:**
```php
// Test QR attendance relationship
$qr = \App\Models\QrAttendance::first();
$qr->student; // Should return student object

// Test student relationship
$student = \App\Models\Student::first();
$student->qrAttendance; // Should return QR attendance object
```

### 🧪 **Debug Steps**

#### **Step 1: Enable Debug Mode**
```bash
# In .env file
APP_DEBUG=true
LOG_LEVEL=debug
```

#### **Step 2: Test QR Generation**
```bash
php artisan qr:test
```

#### **Step 3: Test QR Scanning**
```bash
php artisan qr:test-scan
```

#### **Step 4: Check Database**
```sql
-- Check QR attendance records
SELECT * FROM qr_attendances LIMIT 5;

-- Check students
SELECT * FROM students WHERE status = 'active' LIMIT 5;

-- Check attendance logs
SELECT * FROM attendance_logs ORDER BY created_at DESC LIMIT 5;
```

#### **Step 5: Test API Endpoint**

**Using curl:**
```bash
curl -X POST http://localhost/sekolah-web/student/attendance/scan \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: YOUR_CSRF_TOKEN" \
  -d '{"qr_code":"QR_000001_1703123456_abc123def456","location":"Test"}'
```

### 🔧 **Common Fixes**

#### **Fix 1: Regenerate QR Codes**
```bash
# Clear existing QR codes
php artisan tinker
\App\Models\QrAttendance::truncate();

# Regenerate QR codes
php artisan db:seed --class=QrAttendanceSeeder
```

#### **Fix 2: Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### **Fix 3: Fix Storage Permissions**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

#### **Fix 4: Recreate Storage Link**
```bash
php artisan storage:link
```

#### **Fix 5: Run Migrations**
```bash
php artisan migrate:fresh --seed
```

### 📊 **Expected Behavior**

#### **Successful Scan Flow:**
1. **QR Code Scanned** → JavaScript captures QR data
2. **AJAX Request** → Sent to `/student/attendance/scan`
3. **Controller Validation** → QR code validated against database
4. **Student Found** → Student data retrieved
5. **Attendance Check** → Check if already scanned today
6. **Status Determined** → Based on scan time (hadir/terlambat/alpha)
7. **Log Created** → AttendanceLog record created
8. **Response Sent** → Success response with attendance data
9. **UI Updated** → SweetAlert shows success message
10. **Page Reload** → Shows updated attendance status

#### **Expected Response Format:**
```json
{
  "success": true,
  "message": "Absensi berhasil dicatat!",
  "attendance": {
    "student_name": "Ahmad Rizki",
    "nis": "12001",
    "class": "X-A",
    "status": "Hadir",
    "scan_time": "07:25:30",
    "attendance_date": "20/12/2024",
    "badge_color": "success"
  },
  "debug": {
    "attendance_log_id": 1,
    "raw_status": "hadir",
    "scan_time_raw": "2024-12-20T07:25:30.000000Z"
  }
}
```

### 🚨 **Emergency Fixes**

#### **Quick Database Reset:**
```bash
php artisan migrate:fresh
php artisan db:seed --class=QrAttendanceSeeder
```

#### **Manual QR Code Creation:**
```php
// In tinker
$student = \App\Models\Student::first();
$qrService = new \App\Services\QrCodeService();
$qr = $qrService->generateQrCodeForStudent($student);
echo "QR Code: " . $qr->qr_code;
```

#### **Manual Attendance Log:**
```php
// In tinker
\App\Models\AttendanceLog::create([
    'student_id' => 1,
    'qr_code' => 'QR_000001_1703123456_abc123def456',
    'status' => 'hadir',
    'scan_time' => now(),
    'attendance_date' => today(),
    'location' => 'Manual Test'
]);
```

### 📋 **Checklist**

**Before Testing:**
- [ ] Database tables exist
- [ ] QR codes generated
- [ ] Students exist in database
- [ ] Storage directory writable
- [ ] Storage link created
- [ ] Routes registered
- [ ] CSRF token present

**During Testing:**
- [ ] Browser console clear of errors
- [ ] Network requests successful (200 status)
- [ ] Server logs show expected flow
- [ ] Database records created

**After Testing:**
- [ ] Attendance log created
- [ ] Student status updated
- [ ] UI shows success message
- [ ] Page reloads with new data

---

**Status**: 🔧 **DEBUGGING TOOLS READY**  
**Commands**: ✅ **Available for testing**  
**Logs**: ✅ **Enhanced with debug info**