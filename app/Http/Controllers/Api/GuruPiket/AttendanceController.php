<?php

namespace App\Http\Controllers\Api\GuruPiket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $request->validate([
                'classId' => 'required|exists:classes,id',
                'startDate' => 'required|date',
                'endDate' => 'required|date|after_or_equal:startDate'
            ]);

            $attendances = Attendance::with([
                'student' => function ($query) {
                    $query->select('id', 'name', 'nisn');
                }
            ])
                ->where('class_id', $request->classId)
                ->whereBetween('created_at', [
                    Carbon::parse($request->startDate)->startOfDay(),
                    Carbon::parse($request->endDate)->endOfDay()
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $attendances
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error retrieving attendances: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $request->validate([
                'status' => 'required|in:hadir,alpha,izin,sakit'
            ]);

            $attendance = Attendance::findOrFail($id);
            $attendance->status = $request->status;
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Status kehadiran berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating attendance: ' . $e->getMessage()
            ], 500);
        }
    }

    public function handleQrScan(Request $request)
    {
        try {
            $request->validate([
                'studentId' => 'required|exists:students,id',
                'status' => 'required|in:hadir'
            ]);

            $student = Student::findOrFail($request->studentId);

            // Check if student already has attendance for today
            $existingAttendance = Attendance::where('student_id', $student->id)
                ->whereDate('created_at', Carbon::today())
                ->first();

            if ($existingAttendance) {
                return response()->json([
                    'success' => false,
                    'message' => 'Siswa sudah melakukan absensi hari ini'
                ], 400);
            }

            // Create new attendance
            $attendance = new Attendance();
            $attendance->student_id = $student->id;
            $attendance->class_id = $student->class_id;
            $attendance->status = $request->status;
            $attendance->scan_time = now();
            $attendance->marked_by = auth()->id();
            $attendance->save();

            return response()->json([
                'success' => true,
                'message' => 'Absensi berhasil dicatat'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error scanning QR code: ' . $e->getMessage()
            ], 500);
        }
    }
}