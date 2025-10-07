<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudyProgram;

class StudyProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'program_name' => 'Teknik Informatika',
                'program_code' => 'TI',
                'description' => 'Program studi yang mempelajari teknologi informasi, pemrograman, dan pengembangan sistem komputer.',
                'degree_level' => 'S1',
                'faculty' => 'Fakultas Teknik',
                'vision' => 'Menjadi program studi unggulan dalam bidang teknologi informasi yang menghasilkan lulusan berkualitas dan berdaya saing global.',
                'mission' => 'Menyelenggarakan pendidikan berkualitas di bidang teknologi informasi, melakukan penelitian inovatif, dan memberikan pengabdian kepada masyarakat.',
                'career_prospects' => 'Software Developer, System Analyst, Database Administrator, Network Administrator, IT Consultant, Web Developer, Mobile App Developer.',
                'admission_requirements' => 'Lulusan SMA/SMK jurusan IPA atau yang setara dengan nilai matematika minimal 7.0.',
                'duration_years' => 4,
                'total_credits' => 144,
                'degree_title' => 'S.Kom',
                'accreditation' => 'A',
                'capacity' => 40,
                'tuition_fee' => 5000000,
                'core_subjects' => [
                    [
                        'id' => 1,
                        'name' => 'Algoritma dan Pemrograman',
                        'code' => 'TI101',
                        'credits' => '3',
                        'semester' => '1',
                        'description' => 'Mata kuliah dasar pemrograman dan logika algoritma'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Struktur Data',
                        'code' => 'TI201',
                        'credits' => '3',
                        'semester' => '2',
                        'description' => 'Mempelajari berbagai struktur data dan implementasinya'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Basis Data',
                        'code' => 'TI301',
                        'credits' => '3',
                        'semester' => '3',
                        'description' => 'Konsep dan implementasi sistem basis data'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Rekayasa Perangkat Lunak',
                        'code' => 'TI401',
                        'credits' => '3',
                        'semester' => '4',
                        'description' => 'Metodologi pengembangan perangkat lunak'
                    ]
                ],
                'specializations' => [
                    [
                        'id' => 1,
                        'name' => 'Web Development',
                        'description' => 'Spesialisasi dalam pengembangan aplikasi web modern',
                        'requirements' => 'Menguasai HTML, CSS, JavaScript, dan framework web'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Mobile Development',
                        'description' => 'Spesialisasi dalam pengembangan aplikasi mobile',
                        'requirements' => 'Menguasai Java/Kotlin untuk Android atau Swift untuk iOS'
                    ]
                ],
                'facilities' => [
                    [
                        'id' => 1,
                        'name' => 'Laboratorium Komputer',
                        'description' => 'Lab dengan 40 unit komputer terbaru',
                        'icon' => 'fas fa-desktop',
                        'color' => 'primary'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Laboratorium Jaringan',
                        'description' => 'Lab khusus untuk praktikum jaringan komputer',
                        'icon' => 'fas fa-wifi',
                        'color' => 'success'
                    ]
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'program_name' => 'Sistem Informasi',
                'program_code' => 'SI',
                'description' => 'Program studi yang menggabungkan teknologi informasi dengan manajemen bisnis.',
                'degree_level' => 'S1',
                'faculty' => 'Fakultas Teknik',
                'vision' => 'Menjadi program studi terdepan dalam bidang sistem informasi yang mengintegrasikan teknologi dan bisnis.',
                'mission' => 'Menghasilkan lulusan yang kompeten dalam merancang dan mengelola sistem informasi untuk mendukung proses bisnis.',
                'career_prospects' => 'Business Analyst, System Analyst, IT Project Manager, ERP Consultant, Data Analyst.',
                'admission_requirements' => 'Lulusan SMA/SMK semua jurusan dengan kemampuan dasar matematika dan logika.',
                'duration_years' => 4,
                'total_credits' => 144,
                'degree_title' => 'S.Kom',
                'accreditation' => 'B',
                'capacity' => 35,
                'tuition_fee' => 4500000,
                'core_subjects' => [
                    [
                        'id' => 1,
                        'name' => 'Pengantar Sistem Informasi',
                        'code' => 'SI101',
                        'credits' => '3',
                        'semester' => '1',
                        'description' => 'Konsep dasar sistem informasi dalam organisasi'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Analisis dan Perancangan Sistem',
                        'code' => 'SI201',
                        'credits' => '3',
                        'semester' => '2',
                        'description' => 'Metodologi analisis dan perancangan sistem informasi'
                    ]
                ],
                'specializations' => [
                    [
                        'id' => 1,
                        'name' => 'Enterprise Resource Planning',
                        'description' => 'Spesialisasi dalam sistem ERP',
                        'requirements' => 'Memahami proses bisnis dan sistem terintegrasi'
                    ]
                ],
                'facilities' => [
                    [
                        'id' => 1,
                        'name' => 'Lab Sistem Informasi',
                        'description' => 'Lab dengan software ERP dan business intelligence',
                        'icon' => 'fas fa-chart-bar',
                        'color' => 'warning'
                    ]
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'program_name' => 'Manajemen Informatika',
                'program_code' => 'MI',
                'description' => 'Program diploma yang fokus pada penerapan teknologi informasi dalam dunia kerja.',
                'degree_level' => 'D3',
                'faculty' => 'Fakultas Teknik',
                'vision' => 'Menghasilkan tenaga ahli madya yang kompeten di bidang manajemen informatika.',
                'mission' => 'Memberikan pendidikan vokasi yang berorientasi pada kebutuhan industri.',
                'career_prospects' => 'Programmer, Database Administrator, Network Technician, IT Support.',
                'admission_requirements' => 'Lulusan SMA/SMK semua jurusan.',
                'duration_years' => 3,
                'total_credits' => 110,
                'degree_title' => 'A.Md.Kom',
                'accreditation' => 'B',
                'capacity' => 30,
                'tuition_fee' => 3500000,
                'core_subjects' => [
                    [
                        'id' => 1,
                        'name' => 'Pemrograman Dasar',
                        'code' => 'MI101',
                        'credits' => '4',
                        'semester' => '1',
                        'description' => 'Dasar-dasar pemrograman komputer'
                    ]
                ],
                'specializations' => [],
                'facilities' => [
                    [
                        'id' => 1,
                        'name' => 'Lab Praktikum',
                        'description' => 'Lab untuk praktikum pemrograman',
                        'icon' => 'fas fa-code',
                        'color' => 'info'
                    ]
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'program_name' => 'Magister Teknik Informatika',
                'program_code' => 'MTI',
                'description' => 'Program magister untuk pengembangan keahlian lanjutan di bidang teknologi informasi.',
                'degree_level' => 'S2',
                'faculty' => 'Fakultas Teknik',
                'vision' => 'Menjadi program magister unggulan yang menghasilkan peneliti dan praktisi TI berkualitas tinggi.',
                'mission' => 'Menyelenggarakan pendidikan pascasarjana yang berorientasi pada penelitian dan inovasi teknologi.',
                'career_prospects' => 'Research Scientist, Senior Software Architect, IT Director, Technology Consultant.',
                'admission_requirements' => 'Lulusan S1 Teknik Informatika atau bidang terkait dengan IPK minimal 3.0.',
                'duration_years' => 2,
                'total_credits' => 42,
                'degree_title' => 'M.Kom',
                'accreditation' => 'A',
                'capacity' => 20,
                'tuition_fee' => 8000000,
                'core_subjects' => [
                    [
                        'id' => 1,
                        'name' => 'Metodologi Penelitian',
                        'code' => 'MTI701',
                        'credits' => '3',
                        'semester' => '1',
                        'description' => 'Metodologi penelitian dalam bidang informatika'
                    ]
                ],
                'specializations' => [
                    [
                        'id' => 1,
                        'name' => 'Artificial Intelligence',
                        'description' => 'Spesialisasi dalam kecerdasan buatan',
                        'requirements' => 'Background matematika dan statistika yang kuat'
                    ]
                ],
                'facilities' => [
                    [
                        'id' => 1,
                        'name' => 'Lab Penelitian AI',
                        'description' => 'Lab dengan GPU cluster untuk deep learning',
                        'icon' => 'fas fa-brain',
                        'color' => 'purple'
                    ]
                ],
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'program_name' => 'Akuntansi',
                'program_code' => 'AK',
                'description' => 'Program studi yang mempelajari pencatatan, pengukuran, dan komunikasi informasi keuangan.',
                'degree_level' => 'S1',
                'faculty' => 'Fakultas Ekonomi',
                'vision' => 'Menjadi program studi akuntansi terkemuka yang menghasilkan akuntan profesional.',
                'mission' => 'Menyelenggarakan pendidikan akuntansi berkualitas dengan standar internasional.',
                'career_prospects' => 'Akuntan Publik, Auditor, Financial Analyst, Tax Consultant, Controller.',
                'admission_requirements' => 'Lulusan SMA/SMK jurusan IPS atau IPA dengan kemampuan matematika yang baik.',
                'duration_years' => 4,
                'total_credits' => 144,
                'degree_title' => 'S.Ak',
                'accreditation' => 'A',
                'capacity' => 45,
                'tuition_fee' => 4000000,
                'core_subjects' => [
                    [
                        'id' => 1,
                        'name' => 'Pengantar Akuntansi',
                        'code' => 'AK101',
                        'credits' => '3',
                        'semester' => '1',
                        'description' => 'Konsep dasar akuntansi dan siklus akuntansi'
                    ]
                ],
                'specializations' => [
                    [
                        'id' => 1,
                        'name' => 'Akuntansi Keuangan',
                        'description' => 'Spesialisasi dalam pelaporan keuangan',
                        'requirements' => 'Menguasai standar akuntansi keuangan'
                    ]
                ],
                'facilities' => [
                    [
                        'id' => 1,
                        'name' => 'Lab Akuntansi',
                        'description' => 'Lab dengan software akuntansi terkini',
                        'icon' => 'fas fa-calculator',
                        'color' => 'success'
                    ]
                ],
                'is_active' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($programs as $program) {
            StudyProgram::create($program);
        }
    }
}