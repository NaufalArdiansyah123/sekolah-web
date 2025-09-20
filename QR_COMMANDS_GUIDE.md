# 📋 QR Code Commands Guide

## 🎯 Available Commands

### **1. Check QR Code Status**
```bash
# List all students with QR status
php artisan qr:list

# Show only students WITH QR codes
php artisan qr:list --with-qr

# Show only students WITHOUT QR codes  
php artisan qr:list --without-qr
```

### **2. Show Specific Student QR Details**
```bash
# Show recent QR codes
php artisan qr:show

# Show specific student by ID
php artisan qr:show 1

# Show specific student by NIS
php artisan qr:show 12345

# Show specific student by name
php artisan qr:show "John Doe"
```

### **3. Check QR Code Files**
```bash
# List all QR code files in storage
php artisan qr:files

# Show orphaned files (no DB record)
php artisan qr:files --orphaned

# Show missing files (DB record but no file)
php artisan qr:files --missing
```

### **4. Test & Generate QR Codes**
```bash
# Test QR code generation
php artisan qr:test

# Check PHP extensions
php artisan check:extensions

# Generate QR codes for students
php artisan db:seed --class=QrAttendanceSeeder
```

## 📊 Command Examples & Expected Output

### **Example 1: List All Students**
```bash
php artisan qr:list
```

**Output:**
```
📋 QR Code Status Report

📊 Statistics:
   Total Students: 25
   With QR Code: 15
   Without QR Code: 10

👥 All Students:
+----+------------------+-------+--------+-----------+----------------------+------------------+
| ID | Name             | NIS   | Class  | QR Status | QR Code              | File             |
+----+------------------+-------+--------+-----------+----------------------+------------------+
| 1  | Ahmad Rizki      | 12001 | X-A    | ✅ Yes    | QR_000001_1703123... | student-1-17...  |
| 2  | Siti Nurhaliza   | 12002 | X-A    | ✅ Yes    | QR_000002_1703124... | student-2-17...  |
| 3  | Budi Santoso     | 12003 | X-B    | ❌ No     | -                    | -                |
+----+------------------+-------+--------+-----------+----------------------+------------------+
```

### **Example 2: Show Student Details**
```bash
php artisan qr:show "Ahmad Rizki"
```

**Output:**
```
👤 Student: Ahmad Rizki

📋 Student Information:
   ID: 1
   Name: Ahmad Rizki
   NIS: 12001
   Class: X-A
   Email: ahmad.rizki@example.com
   Status: active

🔲 QR Code Information:
   QR Code: QR_000001_1703123456_abc123def456
   File Path: qr-codes/student-1-1703123456.png
   Created: 20/12/2024 10:30:45
   Updated: 20/12/2024 10:30:45
   File Exists: ✅ Yes
   File Size: 2.5 KB
   File Type: png

🌐 Web Access:
   URL: http://localhost/sekolah-web/storage/qr-codes/student-1-1703123456.png

📅 Recent Attendance History:
+------------+------------+-----------+----------+
| Date       | Status     | Scan Time | Location |
+------------+------------+-----------+----------+
| 20/12/2024 | ✅ hadir   | 07:25:30  | Sekolah  |
| 19/12/2024 | ⚠️ terlambat | 07:35:15  | Sekolah  |
| 18/12/2024 | ✅ hadir   | 07:20:45  | Sekolah  |
+------------+------------+-----------+----------+

📊 This Month Statistics:
   ✅ Hadir: 18
   ⚠️ Terlambat: 2
   ℹ️ Izin: 0
   🤒 Sakit: 1
   ❌ Alpha: 0
```

### **Example 3: Check Files**
```bash
php artisan qr:files
```

