<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:teacher');
    }

    public function index(Request $request)
    {
        $selectedDate = $request->get('date', Carbon::today()->format('Y-m-d'));
        $selectedClass = $request->get('class', 'VIII A');

        // Mock students data
        $students = $this->getStudentsByClass($selectedClass);
        
        // Mock attendance data for selected date
        $attendanceData = $this->getAttendanceByDate($selectedDate, $selectedClass);
        
        // Calculate statistics
        $statistics = $this->calculateStatistics($attendanceData);
        
        // Available classes
        $classes = ['VII A', 'VII B', 'VIII A', 'VIII B', 'IX A', 'IX B'];
        
        return view('teacher.attendance.index', compact(
            'students', 
            'attendanceData', 
            'statistics', 
            'selectedDate', 
            'selectedClass', 
            'classes'
        ));
    }

    public function markAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|integer',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,sick,permission',
            'notes' => 'nullable|string|max:255',
            'time_in' => 'nullable|string',
            'time_out' => 'nullable|string'
        ]);

        // Here you would save to database
        // Attendance::updateOrCreate([
        //     'student_id' => $request->student_id,
        //     'date' => $request->date,
        // ], [
        //     'status' => $request->status,
        //     'notes' => $request->notes,
        //     'time_in' => $request->time_in,
        //     'time_out' => $request->time_out,
        //     'marked_by' => auth()->id(),
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Attendance marked successfully'
        ]);
    }

    public function bulkMarkAttendance(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'class' => 'required|string',
            'status' => 'required|in:present,absent,sick,permission',
            'student_ids' => 'required|array',
            'student_ids.*' => 'integer'
        ]);

        // Here you would bulk update attendance
        foreach ($request->student_ids as $studentId) {
            // Attendance::updateOrCreate([
            //     'student_id' => $studentId,
            //     'date' => $request->date,
            // ], [
            //     'status' => $request->status,
            //     'marked_by' => auth()->id(),
            // ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bulk attendance marked successfully'
        ]);
    }

    public function getStudentsByClass($class)
    {
        // Mock students data - replace with actual model query
        $allStudents = collect([
            (object)[
                'id' => 1,
                'nis' => '2023001',
                'name' => 'Ahmad Rizki Pratama',
                'class' => 'VIII A',
                'gender' => 'L',
                'photo' => null,
                'phone' => '081234567890',
                'parent_name' => 'Budi Pratama',
                'parent_phone' => '081234567891'
            ],
            (object)[
                'id' => 2,
                'nis' => '2023002',
                'name' => 'Siti Nurhaliza',
                'class' => 'VIII A',
                'gender' => 'P',
                'photo' => null,
                'phone' => '081234567892',
                'parent_name' => 'Sari Nurhaliza',
                'parent_phone' => '081234567893'
            ],
            (object)[
                'id' => 3,
                'nis' => '2023003',
                'name' => 'Budi Santoso',
                'class' => 'VIII B',
                'gender' => 'L',
                'photo' => null,
                'phone' => '081234567894',
                'parent_name' => 'Agus Santoso',
                'parent_phone' => '081234567895'
            ],
            (object)[
                'id' => 4,
                'nis' => '2023004',
                'name' => 'Dewi Lestari',
                'class' => 'VII A',
                'gender' => 'P',
                'photo' => null,
                'phone' => '081234567896',
                'parent_name' => 'Indra Lestari',
                'parent_phone' => '081234567897'
            ],
            (object)[
                'id' => 5,
                'nis' => '2023005',
                'name' => 'Andi Wijaya',
                'class' => 'IX A',
                'gender' => 'L',
                'photo' => null,
                'phone' => '081234567898',
                'parent_name' => 'Rudi Wijaya',
                'parent_phone' => '081234567899'
            ],
            (object)[
                'id' => 6,
                'nis' => '2023006',
                'name' => 'Maya Sari',
                'class' => 'IX B',
                'gender' => 'P',
                'photo' => null,
                'phone' => '081234567900',
                'parent_name' => 'Hasan Sari',
                'parent_phone' => '081234567901'
            ],
            (object)[
                'id' => 7,
                'nis' => '2023007',
                'name' => 'Rudi Hermawan',
                'class' => 'VII B',
                'gender' => 'L',
                'photo' => null,
                'phone' => '081234567902',
                'parent_name' => 'Dedi Hermawan',
                'parent_phone' => '081234567903'
            ],
            (object)[
                'id' => 8,
                'nis' => '2023008',
                'name' => 'Lina Marlina',
                'class' => 'VIII A',
                'gender' => 'P',
                'photo' => null,
                'phone' => '081234567904',
                'parent_name' => 'Tono Marlina',
                'parent_phone' => '081234567905'
            ],
            (object)[
                'id' => 9,
                'nis' => '2023009',
                'name' => 'Fajar Nugroho',
                'class' => 'IX A',
                'gender' => 'L',
                'photo' => null,
                'phone' => '081234567906',
                'parent_name' => 'Bambang Nugroho',
                'parent_phone' => '081234567907'
            ],
            (object)[
                'id' => 10,
                'nis' => '2023010',
                'name' => 'Rina Kusuma',
                'class' => 'IX B',
                'gender' => 'P',
                'photo' => null,
                'phone' => '081234567908',
                'parent_name' => 'Wayan Kusuma',
                'parent_phone' => '081234567909'
            ],
            (object)[
                'id' => 11,
                'nis' => '2023011',
                'name' => 'Doni Prasetyo',
                'class' => 'VII A',
                'gender' => 'L',
                'photo' => null,
                'phone' => '081234567910',
                'parent_name' => 'Eko Prasetyo',
                'parent_phone' => '081234567911'
            ],
            (object)[
                'id' => 12,
                'nis' => '2023012',
                'name' => 'Sari Indah',
                'class' => 'VII B',
                'gender' => 'P',
                'photo' => null,
                'phone' => '081234567912',
                'parent_name' => 'Joko Indah',
                'parent_phone' => '081234567913'
            ]
        ]);

        return $allStudents->where('class', $class)->values();
    }

    public function getAttendanceByDate($date, $class)
    {
        // Mock attendance data - replace with actual model query
        $students = $this->getStudentsByClass($class);
        $attendanceData = [];

        foreach ($students as $student) {
            // Generate random attendance status for demo
            $statuses = ['present', 'absent', 'sick', 'permission'];
            $weights = [80, 10, 5, 5]; // 80% present, 10% absent, 5% sick, 5% permission
            
            $randomStatus = $this->getWeightedRandomStatus($statuses, $weights);
            
            $attendanceData[$student->id] = (object)[
                'student_id' => $student->id,
                'date' => $date,
                'status' => $randomStatus,
                'time_in' => $randomStatus === 'present' ? '07:' . rand(15, 45) : null,
                'time_out' => $randomStatus === 'present' ? '14:' . rand(15, 45) : null,
                'notes' => $this->getStatusNotes($randomStatus),
                'marked_at' => Carbon::parse($date)->format('Y-m-d H:i:s'),
                'marked_by' => auth()->id()
            ];
        }

        return $attendanceData;
    }

    private function getWeightedRandomStatus($statuses, $weights)
    {
        $totalWeight = array_sum($weights);
        $random = rand(1, $totalWeight);
        
        $currentWeight = 0;
        for ($i = 0; $i < count($statuses); $i++) {
            $currentWeight += $weights[$i];
            if ($random <= $currentWeight) {
                return $statuses[$i];
            }
        }
        
        return $statuses[0]; // fallback
    }

    private function getStatusNotes($status)
    {
        $notes = [
            'present' => ['Hadir tepat waktu', 'Hadir', 'Masuk kelas'],
            'absent' => ['Tidak hadir tanpa keterangan', 'Alpha', 'Tidak masuk'],
            'sick' => ['Sakit demam', 'Sakit flu', 'Sakit perut', 'Rawat inap'],
            'permission' => ['Izin keperluan keluarga', 'Izin acara keluarga', 'Izin dokter', 'Izin urusan penting']
        ];

        $statusNotes = $notes[$status] ?? [''];
        return $statusNotes[array_rand($statusNotes)];
    }

    public function calculateStatistics($attendanceData)
    {
        $total = count($attendanceData);
        if ($total === 0) {
            return [
                'total' => 0,
                'present' => 0,
                'absent' => 0,
                'sick' => 0,
                'permission' => 0,
                'present_percentage' => 0,
                'absent_percentage' => 0
            ];
        }

        $present = collect($attendanceData)->where('status', 'present')->count();
        $absent = collect($attendanceData)->where('status', 'absent')->count();
        $sick = collect($attendanceData)->where('status', 'sick')->count();
        $permission = collect($attendanceData)->where('status', 'permission')->count();

        return [
            'total' => $total,
            'present' => $present,
            'absent' => $absent,
            'sick' => $sick,
            'permission' => $permission,
            'present_percentage' => round(($present / $total) * 100, 1),
            'absent_percentage' => round((($absent + $sick + $permission) / $total) * 100, 1)
        ];
    }

    public function attendanceHistory(Request $request)
    {
        $studentId = $request->get('student_id');
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        // Mock attendance history data
        $history = [];
        $currentDate = Carbon::parse($startDate);
        $endDateCarbon = Carbon::parse($endDate);

        while ($currentDate->lte($endDateCarbon)) {
            if ($currentDate->isWeekday()) { // Only weekdays
                $statuses = ['present', 'absent', 'sick', 'permission'];
                $weights = [85, 8, 4, 3];
                $status = $this->getWeightedRandomStatus($statuses, $weights);

                $history[] = (object)[
                    'date' => $currentDate->format('Y-m-d'),
                    'status' => $status,
                    'time_in' => $status === 'present' ? '07:' . rand(15, 45) : null,
                    'time_out' => $status === 'present' ? '14:' . rand(15, 45) : null,
                    'notes' => $this->getStatusNotes($status)
                ];
            }
            $currentDate->addDay();
        }

        return response()->json($history);
    }

    public function exportAttendance(Request $request)
    {
        $date = $request->get('date', Carbon::today()->format('Y-m-d'));
        $class = $request->get('class', 'VIII A');
        $format = $request->get('format', 'excel'); // excel, pdf, csv

        // Here you would implement actual export functionality
        // For now, return a mock response
        return response()->json([
            'success' => true,
            'message' => "Attendance report for {$class} on {$date} exported as {$format}",
            'download_url' => '#'
        ]);
    }

    public function monthlyReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $class = $request->get('class', 'VIII A');

        // Mock monthly report data
        $students = $this->getStudentsByClass($class);
        $monthlyData = [];

        foreach ($students as $student) {
            $totalDays = 22; // Average school days in a month
            $presentDays = rand(18, 22);
            $absentDays = $totalDays - $presentDays;
            
            $monthlyData[] = (object)[
                'student' => $student,
                'total_days' => $totalDays,
                'present_days' => $presentDays,
                'absent_days' => $absentDays,
                'sick_days' => rand(0, 2),
                'permission_days' => rand(0, 2),
                'attendance_percentage' => round(($presentDays / $totalDays) * 100, 1)
            ];
        }

        return view('teacher.attendance.monthly-report', compact('monthlyData', 'month', 'class'));
    }

    public function attendanceStatistics(Request $request)
    {
        $class = $request->get('class', 'VIII A');
        $period = $request->get('period', 'month'); // week, month, semester

        // Mock statistics data
        $statistics = [
            'class_average' => 87.5,
            'best_attendance' => 98.2,
            'lowest_attendance' => 76.8,
            'total_students' => count($this->getStudentsByClass($class)),
            'perfect_attendance' => 3,
            'concerning_attendance' => 2,
            'trends' => [
                'improving' => 8,
                'declining' => 2,
                'stable' => 15
            ],
            'daily_averages' => [
                'Monday' => 89.2,
                'Tuesday' => 91.5,
                'Wednesday' => 88.7,
                'Thursday' => 87.3,
                'Friday' => 85.1
            ]
        ];

        return response()->json($statistics);
    }
}