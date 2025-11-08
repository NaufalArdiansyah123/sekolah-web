<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\PklRegistration;
use App\Models\PklAttendanceLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class QrScannerController extends Controller
{
    /**
     * Show PKL QR Scanner page
     */
    public function index()
    {
        try {
            $user = auth()->user();

            // Get approved PKL registration with QR code
            $pklRegistration = PklRegistration::where('student_id', $user->id)
                ->where('status', 'approved')
                ->whereNotNull('qr_code')
                ->with(['tempatPkl'])
                ->first();

            if (!$pklRegistration) {
                return view('student.qr-scanner.index', [
                    'error' => 'Anda belum memiliki registrasi PKL yang disetujui atau QR Code belum dibuat.',
                    'pklRegistration' => null
                ]);
            }

            // Check if already scanned today
            $today = now()->toDateString();
            $todayScan = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)
                ->whereDate('scan_date', $today)
                ->first();

            // Get recent scans (last 5)
            $recentScans = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)
                ->orderBy('scan_date', 'desc')
                ->orderBy('scan_time', 'desc')
                ->limit(5)
                ->get();

            // Get statistics
            $totalScans = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)->count();
            $presentCount = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)
                ->where('status', 'hadir')
                ->count();

            return view('student.qr-scanner.index', compact(
                'pklRegistration',
                'todayScan',
                'recentScans',
                'totalScans',
                'presentCount'
            ));

        } catch (\Exception $e) {
            Log::error('Error loading PKL QR scanner:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return view('student.qr-scanner.index', [
                'error' => 'Terjadi kesalahan saat memuat scanner: ' . $e->getMessage(),
                'pklRegistration' => null
            ]);
        }
    }

    /**
     * Process PKL QR scan
     */
    public function scan(Request $request)
    {
        try {
            // Validate request
            $validated = $request->validate([
                'qr_code' => 'required|string',
            ]);

            $user = auth()->user();
            $qrCode = $validated['qr_code'];

            Log::info('PKL QR Scan attempt:', [
                'user_id' => $user->id,
                'qr_code' => $qrCode,
            ]);

            // Get student's approved PKL registration
            $pklRegistration = PklRegistration::where('student_id', $user->id)
                ->where('status', 'approved')
                ->whereNotNull('qr_code')
                ->with('tempatPkl')
                ->first();

            if (!$pklRegistration) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda belum memiliki registrasi PKL yang disetujui.',
                ], 403);
            }

            // Validate QR code
            if ($pklRegistration->qr_code !== $qrCode) {
                Log::warning('QR Code mismatch:', [
                    'expected' => $pklRegistration->qr_code,
                    'received' => $qrCode,
                    'student_id' => $user->id
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'QR Code tidak valid atau bukan milik Anda.',
                ], 400);
            }

            // Check PKL period
            $today = now()->toDateString();
            $startDate = Carbon::parse($pklRegistration->tanggal_mulai);
            $endDate = Carbon::parse($pklRegistration->tanggal_selesai);

            if (now()->lt($startDate) || now()->gt($endDate->endOfDay())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Saat ini bukan periode PKL Anda. Periode: ' .
                        $startDate->format('d/m/Y') . ' - ' . $endDate->format('d/m/Y'),
                ], 400);
            }

            // Check if already scanned today
            $existingScan = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)
                ->whereDate('scan_date', $today)
                ->first();

            if ($existingScan) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda sudah melakukan scan hari ini pada pukul ' .
                        Carbon::parse($existingScan->scan_time)->format('H:i:s'),
                    'data' => [
                        'scan_time' => Carbon::parse($existingScan->scan_time)->format('H:i:s'),
                        'scan_date' => Carbon::parse($existingScan->scan_date)->format('d/m/Y'),
                    ]
                ], 400);
            }

            // Create attendance log
            $attendanceLog = PklAttendanceLog::create([
                'pkl_registration_id' => $pklRegistration->id,
                'student_id' => $user->id,
                'qr_code' => $qrCode,
                'scan_date' => $today,
                'scan_time' => now(),
                'latitude' => null,
                'longitude' => null,
                'location' => null,
                'accuracy' => null,
                'altitude' => null,
                'heading' => null,
                'speed' => null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => 'hadir',
            ]);

            Log::info('PKL attendance recorded:', [
                'id' => $attendanceLog->id,
                'student_id' => $user->id,
                'pkl_registration_id' => $pklRegistration->id,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Absensi PKL berhasil dicatat!',
                'data' => [
                    'scan_time' => now()->format('H:i:s'),
                    'scan_date' => now()->format('d/m/Y'),
                    'location' => 'Tidak tersedia',
                    'tempat_pkl' => $pklRegistration->tempatPkl->nama_tempat ?? 'Tidak diketahui',
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in PKL scan:', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim tidak valid.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('Error processing PKL QR scan:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memproses scan. Silakan coba lagi.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Get scan history
     */
    public function history()
    {
        try {
            $user = auth()->user();

            $pklRegistration = PklRegistration::where('student_id', $user->id)
                ->where('status', 'approved')
                ->with('tempatPkl')
                ->first();

            if (!$pklRegistration) {
                return redirect()->route('student.qr-scanner.index')
                    ->with('error', 'Anda belum memiliki registrasi PKL yang disetujui.');
            }

            $attendanceLogs = PklAttendanceLog::where('pkl_registration_id', $pklRegistration->id)
                ->orderBy('scan_date', 'desc')
                ->orderBy('scan_time', 'desc')
                ->paginate(20);

            return view('student.qr-scanner.history', compact('attendanceLogs', 'pklRegistration'));

        } catch (\Exception $e) {
            Log::error('Error loading scan history:', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            return redirect()->route('student.qr-scanner.index')
                ->with('error', 'Terjadi kesalahan saat memuat riwayat.');
        }
    }
}
