<?php

return [
    /*
    |--------------------------------------------------------------------------
    | School Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for school-specific settings
    | including class structure, academic years, and other school data.
    |
    */

    'name' => env('SCHOOL_NAME', 'SMK Negeri 1'),
    'address' => env('SCHOOL_ADDRESS', 'Jakarta, Indonesia'),
    'phone' => env('SCHOOL_PHONE', '021-12345678'),
    'email' => env('SCHOOL_EMAIL', 'info@smkn1.sch.id'),
    'website' => env('SCHOOL_WEBSITE', 'https://smkn1.sch.id'),

    /*
    |--------------------------------------------------------------------------
    | Class Structure
    |--------------------------------------------------------------------------
    |
    | Define the class structure for the school.
    | This includes grades, majors, and class numbers.
    |
    */

    'classes' => [
        'grades' => [10, 11, 12],
        'majors' => [
            'TKJ' => [
                'name' => 'Teknik Komputer dan Jaringan',
                'classes' => [1, 2], // TKJ 1, TKJ 2
            ],
            'RPL' => [
                'name' => 'Rekayasa Perangkat Lunak',
                'classes' => [1, 2], // RPL 1, RPL 2
            ],
            'DKV' => [
                'name' => 'Desain Komunikasi Visual',
                'classes' => [1], // DKV 1 only
            ],
        ],
        'new_student_grade' => 10, // Only grade 10 for new student registration
    ],

    /*
    |--------------------------------------------------------------------------
    | Academic Year
    |--------------------------------------------------------------------------
    |
    | Configuration for academic year and semester settings.
    |
    */

    'academic' => [
        'current_year' => env('ACADEMIC_YEAR', date('Y')),
        'semester_1_months' => [7, 8, 9, 10, 11, 12], // July - December
        'semester_2_months' => [1, 2, 3, 4, 5, 6],    // January - June
    ],

    /*
    |--------------------------------------------------------------------------
    | Grading System
    |--------------------------------------------------------------------------
    |
    | Configuration for grading and scoring system.
    |
    */

    'grading' => [
        'max_score' => 100,
        'min_score' => 0,
        'passing_grade' => 75,
        'grade_scale' => [
            'A' => ['min' => 90, 'max' => 100],
            'B' => ['min' => 80, 'max' => 89],
            'C' => ['min' => 70, 'max' => 79],
            'D' => ['min' => 60, 'max' => 69],
            'E' => ['min' => 0, 'max' => 59],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Student Data Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for student-related data options.
    |
    */

    'student' => [
        'religions' => [
            'Islam' => 'Islam',
            'Kristen' => 'Kristen',
            'Katolik' => 'Katolik',
            'Hindu' => 'Hindu',
            'Buddha' => 'Buddha',
            'Konghucu' => 'Konghucu',
        ],
        'statuses' => [
            'active' => 'Aktif',
            'inactive' => 'Tidak Aktif',
            'graduated' => 'Lulus',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | File Upload Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for file uploads in the system.
    |
    */

    'uploads' => [
        'max_file_size' => 10240, // 10MB in KB
        'allowed_extensions' => [
            'documents' => ['pdf', 'doc', 'docx', 'txt'],
            'images' => ['jpg', 'jpeg', 'png', 'gif'],
            'archives' => ['zip', 'rar'],
        ],
    ],
];