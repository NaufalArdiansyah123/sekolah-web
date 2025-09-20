@extends('layouts.student')

@section('title', 'Mengerjakan Ulangan Harian')

@section('content')
<style>
    /* Take Daily Test Styles with Dark Mode Support */
    .take-test-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .test-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .test-header::before {
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
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .test-info h1 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .test-meta {
        display: flex;
        gap: 2rem;
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .timer-display {
        background: rgba(255, 255, 255, 0.2);
        padding: 1rem 1.5rem;
        border-radius: 12px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .timer-label {
        font-size: 0.75rem;
        opacity: 0.8;
        margin-bottom: 0.25rem;
    }

    .timer-value {
        font-size: 1.5rem;
        font-weight: 700;
        font-family: 'Courier New', monospace;
    }

    .timer-warning {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    /* Question Container */
    .questions-container {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .question-item {
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .question-item:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .question-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .question-number {
        background: #3b82f6;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .question-content {
        flex: 1;
    }

    .question-text {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    .question-points {
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 500;
    }

    .question-type-badge {
        display: inline-block;
        background: #10b981;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-left: 1rem;
    }

    .question-type-badge.essay {
        background: #8b5cf6;
    }

    /* Multiple Choice Options */
    .options-container {
        margin-top: 1.5rem;
    }

    .option-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        background: var(--bg-secondary);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .option-item:hover {
        background: var(--bg-tertiary);
        border-color: #3b82f6;
        transform: translateY(-1px);
    }

    .option-item.selected {
        background: rgba(59, 130, 246, 0.1);
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }

    .option-radio {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-radius: 50%;
        position: relative;
        flex-shrink: 0;
        margin-top: 0.125rem;
        transition: all 0.3s ease;
    }

    .option-item.selected .option-radio {
        border-color: #3b82f6;
        background: #3b82f6;
    }

    .option-item.selected .option-radio::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
    }

    .option-letter {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .option-item.selected .option-letter {
        background: #3b82f6;
        color: white;
    }

    .option-text {
        flex: 1;
        color: var(--text-primary);
        line-height: 1.5;
        font-size: 0.95rem;
    }

    /* Essay Answer */
    .essay-container {
        margin-top: 1.5rem;
    }

    .essay-textarea {
        width: 100%;
        min-height: 200px;
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.95rem;
        line-height: 1.6;
        resize: vertical;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .essay-textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        outline: none;
    }

    .essay-counter {
        text-align: right;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    /* Navigation */
    .test-navigation {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .progress-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .progress-bar {
        width: 200px;
        height: 8px;
        background: var(--bg-secondary);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        transition: width 0.3s ease;
    }

    .nav-buttons {
        display: flex;
        gap: 1rem;
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        position: relative;
        overflow: hidden;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8, #1e40af);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
        color: white;
        text-decoration: none;
    }

    .btn-success {
        background: linear-gradient(135deg, #059669, #047857);
        color: white;
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .btn-success:hover {
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

    /* Auto-save indicator */
    .autosave-indicator {
        position: fixed;
        top: 20px;
        right: 20px;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
        box-shadow: 0 2px 8px var(--shadow-color);
        z-index: 1000;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .autosave-indicator.show {
        opacity: 1;
    }

    .autosave-indicator.saving {
        color: #f59e0b;
    }

    .autosave-indicator.saved {
        color: #059669;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .take-test-container {
            padding: 1rem;
        }

        .test-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .test-meta {
            justify-content: center;
        }

        .questions-container,
        .test-navigation {
            padding: 1.5rem;
        }

        .question-header {
            flex-direction: column;
            gap: 0.75rem;
        }

        .option-item {
            padding: 0.75rem;
        }

        .progress-bar {
            width: 150px;
        }

        .nav-buttons {
            flex-direction: column;
            width: 100%;
        }

        .btn {
            justify-content: center;
        }
    }
</style>

<div class="take-test-container">
    <!-- Test Header -->
    <div class="test-header">
        <div class="header-content">
            <div class="test-info">
                <h1>{{ $attempt->dailyTest->title }}</h1>
                <div class="test-meta">
                    <span>📚 {{ ucfirst(str_replace('_', ' ', $attempt->dailyTest->subject)) }}</span>
                    <span>🎯 Kelas {{ $attempt->dailyTest->class }}</span>
                    <span>📝 {{ $questions->count() }} Soal</span>
                    <span>⏱️ {{ $attempt->dailyTest->duration }} Menit</span>
                </div>
            </div>
            
            <div class="timer-display" id="timerDisplay">
                <div class="timer-label">Sisa Waktu</div>
                <div class="timer-value" id="timerValue">{{ sprintf('%02d:%02d', floor($attempt->time_remaining / 60), $attempt->time_remaining % 60) }}</div>
            </div>
        </div>
    </div>

    <!-- Auto-save Indicator -->
    <div class="autosave-indicator" id="autosaveIndicator">
        <span id="autosaveText">Tersimpan otomatis</span>
    </div>

    <!-- Questions Form -->
    <form id="testForm" method="POST" action="{{ route('student.daily-tests.submit', $attempt->id) }}">
        @csrf
        
        <div class="questions-container">
            @foreach($questions as $index => $question)
                <div class="question-item" data-question-id="{{ $question->id }}">
                    <div class="question-header">
                        <div class="question-number">{{ $index + 1 }}</div>
                        <div class="question-content">
                            <div class="question-text">
                                {!! nl2br(e($question->question)) !!}
                                <span class="question-type-badge {{ $question->type }}">
                                    {{ $question->type === 'multiple_choice' ? 'Pilihan Ganda' : 'Essay' }}
                                </span>
                            </div>
                            <div class="question-points">{{ $question->points }} poin</div>
                        </div>
                    </div>

                    @if($question->type === 'multiple_choice')
                        <div class="options-container">
                            @foreach($question->formatted_options as $optionKey => $optionText)
                                @php
                                    $alphabet = chr(65 + $loop->index); // A, B, C, D, etc.
                                    $isSelected = isset($existingAnswers[$question->id]) && $existingAnswers[$question->id]->answer === $optionKey;
                                @endphp
                                <div class="option-item {{ $isSelected ? 'selected' : '' }}" 
                                     onclick="selectOption({{ $question->id }}, '{{ $optionKey }}', this)">
                                    <div class="option-radio"></div>
                                    <div class="option-letter">{{ $alphabet }}</div>
                                    <div class="option-text">{{ $optionText }}</div>
                                </div>
                            @endforeach
                            <input type="hidden" name="answers[{{ $question->id }}]" 
                                   id="answer_{{ $question->id }}" 
                                   value="{{ $existingAnswers[$question->id]->answer ?? '' }}">
                        </div>
                    @else
                        <div class="essay-container">
                            <textarea name="answers[{{ $question->id }}]" 
                                      class="essay-textarea"
                                      placeholder="Tulis jawaban Anda di sini..."
                                      oninput="updateCharCount(this); autoSave();">{{ $existingAnswers[$question->id]->answer ?? '' }}</textarea>
                            <div class="essay-counter">
                                <span class="char-count">{{ strlen($existingAnswers[$question->id]->answer ?? '') }}</span> karakter
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Navigation -->
        <div class="test-navigation">
            <div class="progress-info">
                <span>Progress:</span>
                <div class="progress-bar">
                    <div class="progress-fill" id="progressFill" style="width: 0%"></div>
                </div>
                <span id="progressText">0 / {{ $questions->count() }}</span>
            </div>
            
            <div class="nav-buttons">
                <button type="button" class="btn btn-secondary" onclick="saveDraft()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Simpan Draft
                </button>
                
                <button type="button" class="btn btn-success" onclick="submitTest()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Selesai & Kumpulkan
                </button>
            </div>
        </div>
    </form>
</div>

<script>
let timeRemaining = {{ $attempt->time_remaining * 60 }}; // Convert to seconds
let autoSaveTimer;
let isSubmitting = false;

// Timer functionality
function updateTimer() {
    if (timeRemaining <= 0) {
        // Time's up - auto submit
        if (!isSubmitting) {
            alert('Waktu ulangan telah habis! Jawaban akan dikumpulkan otomatis.');
            submitTest();
        }
        return;
    }
    
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    
    document.getElementById('timerValue').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    // Warning when 5 minutes left
    if (timeRemaining <= 300) {
        document.getElementById('timerDisplay').classList.add('timer-warning');
    }
    
    timeRemaining--;
}

// Start timer
setInterval(updateTimer, 1000);

// Multiple choice selection
function selectOption(questionId, optionKey, element) {
    // Remove selection from other options in this question
    const questionContainer = element.closest('.question-item');
    questionContainer.querySelectorAll('.option-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Select this option
    element.classList.add('selected');
    
    // Update hidden input
    document.getElementById(`answer_${questionId}`).value = optionKey;
    
    // Update progress and auto-save
    updateProgress();
    autoSave();
}

// Update character count for essays
function updateCharCount(textarea) {
    const counter = textarea.parentElement.querySelector('.char-count');
    counter.textContent = textarea.value.length;
}

// Update progress
function updateProgress() {
    const totalQuestions = {{ $questions->count() }};
    let answeredQuestions = 0;
    
    // Count multiple choice answers
    document.querySelectorAll('input[name^="answers["]').forEach(input => {
        if (input.value.trim() !== '') {
            answeredQuestions++;
        }
    });
    
    // Count essay answers
    document.querySelectorAll('.essay-textarea').forEach(textarea => {
        if (textarea.value.trim() !== '') {
            answeredQuestions++;
        }
    });
    
    const percentage = (answeredQuestions / totalQuestions) * 100;
    document.getElementById('progressFill').style.width = percentage + '%';
    document.getElementById('progressText').textContent = `${answeredQuestions} / ${totalQuestions}`;
}

// Auto-save functionality
function autoSave() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        if (isSubmitting) return;
        
        showAutosaveIndicator('saving');
        
        const formData = new FormData(document.getElementById('testForm'));
        formData.append('_method', 'PATCH'); // For partial update
        
        fetch('{{ route("student.daily-tests.submit", $attempt->id) }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            showAutosaveIndicator('saved');
        })
        .catch(error => {
            console.error('Auto-save error:', error);
        });
    }, 2000);
}

// Show auto-save indicator
function showAutosaveIndicator(status) {
    const indicator = document.getElementById('autosaveIndicator');
    const text = document.getElementById('autosaveText');
    
    indicator.className = 'autosave-indicator show ' + status;
    
    if (status === 'saving') {
        text.textContent = 'Menyimpan...';
    } else if (status === 'saved') {
        text.textContent = 'Tersimpan otomatis';
    }
    
    setTimeout(() => {
        indicator.classList.remove('show');
    }, 2000);
}

// Save draft
function saveDraft() {
    showAutosaveIndicator('saving');
    autoSave();
}

// Submit test
function submitTest() {
    if (isSubmitting) return;
    
    if (!confirm('Apakah Anda yakin ingin mengumpulkan ulangan? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }
    
    isSubmitting = true;
    
    const formData = new FormData(document.getElementById('testForm'));
    
    fetch('{{ route("student.daily-tests.submit", $attempt->id) }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else {
            alert(data.message);
            isSubmitting = false;
        }
    })
    .catch(error => {
        console.error('Submit error:', error);
        alert('Terjadi kesalahan saat mengumpulkan ulangan.');
        isSubmitting = false;
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    updateProgress();
    
    // Add event listeners for essay textareas
    document.querySelectorAll('.essay-textarea').forEach(textarea => {
        textarea.addEventListener('input', autoSave);
    });
    
    // Prevent accidental page leave
    window.addEventListener('beforeunload', function(e) {
        if (!isSubmitting) {
            e.preventDefault();
            e.returnValue = 'Anda yakin ingin meninggalkan halaman? Jawaban yang belum disimpan akan hilang.';
        }
    });
});
</script>
@endsection