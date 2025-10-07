<?php
// app/Models/Student.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nis',
        'nisn',
        'email',
        'phone',
        'address',
        'class_id',
        'birth_date',
        'birth_place',
        'gender',
        'religion',
        'parent_name',
        'parent_phone',
        'photo',
        'status',
        'user_id',
        'enrollment_date',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'enrollment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the class that this student belongs to
     */
    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function extracurriculars()
    {
        // Get extracurriculars through approved registrations
        return $this->hasManyThrough(
            Extracurricular::class,
            ExtracurricularRegistration::class,
            'student_nis', // Foreign key on extracurricular_registrations table
            'id', // Foreign key on extracurriculars table
            'nis', // Local key on students table
            'extracurricular_id' // Local key on extracurricular_registrations table
        )->where('extracurricular_registrations.status', 'approved');
    }
    
    public function extracurricularRegistrations()
    {
        return $this->hasMany(ExtracurricularRegistration::class, 'student_nis', 'nis');
    }
    
    public function approvedExtracurriculars()
    {
        return $this->extracurricularRegistrations()->where('status', 'approved')->with('extracurricular');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getInitialsAttribute()
    {
        $names = explode(' ', $this->name);
        $initials = '';
        
        foreach ($names as $name) {
            $initials .= substr($name, 0, 1);
        }
        
        return strtoupper(substr($initials, 0, 2));
    }

    public function getAgeAttribute()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return null;
    }

    public function getStatusLabelAttribute()
    {
        switch ($this->status) {
            case 'active':
                return 'Aktif';
            case 'inactive':
                return 'Tidak Aktif';
            case 'graduated':
                return 'Lulus';
            default:
                return ucfirst($this->status);
        }
    }

    /**
     * Relasi ke QR Attendance
     */
    public function qrAttendance()
    {
        return $this->hasOne(QrAttendance::class);
    }

    /**
     * Relasi ke Attendance Logs
     */
    public function attendanceLogs()
    {
        return $this->hasMany(AttendanceLog::class);
    }

    /**
     * Get today's attendance
     */
    public function getTodayAttendanceAttribute()
    {
        return $this->attendanceLogs()
                   ->whereDate('attendance_date', today())
                   ->first();
    }

    /**
     * Check if student has QR code
     */
    public function hasQrCodeAttribute(): bool
    {
        return $this->qrAttendance !== null;
    }
}
