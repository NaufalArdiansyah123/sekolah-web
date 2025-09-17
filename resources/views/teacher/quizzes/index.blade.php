@extends('layouts.teacher')

@section('title', $pageTitle)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Kelola Kuis & Ujian 📝</h1>
                <p class="text-blue-100 dark:text-blue-200">Buat dan kelola kuis untuk siswa Anda</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-blue-200 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Kuis</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_quizzes'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dipublikasi</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['published'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/50">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Draft</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['draft'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Percobaan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_attempts'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions and Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <!-- Subject Filter -->
                <form method="GET" class="flex space-x-2">
                    <select name="subject" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $currentFilters['subject'] == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="status" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="published" {{ $currentFilters['status'] == 'published' ? 'selected' : '' }}>Dipublikasi</option>
                        <option value="draft" {{ $currentFilters['status'] == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </form>
            </div>

            <a href="{{ route('teacher.quizzes.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Buat Kuis Baru
            </a>
        </div>
    </div>

    <!-- Quizzes List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        @if($quizzes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Kuis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Mata Pelajaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Soal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($quizzes as $quiz)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $quiz->title }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ Str::limit($quiz->description, 50) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        {{ $quiz->subject }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <div>{{ $quiz->start_time->format('d/m/Y H:i') }}</div>
                                    <div class="text-xs text-gray-500">s/d {{ $quiz->end_time->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @if($quiz->status === 'published') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @else bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 @endif">
                                        {{ $quiz->status === 'published' ? 'Dipublikasi' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    {{ $quiz->questions->count() }} soal
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Lihat
                                    </a>
                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" 
                                       class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                                        Edit
                                    </a>
                                    @if($quiz->status === 'draft')
                                        <form method="POST" action="{{ route('teacher.quizzes.publish', $quiz->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                                Publikasi
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('teacher.quizzes.unpublish', $quiz->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300">
                                                Unpublish
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $quizzes->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada kuis</h3>
                <p class="text-gray-500 dark:text-gray-400 mb-4">Mulai dengan membuat kuis pertama Anda</p>
                <a href="{{ route('teacher.quizzes.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Buat Kuis Baru
                </a>
            </div>
        @endif
    </div>
</div>
@endsection