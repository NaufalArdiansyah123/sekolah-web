<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;
use Carbon\Carbon;

class BackupController extends Controller
{
    private $backupPath;

    public function __construct()
    {
        // Use storage path for better compatibility
        $this->backupPath = storage_path('app/backups');
        
        // Create backup directory if it doesn't exist
        if (!File::exists($this->backupPath)) {
            File::makeDirectory($this->backupPath, 0755, true);
        }
    }

    /**
     * Show backup management page
     */
    public function index()
    {
        $backups = $this->getBackupList();
        
        return view('admin.settings.backup', [
            'title' => 'Backup Management',
            'backups' => $backups,
            'backupPath' => $this->backupPath
        ]);
    }

    /**
     * Create full backup (database + files)
     */
    public function createFullBackup(Request $request)
    {
        try {
            // Check if ZIP extension is available
            if (!extension_loaded('zip')) {
                return response()->json([
                    'success' => false,
                    'message' => 'ZIP extension is not available on this server.'
                ], 500);
            }

            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupName = "full_backup_{$timestamp}";
            $backupDir = $this->backupPath . '/' . $backupName;
            
            // Create backup directory
            if (!File::makeDirectory($backupDir, 0755, true)) {
                throw new \Exception('Failed to create backup directory');
            }
            
            // 1. Backup Database
            $this->backupDatabase($backupDir);
            
            // 2. Backup Project Files (simplified)
            $this->backupProjectFiles($backupDir);
            
            // 3. Create ZIP archive
            $zipPath = $this->createZipArchive($backupDir, $backupName);
            
            // 4. Clean up temporary directory
            File::deleteDirectory($backupDir);
            
            // Verify ZIP file exists
            if (!File::exists($zipPath)) {
                throw new \Exception('ZIP file was not created successfully');
            }
            
            $fileSize = filesize($zipPath);
            
            return response()->json([
                'success' => true,
                'message' => 'Full backup created successfully!',
                'backup_name' => $backupName . '.zip',
                'backup_path' => $zipPath,
                'size' => $this->formatBytes($fileSize)
            ]);
            
        } catch (\Exception $e) {
            Log::error('Full backup failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create database backup only
     */
    public function createDatabaseBackup(Request $request)
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupName = "database_backup_{$timestamp}";
            $backupDir = $this->backupPath . '/' . $backupName;
            
            // Create backup directory
            File::makeDirectory($backupDir, 0755, true);
            
            // Backup Database
            $this->backupDatabase($backupDir);
            
            // Create ZIP archive
            $zipPath = $this->createZipArchive($backupDir, $backupName);
            
            // Clean up temporary directory
            File::deleteDirectory($backupDir);
            
            return response()->json([
                'success' => true,
                'message' => 'Database backup created successfully!',
                'backup_name' => $backupName . '.zip',
                'backup_path' => $zipPath,
                'size' => $this->formatBytes(filesize($zipPath))
            ]);
            
        } catch (\Exception $e) {
            Log::error('Database backup failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Database backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create files backup only
     */
    public function createFilesBackup(Request $request)
    {
        try {
            $timestamp = Carbon::now()->format('Y-m-d_H-i-s');
            $backupName = "files_backup_{$timestamp}";
            $backupDir = $this->backupPath . '/' . $backupName;
            
            // Create backup directory
            File::makeDirectory($backupDir, 0755, true);
            
            // Backup Project Files
            $this->backupProjectFiles($backupDir);
            
            // Create ZIP archive
            $zipPath = $this->createZipArchive($backupDir, $backupName);
            
            // Clean up temporary directory
            File::deleteDirectory($backupDir);
            
            return response()->json([
                'success' => true,
                'message' => 'Files backup created successfully!',
                'backup_name' => $backupName . '.zip',
                'backup_path' => $zipPath,
                'size' => $this->formatBytes(filesize($zipPath))
            ]);
            
        } catch (\Exception $e) {
            Log::error('Files backup failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Files backup failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download backup file
     */
    public function downloadBackup($filename)
    {
        $filePath = $this->backupPath . '/' . $filename;
        
        if (!File::exists($filePath)) {
            abort(404, 'Backup file not found');
        }
        
        return response()->download($filePath);
    }

    /**
     * Delete backup file
     */
    public function deleteBackup(Request $request)
    {
        $filename = $request->input('filename');
        $filePath = $this->backupPath . '/' . $filename;
        
        if (File::exists($filePath)) {
            File::delete($filePath);
            
            return response()->json([
                'success' => true,
                'message' => 'Backup deleted successfully!'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Backup file not found!'
        ], 404);
    }

    /**
     * Backup database using Laravel DB (simplified)
     */
    private function backupDatabase($backupDir)
    {
        try {
            $sqlFile = $backupDir . '/database_backup.sql';
            
            // Get all tables
            $tables = DB::select('SHOW TABLES');
            $dbName = config('database.connections.' . config('database.default'))['database'];
            
            $sql = "-- Database Backup\n";
            $sql .= "-- Generated on: " . Carbon::now()->toDateTimeString() . "\n";
            $sql .= "-- Database: {$dbName}\n\n";
            
            $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";
            
            foreach ($tables as $table) {
                $tableName = array_values((array) $table)[0];
                
                try {
                    // Get table structure
                    $createTable = DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
                    $sql .= "-- Table structure for `{$tableName}`\n";
                    $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
                    $sql .= $createTable->{'Create Table'} . ";\n\n";
                    
                    // Get table data (limit to prevent memory issues)
                    $rows = DB::table($tableName)->limit(1000)->get();
                    if ($rows->count() > 0) {
                        $sql .= "-- Data for table `{$tableName}`\n";
                        
                        foreach ($rows as $row) {
                            $values = [];
                            foreach ((array) $row as $value) {
                                if ($value === null) {
                                    $values[] = 'NULL';
                                } else {
                                    $values[] = "'" . addslashes($value) . "'";
                                }
                            }
                            $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(',', $values) . ");\n";
                        }
                        $sql .= "\n";
                    }
                } catch (\Exception $e) {
                    $sql .= "-- Error backing up table {$tableName}: " . $e->getMessage() . "\n\n";
                }
            }
            
            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            
            File::put($sqlFile, $sql);
            
            // Create database info file
            $dbInfo = [
                'database_name' => $dbName,
                'backup_date' => Carbon::now()->toDateTimeString(),
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,
                'backup_method' => 'laravel_db'
            ];
            
            File::put($backupDir . '/database_info.json', json_encode($dbInfo, JSON_PRETTY_PRINT));
            
        } catch (\Exception $e) {
            throw new \Exception('Database backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Backup project files (simplified)
     */
    private function backupProjectFiles($backupDir)
    {
        try {
            $projectRoot = base_path();
            $filesDir = $backupDir . '/project_files';
            
            // Create project files directory
            File::makeDirectory($filesDir, 0755, true);
            
            // Define important files to backup
            $filesToBackup = [
                '.env.example',
                'composer.json',
                'artisan'
            ];
            
            // Define directories to backup (simplified)
            $directoriesToBackup = [
                'app',
                'config',
                'database/migrations',
                'database/seeders',
                'resources/views',
                'routes'
            ];
            
            // Copy important files
            foreach ($filesToBackup as $file) {
                $sourcePath = $projectRoot . '/' . $file;
                $destPath = $filesDir . '/' . $file;
                
                if (File::exists($sourcePath)) {
                    File::copy($sourcePath, $destPath);
                }
            }
            
            // Copy directories (simplified)
            foreach ($directoriesToBackup as $dir) {
                $sourcePath = $projectRoot . '/' . $dir;
                $destPath = $filesDir . '/' . $dir;
                
                if (File::exists($sourcePath)) {
                    $this->copyDirectorySimple($sourcePath, $destPath);
                }
            }
            
            // Create project info file
            $projectInfo = [
                'project_name' => 'SMK PGRI 2 PONOROGO - School Management System',
                'backup_date' => Carbon::now()->toDateTimeString(),
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,
                'directories_backed_up' => $directoriesToBackup,
                'files_backed_up' => $filesToBackup
            ];
            
            File::put($backupDir . '/project_info.json', json_encode($projectInfo, JSON_PRETTY_PRINT));
            
        } catch (\Exception $e) {
            throw new \Exception('Project files backup failed: ' . $e->getMessage());
        }
    }

    /**
     * Simple directory copy without complex exclusions
     */
    private function copyDirectorySimple($source, $destination)
    {
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }
        
        $files = File::allFiles($source);
        
        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            $destFile = $destination . '/' . $relativePath;
            
            // Skip cache and log files
            if (strpos($relativePath, 'cache') !== false || 
                strpos($relativePath, 'logs') !== false ||
                strpos($relativePath, '.git') !== false) {
                continue;
            }
            
            $destDir = dirname($destFile);
            if (!File::exists($destDir)) {
                File::makeDirectory($destDir, 0755, true);
            }
            
            File::copy($file->getPathname(), $destFile);
        }
    }

    /**
     * Create ZIP archive from directory
     */
    private function createZipArchive($sourceDir, $backupName)
    {
        $zipPath = $this->backupPath . '/' . $backupName . '.zip';
        $zip = new ZipArchive();
        
        $result = $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($result !== TRUE) {
            throw new \Exception('Cannot create ZIP archive. Error code: ' . $result);
        }
        
        $files = File::allFiles($sourceDir);
        
        foreach ($files as $file) {
            $relativePath = str_replace($sourceDir . DIRECTORY_SEPARATOR, '', $file->getPathname());
            $relativePath = str_replace('\\', '/', $relativePath);
            $zip->addFile($file->getPathname(), $relativePath);
        }
        
        $zip->close();
        
        return $zipPath;
    }

    /**
     * Get list of existing backups
     */
    private function getBackupList()
    {
        $backups = [];
        
        if (!File::exists($this->backupPath)) {
            return $backups;
        }
        
        try {
            $files = File::files($this->backupPath);
            
            foreach ($files as $file) {
                if ($file->getExtension() === 'zip') {
                    $backups[] = [
                        'name' => $file->getFilename(),
                        'size' => $this->formatBytes($file->getSize()),
                        'date' => Carbon::createFromTimestamp($file->getMTime())->format('Y-m-d H:i:s'),
                        'type' => $this->getBackupType($file->getFilename())
                    ];
                }
            }
            
            // Sort by date (newest first)
            usort($backups, function($a, $b) {
                return strtotime($b['date']) - strtotime($a['date']);
            });
            
        } catch (\Exception $e) {
            Log::error('Error getting backup list: ' . $e->getMessage());
        }
        
        return $backups;
    }

    /**
     * Get backup type from filename
     */
    private function getBackupType($filename)
    {
        if (strpos($filename, 'full_backup') !== false) {
            return 'Full Backup';
        } elseif (strpos($filename, 'database_backup') !== false) {
            return 'Database Only';
        } elseif (strpos($filename, 'files_backup') !== false) {
            return 'Files Only';
        }
        
        return 'Unknown';
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}