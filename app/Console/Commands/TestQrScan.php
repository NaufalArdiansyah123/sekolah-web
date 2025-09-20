<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\QrAttendance;
use App\Models\Student;
use App\Services\QrCodeService;

class TestQrScan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:test-scan {qr_code?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test QR code scanning functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing QR Code Scan Functionality...');
        $this->newLine();

        $qrCode = $this->argument('qr_code');
        
        if (!$qrCode) {
            // Show available QR codes
            $this->info('📋 Available QR Codes:');
            $qrAttendances = QrAttendance::with('student')->get();
            
            if ($qrAttendances->isEmpty()) {
                $this->warn('❌ No QR codes found in database.');
                $this->info('💡 Generate QR codes first: php artisan db:seed --class=QrAttendanceSeeder');
                return 1;
            }
            
            $headers = ['ID', 'Student', 'NIS', 'QR Code', 'Created'];
            $rows = [];
            
            foreach ($qrAttendances as $qr) {
                $rows[] = [
                    $qr->id,
                    $qr->student->name ?? 'Unknown',
                    $qr->student->nis ?? 'N/A',
                    substr($qr->qr_code, 0, 30) . '...',
                    $qr->created_at->format('d/m/Y H:i')
                ];
            }
            
            $this->table($headers, $rows);
            $this->newLine();
            $this->info('💡 Usage: php artisan qr:test-scan "QR_CODE_HERE"');
            return 0;
        }
        
        // Test specific QR code
        $this->info("🔍 Testing QR Code: {$qrCode}");
        $this->newLine();
        
        try {
            $qrCodeService = new QrCodeService();
            
            // Test validation
            $qrAttendance = $qrCodeService->validateQrCode($qrCode);
            
            if (!$qrAttendance) {
                $this->error('❌ QR Code not found in database');
                $this->newLine();
                
                // Check if it's a partial match
                $partialMatches = QrAttendance::where('qr_code', 'like', "%{$qrCode}%")->get();
                if ($partialMatches->isNotEmpty()) {
                    $this->warn('🔍 Found partial matches:');
                    foreach ($partialMatches as $match) {
                        $this->line("   - {$match->qr_code}");
                    }
                }
                return 1;
            }
            
            $this->info('✅ QR Code found!');
            $this->newLine();
            
            // Display QR details
            $this->info('📋 QR Code Details:');
            $this->line("   ID: {$qrAttendance->id}");
            $this->line("   QR Code: {$qrAttendance->qr_code}");
            $this->line("   Student ID: {$qrAttendance->student_id}");
            $this->line("   Image Path: {$qrAttendance->qr_image_path}");
            $this->line("   Created: {$qrAttendance->created_at}");
            $this->newLine();
            
            // Display student details
            $student = $qrAttendance->student;
            if ($student) {
                $this->info('👤 Student Details:');
                $this->line("   Name: {$student->name}");
                $this->line("   NIS: {$student->nis}");
                $this->line("   Class: {$student->class}");
                $this->line("   Status: {$student->status}");
                $this->newLine();
            } else {
                $this->error('❌ Student not found for this QR code!');
                return 1;
            }
            
            // Check image file
            $imagePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
            if (file_exists($imagePath)) {
                $this->info('✅ QR Code image file exists');
                $this->line("   Path: {$imagePath}");
                $this->line("   Size: " . $this->formatBytes(filesize($imagePath)));
                $this->line("   URL: " . asset('storage/' . $qrAttendance->qr_image_path));
            } else {
                $this->warn('⚠️  QR Code image file not found');
                $this->line("   Expected path: {$imagePath}");
            }
            $this->newLine();
            
            // Test attendance log creation (simulation)
            $this->info('🧪 Testing Attendance Log Creation (Simulation):');
            
            $scanTime = now();
            $attendanceDate = $scanTime->toDateString();
            
            // Check existing attendance
            $existingAttendance = \App\Models\AttendanceLog::where('student_id', $student->id)
                                                         ->whereDate('attendance_date', $attendanceDate)
                                                         ->first();
            
            if ($existingAttendance) {
                $this->warn('⚠️  Student already has attendance today:');
                $this->line("   Status: {$existingAttendance->status}");
                $this->line("   Time: {$existingAttendance->scan_time->format('H:i:s')}");
            } else {
                $status = \App\Models\AttendanceLog::determineStatus($scanTime);
                $this->info('✅ Ready to create attendance log:');
                $this->line("   Student: {$student->name}");
                $this->line("   Date: {$attendanceDate}");
                $this->line("   Time: {$scanTime->format('H:i:s')}");
                $this->line("   Status: {$status}");
                
                if ($this->confirm('Create actual attendance log?', false)) {
                    $attendanceLog = \App\Models\AttendanceLog::create([
                        'student_id' => $student->id,
                        'qr_code' => $qrCode,
                        'status' => $status,
                        'scan_time' => $scanTime,
                        'attendance_date' => $attendanceDate,
                        'location' => 'Test Command',
                    ]);
                    
                    $this->info("✅ Attendance log created with ID: {$attendanceLog->id}");
                }
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ Error during test: ' . $e->getMessage());
            $this->line('Stack trace: ' . $e->getTraceAsString());
            return 1;
        }
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