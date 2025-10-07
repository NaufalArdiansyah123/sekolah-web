<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get notifications for dashboard
     */
    public function index(Request $request)
    {
        $query = AdminNotification::with('user');
        
        // Filter by type (category)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        // Filter by status (read/unread)
        if ($request->filled('status')) {
            if ($request->status === 'unread') {
                $query->where('is_read', false);
            } elseif ($request->status === 'read') {
                $query->where('is_read', true);
            }
        }
        
        // Search by title or message
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }
        
        $notifications = $query->latest()->paginate(20);
        
        // Get available categories for filter
        $categories = AdminNotification::select('type')
            ->distinct()
            ->pluck('type')
            ->mapWithKeys(function($type) {
                $labels = [
                    'student' => 'Siswa',
                    'teacher' => 'Guru', 
                    'slideshow' => 'Slideshow',
                    'gallery' => 'Galeri',
                    'video' => 'Video',
                    'media' => 'Media'
                ];
                return [$type => $labels[$type] ?? ucfirst($type)];
            });
            
        // Get statistics
        $stats = [
            'total' => AdminNotification::count(),
            'unread' => AdminNotification::where('is_read', false)->count(),
            'today' => AdminNotification::whereDate('created_at', today())->count(),
            'this_week' => AdminNotification::where('created_at', '>=', now()->startOfWeek())->count(),
        ];
        
        // Get category counts
        $categoryStats = AdminNotification::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type');

        return view('admin.notifications.index', compact('notifications', 'categories', 'stats', 'categoryStats'));
    }

    /**
     * Get recent notifications (AJAX)
     */
    public function recent()
    {
        try {
            $notifications = NotificationService::getRecentNotifications(10);
            $unreadCount = NotificationService::getUnreadCount();

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'unread_count' => $unreadCount,
                'html' => view('admin.partials.notifications-fixed', compact('notifications'))->render()
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading recent notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Gagal memuat notifikasi',
                'html' => '<div class="p-4 text-center text-red-500"><i class="fas fa-exclamation-triangle mb-2"></i><br>Gagal memuat notifikasi</div>'
            ]);
        }
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        try {
            $notification = AdminNotification::findOrFail($id);
            $notification->markAsRead();

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error marking notification as read', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Gagal menandai notifikasi sebagai dibaca'
            ], 500);
        }
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        NotificationService::markAllAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Get unread count
     */
    public function unreadCount()
    {
        return response()->json([
            'count' => NotificationService::getUnreadCount()
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        try {
            $notification = AdminNotification::findOrFail($id);
            $notification->delete();

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting notification', [
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'error' => 'Gagal menghapus notifikasi'
            ], 500);
        }
    }

    /**
     * Clear old notifications (older than 30 days)
     */
    public function clearOld()
    {
        $deleted = AdminNotification::where('created_at', '<', now()->subDays(30))->delete();

        return response()->json([
            'success' => true,
            'deleted_count' => $deleted
        ]);
    }
}