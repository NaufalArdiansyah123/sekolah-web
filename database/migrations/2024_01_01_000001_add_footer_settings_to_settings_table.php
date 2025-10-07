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
        // Insert default footer settings
        $footerSettings = [
            [
                'key' => 'footer_description',
                'value' => 'Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.',
                'type' => 'string',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_facebook',
                'value' => '',
                'type' => 'url',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_instagram',
                'value' => '',
                'type' => 'url',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_youtube',
                'value' => '',
                'type' => 'url',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_twitter',
                'value' => '',
                'type' => 'url',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_address',
                'value' => 'Jl. Pendidikan No. 123, Ponorogo, Jawa Timur 63411',
                'type' => 'string',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_phone',
                'value' => '(0352) 123-4567',
                'type' => 'string',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'footer_email',
                'value' => 'info@smkpgri2ponorogo.sch.id',
                'type' => 'email',
                'group' => 'footer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($footerSettings as $setting) {
            // Only insert if the setting doesn't already exist
            if (!Setting::where('key', $setting['key'])->exists()) {
                Setting::create($setting);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove footer settings
        Setting::whereIn('key', [
            'footer_description',
            'footer_facebook',
            'footer_instagram',
            'footer_youtube',
            'footer_twitter',
            'footer_address',
            'footer_phone',
            'footer_email',
        ])->delete();
    }
};