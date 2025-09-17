@extends('layouts.teacher')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Jawaban: {{ $attempt->student->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $quiz->title }} • {{ $quiz->subject }}</p>
            </div>
            <a href="{{ route('teacher.quizzes.attempts', $quiz->id) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar Hasil
            </a>
        </div>
    </div>

    <!-- Student Info & Score -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Student Information -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Siswa</h3>
            <div class="flex items-center mb-4">
                <img class="h-16 w-16 rounded-full" 
                     src="{{ $attempt->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($attempt->student->name).'&color=059669&background=D1FAE5' }}" 
                     alt="{{ $attempt->student->name }}">
                <div class="ml-4">
                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">{{ $attempt->student->name }}</h4>
                    <p class="text-gray-600 dark:text-gray-400">{{ $attempt->student->email }}</p>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                    @if($attempt->status === 'completed')
                        <span class="text-sm font-medium text-green-600 dark:text-green-400">Selesai</span>
                    @elseif($attempt->status === 'in_progress')
                        <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Berlangsung</span>
                    @else
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ ucfirst($attempt->status) }}</span>
                    @endif
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Waktu Mulai:</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $attempt->started_at ? $attempt->started_at->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Waktu Selesai:</span>
                    <span class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ $attempt->completed_at ? $attempt->completed_at->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
                
                @if($attempt->started_at && $attempt->completed_at)
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Durasi:</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $attempt->started_at->diffInMinutes($attempt->completed_at) }} menit
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Score Summary -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Nilai</h3>
            
            @if($attempt->status === 'completed')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">
                            {{ number_format($attempt->score, 1) }}%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Nilai Akhir</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                            {{ $attempt->answers->where('is_correct', true)->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Jawaban Benar</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                            {{ $attempt->answers->where('is_correct', false)->count() }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Jawaban Salah</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">
                            @php
                                $grade = '';
                                if ($attempt->score >= 90) $grade = 'A';
                                elseif ($attempt->score >= 80) $grade = 'B';
                                elseif ($attempt->score >= 70) $grade = 'C';
                                elseif ($attempt->score >= 60) $grade = 'D';
                                else $grade = 'E';
                            @endphp
                            {{ $grade }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Grade</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <span>Progress</span>
                        <span>{{ $attempt->answers->where('is_correct', true)->count() }}/{{ $quiz->questions->count() }} benar</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-gray-700">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($attempt->answers->where('is_correct', true)->count() / $quiz->questions->count()) * 100 }}%"></div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Kuis belum selesai dikerjakan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Answers Detail -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Detail Jawaban</h3>
        </div>
        
        <div class="p-6">
            @if($attempt->answers->count() > 0)
                <form action="{{ route('teacher.quizzes.grade-essay', [$quiz->id, $attempt->id]) }}" method="POST" id="grading-form">
                    @csrf
                    <div class="space-y-8">
                        @foreach($quiz->questions as $index => $question)
                            @php
                                $answer = $attempt->answers->where('question_id', $question->id)->first();
                            @endphp
                            
                            <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-6">
                                <div class="flex items-start justify-between mb-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                        Soal {{ $index + 1 }}
                                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">({{ $question->points }} poin)</span>
                                    </h4>
                                    
                                    @if($answer)
                                        @if($answer->is_correct === true)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Benar
                                            </span>
                                        @elseif($answer->is_correct === false)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Salah
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Perlu Dinilai
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                            Tidak Dijawab
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Question Text -->
                                <div class="mb-4">
                                    <p class="text-gray-700 dark:text-gray-300 font-medium">{{ $question->question }}</p>
                                </div>
                                
                                <!-- Question Options & Correct Answer -->
                                @if($question->type === 'multiple_choice' && $question->options)
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilihan Jawaban:</h5>
                                        <div class="space-y-2">
                                            @foreach($question->options as $key => $option)
                                                <div class="flex items-center p-2 rounded {{ $question->correct_answer === $key ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-gray-700' }}">
                                                    <span class="w-6 h-6 rounded-full border-2 {{ $question->correct_answer === $key ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300' }} flex items-center justify-center text-sm font-medium mr-3">
                                                        {{ $key }}
                                                    </span>
                                                    <span class="text-gray-700 dark:text-gray-300 {{ $question->correct_answer === $key ? 'font-medium text-green-700 dark:text-green-400' : '' }}">
                                                        {{ $option }}
                                                    </span>
                                                    @if($question->correct_answer === $key)
                                                        <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($question->type === 'true_false')
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jawaban yang Benar:</h5>
                                        <div class="space-y-2">
                                            <div class="flex items-center p-2 rounded {{ $question->correct_answer === 'true' ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-gray-700' }}">
                                                <span class="w-6 h-6 rounded-full border-2 {{ $question->correct_answer === 'true' ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300' }} flex items-center justify-center text-sm font-medium mr-3">
                                                    T
                                                </span>
                                                <span class="text-gray-700 dark:text-gray-300 {{ $question->correct_answer === 'true' ? 'font-medium text-green-700 dark:text-green-400' : '' }}">
                                                    Benar
                                                </span>
                                                @if($question->correct_answer === 'true')
                                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex items-center p-2 rounded {{ $question->correct_answer === 'false' ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-gray-50 dark:bg-gray-700' }}">
                                                <span class="w-6 h-6 rounded-full border-2 {{ $question->correct_answer === 'false' ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300' }} flex items-center justify-center text-sm font-medium mr-3">
                                                    F
                                                </span>
                                                <span class="text-gray-700 dark:text-gray-300 {{ $question->correct_answer === 'false' ? 'font-medium text-green-700 dark:text-green-400' : '' }}">
                                                    Salah
                                                </span>
                                                @if($question->correct_answer === 'false')
                                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Student Answer -->
                                <div class="mb-4">
                                    <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jawaban Siswa:</h5>
                                    @if($answer && $answer->answer)
                                        @if($question->type === 'essay')
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $answer->answer }}</p>
                                            </div>
                                        @else
                                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                                <p class="text-gray-900 dark:text-white font-medium">
                                                    @if($question->type === 'multiple_choice' && isset($question->options[$answer->answer]))
                                                        {{ $answer->answer }}. {{ $question->options[$answer->answer] }}
                                                    @elseif($question->type === 'true_false')
                                                        {{ $answer->answer === 'true' ? 'Benar' : 'Salah' }}
                                                    @else
                                                        {{ $answer->answer }}
                                                    @endif
                                                </p>
                                            </div>
                                        @endif
                                    @else
                                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                                            <p class="text-red-800 dark:text-red-200 text-sm">Tidak ada jawaban</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Manual Grading for Essay Questions -->
                                @if($question->type === 'essay' && $answer && $answer->is_correct === null)
                                    <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                        <h5 class="text-sm font-medium text-yellow-800 dark:text-yellow-200 mb-2">Penilaian Manual:</h5>
                                        <div class="flex items-center space-x-4">
                                            <label class="text-sm text-yellow-700 dark:text-yellow-300">Poin yang diperoleh:</label>
                                            <input type="number" 
                                                   name="grades[{{ $answer->id }}]" 
                                                   min="0" 
                                                   max="{{ $question->points }}"
                                                   value="{{ $answer->points_earned }}"
                                                   class="w-20 px-3 py-1 border border-yellow-300 dark:border-yellow-600 rounded focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-yellow-900/50 dark:text-yellow-100"
                                                   placeholder="0">
                                            <span class="text-sm text-yellow-700 dark:text-yellow-300">dari {{ $question->points }} poin</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Points Earned -->
                                @if($answer)
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Poin yang diperoleh:</span>
                                        <span class="text-sm font-medium {{ $answer->is_correct === true ? 'text-green-600 dark:text-green-400' : ($answer->is_correct === false ? 'text-red-600 dark:text-red-400' : 'text-yellow-600 dark:text-yellow-400') }}">
                                            {{ $answer->points_earned ?? 0 }} / {{ $question->points }} poin
                                        </span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Submit Grading Button -->
                    @if($attempt->answers->where('is_correct', null)->count() > 0)
                        <div class="mt-6 text-center">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Penilaian
                            </button>
                        </div>
                    @endif
                </form>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada jawaban</h3>
                    <p class="text-gray-500 dark:text-gray-400">Siswa belum menjawab soal apapun</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection