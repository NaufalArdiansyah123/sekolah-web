# 🔧 Ngrok QR Scanner Troubleshooting Guide

## ❌ Common Issues with Ngrok + QR Scanner

### **Masalah yang Sering Terjadi:**

#### **1. HTTPS/SSL Issues**
- **Problem**: QR Scanner memerlukan HTTPS untuk akses kamera
- **Ngrok**: Menyediakan HTTPS secara default, tapi ada masalah sertifikat
- **Error**: "Camera access denied" atau "getUserMedia failed"

#### **2. Mixed Content Errors**
- **Problem**: HTTP content di HTTPS page
- **Error**: "Mixed Content: The page was loaded over HTTPS, but requested an insecure resource"

#### **3. CORS Issues**
- **Problem**: Cross-Origin Resource Sharing restrictions
- **Error**: "Access to fetch blocked by CORS policy"

#### **4. Camera Permission Issues**
- **Problem**: Browser tidak mengizinkan akses kamera via ngrok
- **Error**: "Permission denied" atau "NotAllowedError"

#### **5. Network/Latency Issues**
- **Problem**: Koneksi lambat via ngrok tunnel
- **Error**: Timeout atau connection failed

## 🔍 **Diagnosis Steps**

### **Step 1: Check Browser Console**
Buka Developer Tools (F12) dan lihat Console untuk error messages:

```javascript
// Common errors:
// 1. "getUserMedia is not supported"
// 2. "Permission denied"
// 3. "Mixed Content"
// 4. "CORS error"
// 5. "Failed to fetch"
```

### **Step 2: Check Network Tab**
Lihat Network tab untuk failed requests:
- Status 404, 500, atau CORS errors
- Failed fetch requests ke `/student/attendance/scan`
- SSL certificate issues

### **Step 3: Check Camera Permissions**
Di browser address bar, klik icon lock/camera:
- Pastikan camera permission = "Allow"
- Reset permissions jika perlu

## ✅ **Solutions**

### **1. Fix HTTPS/SSL Issues**

#### **Option A: Use Ngrok with Custom Domain**
```bash
# Upgrade to ngrok paid plan for custom domain
ngrok http 8000 --hostname=your-custom-domain.ngrok.io
```

#### **Option B: Force HTTPS in Laravel**
```php
// Add to AppServiceProvider.php boot() method
if (config('app.env') === 'production' || request()->header('x-forwarded-proto') === 'https') {
    \URL::forceScheme('https');
}
```

#### **Option C: Update .env for Ngrok**
```env
APP_URL=https://your-ngrok-url.ngrok.io
FORCE_HTTPS=true
```

### **2. Fix Mixed Content Issues**

#### **Update Asset URLs:**
```php
// In blade templates, use secure asset URLs
<script src="{{ secure_asset('js/app.js') }}"></script>
<link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
```

#### **Force HTTPS for External Resources:**
```html
<!-- Change HTTP to HTTPS -->
<script src="https://unpkg.com/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
```

### **3. Fix CORS Issues**

#### **Update CORS Config:**
```php
// config/cors.php
'allowed_origins' => [
    'https://*.ngrok.io',
    'https://your-ngrok-url.ngrok.io',
],

'allowed_headers' => [
    'Accept',
    'Authorization',
    'Content-Type',
    'X-Requested-With',
    'X-CSRF-TOKEN',
],
```

### **4. Fix Camera Permission Issues**

#### **Add Secure Context Check:**
```javascript
// Add to QR scanner JavaScript
function checkSecureContext() {
    if (!window.isSecureContext) {
        showCameraError('Camera requires HTTPS. Please use secure connection.');
        return false;
    }
    return true;
}

// Update initQrScanner function
function initQrScanner() {
    if (!checkSecureContext()) {
        return false;
    }
    
    // ... rest of scanner code
}
```

#### **Add Permission Request:**
```javascript
// Request camera permission explicitly
async function requestCameraPermission() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        stream.getTracks().forEach(track => track.stop());
        return true;
    } catch (error) {
        console.error('Camera permission denied:', error);
        showCameraError('Camera permission denied. Please allow camera access.');
        return false;
    }
}
```

### **5. Fix Network/Latency Issues**

#### **Add Timeout Handling:**
```javascript
// Update fetch with timeout
function processAttendance(qrCode) {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 second timeout
    
    fetch('{{ route("student.attendance.scan") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            qr_code: qrCode,
            location: 'Sekolah'
        }),
        signal: controller.signal
    })
    .then(response => {
        clearTimeout(timeoutId);
        return response.json();
    })
    .catch(error => {
        clearTimeout(timeoutId);
        if (error.name === 'AbortError') {
            Swal.fire({
                icon: 'error',
                title: 'Timeout',
                text: 'Request timeout. Please check your connection.',
                confirmButtonText: 'OK'
            });
        } else {
            console.error('Network error:', error);
        }
    });
}
```

