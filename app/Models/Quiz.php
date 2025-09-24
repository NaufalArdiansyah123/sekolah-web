<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'subject',
        'class',
        'teacher_id',
        'start_time',
        'end_time',
        'duration_minutes',
        'max_attempts',
        'status',
        'instructions',
        'show_results',
        'randomize_questions'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'show_results' => 'boolean',
        'randomize_questions' => 'boolean'
    ];

    /**
     * Get the teacher that owns the quiz
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the questions for the quiz
     */
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    /**
     * Get the attempts for the quiz
     */
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get the grades for the quiz
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Check if quiz is active
     */
    public function isActive()
    {
        return $this->status === 'published' 
            && $this->start_time <= now() 
            && $this->end_time >= now();
    }

    /**
     * Check if quiz is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'published' && $this->start_time > now();
    }

    /**
     * Check if quiz is ended
     */
    public function isEnded()
    {
        return $this->end_time < now();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        if ($this->isActive()) {
            return 'green';
        } elseif ($this->isUpcoming()) {
            return 'blue';
        } elseif ($this->isEnded()) {
            return 'red';
        } else {
            return 'gray';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        if ($this->isActive()) {
            return 'Aktif';
        } elseif ($this->isUpcoming()) {
            return 'Akan Datang';
        } elseif ($this->isEnded()) {
            return 'Berakhir';
        } else {
            return 'Draft';
        }
    }

    /**
     * Scope for published quizzes
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for active quizzes
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'published')
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now());
    }
}