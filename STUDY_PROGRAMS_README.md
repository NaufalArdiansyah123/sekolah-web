# 📚 Study Programs Management System

Sistem manajemen program studi yang lengkap dengan panel admin dan halaman publik.

## 🚀 Quick Setup

Jalankan script setup otomatis:

```bash
php setup_study_programs.php
```

## 📋 Manual Setup

Jika ingin setup manual, ikuti langkah berikut:

### 1. Jalankan Migration

```bash
php artisan migrate --path=database/migrations/2024_01_15_000000_create_study_programs_table.php
```

### 2. Buat Storage Directories

```bash
mkdir -p storage/app/public/study-programs/images
mkdir -p storage/app/public/study-programs/brochures
```

### 3. Buat Symbolic Link

```bash
php artisan storage:link
```

### 4. Jalankan Seeder

```bash
php artisan db:seed --class=StudyProgramSeeder
```

### 5. Clear Cache

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 🌐 URL Access

### Admin Panel
- **List Programs**: `/admin/study-programs`
- **Create Program**: `/admin/study-programs/create`
- **Edit Program**: `/admin/study-programs/{id}/edit`
- **View Program**: `/admin/study-programs/{id}`

### Public Pages
- **Programs List**: `/study-programs`
- **Program Detail**: `/study-programs/{id}`
- **Search Programs**: `/study-programs?search=keyword`
- **Filter by Degree**: `/study-programs?degree=S1`
- **Filter by Faculty**: `/study-programs?faculty=Fakultas+Teknik`

### API Endpoints
- **Search**: `/study-programs/search?q=keyword`
- **Featured Programs**: `/study-programs/featured`
- **By Degree**: `/study-programs/degree/{degree}`
- **By Faculty**: `/study-programs/faculty/{faculty}`
- **Statistics**: `/study-programs/statistics`

## 📊 Database Structure

### Table: `study_programs`

| Field | Type | Description |
|-------|------|-------------|
| `id` | bigint | Primary key |
| `program_name` | varchar(255) | Nama program studi |
| `program_code` | varchar(20) | Kode program (opsional) |
| `description` | text | Deskripsi program |
| `degree_level` | enum | Jenjang (D3, S1, S2, S3) |
| `faculty` | varchar(255) | Fakultas/jurusan |
| `vision` | text | Visi program |
| `mission` | text | Misi program |
| `career_prospects` | text | Prospek karir |
| `admission_requirements` | text | Syarat masuk |
| `duration_years` | int | Durasi studi (tahun) |
| `total_credits` | int | Total SKS |
| `degree_title` | varchar(100) | Gelar lulusan |
| `accreditation` | enum | Akreditasi (A, B, C) |
| `capacity` | int | Kapasitas mahasiswa |
| `tuition_fee` | decimal | Biaya kuliah per semester |
| `core_subjects` | json | Mata kuliah inti |
| `specializations` | json | Spesialisasi |
| `facilities` | json | Fasilitas program |
| `program_image` | varchar(255) | Path gambar program |
| `brochure_file` | varchar(255) | Path file brosur |
| `is_active` | boolean | Status aktif |
| `is_featured` | boolean | Status unggulan |
| `created_at` | timestamp | Waktu dibuat |
| `updated_at` | timestamp | Waktu diupdate |

## 🎨 Features

### Admin Panel Features
- ✅ **CRUD Operations** - Create, Read, Update, Delete
- ✅ **Advanced Search & Filter** - Berdasarkan nama, degree, status
- ✅ **Dynamic Form Sections** - Core subjects, specializations, facilities
- ✅ **JSON Data Management** - Otomatis generate JSON untuk data kompleks
- ✅ **Media Upload** - Program image dan brochure file
- ✅ **Status Management** - Activate/deactivate, feature programs
- ✅ **AJAX Operations** - Smooth user experience
- ✅ **Statistics Dashboard** - Total programs, active, featured, accredited
- ✅ **Responsive Design** - Mobile-friendly interface

### Public Pages Features
- ✅ **Hero Section** - Attractive landing dengan statistics
- ✅ **Featured Programs** - Highlight program unggulan
- ✅ **Advanced Filtering** - Search by name, degree, faculty
- ✅ **Program Cards** - Beautiful card design dengan badges
- ✅ **Detailed Program View** - Comprehensive program information
- ✅ **Related Programs** - Suggestions untuk program serupa
- ✅ **Call-to-Action** - Contact admissions, download brochure

## 🔧 Configuration

### File Upload Settings

Edit `config/filesystems.php` jika diperlukan:

```php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
],
```

### Validation Rules

