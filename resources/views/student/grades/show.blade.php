@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Nilai</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">{{ $grade->subject }} • {{ $grade->assessment_name }}</p>
            </div>
            <a href="{{ route('student.grades.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Nilai
            </a>
        </div>
    </div>

    <!-- Grade Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Grade Info -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Nilai</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Mata Pelajaran</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->subject }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Penilaian</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                @if($grade->type === 'assignment') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                @elseif($grade->type === 'quiz') bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                @elseif($grade->type === 'exam') bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 @endif">
                                @if($grade->type === 'assignment') Tugas
                                @elseif($grade->type === 'quiz') Kuis
                                @elseif($grade->type === 'exam') Ujian
                                @else {{ ucfirst($grade->type) }} @endif
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Tugas/Kuis</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->assessment_name }}</p>
                    </div>
                    
                    @if($grade->teacher)
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Guru</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->teacher->name }}</p>
                        </div>
                    @endif
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Penilaian</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Semester</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">Semester {{ $grade->semester }} - {{ $grade->year }}</p>
                    </div>
                </div>
                
                @if($grade->notes)
                    <div class="mt-6">
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Catatan Guru</label>
                        <div class="mt-2 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <p class="text-gray-900 dark:text-white">{{ $grade->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Score Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nilai</h3>
            </div>
            <div class="p-6">
                <div class="text-center">
                    <!-- Score Display -->
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ $grade->score }}
                            @if($grade->max_score)
                                <span class="text-2xl text-gray-500 dark:text-gray-400">/ {{ $grade->max_score }}</span>
                            @endif
                        </div>
                        @if($grade->max_score)
                            <div class="text-lg text-gray-600 dark:text-gray-400">{{ $grade->percentage }}%</div>
                        @endif
                    </div>
                    
                    <!-- Grade Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold 
                            @if($grade->grade_color === 'green') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            @elseif($grade->grade_color === 'blue') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            @elseif($grade->grade_color === 'yellow') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            @elseif($grade->grade_color === 'orange') bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                            @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 @endif">
                            Grade {{ $grade->letter_grade }}
                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    @if($grade->max_score)
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span>Progress</span>
                                <span>{{ $grade->percentage }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                                <div class="h-3 rounded-full 
                                    @if($grade->grade_color === 'green') bg-green-600
                                    @elseif($grade->grade_color === 'blue') bg-blue-600
                                    @elseif($grade->grade_color === 'yellow') bg-yellow-600
                                    @elseif($grade->grade_color === 'orange') bg-orange-600
                                    @else bg-red-600 @endif" 
                                    style="width: {{ $grade->percentage }}%"></div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Performance Indicator -->
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        @if($grade->percentage >= 90)
                            <span class="text-green-600 dark:text-green-400 font-medium">Sangat Baik</span>
                        @elseif($grade->percentage >= 80)
                            <span class="text-blue-600 dark:text-blue-400 font-medium">Baik</span>
                        @elseif($grade->percentage >= 70)
                            <span class="text-yellow-600 dark:text-yellow-400 font-medium">Cukup</span>
                        @elseif($grade->percentage >= 60)
                            <span class="text-orange-600 dark:text-orange-400 font-medium">Kurang</span>
                        @else
                            <span class="text-red-600 dark:text-red-400 font-medium">Perlu Perbaikan</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Assignment/Quiz Info -->
    @if($grade->assignment || $grade->quiz)
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    @if($grade->assignment) Informasi Tugas @else Informasi Kuis @endif
                </h3>
            </div>
            <div class="p-6">
                @if($grade->assignment)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Judul Tugas</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->assignment->title }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deadline</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $grade->assignment->due_date ? $grade->assignment->due_date->format('d M Y, H:i') : 'Tidak ada deadline' }}
                            </p>
                        </div>
                        
                        @if($grade->assignment->description)
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi Tugas</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ $grade->assignment->description }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="md:col-span-2">
                            <a href="{{ route('student.assignments.show', $grade->assignment->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail Tugas
                            </a>
                        </div>
                    </div>
                @elseif($grade->quiz)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Judul Kuis</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->quiz->title }}</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Durasi</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->quiz->duration_minutes }} menit</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah Soal</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $grade->quiz->questions->count() }} soal</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Kuis</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $grade->quiz->start_time->format('d M Y, H:i') }} - {{ $grade->quiz->end_time->format('d M Y, H:i') }}
                            </p>
                        </div>
                        
                        @if($grade->quiz->description)
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi Kuis</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white">{{ $grade->quiz->description }}</p>
                                </div>
                            </div>
                        @endif
                        
                        <div class="md:col-span-2">
                            <a href="{{ route('student.quizzes.show', $grade->quiz->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail Kuis
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi Lainnya</h3>
                <p class="text-gray-600 dark:text-gray-400">Lihat nilai lainnya atau rapor lengkap</p>
            </div>
            
            <div class="flex space-x-3">
                <a href="{{ route('student.grades.subject', $grade->subject) }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Nilai {{ $grade->subject }}
                </a>
                
                <a href="{{ route('student.grades.report') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Rapor
                </a>
            </div>
        </div>
    </div>
</div>
@endsection