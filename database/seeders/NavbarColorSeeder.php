<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class NavbarColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $navbarSettings = [
            [
                'key' => 'navbar_bg_color',
                'value' => '#1a202c',
                'type' => 'color',
                'group' => 'school'
            ],
            [
                'key' => 'navbar_text_color',
                'value' => '#ffffff',
                'type' => 'color',
                'group' => 'school'
            ],
            [
                'key' => 'navbar_hover_color',
                'value' => '#3182ce',
                'type' => 'color',
                'group' => 'school'
            ],
            [
                'key' => 'navbar_active_color',
                'value' => '#4299e1',
                'type' => 'color',
                'group' => 'school'
            ]
        ];

        foreach ($navbarSettings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('Navbar color settings have been seeded successfully!');
    }
}