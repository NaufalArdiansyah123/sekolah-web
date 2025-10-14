<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QrTeacherAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'qr_code',
        'qr_image_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke Teacher
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Relasi ke Teacher Attendance Logs
     */
    public function attendanceLogs(): HasMany
    {
        return $this->hasMany(TeacherAttendanceLog::class, 'qr_code', 'qr_code');
    }

    /**
     * Generate QR Code untuk teacher
     */
    public static function generateQrCode($teacherId): string
    {
        return 'QR_TEACHER_' . str_pad($teacherId, 6, '0', STR_PAD_LEFT) . '_' . time() . '_' . uniqid();
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

    /**
     * Scope untuk QR yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}