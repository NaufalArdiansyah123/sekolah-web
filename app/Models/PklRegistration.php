<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PklRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'tempat_pkl_id',
        'status',
        'motivation_letter',
        'notes',
        'approved_at',
        'rejected_at',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'surat_pengantar',
        'catatan',
        'qr_code',
        'qr_image_path',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function tempatPkl()
    {
        return $this->belongsTo(TempatPkl::class, 'tempat_pkl_id');
    }

    public function pklAttendanceLogs()
    {
        return $this->hasMany(PklAttendanceLog::class, 'pkl_registration_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Helper methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    public function approve()
    {
        $this->update([
            'status' => 'approved',
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        // Update student PKL status
        $student = Student::where('user_id', $this->student_id)->first();
        if ($student) {
            $student->update([
                'pkl_status' => 'sedang_pkl',
                'active_pkl_registration_id' => $this->id,
            ]);
        }
    }

    public function reject($notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'notes' => $notes,
            'rejected_at' => now(),
            'approved_at' => null,
        ]);

        // Reset student PKL status if this was their active registration
        $student = Student::where('user_id', $this->student_id)
            ->where('active_pkl_registration_id', $this->id)
            ->first();
        if ($student) {
            $student->update([
                'pkl_status' => 'tidak_pkl',
                'active_pkl_registration_id' => null,
            ]);
        }
    }

    /**
     * Generate QR Code untuk PKL registration
     */
    public static function generateQrCode($registrationId): string
    {
        return 'PKL_' . str_pad($registrationId, 6, '0', STR_PAD_LEFT) . '_' . time() . '_' . uniqid();
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
