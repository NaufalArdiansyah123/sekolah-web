<?php
// app/Models/User.php
// Update app/Models/User.php to include Spatie Permission
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'phone',
        'address',
        'bio',
        'avatar',
        'status',
        'nis',
        'birth_date',
        'birth_place',
        'gender',
        'religion',
        'class',
        'parent_name',
        'parent_phone',
        'parent_email',
        'enrollment_date',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'birth_date' => 'date',
        'enrollment_date' => 'date',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function downloads()
    {
        return $this->hasMany(Download::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function extracurriculars()
    {
        return $this->hasMany(Extracurricular::class);
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

    public function getRoleNameAttribute()
    {
        return $this->roles->first()->name ?? 'No Role';
    }

    /**
     * Get the user who approved this registration
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the user who rejected this registration
     */
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    /**
     * Check if user is a student
     */
    public function isStudent()
    {
        return $this->hasRole('student');
    }

    /**
     * Check if user registration is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if user registration is approved
     */
    public function isApproved()
    {
        return $this->status === 'active';
    }

    /**
     * Check if user registration is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}