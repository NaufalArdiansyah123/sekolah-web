<?php

namespace App\Services;

use App\Models\Student;
use App\Models\QrAttendance;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;

class QrCodeService
{
    /**
     * Check if GD extension is available
     */
    private function isGdAvailable(): bool
    {
        return extension_loaded('gd');
    }
    
    /**
     * Get appropriate writer based on available extensions
     */
    private function getWriter(): object
    {
        if ($this->isGdAvailable()) {
            return new PngWriter();
        } else {
            return new SvgWriter();
        }
    }
    
    /**
     * Get file extension based on writer
     */
    private function getFileExtension(): string
    {
        return $this->isGdAvailable() ? 'png' : 'svg';
    }
    
    /**
     * Generate QR Code untuk student
     */
    public function generateQrCodeForStudent(Student $student): QrAttendance
    {
        // Generate unique QR code
        $qrCode = QrAttendance::generateQrCode($student->id);
        
        try {
            // Create QR code image using Endroid QR Code
            $result = Builder::create()
                ->writer($this->getWriter())
                ->data($qrCode)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->build();
            
            // Get QR code image data
            $qrCodeImage = $result->getString();
            
            // Save QR code image
            $extension = $this->getFileExtension();
            $fileName = 'qr-codes/student-' . $student->id . '-' . time() . '.' . $extension;
            Storage::disk('public')->put($fileName, $qrCodeImage);
            
            // Save or update QR attendance record
            $qrAttendance = QrAttendance::updateOrCreate(
                ['student_id' => $student->id],
                [
                    'qr_code' => $qrCode,
                    'qr_image_path' => $fileName,
                ]
            );
            
            return $qrAttendance;
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate QR code: ' . $e->getMessage());
        }
    }
    
    /**
     * Generate QR Code dengan data custom
     */
    public function generateCustomQrCode(array $data): string
    {
        $qrData = json_encode($data);
        
        try {
            $result = Builder::create()
                ->writer($this->getWriter())
                ->data($qrData)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin)
                ->build();
            
            return $result->getString();
            
        } catch (\Exception $e) {
            throw new \Exception('Failed to generate custom QR code: ' . $e->getMessage());
        }
    }
    
    /**
     * Validate QR Code
     */
    public function validateQrCode(string $qrCode): ?QrAttendance
    {
        return QrAttendance::where('qr_code', $qrCode)->first();
    }
    
    /**
     * Generate QR Code untuk multiple students
     */
    public function generateQrCodesForMultipleStudents(array $studentIds): array
    {
        $results = [];
        
        foreach ($studentIds as $studentId) {
            $student = Student::find($studentId);
            if ($student) {
                $results[] = $this->generateQrCodeForStudent($student);
            }
        }
        
        return $results;
    }
    
    /**
     * Regenerate QR Code untuk student
     */
    public function regenerateQrCodeForStudent(Student $student): QrAttendance
    {
        // Delete old QR code image if exists
        $existingQr = $student->qrAttendance;
        if ($existingQr && $existingQr->qr_image_path) {
            Storage::disk('public')->delete($existingQr->qr_image_path);
        }
        
        // Generate new QR code
        return $this->generateQrCodeForStudent($student);
    }
    
    /**
     * Get QR Code data untuk student
     */
    public function getStudentQrData(Student $student): array
    {
        return [
            'student_id' => $student->id,
            'nis' => $student->nis,
            'name' => $student->name,
            'class' => $student->class,
            'generated_at' => now()->toISOString(),
        ];
    }
}