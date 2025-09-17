<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    /**
     * Display a listing of assignments for teachers
     */
    public function index(Request $request)
    {
        $query = Assignment::with(['submissions', 'teacher'])
            ->where('teacher_id', Auth::id())
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        $assignments = $query->with('submissions')->paginate(12);
        
        // Get filter options
        $subjects = Assignment::where('teacher_id', Auth::id())
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        // Get statistics
        $stats = [
            'total_assignments' => Assignment::where('teacher_id', Auth::id())->count(),
            'active' => Assignment::where('teacher_id', Auth::id())->whereIn('status', ['published', 'active'])->count(),
            'draft' => Assignment::where('teacher_id', Auth::id())->where('status', 'draft')->count(),
            'total_submissions' => AssignmentSubmission::whereHas('assignment', function($q) {
                $q->where('teacher_id', Auth::id());
            })->count(),
        ];

        return view('teacher.learning.assignments.index', [
            'pageTitle' => 'Kelola Tugas',
            'breadcrumb' => [
                ['title' => 'Kelola Tugas']
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
     * Show assignment submissions
     */
    public function submissions(Request $request, $id)
    {
        $assignment = Assignment::with(['submissions.student', 'teacher'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);

        $query = $assignment->submissions()->with('student');

        // Filter by grading status
        if ($request->filled('grading_status')) {
            if ($request->grading_status === 'graded') {
                $query->whereNotNull('graded_at');
            } elseif ($request->grading_status === 'ungraded') {
                $query->whereNull('graded_at');
            }
        }

        $submissions = $query->latest('submitted_at')->paginate(20);

        // Calculate statistics
        $totalSubmissions = $assignment->submissions()->count();
        $gradedSubmissions = $assignment->submissions()->whereNotNull('graded_at')->count();
        $ungradedSubmissions = $totalSubmissions - $gradedSubmissions;
        $progressPercentage = $totalSubmissions > 0 ? round(($gradedSubmissions / $totalSubmissions) * 100, 1) : 0;

        $stats = [
            'total_submissions' => $totalSubmissions,
            'graded' => $gradedSubmissions,
            'ungraded' => $ungradedSubmissions,
            'progress_percentage' => $progressPercentage,
            'average_score' => $assignment->submissions()->whereNotNull('score')->avg('score') ?? 0,
        ];

        return view('teacher.learning.assignments.submissions', [
            'pageTitle' => 'Pengumpulan Tugas: ' . $assignment->title,
            'breadcrumb' => [
                ['title' => 'Kelola Tugas', 'url' => route('teacher.assignments.index')],
                ['title' => $assignment->title]
            ],
            'assignment' => $assignment,
            'submissions' => $submissions,
            'stats' => $stats,
            'currentFilters' => [
                'grading_status' => $request->grading_status,
            ]
        ]);
    }

    /**
     * Show submission detail for grading
     */
    public function showSubmission($assignmentId, $submissionId)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($assignmentId);
        $submission = AssignmentSubmission::with(['student', 'assignment'])
            ->where('assignment_id', $assignmentId)
            ->findOrFail($submissionId);

        return view('teacher.learning.assignments.grade', [
            'pageTitle' => 'Nilai Tugas: ' . $submission->student->name,
            'breadcrumb' => [
                ['title' => 'Kelola Tugas', 'url' => route('teacher.assignments.index')],
                ['title' => $assignment->title, 'url' => route('teacher.assignments.submissions', $assignmentId)],
                ['title' => 'Penilaian']
            ],
            'assignment' => $assignment,
            'submission' => $submission
        ]);
    }

    /**
     * Grade a submission
     */
    public function gradeSubmission(Request $request, $assignmentId, $submissionId)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:' . $request->max_score,
            'feedback' => 'nullable|string|max:1000'
        ]);

        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($assignmentId);
        $submission = AssignmentSubmission::where('assignment_id', $assignmentId)->findOrFail($submissionId);

        // Update submission with grade
        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'graded_at' => now()
        ]);

        // Create or update grade record
        Grade::updateOrCreate(
            [
                'student_id' => $submission->student_id,
                'assignment_id' => $assignmentId,
            ],
            [
                'teacher_id' => Auth::id(),
                'subject' => $assignment->subject,
                'type' => 'assignment',
                'score' => $request->score,
                'max_score' => $assignment->max_score,
                'semester' => $this->getCurrentSemester(),
                'year' => now()->year,
                'notes' => $request->feedback
            ]
        );

        return redirect()->route('teacher.assignments.submissions', $assignmentId)
            ->with('success', 'Tugas berhasil dinilai!');
    }

    /**
     * Create new assignment
     */
    public function create()
    {
        return view('teacher.learning.assignments.create', [
            'pageTitle' => 'Buat Tugas Baru',
            'breadcrumb' => [
                ['title' => 'Kelola Tugas', 'url' => route('teacher.assignments.index')],
                ['title' => 'Buat Tugas Baru']
            ]
        ]);
    }

    /**
     * Store new assignment
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:100',
            'class' => 'required|string|max:50',
            'type' => 'required|in:homework,project,essay,quiz,presentation',
            'description' => 'required|string',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1|max:1000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png'
        ]);

        $assignment = new Assignment();
        $assignment->title = $request->title;
        $assignment->subject = $request->subject;
        $assignment->class = $request->class;
        $assignment->type = $request->type;
        $assignment->description = $request->description;
        $assignment->instructions = $request->instructions;
        $assignment->due_date = $request->due_date;
        $assignment->max_score = $request->max_score;
        $assignment->status = $request->status ?? 'draft';
        $assignment->teacher_id = Auth::id();
        $assignment->created_by = Auth::id();

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assignments/attachments', $filename, 'public');
            $assignment->attachment_path = $path;
            $assignment->attachment_name = $file->getClientOriginalName();
        }

        $assignment->save();

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Tugas berhasil dibuat!');
    }

    /**
     * Show assignment details
     */
    public function show($id)
    {
        $assignment = Assignment::with(['submissions.student', 'teacher'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);

        // Calculate submission statistics
        $totalStudents = \App\Models\User::role('student')->count(); // Assuming you have student role
        $totalSubmissions = $assignment->submissions()->count();
        $gradedSubmissions = $assignment->submissions()->whereNotNull('graded_at')->count();
        $ungradedSubmissions = $totalSubmissions - $gradedSubmissions;
        $pendingSubmissions = $totalStudents - $totalSubmissions;
        
        $submissionPercentage = $totalStudents > 0 ? round(($totalSubmissions / $totalStudents) * 100, 1) : 0;
        $gradingPercentage = $totalSubmissions > 0 ? round(($gradedSubmissions / $totalSubmissions) * 100, 1) : 0;
        $averageScore = $assignment->submissions()->whereNotNull('score')->avg('score') ?? 0;

        $submissionStats = [
            'total_students' => $totalStudents,
            'submitted' => $totalSubmissions,
            'pending' => $pendingSubmissions,
            'graded' => $gradedSubmissions,
            'ungraded' => $ungradedSubmissions,
            'submission_percentage' => $submissionPercentage,
            'grading_percentage' => $gradingPercentage,
            'average_score' => $averageScore,
        ];

        // Get recent submissions (last 5)
        $recentSubmissions = $assignment->submissions()
            ->with('student')
            ->latest('submitted_at')
            ->take(5)
            ->get();

        return view('teacher.learning.assignments.show', [
            'pageTitle' => $assignment->title,
            'breadcrumb' => [
                ['title' => 'Kelola Tugas', 'url' => route('teacher.assignments.index')],
                ['title' => $assignment->title]
            ],
            'assignment' => $assignment,
            'submissionStats' => $submissionStats,
            'recentSubmissions' => $recentSubmissions
        ]);
    }

    /**
     * Edit assignment
     */
    public function edit($id)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($id);

        return view('teacher.learning.assignments.edit', [
            'pageTitle' => 'Edit Tugas: ' . $assignment->title,
            'breadcrumb' => [
                ['title' => 'Kelola Tugas', 'url' => route('teacher.assignments.index')],
                ['title' => $assignment->title, 'url' => route('teacher.assignments.show', $id)],
                ['title' => 'Edit']
            ],
            'assignment' => $assignment
        ]);
    }

    /**
     * Update assignment
     */
    public function update(Request $request, $id)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:100',
            'class' => 'required|string|max:50',
            'type' => 'required|in:homework,project,essay,quiz,presentation',
            'description' => 'required|string',
            'instructions' => 'nullable|string',
            'due_date' => 'required|date',
            'max_score' => 'required|integer|min:1|max:1000',
            'attachment' => 'nullable|file|max:10240|mimes:pdf,doc,docx,txt,jpg,jpeg,png'
        ]);

        $assignment->title = $request->title;
        $assignment->subject = $request->subject;
        $assignment->class = $request->class;
        $assignment->type = $request->type;
        $assignment->description = $request->description;
        $assignment->instructions = $request->instructions;
        $assignment->due_date = $request->due_date;
        $assignment->max_score = $request->max_score;
        $assignment->status = $request->status ?? $assignment->status;
        $assignment->updated_by = Auth::id();

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($assignment->attachment_path) {
                Storage::disk('public')->delete($assignment->attachment_path);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('assignments/attachments', $filename, 'public');
            $assignment->attachment_path = $path;
            $assignment->attachment_name = $file->getClientOriginalName();
        }

        $assignment->save();

        return redirect()->route('teacher.assignments.show', $id)
            ->with('success', 'Tugas berhasil diperbarui!');
    }

    /**
     * Delete assignment
     */
    public function destroy($id)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($id);
        
        // Delete attachment file if exists
        if ($assignment->attachment_path) {
            Storage::disk('public')->delete($assignment->attachment_path);
        }

        $assignment->delete();

        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Tugas berhasil dihapus!');
    }

    /**
     * Get current semester
     */
    private function getCurrentSemester()
    {
        $month = now()->month;
        return $month >= 7 ? 1 : 2; // Semester 1: July-December, Semester 2: January-June
    }

    /**
     * Bulk grade submissions
     */
    public function bulkGrade(Request $request, $assignmentId)
    {
        $request->validate([
            'submissions' => 'required|array',
            'submissions.*.id' => 'required|exists:assignment_submissions,id',
            'submissions.*.score' => 'required|numeric|min:0',
            'submissions.*.feedback' => 'nullable|string|max:1000'
        ]);

        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($assignmentId);

        foreach ($request->submissions as $submissionData) {
            $submission = AssignmentSubmission::where('assignment_id', $assignmentId)
                ->findOrFail($submissionData['id']);

            // Update submission
            $submission->update([
                'score' => $submissionData['score'],
                'feedback' => $submissionData['feedback'] ?? null,
                'graded_at' => now()
            ]);

            // Create or update grade record
            Grade::updateOrCreate(
                [
                    'student_id' => $submission->student_id,
                    'assignment_id' => $assignmentId,
                ],
                [
                    'teacher_id' => Auth::id(),
                    'subject' => $assignment->subject,
                    'type' => 'assignment',
                    'score' => $submissionData['score'],
                    'max_score' => $assignment->max_score,
                    'semester' => $this->getCurrentSemester(),
                    'year' => now()->year,
                    'notes' => $submissionData['feedback'] ?? null
                ]
            );
        }

        return redirect()->route('teacher.assignments.submissions', $assignmentId)
            ->with('success', 'Penilaian massal berhasil disimpan!');
    }

    /**
     * Get submission progress (AJAX)
     */
    public function getSubmissionProgress($assignmentId)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())->findOrFail($assignmentId);
        
        $totalSubmissions = $assignment->submissions()->count();
        $gradedSubmissions = $assignment->submissions()->whereNotNull('graded_at')->count();
        $ungradedSubmissions = $totalSubmissions - $gradedSubmissions;
        $progressPercentage = $totalSubmissions > 0 ? round(($gradedSubmissions / $totalSubmissions) * 100, 1) : 0;
        $averageScore = $assignment->submissions()->whereNotNull('score')->avg('score') ?? 0;

        return response()->json([
            'total_submissions' => $totalSubmissions,
            'graded' => $gradedSubmissions,
            'ungraded' => $ungradedSubmissions,
            'progress_percentage' => $progressPercentage,
            'average_score' => round($averageScore, 1),
        ]);
    }
}