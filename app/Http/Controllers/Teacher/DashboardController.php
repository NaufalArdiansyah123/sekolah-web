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
            // Try to get recent posts
            if ($this->hasColumn('blog_posts', 'user_id')) {
                $recentPosts = BlogPost::where('user_id', $teacher->id)
                                      ->latest()
                                      ->take(5)
                                      ->get()
                                      ->map(function($post) {
                                          return [
                                              'type' => 'post',
                                              'title' => 'Membuat post: ' . $post->title,
                                              'date' => $post->created_at,
                                              'icon' => 'fas fa-edit',
                                              'color' => 'primary',
                                              'url' => '#'
                                          ];
                                      });
                $activities = $activities->merge($recentPosts);
            } elseif ($this->hasColumn('blog_posts', 'author_id')) {
                $recentPosts = BlogPost::where('author_id', $teacher->id)
                                      ->latest()
                                      ->take(5)
                                      ->get()
                                      ->map(function($post) {
                                          return [
                                              'type' => 'post',
                                              'title' => 'Membuat post: ' . $post->title,
                                              'date' => $post->created_at,
                                              'icon' => 'fas fa-edit',
                                              'color' => 'primary',
                                              'url' => '#'
                                          ];
                                      });
                $activities = $activities->merge($recentPosts);
            }
        } catch (\Exception $e) {
            // Ignore error
        }
        
        return $activities->take(10)->values();
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
     * Get upcoming agenda
     */
    private function getUpcomingAgenda()
    {
        try {
            return Agenda::where('tanggal', '>=', now())
                    ->orderBy('tanggal')
                    ->take(5)
                    ->get();
        } catch (\Exception $e) {
            return collect([]);
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
