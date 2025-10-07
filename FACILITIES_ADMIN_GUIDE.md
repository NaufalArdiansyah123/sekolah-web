# 🏢 ADMIN PANEL FASILITAS - PANDUAN LENGKAP

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Fitur-Fitur](#fitur-fitur)
3. [Akses Admin Panel](#akses-admin-panel)
4. [Manajemen Fasilitas](#manajemen-fasilitas)
5. [Halaman Public](#halaman-public)
6. [Struktur Database](#struktur-database)
7. [API Endpoints](#api-endpoints)
8. [Troubleshooting](#troubleshooting)

## 🎯 Overview

Admin Panel Fasilitas adalah sistem manajemen lengkap untuk mengelola fasilitas sekolah. Sistem ini memungkinkan admin untuk:
- Menambah, mengedit, dan menghapus fasilitas
- Mengatur kategori dan status fasilitas
- Upload gambar fasilitas
- Mengelola fitur-fitur fasilitas
- Mengatur urutan tampilan
- Bulk actions untuk efisiensi

## ✨ Fitur-Fitur

### 🔧 Admin Features
- **CRUD Operations**: Create, Read, Update, Delete fasilitas
- **Image Upload**: Upload dan manajemen gambar fasilitas
- **Category Management**: Kategorisasi fasilitas (Academic, Sport, Technology, Arts, Other)
- **Status Management**: Active, Maintenance, Inactive
- **Featured Facilities**: Tandai fasilitas unggulan
- **Sort Order**: Atur urutan tampilan fasilitas
- **Bulk Actions**: Operasi massal (activate, deactivate, delete, feature, unfeature)
- **Search & Filter**: Pencarian dan filter berdasarkan kategori, status
- **Responsive Design**: Interface yang responsif untuk semua device

### 🌐 Public Features
- **Responsive Gallery**: Tampilan galeri fasilitas yang responsif
- **Category Filter**: Filter fasilitas berdasarkan kategori
- **Detail View**: Halaman detail lengkap untuk setiap fasilitas
- **Statistics**: Statistik fasilitas dalam angka
- **Search Functionality**: Pencarian fasilitas
- **Modal Details**: Pop-up detail fasilitas

## 🚀 Akses Admin Panel

### 1. Login sebagai Admin
```
URL: /login
Email: admin@example.com
Password: [admin password]
```

### 2. Navigasi ke Fasilitas
```
Dashboard Admin → Academic Management → 🏢 Fasilitas Sekolah
atau langsung ke: /admin/facilities
```

## 📝 Manajemen Fasilitas

### ➕ Menambah Fasilitas Baru

1. **Klik "Tambah Fasilitas"** di halaman index
2. **Isi Form**:
   - **Nama**: Nama fasilitas (required)
   - **Deskripsi**: Deskripsi lengkap fasilitas (required)
   - **Kategori**: Pilih kategori (Academic/Sport/Technology/Arts/Other)
   - **Gambar**: Upload gambar fasilitas (optional, max 2MB)
   - **Fitur**: Daftar fitur-fitur fasilitas (array)
   - **Status**: Active/Maintenance/Inactive
   - **Kapasitas**: Jumlah kapasitas orang (optional)
   - **Lokasi**: Lokasi fasilitas (optional)
   - **Unggulan**: Centang jika fasilitas unggulan
   - **Urutan**: Urutan tampilan (auto-generated jika kosong)

3. **Klik "Simpan"**

### ✏️ Mengedit Fasilitas

1. **Klik tombol "Edit"** (ikon pensil) pada fasilitas yang ingin diedit
2. **Update informasi** yang diperlukan
3. **Klik "Update"**

### 👁️ Melihat Detail Fasilitas

1. **Klik tombol "Lihat"** (ikon mata) untuk melihat detail lengkap
2. **Informasi yang ditampilkan**:
   - Gambar fasilitas
   - Informasi lengkap
   - Daftar fitur
   - Status dan metadata

### 🗑️ Menghapus Fasilitas

1. **Klik tombol "Hapus"** (ikon tempat sampah)
2. **Konfirmasi penghapusan**
3. **Fasilitas akan dihapus** (soft delete)

### 🔄 Toggle Status & Featured

- **Toggle Status**: Klik tombol toggle untuk mengubah status active/inactive
- **Toggle Featured**: Klik tombol star untuk mengubah status unggulan

### 📦 Bulk Actions

1. **Pilih fasilitas** dengan centang checkbox
2. **Pilih aksi**:
   - Aktifkan
   - Nonaktifkan
   - Jadikan Unggulan
   - Hapus Unggulan
   - Hapus
3. **Konfirmasi aksi**

### 🔍 Search & Filter

- **Search**: Ketik di kolom pencarian untuk mencari nama, deskripsi, atau lokasi
- **Filter Kategori**: Pilih kategori untuk filter
- **Filter Status**: Pilih status untuk filter
- **Sort**: Atur pengurutan berdasarkan kolom

## 🌐 Halaman Public

### Akses Public
```
URL: /facilities
```

### Fitur Public
- **Gallery View**: Tampilan kartu fasilitas
- **Category Filter**: Filter berdasarkan kategori
- **Detail Modal**: Pop-up detail fasilitas
- **Statistics**: Statistik fasilitas
- **Responsive Design**: Optimal di semua device

### Detail Fasilitas
```
URL: /facilities/{facility}
```
- Halaman detail lengkap
- Informasi komprehensif
- Fasilitas terkait
- Call-to-action

## 🗄️ Struktur Database

### Tabel: `facilities`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| name | varchar(255) | Nama fasilitas |
| description | text | Deskripsi fasilitas |
| category | enum | Kategori (academic, sport, technology, arts, other) |
| image | varchar(255) | Nama file gambar |
| features | json | Array fitur-fitur |
| status | enum | Status (active, maintenance, inactive) |
| capacity | integer | Kapasitas orang |
| location | varchar(255) | Lokasi fasilitas |
| is_featured | boolean | Apakah unggulan |
| sort_order | integer | Urutan tampilan |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |
| deleted_at | timestamp | Soft delete |

### Indexes
- `status, category` - untuk filter
- `is_featured, sort_order` - untuk featured dan sorting

## 🔌 API Endpoints

### Admin Routes
```php
GET    /admin/facilities              # Index
GET    /admin/facilities/create       # Create form
POST   /admin/facilities              # Store
GET    /admin/facilities/{facility}   # Show
GET    /admin/facilities/{facility}/edit # Edit form
PUT    /admin/facilities/{facility}   # Update
DELETE /admin/facilities/{facility}   # Delete
POST   /admin/facilities/{facility}/toggle-status # Toggle status
POST   /admin/facilities/{facility}/toggle-featured # Toggle featured
POST   /admin/facilities/bulk-action  # Bulk actions
POST   /admin/facilities/update-sort-order # Update sort order
```

### Public Routes
```php
GET /facilities                       # Public index
GET /facilities/{facility}            # Public show
GET /api/facilities/category          # Get by category (AJAX)
GET /api/facilities/search            # Search facilities (AJAX)
```

## 🛠️ Troubleshooting

### ❌ Error: Column 'sort_order' not found

**Solusi:**
1. Jalankan migration:
   ```bash
   php artisan migrate
   ```
2. Atau jalankan script fix:
   ```bash
   php final_facilities_fix.php
   ```

### ❌ Error: Gambar tidak muncul

**Solusi:**
1. Pastikan storage link sudah dibuat:
   ```bash
   php artisan storage:link
   ```
2. Periksa permission folder storage

### ❌ Error: Route tidak ditemukan

**Solusi:**
1. Clear route cache:
   ```bash
   php artisan route:clear
   php artisan cache:clear
   ```

### ❌ Error: Seeder gagal

**Solusi:**
1. Jalankan seeder manual:
   ```bash
   php artisan db:seed --class=FacilitySeeder
   ```

## 📁 File Structure

```
app/
├── Http/Controllers/Admin/
│   └── FacilityController.php          # Admin controller
├── Http/Controllers/Public/
│   └── FacilityController.php          # Public controller
└── Models/
    └── Facility.php                    # Model

resources/views/
├── admin/facilities/
│   ├── index.blade.php                 # Admin index
│   ├── create.blade.php                # Admin create
│   ├── edit.blade.php                  # Admin edit
│   └── show.blade.php                  # Admin show
└── public/facilities/
    ├── index.blade.php                 # Public index
    └── show.blade.php                  # Public detail

database/
├── migrations/
│   └── 2025_08_29_075151_create_facilities_table.php
└── seeders/
    └── FacilitySeeder.php

routes/
└── web.php                             # Routes definition
```

## 🎯 Best Practices

### 1. Image Management
- Gunakan gambar dengan resolusi optimal (1200x800px)
- Format yang disarankan: JPG, PNG
- Maksimal ukuran: 2MB
- Gunakan nama file yang deskriptif

### 2. Content Management
- Tulis deskripsi yang informatif dan menarik
- Gunakan fitur-fitur yang spesifik dan jelas
- Atur kategori dengan tepat
- Update status secara berkala

### 3. SEO Optimization
- Gunakan nama fasilitas yang SEO-friendly
- Deskripsi yang informatif untuk meta description
- Alt text yang deskriptif untuk gambar

### 4. Performance
- Optimasi gambar sebelum upload
- Gunakan lazy loading untuk gambar
- Cache data yang sering diakses

## 📞 Support

Jika mengalami masalah atau butuh bantuan:
1. Periksa log error di `storage/logs/laravel.log`
2. Jalankan script troubleshooting yang disediakan
3. Hubungi tim development

---

**Dibuat dengan ❤️ untuk SMK PGRI 2 PONOROGO**