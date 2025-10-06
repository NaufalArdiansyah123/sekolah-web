<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class VisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Vision::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('vision_text', 'LIKE', "%{$search}%")
                  ->orWhere('hero_title', 'LIKE', "%{$search}%");
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
        
        $visions = $query->latest()->paginate(10);
        $activeVision = Vision::getActiveVision();
        
        return view('admin.vision.index', compact('visions', 'activeVision'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.vision.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'vision_text' => 'required|string',
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'mission_items_json' => 'nullable|string',
                'goals_json' => 'nullable|string',
                'values_json' => 'nullable|string',
                'focus_areas_json' => 'nullable|string',
                'roadmap_phases_json' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $data = $request->except(['hero_image', 'mission_items_json', 'goals_json', 'values_json', 'focus_areas_json', 'roadmap_phases_json']);
            
            // Handle file upload
            if ($request->hasFile('hero_image')) {
                $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'vision/heroes');
            }
            
            // Process JSON fields from form
            $data['mission_items'] = $this->parseJsonField($request->input('mission_items_json', '[]'));
            $data['goals'] = $this->parseJsonField($request->input('goals_json', '[]'));
            $data['values'] = $this->parseJsonField($request->input('values_json', '[]'));
            $data['focus_areas'] = $this->parseJsonField($request->input('focus_areas_json', '[]'));
            $data['roadmap_phases'] = $this->parseJsonField($request->input('roadmap_phases_json', '[]'));
            
            // Set creator
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();
            
            $vision = Vision::create($data);
            
            // If this vision is set as active, deactivate others
            if ($request->boolean('is_active')) {
                $vision->activate();
                NotificationService::created('Visi & Misi', $vision->title, [
                    'status' => 'Aktif',
                    'mission_count' => count($vision->mission_items ?? []),
                    'goals_count' => count($vision->goals ?? []),
                    'has_hero_image' => !empty($vision->hero_image)
                ]);
            } else {
                NotificationService::created('Visi & Misi', $vision->title, [
                    'status' => 'Tidak Aktif',
                    'mission_count' => count($vision->mission_items ?? []),
                    'goals_count' => count($vision->goals ?? []),
                    'has_hero_image' => !empty($vision->hero_image)
                ]);
            }
            
            return redirect()->route('admin.vision.index')
                           ->with('success', 'Visi & Misi berhasil dibuat!');
            
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Gagal Membuat Visi & Misi', 'Terjadi kesalahan saat membuat visi & misi: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vision $vision)
    {
        return view('admin.vision.show', compact('vision'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vision $vision)
    {
        return view('admin.vision.edit', compact('vision'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vision $vision)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'vision_text' => 'required|string',
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'mission_items_json' => 'nullable|string',
                'goals_json' => 'nullable|string',
                'values_json' => 'nullable|string',
                'focus_areas_json' => 'nullable|string',
                'roadmap_phases_json' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $data = $request->except(['hero_image', 'mission_items_json', 'goals_json', 'values_json', 'focus_areas_json', 'roadmap_phases_json']);
            
            // Handle file upload
            if ($request->hasFile('hero_image')) {
                // Delete old hero image
                if ($vision->hero_image) {
                    $this->deleteFile($vision->hero_image);
                }
                $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'vision/heroes');
            }
            
            // Process JSON fields from form
            $data['mission_items'] = $this->parseJsonField($request->input('mission_items_json', '[]'));
            $data['goals'] = $this->parseJsonField($request->input('goals_json', '[]'));
            $data['values'] = $this->parseJsonField($request->input('values_json', '[]'));
            $data['focus_areas'] = $this->parseJsonField($request->input('focus_areas_json', '[]'));
            $data['roadmap_phases'] = $this->parseJsonField($request->input('roadmap_phases_json', '[]'));
            
            // Set updater
            $data['updated_by'] = auth()->id();
            
            // Track changes for notification
            $changes = [];
            if ($vision->title !== $data['title']) {
                $changes['title'] = ['from' => $vision->title, 'to' => $data['title']];
            }
            if ($request->hasFile('hero_image')) {
                $changes['hero_image'] = 'Updated';
            }
            if ($vision->mission_items !== $data['mission_items']) {
                $changes['mission_items'] = ['count' => count($data['mission_items'])];
            }
            if ($vision->goals !== $data['goals']) {
                $changes['goals'] = ['count' => count($data['goals'])];
            }
            
            $vision->updateVision($data);
            
            NotificationService::updated('Visi & Misi', $vision->title, $changes);
            
            return redirect()->route('admin.vision.index')
                           ->with('success', 'Visi & Misi berhasil diperbarui!');
            
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Gagal Memperbarui Visi & Misi', 'Terjadi kesalahan saat memperbarui visi & misi: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vision $vision)
    {
        try {
            $visionTitle = $vision->title;
            $wasActive = $vision->is_active;
            
            // Count associated data for notification
            $deletedData = [];
            if ($vision->hero_image) {
                $this->deleteFile($vision->hero_image);
                $deletedData[] = 'Hero Image';
            }
            
            $vision->delete();
            
            NotificationService::deleted('Visi & Misi', $visionTitle, [
                'was_active' => $wasActive,
                'deleted_data' => $deletedData,
                'mission_count' => count($vision->mission_items ?? []),
                'goals_count' => count($vision->goals ?? [])
            ]);
            
            return redirect()->route('admin.vision.index')
                           ->with('success', 'Visi & Misi berhasil dihapus!');
            
        } catch (\Exception $e) {
            NotificationService::error('Gagal Menghapus Visi & Misi', 'Terjadi kesalahan saat menghapus visi & misi: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Activate a vision
     */
    public function activate(Vision $vision)
    {
        $vision->activate();
        
        NotificationService::activated('Visi & Misi', $vision->title);
        
        return response()->json([
            'success' => true,
            'message' => 'Visi & Misi berhasil diaktifkan!',
            'notification' => session('notification')
        ]);
    }

    /**
     * Deactivate a vision
     */
    public function deactivate(Vision $vision)
    {
        $vision->update(['is_active' => false]);
        
        NotificationService::deactivated('Visi & Misi', $vision->title);
        
        return response()->json([
            'success' => true,
            'message' => 'Visi & Misi berhasil dinonaktifkan!',
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
}