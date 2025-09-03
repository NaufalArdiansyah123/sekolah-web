<?php
// database/seeders/SettingSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'site_name', 'value' => 'Sekolah Admin Panel', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_description', 'value' => 'Sistem Manajemen Sekolah', 'type' => 'text', 'group' => 'general'],
            ['key' => 'site_email', 'value' => 'info@sekolah.sch.id', 'type' => 'email', 'group' => 'contact'],
            ['key' => 'site_phone', 'value' => '(024) 1234567', 'type' => 'string', 'group' => 'contact'],
            ['key' => 'site_address', 'value' => 'Jl. Pendidikan No. 123, Semarang, Jawa Tengah', 'type' => 'text', 'group' => 'contact'],
            ['key' => 'posts_per_page', 'value' => '10', 'type' => 'number', 'group' => 'content'],
            ['key' => 'max_upload_size', 'value' => '2048', 'type' => 'number', 'group' => 'system'],
            ['key' => 'maintenance_mode', 'value' => 'false', 'type' => 'boolean', 'group' => 'system'],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
