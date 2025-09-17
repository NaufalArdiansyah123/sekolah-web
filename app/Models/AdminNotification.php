<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminNotification extends Model
{
    protected $fillable = [
        'type',
        'action',
        'title',
        'message',
        'data',
        'user_id',
        'target_id',
        'target_type',
        'is_read'
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Get the user who performed the action
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the target model (polymorphic)
     */
    public function target()
    {
        return $this->morphTo();
    }

    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope for recent notifications
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }

    /**
     * Get icon based on type and action
     */
    public function getIconAttribute()
    {
        $icons = [
            'student' => [
                'create' => 'fas fa-user-plus text-success',
                'update' => 'fas fa-user-edit text-warning',
                'delete' => 'fas fa-user-minus text-danger',
            ],
            'teacher' => [
                'create' => 'fas fa-chalkboard-teacher text-success',
                'update' => 'fas fa-edit text-warning',
                'delete' => 'fas fa-trash text-danger',
            ],
            'media' => [
                'upload' => 'fas fa-upload text-info',
                'delete' => 'fas fa-trash text-danger',
            ],
            'gallery' => [
                'upload' => 'fas fa-images text-info',
                'delete' => 'fas fa-trash text-danger',
            ],
            'video' => [
                'upload' => 'fas fa-video text-info',
                'delete' => 'fas fa-trash text-danger',
            ]
        ];

        return $icons[$this->type][$this->action] ?? 'fas fa-bell text-primary';
    }

    /**
     * Get color class based on action
     */
    public function getColorClassAttribute()
    {
        $colors = [
            'create' => 'success',
            'update' => 'warning',
            'delete' => 'danger',
            'upload' => 'info',
        ];

        return $colors[$this->action] ?? 'primary';
    }

    /**
     * Get time ago format
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Create notification helper
     */
    public static function createNotification($type, $action, $title, $message, $targetId = null, $targetType = null, $data = null)
    {
        return self::create([
            'type' => $type,
            'action' => $action,
            'title' => $title,
            'message' => $message,
            'user_id' => auth()->id(),
            'target_id' => $targetId,
            'target_type' => $targetType,
            'data' => $data,
        ]);
    }
}