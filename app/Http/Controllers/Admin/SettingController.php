<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Artisan, Storage, Hash, DB, Mail, File};
use Illuminate\Http\Request;
use App\Models\{Setting, AttendanceLog, User};
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        try {
            // Debug: Check for flash messages
            \Log::info('Settings index loaded:', [
                'has_success' => session()->has('success'),
                'success_message' => session('success'),
                'has_error' => session()->has('error'),
                'error_message' => session('error'),
                'all_session_data' => session()->all()
            ]);
            
            $settings = Setting::all()->keyBy('key');
            
            // Debug: Log current settings for troubleshooting
            \Log::info('Loading settings page:', [
                'total_settings' => $settings->count(),
                'school_logo' => $settings->get('school_logo')?->value ?? 'not found',
                'school_favicon' => $settings->get('school_favicon')?->value ?? 'not found',
                'school_name' => $settings->get('school_name')?->value ?? 'not found',
                'school_subtitle' => $settings->get('school_subtitle')?->value ?? 'not found'
            ]);
            
            // Verify file existence for logo settings
            if ($settings->has('school_logo') && $settings->get('school_logo')->value) {
                $logoPath = $settings->get('school_logo')->value;
                $storagePath = storage_path('app/public/' . $logoPath);
                $publicPath = public_path('storage/' . $logoPath);
                
                \Log::info('Logo file verification on page load:', [
                    'logo_path' => $logoPath,
                    'storage_exists' => file_exists($storagePath),
                    'public_exists' => file_exists($publicPath),
                    'storage_path' => $storagePath,
                    'public_path' => $publicPath
                ]);
            }
            
            // Get system information
            $systemInfo = $this->getSystemInfo();
            
            // Get recent activities
            $recentActivities = $this->getRecentActivities();
            
            return view('admin.settings.index', compact('settings', 'systemInfo', 'recentActivities'));
        } catch (\Exception $e) {
            \Log::error('Error loading settings page:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('admin.settings.index', [
                'settings' => collect(),
                'systemInfo' => [],
                'recentActivities' => [],
                'error' => 'Terjadi kesalahan saat memuat pengaturan.'
            ]);
        }
    }
    
    public function backup()
    {
        try {
            // Get backup path
            $backupPath = storage_path('app/backups');
            
            // Get backup list
            $backups = $this->getBackupList();
            
            return view('admin.settings.backup', compact('backupPath', 'backups'));
        } catch (\Exception $e) {
            \Log::error('Error loading backup page:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return view('admin.settings.backup', [
                'backupPath' => storage_path('app/backups'),
                'backups' => [],
                'error' => 'Terjadi kesalahan saat memuat halaman backup.'
            ]);
        }
    }

    public function update(Request $request)
    {
        try {
            // Debug: Log the incoming request
            \Log::info('Settings update request:', [
                'all_data' => $request->all(),
                'method' => $request->method(),
                'content_type' => $request->header('Content-Type')
            ]);
            
            // Simplified validation - no strict rules
            $validationRules = [];
            
            // Only validate if fields are present
            if ($request->has('academic_year')) {
                $validationRules['academic_year'] = 'nullable|string|max:20';
            }
            if ($request->has('semester')) {
                $validationRules['semester'] = 'nullable|in:1,2';
            }
            if ($request->has('school_timezone')) {
                $validationRules['school_timezone'] = 'nullable|string|max:50';
            }
            if ($request->has('attendance_start_time')) {
                $validationRules['attendance_start_time'] = 'nullable|date_format:H:i';
            }
            if ($request->has('attendance_end_time')) {
                $validationRules['attendance_end_time'] = 'nullable|date_format:H:i';
            }
            if ($request->has('late_tolerance_minutes')) {
                $validationRules['late_tolerance_minutes'] = 'nullable|integer|min:0|max:60';
            }
            if ($request->has('absent_threshold_minutes')) {
                $validationRules['absent_threshold_minutes'] = 'nullable|integer|min:15|max:120';
            }
            if ($request->has('max_upload_size')) {
                $validationRules['max_upload_size'] = 'nullable|integer|min:1|max:100';
            }
            if ($request->has('session_lifetime')) {
                $validationRules['session_lifetime'] = 'nullable|integer|min:30|max:1440';
            }
            if ($request->has('max_login_attempts')) {
                $validationRules['max_login_attempts'] = 'nullable|integer|min:3|max:10';
            }
            if ($request->has('backup_frequency')) {
                $validationRules['backup_frequency'] = 'nullable|in:daily,weekly,monthly';
            }
            if ($request->has('backup_retention_days')) {
                $validationRules['backup_retention_days'] = 'nullable|integer|min:7|max:365';
            }
            if ($request->hasFile('school_logo')) {
                $validationRules['school_logo'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
            }
            if ($request->hasFile('school_favicon')) {
                $validationRules['school_favicon'] = 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:1024';
            }
            if ($request->has('school_name')) {
                $validationRules['school_name'] = 'nullable|string|max:255';
            }
            if ($request->has('school_subtitle')) {
                $validationRules['school_subtitle'] = 'nullable|string|max:255';
            }

            
            if (!empty($validationRules)) {
                $request->validate($validationRules);
            }
            
            // Process file uploads first with enhanced logging
            $fileFields = ['school_logo', 'school_favicon'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    
                    \Log::info('Processing file upload:', [
                        'field' => $field,
                        'original_name' => $file->getClientOriginalName(),
                        'size' => $file->getSize(),
                        'mime_type' => $file->getMimeType(),
                        'tmp_name' => $file->getPathname(),
                        'is_valid' => $file->isValid(),
                        'error' => $file->getError()
                    ]);
                    
                    // Store file with better error handling
                    try {
                        // Validate file before processing
                        if (!$file->isValid()) {
                            throw new \Exception('Invalid file upload for ' . $field . '. Error code: ' . $file->getError());
                        }
                        
                        // Additional validation
                        if ($file->getError() !== UPLOAD_ERR_OK) {
                            throw new \Exception('File upload error for ' . $field . '. Error code: ' . $file->getError());
                        }
                        
                        // Validate file type
                        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                        if (!in_array($file->getMimeType(), $allowedTypes)) {
                            throw new \Exception('Invalid file type for ' . $field . '. Got: ' . $file->getMimeType());
                        }
                        
                        // Generate unique filename
                        $extension = $file->getClientOriginalExtension();
                        if (empty($extension)) {
                            $extension = 'png'; // Default extension
                        }
                        $filename = time() . '_' . uniqid() . '_' . $field . '.' . $extension;
                        
                        \Log::info('Generated filename:', [
                            'field' => $field,
                            'filename' => $filename,
                            'extension' => $extension
                        ]);
                        
                        // Ensure storage directory exists
                        $storageDir = storage_path('app/public/school');
                        if (!is_dir($storageDir)) {
                            mkdir($storageDir, 0755, true);
                            \Log::info('Created storage directory:', ['dir' => $storageDir]);
                        }
                        
                        // Use Laravel's storage with better error handling
                        try {
                            // Store file using Laravel's storage system
                            $path = Storage::disk('public')->putFileAs('school', $file, $filename);
                            
                            if (!$path) {
                                throw new \Exception('Storage::putFileAs returned false for ' . $field);
                            }
                            
                            \Log::info('File stored using Storage::putFileAs:', [
                                'field' => $field,
                                'filename' => $filename,
                                'returned_path' => $path
                            ]);
                            
                        } catch (\Exception $storageException) {
                            \Log::error('Storage::putFileAs failed, trying manual move:', [
                                'error' => $storageException->getMessage()
                            ]);
                            
                            // Fallback to manual file move
                            $destinationPath = storage_path('app/public/school');
                            
                            // Ensure destination exists
                            if (!is_dir($destinationPath)) {
                                mkdir($destinationPath, 0755, true);
                            }
                            
                            // Get temp file path
                            $tempPath = $file->getRealPath();
                            $destinationFile = $destinationPath . DIRECTORY_SEPARATOR . $filename;
                            
                            // Copy file manually
                            if (!copy($tempPath, $destinationFile)) {
                                throw new \Exception('Failed to copy file manually for ' . $field);
                            }
                            
                            $path = 'school/' . $filename;
                            
                            \Log::info('File stored manually:', [
                                'field' => $field,
                                'temp_path' => $tempPath,
                                'destination' => $destinationFile,
                                'final_path' => $path
                            ]);
                        }
                        
                        // Final validation of path
                        if (strpos($path, 'tmp') !== false || strpos($path, 'temp') !== false || strpos($path, 'C:') !== false) {
                            throw new \Exception('Invalid path generated: ' . $path);
                        }
                        
                        \Log::info('File stored successfully:', [
                            'field' => $field,
                            'original_name' => $file->getClientOriginalName(),
                            'stored_filename' => $filename,
                            'path' => $path,
                            'full_storage_path' => storage_path('app/public/' . $path),
                            'full_public_path' => public_path('storage/' . $path)
                        ]);
                        
                        // Verify file was actually stored
                        $storedFilePath = storage_path('app/public/' . $path);
                        $publicFilePath = public_path('storage/' . $path);
                        
                        if (!file_exists($storedFilePath)) {
                            throw new \Exception('File was not stored properly: ' . $storedFilePath);
                        }
                        
                        // Validate that path doesn't contain temp directory
                        if (strpos($path, 'tmp') !== false || strpos($path, 'temp') !== false) {
                            throw new \Exception('Invalid path detected (contains temp): ' . $path);
                        }
                        
                        // Delete old file if exists
                        $oldSetting = Setting::where('key', $field)->first();
                        if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                            \Log::info('Deleting old file:', ['old_path' => $oldSetting->value]);
                            Storage::disk('public')->delete($oldSetting->value);
                        }
                        
                        // Final validation before saving to database
                        if (empty($path) || strpos($path, 'tmp') !== false || strpos($path, 'C:') !== false) {
                            throw new \Exception('Invalid path before database save: ' . $path);
                        }
                        
                        // Save to database with additional validation
                        $setting = Setting::updateOrCreate(
                            ['key' => $field],
                            ['value' => $path, 'type' => 'file', 'group' => 'school']
                        );
                        
                        // Verify what was actually saved
                        $savedSetting = Setting::where('key', $field)->first();
                        
                        \Log::info('Setting saved to database:', [
                            'field' => $field,
                            'setting_id' => $setting->id,
                            'saved_value' => $savedSetting->value,
                            'expected_value' => $path,
                            'values_match' => ($savedSetting->value === $path),
                            'created_at' => $setting->created_at,
                            'updated_at' => $setting->updated_at
                        ]);
                        
                        // Final verification
                        \Log::info('Final file verification:', [
                            'storage_exists' => file_exists($storedFilePath),
                            'public_exists' => file_exists($publicFilePath),
                            'storage_path' => $storedFilePath,
                            'public_path' => $publicFilePath,
                            'asset_url' => asset('storage/' . $path),
                            'saved_path_in_db' => $savedSetting->value
                        ]);
                        
                        // Double check for temp paths in database
                        if (strpos($savedSetting->value, 'tmp') !== false) {
                            \Log::error('CRITICAL: Temp path saved to database!', [
                                'field' => $field,
                                'saved_value' => $savedSetting->value,
                                'expected_value' => $path
                            ]);
                            throw new \Exception('Temp path was saved to database: ' . $savedSetting->value);
                        }
                        
                    } catch (\Exception $e) {
                        \Log::error('Error processing file upload:', [
                            'field' => $field,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'file_info' => [
                                'tmp_name' => $file->getPathname(),
                                'original_name' => $file->getClientOriginalName(),
                                'size' => $file->getSize(),
                                'mime_type' => $file->getMimeType(),
                                'is_valid' => $file->isValid(),
                                'error_code' => $file->getError()
                            ]
                        ]);
                        
                        // Log detailed error and return user-friendly message
                        \Log::error('Complete file upload failure:', [
                            'field' => $field,
                            'error' => $e->getMessage(),
                            'trace' => $e->getTraceAsString(),
                            'request_data' => $request->except(['_token', '_method'])
                        ]);
                        
                        // Return error response with user-friendly message
                        return redirect()->back()
                                       ->withInput()
                                       ->with('error', 'Gagal mengupload file ' . $field . '. Silakan coba lagi atau hubungi administrator.');
                    }
                }
            }
            
            // Handle boolean fields - with hidden inputs, we always get values
            $booleanFields = [
                'maintenance_mode', 'allow_registration', 'auto_backup_enabled'
            ];
            
            // Process other settings (exclude file fields completely)
            $settingsData = $request->except(['_token', '_method'] + $fileFields);
            
            // Remove any file-related data that might have slipped through
            foreach ($fileFields as $fileField) {
                if (isset($settingsData[$fileField])) {
                    unset($settingsData[$fileField]);
                    \Log::info('Removed file field from settings data:', ['field' => $fileField]);
                }
            }
            
            \Log::info('Processing non-file settings:', [
                'settings_count' => count($settingsData),
                'settings_keys' => array_keys($settingsData)
            ]);
            
            foreach ($settingsData as $key => $value) {
                // Skip file fields (double check)
                if (in_array($key, $fileFields)) {
                    \Log::warning('Skipping file field in non-file processing:', ['key' => $key]);
                    continue;
                }
                
                // Skip empty values
                if ($value === null || $value === '') {
                    \Log::debug('Skipping empty setting:', ['key' => $key, 'value' => $value]);
                    continue;
                }
                
                // Determine setting group
                $group = $this->getSettingGroup($key);
                
                // Determine setting type
                $type = $this->getSettingType($key, $value);
                
                // Convert boolean values
                if (in_array($key, $booleanFields)) {
                    // With hidden inputs, checkbox will send array ['0', '1'] when checked, or just '0' when unchecked
                    if (is_array($value)) {
                        $value = in_array('1', $value) ? '1' : '0';
                    } else {
                        $value = ($value === '1' || $value === 1 || $value === true || $value === 'on') ? '1' : '0';
                    }
                }
                
                try {
                    Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value, 'type' => $type, 'group' => $group]
                    );
                } catch (\Exception $e) {
                    \Log::error('Error saving setting: ' . $key, [
                        'value' => $value,
                        'type' => $type,
                        'group' => $group,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Clear cache after updating settings
            try {
                \Log::info('Clearing caches after settings update');
                
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                
                // Clear settings cache specifically
                Setting::clearCache();
                
                // Clear static cache in AttendanceLog
                \App\Models\AttendanceLog::clearSettingsCache();
                \Log::info('All caches cleared successfully');
                
            } catch (\Exception $e) {
                \Log::warning('Cache clear failed: ' . $e->getMessage());
            }
            
            // Verify settings are saved correctly before redirect
            $savedSettings = Setting::whereIn('key', ['school_logo', 'school_favicon', 'school_name', 'school_subtitle'])
                                   ->get()
                                   ->keyBy('key');
            
            \Log::info('Settings verification after save:', [
                'school_logo' => $savedSettings->get('school_logo')?->value ?? 'not found',
                'school_favicon' => $savedSettings->get('school_favicon')?->value ?? 'not found',
                'school_name' => $savedSettings->get('school_name')?->value ?? 'not found',
                'school_subtitle' => $savedSettings->get('school_subtitle')?->value ?? 'not found'
            ]);
            
            // Check for any temp paths that might have been saved
            foreach ($savedSettings as $key => $setting) {
                if ($setting && strpos($setting->value, 'tmp') !== false) {
                    \Log::error('CRITICAL: Temp path found in saved settings!', [
                        'key' => $key,
                        'value' => $setting->value
                    ]);
                }
            }
            
            // Clear all possible caches one more time
            try {
                \Cache::flush();
                \Artisan::call('view:clear');
                \Log::info('Additional cache clear completed');
            } catch (\Exception $e) {
                \Log::warning('Additional cache clear failed: ' . $e->getMessage());
            }
            
            \Log::info('Settings update completed successfully');
            
            // Force session save before redirect
            session()->save();
            
            \Log::info('Setting flash message and redirecting');
            
            return redirect()->route('admin.settings.index')
                           ->with('success', 'Pengaturan berhasil diperbarui!')
                           ->with('logo_updated', true); // Flag to indicate logo was updated
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation error in settings update:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput()
                           ->with('error', 'Terdapat kesalahan validasi. Silakan periksa kembali.');
        } catch (\Exception $e) {
            \Log::error('Error updating settings:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['_token', '_method'])
            ]);
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan. Silakan coba lagi.');
        }
    }

    public function reset(Request $request)
    {
        try {
            \Log::info('Reset settings to default requested');
            
            // Reset settings to default values based on actual form fields
            $defaultSettings = [
                // School Settings
                'school_name' => 'SMK PGRI 2 PONOROGO',
                'school_subtitle' => 'Terbukti Lebih Maju',
                'school_description' => 'Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.',
                
                // Academic Settings
                'academic_year' => '2024/2025',
                'semester' => '1',
                'school_timezone' => 'Asia/Jakarta',
                'attendance_start_time' => '07:00',
                'attendance_end_time' => '07:30',
                
                // System Settings
                'maintenance_mode' => '0',
                'allow_registration' => '1',
                'max_upload_size' => '10',
                'session_lifetime' => '120',
                'max_login_attempts' => '5',
                
                // Appearance Settings
                'navbar_bg_color' => '#1a202c',
                'navbar_text_color' => '#ffffff',
                'navbar_hover_color' => '#3182ce',
                'navbar_hover_text_color' => '#ffffff',
                'navbar_active_color' => '#4299e1',
                
                // Backup Settings
                'auto_backup_enabled' => '0',
                'backup_frequency' => 'daily',
                'backup_retention_days' => '30',
            ];

            \Log::info('Resetting settings to default values:', $defaultSettings);

            foreach ($defaultSettings as $key => $value) {
                // Determine setting group and type
                $group = $this->getSettingGroup($key);
                $type = $this->getSettingType($key, $value);
                
                Setting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $value,
                        'type' => $type,
                        'group' => $group
                    ]
                );
                
                \Log::info('Reset setting:', [
                    'key' => $key,
                    'value' => $value,
                    'type' => $type,
                    'group' => $group
                ]);
            }
            
            // Note: We don't reset file settings (school_logo, school_favicon) 
            // as they would need to be re-uploaded by the user
            
            // Clear cache after resetting settings
            try {
                \Log::info('Clearing caches after settings reset');
                
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                
                // Clear settings cache specifically
                Setting::clearCache();
                
                \Log::info('All caches cleared successfully after reset');
                
            } catch (\Exception $e) {
                \Log::warning('Cache clear failed after reset: ' . $e->getMessage());
            }

            \Log::info('Settings reset completed successfully');

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil direset ke nilai default! Halaman akan dimuat ulang untuk menampilkan perubahan.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error resetting settings:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mereset pengaturan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clearCache(Request $request)
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('view:clear');
            Artisan::call('route:clear');

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dibersihkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan cache: ' . $e->getMessage()
            ], 500);
        }
    }

    public function optimize(Request $request)
    {
        try {
            Artisan::call('optimize');
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');

            return response()->json([
                'success' => true,
                'message' => 'Sistem berhasil dioptimasi!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengoptimasi sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createBackup(Request $request)
    {
        try {
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $filepath = $backupPath . '/' . $filename;

            // Simple database backup (you might want to use a more robust solution)
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.host'),
                config('database.connections.mysql.database'),
                $filepath
            );

            exec($command, $output, $returnVar);

            if ($returnVar === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Backup berhasil dibuat!',
                    'filename' => $filename
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat backup database'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function optimizeDatabase(Request $request)
    {
        try {
            DB::statement('OPTIMIZE TABLE users, roles, permissions, settings');

            return response()->json([
                'success' => true,
                'message' => 'Database berhasil dioptimasi!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengoptimasi database: ' . $e->getMessage()
            ], 500);
        }
    }

    public function clearLogs(Request $request)
    {
        try {
            $logPath = storage_path('logs');
            $files = glob($logPath . '/*.log');
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Log berhasil dibersihkan!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membersihkan log: ' . $e->getMessage()
            ], 500);
        }
    }

    public function systemHealth(Request $request)
    {
        try {
            $health = [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'database_connection' => 'OK',
                'storage_writable' => is_writable(storage_path()),
                'cache_writable' => is_writable(storage_path('framework/cache')),
                'logs_writable' => is_writable(storage_path('logs')),
                'disk_space' => disk_free_space('/') / 1024 / 1024 / 1024, // GB
                'memory_usage' => memory_get_usage(true) / 1024 / 1024, // MB
                'uptime' => exec('uptime'),
            ];

            // Test database connection
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                $health['database_connection'] = 'ERROR: ' . $e->getMessage();
            }

            return response()->json([
                'success' => true,
                'data' => $health
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengecek kesehatan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'template' => 'nullable|string|in:basic,welcome,notification,announcement'
        ]);

        try {
            $template = $request->get('template', 'basic');
            $schoolName = Setting::get('school_name', 'SMA Negeri 1');
            
            $templates = [
                'basic' => [
                    'subject' => 'Test Email - ' . $schoolName,
                    'content' => 'Ini adalah test email dari sistem ' . $schoolName . '. Jika Anda menerima email ini, konfigurasi email sudah benar.'
                ],
                'welcome' => [
                    'subject' => 'Selamat Datang di ' . $schoolName,
                    'content' => 'Selamat datang di sistem informasi ' . $schoolName . '. Akun Anda telah berhasil dibuat dan siap digunakan.'
                ],
                'notification' => [
                    'subject' => 'Notifikasi Sistem - ' . $schoolName,
                    'content' => 'Ini adalah contoh notifikasi dari sistem ' . $schoolName . '. Anda akan menerima notifikasi seperti ini untuk informasi penting.'
                ],
                'announcement' => [
                    'subject' => 'Pengumuman - ' . $schoolName,
                    'content' => 'Ini adalah contoh pengumuman dari ' . $schoolName . '. Pengumuman penting akan dikirim melalui email ini.'
                ]
            ];
            
            $emailData = $templates[$template];
            
            Mail::raw($emailData['content'], function ($message) use ($request, $emailData) {
                $message->to($request->email)
                        ->subject($emailData['subject']);
            });

            return response()->json([
                'success' => true,
                'message' => 'Email test berhasil dikirim ke ' . $request->email
            ]);
        } catch (\Exception $e) {
            \Log::error('Error sending test email:', [
                'error' => $e->getMessage(),
                'email' => $request->email
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email test: ' . $e->getMessage()
            ], 500);
        }
    }

    public function listBackups(Request $request)
    {
        try {
            $backups = $this->getBackupList();

            return response()->json([
                'success' => true,
                'data' => $backups
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil daftar backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function downloadBackup(Request $request)
    {
        $filename = $request->get('file');
        $filepath = storage_path('app/backups/' . $filename);

        if (!file_exists($filepath)) {
            abort(404, 'File backup tidak ditemukan');
        }

        return response()->download($filepath);
    }

    public function deleteBackup(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        try {
            $filepath = storage_path('app/backups/' . $request->filename);
            
            if (file_exists($filepath)) {
                unlink($filepath);
                return response()->json([
                    'success' => true,
                    'message' => 'Backup berhasil dihapus!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'File backup tidak ditemukan'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus backup: ' . $e->getMessage()
            ], 500);
        }
    }

    public function systemMonitoring(Request $request)
    {
        try {
            $monitoring = [
                'cpu_usage' => sys_getloadavg()[0] ?? 0,
                'memory_total' => memory_get_peak_usage(true) / 1024 / 1024,
                'memory_used' => memory_get_usage(true) / 1024 / 1024,
                'disk_total' => disk_total_space('/') / 1024 / 1024 / 1024,
                'disk_free' => disk_free_space('/') / 1024 / 1024 / 1024,
                'active_users' => User::where('last_login_at', '>=', now()->subMinutes(15))->count(),
                'total_users' => User::count(),
                'database_size' => $this->getDatabaseSize(),
                'log_size' => $this->getLogSize(),
            ];

            return response()->json([
                'success' => true,
                'data' => $monitoring
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data monitoring: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getDatabaseSize()
    {
        try {
            $result = DB::select('SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS "DB Size in MB" FROM information_schema.tables WHERE table_schema = ?', [config('database.connections.mysql.database')]);
            return $result[0]->{'DB Size in MB'} ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }

    private function getLogSize()
    {
        try {
            $logPath = storage_path('logs');
            $size = 0;
            $files = glob($logPath . '/*.log');
            
            foreach ($files as $file) {
                if (is_file($file)) {
                    $size += filesize($file);
                }
            }
            
            return round($size / 1024 / 1024, 2); // MB
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get setting group based on key
     */
    private function getSettingGroup($key)
    {
        $groups = [
            'school' => ['school_name', 'school_subtitle', 'school_address', 'school_phone', 'school_email', 'school_website', 'principal_name', 'school_npsn', 'school_accreditation', 'school_logo', 'school_favicon'],
            'academic' => ['academic_year', 'semester', 'school_timezone', 'attendance_start_time', 'attendance_end_time', 'late_tolerance_minutes', 'absent_threshold_minutes'],
            'system' => ['maintenance_mode', 'allow_registration', 'max_upload_size', 'session_lifetime', 'max_login_attempts'],
            'email' => ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_name'],
            'notification' => ['email_notifications_enabled', 'notification_frequency', 'registration_notifications', 'system_notifications', 'announcement_notifications', 'agenda_notifications'],
            'appearance' => ['navbar_bg_color', 'navbar_text_color', 'navbar_hover_color', 'navbar_hover_text_color', 'navbar_active_color'],
            'backup' => ['auto_backup_enabled', 'backup_frequency', 'backup_retention_days']
        ];
        
        foreach ($groups as $group => $keys) {
            if (in_array($key, $keys)) {
                return $group;
            }
        }
        
        return 'general';
    }
    
    /**
     * Get setting type based on key and value
     */
    private function getSettingType($key, $value)
    {
        $booleanKeys = [
            'maintenance_mode', 'allow_registration', 'email_notifications_enabled',
            'registration_notifications', 'system_notifications', 'announcement_notifications',
            'agenda_notifications', 'auto_backup_enabled'
        ];
        
        $integerKeys = [
            'max_upload_size', 'session_lifetime', 'max_login_attempts', 'mail_port',
            'backup_retention_days', 'late_tolerance_minutes'
        ];
        
        $emailKeys = ['school_email', 'mail_username'];
        $urlKeys = ['school_website'];
        $timeKeys = ['attendance_start_time', 'attendance_end_time'];
        
        if (in_array($key, $booleanKeys)) {
            return 'boolean';
        } elseif (in_array($key, $integerKeys)) {
            return 'integer';
        } elseif (in_array($key, $emailKeys)) {
            return 'email';
        } elseif (in_array($key, $urlKeys)) {
            return 'url';
        } elseif (in_array($key, $timeKeys)) {
            return 'time';
        }
        
        return 'string';
    }
    
    /**
     * Get system information
     */
    private function getSystemInfo()
    {
        try {
            return [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'server_software' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
                'database_version' => $this->getDatabaseVersion(),
                'storage_used' => $this->getStorageUsed(),
                'memory_limit' => ini_get('memory_limit'),
                'max_execution_time' => ini_get('max_execution_time'),
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'timezone' => config('app.timezone'),
                'environment' => config('app.env'),
                'debug_mode' => config('app.debug'),
                'cache_driver' => config('cache.default'),
                'session_driver' => config('session.driver'),
                'queue_driver' => config('queue.default'),
                'mail_driver' => config('mail.default')
            ];
        } catch (\Exception $e) {
            \Log::error('Error getting system info:', ['error' => $e->getMessage()]);
            return [];
        }
    }
    
    /**
     * Get database version
     */
    private function getDatabaseVersion()
    {
        try {
            $result = DB::select('SELECT VERSION() as version');
            return $result[0]->version ?? 'Unknown';
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }
    
    /**
     * Get storage used
     */
    private function getStorageUsed()
    {
        try {
            $storagePath = storage_path();
            $publicPath = public_path();
            
            $storageSize = $this->getDirectorySize($storagePath);
            $publicSize = $this->getDirectorySize($publicPath . '/storage');
            
            return round(($storageSize + $publicSize) / 1024 / 1024, 2); // MB
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get directory size
     */
    private function getDirectorySize($directory)
    {
        $size = 0;
        if (is_dir($directory)) {
            foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $file) {
                if ($file->isFile()) {
                    $size += $file->getSize();
                }
            }
        }
        return $size;
    }
    
    /**
     * Get recent activities
     */
    private function getRecentActivities()
    {
        try {
            $activities = [];
            
            // Recent user registrations
            $recentUsers = User::where('created_at', '>=', Carbon::now()->subDays(7))
                              ->orderBy('created_at', 'desc')
                              ->limit(5)
                              ->get();
            
            foreach ($recentUsers as $user) {
                $activities[] = [
                    'type' => 'user_registration',
                    'message' => 'User baru terdaftar: ' . $user->name,
                    'timestamp' => $user->created_at,
                    'icon' => 'user-plus',
                    'color' => 'green'
                ];
            }
            
            // Recent settings changes
            $recentSettings = Setting::where('updated_at', '>=', Carbon::now()->subDays(7))
                                    ->orderBy('updated_at', 'desc')
                                    ->limit(5)
                                    ->get();
            
            foreach ($recentSettings as $setting) {
                $activities[] = [
                    'type' => 'setting_change',
                    'message' => 'Pengaturan diubah: ' . str_replace('_', ' ', $setting->key),
                    'timestamp' => $setting->updated_at,
                    'icon' => 'cog',
                    'color' => 'blue'
                ];
            }
            
            // Sort by timestamp
            usort($activities, function($a, $b) {
                return $b['timestamp'] <=> $a['timestamp'];
            });
            
            return array_slice($activities, 0, 10);
        } catch (\Exception $e) {
            \Log::error('Error getting recent activities:', ['error' => $e->getMessage()]);
            return [];
        }
    }
    
    /**
     * Get backup list
     */
    private function getBackupList()
    {
        try {
            $backupPath = storage_path('app/backups');
            $backups = [];

            if (file_exists($backupPath)) {
                $files = File::files($backupPath);
                foreach ($files as $file) {
                    $backups[] = [
                        'name' => $file->getFilename(),
                        'type' => $this->getBackupType($file->getFilename()),
                        'size' => $this->formatFileSize($file->getSize()),
                        'date' => date('Y-m-d H:i:s', $file->getMTime())
                    ];
                }
                
                // Sort by date (newest first)
                usort($backups, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });
            }

            return $backups;
        } catch (\Exception $e) {
            \Log::error('Error getting backup list:', ['error' => $e->getMessage()]);
            return [];
        }
    }
    
    /**
     * Get backup type from filename
     */
    private function getBackupType($filename)
    {
        if (strpos($filename, 'full_backup') !== false) {
            return 'Full Backup';
        } elseif (strpos($filename, 'database') !== false || strpos($filename, '.sql') !== false) {
            return 'Database Only';
        } elseif (strpos($filename, 'files') !== false) {
            return 'Files Only';
        } else {
            return 'Unknown';
        }
    }
    
    /**
     * Format file size
     */
    private function formatFileSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}