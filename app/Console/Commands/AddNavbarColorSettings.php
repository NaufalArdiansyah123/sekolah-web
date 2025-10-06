<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Setting;

class AddNavbarColorSettings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'settings:add-navbar-colors';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add default navbar color settings to the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding default navbar color settings...');

        $defaultNavbarColors = [
            'navbar_bg_color' => '#1a202c',
            'navbar_text_color' => '#ffffff',
            'navbar_hover_color' => '#3182ce',
            'navbar_active_color' => '#4299e1'
        ];

        $added = 0;
        $existing = 0;

        foreach ($defaultNavbarColors as $key => $defaultValue) {
            $setting = Setting::firstOrCreate(
                ['key' => $key],
                [
                    'value' => $defaultValue,
                    'type' => 'color',
                    'group' => 'school'
                ]
            );

            if ($setting->wasRecentlyCreated) {
                $added++;
                $this->line("✓ Added: {$key} = {$defaultValue}");
            } else {
                $existing++;
                $this->line("- Exists: {$key} = {$setting->value}");
            }
        }

        $this->info("Completed! Added {$added} new settings, {$existing} already existed.");
        
        if ($added > 0) {
            $this->info('Navbar color settings have been added successfully!');
            $this->info('You can now customize navbar colors in Admin Settings > Appearance tab.');
        }

        return Command::SUCCESS;
    }
}