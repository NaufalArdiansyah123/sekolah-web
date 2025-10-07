<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Student;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Exports\GradesExport;
use App\Exports\GradesTemplateExport;
use App\Imports\GradesImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
{
    /**
     * Display grades management dashboard
     */
    public function index(Request $request)
    {
        $teacherId = Auth::id();
        
        // Handle export requests
        if ($request->has('export')) {
            return $this->handleExport($request);
        }
        
        // Handle template download
        if ($request->has('download') && $request->download === 'template') {
            return $this->downloadTemplate();
        }
        
        // Handle import requests
        if ($request->hasFile('excel_file')) {
            return $this->handleImport($request);
        }
        
        // Get filters
        $subject = $request->get('subject');
        $class = $request->get('class');
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        $search = $request->get('search');
        
        // Build query
        $query = Grade::with(['student', 'assignment', 'quiz', 'teacher'])
                     ->where('teacher_id', $teacherId)
                     ->where('semester', $semester)
                     ->where('year', $year);
        
        if ($subject) {
            $query->where('subject', $subject);
        }
        
        if ($class) {
            $query->whereHas('student', function($q) use ($class) {
                $q->where('class', $class);
            });
        }
        
        if ($search) {
            $query->whereHas('student', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }
        
        $grades = $query->orderBy('created_at', 'desc')->paginate(20);
        
        // Get statistics
        $stats = [
            'total_grades' => Grade::where('teacher_id', $teacherId)->count(),
            'this_semester' => Grade::where('teacher_id', $teacherId)
                                  ->where('semester', $semester)
                                  ->where('year', $year)
                                  ->count(),
            'average_score' => Grade::where('teacher_id', $teacherId)
                                  ->where('semester', $semester)
                                  ->where('year', $year)
                                  ->avg('score') ?? 0,
            'subjects_count' => Grade::where('teacher_id', $teacherId)
                                   ->distinct('subject')
                                   ->count('subject'),
        ];
        
        // Get subjects for filter
        $subjects = Grade::where('teacher_id', $teacherId)
                        ->distinct('subject')
                        ->pluck('subject')
                        ->sort();
        
        // Get classes for filter
        $classes = User::role('student')
                      ->active()
                      ->distinct()
                      ->pluck('class')
                      ->filter()
                      ->sort();
        
        return view('teacher.grades.index', compact(
            'grades', 'stats', 'subjects', 'classes', 
            'subject', 'class', 'semester', 'year'
        ));
    }
    
    /**
     * Show form to create new grade
     */
    public function create()
    {
        $students = User::role('student')->orderBy('name')->get();
        $assignments = Assignment::where('teacher_id', Auth::id())->get();
        $quizzes = Quiz::where('teacher_id', Auth::id())->get();
        
        return view('teacher.grades.create', compact('students', 'assignments', 'quizzes'));
    }
    
    /**
     * Store new grade
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'type' => 'required|in:assignment,quiz,exam,manual',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'semester' => 'required|integer|in:1,2',
            'year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);
        
        Grade::create([
            'student_id' => $request->student_id,
            'teacher_id' => Auth::id(),
            'assignment_id' => $request->assignment_id,
            'quiz_id' => $request->quiz_id,
            'subject' => $request->subject,
            'type' => $request->type,
            'score' => $request->score,
            'max_score' => $request->max_score,
            'semester' => $request->semester,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('teacher.grades.index')
                        ->with('success', 'Nilai berhasil ditambahkan!');
    }
    
    /**
     * Show grade details
     */
    public function show($id)
    {
        $grade = Grade::with(['student', 'assignment', 'quiz'])
                     ->where('teacher_id', Auth::id())
                     ->findOrFail($id);
        
        return view('teacher.grades.show', compact('grade'));
    }
    
    /**
     * Show edit form
     */
    public function edit($id)
    {
        $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
        $students = User::role('student')->orderBy('name')->get();
        $assignments = Assignment::where('teacher_id', Auth::id())->get();
        $quizzes = Quiz::where('teacher_id', Auth::id())->get();
        
        return view('teacher.grades.edit', compact('grade', 'students', 'assignments', 'quizzes'));
    }
    
    /**
     * Update grade
     */
    public function update(Request $request, $id)
    {
        $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
        
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject' => 'required|string',
            'type' => 'required|in:assignment,quiz,exam,manual',
            'score' => 'required|numeric|min:0',
            'max_score' => 'required|numeric|min:1',
            'semester' => 'required|integer|in:1,2',
            'year' => 'required|integer',
            'notes' => 'nullable|string',
        ]);
        
        $grade->update([
            'student_id' => $request->student_id,
            'assignment_id' => $request->assignment_id,
            'quiz_id' => $request->quiz_id,
            'subject' => $request->subject,
            'type' => $request->type,
            'score' => $request->score,
            'max_score' => $request->max_score,
            'semester' => $request->semester,
            'year' => $request->year,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('teacher.grades.index')
                        ->with('success', 'Nilai berhasil diperbarui!');
    }
    
    /**
     * Delete grade
     */
    public function destroy(Request $request, $id = null)
    {
        if ($request->ajax()) {
            // Handle bulk delete
            if ($request->has('ids')) {
                $ids = $request->input('ids');
                $deleted = Grade::where('teacher_id', Auth::id())
                               ->whereIn('id', $ids)
                               ->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => $deleted . ' nilai berhasil dihapus!'
                ]);
            }
            
            // Handle single delete
            if ($id) {
                $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
                $grade->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Nilai berhasil dihapus!'
                ]);
            }
        }
        
        // Regular delete for non-AJAX requests
        $grade = Grade::where('teacher_id', Auth::id())->findOrFail($id);
        $grade->delete();
        
        return redirect()->route('teacher.grades.index')
                        ->with('success', 'Nilai berhasil dihapus!');
    }
    
    /**
     * Show grades report
     */
    public function report(Request $request)
    {
        $teacherId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        
        // Get grades grouped by subject and student
        $grades = Grade::with(['student'])
                      ->where('teacher_id', $teacherId)
                      ->where('semester', $semester)
                      ->where('year', $year)
                      ->get();
        
        $gradesBySubject = $grades->groupBy('subject');
        $gradesByStudent = $grades->groupBy('student_id');
        
        // Calculate statistics
        $stats = [
            'total_students' => $gradesByStudent->count(),
            'total_subjects' => $gradesBySubject->count(),
            'total_grades' => $grades->count(),
            'average_score' => $grades->avg('score') ?? 0,
            'highest_score' => $grades->max('score') ?? 0,
            'lowest_score' => $grades->min('score') ?? 0,
        ];
        
        // Subject performance
        $subjectStats = [];
        foreach ($gradesBySubject as $subject => $subjectGrades) {
            $subjectStats[$subject] = [
                'average' => round($subjectGrades->avg('score'), 2),
                'count' => $subjectGrades->count(),
                'highest' => $subjectGrades->max('score'),
                'lowest' => $subjectGrades->min('score'),
            ];
        }
        
        return view('teacher.grades.report', compact(
            'grades', 'gradesBySubject', 'gradesByStudent', 
            'stats', 'subjectStats', 'semester', 'year'
        ));
    }
    
    /**
     * Show grade recap/summary
     */
    public function recap(Request $request)
    {
        $teacherId = Auth::id();
        $semester = $request->get('semester', $this->getCurrentSemester());
        $year = $request->get('year', now()->year);
        
        // Get all students with their grades
        $students = User::role('student')
                       ->with(['grades' => function($query) use ($teacherId, $semester, $year) {
                           $query->where('teacher_id', $teacherId)
                                 ->where('semester', $semester)
                                 ->where('year', $year);
                       }])
                       ->whereHas('grades', function($query) use ($teacherId, $semester, $year) {
                           $query->where('teacher_id', $teacherId)
                                 ->where('semester', $semester)
                                 ->where('year', $year);
                       })
                       ->orderBy('name')
                       ->get();
        
        // Get subjects
        $subjects = Grade::where('teacher_id', $teacherId)
                        ->where('semester', $semester)
                        ->where('year', $year)
                        ->distinct('subject')
                        ->pluck('subject')
                        ->sort();
        
        return view('teacher.grades.recap', compact('students', 'subjects', 'semester', 'year'));
    }
    
    /**
     * Handle export functionality
     */
    private function handleExport(Request $request)
    {
        $teacherId = Auth::id();
        
        // Get filters
        $filters = [
            'subject' => $request->get('subject'),
            'class' => $request->get('class'),
            'semester' => $request->get('semester', $this->getCurrentSemester()),
            'year' => $request->get('year', now()->year),
            'search' => $request->get('search')
        ];
        
        // Build query
        $query = Grade::with(['student', 'assignment', 'quiz', 'teacher'])
                     ->where('teacher_id', $teacherId)
                     ->where('semester', $filters['semester'])
                     ->where('year', $filters['year']);
        
        if ($filters['subject']) {
            $query->where('subject', $filters['subject']);
        }
        
        if ($filters['class']) {
            $query->whereHas('student', function($q) use ($filters) {
                $q->where('class', $filters['class']);
            });
        }
        
        if ($filters['search']) {
            $query->whereHas('student', function($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%');
            });
        }
        
        // Handle selected export
        if ($request->export === 'selected' && $request->has('ids')) {
            $query->whereIn('id', $request->input('ids'));
        }
        
        $grades = $query->orderBy('created_at', 'desc')->get();
        
        // Generate filename
        $filename = 'nilai-siswa';
        if ($filters['subject']) {
            $filename .= '-' . str_replace(' ', '-', strtolower($filters['subject']));
        }
        if ($filters['class']) {
            $filename .= '-kelas-' . str_replace(' ', '-', strtolower($filters['class']));
        }
        $filename .= '-semester-' . $filters['semester'];
        $filename .= '-' . $filters['year'];
        $filename .= '-' . date('Y-m-d');
        $filename .= '.xlsx';
        
        return Excel::download(new GradesExport($grades, $filters), $filename);
    }
    
    /**
     * Download import template
     */
    private function downloadTemplate()
    {
        $filename = 'template-import-nilai-' . date('Y-m-d') . '.xlsx';
        return Excel::download(new GradesTemplateExport(), $filename);
    }
    
    /**
     * Handle import functionality
     */
    private function handleImport(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:5120' // 5MB max
        ]);
        
        try {
            DB::beginTransaction();
            
            $import = new GradesImport();
            Excel::import($import, $request->file('excel_file'));
            
            $results = $import->getResults();
            
            DB::commit();
            
            $message = "Berhasil mengimpor {$results['imported_count']} data nilai";
            
            if ($results['total_errors'] > 0) {
                $message .= ". Terdapat {$results['total_errors']} error";
                
                return response()->json([
                    'success' => $results['imported_count'] > 0,
                    'message' => $message,
                    'imported' => $results['imported_count'],
                    'errors' => $results['errors'],
                    'total_errors' => $results['total_errors']
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => $message,
                'imported' => $results['imported_count'],
                'errors' => [],
                'total_errors' => 0
            ]);
            
        } catch (\Exception $e) {
            DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage(),
                'imported' => 0,
                'errors' => [$e->getMessage()],
                'total_errors' => 1
            ]);
        }
    }
    
    /**
     * Get current semester
     */
    private function getCurrentSemester()
    {
        $month = now()->month;
        return $month >= 7 ? 1 : 2;
    }
}