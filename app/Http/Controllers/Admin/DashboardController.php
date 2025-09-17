<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Schema, Log};
use App\Services\NotificationService;
use App\Models\{Student, Teacher, BlogPost};

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get dashboard statistics with fallback
            $stats = [
                'total_students' => $this->safeCount(Student::class),
                'active_students' => $this->safeCount(Student::class, ['status' => 'active']),
                'total_teachers' => $this->safeCount(Teacher::class),
                'active_teachers' => $this->safeCount(Teacher::class, ['status' => 'active']),
                'total_posts' => $this->safeCount(BlogPost::class),
                'published_posts' => $this->safeCount(BlogPost::class, ['status' => 'published']),
            ];

            // Get recent notifications with error handling
            $notifications = collect();
            $unreadCount = 0;
            
            try {
                if (class_exists('App\Models\AdminNotification') && \Schema::hasTable('admin_notifications')) {
                    $notifications = NotificationService::getRecentNotifications(5);
                    $unreadCount = NotificationService::getUnreadCount();
                }
            } catch (\Exception $e) {
                \Log::warning('Notification system not available: ' . $e->getMessage());
            }

            return view('admin.dashboard', [
                'pageTitle' => 'Dashboard Admin',
                'breadcrumb' => [],
                'stats' => $stats,
                'notifications' => $notifications,
                'unreadCount' => $unreadCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            
            // Fallback data if everything fails
            return view('admin.dashboard', [
                'pageTitle' => 'Dashboard Admin',
                'breadcrumb' => [],
                'stats' => [
                    'total_students' => 0,
                    'active_students' => 0,
                    'total_teachers' => 0,
                    'active_teachers' => 0,
                    'total_posts' => 0,
                    'published_posts' => 0,
                ],
                'notifications' => collect(),
                'unreadCount' => 0
            ]);
        }
    }
    
    /**
     * Safely count records with error handling
     */
    private function safeCount($model, $conditions = [])
    {
        try {
            $query = $model::query();
            
            foreach ($conditions as $field => $value) {
                $query->where($field, $value);
            }
            
            return $query->count();
        } catch (\Exception $e) {
            \Log::warning("Failed to count {$model}: " . $e->getMessage());
            return 0;
        }
    }

    public function profile()
    {
        return view('admin.profile', [
            'pageTitle' => 'Profile',
            'breadcrumb' => [
                ['title' => 'Profile']
            ]
        ]);
    }

    public function settings()
    {
        return view('admin.settings', [
            'pageTitle' => 'Settings',
            'breadcrumb' => [
                ['title' => 'Settings']
            ]
        ]);
    }
}