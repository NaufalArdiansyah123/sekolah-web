<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'file_path',
        'file_name',
        'submitted_at',
        'graded_at',
        'score',
        'feedback'
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
    ];

    /**
     * Get the assignment that owns the submission
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student that owns the submission
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Check if submission is graded
     */
    public function isGraded()
    {
        return !is_null($this->graded_at);
    }

    /**
     * Check if submission is late
     */
    public function isLate()
    {
        return $this->submitted_at > $this->assignment->due_date;
    }

    /**
     * Get grade percentage
     */
    public function getGradePercentageAttribute()
    {
        if (!$this->score || !$this->assignment->max_score) {
            return 0;
        }
        
        return round(($this->score / $this->assignment->max_score) * 100, 2);
    }
}