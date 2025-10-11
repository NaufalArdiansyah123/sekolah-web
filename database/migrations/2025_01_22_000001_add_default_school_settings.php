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
        // Add default school settings if they don't exist
        $defaultSettings = [
            [
                'key' => 'school_name',
                'value' => 'SMK PGRI 2 PONOROGO',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_subtitle',
                'value' => 'Terbukti Lebih Maju',
                'type' => 'string',
                'group' => 'school'
            ],
            [
                'key' => 'school_description',
                'value' => 'Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.',
                'type' => 'text',
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
            ]
        ];

        foreach ($defaultSettings as $setting) {
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
        // Remove the default settings
        $keys = [
            'school_name',
            'school_subtitle', 
            'school_description',
            'school_address',
            'school_phone',
            'school_email',
            'school_website'
        ];

        Setting::whereIn('key', $keys)->delete();
    }
};