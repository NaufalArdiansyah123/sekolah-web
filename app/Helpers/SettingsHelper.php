<?php

if (!function_exists('school_setting')) {
    /**
     * Get school setting value
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function school_setting($key, $default = null)
    {
        try {
            return \App\Models\Setting::get($key, $default);
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('school_name')) {
    /**
     * Get school name
     *
     * @return string
     */
    function school_name()
    {
        return school_setting('school_name', 'SMK PGRI 2 PONOROGO');
    }
}

if (!function_exists('school_subtitle')) {
    /**
     * Get school subtitle
     *
     * @return string
     */
    function school_subtitle()
    {
        return school_setting('school_subtitle', 'Terbukti Lebih Maju');
    }
}

if (!function_exists('school_logo')) {
    /**
     * Get school logo URL
     *
     * @return string|null
     */
    function school_logo()
    {
        $logo = school_setting('school_logo');
        return $logo ? asset('storage/' . $logo) : null;
    }
}

if (!function_exists('school_favicon')) {
    /**
     * Get school favicon URL
     *
     * @return string|null
     */
    function school_favicon()
    {
        $favicon = school_setting('school_favicon');
        return $favicon ? asset('storage/' . $favicon) : null;
    }
}