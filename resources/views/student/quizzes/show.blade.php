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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Quiz Details -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        @php
                            $attempt = $quiz->attempts->first();
                            $now = now();
                            $isActive = $quiz->start_time <= $now && $quiz->end_time >= $now;
                            $isUpcoming = $quiz->start_time > $now;
                            $isEnded = $quiz->end_time < $now;
                        @endphp
                        
                        @if(config('app.debug'))
                            <!-- Debug Info (only shown in debug mode) -->
                            <div class="mb-4 p-3 bg-yellow-50 border border-yellow-200 rounded text-xs">
                                <strong>Debug Info:</strong><br>
                                Current Time: {{ $now }}<br>
                                Start Time: {{ $quiz->start_time }}<br>
                                End Time: {{ $quiz->end_time }}<br>
                                Is Active: {{ $isActive ? 'YES' : 'NO' }}<br>
                                Is Upcoming: {{ $isUpcoming ? 'YES' : 'NO' }}<br>
                                Is Ended: {{ $isEnded ? 'YES' : 'NO' }}<br>
                                Start <= Now: {{ $quiz->start_time <= $now ? 'TRUE' : 'FALSE' }}<br>
                                End >= Now: {{ $quiz->end_time >= $now ? 'TRUE' : 'FALSE' }}
                            </div>
                        @endif
                        
                        <div class="flex items-start justify-between mb-4">
                            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                                {{ $quiz->title }}
                            </h1>
                            @if($attempt && $attempt->status === 'completed')
                                <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Sudah Selesai
                                </span>
                            @elseif($isActive)
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Aktif
                                </span>
                            @elseif($isUpcoming)
                                <span class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Akan Datang
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 px-3 py-1 rounded-full text-sm font-medium">
                                    Berakhir
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $quiz->subject }}
                            </div>
                            
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $quiz->teacher->name ?? 'Unknown Teacher' }}
                            </div>
                            
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $quiz->duration_minutes }} menit
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deskripsi Kuis</h3>
                        <div class="prose dark:prose-invert max-w-none">
                            {!! nl2br(e($quiz->description)) !!}
                        </div>
                        
                        @if($quiz->instructions)
                            <div class="mt-6">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Instruksi</h4>
                                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                                    <div class="prose dark:prose-invert max-w-none text-sm">
                                        {!! nl2br(e($quiz->instructions)) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Action Section -->
                @if($attempt && $attempt->status === 'completed')
                    <!-- Show Result -->
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Hasil Kuis Anda</h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">{{ $attempt->score ?? 0 }}%</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Nilai Anda</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $attempt->duration ?? 0 }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Menit</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $attempt->grade_letter ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">Grade</div>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <a href="{{ route('student.quizzes.result', $attempt->id) }}" 
                                   class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    Lihat Detail Hasil
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif($attempt && $attempt->status === 'in_progress')
                    <!-- Continue Quiz -->
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Lanjutkan Kuis</h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-blue-800 dark:text-blue-200 font-medium">
                                        Anda memiliki kuis yang sedang berlangsung
                                    </span>
                                </div>
                            </div>
                            
                            <div class="text-center">
                                <a href="{{ route('student.quizzes.take', $attempt->id) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    Lanjutkan Kuis
                                </a>
                            </div>
                        </div>
                    </div>
                @elseif($isActive)
                    <!-- Start Quiz -->
                    <div class="mt-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mulai Kuis</h3>
                        </div>
                        
                        <div class="p-6">
                            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-green-800 dark:text-green-200 font-medium">
                                        Kuis sedang aktif dan dapat dimulai
                                    </span>
                                </div>
                            </div>
                            
                            <form action="{{ route('student.quizzes.start', $quiz->id) }}" method="POST" class="text-center">
                                @csrf
                                <button type="submit" 
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                                    Mulai Kuis Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                @elseif($isUpcoming)
                    <!-- Upcoming Quiz -->
                    <div class="mt-8 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-xl p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-orange-800 dark:text-orange-200">Kuis Belum Dimulai</h3>
                                <p class="text-orange-600 dark:text-orange-400">Kuis akan dimulai pada {{ $quiz->start_time->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Ended Quiz -->
                    <div class="mt-8 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Kuis Sudah Berakhir</h3>
                                <p class="text-red-600 dark:text-red-400">Waktu kuis sudah berakhir pada {{ $quiz->end_time->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Quiz Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Kuis</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Jumlah Soal:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $quiz->questions->count() }} soal</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Durasi:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $quiz->duration_minutes }} menit</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Maksimal Percobaan:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $quiz->max_attempts }} kali</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Waktu Mulai:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $quiz->start_time->format('d M Y, H:i') }}</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Waktu Berakhir:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $quiz->end_time->format('d M Y, H:i') }}</div>
                        </div>
                        
                        @if($isActive)
                            <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                <div class="text-sm text-green-800 dark:text-green-200 font-medium">
                                    Kuis sedang aktif
                                </div>
                            </div>
                        @elseif($isUpcoming)
                            <div class="p-3 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-800 rounded-lg">
                                <div class="text-sm text-orange-800 dark:text-orange-200 font-medium">
                                    Dimulai {{ $quiz->start_time->diffForHumans() }}
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="text-sm text-red-800 dark:text-red-200 font-medium">
                                    Berakhir {{ $quiz->end_time->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection