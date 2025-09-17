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
        'excerpt',
        'content',
        'type',
        'status',
        'category',
        'tags',
        'author',
        'user_id',
        'published_at',
        'featured_image',
        'image_alt',
        'meta_title',
        'meta_description',
        'keywords',
        'views_count',
        'event_date',
        'location',
        'schedule',
        'image',
        'priority',
        'expires_at',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'tags' => 'array',
        'keywords' => 'array',
        'views_count' => 'integer',
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