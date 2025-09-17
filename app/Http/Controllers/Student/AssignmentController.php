<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
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
        $query = Assignment::with(['teacher', 'submissions' => function($q) {
            $q->where('student_id', Auth::id());
        }])
        ->where('status', 'published')
        ->where('due_date', '>=', now())
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
        
        // Get filter options
        $subjects = Assignment::where('status', 'published')
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        // Get statistics
        $stats = [
            'total_assignments' => Assignment::where('status', 'published')->count(),
            'submitted' => AssignmentSubmission::where('student_id', Auth::id())->count(),
            'pending' => Assignment::where('status', 'published')
                ->where('due_date', '>=', now())
                ->whereDoesntHave('submissions', function($q) {
                    $q->where('student_id', Auth::id());
                })->count(),
            'overdue' => Assignment::where('status', 'published')
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
            ]
        ]);
    }

    /**
     * Display the specified assignment
     */
    public function show($id)
    {
        $assignment = Assignment::with(['teacher', 'submissions' => function($q) {
            $q->where('student_id', Auth::id());
        }])->findOrFail($id);

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
}