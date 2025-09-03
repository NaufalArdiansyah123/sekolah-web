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
        'phone',
        'address',
        'bio',
        'avatar',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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
}