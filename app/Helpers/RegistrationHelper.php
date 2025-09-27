<?php

namespace App\Helpers;

use App\Models\Setting;

class RegistrationHelper
{
    /**
     * Check if student registration is enabled
     *
     * @return bool
     */
    public static function isRegistrationEnabled(): bool
    {
        return Setting::get('allow_registration', '1') === '1';
    }

    /**
     * Get registration status message
     *
     * @return string
     */
    public static function getRegistrationStatusMessage(): string
    {
        if (self::isRegistrationEnabled()) {
            return 'Pendaftaran akun siswa sedang dibuka';
        }
        
        return 'Pendaftaran akun siswa saat ini sedang ditutup';
    }

    /**
     * Get registration closure reason (can be extended to include custom reasons)
     *
     * @return string
     */
    public static function getRegistrationClosureReason(): string
    {
        return Setting::get('registration_closure_reason', 'Pendaftaran akun siswa saat ini sedang ditutup. Silakan hubungi administrator sekolah untuk informasi lebih lanjut.');
    }
}