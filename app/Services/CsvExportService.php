<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class CsvExportService
{
    /**
     * Generate CSV response for download
     */
    public static function generateCsvResponse($data, $headers, $filename)
    {
        $responseHeaders = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
            'Pragma' => 'public',
        ];
        
        $callback = function() use ($data, $headers) {
            $file = fopen('php://output', 'w');
            
            try {
                // Add BOM for UTF-8 to ensure proper encoding in Excel
                fwrite($file, "\xEF\xBB\xBF");
                
                // Set locale for proper CSV formatting
                setlocale(LC_ALL, 'id_ID.UTF-8');
                
                // Write headers
                fputcsv($file, $headers);
                
                // Write data
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }
                
            } catch (\Exception $e) {
                Log::error('CSV generation error', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Write error message to CSV
                fputcsv($file, ['Error', 'Failed to generate CSV: ' . $e->getMessage()]);
            } finally {
                fclose($file);
            }
        };
        
        return response()->stream($callback, 200, $responseHeaders);
    }
    
    /**
     * Format attendance log data for CSV export
     */
    public static function formatAttendanceLogsForCsv($logs)
    {
        $data = [];
        $no = 1;
        
        foreach ($logs as $log) {
            try {
                // Determine status text in Indonesian
                $statusText = match($log->status) {
                    'hadir' => 'Hadir',
                    'terlambat' => 'Terlambat',
                    'izin' => 'Izin',
                    'sakit' => 'Sakit',
                    'alpha' => 'Alpha',
                    default => ucfirst($log->status)
                };
                
                // Additional notes based on status
                $additionalNotes = '';
                if ($log->status === 'terlambat') {
                    $additionalNotes = 'Datang setelah jam masuk';
                } elseif ($log->status === 'hadir') {
                    $additionalNotes = 'Hadir tepat waktu';
                } elseif (in_array($log->status, ['izin', 'sakit'])) {
                    $additionalNotes = 'Ada keterangan resmi';
                } elseif ($log->status === 'alpha') {
                    $additionalNotes = 'Tidak hadir tanpa keterangan';
                }
                
                $data[] = [
                    $no++,
                    $log->attendance_date ? $log->attendance_date->format('d/m/Y') : '-',
                    $log->scan_time ? $log->scan_time->format('H:i:s') : '-',
                    $log->student->nis ?? '-',
                    $log->student->name ?? '-',
                    ($log->student && $log->student->class) ? $log->student->class->name : '-',
                    $statusText,
                    $log->location ?? '-',
                    $log->qr_code ?? '-',
                    $log->notes ?? '-',
                    $additionalNotes
                ];
                
            } catch (\Exception $e) {
                Log::warning('Error processing log record for CSV', [
                    'log_id' => $log->id ?? 'unknown',
                    'error' => $e->getMessage()
                ]);
                
                // Add error row
                $data[] = [
                    $no++,
                    '-',
                    '-',
                    '-',
                    'Error processing record',
                    '-',
                    'Error',
                    '-',
                    '-',
                    'Error: ' . $e->getMessage(),
                    'Data tidak dapat diproses'
                ];
            }
        }
        
        return $data;
    }
    
    /**
     * Get CSV headers for attendance logs
     */
    public static function getAttendanceLogsHeaders()
    {
        return [
            'No',
            'Tanggal',
            'Waktu Scan',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Status',
            'Lokasi',
            'QR Code',
            'Catatan',
            'Keterangan Tambahan'
        ];
    }



    /**
     * Get CSV headers for confirmed attendance logs
     */
    public static function getConfirmedAttendanceLogsHeaders()
    {
        return [
            'No',
            'Tanggal',
            'Waktu Scan',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Status',
            'Lokasi',
            'QR Code',
            'Catatan',
            'Dikonfirmasi Oleh',
            'Waktu Konfirmasi',
            'Keterangan Tambahan'
        ];
    }

    /**
     * Format confirmed attendance log data for CSV export
     */
    public static function formatConfirmedAttendanceLogsForCsv($logs)
    {
        $data = [];
        $no = 1;

        foreach ($logs as $log) {
            try {
                // Determine status text in Indonesian
                $statusText = match($log->status) {
                    'hadir' => 'Hadir',
                    'terlambat' => 'Terlambat',
                    'izin' => 'Izin',
                    'sakit' => 'Sakit',
                    'alpha' => 'Alpha',
                    default => ucfirst($log->status)
                };

                // Additional notes based on status
                $additionalNotes = '';
                if ($log->status === 'terlambat') {
                    $additionalNotes = 'Datang setelah jam masuk';
                } elseif ($log->status === 'hadir') {
                    $additionalNotes = 'Hadir tepat waktu';
                } elseif (in_array($log->status, ['izin', 'sakit'])) {
                    $additionalNotes = 'Ada keterangan resmi';
                } elseif ($log->status === 'alpha') {
                    $additionalNotes = 'Tidak hadir tanpa keterangan';
                }

                // Get confirmer name
                $confirmedByName = $log->confirmedBy ? $log->confirmedBy->name : 'Tidak diketahui';

                $data[] = [
                    $no++,
                    $log->attendance_date ? $log->attendance_date->format('d/m/Y') : '-',
                    $log->scan_time ? $log->scan_time->format('H:i:s') : '-',
                    $log->student->nis ?? '-',
                    $log->student->name ?? '-',
                    ($log->student && $log->student->class) ? $log->student->class->name : '-',
                    $statusText,
                    $log->location ?? '-',
                    $log->qr_code ?? '-',
                    $log->notes ?? '-',
                    $confirmedByName,
                    $log->confirmed_at ? $log->confirmed_at->format('d/m/Y H:i:s') : '-',
                    $additionalNotes
                ];

            } catch (\Exception $e) {
                Log::warning('Error processing confirmed log record for CSV', [
                    'log_id' => $log->id ?? 'unknown',
                    'error' => $e->getMessage()
                ]);

                // Add error row
                $data[] = [
                    $no++,
                    '-',
                    '-',
                    '-',
                    'Error processing record',
                    '-',
                    'Error',
                    '-',
                    '-',
                    'Error: ' . $e->getMessage(),
                    '-',
                    '-',
                    'Data tidak dapat diproses'
                ];
            }
        }

        return $data;
    }
}