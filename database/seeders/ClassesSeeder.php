<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Classes;
use App\Models\AcademicYear;

class ClassesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 15 SMK classes for the school system (SMA classes removed)
     */
    public function run(): void
    {
        // Create academic year if not exists
        $academicYear = AcademicYear::firstOrCreate([
            'name' => '2024/2025'
        ], [
            'name' => '2024/2025',
            'start_date' => '2024-07-01',
            'end_date' => '2025-06-30',
            'is_active' => true,
            'description' => 'Tahun Ajaran 2024/2025 untuk SMK'
        ]);

        // Create SMK classes only (SMA classes removed)
        $classes = [
            // Kelas 10 (Grade 10) - SMK
            ['name' => '10 TKJ 1', 'code' => '10TKJ1', 'level' => '10', 'program' => 'TKJ', 'description' => 'Kelas 10 TKJ 1 - Teknik Komputer dan Jaringan, fokus pada dasar-dasar networking dan hardware komputer.'],
            ['name' => '10 TKJ 2', 'code' => '10TKJ2', 'level' => '10', 'program' => 'TKJ', 'description' => 'Kelas 10 TKJ 2 - Teknik Komputer dan Jaringan, fokus pada administrasi jaringan dan troubleshooting.'],
            ['name' => '10 RPL 1', 'code' => '10RPL1', 'level' => '10', 'program' => 'RPL', 'description' => 'Kelas 10 RPL 1 - Rekayasa Perangkat Lunak, fokus pada dasar-dasar pemrograman dan algoritma.'],
            ['name' => '10 RPL 2', 'code' => '10RPL2', 'level' => '10', 'program' => 'RPL', 'description' => 'Kelas 10 RPL 2 - Rekayasa Perangkat Lunak, fokus pada web development dan database.'],
            ['name' => '10 DKV 1', 'code' => '10DKV1', 'level' => '10', 'program' => 'DKV', 'description' => 'Kelas 10 DKV 1 - Desain Komunikasi Visual, fokus pada dasar-dasar desain dan ilustrasi.'],
            
            // Kelas 11 (Grade 11) - SMK
            ['name' => '11 TKJ 1', 'code' => '11TKJ1', 'level' => '11', 'program' => 'TKJ', 'description' => 'Kelas 11 TKJ 1 - Teknik Komputer dan Jaringan, fokus pada keamanan jaringan dan server administration.'],
            ['name' => '11 TKJ 2', 'code' => '11TKJ2', 'level' => '11', 'program' => 'TKJ', 'description' => 'Kelas 11 TKJ 2 - Teknik Komputer dan Jaringan, fokus pada sistem operasi dan virtualisasi.'],
            ['name' => '11 RPL 1', 'code' => '11RPL1', 'level' => '11', 'program' => 'RPL', 'description' => 'Kelas 11 RPL 1 - Rekayasa Perangkat Lunak, fokus pada mobile app development dan framework modern.'],
            ['name' => '11 RPL 2', 'code' => '11RPL2', 'level' => '11', 'program' => 'RPL', 'description' => 'Kelas 11 RPL 2 - Rekayasa Perangkat Lunak, fokus pada full stack development dan project management.'],
            ['name' => '11 DKV 1', 'code' => '11DKV1', 'level' => '11', 'program' => 'DKV', 'description' => 'Kelas 11 DKV 1 - Desain Komunikasi Visual, fokus pada multimedia design dan motion graphics.'],
            
            // Kelas 12 (Grade 12) - SMK
            ['name' => '12 TKJ 1', 'code' => '12TKJ1', 'level' => '12', 'program' => 'TKJ', 'description' => 'Kelas 12 TKJ 1 - Teknik Komputer dan Jaringan, persiapan sertifikasi dan magang industri.'],
            ['name' => '12 TKJ 2', 'code' => '12TKJ2', 'level' => '12', 'program' => 'TKJ', 'description' => 'Kelas 12 TKJ 2 - Teknik Komputer dan Jaringan, fokus pada IT infrastructure dan cloud computing.'],
            ['name' => '12 RPL 1', 'code' => '12RPL1', 'level' => '12', 'program' => 'RPL', 'description' => 'Kelas 12 RPL 1 - Rekayasa Perangkat Lunak, persiapan industri dan software architecture.'],
            ['name' => '12 RPL 2', 'code' => '12RPL2', 'level' => '12', 'program' => 'RPL', 'description' => 'Kelas 12 RPL 2 - Rekayasa Perangkat Lunak, fokus pada DevOps dan deployment automation.'],
            ['name' => '12 DKV 1', 'code' => '12DKV1', 'level' => '12', 'program' => 'DKV', 'description' => 'Kelas 12 DKV 1 - Desain Komunikasi Visual, persiapan portfolio dan industri kreatif.'],
        ];

        foreach ($classes as $classData) {
            Classes::firstOrCreate(
                ['code' => $classData['code']],
                [
                    'name' => $classData['name'],
                    'level' => $classData['level'],
                    'program' => $classData['program'],
                    'capacity' => 30,
                    'academic_year_id' => $academicYear->id,
                    'description' => $classData['description'],
                    'is_active' => true
                ]
            );
        }
        
        $this->command->info('SMK Classes seeder completed successfully!');
        $this->command->info('Total SMK classes created: ' . count($classes));
        $this->command->info('Academic Year: 2024/2025');
        $this->command->info('SMK Class structure:');
        $this->command->info('- Grade 10: 10 TKJ 1, 10 TKJ 2, 10 RPL 1, 10 RPL 2, 10 DKV 1 (5 classes)');
        $this->command->info('- Grade 11: 11 TKJ 1, 11 TKJ 2, 11 RPL 1, 11 RPL 2, 11 DKV 1 (5 classes)');
        $this->command->info('- Grade 12: 12 TKJ 1, 12 TKJ 2, 12 RPL 1, 12 RPL 2, 12 DKV 1 (5 classes)');
        $this->command->info('- Majors: TKJ (Teknik Komputer Jaringan), RPL (Rekayasa Perangkat Lunak), DKV (Desain Komunikasi Visual)');
        $this->command->info('- Total: 15 SMK classes with 30 students capacity each');
        $this->command->info('- SMA classes have been removed from this seeder');
    }
}