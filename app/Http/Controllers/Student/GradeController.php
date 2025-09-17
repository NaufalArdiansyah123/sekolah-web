<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Assignment;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class GradeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Display grades dashboard
     */
    public function index(Request $request)
    {
        $studentId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);

        // Get grades for current semester
        $grades = Grade::with(['assignment', 'quiz', 'teacher'])
            ->where('student_id', $studentId)
            ->where('semester', $semester)
            ->where('year', $year)
            ->orderBy('created_at', 'desc')
            ->get();

        // Group grades by subject
        $gradesBySubject = $grades->groupBy('subject');

        // Calculate statistics
        $stats = [
            'total_grades' => $grades->count(),
            'average_score' => $grades->avg('score') ?? 0,
            'highest_score' => $grades->max('score') ?? 0,
            'lowest_score' => $grades->min('score') ?? 0,
            'subjects_count' => $gradesBySubject->count()
        ];

        // Calculate subject averages
        $subjectAverages = [];
        foreach ($gradesBySubject as $subject => $subjectGrades) {
            $subjectAverages[$subject] = [
                'average' => round($subjectGrades->avg('score'), 2),
                'count' => $subjectGrades->count(),
                'latest' => $subjectGrades->first()
            ];
        }

        // Get recent grades (last 10)
        $recentGrades = $grades->take(10);

        return view('student.grades.index', [
            'pageTitle' => 'Nilai & Rapor',
            'breadcrumb' => [
                ['title' => 'Nilai & Rapor']
            ],
            'grades' => $grades,
            'gradesBySubject' => $gradesBySubject,
            'subjectAverages' => $subjectAverages,
            'recentGrades' => $recentGrades,
            'stats' => $stats,
            'currentSemester' => $semester,
            'currentYear' => $year
        ]);
    }

    /**
     * Show detailed grades by subject
     */
    public function subject(Request $request, $subject)
    {
        $studentId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);

        $grades = Grade::with(['assignment', 'quiz', 'teacher'])
            ->where('student_id', $studentId)
            ->where('subject', $subject)
            ->where('semester', $semester)
            ->where('year', $year)
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics for this subject
        $stats = [
            'total_grades' => $grades->count(),
            'average_score' => round($grades->avg('score'), 2) ?? 0,
            'highest_score' => $grades->max('score') ?? 0,
            'lowest_score' => $grades->min('score') ?? 0,
        ];

        // Group by assessment type
        $gradesByType = $grades->groupBy('type');

        return view('student.grades.subject', [
            'pageTitle' => 'Nilai ' . $subject,
            'breadcrumb' => [
                ['title' => 'Nilai & Rapor', 'url' => route('student.grades.index')],
                ['title' => $subject]
            ],
            'grades' => $grades,
            'gradesByType' => $gradesByType,
            'stats' => $stats,
            'subject' => $subject,
            'currentSemester' => $semester,
            'currentYear' => $year
        ]);
    }

    /**
     * Generate and download report card
     */
    public function report(Request $request)
    {
        $studentId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);

        // Get all grades for the semester
        $grades = Grade::with(['assignment', 'quiz', 'teacher'])
            ->where('student_id', $studentId)
            ->where('semester', $semester)
            ->where('year', $year)
            ->get();

        // Group by subject and calculate averages
        $subjectGrades = [];
        $gradesBySubject = $grades->groupBy('subject');
        
        foreach ($gradesBySubject as $subject => $subjectGradeList) {
            $subjectGrades[$subject] = [
                'grades' => $subjectGradeList,
                'average' => round($subjectGradeList->avg('score'), 2),
                'count' => $subjectGradeList->count(),
                'assignments' => $subjectGradeList->where('type', 'assignment'),
                'quizzes' => $subjectGradeList->where('type', 'quiz'),
                'exams' => $subjectGradeList->where('type', 'exam'),
            ];
        }

        // Calculate overall statistics
        $overallStats = [
            'total_subjects' => count($subjectGrades),
            'overall_average' => round($grades->avg('score'), 2),
            'total_assessments' => $grades->count(),
            'semester' => $semester,
            'year' => $year
        ];

        return view('student.grades.report', [
            'pageTitle' => 'Rapor Semester ' . $semester . ' - ' . $year,
            'breadcrumb' => [
                ['title' => 'Nilai & Rapor', 'url' => route('student.grades.index')],
                ['title' => 'Rapor']
            ],
            'subjectGrades' => $subjectGrades,
            'overallStats' => $overallStats,
            'student' => Auth::user()
        ]);
    }

    /**
     * Get current semester based on date
     */
    private function getCurrentSemester()
    {
        $month = now()->month;
        
        // Semester 1: July - December (7-12)
        // Semester 2: January - June (1-6)
        return $month >= 7 ? 1 : 2;
    }

    /**
     * Show grade detail
     */
    public function show($id)
    {
        $grade = Grade::with(['assignment', 'quiz', 'teacher'])
            ->where('student_id', Auth::id())
            ->findOrFail($id);

        return view('student.grades.show', [
            'pageTitle' => 'Detail Nilai',
            'breadcrumb' => [
                ['title' => 'Nilai & Rapor', 'url' => route('student.grades.index')],
                ['title' => 'Detail Nilai']
            ],
            'grade' => $grade
        ]);
    }
}