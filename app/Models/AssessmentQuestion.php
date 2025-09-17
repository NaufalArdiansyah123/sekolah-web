<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id',
        'question_number',
        'question',
        'type',
        'options',
        'correct_answer',
        'points'
    ];

    protected $casts = [
        'options' => 'array',
    ];

    /**
     * Get the assessment this question belongs to
     */
    public function assessment(): BelongsTo
    {
        return $this->belongsTo(Assessment::class);
    }

    /**
     * Get formatted options for multiple choice
     */
    public function getFormattedOptionsAttribute(): array
    {
        if ($this->type !== 'multiple_choice' || !$this->options) {
            return [];
        }

        $formatted = [];
        foreach ($this->options as $index => $option) {
            $formatted[] = [
                'letter' => chr(65 + $index), // A, B, C, D, etc.
                'text' => $option,
                'is_correct' => $this->correct_answer == $index
            ];
        }

        return $formatted;
    }

    /**
     * Get correct answer text for multiple choice
     */
    public function getCorrectAnswerTextAttribute(): ?string
    {
        if ($this->type === 'multiple_choice' && $this->options && isset($this->options[$this->correct_answer])) {
            return chr(65 + $this->correct_answer) . '. ' . $this->options[$this->correct_answer];
        }

        if ($this->type === 'true_false') {
            return ucfirst($this->correct_answer);
        }

        return $this->correct_answer;
    }

    /**
     * Check if answer is correct
     */
    public function isCorrectAnswer($answer): bool
    {
        if ($this->type === 'multiple_choice') {
            return $this->correct_answer == $answer;
        }

        if ($this->type === 'true_false') {
            return strtolower($this->correct_answer) === strtolower($answer);
        }

        // For essay and short answer, manual grading is needed
        return false;
    }
}