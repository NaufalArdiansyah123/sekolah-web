# 🧪 QR Code Testing Commands

## 📋 Step-by-Step Testing

### **1. Test QR Code Generation**
```bash
php artisan qr:test
```

### **2. Generate QR Codes for Students (Limited)**
```bash
php artisan db:seed --class=QrAttendanceSeeder
```

### **3. Check Storage Link**
```bash
php artisan storage:link
```

### **4. Verify Files Created**
```bash
ls -la storage/app/public/qr-codes/
```

### **5. Test Web Access**
Open browser and go to:
```
http://localhost/sekolah-web/storage/qr-codes/
```

## 🔧 Expected Results

### **Test Command Output**
```
🧪 Testing QR Code generation...
📝 Generating test QR code...
✅ Test QR code generated successfully!
📁 Saved to: storage/app/public/qr-codes/test-qr-1703123456.png
🌐 Access via: http://localhost/sekolah-web/storage/qr-codes/test-qr-1703123456.png
✅ Storage directory is ready: /path/to/storage/app/public/qr-codes
```

### **Seeder Output**
```
Generating QR codes for 10 students...
10/10 [============================] 100%
✅ Generated QR code for: Student Name 1
✅ Generated QR code for: Student Name 2
...
🎉 QR code generation completed!
✅ Success: 10
❌ Errors: 0
📁 QR codes saved to: storage/app/public/qr-codes/
🌐 Access via: /storage/qr-codes/
```

## 🚀 Ready to Test

Silakan jalankan command berikut untuk test:

```bash
# 1. Test QR generation
php artisan qr:test

# 2. If test successful, generate student QR codes
php artisan db:seed --class=QrAttendanceSeeder
```