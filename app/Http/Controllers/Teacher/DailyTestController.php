<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\DailyTest;
use App\Models\DailyTestQuestion;
use App\Models\DailyTestAttempt;
use App\Models\DailyTestAnswer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DailyTestController extends Controller
{
    /**
     * Display a listing of daily tests
     */
    public function index(Request $request)
    {
        $query = DailyTest::where('teacher_id', Auth::id())
                          ->with(['questions', 'attempts'])
                          ->withCount(['questions', 'attempts']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('subject')) {
            $query->where('subject', $request->subject);
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $dailyTests = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calculate statistics
        $stats = [
            'total' => DailyTest::where('teacher_id', Auth::id())->count(),
            'published' => DailyTest::where('teacher_id', Auth::id())->where('status', 'published')->count(),
            'draft' => DailyTest::where('teacher_id', Auth::id())->where('status', 'draft')->count(),
            'completed' => DailyTest::where('teacher_id', Auth::id())->where('status', 'completed')->count(),
        ];

        return view('teacher.daily-tests.index', compact('dailyTests', 'stats'));
    }

    /**
     * Show the form for creating a new daily test
     */
    public function create()
    {
        return view('teacher.daily-tests.create');
    }

    /**
     * Store a newly created daily test
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string',
            'class' => 'required|string',
            'duration' => 'required|integer|min:15|max:180',
            'scheduled_at' => 'nullable|date|after:now',
            'status' => 'required|in:draft,published',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,essay',
            'questions.*.points' => 'required|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();

            // Create the daily test
            $dailyTest = DailyTest::create([
                'title' => $request->title,
                'description' => $request->description,
                'subject' => $request->subject,
                'class' => $request->class,
                'teacher_id' => Auth::id(),
                'duration' => $request->duration,
                'scheduled_at' => $request->scheduled_at,
                'status' => $request->status,
                'instructions' => $request->instructions,
                'show_results' => $request->boolean('show_results', true),
                'randomize_questions' => $request->boolean('randomize_questions', false),
                'max_attempts' => $request->integer('max_attempts', 1),
            ]);

            // Create questions
            foreach ($request->questions as $index => $questionData) {
                $question = DailyTestQuestion::create([
                    'daily_test_id' => $dailyTest->id,
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'points' => $questionData['points'],
                    'order' => $index + 1,
                ]);

                // Handle multiple choice options
                if ($questionData['type'] === 'multiple_choice' && isset($questionData['options'])) {
                    $options = [];
                    $correctAnswer = null;

                    foreach ($questionData['options'] as $optionIndex => $optionText) {
                        if (!empty($optionText)) {
                            $options[$optionIndex] = $optionText;
                            
                            // Check if this is the correct answer
                            if (isset($questionData['correct_answer']) && $questionData['correct_answer'] == $optionIndex) {
                                $correctAnswer = $optionIndex;
                            }
                        }
                    }

                    $question->update([
                        'options' => $options,
                        'correct_answer' => $correctAnswer,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('teacher.daily-tests.index')
                           ->with('success', 'Ulangan harian berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat membuat ulangan harian.')
                           ->withInput();
        }
    }

    /**
     * Display the specified daily test
     */
    public function show($id)
    {
        $dailyTest = DailyTest::where('teacher_id', Auth::id())
                             ->with(['questions.answers', 'attempts.student'])
                             ->findOrFail($id);

        $stats = [
            'total_questions' => $dailyTest->questions->count(),
            'total_points' => $dailyTest->questions->sum('points'),
            'total_attempts' => $dailyTest->attempts->count(),
            'completed_attempts' => $dailyTest->attempts->where('status', 'completed')->count(),
            'average_score' => $dailyTest->attempts->where('status', 'completed')->avg('score') ?? 0,
        ];

        return view('teacher.daily-tests.show', compact('dailyTest', 'stats'));
    }

    /**
     * Show the form for editing the specified daily test
     */
    public function edit($id)
    {
        $dailyTest = DailyTest::where('teacher_id', Auth::id())
                             ->with('questions')
                             ->findOrFail($id);

        return view('teacher.daily-tests.edit', compact('dailyTest'));
    }

    /**
     * Update the specified daily test
     */
    public function update(Request $request, $id)
    {
        $dailyTest = DailyTest::where('teacher_id', Auth::id())->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject' => 'required|string',
            'class' => 'required|string',
            'duration' => 'required|integer|min:15|max:180',
            'scheduled_at' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            $dailyTest->update([
                'title' => $request->title,
                'description' => $request->description,
                'subject' => $request->subject,
                'class' => $request->class,
                'duration' => $request->duration,
                'scheduled_at' => $request->scheduled_at,
                'status' => $request->status,
                'instructions' => $request->instructions,
                'show_results' => $request->boolean('show_results', true),
                'randomize_questions' => $request->boolean('randomize_questions', false),
                'max_attempts' => $request->integer('max_attempts', 1),
            ]);

            return redirect()->route('teacher.daily-tests.index')
                           ->with('success', 'Ulangan harian berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memperbarui ulangan harian.')
                           ->withInput();
        }
    }

    /**
     * Remove the specified daily test
     */
    public function destroy($id)
    {
        try {
            $dailyTest = DailyTest::where('teacher_id', Auth::id())->findOrFail($id);
            $dailyTest->delete();

            return response()->json([
                'success' => true,
                'message' => 'Ulangan harian berhasil dihapus!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus ulangan harian.'
            ], 500);
        }
    }

    /**
     * Publish the daily test
     */
    public function publish($id)
    {
        try {
            $dailyTest = DailyTest::where('teacher_id', Auth::id())->findOrFail($id);
            
            // Check if test has questions
            if ($dailyTest->questions->count() === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mempublikasikan ulangan tanpa soal.'
                ], 400);
            }

            $dailyTest->update(['status' => 'published']);

            return response()->json([
                'success' => true,
                'message' => 'Ulangan harian berhasil dipublikasikan!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mempublikasikan ulangan harian.'
            ], 500);
        }
    }

    /**
     * Unpublish the daily test
     */
    public function unpublish($id)
    {
        try {
            $dailyTest = DailyTest::where('teacher_id', Auth::id())->findOrFail($id);
            $dailyTest->update(['status' => 'draft']);

            return response()->json([
                'success' => true,
                'message' => 'Ulangan harian berhasil dibatalkan publikasinya!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat membatalkan publikasi ulangan harian.'
            ], 500);
        }
    }

    /**
     * Show attempts for the daily test
     */
    public function attempts($id)
    {
        $dailyTest = DailyTest::where('teacher_id', Auth::id())
                             ->with(['attempts.student'])
                             ->findOrFail($id);

        $attempts = $dailyTest->attempts()
                             ->with('student')
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        return view('teacher.daily-tests.attempts', compact('dailyTest', 'attempts'));
    }

    /**
     * Show specific attempt detail
     */
    public function attemptDetail($testId, $attemptId)
    {
        $dailyTest = DailyTest::where('teacher_id', Auth::id())->findOrFail($testId);
        
        $attempt = DailyTestAttempt::where('daily_test_id', $testId)
                                  ->with(['student', 'testAnswers.question'])
                                  ->findOrFail($attemptId);

        return view('teacher.daily-tests.attempt-detail', compact('dailyTest', 'attempt'));
    }

    /**
     * Grade essay question
     */
    public function gradeEssay(Request $request, $testId, $attemptId)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:daily_test_questions,id',
            'points' => 'required|numeric|min:0',
            'feedback' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid.',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $dailyTest = DailyTest::where('teacher_id', Auth::id())->findOrFail($testId);
            $attempt = DailyTestAttempt::where('daily_test_id', $testId)->findOrFail($attemptId);
            
            $answer = DailyTestAnswer::where('attempt_id', $attemptId)
                                    ->where('question_id', $request->question_id)
                                    ->firstOrFail();

            $answer->gradeEssay($request->points, $request->feedback);

            return response()->json([
                'success' => true,
                'message' => 'Jawaban essay berhasil dinilai!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menilai jawaban essay.'
            ], 500);
        }
    }

    /**
     * Show analytics for daily tests
     */
    public function analytics()
    {
        $teacherId = Auth::id();
        
        $stats = [
            'total_tests' => DailyTest::where('teacher_id', $teacherId)->count(),
            'published_tests' => DailyTest::where('teacher_id', $teacherId)->where('status', 'published')->count(),
            'total_attempts' => DailyTestAttempt::whereHas('dailyTest', function($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->count(),
            'completed_attempts' => DailyTestAttempt::whereHas('dailyTest', function($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->where('status', 'completed')->count(),
            'average_score' => DailyTestAttempt::whereHas('dailyTest', function($q) use ($teacherId) {
                $q->where('teacher_id', $teacherId);
            })->where('status', 'completed')->avg('score') ?? 0,
        ];

        // Get recent tests
        $recentTests = DailyTest::where('teacher_id', $teacherId)
                               ->with(['attempts'])
                               ->orderBy('created_at', 'desc')
                               ->limit(5)
                               ->get();

        // Get subject performance
        $subjectPerformance = DailyTest::where('teacher_id', $teacherId)
                                      ->select('subject')
                                      ->selectRaw('AVG(
                                          (SELECT AVG(score) FROM daily_test_attempts 
                                           WHERE daily_test_id = daily_tests.id 
                                           AND status = "completed")
                                      ) as avg_score')
                                      ->groupBy('subject')
                                      ->get();

        return view('teacher.daily-tests.analytics', compact('stats', 'recentTests', 'subjectPerformance'));
    }
}