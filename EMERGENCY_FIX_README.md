# 🚨 EMERGENCY FIX - Facilities Error

## ❌ Error yang Terjadi:
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'facilities.deleted_at' in 'where clause'
```

## 🔥 SOLUSI DARURAT - Pilih Salah Satu:

### 🚀 Opsi 1: Script Otomatis (RECOMMENDED)
```bash
# Windows
force_fix.bat

# Linux/Mac  
php emergency_fix.php
```

### 🛠️ Opsi 2: Manual via phpMyAdmin
1. Buka phpMyAdmin
2. Pilih database sekolah
3. Klik tab "SQL"
4. Copy-paste isi file `create_facilities_table.sql`
5. Klik "Go"

### ⚡ Opsi 3: Command Line MySQL
```bash
mysql -u root -p nama_database < create_facilities_table.sql
```

### 🔧 Opsi 4: Artisan Commands
```bash
php artisan cache:clear
php artisan config:clear
php artisan migrate:reset
php artisan migrate --force
php artisan db:seed --class=FacilitySeeder
```

## 🎯 Yang Akan Diperbaiki:

✅ **Tabel facilities** dibuat dengan struktur lengkap  
✅ **Kolom deleted_at** untuk soft deletes  
✅ **5 data contoh** fasilitas  
✅ **Cache dibersihkan** untuk memastikan perubahan terdeteksi  
✅ **Storage link** untuk upload gambar  

## 🔍 Verifikasi Berhasil:

Setelah menjalankan salah satu opsi di atas:

1. **Refresh halaman** `/facilities`
2. **Error akan hilang** dan halaman tampil normal
3. **Data fasilitas** akan muncul
4. **Panel admin** `/admin/facilities` siap digunakan

## 🆘 Jika Masih Error:

1. **Cek koneksi database** di file `.env`
2. **Pastikan MySQL/MariaDB** sudah running
3. **Cek nama database** sudah benar
4. **Jalankan ulang** script emergency fix

## 📞 Troubleshooting:

### Error: "Access denied"
- Cek username/password database di `.env`
- Pastikan user memiliki permission CREATE/DROP

### Error: "Database not found"  
- Cek nama database di `.env`
- Buat database jika belum ada

### Error: "Table already exists"
- Script akan otomatis drop table lama
- Atau hapus manual via phpMyAdmin

---

**💡 PENTING:** Pilih salah satu opsi di atas dan jalankan. Setelah itu refresh halaman `/facilities` - error akan hilang!