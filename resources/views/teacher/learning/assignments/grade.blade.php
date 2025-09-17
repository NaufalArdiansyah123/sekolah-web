@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        📝 Penilaian Tugas
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
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
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Pengumpulan Siswa</h2>
                            @if($submission->submitted_at > $assignment->due_date)
                                <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Terlambat
                                </span>
                            @else
                                <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Tepat Waktu
                                </span>
                            @endif
                        </div>
                        
                        <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Dikumpulkan pada:</span>
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $submission->submitted_at->format('d M Y, H:i') }}
                                </div>
                            </div>
                            <div>
                                <span class="text-gray-600 dark:text-gray-400">Deadline:</span>
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $assignment->due_date->format('d M Y, H:i') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Jawaban Siswa</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 mb-6">
                            <div class="prose dark:prose-invert max-w-none">
                                {!! nl2br(e($submission->content)) !!}
                            </div>
                        </div>
                        
                        @if($submission->file_path)
                            <div>
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">File yang Dikumpulkan</h4>
                                <div class="flex items-center space-x-4">
                                    <a href="{{ Storage::url($submission->file_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-lg transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        {{ $submission->file_name }}
                                    </a>
                                    <a href="{{ Storage::url($submission->file_path) }}" 
                                       download
                                       class="inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 dark:bg-green-900 dark:hover:bg-green-800 text-green-700 dark:text-green-300 rounded-lg transition-colors">
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
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ $submission->graded_at ? 'Edit Penilaian' : 'Beri Penilaian' }}
                        </h2>
                    </div>
                    
                    <form action="{{ route('teacher.assignments.grade.store', [$assignment->id, $submission->id]) }}" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="max_score" value="{{ $assignment->max_score }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
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
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white pr-16"
                                           placeholder="0"
                                           required>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <span class="text-gray-500 dark:text-gray-400">/ {{ $assignment->max_score }}</span>
                                    </div>
                                </div>
                                @error('score')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                
                                <!-- Score Percentage Display -->
                                <div class="mt-2">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-gray-600 dark:text-gray-400">Persentase:</span>
                                        <span id="scorePercentage" class="font-medium text-gray-900 dark:text-white">0%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-1">
                                        <div id="scoreBar" class="bg-blue-600 h-2 rounded-full transition-all duration-300" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Grade
                                </label>
                                <div id="gradeDisplay" class="text-3xl font-bold text-gray-400 dark:text-gray-500">
                                    -
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    A: 90-100, B: 80-89, C: 70-79, D: 60-69, E: <60
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label for="feedback" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Feedback untuk Siswa
                            </label>
                            <textarea name="feedback" 
                                      id="feedback" 
                                      rows="4" 
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                      placeholder="Berikan feedback konstruktif untuk siswa...">{{ old('feedback', $submission->feedback) }}</textarea>
                            @error('feedback')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
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
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Siswa</h3>
                    
                    <div class="flex items-center mb-4">
                        <img class="h-12 w-12 rounded-full" 
                             src="{{ $submission->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($submission->student->name).'&color=7C3AED&background=EDE9FE' }}" 
                             alt="{{ $submission->student->name }}">
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $submission->student->name }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $submission->student->email }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">NIS:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $submission->student->student_id ?? 'N/A' }}</div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Kelas:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $submission->student->class ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Assignment Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tugas</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Mata Pelajaran:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->subject }}</div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Tipe:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ ucfirst($assignment->type) }}</div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Nilai Maksimal:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->max_score }} poin</div>
                        </div>
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Deadline:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->due_date->format('d M Y, H:i') }}</div>
                        </div>
                        
                        @if($submission->graded_at)
                            <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Dinilai pada:</span>
                                <div class="font-medium text-gray-900 dark:text-white">{{ $submission->graded_at->format('d M Y, H:i') }}</div>
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
        let gradeColor = 'text-red-600 dark:text-red-400';
        
        if (percentage >= 90) {
            grade = 'A';
            gradeColor = 'text-green-600 dark:text-green-400';
        } else if (percentage >= 80) {
            grade = 'B';
            gradeColor = 'text-blue-600 dark:text-blue-400';
        } else if (percentage >= 70) {
            grade = 'C';
            gradeColor = 'text-yellow-600 dark:text-yellow-400';
        } else if (percentage >= 60) {
            grade = 'D';
            gradeColor = 'text-orange-600 dark:text-orange-400';
        }
        
        gradeDisplay.textContent = grade;
        gradeDisplay.className = `text-3xl font-bold ${gradeColor}`;
        
        // Update progress bar color
        if (percentage >= 80) {
            scoreBar.className = 'bg-green-600 h-2 rounded-full transition-all duration-300';
        } else if (percentage >= 60) {
            scoreBar.className = 'bg-yellow-600 h-2 rounded-full transition-all duration-300';
        } else {
            scoreBar.className = 'bg-red-600 h-2 rounded-full transition-all duration-300';
        }
    }
    
    scoreInput.addEventListener('input', updateScoreDisplay);
    
    // Initialize display
    updateScoreDisplay();
});
</script>
@endsection