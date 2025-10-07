<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

class ShareSettingsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Share school settings to all views
        $schoolSettings = [
            'school_name' => Setting::get('school_name', 'SMK PGRI 2 PONOROGO'),
            'school_logo' => Setting::get('school_logo'),
            'school_address' => Setting::get('school_address'),
            'school_phone' => Setting::get('school_phone'),
            'school_email' => Setting::get('school_email'),
            'school_website' => Setting::get('school_website'),
            'principal_name' => Setting::get('principal_name'),
            'school_accreditation' => Setting::get('school_accreditation'),
            'maintenance_mode' => Setting::getBool('maintenance_mode', false),
        ];

        View::share('schoolSettings', $schoolSettings);
        
        // Share individual settings for backward compatibility
        foreach ($schoolSettings as $key => $value) {
            View::share($key, $value);
        }

        return $next($request);
    }
}