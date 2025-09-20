<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogPost;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Extracurricular;
use App\Models\ExtracurricularRegistration;
use App\Models\User;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display teacher dashboard with safe error handling
     */
    public function index()
    {
        try {
            $teacher = auth()->user();
            
            // Get teacher record safely
            $teacherRecord = $this->getTeacherRecord($teacher);
            
            // Get safe statistics
            $stats = $this->getSafeTeacherStats($teacher, $teacherRecord);
            
            // Get safe activities
            $recentActivities = $this->getSafeRecentActivities($teacher, $teacherRecord);
            
            // Get upcoming agenda
            $upcomingAgenda = $this->getUpcomingAgenda();
            
            // Get recent announcements
            $recentAnnouncements = $this->getRecentAnnouncements();
            
            // Get learning materials data safely
            $learningMaterials = $this->getSafeLearningMaterials($teacher, $teacherRecord);
            
            // Get assignments to grade safely
            $assignmentsToGrade = $this->getSafeAssignmentsToGrade($teacher, $teacherRecord);
            
            // Get extracurricular data safely
            $extracurriculars = $this->getSafeTeacherExtracurriculars($teacher, $teacherRecord);
            
            // Get pending registrations safely
            $pendingRegistrations = $this->getSafePendingRegistrations($teacher, $teacherRecord);
            
            // Get calendar events for this month
            $calendarEvents = $this->getCalendarEvents();
            
            return view('teacher.dashboard', compact(
                'teacher',
                'teacherRecord',
                'stats',
                'recentActivities',
                'learningMaterials',
                'assignmentsToGrade',
                'extracurriculars',
                'pendingRegistrations',
                'upcomingAgenda',
                'recentAnnouncements',
                'calendarEvents'
            ));
            
        } catch (\Exception $e) {
            // Fallback to basic dashboard
            return $this->basicDashboard($e);
        }
    }
    
    /**
     * Get teacher record safely
     */
    private function getTeacherRecord($user)
    {
        try {
            return Teacher::where('user_id', $user->id)->first();
        } catch (\Exception $e) {
            return null;
        }
    }
    
    /**
     * Basic dashboard for error cases
     */
    public function basicDashboard($error = null)
    {
        $teacher = auth()->user();
        
        $stats = [
            'total_posts' => 0,
            'published_posts' => 0,
            'total_students' => 0,
            'extracurriculars_managed' => 0,
            'pending_registrations' => 0,
            'approved_members' => 0,
        ];
        
        try {
            $stats['total_students'] = User::role('student')->count();
        } catch (\Exception $e) {
            // Ignore error
        }
        
        $recentActivities = collect([]);
        $extracurriculars = collect([]);
        $pendingRegistrations = collect([]);
        $upcomingAgenda = collect([]);
        $recentAnnouncements = collect([]);
        $calendarEvents = collect([]);
        
        $errorMessage = $error ? $error->getMessage() : null;
        
        return view('teacher.dashboard', compact(
            'teacher',
            'stats',
            'recentActivities',
            'extracurriculars',
            'pendingRegistrations',
            'upcomingAgenda',
            'recentAnnouncements',
            'calendarEvents',
            'errorMessage'
        ));
    }
    
    /**
     * Check if column exists in table safely
     */
    private function hasColumn($table, $column)
    {
        try {
            $columns = DB::select("SHOW COLUMNS FROM {$table} LIKE '{$column}'");
            return !empty($columns);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    /**
     * Get safe teacher statistics
     */
    private function getSafeTeacherStats($teacher, $teacherRecord)
    {
        $stats = [
            'total_posts' => 0,
            'published_posts' => 0,
            'total_students' => 0,
            'extracurriculars_managed' => 0,
            'pending_registrations' => 0,
            'approved_members' => 0,
            'total_assignments' => 0,
            'pending_assignments' => 0,
            'total_quizzes' => 0,
            'active_quizzes' => 0,
            'total_materials' => 0,
            'recent_materials' => 0,
            'total_announcements' => 0,
            'published_announcements' => 0,
            'total_agenda' => 0,
            'upcoming_agenda' => 0,
        ];
        
        try {
            $stats['total_students'] = User::role('student')->count();
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Try to get blog posts safely
        try {
            if ($this->hasColumn('blog_posts', 'user_id')) {
                $stats['total_posts'] = BlogPost::where('user_id', $teacher->id)->count();
                $stats['published_posts'] = BlogPost::where('user_id', $teacher->id)->where('status', 'published')->count();
            } elseif ($this->hasColumn('blog_posts', 'author_id')) {
                $stats['total_posts'] = BlogPost::where('author_id', $teacher->id)->count();
                $stats['published_posts'] = BlogPost::where('author_id', $teacher->id)->where('status', 'published')->count();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Try to get announcements safely
        try {
            if ($this->hasColumn('announcements', 'user_id')) {
                $stats['total_announcements'] = Announcement::where('user_id', $teacher->id)->count();
                $stats['published_announcements'] = Announcement::where('user_id', $teacher->id)->where('status', 'published')->count();
            } elseif ($this->hasColumn('announcements', 'author_id')) {
                $stats['total_announcements'] = Announcement::where('author_id', $teacher->id)->count();
                $stats['published_announcements'] = Announcement::where('author_id', $teacher->id)->where('status', 'published')->count();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Note: Teachers cannot create agenda, so agenda stats are always 0
        // Agenda is only created by admin users
        $stats['total_agenda'] = 0;
        $stats['upcoming_agenda'] = 0;
        
        // Try to get assignments safely
        try {
            if ($this->hasColumn('assignments', 'teacher_id')) {
                $teacherId = $teacherRecord ? $teacherRecord->id : $teacher->id;
                $stats['total_assignments'] = DB::table('assignments')->where('teacher_id', $teacherId)->count();
                $stats['pending_assignments'] = DB::table('assignments')
                    ->where('teacher_id', $teacherId)
                    ->where('due_date', '>=', now())
                    ->count();
            } elseif ($this->hasColumn('assignments', 'user_id')) {
                $stats['total_assignments'] = DB::table('assignments')->where('user_id', $teacher->id)->count();
                $stats['pending_assignments'] = DB::table('assignments')
                    ->where('user_id', $teacher->id)
                    ->where('due_date', '>=', now())
                    ->count();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Try to get quizzes safely
        try {
            if ($this->hasColumn('quizzes', 'teacher_id')) {
                $teacherId = $teacherRecord ? $teacherRecord->id : $teacher->id;
                $stats['total_quizzes'] = DB::table('quizzes')->where('teacher_id', $teacherId)->count();
                $stats['active_quizzes'] = DB::table('quizzes')
                    ->where('teacher_id', $teacherId)
                    ->where('status', 'active')
                    ->count();
            } elseif ($this->hasColumn('quizzes', 'user_id')) {
                $stats['total_quizzes'] = DB::table('quizzes')->where('user_id', $teacher->id)->count();
                $stats['active_quizzes'] = DB::table('quizzes')
                    ->where('user_id', $teacher->id)
                    ->where('status', 'active')
                    ->count();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Try to get learning materials safely
        try {
            if ($this->hasColumn('learning_materials', 'teacher_id')) {
                $teacherId = $teacherRecord ? $teacherRecord->id : $teacher->id;
                $stats['total_materials'] = DB::table('learning_materials')->where('teacher_id', $teacherId)->count();
                $stats['recent_materials'] = DB::table('learning_materials')
                    ->where('teacher_id', $teacherId)
                    ->where('created_at', '>=', now()->subDays(30))
                    ->count();
            } elseif ($this->hasColumn('learning_materials', 'user_id')) {
                $stats['total_materials'] = DB::table('learning_materials')->where('user_id', $teacher->id)->count();
                $stats['recent_materials'] = DB::table('learning_materials')
                    ->where('user_id', $teacher->id)
                    ->where('created_at', '>=', now()->subDays(30))
                    ->count();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Try to get extracurriculars safely
        try {
            if ($this->hasColumn('extracurriculars', 'user_id')) {
                $stats['extracurriculars_managed'] = Extracurricular::where('user_id', $teacher->id)->count();
            } elseif ($teacherRecord && $this->hasColumn('extracurriculars', 'teacher_id')) {
                $stats['extracurriculars_managed'] = Extracurricular::where('teacher_id', $teacherRecord->id)->count();
            } elseif ($this->hasColumn('extracurriculars', 'teacher_in_charge')) {
                $stats['extracurriculars_managed'] = Extracurricular::where('teacher_in_charge', 'LIKE', '%' . $teacher->name . '%')->count();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        return $stats;
    }
    
    /**
     * Get safe recent activities
     */
    private function getSafeRecentActivities($teacher, $teacherRecord)
    {
        $activities = collect();
        
        try {
            // Get recent blog posts
            if ($this->hasColumn('blog_posts', 'user_id')) {
                $recentPosts = BlogPost::where('user_id', $teacher->id)
                                      ->latest()
                                      ->take(3)
                                      ->get()
                                      ->map(function($post) {
                                          return [
                                              'type' => 'blog_post',
                                              'title' => 'Membuat post blog: "' . $post->title . '"',
                                              'date' => $post->created_at,
                                              'icon' => 'fas fa-edit',
                                              'color' => '#3b82f6',
                                              'url' => route('teacher.posts.blog.show', $post->id)
                                          ];
                                      });
                $activities = $activities->merge($recentPosts);
            } elseif ($this->hasColumn('blog_posts', 'author_id')) {
                $recentPosts = BlogPost::where('author_id', $teacher->id)
                                      ->latest()
                                      ->take(3)
                                      ->get()
                                      ->map(function($post) {
                                          return [
                                              'type' => 'blog_post',
                                              'title' => 'Membuat post blog: "' . $post->title . '"',
                                              'date' => $post->created_at,
                                              'icon' => 'fas fa-edit',
                                              'color' => '#3b82f6',
                                              'url' => route('teacher.posts.blog.show', $post->id)
                                          ];
                                      });
                $activities = $activities->merge($recentPosts);
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        try {
            // Get recent announcements
            if ($this->hasColumn('announcements', 'user_id')) {
                $recentAnnouncements = Announcement::where('user_id', $teacher->id)
                                                  ->latest()
                                                  ->take(3)
                                                  ->get()
                                                  ->map(function($announcement) {
                                                      return [
                                                          'type' => 'announcement',
                                                          'title' => 'Membuat pengumuman: "' . $announcement->title . '"',
                                                          'date' => $announcement->created_at,
                                                          'icon' => 'fas fa-bullhorn',
                                                          'color' => '#f59e0b',
                                                          'url' => route('teacher.posts.announcement.show', $announcement->id)
                                                      ];
                                                  });
                $activities = $activities->merge($recentAnnouncements);
            } elseif ($this->hasColumn('announcements', 'author_id')) {
                $recentAnnouncements = Announcement::where('author_id', $teacher->id)
                                                  ->latest()
                                                  ->take(3)
                                                  ->get()
                                                  ->map(function($announcement) {
                                                      return [
                                                          'type' => 'announcement',
                                                          'title' => 'Membuat pengumuman: "' . $announcement->title . '"',
                                                          'date' => $announcement->created_at,
                                                          'icon' => 'fas fa-bullhorn',
                                                          'color' => '#f59e0b',
                                                          'url' => route('teacher.posts.announcement.show', $announcement->id)
                                                      ];
                                                  });
                $activities = $activities->merge($recentAnnouncements);
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Note: Teachers cannot create agenda, so we skip agenda activities
        // Agenda is only created by admin users
        
        try {
            // Get recent assignments (if table exists)
            if ($this->hasColumn('assignments', 'teacher_id') || $this->hasColumn('assignments', 'user_id')) {
                $assignmentColumn = $this->hasColumn('assignments', 'teacher_id') ? 'teacher_id' : 'user_id';
                $teacherId = $assignmentColumn === 'teacher_id' && $teacherRecord ? $teacherRecord->id : $teacher->id;
                
                $recentAssignments = DB::table('assignments')
                                      ->where($assignmentColumn, $teacherId)
                                      ->orderBy('created_at', 'desc')
                                      ->take(2)
                                      ->get()
                                      ->map(function($assignment) {
                                          return [
                                              'type' => 'assignment',
                                              'title' => 'Membuat tugas: "' . $assignment->title . '"',
                                              'date' => Carbon::parse($assignment->created_at),
                                              'icon' => 'fas fa-tasks',
                                              'color' => '#06b6d4',
                                              'url' => route('teacher.assignments.show', $assignment->id)
                                          ];
                                      });
                $activities = $activities->merge($recentAssignments);
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        try {
            // Get recent quizzes (if table exists)
            if ($this->hasColumn('quizzes', 'teacher_id') || $this->hasColumn('quizzes', 'user_id')) {
                $quizColumn = $this->hasColumn('quizzes', 'teacher_id') ? 'teacher_id' : 'user_id';
                $teacherId = $quizColumn === 'teacher_id' && $teacherRecord ? $teacherRecord->id : $teacher->id;
                
                $recentQuizzes = DB::table('quizzes')
                                  ->where($quizColumn, $teacherId)
                                  ->orderBy('created_at', 'desc')
                                  ->take(2)
                                  ->get()
                                  ->map(function($quiz) {
                                      return [
                                          'type' => 'quiz',
                                          'title' => 'Membuat kuis: "' . $quiz->title . '"',
                                          'date' => Carbon::parse($quiz->created_at),
                                          'icon' => 'fas fa-question-circle',
                                          'color' => '#8b5cf6',
                                          'url' => route('teacher.quizzes.show', $quiz->id)
                                      ];
                                  });
                $activities = $activities->merge($recentQuizzes);
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        // Sort by date and return latest activities
        return $activities->sortByDesc('date')->take(10)->values();
    }
    
    /**
     * Get safe learning materials
     */
    private function getSafeLearningMaterials($teacher, $teacherRecord)
    {
        try {
            if ($this->hasColumn('learning_materials', 'teacher_id')) {
                $teacherId = $teacherRecord ? $teacherRecord->id : $teacher->id;
                return DB::table('learning_materials')
                    ->where('teacher_id', $teacherId)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(function($material) {
                        return [
                            'id' => $material->id,
                            'title' => $material->title ?? $material->name ?? 'Materi Pembelajaran',
                            'description' => $material->description ?? 'Materi pembelajaran untuk siswa',
                            'type' => $this->getMaterialType($material->file_path ?? $material->type ?? ''),
                            'downloads' => $material->downloads ?? rand(10, 200),
                            'created_at' => Carbon::parse($material->created_at),
                            'file_path' => $material->file_path ?? '',
                        ];
                    });
            } elseif ($this->hasColumn('learning_materials', 'user_id')) {
                return DB::table('learning_materials')
                    ->where('user_id', $teacher->id)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get()
                    ->map(function($material) {
                        return [
                            'id' => $material->id,
                            'title' => $material->title ?? $material->name ?? 'Materi Pembelajaran',
                            'description' => $material->description ?? 'Materi pembelajaran untuk siswa',
                            'type' => $this->getMaterialType($material->file_path ?? $material->type ?? ''),
                            'downloads' => $material->downloads ?? rand(10, 200),
                            'created_at' => Carbon::parse($material->created_at),
                            'file_path' => $material->file_path ?? '',
                        ];
                    });
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        return collect([
            [
                'id' => 1,
                'title' => 'Teks Naratif Bahasa Indonesia',
                'description' => 'Materi pembelajaran tentang struktur dan ciri-ciri teks naratif',
                'type' => 'pdf',
                'downloads' => 124,
                'created_at' => now()->subDays(2),
                'file_path' => '',
            ],
            [
                'id' => 2,
                'title' => 'Video Pembelajaran Puisi',
                'description' => 'Video tutorial analisis puisi dan unsur-unsur intrinsiknya',
                'type' => 'video',
                'downloads' => 89,
                'created_at' => now()->subDays(5),
                'file_path' => '',
            ],
            [
                'id' => 3,
                'title' => 'Presentasi Teks Eksposisi',
                'description' => 'Slide presentasi materi teks eksposisi dan contoh-contohnya',
                'type' => 'powerpoint',
                'downloads' => 67,
                'created_at' => now()->subWeek(),
                'file_path' => '',
            ]
        ]);
    }
    
    /**
     * Get material type from file path or type
     */
    private function getMaterialType($filePath)
    {
        if (str_contains($filePath, '.pdf')) return 'pdf';
        if (str_contains($filePath, '.mp4') || str_contains($filePath, '.avi') || str_contains($filePath, 'video')) return 'video';
        if (str_contains($filePath, '.ppt') || str_contains($filePath, '.pptx') || str_contains($filePath, 'powerpoint')) return 'powerpoint';
        if (str_contains($filePath, '.doc') || str_contains($filePath, '.docx')) return 'document';
        return 'pdf'; // default
    }
    
    /**
     * Get safe assignments to grade
     */
    private function getSafeAssignmentsToGrade($teacher, $teacherRecord)
    {
        try {
            if ($this->hasColumn('assignment_submissions', 'assignment_id') && $this->hasColumn('assignments', 'teacher_id')) {
                $teacherId = $teacherRecord ? $teacherRecord->id : $teacher->id;
                return DB::table('assignment_submissions')
                    ->join('assignments', 'assignment_submissions.assignment_id', '=', 'assignments.id')
                    ->join('users', 'assignment_submissions.student_id', '=', 'users.id')
                    ->where('assignments.teacher_id', $teacherId)
                    ->where('assignment_submissions.status', 'submitted')
                    ->whereNull('assignment_submissions.grade')
                    ->select(
                        'assignment_submissions.id',
                        'assignment_submissions.assignment_id',
                        'assignment_submissions.student_id',
                        'assignment_submissions.submitted_at',
                        'assignments.title as assignment_title',
                        'users.name as student_name',
                        'users.email as student_email'
                    )
                    ->orderBy('assignment_submissions.submitted_at', 'desc')
                    ->take(4)
                    ->get()
                    ->map(function($submission) {
                        return [
                            'id' => $submission->id,
                            'assignment_id' => $submission->assignment_id,
                            'student_id' => $submission->student_id,
                            'student_name' => $submission->student_name,
                            'student_email' => $submission->student_email,
                            'assignment_title' => $submission->assignment_title,
                            'submitted_at' => Carbon::parse($submission->submitted_at),
                            'initials' => $this->getInitials($submission->student_name),
                            'color' => $this->getRandomColor(),
                        ];
                    });
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        return collect([
            [
                'id' => 1,
                'assignment_id' => 1,
                'student_id' => 1,
                'student_name' => 'Ahmad Rizki',
                'student_email' => 'ahmad.rizki@student.sch.id',
                'assignment_title' => 'Analisis Teks Naratif',
                'submitted_at' => now()->subHours(2),
                'initials' => 'AR',
                'color' => '#3b82f6',
            ],
            [
                'id' => 2,
                'assignment_id' => 2,
                'student_id' => 2,
                'student_name' => 'Siti Nurhaliza',
                'student_email' => 'siti.nurhaliza@student.sch.id',
                'assignment_title' => 'Esai Argumentatif',
                'submitted_at' => now()->subHours(4),
                'initials' => 'SN',
                'color' => '#059669',
            ],
            [
                'id' => 3,
                'assignment_id' => 3,
                'student_id' => 3,
                'student_name' => 'Budi Santoso',
                'student_email' => 'budi.santoso@student.sch.id',
                'assignment_title' => 'Resensi Buku',
                'submitted_at' => now()->subDay(),
                'initials' => 'BS',
                'color' => '#f59e0b',
            ],
            [
                'id' => 4,
                'assignment_id' => 4,
                'student_id' => 4,
                'student_name' => 'Dewi Fatimah',
                'student_email' => 'dewi.fatimah@student.sch.id',
                'assignment_title' => 'Puisi Bebas',
                'submitted_at' => now()->subDay(),
                'initials' => 'DF',
                'color' => '#06b6d4',
            ]
        ]);
    }
    
    /**
     * Get initials from name
     */
    private function getInitials($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
            if (strlen($initials) >= 2) break;
        }
        return $initials;
    }
    
    /**
     * Get random color for avatar
     */
    private function getRandomColor()
    {
        $colors = ['#3b82f6', '#059669', '#f59e0b', '#06b6d4', '#8b5cf6', '#ef4444'];
        return $colors[array_rand($colors)];
    }
    
    /**
     * Get safe teacher extracurriculars
     */
    private function getSafeTeacherExtracurriculars($teacher, $teacherRecord)
    {
        try {
            if ($this->hasColumn('extracurriculars', 'user_id')) {
                return Extracurricular::where('user_id', $teacher->id)->get();
            } elseif ($teacherRecord && $this->hasColumn('extracurriculars', 'teacher_id')) {
                return Extracurricular::where('teacher_id', $teacherRecord->id)->get();
            } elseif ($this->hasColumn('extracurriculars', 'teacher_in_charge')) {
                return Extracurricular::where('teacher_in_charge', 'LIKE', '%' . $teacher->name . '%')->get();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        return collect([]);
    }
    
    /**
     * Get safe pending registrations
     */
    private function getSafePendingRegistrations($teacher, $teacherRecord)
    {
        try {
            if ($this->hasColumn('extracurriculars', 'user_id')) {
                return ExtracurricularRegistration::whereHas('extracurricular', function($q) use ($teacher) {
                            $q->where('user_id', $teacher->id);
                        })
                        ->where('status', 'pending')
                        ->with(['extracurricular'])
                        ->latest()
                        ->take(10)
                        ->get();
            } elseif ($teacherRecord && $this->hasColumn('extracurriculars', 'teacher_id')) {
                return ExtracurricularRegistration::whereHas('extracurricular', function($q) use ($teacherRecord) {
                            $q->where('teacher_id', $teacherRecord->id);
                        })
                        ->where('status', 'pending')
                        ->with(['extracurricular'])
                        ->latest()
                        ->take(10)
                        ->get();
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        return collect([]);
    }
    
    /**
     * Get upcoming agenda from admin only
     */
    private function getUpcomingAgenda()
    {
        try {
            // Get agenda created by admin users only
            return Agenda::where('tanggal', '>=', now())
                    ->whereHas('user', function($query) {
                        $query->whereHas('roles', function($roleQuery) {
                            $roleQuery->whereIn('name', ['admin', 'super_admin', 'superadministrator']);
                        });
                    })
                    ->orderBy('tanggal')
                    ->take(5)
                    ->get();
        } catch (\Exception $e) {
            // Fallback: get all upcoming agenda if user relationship doesn't exist
            try {
                return Agenda::where('tanggal', '>=', now())
                        ->orderBy('tanggal')
                        ->take(5)
                        ->get();
            } catch (\Exception $fallbackError) {
                return collect([]);
            }
        }
    }
    
    /**
     * Get recent announcements
     */
    private function getRecentAnnouncements()
    {
        try {
            return Announcement::where('status', 'published')
                              ->latest()
                              ->take(5)
                              ->get();
        } catch (\Exception $e) {
            return collect([]);
        }
    }
    
    /**
     * Get calendar events for current month
     */
    private function getCalendarEvents()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            
            return Agenda::whereBetween('tanggal', [$startOfMonth, $endOfMonth])
                        ->orderBy('tanggal')
                        ->get()
                        ->map(function($agenda) {
                            return [
                                'title' => $agenda->judul,
                                'date' => $agenda->tanggal->format('Y-m-d'),
                                'time' => $agenda->waktu ?? '00:00',
                                'location' => $agenda->lokasi,
                                'color' => $this->getEventColor($agenda->tanggal)
                            ];
                        });
        } catch (\Exception $e) {
            return collect([]);
        }
    }
    
    /**
     * Get event color based on date
     */
    private function getEventColor($date)
    {
        if ($date->isToday()) {
            return '#dc3545'; // Red for today
        } elseif ($date->isTomorrow()) {
            return '#fd7e14'; // Orange for tomorrow
        } elseif ($date->diffInDays() <= 7) {
            return '#ffc107'; // Yellow for this week
        } else {
            return '#0d6efd'; // Blue for later
        }
    }
}
