<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'student_id',
        'score',
        'percentage',
        'grade',
        'started_at',
        'completed_at',
        'duration_taken',
        'status',
        'answers'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers' => 'array',
    ];

    /**
     * Get the assessment this result belongs to
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get the student this result belongs to
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Calculate grade based on percentage
     */
    public function calculateGrade(): string
    {
        if ($this->percentage === null) {
            return '-';
        }

        return match(true) {
            $this->percentage >= 90 => 'A',
            $this->percentage >= 80 => 'B',
            $this->percentage >= 70 => 'C',
            $this->percentage >= 60 => 'D',
            default => 'F'
        };
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute(): string
    {
        if (!$this->duration_taken) {
            return '-';
        }

        $hours = floor($this->duration_taken / 60);
        $minutes = $this->duration_taken % 60;

        if ($hours > 0) {
            return "{$hours}h {$minutes}m";
        }

        return "{$minutes}m";
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'completed' => 'badge-success',
            'in_progress' => 'badge-warning',
            'submitted' => 'badge-info',
            'not_started' => 'badge-secondary',
            default => 'badge-secondary'
        };
    }

    /**
     * Check if result is completed
     */
    public function getIsCompletedAttribute(): bool
    {
        return $this->status === 'completed' && $this->completed_at !== null;
    }

    /**
     * Get time remaining if in progress
     */
    public function getTimeRemainingAttribute(): ?int
    {
        if ($this->status !== 'in_progress' || !$this->started_at) {
            return null;
        }

        $elapsed = now()->diffInMinutes($this->started_at);
        $remaining = $this->assessment->duration - $elapsed;

        return max(0, $remaining);
    }

    /**
     * Auto-calculate percentage and grade when score is set
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($result) {
            if ($result->score !== null && $result->assessment) {
                $result->percentage = ($result->score / $result->assessment->max_score) * 100;
                $result->grade = $result->calculateGrade();
            }
        });
    }
}