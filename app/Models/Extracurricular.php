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
        return $this->belongsToMany(Student::class, 'student_extracurriculars');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}

