<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Display a listing of assignments for students
     */
    public function index(Request $request)
    {
        // Get current student's class
        $student = Student::where('user_id', Auth::id())->with('class')->first();
        
        // Debug information
        $debugInfo = [
            'user_id' => Auth::id(),
            'student_found' => $student ? true : false,
            'student_class_id' => $student ? $student->class_id : null,
            'student_class_name' => $student && $student->class ? $student->class->name : null,
        ];
        
        if (!$student || !$student->class_id) {
            // Create empty paginated collection
            $emptyAssignments = new \Illuminate\Pagination\LengthAwarePaginator(
                collect(), // items
                0, // total
                12, // per page
                1, // current page
                ['path' => request()->url(), 'pageName' => 'page']
            );
            
            return view('student.assignments.index', [
                'pageTitle' => 'Tugas & Assignment',
                'breadcrumb' => [['title' => 'Tugas & Assignment']],
                'assignments' => $emptyAssignments,
                'subjects' => collect(),
                'stats' => ['total_assignments' => 0, 'submitted' => 0, 'pending' => 0, 'overdue' => 0],
                'currentFilters' => ['subject' => null, 'status' => null],
                'message' => 'Anda belum terdaftar dalam kelas manapun. Silakan hubungi admin.',
                'debugInfo' => $debugInfo
            ]);
        }

        // Add debug info for assignments query
        $debugInfo['total_assignments_in_db'] = Assignment::count();
        $debugInfo['assignments_for_class'] = Assignment::where('class_id', $student->class_id)->count();
        $debugInfo['published_assignments_for_class'] = Assignment::where('class_id', $student->class_id)
            ->whereIn('status', ['published', 'active'])->count();
        
        $query = Assignment::with(['teacher', 'class', 'submissions' => function($q) {
            $q->where('student_id', Auth::id());
        }])
        ->where('class_id', $student->class_id)
        ->whereIn('status', ['published', 'active'])
        ->latest();

        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'submitted') {
                $query->whereHas('submissions', function($q) {
                    $q->where('student_id', Auth::id());
                });
            } elseif ($request->status === 'pending') {
                $query->whereDoesntHave('submissions', function($q) {
                    $q->where('student_id', Auth::id());
                });
            }
        }

        $assignments = $query->paginate(12);
        $debugInfo['assignments_found'] = $assignments->total();
        
        // Get filter options
        $subjects = Assignment::where('class_id', $student->class_id)
            ->whereIn('status', ['published', 'active'])
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        // Get statistics
        $stats = [
            'total_assignments' => Assignment::where('class_id', $student->class_id)
                ->whereIn('status', ['published', 'active'])->count(),
            'submitted' => AssignmentSubmission::where('student_id', Auth::id())
                ->whereHas('assignment', function($q) use ($student) {
                    $q->where('class_id', $student->class_id);
                })->count(),
            'pending' => Assignment::where('class_id', $student->class_id)
                ->whereIn('status', ['published', 'active'])
                ->where('due_date', '>=', now())
                ->whereDoesntHave('submissions', function($q) {
                    $q->where('student_id', Auth::id());
                })->count(),
            'overdue' => Assignment::where('class_id', $student->class_id)
                ->whereIn('status', ['published', 'active'])
                ->where('due_date', '<', now())
                ->whereDoesntHave('submissions', function($q) {
                    $q->where('student_id', Auth::id());
                })->count(),
        ];

        return view('student.assignments.index', [
            'pageTitle' => 'Tugas & Assignment',
            'breadcrumb' => [
                ['title' => 'Tugas & Assignment']
            ],
            'assignments' => $assignments,
            'subjects' => $subjects,
            'stats' => $stats,
            'currentFilters' => [
                'subject' => $request->subject,
                'status' => $request->status,
            ],
            'debugInfo' => $debugInfo
        ]);
    }

    /**
     * Display the specified assignment
     */
    public function show($id)
    {
        // Get current student's class
        $student = Student::where('user_id', Auth::id())->first();
        if (!$student || !$student->class_id) {
            abort(403, 'Anda belum terdaftar dalam kelas manapun.');
        }

        $assignment = Assignment::with(['teacher', 'class', 'submissions' => function($q) {
            $q->where('student_id', Auth::id());
        }])
        ->where('class_id', $student->class_id)
        ->findOrFail($id);

        // Check if student has already submitted
        $submission = $assignment->submissions->first();

        return view('student.assignments.show', [
            'pageTitle' => $assignment->title,
            'breadcrumb' => [
                ['title' => 'Tugas & Assignment', 'url' => route('student.assignments.index')],
                ['title' => $assignment->title]
            ],
            'assignment' => $assignment,
            'submission' => $submission
        ]);
    }

    /**
     * Submit assignment
     */
    public function submit(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        
        // Check if assignment is still open
        if ($assignment->due_date < now()) {
            return redirect()->back()->with('error', 'Waktu pengumpulan tugas sudah berakhir!');
        }

        // Check if already submitted
        $existingSubmission = AssignmentSubmission::where('assignment_id', $id)
            ->where('student_id', Auth::id())
            ->first();

        if ($existingSubmission) {
            return redirect()->back()->with('error', 'Anda sudah mengumpulkan tugas ini!');
        }

        $request->validate([
            'content' => 'required|string',
            'file' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png'
        ]);

        $submission = new AssignmentSubmission();
        $submission->assignment_id = $id;
        $submission->student_id = Auth::id();
        $submission->content = $request->content;
        $submission->submitted_at = now();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assignments/submissions', $filename, 'public');
            $submission->file_path = $path;
            $submission->file_name = $file->getClientOriginalName();
        }

        $submission->save();

        return redirect()->route('student.assignments.show', $id)
            ->with('success', 'Tugas berhasil dikumpulkan!');
    }

    /**
     * Check assignment grading status (AJAX)
     */
    public function checkStatus($id)
    {
        $assignment = Assignment::findOrFail($id);
        $submission = AssignmentSubmission::where('assignment_id', $id)
            ->where('student_id', Auth::id())
            ->first();

        if (!$submission) {
            return response()->json([
                'submitted' => false,
                'graded' => false
            ]);
        }

        $data = [
            'submitted' => true,
            'graded' => !is_null($submission->graded_at),
            'submitted_at' => $submission->submitted_at->toISOString(),
        ];

        if ($submission->graded_at) {
            $data['graded_at'] = $submission->graded_at->toISOString();
            $data['score'] = $submission->score;
            $data['max_score'] = $assignment->max_score;
            $data['percentage'] = round(($submission->score / $assignment->max_score) * 100, 1);
            $data['feedback'] = $submission->feedback;
        }

        return response()->json($data);
    }
}