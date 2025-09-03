<?php
// app/Models/Slideshow.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'content',
        'image',
        'status',
        'order',
        'link'
    ];

    protected $casts = [
        'order' => 'integer'
    ];

    /**
     * Scope a query to only include active slideshows.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to order slideshows by order column.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }
}