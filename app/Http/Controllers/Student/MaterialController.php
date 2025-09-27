<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Display a listing of learning materials for students
     */
    public function index(Request $request)
    {
        // Get current student's class
        $userId = Auth::id();
        $student = \App\Models\Student::where('user_id', $userId)->with('class')->first();
        
        // Debug info for troubleshooting
        $debugInfo = [
            'user_id' => $userId,
            'student_found' => $student ? true : false,
            'student_class_id' => $student ? $student->class_id : null,
            'student_class_name' => $student && $student->class ? $student->class->name : null,
        ];
        
        $query = LearningMaterial::with(['teacher', 'class'])
                                ->published()
                                ->latest();
        
        // Filter by student's class if student found
        if ($student && $student->class_id) {
            $query->forStudent($student->class_id);
            $debugInfo['filtering_applied'] = true;
            $debugInfo['filter_class_id'] = $student->class_id;
        } else {
            $debugInfo['filtering_applied'] = false;
            $debugInfo['reason'] = !$student ? 'Student not found' : 'Student has no class';
        }

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Subject filter
        if ($request->filled('subject')) {
            $query->bySubject($request->subject);
        }

        // Type filter
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'title':
                $query->orderBy('title');
                break;
            case 'downloads':
                $query->orderBy('downloads', 'desc');
                break;
            case 'subject':
                $query->orderBy('subject');
                break;
            default:
                $query->latest();
        }

        $materials = $query->paginate(12);
        
        // Add debug info
        $debugInfo['total_materials_found'] = $materials->total();
        $debugInfo['materials_on_current_page'] = $materials->count();
        
        // Get filter options (filtered by student's class)
        $subjectsQuery = LearningMaterial::published()
            ->select('subject')
            ->distinct()
            ->orderBy('subject');
        
        // Filter subjects by student's class if student found
        if ($student && $student->class_id) {
            $subjectsQuery->forStudent($student->class_id);
        }
        
        $subjects = $subjectsQuery->pluck('subject');

        $types = [
            'document' => 'Dokumen',
            'video' => 'Video',
            'presentation' => 'Presentasi',
            'exercise' => 'Latihan',
            'audio' => 'Audio'
        ];

        // Get statistics (filtered by student's class)
        $totalMaterialsQuery = LearningMaterial::published();
        $totalDownloadsQuery = LearningMaterial::published();
        $recentMaterialsQuery = LearningMaterial::published()->where('created_at', '>=', now()->subDays(7));
        
        // Filter statistics by student's class if student found
        if ($student && $student->class_id) {
            $totalMaterialsQuery->forStudent($student->class_id);
            $totalDownloadsQuery->forStudent($student->class_id);
            $recentMaterialsQuery->forStudent($student->class_id);
        }
        
        $stats = [
            'total_materials' => $totalMaterialsQuery->count(),
            'total_downloads' => $totalDownloadsQuery->sum('downloads'),
            'subjects_count' => $subjects->count(),
            'recent_materials' => $recentMaterialsQuery->count(),
        ];

        return view('student.materials.index', [
            'pageTitle' => 'Materi Pembelajaran',
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran']
            ],
            'materials' => $materials,
            'subjects' => $subjects,
            'types' => $types,
            'stats' => $stats,
            'currentFilters' => [
                'search' => $request->search,
                'subject' => $request->subject,
                'type' => $request->type,
                'sort' => $request->get('sort', 'latest')
            ],
            'debugInfo' => $debugInfo
        ]);
    }

    /**
     * Display the specified learning material
     */
    public function show($id)
    {
        // Get current student's class
        $userId = Auth::id();
        $student = \App\Models\Student::where('user_id', $userId)->first();
        
        $query = LearningMaterial::with(['teacher', 'class'])
                                ->published();
        
        // Filter by student's class if student found
        if ($student && $student->class_id) {
            $query->forStudent($student->class_id);
        }
        
        $material = $query->findOrFail($id);

        return view('student.materials.show', [
            'pageTitle' => $material->title,
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran', 'url' => route('student.materials.index')],
                ['title' => $material->title]
            ],
            'material' => $material,
            'debugInfo' => [
                'material_id' => $material->id,
                'material_class_id' => $material->class_id,
                'material_class_name' => $material->class ? $material->class->name : null,
                'student_class_id' => $student ? $student->class_id : null,
                'student_class_name' => $student && $student->class ? $student->class->name : null,
            ]
        ]);
    }

    /**
     * Download the specified learning material
     */
    public function download($id)
    {
        // Get current student's class
        $userId = Auth::id();
        $student = \App\Models\Student::where('user_id', $userId)->first();
        
        $query = LearningMaterial::published();
        
        // Filter by student's class if student found
        if ($student && $student->class_id) {
            $query->forStudent($student->class_id);
        }
        
        $material = $query->findOrFail($id);

        // Check if file exists
        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        // Increment download count
        $material->incrementDownloads();

        // Log download activity (optional)
        \Log::info('Material downloaded', [
            'material_id' => $material->id,
            'material_title' => $material->title,
            'student_id' => Auth::id(),
            'student_name' => Auth::user()->name,
            'downloaded_at' => now()
        ]);

        // Return file download
        return Storage::disk('public')->download(
            $material->file_path, 
            $material->original_name ?? $material->file_name
        );
    }
}