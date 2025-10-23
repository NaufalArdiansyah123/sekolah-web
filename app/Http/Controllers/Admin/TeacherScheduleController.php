<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherSchedule;
use App\Models\Teacher;
use App\Models\Classes;
use App\Models\Subject;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TeacherScheduleController extends Controller
{
    /**
     * Display a listing of teacher schedules
     */
    public function index(Request $request)
    {
        $query = TeacherSchedule::with(['teacher', 'class', 'subject', 'academicYear']);

        // Filter by teacher
        if ($request->filled('teacher_id')) {
            $query->where('teacher_id', $request->teacher_id);
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by day
        if ($request->filled('day_of_week')) {
            $query->where('day_of_week', $request->day_of_week);
        }

        // Filter by academic year
        if ($request->filled('academic_year_id')) {
            $query->where('academic_year_id', $request->academic_year_id);
        }

        $schedules = $query->orderBy('day_of_week')
                          ->orderBy('start_time')
                          ->paginate(15);

        $teachers = Teacher::active()->orderBy('name')->get();
        $classes = Classes::active()->orderBy('name')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();

        return view('admin.teacher-schedules.index', compact(
            'schedules', 'teachers', 'classes', 'subjects', 'academicYears'
        ));
    }

    /**
     * Show the form for creating a new schedule
     */
    public function create()
    {
        $teachers = Teacher::active()->orderBy('name')->get();
        $classes = Classes::active()->orderBy('name')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $currentAcademicYear = AcademicYear::where('is_active', true)->first();

        return view('admin.teacher-schedules.create', compact(
            'teachers', 'classes', 'subjects', 'currentAcademicYear'
        ));
    }

    /**
     * Store a newly created schedule
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Check for conflicts
            $conflicts = TeacherSchedule::where('teacher_id', $request->teacher_id)
                ->where('day_of_week', $request->day_of_week)
                ->where('academic_year_id', $request->academic_year_id)
                ->where('is_active', true)
                ->where(function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->end_time)
                          ->where('end_time', '>', $request->start_time);
                    });
                })
                ->exists();

            if ($conflicts) {
                return back()->withInput()->withErrors([
                    'conflict' => 'Jadwal bertabrakan dengan jadwal lain untuk guru yang sama pada hari yang sama.'
                ]);
            }

            TeacherSchedule::create($request->all());

            DB::commit();

            return redirect()->route('admin.teacher-schedules.index')
                           ->with('success', 'Jadwal guru berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating teacher schedule: ' . $e->getMessage());

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat menyimpan jadwal.'
            ]);
        }
    }

    /**
     * Display the specified schedule
     */
    public function show(TeacherSchedule $teacherSchedule)
    {
        $teacherSchedule->load(['teacher', 'class', 'subject', 'academicYear']);

        return view('admin.teacher-schedules.show', compact('teacherSchedule'));
    }

    /**
     * Show the form for editing the schedule
     */
    public function edit(TeacherSchedule $teacherSchedule)
    {
        $teachers = Teacher::active()->orderBy('name')->get();
        $classes = Classes::active()->orderBy('name')->get();
        $subjects = Subject::where('is_active', true)->orderBy('name')->get();
        $academicYears = AcademicYear::orderBy('name', 'desc')->get();

        return view('admin.teacher-schedules.edit', compact(
            'teacherSchedule', 'teachers', 'classes', 'subjects', 'academicYears'
        ));
    }

    /**
     * Update the specified schedule
     */
    public function update(Request $request, TeacherSchedule $teacherSchedule)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        try {
            DB::beginTransaction();

            // Check for conflicts (excluding current schedule)
            $conflicts = TeacherSchedule::where('teacher_id', $request->teacher_id)
                ->where('day_of_week', $request->day_of_week)
                ->where('academic_year_id', $request->academic_year_id)
                ->where('id', '!=', $teacherSchedule->id)
                ->where('is_active', true)
                ->where(function ($query) use ($request) {
                    $query->where(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->end_time)
                          ->where('end_time', '>', $request->start_time);
                    });
                })
                ->exists();

            if ($conflicts) {
                return back()->withInput()->withErrors([
                    'conflict' => 'Jadwal bertabrakan dengan jadwal lain untuk guru yang sama pada hari yang sama.'
                ]);
            }

            $teacherSchedule->update($request->all());

            DB::commit();

            return redirect()->route('admin.teacher-schedules.index')
                           ->with('success', 'Jadwal guru berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating teacher schedule: ' . $e->getMessage());

            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui jadwal.'
            ]);
        }
    }

    /**
     * Remove the specified schedule
     */
    public function destroy(TeacherSchedule $teacherSchedule)
    {
        try {
            $teacherSchedule->delete();

            return redirect()->route('admin.teacher-schedules.index')
                           ->with('success', 'Jadwal guru berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Error deleting teacher schedule: ' . $e->getMessage());

            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus jadwal.'
            ]);
        }
    }

    /**
     * Toggle schedule status
     */
    public function toggleStatus(TeacherSchedule $teacherSchedule)
    {
        $teacherSchedule->update(['is_active' => !$teacherSchedule->is_active]);

        $status = $teacherSchedule->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Jadwal berhasil {$status}.");
    }

    /**
     * Get teacher's schedule for a specific day (AJAX)
     */
    public function getTeacherSchedule(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
        ]);

        $schedules = TeacherSchedule::where('teacher_id', $request->teacher_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('is_active', true)
            ->with(['class', 'subject'])
            ->orderBy('start_time')
            ->get();

        return response()->json($schedules);
    }
}
