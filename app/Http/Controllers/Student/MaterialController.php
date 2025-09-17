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
        $query = LearningMaterial::with('teacher')
                                ->published()
                                ->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        // Subject filter
        if ($request->filled('subject')) {
            $query->bySubject($request->subject);
        }

        // Class filter
        if ($request->filled('class')) {
            $query->byClass($request->class);
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
        
        // Get filter options
        $subjects = LearningMaterial::published()
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        $classes = LearningMaterial::published()
            ->select('class')
            ->distinct()
            ->orderBy('class')
            ->pluck('class');

        $types = [
            'document' => 'Dokumen',
            'video' => 'Video',
            'presentation' => 'Presentasi',
            'exercise' => 'Latihan',
            'audio' => 'Audio'
        ];

        // Get statistics
        $stats = [
            'total_materials' => LearningMaterial::published()->count(),
            'total_downloads' => LearningMaterial::published()->sum('downloads'),
            'subjects_count' => $subjects->count(),
            'recent_materials' => LearningMaterial::published()->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        return view('student.materials.index', [
            'pageTitle' => 'Materi Pembelajaran',
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran']
            ],
            'materials' => $materials,
            'subjects' => $subjects,
            'classes' => $classes,
            'types' => $types,
            'stats' => $stats,
            'currentFilters' => [
                'search' => $request->search,
                'subject' => $request->subject,
                'class' => $request->class,
                'type' => $request->type,
                'sort' => $request->get('sort', 'latest')
            ]
        ]);
    }

    /**
     * Display the specified learning material
     */
    public function show($id)
    {
        $material = LearningMaterial::with('teacher')
                                   ->published()
                                   ->findOrFail($id);

        return view('student.materials.show', [
            'pageTitle' => $material->title,
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran', 'url' => route('student.materials.index')],
                ['title' => $material->title]
            ],
            'material' => $material
        ]);
    }

    /**
     * Download the specified learning material
     */
    public function download($id)
    {
        $material = LearningMaterial::published()->findOrFail($id);

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