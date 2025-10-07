<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'student_id',
        'started_at',
        'completed_at',
        'score',
        'status'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the quiz that owns the attempt
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the student that owns the attempt
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the answers for the attempt
     */
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class);
    }

    /**
     * Check if attempt is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if attempt is in progress
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Get duration in minutes
     */
    public function getDurationAttribute()
    {
        if (!$this->completed_at || !$this->started_at) {
            return 0;
        }
        
        return $this->started_at->diffInMinutes($this->completed_at);
    }

    /**
     * Get remaining time in minutes
     */
    public function getRemainingTimeAttribute()
    {
        if ($this->isCompleted()) {
            return 0;
        }
        
        $endTime = $this->started_at->addMinutes($this->quiz->duration_minutes);
        $now = now();
        
        if ($now >= $endTime) {
            return 0;
        }
        
        return $now->diffInMinutes($endTime);
    }

    /**
     * Get grade letter
     */
    public function getGradeLetterAttribute()
    {
        if (!$this->score) {
            return 'N/A';
        }
        
        if ($this->score >= 90) return 'A';
        if ($this->score >= 80) return 'B';
        if ($this->score >= 70) return 'C';
        if ($this->score >= 60) return 'D';
        return 'E';
    }
}