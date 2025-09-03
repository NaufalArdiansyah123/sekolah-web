<?php

// app/Models/Post.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'type',
        'image',
        'featured_image',
        'tags',
        'status',
        'priority',
        'event_date',
        'location',
        'user_id',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}