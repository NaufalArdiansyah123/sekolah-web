<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Setting;

class SchoolInfo extends Component
{
    public $schoolName;
    public $schoolLogo;
    public $schoolAddress;
    public $schoolPhone;
    public $schoolEmail;
    public $schoolWebsite;
    public $principalName;
    public $schoolAccreditation;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->schoolName = Setting::get('school_name', 'SMK PGRI 2 PONOROGO');
        $this->schoolLogo = Setting::get('school_logo');
        $this->schoolAddress = Setting::get('school_address');
        $this->schoolPhone = Setting::get('school_phone');
        $this->schoolEmail = Setting::get('school_email');
        $this->schoolWebsite = Setting::get('school_website');
        $this->principalName = Setting::get('principal_name');
        $this->schoolAccreditation = Setting::get('school_accreditation');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.school-info');
    }
}