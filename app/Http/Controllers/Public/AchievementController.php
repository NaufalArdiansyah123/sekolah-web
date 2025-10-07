<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    /**
     * Display a listing of achievements for public
     */
    public function index(Request $request)
    {
        $query = Achievement::active()->latest('achievement_date');
        
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
        
        // Sorting
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'oldest':
                $query->oldest('achievement_date');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            case 'level':
                $query->orderByRaw("FIELD(level, 'international', 'national', 'province', 'city', 'district', 'school')");
                break;
            default: // latest
                $query->latest('achievement_date');
        }
        
        $achievements = $query->paginate(12);
        
        // Get featured achievements
        $featuredAchievements = Achievement::active()
                                         ->featured()
                                         ->latest('achievement_date')
                                         ->take(6)
                                         ->get();
        
        // Get filter options
        $categories = Achievement::active()
                                ->distinct()
                                ->pluck('category')
                                ->filter()
                                ->mapWithKeys(function($category) {
                                    return [$category => Achievement::getCategoryOptions()[$category] ?? ucfirst($category)];
                                })
                                ->sort();
        
        $levels = Achievement::active()
                            ->distinct()
                            ->pluck('level')
                            ->filter()
                            ->mapWithKeys(function($level) {
                                return [$level => Achievement::getLevelOptions()[$level] ?? ucfirst($level)];
                            });
        
        $years = Achievement::active()
                           ->distinct()
                           ->pluck('year')
                           ->filter()
                           ->sort()
                           ->reverse()
                           ->values();
        
        // Get statistics
        $statistics = Achievement::getStatistics();
        
        return view('public.achievements.index', compact(
            'achievements',
            'featuredAchievements', 
            'categories', 
            'levels', 
            'years',
            'statistics'
        ));
    }

    /**
     * Display the specified achievement
     */
    public function show(Achievement $achievement)
    {
        // Check if achievement is active
        if (!$achievement->is_active) {
            abort(404);
        }
        
        // Get related achievements (same category, different achievement)
        $relatedAchievements = Achievement::active()
                                        ->where('id', '!=', $achievement->id)
                                        ->where('category', $achievement->category)
                                        ->latest('achievement_date')
                                        ->take(6)
                                        ->get();
        
        // If not enough related achievements, get more from other categories
        if ($relatedAchievements->count() < 6) {
            $additionalAchievements = Achievement::active()
                                               ->where('id', '!=', $achievement->id)
                                               ->whereNotIn('id', $relatedAchievements->pluck('id'))
                                               ->latest('achievement_date')
                                               ->take(6 - $relatedAchievements->count())
                                               ->get();
            $relatedAchievements = $relatedAchievements->merge($additionalAchievements);
        }
        
        // Get achievements from same year
        $sameYearAchievements = Achievement::active()
                                         ->where('id', '!=', $achievement->id)
                                         ->where('year', $achievement->year)
                                         ->latest('achievement_date')
                                         ->take(4)
                                         ->get();
        
        return view('public.achievements.show', compact(
            'achievement', 
            'relatedAchievements',
            'sameYearAchievements'
        ));
    }
}