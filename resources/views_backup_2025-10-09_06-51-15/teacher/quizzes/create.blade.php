@extends('layouts.teacher')

@section('title', $pageTitle)

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="rounded-xl p-6 text-white shadow-lg" style="background: linear-gradient(135deg, #059669, #10b981);">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Buat Kuis Baru ✨</h1>
                <p class="text-green-100">Buat kuis interaktif untuk siswa Anda</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('teacher.quizzes.store') }}" id="quiz-form">
        @csrf
        
        <!-- Quiz Information -->
        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <h3 class="text-lg font-semibold mb-6" style="color: var(--text-primary, #111827);">Informasi Kuis</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Judul Kuis <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan judul kuis">
                    @error('title')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="subject" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Mata Pelajaran <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="subject" id="subject" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Contoh: Matematika">
                    @error('subject')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="class_id" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Target Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" id="class_id" required
                            class="w-full rounded-lg border px-3 py-2" 
                            style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Pilih Kelas</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->level }} {{ $class->name }} @if($class->program) - {{ $class->program }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Deskripsi
                    </label>
                    <textarea name="description" id="description" rows="3"
                              class="w-full rounded-lg border px-3 py-2" 
                              style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                              placeholder="Deskripsi singkat tentang kuis ini"></textarea>
                    @error('description')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="start_time" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Waktu Mulai <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="start_time" id="start_time" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                    @error('start_time')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Waktu Berakhir <span class="text-red-500">*</span>
                    </label>
                    <input type="datetime-local" name="end_time" id="end_time" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                    @error('end_time')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="duration_minutes" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Durasi (menit) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="duration_minutes" id="duration_minutes" required min="1" max="300"
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="60">
                    @error('duration_minutes')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="max_attempts" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Maksimal Percobaan <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="max_attempts" id="max_attempts" required min="1" max="10" value="1"
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                    @error('max_attempts')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="instructions" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Instruksi Kuis
                    </label>
                    <textarea name="instructions" id="instructions" rows="3"
                              class="w-full rounded-lg border px-3 py-2" 
                              style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                              placeholder="Instruksi khusus untuk siswa sebelum mengerjakan kuis"></textarea>
                    @error('instructions')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <div class="flex items-center space-x-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="show_results" value="1" 
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm" style="color: var(--text-primary, #374151);">Tampilkan hasil setelah selesai</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" name="randomize_questions" value="1"
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span class="ml-2 text-sm" style="color: var(--text-primary, #374151);">Acak urutan soal</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Questions Section -->
        <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold" style="color: var(--text-primary, #111827);">Soal-soal Kuis</h3>
                <button type="button" id="add-question" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Soal
                </button>
            </div>

            <div id="questions-container">
                <!-- Questions will be added here dynamically -->
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('teacher.quizzes.index') }}" 
               class="px-6 py-2 border rounded-lg transition-colors duration-200" 
               style="border-color: var(--border-color, #d1d5db); color: var(--text-primary, #374151);"
               onmouseover="this.style.background='var(--bg-tertiary, #f9fafb)'"
               onmouseout="this.style.background='transparent'">
                Batal
            </a>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                Simpan Kuis
            </button>
        </div>
    </form>
</div>

<!-- Question Template -->
<template id="question-template">
    <div class="question-item border rounded-lg p-4 mb-4" style="border-color: var(--border-color, #e5e7eb);">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-md font-medium" style="color: var(--text-primary, #111827);">Soal <span class="question-number">1</span></h4>
            <button type="button" class="remove-question" style="color: #dc2626;"
                    onmouseover="this.style.color='#b91c1c'"
                    onmouseout="this.style.color='#dc2626'">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                    Pertanyaan <span class="text-red-500">*</span>
                </label>
                <textarea name="questions[INDEX][question]" rows="3" required
                          class="w-full rounded-lg border px-3 py-2" 
                          style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                          placeholder="Masukkan pertanyaan"></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                    Tipe Soal <span class="text-red-500">*</span>
                </label>
                <select name="questions[INDEX][type]" class="question-type w-full rounded-lg border px-3 py-2" 
                        style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);" required>
                    <option value="">Pilih Tipe</option>
                    <option value="multiple_choice">Pilihan Ganda</option>
                    <option value="true_false">Benar/Salah</option>
                    <option value="essay">Essay</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                    Poin <span class="text-red-500">*</span>
                </label>
                <input type="number" name="questions[INDEX][points]" min="1" value="10" required
                       class="w-full rounded-lg border px-3 py-2" 
                       style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
            </div>

            <!-- Options for multiple choice -->
            <div class="options-container md:col-span-2" style="display: none;">
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                    Pilihan Jawaban
                </label>
                <div class="space-y-2">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">A.</span>
                        <input type="text" name="questions[INDEX][options][A]" 
                               class="flex-1 rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Pilihan A">
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">B.</span>
                        <input type="text" name="questions[INDEX][options][B]" 
                               class="flex-1 rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Pilihan B">
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">C.</span>
                        <input type="text" name="questions[INDEX][options][C]" 
                               class="flex-1 rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Pilihan C">
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">D.</span>
                        <input type="text" name="questions[INDEX][options][D]" 
                               class="flex-1 rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Pilihan D">
                    </div>
                </div>
            </div>

            <!-- Correct Answer -->
            <div class="correct-answer-container md:col-span-2">
                <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                    Jawaban Benar <span class="text-red-500">*</span>
                </label>
                <select name="questions[INDEX][correct_answer]" class="correct-answer-select w-full rounded-lg border px-3 py-2" 
                        style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);" required>
                    <option value="">Pilih Jawaban Benar</option>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let questionIndex = 0;
    const questionsContainer = document.getElementById('questions-container');
    const addQuestionBtn = document.getElementById('add-question');
    const questionTemplate = document.getElementById('question-template');

    // Add first question automatically
    addQuestion();

    addQuestionBtn.addEventListener('click', addQuestion);

    function addQuestion() {
        const template = questionTemplate.content.cloneNode(true);
        const questionItem = template.querySelector('.question-item');
        
        // Replace INDEX with actual index
        questionItem.innerHTML = questionItem.innerHTML.replace(/INDEX/g, questionIndex);
        
        // Update question number
        questionItem.querySelector('.question-number').textContent = questionIndex + 1;
        
        // Add event listeners
        const typeSelect = questionItem.querySelector('.question-type');
        const removeBtn = questionItem.querySelector('.remove-question');
        
        typeSelect.addEventListener('change', function() {
            handleQuestionTypeChange(questionItem, this.value);
        });
        
        removeBtn.addEventListener('click', function() {
            questionItem.remove();
            updateQuestionNumbers();
        });
        
        questionsContainer.appendChild(questionItem);
        questionIndex++;
    }

    function handleQuestionTypeChange(questionItem, type) {
        const optionsContainer = questionItem.querySelector('.options-container');
        const correctAnswerSelect = questionItem.querySelector('.correct-answer-select');
        
        // Clear previous options
        correctAnswerSelect.innerHTML = '<option value="">Pilih Jawaban Benar</option>';
        
        if (type === 'multiple_choice') {
            optionsContainer.style.display = 'block';
            correctAnswerSelect.innerHTML = `
                <option value="">Pilih Jawaban Benar</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            `;
        } else if (type === 'true_false') {
            optionsContainer.style.display = 'none';
            correctAnswerSelect.innerHTML = `
                <option value="">Pilih Jawaban Benar</option>
                <option value="true">Benar</option>
                <option value="false">Salah</option>
            `;
        } else if (type === 'essay') {
            optionsContainer.style.display = 'none';
            correctAnswerSelect.innerHTML = `
                <option value="manual">Dinilai Manual</option>
            `;
            correctAnswerSelect.value = 'manual';
        } else {
            optionsContainer.style.display = 'none';
        }
    }

    function updateQuestionNumbers() {
        const questions = questionsContainer.querySelectorAll('.question-item');
        questions.forEach((question, index) => {
            question.querySelector('.question-number').textContent = index + 1;
            
            // Update all name attributes
            const inputs = question.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                if (input.name) {
                    input.name = input.name.replace(/questions\[\d+\]/, `questions[${index}]`);
                }
            });
        });
        questionIndex = questions.length;
    }

    // Form validation
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
        const questions = questionsContainer.querySelectorAll('.question-item');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Kuis harus memiliki minimal 1 soal!');
            return false;
        }
        
        // Validate each question
        let isValid = true;
        questions.forEach((question, index) => {
            const questionText = question.querySelector('textarea[name*="[question]"]').value.trim();
            const questionType = question.querySelector('select[name*="[type]"]').value;
            const correctAnswer = question.querySelector('select[name*="[correct_answer]"]').value;
            
            if (!questionText || !questionType || !correctAnswer) {
                isValid = false;
                alert(`Soal ${index + 1} belum lengkap!`);
                return false;
            }
            
            if (questionType === 'multiple_choice') {
                const options = question.querySelectorAll('input[name*="[options]"]');
                let hasEmptyOption = false;
                options.forEach(option => {
                    if (!option.value.trim()) {
                        hasEmptyOption = true;
                    }
                });
                if (hasEmptyOption) {
                    isValid = false;
                    alert(`Soal ${index + 1}: Semua pilihan jawaban harus diisi!`);
                    return false;
                }
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
    });
});
</script>
@endsection