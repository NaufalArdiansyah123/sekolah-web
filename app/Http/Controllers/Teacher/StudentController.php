<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Grade;
use App\Models\Classes;
use App\Exports\StudentsExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    public function index(Request $request)
    {
        // Handle export requests
        if ($request->has('export')) {
            return $this->handleExport($request);
        }

        // Get students from database
        $query = Student::with(['user', 'class'])->active();

        // Apply filters
        if (request('search')) {
            $search = request('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if (request('class')) {
            $query->whereHas('class', function ($q) {
                $q->where('name', request('class'));
            });
        }

        if (request('gender')) {
            $query->where('gender', request('gender'));
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        // Apply sorting
        $sortBy = request('sort', 'name');
        $sortDirection = request('direction', 'asc');

        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'nis':
                $query->orderBy('nis', $sortDirection);
                break;
            case 'class':
                $query->join('classes', 'students.class_id', '=', 'classes.id')
                    ->orderBy('classes.name', $sortDirection)
                    ->select('students.*');
                break;
            case 'enrollment_date':
                $query->orderBy('enrollment_date', $sortDirection);
                break;
            case 'enrollment_date':
                $query->orderBy('enrollment_date', $sortDirection);
                break;
            case 'created_at':
                $query->orderBy('created_at', $sortDirection);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        // Paginate
        $students = $query->paginate(12)->appends(request()->query());

        // Get filter options
        $classes = Classes::where('is_active', true)->pluck('name')->sort();
        $genders = [
            'L' => 'Laki-laki',
            'P' => 'Perempuan'
        ];
        $statuses = [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'graduated' => 'Lulus'
        ];

        return view('teacher.students.index', compact('students', 'classes', 'genders', 'statuses'));
    }

    public function show($id)
    {
        // Get student from database
        $student = Student::with(['user', 'extracurricularRegistrations.extracurricular', 'attendanceLogs', 'activePklRegistration.tempatPkl'])
            ->findOrFail($id);

        // Get academic data from database
        $grades = Grade::where('student_id', $student->user_id ?? $student->id)
            ->with(['assignment', 'quiz'])
            ->latest()
            ->take(10)
            ->get();

        $academicData = [
            'current_semester' => 'Ganjil 2024/2025',
            'total_subjects' => $grades->pluck('subject')->unique()->count(),
            'average_score' => $grades->avg('score') ?? 0,
            'rank_in_class' => $this->getStudentRankInClass($student),
            'total_students_in_class' => Student::where('class_id', $student->class_id)->active()->count(),
            'attendance_percentage' => $this->getAttendancePercentage($student),
            'total_absences' => $student->attendanceLogs()->where('status', 'absent')->count(),
            'recent_grades' => $grades->map(function ($grade) {
                return [
                    'subject' => $grade->subject,
                    'score' => $grade->score,
                    'max_score' => $grade->max_score,
                    'grade' => $grade->letter_grade,
                    'assessment_name' => $grade->assessment_name,
                    'created_at' => $grade->created_at
                ];
            })
        ];

        return view('teacher.students.show', compact('student', 'academicData'));
    }

    public function create()
    {
        $classes = Classes::where('is_active', true)->get();
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

        return view('teacher.students.create', compact('classes', 'religions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|string|unique:students,nis',
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'religion' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'nis',
            'name',
            'class_id',
            'gender',
            'birth_date',
            'birth_place',
            'address',
            'phone',
            'email',
            'parent_name',
            'parent_phone',
            'religion'
        ]);

        // Handle file upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('students/photos', $filename, 'public');
            $data['photo'] = $path;
        }

        // Set default status and enrollment date
        $data['status'] = 'active';
        $data['enrollment_date'] = now()->toDateString();

        // Save to database
        Student::create($data);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $classes = Classes::where('is_active', true)->get();
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'];

        return view('teacher.students.edit', compact('student', 'classes', 'religions'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nis' => 'required|string|unique:students,nis,' . $id,
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'gender' => 'required|in:L,P',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:students,email,' . $id,
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'religion' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->only([
            'nis',
            'name',
            'class_id',
            'gender',
            'birth_date',
            'birth_place',
            'address',
            'phone',
            'email',
            'parent_name',
            'parent_phone',
            'religion'
        ]);

        // Handle file upload if new photo provided
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('students/photos', $filename, 'public');
            $data['photo'] = $path;
        }

        // Update in database
        $student->update($data);

        return redirect()->route('teacher.students.index')
            ->with('success', 'Data siswa berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete photo if exists
        if ($student->photo) {
            Storage::disk('public')->delete($student->photo);
        }

        // Delete from database
        $student->delete();

        return redirect()->route('teacher.students.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    public function export(Request $request)
    {
        return $this->handleExport($request);
    }

    /**
     * Handle export functionality
     */
    private function handleExport(Request $request)
    {
        // Get filters
        $filters = [
            'search' => $request->get('search'),
            'class' => $request->get('class'),
            'gender' => $request->get('gender'),
            'status' => $request->get('status')
        ];

        // Build query with same filters as index
        $query = Student::with(['user', 'class'])->active();

        if ($filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('nis', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($filters['class']) {
            $query->whereHas('class', function ($q) use ($filters) {
                $q->where('name', $filters['class']);
            });
        }

        if ($filters['gender']) {
            $query->where('gender', $filters['gender']);
        }

        if ($filters['status']) {
            $query->where('status', $filters['status']);
        }

        // Apply sorting
        $sortBy = $request->get('sort', 'name');
        $sortDirection = $request->get('direction', 'asc');

        switch ($sortBy) {
            case 'name':
                $query->orderBy('name', $sortDirection);
                break;
            case 'nis':
                $query->orderBy('nis', $sortDirection);
                break;
            case 'class':
                $query->join('classes', 'students.class_id', '=', 'classes.id')
                    ->orderBy('classes.name', $sortDirection)
                    ->select('students.*');
                break;
            case 'created_at':
                $query->orderBy('created_at', $sortDirection);
                break;
            default:
                $query->orderBy('name', 'asc');
        }

        $students = $query->with(['user', 'class'])->get();

        // Generate filename
        $filename = 'data-siswa';
        if ($filters['class']) {
            $filename .= '-kelas-' . str_replace(' ', '-', strtolower($filters['class']));
        }
        if ($filters['status']) {
            $filename .= '-status-' . $filters['status'];
        }
        $filename .= '-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new StudentsExport($students, $filters), $filename);
    }

    /**
     * Get student rank in class
     */
    private function getStudentRankInClass($student)
    {
        $classmates = Student::where('class_id', $student->class_id)
            ->active()
            ->with(['user'])
            ->get();

        $rankings = [];
        foreach ($classmates as $classmate) {
            $avgScore = Grade::where('student_id', $classmate->user_id ?? $classmate->id)
                ->avg('score') ?? 0;
            $rankings[] = [
                'student_id' => $classmate->id,
                'avg_score' => $avgScore
            ];
        }

        // Sort by average score descending
        usort($rankings, function ($a, $b) {
            return $b['avg_score'] <=> $a['avg_score'];
        });

        // Find student's rank
        foreach ($rankings as $index => $ranking) {
            if ($ranking['student_id'] == $student->id) {
                return $index + 1;
            }
        }

        return '-';
    }

    /**
     * Get attendance percentage
     */
    private function getAttendancePercentage($student)
    {
        $totalDays = $student->attendanceLogs()->count();
        if ($totalDays == 0)
            return 0;

        $presentDays = $student->attendanceLogs()
            ->whereIn('status', ['present', 'late'])
            ->count();

        return round(($presentDays / $totalDays) * 100, 1);
    }
}