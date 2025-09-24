<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DebugController extends Controller
{
    public function createTeacher()
    {
        try {
            // Check if teacher role exists
            $teacherRole = Role::where('name', 'teacher')->first();
            if (!$teacherRole) {
                $teacherRole = Role::create([
                    'name' => 'teacher',
                    'guard_name' => 'web'
                ]);
            }
            
            // Create or find teacher user
            $teacher = User::where('email', 'teacher@test.com')->first();
            if (!$teacher) {
                $teacher = User::create([
                    'name' => 'Test Teacher',
                    'email' => 'teacher@test.com',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now()
                ]);
            }
            
            // Assign role
            if (!$teacher->hasRole('teacher')) {
                $teacher->assignRole('teacher');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Teacher user created/updated successfully',
                'user' => [
                    'id' => $teacher->id,
                    'name' => $teacher->name,
                    'email' => $teacher->email,
                    'roles' => $teacher->roles->pluck('name')->toArray()
                ],
                'login_info' => [
                    'email' => 'teacher@test.com',
                    'password' => 'password'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
    
    public function userRoles()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Not authenticated']);
        }
        
        $user = auth()->user();
        return response()->json([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'roles' => $user->roles->pluck('name')->toArray(),
            'has_admin' => $user->hasRole('admin'),
            'has_teacher' => $user->hasRole('teacher'),
            'has_student' => $user->hasRole('student'),
            'all_permissions' => $user->getAllPermissions()->pluck('name')->toArray()
        ]);
    }
    
    public function testRedirect()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Not authenticated']);
        }
        
        $user = auth()->user();
        $roles = $user->roles->pluck('name')->toArray();
        
        $redirectTo = null;
        
        if ($user->hasRole('admin')) {
            $redirectTo = 'admin.dashboard';
        } elseif ($user->hasRole('teacher')) {
            $redirectTo = 'teacher.dashboard';
        } elseif ($user->hasRole('student')) {
            $redirectTo = 'student.dashboard';
        } else {
            $redirectTo = 'home';
        }
        
        return response()->json([
            'user' => $user->email,
            'roles' => $roles,
            'should_redirect_to' => $redirectTo,
            'admin_route_exists' => \Route::has('admin.dashboard'),
            'teacher_route_exists' => \Route::has('teacher.dashboard'),
            'student_route_exists' => \Route::has('student.dashboard'),
            'can_access_admin' => $user->hasRole('admin'),
            'can_access_teacher' => $user->hasRole('teacher')
        ]);
    }
    
    /**
     * Show all users with their roles
     */
    public function allUsersRoles()
    {
        try {
            $users = User::with('roles')->get()->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'email_verified' => $user->email_verified_at ? true : false
                ];
            });
            
            return response()->json([
                'success' => true,
                'total_users' => $users->count(),
                'users' => $users
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Check specific user role by email
     */
    public function checkUserRole(Request $request)
    {
        $email = $request->get('email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'error' => 'Email parameter required. Usage: /debug/check-user-role?email=user@example.com'
            ], 400);
        }
        
        try {
            $user = User::where('email', $email)->with('roles')->first();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'error' => 'User not found with email: ' . $email
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name')->toArray(),
                    'has_admin' => $user->hasRole('admin'),
                    'has_teacher' => $user->hasRole('teacher'),
                    'has_student' => $user->hasRole('student'),
                    'permissions' => $user->getAllPermissions()->pluck('name')->toArray(),
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'email_verified' => $user->email_verified_at ? true : false
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Show role info page with HTML interface
     */
    public function roleInfoPage()
    {
        return view('debug.role-info');
    }
}