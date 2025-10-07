@extends('layouts.teacher')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="rounded-xl shadow-sm border overflow-hidden" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $quiz->title }}</h1>
                        @if($quiz->status === 'published')
                            <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                Published
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-sm font-medium" style="background: rgba(107, 114, 128, 0.1); color: #374151;">
                                Draft
                            </span>
                        @endif
                    </div>
                    <p style="color: var(--text-secondary, #6b7280);">{{ $quiz->subject }}</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Kuis
                    </a>
                    
                    @if($quiz->status === 'draft')
                        <form action="{{ route('teacher.quizzes.publish', $quiz->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin mempublikasi kuis ini?')">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Publikasi
                            </button>
                        </form>
                    @else
                        <form action="{{ route('teacher.quizzes.unpublish', $quiz->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin meng-unpublish kuis ini?')">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Unpublish
                            </button>
                        </form>
                    @endif
                    
                    <form action="{{ route('teacher.quizzes.destroy', $quiz->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kuis ini? Tindakan ini tidak dapat dibatalkan.')">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
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
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Soal</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $quiz->questions->count() }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(16, 185, 129, 0.1);">
                    <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Percobaan</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $attemptStats['total_attempts'] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(139, 92, 246, 0.1);">
                    <svg class="w-6 h-6" style="color: #7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Selesai</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $attemptStats['completed_attempts'] }}</p>
                </div>
            </div>
        </div>

        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center">
                <div class="p-3 rounded-lg" style="background: rgba(245, 158, 11, 0.1);">
                    <svg class="w-6 h-6" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Rata-rata Nilai</p>
                    <p class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ number_format($attemptStats['average_score'], 1) }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quiz Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quiz Information -->
            <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Informasi Kuis</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Deskripsi</label>
                            <p class="mt-1" style="color: var(--text-primary, #111827);">{{ $quiz->description ?: 'Tidak ada deskripsi' }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Mata Pelajaran</label>
                            <p class="mt-1" style="color: var(--text-primary, #111827);">{{ $quiz->subject }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Waktu Mulai</label>
                            <p class="mt-1" style="color: var(--text-primary, #111827);">{{ $quiz->start_time->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Waktu Berakhir</label>
                            <p class="mt-1" style="color: var(--text-primary, #111827);">{{ $quiz->end_time->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Durasi</label>
                            <p class="mt-1" style="color: var(--text-primary, #111827);">{{ $quiz->duration_minutes }} menit</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Maksimal Percobaan</label>
                            <p class="mt-1" style="color: var(--text-primary, #111827);">{{ $quiz->max_attempts }} kali</p>
                        </div>
                    </div>
                    
                    @if($quiz->instructions)
                        <div class="mt-6">
                            <label class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Instruksi</label>
                            <div class="mt-1 p-4 rounded-lg" style="background: var(--bg-tertiary, #f9fafb);">
                                <p style="color: var(--text-primary, #111827);">{{ $quiz->instructions }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Questions List -->
            <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Daftar Soal ({{ $quiz->questions->count() }})</h3>
                </div>
                <div class="p-6">
                    @if($quiz->questions->count() > 0)
                        <div class="space-y-6">
                            @foreach($quiz->questions as $index => $question)
                                <div class="border rounded-lg p-4" style="border-color: var(--border-color, #e5e7eb);">
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="font-medium" style="color: var(--text-primary, #111827);">
                                            Soal {{ $index + 1 }}
                                            <span class="ml-2 text-sm" style="color: var(--text-secondary, #6b7280);">({{ $question->points }} poin)</span>
                                        </h4>
                                        <span class="px-2 py-1 rounded text-xs font-medium" style="background: rgba(59, 130, 246, 0.1); color: #2563eb;">
                                            {{ ucfirst(str_replace('_', ' ', $question->type)) }}
                                        </span>
                                    </div>
                                    
                                    <p class="mb-3" style="color: var(--text-primary, #374151);">{{ $question->question }}</p>
                                    
                                    @if($question->type === 'multiple_choice' && $question->options)
                                        <div class="space-y-2">
                                            @foreach($question->options as $key => $option)
                                                <div class="flex items-center">
                                                    <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-sm font-medium mr-3 {{ $question->correct_answer === $key ? 'border-green-500 text-green-700' : '' }}" 
                                                          style="border-color: {{ $question->correct_answer === $key ? '#10b981' : 'var(--border-color, #d1d5db)' }}; background: {{ $question->correct_answer === $key ? 'rgba(16, 185, 129, 0.1)' : 'transparent' }};">
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
                                    @elseif($question->type === 'true_false')
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-sm font-medium mr-3 {{ $question->correct_answer === 'true' ? 'border-green-500 text-green-700' : '' }}" 
                                                      style="border-color: {{ $question->correct_answer === 'true' ? '#10b981' : 'var(--border-color, #d1d5db)' }}; background: {{ $question->correct_answer === 'true' ? 'rgba(16, 185, 129, 0.1)' : 'transparent' }};">
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
                                            <div class="flex items-center">
                                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center text-sm font-medium mr-3 {{ $question->correct_answer === 'false' ? 'border-green-500 text-green-700' : '' }}" 
                                                      style="border-color: {{ $question->correct_answer === 'false' ? '#10b981' : 'var(--border-color, #d1d5db)' }}; background: {{ $question->correct_answer === 'false' ? 'rgba(16, 185, 129, 0.1)' : 'transparent' }};">
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
                                    @elseif($question->type === 'essay')
                                        <div class="border rounded-lg p-3" style="background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                                            <p class="text-sm" style="color: #b45309;">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Soal essay - Perlu penilaian manual
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto mb-4" style="color: var(--text-tertiary, #9ca3af);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <p style="color: var(--text-secondary, #6b7280);">Belum ada soal ditambahkan</p>
                            <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" 
                               class="mt-2 font-medium" style="color: #2563eb;"
                               onmouseover="this.style.color='#1d4ed8'"
                               onmouseout="this.style.color='#2563eb'">
                                Tambah Soal
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('teacher.quizzes.attempts', $quiz->id) }}" 
                       class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Lihat Hasil Siswa
                    </a>
                    
                    <a href="{{ route('teacher.quizzes.edit', $quiz->id) }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Kuis
                    </a>
                    
                    <a href="{{ route('teacher.quizzes.create') }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Kuis Baru
                    </a>
                </div>
            </div>

            <!-- Quiz Settings -->
            <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Pengaturan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Tampilkan Hasil</span>
                        <span class="text-sm font-medium" style="color: {{ $quiz->show_results ? '#059669' : '#dc2626' }};">
                            {{ $quiz->show_results ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Acak Soal</span>
                        <span class="text-sm font-medium" style="color: {{ $quiz->randomize_questions ? '#059669' : '#dc2626' }};">
                            {{ $quiz->randomize_questions ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Dibuat</span>
                        <span class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                            {{ $quiz->created_at->format('d M Y') }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm" style="color: var(--text-secondary, #6b7280);">Terakhir Diubah</span>
                        <span class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                            {{ $quiz->updated_at->format('d M Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection