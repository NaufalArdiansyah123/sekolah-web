<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Schema;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share notification data with admin layout
        View::composer(['layouts.admin*', 'admin.*'], function ($view) {
            try {
                // Check if user is authenticated and has admin role
                if (auth()->check() && auth()->user()->hasRole('admin')) {
                    // Check if notification system is available
                    if (class_exists('App\Models\AdminNotification') && Schema::hasTable('admin_notifications')) {
                        $unreadCount = NotificationService::getUnreadCount();
                        $recentNotifications = NotificationService::getRecentNotifications(5);
                        
                        $view->with([
                            'unreadCount' => $unreadCount,
                            'recentNotifications' => $recentNotifications
                        ]);
                    } else {
                        $view->with([
                            'unreadCount' => 0,
                            'recentNotifications' => collect()
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Fallback if notification system fails
                $view->with([
                    'unreadCount' => 0,
                    'recentNotifications' => collect()
                ]);
            }
        });
    }
}