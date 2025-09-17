<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BroadcastMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'extracurricular_id',
        'user_id',
        'subject',
        'content',
        'send_email',
        'post_public',
        'send_sms',
        'schedule_type',
        'scheduled_at',
        'status',
        'sent_at',
        'recipients_count',
        'emails_sent',
        'sms_sent',
        'delivery_log',
        'error_message',
    ];

    protected $casts = [
        'send_email' => 'boolean',
        'post_public' => 'boolean',
        'send_sms' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivery_log' => 'array',
    ];

    /**
     * Get the extracurricular that owns the broadcast message.
     */
    public function extracurricular(): BelongsTo
    {
        return $this->belongsTo(Extracurricular::class);
    }

    /**
     * Get the user who sent the broadcast message.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for public broadcasts
     */
    public function scopePublic($query)
    {
        return $query->where('post_public', true)
                    ->where('status', 'sent');
    }

    /**
     * Scope for recent broadcasts
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Scope for scheduled broadcasts
     */
    public function scopeScheduled($query)
    {
        return $query->where('schedule_type', 'later')
                    ->where('status', 'pending')
                    ->where('scheduled_at', '<=', now());
    }

    /**
     * Get formatted content for display
     */
    public function getFormattedContentAttribute()
    {
        return nl2br(e($this->content));
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'sent' => 'bg-success',
            'pending' => 'bg-warning',
            'failed' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get delivery summary
     */
    public function getDeliverySummaryAttribute()
    {
        $summary = [];
        
        if ($this->send_email && $this->emails_sent > 0) {
            $summary[] = "{$this->emails_sent} emails sent";
        }
        
        if ($this->send_sms && $this->sms_sent > 0) {
            $summary[] = "{$this->sms_sent} SMS sent";
        }
        
        if ($this->post_public) {
            $summary[] = "Posted publicly";
        }
        
        return implode(', ', $summary) ?: 'No delivery methods';
    }
}