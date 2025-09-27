<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Display a listing of quizzes for students
     */
    public function index(Request $request)
    {
        // Get current student's class
        $student = Student::where('user_id', Auth::id())->first();
        if (!$student || !$student->class_id) {
            // Create empty paginated collection
            $emptyQuizzes = new \Illuminate\Pagination\LengthAwarePaginator(
                collect(), // items
                0, // total
                12, // per page
                1, // current page
                ['path' => request()->url(), 'pageName' => 'page']
            );
            
            return view('student.quizzes.index', [
                'pageTitle' => 'Kuis & Ujian',
                'breadcrumb' => [['title' => 'Kuis & Ujian']],
                'quizzes' => $emptyQuizzes,
                'subjects' => collect(),
                'stats' => ['total_quizzes' => 0, 'completed' => 0, 'available' => 0, 'upcoming' => 0],
                'currentFilters' => ['subject' => null, 'status' => null],
                'message' => 'Anda belum terdaftar dalam kelas manapun. Silakan hubungi admin.'
            ]);
        }

        $query = Quiz::with(['teacher', 'class', 'attempts' => function($q) {
            $q->where('student_id', Auth::id());
        }])
        ->where('class_id', $student->class_id)
        ->where('status', 'published')
        ->latest();

        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->whereHas('attempts', function($q) {
                    $q->where('student_id', Auth::id())
                      ->where('status', 'completed');
                });
            } elseif ($request->status === 'available') {
                $query->where('start_time', '<=', now())
                      ->where('end_time', '>=', now())
                      ->whereDoesntHave('attempts', function($q) {
                          $q->where('student_id', Auth::id());
                      });
            }
        }

        $quizzes = $query->paginate(12);
        
        // Get filter options
        $subjects = Quiz::where('class_id', $student->class_id)
            ->where('status', 'published')
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        // Get statistics
        $stats = [
            'total_quizzes' => Quiz::where('class_id', $student->class_id)
                ->where('status', 'published')->count(),
            'completed' => QuizAttempt::where('student_id', Auth::id())
                ->whereHas('quiz', function($q) use ($student) {
                    $q->where('class_id', $student->class_id);
                })
                ->where('status', 'completed')->count(),
            'available' => Quiz::where('class_id', $student->class_id)
                ->where('status', 'published')
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->whereDoesntHave('attempts', function($q) {
                    $q->where('student_id', Auth::id());
                })->count(),
            'upcoming' => Quiz::where('class_id', $student->class_id)
                ->where('status', 'published')
                ->where('start_time', '>', now())->count(),
        ];

        return view('student.quizzes.index', [
            'pageTitle' => 'Kuis & Ujian',
            'breadcrumb' => [
                ['title' => 'Kuis & Ujian']
            ],
            'quizzes' => $quizzes,
            'subjects' => $subjects,
            'stats' => $stats,
            'currentFilters' => [
                'subject' => $request->subject,
                'status' => $request->status,
            ]
        ]);
    }

    /**
     * Display the specified quiz
     */
    public function show($id)
    {
        // Get current student's class
        $student = Student::where('user_id', Auth::id())->first();
        if (!$student || !$student->class_id) {
            abort(403, 'Anda belum terdaftar dalam kelas manapun.');
        }

        $quiz = Quiz::with(['teacher', 'class', 'questions', 'attempts' => function($q) {
            $q->where('student_id', Auth::id());
        }])
        ->where('class_id', $student->class_id)
        ->findOrFail($id);

        // Check if student has already attempted
        $attempt = $quiz->attempts->first();

        return view('student.quizzes.show', [
            'pageTitle' => $quiz->title,
            'breadcrumb' => [
                ['title' => 'Kuis & Ujian', 'url' => route('student.quizzes.index')],
                ['title' => $quiz->title]
            ],
            'quiz' => $quiz,
            'attempt' => $attempt
        ]);
    }

    /**
     * Start quiz attempt
     */
    public function start($id)
    {
        // Get current student's class
        $student = Student::where('user_id', Auth::id())->first();
        if (!$student || !$student->class_id) {
            abort(403, 'Anda belum terdaftar dalam kelas manapun.');
        }

        $quiz = Quiz::with('questions')
            ->where('class_id', $student->class_id)
            ->findOrFail($id);
        
        // Check if quiz is available
        if ($quiz->start_time > now()) {
            return redirect()->back()->with('error', 'Kuis belum dimulai!');
        }
        
        if ($quiz->end_time < now()) {
            return redirect()->back()->with('error', 'Waktu kuis sudah berakhir!');
        }

        // Check if already attempted
        $existingAttempt = QuizAttempt::where('quiz_id', $id)
            ->where('student_id', Auth::id())
            ->first();

        if ($existingAttempt) {
            return redirect()->back()->with('error', 'Anda sudah mengerjakan kuis ini!');
        }

        // Create new attempt
        $attempt = QuizAttempt::create([
            'quiz_id' => $id,
            'student_id' => Auth::id(),
            'started_at' => now(),
            'status' => 'in_progress'
        ]);

        return redirect()->route('student.quizzes.take', $attempt->id);
    }

    /**
     * Take quiz
     */
    public function take($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz.questions', 'answers'])
            ->where('id', $attemptId)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        if ($attempt->status === 'completed') {
            return redirect()->route('student.quizzes.result', $attemptId);
        }

        return view('student.quizzes.take', [
            'pageTitle' => 'Mengerjakan: ' . $attempt->quiz->title,
            'breadcrumb' => [
                ['title' => 'Kuis & Ujian', 'url' => route('student.quizzes.index')],
                ['title' => $attempt->quiz->title, 'url' => route('student.quizzes.show', $attempt->quiz_id)],
                ['title' => 'Mengerjakan']
            ],
            'attempt' => $attempt
        ]);
    }

    /**
     * Submit quiz answers
     */
    public function submit(Request $request, $attemptId)
    {
        $attempt = QuizAttempt::with(['quiz.questions'])
            ->where('id', $attemptId)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        if ($attempt->status === 'completed') {
            return redirect()->route('student.quizzes.result', $attemptId);
        }

        $answers = $request->input('answers', []);
        $totalScore = 0;
        $totalPoints = 0;
        $correctAnswers = 0;
        $totalQuestions = $attempt->quiz->questions->count();

        DB::transaction(function() use ($attempt, $answers, &$totalScore, &$totalPoints, &$correctAnswers, $totalQuestions) {
            foreach ($attempt->quiz->questions as $question) {
                $studentAnswer = $answers[$question->id] ?? null;
                $isCorrect = false;
                $pointsEarned = 0;
                
                // Auto-grade based on question type
                if ($question->type === 'multiple_choice' || $question->type === 'true_false') {
                    $isCorrect = $question->correct_answer === $studentAnswer;
                    $pointsEarned = $isCorrect ? $question->points : 0;
                    if ($isCorrect) {
                        $correctAnswers++;
                    }
                } elseif ($question->type === 'essay') {
                    // Essay questions need manual grading
                    $isCorrect = null; // Will be graded manually by teacher
                    $pointsEarned = 0; // Will be assigned by teacher
                }
                
                // Save the answer
                QuizAnswer::create([
                    'quiz_attempt_id' => $attempt->id,
                    'question_id' => $question->id,
                    'answer' => $studentAnswer,
                    'is_correct' => $isCorrect,
                    'points_earned' => $pointsEarned
                ]);
                
                $totalScore += $pointsEarned;
                $totalPoints += $question->points;
            }

            // Calculate final score percentage
            $finalScore = $totalPoints > 0 ? ($totalScore / $totalPoints) * 100 : 0;
            
            // Update attempt with results
            $attempt->update([
                'completed_at' => now(),
                'score' => $finalScore,
                'status' => 'completed'
            ]);
        });

        return redirect()->route('student.quizzes.result', $attemptId)
            ->with('success', 'Kuis berhasil diselesaikan! Skor Anda: ' . number_format($totalScore, 1) . '/' . $totalPoints . ' (' . $correctAnswers . '/' . $totalQuestions . ' benar)');
    }

    /**
     * Show quiz result
     */
    public function result($attemptId)
    {
        $attempt = QuizAttempt::with(['quiz', 'answers.question'])
            ->where('id', $attemptId)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        return view('student.quizzes.result', [
            'pageTitle' => 'Hasil: ' . $attempt->quiz->title,
            'breadcrumb' => [
                ['title' => 'Kuis & Ujian', 'url' => route('student.quizzes.index')],
                ['title' => $attempt->quiz->title, 'url' => route('student.quizzes.show', $attempt->quiz_id)],
                ['title' => 'Hasil']
            ],
            'attempt' => $attempt
        ]);
    }
}