## 🛠️ **Quick Fixes to Implement**

### **1. Update QR Scanner JavaScript**

Add this to the beginning of your QR scanner script:

```javascript
// Ngrok compatibility fixes
(function() {
    // Force HTTPS for all requests
    if (location.protocol !== 'https:' && location.hostname.includes('ngrok.io')) {
        location.replace('https:' + window.location.href.substring(window.location.protocol.length));
    }
    
    // Check if we're in secure context
    if (!window.isSecureContext) {
        console.warn('Not in secure context. Camera may not work.');
    }
})();
```

### **2. Update Laravel Configuration**

Add to `config/app.php`:

```php
'force_https' => env('FORCE_HTTPS', false),
```

Add to `AppServiceProvider.php`:

```php
public function boot()
{
    if (config('app.force_https')) {
        \URL::forceScheme('https');
    }
    
    // Trust ngrok proxy
    if (request()->header('x-forwarded-proto') === 'https') {
        request()->server->set('HTTPS', 'on');
    }
}
```

### **3. Update .env File**

```env
APP_URL=https://your-ngrok-url.ngrok.io
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

### **4. Add Ngrok-Specific Error Handling**

```javascript
function showNgrokSpecificError(error) {
    let message = 'Unknown error occurred';
    
    if (error.includes('Mixed Content')) {
        message = 'Mixed content error. Please ensure all resources use HTTPS.';
    } else if (error.includes('CORS')) {
        message = 'CORS error. Please check server configuration.';
    } else if (error.includes('Permission denied')) {
        message = 'Camera permission denied. Please allow camera access and use HTTPS.';
    } else if (error.includes('NotAllowedError')) {
        message = 'Camera access not allowed. Please check browser permissions.';
    }
    
    Swal.fire({
        icon: 'error',
        title: 'Ngrok Connection Issue',
        html: `
            <p>${message}</p>
            <br>
            <small>
                <strong>Troubleshooting:</strong><br>
                1. Ensure you're using HTTPS URL<br>
                2. Allow camera permissions<br>
                3. Check browser console for errors<br>
                4. Try refreshing the page
            </small>
        `,
        confirmButtonText: 'OK'
    });
}
```

## 📱 **Mobile-Specific Issues**

### **Common Mobile Problems:**
1. **iOS Safari**: Requires user gesture to access camera
2. **Android Chrome**: May have different permission model
3. **Mobile browsers**: May not support all camera features

### **Mobile Fixes:**
```javascript
// Detect mobile and adjust camera settings
function isMobile() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

function getMobileOptimizedConfig() {
    if (isMobile()) {
        return {
            fps: 5, // Lower FPS for mobile
            qrbox: { width: 200, height: 200 }, // Smaller box
            aspectRatio: 1.0,
            videoConstraints: {
                facingMode: "environment", // Use back camera
                width: { ideal: 640 },
                height: { ideal: 480 }
            }
        };
    }
    return {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0,
        videoConstraints: {
            facingMode: "environment"
        }
    };
}
```

## 🔧 **Testing Checklist**

### **Before Testing:**
- [ ] Ngrok tunnel is running with HTTPS
- [ ] Laravel app is configured for HTTPS
- [ ] Browser allows camera permissions
- [ ] No mixed content warnings in console

### **Test Steps:**
1. **Open ngrok HTTPS URL** in browser
2. **Check browser console** for errors
3. **Test camera permission** request
4. **Try QR scanner** functionality
5. **Test manual input** as fallback
6. **Check network requests** in DevTools

### **Common Test URLs:**
```
Local: http://localhost:8000/student/attendance/qr-scanner
Ngrok: https://abc123.ngrok.io/student/attendance/qr-scanner
```

## 🚨 **Emergency Fallbacks**

### **If Camera Still Doesn't Work:**

#### **1. Manual Input Only:**
```javascript
// Hide camera scanner, show only manual input
document.getElementById('start-scanner').style.display = 'none';
document.getElementById('manual-input-form').classList.remove('hidden');
```

#### **2. Alternative QR Scanner:**
```html
<!-- Use different QR library -->
<script src="https://cdn.jsdelivr.net/npm/qr-scanner@1.4.2/qr-scanner.min.js"></script>
```

#### **3. File Upload Option:**
```html
<!-- Add file upload for QR images -->
<input type="file" accept="image/*" onchange="processQrImage(this)">
```

---

**Status**: 🔧 **TROUBLESHOOTING GUIDE**  
**Platform**: 🌐 **Ngrok + Laravel + QR Scanner**  
**Focus**: 📱 **HTTPS, Permissions, CORS, Mobile**  
**Fallback**: ⌨️ **Manual Input Always Available**