<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'answer',
        'is_correct',
        'points_earned'
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'points_earned' => 'decimal:2'
    ];

    /**
     * Get the quiz attempt that owns the answer
     */
    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'quiz_attempt_id');
    }

    /**
     * Get the question that owns the answer
     */
    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'question_id');
    }

    /**
     * Check if the answer is correct
     */
    public function checkCorrectness()
    {
        if ($this->question) {
            $this->is_correct = $this->question->isCorrectAnswer($this->answer);
            $this->points_earned = $this->is_correct ? $this->question->points : 0;
            $this->save();
        }
    }
}