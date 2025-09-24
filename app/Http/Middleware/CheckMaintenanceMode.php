<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            // Check if maintenance mode is enabled from database settings
            $maintenanceMode = Setting::where('key', 'maintenance_mode')->first();
            
            if ($maintenanceMode && $maintenanceMode->value == '1') {
                // Define routes that should bypass maintenance mode
                $allowedRoutes = [
                    'admin',
                    'admin/*',
                    'login',
                    'login/*',
                    'logout',
                    'register',
                    'password/*',
                    'email/*',
                    'api/*'
                ];
                
                // Check if current route should be allowed
                foreach ($allowedRoutes as $pattern) {
                    if ($request->is($pattern)) {
                        return $next($request);
                    }
                }
                
                // Allow authenticated admin users to access any route
                if ($request->user() && $request->user()->hasRole('admin')) {
                    return $next($request);
                }
                
                // Show maintenance page for all other routes
                return $this->showMaintenancePage($request);
            }
        } catch (\Exception $e) {
            // If there's an error checking the setting, log it but don't block the request
            \Log::error('Error checking maintenance mode:', [
                'error' => $e->getMessage(),
                'url' => $request->url(),
                'trace' => $e->getTraceAsString()
            ]);
        }
        
        return $next($request);
    }
    
    /**
     * Show maintenance page
     */
    private function showMaintenancePage(Request $request)
    {
        // Get school information for the maintenance page
        $schoolName = Setting::where('key', 'school_name')->first();
        $schoolName = $schoolName ? $schoolName->value : 'Sekolah';
        
        $schoolLogo = Setting::where('key', 'school_logo')->first();
        $schoolLogo = $schoolLogo ? $schoolLogo->value : null;
        
        $schoolEmail = Setting::where('key', 'school_email')->first();
        $schoolEmail = $schoolEmail ? $schoolEmail->value : null;
        
        $schoolPhone = Setting::where('key', 'school_phone')->first();
        $schoolPhone = $schoolPhone ? $schoolPhone->value : null;
        
        // If it's an AJAX request, return JSON response
        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Website sedang dalam mode maintenance. Silakan coba lagi nanti.',
                'maintenance_mode' => true,
                'school_name' => $schoolName
            ], 503);
        }
        
        // Return maintenance view
        return response()->view('maintenance', [
            'school_name' => $schoolName,
            'school_logo' => $schoolLogo,
            'school_email' => $schoolEmail,
            'school_phone' => $schoolPhone
        ], 503);
    }
}