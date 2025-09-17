{{-- resources/views/student/materials/show.blade.php --}}
@extends('layouts.student')

@section('title', $pageTitle)

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('student.materials.index') }}" 
           class="flex items-center text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Daftar Materi
        </a>
    </div>

    <!-- Material Detail Card -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-8">
            <!-- Header Section -->
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between mb-8">
                <div class="flex-1">
                    <!-- Type and Status -->
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="text-4xl">{{ $material->type_icon }}</div>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 text-sm font-medium rounded-full 
                                {{ $material->type == 'document' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : '' }}
                                {{ $material->type == 'video' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}
                                {{ $material->type == 'presentation' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : '' }}
                                {{ $material->type == 'exercise' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                {{ $material->type == 'audio' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : '' }}">
                                {{ ucfirst($material->type) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 rounded-full">
                                Published
                            </span>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                        {{ $material->title }}
                    </h1>

                    <!-- Subject and Class -->
                    <div class="flex flex-wrap items-center gap-3 mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            <span class="text-lg font-medium text-emerald-600 dark:text-emerald-400">{{ $material->subject }}</span>
                        </div>
                        <span class="text-gray-400">•</span>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-gray-600 dark:text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <span class="text-lg font-medium text-gray-600 dark:text-gray-400">Kelas {{ $material->class }}</span>
                        </div>
                    </div>

                    <!-- Teacher Info -->
                    <div class="flex items-center mb-6">
                        <img class="w-12 h-12 rounded-full mr-4" 
                             src="{{ $material->teacher->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($material->teacher->name ?? 'Teacher').'&color=10B981&background=D1FAE5' }}" 
                             alt="{{ $material->teacher->name ?? 'Teacher' }}">
                        <div>
                            <p class="text-lg font-medium text-gray-900 dark:text-white">{{ $material->teacher->name ?? 'Unknown Teacher' }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Guru Mata Pelajaran {{ $material->subject }}</p>
                        </div>
                    </div>
                </div>

                <!-- Download Section -->
                <div class="lg:ml-8 mt-6 lg:mt-0">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-xl p-6 text-center">
                        <div class="text-emerald-600 dark:text-emerald-400 mb-4">
                            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Download Materi</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            File: {{ $material->original_name ?? $material->file_name }}<br>
                            Ukuran: {{ $material->formatted_file_size }}
                        </p>
                        <a href="{{ route('student.materials.download', $material->id) }}" 
                           class="inline-flex items-center bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Download Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Description -->
            @if($material->description)
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Deskripsi Materi</h2>
                    <div class="prose prose-emerald dark:prose-invert max-w-none">
                        <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $material->description }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Material Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $material->downloads }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Download</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $material->formatted_file_size }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Ukuran File</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $material->created_at->format('d M Y') }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Tanggal Upload</div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ ucfirst($material->type) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Jenis Materi</div>
                </div>
            </div>
        </div>
    </div>



    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('student.materials.download', $material->id) }}" 
           class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white text-center py-3 px-6 rounded-lg font-medium transition-colors duration-200">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Download Materi
        </a>
        <a href="{{ route('student.materials.index', ['subject' => $material->subject]) }}" 
           class="flex-1 bg-gray-600 hover:bg-gray-700 text-white text-center py-3 px-6 rounded-lg font-medium transition-colors duration-200">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
            Lihat Materi {{ $material->subject }} Lainnya
        </a>
        <a href="{{ route('student.materials.index') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-6 rounded-lg font-medium transition-colors duration-200">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
            </svg>
            Semua Materi
        </a>
    </div>
</div>

@push('scripts')
<script>
// Track download clicks for analytics
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('a[href*="/download"]');
    
    downloadButtons.forEach(button => {
        button.addEventListener('click', function() {
            // You can add analytics tracking here
            console.log('Material download initiated:', '{{ $material->title }}');
        });
    });
});
</script>
@endpush
@endsection