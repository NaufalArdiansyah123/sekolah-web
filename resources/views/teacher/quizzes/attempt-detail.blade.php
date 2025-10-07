@extends('layouts.teacher')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="rounded-xl shadow-sm border p-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary, #111827);">Detail Jawaban: {{ $attempt->student->name }}</h1>
                <p class="mt-1" style="color: var(--text-secondary, #6b7280);">{{ $quiz->title }} • {{ $quiz->subject }}</p>
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
        <div class="rounded-xl shadow-sm border p-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary, #111827);">Informasi Siswa</h3>
            <div class="flex items-center mb-4">
                <img class="h-16 w-16 rounded-full" 
                     src="{{ $attempt->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($attempt->student->name).'&color=059669&background=D1FAE5' }}" 
                     alt="{{ $attempt->student->name }}">
                <div class="ml-4">
                    <h4 class="text-lg font-medium" style="color: var(--text-primary, #111827);">{{ $attempt->student->name }}</h4>
                    <p style="color: var(--text-secondary, #6b7280);">{{ $attempt->student->email }}</p>
                </div>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Status:</span>
                    @if($attempt->status === 'completed')
                        <span class="text-sm font-medium" style="color: #059669;">Selesai</span>
                    @elseif($attempt->status === 'in_progress')
                        <span class="text-sm font-medium" style="color: #d97706;">Berlangsung</span>
                    @else
                        <span class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">{{ ucfirst($attempt->status) }}</span>
                    @endif
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Waktu Mulai:</span>
                    <span class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                        {{ $attempt->started_at ? $attempt->started_at->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Waktu Selesai:</span>
                    <span class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                        {{ $attempt->completed_at ? $attempt->completed_at->format('d M Y, H:i') : '-' }}
                    </span>
                </div>
                
                @if($attempt->started_at && $attempt->completed_at)
                    <div class="flex justify-between">
                        <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Durasi:</span>
                        <span class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                            {{ $attempt->started_at->diffInMinutes($attempt->completed_at) }} menit
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Score Summary -->
        <div class="lg:col-span-2 rounded-xl shadow-sm border p-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary, #111827);">Ringkasan Nilai</h3>
            
            @if($attempt->status === 'completed')
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: #2563eb;">
                            {{ number_format($attempt->score, 1) }}%
                        </div>
                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Nilai Akhir</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: #059669;">
                            {{ $attempt->answers->where('is_correct', true)->count() }}
                        </div>
                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Jawaban Benar</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: #dc2626;">
                            {{ $attempt->answers->where('is_correct', false)->count() }}
                        </div>
                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Jawaban Salah</div>
                    </div>
                    
                    <div class="text-center">
                        <div class="text-3xl font-bold" style="color: #7c3aed;">
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
                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Grade</div>
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="mt-6">
                    <div class="flex justify-between text-sm mb-2" style="color: var(--text-secondary, #6b7280);">
                        <span>Progress</span>
                        <span>{{ $attempt->answers->where('is_correct', true)->count() }}/{{ $quiz->questions->count() }} benar</span>
                    </div>
                    <div class="w-full rounded-full h-2" style="background: var(--bg-tertiary, #e5e7eb);">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($attempt->answers->where('is_correct', true)->count() / $quiz->questions->count()) * 100 }}%"></div>
                    </div>
                </div>
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 mx-auto mb-4" style="color: var(--text-tertiary, #9ca3af);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p style="color: var(--text-secondary, #6b7280);">Kuis belum selesai dikerjakan</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Answers Detail -->
    <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
            <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Detail Jawaban</h3>
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
                            
                            <div class="border rounded-lg p-6" style="border-color: var(--border-color, #e5e7eb);">
                                <div class="flex items-start justify-between mb-4">
                                    <h4 class="text-lg font-medium" style="color: var(--text-primary, #111827);">
                                        Soal {{ $index + 1 }}
                                        <span class="ml-2 text-sm" style="color: var(--text-secondary, #6b7280);">({{ $question->points }} poin)</span>
                                    </h4>
                                    
                                    @if($answer)
                                        @if($answer->is_correct === true)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Benar
                                            </span>
                                        @elseif($answer->is_correct === false)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(239, 68, 68, 0.1); color: #dc2626;">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Salah
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Perlu Dinilai
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(107, 114, 128, 0.1); color: #374151;">
                                            Tidak Dijawab
                                        </span>
                                    @endif
                                </div>
                                
                                <!-- Question Text -->
                                <div class="mb-4">
                                    <p class="font-medium" style="color: var(--text-primary, #374151);">{{ $question->question }}</p>
                                </div>
                                
                                <!-- Question Options & Correct Answer -->
                                @if($question->type === 'multiple_choice' && $question->options)
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">Pilihan Jawaban:</h5>
                                        <div class="space-y-2">
                                            @foreach($question->options as $key => $option)
                                                <div class="flex items-center p-2 rounded border" 
                                                     style="background: {{ $question->correct_answer === $key ? 'rgba(16, 185, 129, 0.1)' : 'var(--bg-tertiary, #f9fafb)' }}; border-color: {{ $question->correct_answer === $key ? 'rgba(16, 185, 129, 0.2)' : 'var(--border-color, #e5e7eb)' }};">
                                                    <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-sm font-medium mr-3" 
                                                          style="border-color: {{ $question->correct_answer === $key ? '#10b981' : 'var(--border-color, #d1d5db)' }}; background: {{ $question->correct_answer === $key ? 'rgba(16, 185, 129, 0.1)' : 'transparent' }}; color: {{ $question->correct_answer === $key ? '#059669' : 'var(--text-primary, #111827)' }};">
                                                        {{ $key }}
                                                    </span>
                                                    <span style="color: {{ $question->correct_answer === $key ? '#059669' : 'var(--text-primary, #374151)' }}; font-weight: {{ $question->correct_answer === $key ? '500' : 'normal' }};">
                                                        {{ $option }}
                                                    </span>
                                                    @if($question->correct_answer === $key)
                                                        <svg class="w-4 h-4 ml-2" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif($question->type === 'true_false')
                                    <div class="mb-4">
                                        <h5 class="text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">Jawaban yang Benar:</h5>
                                        <div class="space-y-2">
                                            <div class="flex items-center p-2 rounded border" 
                                                 style="background: {{ $question->correct_answer === 'true' ? 'rgba(16, 185, 129, 0.1)' : 'var(--bg-tertiary, #f9fafb)' }}; border-color: {{ $question->correct_answer === 'true' ? 'rgba(16, 185, 129, 0.2)' : 'var(--border-color, #e5e7eb)' }};">
                                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-sm font-medium mr-3" 
                                                      style="border-color: {{ $question->correct_answer === 'true' ? '#10b981' : 'var(--border-color, #d1d5db)' }}; background: {{ $question->correct_answer === 'true' ? 'rgba(16, 185, 129, 0.1)' : 'transparent' }}; color: {{ $question->correct_answer === 'true' ? '#059669' : 'var(--text-primary, #111827)' }};">
                                                    T
                                                </span>
                                                <span style="color: {{ $question->correct_answer === 'true' ? '#059669' : 'var(--text-primary, #374151)' }}; font-weight: {{ $question->correct_answer === 'true' ? '500' : 'normal' }};">
                                                    Benar
                                                </span>
                                                @if($question->correct_answer === 'true')
                                                    <svg class="w-4 h-4 ml-2" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div class="flex items-center p-2 rounded border" 
                                                 style="background: {{ $question->correct_answer === 'false' ? 'rgba(16, 185, 129, 0.1)' : 'var(--bg-tertiary, #f9fafb)' }}; border-color: {{ $question->correct_answer === 'false' ? 'rgba(16, 185, 129, 0.2)' : 'var(--border-color, #e5e7eb)' }};">
                                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-sm font-medium mr-3" 
                                                      style="border-color: {{ $question->correct_answer === 'false' ? '#10b981' : 'var(--border-color, #d1d5db)' }}; background: {{ $question->correct_answer === 'false' ? 'rgba(16, 185, 129, 0.1)' : 'transparent' }}; color: {{ $question->correct_answer === 'false' ? '#059669' : 'var(--text-primary, #111827)' }};">
                                                    F
                                                </span>
                                                <span style="color: {{ $question->correct_answer === 'false' ? '#059669' : 'var(--text-primary, #374151)' }}; font-weight: {{ $question->correct_answer === 'false' ? '500' : 'normal' }};">
                                                    Salah
                                                </span>
                                                @if($question->correct_answer === 'false')
                                                    <svg class="w-4 h-4 ml-2" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Student Answer -->
                                <div class="mb-4">
                                    <h5 class="text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">Jawaban Siswa:</h5>
                                    @if($answer && $answer->answer)
                                        @if($question->type === 'essay')
                                            <div class="rounded-lg p-4" style="background: var(--bg-tertiary, #f9fafb);">
                                                <p class="whitespace-pre-wrap" style="color: var(--text-primary, #111827);">{{ $answer->answer }}</p>
                                            </div>
                                        @else
                                            <div class="rounded-lg p-4" style="background: var(--bg-tertiary, #f9fafb);">
                                                <p class="font-medium" style="color: var(--text-primary, #111827);">
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
                                        <div class="border rounded-lg p-4" style="background: rgba(239, 68, 68, 0.1); border-color: rgba(239, 68, 68, 0.2);">
                                            <p class="text-sm" style="color: #b91c1c;">Tidak ada jawaban</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Manual Grading for Essay Questions -->
                                @if($question->type === 'essay' && $answer && $answer->is_correct === null)
                                    <div class="mt-4 p-4 border rounded-lg" style="background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                                        <h5 class="text-sm font-medium mb-2" style="color: #b45309;">Penilaian Manual:</h5>
                                        <div class="flex items-center space-x-4">
                                            <label class="text-sm" style="color: #92400e;">Poin yang diperoleh:</label>
                                            <input type="number" 
                                                   name="grades[{{ $answer->id }}]" 
                                                   min="0" 
                                                   max="{{ $question->points }}"
                                                   value="{{ $answer->points_earned }}"
                                                   class="w-20 px-3 py-1 border rounded focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500" 
                                                   style="border-color: rgba(245, 158, 11, 0.3); background: rgba(245, 158, 11, 0.05);"
                                                   placeholder="0">
                                            <span class="text-sm" style="color: #92400e;">dari {{ $question->points }} poin</span>
                                        </div>
                                    </div>
                                @endif
                                
                                <!-- Points Earned -->
                                @if($answer)
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Poin yang diperoleh:</span>
                                        <span class="text-sm font-medium" style="color: {{ $answer->is_correct === true ? '#059669' : ($answer->is_correct === false ? '#dc2626' : '#d97706') }};">
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
                    <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--text-tertiary, #9ca3af);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <h3 class="text-lg font-medium mb-2" style="color: var(--text-primary, #111827);">Belum ada jawaban</h3>
                    <p style="color: var(--text-secondary, #6b7280);">Siswa belum menjawab soal apapun</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection