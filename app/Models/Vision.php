<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vision extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'vision_text',
        'mission_items',
        'goals',
        'values',
        'focus_areas',
        'roadmap_phases',
        'hero_image',
        'hero_title',
        'hero_subtitle',
        'meta_title',
        'meta_description',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'mission_items' => 'array',
        'goals' => 'array',
        'values' => 'array',
        'focus_areas' => 'array',
        'roadmap_phases' => 'array',
        'is_active' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Scope untuk vision yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get the active vision
    public static function getActiveVision()
    {
        return static::active()->first();
    }

    // Accessor untuk mission items dengan numbering
    public function getMissionItemsFormattedAttribute()
    {
        $missions = $this->mission_items ?? [];
        $formattedMissions = [];
        
        foreach ($missions as $index => $mission) {
            $formattedMissions[] = [
                'number' => $index + 1,
                'title' => $mission['title'] ?? '',
                'description' => $mission['description'] ?? '',
                'icon' => $mission['icon'] ?? 'fas fa-bullseye'
            ];
        }
        
        return $formattedMissions;
    }

    // Accessor untuk goals dengan icons
    public function getGoalsWithIconsAttribute()
    {
        $goals = $this->goals ?? [];
        $goalsWithIcons = [];
        
        foreach ($goals as $goal) {
            $goalsWithIcons[] = [
                'title' => $goal['title'] ?? '',
                'description' => $goal['description'] ?? '',
                'icon' => $goal['icon'] ?? $this->getGoalIcon($goal['title'] ?? ''),
                'color' => $goal['color'] ?? 'primary'
            ];
        }
        
        return $goalsWithIcons;
    }

    // Helper untuk mendapatkan icon goal
    private function getGoalIcon($goalTitle)
    {
        $icons = [
            'akademik' => 'fas fa-graduation-cap',
            'karakter' => 'fas fa-users',
            'lingkungan' => 'fas fa-leaf',
            'global' => 'fas fa-globe',
            'teknologi' => 'fas fa-laptop',
            'prestasi' => 'fas fa-medal',
            'kualitas' => 'fas fa-star',
            'inovasi' => 'fas fa-lightbulb'
        ];

        $titleLower = strtolower($goalTitle);
        foreach ($icons as $key => $icon) {
            if (strpos($titleLower, $key) !== false) {
                return $icon;
            }
        }

        return 'fas fa-target';
    }

    // Accessor untuk values dengan colors
    public function getValuesWithColorsAttribute()
    {
        $values = $this->values ?? [];
        $valuesWithColors = [];
        
        foreach ($values as $value) {
            $valuesWithColors[] = [
                'title' => $value['title'] ?? '',
                'description' => $value['description'] ?? '',
                'icon' => $value['icon'] ?? $this->getValueIcon($value['title'] ?? ''),
                'color' => $value['color'] ?? $this->getValueColor($value['title'] ?? '')
            ];
        }
        
        return $valuesWithColors;
    }

    // Helper untuk mendapatkan icon value
    private function getValueIcon($valueTitle)
    {
        $icons = [
            'keadilan' => 'fas fa-balance-scale',
            'integritas' => 'fas fa-heart',
            'inovasi' => 'fas fa-lightbulb',
            'lingkungan' => 'fas fa-leaf',
            'kerjasama' => 'fas fa-handshake',
            'disiplin' => 'fas fa-clock',
            'tanggung jawab' => 'fas fa-shield-alt'
        ];

        $titleLower = strtolower($valueTitle);
        foreach ($icons as $key => $icon) {
            if (strpos($titleLower, $key) !== false) {
                return $icon;
            }
        }

        return 'fas fa-star';
    }

    // Helper untuk mendapatkan color value
    private function getValueColor($valueTitle)
    {
        $colors = [
            'keadilan' => 'primary',
            'integritas' => 'danger',
            'inovasi' => 'info',
            'lingkungan' => 'success',
            'kerjasama' => 'warning',
            'disiplin' => 'secondary',
            'tanggung jawab' => 'dark'
        ];

        $titleLower = strtolower($valueTitle);
        foreach ($colors as $key => $color) {
            if (strpos($titleLower, $key) !== false) {
                return $color;
            }
        }

        return 'primary';
    }

    // Accessor untuk focus areas dengan icons
    public function getFocusAreasWithIconsAttribute()
    {
        $focusAreas = $this->focus_areas ?? [];
        $areasWithIcons = [];
        
        foreach ($focusAreas as $area) {
            $areasWithIcons[] = [
                'title' => $area['title'] ?? '',
                'description' => $area['description'] ?? '',
                'items' => $area['items'] ?? [],
                'icon' => $area['icon'] ?? $this->getFocusAreaIcon($area['title'] ?? ''),
                'color' => $area['color'] ?? 'primary'
            ];
        }
        
        return $areasWithIcons;
    }

    // Helper untuk mendapatkan icon focus area
    private function getFocusAreaIcon($areaTitle)
    {
        $icons = [
            'pembelajaran' => 'fas fa-brain',
            'karakter' => 'fas fa-seedling',
            'prestasi' => 'fas fa-medal',
            'kemitraan' => 'fas fa-globe',
            'teknologi' => 'fas fa-laptop',
            'lingkungan' => 'fas fa-leaf'
        ];

        $titleLower = strtolower($areaTitle);
        foreach ($icons as $key => $icon) {
            if (strpos($titleLower, $key) !== false) {
                return $icon;
            }
        }

        return 'fas fa-bullseye';
    }

    // Accessor untuk roadmap phases dengan colors
    public function getRoadmapPhasesFormattedAttribute()
    {
        $phases = $this->roadmap_phases ?? [];
        $formattedPhases = [];
        
        foreach ($phases as $phase) {
            $formattedPhases[] = [
                'year' => $phase['year'] ?? '',
                'title' => $phase['title'] ?? '',
                'description' => $phase['description'] ?? '',
                'target' => $phase['target'] ?? '',
                'color' => $phase['color'] ?? $this->getPhaseColor($phase['year'] ?? ''),
                'status' => $phase['status'] ?? 'planned'
            ];
        }
        
        // Sort by year
        usort($formattedPhases, function($a, $b) {
            return strcmp($a['year'], $b['year']);
        });
        
        return $formattedPhases;
    }

    // Helper untuk mendapatkan color phase
    private function getPhaseColor($year)
    {
        $colors = ['primary', 'success', 'warning', 'info', 'secondary'];
        $yearNum = intval($year);
        $index = ($yearNum - 2025) % count($colors);
        return $colors[$index] ?? 'primary';
    }

    // Method untuk update vision
    public function updateVision(array $data)
    {
        // Set semua vision lain menjadi tidak aktif jika vision ini diaktifkan
        if (isset($data['is_active']) && $data['is_active']) {
            static::where('id', '!=', $this->id)->update(['is_active' => false]);
        }

        return $this->update($data);
    }

    // Method untuk activate vision
    public function activate()
    {
        // Set semua vision lain menjadi tidak aktif
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        return $this->update(['is_active' => true]);
    }

    // Relationship dengan user yang membuat
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relationship dengan user yang mengupdate
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}