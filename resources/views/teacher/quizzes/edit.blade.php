@extends('layouts.teacher')

@push('styles')
<style>
    .question-item {
        border: 2px solid var(--border-color, #e5e7eb);
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .question-item:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }
    
    .question-item.active {
        border-color: #3b82f6;
        background-color: rgba(59, 130, 246, 0.05);
    }
    
    .option-input {
        transition: all 0.2s ease;
    }
    
    .option-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .question-type-selector {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .btn-add-question {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        transition: all 0.3s ease;
    }
    
    .btn-add-question:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(79, 172, 254, 0.3);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="rounded-xl shadow-sm border p-6" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary, #111827);">Edit Kuis</h1>
                <p class="mt-1" style="color: var(--text-secondary, #6b7280);">Perbarui informasi dan soal kuis</p>
            </div>
            <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <form action="{{ route('teacher.quizzes.update', $quiz->id) }}" method="POST" id="quiz-form">
        @csrf
        @method('PUT')
        
        <!-- Quiz Information -->
        <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Informasi Kuis</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Judul Kuis <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $quiz->title) }}"
                               class="w-full px-4 py-3 border rounded-lg transition-colors" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Masukkan judul kuis"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="subject" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Mata Pelajaran <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               value="{{ old('subject', $quiz->subject) }}"
                               class="w-full px-4 py-3 border rounded-lg transition-colors" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Contoh: Matematika"
                               required>
                        @error('subject')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Target Kelas -->
                    <div>
                        <label for="class_id" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Target Kelas <span class="text-red-500">*</span>
                        </label>
                        <select id="class_id" 
                                name="class_id"
                                class="w-full px-4 py-3 border rounded-lg transition-colors" 
                                style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                required>
                            <option value="">Pilih Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ old('class_id', $quiz->class_id) == $class->id ? 'selected' : '' }}>
                                    {{ $class->level }} {{ $class->name }} @if($class->program) - {{ $class->program }} @endif
                                </option>
                            @endforeach
                        </select>
                        @error('class_id')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Duration -->
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Durasi (menit) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="duration_minutes" 
                               name="duration_minutes" 
                               value="{{ old('duration_minutes', $quiz->duration_minutes) }}"
                               min="1" 
                               max="300"
                               class="w-full px-4 py-3 border rounded-lg transition-colors" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="60"
                               required>
                        @error('duration_minutes')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Start Time -->
                    <div>
                        <label for="start_time" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Waktu Mulai <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="start_time" 
                               name="start_time" 
                               value="{{ old('start_time', $quiz->start_time->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-3 border rounded-lg transition-colors" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               required>
                        @error('start_time')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- End Time -->
                    <div>
                        <label for="end_time" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Waktu Berakhir <span class="text-red-500">*</span>
                        </label>
                        <input type="datetime-local" 
                               id="end_time" 
                               name="end_time" 
                               value="{{ old('end_time', $quiz->end_time->format('Y-m-d\TH:i')) }}"
                               class="w-full px-4 py-3 border rounded-lg transition-colors" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               required>
                        @error('end_time')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Max Attempts -->
                    <div>
                        <label for="max_attempts" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Maksimal Percobaan <span class="text-red-500">*</span>
                        </label>
                        <select id="max_attempts" 
                                name="max_attempts"
                                class="w-full px-4 py-3 border rounded-lg transition-colors" 
                                style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                required>
                            @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('max_attempts', $quiz->max_attempts) == $i ? 'selected' : '' }}>
                                    {{ $i }} kali
                                </option>
                            @endfor
                        </select>
                        @error('max_attempts')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Deskripsi
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-4 py-3 border rounded-lg transition-colors" 
                                  style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                  placeholder="Deskripsi singkat tentang kuis ini">{{ old('description', $quiz->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instructions -->
                    <div class="md:col-span-2">
                        <label for="instructions" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Instruksi untuk Siswa
                        </label>
                        <textarea id="instructions" 
                                  name="instructions" 
                                  rows="3"
                                  class="w-full px-4 py-3 border rounded-lg transition-colors" 
                                  style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                  placeholder="Instruksi khusus untuk mengerjakan kuis ini">{{ old('instructions', $quiz->instructions) }}</textarea>
                        @error('instructions')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Settings -->
                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="show_results" 
                                       name="show_results" 
                                       value="1"
                                       {{ old('show_results', $quiz->show_results) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="show_results" class="ml-2 text-sm font-medium" style="color: var(--text-primary, #374151);">
                                    Tampilkan hasil kepada siswa setelah selesai
                                </label>
                            </div>
                            
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       id="randomize_questions" 
                                       name="randomize_questions" 
                                       value="1"
                                       {{ old('randomize_questions', $quiz->randomize_questions) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="randomize_questions" class="ml-2 text-sm font-medium" style="color: var(--text-primary, #374151);">
                                    Acak urutan soal
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between">
            <a href="{{ route('teacher.quizzes.show', $quiz->id) }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                Batal
            </a>
            
            <div class="flex items-center space-x-3">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </form>

    <!-- Questions Management -->
    <div class="rounded-xl shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">
                    Kelola Soal ({{ $quiz->questions->count() }})
                </h3>
                <button type="button" 
                        onclick="addQuestion()" 
                        class="btn-add-question text-white px-4 py-2 rounded-lg font-medium transition-all duration-300">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Soal
                </button>
            </div>
        </div>
        <div class="p-6">
            <div id="questions-container" class="space-y-6">
                @foreach($quiz->questions as $index => $question)
                    <div class="question-item p-6" data-question-index="{{ $index }}">
                        <div class="flex items-start justify-between mb-4">
                            <h4 class="text-lg font-medium" style="color: var(--text-primary, #111827);">
                                Soal {{ $index + 1 }}
                            </h4>
                            <button type="button" 
                                    onclick="removeQuestion({{ $index }})" 
                                    style="color: #dc2626;"
                                    onmouseover="this.style.color='#b91c1c'"
                                    onmouseout="this.style.color='#dc2626'">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Question Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Tipe Soal
                            </label>
                            <select name="questions[{{ $index }}][type]" 
                                    class="question-type w-full px-4 py-3 border rounded-lg" 
                                    style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                    onchange="updateQuestionType({{ $index }}, this.value)">
                                <option value="multiple_choice" {{ $question->type === 'multiple_choice' ? 'selected' : '' }}>Pilihan Ganda</option>
                                <option value="true_false" {{ $question->type === 'true_false' ? 'selected' : '' }}>Benar/Salah</option>
                                <option value="essay" {{ $question->type === 'essay' ? 'selected' : '' }}>Essay</option>
                            </select>
                        </div>

                        <!-- Question Text -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Pertanyaan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="questions[{{ $index }}][question]" 
                                      rows="3"
                                      class="w-full px-4 py-3 border rounded-lg" 
                                      style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                      placeholder="Masukkan pertanyaan"
                                      required>{{ $question->question }}</textarea>
                        </div>

                        <!-- Points -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Poin <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="questions[{{ $index }}][points]" 
                                   value="{{ $question->points }}"
                                   min="1" 
                                   max="100"
                                   class="w-32 px-4 py-3 border rounded-lg" 
                                   style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                   required>
                        </div>

                        <!-- Options (for multiple choice) -->
                        @if($question->type === 'multiple_choice')
                            <div class="options-container mb-4">
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                    Pilihan Jawaban <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-3">
                                    @foreach(['A', 'B', 'C', 'D'] as $optionKey)
                                        <div class="flex items-center space-x-3">
                                            <input type="radio" 
                                                   name="questions[{{ $index }}][correct_answer]" 
                                                   value="{{ $optionKey }}"
                                                   {{ $question->correct_answer === $optionKey ? 'checked' : '' }}
                                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                            <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium" style="background: var(--bg-tertiary, #f3f4f6);">
                                                {{ $optionKey }}
                                            </span>
                                            <input type="text" 
                                                   name="questions[{{ $index }}][options][{{ $optionKey }}]" 
                                                   value="{{ $question->options[$optionKey] ?? '' }}"
                                                   class="flex-1 option-input px-4 py-3 border rounded-lg" 
                                                   style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                                   placeholder="Masukkan pilihan {{ $optionKey }}"
                                                   required>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($question->type === 'true_false')
                            <div class="options-container mb-4">
                                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                    Jawaban Benar <span class="text-red-500">*</span>
                                </label>
                                <div class="space-y-2">
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               name="questions[{{ $index }}][correct_answer]" 
                                               value="true"
                                               {{ $question->correct_answer === 'true' ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        <label class="ml-2 text-sm font-medium" style="color: var(--text-primary, #374151);">Benar</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" 
                                               name="questions[{{ $index }}][correct_answer]" 
                                               value="false"
                                               {{ $question->correct_answer === 'false' ? 'checked' : '' }}
                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                        <label class="ml-2 text-sm font-medium" style="color: var(--text-primary, #374151);">Salah</label>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="options-container mb-4">
                                <div class="border rounded-lg p-4" style="background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                                    <p class="text-sm" style="color: #b45309;">
                                        <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Soal essay akan dinilai secara manual oleh guru
                                    </p>
                                </div>
                                <input type="hidden" name="questions[{{ $index }}][correct_answer]" value="manual">
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            @if($quiz->questions->count() === 0)
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto mb-4" style="color: var(--text-tertiary, #9ca3af);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <h3 class="text-lg font-medium mb-2" style="color: var(--text-primary, #111827);">Belum ada soal</h3>
                    <p class="mb-4" style="color: var(--text-secondary, #6b7280);">Tambahkan soal untuk melengkapi kuis ini</p>
                    <button type="button" 
                            onclick="addQuestion()" 
                            class="btn-add-question text-white px-6 py-3 rounded-lg font-medium transition-all duration-300">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Soal Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Question Template (Hidden) -->
<template id="question-template">
    <div class="question-item p-6" data-question-index="">
        <div class="flex items-start justify-between mb-4">
            <h4 class="text-lg font-medium" style="color: var(--text-primary, #111827);">
                Soal <span class="question-number"></span>
            </h4>
            <button type="button" 
                    onclick="removeQuestion(this)" 
                    style="color: #dc2626;"
                    onmouseover="this.style.color='#b91c1c'"
                    onmouseout="this.style.color='#dc2626'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>

        <!-- Question Type -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                Tipe Soal
            </label>
            <select name="questions[][type]" 
                    class="question-type w-full px-4 py-3 border rounded-lg" 
                    style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                    onchange="updateQuestionType(this)">
                <option value="multiple_choice">Pilihan Ganda</option>
                <option value="true_false">Benar/Salah</option>
                <option value="essay">Essay</option>
            </select>
        </div>

        <!-- Question Text -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                Pertanyaan <span class="text-red-500">*</span>
            </label>
            <textarea name="questions[][question]" 
                      rows="3"
                      class="w-full px-4 py-3 border rounded-lg" 
                      style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                      placeholder="Masukkan pertanyaan"
                      required></textarea>
        </div>

        <!-- Points -->
        <div class="mb-4">
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                Poin <span class="text-red-500">*</span>
            </label>
            <input type="number" 
                   name="questions[][points]" 
                   value="10"
                   min="1" 
                   max="100"
                   class="w-32 px-4 py-3 border rounded-lg" 
                   style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                   required>
        </div>

        <!-- Options Container -->
        <div class="options-container mb-4">
            <!-- Will be populated by JavaScript -->
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
let questionIndex = {{ $quiz->questions->count() }};

function addQuestion() {
    const template = document.getElementById('question-template');
    const clone = template.content.cloneNode(true);
    
    // Update question number
    clone.querySelector('.question-number').textContent = questionIndex + 1;
    clone.querySelector('.question-item').setAttribute('data-question-index', questionIndex);
    
    // Update form field names
    const inputs = clone.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        if (input.name) {
            input.name = input.name.replace('[]', `[${questionIndex}]`);
        }
    });
    
    // Set up initial options for multiple choice
    const optionsContainer = clone.querySelector('.options-container');
    updateQuestionTypeContent(optionsContainer, 'multiple_choice', questionIndex);
    
    // Add to container
    document.getElementById('questions-container').appendChild(clone);
    
    questionIndex++;
    updateQuestionNumbers();
}

function removeQuestion(element) {
    if (typeof element === 'number') {
        // Called with index
        const questionItem = document.querySelector(`[data-question-index="${element}"]`);
        if (questionItem) {
            questionItem.remove();
        }
    } else {
        // Called with button element
        element.closest('.question-item').remove();
    }
    updateQuestionNumbers();
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((question, index) => {
        question.setAttribute('data-question-index', index);
        const numberSpan = question.querySelector('.question-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        } else {
            const title = question.querySelector('h4');
            if (title) {
                title.textContent = `Soal ${index + 1}`;
            }
        }
        
        // Update form field names
        const inputs = question.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            if (input.name) {
                input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
            }
        });
    });
    
    questionIndex = questions.length;
}

function updateQuestionType(element, type) {
    let questionItem, questionIndex, selectedType;
    
    if (typeof element === 'number') {
        // Called with index and type
        questionIndex = element;
        selectedType = type;
        questionItem = document.querySelector(`[data-question-index="${questionIndex}"]`);
    } else {
        // Called with select element
        questionItem = element.closest('.question-item');
        questionIndex = parseInt(questionItem.getAttribute('data-question-index'));
        selectedType = element.value;
    }
    
    const optionsContainer = questionItem.querySelector('.options-container');
    updateQuestionTypeContent(optionsContainer, selectedType, questionIndex);
}

function updateQuestionTypeContent(container, type, index) {
    let html = '';
    
    if (type === 'multiple_choice') {
        html = `
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                Pilihan Jawaban <span class="text-red-500">*</span>
            </label>
            <div class="space-y-3">
                ${['A', 'B', 'C', 'D'].map(option => `
                    <div class="flex items-center space-x-3">
                        <input type="radio" 
                               name="questions[${index}][correct_answer]" 
                               value="${option}"
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                        <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium" style="background: var(--bg-tertiary, #f3f4f6);">
                            ${option}
                        </span>
                        <input type="text" 
                               name="questions[${index}][options][${option}]" 
                               class="flex-1 option-input px-4 py-3 border rounded-lg" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Masukkan pilihan ${option}"
                               required>
                    </div>
                `).join('')}
            </div>
        `;
    } else if (type === 'true_false') {
        html = `
            <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                Jawaban Benar <span class="text-red-500">*</span>
            </label>
            <div class="space-y-2">
                <div class="flex items-center">
                    <input type="radio" 
                           name="questions[${index}][correct_answer]" 
                           value="true"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                    <label class="ml-2 text-sm font-medium" style="color: var(--text-primary, #374151);">Benar</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" 
                           name="questions[${index}][correct_answer]" 
                           value="false"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                    <label class="ml-2 text-sm font-medium" style="color: var(--text-primary, #374151);">Salah</label>
                </div>
            </div>
        `;
    } else if (type === 'essay') {
        html = `
            <div class="border rounded-lg p-4" style="background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                <p class="text-sm" style="color: #b45309;">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Soal essay akan dinilai secara manual oleh guru
                </p>
            </div>
            <input type="hidden" name="questions[${index}][correct_answer]" value="manual">
        `;
    }
    
    container.innerHTML = html;
}

// Form validation
document.getElementById('quiz-form').addEventListener('submit', function(e) {
    const questions = document.querySelectorAll('.question-item');
    if (questions.length === 0) {
        e.preventDefault();
        alert('Kuis harus memiliki minimal 1 soal!');
        return false;
    }
    
    // Validate each question
    let isValid = true;
    questions.forEach((question, index) => {
        const questionText = question.querySelector('textarea[name*="[question]"]');
        const points = question.querySelector('input[name*="[points]"]');
        const type = question.querySelector('select[name*="[type]"]');
        
        if (!questionText.value.trim()) {
            isValid = false;
            questionText.focus();
            alert(`Pertanyaan ${index + 1} tidak boleh kosong!`);
            return;
        }
        
        if (!points.value || points.value < 1) {
            isValid = false;
            points.focus();
            alert(`Poin untuk soal ${index + 1} harus minimal 1!`);
            return;
        }
        
        // Validate multiple choice options
        if (type.value === 'multiple_choice') {
            const options = question.querySelectorAll('input[name*="[options]"]');
            const correctAnswer = question.querySelector('input[name*="[correct_answer]"]:checked');
            
            let hasEmptyOption = false;
            options.forEach(option => {
                if (!option.value.trim()) {
                    hasEmptyOption = true;
                }
            });
            
            if (hasEmptyOption) {
                isValid = false;
                alert(`Semua pilihan jawaban untuk soal ${index + 1} harus diisi!`);
                return;
            }
            
            if (!correctAnswer) {
                isValid = false;
                alert(`Pilih jawaban yang benar untuk soal ${index + 1}!`);
                return;
            }
        }
        
        // Validate true/false
        if (type.value === 'true_false') {
            const correctAnswer = question.querySelector('input[name*="[correct_answer]"]:checked');
            if (!correctAnswer) {
                isValid = false;
                alert(`Pilih jawaban yang benar untuk soal ${index + 1}!`);
                return;
            }
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        return false;
    }
});
</script>
@endpush