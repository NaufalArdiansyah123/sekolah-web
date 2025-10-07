<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'assignment_id',
        'quiz_id',
        'subject',
        'type',
        'score',
        'max_score',
        'semester',
        'year',
        'notes'
    ];

    /**
     * Get the student that owns the grade
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the teacher that created the grade
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the assignment that owns the grade
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the quiz that owns the grade
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get grade percentage
     */
    public function getPercentageAttribute()
    {
        if (!$this->max_score || $this->max_score == 0) {
            return 0;
        }
        
        return round(($this->score / $this->max_score) * 100, 2);
    }

    /**
     * Get grade letter
     */
    public function getLetterGradeAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'E';
    }

    /**
     * Get grade color
     */
    public function getGradeColorAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return 'green';
        if ($percentage >= 80) return 'blue';
        if ($percentage >= 70) return 'yellow';
        if ($percentage >= 60) return 'orange';
        return 'red';
    }

    /**
     * Get assessment name
     */
    public function getAssessmentNameAttribute()
    {
        if ($this->assignment) {
            return $this->assignment->title;
        } elseif ($this->quiz) {
            return $this->quiz->title;
        } else {
            return 'Manual Grade';
        }
    }

    /**
     * Scope for specific semester
     */
    public function scopeForSemester($query, $semester, $year)
    {
        return $query->where('semester', $semester)
                    ->where('year', $year);
    }

    /**
     * Scope for specific subject
     */
    public function scopeForSubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    /**
     * Scope for specific student
     */
    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }
}