<?php

namespace App\Services;

use App\Models\AdminNotification;

class NotificationService
{
    /**
     * Create student notification
     */
    public static function studentAction($action, $student, $additionalData = [])
    {
        $messages = [
            'create' => "Siswa baru '{$student->name}' telah ditambahkan ke kelas {$student->class}",
            'update' => "Data siswa '{$student->name}' telah diperbarui",
            'delete' => "Siswa '{$student->name}' telah dihapus dari sistem",
        ];

        $titles = [
            'create' => 'Siswa Baru Ditambahkan',
            'update' => 'Data Siswa Diperbarui',
            'delete' => 'Siswa Dihapus',
        ];

        AdminNotification::createNotification(
            'student',
            $action,
            $titles[$action] ?? 'Aktivitas Siswa',
            $messages[$action] ?? "Aktivitas {$action} pada siswa {$student->name}",
            $student->id,
            get_class($student),
            array_merge([
                'student_name' => $student->name,
                'student_nis' => $student->nis,
                'student_class' => $student->class,
            ], $additionalData)
        );
    }

    /**
     * Create teacher notification
     */
    public static function teacherAction($action, $teacher, $additionalData = [])
    {
        $messages = [
            'create' => "Guru baru '{$teacher->name}' telah ditambahkan dengan mata pelajaran {$teacher->subject}",
            'update' => "Data guru '{$teacher->name}' telah diperbarui",
            'delete' => "Guru '{$teacher->name}' telah dihapus dari sistem",
        ];

        $titles = [
            'create' => 'Guru Baru Ditambahkan',
            'update' => 'Data Guru Diperbarui',
            'delete' => 'Guru Dihapus',
        ];

        AdminNotification::createNotification(
            'teacher',
            $action,
            $titles[$action] ?? 'Aktivitas Guru',
            $messages[$action] ?? "Aktivitas {$action} pada guru {$teacher->name}",
            $teacher->id,
            get_class($teacher),
            array_merge([
                'teacher_name' => $teacher->name,
                'teacher_nip' => $teacher->nip,
                'teacher_subject' => $teacher->subject,
            ], $additionalData)
        );
    }

    /**
     * Create media upload notification
     */
    public static function mediaUpload($type, $filename, $size = null, $additionalData = [])
    {
        $messages = [
            'gallery' => "Foto baru '{$filename}' telah diupload ke galeri",
            'video' => "Video baru '{$filename}' telah diupload",
            'slideshow' => "Gambar slideshow '{$filename}' telah diupload",
            'media' => "File media '{$filename}' telah diupload",
        ];

        $titles = [
            'gallery' => 'Foto Baru Diupload',
            'video' => 'Video Baru Diupload',
            'slideshow' => 'Slideshow Diupload',
            'media' => 'Media Diupload',
        ];

        AdminNotification::createNotification(
            $type,
            'upload',
            $titles[$type] ?? 'Media Diupload',
            $messages[$type] ?? "File {$filename} telah diupload",
            null,
            null,
            array_merge([
                'filename' => $filename,
                'file_size' => $size,
                'upload_time' => now()->toDateTimeString(),
            ], $additionalData)
        );
    }

    /**
     * Create bulk action notification
     */
    public static function bulkAction($type, $action, $count, $additionalData = [])
    {
        $messages = [
            'student' => [
                'delete' => "{$count} siswa telah dihapus secara bersamaan",
                'activate' => "{$count} siswa telah diaktifkan",
                'deactivate' => "{$count} siswa telah dinonaktifkan",
                'graduate' => "{$count} siswa telah diluluskan",
            ],
        ];

        $titles = [
            'student' => [
                'delete' => 'Hapus Siswa Massal',
                'activate' => 'Aktivasi Siswa Massal',
                'deactivate' => 'Nonaktifkan Siswa Massal',
                'graduate' => 'Kelulusan Siswa Massal',
            ],
        ];

        AdminNotification::createNotification(
            $type,
            $action,
            $titles[$type][$action] ?? 'Aksi Massal',
            $messages[$type][$action] ?? "Aksi {$action} dilakukan pada {$count} {$type}",
            null,
            null,
            array_merge([
                'count' => $count,
                'bulk_action' => true,
            ], $additionalData)
        );
    }

    /**
     * Get recent notifications for dashboard
     */
    public static function getRecentNotifications($limit = 10)
    {
        try {
            if (!class_exists('App\Models\AdminNotification')) {
                return collect();
            }
            
            return AdminNotification::with('user')
                ->latest()
                ->take($limit)
                ->get();
        } catch (\Exception $e) {
            \Log::warning('Failed to get recent notifications: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get unread count
     */
    public static function getUnreadCount()
    {
        try {
            if (!class_exists('App\Models\AdminNotification')) {
                return 0;
            }
            
            return AdminNotification::unread()->count();
        } catch (\Exception $e) {
            \Log::warning('Failed to get unread count: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * Mark all as read
     */
    public static function markAllAsRead()
    {
        AdminNotification::unread()->update(['is_read' => true]);
    }

    /**
     * Create student registration notification
     */
    public static function createStudentNotification($action, $student, $title, $message, $additionalData = [])
    {
        try {
            // Check if AdminNotification model exists
            if (!class_exists('App\Models\AdminNotification')) {
                \Log::info('AdminNotification model not found, skipping notification creation');
                return;
            }

            // Check if the model has the createNotification method
            if (!method_exists('App\Models\AdminNotification', 'createNotification')) {
                \Log::info('AdminNotification::createNotification method not found, skipping notification creation');
                return;
            }

            // Safely get student data
            $studentData = [
                'student_name' => $student->name ?? 'Unknown',
                'student_email' => $student->email ?? 'Unknown',
                'registration_date' => $student->created_at ? $student->created_at->toDateTimeString() : now()->toDateTimeString(),
            ];

            // Add optional fields if they exist
            if (isset($student->nis)) {
                $studentData['student_nis'] = $student->nis;
            }
            if (isset($student->class)) {
                $studentData['student_class'] = $student->class;
            }

            AdminNotification::createNotification(
                'student',
                $action,
                $title,
                $message,
                $student->id,
                get_class($student),
                array_merge($studentData, $additionalData)
            );

            \Log::info('Student notification created successfully', [
                'action' => $action,
                'student_id' => $student->id,
                'title' => $title
            ]);

        } catch (\Exception $e) {
            \Log::warning('Failed to create student notification (non-critical)', [
                'error' => $e->getMessage(),
                'student_id' => $student->id ?? 'unknown',
                'action' => $action
            ]);
        }
    }
}