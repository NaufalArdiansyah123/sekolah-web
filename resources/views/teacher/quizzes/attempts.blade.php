@extends('layouts.teacher')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="rounded-xl shadow-sm border p-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary, #111827);">Hasil Kuis: {{ $quiz->title }}</h1>
                <p class="mt-1" style="color: var(--text-secondary, #6b7280);">{{ $quiz->subject }} • {{ $quiz->questions->count() }} soal</p>
            </div>
            <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Detail Kuis
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(59, 130, 246, 0.1);">
                    <svg class="w-6 h-6" style="color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Percobaan</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $attempts->total() }}</p>
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
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Selesai</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $attempts->where('status', 'completed')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(245, 158, 11, 0.1);">
                    <svg class="w-6 h-6" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Sedang Berlangsung</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $attempts->where('status', 'in_progress')->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(139, 92, 246, 0.1);">
                    <svg class="w-6 h-6" style="color: #7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Rata-rata Nilai</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">
                        {{ $attempts->where('status', 'completed')->avg('score') ? number_format($attempts->where('status', 'completed')->avg('score'), 1) : '0' }}%
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Attempts List -->
    <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
            <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Daftar Percobaan</h3>
        </div>
        
        @if($attempts->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead style="background: var(--bg-tertiary, #f9fafb);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Nilai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Waktu Mulai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Waktu Selesai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Durasi
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                        @foreach($attempts as $attempt)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" 
                                                 src="{{ $attempt->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($attempt->student->name).'&color=059669&background=D1FAE5' }}" 
                                                 alt="{{ $attempt->student->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                                                {{ $attempt->student->name }}
                                            </div>
                                            <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                                {{ $attempt->student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attempt->status === 'completed')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Selesai
                                        </span>
                                    @elseif($attempt->status === 'in_progress')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Berlangsung
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(107, 114, 128, 0.1); color: #374151;">
                                            {{ ucfirst($attempt->status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($attempt->status === 'completed')
                                        <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                                            {{ number_format($attempt->score, 1) }}%
                                        </div>
                                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                            @php
                                                $grade = '';
                                                if ($attempt->score >= 90) $grade = 'A';
                                                elseif ($attempt->score >= 80) $grade = 'B';
                                                elseif ($attempt->score >= 70) $grade = 'C';
                                                elseif ($attempt->score >= 60) $grade = 'D';
                                                else $grade = 'E';
                                            @endphp
                                            Grade: {{ $grade }}
                                        </div>
                                    @else
                                        <span style="color: var(--text-tertiary, #9ca3af);">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-primary, #111827);">
                                    {{ $attempt->started_at ? $attempt->started_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-primary, #111827);">
                                    {{ $attempt->completed_at ? $attempt->completed_at->format('d M Y, H:i') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-primary, #111827);">
                                    @if($attempt->started_at && $attempt->completed_at)
                                        @php
                                            $duration = $attempt->started_at->diffInMinutes($attempt->completed_at);
                                        @endphp
                                        {{ $duration }} menit
                                    @elseif($attempt->started_at && $attempt->status === 'in_progress')
                                        @php
                                            $duration = $attempt->started_at->diffInMinutes(now());
                                        @endphp
                                        {{ $duration }} menit (berlangsung)
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('teacher.quizzes.attempt-detail', [$quiz->id, $attempt->id]) }}" 
                                       style="color: #2563eb;"
                                       onmouseover="this.style.color='#1d4ed8'"
                                       onmouseout="this.style.color='#2563eb'">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($attempts->hasPages())
                <div class="px-6 py-4 border-t" style="border-color: var(--border-color, #e5e7eb);">
                    {{ $attempts->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--text-tertiary, #9ca3af);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                </svg>
                <h3 class="text-lg font-medium mb-2" style="color: var(--text-primary, #111827);">Belum ada yang mengerjakan</h3>
                <p style="color: var(--text-secondary, #6b7280);">Belum ada siswa yang mengerjakan kuis ini</p>
            </div>
        @endif
    </div>
</div>
@endsection