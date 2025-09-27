<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if settings table exists, if not create it first
        if (!Schema::hasTable('settings')) {
            Schema::create('settings', function (Blueprint $table) {
                $table->id();
                $table->string('key')->unique();
                $table->text('value')->nullable();
                $table->string('type')->default('string');
                $table->string('group')->default('general');
                $table->text('description')->nullable();
                $table->timestamps();
                
                // Add indexes for better performance
                $table->index(['group', 'key'], 'settings_group_key_index');
                $table->index('type', 'settings_type_index');
            });
        } else {
            // Table exists, just add missing columns
            Schema::table('settings', function (Blueprint $table) {
                // Add new columns if they don't exist
                if (!Schema::hasColumn('settings', 'type')) {
                    $table->string('type')->default('string')->after('value');
                }
                if (!Schema::hasColumn('settings', 'group')) {
                    $table->string('group')->default('general')->after('type');
                }
                if (!Schema::hasColumn('settings', 'description')) {
                    $table->text('description')->nullable()->after('group');
                }
            });
            
            // Add indexes for better performance if they don't exist
            $this->addIndexIfNotExists('settings', ['group', 'key'], 'settings_group_key_index');
            $this->addIndexIfNotExists('settings', ['type'], 'settings_type_index');
        }
        
        // Insert default school settings
        $defaultSettings = [
            // School Information
            ['key' => 'school_name', 'value' => 'SMA Negeri 1 Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Nama resmi sekolah'],
            ['key' => 'school_address', 'value' => 'Jl. Pendidikan No. 1, Balong', 'type' => 'string', 'group' => 'school', 'description' => 'Alamat lengkap sekolah'],
            ['key' => 'school_phone', 'value' => '(0274) 123456', 'type' => 'string', 'group' => 'school', 'description' => 'Nomor telepon sekolah'],
            ['key' => 'school_email', 'value' => 'info@sman1balong.sch.id', 'type' => 'email', 'group' => 'school', 'description' => 'Email resmi sekolah'],
            ['key' => 'school_website', 'value' => 'https://sman1balong.sch.id', 'type' => 'url', 'group' => 'school', 'description' => 'Website resmi sekolah'],
            ['key' => 'principal_name', 'value' => 'Drs. Ahmad Suryanto, M.Pd', 'type' => 'string', 'group' => 'school', 'description' => 'Nama kepala sekolah'],
            ['key' => 'school_npsn', 'value' => '20404117', 'type' => 'string', 'group' => 'school', 'description' => 'Nomor Pokok Sekolah Nasional'],
            ['key' => 'school_accreditation', 'value' => 'A', 'type' => 'string', 'group' => 'school', 'description' => 'Akreditasi sekolah'],
            
            // Academic Settings
            ['key' => 'academic_year', 'value' => '2024/2025', 'type' => 'string', 'group' => 'academic', 'description' => 'Tahun ajaran aktif'],
            ['key' => 'semester', 'value' => '1', 'type' => 'integer', 'group' => 'academic', 'description' => 'Semester aktif (1 atau 2)'],
            ['key' => 'school_timezone', 'value' => 'Asia/Jakarta', 'type' => 'string', 'group' => 'academic', 'description' => 'Zona waktu sekolah'],
            ['key' => 'attendance_start_time', 'value' => '07:00', 'type' => 'time', 'group' => 'academic', 'description' => 'Jam mulai absensi'],
            ['key' => 'attendance_end_time', 'value' => '07:30', 'type' => 'time', 'group' => 'academic', 'description' => 'Jam berakhir absensi'],
            ['key' => 'late_tolerance_minutes', 'value' => '15', 'type' => 'integer', 'group' => 'academic', 'description' => 'Toleransi keterlambatan (menit)'],
            
            // System Settings
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'system', 'description' => 'Mode pemeliharaan sistem'],
            ['key' => 'allow_registration', 'value' => '1', 'type' => 'boolean', 'group' => 'system', 'description' => 'Izinkan pendaftaran akun siswa baru'],
            ['key' => 'max_upload_size', 'value' => '10', 'type' => 'integer', 'group' => 'system', 'description' => 'Ukuran maksimal upload (MB)'],
            ['key' => 'session_lifetime', 'value' => '120', 'type' => 'integer', 'group' => 'system', 'description' => 'Durasi session (menit)'],
            ['key' => 'max_login_attempts', 'value' => '5', 'type' => 'integer', 'group' => 'system', 'description' => 'Maksimal percobaan login'],
            
            // Email Settings
            ['key' => 'mail_host', 'value' => '', 'type' => 'string', 'group' => 'email', 'description' => 'SMTP Host'],
            ['key' => 'mail_port', 'value' => '587', 'type' => 'integer', 'group' => 'email', 'description' => 'SMTP Port'],
            ['key' => 'mail_username', 'value' => '', 'type' => 'email', 'group' => 'email', 'description' => 'SMTP Username'],
            ['key' => 'mail_password', 'value' => '', 'type' => 'string', 'group' => 'email', 'description' => 'SMTP Password'],
            ['key' => 'mail_encryption', 'value' => 'tls', 'type' => 'string', 'group' => 'email', 'description' => 'Enkripsi email (tls/ssl)'],
            ['key' => 'mail_from_name', 'value' => 'SMA Negeri 1 Balong', 'type' => 'string', 'group' => 'email', 'description' => 'Nama pengirim email'],
            
            // Notification Settings
            ['key' => 'email_notifications_enabled', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Aktifkan notifikasi email'],
            ['key' => 'notification_frequency', 'value' => 'instant', 'type' => 'string', 'group' => 'notification', 'description' => 'Frekuensi notifikasi'],
            ['key' => 'registration_notifications', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Notifikasi pendaftaran'],
            ['key' => 'system_notifications', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Notifikasi sistem'],
            ['key' => 'announcement_notifications', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Notifikasi pengumuman'],
            ['key' => 'agenda_notifications', 'value' => '1', 'type' => 'boolean', 'group' => 'notification', 'description' => 'Notifikasi agenda'],
            
            // Backup Settings
            ['key' => 'auto_backup_enabled', 'value' => '0', 'type' => 'boolean', 'group' => 'backup', 'description' => 'Backup otomatis'],
            ['key' => 'backup_frequency', 'value' => 'daily', 'type' => 'string', 'group' => 'backup', 'description' => 'Frekuensi backup'],
            ['key' => 'backup_retention_days', 'value' => '30', 'type' => 'integer', 'group' => 'backup', 'description' => 'Lama simpan backup (hari)'],
        ];
        
        foreach ($defaultSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                $setting + ['created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('settings')) {
            Schema::table('settings', function (Blueprint $table) {
                // Drop indexes if they exist
                $this->dropIndexIfExists('settings', 'settings_group_key_index');
                $this->dropIndexIfExists('settings', 'settings_type_index');
                
                // Drop columns if they exist
                if (Schema::hasColumn('settings', 'description')) {
                    $table->dropColumn('description');
                }
                if (Schema::hasColumn('settings', 'group')) {
                    $table->dropColumn('group');
                }
                if (Schema::hasColumn('settings', 'type')) {
                    $table->dropColumn('type');
                }
            });
        }
    }
    
    /**
     * Add index if it doesn't exist
     */
    private function addIndexIfNotExists(string $table, array $columns, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            if (!in_array($indexName, $existingIndexes)) {
                Schema::table($table, function (Blueprint $table) use ($columns, $indexName) {
                    $table->index($columns, $indexName);
                });
            }
        } catch (\Exception $e) {
            // Index creation failed, but continue
        }
    }
    
    /**
     * Drop index if it exists
     */
    private function dropIndexIfExists(string $table, string $indexName): void
    {
        try {
            $indexes = DB::select("SHOW INDEX FROM {$table}");
            $existingIndexes = collect($indexes)->pluck('Key_name')->toArray();
            
            if (in_array($indexName, $existingIndexes)) {
                Schema::table($table, function (Blueprint $table) use ($indexName) {
                    $table->dropIndex($indexName);
                });
            }
        } catch (\Exception $e) {
            // Index drop failed, but continue
        }
    }
};