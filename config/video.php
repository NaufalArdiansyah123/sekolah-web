<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Video Upload Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration options for video uploads
    |
    */

    'max_file_size' => env('VIDEO_MAX_FILE_SIZE', 104857600), // 100MB in bytes
    
    'allowed_mimes' => [
        'mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv', '3gp'
    ],
    
    'thumbnail_mimes' => [
        'jpeg', 'png', 'jpg', 'gif', 'webp'
    ],
    
    'storage_disk' => env('VIDEO_STORAGE_DISK', 'public'),
    
    'storage_path' => 'videos',
    
    'thumbnail_path' => 'videos/thumbnails',
    
    'default_category' => 'lainnya',
    
    'default_status' => 'active',
    
    'auto_generate_thumbnail' => env('VIDEO_AUTO_THUMBNAIL', false),
    
    'ffmpeg_path' => env('FFMPEG_PATH', '/usr/bin/ffmpeg'),
    
    'categories' => [
        'dokumentasi' => 'Dokumentasi',
        'kegiatan' => 'Kegiatan Sekolah',
        'pembelajaran' => 'Pembelajaran',
        'prestasi' => 'Prestasi',
        'lainnya' => 'Lainnya',
    ],
    
    'statuses' => [
        'active' => 'Aktif',
        'inactive' => 'Tidak Aktif',
    ],
];