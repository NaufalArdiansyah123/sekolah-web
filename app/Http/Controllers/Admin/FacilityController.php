<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    /**
     * Display enhanced listing of facilities
     */
    public function indexEnhanced(Request $request)
    {
        $query = Facility::query();

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Handle sort_order column safely
        if ($sortBy === 'sort_order') {
            try {
                $query->orderBy('sort_order', 'asc');
            } catch (\Exception $e) {
                $query->orderBy('created_at', 'desc');
            }
        } else {
            $query->orderBy($sortBy, $sortOrder);
        }

        $facilities = $query->paginate(12)->withQueryString();

        $categories = Facility::getCategories();
        $statuses = Facility::getStatuses();

        return view('admin.facilities.index-enhanced', compact('facilities', 'categories', 'statuses'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Facility::query();

        // Filter berdasarkan kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'sort_order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $facilities = $query->paginate(10)->withQueryString();

        $categories = Facility::getCategories();
        $statuses = Facility::getStatuses();

        return view('admin.facilities.index', compact('facilities', 'categories', 'statuses'));
    }

    /**
     * Show enhanced form for creating a new resource.
     */
    public function createEnhanced()
    {
        $categories = Facility::getCategories();
        $statuses = Facility::getStatuses();

        return view('admin.facilities.create-enhanced', compact('categories', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Facility::getCategories();
        $statuses = Facility::getStatuses();

        return view('admin.facilities.create', compact('categories', 'statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:academic,sport,technology,arts,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|string|in:active,maintenance,inactive',
        ]);
        
        // Remove fields that might not exist in database
        $optionalFields = ['features', 'capacity', 'location', 'is_featured', 'sort_order'];
        foreach ($optionalFields as $field) {
            if ($request->has($field)) {
                $validated[$field] = $request->input($field);
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/facilities', $imageName);
            $validated['image'] = $imageName;
        }

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features'], function($feature) {
                return !empty(trim($feature));
            });
        }

        // Set default sort order if not provided (with error handling)
        if (!isset($validated['sort_order'])) {
            try {
                // Try to get max sort_order, fallback if column doesn't exist
                $maxSortOrder = Facility::max('sort_order');
                $validated['sort_order'] = ($maxSortOrder ?? 0) + 1;
            } catch (\Exception $e) {
                // If sort_order column doesn't exist, don't include it
                // This prevents the error when the column is not in the database
                unset($validated['sort_order']);
            }
        }

        // Ensure status is set to active if not provided (for public visibility)
        if (!isset($validated['status']) || empty($validated['status'])) {
            $validated['status'] = 'active';
        }
        
        // Validate status value to prevent data truncation
        $allowedStatuses = ['active', 'maintenance', 'inactive'];
        if (!in_array($validated['status'], $allowedStatuses)) {
            $validated['status'] = 'active'; // Default to active if invalid
        }

        // Debug: Log the data being inserted
        \Log::info('Creating facility with data:', $validated);
        
        try {
            $facility = Facility::create($validated);
            \Log::info('Facility created successfully with ID: ' . $facility->id);
        } catch (\Exception $e) {
            \Log::error('Failed to create facility: ' . $e->getMessage());
            \Log::error('Data that failed: ', $validated);
            
            // Check if it's a data truncation error
            if (str_contains($e->getMessage(), 'Data truncated') || str_contains($e->getMessage(), '1265')) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors([
                        'status' => 'Database error: Status column needs to be fixed. Please contact administrator.'
                    ])
                    ->with('error', 'Database configuration issue detected. The status column needs to be repaired.');
            }
            
            // Re-throw other exceptions
            throw $e;
        }

        // Handle different actions
        $action = $request->input('action', 'save');
        
        if ($action === 'save_and_new') {
            return redirect()->route('admin.facilities.create')
                ->with('success', 'Fasilitas berhasil ditambahkan. Silakan tambah fasilitas baru.');
        }

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil ditambahkan dan akan muncul di halaman fasilitas publik.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Facility $facility)
    {
        return view('admin.facilities.show', compact('facility'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        $categories = Facility::getCategories();
        $statuses = Facility::getStatuses();

        return view('admin.facilities.edit', compact('facility', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|in:academic,sport,technology,arts,other',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|string|in:active,maintenance,inactive',
        ]);
        
        // Add optional fields that might not exist in database
        $optionalFields = ['features', 'capacity', 'location', 'is_featured', 'sort_order'];
        foreach ($optionalFields as $field) {
            if ($request->has($field)) {
                $validated[$field] = $request->input($field);
            }
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($facility->image) {
                Storage::delete('public/facilities/' . $facility->image);
            }

            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/facilities', $imageName);
            $validated['image'] = $imageName;
        }

        // Filter empty features
        if (isset($validated['features'])) {
            $validated['features'] = array_filter($validated['features'], function($feature) {
                return !empty(trim($feature));
            });
        }

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        // Delete image file
        if ($facility->image) {
            Storage::delete('public/facilities/' . $facility->image);
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }

    /**
     * Toggle facility status
     */
    public function toggleStatus(Facility $facility)
    {
        $newStatus = $facility->status === 'active' ? 'inactive' : 'active';
        $facility->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'message' => 'Status fasilitas berhasil diubah.',
            'status' => $newStatus
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Facility $facility)
    {
        $facility->update(['is_featured' => !$facility->is_featured]);

        return response()->json([
            'success' => true,
            'message' => 'Status unggulan berhasil diubah.',
            'is_featured' => $facility->is_featured
        ]);
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,activate,deactivate,feature,unfeature',
            'ids' => 'required|array',
            'ids.*' => 'exists:facilities,id'
        ]);

        $facilities = Facility::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'delete':
                // Delete images
                $facilitiesToDelete = $facilities->get();
                foreach ($facilitiesToDelete as $facility) {
                    if ($facility->image) {
                        Storage::delete('public/facilities/' . $facility->image);
                    }
                }
                $facilities->delete();
                $message = 'Fasilitas terpilih berhasil dihapus.';
                break;

            case 'activate':
                $facilities->update(['status' => 'active']);
                $message = 'Fasilitas terpilih berhasil diaktifkan.';
                break;

            case 'deactivate':
                $facilities->update(['status' => 'inactive']);
                $message = 'Fasilitas terpilih berhasil dinonaktifkan.';
                break;

            case 'feature':
                $facilities->update(['is_featured' => true]);
                $message = 'Fasilitas terpilih berhasil dijadikan unggulan.';
                break;

            case 'unfeature':
                $facilities->update(['is_featured' => false]);
                $message = 'Fasilitas terpilih berhasil dihapus dari unggulan.';
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message
        ]);
    }

    /**
     * Update sort order
     */
    public function updateSortOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:facilities,id',
            'items.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($request->items as $item) {
            Facility::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Urutan fasilitas berhasil diperbarui.'
        ]);
    }
}