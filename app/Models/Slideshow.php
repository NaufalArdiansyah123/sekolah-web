<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slideshow extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        'order',
        'user_id',
        'link',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Get the user that owns the slideshow.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active slideshows.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive slideshows.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Scope a query to order slideshows by their display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get the full URL for the slideshow image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }

    /**
     * Get the status label.
     */
    public function getStatusLabelAttribute()
    {
        return $this->status === 'active' ? 'Aktif' : 'Tidak Aktif';
    }

    /**
     * Check if slideshow is active.
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if slideshow is inactive.
     */
    public function isInactive()
    {
        return $this->status === 'inactive';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-set user_id when creating
        static::creating(function ($slideshow) {
            if (auth()->check() && !$slideshow->user_id) {
                $slideshow->user_id = auth()->id();
            }
        });

        // Set default order if not provided
        static::creating(function ($slideshow) {
            if (is_null($slideshow->order)) {
                $slideshow->order = static::max('order') + 1 ?? 0;
            }
        });
    }
}