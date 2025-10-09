<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolProfile extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'school_name',

        'school_motto',
        'about_description',
        'vision',
        'mission',
        'history',
        'established_year',
        'accreditation',
        'principal_name',
        'principal_photo',
        'vice_principals',
        'address',
        'phone',
        'email',
        'website',
        'social_media',
        'student_count',
        'teacher_count',
        'staff_count',
        'industry_partnerships',
        'graduation_rate',
        'facilities',
        'achievements',
        'programs',
        'hero_image',
        'gallery_images',
        'contact_info',
        'is_active',
        'meta_data'
    ];

    protected $casts = [
        'vice_principals' => 'array',
        'social_media' => 'array',
        'facilities' => 'array',
        'achievements' => 'array',
        'programs' => 'array',
        'gallery_images' => 'array',
        'contact_info' => 'array',
        'meta_data' => 'array',
        'is_active' => 'boolean',
        'student_count' => 'integer',
        'teacher_count' => 'integer',
        'staff_count' => 'integer',
        'industry_partnerships' => 'integer',
        'graduation_rate' => 'integer',
        'established_year' => 'integer'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    // Scope untuk profile yang aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Get the active school profile
    public static function getActiveProfile()
    {
        return static::active()->first();
    }

    // Accessor untuk format tahun berdiri
    public function getEstablishedYearFormattedAttribute()
    {
        if ($this->established_year) {
            $years = date('Y') - $this->established_year;
            return $this->established_year . ' (' . $years . ' tahun)';
        }
        return null;
    }

    // Accessor untuk social media links
    public function getSocialMediaLinksAttribute()
    {
        $socialMedia = $this->social_media ?? [];
        $links = [];
        
        foreach ($socialMedia as $platform => $url) {
            if (!empty($url)) {
                $links[$platform] = [
                    'url' => $url,
                    'icon' => $this->getSocialMediaIcon($platform),
                    'name' => ucfirst($platform)
                ];
            }
        }
        
        return $links;
    }

    // Helper untuk mendapatkan icon social media
    private function getSocialMediaIcon($platform)
    {
        $icons = [
            'facebook' => 'fab fa-facebook-f',
            'instagram' => 'fab fa-instagram',
            'twitter' => 'fab fa-twitter',
            'youtube' => 'fab fa-youtube',
            'linkedin' => 'fab fa-linkedin-in',
            'tiktok' => 'fab fa-tiktok',
            'whatsapp' => 'fab fa-whatsapp'
        ];

        return $icons[$platform] ?? 'fas fa-link';
    }

    // Accessor untuk facilities dengan icon
    public function getFacilitiesWithIconsAttribute()
    {
        $facilities = $this->facilities ?? [];
        $facilitiesWithIcons = [];
        
        foreach ($facilities as $facility) {
            $facilitiesWithIcons[] = [
                'name' => $facility['name'] ?? $facility,
                'description' => $facility['description'] ?? '',
                'icon' => $facility['icon'] ?? $this->getFacilityIcon($facility['name'] ?? $facility),
                'color' => $facility['color'] ?? 'primary',
                'features' => $facility['features'] ?? []
            ];
        }
        
        return $facilitiesWithIcons;
    }

    // Helper untuk mendapatkan icon fasilitas
    private function getFacilityIcon($facilityName)
    {
        $icons = [
            'laboratorium' => 'fas fa-microscope',
            'perpustakaan' => 'fas fa-book',
            'studio seni' => 'fas fa-music',
            'lapangan olahraga' => 'fas fa-running',
            'kantin' => 'fas fa-utensils',
            'masjid' => 'fas fa-mosque',
            'aula' => 'fas fa-building',
            'parkir' => 'fas fa-parking',
            'wifi' => 'fas fa-wifi',
            'ac' => 'fas fa-snowflake'
        ];

        $facilityLower = strtolower($facilityName);
        foreach ($icons as $key => $icon) {
            if (strpos($facilityLower, $key) !== false) {
                return $icon;
            }
        }

        return 'fas fa-building';
    }

    // Accessor untuk achievements dengan badge color
    public function getAchievementsWithBadgesAttribute()
    {
        $achievements = $this->achievements ?? [];
        $achievementsWithBadges = [];
        
        foreach ($achievements as $achievement) {
            $level = strtolower($achievement['level'] ?? 'kota');
            $badgeColor = $achievement['badge_color'] ?? $this->getAchievementBadgeColor($level);
            
            $achievementsWithBadges[] = [
                'title' => $achievement['title'] ?? $achievement,
                'description' => $achievement['description'] ?? '',
                'level' => $achievement['level'] ?? 'Kota',
                'year' => $achievement['year'] ?? date('Y'),
                'month' => $achievement['month'] ?? '',
                'badge_color' => $badgeColor,
                'icon' => $achievement['icon'] ?? $this->getAchievementIcon($achievement['title'] ?? $achievement)
            ];
        }
        
        return $achievementsWithBadges;
    }

    // Helper untuk mendapatkan warna badge achievement
    private function getAchievementBadgeColor($level)
    {
        $colors = [
            'internasional' => 'danger',
            'nasional' => 'warning',
            'provinsi' => 'success',
            'kota' => 'info',
            'kabupaten' => 'info'
        ];

        return $colors[$level] ?? 'secondary';
    }

    // Helper untuk mendapatkan icon achievement
    private function getAchievementIcon($title)
    {
        $titleLower = strtolower($title);
        
        if (strpos($titleLower, 'olimpiade') !== false || strpos($titleLower, 'sains') !== false) {
            return 'fas fa-medal';
        } elseif (strpos($titleLower, 'olahraga') !== false || strpos($titleLower, 'sport') !== false) {
            return 'fas fa-trophy';
        } elseif (strpos($titleLower, 'seni') !== false || strpos($titleLower, 'musik') !== false) {
            return 'fas fa-music';
        } elseif (strpos($titleLower, 'lingkungan') !== false || strpos($titleLower, 'adiwiyata') !== false) {
            return 'fas fa-leaf';
        } elseif (strpos($titleLower, 'debat') !== false || strpos($titleLower, 'bahasa') !== false) {
            return 'fas fa-comments';
        }
        
        return 'fas fa-award';
    }

    // Method untuk update profile
    public function updateProfile(array $data)
    {
        // Set semua profile lain menjadi tidak aktif jika profile ini diaktifkan
        if (isset($data['is_active']) && $data['is_active']) {
            static::where('id', '!=', $this->id)->update(['is_active' => false]);
        }

        return $this->update($data);
    }

    // Method untuk activate profile
    public function activate()
    {
        // Set semua profile lain menjadi tidak aktif
        static::where('id', '!=', $this->id)->update(['is_active' => false]);
        
        return $this->update(['is_active' => true]);
    }

    // Accessor untuk history timeline
    public function getHistoryTimelineAttribute()
    {
        if (empty($this->history)) {
            return [];
        }
        
        // Try to decode as JSON first (new format)
        $decoded = json_decode($this->history, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            // Sort by year
            usort($decoded, function($a, $b) {
                return ($a['year'] ?? 0) - ($b['year'] ?? 0);
            });
            return $decoded;
        }
        
        // Fallback to plain text (old format)
        return [
            [
                'year' => $this->established_year ?? date('Y'),
                'title' => 'Sejarah Sekolah',
                'description' => $this->history,
                'type' => 'milestone'
            ]
        ];
    }
}