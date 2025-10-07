<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class SchoolProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SchoolProfile::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('school_name', 'LIKE', "%{$search}%")
                  ->orWhere('principal_name', 'LIKE', "%{$search}%")
                  ->orWhere('about_description', 'LIKE', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $profiles = $query->latest()->paginate(10);
        $activeProfile = SchoolProfile::getActiveProfile();
        
        return view('admin.school-profile.index', compact('profiles', 'activeProfile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.school-profile.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
            'school_name' => 'required|string|max:255',
            'school_motto' => 'nullable|string|max:500',
            'about_description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'history' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'accreditation' => 'nullable|string|max:10',
            'principal_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'student_count' => 'nullable|integer|min:0',
            'teacher_count' => 'nullable|integer|min:0',
            'staff_count' => 'nullable|integer|min:0',
            'industry_partnerships' => 'nullable|integer|min:0',

            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'facilities_json' => 'nullable|string',
            'achievements_json' => 'nullable|string',
            'programs_json' => 'nullable|string',
            'history_json' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->except(['principal_photo', 'hero_image', 'gallery_images', 'facilities_json', 'achievements_json', 'programs_json', 'history_json']);
        
        // Handle file uploads
        
        if ($request->hasFile('principal_photo')) {
            $data['principal_photo'] = $this->uploadFile($request->file('principal_photo'), 'school-profile/principals');
        }
        
        if ($request->hasFile('hero_image')) {
            $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'school-profile/heroes');
        }
        
        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $galleryImages[] = $this->uploadFile($file, 'school-profile/gallery');
            }
            $data['gallery_images'] = $galleryImages;
        }
        
        // Process JSON fields from form
        $data['facilities'] = $this->parseJsonField($request->input('facilities_json', '[]'));
        $data['achievements'] = $this->parseJsonField($request->input('achievements_json', '[]'));
        $data['programs'] = $this->parseJsonField($request->input('programs_json', '[]'));
        
        // Handle history data - store in history field as JSON
        $historyData = $this->parseJsonField($request->input('history_json', '[]'));
        if (!empty($historyData)) {
            $data['history'] = json_encode($historyData);
        }
        
        // Set default values for other JSON fields
        $data['vice_principals'] = [];
        $data['social_media'] = [];
        $data['contact_info'] = [];
        
        $profile = SchoolProfile::create($data);
        
        // If this profile is set as active, deactivate others
        if ($request->boolean('is_active')) {
            $profile->activate();
            NotificationService::created('Profil Sekolah', $profile->school_name, [
                'status' => 'Aktif',
                'facilities_count' => count($profile->facilities ?? []),
                'has_hero_image' => !empty($profile->hero_image)
            ]);
        } else {
            NotificationService::created('Profil Sekolah', $profile->school_name, [
                'status' => 'Tidak Aktif',
                'facilities_count' => count($profile->facilities ?? []),
                'has_hero_image' => !empty($profile->hero_image)
            ]);
        }
        
        return redirect()->route('admin.school-profile.index');
        
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Gagal Membuat Profil', 'Terjadi kesalahan saat membuat profil sekolah: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profile.show', compact('schoolProfile'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SchoolProfile $schoolProfile)
    {
        return view('admin.school-profile.edit', compact('schoolProfile'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolProfile $schoolProfile)
    {
        try {
            $request->validate([
            'school_name' => 'required|string|max:255',
            'school_motto' => 'nullable|string|max:500',
            'about_description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'history' => 'nullable|string',
            'established_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'accreditation' => 'nullable|string|max:10',
            'principal_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'student_count' => 'nullable|integer|min:0',
            'teacher_count' => 'nullable|integer|min:0',
            'staff_count' => 'nullable|integer|min:0',
            'industry_partnerships' => 'nullable|integer|min:0',

            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
            'facilities_json' => 'nullable|string',
            'achievements_json' => 'nullable|string',
            'programs_json' => 'nullable|string',
            'history_json' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $data = $request->except(['principal_photo', 'hero_image', 'gallery_images', 'facilities_json', 'achievements_json', 'programs_json', 'history_json']);
        
        // Handle file uploads
        
        if ($request->hasFile('principal_photo')) {
            // Delete old photo
            if ($schoolProfile->principal_photo) {
                $this->deleteFile($schoolProfile->principal_photo);
            }
            $data['principal_photo'] = $this->uploadFile($request->file('principal_photo'), 'school-profile/principals');
        }
        
        if ($request->hasFile('hero_image')) {
            // Delete old hero image
            if ($schoolProfile->hero_image) {
                $this->deleteFile($schoolProfile->hero_image);
            }
            $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'school-profile/heroes');
        }
        
        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            // Delete old gallery images
            if ($schoolProfile->gallery_images) {
                foreach ($schoolProfile->gallery_images as $image) {
                    $this->deleteFile($image);
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery_images') as $file) {
                $galleryImages[] = $this->uploadFile($file, 'school-profile/gallery');
            }
            $data['gallery_images'] = $galleryImages;
        }
        
        // Process JSON fields from form
        $data['facilities'] = $this->parseJsonField($request->input('facilities_json', '[]'));
        $data['achievements'] = $this->parseJsonField($request->input('achievements_json', '[]'));
        $data['programs'] = $this->parseJsonField($request->input('programs_json', '[]'));
        
        // Handle history data - store in history field as JSON
        $historyData = $this->parseJsonField($request->input('history_json', '[]'));
        if (!empty($historyData)) {
            $data['history'] = json_encode($historyData);
        }
        
        // Set default values for other JSON fields
        $data['vice_principals'] = [];
        $data['social_media'] = [];
        $data['contact_info'] = [];
        
        // Track changes for notification
        $changes = [];
        if ($schoolProfile->school_name !== $data['school_name']) {
            $changes['school_name'] = ['from' => $schoolProfile->school_name, 'to' => $data['school_name']];
        }

        if ($request->hasFile('principal_photo')) {
            $changes['principal_photo'] = 'Updated';
        }
        if ($request->hasFile('hero_image')) {
            $changes['hero_image'] = 'Updated';
        }
        if ($schoolProfile->facilities !== $data['facilities']) {
            $changes['facilities'] = ['count' => count($data['facilities'])];
        }
        
        $schoolProfile->updateProfile($data);
        
        NotificationService::updated('Profil Sekolah', $schoolProfile->school_name, $changes);
        
        return redirect()->route('admin.school-profile.index');
        
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Gagal Memperbarui Profil', 'Terjadi kesalahan saat memperbarui profil sekolah: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SchoolProfile $schoolProfile)
    {
        try {
            $schoolName = $schoolProfile->school_name;
            $wasActive = $schoolProfile->is_active;
        
        // Count associated files for notification
        $deletedFiles = [];
        
        if ($schoolProfile->principal_photo) {
            $this->deleteFile($schoolProfile->principal_photo);
            $deletedFiles[] = 'Foto Kepala Sekolah';
        }
        
        if ($schoolProfile->hero_image) {
            $this->deleteFile($schoolProfile->hero_image);
            $deletedFiles[] = 'Gambar Hero';
        }
        
        if ($schoolProfile->gallery_images) {
            foreach ($schoolProfile->gallery_images as $image) {
                $this->deleteFile($image);
            }
            $deletedFiles[] = count($schoolProfile->gallery_images) . ' Gambar Galeri';
        }
        
        $schoolProfile->delete();
        
        NotificationService::deleted('Profil Sekolah', $schoolName, [
            'was_active' => $wasActive,
            'deleted_files' => $deletedFiles,
            'facilities_count' => count($schoolProfile->facilities ?? [])
        ]);
        
        return redirect()->route('admin.school-profile.index');
        
        } catch (\Exception $e) {
            NotificationService::error('Gagal Menghapus Profil', 'Terjadi kesalahan saat menghapus profil sekolah: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Activate a school profile
     */
    public function activate(SchoolProfile $schoolProfile)
    {
        $schoolProfile->activate();
        
        NotificationService::activated('Profil Sekolah', $schoolProfile->school_name);
        
        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil diaktifkan!',
            'notification' => session('notification')
        ]);
    }

    /**
     * Deactivate a school profile
     */
    public function deactivate(SchoolProfile $schoolProfile)
    {
        $schoolProfile->update(['is_active' => false]);
        
        NotificationService::deactivated('Profil Sekolah', $schoolProfile->school_name);
        
        return response()->json([
            'success' => true,
            'message' => 'Profil sekolah berhasil dinonaktifkan!',
            'notification' => session('notification')
        ]);
    }

    /**
     * Upload file helper
     */
    private function uploadFile($file, $directory)
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        return 'storage/' . $path;
    }

    /**
     * Delete file helper
     */
    private function deleteFile($filePath)
    {
        if ($filePath && str_starts_with($filePath, 'storage/')) {
            $path = str_replace('storage/', '', $filePath);
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Parse JSON field helper
     */
    private function parseJsonField($jsonString)
    {
        try {
            $decoded = json_decode($jsonString, true);
            return is_array($decoded) ? $decoded : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Parse social media from request
     */
    private function parseSocialMedia(Request $request)
    {
        return [
            'facebook' => $request->input('facebook'),
            'instagram' => $request->input('instagram'),
            'twitter' => $request->input('twitter'),
            'youtube' => $request->input('youtube'),
            'linkedin' => $request->input('linkedin'),
            'tiktok' => $request->input('tiktok'),
            'whatsapp' => $request->input('whatsapp')
        ];
    }

    /**
     * Parse contact info from request
     */
    private function parseContactInfo(Request $request)
    {
        return [
            'fax' => $request->input('fax'),
            'postal_code' => $request->input('postal_code'),
            'office_hours' => $request->input('office_hours'),
            'emergency_contact' => $request->input('emergency_contact')
        ];
    }
}