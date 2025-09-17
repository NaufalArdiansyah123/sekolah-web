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
        'gambar'
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
}