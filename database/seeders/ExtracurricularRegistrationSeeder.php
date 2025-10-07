<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Extracurricular;
use App\Models\ExtracurricularRegistration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ExtracurricularRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all extracurriculars
        $extracurriculars = Extracurricular::all();

        if ($extracurriculars->isEmpty()) {
            $this->command->info('No extracurriculars found. Please create some extracurriculars first.');
            return;
        }
        
        // Get admin user ID for approved_by field
        $adminUser = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', 'admin')
            ->select('users.id')
            ->first();
            
        if (!$adminUser) {
            // Fallback: get any user
            $adminUser = User::first();
            if (!$adminUser) {
                $this->command->error('No users found in database. Please create users first.');
                return;
            }
        }
        
        $adminUserId = $adminUser->id;

        // Sample student data
        $students = [
            [
                'student_name' => 'Ahmad Rizki Pratama',
                'student_class' => 'XII',
                'student_major' => 'TKJ 1',
                'student_nis' => '2021001',
                'email' => 'ahmad.rizki@student.smk.sch.id',
                'phone' => '081234567890',
                'parent_name' => 'Budi Pratama',
                'parent_phone' => '081234567891',
                'address' => 'Jl. Merdeka No. 123, Jakarta',
                'reason' => 'Saya ingin mengembangkan kemampuan di bidang teknologi dan jaringan komputer.',
                'experience' => 'Pernah mengikuti kursus komputer dasar dan memiliki sertifikat Microsoft Office.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Siti Nurhaliza',
                'student_class' => 'XI',
                'student_major' => 'RPL 2',
                'student_nis' => '2022002',
                'email' => 'siti.nurhaliza@student.smk.sch.id',
                'phone' => '081234567892',
                'parent_name' => 'Hasan Nurdin',
                'parent_phone' => '081234567893',
                'address' => 'Jl. Sudirman No. 456, Jakarta',
                'reason' => 'Ingin belajar programming dan mengembangkan aplikasi mobile.',
                'experience' => 'Sudah belajar HTML dan CSS secara otodidak.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Budi Santoso',
                'student_class' => 'X',
                'student_major' => 'DKV 1',
                'student_nis' => '2023003',
                'email' => 'budi.santoso@student.smk.sch.id',
                'phone' => '081234567894',
                'parent_name' => 'Santoso Wijaya',
                'parent_phone' => '081234567895',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta',
                'reason' => 'Saya tertarik dengan desain grafis dan ingin mengasah kreativitas.',
                'experience' => 'Pernah membuat poster untuk acara sekolah.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Dewi Lestari',
                'student_class' => 'XII',
                'student_major' => 'TKJ 2',
                'student_nis' => '2021004',
                'email' => 'dewi.lestari@student.smk.sch.id',
                'phone' => '081234567896',
                'parent_name' => 'Lestari Indah',
                'parent_phone' => '081234567897',
                'address' => 'Jl. Thamrin No. 321, Jakarta',
                'reason' => 'Ingin memperdalam ilmu jaringan komputer dan keamanan siber.',
                'experience' => 'Mengikuti workshop cybersecurity di sekolah.',
                'status' => 'pending'
            ],
            [
                'student_name' => 'Andi Wijaya',
                'student_class' => 'XI',
                'student_major' => 'RPL 1',
                'student_nis' => '2022005',
                'email' => 'andi.wijaya@student.smk.sch.id',
                'phone' => '081234567898',
                'parent_name' => 'Wijaya Kusuma',
                'parent_phone' => '081234567899',
                'address' => 'Jl. Kuningan No. 654, Jakarta',
                'reason' => 'Passion saya di bidang software development dan ingin berkarir sebagai programmer.',
                'experience' => 'Sudah membuat beberapa project kecil dengan PHP dan JavaScript.',
                'status' => 'approved'
            ],
            [
                'student_name' => 'Maya Sari',
                'student_class' => 'X',
                'student_major' => 'DKV 2',
                'student_nis' => '2023006',
                'email' => 'maya.sari@student.smk.sch.id',
                'phone' => '081234567800',
                'parent_name' => 'Sari Dewi',
                'parent_phone' => '081234567801',
                'address' => 'Jl. Kemang No. 987, Jakarta',
                'reason' => 'Suka menggambar dan ingin belajar desain digital.',
                'experience' => 'Juara 2 lomba poster tingkat sekolah.',
                'status' => 'pending'
            ]
        ];

        foreach ($extracurriculars as $extracurricular) {
            // Add 2-4 random students to each extracurricular
            $selectedStudents = collect($students)->random(rand(2, 4));
            
            foreach ($selectedStudents as $student) {
                // Check if this student is already registered for this extracurricular
                $exists = ExtracurricularRegistration::where('extracurricular_id', $extracurricular->id)
                    ->where('student_nis', $student['student_nis'])
                    ->exists();
                
                if (!$exists) {
                    ExtracurricularRegistration::create([
                        'extracurricular_id' => $extracurricular->id,
                        'student_name' => $student['student_name'],
                        'student_class' => $student['student_class'],
                        'student_major' => $student['student_major'],
                        'student_nis' => $student['student_nis'],
                        'email' => $student['email'],
                        'phone' => $student['phone'],
                        'parent_name' => $student['parent_name'],
                        'parent_phone' => $student['parent_phone'],
                        'address' => $student['address'],
                        'reason' => $student['reason'],
                        'experience' => $student['experience'],
                        'status' => $student['status'],
                        'registered_at' => now(),
                        'approved_at' => $student['status'] === 'approved' ? now() : null,
                        'approved_by' => $student['status'] === 'approved' ? $adminUserId : null
                    ]);
                }
            }
        }

        $this->command->info('Extracurricular registrations seeded successfully!');
    }
}