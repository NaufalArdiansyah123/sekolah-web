<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load helper files
        require_once app_path('Helpers/RegistrationHelper.php');
    }
    
    /**
     * Share school settings to all views
     */
    private function shareSchoolSettings()
    {
        try {
            if (Schema::hasTable('settings')) {
                $schoolSettings = \App\Models\Setting::getByGroup('school');
                
                // Add default values if not set
                $schoolSettings = array_merge([
                    'school_name' => 'SMK PGRI 2 PONOROGO',
                    'school_logo' => '',
                    'school_address' => '',
                    'school_phone' => '',
                    'school_email' => '',
                    'school_website' => '',
                    'principal_name' => '',
                    'school_accreditation' => '',
                ], $schoolSettings);
                
                View::share('schoolSettings', $schoolSettings);
                
                // Share individual settings for backward compatibility
                foreach ($schoolSettings as $key => $value) {
                    View::share($key, $value);
                }
            }
        } catch (\Exception $e) {
            // Silently fail if settings table doesn't exist yet
            View::share('schoolSettings', [
                'school_name' => 'SMK PGRI 2 PONOROGO',
                'school_logo' => '',
                'school_address' => '',
                'school_phone' => '',
                'school_email' => '',
                'school_website' => '',
                'principal_name' => '',
                'school_accreditation' => '',
            ]);
        }
    }
}