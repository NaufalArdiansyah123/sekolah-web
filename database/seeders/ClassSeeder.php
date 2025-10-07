<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates 15 SMK classes for the school system
     */
    public function run(): void
    {
        // Check if classes table exists
        if (!DB::getSchemaBuilder()->hasTable('classes')) {
            $this->command->info('Classes table does not exist. Skipping class seeder.');
            return;
        }

        // Clear existing classes
        DB::table('classes')->truncate();
        
        // First, ensure we have an academic year record
        $academicYearId = DB::table('academic_years')->insertGetId([
            'name' => '2024/2025',
            'start_date' => '2024-07-01',
            'end_date' => '2025-06-30',
            'is_active' => true,
            'description' => 'Tahun Ajaran 2024/2025 untuk SMK',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Define 15 SMK classes structure
        $classes = [
            // Kelas 10 (Grade 10)
            [
                'name' => '10 TKJ 1',
                'code' => '10TKJ1',
                'level' => '10',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 10 TKJ 1 - Teknik Komputer dan Jaringan, fokus pada dasar-dasar networking dan hardware komputer.',
                'is_active' => true,
            ],
            [
                'name' => '10 TKJ 2',
                'code' => '10TKJ2',
                'level' => '10',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 10 TKJ 2 - Teknik Komputer dan Jaringan, fokus pada administrasi jaringan dan troubleshooting.',
                'is_active' => true,
            ],
            [
                'name' => '10 RPL 1',
                'code' => '10RPL1',
                'level' => '10',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 10 RPL 1 - Rekayasa Perangkat Lunak, fokus pada dasar-dasar pemrograman dan algoritma.',
                'is_active' => true,
            ],
            [
                'name' => '10 RPL 2',
                'code' => '10RPL2',
                'level' => '10',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 10 RPL 2 - Rekayasa Perangkat Lunak, fokus pada web development dan database.',
                'is_active' => true,
            ],
            [
                'name' => '10 DKV 1',
                'code' => '10DKV1',
                'level' => '10',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 10 DKV 1 - Desain Komunikasi Visual, fokus pada dasar-dasar desain dan ilustrasi.',
                'is_active' => true,
            ],

            // Kelas 11 (Grade 11)
            [
                'name' => '11 TKJ 1',
                'code' => '11TKJ1',
                'level' => '11',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 11 TKJ 1 - Teknik Komputer dan Jaringan, fokus pada keamanan jaringan dan server administration.',
                'is_active' => true,
            ],
            [
                'name' => '11 TKJ 2',
                'code' => '11TKJ2',
                'level' => '11',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 11 TKJ 2 - Teknik Komputer dan Jaringan, fokus pada sistem operasi dan virtualisasi.',
                'is_active' => true,
            ],
            [
                'name' => '11 RPL 1',
                'code' => '11RPL1',
                'level' => '11',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 11 RPL 1 - Rekayasa Perangkat Lunak, fokus pada mobile app development dan framework modern.',
                'is_active' => true,
            ],
            [
                'name' => '11 RPL 2',
                'code' => '11RPL2',
                'level' => '11',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 11 RPL 2 - Rekayasa Perangkat Lunak, fokus pada full stack development dan project management.',
                'is_active' => true,
            ],
            [
                'name' => '11 DKV 1',
                'code' => '11DKV1',
                'level' => '11',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 11 DKV 1 - Desain Komunikasi Visual, fokus pada multimedia design dan motion graphics.',
                'is_active' => true,
            ],

            // Kelas 12 (Grade 12)
            [
                'name' => '12 TKJ 1',
                'code' => '12TKJ1',
                'level' => '12',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 12 TKJ 1 - Teknik Komputer dan Jaringan, persiapan sertifikasi dan magang industri.',
                'is_active' => true,
            ],
            [
                'name' => '12 TKJ 2',
                'code' => '12TKJ2',
                'level' => '12',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 12 TKJ 2 - Teknik Komputer dan Jaringan, fokus pada IT infrastructure dan cloud computing.',
                'is_active' => true,
            ],
            [
                'name' => '12 RPL 1',
                'code' => '12RPL1',
                'level' => '12',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 12 RPL 1 - Rekayasa Perangkat Lunak, persiapan industri dan software architecture.',
                'is_active' => true,
            ],
            [
                'name' => '12 RPL 2',
                'code' => '12RPL2',
                'level' => '12',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 12 RPL 2 - Rekayasa Perangkat Lunak, fokus pada DevOps dan deployment automation.',
                'is_active' => true,
            ],
            [
                'name' => '12 DKV 1',
                'code' => '12DKV1',
                'level' => '12',
                'program' => null,
                'capacity' => 30,
                'academic_year_id' => $academicYearId,
                'homeroom_teacher_id' => null,
                'description' => 'Kelas 12 DKV 1 - Desain Komunikasi Visual, persiapan portfolio dan industri kreatif.',
                'is_active' => true,
            ],
        ];

        foreach ($classes as $class) {
            DB::table('classes')->insert([
                'name' => $class['name'],
                'code' => $class['code'],
                'level' => $class['level'],
                'program' => $class['program'],
                'capacity' => $class['capacity'],
                'academic_year_id' => $class['academic_year_id'],
                'homeroom_teacher_id' => $class['homeroom_teacher_id'],
                'description' => $class['description'],
                'is_active' => $class['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Created SMK class: {$class['name']} ({$class['code']})");
        }

        $this->command->info('SMK Class seeder completed successfully!');
        $this->command->info('Total classes created: ' . count($classes));
        $this->command->info('Academic Year: 2024/2025 (ID: ' . $academicYearId . ')');
        $this->command->info('SMK Class structure:');
        $this->command->info('- Grade 10: 10 TKJ 1, 10 TKJ 2, 10 RPL 1, 10 RPL 2, 10 DKV 1 (5 classes)');
        $this->command->info('- Grade 11: 11 TKJ 1, 11 TKJ 2, 11 RPL 1, 11 RPL 2, 11 DKV 1 (5 classes)');
        $this->command->info('- Grade 12: 12 TKJ 1, 12 TKJ 2, 12 RPL 1, 12 RPL 2, 12 DKV 1 (5 classes)');
        $this->command->info('- Majors: TKJ (Teknik Komputer Jaringan), RPL (Rekayasa Perangkat Lunak), DKV (Desain Komunikasi Visual)');
        $this->command->info('- Total: 15 SMK classes with 30 students capacity each');
    }
}