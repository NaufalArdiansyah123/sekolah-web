<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'announcements'; // Sesuaikan dengan nama tabel Anda

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'prioritas',
        'penulis',
        'status',
        'views',
        'tanggal_publikasi',
        'gambar',
        'slug'
    ];

    protected $casts = [
        'tanggal_publikasi' => 'datetime',
        'views' => 'integer'
    ];

    // Scope untuk announcements yang published
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    // Scope untuk announcements terbaru
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('judul', 'LIKE', "%{$search}%")
              ->orWhere('isi', 'LIKE', "%{$search}%");
        });
    }

    // Accessor untuk format tanggal Indonesia
    public function getFormattedDateAttribute()
    {
        return $this->created_at->format('d F Y');
    }

    // Accessor untuk excerpt
    public function getExcerptAttribute()
    {
        return \Str::limit(strip_tags($this->isi), 200);
    }

    // Mutator untuk increment views
    public function incrementViews()
    {
        $this->increment('views');
    }

    // Generate slug otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($announcement) {
            if (empty($announcement->slug)) {
                $announcement->slug = static::generateUniqueSlug($announcement->judul);
            }
        });

        static::updating(function ($announcement) {
            if ($announcement->isDirty('judul') && empty($announcement->slug)) {
                $announcement->slug = static::generateUniqueSlug($announcement->judul);
            }
        });
    }

    public static function generateUniqueSlug($title)
    {
        $slug = \Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}