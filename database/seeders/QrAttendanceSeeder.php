<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Services\QrCodeService;

class QrAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $qrCodeService = new QrCodeService();
        
        // Get first 10 active students for testing
        $students = Student::where('status', 'active')->take(10)->get();
        
        if ($students->isEmpty()) {
            $this->command->info("No active students found. Please add some students first.");
            return;
        }
        
        $this->command->info("Generating QR codes for {$students->count()} students...");
        
        $progressBar = $this->command->getOutput()->createProgressBar($students->count());
        $progressBar->start();
        
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($students as $student) {
            try {
                // Check if student already has QR code
                if (!$student->qrAttendance) {
                    $qrCodeService->generateQrCodeForStudent($student);
                    $successCount++;
                    $this->command->info("\n✅ Generated QR code for: {$student->name}");
                } else {
                    $this->command->info("\n⏭️ QR code already exists for: {$student->name}");
                }
                
                $progressBar->advance();
            } catch (\Exception $e) {
                $errorCount++;
                $this->command->error("\n❌ Failed to generate QR code for {$student->name}: " . $e->getMessage());
                $progressBar->advance();
            }
        }
        
        $progressBar->finish();
        $this->command->info("\n\n🎉 QR code generation completed!");
        $this->command->info("✅ Success: {$successCount}");
        $this->command->info("❌ Errors: {$errorCount}");
        
        if ($successCount > 0) {
            $this->command->info("\n📁 QR codes saved to: storage/app/public/qr-codes/");
            $this->command->info("🌐 Access via: /storage/qr-codes/");
        }
    }
}