**Output:**
```
📁 QR Code Files Report

📊 Summary:
   Files in storage: 15
   QR records in DB: 15

📄 All QR Code Files:
+-------------------------+--------+----------------+------------------+-----------+
| File                    | Size   | Modified       | Student          | Status    |
+-------------------------+--------+----------------+------------------+-----------+
| student-1-1703123456.png| 2.5 KB | 20/12/2024 10:30| Ahmad Rizki     | ✅ Linked |
| student-2-1703123457.png| 2.4 KB | 20/12/2024 10:31| Siti Nurhaliza  | ✅ Linked |
| test-qr-1703123458.png  | 2.3 KB | 20/12/2024 10:32| -               | ⚠️ Orphaned|
+-------------------------+--------+----------------+------------------+-----------+

🌐 Access URLs (first 3):
   student-1-1703123456.png: http://localhost/sekolah-web/storage/qr-codes/student-1-1703123456.png
   student-2-1703123457.png: http://localhost/sekolah-web/storage/qr-codes/student-2-1703123457.png
   test-qr-1703123458.png: http://localhost/sekolah-web/storage/qr-codes/test-qr-1703123458.png
```

### **Example 4: Students Without QR**
```bash
php artisan qr:list --without-qr
```

**Output:**
```
📋 QR Code Status Report

📊 Statistics:
   Total Students: 25
   With QR Code: 15
   Without QR Code: 10

❌ Students WITHOUT QR Codes:
+----+------------------+-------+--------+----------------------+--------+
| ID | Name             | NIS   | Class  | Email                | Status |
+----+------------------+-------+--------+----------------------+--------+
| 3  | Budi Santoso     | 12003 | X-B    | budi@example.com     | active |
| 7  | Maya Sari        | 12007 | X-C    | maya@example.com     | active |
| 12 | Andi Wijaya      | 12012 | XI-A   | andi@example.com     | active |
+----+------------------+-------+--------+----------------------+--------+

💡 To generate QR codes for these students:
   php artisan db:seed --class=QrAttendanceSeeder
```

## 🔍 Search & Filter Options

### **Search by Name (Partial Match)**
```bash
php artisan qr:show "Ahmad"     # Finds "Ahmad Rizki"
php artisan qr:show "Siti"      # Finds "Siti Nurhaliza"
```

### **Search by NIS**
```bash
php artisan qr:show 12001       # Finds student with NIS 12001
```

### **Search by ID**
```bash
php artisan qr:show 1           # Finds student with ID 1
```

## 🛠️ Maintenance Commands

### **Find Orphaned Files**
```bash
php artisan qr:files --orphaned
```
Shows files in storage that don't have corresponding database records.

### **Find Missing Files**
```bash
php artisan qr:files --missing
```
Shows database records that don't have corresponding files in storage.

### **Clean Up & Regenerate**
```bash
# Remove orphaned files manually, then regenerate missing QR codes
php artisan db:seed --class=QrAttendanceSeeder
```

## 📈 Usage Scenarios

### **Scenario 1: Check System Status**
```bash
# Quick overview
php artisan qr:list

# Check file integrity
php artisan qr:files
```

### **Scenario 2: Troubleshoot Student Issues**
```bash
# Student can't scan QR code
php artisan qr:show "Student Name"

# Check if file exists and is accessible
```

### **Scenario 3: System Maintenance**
```bash
# Find problems
php artisan qr:files --orphaned
php artisan qr:files --missing

# Fix problems
php artisan db:seed --class=QrAttendanceSeeder
```

### **Scenario 4: Generate Reports**
```bash
# Students without QR codes
php artisan qr:list --without-qr

# Students with QR codes
php artisan qr:list --with-qr
```

## 🎯 Quick Reference

| Command | Purpose | Example |
|---------|---------|---------|
| `qr:list` | Show all students with QR status | `php artisan qr:list --with-qr` |
| `qr:show` | Show detailed student QR info | `php artisan qr:show "John Doe"` |
| `qr:files` | Check QR code files in storage | `php artisan qr:files --orphaned` |
| `qr:test` | Test QR code generation | `php artisan qr:test` |
| `check:extensions` | Check PHP extensions | `php artisan check:extensions` |

## 🔧 Troubleshooting

### **No Students Found**
```bash
# Check if students exist in database
php artisan qr:list
```

### **QR Code Not Working**
```bash
# Check specific student
php artisan qr:show <student_id>

# Verify file exists and is accessible
```

### **Files Missing**
```bash
# Find missing files
php artisan qr:files --missing

# Regenerate QR codes
php artisan db:seed --class=QrAttendanceSeeder
```

---

**Status**: 📋 **READY TO USE**  
**All commands available**: ✅ **YES**  
**Documentation**: 📚 **COMPLETE**