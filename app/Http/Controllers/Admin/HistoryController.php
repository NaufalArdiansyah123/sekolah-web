<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = History::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('content', 'LIKE', "%{$search}%")
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
        
        $histories = $query->latest()->paginate(10);
        $activeHistory = History::getActiveHistory();
        
        return view('admin.history.index', compact('histories', 'activeHistory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.history.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'timeline_events_json' => 'nullable|string',
                'milestones_json' => 'nullable|string',
                'achievements_json' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $data = $request->except(['hero_image', 'timeline_events_json', 'milestones_json', 'achievements_json']);
            
            // Handle file upload
            if ($request->hasFile('hero_image')) {
                $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'history/heroes');
            }
            
            // Process JSON fields from form
            $data['timeline_events'] = $this->parseJsonField($request->input('timeline_events_json', '[]'));
            $data['milestones'] = $this->parseJsonField($request->input('milestones_json', '[]'));
            $data['achievements'] = $this->parseJsonField($request->input('achievements_json', '[]'));
            
            // Set creator
            $data['created_by'] = auth()->id();
            $data['updated_by'] = auth()->id();
            
            $history = History::create($data);
            
            // If this history is set as active, deactivate others
            if ($request->boolean('is_active')) {
                $history->activate();
                NotificationService::created('Sejarah Sekolah', $history->title, [
                    'status' => 'Aktif',
                    'timeline_count' => count($history->timeline_events ?? []),
                    'milestones_count' => count($history->milestones ?? []),
                    'achievements_count' => count($history->achievements ?? []),
                    'has_hero_image' => !empty($history->hero_image)
                ]);
            } else {
                NotificationService::created('Sejarah Sekolah', $history->title, [
                    'status' => 'Tidak Aktif',
                    'timeline_count' => count($history->timeline_events ?? []),
                    'milestones_count' => count($history->milestones ?? []),
                    'achievements_count' => count($history->achievements ?? []),
                    'has_hero_image' => !empty($history->hero_image)
                ]);
            }
            
            return redirect()->route('admin.history.index')
                           ->with('success', 'Sejarah Sekolah berhasil dibuat!');
            
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Gagal Membuat Sejarah Sekolah', 'Terjadi kesalahan saat membuat sejarah sekolah: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        return view('admin.history.show', compact('history'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        return view('admin.history.edit', compact('history'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'hero_title' => 'nullable|string|max:255',
                'hero_subtitle' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                'timeline_events_json' => 'nullable|string',
                'milestones_json' => 'nullable|string',
                'achievements_json' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            $data = $request->except(['hero_image', 'timeline_events_json', 'milestones_json', 'achievements_json']);
            
            // Handle file upload
            if ($request->hasFile('hero_image')) {
                // Delete old hero image
                if ($history->hero_image) {
                    $this->deleteFile($history->hero_image);
                }
                $data['hero_image'] = $this->uploadFile($request->file('hero_image'), 'history/heroes');
            }
            
            // Process JSON fields from form
            $data['timeline_events'] = $this->parseJsonField($request->input('timeline_events_json', '[]'));
            $data['milestones'] = $this->parseJsonField($request->input('milestones_json', '[]'));
            $data['achievements'] = $this->parseJsonField($request->input('achievements_json', '[]'));
            
            // Set updater
            $data['updated_by'] = auth()->id();
            
            // Track changes for notification
            $changes = [];
            if ($history->title !== $data['title']) {
                $changes['title'] = ['from' => $history->title, 'to' => $data['title']];
            }
            if ($request->hasFile('hero_image')) {
                $changes['hero_image'] = 'Updated';
            }
            if ($history->timeline_events !== $data['timeline_events']) {
                $changes['timeline_events'] = ['count' => count($data['timeline_events'])];
            }
            if ($history->milestones !== $data['milestones']) {
                $changes['milestones'] = ['count' => count($data['milestones'])];
            }
            if ($history->achievements !== $data['achievements']) {
                $changes['achievements'] = ['count' => count($data['achievements'])];
            }
            
            $history->updateHistory($data);
            
            NotificationService::updated('Sejarah Sekolah', $history->title, $changes);
            
            return redirect()->route('admin.history.index')
                           ->with('success', 'Sejarah Sekolah berhasil diperbarui!');
            
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Gagal Memperbarui Sejarah Sekolah', 'Terjadi kesalahan saat memperbarui sejarah sekolah: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        try {
            $historyTitle = $history->title;
            $wasActive = $history->is_active;
            
            // Count associated data for notification
            $deletedData = [];
            if ($history->hero_image) {
                $this->deleteFile($history->hero_image);
                $deletedData[] = 'Hero Image';
            }
            
            $history->delete();
            
            NotificationService::deleted('Sejarah Sekolah', $historyTitle, [
                'was_active' => $wasActive,
                'deleted_data' => $deletedData,
                'timeline_count' => count($history->timeline_events ?? []),
                'milestones_count' => count($history->milestones ?? []),
                'achievements_count' => count($history->achievements ?? [])
            ]);
            
            return redirect()->route('admin.history.index')
                           ->with('success', 'Sejarah Sekolah berhasil dihapus!');
            
        } catch (\Exception $e) {
            NotificationService::error('Gagal Menghapus Sejarah Sekolah', 'Terjadi kesalahan saat menghapus sejarah sekolah: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Activate a history
     */
    public function activate(History $history)
    {
        $history->activate();
        
        NotificationService::activated('Sejarah Sekolah', $history->title);
        
        return response()->json([
            'success' => true,
            'message' => 'Sejarah Sekolah berhasil diaktifkan!',
            'notification' => session('notification')
        ]);
    }

    /**
     * Deactivate a history
     */
    public function deactivate(History $history)
    {
        $history->update(['is_active' => false]);
        
        NotificationService::deactivated('Sejarah Sekolah', $history->title);
        
        return response()->json([
            'success' => true,
            'message' => 'Sejarah Sekolah berhasil dinonaktifkan!',
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