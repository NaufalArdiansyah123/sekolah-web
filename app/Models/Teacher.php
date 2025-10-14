<?php
// app/Models/Teacher.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nip',
        'email',
        'phone',
        'address',
        'subject',
        'position',
        'education',
        'photo',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    /**
     * Relasi ke QR Teacher Attendance
     */
    public function qrTeacherAttendance()
    {
        return $this->hasOne(QrTeacherAttendance::class);
    }

    /**
     * Relasi ke Teacher Attendance Logs
     */
    public function teacherAttendanceLogs()
    {
        return $this->hasMany(TeacherAttendanceLog::class);
    }

    /**
     * Get today's attendance log
     */
    public function todayAttendance()
    {
        return $this->teacherAttendanceLogs()
                   ->whereDate('attendance_date', today())
                   ->first();
    }
}