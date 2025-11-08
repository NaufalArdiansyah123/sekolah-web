<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Redirect based on user role
        $user = auth()->user();

        // Log for debugging
        Log::info('Login redirect for user: ' . $user->email, [
            'user_id' => $user->id,
            'roles' => $user->roles->pluck('name')->toArray(),
            'roles_count' => $user->roles->count(),
            'has_admin' => $user->hasRole('admin'),
            'has_teacher' => $user->hasRole('teacher'),
            'has_guru_piket' => $user->hasRole('guru_piket'),
            'has_student' => $user->hasRole('student'),
            'all_role_checks' => [
                'admin' => $user->hasRole('admin'),
                'teacher' => $user->hasRole('teacher'),
                'guru_piket' => $user->hasRole('guru_piket'),
                'student' => $user->hasRole('student')
            ]
        ]);

        // Check roles in priority order
        if ($user->hasRole('admin')) {
            Log::info('Login: Redirecting to admin dashboard (admin)');
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('teacher')) {
            Log::info('Login: Redirecting to teacher dashboard');
            return redirect()->route('teacher.dashboard');
        } elseif ($user->hasRole('guru_piket')) {
            Log::info('Login: Redirecting to guru piket dashboard');
            return redirect()->route('guru-piket.dashboard');
        } elseif ($user->hasRole('student')) {
            Log::info('Login: Redirecting to student dashboard');
            return redirect()->route('student.dashboard');
        }

        // Default redirect for users without specific roles
        Log::info('Login: Redirecting to default home - no matching roles found');
        return redirect()->route('home');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
