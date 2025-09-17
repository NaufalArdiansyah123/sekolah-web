<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, Role, Permission, Setting};
use Illuminate\Support\Facades\{Hash, Artisan, DB, Mail};

// SettingController.php
class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|max:255',
            'site_description' => 'nullable',
            'site_email' => 'required|email',
            'site_phone' => 'nullable|max:20',
            'site_address' => 'nullable',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:1024',
            'site_favicon' => 'nullable|image|mimes:ico,png|max:512',
        ]);

        foreach ($request->except(['_token', '_method', 'site_logo', 'site_favicon']) as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        if ($request->hasFile('site_logo')) {
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );
        }

        if ($request->hasFile('site_favicon')) {
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $faviconPath]
            );
        }

        return redirect()->route('admin.settings')
                        ->with('success', 'Pengaturan berhasil diperbarui!');
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
            'email' => 'required|email'
        ]);

        try {
            Mail::raw('Test email dari sistem sekolah', function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Test Email - Sistem Sekolah');
            });

            return response()->json([
                'success' => true,
                'message' => 'Email test berhasil dikirim!'
            ]);
        } catch (\Exception $e) {
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
}