<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class NotificationService
{
    /**
     * Show success notification
     */
    public static function success($title, $message = null, $details = [])
    {
        return self::addNotification('success', $title, $message, $details);
    }

    /**
     * Show error notification
     */
    public static function error($title, $message = null, $details = [])
    {
        return self::addNotification('error', $title, $message, $details);
    }

    /**
     * Show warning notification
     */
    public static function warning($title, $message = null, $details = [])
    {
        return self::addNotification('warning', $title, $message, $details);
    }

    /**
     * Show info notification
     */
    public static function info($title, $message = null, $details = [])
    {
        return self::addNotification('info', $title, $message, $details);
    }

    /**
     * Add notification to session
     */
    private static function addNotification($type, $title, $message = null, $details = [])
    {
        $notification = [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'details' => $details,
            'timestamp' => now()->format('H:i:s'),
            'id' => uniqid()
        ];

        Session::flash('notification', $notification);
        
        return $notification;
    }

    /**
     * Create notification for create operation
     */
    public static function created($entityName, $entityTitle = null, $additionalInfo = [])
    {
        $title = "✅ {$entityName} Berhasil Dibuat";
        $message = $entityTitle ? "'{$entityTitle}' telah berhasil ditambahkan ke sistem." : "Data baru telah berhasil ditambahkan.";
        
        $details = array_merge([
            'action' => 'create',
            'entity' => $entityName,
            'time' => now()->format('d M Y, H:i:s')
        ], $additionalInfo);

        return self::success($title, $message, $details);
    }

    /**
     * Create notification for update operation
     */
    public static function updated($entityName, $entityTitle = null, $changes = [])
    {
        $title = "📝 {$entityName} Berhasil Diperbarui";
        $message = $entityTitle ? "'{$entityTitle}' telah berhasil diperbarui." : "Data telah berhasil diperbarui.";
        
        $details = [
            'action' => 'update',
            'entity' => $entityName,
            'changes' => $changes,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::success($title, $message, $details);
    }

    /**
     * Create notification for delete operation
     */
    public static function deleted($entityName, $entityTitle = null, $additionalInfo = [])
    {
        $title = "🗑️ {$entityName} Berhasil Dihapus";
        $message = $entityTitle ? "'{$entityTitle}' telah berhasil dihapus dari sistem." : "Data telah berhasil dihapus.";
        
        $details = array_merge([
            'action' => 'delete',
            'entity' => $entityName,
            'time' => now()->format('d M Y, H:i:s')
        ], $additionalInfo);

        return self::success($title, $message, $details);
    }

    /**
     * Create notification for activation operation
     */
    public static function activated($entityName, $entityTitle = null)
    {
        $title = "🟢 {$entityName} Diaktifkan";
        $message = $entityTitle ? "'{$entityTitle}' telah berhasil diaktifkan." : "Data telah berhasil diaktifkan.";
        
        $details = [
            'action' => 'activate',
            'entity' => $entityName,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::success($title, $message, $details);
    }

    /**
     * Create notification for deactivation operation
     */
    public static function deactivated($entityName, $entityTitle = null)
    {
        $title = "🔴 {$entityName} Dinonaktifkan";
        $message = $entityTitle ? "'{$entityTitle}' telah berhasil dinonaktifkan." : "Data telah berhasil dinonaktifkan.";
        
        $details = [
            'action' => 'deactivate',
            'entity' => $entityName,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::success($title, $message, $details);
    }

    /**
     * Create notification for validation errors
     */
    public static function validationError($errors = [])
    {
        $title = "❌ Validasi Gagal";
        $message = "Terdapat kesalahan dalam data yang dimasukkan. Silakan periksa kembali.";
        
        $details = [
            'action' => 'validation_error',
            'errors' => $errors,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::error($title, $message, $details);
    }

    /**
     * Create notification for file upload
     */
    public static function fileUploaded($fileName, $fileType = 'file')
    {
        $title = "📁 File Berhasil Diunggah";
        $message = "File '{$fileName}' telah berhasil diunggah.";
        
        $details = [
            'action' => 'file_upload',
            'file_name' => $fileName,
            'file_type' => $fileType,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::success($title, $message, $details);
    }

    /**
     * Create notification for bulk operations
     */
    public static function bulkOperation($action, $count, $entityName)
    {
        $title = "📊 Operasi Massal Berhasil";
        $message = "{$count} {$entityName} telah berhasil {$action}.";
        
        $details = [
            'action' => 'bulk_operation',
            'operation' => $action,
            'count' => $count,
            'entity' => $entityName,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::success($title, $message, $details);
    }

    /**
     * Get notification icon based on type
     */
    public static function getIcon($type)
    {
        $icons = [
            'success' => '✅',
            'error' => '❌',
            'warning' => '⚠️',
            'info' => 'ℹ️'
        ];

        return $icons[$type] ?? 'ℹ️';
    }

    /**
     * Get notification color based on type
     */
    public static function getColor($type)
    {
        $colors = [
            'success' => 'green',
            'error' => 'red',
            'warning' => 'yellow',
            'info' => 'blue'
        ];

        return $colors[$type] ?? 'blue';
    }

    /**
     * Get unread notification count
     */
    public static function getUnreadCount()
    {
        try {
            // Check if AdminNotification model exists and table is available
            if (class_exists('App\Models\AdminNotification') && \Schema::hasTable('admin_notifications')) {
                return \App\Models\AdminNotification::where('is_read', false)->count();
            }
            
            // Fallback to session-based notifications
            $notifications = self::getAllNotifications();
            $unreadCount = 0;
            
            foreach ($notifications as $notification) {
                if (!isset($notification['read']) || !$notification['read']) {
                    $unreadCount++;
                }
            }
            
            return $unreadCount;
        } catch (\Exception $e) {
            // Return 0 if there's any error
            return 0;
        }
    }

    /**
     * Get all notifications from session
     */
    public static function getAllNotifications()
    {
        return Session::get('notifications', []);
    }

    /**
     * Clear all notifications
     */
    public static function clearAll()
    {
        Session::forget('notifications');
        Session::forget('notification');
    }

    /**
     * Add multiple notifications to session
     */
    public static function addMultiple($notifications)
    {
        $existingNotifications = Session::get('notifications', []);
        $allNotifications = array_merge($existingNotifications, $notifications);
        Session::put('notifications', $allNotifications);
        
        return $allNotifications;
    }

    /**
     * Get recent notifications (last N notifications)
     */
    public static function getRecent($limit = 5)
    {
        $notifications = self::getAllNotifications();
        return array_slice($notifications, -$limit, $limit);
    }

    /**
     * Get recent notifications for admin
     */
    public static function getRecentNotifications($limit = 5)
    {
        try {
            // Check if AdminNotification model exists and table is available
            if (class_exists('App\Models\AdminNotification') && \Schema::hasTable('admin_notifications')) {
                return \App\Models\AdminNotification::with('user')
                    ->latest()
                    ->limit($limit)
                    ->get();
            }
            
            // Fallback to session-based notifications
            return collect(self::getRecent($limit));
        } catch (\Exception $e) {
            // Return empty collection if there's any error
            return collect();
        }
    }

    /**
     * Mark notification as read
     */
    public static function markAsRead($notificationId)
    {
        $notifications = Session::get('notifications', []);
        
        foreach ($notifications as &$notification) {
            if ($notification['id'] === $notificationId) {
                $notification['read'] = true;
                break;
            }
        }
        
        Session::put('notifications', $notifications);
    }

    /**
     * Mark all notifications as read
     */
    public static function markAllAsRead()
    {
        try {
            // Check if AdminNotification model exists and table is available
            if (class_exists('App\Models\AdminNotification') && Schema::hasTable('admin_notifications')) {
                $count = \App\Models\AdminNotification::where('is_read', false)->count();
                \App\Models\AdminNotification::where('is_read', false)->update(['is_read' => true]);
                return $count;
            }
            
            // Fallback to session-based notifications
            $notifications = Session::get('notifications', []);
            
            foreach ($notifications as &$notification) {
                $notification['read'] = true;
            }
            
            Session::put('notifications', $notifications);
            
            return count($notifications);
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get notification statistics
     */
    public static function getStats()
    {
        $notifications = self::getAllNotifications();
        
        $stats = [
            'total' => count($notifications),
            'unread' => 0,
            'by_type' => [
                'success' => 0,
                'error' => 0,
                'warning' => 0,
                'info' => 0
            ]
        ];
        
        foreach ($notifications as $notification) {
            if (!isset($notification['read']) || !$notification['read']) {
                $stats['unread']++;
            }
            
            $type = $notification['type'] ?? 'info';
            if (isset($stats['by_type'][$type])) {
                $stats['by_type'][$type]++;
            }
        }
        
        return $stats;
    }

    /**
     * Create system notification (for admin alerts)
     */
    public static function system($title, $message = null, $priority = 'normal')
    {
        $details = [
            'action' => 'system',
            'priority' => $priority,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::info($title, $message, $details);
    }

    /**
     * Create maintenance notification
     */
    public static function maintenance($title, $message = null, $scheduledTime = null)
    {
        $details = [
            'action' => 'maintenance',
            'scheduled_time' => $scheduledTime,
            'time' => now()->format('d M Y, H:i:s')
        ];

        return self::warning($title, $message, $details);
    }
}