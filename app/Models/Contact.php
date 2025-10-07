<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'phone',
        'email',
        'website',
        'map_embed',
        'social_media',
        'quick_cards',
        'hero_image',
        'office_hours',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'social_media' => 'array',
        'quick_cards' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Scope for active contacts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered contacts
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc');
    }

    /**
     * Get formatted social media links
     */
    public function getFormattedSocialMediaAttribute()
    {
        if (!$this->social_media) {
            return [];
        }

        $formatted = [];
        foreach ($this->social_media as $platform => $url) {
            if (!empty($url)) {
                $formatted[$platform] = [
                    'url' => $url,
                    'icon' => $this->getSocialMediaIcon($platform),
                    'name' => ucfirst($platform)
                ];
            }
        }

        return $formatted;
    }

    /**
     * Get social media icon class
     */
    private function getSocialMediaIcon($platform)
    {
        $icons = [
            'facebook' => 'fab fa-facebook',
            'instagram' => 'fab fa-instagram',
            'twitter' => 'fab fa-twitter',
            'youtube' => 'fab fa-youtube',
            'linkedin' => 'fab fa-linkedin',
            'whatsapp' => 'fab fa-whatsapp',
            'telegram' => 'fab fa-telegram'
        ];

        return $icons[$platform] ?? 'fas fa-link';
    }

    /**
     * Get formatted phone number
     */
    public function getFormattedPhoneAttribute()
    {
        if (!$this->phone) {
            return null;
        }

        // Simple phone formatting for Indonesian numbers
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        if (strlen($phone) >= 10) {
            return preg_replace('/(\d{4})(\d{4})(\d+)/', '$1-$2-$3', $phone);
        }

        return $this->phone;
    }

    /**
     * Get clean map embed code
     */
    public function getCleanMapEmbedAttribute()
    {
        if (!$this->map_embed) {
            return null;
        }

        // Extract src from iframe if full iframe is provided
        if (strpos($this->map_embed, '<iframe') !== false) {
            preg_match('/src="([^"]+)"/', $this->map_embed, $matches);
            return $matches[1] ?? $this->map_embed;
        }

        return $this->map_embed;
    }

    /**
     * Get the active contact (only one should be active)
     */
    public static function getActiveContact()
    {
        return static::where('is_active', true)
                    ->ordered()
                    ->first();
    }

    /**
     * Get formatted quick cards with defaults
     */
    public function getFormattedQuickCardsAttribute()
    {
        $defaultCards = [
            [
                'icon' => 'fas fa-user-graduate',
                'title' => 'Penerimaan Siswa',
                'description' => 'Informasi lengkap tentang penerimaan siswa baru, syarat pendaftaran, dan jadwal seleksi.'
            ],
            [
                'icon' => 'fas fa-book',
                'title' => 'Program Akademik',
                'description' => 'Kurikulum, ekstrakurikuler, dan berbagai program unggulan yang tersedia di sekolah kami.'
            ],
            [
                'icon' => 'fas fa-users',
                'title' => 'Kerjasama',
                'description' => 'Peluang kerjasama dengan institusi lain, program magang, dan kemitraan strategis.'
            ]
        ];

        // Check if quick_cards column exists and has data
        try {
            return $this->quick_cards ?: $defaultCards;
        } catch (\Exception $e) {
            // If column doesn't exist, return default cards
            return $defaultCards;
        }
    }

    /**
     * Get hero image URL
     */
    public function getHeroImageUrlAttribute()
    {
        if ($this->hero_image && file_exists(public_path('storage/' . $this->hero_image))) {
            return asset('storage/' . $this->hero_image);
        }
        return null;
    }

    /**
     * Boot method to ensure only one contact is active
     */
    protected static function boot()
    {
        parent::boot();

        // When a contact is being saved and set to active
        static::saving(function ($contact) {
            if ($contact->is_active) {
                // Deactivate all other contacts
                static::where('id', '!=', $contact->id)
                      ->where('is_active', true)
                      ->update(['is_active' => false]);
            }
        });

        // When a contact is being created and set to active
        static::creating(function ($contact) {
            if ($contact->is_active) {
                // Deactivate all other contacts
                static::where('is_active', true)
                      ->update(['is_active' => false]);
            }
        });
    }
}