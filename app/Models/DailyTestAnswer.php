<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTestAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'attempt_id',
        'question_id',
        'answer',
        'is_correct',
        'points_earned',
        'teacher_feedback'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'decimal:2'
    ];

    /**
     * Get the attempt that owns the answer
     */
    public function attempt()
    {
        return $this->belongsTo(DailyTestAttempt::class, 'attempt_id');
    }

    /**
     * Get the question that owns the answer
     */
    public function question()
    {
        return $this->belongsTo(DailyTestQuestion::class, 'question_id');
    }

    /**
     * Check and set if answer is correct
     */
    public function checkCorrectness()
    {
        if ($this->question->type === 'multiple_choice') {
            $this->is_correct = $this->question->isCorrectAnswer($this->answer);
            $this->points_earned = $this->is_correct ? $this->question->points : 0;
        } else {
            // Essay questions need manual grading
            $this->is_correct = null;
            $this->points_earned = 0;
        }
        
        $this->save();
    }

    /**
     * Grade essay answer (for teachers)
     */
    public function gradeEssay($points, $feedback = null)
    {
        if ($this->question->type !== 'essay') {
            return false;
        }

        $maxPoints = $this->question->points;
        $this->points_earned = min($points, $maxPoints);
        $this->teacher_feedback = $feedback;
        $this->save();

        // Recalculate attempt score
        $this->attempt->calculateScore();

        return true;
    }

    /**
     * Get formatted answer for display
     */
    public function getFormattedAnswerAttribute()
    {
        if ($this->question->type === 'multiple_choice') {
            $options = $this->question->formatted_options;
            return $options[$this->answer] ?? $this->answer;
        }
        
        return $this->answer;
    }

    /**
     * Get answer letter for multiple choice
     */
    public function getAnswerLetterAttribute()
    {
        if ($this->question->type === 'multiple_choice') {
            $letters = $this->question->option_letters;
            return $letters[$this->answer] ?? $this->answer;
        }
        
        return null;
    }

    /**
     * Scope for correct answers
     */
    public function scopeCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    /**
     * Scope for incorrect answers
     */
    public function scopeIncorrect($query)
    {
        return $query->where('is_correct', false);
    }

    /**
     * Scope for essay answers
     */
    public function scopeEssay($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('type', 'essay');
        });
    }

    /**
     * Scope for multiple choice answers
     */
    public function scopeMultipleChoice($query)
    {
        return $query->whereHas('question', function ($q) {
            $q->where('type', 'multiple_choice');
        });
    }
}