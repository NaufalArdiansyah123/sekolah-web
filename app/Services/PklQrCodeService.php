<?php

namespace App\Services;

use App\Models\PklRegistration;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\SvgWriter;

class PklQrCodeService
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
     * Generate QR Code untuk PKL registration
     */
    public function generateQrCodeForRegistration(PklRegistration $registration): PklRegistration
    {
        // Generate unique QR code
        $qrCode = PklRegistration::generateQrCode($registration->id);

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
            $fileName = 'pkl-qr-codes/pkl-registration-' . $registration->id . '-' . time() . '.' . $extension;
            Storage::disk('public')->put($fileName, $qrCodeImage);

            // Update registration record
            $registration->update([
                'qr_code' => $qrCode,
                'qr_image_path' => $fileName,
            ]);

            return $registration->fresh();

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
    public function validateQrCode(string $qrCode): ?PklRegistration
    {
        return PklRegistration::where('qr_code', $qrCode)->first();
    }

    /**
     * Regenerate QR Code untuk registration
     */
    public function regenerateQrCodeForRegistration(PklRegistration $registration): PklRegistration
    {
        // Delete old QR code image if exists
        if ($registration->qr_image_path) {
            Storage::disk('public')->delete($registration->qr_image_path);
        }

        // Generate new QR code
        return $this->generateQrCodeForRegistration($registration);
    }

    /**
     * Get QR Code data untuk registration
     */
    public function getRegistrationQrData(PklRegistration $registration): array
    {
        return [
            'registration_id' => $registration->id,
            'student_id' => $registration->student_id,
            'student_name' => $registration->student->name ?? '',
            'tempat_pkl' => $registration->tempatPkl->nama_tempat ?? '',
            'status' => $registration->status,
            'generated_at' => now()->toISOString(),
        ];
    }
}
