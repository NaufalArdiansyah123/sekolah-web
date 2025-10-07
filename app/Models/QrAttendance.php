<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QrAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'qr_code',
        'qr_image_path',
    ];

    /**
     * Relasi ke Student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Relasi ke Attendance Logs
     */
    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(AttendanceLog::class, 'qr_code', 'qr_code');
    }

    /**
     * Generate QR Code untuk student
     */
    public static function generateQrCode($studentId): string
    {
        return 'QR_' . str_pad($studentId, 6, '0', STR_PAD_LEFT) . '_' . time() . '_' . uniqid();
    }

    /**
     * Get QR Code Image URL
     */
    public function getQrImageUrlAttribute(): ?string
    {
        if ($this->qr_image_path) {
            return asset('storage/' . $this->qr_image_path);
        }
        return null;
    }
}