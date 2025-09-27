<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'level',
        'program',
        'capacity',
        'academic_year_id',
        'homeroom_teacher_id',
        'description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the academic year that this class belongs to
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the homeroom teacher for this class
     */
    public function homeroomTeacher()
    {
        return $this->belongsTo(User::class, 'homeroom_teacher_id');
    }

    /**
     * Get the students in this class
     */
    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    /**
     * Get the assignments for this class
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    /**
     * Get the quizzes for this class
     */
    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'class_id');
    }

    /**
     * Scope for active classes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the full class name (e.g., "X IPA 1")
     */
    public function getFullNameAttribute()
    {
        return $this->name;
    }

    /**
     * Get the class display name with level and program
     */
    public function getDisplayNameAttribute()
    {
        $name = $this->level;
        if ($this->program) {
            $name .= ' ' . $this->program;
        }
        return $name . ' - ' . $this->name;
    }
}
