<?php
// app/Http/Middleware/CheckRole.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Log untuk debugging
        Log::info('CheckRole middleware', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'required_roles' => $roles,
            'user_roles' => $user->roles->pluck('name')->toArray()
        ]);
        
        // Jika user memiliki role admin, izinkan akses ke semua
        if ($user->hasRole('admin')) {
            Log::info('Access granted: User has admin role');
            return $next($request);
        }
        
        // Periksa role yang diminta
        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                Log::info('Access granted: User has required role', ['role' => $role]);
                return $next($request);
            }
        }

        Log::warning('Access denied: User does not have required roles', [
            'required_roles' => $roles,
            'user_roles' => $user->roles->pluck('name')->toArray()
        ]);
        
        abort(403, 'Unauthorized access');
    }
}