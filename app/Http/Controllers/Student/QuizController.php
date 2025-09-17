<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
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
        $query = Quiz::with(['teacher', 'attempts' => function($q) {
            $q->where('student_id', Auth::id());
        }])
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
        $subjects = Quiz::where('status', 'published')
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        // Get statistics
        $stats = [
            'total_quizzes' => Quiz::where('status', 'published')->count(),
            'completed' => QuizAttempt::where('student_id', Auth::id())
                ->where('status', 'completed')->count(),
            'available' => Quiz::where('status', 'published')
                ->where('start_time', '<=', now())
                ->where('end_time', '>=', now())
                ->whereDoesntHave('attempts', function($q) {
                    $q->where('student_id', Auth::id());
                })->count(),
            'upcoming' => Quiz::where('status', 'published')
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
        $quiz = Quiz::with(['teacher', 'questions', 'attempts' => function($q) {
            $q->where('student_id', Auth::id());
        }])->findOrFail($id);

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
        $quiz = Quiz::with('questions')->findOrFail($id);
        
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
        $attempt = QuizAttempt::with('quiz')
            ->where('id', $attemptId)
            ->where('student_id', Auth::id())
            ->firstOrFail();

        if ($attempt->status === 'completed') {
            return redirect()->route('student.quizzes.result', $attemptId);
        }

        $answers = $request->input('answers', []);
        $score = 0;
        $totalQuestions = $attempt->quiz->questions()->count();

        DB::transaction(function() use ($attempt, $answers, &$score, $totalQuestions) {
            foreach ($answers as $questionId => $answer) {
                QuizAnswer::create([
                    'quiz_attempt_id' => $attempt->id,
                    'question_id' => $questionId,
                    'answer' => $answer
                ]);

                // Calculate score (simplified - you might want more complex scoring)
                $question = $attempt->quiz->questions()->find($questionId);
                if ($question && $question->correct_answer === $answer) {
                    $score++;
                }
            }

            // Update attempt
            $attempt->update([
                'completed_at' => now(),
                'score' => ($score / $totalQuestions) * 100,
                'status' => 'completed'
            ]);
        });

        return redirect()->route('student.quizzes.result', $attemptId)
            ->with('success', 'Kuis berhasil diselesaikan!');
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