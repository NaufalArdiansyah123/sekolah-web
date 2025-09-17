<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for student dashboard
        $stats = [
            'total_materials' => LearningMaterial::published()->count(),
            'recent_materials' => LearningMaterial::published()->where('created_at', '>=', now()->subDays(7))->count(),
            'categories' => LearningMaterial::published()->distinct('subject')->count('subject'),
            'total_downloads' => LearningMaterial::published()->sum('downloads'),
        ];

        // Get recent materials
        $recentMaterials = LearningMaterial::with('teacher')
            ->published()
            ->latest()
            ->take(6)
            ->get();

        return view('student.dashboard', [
            'pageTitle' => 'Dashboard Siswa',
            'breadcrumb' => [],
            'stats' => $stats,
            'recentMaterials' => $recentMaterials
        ]);
    }

    public function materials(Request $request)
    {
        $query = Download::active();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('file_name', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Sorting
        switch ($request->get('sort', 'latest')) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name':
                $query->orderBy('title');
                break;
            case 'downloads':
                $query->orderBy('download_count', 'desc');
                break;
            case 'size':
                $query->orderBy('file_size', 'desc');
                break;
            default:
                $query->latest();
        }

        $materials = $query->paginate(12);
        
        // Get categories for filter
        $categories = Download::active()
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('student.materials.index', [
            'pageTitle' => 'Materi Pembelajaran',
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran']
            ],
            'materials' => $materials,
            'categories' => $categories
        ]);
    }

    public function downloadMaterial(Download $material)
    {
        // Check if file exists
        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            return redirect()->back()->with('error', 'File tidak ditemukan!');
        }

        // Increment download count
        $material->incrementDownloadCount();

        // Return file download
        return Storage::disk('public')->download($material->file_path, $material->file_name);
    }

    public function showMaterial(Download $material)
    {
        return view('student.materials.show', [
            'pageTitle' => $material->title,
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran', 'url' => route('student.materials')],
                ['title' => $material->title]
            ],
            'material' => $material
        ]);
    }
}
