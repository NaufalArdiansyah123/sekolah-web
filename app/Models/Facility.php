<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'category',
        'image',
        'features',
        'status',
        'capacity',
        'location',
        'is_featured',
        'sort_order'
    ];
    
    /**
     * Get fillable attributes that exist in the database
     */
    public function getActualFillableAttribute()
    {
        try {
            $columns = \Schema::getColumnListing($this->getTable());
            return array_intersect($this->fillable, $columns);
        } catch (\Exception $e) {
            // Fallback to basic required fields
            return ['name', 'description', 'category', 'image', 'status'];
        }
    }

    protected $casts = [
        'features' => 'array',
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
        'capacity' => 'integer'
    ];

    // Scope untuk fasilitas aktif
    public function scopeActive($query)
    {
        try {
            // Check if status column exists
            \DB::connection()->select('SELECT status FROM facilities LIMIT 1');
            return $query->where('status', 'active');
        } catch (\Exception $e) {
            // Jika kolom status tidak ada, return semua
            return $query;
        }
    }

    // Scope untuk fasilitas unggulan
    public function scopeFeatured($query)
    {
        try {
            // Check if is_featured column exists
            \DB::connection()->select('SELECT is_featured FROM facilities LIMIT 1');
            return $query->where('is_featured', true);
        } catch (\Exception $e) {
            // Jika kolom is_featured tidak ada, return semua
            return $query;
        }
    }

    // Scope berdasarkan kategori
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accessor untuk URL gambar
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // Check multiple possible paths
            $paths = [
                'storage/facilities/' . $this->image,
                'storage/uploads/facilities/' . $this->image,
                'uploads/facilities/' . $this->image,
                'images/facilities/' . $this->image,
                $this->image // Direct path if already full URL
            ];
            
            foreach ($paths as $path) {
                $fullPath = public_path($path);
                if (file_exists($fullPath)) {
                    return asset($path);
                }
            }
            
            // If image field contains full URL
            if (filter_var($this->image, FILTER_VALIDATE_URL)) {
                return $this->image;
            }
        }
        
        // Return placeholder image (SVG for better quality)
        return asset('images/default-facility.svg');
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => '<span class="badge bg-success">Aktif</span>',
            'maintenance' => '<span class="badge bg-warning">Maintenance</span>',
            'inactive' => '<span class="badge bg-danger">Tidak Aktif</span>'
        ];

        return $badges[$this->status] ?? '<span class="badge bg-secondary">Unknown</span>';
    }

    // Accessor untuk kategori label
    public function getCategoryLabelAttribute()
    {
        $categories = [
            'academic' => 'Akademik',
            'sport' => 'Olahraga',
            'technology' => 'Teknologi',
            'arts' => 'Seni & Budaya',
            'other' => 'Lainnya'
        ];

        return $categories[$this->category] ?? 'Tidak Diketahui';
    }

    // Method untuk mendapatkan daftar kategori
    public static function getCategories()
    {
        return [
            'academic' => 'Akademik',
            'sport' => 'Olahraga',
            'technology' => 'Teknologi',
            'arts' => 'Seni & Budaya',
            'other' => 'Lainnya'
        ];
    }

    // Method untuk mendapatkan daftar status
    public static function getStatuses()
    {
        return [
            'active' => 'Aktif',
            'maintenance' => 'Maintenance',
            'inactive' => 'Tidak Aktif'
        ];
    }
    
    // Method untuk validasi status
    public static function isValidStatus($status)
    {
        return in_array($status, array_keys(self::getStatuses()));
    }
    
    // Mutator untuk memastikan status yang valid
    public function setStatusAttribute($value)
    {
        $validStatuses = array_keys(self::getStatuses());
        $this->attributes['status'] = in_array($value, $validStatuses) ? $value : 'active';
    }
}