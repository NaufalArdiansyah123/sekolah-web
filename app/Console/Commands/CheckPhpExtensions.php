<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckPhpExtensions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:extensions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check PHP extensions required for QR Code generation';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 Checking PHP Extensions for QR Code generation...');
        $this->newLine();
        
        // Check GD Extension
        if (extension_loaded('gd')) {
            $this->info('✅ GD Extension: ENABLED');
            $gdInfo = gd_info();
            $this->line("   Version: " . ($gdInfo['GD Version'] ?? 'Unknown'));
            $this->line("   PNG Support: " . ($gdInfo['PNG Support'] ? 'Yes' : 'No'));
            $this->line("   JPEG Support: " . ($gdInfo['JPEG Support'] ? 'Yes' : 'No'));
        } else {
            $this->error('❌ GD Extension: NOT ENABLED');
            $this->warn('   GD extension is required for QR code image generation');
        }
        
        $this->newLine();
        
        // Check Imagick Extension
        if (extension_loaded('imagick')) {
            $this->info('✅ Imagick Extension: ENABLED');
            $imagick = new \Imagick();
            $this->line("   Version: " . $imagick->getVersion()['versionString']);
        } else {
            $this->warn('⚠️  Imagick Extension: NOT ENABLED (Optional)');
        }
        
        $this->newLine();
        
        // Check other required extensions
        $requiredExtensions = [
            'mbstring' => 'Multi-byte string support',
            'fileinfo' => 'File information support',
            'json' => 'JSON support'
        ];
        
        foreach ($requiredExtensions as $ext => $description) {
            if (extension_loaded($ext)) {
                $this->info("✅ {$ext}: ENABLED");
            } else {
                $this->error("❌ {$ext}: NOT ENABLED - {$description}");
            }
        }
        
        $this->newLine();
        
        // PHP Info
        $this->info('📋 PHP Information:');
        $this->line('   PHP Version: ' . PHP_VERSION);
        $this->line('   PHP SAPI: ' . PHP_SAPI);
        $this->line('   OS: ' . PHP_OS);
        
        $this->newLine();
        
        // Recommendations
        if (!extension_loaded('gd')) {
            $this->warn('🔧 To enable GD extension in XAMPP:');
            $this->line('   1. Open php.ini file (usually in C:\\xampp\\php\\php.ini)');
            $this->line('   2. Find line: ;extension=gd');
            $this->line('   3. Remove semicolon: extension=gd');
            $this->line('   4. Restart Apache server');
            $this->line('   5. Run: php artisan check:extensions');
        } else {
            $this->info('🎉 All required extensions are available!');
            $this->line('   You can now run: php artisan qr:test');
        }
        
        return 0;
    }
}