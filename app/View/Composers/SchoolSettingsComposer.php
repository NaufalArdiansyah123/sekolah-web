<?php

namespace App\View\Composers;

use Illuminate\View\View;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SchoolSettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $schoolSettings = Cache::remember('school_settings', 3600, function () {
            return Setting::where('group', 'school')
                         ->pluck('value', 'key')
                         ->toArray();
        });

        // Set default values if settings don't exist
        $defaultSettings = [
            'school_name' => 'SMK PGRI 2 PONOROGO',
            'school_subtitle' => 'Terbukti Lebih Maju',
            'school_description' => 'Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.',
            'school_address' => 'Jl. Pendidikan No. 123, Ponorogo, Jawa Timur 63411',
            'school_phone' => '(0352) 123-4567',
            'school_email' => 'info@smkpgri2ponorogo.sch.id',
            'school_website' => 'https://smkpgri2ponorogo.sch.id',
            'school_logo' => null,
            'school_favicon' => null
        ];

        $schoolSettings = array_merge($defaultSettings, $schoolSettings);

        $view->with('schoolSettings', $schoolSettings);
    }
}