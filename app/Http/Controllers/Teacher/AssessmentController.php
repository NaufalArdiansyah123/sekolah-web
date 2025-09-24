<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Student, Assignment, Quiz, Grade, DailyTest};
use Illuminate\Support\Facades\Auth;

class AssessmentController extends Controller
{
    /**
     * Display a listing of assessments.
     */
    public function index(Request $request)
    {
        $teacher = Auth::user();
        
        // Get filter parameters
        $subject = $request->get('subject');
        $class = $request->get('class');
        $type = $request->get('type', 'all'); // all, assignments, quizzes, daily_tests
        
        // Base query for teacher's assessments
        $assignments = Assignment::where('teacher_id', $teacher->id);
        $quizzes = Quiz::where('teacher_id', $teacher->id);
        $dailyTests = DailyTest::where('teacher_id', $teacher->id);
        
        // Apply filters
        if ($subject) {
            $assignments->where('subject', $subject);
            $quizzes->where('subject', $subject);
            $dailyTests->where('subject', $subject);
        }
        
        if ($class) {
            $assignments->where('class', $class);
            $quizzes->where('class', $class);
            $dailyTests->where('class', $class);
        }
        
        // Get data based on type filter
        $assessments = collect();
        
        if ($type === 'all' || $type === 'assignments') {
            $assignmentData = $assignments->with(['submissions'])->get()->map(function ($item) {
                $item->type = 'assignment';
                $item->submissions_count = $item->submissions->count();
                $item->graded_count = $item->submissions->whereNotNull('grade')->count();
                return $item;
            });
            $assessments = $assessments->merge($assignmentData);
        }
        
        if ($type === 'all' || $type === 'quizzes') {
            $quizData = $quizzes->with(['attempts'])->get()->map(function ($item) {
                $item->type = 'quiz';
                $item->submissions_count = $item->attempts->count();
                $item->graded_count = $item->attempts->whereNotNull('score')->count();
                return $item;
            });
            $assessments = $assessments->merge($quizData);
        }
        
        if ($type === 'all' || $type === 'daily_tests') {
            $dailyTestData = $dailyTests->with(['attempts'])->get()->map(function ($item) {
                $item->type = 'daily_test';
                $item->submissions_count = $item->attempts->count();
                $item->graded_count = $item->attempts->whereNotNull('score')->count();
                return $item;
            });
            $assessments = $assessments->merge($dailyTestData);
        }
        
        // Sort by created_at desc
        $assessments = $assessments->sortByDesc('created_at');
        
        // Get unique subjects and classes for filters
        $subjects = collect();
        $classes = collect();
        
        if ($type === 'all' || $type === 'assignments') {
            $assignmentSubjects = Assignment::where('teacher_id', $teacher->id)->distinct()->pluck('subject');
            $assignmentClasses = Assignment::where('teacher_id', $teacher->id)->distinct()->pluck('class');
            $subjects = $subjects->merge($assignmentSubjects);
            $classes = $classes->merge($assignmentClasses);
        }
        
        if ($type === 'all' || $type === 'quizzes') {
            $quizSubjects = Quiz::where('teacher_id', $teacher->id)->distinct()->pluck('subject');
            $quizClasses = Quiz::where('teacher_id', $teacher->id)->distinct()->pluck('class');
            $subjects = $subjects->merge($quizSubjects);
            $classes = $classes->merge($quizClasses);
        }
        
        if ($type === 'all' || $type === 'daily_tests') {
            $dailyTestSubjects = DailyTest::where('teacher_id', $teacher->id)->distinct()->pluck('subject');
            $dailyTestClasses = DailyTest::where('teacher_id', $teacher->id)->distinct()->pluck('class');
            $subjects = $subjects->merge($dailyTestSubjects);
            $classes = $classes->merge($dailyTestClasses);
        }
        
        $subjects = $subjects->unique()->filter()->sort()->values();
        $classes = $classes->unique()->filter()->sort()->values();
        
        // Statistics
        $stats = [
            'total_assessments' => $assessments->count(),
            'pending_grading' => $assessments->sum(function ($item) {
                return $item->submissions_count - $item->graded_count;
            }),
            'total_submissions' => $assessments->sum('submissions_count'),
            'graded_submissions' => $assessments->sum('graded_count'),
        ];
        
        return view('teacher.assessment.index', compact(
            'assessments',
            'subjects',
            'classes',
            'stats',
            'subject',
            'class',
            'type'
        ));
    }
    
