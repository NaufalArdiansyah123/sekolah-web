<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;

class SetupProfileSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set up the profile management system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Setting up Profile Management System...');

        // Run migrations
        $this->info('Running migrations...');
        Artisan::call('migrate', ['--force' => true]);
        $this->info('Migrations completed.');

        // Create storage link if it doesn't exist
        if (!file_exists(public_path('storage'))) {
            $this->info('Creating storage link...');
            Artisan::call('storage:link');
            $this->info('Storage link created.');
        } else {
            $this->info('Storage link already exists.');
        }

        // Clear cache
        $this->info('Clearing cache...');
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        $this->info('Cache cleared.');

        $this->info('✅ Profile Management System setup completed!');
        $this->info('');
        $this->info('Available features:');
        $this->info('- Profile information management');
        $this->info('- Avatar upload and management');
        $this->info('- Password change functionality');
        $this->info('- Activity logging and tracking');
        $this->info('- Session management');
        $this->info('- Security settings');
        $this->info('- Data export (GDPR compliance)');
        $this->info('');
        $this->info('Access the profile page at: /admin/profile');
    }
}