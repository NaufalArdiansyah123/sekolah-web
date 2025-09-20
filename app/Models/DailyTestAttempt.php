<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTestAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_test_id',
        'student_id',
        'started_at',
        'completed_at',
        'score',
        'total_questions',
        'correct_answers',
        'answers',
        'status',
        'notes'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'answers' => 'array',
        'score' => 'decimal:2'
    ];

    /**
     * Get the daily test that owns the attempt
     */
    public function dailyTest()
    {
        return $this->belongsTo(DailyTest::class);
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
    public function testAnswers()
    {
        return $this->hasMany(DailyTestAnswer::class, 'attempt_id');
    }

    /**
     * Check if attempt is in progress
     */
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if attempt is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if attempt is abandoned
     */
    public function isAbandoned()
    {
        return $this->status === 'abandoned';
    }

    /**
     * Get time remaining in minutes
     */
    public function getTimeRemainingAttribute()
    {
        if ($this->isCompleted() || $this->isAbandoned()) {
            return 0;
        }

        $endTime = $this->started_at->addMinutes($this->dailyTest->duration);
        $remaining = now()->diffInMinutes($endTime, false);
        
        return max(0, $remaining);
    }

    /**
     * Check if time is up
     */
    public function isTimeUp()
    {
        return $this->getTimeRemainingAttribute() <= 0;
    }

    /**
     * Get duration taken in minutes
     */
    public function getDurationTakenAttribute()
    {
        if (!$this->completed_at) {
            return now()->diffInMinutes($this->started_at);
        }
        
        return $this->completed_at->diffInMinutes($this->started_at);
    }

    /**
     * Get percentage score
     */
    public function getPercentageAttribute()
    {
        return $this->score ?? 0;
    }

    /**
     * Get grade letter
     */
    public function getGradeLetterAttribute()
    {
        $score = $this->score ?? 0;
        
        if ($score >= 90) return 'A';
        if ($score >= 80) return 'B';
        if ($score >= 70) return 'C';
        if ($score >= 60) return 'D';
        return 'E';
    }

    /**
     * Calculate and update score
     */
    public function calculateScore()
    {
        $totalPoints = $this->dailyTest->total_points;
        
        if ($totalPoints == 0) {
            $this->score = 0;
            $this->save();
            return;
        }

        $earnedPoints = $this->testAnswers()->sum('points_earned');
        $this->score = ($earnedPoints / $totalPoints) * 100;
        
        // Count correct answers for multiple choice
        $this->correct_answers = $this->testAnswers()->where('is_correct', true)->count();
        
        $this->save();
    }

    /**
     * Complete the attempt
     */
    public function complete()
    {
        $this->completed_at = now();
        $this->status = 'completed';
        $this->calculateScore();
        $this->save();
    }

    /**
     * Abandon the attempt
     */
    public function abandon()
    {
        $this->status = 'abandoned';
        $this->save();
    }

    /**
     * Scope for completed attempts
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope for in progress attempts
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }
}