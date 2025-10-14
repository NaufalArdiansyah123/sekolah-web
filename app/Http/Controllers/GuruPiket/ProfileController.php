<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:guru_piket');
    }

    /**
     * Show profile page
     */
    public function index()
    {
        $pageTitle = 'Profil Saya';
        $breadcrumb = 'Profil';
        
        $user = Auth::user();
        
        // Get user statistics
        $statistics = [
            'days_on_duty' => 156,
            'students_monitored' => 2847,
            'qr_scanned' => 1234,
            'reports_created' => 89
        ];
        
        // Get recent activities
        $recentActivities = [
            [
                'type' => 'qr_scan',
                'description' => 'Scan QR Code Siswa',
                'details' => 'Ahmad Fauzi (XII IPA 1) berhasil diabsen',
                'time' => '2 menit yang lalu',
                'icon' => 'check',
                'color' => 'green'
            ],
            [
                'type' => 'export',
                'description' => 'Export Laporan Harian',
                'details' => 'Laporan tanggal 28 November 2024 (PDF)',
                'time' => '15 menit yang lalu',
                'icon' => 'download',
                'color' => 'blue'
            ],
            [
                'type' => 'update',
                'description' => 'Update Status Absensi',
                'details' => 'Mengubah status Dewi Permata dari Alpha ke Izin',
                'time' => '1 jam yang lalu',
                'icon' => 'edit',
                'color' => 'yellow'
            ],
            [
                'type' => 'login',
                'description' => 'Login ke Sistem',
                'details' => 'Memulai shift piket hari ini',
                'time' => '3 jam yang lalu',
                'icon' => 'calendar',
                'color' => 'purple'
            ]
        ];
        
        return view('guru-piket.profile', compact(
            'pageTitle',
            'breadcrumb',
            'user',
            'statistics',
            'recentActivities'
        ));
    }

    /**
     * Update profile information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'nip' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string|max:1000'
        ]);

        $user = Auth::user();
        $user->update($request->only([
            'name', 'email', 'nip', 'phone', 'birth_date', 
            'gender', 'address', 'bio'
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui'
        ]);
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password saat ini tidak sesuai'
            ], 422);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui'
        ]);
    }

    /**
     * Update avatar
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            // Store new avatar
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $avatarName);

            $user->update(['avatar' => $avatarName]);

            return response()->json([
                'success' => true,
                'message' => 'Avatar berhasil diperbarui',
                'avatar_url' => Storage::url('avatars/' . $avatarName)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mengupload avatar'
        ], 422);
    }
}