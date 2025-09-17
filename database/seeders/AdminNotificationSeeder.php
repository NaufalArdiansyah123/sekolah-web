<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminNotification;
use App\Models\User;

class AdminNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user
        $adminUser = User::whereHas('roles', function($query) {
            $query->whereIn('name', ['admin', 'super_admin', 'superadministrator']);
        })->first();

        if (!$adminUser) {
            // Create a default admin user if none exists
            $adminUser = User::create([
                'name' => 'System Admin',
                'email' => 'admin@sekolah.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
        }

        // Create sample notifications
        $notifications = [
            [
                'type' => 'student',
                'action' => 'create',
                'title' => 'Siswa Baru Ditambahkan',
                'message' => 'Siswa baru "Ahmad Rizki" telah ditambahkan ke kelas X IPA 1',
                'data' => [
                    'student_name' => 'Ahmad Rizki',
                    'student_nis' => '2024001',
                    'student_class' => 'X IPA 1',
                ],
                'user_id' => $adminUser->id,
                'target_id' => 1,
                'target_type' => 'App\Models\Student',
                'is_read' => false,
                'created_at' => now()->subMinutes(30),
            ],
            [
                'type' => 'teacher',
                'action' => 'update',
                'title' => 'Data Guru Diperbarui',
                'message' => 'Data guru "Siti Nurhaliza, S.Pd" telah diperbarui',
                'data' => [
                    'teacher_name' => 'Siti Nurhaliza, S.Pd',
                    'teacher_nip' => '198501012010012001',
                    'teacher_subject' => 'Matematika',
                ],
                'user_id' => $adminUser->id,
                'target_id' => 1,
                'target_type' => 'App\Models\Teacher',
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'type' => 'gallery',
                'action' => 'upload',
                'title' => 'Foto Baru Diupload',
                'message' => 'Foto kegiatan "Upacara Bendera" telah diupload ke galeri',
                'data' => [
                    'filename' => 'upacara-bendera-2024.jpg',
                    'file_size' => '2.5 MB',
                    'upload_time' => now()->subHours(4)->toDateTimeString(),
                ],
                'user_id' => $adminUser->id,
                'target_id' => null,
                'target_type' => null,
                'is_read' => true,
                'created_at' => now()->subHours(4),
            ],
            [
                'type' => 'video',
                'action' => 'upload',
                'title' => 'Video Baru Diupload',
                'message' => 'Video pembelajaran "Pengenalan Fisika Dasar" telah diupload',
                'data' => [
                    'filename' => 'fisika-dasar-intro.mp4',
                    'file_size' => '125 MB',
                    'upload_time' => now()->subHours(6)->toDateTimeString(),
                ],
                'user_id' => $adminUser->id,
                'target_id' => null,
                'target_type' => null,
                'is_read' => true,
                'created_at' => now()->subHours(6),
            ],
            [
                'type' => 'student',
                'action' => 'delete',
                'title' => 'Siswa Dihapus',
                'message' => 'Siswa "Budi Santoso" telah dihapus dari sistem',
                'data' => [
                    'student_name' => 'Budi Santoso',
                    'student_nis' => '2023045',
                    'student_class' => 'XII IPS 2',
                ],
                'user_id' => $adminUser->id,
                'target_id' => null,
                'target_type' => null,
                'is_read' => true,
                'created_at' => now()->subDay(),
            ],
            [
                'type' => 'slideshow',
                'action' => 'upload',
                'title' => 'Slideshow Diupload',
                'message' => 'Gambar slideshow "Prestasi Siswa 2024" telah diupload',
                'data' => [
                    'filename' => 'prestasi-siswa-2024.jpg',
                    'file_size' => '1.8 MB',
                    'upload_time' => now()->subDays(2)->toDateTimeString(),
                ],
                'user_id' => $adminUser->id,
                'target_id' => null,
                'target_type' => null,
                'is_read' => true,
                'created_at' => now()->subDays(2),
            ],
        ];

        foreach ($notifications as $notification) {
            AdminNotification::create($notification);
        }

        $this->command->info('Admin notifications seeded successfully!');
    }
}