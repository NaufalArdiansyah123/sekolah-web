<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LearningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    // Materials Management
    public function materials(Request $request)
    {
        $query = LearningMaterial::with('teacher')
                                ->where('teacher_id', Auth::id())
                                ->latest();

        // Apply filters
        if ($request->filled('subject')) {
            $query->bySubject($request->get('subject'));
        }

        if ($request->filled('class')) {
            $query->byClass($request->get('class'));
        }

        if ($request->filled('type')) {
            $query->byType($request->get('type'));
        }

        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        $materials = $query->get();

        return view('teacher.learning.materials.index', compact('materials'));
    }

    public function createMaterial()
    {
        return view('teacher.learning.materials.create');
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'class' => 'required|string',
            'type' => 'required|in:document,video,presentation,exercise,audio',
            'description' => 'nullable|string',
            'file' => 'required|file|max:102400', // 100MB max
            'status' => 'required|in:draft,published'
        ]);

        $filePath = null;
        $fileName = null;
        $originalName = null;
        $mimeType = null;
        $fileSize = null;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();
            $filePath = $file->storeAs('learning/materials', $fileName, 'public');
        }

        // Save to database
        LearningMaterial::create([
            'title' => $request->title,
            'subject' => $request->subject,
            'class' => $request->class,
            'type' => $request->type,
            'description' => $request->description,
            'file_name' => $fileName,
            'file_path' => $filePath,
            'original_name' => $originalName,
            'mime_type' => $mimeType,
            'file_size' => $fileSize,
            'status' => $request->status,
            'teacher_id' => Auth::id(),
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.learning.materials.index')
            ->with('success', 'Learning material has been created successfully!');
    }

    public function editMaterial($id)
    {
        $material = LearningMaterial::where('teacher_id', Auth::id())
                                   ->findOrFail($id);

        return view('teacher.learning.materials.edit', compact('material'));
    }

    public function updateMaterial(Request $request, $id)
    {
        $material = LearningMaterial::where('teacher_id', Auth::id())
                                   ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'class' => 'required|string',
            'type' => 'required|in:document,video,presentation,exercise,audio',
            'description' => 'nullable|string',
            'file' => 'nullable|file|max:102400',
            'status' => 'required|in:draft,published'
        ]);

        $updateData = [
            'title' => $request->title,
            'subject' => $request->subject,
            'class' => $request->class,
            'type' => $request->type,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ];

        // Handle file upload if new file provided
        if ($request->hasFile('file')) {
            // Delete old file
            if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
                Storage::disk('public')->delete($material->file_path);
            }

            $file = $request->file('file');
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $mimeType = $file->getMimeType();
            $fileSize = $file->getSize();
            $filePath = $file->storeAs('learning/materials', $fileName, 'public');

            $updateData = array_merge($updateData, [
                'file_name' => $fileName,
                'file_path' => $filePath,
                'original_name' => $originalName,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
            ]);
        }

        $material->update($updateData);

        return redirect()->route('teacher.learning.materials.index')
            ->with('success', 'Learning material has been updated successfully!');
    }

    public function destroyMaterial($id)
    {
        $material = LearningMaterial::where('teacher_id', Auth::id())
                                   ->findOrFail($id);

        // Delete file from storage
        if ($material->file_path && Storage::disk('public')->exists($material->file_path)) {
            Storage::disk('public')->delete($material->file_path);
        }

        // Delete from database
        $material->delete();

        return redirect()->route('teacher.learning.materials.index')
            ->with('success', 'Learning material has been deleted successfully!');
    }

    // Assignments Management
    public function assignments(Request $request)
    {
        $query = Assignment::with('teacher')
                          ->where('teacher_id', Auth::id())
                          ->latest();

        // Apply filters
        if ($request->filled('subject')) {
            $query->bySubject($request->get('subject'));
        }

        if ($request->filled('class')) {
            $query->byClass($request->get('class'));
        }

        if ($request->filled('status')) {
            $query->byStatus($request->get('status'));
        }

        if ($request->filled('type')) {
            $query->byType($request->get('type'));
        }

        if ($request->filled('search')) {
            $query->search($request->get('search'));
        }

        $assignments = $query->paginate(12);
        
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
            'total_submissions' => \App\Models\AssignmentSubmission::whereHas('assignment', function($q) {
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

    public function createAssignment()
    {
        return view('teacher.learning.assignments.create');
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'class' => 'required|string',
            'type' => 'required|in:homework,project,essay,quiz,presentation',
            'description' => 'required|string',
            'due_date' => 'required|date|after:today',
            'max_score' => 'required|integer|min:1|max:1000',
            'instructions' => 'nullable|string',
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|max:51200', // 50MB per file
            'status' => 'required|in:draft,active'
        ]);

        // Create assignment
        $assignment = Assignment::create([
            'title' => $request->title,
            'subject' => $request->subject,
            'class' => $request->class,
            'type' => $request->type,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'due_date' => $request->due_date,
            'max_score' => $request->max_score,
            'status' => $request->status,
            'teacher_id' => Auth::id(),
            'created_by' => Auth::id(),
        ]);

        // Handle file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('learning/assignments', $filename, 'public');
                
                // Here you would save attachment info to assignment_attachments table
                // AssignmentAttachment::create([...]);
            }
        }

        return redirect()->route('teacher.learning.assignments.index')
            ->with('success', 'Assignment has been created successfully!');
    }

    public function showAssignment($id)
    {
        $assignment = Assignment::with('teacher')
                                ->where('teacher_id', Auth::id())
                                ->findOrFail($id);

        // Mock submissions data for now (until submission system is implemented)
        $submissions = collect([
            (object)[
                'id' => 1,
                'student_name' => 'Ahmad Rizki',
                'student_nis' => '2023001',
                'submitted_at' => Carbon::parse('2024-02-10 14:30:00'),
                'score' => 85,
                'status' => 'graded',
                'file_name' => 'tugas_ahmad.pdf'
            ],
            (object)[
                'id' => 2,
                'student_name' => 'Siti Nurhaliza',
                'student_nis' => '2023002',
                'submitted_at' => Carbon::parse('2024-02-12 09:15:00'),
                'score' => null,
                'status' => 'submitted',
                'file_name' => 'tugas_siti.pdf'
            ]
        ]);

        // Calculate submission statistics
        $totalStudents = \App\Models\User::role('student')->count();
        $totalSubmissions = 0; // Mock data for now
        $gradedSubmissions = 0; // Mock data for now
        $ungradedSubmissions = $totalSubmissions - $gradedSubmissions;
        $pendingSubmissions = $totalStudents - $totalSubmissions;
        
        $submissionPercentage = $totalStudents > 0 ? round(($totalSubmissions / $totalStudents) * 100, 1) : 0;
        $gradingPercentage = $totalSubmissions > 0 ? round(($gradedSubmissions / $totalSubmissions) * 100, 1) : 0;
        $averageScore = 0; // Mock data for now

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

        // Get recent submissions (mock data)
        $recentSubmissions = collect();

        return view('teacher.learning.assignments.show', [
            'pageTitle' => $assignment->title,
            'breadcrumb' => [
                ['title' => 'Kelola Tugas', 'url' => route('teacher.learning.assignments.index')],
                ['title' => $assignment->title]
            ],
            'assignment' => $assignment,
            'submissionStats' => $submissionStats,
            'recentSubmissions' => $recentSubmissions
        ]);
    }

    public function editAssignment($id)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())
                                ->findOrFail($id);

        return view('teacher.learning.assignments.edit', compact('assignment'));
    }

    public function updateAssignment(Request $request, $id)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())
                                ->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'class' => 'required|string',
            'type' => 'required|in:homework,project,essay,quiz,presentation',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'max_score' => 'required|integer|min:1|max:1000',
            'instructions' => 'nullable|string',
            'status' => 'required|in:draft,active,completed'
        ]);

        $assignment->update([
            'title' => $request->title,
            'subject' => $request->subject,
            'class' => $request->class,
            'type' => $request->type,
            'description' => $request->description,
            'instructions' => $request->instructions,
            'due_date' => $request->due_date,
            'max_score' => $request->max_score,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('teacher.learning.assignments.index')
            ->with('success', 'Assignment has been updated successfully!');
    }

    public function destroyAssignment($id)
    {
        $assignment = Assignment::where('teacher_id', Auth::id())
                                ->findOrFail($id);

        // Delete assignment from database
        $assignment->delete();

        return redirect()->route('teacher.learning.assignments.index')
            ->with('success', 'Assignment has been deleted successfully!');
    }
}