<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\User;
use Carbon\Carbon;

class AssessmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a teacher user
        $teacher = User::role('teacher')->first();
        
        if (!$teacher) {
            $this->command->warn('No teacher found. Please run UserSeeder first.');
            return;
        }

        // Create sample assessments
        $assessments = [
            [
                'title' => 'Ujian Tengah Semester - Matematika',
                'subject' => 'Matematika',
                'class' => 'VIII A',
                'type' => 'exam',
                'date' => Carbon::now()->addDays(7)->setTime(8, 0),
                'duration' => 90,
                'max_score' => 100,
                'status' => 'scheduled',
                'description' => 'Ujian tengah semester untuk materi aljabar dan geometri',
                'instructions' => 'Kerjakan dengan teliti, baca soal dengan seksama. Waktu pengerjaan 90 menit.',
                'questions' => [
                    [
                        'question' => 'Hasil dari 2x + 3 = 11 adalah...',
                        'type' => 'multiple_choice',
                        'options' => ['x = 3', 'x = 4', 'x = 5', 'x = 6'],
                        'correct_answer' => '1',
                        'points' => 10
                    ],
                    [
                        'question' => 'Jelaskan langkah-langkah menyelesaikan persamaan linear satu variabel!',
                        'type' => 'essay',
                        'options' => null,
                        'correct_answer' => null,
                        'points' => 20
                    ]
                ]
            ],
            [
                'title' => 'Kuis Harian - Sistem Pernapasan',
                'subject' => 'Biologi',
                'class' => 'VII A',
                'type' => 'quiz',
                'date' => Carbon::now()->addDays(3)->setTime(10, 0),
                'duration' => 30,
                'max_score' => 50,
                'status' => 'scheduled',
                'description' => 'Kuis tentang sistem pernapasan manusia',
                'instructions' => 'Pilih jawaban yang paling tepat. Waktu pengerjaan 30 menit.',
                'questions' => [
                    [
                        'question' => 'Organ utama dalam sistem pernapasan adalah...',
                        'type' => 'multiple_choice',
                        'options' => ['Jantung', 'Paru-paru', 'Hati', 'Ginjal'],
                        'correct_answer' => '1',
                        'points' => 10
                    ],
                    [
                        'question' => 'Proses pertukaran gas terjadi di alveolus.',
                        'type' => 'true_false',
                        'options' => null,
                        'correct_answer' => 'true',
                        'points' => 10
                    ]
                ]
            ],
            [
                'title' => 'Ulangan Harian - Teks Argumentasi',
                'subject' => 'Bahasa Indonesia',
                'class' => 'IX B',
                'type' => 'test',
                'date' => Carbon::now()->addDays(10)->setTime(13, 0),
                'duration' => 60,
                'max_score' => 75,
                'status' => 'scheduled',
                'description' => 'Ulangan tentang struktur dan ciri-ciri teks argumentasi',
                'instructions' => 'Baca teks dengan cermat sebelum menjawab pertanyaan.',
                'questions' => [
                    [
                        'question' => 'Apa yang dimaksud dengan teks argumentasi?',
                        'type' => 'essay',
                        'options' => null,
                        'correct_answer' => null,
                        'points' => 15
                    ],
                    [
                        'question' => 'Sebutkan 3 ciri-ciri teks argumentasi!',
                        'type' => 'short_answer',
                        'options' => null,
                        'correct_answer' => null,
                        'points' => 15
                    ]
                ]
            ],
            [
                'title' => 'Praktikum Fisika - Hukum Newton',
                'subject' => 'Fisika',
                'class' => 'IX A',
                'type' => 'practical',
                'date' => Carbon::now()->addDays(5)->setTime(14, 0),
                'duration' => 120,
                'max_score' => 100,
                'status' => 'scheduled',
                'description' => 'Praktikum untuk membuktikan hukum Newton tentang gerak',
                'instructions' => 'Ikuti prosedur praktikum dengan hati-hati. Catat semua hasil pengamatan.',
                'questions' => [
                    [
                        'question' => 'Apa bunyi hukum Newton I?',
                        'type' => 'essay',
                        'options' => null,
                        'correct_answer' => null,
                        'points' => 25
                    ],
                    [
                        'question' => 'Berdasarkan percobaan, apakah hukum Newton terbukti?',
                        'type' => 'true_false',
                        'options' => null,
                        'correct_answer' => 'true',
                        'points' => 25
                    ]
                ]
            ],
            [
                'title' => 'Tugas Mandiri - Ekosistem',
                'subject' => 'Biologi',
                'class' => 'VIII B',
                'type' => 'assignment',
                'date' => Carbon::now()->addDays(14)->setTime(23, 59),
                'duration' => 1440, // 24 hours
                'max_score' => 80,
                'status' => 'scheduled',
                'description' => 'Tugas mandiri tentang komponen ekosistem dan interaksinya',
                'instructions' => 'Kerjakan tugas secara mandiri. Boleh menggunakan referensi buku dan internet.',
                'questions' => [
                    [
                        'question' => 'Jelaskan perbedaan antara komponen biotik dan abiotik dalam ekosistem!',
                        'type' => 'essay',
                        'options' => null,
                        'correct_answer' => null,
                        'points' => 20
                    ],
                    [
                        'question' => 'Berikan contoh rantai makanan dalam ekosistem sawah!',
                        'type' => 'essay',
                        'options' => null,
                        'correct_answer' => null,
                        'points' => 20
                    ]
                ]
            ]
        ];

        foreach ($assessments as $assessmentData) {
            $questions = $assessmentData['questions'];
            unset($assessmentData['questions']);
            
            $assessmentData['user_id'] = $teacher->id;
            
            $assessment = Assessment::create($assessmentData);
            
            foreach ($questions as $index => $questionData) {
                $questionData['assessment_id'] = $assessment->id;
                $questionData['question_number'] = $index + 1;
                
                AssessmentQuestion::create($questionData);
            }
        }

        $this->command->info('Sample assessments created successfully!');
    }
}