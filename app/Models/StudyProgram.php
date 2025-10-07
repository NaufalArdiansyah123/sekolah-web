<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class StudyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'program_code',
        'description',
        'degree_level',
        'faculty',
        'vision',
        'mission',
        'career_prospects',
        'admission_requirements',
        'duration_years',
        'total_credits',
        'degree_title',
        'accreditation',
        'capacity',
        'tuition_fee',
        'core_subjects',
        'specializations',
        'facilities',
        'program_image',
        'brochure_file',
        'is_active',
        'is_featured',
    ];

    protected $casts = [
        'core_subjects' => 'array',
        'specializations' => 'array',
        'facilities' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'tuition_fee' => 'decimal:2',
    ];

    protected $attributes = [
        'is_active' => false,
        'is_featured' => false,
    ];

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeByDegree(Builder $query, string $degree): Builder
    {
        return $query->where('degree_level', $degree);
    }

    public function scopeByFaculty(Builder $query, string $faculty): Builder
    {
        return $query->where('faculty', $faculty);
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function ($q) use ($search) {
            $q->where('program_name', 'like', "%{$search}%")
              ->orWhere('program_code', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%")
              ->orWhere('faculty', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getFormattedTuitionFeeAttribute(): string
    {
        if (!$this->tuition_fee) {
            return '-';
        }
        return 'Rp ' . number_format($this->tuition_fee, 0, ',', '.');
    }

    public function getDegreeFullNameAttribute(): string
    {
        $degrees = [
            'D3' => 'Diploma',
            'S1' => 'Bachelor',
            'S2' => 'Master',
            'S3' => 'Doctoral',
        ];

        return $degrees[$this->degree_level] ?? $this->degree_level;
    }

    public function getAccreditationFullNameAttribute(): string
    {
        $accreditations = [
            'A' => 'Excellent',
            'B' => 'Good',
            'C' => 'Fair',
        ];

        return $accreditations[$this->accreditation] ?? '';
    }

    public function getCoreSubjectsCountAttribute(): int
    {
        return is_array($this->core_subjects) ? count($this->core_subjects) : 0;
    }

    public function getSpecializationsCountAttribute(): int
    {
        return is_array($this->specializations) ? count($this->specializations) : 0;
    }

    public function getFacilitiesCountAttribute(): int
    {
        return is_array($this->facilities) ? count($this->facilities) : 0;
    }

    // Mutators
    public function setCoreSubjectsAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['core_subjects'] = $value;
        } else {
            $this->attributes['core_subjects'] = json_encode($value);
        }
    }

    public function setSpecializationsAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['specializations'] = $value;
        } else {
            $this->attributes['specializations'] = json_encode($value);
        }
    }

    public function setFacilitiesAttribute($value)
    {
        if (is_string($value)) {
            $this->attributes['facilities'] = $value;
        } else {
            $this->attributes['facilities'] = json_encode($value);
        }
    }

    // Helper Methods
    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }

    public function feature(): bool
    {
        return $this->update(['is_featured' => true]);
    }

    public function unfeature(): bool
    {
        return $this->update(['is_featured' => false]);
    }

    public function toggleActive(): bool
    {
        return $this->update(['is_active' => !$this->is_active]);
    }

    public function toggleFeatured(): bool
    {
        return $this->update(['is_featured' => !$this->is_featured]);
    }

    // Static Methods
    public static function getAvailableDegrees(): array
    {
        return ['D3', 'S1', 'S2', 'S3'];
    }

    public static function getAvailableAccreditations(): array
    {
        return ['A', 'B', 'C'];
    }

    public static function getAvailableFaculties(): array
    {
        return self::active()
                   ->whereNotNull('faculty')
                   ->distinct()
                   ->pluck('faculty')
                   ->filter()
                   ->sort()
                   ->values()
                   ->toArray();
    }

    public static function getStatistics(): array
    {
        return [
            'total' => self::count(),
            'active' => self::active()->count(),
            'featured' => self::featured()->count(),
            'by_degree' => self::selectRaw('degree_level, COUNT(*) as count')
                              ->groupBy('degree_level')
                              ->pluck('count', 'degree_level')
                              ->toArray(),
            'by_accreditation' => self::whereNotNull('accreditation')
                                     ->selectRaw('accreditation, COUNT(*) as count')
                                     ->groupBy('accreditation')
                                     ->pluck('count', 'accreditation')
                                     ->toArray(),
        ];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        // Ensure only one featured program per degree level
        static::updating(function ($program) {
            if ($program->isDirty('is_featured') && $program->is_featured) {
                // Optionally limit featured programs
                // self::where('degree_level', $program->degree_level)
                //     ->where('id', '!=', $program->id)
                //     ->update(['is_featured' => false]);
            }
        });
    }
}