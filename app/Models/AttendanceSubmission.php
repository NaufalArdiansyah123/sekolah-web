<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\SchoolClass;

class AttendanceSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'guru_piket_id',
        'submission_date',
        'class_id',
        'subject',
        'session_time',
        'total_students',
        'present_count',
        'late_count',
        'absent_count',
        'attendance_data',
        'notes',
        'status',
        'submitted_at',
        'confirmed_at',
        'confirmed_by'
    ];

    protected $casts = [
        'attendance_data' => 'array',
        'submission_date' => 'date',
        'submitted_at' => 'datetime',
        'confirmed_at' => 'datetime'
    ];

    /**
     * Status constants
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_REJECTED = 'rejected';

    /**
     * Get the teacher who submitted the attendance
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the guru piket who confirmed the attendance
     */
    public function guruPiket()
    {
        return $this->belongsTo(User::class, 'guru_piket_id');
    }

    /**
     * Get the class for this attendance submission
     */
    public function class()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }

    /**
     * Get the confirmer (guru piket who confirmed)
     */
    public function confirmer()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    /**
     * Scope for pending submissions
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for confirmed submissions
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', self::STATUS_CONFIRMED);
    }

    /**
     * Scope for today's submissions
     */
    public function scopeToday($query)
    {
        return $query->whereDate('submission_date', Carbon::today());
    }

    /**
     * Get formatted session time
     */
    public function getFormattedSessionTimeAttribute()
    {
        return $this->session_time ? Carbon::parse($this->session_time)->format('H:i') : '-';
    }

    /**
     * Get attendance percentage
     */
    public function getAttendancePercentageAttribute()
    {
        if ($this->total_students == 0) {
            return 0;
        }
        
        return round(($this->present_count / $this->total_students) * 100, 1);
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
            case self::STATUS_CONFIRMED:
                return 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
            case self::STATUS_REJECTED:
                return 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
            default:
                return 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200';
        }
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->status) {
            case self::STATUS_PENDING:
                return 'Menunggu Konfirmasi';
            case self::STATUS_CONFIRMED:
                return 'Dikonfirmasi';
            case self::STATUS_REJECTED:
                return 'Ditolak';
            default:
                return 'Unknown';
        }
    }
}