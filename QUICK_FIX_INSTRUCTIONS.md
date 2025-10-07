# 🚨 QUICK FIX untuk Error Facilities

## ❌ Error yang Terjadi:
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'facilities.deleted_at' in 'where clause'
```

## ⚡ Solusi Cepat:

### Opsi 1: Script Otomatis (Windows)
```bash
fix_facilities.bat
```

### Opsi 2: Script PHP
```bash
php quick_fix.php
```

### Opsi 3: Manual Commands
```bash
# Jalankan migration
php artisan migrate --force

# Jalankan seeder
php artisan db:seed --class=FacilitySeeder

# Buat storage link
php artisan storage:link
```

## 🔍 Apa yang Diperbaiki:

1. **Migration facilities** yang sudah ada diupdate dengan kolom lengkap:
   - ✅ `deleted_at` untuk soft deletes
   - ✅ `name`, `description`, `category`
   - ✅ `status`, `features`, `capacity`
   - ✅ `location`, `is_featured`, `sort_order`

2. **Seeder** akan menambahkan 10 data contoh fasilitas

3. **Storage link** untuk upload gambar fasilitas

## 🎯 Setelah Fix:

- ✅ Error `Column not found` akan hilang
- ✅ Halaman `/facilities` akan berfungsi normal
- ✅ Panel admin `/admin/facilities` siap digunakan
- ✅ Data contoh fasilitas tersedia

## 🔄 Jika Masih Error:

1. Cek apakah migration berhasil:
```bash
php artisan migrate:status
```

2. Cek apakah tabel facilities ada:
```bash
php artisan tinker
>>> Schema::hasTable('facilities')
>>> exit
```

3. Reset dan jalankan ulang:
```bash
php artisan migrate:reset
php artisan migrate
php artisan db:seed --class=FacilitySeeder
```

---

**💡 Catatan:** Migration yang sudah ada (`2025_08_29_075151_create_facilities_table.php`) telah diupdate dengan struktur lengkap yang diperlukan.