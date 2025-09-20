@extends('layouts.teacher')

@section('title', 'Buat Ulangan Harian')

@section('content')
<style>
    /* Create Daily Test Styles with Dark Mode Support */
    .create-test-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 100%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        backdrop-filter: blur(10px);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
    }

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .section-title svg {
        color: #059669;
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .form-control, .form-select, .form-textarea {
        width: 100%;
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
        font-size: 0.875rem;
    }

    .form-control:focus, .form-select:focus, .form-textarea:focus {
        border-color: #059669;
        box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        background: var(--bg-primary);
        color: var(--text-primary);
        outline: none;
    }

    .form-textarea {
        resize: vertical;
        min-height: 100px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }

    /* Question Builder */
    .questions-container {
        margin-top: 1.5rem;
    }

    .question-item {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        position: relative;
    }

    .question-item:hover {
        background: var(--bg-tertiary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .question-header {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .question-number {
        background: #059669;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .question-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-question {
        padding: 0.5rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
    }

    .btn-remove {
        background: #ef4444;
        color: white;
    }

    .btn-remove:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .question-type-select {
        margin-bottom: 1rem;
    }

    .options-container {
        margin-top: 1rem;
    }

    .option-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        padding: 0.75rem;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .option-item:hover {
        background: var(--bg-secondary);
    }

    .option-radio {
        width: 20px;
        height: 20px;
        accent-color: #059669;
    }

    .option-input {
        flex: 1;
        border: none;
        background: transparent;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .option-input:focus {
        outline: none;
    }

    .btn-remove-option {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 0.25rem 0.5rem;
        cursor: pointer;
        font-size: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-remove-option:hover {
        background: #dc2626;
    }

    .btn-add-option {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.5rem 1rem;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .btn-add-option:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    .btn-add-question {
        background: #059669;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .btn-add-question:hover {
        background: #047857;
        transform: translateY(-2px);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #047857, #065f46);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        transform: translateY(-2px);
        color: var(--text-primary);
        text-decoration: none;
    }

    .btn-draft {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);
    }

    .btn-draft:hover {
        background: linear-gradient(135deg, #d97706, #b45309);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35);
        color: white;
        text-decoration: none;
    }

    /* CSS Variables */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-tertiary: #9ca3af;
        --border-color: #e5e7eb;
        --shadow-color: rgba(0, 0, 0, 0.05);
    }

    .dark {
        --bg-primary: #1f2937;
        --bg-secondary: #111827;
        --bg-tertiary: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #d1d5db;
        --text-tertiary: #9ca3af;
        --border-color: #374151;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Animation */
    .form-container {
        animation: slideUp 0.5s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="create-test-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Buat Ulangan Harian Baru
            </h1>
            <p class="page-subtitle">
                Buat ulangan harian untuk siswa dengan soal pilihan ganda dan essay
            </p>
            <a href="{{ route('teacher.daily-tests.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Form Container -->
    <div class="form-container">
        <form id="createTestForm" method="POST" action="{{ route('teacher.daily-tests.store') }}">
            @csrf
            
            <!-- Basic Information Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Dasar
                </h3>
                
                <div class="form-group">
                    <label for="title" class="form-label">Judul Ulangan *</label>
                    <input type="text" id="title" name="title" class="form-control" 
                           placeholder="Masukkan judul ulangan..." required>
                </div>
                
                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea id="description" name="description" class="form-textarea" 
                              placeholder="Deskripsi ulangan (opsional)..."></textarea>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="subject" class="form-label">Mata Pelajaran *</label>
                        <select id="subject" name="subject" class="form-select" required>
                            <option value="">Pilih Mata Pelajaran</option>
                            <option value="matematika">Matematika</option>
                            <option value="bahasa_indonesia">Bahasa Indonesia</option>
                            <option value="bahasa_inggris">Bahasa Inggris</option>
                            <option value="ipa">IPA</option>
                            <option value="ips">IPS</option>
                            <option value="pkn">PKN</option>
                            <option value="agama">Agama</option>
                            <option value="seni_budaya">Seni Budaya</option>
                            <option value="pjok">PJOK</option>
                            <option value="prakarya">Prakarya</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="class" class="form-label">Kelas *</label>
                        <select id="class" name="class" class="form-select" required>
                            <option value="">Pilih Kelas</option>
                            <option value="7">Kelas 7</option>
                            <option value="8">Kelas 8</option>
                            <option value="9">Kelas 9</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="duration" class="form-label">Durasi (menit) *</label>
                        <input type="number" id="duration" name="duration" class="form-control" 
                               placeholder="90" min="15" max="180" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="scheduled_at" class="form-label">Jadwal Pelaksanaan</label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" class="form-control">
                    </div>
                </div>
            </div>
            
            <!-- Questions Section -->
            <div class="form-section">
                <h3 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Soal-soal Ulangan
                </h3>
                
                <div class="questions-container" id="questionsContainer">
                    <!-- Questions will be added here dynamically -->
                </div>
                
                <button type="button" class="btn-add-question" onclick="addQuestion()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Soal
                </button>
            </div>
            
            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('teacher.daily-tests.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                
                <button type="submit" name="status" value="draft" class="btn btn-draft">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Simpan sebagai Draft
                </button>
                
                <button type="submit" name="status" value="published" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Publikasikan Ulangan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let questionCount = 0;

// Add new question
function addQuestion() {
    questionCount++;
    const questionsContainer = document.getElementById('questionsContainer');
    
    const questionHtml = `
        <div class="question-item" id="question-${questionCount}">
            <div class="question-header">
                <div class="question-number">${questionCount}</div>
                <div class="question-actions">
                    <button type="button" class="btn-question btn-remove" onclick="removeQuestion(${questionCount})" title="Hapus Soal">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="form-group question-type-select">
                <label class="form-label">Tipe Soal</label>
                <select name="questions[${questionCount}][type]" class="form-select" onchange="toggleQuestionType(${questionCount}, this.value)" required>
                    <option value="">Pilih Tipe Soal</option>
                    <option value="multiple_choice">Pilihan Ganda</option>
                    <option value="essay">Essay</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Pertanyaan *</label>
                <textarea name="questions[${questionCount}][question]" class="form-textarea" placeholder="Masukkan pertanyaan..." required></textarea>
            </div>
            
            <div class="form-group">
                <label class="form-label">Poin</label>
                <input type="number" name="questions[${questionCount}][points]" class="form-control" placeholder="10" min="1" max="100" value="10">
            </div>
            
            <div class="options-container" id="options-${questionCount}" style="display: none;">
                <label class="form-label">Pilihan Jawaban</label>
                <div id="options-list-${questionCount}">
                    <!-- Options will be added here -->
                </div>
                <button type="button" class="btn-add-option" onclick="addOption(${questionCount})">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Pilihan
                </button>
            </div>
        </div>
    `;
    
    questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
    updateQuestionNumbers();
}

// Remove question
function removeQuestion(questionId) {
    if (confirm('Apakah Anda yakin ingin menghapus soal ini?')) {
        document.getElementById(`question-${questionId}`).remove();
        updateQuestionNumbers();
    }
}

// Toggle question type (multiple choice or essay)
function toggleQuestionType(questionId, type) {
    const optionsContainer = document.getElementById(`options-${questionId}`);
    
    if (type === 'multiple_choice') {
        optionsContainer.style.display = 'block';
        // Add default options if none exist
        const optionsList = document.getElementById(`options-list-${questionId}`);
        if (optionsList.children.length === 0) {
            addOption(questionId);
            addOption(questionId);
            addOption(questionId);
            addOption(questionId);
        }
    } else {
        optionsContainer.style.display = 'none';
    }
}

// Add option to multiple choice question
function addOption(questionId) {
    const optionsList = document.getElementById(`options-list-${questionId}`);
    const optionCount = optionsList.children.length;
    const optionLetter = String.fromCharCode(65 + optionCount); // A, B, C, D, etc.
    
    const optionHtml = `
        <div class="option-item" id="option-${questionId}-${optionCount}">
            <input type="radio" name="questions[${questionId}][correct_answer]" value="${optionCount}" class="option-radio" required>
            <input type="text" name="questions[${questionId}][options][${optionCount}]" class="option-input" placeholder="Pilihan ${optionLetter}" required>
            <button type="button" class="btn-remove-option" onclick="removeOption(${questionId}, ${optionCount})">Hapus</button>
        </div>
    `;
    
    optionsList.insertAdjacentHTML('beforeend', optionHtml);
}

// Remove option from multiple choice question
function removeOption(questionId, optionIndex) {
    const optionElement = document.getElementById(`option-${questionId}-${optionIndex}`);
    if (optionElement) {
        optionElement.remove();
    }
}

// Update question numbers after adding/removing questions
function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((question, index) => {
        const questionNumber = question.querySelector('.question-number');
        if (questionNumber) {
            questionNumber.textContent = index + 1;
        }
    });
}

// Form validation before submit
document.getElementById('createTestForm').addEventListener('submit', function(e) {
    const questions = document.querySelectorAll('.question-item');
    
    if (questions.length === 0) {
        e.preventDefault();
        alert('Minimal harus ada 1 soal untuk membuat ulangan.');
        return false;
    }
    
    // Validate each question
    let isValid = true;
    questions.forEach((question, index) => {
        const questionText = question.querySelector('textarea[name*="[question]"]');
        const questionType = question.querySelector('select[name*="[type]"]');
        
        if (!questionText.value.trim()) {
            isValid = false;
            alert(`Soal nomor ${index + 1} harus diisi.`);
            return;
        }
        
        if (!questionType.value) {
            isValid = false;
            alert(`Tipe soal nomor ${index + 1} harus dipilih.`);
            return;
        }
        
        // Validate multiple choice questions
        if (questionType.value === 'multiple_choice') {
            const options = question.querySelectorAll('input[name*="[options]"]');
            const correctAnswer = question.querySelector('input[name*="[correct_answer]"]:checked');
            
            if (options.length < 2) {
                isValid = false;
                alert(`Soal pilihan ganda nomor ${index + 1} minimal harus memiliki 2 pilihan.`);
                return;
            }
            
            if (!correctAnswer) {
                isValid = false;
                alert(`Soal pilihan ganda nomor ${index + 1} harus memiliki jawaban yang benar.`);
                return;
            }
            
            // Check if all options are filled
            let emptyOptions = 0;
            options.forEach(option => {
                if (!option.value.trim()) {
                    emptyOptions++;
                }
            });
            
            if (emptyOptions > 0) {
                isValid = false;
                alert(`Semua pilihan pada soal nomor ${index + 1} harus diisi.`);
                return;
            }
        }
    });
    
    if (!isValid) {
        e.preventDefault();
        return false;
    }
});

// Initialize with one question
document.addEventListener('DOMContentLoaded', function() {
    addQuestion();
});
</script>
@endsection