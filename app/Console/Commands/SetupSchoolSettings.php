<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class SetupSchoolSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'school:setup-settings 
                            {--reset : Reset all settings to default}
                            {--force : Force setup without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup school settings with default values';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🏫 Setting up School Settings...');

        if ($this->option('reset')) {
            if (!$this->option('force') && !$this->confirm('This will reset all settings to default. Continue?')) {
                $this->info('Operation cancelled.');
                return 0;
            }
            
            $this->info('🗑️  Resetting all settings...');
            Setting::truncate();
        }

        $this->info('📝 Creating default settings...');

        $settings = [
            // School Information
            [
                'key' => 'school_name',
                'value' => 'SMK PGRI 2 PONOROGO',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_npsn',
                'value' => '20568123',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_address',
                'value' => 'Jl. Pendidikan No. 123, Ponorogo, Jawa Timur 63411',
                'type' => 'text',
                'group' => 'school'
            ],
            [
                'key' => 'school_phone',
                'value' => '(0352) 123-4567',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_email',
                'value' => 'info@smkpgri2ponorogo.sch.id',
                'type' => 'email',
                'group' => 'school'
            ],
            [
                'key' => 'school_website',
                'value' => 'https://smkpgri2ponorogo.sch.id',
                'type' => 'url',
                'group' => 'school'
            ],
            [
                'key' => 'principal_name',
                'value' => 'Drs. Ahmad Suryanto, M.Pd',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_accreditation',
                'value' => 'A',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_logo',
                'value' => '',
                'type' => 'file',
                'group' => 'school'
            ],
            [
                'key' => 'school_favicon',
                'value' => '',
                'type' => 'file',
                'group' => 'school'
            ],

            // Academic Settings
            [
                'key' => 'academic_year',
                'value' => '2024/2025',
                'type' => 'string',
                'group' => 'academic'
            ],
            [
                'key' => 'semester',
                'value' => '1',
                'type' => 'string',
                'group' => 'academic'
            ],
            [
                'key' => 'school_timezone',
                'value' => 'Asia/Jakarta',
                'type' => 'string',
                'group' => 'academic'
            ],
            [
                'key' => 'attendance_start_time',
                'value' => '07:00',
                'type' => 'time',
                'group' => 'academic'
            ],
            [
                'key' => 'attendance_end_time',
                'value' => '07:30',
                'type' => 'time',
                'group' => 'academic'
            ],
            [
                'key' => 'late_tolerance_minutes',
                'value' => '15',
                'type' => 'integer',
                'group' => 'academic'
            ],

            // System Settings
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'system'
            ],
            [
                'key' => 'allow_registration',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'system'
            ],
            [
                'key' => 'max_upload_size',
                'value' => '10',
                'type' => 'integer',
                'group' => 'system'
            ],
            [
                'key' => 'session_lifetime',
                'value' => '120',
                'type' => 'integer',
                'group' => 'system'
            ],
            [
                'key' => 'max_login_attempts',
                'value' => '5',
                'type' => 'integer',
                'group' => 'system'
            ],

            // Email Settings
            [
                'key' => 'mail_host',
                'value' => 'smtp.gmail.com',
                'type' => 'string',
                'group' => 'email'
            ],
            [
                'key' => 'mail_port',
                'value' => '587',
                'type' => 'integer',
                'group' => 'email'
            ],
            [
                'key' => 'mail_username',
                'value' => '',
                'type' => 'email',
                'group' => 'email'
            ],
            [
                'key' => 'mail_password',
                'value' => '',
                'type' => 'string',
                'group' => 'email'
            ],
            [
                'key' => 'mail_encryption',
                'value' => 'tls',
                'type' => 'string',
                'group' => 'email'
            ],
            [
                'key' => 'mail_from_name',
                'value' => 'SMK PGRI 2 PONOROGO',
                'type' => 'string',
                'group' => 'email'
            ],

            // Notification Settings
            [
                'key' => 'email_notifications_enabled',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification'
            ],
            [
                'key' => 'registration_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification'
            ],
            [
                'key' => 'system_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification'
            ],
            [
                'key' => 'announcement_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification'
            ],
            [
                'key' => 'agenda_notifications',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'notification'
            ],

            // Backup Settings
            [
                'key' => 'auto_backup_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'backup'
            ],
            [
                'key' => 'backup_frequency',
                'value' => 'daily',
                'type' => 'string',
                'group' => 'backup'
            ],
            [
                'key' => 'backup_retention_days',
                'value' => '30',
                'type' => 'integer',
                'group' => 'backup'
            ],
        ];

        $progressBar = $this->output->createProgressBar(count($settings));
        $progressBar->start();

        $created = 0;
        $updated = 0;

        foreach ($settings as $setting) {
            $existing = Setting::where('key', $setting['key'])->first();
            
            if ($existing) {
                if ($this->option('reset')) {
                    $existing->update($setting);
                    $updated++;
                }
            } else {
                Setting::create($setting);
                $created++;
            }
            
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("✅ Settings setup completed!");
        $this->info("📊 Created: {$created} settings");
        
        if ($updated > 0) {
            $this->info("🔄 Updated: {$updated} settings");
        }

        // Clear cache
        Setting::clearCache();
        $this->info("🗑️  Cache cleared");

        $this->newLine();
        $this->info("🎉 School settings are ready to use!");
        $this->info("💡 You can now configure your school information in the admin panel.");

        return 0;
    }
}