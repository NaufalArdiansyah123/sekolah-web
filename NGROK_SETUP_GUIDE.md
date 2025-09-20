# 🚀 Ngrok Setup Guide for QR Scanner

## ⚡ Quick Fix Implementation

Saya telah mengimplementasikan perbaikan untuk masalah ngrok dengan QR scanner. Berikut adalah yang sudah diperbaiki:

### 🔧 **Perbaikan yang Sudah Diterapkan:**

#### **1. JavaScript Improvements**
- ✅ **Auto HTTPS redirect** untuk ngrok URLs
- ✅ **Environment detection** dan logging
- ✅ **Enhanced camera permission** handling
- ✅ **Mobile-optimized configuration**
- ✅ **Better error handling** dengan timeout
- ✅ **Ngrok-specific error messages**

#### **2. Laravel Configuration**
- ✅ **AppServiceProvider** updated untuk ngrok support
- ✅ **Force HTTPS** untuk ngrok domains
- ✅ **Trust proxy headers**
- ✅ **Secure cookie settings**

#### **3. Enhanced Error Handling**
- ✅ **Request timeout** (15 detik untuk ngrok)
- ✅ **Connection error detection**
- ✅ **CORS error handling**
- ✅ **Detailed troubleshooting messages**

## 🛠️ **Setup Instructions**

### **Step 1: Update .env File**
```env
# Add these to your .env file
APP_URL=https://your-ngrok-url.ngrok.io
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
SESSION_SAME_SITE=none
```

### **Step 2: Start Ngrok**
```bash
# Start ngrok with HTTPS (default)
ngrok http 8000

# Or with custom subdomain (paid plan)
ngrok http 8000 --subdomain=your-custom-name
```

### **Step 3: Update APP_URL**
```bash
# Copy the HTTPS URL from ngrok
# Example: https://abc123.ngrok.io
# Update your .env file:
APP_URL=https://abc123.ngrok.io
```

### **Step 4: Clear Cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

## 🔍 **Troubleshooting Steps**

### **If QR Scanner Still Doesn't Work:**

#### **1. Check Browser Console**
- Open Developer Tools (F12)
- Look for errors in Console tab
- Check Network tab for failed requests

#### **2. Common Error Solutions:**

##### **"Camera requires HTTPS"**
```
Solution: Pastikan menggunakan HTTPS URL dari ngrok
✅ https://abc123.ngrok.io ← Correct
❌ http://abc123.ngrok.io ← Wrong
```

##### **"Camera permission denied"**
```
Solution: 
1. Click lock icon in browser address bar
2. Set Camera permission to "Allow"
3. Refresh the page
```

##### **"Mixed Content Error"**
```
Solution: Semua resources sudah menggunakan HTTPS
Check: Tidak ada HTTP links di halaman
```

##### **"Request timeout"**
```
Solution: 
1. Check internet connection
2. Try refreshing ngrok tunnel
3. Use manual input as fallback
```

#### **3. Browser-Specific Issues:**

##### **Chrome:**
- Go to `chrome://settings/content/camera`
- Make sure ngrok domain is allowed

##### **Safari (iOS):**
- Settings > Safari > Camera
- Allow camera access

##### **Firefox:**
- about:preferences#privacy
- Check camera permissions

## 📱 **Mobile Testing**

### **Android Chrome:**
1. Open ngrok HTTPS URL
2. Allow camera permission when prompted
3. Test QR scanner functionality

### **iOS Safari:**
1. Open ngrok HTTPS URL
2. Allow camera access
3. May need user gesture to start camera

## 🔧 **Advanced Configuration**

### **For Better Performance:**

#### **1. Ngrok Configuration File**
Create `~/.ngrok2/ngrok.yml`:
```yaml
version: "2"
authtoken: your_auth_token
tunnels:
  sekolah-web:
    addr: 8000
    proto: http
    hostname: your-custom-domain.ngrok.io
    bind_tls: true
```

#### **2. Laravel Optimization**
```php
// Add to config/app.php
'ngrok_optimized' => env('NGROK_OPTIMIZED', false),

// Add to .env
NGROK_OPTIMIZED=true
```

## 🚨 **Emergency Fallbacks**

### **If Camera Completely Fails:**

#### **1. Manual Input Always Available**
- Click "Input Manual" button
- Enter QR code manually
- Works without camera

#### **2. Alternative QR Apps**
- Use phone's built-in QR scanner
- Copy QR code text
- Paste into manual input

#### **3. Desktop Testing**
- Use webcam on desktop/laptop
- Better camera support
- More stable connection

## 📊 **Performance Monitoring**

### **Check These Metrics:**

#### **1. Network Speed**
```javascript
// Check in browser console
console.log('Connection:', navigator.connection);
```

#### **2. Camera Performance**
```javascript
// Check camera constraints
navigator.mediaDevices.getSupportedConstraints();
```

#### **3. Ngrok Status**
```bash
# Check ngrok status
curl -s http://localhost:4040/api/tunnels
```

## ✅ **Success Indicators**

### **Everything Working When:**
- ✅ Browser shows HTTPS lock icon
- ✅ Camera permission granted
- ✅ QR scanner starts without errors
- ✅ Network requests succeed
- ✅ Manual input works as fallback

### **Console Logs Should Show:**
```
🌐 Environment check: {protocol: "https:", isSecureContext: true, isNgrok: true}
📷 Requesting camera permission...
✅ Camera permission granted
📱 Device info: {isMobile: false, isNgrok: true}
🔧 Scanner config: {fps: 5, qrbox: {width: 200, height: 200}}
✅ QR Scanner initialized
```

## 🎯 **Testing Checklist**

### **Before Going Live:**
- [ ] Ngrok tunnel running with HTTPS
- [ ] APP_URL updated in .env
- [ ] Cache cleared
- [ ] Browser camera permission granted
- [ ] QR scanner starts successfully
- [ ] Manual input works
- [ ] Network requests complete
- [ ] Error handling works
- [ ] Mobile devices tested

### **Test Scenarios:**
1. **Desktop Chrome** - Primary testing
2. **Mobile Chrome** - Android testing
3. **Mobile Safari** - iOS testing
4. **Slow connection** - Timeout testing
5. **Camera blocked** - Fallback testing

---

**Status**: ✅ **NGROK COMPATIBILITY IMPLEMENTED**  
**Features**: 🔧 **Auto HTTPS + Enhanced Error Handling**  
**Fallback**: ⌨️ **Manual Input Always Available**  
**Mobile**: 📱 **Optimized for Mobile Devices**