<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssessmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    public function index(Request $request)
    {
        $query = Assessment::with(['questions', 'results'])
            ->forTeacher(Auth::id())
            ->latest();

        // Apply filters
        $query->bySubject($request->get('subject'))
              ->byClass($request->get('class'))
              ->byType($request->get('type'))
              ->byStatus($request->get('status'))
              ->search($request->get('search'));

        $assessments = $query->paginate(12);

        // Update status for assessments that should be auto-updated
        foreach ($assessments as $assessment) {
            $assessment->updateStatus();
        }

        return view('teacher.assessment.index', compact('assessments'));
    }

    public function create()
    {
        return view('teacher.assessment.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'class' => 'required|string',
            'type' => 'required|in:exam,quiz,test,practical,assignment',
            'date' => 'required|date|after:now',
            'duration' => 'required|integer|min:5|max:300',
            'max_score' => 'required|integer|min:1|max:1000',
            'status' => 'nullable|in:draft,scheduled,active',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'questions' => 'nullable|array',
            'questions.*.question' => 'required_with:questions|string',
            'questions.*.type' => 'required_with:questions|in:multiple_choice,essay,short_answer,true_false',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'nullable|string',
            'questions.*.points' => 'required_with:questions|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // Create assessment
            $assessment = Assessment::create([
                'title' => $request->title,
                'subject' => $request->subject,
                'class' => $request->class,
                'type' => $request->type,
                'date' => $request->date,
                'duration' => $request->duration,
                'max_score' => $request->max_score,
                'status' => $request->status ?: 'draft',
                'description' => $request->description,
                'instructions' => $request->instructions,
                'user_id' => Auth::id()
            ]);

            // Create questions if provided
            if ($request->has('questions') && is_array($request->questions)) {
                foreach ($request->questions as $index => $questionData) {
                    if (!empty($questionData['question'])) {
                        AssessmentQuestion::create([
                            'assessment_id' => $assessment->id,
                            'question_number' => $index + 1,
                            'question' => $questionData['question'],
                            'type' => $questionData['type'],
                            'options' => $questionData['options'] ?? null,
                            'correct_answer' => $questionData['correct_answer'] ?? null,
                            'points' => $questionData['points']
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('teacher.assessment.index')
                ->with('success', 'Assessment has been created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Failed to create assessment. Please try again.');
        }
    }

    public function show($id)
    {
        $assessment = Assessment::with(['questions', 'results.student'])
            ->forTeacher(Auth::id())
            ->findOrFail($id);

        // Update status if needed
        $assessment->updateStatus();

        $results = $assessment->results()->with('student')->get();

        return view('teacher.assessment.show', compact('assessment', 'results'));
    }

    public function edit($id)
    {
        $assessment = Assessment::with('questions')
            ->forTeacher(Auth::id())
            ->findOrFail($id);

        return view('teacher.assessment.edit', compact('assessment'));
    }

    public function update(Request $request, $id)
    {
        $assessment = Assessment::forTeacher(Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string',
            'class' => 'required|string',
            'type' => 'required|in:exam,quiz,test,practical,assignment',
            'date' => 'required|date',
            'duration' => 'required|integer|min:5|max:300',
            'max_score' => 'required|integer|min:1|max:1000',
            'status' => 'nullable|in:draft,scheduled,active,completed',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'questions' => 'nullable|array',
            'questions.*.question' => 'required_with:questions|string',
            'questions.*.type' => 'required_with:questions|in:multiple_choice,essay,short_answer,true_false',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'nullable|string',
            'questions.*.points' => 'required_with:questions|integer|min:1'
        ]);

        DB::beginTransaction();
        try {
            // Update assessment
            $assessment->update([
                'title' => $request->title,
                'subject' => $request->subject,
                'class' => $request->class,
                'type' => $request->type,
                'date' => $request->date,
                'duration' => $request->duration,
                'max_score' => $request->max_score,
                'status' => $request->status ?: $assessment->status,
                'description' => $request->description,
                'instructions' => $request->instructions
            ]);

            // Update questions if provided
            if ($request->has('questions') && is_array($request->questions)) {
                // Delete existing questions
                $assessment->questions()->delete();

                // Create new questions
                foreach ($request->questions as $index => $questionData) {
                    if (!empty($questionData['question'])) {
                        AssessmentQuestion::create([
                            'assessment_id' => $assessment->id,
                            'question_number' => $index + 1,
                            'question' => $questionData['question'],
                            'type' => $questionData['type'],
                            'options' => $questionData['options'] ?? null,
                            'correct_answer' => $questionData['correct_answer'] ?? null,
                            'points' => $questionData['points']
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('teacher.assessment.index')
                ->with('success', 'Assessment has been updated successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Failed to update assessment. Please try again.');
        }
    }

    public function destroy($id)
    {
        $assessment = Assessment::forTeacher(Auth::id())->findOrFail($id);

        try {
            $assessment->delete();

            return redirect()->route('teacher.assessment.index')
                ->with('success', 'Assessment has been deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete assessment. Please try again.');
        }
    }

    public function grades(Request $request)
    {
        // Mock data for grades overview
        $grades = collect([
            (object)[
                'student_id' => 1,
                'student_name' => 'Ahmad Rizki',
                'student_nis' => '2023001',
                'class' => 'VIII A',
                'subjects' => [
                    'Matematika' => ['score' => 85, 'grade' => 'B', 'assessments' => 5],
                    'Fisika' => ['score' => 78, 'grade' => 'B-', 'assessments' => 4],
                    'Biologi' => ['score' => 90, 'grade' => 'A-', 'assessments' => 3],
                    'Bahasa Indonesia' => ['score' => 82, 'grade' => 'B+', 'assessments' => 4]
                ],
                'average' => 83.75,
                'overall_grade' => 'B+',
                'total_assessments' => 16
            ],
            (object)[
                'student_id' => 2,
                'student_name' => 'Siti Nurhaliza',
                'student_nis' => '2023002',
                'class' => 'VIII A',
                'subjects' => [
                    'Matematika' => ['score' => 92, 'grade' => 'A', 'assessments' => 5],
                    'Fisika' => ['score' => 88, 'grade' => 'A-', 'assessments' => 4],
                    'Biologi' => ['score' => 95, 'grade' => 'A', 'assessments' => 3],
                    'Bahasa Indonesia' => ['score' => 89, 'grade' => 'A-', 'assessments' => 4]
                ],
                'average' => 91,
                'overall_grade' => 'A',
                'total_assessments' => 16
            ]
        ]);

        // Apply filters
        if ($request->get('class')) {
            $grades = $grades->where('class', $request->get('class'));
        }

        if ($request->get('search')) {
            $search = $request->get('search');
            $grades = $grades->filter(function ($grade) use ($search) {
                return stripos($grade->student_name, $search) !== false ||
                       stripos($grade->student_nis, $search) !== false;
            });
        }

        return view('teacher.assessment.grades', compact('grades'));
    }

    public function reports(Request $request)
    {
        // Mock data for reports and analytics
        $analytics = [
            'class_performance' => [
                'VIII A' => ['average' => 85.2, 'students' => 25, 'assessments' => 12],
                'VIII B' => ['average' => 82.7, 'students' => 24, 'assessments' => 11],
                'IX A' => ['average' => 87.1, 'students' => 23, 'assessments' => 15],
                'IX B' => ['average' => 84.5, 'students' => 22, 'assessments' => 13]
            ],
            'subject_performance' => [
                'Matematika' => ['average' => 83.5, 'assessments' => 20, 'students' => 94],
                'Fisika' => ['average' => 81.2, 'assessments' => 18, 'students' => 94],
                'Biologi' => ['average' => 86.8, 'assessments' => 15, 'students' => 94],
                'Bahasa Indonesia' => ['average' => 85.1, 'assessments' => 16, 'students' => 94]
            ],
            'grade_distribution' => [
                'A' => 28,
                'B' => 45,
                'C' => 18,
                'D' => 3,
                'F' => 0
            ],
            'monthly_trends' => [
                'January' => 82.5,
                'February' => 84.2,
                'March' => 85.8,
                'April' => 83.9,
                'May' => 86.1
            ]
        ];

        return view('teacher.assessment.reports', compact('analytics'));
    }
}