<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AchievementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Achievement::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }
        
        // Filter by level
        if ($request->filled('level')) {
            $query->byLevel($request->level);
        }
        
        // Filter by year
        if ($request->filled('year')) {
            $query->byYear($request->year);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        if (in_array($sortBy, ['title', 'category', 'level', 'year', 'achievement_date', 'created_at', 'sort_order'])) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }
        
        $achievements = $query->paginate(12);
        
        // Get filter options
        $categories = Achievement::getCategoryOptions();
        $levels = Achievement::getLevelOptions();
        $years = Achievement::getAvailableYears();
        
        // Get statistics
        $statistics = Achievement::getStatistics();
        
        return view('admin.achievements.index', compact(
            'achievements', 
            'categories', 
            'levels', 
            'years', 
            'statistics'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Achievement::getCategoryOptions();
        $levels = Achievement::getLevelOptions();
        $positions = Achievement::getPositionOptions();
        
        return view('admin.achievements.create', compact('categories', 'levels', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string|in:' . implode(',', array_keys(Achievement::getCategoryOptions())),
                'level' => 'required|string|in:' . implode(',', array_keys(Achievement::getLevelOptions())),
                'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
                'achievement_date' => 'nullable|date',
                'organizer' => 'nullable|string|max:255',
                'participant' => 'nullable|string|max:255',
                'position' => 'nullable|string|in:' . implode(',', array_keys(Achievement::getPositionOptions())),
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'additional_info' => 'nullable|string',
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            $data = $request->except(['image']);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadFile($request->file('image'), 'achievements');
            }
            
            // Set default values
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = $request->input('sort_order', 0);
            
            // Set year from achievement_date if not provided
            if (!$data['year'] && $data['achievement_date']) {
                $data['year'] = date('Y', strtotime($data['achievement_date']));
            }
            
            $achievement = Achievement::create($data);
            
            NotificationService::created('Achievement', $achievement->title, [
                'category' => $achievement->category_formatted,
                'level' => $achievement->level_formatted,
                'is_featured' => $achievement->is_featured,
                'has_image' => !empty($achievement->image)
            ]);
            
            return redirect()->route('admin.achievements.index')
                           ->with('success', 'Achievement created successfully!');
            
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Failed to Create Achievement', 'An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Achievement $achievement)
    {
        return view('admin.achievements.show', compact('achievement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Achievement $achievement)
    {
        $categories = Achievement::getCategoryOptions();
        $levels = Achievement::getLevelOptions();
        $positions = Achievement::getPositionOptions();
        
        return view('admin.achievements.edit', compact('achievement', 'categories', 'levels', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Achievement $achievement)
    {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'category' => 'required|string|in:' . implode(',', array_keys(Achievement::getCategoryOptions())),
                'level' => 'required|string|in:' . implode(',', array_keys(Achievement::getLevelOptions())),
                'year' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
                'achievement_date' => 'nullable|date',
                'organizer' => 'nullable|string|max:255',
                'participant' => 'nullable|string|max:255',
                'position' => 'nullable|string|in:' . implode(',', array_keys(Achievement::getPositionOptions())),
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'additional_info' => 'nullable|string',
                'is_featured' => 'boolean',
                'is_active' => 'boolean',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'sort_order' => 'nullable|integer|min:0'
            ]);

            $data = $request->except(['image']);
            
            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image
                if ($achievement->image) {
                    $this->deleteFile($achievement->image);
                }
                $data['image'] = $this->uploadFile($request->file('image'), 'achievements');
            }
            
            // Set boolean values
            $data['is_featured'] = $request->boolean('is_featured');
            $data['is_active'] = $request->boolean('is_active', true);
            $data['sort_order'] = $request->input('sort_order', 0);
            
            // Set year from achievement_date if not provided
            if (!$data['year'] && $data['achievement_date']) {
                $data['year'] = date('Y', strtotime($data['achievement_date']));
            }
            
            // Track changes for notification
            $changes = [];
            if ($achievement->title !== $data['title']) {
                $changes['title'] = ['from' => $achievement->title, 'to' => $data['title']];
            }
            if ($achievement->category !== $data['category']) {
                $changes['category'] = ['from' => $achievement->category_formatted, 'to' => Achievement::getCategoryOptions()[$data['category']]];
            }
            if ($request->hasFile('image')) {
                $changes['image'] = 'Updated';
            }
            
            $achievement->update($data);
            
            NotificationService::updated('Achievement', $achievement->title, $changes);
            
            return redirect()->route('admin.achievements.index')
                           ->with('success', 'Achievement updated successfully!');
            
        } catch (ValidationException $e) {
            NotificationService::validationError($e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            NotificationService::error('Failed to Update Achievement', 'An error occurred: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Achievement $achievement)
    {
        try {
            $title = $achievement->title;
            $category = $achievement->category_formatted;
            
            // Delete image file
            if ($achievement->image) {
                $this->deleteFile($achievement->image);
            }
            
            $achievement->delete();
            
            NotificationService::deleted('Achievement', $title, [
                'category' => $category,
                'had_image' => !empty($achievement->image)
            ]);
            
            return redirect()->route('admin.achievements.index')
                           ->with('success', 'Achievement deleted successfully!');
            
        } catch (\Exception $e) {
            NotificationService::error('Failed to Delete Achievement', 'An error occurred: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Achievement $achievement)
    {
        $achievement->update(['is_featured' => !$achievement->is_featured]);
        
        $status = $achievement->is_featured ? 'featured' : 'unfeatured';
        NotificationService::success(
            'Achievement ' . ucfirst($status), 
            $achievement->title . ' has been ' . $status . ' successfully!'
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Achievement ' . $status . ' successfully!',
            'is_featured' => $achievement->is_featured
        ]);
    }

    /**
     * Toggle active status
     */
    public function toggleStatus(Achievement $achievement)
    {
        $achievement->update(['is_active' => !$achievement->is_active]);
        
        $status = $achievement->is_active ? 'activated' : 'deactivated';
        NotificationService::success(
            'Achievement ' . ucfirst($status), 
            $achievement->title . ' has been ' . $status . ' successfully!'
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Achievement ' . $status . ' successfully!',
            'is_active' => $achievement->is_active
        ]);
    }

    /**
     * Bulk action handler
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,feature,unfeature,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:achievements,id'
        ]);

        $achievements = Achievement::whereIn('id', $request->ids)->get();
        $count = $achievements->count();

        try {
            switch ($request->action) {
                case 'activate':
                    Achievement::whereIn('id', $request->ids)->update(['is_active' => true]);
                    $message = "{$count} achievements activated successfully!";
                    break;
                    
                case 'deactivate':
                    Achievement::whereIn('id', $request->ids)->update(['is_active' => false]);
                    $message = "{$count} achievements deactivated successfully!";
                    break;
                    
                case 'feature':
                    Achievement::whereIn('id', $request->ids)->update(['is_featured' => true]);
                    $message = "{$count} achievements featured successfully!";
                    break;
                    
                case 'unfeature':
                    Achievement::whereIn('id', $request->ids)->update(['is_featured' => false]);
                    $message = "{$count} achievements unfeatured successfully!";
                    break;
                    
                case 'delete':
                    // Delete associated images
                    foreach ($achievements as $achievement) {
                        if ($achievement->image) {
                            $this->deleteFile($achievement->image);
                        }
                    }
                    Achievement::whereIn('id', $request->ids)->delete();
                    $message = "{$count} achievements deleted successfully!";
                    break;
            }

            NotificationService::success('Bulk Action Completed', $message);
            
            return response()->json([
                'success' => true,
                'message' => $message
            ]);
            
        } catch (\Exception $e) {
            NotificationService::error('Bulk Action Failed', 'An error occurred: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Bulk action failed: ' . $e->getMessage()
            ], 500);
        }
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
}