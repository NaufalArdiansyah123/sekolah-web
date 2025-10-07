<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\AttendanceSession;
use App\Models\Attendance;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Get current student info for debugging
            $student = \App\Models\Student::where('user_id', auth()->id())->with('class')->first();
            
            // Get statistics for student dashboard with error handling
            $stats = [
                'total_materials' => $this->safeCount(LearningMaterial::class, 'published'),
                'recent_materials' => $this->safeCount(LearningMaterial::class, 'recent'),
                'categories' => $this->safeCount(LearningMaterial::class, 'categories'),
                'total_downloads' => $this->safeSum(LearningMaterial::class, 'downloads'),
                'total_assignments' => $this->getAssignmentStats('total'),
                'pending_assignments' => $this->getAssignmentStats('pending'),
                'attendance_percentage' => $this->getAttendancePercentage(),
                'total_attendance_sessions' => $this->getAttendanceStats('total'),
                'available_quizzes' => $this->getQuizStats('available'),
                'completed_quizzes' => $this->getQuizStats('completed'),
            ];
            
            // Debug info for troubleshooting
            $debugInfo = [
                'user_id' => auth()->id(),
                'student_found' => $student ? true : false,
                'student_class_id' => $student ? $student->class_id : null,
                'student_class_name' => $student && $student->class ? $student->class->name : null,
            ];

            // Get recent materials with error handling
            $recentMaterials = $this->getRecentMaterials();
            
            // Get recent assignments and quizzes
            $recentAssignments = $this->getRecentAssignments();
            $recentQuizzes = $this->getRecentQuizzes();

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            
            // Fallback data
            $stats = [
                'total_materials' => 0,
                'recent_materials' => 0,
                'categories' => 0,
                'total_downloads' => 0,
                'total_assignments' => 0,
                'pending_assignments' => 0,
                'attendance_percentage' => 0,
                'total_attendance_sessions' => 0,
                'available_quizzes' => 0,
                'completed_quizzes' => 0,
            ];
            $recentMaterials = collect();
            $recentAssignments = collect();
            $recentQuizzes = collect();
            $debugInfo = [
                'user_id' => auth()->id(),
                'student_found' => false,
                'student_class_id' => null,
                'student_class_name' => null,
                'error' => $e->getMessage()
            ];
        }

        return view('student.dashboard', [
            'pageTitle' => 'Dashboard Siswa',
            'breadcrumb' => [],
            'stats' => $stats,
            'recentMaterials' => $recentMaterials,
            'recentAssignments' => $recentAssignments,
            'recentQuizzes' => $recentQuizzes,
            'debugInfo' => $debugInfo
        ]);
    }

    /**
     * Safely count records with error handling
     */
    private function safeCount($model, $type = 'all')
    {
        try {
            // Get current student's class for filtering
            $userId = auth()->id();
            $student = \App\Models\Student::where('user_id', $userId)->first();
            
            switch ($type) {
                case 'published':
                    $query = $model::published();
                    if ($student && $student->class_id && $model === LearningMaterial::class) {
                        $query->forStudent($student->class_id);
                    }
                    return $query->count();
                    
                case 'recent':
                    $query = $model::published()->where('created_at', '>=', now()->subDays(7));
                    if ($student && $student->class_id && $model === LearningMaterial::class) {
                        $query->forStudent($student->class_id);
                    }
                    return $query->count();
                    
                case 'categories':
                    $query = $model::published();
                    if ($student && $student->class_id && $model === LearningMaterial::class) {
                        $query->forStudent($student->class_id);
                    }
                    return $query->distinct('subject')->count('subject');
                    
                default:
                    return $model::count();
            }
        } catch (\Exception $e) {
            Log::warning("Failed to count {$model} ({$type}): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get quiz statistics
     */
    private function getQuizStats($type = 'available')
    {
        try {
            $userId = auth()->id();
            
            // Get current student's class
            $student = \App\Models\Student::where('user_id', $userId)->first();
            if (!$student || !$student->class_id) {
                return 0;
            }
            
            switch ($type) {
                case 'available':
                    return Quiz::where('status', 'published')
                        ->where('class_id', $student->class_id)
                        ->where('start_time', '<=', now())
                        ->where('end_time', '>=', now())
                        ->whereDoesntHave('attempts', function($q) use ($userId) {
                            $q->where('student_id', $userId);
                        })
                        ->count();
                        
                case 'completed':
                    return QuizAttempt::where('student_id', $userId)
                        ->where('status', 'completed')
                        ->whereHas('quiz', function($q) use ($student) {
                            $q->where('class_id', $student->class_id);
                        })
                        ->count();
                        
                case 'upcoming':
                    return Quiz::where('status', 'published')
                        ->where('class_id', $student->class_id)
                        ->where('start_time', '>', now())
                        ->count();
                        
                default:
                    return 0;
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get quiz stats ({$type}): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Safely sum records with error handling
     */
    private function safeSum($model, $column)
    {
        try {
            if (method_exists($model, 'published')) {
                return $model::published()->sum($column) ?? 0;
            }
            return $model::where('status', 'published')->sum($column) ?? 0;
        } catch (\Exception $e) {
            Log::warning("Failed to sum {$model}.{$column}: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get recent materials with error handling
     */
    private function getRecentMaterials()
    {
        try {
            if (class_exists('App\Models\LearningMaterial')) {
                $userId = auth()->id();
                $student = \App\Models\Student::where('user_id', $userId)->first();
                
                $query = LearningMaterial::with(['teacher', 'class'])
                    ->published()
                    ->latest();
                
                // Filter by student's class if student found
                if ($student && $student->class_id) {
                    $query->forStudent($student->class_id);
                }
                
                return $query->take(6)->get();
            }
            
            // Fallback to mock data
            return collect([
                (object) [
                    'id' => 1,
                    'title' => 'Materi Matematika - Aljabar',
                    'subject' => 'Matematika',
                    'formatted_file_size' => '2.5 MB',
                    'created_at' => now()->subDays(1)
                ],
                (object) [
                    'id' => 2,
                    'title' => 'Materi Fisika - Gerak Lurus',
                    'subject' => 'Fisika',
                    'formatted_file_size' => '1.8 MB',
                    'created_at' => now()->subDays(2)
                ],
                (object) [
                    'id' => 3,
                    'title' => 'Materi Kimia - Tabel Periodik',
                    'subject' => 'Kimia',
                    'formatted_file_size' => '3.2 MB',
                    'created_at' => now()->subDays(3)
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::warning('Failed to get recent materials: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get recent assignments with error handling
     */
    private function getRecentAssignments()
    {
        try {
            $userId = auth()->id();
            
            // Get current student's class
            $student = \App\Models\Student::where('user_id', $userId)->first();
            if (!$student || !$student->class_id) {
                return collect();
            }
            
            // Get assignments that haven't been submitted by current user and are still active
            $submittedAssignmentIds = AssignmentSubmission::where('student_id', $userId)
                ->pluck('assignment_id')
                ->toArray();
            
            return Assignment::with(['teacher', 'class'])
                ->where('class_id', $student->class_id) // Filter by student's class
                ->whereIn('status', ['published', 'active']) // Only published assignments
                ->whereNotIn('id', $submittedAssignmentIds)
                ->where('due_date', '>=', now())
                ->latest('created_at')
                ->take(3)
                ->get()
                ->map(function($assignment) {
                    // Add formatted due date
                    $assignment->formatted_due_date = $assignment->due_date->format('d M Y');
                    $assignment->days_left = now()->diffInDays($assignment->due_date, false);
                    return $assignment;
                });
            
        } catch (\Exception $e) {
            Log::warning('Failed to get recent assignments: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get recent quizzes with error handling
     */
    private function getRecentQuizzes()
    {
        try {
            $userId = auth()->id();
            
            // Get current student's class
            $student = \App\Models\Student::where('user_id', $userId)->first();
            if (!$student || !$student->class_id) {
                return collect();
            }
            
            // Get available quizzes that haven't been attempted by current user
            return Quiz::where('status', 'published')
                ->where('class_id', $student->class_id) // Filter by student's class
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->whereDoesntHave('attempts', function($q) use ($userId) {
                    $q->where('student_id', $userId);
                })
                ->with(['teacher', 'class'])
                ->latest('created_at')
                ->take(3)
                ->get()
                ->map(function($quiz) {
                    // Add formatted dates and time left
                    $quiz->formatted_end_time = $quiz->end_time->format('d M Y H:i');
                    $quiz->hours_left = now()->diffInHours($quiz->end_time, false);
                    return $quiz;
                });
            
        } catch (\Exception $e) {
            Log::warning('Failed to get recent quizzes: ' . $e->getMessage());
            return collect();
        }
    }

    /**
     * Get assignment statistics
     */
    private function getAssignmentStats($type = 'total')
    {
        try {
            $userId = auth()->id();
            
            // Get current student's class
            $student = \App\Models\Student::where('user_id', $userId)->first();
            if (!$student || !$student->class_id) {
                return 0;
            }
            
            switch ($type) {
                case 'total':
                    return Assignment::where('class_id', $student->class_id)
                        ->whereIn('status', ['published', 'active'])
                        ->count();
                    
                case 'pending':
                    // Get assignments that haven't been submitted by current user
                    $submittedAssignmentIds = AssignmentSubmission::where('student_id', $userId)
                        ->pluck('assignment_id')
                        ->toArray();
                    
                    return Assignment::where('class_id', $student->class_id)
                        ->whereIn('status', ['published', 'active'])
                        ->whereNotIn('id', $submittedAssignmentIds)
                        ->where('due_date', '>=', now())
                        ->count();
                        
                case 'submitted':
                    return AssignmentSubmission::where('student_id', $userId)
                        ->whereHas('assignment', function($q) use ($student) {
                            $q->where('class_id', $student->class_id);
                        })
                        ->count();
                    
                default:
                    return 0;
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get assignment stats ({$type}): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get attendance statistics
     */
    private function getAttendanceStats($type = 'total')
    {
        try {
            $userId = auth()->id();
            
            switch ($type) {
                case 'total':
                    return AttendanceSession::count();
                    
                case 'present':
                    return Attendance::where('student_id', $userId)
                        ->where('status', 'present')
                        ->count();
                        
                case 'absent':
                    return Attendance::where('student_id', $userId)
                        ->where('status', 'absent')
                        ->count();
                        
                default:
                    return 0;
            }
        } catch (\Exception $e) {
            Log::warning("Failed to get attendance stats ({$type}): " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get attendance percentage
     */
    private function getAttendancePercentage()
    {
        try {
            $userId = auth()->id();
            
            $totalSessions = AttendanceSession::count();
            if ($totalSessions == 0) {
                return 0;
            }
            
            $presentCount = Attendance::where('student_id', $userId)
                ->where('status', 'present')
                ->count();
                
            return round(($presentCount / $totalSessions) * 100, 1);
        } catch (\Exception $e) {
            Log::warning("Failed to get attendance percentage: " . $e->getMessage());
            return 0;
        }
    }

    public function materials(Request $request)
    {
        try {
            // Get current student's class
            $userId = auth()->id();
            $student = \App\Models\Student::where('user_id', $userId)->first();
            
            $query = LearningMaterial::with(['teacher', 'class'])->published();
            
            // Filter by student's class if student found
            if ($student && $student->class_id) {
                $query->forStudent($student->class_id);
            }

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
                $query->where('subject', $request->category);
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
                    $query->orderBy('downloads', 'desc');
                    break;
                default:
                    $query->latest();
            }

            $materials = $query->paginate(12);
            
            // Get categories for filter
            $categories = LearningMaterial::published()
                ->select('subject')
                ->distinct()
                ->orderBy('subject')
                ->pluck('subject');

        } catch (\Exception $e) {
            Log::error('Materials error: ' . $e->getMessage());
            $materials = collect()->paginate(12);
            $categories = collect();
        }

        return view('student.materials.index', [
            'pageTitle' => 'Materi Pembelajaran',
            'breadcrumb' => [
                ['title' => 'Materi Pembelajaran']
            ],
            'materials' => $materials,
            'categories' => $categories
        ]);
    }

    public function downloadMaterial($id)
    {
        try {
            $material = LearningMaterial::findOrFail($id);

            // Check if file exists
            if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
                return redirect()->back()->with('error', 'File tidak ditemukan!');
            }

            // Increment download count
            $material->increment('downloads');

            // Return file download
            return Storage::disk('public')->download(
                $material->file_path, 
                $material->original_name ?? $material->file_name
            );
            
        } catch (\Exception $e) {
            Log::error('Download error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengunduh file!');
        }
    }

    public function showMaterial($id)
    {
        try {
            $material = LearningMaterial::with('teacher')->findOrFail($id);

            return view('student.materials.show', [
                'pageTitle' => $material->title,
                'breadcrumb' => [
                    ['title' => 'Materi Pembelajaran', 'url' => route('student.materials.index')],
                    ['title' => $material->title]
                ],
                'material' => $material
            ]);
            
        } catch (\Exception $e) {
            Log::error('Show material error: ' . $e->getMessage());
            return redirect()->route('student.materials.index')
                           ->with('error', 'Materi tidak ditemukan!');
        }
    }
}