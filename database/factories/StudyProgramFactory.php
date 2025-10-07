<?php

namespace Database\Factories;

use App\Models\StudyProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudyProgram>
 */
class StudyProgramFactory extends Factory
{
    protected $model = StudyProgram::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $degreeLevel = $this->faker->randomElement(['D3', 'S1', 'S2', 'S3']);
        $faculties = [
            'Fakultas Teknik',
            'Fakultas Ekonomi',
            'Fakultas Hukum',
            'Fakultas Kedokteran',
            'Fakultas Pendidikan',
            'Fakultas Sains dan Teknologi'
        ];

        $programNames = [
            'D3' => [
                'Manajemen Informatika',
                'Akuntansi Komputer',
                'Teknik Komputer',
                'Administrasi Bisnis'
            ],
            'S1' => [
                'Teknik Informatika',
                'Sistem Informasi',
                'Teknik Elektro',
                'Manajemen',
                'Akuntansi',
                'Hukum',
                'Kedokteran',
                'Pendidikan Matematika'
            ],
            'S2' => [
                'Magister Teknik Informatika',
                'Magister Manajemen',
                'Magister Hukum',
                'Magister Pendidikan'
            ],
            'S3' => [
                'Doktor Teknik Informatika',
                'Doktor Manajemen',
                'Doktor Hukum'
            ]
        ];

        $degreeTitles = [
            'D3' => ['A.Md.Kom', 'A.Md.Ak', 'A.Md.T', 'A.Md'],
            'S1' => ['S.Kom', 'S.E', 'S.T', 'S.H', 'S.Pd', 'S.Ked'],
            'S2' => ['M.Kom', 'M.M', 'M.T', 'M.H', 'M.Pd'],
            'S3' => ['Dr.', 'Ph.D']
        ];

        $programName = $this->faker->randomElement($programNames[$degreeLevel]);
        $faculty = $this->faker->randomElement($faculties);

        return [
            'program_name' => $programName,
            'program_code' => strtoupper($this->faker->lexify('??')),
            'description' => $this->faker->paragraph(3),
            'degree_level' => $degreeLevel,
            'faculty' => $faculty,
            'vision' => $this->faker->paragraph(2),
            'mission' => $this->faker->paragraph(3),
            'career_prospects' => $this->faker->paragraph(2),
            'admission_requirements' => $this->faker->paragraph(2),
            'duration_years' => $this->getDurationByDegree($degreeLevel),
            'total_credits' => $this->getCreditsByDegree($degreeLevel),
            'degree_title' => $this->faker->randomElement($degreeTitles[$degreeLevel]),
            'accreditation' => $this->faker->randomElement(['A', 'B', 'C']),
            'capacity' => $this->faker->numberBetween(20, 50),
            'tuition_fee' => $this->faker->numberBetween(3000000, 10000000),
            'core_subjects' => $this->generateCoreSubjects(),
            'specializations' => $this->generateSpecializations(),
            'facilities' => $this->generateFacilities(),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'is_featured' => $this->faker->boolean(20), // 20% chance of being featured
        ];
    }

    /**
     * Get duration based on degree level.
     */
    private function getDurationByDegree(string $degree): int
    {
        return match ($degree) {
            'D3' => 3,
            'S1' => 4,
            'S2' => 2,
            'S3' => 3,
            default => 4,
        };
    }

    /**
     * Get credits based on degree level.
     */
    private function getCreditsByDegree(string $degree): int
    {
        return match ($degree) {
            'D3' => $this->faker->numberBetween(110, 120),
            'S1' => $this->faker->numberBetween(140, 150),
            'S2' => $this->faker->numberBetween(36, 48),
            'S3' => $this->faker->numberBetween(42, 54),
            default => 144,
        };
    }

    /**
     * Generate core subjects.
     */
    private function generateCoreSubjects(): array
    {
        $subjects = [];
        $subjectCount = $this->faker->numberBetween(3, 8);

        $subjectNames = [
            'Algoritma dan Pemrograman',
            'Struktur Data',
            'Basis Data',
            'Rekayasa Perangkat Lunak',
            'Jaringan Komputer',
            'Sistem Operasi',
            'Matematika Diskrit',
            'Statistika',
            'Manajemen Proyek',
            'Keamanan Sistem',
        ];

        for ($i = 1; $i <= $subjectCount; $i++) {
            $subjects[] = [
                'id' => $i,
                'name' => $this->faker->randomElement($subjectNames),
                'code' => strtoupper($this->faker->lexify('??')) . $this->faker->numberBetween(101, 999),
                'credits' => (string) $this->faker->numberBetween(2, 4),
                'semester' => (string) $this->faker->numberBetween(1, 8),
                'description' => $this->faker->sentence(),
            ];
        }

        return $subjects;
    }

    /**
     * Generate specializations.
     */
    private function generateSpecializations(): array
    {
        $specializations = [];
        $specializationCount = $this->faker->numberBetween(0, 3);

        $specializationNames = [
            'Web Development',
            'Mobile Development',
            'Data Science',
            'Artificial Intelligence',
            'Cybersecurity',
            'Cloud Computing',
            'Game Development',
            'IoT Development',
        ];

        for ($i = 1; $i <= $specializationCount; $i++) {
            $specializations[] = [
                'id' => $i,
                'name' => $this->faker->randomElement($specializationNames),
                'description' => $this->faker->sentence(),
                'requirements' => $this->faker->sentence(),
            ];
        }

        return $specializations;
    }

    /**
     * Generate facilities.
     */
    private function generateFacilities(): array
    {
        $facilities = [];
        $facilityCount = $this->faker->numberBetween(2, 6);

        $facilityData = [
            ['name' => 'Laboratorium Komputer', 'icon' => 'fas fa-desktop', 'color' => 'primary'],
            ['name' => 'Laboratorium Jaringan', 'icon' => 'fas fa-wifi', 'color' => 'success'],
            ['name' => 'Perpustakaan Digital', 'icon' => 'fas fa-book', 'color' => 'info'],
            ['name' => 'Ruang Multimedia', 'icon' => 'fas fa-video', 'color' => 'warning'],
            ['name' => 'Lab Penelitian', 'icon' => 'fas fa-microscope', 'color' => 'danger'],
            ['name' => 'Ruang Seminar', 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'purple'],
        ];

        for ($i = 1; $i <= $facilityCount; $i++) {
            $facility = $this->faker->randomElement($facilityData);
            $facilities[] = [
                'id' => $i,
                'name' => $facility['name'],
                'description' => $this->faker->sentence(),
                'icon' => $facility['icon'],
                'color' => $facility['color'],
            ];
        }

        return $facilities;
    }

    /**
     * Indicate that the study program is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the study program is featured.
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the study program is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}