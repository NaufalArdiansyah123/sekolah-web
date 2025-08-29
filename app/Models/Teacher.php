<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Teacher extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'employee_id', 'name', 'email', 'phone', 'address',
        'position', 'specialization', 'education_level',
        'experience_years', 'join_date', 'status', 'bio',
        'user_id'
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subjects');
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(ClassRoom::class, 'teacher_classes');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'created_by', 'user_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile')
              ->singleFile()
              ->acceptsMimeTypes(['image/jpeg', 'image/png']);
    }
}