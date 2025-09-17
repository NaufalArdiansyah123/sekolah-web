<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'student_id',
        'date',
        'status',
        'check_in_time',
        'notes',
        'attachment'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime'
    ];

    /**
     * Get the session that owns the attendance
     */
    public function session()
    {
        return $this->belongsTo(AttendanceSession::class, 'session_id');
    }

    /**
     * Get the student that owns the attendance
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'present' => 'green',
            'late' => 'yellow',
            'absent' => 'red',
            'sick' => 'blue',
            'permission' => 'purple',
            default => 'gray'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            'present' => 'Hadir',
            'late' => 'Terlambat',
            'absent' => 'Tidak Hadir',
            'sick' => 'Sakit',
            'permission' => 'Izin',
            default => 'Unknown'
        };
    }

    /**
     * Scope for present status
     */
    public function scopePresent($query)
    {
        return $query->whereIn('status', ['present', 'late']);
    }

    /**
     * Scope for absent status
     */
    public function scopeAbsent($query)
    {
        return $query->whereIn('status', ['absent', 'sick', 'permission']);
    }

    /**
     * Scope for specific month
     */
    public function scopeForMonth($query, $year, $month)
    {
        return $query->whereYear('date', $year)
                    ->whereMonth('date', $month);
    }
}