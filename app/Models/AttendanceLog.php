<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'qr_code',
        'status',
        'scan_time',
        'attendance_date',
        'location',
        'notes',
    ];

    protected $casts = [
        'scan_time' => 'datetime',
        'attendance_date' => 'date',
    ];

    /**
     * Relasi ke Student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke QR Attendance
     */
    public function qrAttendance(): BelongsTo
    {
        return $this->belongsTo(QrAttendance::class, 'qr_code', 'qr_code');
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('attendance_date', $date);
    }

    /**
     * Scope untuk filter berdasarkan bulan
     */
    public function scopeByMonth($query, $month, $year = null)
    {
        $year = $year ?? date('Y');
        return $query->whereMonth('attendance_date', $month)
                    ->whereYear('attendance_date', $year);
    }

    /**
     * Determine status berdasarkan waktu scan
     */
    public static function determineStatus($scanTime): string
    {
        $scanHour = Carbon::parse($scanTime)->format('H:i');
        
        // Aturan waktu (bisa disesuaikan)
        if ($scanHour <= '07:30') {
            return 'hadir';
        } elseif ($scanHour <= '08:00') {
            return 'terlambat';
        } else {
            return 'alpha'; // Terlalu terlambat
        }
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'success',
            'terlambat' => 'warning',
            'izin' => 'info',
            'sakit' => 'secondary',
            'alpha' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => 'Unknown'
        };
    }
}