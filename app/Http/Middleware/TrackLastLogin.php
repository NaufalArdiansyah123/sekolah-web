<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserActivity;

class TrackLastLogin
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
            
            // Only update if it's been more than 5 minutes since last update
            // to avoid too frequent database writes
            if (!$user->last_login_at || $user->last_login_at->diffInMinutes(now()) > 5) {
                $user->update([
                    'last_login_at' => now()
                ]);
                
                // Log login activity (only once per session)
                if (!session('login_logged')) {
                    UserActivity::log(
                        $user->id,
                        'login',
                        'Logged in to the system',
                        [
                            'user_agent' => $request->userAgent(),
                            'ip_address' => $request->ip()
                        ]
                    );
                    session(['login_logged' => true]);
                }
            }
        }

        return $next($request);
    }
}