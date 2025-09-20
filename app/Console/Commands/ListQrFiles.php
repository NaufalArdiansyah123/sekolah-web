<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\QrAttendance;

class ListQrFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qr:files {--orphaned : Show only orphaned files} {--missing : Show only missing files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List QR code files in storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📁 QR Code Files Report');
        $this->newLine();

        $storagePath = 'qr-codes';
        
        // Check if directory exists
        if (!Storage::disk('public')->exists($storagePath)) {
            $this->error("❌ QR codes directory not found: storage/app/public/{$storagePath}");
            $this->info('💡 Create directory with: mkdir -p storage/app/public/qr-codes');
            return 1;
        }

        // Get all files in QR codes directory
        $files = Storage::disk('public')->files($storagePath);
        $qrRecords = QrAttendance::with('student')->get();

        $this->info("📊 Summary:");
        $this->line("   Files in storage: " . count($files));
        $this->line("   QR records in DB: " . $qrRecords->count());
        $this->newLine();

        if ($this->option('orphaned')) {
            $this->showOrphanedFiles($files, $qrRecords);
        } elseif ($this->option('missing')) {
            $this->showMissingFiles($qrRecords);
        } else {
            $this->showAllFiles($files, $qrRecords);
        }

        return 0;
    }

    /**
     * Show all QR code files
     */
    private function showAllFiles($files, $qrRecords)
    {
        $this->info('📄 All QR Code Files:');
        
        if (empty($files)) {
            $this->warn('   No QR code files found in storage.');
            return;
        }

        $headers = ['File', 'Size', 'Modified', 'Student', 'Status'];
        $rows = [];

        foreach ($files as $file) {
            $filePath = Storage::disk('public')->path($file);
            $fileSize = $this->formatBytes(filesize($filePath));
            $modified = date('d/m/Y H:i', filemtime($filePath));
            
            // Find corresponding QR record
            $qrRecord = $qrRecords->firstWhere('qr_image_path', $file);
            
            if ($qrRecord) {
                $studentName = $qrRecord->student->name ?? 'Unknown';
                $status = '✅ Linked';
            } else {
                $studentName = '-';
                $status = '⚠️ Orphaned';
            }

            $rows[] = [
                basename($file),
                $fileSize,
                $modified,
                $studentName,
                $status
            ];
        }

        $this->table($headers, $rows);
        
        // Show access URLs for first few files
        $this->newLine();
        $this->info('🌐 Access URLs (first 3):');
        foreach (array_slice($files, 0, 3) as $file) {
            $url = asset('storage/' . $file);
            $this->line("   " . basename($file) . ": {$url}");
        }
        if (count($files) > 3) {
            $this->line("   ... and " . (count($files) - 3) . " more files");
        }
    }

    /**
     * Show orphaned files (files without DB records)
     */
    private function showOrphanedFiles($files, $qrRecords)
    {
        $this->info('⚠️ Orphaned QR Code Files (no DB record):');
        
        $orphanedFiles = [];
        $dbFiles = $qrRecords->pluck('qr_image_path')->toArray();
        
        foreach ($files as $file) {
            if (!in_array($file, $dbFiles)) {
                $orphanedFiles[] = $file;
            }
        }

        if (empty($orphanedFiles)) {
            $this->info('   🎉 No orphaned files found! All files are properly linked.');
            return;
        }

        $headers = ['File', 'Size', 'Modified', 'Action'];
        $rows = [];

        foreach ($orphanedFiles as $file) {
            $filePath = Storage::disk('public')->path($file);
            $fileSize = $this->formatBytes(filesize($filePath));
            $modified = date('d/m/Y H:i', filemtime($filePath));

            $rows[] = [
                basename($file),
                $fileSize,
                $modified,
                'Can be deleted'
            ];
        }

        $this->table($headers, $rows);
        
        $this->newLine();
        $this->warn('💡 These files can be safely deleted as they have no corresponding database records.');
    }

    /**
     * Show missing files (DB records without files)
     */
    private function showMissingFiles($qrRecords)
    {
        $this->info('❌ Missing QR Code Files (DB record exists but file missing):');
        
        $missingFiles = [];
        
        foreach ($qrRecords as $qrRecord) {
            if (!Storage::disk('public')->exists($qrRecord->qr_image_path)) {
                $missingFiles[] = $qrRecord;
            }
        }

        if (empty($missingFiles)) {
            $this->info('   🎉 No missing files! All DB records have corresponding files.');
            return;
        }

        $headers = ['Student', 'NIS', 'Expected File', 'Created', 'Action'];
        $rows = [];

        foreach ($missingFiles as $qrRecord) {
            $rows[] = [
                $qrRecord->student->name ?? 'Unknown',
                $qrRecord->student->nis ?? 'N/A',
                basename($qrRecord->qr_image_path),
                $qrRecord->created_at->format('d/m/Y H:i'),
                'Regenerate QR'
            ];
        }

        $this->table($headers, $rows);
        
        $this->newLine();
        $this->warn('💡 These QR codes need to be regenerated:');
        $this->line('   php artisan db:seed --class=QrAttendanceSeeder');
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