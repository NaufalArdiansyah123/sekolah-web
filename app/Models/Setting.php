<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get setting value with caching
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value and clear cache
     */
    public static function set($key, $value, $type = 'string', $group = 'general')
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");
        Cache::forget('all_settings');
        Cache::forget("settings_group_{$group}");
        
        // Clear school info cache if it's a school setting
        if ($group === 'school') {
            Cache::forget('school_info');
        }
        
        return $setting;
    }

    /**
     * Get boolean value
     */
    public static function getBool($key, $default = false)
    {
        $value = static::get($key, $default);
        
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            return in_array(strtolower($value), ['1', 'true', 'yes', 'on']);
        }
        
        return (bool) $value;
    }

    /**
     * Get integer value
     */
    public static function getInt($key, $default = 0)
    {
        return (int) static::get($key, $default);
    }

    /**
     * Get float value
     */
    public static function getFloat($key, $default = 0.0)
    {
        return (float) static::get($key, $default);
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return static::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all caches
     */
    public static function clearCache()
    {
        $settings = static::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        
        $groups = ['school', 'academic', 'system', 'email', 'notification', 'backup', 'general'];
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
        }
        
        Cache::forget('all_settings');
        Cache::forget('school_info');
    }

    /**
     * Boot method to clear cache on model events
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($setting) {
            Cache::forget("setting_{$setting->key}");
            Cache::forget('all_settings');
            Cache::forget("settings_group_{$setting->group}");
            
            if ($setting->group === 'school') {
                Cache::forget('school_info');
            }
        });

        static::deleted(function ($setting) {
            Cache::forget("setting_{$setting->key}");
            Cache::forget('all_settings');
            Cache::forget("settings_group_{$setting->group}");
            
            if ($setting->group === 'school') {
                Cache::forget('school_info');
            }
        });
    }

    /**
     * Scope for specific group
     */
    public function scopeGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope for specific type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}