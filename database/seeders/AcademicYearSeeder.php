<?php
// database/seeders/AcademicYearSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicYear;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $academicYears = [
            [
                'name' => '2023/2024',
                'start_date' => '2023-07-01',
                'end_date' => '2024-06-30',
                'is_active' => false,
                'description' => 'Tahun Ajaran 2023/2024'
            ],
            [
                'name' => '2024/2025',
                'start_date' => '2024-07-01',
                'end_date' => '2025-06-30',
                'is_active' => true,
                'description' => 'Tahun Ajaran 2024/2025 (Aktif)'
            ]
        ];

        foreach ($academicYears as $year) {
            AcademicYear::create($year);
        }
    }
}