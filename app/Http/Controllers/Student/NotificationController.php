<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Quiz;
use App\Models\AssignmentSubmission;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Get notifications for student (AJAX)
     */
    public function getNotifications()
    {
        $notifications = [];
        $studentId = Auth::id();

        try {
            // Get new assignments (published in last 7 days)
            $newAssignments = $this->getNewAssignments($studentId);
            foreach ($newAssignments as $assignment) {
                $notifications[] = [
                    'id' => 'assignment_new_' . $assignment->id,
                    'type' => 'assignment_new',
                    'title' => 'Tugas Baru: ' . $assignment->title,
                    'message' => 'Mata pelajaran: ' . $assignment->subject,
                    'time' => $assignment->created_at->diffForHumans(),
                    'url' => route('student.assignments.show', $assignment->id),
                    'icon' => '📝',
                    'color' => 'blue',
                    'is_read' => false
                ];
            }

            // Get assignment deadlines (due in next 3 days)
            $upcomingDeadlines = $this->getUpcomingDeadlines($studentId);
            foreach ($upcomingDeadlines as $assignment) {
                $daysLeft = now()->diffInDays($assignment->due_date);
                $hoursLeft = now()->diffInHours($assignment->due_date);
                
                if ($daysLeft == 0) {
                    $timeLeft = $hoursLeft . ' jam lagi';
                    $urgency = 'urgent';
                    $color = 'red';
                } elseif ($daysLeft == 1) {
                    $timeLeft = 'Besok';
                    $urgency = 'warning';
                    $color = 'yellow';
                } else {
                    $timeLeft = $daysLeft . ' hari lagi';
                    $urgency = 'normal';
                    $color = 'orange';
                }

                $notifications[] = [
                    'id' => 'assignment_deadline_' . $assignment->id,
                    'type' => 'assignment_deadline',
                    'title' => 'Deadline: ' . $assignment->title,
                    'message' => 'Batas waktu: ' . $timeLeft,
                    'time' => $assignment->due_date->format('d M Y, H:i'),
                    'url' => route('student.assignments.show', $assignment->id),
                    'icon' => '⏰',
                    'color' => $color,
                    'is_read' => false,
                    'urgency' => $urgency
                ];
            }

            // Get new quizzes (published in last 7 days)
            $newQuizzes = $this->getNewQuizzes($studentId);
            foreach ($newQuizzes as $quiz) {
                $notifications[] = [
                    'id' => 'quiz_new_' . $quiz->id,
                    'type' => 'quiz_new',
                    'title' => 'Kuis Baru: ' . $quiz->title,
                    'message' => 'Mata pelajaran: ' . $quiz->subject,
                    'time' => $quiz->created_at->diffForHumans(),
                    'url' => route('student.quizzes.show', $quiz->id),
                    'icon' => '📋',
                    'color' => 'green',
                    'is_read' => false
                ];
            }

            // Get graded assignments (graded in last 3 days)
            $gradedAssignments = $this->getGradedAssignments($studentId);
            foreach ($gradedAssignments as $submission) {
                $percentage = round(($submission->score / $submission->assignment->max_score) * 100, 1);
                
                $notifications[] = [
                    'id' => 'assignment_graded_' . $submission->id,
                    'type' => 'assignment_graded',
                    'title' => 'Tugas Dinilai: ' . $submission->assignment->title,
                    'message' => 'Nilai: ' . $submission->score . '/' . $submission->assignment->max_score . ' (' . $percentage . '%)',
                    'time' => $submission->graded_at->diffForHumans(),
                    'url' => route('student.assignments.show', $submission->assignment->id),
                    'icon' => '⭐',
                    'color' => $percentage >= 80 ? 'green' : ($percentage >= 60 ? 'yellow' : 'red'),
                    'is_read' => false
                ];
            }

            // Sort notifications by urgency and time
            $notifications = $this->sortNotifications($notifications);

            // Limit to 10 notifications
            $notifications = array_slice($notifications, 0, 10);

        } catch (\Exception $e) {
            // Fallback to mock data if database error
            $notifications = $this->getMockNotifications();
        }

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => count($notifications)
        ]);
    }

    /**
     * Get notification count (for badge)
     */
    public function getNotificationCount()
    {
        $studentId = Auth::id();
        $count = 0;

        try {
            // Count new assignments
            $count += $this->getNewAssignments($studentId)->count();

            // Count upcoming deadlines
            $count += $this->getUpcomingDeadlines($studentId)->count();

            // Count new quizzes
            $count += $this->getNewQuizzes($studentId)->count();

            // Count recent grades
            $count += $this->getGradedAssignments($studentId)->count();

        } catch (\Exception $e) {
            // Fallback count
            $count = 3;
        }

        return response()->json([
            'success' => true,
            'count' => min($count, 99) // Cap at 99
        ]);
    }

    /**
     * Get new assignments
     */
    private function getNewAssignments($studentId)
    {
        try {
            if (class_exists('App\Models\Assignment')) {
                return Assignment::whereIn('status', ['published', 'active'])
                    ->where('created_at', '>=', now()->subDays(7))
                    ->whereDoesntHave('submissions', function($q) use ($studentId) {
                        $q->where('student_id', $studentId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            }
        } catch (\Exception $e) {
            // Return empty collection if error
        }
        
        return collect();
    }

    /**
     * Get upcoming deadlines
     */
    private function getUpcomingDeadlines($studentId)
    {
        try {
            if (class_exists('App\Models\Assignment')) {
                return Assignment::whereIn('status', ['published', 'active'])
                    ->where('due_date', '>', now())
                    ->where('due_date', '<=', now()->addDays(3))
                    ->whereDoesntHave('submissions', function($q) use ($studentId) {
                        $q->where('student_id', $studentId);
                    })
                    ->orderBy('due_date', 'asc')
                    ->take(5)
                    ->get();
            }
        } catch (\Exception $e) {
            // Return empty collection if error
        }
        
        return collect();
    }

    /**
     * Get new quizzes
     */
    private function getNewQuizzes($studentId)
    {
        try {
            if (class_exists('App\Models\Quiz')) {
                return Quiz::whereIn('status', ['published', 'active'])
                    ->where('created_at', '>=', now()->subDays(7))
                    ->where('start_time', '<=', now())
                    ->where('end_time', '>=', now())
                    ->whereDoesntHave('attempts', function($q) use ($studentId) {
                        $q->where('student_id', $studentId);
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get();
            }
        } catch (\Exception $e) {
            // Return empty collection if error
        }
        
        return collect();
    }

    /**
     * Get graded assignments
     */
    private function getGradedAssignments($studentId)
    {
        try {
            if (class_exists('App\Models\AssignmentSubmission')) {
                return AssignmentSubmission::where('student_id', $studentId)
                    ->whereNotNull('graded_at')
                    ->where('graded_at', '>=', now()->subDays(3))
                    ->with('assignment')
                    ->orderBy('graded_at', 'desc')
                    ->take(3)
                    ->get();
            }
        } catch (\Exception $e) {
            // Return empty collection if error
        }
        
        return collect();
    }

    /**
     * Sort notifications by priority
     */
    private function sortNotifications($notifications)
    {
        usort($notifications, function($a, $b) {
            // Urgent notifications first
            if (isset($a['urgency']) && $a['urgency'] === 'urgent' && (!isset($b['urgency']) || $b['urgency'] !== 'urgent')) {
                return -1;
            }
            if (isset($b['urgency']) && $b['urgency'] === 'urgent' && (!isset($a['urgency']) || $a['urgency'] !== 'urgent')) {
                return 1;
            }
            
            // Then by type priority (deadlines > new items > grades)
            $typePriority = [
                'assignment_deadline' => 1,
                'quiz_deadline' => 1,
                'assignment_new' => 2,
                'quiz_new' => 2,
                'assignment_graded' => 3
            ];
            
            $aPriority = $typePriority[$a['type']] ?? 4;
            $bPriority = $typePriority[$b['type']] ?? 4;
            
            return $aPriority - $bPriority;
        });

        return $notifications;
    }

    /**
     * Get mock notifications for demo
     */
    private function getMockNotifications()
    {
        return [
            [
                'id' => 'mock_1',
                'type' => 'assignment_new',
                'title' => 'Tugas Baru: Matematika',
                'message' => 'Tugas Aljabar Linear telah ditambahkan',
                'time' => '5 menit yang lalu',
                'url' => '#',
                'icon' => '📝',
                'color' => 'blue',
                'is_read' => false
            ],
            [
                'id' => 'mock_2',
                'type' => 'assignment_deadline',
                'title' => 'Deadline Besok',
                'message' => 'Tugas Fisika harus dikumpulkan besok',
                'time' => '1 jam yang lalu',
                'url' => '#',
                'icon' => '⏰',
                'color' => 'red',
                'is_read' => false,
                'urgency' => 'urgent'
            ],
            [
                'id' => 'mock_3',
                'type' => 'quiz_new',
                'title' => 'Kuis Tersedia',
                'message' => 'Kuis Bahasa Indonesia sudah dapat dikerjakan',
                'time' => '2 jam yang lalu',
                'url' => '#',
                'icon' => '📋',
                'color' => 'green',
                'is_read' => false
            ]
        ];
    }
}