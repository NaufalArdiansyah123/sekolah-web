<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityViolation extends Model
{
    use HasFactory;

    protected $fillable = [
        'violator_student_id',
        'qr_owner_student_id',
        'qr_code',
        'violation_type',
        'violation_time',
        'violation_date',
        'location',
        'ip_address',
        'user_agent',
        'violation_details',
        'severity',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'violation_time' => 'datetime',
        'violation_date' => 'date',
        'violation_details' => 'array',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Relasi ke siswa yang melakukan pelanggaran
     */
    public function violatorStudent(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'violator_student_id');
    }

    /**
     * Relasi ke siswa pemilik QR code
     */
    public function qrOwnerStudent(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'qr_owner_student_id');
    }

    /**
     * Relasi ke admin yang mereview
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeByDate($query, $date)
    {
        return $query->whereDate('violation_date', $date);
    }

    /**
     * Scope untuk filter berdasarkan bulan
     */
    public function scopeByMonth($query, $month, $year = null)
    {
        $year = $year ?? date('Y');
        return $query->whereMonth('violation_date', $month)
                    ->whereYear('violation_date', $year);
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk filter berdasarkan severity
     */
    public function scopeBySeverity($query, $severity)
    {
        return $query->where('severity', $severity);
    }

    /**
     * Get violation type text
     */
    public function getViolationTypeTextAttribute(): string
    {
        return match($this->violation_type) {
            'wrong_qr_owner' => 'Menggunakan QR Code Orang Lain',
            'invalid_qr' => 'QR Code Tidak Valid',
            'duplicate_scan' => 'Scan Berulang',
            'other' => 'Lainnya',
            default => 'Unknown'
        };
    }

    /**
     * Get severity text
     */
    public function getSeverityTextAttribute(): string
    {
        return match($this->severity) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'critical' => 'Kritis',
            default => 'Unknown'
        };
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Menunggu Review',
            'reviewed' => 'Sudah Direview',
            'resolved' => 'Diselesaikan',
            'dismissed' => 'Diabaikan',
            default => 'Unknown'
        };
    }

    /**
     * Get severity badge color
     */
    public function getSeverityBadgeAttribute(): string
    {
        return match($this->severity) {
            'low' => 'success',
            'medium' => 'warning',
            'high' => 'danger',
            'critical' => 'dark',
            default => 'secondary'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'reviewed' => 'info',
            'resolved' => 'success',
            'dismissed' => 'secondary',
            default => 'secondary'
        };
    }
}