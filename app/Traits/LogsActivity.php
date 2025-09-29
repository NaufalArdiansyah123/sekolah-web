<?php

namespace App\Traits;

use App\Models\UserActivity;

trait LogsActivity
{
    /**
     * Log an activity for the current user.
     */
    protected function logActivity(string $type, string $description, array $properties = []): void
    {
        if (auth()->check()) {
            UserActivity::log(
                auth()->id(),
                $type,
                $description,
                $properties
            );
        }
    }

    /**
     * Log a login activity.
     */
    protected function logLogin(array $properties = []): void
    {
        $this->logActivity(
            'login',
            'User logged in',
            array_merge([
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
            ], $properties)
        );
    }

    /**
     * Log a logout activity.
     */
    protected function logLogout(array $properties = []): void
    {
        $this->logActivity(
            'logout',
            'User logged out',
            array_merge([
                'ip_address' => request()->ip(),
            ], $properties)
        );
    }

    /**
     * Log a profile update activity.
     */
    protected function logProfileUpdate(array $fieldsUpdated = [], array $properties = []): void
    {
        $this->logActivity(
            'profile_update',
            'Profile information updated',
            array_merge([
                'fields_updated' => $fieldsUpdated,
            ], $properties)
        );
    }

    /**
     * Log a password change activity.
     */
    protected function logPasswordChange(array $properties = []): void
    {
        $this->logActivity(
            'password_change',
            'Password changed',
            array_merge([
                'ip_address' => request()->ip(),
            ], $properties)
        );
    }

    /**
     * Log a security-related activity.
     */
    protected function logSecurityActivity(string $description, array $properties = []): void
    {
        $this->logActivity(
            'security',
            $description,
            array_merge([
                'ip_address' => request()->ip(),
            ], $properties)
        );
    }
}