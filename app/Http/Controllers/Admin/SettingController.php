<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Role, Permission, Setting};
use Illuminate\Support\Facades\{Hash, Artisan, DB, Mail, Storage, File};
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $settings = Setting::all()->keyBy('key');
            
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

    public function update(Request $request)
    {
        try {
            $validationRules = [
                // School Information
                'school_name' => 'required|string|max:255',
                'school_address' => 'nullable|string|max:500',
                'school_phone' => 'nullable|string|max:20',
                'school_email' => 'nullable|email|max:255',
                'school_website' => 'nullable|url|max:255',
                'principal_name' => 'nullable|string|max:255',
                'school_npsn' => 'nullable|string|max:20',
                'school_accreditation' => 'nullable|string|max:10',
                
                // Academic Settings
                'academic_year' => 'nullable|string|max:20',
                'semester' => 'nullable|in:1,2',
                'school_timezone' => 'nullable|string|max:50',
                'attendance_start_time' => 'nullable|date_format:H:i',
                'attendance_end_time' => 'nullable|date_format:H:i',
                'late_tolerance_minutes' => 'nullable|integer|min:0|max:60',
                
                // System Settings
                'maintenance_mode' => 'nullable|boolean',
                'allow_registration' => 'nullable|boolean',
                'max_upload_size' => 'nullable|integer|min:1|max:100',
                'session_lifetime' => 'nullable|integer|min:30|max:1440',
                'max_login_attempts' => 'nullable|integer|min:3|max:10',
                
                // Email Settings
                'mail_host' => 'nullable|string|max:255',
                'mail_port' => 'nullable|integer|min:1|max:65535',
                'mail_username' => 'nullable|email|max:255',
                'mail_password' => 'nullable|string|max:255',
                'mail_encryption' => 'nullable|in:tls,ssl,',
                'mail_from_name' => 'nullable|string|max:255',
                
                // Notification Settings
                'email_notifications_enabled' => 'nullable|boolean',
                'notification_frequency' => 'nullable|in:instant,hourly,daily,weekly',
                'registration_notifications' => 'nullable|boolean',
                'system_notifications' => 'nullable|boolean',
                'announcement_notifications' => 'nullable|boolean',
                'agenda_notifications' => 'nullable|boolean',
                
                // Backup Settings
                'auto_backup_enabled' => 'nullable|boolean',
                'backup_frequency' => 'nullable|in:daily,weekly,monthly',
                'backup_retention_days' => 'nullable|integer|min:7|max:365',
                
                // Files
                'school_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'school_favicon' => 'nullable|image|mimes:ico,png|max:512',
            ];
            
            $request->validate($validationRules);
            
            // Process file uploads first
            $fileFields = ['school_logo', 'school_favicon'];
            foreach ($fileFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $path = $file->store('school', 'public');
                    
                    // Delete old file if exists
                    $oldSetting = Setting::where('key', $field)->first();
                    if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                        Storage::disk('public')->delete($oldSetting->value);
                    }
                    
                    Setting::updateOrCreate(
                        ['key' => $field],
                        ['value' => $path, 'type' => 'file', 'group' => 'school']
                    );
                }
            }
            
            // Handle boolean fields that might not be present in request (unchecked checkboxes)
            $booleanFields = [
                'maintenance_mode', 'allow_registration', 'email_notifications_enabled',
                'registration_notifications', 'system_notifications', 'announcement_notifications',
                'agenda_notifications', 'auto_backup_enabled'
            ];
            
            // Set boolean fields to 0 if not present in request
            foreach ($booleanFields as $field) {
                if (!$request->has($field)) {
                    $request->merge([$field => '0']);
                }
            }
            
            // Process other settings
            $settingsData = $request->except(['_token', '_method'] + $fileFields);
            
            foreach ($settingsData as $key => $value) {
                // Determine setting group
                $group = $this->getSettingGroup($key);
                
                // Determine setting type
                $type = $this->getSettingType($key, $value);
                
                // Convert boolean values
                if (is_bool($value) || in_array($value, ['0', '1', 'true', 'false'])) {
                    $value = $value ? '1' : '0';
                }
                
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'type' => $type, 'group' => $group]
                );
            }
            
            // Clear cache after updating settings
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
            
            return redirect()->route('admin.settings')
                           ->with('success', 'Pengaturan berhasil diperbarui!');
                           
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput()
                           ->with('error', 'Terdapat kesalahan validasi. Silakan periksa kembali.');
        } catch (\Exception $e) {
            \Log::error('Error updating settings:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Terjadi kesalahan saat menyimpan pengaturan: ' . $e->getMessage());
        }
    }

    public function reset(Request $request)
    {
        try {
            // Reset settings to default values
            $defaultSettings = [
                'site_name' => 'School Management System',
                'site_description' => 'Sistem Manajemen Sekolah',
                'site_email' => 'admin@school.com',
                'site_phone' => '',
                'site_address' => '',
                'maintenance_mode' => 'false',
                'registration_enabled' => 'true',
                'email_notifications' => 'true',
                'sms_notifications' => 'false',
                'backup_frequency' => 'daily',
                'max_file_size' => '10',
                'allowed_file_types' => 'jpg,jpeg,png,pdf,doc,docx',
                'timezone' => 'Asia/Jakarta',
                'date_format' => 'd/m/Y',
                'time_format' => 'H:i',
            ];

            foreach ($defaultSettings as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Pengaturan berhasil direset ke default!'
            ]);
        } catch (\Exception $e) {
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
            $backupPath = storage_path('app/backups');
            $backups = [];

            if (file_exists($backupPath)) {
                $files = glob($backupPath . '/*.sql');
                foreach ($files as $file) {
                    $backups[] = [
                        'filename' => basename($file),
                        'size' => filesize($file),
                        'created_at' => date('Y-m-d H:i:s', filemtime($file))
                    ];
                }
            }

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
            'school' => ['school_name', 'school_address', 'school_phone', 'school_email', 'school_website', 'principal_name', 'school_npsn', 'school_accreditation', 'school_logo', 'school_favicon'],
            'academic' => ['academic_year', 'semester', 'school_timezone', 'attendance_start_time', 'attendance_end_time', 'late_tolerance_minutes'],
            'system' => ['maintenance_mode', 'allow_registration', 'max_upload_size', 'session_lifetime', 'max_login_attempts'],
            'email' => ['mail_host', 'mail_port', 'mail_username', 'mail_password', 'mail_encryption', 'mail_from_name'],
            'notification' => ['email_notifications_enabled', 'notification_frequency', 'registration_notifications', 'system_notifications', 'announcement_notifications', 'agenda_notifications'],
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
}