<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\QrAttendance;
use Illuminate\Support\Facades\Storage;

class ListQrCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:list {--all : Show all students} {--with-qr : Show only students with QR codes} {--without-qr : Show only students without QR codes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List students and their QR code status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📋 QR Code Status Report');
        $this->newLine();

        // Get statistics
        $totalStudents = Student::count();
        $studentsWithQr = QrAttendance::count();
        $studentsWithoutQr = $totalStudents - $studentsWithQr;

        // Display statistics
        $this->info('📊 Statistics:');
        $this->line("   Total Students: {$totalStudents}");
        $this->line("   With QR Code: {$studentsWithQr}");
        $this->line("   Without QR Code: {$studentsWithoutQr}");
        $this->newLine();

        // Determine what to show based on options
        if ($this->option('with-qr')) {
            $this->showStudentsWithQr();
        } elseif ($this->option('without-qr')) {
            $this->showStudentsWithoutQr();
        } else {
            $this->showAllStudents();
        }

        return 0;
    }

    /**
     * Show all students with their QR status
     */
    private function showAllStudents()
    {
        $this->info('👥 All Students:');
        
        $students = Student::with('qrAttendance')
                          ->orderBy('name')
                          ->get();

        if ($students->isEmpty()) {
            $this->warn('   No students found in database.');
            return;
        }

        $headers = ['ID', 'Name', 'NIS', 'Class', 'QR Status', 'QR Code', 'File'];
        $rows = [];

        foreach ($students as $student) {
            $qrStatus = $student->qrAttendance ? '✅ Yes' : '❌ No';
            $qrCode = $student->qrAttendance ? substr($student->qrAttendance->qr_code, 0, 20) . '...' : '-';
            $qrFile = $student->qrAttendance ? basename($student->qrAttendance->qr_image_path) : '-';

            $rows[] = [
                $student->id,
                $student->name,
                $student->nis,
                $student->class ?? 'N/A',
                $qrStatus,
                $qrCode,
                $qrFile
            ];
        }

        $this->table($headers, $rows);
    }

    /**
     * Show only students with QR codes
     */
    private function showStudentsWithQr()
    {
        $this->info('✅ Students WITH QR Codes:');
        
        $students = Student::whereHas('qrAttendance')
                          ->with('qrAttendance')
                          ->orderBy('name')
                          ->get();

        if ($students->isEmpty()) {
            $this->warn('   No students with QR codes found.');
            return;
        }

        $headers = ['ID', 'Name', 'NIS', 'Class', 'QR Code', 'File', 'Created', 'File Exists'];
        $rows = [];

        foreach ($students as $student) {
            $qrAttendance = $student->qrAttendance;
            $filePath = storage_path('app/public/' . $qrAttendance->qr_image_path);
            $fileExists = file_exists($filePath) ? '✅' : '❌';
            
            $rows[] = [
                $student->id,
                $student->name,
                $student->nis,
                $student->class ?? 'N/A',
                substr($qrAttendance->qr_code, 0, 25) . '...',
                basename($qrAttendance->qr_image_path),
                $qrAttendance->created_at->format('d/m/Y H:i'),
                $fileExists
            ];
        }

        $this->table($headers, $rows);
        
        // Show file access URLs
        $this->newLine();
        $this->info('🌐 Access QR Code files via:');
        foreach ($students->take(3) as $student) {
            $url = asset('storage/' . $student->qrAttendance->qr_image_path);
            $this->line("   {$student->name}: {$url}");
        }
        if ($students->count() > 3) {
            $this->line("   ... and " . ($students->count() - 3) . " more");
        }
    }

    /**
     * Show only students without QR codes
     */
    private function showStudentsWithoutQr()
    {
        $this->info('❌ Students WITHOUT QR Codes:');
        
        $students = Student::whereDoesntHave('qrAttendance')
                          ->orderBy('name')
                          ->get();

        if ($students->isEmpty()) {
            $this->info('   🎉 All students have QR codes!');
            return;
        }

        $headers = ['ID', 'Name', 'NIS', 'Class', 'Email', 'Status'];
        $rows = [];

        foreach ($students as $student) {
            $rows[] = [
                $student->id,
                $student->name,
                $student->nis,
                $student->class ?? 'N/A',
                $student->email ?? 'N/A',
                $student->status ?? 'N/A'
            ];
        }

        $this->table($headers, $rows);
        
        $this->newLine();
        $this->info('💡 To generate QR codes for these students:');
        $this->line('   php artisan db:seed --class=QrAttendanceSeeder');
    }
}