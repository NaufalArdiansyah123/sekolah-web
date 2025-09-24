<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('email_verified_at');
            } elseif ($request->status === 'verified') {
                $query->whereNotNull('email_verified_at');
            }
        }

        $users = $query->latest()->paginate(10);
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'email_verified_at' => now(), // Auto verify for admin created users
            'status' => 'active', // Set status to active immediately
        ]);

        // Assign role - ensure clean assignment
        $user->syncRoles([]); // Clear any existing roles first
        $user->assignRole($request->role);
        
        // Verify role assignment
        $user = $user->fresh(); // Reload user with fresh data
        
        // Debug: Log role assignment
        \Log::info('User created with role assignment', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'requested_role' => $request->role,
            'assigned_roles' => $user->roles->pluck('name')->toArray(),
            'roles_count' => $user->roles->count(),
            'has_teacher_role' => $user->hasRole('teacher'),
            'has_student_role' => $user->hasRole('student'),
            'role_assignment_success' => $user->hasRole($request->role)
        ]);
        
        // Verify the role was assigned correctly
        if (!$user->hasRole($request->role)) {
            \Log::error('Role assignment failed', [
                'user_id' => $user->id,
                'requested_role' => $request->role,
                'actual_roles' => $user->roles->pluck('name')->toArray()
            ]);
            
            return redirect()->route('admin.users.index')
                ->with('error', 'User dibuat tetapi role assignment gagal. Silakan edit user untuk mengatur role.');
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan dan dapat langsung digunakan untuk login!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        // Update role
        $user->syncRoles([$request->role]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting current user
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        // Prevent deleting super admin if current user is not super admin
        if ($user->hasRole('admin') && !auth()->user()->hasRole('admin')) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak memiliki izin untuk menghapus Super Administrator!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Toggle user status (activate/deactivate)
     */
    public function toggleStatus(User $user)
    {
        // Prevent deactivating current user
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun sendiri!'
            ], 403);
        }

        // Toggle both email_verified_at and status
        $isActive = $user->email_verified_at && $user->status === 'active';
        
        $user->update([
            'email_verified_at' => $isActive ? null : now(),
            'status' => $isActive ? 'inactive' : 'active'
        ]);

        return response()->json([
            'success' => true,
            'status' => $user->email_verified_at && $user->status === 'active' ? 'active' : 'inactive',
            'message' => 'Status user berhasil diubah!'
        ]);
    }

    /**
     * Show reset password form
     */
    public function showResetPassword(User $user)
    {
        return view('admin.users.reset-password', compact('user'));
    }

    /**
     * Process password reset
     */
    public function processResetPassword(Request $request, User $user)
    {
        $request->validate([
            'reset_type' => 'required|in:default,custom,generate',
            'custom_password' => 'required_if:reset_type,custom|min:8'
        ]);

        $newPassword = '';
        
        switch ($request->reset_type) {
            case 'default':
                $newPassword = 'password123';
                break;
            case 'custom':
                $newPassword = $request->custom_password;
                break;
            case 'generate':
                $newPassword = $this->generateRandomPassword();
                break;
        }
        
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Log the password reset
        \Log::info('Password reset for user', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'reset_by' => auth()->user()->email,
            'reset_type' => $request->reset_type,
            'timestamp' => now()
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Password for {$user->name} has been reset successfully! New password: {$newPassword}");
    }

    /**
     * Generate a random password
     */
    private function generateRandomPassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*';
        $password = '';
        
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
        
        return $password;
    }

    /**
     * Reset user password (Legacy AJAX endpoint)
     */
    public function resetPassword(User $user)
    {
        $newPassword = 'password123'; // Default password
        
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return response()->json([
            'success' => true,
            'message' => "Password user berhasil direset ke: {$newPassword}",
            'new_password' => $newPassword
        ]);
    }
}