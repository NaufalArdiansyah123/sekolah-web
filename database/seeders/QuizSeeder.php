<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\User;
use Carbon\Carbon;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get a teacher user
        $teacher = User::whereHas('roles', function($q) {
            $q->where('name', 'teacher');
        })->first();

        if (!$teacher) {
            // Create a teacher if none exists
            $teacher = User::create([
                'name' => 'Teacher Demo',
                'email' => 'teacher@demo.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]);
            $teacher->assignRole('teacher');
        }

        // Create sample quizzes
        $quizzes = [
            [
                'title' => 'Kuis Matematika - Aljabar',
                'description' => 'Kuis tentang dasar-dasar aljabar untuk siswa kelas 10',
                'subject' => 'Matematika',
                'teacher_id' => $teacher->id,
                'start_time' => Carbon::now('Asia/Jakarta')->subHours(1), // Started 1 hour ago
                'end_time' => Carbon::now('Asia/Jakarta')->addDays(7), // Ends in 7 days
                'duration_minutes' => 60,
                'max_attempts' => 1,
                'status' => 'published',
                'instructions' => 'Bacalah setiap soal dengan teliti sebelum menjawab. Waktu pengerjaan adalah 60 menit.',
                'show_results' => true,
                'randomize_questions' => false,
                'questions' => [
                    [
                        'question' => 'Berapakah hasil dari 2x + 3 = 11?',
                        'type' => 'multiple_choice',
                        'options' => ['A' => '4', 'B' => '5', 'C' => '6', 'D' => '7'],
                        'correct_answer' => 'A',
                        'points' => 10,
                    ],
                    [
                        'question' => 'Apakah 3x - 6 = 0 memiliki solusi x = 2?',
                        'type' => 'true_false',
                        'options' => null,
                        'correct_answer' => 'true',
                        'points' => 10,
                    ],
                    [
                        'question' => 'Jelaskan langkah-langkah untuk menyelesaikan persamaan linear satu variabel!',
                        'type' => 'essay',
                        'options' => null,
                        'correct_answer' => 'manual',
                        'points' => 20,
                    ]
                ]
            ],
            [
                'title' => 'Kuis Fisika - Gerak Lurus',
                'description' => 'Kuis tentang konsep gerak lurus beraturan dan gerak lurus berubah beraturan',
                'subject' => 'Fisika',
                'teacher_id' => $teacher->id,
                'start_time' => Carbon::now('Asia/Jakarta')->subMinutes(30), // Started 30 minutes ago
                'end_time' => Carbon::now('Asia/Jakarta')->addDays(3), // Ends in 3 days
                'duration_minutes' => 45,
                'max_attempts' => 2,
                'status' => 'published',
                'instructions' => 'Gunakan rumus fisika yang tepat untuk menjawab setiap soal.',
                'show_results' => true,
                'randomize_questions' => true,
                'questions' => [
                    [
                        'question' => 'Sebuah mobil bergerak dengan kecepatan konstan 60 km/jam. Berapa jarak yang ditempuh dalam 2 jam?',
                        'type' => 'multiple_choice',
                        'options' => ['A' => '120 km', 'B' => '100 km', 'C' => '80 km', 'D' => '60 km'],
                        'correct_answer' => 'A',
                        'points' => 15,
                    ],
                    [
                        'question' => 'Apakah percepatan adalah perubahan kecepatan terhadap waktu?',
                        'type' => 'true_false',
                        'options' => null,
                        'correct_answer' => 'true',
                        'points' => 10,
                    ]
                ]
            ],
            [
                'title' => 'Kuis Bahasa Indonesia - Teks Eksposisi',
                'description' => 'Kuis tentang struktur dan ciri-ciri teks eksposisi',
                'subject' => 'Bahasa Indonesia',
                'teacher_id' => $teacher->id,
                'start_time' => Carbon::now('Asia/Jakarta')->addHours(2), // Starts in 2 hours (upcoming)
                'end_time' => Carbon::now('Asia/Jakarta')->addDays(5), // Ends in 5 days
                'duration_minutes' => 90,
                'max_attempts' => 1,
                'status' => 'published',
                'instructions' => 'Bacalah teks dengan cermat sebelum menjawab pertanyaan.',
                'show_results' => false,
                'randomize_questions' => false,
                'questions' => [
                    [
                        'question' => 'Apa yang dimaksud dengan teks eksposisi?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'A' => 'Teks yang berisi cerita fiksi',
                            'B' => 'Teks yang berisi informasi dan penjelasan',
                            'C' => 'Teks yang berisi dialog',
                            'D' => 'Teks yang berisi puisi'
                        ],
                        'correct_answer' => 'B',
                        'points' => 10,
                    ]
                ]
            ],
            [
                'title' => 'Kuis Sejarah - Kemerdekaan Indonesia',
                'description' => 'Kuis tentang peristiwa-peristiwa menjelang kemerdekaan Indonesia',
                'subject' => 'Sejarah',
                'teacher_id' => $teacher->id,
                'start_time' => Carbon::now('Asia/Jakarta')->subDays(1), // Started yesterday
                'end_time' => Carbon::now('Asia/Jakarta')->subHours(2), // Ended 2 hours ago
                'duration_minutes' => 75,
                'max_attempts' => 1,
                'status' => 'published',
                'instructions' => 'Jawablah berdasarkan pengetahuan sejarah Indonesia.',
                'show_results' => true,
                'randomize_questions' => false,
                'questions' => [
                    [
                        'question' => 'Kapan Indonesia memproklamasikan kemerdekaan?',
                        'type' => 'multiple_choice',
                        'options' => [
                            'A' => '17 Agustus 1945',
                            'B' => '17 Agustus 1944',
                            'C' => '17 Agustus 1946',
                            'D' => '18 Agustus 1945'
                        ],
                        'correct_answer' => 'A',
                        'points' => 10,
                    ]
                ]
            ]
        ];

        foreach ($quizzes as $quizData) {
            $questions = $quizData['questions'];
            unset($quizData['questions']);

            $quiz = Quiz::create($quizData);

            foreach ($questions as $index => $questionData) {
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questionData['question'],
                    'type' => $questionData['type'],
                    'options' => $questionData['options'],
                    'correct_answer' => $questionData['correct_answer'],
                    'points' => $questionData['points'],
                    'order' => $index + 1,
                ]);
            }
        }

        $this->command->info('Quiz seeder completed! Created ' . count($quizzes) . ' quizzes with questions.');
    }
}