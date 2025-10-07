<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            // Check if user status is pending or rejected
            if ($user->status === 'pending') {
                Auth::logout();
                return redirect()->route('student.registration.pending')
                    ->with('error', 'Akun Anda masih menunggu konfirmasi dari admin. Silakan tunggu hingga akun Anda disetujui.');
            }
            
            if ($user->status === 'rejected') {
                Auth::logout();
                
                // Store user ID in session for rejection page
                request()->session()->put('rejected_user_id', $user->id);
                
                return redirect()->route('auth.rejection.show')
                    ->with('info', 'Pendaftaran Anda telah ditinjau. Silakan baca penjelasan di bawah ini.');
            }
            
            if ($user->status === 'inactive') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin untuk informasi lebih lanjut.');
            }
            
            // Check if email is not verified (but allow active users created by admin)
            if (!$user->email_verified_at && $user->status !== 'active') {
                Auth::logout();
                return redirect()->route('login')
                    ->with('error', 'Akun Anda belum diverifikasi. Silakan periksa email Anda untuk verifikasi.');
            }
        }
        
        return $next($request);
    }
}