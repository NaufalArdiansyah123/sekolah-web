@extends('layouts.student')

@push('scripts')
<script src="{{ asset('js/assignment-realtime.js') }}"></script>
@endpush

@section('content')
<div class="student-page">
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('student.assignments.index') }}" 
               class="inline-flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Tugas
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Assignment Details -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between mb-4">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $assignment->title }}
                            </h1>
                            @if($submission ?? false)
                                <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Sudah Dikumpulkan
                                </span>
                            @elseif($assignment->due_date < now())
                                <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Terlambat
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Belum Dikumpulkan
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $assignment->subject }}
                            </div>
                            
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $assignment->teacher->name ?? 'Unknown Teacher' }}
                            </div>
                            
                            <div class="flex items-center {{ $assignment->due_date < now() ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $assignment->due_date->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deskripsi Tugas</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($assignment->description)) !!}
                        </div>
                        
                        @if($assignment->instructions)
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Instruksi</h4>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="prose dark:prose-invert max-w-none text-sm">
                                        {!! nl2br(e($assignment->instructions)) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($assignment->attachment_path)
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">File Lampiran</h4>
                                <a href="{{ Storage::url($assignment->attachment_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $assignment->attachment_name ?? 'Download File' }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submission Section -->
                @if($submission ?? false)
                    <!-- Show Submission -->
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengumpulan Anda</h3>
                                @if($submission->graded_at)
                                    <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                        ✅ Sudah Dinilai
                                    </span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-3 py-1 rounded-full text-sm font-medium">
                                        ⏳ Sedang Diperiksa
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Progress Bar for Grading Status -->
                            @if(!$submission->graded_at)
                                <div class="mb-6">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Status Penilaian</span>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Sedang dalam proses...</span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-yellow-500 h-2 rounded-full animate-pulse" style="width: 60%"></div>
                                    </div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                        Guru sedang memeriksa tugas Anda. Nilai akan muncul setelah selesai diperiksa.
                                    </p>
                                </div>
                            @endif
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Dikumpulkan pada:</span>
                                    <div class="font-medium text-gray-900 dark:text-white">
                                        {{ $submission->submitted_at->format('d M Y, H:i') }}
                                    </div>
                                </div>
                                
                                @if($submission->graded_at)
                                    <div>
                                        <span class="text-sm text-gray-600 dark:text-gray-400">Dinilai pada:</span>
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $submission->graded_at->format('d M Y, H:i') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            @if($submission->score !== null)
                                <!-- Score Display -->
                                <div class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Nilai Anda</span>
                                        @php
                                            $percentage = round(($submission->score / $assignment->max_score) * 100, 1);
                                            $grade = $percentage >= 90 ? 'A' : ($percentage >= 80 ? 'B' : ($percentage >= 70 ? 'C' : ($percentage >= 60 ? 'D' : 'E')));
                                            $gradeColor = $percentage >= 80 ? 'text-green-600 dark:text-green-400' : ($percentage >= 60 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400');
                                        @endphp
                                        <span class="text-2xl font-bold {{ $gradeColor }}">{{ $grade }}</span>
                                    </div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ $submission->score }}/{{ $assignment->max_score }}
                                        </span>
                                        <span class="text-lg font-semibold {{ $gradeColor }}">
                                            {{ $percentage }}%
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                        <div class="{{ $percentage >= 80 ? 'bg-green-500' : ($percentage >= 60 ? 'bg-yellow-500' : 'bg-red-500') }} h-3 rounded-full transition-all duration-500" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="mb-4">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Jawaban:</span>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    {!! nl2br(e($submission->content)) !!}
                                </div>
                            </div>
                            
                            @if($submission->file_path ?? false)
                                <div class="mb-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">File yang dikumpulkan:</span>
                                    <div class="mt-2">
                                        <a href="{{ Storage::url($submission->file_path) }}" 
                                           target="_blank"
                                           class="inline-flex items-center px-4 py-2 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-700 dark:text-blue-300 rounded-lg transition-colors">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            {{ $submission->file_name ?? 'Download File' }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            @if($submission->feedback ?? false)
                                <div>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Feedback dari Guru:</span>
                                    <div class="mt-2 p-4 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                        {!! nl2br(e($submission->feedback)) !!}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($assignment->due_date >= now())
                    <!-- Submit Form -->
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kumpulkan Tugas</h3>
                        </div>
                        
                        <form action="{{ route('student.assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf
                            
                            <div class="mb-6">
                                <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Jawaban/Deskripsi <span class="text-red-500">*</span>
                                </label>
                                <textarea name="content" id="content" rows="6" required
                                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                          placeholder="Tulis jawaban atau deskripsi tugas Anda di sini...">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="mb-6">
                                <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    File Lampiran (Opsional)
                                </label>
                                <input type="file" name="file" id="file" 
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                       accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Format yang didukung: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG. Maksimal 10MB.
                                </p>
                                @error('file')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex justify-end">
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    Kumpulkan Tugas
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <!-- Overdue Message -->
                    <div class="mt-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Waktu Pengumpulan Berakhir</h3>
                                <p class="text-red-600 dark:text-red-400">Batas waktu pengumpulan tugas ini sudah terlewat.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Assignment Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tugas</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Nilai Maksimal:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->max_score }} poin</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Status:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ ucfirst($assignment->status) }}</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Dibuat pada:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->created_at->format('d M Y') }}</div>
                        </div>
                        
                        @if($assignment->due_date < now())
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="text-sm text-red-800 dark:text-red-200 font-medium">
                                    Terlambat {{ $assignment->due_date->diffForHumans() }}
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="text-sm text-blue-800 dark:text-blue-200 font-medium">
                                    Deadline {{ $assignment->due_date->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection