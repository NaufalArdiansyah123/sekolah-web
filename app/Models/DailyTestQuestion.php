<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTestQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_test_id',
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
     * Get the daily test that owns the question
     */
    public function dailyTest()
    {
        return $this->belongsTo(DailyTest::class);
    }

    /**
     * Get the answers for the question
     */
    public function answers()
    {
        return $this->hasMany(DailyTestAnswer::class, 'question_id');
    }

    /**
     * Check if answer is correct
     */
    public function isCorrectAnswer($answer)
    {
        if ($this->type === 'essay') {
            return null; // Essay questions need manual grading
        }
        
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
     * Get option letters (A, B, C, D, etc.)
     */
    public function getOptionLettersAttribute()
    {
        if ($this->type !== 'multiple_choice' || !$this->options) {
            return [];
        }

        $letters = [];
        $alphabet = range('A', 'Z');
        
        foreach (array_keys($this->options) as $index => $key) {
            $letters[$key] = $alphabet[$index] ?? $key;
        }
        
        return $letters;
    }

    /**
     * Scope for ordering questions
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Scope for multiple choice questions
     */
    public function scopeMultipleChoice($query)
    {
        return $query->where('type', 'multiple_choice');
    }

    /**
     * Scope for essay questions
     */
    public function scopeEssay($query)
    {
        return $query->where('type', 'essay');
    }
}