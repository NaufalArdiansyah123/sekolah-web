@extends('layouts.teacher')

@section('content')
<div class="min-h-screen" style="background: var(--bg-primary, #ffffff);">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary, #111827);">
                        📝 Penilaian Tugas
                    </h1>
                    <p style="color: var(--text-secondary, #6b7280);">
                        {{ $assignment->title }} • {{ $submission->student->name }}
                    </p>
                </div>
                
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Kembali ke Pengumpulan
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Student Submission -->
                <div class="rounded-xl shadow-sm border overflow-hidden mb-8" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                    <!-- Header -->
                    <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold" style="color: var(--text-primary, #111827);">Pengumpulan Siswa</h2>
                            @if($submission->submitted_at > $assignment->due_date)
                                <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: rgba(239, 68, 68, 0.1); color: #dc2626;">
                                    Terlambat
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                    Tepat Waktu
                                </span>
                            @endif
                        </div>
                        
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span style="color: var(--text-secondary, #6b7280);">Dikumpulkan pada:</span>
                                <div class="font-medium" style="color: var(--text-primary, #111827);">
                                    {{ $submission->submitted_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div>
                                <span style="color: var(--text-secondary, #6b7280);">Deadline:</span>
                                <div class="font-medium" style="color: var(--text-primary, #111827);">
                                    {{ $assignment->due_date->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary, #111827);">Jawaban Siswa</h3>
                        <div class="rounded-lg p-4 mb-6" style="background: var(--bg-tertiary, #f9fafb);">
                            <div class="prose max-w-none" style="color: var(--text-primary, #111827);">
                                {!! nl2br(e($submission->content)) !!}
                            </div>
                        </div>
                        
                        @if($submission->file_path)
                            <div>
                                <h4 class="text-md font-semibold mb-3" style="color: var(--text-primary, #111827);">File yang Dikumpulkan</h4>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ Storage::url($submission->file_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 rounded-lg transition-colors" 
                                       style="background: rgba(59, 130, 246, 0.1); color: #2563eb;"
                                       onmouseover="this.style.background='rgba(59, 130, 246, 0.2)'"
                                       onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ $submission->file_name }}
                                    </a>
                                    <a href="{{ Storage::url($submission->file_path) }}" 
                                       download
                                       class="inline-flex items-center px-4 py-2 rounded-lg transition-colors" 
                                       style="background: rgba(16, 185, 129, 0.1); color: #059669;"
                                       onmouseover="this.style.background='rgba(16, 185, 129, 0.2)'"
                                       onmouseout="this.style.background='rgba(16, 185, 129, 0.1)'">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Grading Form -->
                <div class="rounded-xl shadow-sm border overflow-hidden" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                    <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                        <h2 class="text-xl font-semibold" style="color: var(--text-primary, #111827);">
                            {{ $submission->graded_at ? 'Edit Penilaian' : 'Beri Penilaian' }}
                        </h2>
                    </div>
                    
                    <form action="{{ route('teacher.assignments.grade.store', [$assignment->id, $submission->id]) }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="max_score" value="{{ $assignment->max_score }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="score" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                    Nilai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="score" 
                                           id="score" 
                                           min="0" 
                                           max="{{ $assignment->max_score }}" 
                                           step="0.1"
                                           value="{{ old('score', $submission->score) }}"
                                           class="w-full rounded-lg border pr-16 px-3 py-2" 
                                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                           placeholder="0"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span style="color: var(--text-secondary, #6b7280);">/ {{ $assignment->max_score }}</span>
                                    </div>
                                </div>
                                @error('score')
                                    <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                                @enderror
                                
                                <!-- Score Percentage Display -->
                                <div class="mt-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span style="color: var(--text-secondary, #6b7280);">Persentase:</span>
                                        <span id="scorePercentage" class="font-medium" style="color: var(--text-primary, #111827);">0%</span>
                                    </div>
                                    <div class="w-full rounded-full h-2 mt-1" style="background: var(--bg-tertiary, #e5e7eb);">
                                        <div id="scoreBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                    Grade
                                </label>
                                <div id="gradeDisplay" class="text-3xl font-bold" style="color: var(--text-tertiary, #9ca3af);">
                                    -
                                </div>
                                <div class="text-sm mt-1" style="color: var(--text-secondary, #6b7280);">
                                    A: 90-100, B: 80-89, C: 70-79, D: 60-69, E: <60
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="feedback" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Feedback untuk Siswa
                            </label>
                            <textarea name="feedback" 
                                      id="feedback" 
                                      rows="4" 
                                      class="w-full rounded-lg border px-3 py-2" 
                                      style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                      placeholder="Berikan feedback konstruktif untuk siswa...">{{ old('feedback', $submission->feedback) }}</textarea>
                            @error('feedback')
                                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                {{ $submission->graded_at ? 'Update Nilai' : 'Simpan Nilai' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Student Info -->
                <div class="rounded-xl shadow-sm border p-6 mb-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                    <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary, #111827);">Informasi Siswa</h3>
                    
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" 
                             src="{{ $submission->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($submission->student->name).'&color=7C3AED&background=EDE9FE' }}" 
                             alt="{{ $submission->student->name }}">
                        <div class="ml-4">
                            <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                                {{ $submission->student->name }}
                            </div>
                            <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                {{ $submission->student->email }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm" style="color: var(--text-secondary, #6b7280);">NIS:</span>
                            <div class="font-medium" style="color: var(--text-primary, #111827);">{{ $submission->student->student_id ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Kelas:</span>
                            <div class="font-medium" style="color: var(--text-primary, #111827);">{{ $submission->student->class ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Assignment Info -->
                <div class="rounded-xl shadow-sm border p-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                    <h3 class="text-lg font-semibold mb-4" style="color: var(--text-primary, #111827);">Informasi Tugas</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Mata Pelajaran:</span>
                            <div class="font-medium" style="color: var(--text-primary, #111827);">{{ $assignment->subject }}</div>
                        </div>
                        <div>
                            <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Tipe:</span>
                            <div class="font-medium" style="color: var(--text-primary, #111827);">{{ ucfirst($assignment->type) }}</div>
                        </div>
                        <div>
                            <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Nilai Maksimal:</span>
                            <div class="font-medium" style="color: var(--text-primary, #111827);">{{ $assignment->max_score }} poin</div>
                        </div>
                        <div>
                            <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Deadline:</span>
                            <div class="font-medium" style="color: var(--text-primary, #111827);">{{ $assignment->due_date->format('d M Y, H:i') }}</div>
                        </div>
                        
                        @if($submission->graded_at)
                            <div class="pt-3 border-t" style="border-color: var(--border-color, #e5e7eb);">
                                <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Dinilai pada:</span>
                                <div class="font-medium" style="color: var(--text-primary, #111827);">{{ $submission->graded_at->format('d M Y, H:i') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scoreInput = document.getElementById('score');
    const scorePercentage = document.getElementById('scorePercentage');
    const scoreBar = document.getElementById('scoreBar');
    const gradeDisplay = document.getElementById('gradeDisplay');
    const maxScore = {{ $assignment->max_score }};
    
    function updateScoreDisplay() {
        const score = parseFloat(scoreInput.value) || 0;
        const percentage = Math.round((score / maxScore) * 100);
        
        scorePercentage.textContent = percentage + '%';
        scoreBar.style.width = percentage + '%';
        
        // Update grade
        let grade = 'E';
        let gradeColor = '#dc2626';
        
        if (percentage >= 90) {
            grade = 'A';
            gradeColor = '#059669';
        } else if (percentage >= 80) {
            grade = 'B';
            gradeColor = '#2563eb';
        } else if (percentage >= 70) {
            grade = 'C';
            gradeColor = '#d97706';
        } else if (percentage >= 60) {
            grade = 'D';
            gradeColor = '#ea580c';
        }
        
        gradeDisplay.textContent = grade;
        gradeDisplay.style.color = gradeColor;
        
        // Update progress bar color
        if (percentage >= 80) {
            scoreBar.style.backgroundColor = '#059669';
        } else if (percentage >= 60) {
            scoreBar.style.backgroundColor = '#d97706';
        } else {
            scoreBar.style.backgroundColor = '#dc2626';
        }
    }
    
    scoreInput.addEventListener('input', updateScoreDisplay);
    
    // Initialize display
    updateScoreDisplay();
});
</script>
@endsection