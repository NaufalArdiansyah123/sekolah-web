<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\QrAttendance;
use App\Models\AttendanceLog;
use Illuminate\Support\Facades\Storage;

class ShowQrCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:show {student? : Student ID, NIS, or name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show detailed QR code information for a student';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $studentInput = $this->argument('student');
        
        if (!$studentInput) {
            $this->showRecentQrCodes();
            return 0;
        }

        // Find student by ID, NIS, or name
        $student = $this->findStudent($studentInput);
        
        if (!$student) {
            $this->error("❌ Student not found: {$studentInput}");
            $this->suggestStudents($studentInput);
            return 1;
        }

        $this->showStudentQrDetails($student);
        return 0;
    }

    /**
     * Find student by various criteria
     */
    private function findStudent($input): ?Student
    {
        // Try by ID first
        if (is_numeric($input)) {
            $student = Student::find($input);
            if ($student) return $student;
            
            // Try by NIS
            $student = Student::where('nis', $input)->first();
            if ($student) return $student;
        }

        // Try by name (partial match)
        return Student::where('name', 'like', "%{$input}%")->first();
    }

    /**
     * Show suggestions when student not found
     */
    private function suggestStudents($input)
    {
        $this->newLine();
        $this->info('🔍 Did you mean one of these students?');
        
        $suggestions = Student::where('name', 'like', "%{$input}%")
                             ->orWhere('nis', 'like', "%{$input}%")
                             ->limit(5)
                             ->get();

        if ($suggestions->isNotEmpty()) {
            $headers = ['ID', 'Name', 'NIS', 'Class'];
            $rows = [];
            
            foreach ($suggestions as $student) {
                $rows[] = [
                    $student->id,
                    $student->name,
                    $student->nis,
                    $student->class ?? 'N/A'
                ];
            }
            
            $this->table($headers, $rows);
            $this->newLine();
            $this->info('💡 Usage: php artisan qr:show <student_id|nis|name>');
        } else {
            $this->warn('No similar students found.');
        }
    }

    /**
     * Show detailed QR code information for a student
     */
    private function showStudentQrDetails(Student $student)
    {
        $this->info("👤 Student: {$student->name}");
        $this->newLine();

        // Basic student info
        $this->info('📋 Student Information:');
        $this->line("   ID: {$student->id}");
        $this->line("   Name: {$student->name}");
        $this->line("   NIS: {$student->nis}");
        $this->line("   Class: " . ($student->class ?? 'N/A'));
        $this->line("   Email: " . ($student->email ?? 'N/A'));
        $this->line("   Status: " . ($student->status ?? 'N/A'));
        $this->newLine();

        // QR Code information
        $qrAttendance = $student->qrAttendance;
        
        if (!$qrAttendance) {
            $this->warn('❌ No QR Code found for this student');
            $this->newLine();
            $this->info('💡 To generate QR code:');
            $this->line('   php artisan db:seed --class=QrAttendanceSeeder');
            return;
        }

        $this->info('🔲 QR Code Information:');
        $this->line("   QR Code: {$qrAttendance->qr_code}");
        $this->line("   File Path: {$qrAttendance->qr_image_path}");
        $this->line("   Created: {$qrAttendance->created_at->format('d/m/Y H:i:s')}");
        $this->line("   Updated: {$qrAttendance->updated_at->format('d/m/Y H:i:s')}");
        
        // Check if file exists
        $filePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
        $fileExists = file_exists($filePath);
        $this->line("   File Exists: " . ($fileExists ? '✅ Yes' : '❌ No'));
        
        if ($fileExists) {
            $fileSize = filesize($filePath);
            $this->line("   File Size: " . $this->formatBytes($fileSize));
            $this->line("   File Type: " . pathinfo($filePath, PATHINFO_EXTENSION));
        }
        
        $this->newLine();

        // Web access URL
        $this->info('🌐 Web Access:');
        $url = asset('storage/' . $qrAttendance->qr_image_path);
        $this->line("   URL: {$url}");
        $this->newLine();

        // Attendance history
        $this->showAttendanceHistory($student);
    }

    /**
     * Show attendance history for student
     */
    private function showAttendanceHistory(Student $student)
    {
        $this->info('📅 Recent Attendance History:');
        
        $logs = AttendanceLog::where('student_id', $student->id)
                           ->orderBy('attendance_date', 'desc')
                           ->limit(10)
                           ->get();

        if ($logs->isEmpty()) {
            $this->line('   No attendance records found');
            return;
        }

        $headers = ['Date', 'Status', 'Scan Time', 'Location'];
        $rows = [];

        foreach ($logs as $log) {
            $rows[] = [
                $log->attendance_date->format('d/m/Y'),
                $this->getStatusEmoji($log->status) . ' ' . ucfirst($log->status),
                $log->scan_time->format('H:i:s'),
                $log->location ?? '-'
            ];
        }

        $this->table($headers, $rows);
        
        // Attendance statistics
        $this->newLine();
        $this->info('📊 This Month Statistics:');
        $monthlyStats = AttendanceLog::where('student_id', $student->id)
                                   ->whereMonth('attendance_date', now()->month)
                                   ->whereYear('attendance_date', now()->year)
                                   ->selectRaw('status, count(*) as count')
                                   ->groupBy('status')
                                   ->pluck('count', 'status')
                                   ->toArray();

        foreach (['hadir', 'terlambat', 'izin', 'sakit', 'alpha'] as $status) {
            $count = $monthlyStats[$status] ?? 0;
            $emoji = $this->getStatusEmoji($status);
            $this->line("   {$emoji} " . ucfirst($status) . ": {$count}");
        }
    }

    /**
     * Show recent QR codes when no student specified
     */
    private function showRecentQrCodes()
    {
        $this->info('🔲 Recent QR Codes Generated:');
        $this->newLine();

        $recentQrs = QrAttendance::with('student')
                                ->orderBy('created_at', 'desc')
                                ->limit(10)
                                ->get();

        if ($recentQrs->isEmpty()) {
            $this->warn('No QR codes found in database.');
            $this->newLine();
            $this->info('💡 To generate QR codes:');
            $this->line('   php artisan db:seed --class=QrAttendanceSeeder');
            return;
        }

        $headers = ['Student', 'NIS', 'Class', 'QR Code', 'Created', 'File'];
        $rows = [];

        foreach ($recentQrs as $qr) {
            $rows[] = [
                $qr->student->name,
                $qr->student->nis,
                $qr->student->class ?? 'N/A',
                substr($qr->qr_code, 0, 20) . '...',
                $qr->created_at->format('d/m H:i'),
                basename($qr->qr_image_path)
            ];
        }

        $this->table($headers, $rows);
        
        $this->newLine();
        $this->info('💡 Usage:');
        $this->line('   php artisan qr:show <student_id>   # Show specific student');
        $this->line('   php artisan qr:show "John Doe"     # Search by name');
        $this->line('   php artisan qr:show 12345          # Search by NIS');
    }

    /**
     * Get emoji for attendance status
     */
    private function getStatusEmoji($status): string
    {
        return match($status) {
            'hadir' => '✅',
            'terlambat' => '⚠️',
            'izin' => 'ℹ️',
            'sakit' => '🤒',
            'alpha' => '❌',
            default => '❓'
        };
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2): string
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}