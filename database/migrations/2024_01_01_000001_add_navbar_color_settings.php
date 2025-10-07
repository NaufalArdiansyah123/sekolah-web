<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Setting;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add navbar color settings to the settings table
        $navbarSettings = [
            [
                'key' => 'navbar_bg_color',
                'value' => '#1a202c',
                'type' => 'color',
                'group' => 'school',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'navbar_text_color',
                'value' => '#ffffff',
                'type' => 'color',
                'group' => 'school',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'navbar_hover_color',
                'value' => '#3182ce',
                'type' => 'color',
                'group' => 'school',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'key' => 'navbar_active_color',
                'value' => '#4299e1',
                'type' => 'color',
                'group' => 'school',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($navbarSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove navbar color settings
        Setting::whereIn('key', [
            'navbar_bg_color',
            'navbar_text_color', 
            'navbar_hover_color',
            'navbar_active_color'
        ])->delete();
    }
};