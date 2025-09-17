<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subject',
        'class',
        'type',
        'date',
        'duration',
        'max_score',
        'status',
        'description',
        'instructions',
        'user_id'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    /**
     * Get the teacher who created this assessment
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the questions for this assessment
     */
    public function questions(): HasMany
    {
        return $this->hasMany(AssessmentQuestion::class)->orderBy('question_number');
    }

    /**
     * Get the results for this assessment
     */
    public function results(): HasMany
    {
        return $this->hasMany(AssessmentResult::class);
    }

    /**
     * Get completed results only
     */
    public function completedResults(): HasMany
    {
        return $this->hasMany(AssessmentResult::class)->where('status', 'completed');
    }

    /**
     * Get total questions count
     */
    public function getTotalQuestionsAttribute(): int
    {
        return $this->questions()->count();
    }

    /**
     * Get participants count (students who have access to this assessment)
     */
    public function getParticipantsAttribute(): int
    {
        // For now, we'll use a mock count based on class
        // In a real implementation, you'd count students in the specific class
        return $this->results()->distinct('student_id')->count() ?: 25; // Default mock count
    }

    /**
     * Get completed count
     */
    public function getCompletedAttribute(): int
    {
        return $this->completedResults()->count();
    }

    /**
     * Get completion percentage
     */
    public function getCompletionPercentageAttribute(): float
    {
        $participants = $this->participants;
        if ($participants === 0) {
            return 0;
        }
        return round(($this->completed / $participants) * 100, 1);
    }

    /**
     * Get average score
     */
    public function getAverageScoreAttribute(): float
    {
        return $this->completedResults()->avg('score') ?: 0;
    }

    /**
     * Check if assessment is active
     */
    public function getIsActiveAttribute(): bool
    {
        return $this->status === 'active' && 
               $this->date <= now() && 
               $this->date->addMinutes($this->duration) >= now();
    }

    /**
     * Check if assessment is upcoming
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->status === 'scheduled' && $this->date > now();
    }

    /**
     * Check if assessment is past due
     */
    public function getIsPastDueAttribute(): bool
    {
        return $this->date->addMinutes($this->duration) < now();
    }

    /**
     * Get formatted date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->date->format('d M Y, H:i');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'active' => 'status-active',
            'completed' => 'status-completed',
            'scheduled' => 'status-scheduled',
            'draft' => 'status-draft',
            default => 'status-draft'
        };
    }

    /**
     * Get type icon
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'exam' => '📋',
            'quiz' => '❓',
            'test' => '📝',
            'practical' => '🔬',
            'assignment' => '📚',
            default => '📋'
        };
    }

    /**
     * Scope for teacher's assessments
     */
    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('user_id', $teacherId);
    }

    /**
     * Scope for specific subject
     */
    public function scopeBySubject($query, $subject)
    {
        if ($subject) {
            return $query->where('subject', $subject);
        }
        return $query;
    }

    /**
     * Scope for specific class
     */
    public function scopeByClass($query, $class)
    {
        if ($class) {
            return $query->where('class', $class);
        }
        return $query;
    }

    /**
     * Scope for specific type
     */
    public function scopeByType($query, $type)
    {
        if ($type) {
            return $query->where('type', $type);
        }
        return $query;
    }

    /**
     * Scope for specific status
     */
    public function scopeByStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        return $query;
    }

    /**
     * Auto-update status based on date
     */
    public function updateStatus(): void
    {
        if ($this->status === 'scheduled' && $this->date <= now()) {
            $this->update(['status' => 'active']);
        } elseif ($this->status === 'active' && $this->is_past_due) {
            $this->update(['status' => 'completed']);
        }
    }
}