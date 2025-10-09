<?php

namespace App\Http\Controllers;

use App\Models\StudyProgram;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudyProgramController extends Controller
{
    /**
     * Display a listing of active study programs.
     */
    public function index(Request $request): View
    {
        $query = StudyProgram::active();

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply degree filter
        if ($request->filled('degree')) {
            $query->byDegree($request->degree);
        }

        // Apply faculty filter
        if ($request->filled('faculty')) {
            $query->byFaculty($request->faculty);
        }

        // Order by featured first, then by name
        $query->orderBy('is_featured', 'desc')
              ->orderBy('program_name', 'asc');

        // Paginate results
        $programs = $query->paginate(12)->withQueryString();

        // Get statistics for hero section
        $statistics = $this->getPublicStatistics();

        // Get available faculties for filter
        $faculties = StudyProgram::getAvailableFaculties();

        // Check if this is the academic programs route
        if (request()->route()->getName() === 'public.academic.programs') {
            return view('public.academic.programs', compact(
                'programs',
                'faculties'
            ) + $statistics);
        }

        return view('public.academic.programs', compact(
            'programs',
            'faculties'
        ) + $statistics);
    }

    /**
     * Display the specified study program.
     */
    public function show(StudyProgram $studyProgram): View
    {
        // Check if program is active
        if (!$studyProgram->is_active) {
            abort(404, 'Study program not found or not available.');
        }

        // Get related programs (same faculty or degree level)
        $relatedPrograms = StudyProgram::active()
            ->where('id', '!=', $studyProgram->id)
            ->where(function ($query) use ($studyProgram) {
                $query->where('faculty', $studyProgram->faculty)
                      ->orWhere('degree_level', $studyProgram->degree_level);
            })
            ->limit(3)
            ->get();

        return view('public.academic.program-detail', compact('studyProgram', 'relatedPrograms'));
    }

    /**
     * Get public statistics for the index page.
     */
    private function getPublicStatistics(): array
    {
        $activePrograms = StudyProgram::active();
        
        return [
            'totalPrograms' => $activePrograms->count(),
            'activePrograms' => $activePrograms->count(),
            'featuredPrograms' => $activePrograms->featured()->count(),
            'degreeTypes' => $activePrograms->distinct('degree_level')->count('degree_level'),
        ];
    }

    /**
     * Get programs by degree level (API endpoint).
     */
    public function byDegree(Request $request, string $degree)
    {
        $programs = StudyProgram::active()
            ->byDegree(strtoupper($degree))
            ->orderBy('program_name')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $programs,
                'count' => $programs->count(),
            ]);
        }

        return view('study-programs.by-degree', compact('programs', 'degree'));
    }

    /**
     * Get programs by faculty (API endpoint).
     */
    public function byFaculty(Request $request, string $faculty)
    {
        $programs = StudyProgram::active()
            ->byFaculty($faculty)
            ->orderBy('program_name')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $programs,
                'count' => $programs->count(),
            ]);
        }

        return view('study-programs.by-faculty', compact('programs', 'faculty'));
    }

    /**
     * Search programs (API endpoint).
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $programs = StudyProgram::active()
            ->search($request->q)
            ->limit($request->get('limit', 10))
            ->get(['id', 'program_name', 'program_code', 'degree_level', 'faculty']);

        return response()->json([
            'success' => true,
            'data' => $programs,
            'count' => $programs->count(),
            'query' => $request->q,
        ]);
    }

    /**
     * Get featured programs (API endpoint).
     */
    public function featured(Request $request)
    {
        $programs = StudyProgram::active()
            ->featured()
            ->orderBy('program_name')
            ->get();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'data' => $programs,
                'count' => $programs->count(),
            ]);
        }

        return view('study-programs.featured', compact('programs'));
    }

    /**
     * Get program statistics (API endpoint).
     */
    public function statistics()
    {
        $statistics = StudyProgram::getStatistics();
        $publicStats = $this->getPublicStatistics();

        return response()->json([
            'success' => true,
            'data' => array_merge($statistics, $publicStats),
        ]);
    }
}