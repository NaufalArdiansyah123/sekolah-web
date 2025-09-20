<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\QrCodeService;
use Illuminate\Support\Facades\Storage;

class TestQrCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test QR Code generation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🧪 Testing QR Code generation...');
        $this->newLine();
        
        // Check PHP extensions first
        $this->info('🔍 Checking PHP extensions...');
        $gdAvailable = extension_loaded('gd');
        $imagickAvailable = extension_loaded('imagick');
        
        if ($gdAvailable) {
            $this->info('✅ GD Extension: Available');
        } else {
            $this->warn('⚠️  GD Extension: Not available - will use SVG format');
        }
        
        if ($imagickAvailable) {
            $this->info('✅ Imagick Extension: Available');
        } else {
            $this->line('ℹ️  Imagick Extension: Not available (optional)');
        }
        
        $this->newLine();
        
        try {
            $qrCodeService = new QrCodeService();
            
            // Test custom QR code generation
            $testData = [
                'test' => true,
                'message' => 'Hello QR Code!',
                'timestamp' => now()->toISOString()
            ];
            
            $this->info('📝 Generating test QR code...');
            $qrCodeImage = $qrCodeService->generateCustomQrCode($testData);
            
            // Determine file extension based on available extensions
            $extension = $gdAvailable ? 'png' : 'svg';
            $fileName = 'qr-codes/test-qr-' . time() . '.' . $extension;
            
            // Save test QR code
            Storage::disk('public')->put($fileName, $qrCodeImage);
            
            $this->info('✅ Test QR code generated successfully!');
            $this->info("📁 Saved to: storage/app/public/{$fileName}");
            $this->info("🌐 Access via: " . asset("storage/{$fileName}"));
            $this->info("📄 Format: " . strtoupper($extension) . ($gdAvailable ? ' (PNG with GD)' : ' (SVG fallback)'));
            
            // Check if storage directory exists and is writable
            $storagePath = storage_path('app/public/qr-codes');
            if (!is_dir($storagePath)) {
                $this->error("❌ Directory does not exist: {$storagePath}");
                return 1;
            }
            
            if (!is_writable($storagePath)) {
                $this->error("❌ Directory is not writable: {$storagePath}");
                return 1;
            }
            
            $this->info("✅ Storage directory is ready: {$storagePath}");
            
            $this->newLine();
            
            if (!$gdAvailable) {
                $this->warn('💡 To enable PNG format (recommended):');
                $this->line('   1. Open php.ini file (C:\\xampp\\php\\php.ini)');
                $this->line('   2. Find: ;extension=gd');
                $this->line('   3. Change to: extension=gd');
                $this->line('   4. Restart Apache');
                $this->line('   5. Run: php artisan check:extensions');
            } else {
                $this->info('🎉 All systems ready! You can now run:');
                $this->line('   php artisan db:seed --class=QrAttendanceSeeder');
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('❌ QR Code generation failed: ' . $e->getMessage());
            
            if (str_contains($e->getMessage(), 'GD')) {
                $this->newLine();
                $this->warn('🔧 This error is related to GD extension. Try:');
                $this->line('   php artisan check:extensions');
            }
            
            return 1;
        }
    }
}