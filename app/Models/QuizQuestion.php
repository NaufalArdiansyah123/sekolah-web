<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question',
        'type',
        'options',
        'correct_answer',
        'points',
        'order'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    /**
     * Get the quiz that owns the question
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the answers for the question
     */
    public function answers()
    {
        return $this->hasMany(QuizAnswer::class, 'question_id');
    }

    /**
     * Check if answer is correct
     */
    public function isCorrectAnswer($answer)
    {
        return $this->correct_answer === $answer;
    }

    /**
     * Get formatted options for multiple choice
     */
    public function getFormattedOptionsAttribute()
    {
        if ($this->type !== 'multiple_choice' || !$this->options) {
            return [];
        }

        $formatted = [];
        foreach ($this->options as $key => $option) {
            $formatted[$key] = $option;
        }
        
        return $formatted;
    }

    /**
     * Scope for ordering questions
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}