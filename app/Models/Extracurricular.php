<?php
// app/Models/Extracurricular.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Extracurricular extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'coach',
        'schedule',
        'image',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        // Get students through approved registrations
        return $this->hasManyThrough(
            Student::class,
            ExtracurricularRegistration::class,
            'extracurricular_id', // Foreign key on extracurricular_registrations table
            'nis', // Foreign key on students table
            'id', // Local key on extracurriculars table
            'student_nis' // Local key on extracurricular_registrations table
        )->where('extracurricular_registrations.status', 'approved');
    }
    
    public function approvedStudents()
    {
        return $this->registrations()->where('status', 'approved');
    }

    /**
     * Get the registrations for the extracurricular.
     */
    public function registrations()
    {
        return $this->hasMany(ExtracurricularRegistration::class);
    }

    /**
     * Get the broadcast messages for the extracurricular.
     */
    public function broadcastMessages()
    {
        return $this->hasMany(\App\Models\BroadcastMessage::class);
    }

    public function pendingRegistrations()
    {
        return $this->hasMany(ExtracurricularRegistration::class)->where('status', 'pending');
    }

    public function approvedRegistrations()
    {
        return $this->hasMany(ExtracurricularRegistration::class)->where('status', 'approved');
    }

    public function rejectedRegistrations()
    {
        return $this->hasMany(ExtracurricularRegistration::class)->where('status', 'rejected');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getRegistrationCountAttribute()
    {
        return $this->registrations()->count();
    }

    public function getPendingCountAttribute()
    {
        return $this->pendingRegistrations()->count();
    }

    public function getApprovedCountAttribute()
    {
        return $this->approvedRegistrations()->count();
    }

    public function getRejectedCountAttribute()
    {
        return $this->rejectedRegistrations()->count();
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active' 
            ? '<span class="badge bg-success">Aktif</span>' 
            : '<span class="badge bg-secondary">Tidak Aktif</span>';
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}

