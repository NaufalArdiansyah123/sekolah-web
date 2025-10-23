# TODO: Implementasi Sistem Jadwal Guru

## Tugas Utama
- [x] Buat migration untuk tabel teacher_schedules
- [x] Buat model TeacherSchedule dengan relasi dan accessor
- [x] Buat controller TeacherScheduleController dengan CRUD operations
- [x] Tambahkan routes untuk teacher-schedules
- [x] Buat view index untuk menampilkan daftar jadwal
- [x] Buat view create untuk menambah jadwal baru
- [x] Buat view edit untuk mengedit jadwal
- [x] Buat view show untuk detail jadwal
- [x] Tambahkan menu "Jadwal Guru" di sidebar admin
- [x] Jalankan migration untuk membuat tabel
- [x] Test semua fungsi CRUD

## File yang Dibuat/Diedit
- [x] `database/migrations/2025_10_21_150945_create_teacher_schedules_table.php`
- [x] `app/Models/TeacherSchedule.php`
- [x] `app/Http/Controllers/Admin/TeacherScheduleController.php`
- [x] `routes/web.php` - tambah routes teacher-schedules
- [x] `resources/views/admin/teacher-schedules/index.blade.php`
- [x] `resources/views/admin/teacher-schedules/create.blade.php`
- [x] `resources/views/admin/teacher-schedules/edit.blade.php`
- [x] `resources/views/admin/teacher-schedules/show.blade.php`
- [x] `resources/views/layouts/admin/sidebar.blade.php` - tambah menu

## Fitur yang Diimplementasi
- [x] CRUD jadwal guru (Create, Read, Update, Delete)
- [x] Filter berdasarkan guru, kelas, hari, tahun akademik
- [x] Validasi konflik jadwal untuk guru yang sama
- [x] Toggle status aktif/nonaktif
- [x] AJAX endpoint untuk mendapatkan jadwal guru per hari
- [x] Responsive design dengan AdminLTE
- [x] Pagination dan pencarian

## Testing
- [x] Migration berhasil dijalankan
- [x] Routes terdaftar dengan benar
- [x] Controller methods berfungsi
- [x] Views menampilkan data dengan benar
- [x] Form validation bekerja
- [x] Filter dan pencarian berfungsi
- [x] Menu sidebar muncul dan aktif saat di halaman terkait
