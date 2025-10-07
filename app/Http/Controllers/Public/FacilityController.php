<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    /**
     * Display enhanced listing of facilities for public view
     */
    public function indexEnhanced(Request $request)
    {
        try {
            // Get active facilities
            $query = Facility::active();
            
            // Try to order by sort_order, fallback to created_at if column doesn't exist
            try {
                $query = $query->orderBy('sort_order', 'asc');
            } catch (\Exception $e) {
                $query = $query->orderBy('created_at', 'desc');
            }
            
            $facilities = $query->get();

            // Get facility statistics
            $stats = [
                'total_facilities' => Facility::active()->count(),
                'academic_facilities' => Facility::active()->where('category', 'academic')->count(),
                'sport_facilities' => Facility::active()->where('category', 'sport')->count(),
                'technology_facilities' => Facility::active()->where('category', 'technology')->count(),
            ];

            $categories = Facility::getCategories();

            return view('public.facilities.index-enhanced', compact(
                'facilities',
                'stats',
                'categories'
            ));
            
        } catch (\Exception $e) {
            // If table doesn't exist or other critical error, return empty data
            $facilities = collect([]);
            $stats = [
                'total_facilities' => 0,
                'academic_facilities' => 0,
                'sport_facilities' => 0,
                'technology_facilities' => 0,
            ];
            $categories = [
                'academic' => 'Akademik',
                'sport' => 'Olahraga', 
                'technology' => 'Teknologi',
                'arts' => 'Seni & Budaya',
                'other' => 'Lainnya'
            ];
            
            return view('public.facilities.index-enhanced', compact(
                'facilities',
                'stats',
                'categories'
            ));
        }
    }

    /**
     * Display a listing of facilities for public view
     */
    public function index(Request $request)
    {
        try {
            // Check if facilities table exists and has required columns
            $query = Facility::active();
            
            // Try to order by sort_order, fallback to id if column doesn't exist
            try {
                // Test if sort_order column exists by attempting to select it
                \DB::connection()->select('SELECT sort_order FROM facilities LIMIT 1');
                $query = $query->orderBy('sort_order', 'asc');
            } catch (\Exception $e) {
                // sort_order column doesn't exist, use id instead
                $query = $query->orderBy('id', 'asc');
            }
            
            // Filter berdasarkan kategori
            if ($request->filled('category') && $request->category !== 'all') {
                $query->where('category', $request->category);
            }

            $facilities = $query->get();

            // Group facilities by category for better organization
            $facilitiesByCategory = $facilities->groupBy('category');

            // Get featured facilities
            try {
                // Try to use is_featured column, fallback if it doesn't exist
                try {
                    \DB::connection()->select('SELECT is_featured FROM facilities LIMIT 1');
                    $featuredFacilities = Facility::active()->where('is_featured', true)->orderBy('id', 'asc')->take(6)->get();
                } catch (\Exception $e) {
                    // is_featured column doesn't exist, just get first 6
                    $featuredFacilities = Facility::active()->orderBy('id', 'asc')->take(6)->get();
                }
            } catch (\Exception $e) {
                $featuredFacilities = collect([]);
            }

            // Get facility statistics
            try {
                $stats = [
                    'total_facilities' => Facility::active()->count(),
                    'academic_facilities' => Facility::active()->where('category', 'academic')->count(),
                    'sport_facilities' => Facility::active()->where('category', 'sport')->count(),
                    'technology_facilities' => Facility::active()->where('category', 'technology')->count(),
                ];
            } catch (\Exception $e) {
                $stats = [
                    'total_facilities' => 0,
                    'academic_facilities' => 0,
                    'sport_facilities' => 0,
                    'technology_facilities' => 0,
                ];
            }

            $categories = Facility::getCategories();

            return view('public.facilities.index', compact(
                'facilities',
                'facilitiesByCategory',
                'featuredFacilities',
                'stats',
                'categories'
            ));
            
        } catch (\Exception $e) {
            // If table doesn't exist or other critical error, return empty data
            $facilities = collect([]);
            $facilitiesByCategory = collect([]);
            $featuredFacilities = collect([]);
            $stats = [
                'total_facilities' => 0,
                'academic_facilities' => 0,
                'sport_facilities' => 0,
                'technology_facilities' => 0,
            ];
            $categories = [
                'academic' => 'Akademik',
                'sport' => 'Olahraga', 
                'technology' => 'Teknologi',
                'arts' => 'Seni & Budaya',
                'other' => 'Lainnya'
            ];
            
            return view('public.facilities.index', compact(
                'facilities',
                'facilitiesByCategory',
                'featuredFacilities',
                'stats',
                'categories'
            ));
        }
    }

    /**
     * Display the specified facility
     */
    public function show(Facility $facility)
    {
        // Only show active facilities to public
        if ($facility->status !== 'active') {
            abort(404);
        }

        // Get related facilities (same category, excluding current)
        $relatedQuery = Facility::active()
            ->where('category', $facility->category)
            ->where('id', '!=', $facility->id);
            
        // Try to order by sort_order, fallback to id
        try {
            \DB::connection()->select('SELECT sort_order FROM facilities LIMIT 1');
            $relatedQuery = $relatedQuery->orderBy('sort_order', 'asc');
        } catch (\Exception $e) {
            $relatedQuery = $relatedQuery->orderBy('id', 'asc');
        }
        
        $relatedFacilities = $relatedQuery->take(3)->get();

        return view('public.facilities.show', compact('facility', 'relatedFacilities'));
    }

    /**
     * Get facilities by category (AJAX)
     */
    public function getByCategory(Request $request)
    {
        $category = $request->get('category');
        
        $query = Facility::active();
        
        // Try to order by sort_order, fallback to id
        try {
            \DB::connection()->select('SELECT sort_order FROM facilities LIMIT 1');
            $query = $query->orderBy('sort_order', 'asc');
        } catch (\Exception $e) {
            $query = $query->orderBy('id', 'asc');
        }
        
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        
        $facilities = $query->get();
        
        return response()->json([
            'success' => true,
            'facilities' => $facilities->map(function ($facility) {
                return [
                    'id' => $facility->id,
                    'name' => $facility->name,
                    'description' => $facility->description,
                    'category' => $facility->category,
                    'category_label' => $facility->category_label,
                    'image_url' => $facility->image_url,
                    'features' => $facility->features,
                    'status' => $facility->status,
                    'capacity' => $facility->capacity,
                    'location' => $facility->location,
                    'is_featured' => $facility->is_featured
                ];
            })
        ]);
    }

    /**
     * Search facilities (AJAX)
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        
        $query = Facility::active();
        
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }
        
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }
        
        // Try to order by sort_order, fallback to id
        try {
            \DB::connection()->select('SELECT sort_order FROM facilities LIMIT 1');
            $facilities = $query->orderBy('sort_order', 'asc')->get();
        } catch (\Exception $e) {
            $facilities = $query->orderBy('id', 'asc')->get();
        }
        
        return response()->json([
            'success' => true,
            'facilities' => $facilities->map(function ($facility) {
                return [
                    'id' => $facility->id,
                    'name' => $facility->name,
                    'description' => $facility->description,
                    'category' => $facility->category,
                    'category_label' => $facility->category_label,
                    'image_url' => $facility->image_url,
                    'features' => $facility->features,
                    'status' => $facility->status,
                    'capacity' => $facility->capacity,
                    'location' => $facility->location,
                    'is_featured' => $facility->is_featured
                ];
            })
        ]);
    }
}