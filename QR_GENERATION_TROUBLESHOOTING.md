# 🔧 QR Code Generation Troubleshooting

## ❌ Problem Analysis

### **Issue:**
Tidak bisa membuat QR code untuk siswa yang belum mendapatkan QR code di halaman admin kelola QR code.

### **Possible Causes:**

#### **1. Route Issues:**
- Route `/admin/qr-attendance/generate/{student}` tidak terdaftar
- Parameter binding tidak bekerja dengan benar
- Middleware blocking request

#### **2. CSRF Token Issues:**
- CSRF token tidak valid atau expired
- Meta tag CSRF tidak ada di layout

#### **3. JavaScript Issues:**
- SweetAlert2 tidak loaded
- Fetch API error handling
- Console errors blocking execution

#### **4. Controller Issues:**
- QrCodeService dependency injection error
- Database connection issues
- File permission issues untuk storage

#### **5. Model Issues:**
- Student model tidak ditemukan
- QrAttendance relationship issues
- Database table structure issues

## 🔍 **Diagnostic Steps**

### **Step 1: Check Browser Console**
```javascript
// Open Developer Tools (F12) and check for:
// 1. JavaScript errors
// 2. Network request failures
// 3. CSRF token issues
// 4. 404/500 errors
```

### **Step 2: Check Network Tab**
```
// Look for:
// 1. POST /admin/qr-attendance/generate/{id} - Status?
// 2. Response content
// 3. Request headers (CSRF token)
// 4. Response time
```

### **Step 3: Check Laravel Logs**
```bash
# Check for errors in:
tail -f storage/logs/laravel.log
```

## ✅ **Solutions**

### **1. Add Missing Route (if needed)**
```php
// In routes/web.php - Admin QR Attendance routes
Route::middleware(['auth', 'role:superadministrator,super_admin,admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        
    Route::prefix('qr-attendance')->name('qr-attendance.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\QrAttendanceController::class, 'index'])->name('index');
        Route::post('/generate/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'generateQr'])->name('generate');
        Route::post('/regenerate/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'regenerateQr'])->name('regenerate');
        Route::post('/generate-bulk', [App\Http\Controllers\Admin\QrAttendanceController::class, 'generateBulkQr'])->name('generate-bulk');
        Route::get('/view/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'viewQr'])->name('view');
        Route::get('/logs', [App\Http\Controllers\Admin\QrAttendanceController::class, 'attendanceLogs'])->name('logs');
        Route::get('/statistics', [App\Http\Controllers\Admin\QrAttendanceController::class, 'statistics'])->name('statistics');
        Route::get('/download/{student}', [App\Http\Controllers\Admin\QrAttendanceController::class, 'downloadQr'])->name('download');
    });
});
```

### **2. Add CSRF Meta Tag**
```html
<!-- In layouts/admin.blade.php or layouts/admin/app.blade.php -->
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- other meta tags -->
</head>
```

