<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class History extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'timeline_events',
        'milestones',
        'achievements',
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
        'timeline_events' => 'array',
        'milestones' => 'array',
        'achievements' => 'array',
        'is_active' => 'boolean'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Scope untuk history yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get the active history
    public static function getActiveHistory()
    {
        return static::active()->first();
    }

    // Accessor untuk timeline events dengan formatting
    public function getTimelineEventsFormattedAttribute()
    {
        $events = $this->timeline_events ?? [];
        $formattedEvents = [];
        
        foreach ($events as $event) {
            $formattedEvents[] = [
                'year' => $event['year'] ?? '',
                'title' => $event['title'] ?? '',
                'description' => $event['description'] ?? '',
                'type' => $event['type'] ?? 'milestone',
                'icon' => $event['icon'] ?? $this->getEventIcon($event['type'] ?? 'milestone'),
                'color' => $event['color'] ?? $this->getEventColor($event['type'] ?? 'milestone')
            ];
        }
        
        // Sort by year
        usort($formattedEvents, function($a, $b) {
            return ($a['year'] ?? 0) - ($b['year'] ?? 0);
        });
        
        return $formattedEvents;
    }

    // Helper untuk mendapatkan icon event
    private function getEventIcon($type)
    {
        $icons = [
            'founding' => 'fas fa-flag',
            'milestone' => 'fas fa-star',
            'achievement' => 'fas fa-trophy',
            'expansion' => 'fas fa-expand-arrows-alt',
            'renovation' => 'fas fa-tools',
            'accreditation' => 'fas fa-certificate',
            'partnership' => 'fas fa-handshake',
            'technology' => 'fas fa-laptop',
            'facility' => 'fas fa-building'
        ];

        return $icons[$type] ?? 'fas fa-calendar-alt';
    }

    // Helper untuk mendapatkan color event
    private function getEventColor($type)
    {
        $colors = [
            'founding' => 'danger',
            'milestone' => 'primary',
            'achievement' => 'warning',
            'expansion' => 'success',
            'renovation' => 'info',
            'accreditation' => 'warning',
            'partnership' => 'success',
            'technology' => 'info',
            'facility' => 'secondary'
        ];

        return $colors[$type] ?? 'primary';
    }

    // Accessor untuk milestones dengan formatting
    public function getMilestonesFormattedAttribute()
    {
        $milestones = $this->milestones ?? [];
        $formattedMilestones = [];
        
        foreach ($milestones as $milestone) {
            $formattedMilestones[] = [
                'year' => $milestone['year'] ?? '',
                'title' => $milestone['title'] ?? '',
                'description' => $milestone['description'] ?? '',
                'image' => $milestone['image'] ?? '',
                'icon' => $milestone['icon'] ?? 'fas fa-star',
                'color' => $milestone['color'] ?? 'primary'
            ];
        }
        
        // Sort by year
        usort($formattedMilestones, function($a, $b) {
            return ($a['year'] ?? 0) - ($b['year'] ?? 0);
        });
        
        return $formattedMilestones;
    }

    // Accessor untuk achievements dengan formatting
    public function getAchievementsFormattedAttribute()
    {
        $achievements = $this->achievements ?? [];
        $formattedAchievements = [];
        
        foreach ($achievements as $achievement) {
            $formattedAchievements[] = [
                'year' => $achievement['year'] ?? '',
                'title' => $achievement['title'] ?? '',
                'description' => $achievement['description'] ?? '',
                'level' => $achievement['level'] ?? 'Sekolah',
                'category' => $achievement['category'] ?? 'Umum',
                'icon' => $achievement['icon'] ?? $this->getAchievementIcon($achievement['category'] ?? 'Umum'),
                'color' => $achievement['color'] ?? $this->getAchievementColor($achievement['level'] ?? 'Sekolah')
            ];
        }
        
        // Sort by year descending
        usort($formattedAchievements, function($a, $b) {
            return ($b['year'] ?? 0) - ($a['year'] ?? 0);
        });
        
        return $formattedAchievements;
    }

    // Helper untuk mendapatkan icon achievement
    private function getAchievementIcon($category)
    {
        $icons = [
            'akademik' => 'fas fa-graduation-cap',
            'olahraga' => 'fas fa-trophy',
            'seni' => 'fas fa-music',
            'lingkungan' => 'fas fa-leaf',
            'teknologi' => 'fas fa-laptop',
            'sosial' => 'fas fa-users',
            'kepemimpinan' => 'fas fa-crown'
        ];

        $categoryLower = strtolower($category);
        foreach ($icons as $key => $icon) {
            if (strpos($categoryLower, $key) !== false) {
                return $icon;
            }
        }

        return 'fas fa-award';
    }

    // Helper untuk mendapatkan color achievement
    private function getAchievementColor($level)
    {
        $colors = [
            'internasional' => 'danger',
            'nasional' => 'warning',
            'provinsi' => 'success',
            'kota' => 'info',
            'kabupaten' => 'info',
            'sekolah' => 'secondary'
        ];

        $levelLower = strtolower($level);
        return $colors[$levelLower] ?? 'primary';
    }

    // Method untuk update history
    public function updateHistory(array $data)
    {
        // Set semua history lain menjadi tidak aktif jika history ini diaktifkan
        if (isset($data['is_active']) && $data['is_active']) {
            static::where('id', '!=', $this->id)->update(['is_active' => false]);
        }

        return $this->update($data);
    }

    // Method untuk activate history
    public function activate()
    {
        // Set semua history lain menjadi tidak aktif
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