<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share settings with all views
        View::composer('*', function ($view) {
            try {
                $settings = [
                    'school_name' => Setting::get('school_name', 'SMK PGRI 2 PONOROGO'),
                    'school_subtitle' => Setting::get('school_subtitle', 'Terbukti Lebih Maju'),
                    'school_logo' => Setting::get('school_logo'),
                    'school_favicon' => Setting::get('school_favicon'),
                    'school_phone' => Setting::get('school_phone', '(024) 123-4567'),
                    'school_email' => Setting::get('school_email', 'info@sekolah.com'),
                    'school_address' => Setting::get('school_address', ''),
                    'school_website' => Setting::get('school_website', ''),
                    'principal_name' => Setting::get('principal_name', ''),
                    'school_npsn' => Setting::get('school_npsn', ''),
                    'school_accreditation' => Setting::get('school_accreditation', ''),
                ];
                
                $view->with('globalSettings', $settings);
                
                // Also provide as schoolInfo for backward compatibility
                $view->with('schoolInfo', $settings);
            } catch (\Exception $e) {
                // Fallback values if database is not available
                $fallbackSettings = [
                    'school_name' => 'SMK PGRI 2 PONOROGO',
                    'school_subtitle' => 'Terbukti Lebih Maju',
                    'school_logo' => null,
                    'school_favicon' => null,
                    'school_phone' => '(024) 123-4567',
                    'school_email' => 'info@sekolah.com',
                    'school_address' => '',
                    'school_website' => '',
                    'principal_name' => '',
                    'school_npsn' => '',
                    'school_accreditation' => '',
                ];
                
                $view->with('globalSettings', $fallbackSettings);
                $view->with('schoolInfo', $fallbackSettings);
            }
        });
    }
}