<?php

namespace App\Http\Controllers\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:guru_piket');
    }

    /**
     * Show daily report
     */
    public function daily(Request $request)
    {
        $pageTitle = 'Laporan Harian';
        $breadcrumb = 'Laporan Harian';

        $date = $request->get('date', date('Y-m-d'));
        $selectedDate = Carbon::parse($date);

        // Mock data for daily report
        $summary = [
            'total_students' => 450,
            'hadir' => 398,
            'terlambat' => 28,
            'tidak_hadir' => 24,
            'attendance_percentage' => 88.4
        ];

        // Time distribution data
        $timeDistribution = [
            '06:30-07:00' => ['count' => 298, 'percentage' => 75],
            '07:00-07:15' => ['count' => 100, 'percentage' => 25],
            '07:15-07:30' => ['count' => 28, 'percentage' => 15],
            'After 07:30' => ['count' => 24, 'percentage' => 5]
        ];

        // Class attendance data
        $classAttendance = [
            [
                'class' => 'XII IPA 1',
                'wali_kelas' => 'Dr. Rahman, M.Pd',
                'total_students' => 36,
                'hadir' => 32,
                'terlambat' => 2,
                'izin_sakit' => 1,
                'alpha' => 1,
                'percentage' => 89
            ],
            [
                'class' => 'XII IPA 2',
                'wali_kelas' => 'Lisa Maharani, S.Pd',
                'total_students' => 35,
                'hadir' => 31,
                'terlambat' => 3,
                'izin_sakit' => 1,
                'alpha' => 0,
                'percentage' => 89
            ],
            [
                'class' => 'XII IPS 1',
                'wali_kelas' => 'Ahmad Syahrul, S.Pd',
                'total_students' => 34,
                'hadir' => 29,
                'terlambat' => 3,
                'izin_sakit' => 2,
                'alpha' => 0,
                'percentage' => 85
            ],
            [
                'class' => 'XII IPS 2',
                'wali_kelas' => 'Sari Andini, S.Pd',
                'total_students' => 33,
                'hadir' => 28,
                'terlambat' => 2,
                'izin_sakit' => 2,
                'alpha' => 1,
                'percentage' => 85
            ]
        ];

        // Teacher attendance summary
        $teacherSummary = [
            'total_teachers' => 45,
            'hadir' => 42,
            'izin' => 2,
            'terlambat' => 1,
            'attendance_percentage' => 93
        ];

        return view('guru-piket.reports.daily', compact(
            'pageTitle',
            'breadcrumb',
            'date',
            'selectedDate',
            'summary',
            'timeDistribution',
            'classAttendance',
            'teacherSummary'
        ));
    }

    /**
     * Show monthly report
     */
    public function monthly(Request $request)
    {
        $pageTitle = 'Laporan Bulanan';
        $breadcrumb = 'Laporan Bulanan';

        $month = $request->get('month', date('Y-m'));
        $selectedMonth = Carbon::parse($month . '-01');

        // Mock data for monthly report
        $overview = [
            'effective_days' => 22,
            'average_attendance' => 91.2,
            'average_late' => 5.8,
            'average_absent' => 3.0,
            'trend_attendance' => 2.1, // positive trend
            'trend_late' => -0.5, // negative trend (good)
            'trend_absent' => -1.6 // negative trend (good)
        ];

        // Calendar data for the month
        $calendarData = $this->generateCalendarData($selectedMonth);

        // Weekly trends
        $weeklyTrends = [
            'week_1' => 89,
            'week_2' => 92,
            'week_3' => 93,
            'week_4' => 91
        ];

        // Class performance data
        $classPerformance = [
            [
                'class' => 'XII IPA 1',
                'total_students' => 36,
                'average_attendance' => 93.2,
                'best_day' => ['date' => '15 Nov', 'percentage' => 100],
                'worst_day' => ['date' => '9 Nov', 'percentage' => 83],
                'trend' => 2.1,
                'ranking' => 1
            ],
            [
                'class' => 'XII IPA 2',
                'total_students' => 35,
                'average_attendance' => 91.8,
                'best_day' => ['date' => '22 Nov', 'percentage' => 97],
                'worst_day' => ['date' => '13 Nov', 'percentage' => 80],
                'trend' => 1.5,
                'ranking' => 2
            ],
            [
                'class' => 'XII IPS 1',
                'total_students' => 34,
                'average_attendance' => 89.5,
                'best_day' => ['date' => '18 Nov', 'percentage' => 94],
                'worst_day' => ['date' => '21 Nov', 'percentage' => 76],
                'trend' => 0.2,
                'ranking' => 3
            ],
            [
                'class' => 'XII IPS 2',
                'total_students' => 33,
                'average_attendance' => 87.3,
                'best_day' => ['date' => '26 Nov', 'percentage' => 91],
                'worst_day' => ['date' => '16 Nov', 'percentage' => 73],
                'trend' => -1.2,
                'ranking' => 4
            ]
        ];

        return view('guru-piket.reports.monthly', compact(
            'pageTitle',
            'breadcrumb',
            'month',
            'selectedMonth',
            'overview',
            'calendarData',
            'weeklyTrends',
            'classPerformance'
        ));
    }

    /**
     * Show export page
     */
    public function export()
    {
        $pageTitle = 'Export Data';
        $breadcrumb = 'Export Data';

        // Mock data for export summary
        $summary = [
            'total_students' => 450,
            'total_teachers' => 45,
            'effective_days_this_month' => 22,
            'total_records' => 9900
        ];

        // Mock export history
        $exportHistory = [
            [
                'id' => 1,
                'filename' => 'Laporan Bulanan November',
                'format' => 'PDF',
                'size' => '2.3 MB',
                'created_at' => '28 Nov 2024, 14:30',
                'download_url' => '#'
            ],
            [
                'id' => 2,
                'filename' => 'Data Absensi Siswa',
                'format' => 'Excel',
                'size' => '1.8 MB',
                'created_at' => '27 Nov 2024, 09:15',
                'download_url' => '#'
            ],
            [
                'id' => 3,
                'filename' => 'Raw Data Backup',
                'format' => 'CSV',
                'size' => '856 KB',
                'created_at' => '25 Nov 2024, 16:45',
                'download_url' => '#'
            ]
        ];

        return view('guru-piket.reports.export', compact(
            'pageTitle',
            'breadcrumb',
            'summary',
            'exportHistory'
        ));
    }

    /**
     * Process export request
     */
    public function processExport(Request $request)
    {
        $request->validate([
            'data_type' => 'required|in:students,teachers',
            'format' => 'required|in:pdf,excel,csv',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after_or_equal:date_start',
            'class_filter' => 'nullable|string',
            'status_filters' => 'nullable|array'
        ]);

        // Here you would typically:
        // 1. Query data based on filters
        // 2. Generate file in requested format
        // 3. Store file temporarily
        // 4. Return download response

        // Mock processing delay
        sleep(2);

        $filename = 'export_' . $request->data_type . '_' . date('Y-m-d_H-i-s') . '.' . $request->format;

        return response()->json([
            'success' => true,
            'message' => 'Export berhasil diproses',
            'filename' => $filename,
            'download_url' => route('guru-piket.reports.download', ['filename' => $filename])
        ]);
    }

    /**
     * Download exported file
     */
    public function download($filename)
    {
        // Here you would typically:
        // 1. Validate filename
        // 2. Check file exists
        // 3. Return file download response

        // For demo purposes, return a simple response
        return response()->json([
            'message' => 'File download would start here: ' . $filename
        ]);
    }

    /**
     * Get attendance statistics for charts
     */
    public function getAttendanceStats(Request $request)
    {
        $period = $request->get('period', '7days');
        $type = $request->get('type', 'students');

        // Mock chart data
        $chartData = [];

        if ($period === '7days') {
            $chartData = [
                'labels' => ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                'datasets' => [
                    [
                        'label' => 'Hadir',
                        'data' => [420, 415, 430, 425, 410, 0, 0],
                        'backgroundColor' => '#10b981'
                    ],
                    [
                        'label' => 'Terlambat',
                        'data' => [25, 30, 15, 20, 35, 0, 0],
                        'backgroundColor' => '#f59e0b'
                    ],
                    [
                        'label' => 'Alpha',
                        'data' => [5, 5, 5, 5, 5, 0, 0],
                        'backgroundColor' => '#ef4444'
                    ]
                ]
            ];
        }

        return response()->json($chartData);
    }

    /**
     * Generate calendar data for monthly view
     */
    private function generateCalendarData($month)
    {
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();
        $calendar = [];

        // Generate mock attendance data for each day
        for ($date = $startOfMonth->copy(); $date <= $endOfMonth; $date->addDay()) {
            $dayOfWeek = $date->dayOfWeek;
            
            // Skip weekends for school days
            if ($dayOfWeek == 0 || $dayOfWeek == 6) {
                continue;
            }

            // Mock attendance percentage (85-95%)
            $attendancePercentage = rand(85, 95);
            
            $calendar[] = [
                'date' => $date->format('Y-m-d'),
                'day' => $date->day,
                'attendance_percentage' => $attendancePercentage,
                'status' => $attendancePercentage >= 90 ? 'high' : ($attendancePercentage >= 80 ? 'medium' : 'low')
            ];
        }

        return $calendar;
    }
}