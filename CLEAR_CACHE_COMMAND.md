# 🧹 Clear Cache Commands untuk Mengatasi Masalah Navbar

## 🚀 **QUICK FIX COMMANDS**

Jalankan command berikut untuk mengatasi masalah navbar yang tidak update:

### **1. Complete Cache Clear**
```bash
# Clear semua cache Laravel
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Clear compiled views
php artisan view:clear

# Clear application cache
php artisan cache:clear
```

### **2. Storage Link Check**
```bash
# Pastikan storage link ada
php artisan storage:link

# Verify link
ls -la public/storage
```

### **3. Settings Cache Clear (Manual)**
```bash
# Masuk ke tinker untuk clear cache settings
php artisan tinker

# Jalankan di tinker:
App\Models\Setting::clearCache();
Cache::flush();
exit
```

### **4. Force Refresh (One-liner)**
```bash
php artisan optimize:clear && php artisan cache:clear && php artisan config:clear && php artisan view:clear && php artisan storage:link
```

## 🔧 **STEP-BY-STEP TROUBLESHOOTING**

### **Step 1: Verify Settings in Database**
```bash
php artisan tinker

# Check current settings
App\Models\Setting::where('key', 'school_name')->first()
App\Models\Setting::where('key', 'school_logo')->first()
App\Models\Setting::where('key', 'school_subtitle')->first()

# Check if any temp paths exist (should be empty)
App\Models\Setting::where('value', 'like', '%tmp%')->get()
```

### **Step 2: Clear All Caches**
```bash
# Laravel caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Application cache
php artisan optimize:clear

# Settings specific cache
php artisan tinker
App\Models\Setting::clearCache();
Cache::flush();
exit
```

### **Step 3: Verify File Storage**
```bash
# Check if logo files exist
ls -la storage/app/public/school/

# Check public storage link
ls -la public/storage/school/

# If storage link missing, recreate
php artisan storage:link
```

### **Step 4: Test in Browser**
```bash
# Open browser and test:
# 1. Clear browser cache (Ctrl+F5)
# 2. Open public page
# 3. Check navbar logo and name
# 4. Try different browser
```

## 🎯 **VERIFICATION COMMANDS**

### **Check Current Settings**
```bash
php artisan tinker

# Get all school settings
$settings = App\Models\Setting::whereIn('key', ['school_name', 'school_subtitle', 'school_logo', 'school_favicon'])->get();
foreach($settings as $setting) {
    echo $setting->key . ': ' . $setting->value . "\n";
}
```

### **Check Cache Status**
```bash
php artisan tinker

# Check if cache is working
Cache::put('test_key', 'test_value', 60);
Cache::get('test_key'); // Should return 'test_value'
Cache::forget('test_key');
```

### **Check Storage Link**
```bash
# Verify storage link exists and works
ls -la public/storage
file public/storage  # Should show it's a symlink

# Test file access
ls -la storage/app/public/school/
ls -la public/storage/school/
```

## 🚨 **EMERGENCY RESET**

Jika masalah masih ada, lakukan reset lengkap:

### **1. Complete Reset**
```bash
# Stop any running processes
php artisan down

# Clear everything
rm -rf bootstrap/cache/*
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Recreate storage link
rm public/storage
php artisan storage:link

# Restart
php artisan up
```

### **2. Database Cache Reset**
```bash
php artisan tinker

# Clear all settings cache
App\Models\Setting::clearCache();

# Force refresh settings
$settings = App\Models\Setting::all();
foreach($settings as $setting) {
    Cache::forget("setting_{$setting->key}");
}

Cache::flush();
exit
```

### **3. File Permission Fix**
```bash
# Fix file permissions if needed
chmod -R 755 storage/
chmod -R 755 public/storage/
chown -R www-data:www-data storage/ # Linux/Ubuntu
chown -R _www:_www storage/         # macOS
```

## 📊 **TESTING CHECKLIST**

Setelah menjalankan commands di atas, test hal berikut:

### **✅ Backend Test**
- [ ] Login ke admin panel
- [ ] Buka Settings page  
- [ ] Upload logo baru
- [ ] Ubah nama sekolah
- [ ] Save settings
- [ ] Check success notification

### **✅ Frontend Test**
- [ ] Buka halaman public
- [ ] Check navbar logo (harus berubah)
- [ ] Check nama sekolah (harus berubah)
- [ ] Refresh halaman (perubahan tetap ada)
- [ ] Test di browser berbeda
- [ ] Test di mobile view

### **✅ Technical Test**
```bash
# Check database
php artisan tinker
App\Models\Setting::where('key', 'school_name')->first()->value

# Check file exists
ls -la storage/app/public/school/

# Check public access
curl -I http://yoursite.com/storage/school/logo.png
```

## 🔄 **AUTOMATED SCRIPT**

Buat script untuk otomatis clear cache:

### **create_clear_cache_script.sh**
```bash
#!/bin/bash
echo "🧹 Clearing all Laravel caches..."

# Laravel caches
php artisan cache:clear
php artisan config:clear  
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Settings cache
php artisan tinker --execute="App\Models\Setting::clearCache(); Cache::flush();"

# Storage link
php artisan storage:link

echo "✅ All caches cleared successfully!"
echo "🔄 Please refresh your browser (Ctrl+F5)"
```

### **Jalankan script:**
```bash
chmod +x clear_cache_script.sh
./clear_cache_script.sh
```

## 📝 **NOTES**

### **Important Points:**
1. **Always clear cache** setelah update settings
2. **Check storage link** jika logo tidak muncul
3. **Clear browser cache** untuk test yang akurat
4. **Check file permissions** jika ada error upload
5. **Monitor logs** untuk debug error

### **Common Locations:**
- **Settings Database**: `settings` table
- **Logo Storage**: `storage/app/public/school/`
- **Public Access**: `public/storage/school/`
- **Cache Location**: `storage/framework/cache/`
- **Logs**: `storage/logs/laravel.log`

---

**🎯 Setelah menjalankan commands ini, navbar public harus sudah menampilkan logo dan nama sekolah yang baru!**