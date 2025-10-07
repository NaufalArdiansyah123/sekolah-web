<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'category',
        'level',
        'year',
        'achievement_date',
        'organizer',
        'participant',
        'position',
        'image',
        'additional_info',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
        'sort_order'
    ];

    protected $casts = [
        'achievement_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    protected $dates = [
        'achievement_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'id';
    }

    /**
     * Retrieve the model for a bound value.
     */
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where('id', $value)
                    ->where('is_active', true)
                    ->first();
    }

    // Scope untuk achievement yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope untuk achievement yang featured
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    // Scope untuk filter berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Scope untuk filter berdasarkan level
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    // Scope untuk filter berdasarkan tahun
    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    // Scope untuk pencarian
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('description', 'LIKE', "%{$search}%")
              ->orWhere('participant', 'LIKE', "%{$search}%")
              ->orWhere('organizer', 'LIKE', "%{$search}%");
        });
    }

    // Accessor untuk mendapatkan kategori dengan format yang bagus
    public function getCategoryFormattedAttribute()
    {
        $categories = [
            'akademik' => 'Akademik',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni & Budaya',
            'teknologi' => 'Teknologi',
            'lingkungan' => 'Lingkungan',
            'sosial' => 'Sosial',
            'lainnya' => 'Lainnya'
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    // Accessor untuk mendapatkan level dengan format yang bagus
    public function getLevelFormattedAttribute()
    {
        $levels = [
            'school' => 'Sekolah',
            'district' => 'Kecamatan',
            'city' => 'Kota/Kabupaten',
            'province' => 'Provinsi',
            'national' => 'Nasional',
            'international' => 'Internasional'
        ];

        return $levels[$this->level] ?? ucfirst($this->level);
    }

    // Accessor untuk mendapatkan posisi dengan format yang bagus
    public function getPositionFormattedAttribute()
    {
        $positions = [
            'juara_1' => 'Juara 1',
            'juara_2' => 'Juara 2',
            'juara_3' => 'Juara 3',
            'harapan_1' => 'Harapan 1',
            'harapan_2' => 'Harapan 2',
            'harapan_3' => 'Harapan 3',
            'finalis' => 'Finalis',
            'peserta' => 'Peserta',
            'penghargaan' => 'Penghargaan Khusus',
            'lainnya' => 'Lainnya'
        ];

        return $positions[$this->position] ?? ucfirst(str_replace('_', ' ', $this->position));
    }

    // Accessor untuk mendapatkan icon berdasarkan kategori
    public function getCategoryIconAttribute()
    {
        $icons = [
            'akademik' => 'fas fa-graduation-cap',
            'olahraga' => 'fas fa-running',
            'seni' => 'fas fa-palette',
            'teknologi' => 'fas fa-laptop-code',
            'lingkungan' => 'fas fa-leaf',
            'sosial' => 'fas fa-handshake',
            'lainnya' => 'fas fa-award'
        ];

        return $icons[$this->category] ?? 'fas fa-trophy';
    }

    // Accessor untuk mendapatkan warna badge berdasarkan level
    public function getLevelBadgeColorAttribute()
    {
        $colors = [
            'school' => 'secondary',
            'district' => 'light',
            'city' => 'info',
            'province' => 'success',
            'national' => 'warning',
            'international' => 'danger'
        ];

        return $colors[$this->level] ?? 'primary';
    }

    // Accessor untuk mendapatkan warna badge berdasarkan posisi
    public function getPositionBadgeColorAttribute()
    {
        $colors = [
            'juara_1' => 'warning',
            'juara_2' => 'secondary',
            'juara_3' => 'dark',
            'harapan_1' => 'success',
            'harapan_2' => 'success',
            'harapan_3' => 'success',
            'finalis' => 'info',
            'peserta' => 'light',
            'penghargaan' => 'primary',
            'lainnya' => 'secondary'
        ];

        return $colors[$this->position] ?? 'primary';
    }

    // Method untuk mendapatkan opsi kategori
    public static function getCategoryOptions()
    {
        return [
            'akademik' => 'Akademik',
            'olahraga' => 'Olahraga',
            'seni' => 'Seni & Budaya',
            'teknologi' => 'Teknologi',
            'lingkungan' => 'Lingkungan',
            'sosial' => 'Sosial',
            'lainnya' => 'Lainnya'
        ];
    }

    // Method untuk mendapatkan opsi level
    public static function getLevelOptions()
    {
        return [
            'school' => 'Sekolah',
            'district' => 'Kecamatan',
            'city' => 'Kota/Kabupaten',
            'province' => 'Provinsi',
            'national' => 'Nasional',
            'international' => 'Internasional'
        ];
    }

    // Method untuk mendapatkan opsi posisi
    public static function getPositionOptions()
    {
        return [
            'juara_1' => 'Juara 1',
            'juara_2' => 'Juara 2',
            'juara_3' => 'Juara 3',
            'harapan_1' => 'Harapan 1',
            'harapan_2' => 'Harapan 2',
            'harapan_3' => 'Harapan 3',
            'finalis' => 'Finalis',
            'peserta' => 'Peserta',
            'penghargaan' => 'Penghargaan Khusus',
            'lainnya' => 'Lainnya'
        ];
    }

    // Method untuk mendapatkan tahun-tahun yang tersedia
    public static function getAvailableYears()
    {
        return static::selectRaw('DISTINCT year')
                    ->whereNotNull('year')
                    ->orderBy('year', 'desc')
                    ->pluck('year')
                    ->toArray();
    }

    // Method untuk mendapatkan statistik achievements
    public static function getStatistics()
    {
        return [
            'total' => static::active()->count(),
            'featured' => static::active()->featured()->count(),
            'by_level' => static::active()
                               ->selectRaw('level, COUNT(*) as count')
                               ->groupBy('level')
                               ->pluck('count', 'level')
                               ->toArray(),
            'by_category' => static::active()
                                  ->selectRaw('category, COUNT(*) as count')
                                  ->groupBy('category')
                                  ->pluck('count', 'category')
                                  ->toArray(),
            'recent' => static::active()
                             ->where('created_at', '>=', now()->subDays(30))
                             ->count()
        ];
    }
}