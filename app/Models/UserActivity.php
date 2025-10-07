<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'description',
        'properties',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the activity.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Log a user activity.
     */
    public static function log(int $userId, string $type, string $description, array $properties = [], ?string $ipAddress = null, ?string $userAgent = null): self
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => $ipAddress ?? request()->ip(),
            'user_agent' => $userAgent ?? request()->userAgent(),
        ]);
    }

    /**
     * Get activities for a specific user.
     */
    public static function forUser(int $userId, int $limit = 10)
    {
        return self::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get recent activities.
     */
    public static function recent(int $limit = 50)
    {
        return self::with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Clean up old activities (older than specified days).
     */
    public static function cleanup(int $days = 90): int
    {
        return self::where('created_at', '<', now()->subDays($days))->delete();
    }
}