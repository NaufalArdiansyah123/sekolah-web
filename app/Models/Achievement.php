<?php
// app/Models/Achievement.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'student_id',
        'achievement_date',
        'level',
        'rank',
        'certificate',
        'status',
        'user_id',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getLevelBadgeAttribute()
    {
        $badges = [
            'school' => 'bg-blue-100 text-blue-800',
            'district' => 'bg-green-100 text-green-800',
            'city' => 'bg-yellow-100 text-yellow-800',
            'province' => 'bg-purple-100 text-purple-800',
            'national' => 'bg-red-100 text-red-800',
            'international' => 'bg-indigo-100 text-indigo-800',
        ];

        return $badges[$this->level] ?? 'bg-gray-100 text-gray-800';
    }
}
