# 📝 Panduan Menjalankan Blog Seeder

## 🚀 Cara Menjalankan Seeder Blog

### Opsi 1: Menggunakan SimpleBlogSeeder (Direkomendasikan)
```bash
php artisan db:seed --class=SimpleBlogSeeder
```

### Opsi 2: Menggunakan BlogPostSeeder
```bash
php artisan db:seed --class=BlogPostSeeder
```

### Opsi 3: Menjalankan Semua Seeder
```bash
php artisan db:seed
```

## 🔧 Jika Terjadi Error

### 1. Pastikan Migration Sudah Dijalankan
```bash
php artisan migrate
```

### 2. Jika Error "Table doesn't exist"
```bash
php artisan migrate:fresh
php artisan db:seed --class=SimpleBlogSeeder
```

### 3. Jika Error "User not found"
Seeder akan otomatis membuat user default dengan:
- **Email**: admin@sman1balong.sch.id
- **Password**: password

### 4. Jika Error "Class not found"
```bash
composer dump-autoload
php artisan db:seed --class=SimpleBlogSeeder
```

## 📊 Setelah Seeder Berhasil

Anda dapat mengakses:

### Halaman Public
- **Blog Index**: `http://localhost/sekolah-web/public/blog`
- **News Index**: `http://localhost/sekolah-web/public/news`
- **Detail Blog**: `http://localhost/sekolah-web/public/blog/{id}`

### Halaman Admin
- **Admin Blog**: `http://localhost/sekolah-web/public/admin/posts/blog`

## 📝 Data yang Dibuat

Seeder akan membuat **5 artikel blog** dengan kategori:
1. **Prestasi** - Olimpiade Sains Nasional
2. **Kegiatan** - Bakti Sosial
3. **Pengumuman** - PPDB 2024/2025
4. **Kegiatan** - Festival Seni dan Budaya
5. **Berita** - Kurikulum Merdeka

## 🔍 Troubleshooting

### Error: "SQLSTATE[42S02]: Base table or view not found"
**Solusi**: Jalankan migration terlebih dahulu
```bash
php artisan migrate
```

### Error: "Class 'Database\Seeders\SimpleBlogSeeder' not found"
**Solusi**: Update autoloader
```bash
composer dump-autoload
```

### Error: "Foreign key constraint fails"
**Solusi**: Pastikan ada user di database
```bash
php artisan tinker
User::create(['name' => 'Admin', 'email' => 'admin@test.com', 'password' => bcrypt('password')]);
exit
php artisan db:seed --class=SimpleBlogSeeder
```

## ✅ Verifikasi Seeder Berhasil

1. **Cek Database**:
   ```bash
   php artisan tinker
   \App\Models\BlogPost::count()
   ```
   Harus mengembalikan angka 5 atau lebih.

2. **Cek Halaman Web**:
   - Buka `/blog` di browser
   - Harus menampilkan daftar artikel

3. **Cek Admin**:
   - Login ke admin dengan user yang dibuat
   - Buka `/admin/posts/blog`
   - Harus menampilkan artikel di dashboard admin

## 🎯 Tips

- Gunakan `SimpleBlogSeeder` untuk hasil yang lebih stabil
- Jika ingin reset data, jalankan `php artisan migrate:fresh` lalu seeder lagi
- Pastikan file `.env` sudah dikonfigurasi dengan benar untuk database

## 📞 Bantuan

Jika masih ada error, periksa:
1. Koneksi database di `.env`
2. Permission folder `storage/` dan `bootstrap/cache/`
3. Versi PHP (minimal 8.1)
4. Extension PHP yang diperlukan Laravel