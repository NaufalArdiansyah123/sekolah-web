@extends('layouts.teacher')

@section('title', $pageTitle)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="rounded-xl p-6 text-white shadow-lg" style="background: linear-gradient(135deg, #2563eb, #4f46e5);">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Kelola Kuis 📝</h1>
                <p class="text-blue-100">Buat dan kelola kuis untuk siswa Anda</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(59, 130, 246, 0.1);">
                    <svg class="w-6 h-6" style="color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Kuis</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $stats['total_quizzes'] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(16, 185, 129, 0.1);">
                    <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Dipublikasi</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $stats['published'] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(245, 158, 11, 0.1);">
                    <svg class="w-6 h-6" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Draft</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $stats['draft'] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(139, 92, 246, 0.1);">
                    <svg class="w-6 h-6" style="color: #7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Percobaan</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $stats['total_attempts'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions and Filters -->
    <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <!-- Subject Filter -->
                <form method="GET" class="flex space-x-2">
                    <select name="subject" class="rounded-lg border px-3 py-2" style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);" onchange="this.form.submit()">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $currentFilters['subject'] == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                    
                    <select name="status" class="rounded-lg border px-3 py-2" style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);" onchange="this.form.submit()">
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
    <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        @if($quizzes->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y" style="border-color: var(--border-color, #e5e7eb);">
                    <thead style="background: var(--bg-tertiary, #f9fafb);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Kuis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Mata Pelajaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Kelas
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Waktu
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Soal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                        @foreach($quizzes as $quiz)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                                            {{ $quiz->title }}
                                        </div>
                                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                            {{ Str::limit($quiz->description, 50) }}
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(59, 130, 246, 0.1); color: #2563eb;">
                                        {{ $quiz->subject }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($quiz->class)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(139, 92, 246, 0.1); color: #7c3aed;">
                                            {{ $quiz->class->level }} {{ $quiz->class->name }}
                                        </span>
                                    @else
                                        <span class="text-xs" style="color: var(--text-tertiary, #9ca3af);">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-primary, #111827);">
                                    <div>{{ $quiz->start_time->format('d/m/Y H:i') }}</div>
                                    <div class="text-xs" style="color: var(--text-secondary, #6b7280);">s/d {{ $quiz->end_time->format('d/m/Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusBg = $quiz->status === 'published' ? 'rgba(16, 185, 129, 0.1)' : 'rgba(245, 158, 11, 0.1)';
                                        $statusText = $quiz->status === 'published' ? '#059669' : '#d97706';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: {{ $statusBg }}; color: {{ $statusText }};">
                                        {{ $quiz->status === 'published' ? 'Dipublikasi' : 'Draft' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-primary, #111827);">
                                    {{ $quiz->questions->count() }} soal
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" 
                                       style="color: #2563eb;"
                                       onmouseover="this.style.color='#1d4ed8'"
                                       onmouseout="this.style.color='#2563eb'">
                                        Lihat
                                    </a>
                                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" 
                                       style="color: #4f46e5;"
                                       onmouseover="this.style.color='#4338ca'"
                                       onmouseout="this.style.color='#4f46e5'">
                                        Edit
                                    </a>
                                    @if($quiz->status === 'draft')
                                        <form method="POST" action="{{ route('teacher.quizzes.publish', $quiz->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="color: #059669;"
                                                    onmouseover="this.style.color='#047857'"
                                                    onmouseout="this.style.color='#059669'">
                                                Publikasi
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('teacher.quizzes.unpublish', $quiz->id) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" style="color: #d97706;"
                                                    onmouseover="this.style.color='#b45309'"
                                                    onmouseout="this.style.color='#d97706'">
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
            <div class="px-6 py-4 border-t" style="border-color: var(--border-color, #e5e7eb);">
                {{ $quizzes->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-12 h-12 mx-auto mb-4" style="color: var(--text-tertiary, #9ca3af);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <h3 class="text-lg font-medium mb-2" style="color: var(--text-primary, #111827);">Belum ada kuis</h3>
                <p class="mb-4" style="color: var(--text-secondary, #6b7280);">Mulai dengan membuat kuis pertama Anda</p>
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