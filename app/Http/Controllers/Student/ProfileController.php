<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, UserActivity};
use App\Http\Requests\{UpdateProfileRequest, UpdatePasswordRequest};
use App\Traits\LogsActivity;
use Illuminate\Support\Facades\{Hash, Storage, Auth, Session, DB};
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ProfileController extends Controller
{
    use LogsActivity;

    /**
     * Display the student's profile page.
     */
    public function index()
    {
        $user = auth()->user();
        return view('student.profile.index', compact('user'));
    }

    /**
     * Update the student's profile information.
     */
    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = auth()->user();

        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'bio' => $request->bio,
            ]);

            // Log the activity
            $this->logProfileUpdate(['name', 'email', 'phone', 'bio']);

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update profile: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the student's password.
     */
    public function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        $user = auth()->user();

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect.'
            ], 422);
        }

        try {
            $user->update([
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
            ]);

            // Log the activity
            $this->logPasswordChange();

            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update password: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload and update the student's avatar.
     */
    public function updateAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        try {
            $user = auth()->user();
            
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            
            $user->update([
                'avatar' => $avatarPath
            ]);

            // Log the activity
            $this->logActivity('avatar_update', 'Updated profile avatar', ['avatar_path' => $avatarPath]);

            return response()->json([
                'success' => true,
                'message' => 'Avatar updated successfully!',
                'avatar_url' => Storage::url($avatarPath)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload avatar: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout from all devices except current.
     */
    public function logoutOtherDevices(Request $request): JsonResponse
    {
        try {
            // Get current session ID
            $currentSessionId = Session::getId();
            
            // Delete all other sessions for this user
            $deletedSessions = DB::table('sessions')
                ->where('user_id', auth()->id())
                ->where('id', '!=', $currentSessionId)
                ->delete();

            // Log the activity
            $this->logSecurityActivity('Logged out from all other devices', ['sessions_terminated' => $deletedSessions]);

            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out from all other devices.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout other devices: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get student's recent activity.
     */
    public function getActivity(): JsonResponse
    {
        try {
            $user = auth()->user();
            $userActivities = UserActivity::forUser($user->id, 10);
            
            $activities = $userActivities->map(function ($activity) {
                $icon = match($activity->type) {
                    'login' => 'fas fa-sign-in-alt',
                    'logout' => 'fas fa-sign-out-alt',
                    'profile_update' => 'fas fa-edit',
                    'password_change' => 'fas fa-key',
                    'avatar_update' => 'fas fa-camera',
                    'security' => 'fas fa-shield-alt',
                    'assignment' => 'fas fa-tasks',
                    'quiz' => 'fas fa-question-circle',
                    'attendance' => 'fas fa-calendar-check',
                    'material' => 'fas fa-book',
                    default => 'fas fa-info-circle'
                };
                
                return [
                    'type' => $activity->type,
                    'description' => $activity->description,
                    'timestamp' => $activity->created_at->format('M d, Y \\a\\t H:i'),
                    'icon' => $icon,
                    'ip_address' => $activity->ip_address,
                    'properties' => $activity->properties
                ];
            });

            return response()->json([
                'success' => true,
                'activities' => $activities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load activity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get student's security settings.
     */
    public function getSecuritySettings(): JsonResponse
    {
        try {
            $user = auth()->user();
            
            $settings = [
                'two_factor_enabled' => false, // Placeholder
                'login_notifications' => true, // Placeholder
                'password_last_changed' => $user->password_changed_at ? 
                    Carbon::parse($user->password_changed_at)->diffForHumans() : 'Never',
                'active_sessions' => 1, // Placeholder
            ];

            return response()->json([
                'success' => true,
                'settings' => $settings
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load security settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download student data (GDPR compliance).
     */
    public function downloadData(): JsonResponse
    {
        try {
            $user = auth()->user();
            
            $userData = [
                'personal_information' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'bio' => $user->bio,
                    'created_at' => $user->created_at,
                    'updated_at' => $user->updated_at,
                ],
                'account_information' => [
                    'last_login' => $user->last_login_at,
                    'email_verified' => $user->email_verified_at ? true : false,
                    'status' => $user->status ?? 'active',
                    'role' => 'student',
                ],
                'academic_data' => [
                    'student_id' => $user->nis ?? null,
                    'class' => $user->class ?? null,
                    'enrollment_date' => $user->enrollment_date ?? null,
                ],
                'export_date' => now()->toISOString(),
            ];

            return response()->json([
                'success' => true,
                'data' => $userData,
                'message' => 'User data exported successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to export user data: ' . $e->getMessage()
            ], 500);
        }
    }
}