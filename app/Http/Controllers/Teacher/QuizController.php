<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizAttempt;
use App\Models\QuizAnswer;
use App\Models\Classes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    /**
     * Display a listing of quizzes for teachers
     */
    public function index(Request $request)
    {
        $query = Quiz::with(['teacher', 'questions', 'class'])
            ->where('teacher_id', Auth::id())
            ->latest();

        // Filter by subject
        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quizzes = $query->paginate(12);
        
        // Get filter options
        $subjects = Quiz::where('teacher_id', Auth::id())
            ->select('subject')
            ->distinct()
            ->orderBy('subject')
            ->pluck('subject');

        // Get statistics
        $stats = [
            'total_quizzes' => Quiz::where('teacher_id', Auth::id())->count(),
            'published' => Quiz::where('teacher_id', Auth::id())->where('status', 'published')->count(),
            'draft' => Quiz::where('teacher_id', Auth::id())->where('status', 'draft')->count(),
            'total_attempts' => QuizAttempt::whereHas('quiz', function($q) {
                $q->where('teacher_id', Auth::id());
            })->count(),
        ];

        return view('teacher.quizzes.index', [
            'pageTitle' => 'Kelola Kuis',
            'breadcrumb' => [
                ['title' => 'Kelola Kuis']
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
     * Show the form for creating a new quiz
     */
    public function create()
    {
        $classes = Classes::active()->orderBy('level')->orderBy('name')->get();
        
        return view('teacher.quizzes.create', [
            'pageTitle' => 'Buat Kuis Baru',
            'breadcrumb' => [
                ['title' => 'Kelola Kuis', 'url' => route('teacher.quizzes.index')],
                ['title' => 'Buat Kuis Baru']
            ],
            'classes' => $classes
        ]);
    }

    /**
     * Store a newly created quiz in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'class_id' => 'required|exists:classes,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1|max:300',
            'max_attempts' => 'required|integer|min:1|max:10',
            'instructions' => 'nullable|string',
            'show_results' => 'boolean',
            'randomize_questions' => 'boolean',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,true_false,essay',
            'questions.*.options' => 'required_if:questions.*.type,multiple_choice|array|min:2',
            'questions.*.correct_answer' => 'required',
            'questions.*.points' => 'required|numeric|min:1',
        ]);

        DB::transaction(function() use ($request) {
            $quiz = Quiz::create([
                'title' => $request->title,
                'description' => $request->description,
                'subject' => $request->subject,
                'class_id' => $request->class_id,
                'teacher_id' => Auth::id(),
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'duration_minutes' => $request->duration_minutes,
                'max_attempts' => $request->max_attempts,
                'status' => 'draft',
                'instructions' => $request->instructions,
                'show_results' => $request->boolean('show_results'),
                'randomize_questions' => $request->boolean('randomize_questions'),
            ]);

            foreach ($request->questions as $index => $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'options' => $questionData['options'] ?? null,
                    'correct_answer' => $questionData['correct_answer'],
                    'points' => $questionData['points'],
                    'order' => $index + 1,
                ]);
            }
        });

        return redirect()->route('teacher.quizzes.index')
            ->with('success', 'Kuis berhasil dibuat!');
    }

    /**
     * Display the specified quiz
     */
    public function show($id)
    {
        $quiz = Quiz::with(['teacher', 'questions', 'attempts.student'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);

        // Get attempts statistics
        $attemptStats = [
            'total_attempts' => $quiz->attempts->count(),
            'completed_attempts' => $quiz->attempts->where('status', 'completed')->count(),
            'in_progress' => $quiz->attempts->where('status', 'in_progress')->count(),
            'average_score' => $quiz->attempts->where('status', 'completed')->avg('score') ?? 0,
        ];

        return view('teacher.quizzes.show', [
            'pageTitle' => $quiz->title,
            'breadcrumb' => [
                ['title' => 'Kelola Kuis', 'url' => route('teacher.quizzes.index')],
                ['title' => $quiz->title]
            ],
            'quiz' => $quiz,
            'attemptStats' => $attemptStats
        ]);
    }

    /**
     * Show the form for editing the specified quiz
     */
    public function edit($id)
    {
        $quiz = Quiz::with(['questions', 'class'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);
        
        $classes = Classes::active()->orderBy('level')->orderBy('name')->get();

        return view('teacher.quizzes.edit', [
            'pageTitle' => 'Edit Kuis: ' . $quiz->title,
            'breadcrumb' => [
                ['title' => 'Kelola Kuis', 'url' => route('teacher.quizzes.index')],
                ['title' => $quiz->title, 'url' => route('teacher.quizzes.show', $id)],
                ['title' => 'Edit']
            ],
            'quiz' => $quiz,
            'classes' => $classes
        ]);
    }

    /**
     * Update the specified quiz in storage
     */
    public function update(Request $request, $id)
    {
        $quiz = Quiz::where('teacher_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string|max:100',
            'class_id' => 'required|exists:classes,id',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1|max:300',
            'max_attempts' => 'required|integer|min:1|max:10',
            'instructions' => 'nullable|string',
            'show_results' => 'boolean',
            'randomize_questions' => 'boolean',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'subject' => $request->subject,
            'class_id' => $request->class_id,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_minutes' => $request->duration_minutes,
            'max_attempts' => $request->max_attempts,
            'instructions' => $request->instructions,
            'show_results' => $request->boolean('show_results'),
            'randomize_questions' => $request->boolean('randomize_questions'),
        ]);

        return redirect()->route('teacher.quizzes.show', $id)
            ->with('success', 'Kuis berhasil diperbarui!');
    }

    /**
     * Remove the specified quiz from storage
     */
    public function destroy($id)
    {
        $quiz = Quiz::where('teacher_id', Auth::id())->findOrFail($id);
        
        // Check if quiz has attempts
        if ($quiz->attempts()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Tidak dapat menghapus kuis yang sudah dikerjakan siswa!');
        }

        $quiz->delete();

        return redirect()->route('teacher.quizzes.index')
            ->with('success', 'Kuis berhasil dihapus!');
    }

    /**
     * Publish quiz
     */
    public function publish($id)
    {
        $quiz = Quiz::where('teacher_id', Auth::id())->findOrFail($id);
        
        // Validate quiz has questions
        if ($quiz->questions()->count() === 0) {
            return redirect()->back()
                ->with('error', 'Kuis harus memiliki minimal 1 soal untuk dipublikasi!');
        }

        $quiz->update(['status' => 'published']);

        return redirect()->back()
            ->with('success', 'Kuis berhasil dipublikasi!');
    }

    /**
     * Unpublish quiz
     */
    public function unpublish($id)
    {
        $quiz = Quiz::where('teacher_id', Auth::id())->findOrFail($id);
        $quiz->update(['status' => 'draft']);

        return redirect()->back()
            ->with('success', 'Kuis berhasil di-unpublish!');
    }

    /**
     * View quiz attempts
     */
    public function attempts($id)
    {
        $quiz = Quiz::with(['attempts.student', 'attempts.answers.question'])
            ->where('teacher_id', Auth::id())
            ->findOrFail($id);

        $attempts = $quiz->attempts()
            ->with(['student', 'answers.question'])
            ->latest()
            ->paginate(20);

        return view('teacher.quizzes.attempts', [
            'pageTitle' => 'Hasil Kuis: ' . $quiz->title,
            'breadcrumb' => [
                ['title' => 'Kelola Kuis', 'url' => route('teacher.quizzes.index')],
                ['title' => $quiz->title, 'url' => route('teacher.quizzes.show', $id)],
                ['title' => 'Hasil Kuis']
            ],
            'quiz' => $quiz,
            'attempts' => $attempts
        ]);
    }

    /**
     * View specific attempt details
     */
    public function attemptDetail($quizId, $attemptId)
    {
        $quiz = Quiz::where('teacher_id', Auth::id())->findOrFail($quizId);
        
        $attempt = QuizAttempt::with(['student', 'answers.question'])
            ->where('quiz_id', $quizId)
            ->findOrFail($attemptId);

        return view('teacher.quizzes.attempt-detail', [
            'pageTitle' => 'Detail Jawaban: ' . $attempt->student->name,
            'breadcrumb' => [
                ['title' => 'Kelola Kuis', 'url' => route('teacher.quizzes.index')],
                ['title' => $quiz->title, 'url' => route('teacher.quizzes.show', $quizId)],
                ['title' => 'Hasil Kuis', 'url' => route('teacher.quizzes.attempts', $quizId)],
                ['title' => $attempt->student->name]
            ],
            'quiz' => $quiz,
            'attempt' => $attempt
        ]);
    }

    /**
     * Grade essay questions manually
     */
    public function gradeEssay(Request $request, $quizId, $attemptId)
    {
        $quiz = Quiz::where('teacher_id', Auth::id())->findOrFail($quizId);
        $attempt = QuizAttempt::where('quiz_id', $quizId)->findOrFail($attemptId);

        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'required|numeric|min:0',
        ]);

        DB::transaction(function() use ($request, $attempt) {
            $totalScore = 0;
            $totalPoints = 0;

            foreach ($request->grades as $answerId => $points) {
                $answer = QuizAnswer::where('quiz_attempt_id', $attempt->id)
                    ->findOrFail($answerId);
                
                $answer->update([
                    'points_earned' => $points,
                    'is_correct' => $points > 0
                ]);

                $totalScore += $points;
                $totalPoints += $answer->question->points;
            }

            // Recalculate total score
            $finalScore = $totalPoints > 0 ? ($totalScore / $totalPoints) * 100 : 0;
            $attempt->update(['score' => $finalScore]);
        });

        return redirect()->back()
            ->with('success', 'Penilaian berhasil disimpan!');
    }
}