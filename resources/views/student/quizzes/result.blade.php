@extends('layouts.student')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('student.quizzes.index') }}" 
               class="inline-flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Kuis
            </a>
        </div>

        <!-- Result Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                    Hasil Kuis: {{ $attempt->quiz->title }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300">
                    {{ $attempt->quiz->subject }} • {{ $attempt->quiz->teacher->name ?? 'Unknown Teacher' }}
                </p>
            </div>
            
            <!-- Score Summary -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <!-- Score -->
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2 {{ $attempt->score >= 80 ? 'text-green-600 dark:text-green-400' : ($attempt->score >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ $attempt->score ?? 0 }}%
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Nilai Anda</div>
                    </div>
                    
                    <!-- Grade -->
                    <div class="text-center">
                        <div class="text-4xl font-bold mb-2 {{ $attempt->score >= 80 ? 'text-green-600 dark:text-green-400' : ($attempt->score >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                            {{ $attempt->grade_letter ?? 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Nilai</div>
                    </div>
                    
                    <!-- Duration -->
                    <div class="text-center">
                        <div class="text-4xl font-bold text-blue-600 dark:text-blue-400 mb-2">
                            {{ $attempt->duration ?? 0 }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Menit</div>
                    </div>
                    
                    <!-- Completion -->
                    <div class="text-center">
                        <div class="text-4xl font-bold text-purple-600 dark:text-purple-400 mb-2">
                            {{ $attempt->completed_at ? $attempt->completed_at->format('H:i') : 'N/A' }}
                        </div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Selesai</div>
                    </div>
                </div>
                
                <!-- Performance Message -->
                <div class="mt-6 text-center">
                    @if($attempt->score >= 90)
                        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-green-800 dark:text-green-200 font-medium">Excellent! Hasil yang sangat baik!</span>
                            </div>
                        </div>
                    @elseif($attempt->score >= 80)
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                </svg>
                                <span class="text-blue-800 dark:text-blue-200 font-medium">Good job! Hasil yang baik!</span>
                            </div>
                        </div>
                    @elseif($attempt->score >= 60)
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-yellow-800 dark:text-yellow-200 font-medium">Not bad! Masih bisa ditingkatkan lagi.</span>
                            </div>
                        </div>
                    @else
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <div class="flex items-center justify-center">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-red-800 dark:text-red-200 font-medium">Keep trying! Belajar lebih giat lagi ya.</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Detailed Results -->
        @if($attempt->quiz->show_results)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detail Jawaban</h2>
                </div>
                
                <div class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($attempt->quiz->questions as $index => $question)
                        @php
                            $answer = $attempt->answers->where('question_id', $question->id)->first();
                            $isCorrect = $answer && $answer->is_correct;
                        @endphp
                        
                        <div class="p-6">
                            <!-- Question Header -->
                            <div class="flex items-start justify-between mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    Soal {{ $index + 1 }}
                                </h3>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $question->points }} poin</span>
                                    @if($isCorrect)
                                        <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs px-2 py-1 rounded-full">
                                            Benar
                                        </span>
                                    @else
                                        <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 text-xs px-2 py-1 rounded-full">
                                            Salah
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Question Text -->
                            <div class="mb-4">
                                <p class="text-gray-900 dark:text-white">
                                    {!! nl2br(e($question->question)) !!}
                                </p>
                            </div>
                            
                            <!-- Answer Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Your Answer -->
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jawaban Anda:</h4>
                                    <div class="p-3 rounded-lg {{ $isCorrect ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' }}">
                                        <span class="{{ $isCorrect ? 'text-green-800 dark:text-green-200' : 'text-red-800 dark:text-red-200' }}">
                                            {{ $answer->answer ?? 'Tidak dijawab' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <!-- Correct Answer -->
                                @if($question->type !== 'essay')
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jawaban Benar:</h4>
                                        <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                            <span class="text-green-800 dark:text-green-200">
                                                {{ $question->correct_answer }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <!-- Results Hidden Message -->
            <div class="bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Detail Jawaban Disembunyikan</h3>
                <p class="text-gray-600 dark:text-gray-400">
                    Guru tidak mengizinkan untuk melihat detail jawaban dan pembahasan.
                </p>
            </div>
        @endif
        
        <!-- Action Buttons -->
        <div class="mt-8 text-center space-x-4">
            <a href="{{ route('student.quizzes.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                Kembali ke Daftar Kuis
            </a>
            
            @if($attempt->quiz->show_results)
                <button onclick="window.print()" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Cetak Hasil
                </button>
            @endif
        </div>
    </div>
</div>

<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-white, .bg-gray-800 {
        background: white !important;
        border: 1px solid #e5e7eb !important;
    }
    
    .text-white {
        color: black !important;
    }
}
</style>
@endsection