### **3. Enhanced Error Handling in JavaScript**
```javascript
// Enhanced generateQr function with better error handling
function generateQr(studentId) {
    // Check if CSRF token exists
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'CSRF token not found. Please refresh the page.',
            confirmButtonColor: '#ef4444'
        });
        return;
    }

    Swal.fire({
        title: 'Generate QR Code',
        text: 'Generate QR Code untuk siswa ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Generate!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Generating...',
                text: 'Sedang membuat QR Code',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Enhanced fetch with better error handling
            fetch(`/admin/qr-attendance/generate/${studentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
            })
            .then(response => {
                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Unknown error occurred',
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
                
                let errorMessage = 'Terjadi kesalahan sistem';
                
                if (error.message.includes('404')) {
                    errorMessage = 'Route tidak ditemukan. Periksa konfigurasi route.';
                } else if (error.message.includes('403')) {
                    errorMessage = 'Akses ditolak. Periksa permission.';
                } else if (error.message.includes('419')) {
                    errorMessage = 'CSRF token expired. Refresh halaman dan coba lagi.';
                } else if (error.message.includes('500')) {
                    errorMessage = 'Server error. Periksa log Laravel.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    html: `
                        <p>${errorMessage}</p>
                        <br>
                        <small class="text-gray-500">
                            <strong>Debug Info:</strong><br>
                            ${error.message}
                        </small>
                    `,
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}
```

### **4. Add Missing viewQr Method**
```php
// Add to QrAttendanceController.php
/**
 * View QR code for student
 */
public function viewQr(Student $student)
{
    try {
        $qrAttendance = $student->qrAttendance;
        
        if (!$qrAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code belum dibuat untuk siswa ini.',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'qr_image_url' => $qrAttendance->qr_image_url,
            'qr_code' => $qrAttendance->qr_code,
            'student' => [
                'name' => $student->name,
                'nis' => $student->nis,
                'class' => $student->class,
            ],
            'download_url' => route('admin.qr-attendance.download', $student),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
        ], 500);
    }
}
```

### **5. Enhanced Controller Error Handling**
```php
// Enhanced generateQr method with better error handling
public function generateQr(Student $student)
{
    try {
        // Log the request
        \Log::info('Generating QR code for student', [
            'student_id' => $student->id,
            'student_name' => $student->name,
            'user_id' => auth()->id()
        ]);
        
        // Check if QR already exists
        if ($student->qrAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code sudah ada untuk siswa ini. Gunakan regenerate jika ingin membuat ulang.',
            ], 400);
        }
        
        // Check storage permissions
        if (!is_writable(storage_path('app/public'))) {
            \Log::error('Storage directory not writable', [
                'path' => storage_path('app/public'),
                'permissions' => fileperms(storage_path('app/public'))
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Storage directory tidak dapat ditulis. Hubungi administrator.',
            ], 500);
        }
        
        // Generate QR code
        $qrAttendance = $this->qrCodeService->generateQrCodeForStudent($student);
        
        \Log::info('QR code generated successfully', [
            'student_id' => $student->id,
            'qr_attendance_id' => $qrAttendance->id,
            'qr_image_path' => $qrAttendance->qr_image_path
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'QR Code berhasil dibuat untuk ' . $student->name,
            'qr_image_url' => $qrAttendance->qr_image_url,
            'qr_code' => $qrAttendance->qr_code,
        ]);
    } catch (\Exception $e) {
        \Log::error('QR code generation failed', [
            'student_id' => $student->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat QR Code: ' . $e->getMessage(),
            'debug' => [
                'error_type' => get_class($e),
                'error_line' => $e->getLine(),
                'error_file' => basename($e->getFile())
            ]
        ], 500);
    }
}
```

### **6. Check Required Dependencies**
```bash
# Check if QR code library is installed
composer show endroid/qr-code

# If not installed:
composer require endroid/qr-code

# Check if GD extension is available
php -m | grep -i gd

# Check storage permissions
ls -la storage/app/public/
```

### **7. Create Storage Directory**
```bash
# Create QR codes directory if not exists
mkdir -p storage/app/public/qr-codes
chmod 755 storage/app/public/qr-codes

# Create symbolic link if not exists
php artisan storage:link
```

## 🧪 **Testing Steps**

### **1. Test Route Accessibility**
```bash
# Test route exists
php artisan route:list | grep qr-attendance

# Test specific route
curl -X POST http://localhost:8000/admin/qr-attendance/generate/1 \
  -H "Content-Type: application/json" \
  -H "X-CSRF-TOKEN: your-csrf-token"
```

### **2. Test JavaScript Console**
```javascript
// In browser console, test CSRF token
console.log(document.querySelector('meta[name="csrf-token"]'));

// Test fetch manually
fetch('/admin/qr-attendance/generate/1', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json',
    },
}).then(response => response.json()).then(console.log);
```

### **3. Test Storage Permissions**
```php
// Add temporary test route
Route::get('/test-storage', function() {
    $testFile = storage_path('app/public/test.txt');
    
    try {
        file_put_contents($testFile, 'test');
        unlink($testFile);
        return 'Storage writable';
    } catch (Exception $e) {
        return 'Storage not writable: ' . $e->getMessage();
    }
});
```

## 🎯 **Quick Fixes**

### **1. Immediate Debug Steps:**
1. Open browser Developer Tools (F12)
2. Go to Console tab
3. Click "Generate QR" button
4. Check for JavaScript errors
5. Go to Network tab and check the POST request

### **2. Check Laravel Logs:**
```bash
tail -f storage/logs/laravel.log
```

### **3. Test Route:**
```bash
php artisan route:list | grep generate
```

### **4. Clear Cache:**
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

---

**Status**: 🔧 **TROUBLESHOOTING GUIDE**  
**Focus**: 🎯 **QR Code Generation Issues**  
**Method**: 🔍 **Systematic Debugging**  
**Priority**: 🚨 **HIGH - Core Functionality**