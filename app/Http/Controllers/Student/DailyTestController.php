<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DailyTest;
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
     * Display a listing of available daily tests
     */
    public function index(Request $request)
    {
        $student = Auth::user();
        
        // Get student's class - assuming it's stored in user profile
        $studentClass = $student->class ?? '7'; // Default to class 7 if not set
        
        $query = DailyTest::published()
                          ->forClass($studentClass)
                          ->with(['teacher', 'questions', 'attempts' => function($q) {
                              $q->where('student_id', Auth::id());
                          }]);

        // Apply filters
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'available':
                    $query->available();
                    break;
                case 'completed':
                    $query->whereHas('attempts', function($q) {
                        $q->where('student_id', Auth::id())
                          ->where('status', 'completed');
                    });
                    break;
                case 'pending':
                    $query->whereHas('attempts', function($q) {
                        $q->where('student_id', Auth::id())
                          ->where('status', 'in_progress');
                    });
                    break;
            }
        }

        if ($request->filled('subject')) {
            $query->forSubject($request->subject);
        }

        $dailyTests = $query->orderBy('scheduled_at', 'desc')
                           ->orderBy('created_at', 'desc')
                           ->get();

        // Calculate statistics
        $allTests = DailyTest::published()->forClass($studentClass)->get();
        $studentAttempts = DailyTestAttempt::where('student_id', Auth::id())->get();
        
        $stats = [
            'available' => $allTests->filter(function($test) {
                return $test->isAvailable() && !$test->isExpired() && $test->canStudentTake(Auth::id());
            })->count(),
            'completed' => $studentAttempts->where('status', 'completed')->count(),
            'pending' => $studentAttempts->where('status', 'in_progress')->count(),
            'average' => $studentAttempts->where('status', 'completed')->avg('score') ?? 0,
        ];

        return view('student.daily-tests.index', compact('dailyTests', 'stats'));
    }

    /**
     * Display the specified daily test
     */
    public function show($id)
    {
        $dailyTest = DailyTest::published()
                             ->with(['teacher', 'questions'])
                             ->findOrFail($id);

        // Check if student can access this test (same class)
        $student = Auth::user();
        $studentClass = $student->class ?? '7';
        
        if ($dailyTest->class !== $studentClass) {
            abort(403, 'Anda tidak memiliki akses ke ulangan ini.');
        }

        // Get student's attempt if exists
        $attempt = $dailyTest->getStudentAttempt(Auth::id());

        return view('student.daily-tests.show', compact('dailyTest', 'attempt'));
    }

    /**
     * Start a new daily test attempt
     */
    public function start($id)
    {
        try {
            $dailyTest = DailyTest::published()->findOrFail($id);
            
            // Check if student can access this test
            $student = Auth::user();
            $studentClass = $student->class ?? '7';
            
            if ($dailyTest->class !== $studentClass) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak memiliki akses ke ulangan ini.'
                ], 403);
            }

            // Check if student can take this test
            if (!$dailyTest->canStudentTake(Auth::id())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat mengerjakan ulangan ini. Mungkin sudah mencapai batas maksimal percobaan atau waktu sudah habis.'
                ], 400);
            }

            // Check for existing in-progress attempt
            $existingAttempt = DailyTestAttempt::where('daily_test_id', $id)
                                              ->where('student_id', Auth::id())
                                              ->where('status', 'in_progress')
                                              ->first();

            if ($existingAttempt) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('student.daily-tests.take', $existingAttempt->id),
                    'message' => 'Melanjutkan percobaan yang sudah ada.'
                ]);
            }

            DB::beginTransaction();

            // Create new attempt
            $attempt = DailyTestAttempt::create([
                'daily_test_id' => $id,
                'student_id' => Auth::id(),
                'started_at' => now(),
                'total_questions' => $dailyTest->questions->count(),
                'status' => 'in_progress'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('student.daily-tests.take', $attempt->id),
                'message' => 'Ulangan dimulai!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memulai ulangan.'
            ], 500);
        }
    }

    /**
     * Continue existing attempt
     */
    public function continue($attemptId)
    {
        $attempt = DailyTestAttempt::where('student_id', Auth::id())
                                  ->where('status', 'in_progress')
                                  ->findOrFail($attemptId);

        return redirect()->route('student.daily-tests.take', $attemptId);
    }

    /**
     * Show the test taking interface
     */
    public function take($attemptId)
    {
        $attempt = DailyTestAttempt::where('student_id', Auth::id())
                                  ->with(['dailyTest.questions', 'testAnswers'])
                                  ->findOrFail($attemptId);

        // Check if attempt is still valid
        if ($attempt->isCompleted() || $attempt->isAbandoned()) {
            return redirect()->route('student.daily-tests.result', $attemptId);
        }

        // Check if time is up
        if ($attempt->isTimeUp()) {
            $attempt->complete();
            return redirect()->route('student.daily-tests.result', $attemptId)
                           ->with('info', 'Waktu ulangan telah habis. Jawaban Anda telah disimpan.');
        }

        $questions = $attempt->dailyTest->questions()->ordered()->get();
        
        // Get existing answers
        $existingAnswers = $attempt->testAnswers->keyBy('question_id');

        return view('student.daily-tests.take', compact('attempt', 'questions', 'existingAnswers'));
    }

    /**
     * Submit the daily test
     */
    public function submit(Request $request, $attemptId)
    {
        try {
            $attempt = DailyTestAttempt::where('student_id', Auth::id())
                                      ->where('status', 'in_progress')
                                      ->with('dailyTest.questions')
                                      ->findOrFail($attemptId);

            DB::beginTransaction();

            // Process answers
            $answers = $request->input('answers', []);
            
            foreach ($attempt->dailyTest->questions as $question) {
                $answerText = $answers[$question->id] ?? '';
                
                // Skip empty answers
                if (empty($answerText)) {
                    continue;
                }

                // Create or update answer
                $answer = DailyTestAnswer::updateOrCreate(
                    [
                        'attempt_id' => $attempt->id,
                        'question_id' => $question->id,
                    ],
                    [
                        'answer' => $answerText,
                    ]
                );

                // Check correctness for multiple choice
                $answer->checkCorrectness();
            }

            // Complete the attempt
            $attempt->complete();

            DB::commit();

            return response()->json([
                'success' => true,
                'redirect' => route('student.daily-tests.result', $attemptId),
                'message' => 'Ulangan berhasil dikumpulkan!'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengumpulkan ulangan.'
            ], 500);
        }
    }

    /**
     * Show test result
     */
    public function result($attemptId)
    {
        $attempt = DailyTestAttempt::where('student_id', Auth::id())
                                  ->with([
                                      'dailyTest.questions',
                                      'testAnswers.question',
                                      'student'
                                  ])
                                  ->findOrFail($attemptId);

        // Check if student can view results
        if (!$attempt->dailyTest->show_results && $attempt->status !== 'completed') {
            abort(403, 'Hasil ulangan belum dapat dilihat.');
        }

        $questions = $attempt->dailyTest->questions()->ordered()->get();
        $answers = $attempt->testAnswers->keyBy('question_id');

        // Calculate detailed statistics
        $stats = [
            'total_questions' => $questions->count(),
            'answered_questions' => $answers->count(),
            'correct_answers' => $answers->where('is_correct', true)->count(),
            'incorrect_answers' => $answers->where('is_correct', false)->count(),
            'essay_questions' => $questions->where('type', 'essay')->count(),
            'multiple_choice_questions' => $questions->where('type', 'multiple_choice')->count(),
            'total_points' => $questions->sum('points'),
            'earned_points' => $answers->sum('points_earned'),
            'percentage' => $attempt->score ?? 0,
            'grade_letter' => $attempt->grade_letter,
            'duration_taken' => $attempt->duration_taken,
        ];

        return view('student.daily-tests.result', compact('attempt', 'questions', 'answers', 'stats'));
    }
}