<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'subject',
        'teacher_id',
        'date',
        'start_time',
        'end_time',
        'status',
        'location'
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime'
    ];

    /**
     * Get the teacher that owns the session
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the attendances for the session
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }

    /**
     * Check if session is active
     */
    public function isActive()
    {
        return $this->status === 'active' 
            && $this->date->isToday()
            && now()->between(
                $this->date->setTimeFromTimeString($this->start_time),
                $this->date->setTimeFromTimeString($this->end_time)
            );
    }

    /**
     * Check if session is open for check-in
     */
    public function isOpenForCheckIn()
    {
        return $this->status === 'active' 
            && $this->date->isToday()
            && now()->gte($this->date->setTimeFromTimeString($this->start_time))
            && now()->lte($this->date->setTimeFromTimeString($this->end_time));
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'active' => 'green',
            'closed' => 'red',
            'draft' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Scope for active sessions
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for today's sessions
     */
    public function scopeToday($query)
    {
        return $query->whereDate('date', today());
    }
}