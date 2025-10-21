<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class TeacherAttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'qr_code',
        'status',
        'attendance_date',
        'scan_time',
        'check_out_time',
        'location',
        'scanned_by',
        'notes',
    ];

    protected $casts = [
        'attendance_date' => 'date',
        'scan_time' => 'datetime:H:i:s',
        'check_out_time' => 'datetime:H:i:s',
    ];

    /**
     * Relasi ke Teacher
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relasi ke QR Teacher Attendance
     */
    public function qrTeacherAttendance(): BelongsTo
    {
        return $this->belongsTo(QrTeacherAttendance::class, 'qr_code', 'qr_code');
    }

    /**
     * Scope untuk filter berdasarkan bulan
     */
    public function scopeByMonth($query, $month, $year)
    {
        return $query->whereMonth('attendance_date', $month)
                    ->whereYear('attendance_date', $year);
    }

    /**
     * Scope untuk filter berdasarkan tanggal hari ini
     */
    public function scopeToday($query)
    {
        return $query->whereDate('attendance_date', today());
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Get formatted scan time
     */
    public function getFormattedScanTimeAttribute()
    {
        return Carbon::parse($this->scan_time)->format('H:i:s');
    }

    /**
     * Get formatted check out time
     */
    public function getFormattedCheckOutTimeAttribute()
    {
        return $this->check_out_time ? Carbon::parse($this->check_out_time)->format('H:i:s') : null;
    }

    /**
     * Get formatted attendance date
     */
    public function getFormattedAttendanceDateAttribute()
    {
        return Carbon::parse($this->attendance_date)->format('d/m/Y');
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'hadir' => 'bg-green-100 text-green-800',
            'terlambat' => 'bg-yellow-100 text-yellow-800',
            'izin' => 'bg-blue-100 text-blue-800',
            'sakit' => 'bg-purple-100 text-purple-800',
            'alpha' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'hadir' => 'Hadir',
            'terlambat' => 'Terlambat',
            'izin' => 'Izin',
            'sakit' => 'Sakit',
            'alpha' => 'Alpha',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get duration between check out and check in time
     */
    public function getDurationAttribute()
    {
        if (!$this->check_out_time || !$this->scan_time) {
            return '-';
        }

        $checkIn = Carbon::parse($this->scan_time);
        $checkOut = Carbon::parse($this->check_out_time);

        $diffInSeconds = $checkOut->diffInSeconds($checkIn);

        $hours = floor($diffInSeconds / 3600);
        $minutes = floor(($diffInSeconds % 3600) / 60);

        if ($hours > 0) {
            return sprintf('%dh %dm', $hours, $minutes);
        } else {
            return sprintf('%dm', $minutes);
        }
    }
}