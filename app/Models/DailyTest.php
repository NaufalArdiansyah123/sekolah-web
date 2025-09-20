<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DailyTest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'subject',
        'class',
        'teacher_id',
        'scheduled_at',
        'duration',
        'status',
        'instructions',
        'show_results',
        'randomize_questions',
        'max_attempts'
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'show_results' => 'boolean',
        'randomize_questions' => 'boolean'
    ];

    /**
     * Get the teacher that owns the daily test
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the questions for the daily test
     */
    public function questions()
    {
        return $this->hasMany(DailyTestQuestion::class);
    }

    /**
     * Get the attempts for the daily test
     */
    public function attempts()
    {
        return $this->hasMany(DailyTestAttempt::class);
    }

    /**
     * Get the grades for the daily test
     */
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    /**
     * Check if daily test is available for students
     */
    public function isAvailable()
    {
        return $this->status === 'published' 
            && ($this->scheduled_at === null || $this->scheduled_at <= now());
    }

    /**
     * Check if daily test is upcoming
     */
    public function isUpcoming()
    {
        return $this->status === 'published' 
            && $this->scheduled_at !== null 
            && $this->scheduled_at > now();
    }

    /**
     * Check if daily test is expired
     */
    public function isExpired()
    {
        if ($this->scheduled_at === null) {
            return false;
        }
        
        return $this->scheduled_at->addMinutes($this->duration)->isPast();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        switch ($this->status) {
            case 'published':
                if ($this->isAvailable() && !$this->isExpired()) {
                    return 'green';
                } elseif ($this->isUpcoming()) {
                    return 'blue';
                } else {
                    return 'red';
                }
            case 'completed':
                return 'purple';
            default:
                return 'gray';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case 'published':
                if ($this->isAvailable() && !$this->isExpired()) {
                    return 'Tersedia';
                } elseif ($this->isUpcoming()) {
                    return 'Akan Datang';
                } else {
                    return 'Berakhir';
                }
            case 'completed':
                return 'Selesai';
            default:
                return 'Draft';
        }
    }

    /**
     * Get questions count attribute
     */
    public function getQuestionsCountAttribute()
    {
        return $this->questions()->count();
    }

    /**
     * Get total points attribute
     */
    public function getTotalPointsAttribute()
    {
        return $this->questions()->sum('points');
    }

    /**
     * Scope for published daily tests
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope for available daily tests
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'published')
                    ->where(function ($q) {
                        $q->whereNull('scheduled_at')
                          ->orWhere('scheduled_at', '<=', now());
                    });
    }

    /**
     * Scope for specific class
     */
    public function scopeForClass($query, $class)
    {
        return $query->where('class', $class);
    }

    /**
     * Scope for specific subject
     */
    public function scopeForSubject($query, $subject)
    {
        return $query->where('subject', $subject);
    }

    /**
     * Get student attempt for this test
     */
    public function getStudentAttempt($studentId)
    {
        return $this->attempts()->where('student_id', $studentId)->first();
    }

    /**
     * Check if student can take this test
     */
    public function canStudentTake($studentId)
    {
        if (!$this->isAvailable() || $this->isExpired()) {
            return false;
        }

        $attempts = $this->attempts()->where('student_id', $studentId)->count();
        return $attempts < $this->max_attempts;
    }
}