File upload limits (dapat diubah di `StudyProgramRequest.php`):
- **Program Image**: Max 5MB (JPEG, PNG, JPG, GIF)
- **Brochure File**: Max 10MB (PDF, DOC, DOCX)

## 📝 Usage Examples

### Creating a Study Program

```php
use App\Models\StudyProgram;

$program = StudyProgram::create([
    'program_name' => 'Teknik Informatika',
    'program_code' => 'TI',
    'degree_level' => 'S1',
    'faculty' => 'Fakultas Teknik',
    'is_active' => true,
    'core_subjects' => [
        [
            'id' => 1,
            'name' => 'Algoritma dan Pemrograman',
            'code' => 'TI101',
            'credits' => '3',
            'semester' => '1'
        ]
    ]
]);
```

### Querying Programs

```php
// Get active programs
$activePrograms = StudyProgram::active()->get();

// Search programs
$searchResults = StudyProgram::search('informatika')->get();

// Filter by degree
$s1Programs = StudyProgram::byDegree('S1')->get();

// Get featured programs
$featuredPrograms = StudyProgram::featured()->get();

// Get statistics
$stats = StudyProgram::getStatistics();
```

### Using Scopes

```php
// Chain multiple scopes
$programs = StudyProgram::active()
    ->featured()
    ->byDegree('S1')
    ->search('teknik')
    ->paginate(10);
```

## 🎯 JSON Data Structure

### Core Subjects
```json
[
    {
        "id": 1,
        "name": "Algoritma dan Pemrograman",
        "code": "TI101",
        "credits": "3",
        "semester": "1",
        "description": "Mata kuliah dasar pemrograman"
    }
]
```

### Specializations
```json
[
    {
        "id": 1,
        "name": "Web Development",
        "description": "Spesialisasi pengembangan web",
        "requirements": "Menguasai HTML, CSS, JavaScript"
    }
]
```

### Facilities
```json
[
    {
        "id": 1,
        "name": "Laboratorium Komputer",
        "description": "Lab dengan 40 unit komputer",
        "icon": "fas fa-desktop",
        "color": "primary"
    }
]
```

## 🔒 Security Features

- ✅ **Role-based Access Control** - Admin only untuk management
- ✅ **File Upload Validation** - Type dan size validation
- ✅ **CSRF Protection** - Laravel built-in protection
- ✅ **Input Sanitization** - Automatic XSS protection
- ✅ **SQL Injection Prevention** - Eloquent ORM protection

## 🎨 Styling & Design

### CSS Variables untuk Dark Mode
```css
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --text-primary: #1e293b;
    --accent-color: #3b82f6;
}

.dark {
    --bg-primary: #1e293b;
    --bg-secondary: #0f172a;
    --text-primary: #f1f5f9;
}
```

### Responsive Breakpoints
- **Mobile**: < 768px
- **Tablet**: 768px - 1024px
- **Desktop**: > 1024px

## 🚨 Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   sudo chown -R www-data:www-data storage/
   sudo chmod -R 755 storage/
   ```

2. **Routes Not Working**
   ```bash
   php artisan route:cache
   php artisan config:cache
   ```

3. **Views Not Loading**
   ```bash
   php artisan view:clear
   php artisan view:cache
   ```

4. **File Upload Errors**
   - Check `php.ini` settings: `upload_max_filesize`, `post_max_size`
   - Verify storage directory permissions
   - Ensure symbolic link exists: `php artisan storage:link`

### Debug Mode

Enable debug mode untuk development:
```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## 📈 Performance Tips

1. **Database Indexing**
   - Indexes sudah dibuat untuk: `is_active`, `degree_level`, `faculty`, `program_name`

2. **Caching**
   ```php
   // Cache statistics
   $stats = Cache::remember('study_programs_stats', 3600, function () {
       return StudyProgram::getStatistics();
   });
   ```

3. **Eager Loading**
   ```php
   // Avoid N+1 queries
   $programs = StudyProgram::with('relatedModel')->get();
   ```

## 🔄 Updates & Maintenance

### Adding New Fields

1. Create migration:
   ```bash
   php artisan make:migration add_new_field_to_study_programs_table
   ```

2. Update model `$fillable` array
3. Update request validation rules
4. Update views and forms

### Backup Database

```bash
php artisan backup:run --only-db
```

## 📞 Support

Jika mengalami masalah:

1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode untuk detail error
3. Verify database connection
4. Check file permissions
5. Clear all caches

## 🎉 Conclusion

Sistem Study Programs Management telah siap digunakan dengan fitur lengkap untuk admin dan public. Sistem ini mengikuti best practices Laravel dan dapat dengan mudah dikustomisasi sesuai kebutuhan.

**Happy coding! 🚀**