<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingHelper
{
    /**
     * Get setting value with caching
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("setting_{$key}", 3600, function () use ($key, $default) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set setting value and clear cache
     */
    public static function set(string $key, $value, string $type = 'string', string $group = 'general')
    {
        $setting = Setting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group
            ]
        );

        // Clear cache
        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup(string $group)
    {
        return Cache::remember("settings_group_{$group}", 3600, function () use ($group) {
            return Setting::where('group', $group)->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Get school information
     */
    public static function getSchoolInfo()
    {
        return Cache::remember('school_info', 3600, function () {
            return [
                'name' => self::get('school_name', 'SMK PGRI 2 PONOROGO'),
                'npsn' => self::get('school_npsn'),
                'address' => self::get('school_address'),
                'phone' => self::get('school_phone'),
                'email' => self::get('school_email'),
                'website' => self::get('school_website'),
                'principal' => self::get('principal_name'),
                'accreditation' => self::get('school_accreditation'),
                'logo' => self::get('school_logo'),
                'favicon' => self::get('school_favicon'),
            ];
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        
        // Clear group caches
        $groups = ['school', 'academic', 'system', 'email', 'notification', 'backup'];
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
        }
        
        Cache::forget('school_info');
    }

    /**
     * Get boolean setting value
     */
    public static function getBool(string $key, bool $default = false): bool
    {
        $value = self::get($key, $default);
        
        if (is_bool($value)) {
            return $value;
        }
        
        if (is_string($value)) {
            return in_array(strtolower($value), ['1', 'true', 'yes', 'on']);
        }
        
        return (bool) $value;
    }

    /**
     * Get integer setting value
     */
    public static function getInt(string $key, int $default = 0): int
    {
        return (int) self::get($key, $default);
    }

    /**
     * Get float setting value
     */
    public static function getFloat(string $key, float $default = 0.0): float
    {
        return (float) self::get($key, $default);
    }

    /**
     * Check if setting exists
     */
    public static function has(string $key): bool
    {
        return Setting::where('key', $key)->exists();
    }

    /**
     * Delete setting
     */
    public static function forget(string $key): bool
    {
        Cache::forget("setting_{$key}");
        return Setting::where('key', $key)->delete();
    }

    /**
     * Get all settings as array
     */
    public static function all(): array
    {
        return Cache::remember('all_settings', 3600, function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Bulk set settings
     */
    public static function setBulk(array $settings): void
    {
        foreach ($settings as $key => $data) {
            if (is_array($data)) {
                self::set(
                    $key,
                    $data['value'] ?? '',
                    $data['type'] ?? 'string',
                    $data['group'] ?? 'general'
                );
            } else {
                self::set($key, $data);
            }
        }
    }
}