    /**
     * Display assessment grades overview.
     */
    public function grades(Request $request)
    {
        $teacher = Auth::user();
        
        // Get filter parameters
        $subject = $request->get('subject');
        $class = $request->get('class');
        
        // Get grades for teacher's assessments
        $grades = Grade::whereHas('assignment', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        });
        
        if ($subject) {
            $grades->whereHas('assignment', function ($query) use ($subject) {
                $query->where('subject', $subject);
            });
        }
        
        if ($class) {
            $grades->whereHas('assignment', function ($query) use ($class) {
                $query->where('class', $class);
            });
        }
        
        $grades = $grades->with(['assignment', 'student'])->latest()->paginate(20);
        
        // Get subjects and classes for filters
        $subjects = Assignment::where('teacher_id', $teacher->id)->distinct()->pluck('subject')->filter()->sort();
        $classes = Assignment::where('teacher_id', $teacher->id)->distinct()->pluck('class')->filter()->sort();
        
        // Statistics
        $stats = [
            'total_grades' => Grade::whereHas('assignment', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->count(),
            'average_grade' => Grade::whereHas('assignment', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->avg('grade'),
            'highest_grade' => Grade::whereHas('assignment', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->max('grade'),
            'lowest_grade' => Grade::whereHas('assignment', function ($query) use ($teacher) {
                $query->where('teacher_id', $teacher->id);
            })->min('grade'),
        ];
        
        return view('teacher.assessment.grades', compact(
            'grades',
            'subjects',
            'classes',
            'stats',
            'subject',
            'class'
        ));
    }
    
    /**
     * Display assessment reports.
     */
    public function reports(Request $request)
    {
        $teacher = Auth::user();
        
        // Get filter parameters
        $subject = $request->get('subject');
        $class = $request->get('class');
        $period = $request->get('period', 'month'); // week, month, semester
        
        // Get date range based on period
        $startDate = now();
        $endDate = now();
        
        switch ($period) {
            case 'week':
                $startDate = now()->startOfWeek();
                $endDate = now()->endOfWeek();
                break;
            case 'month':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'semester':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
        }
        
        // Get assessment data for reports
        $assignments = Assignment::where('teacher_id', $teacher->id)
            ->whereBetween('created_at', [$startDate, $endDate]);
            
        $quizzes = Quiz::where('teacher_id', $teacher->id)
            ->whereBetween('created_at', [$startDate, $endDate]);
            
        $dailyTests = DailyTest::where('teacher_id', $teacher->id)
            ->whereBetween('created_at', [$startDate, $endDate]);
        
        // Apply filters
        if ($subject) {
            $assignments->where('subject', $subject);
            $quizzes->where('subject', $subject);
            $dailyTests->where('subject', $subject);
        }
        
        if ($class) {
            $assignments->where('class', $class);
            $quizzes->where('class', $class);
            $dailyTests->where('class', $class);
        }
        
        // Get counts
        $assignmentCount = $assignments->count();
        $quizCount = $quizzes->count();
        $dailyTestCount = $dailyTests->count();
        
        // Get subjects and classes for filters
        $subjects = Assignment::where('teacher_id', $teacher->id)->distinct()->pluck('subject')->filter()->sort();
        $classes = Assignment::where('teacher_id', $teacher->id)->distinct()->pluck('class')->filter()->sort();
        
        // Report data
        $reportData = [
            'period' => $period,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'assignments' => $assignmentCount,
            'quizzes' => $quizCount,
            'daily_tests' => $dailyTestCount,
            'total_assessments' => $assignmentCount + $quizCount + $dailyTestCount,
        ];
        
        return view('teacher.assessment.reports', compact(
            'reportData',
            'subjects',
            'classes',
            'subject',
            'class',
            'period'
        ));
    }
}