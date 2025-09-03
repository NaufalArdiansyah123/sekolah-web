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
        'class',
        'birth_date',
        'birth_place',
        'gender',
        'parent_name',
        'parent_phone',
        'photo',
        'status',
        'user_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }

    public function extracurriculars()
    {
        return $this->belongsToMany(Extracurricular::class, 'student_extracurriculars');
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
}
