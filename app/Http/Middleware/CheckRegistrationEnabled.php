<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistrationEnabled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if registration is allowed
        $allowRegistration = Setting::get('allow_registration', '1');
        
        if ($allowRegistration !== '1') {
            // If it's an AJAX request, return JSON response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Pendaftaran akun siswa saat ini sedang ditutup'
                ], 403);
            }
            
            // For regular requests, redirect to home with error message
            return redirect()->route('home')
                ->with('error', 'Pendaftaran akun siswa saat ini sedang ditutup. Silakan hubungi administrator sekolah untuk informasi lebih lanjut.');
        }

        return $next($request);
    }
}