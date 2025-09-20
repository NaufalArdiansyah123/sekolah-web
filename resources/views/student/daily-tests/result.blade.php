@extends('layouts.student')

@section('title', 'Hasil Ulangan Harian')

@section('content')
<style>
    /* Result Daily Test Styles with Dark Mode Support */
    .result-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        box-sizing: border-box;
    }

    .result-header {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        text-align: center;
    }

    .result-header::before {
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
    }

    .result-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
    }

    .test-info {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .score-display {
        background: rgba(255, 255, 255, 0.2);
        padding: 1.5rem;
        border-radius: 16px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: inline-block;
    }

    .score-value {
        font-size: 3rem;
        font-weight: 800;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .score-label {
        font-size: 0.875rem;
        opacity: 0.8;
        margin-top: 0.5rem;
    }

    .grade-letter {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: 800;
        margin: 1rem auto 0;
        border: 2px solid rgba(255, 255, 255, 0.5);
    }

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px var(--shadow-color);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 14px 14px 0 0;
    }

    .stat-card.questions::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-card.correct::before { background: linear-gradient(90deg, #059669, #10b981); }
    .stat-card.incorrect::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .stat-card.time::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: #3b82f6;
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Review Section */
    .review-section {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
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

    .question-review {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .question-review:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    .question-review:last-child {
        margin-bottom: 0;
    }

    .review-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .review-number {
        background: #3b82f6;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .review-number.correct {
        background: #059669;
    }

    .review-number.incorrect {
        background: #ef4444;
    }

    .review-number.essay {
        background: #8b5cf6;
    }

    .review-content {
        flex: 1;
    }

    .review-question {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .review-points {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .answer-section {
        margin-top: 1rem;
    }

    .answer-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .answer-content {
        padding: 0.75rem 1rem;
        border-radius: 8px;
        margin-bottom: 0.75rem;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .student-answer {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.2);
        color: var(--text-primary);
    }

    .student-answer.correct {
        background: rgba(5, 150, 105, 0.1);
        border-color: rgba(5, 150, 105, 0.2);
    }

    .student-answer.incorrect {
        background: rgba(239, 68, 68, 0.1);
        border-color: rgba(239, 68, 68, 0.2);
    }

    .correct-answer {
        background: rgba(5, 150, 105, 0.1);
        border: 1px solid rgba(5, 150, 105, 0.2);
        color: var(--text-primary);
    }

    .teacher-feedback {
        background: rgba(139, 92, 246, 0.1);
        border: 1px solid rgba(139, 92, 246, 0.2);
        color: var(--text-primary);
        font-style: italic;
    }

    .points-earned {
        display: inline-block;
        background: #059669;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
    }

    .points-earned.partial {
        background: #f59e0b;
    }

    .points-earned.zero {
        background: #ef4444;
    }

    /* Action Buttons */
    .action-section {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        text-align: center;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 1rem;
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
        .result-container {
            padding: 1rem;
        }

        .result-header {
            padding: 1.5rem;
        }

        .result-title {
            font-size: 1.5rem;
        }

        .score-value {
            font-size: 2rem;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .review-section,
        .action-section {
            padding: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }

    /* Animation */
    .result-header,
    .stat-card,
    .review-section,
    .action-section {
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

<div class="result-container">
    <!-- Result Header -->
    <div class="result-header">
        <div class="header-content">
            <h1 class="result-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Hasil Ulangan Harian
            </h1>
            <div class="test-info">
                {{ $attempt->dailyTest->title }} - {{ ucfirst(str_replace('_', ' ', $attempt->dailyTest->subject)) }}
            </div>
            <div class="score-display">
                <div class="score-value">{{ number_format($attempt->score, 1) }}</div>
                <div class="score-label">dari 100 poin</div>
                <div class="grade-letter">{{ $attempt->grade_letter }}</div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card questions">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['answered_questions'] }}/{{ $stats['total_questions'] }}</div>
            <div class="stat-label">Soal Dijawab</div>
        </div>

        <div class="stat-card correct">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['correct_answers'] }}</div>
            <div class="stat-label">Jawaban Benar</div>
        </div>

        <div class="stat-card incorrect">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['incorrect_answers'] }}</div>
            <div class="stat-label">Jawaban Salah</div>
        </div>

        <div class="stat-card time">
            <div class="stat-icon">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['duration_taken'] }}</div>
            <div class="stat-label">Menit Digunakan</div>
        </div>
    </div>

    <!-- Question Review -->
    <div class="review-section">
        <h3 class="section-title">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
            Review Jawaban
        </h3>

        @foreach($questions as $index => $question)
            @php
                $answer = $answers[$question->id] ?? null;
                $isCorrect = $answer ? $answer->is_correct : null;
                $pointsEarned = $answer ? $answer->points_earned : 0;
                $maxPoints = $question->points;
            @endphp
            
            <div class="question-review">
                <div class="review-header">
                    <div class="review-number {{ $question->type === 'essay' ? 'essay' : ($isCorrect === true ? 'correct' : ($isCorrect === false ? 'incorrect' : '')) }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="review-content">
                        <div class="review-question">{!! nl2br(e($question->question)) !!}</div>
                        <div class="review-points">{{ $question->points }} poin - {{ ucfirst($question->type) }}</div>
                    </div>
                </div>

                <div class="answer-section">
                    @if($answer)
                        <div class="answer-label">Jawaban Anda:</div>
                        <div class="answer-content student-answer {{ $isCorrect === true ? 'correct' : ($isCorrect === false ? 'incorrect' : '') }}">
                            @if($question->type === 'multiple_choice')
                                @php
                                    $optionLetter = chr(65 + array_search($answer->answer, array_keys($question->formatted_options)));
                                    $optionText = $question->formatted_options[$answer->answer] ?? $answer->answer;
                                @endphp
                                <strong>{{ $optionLetter }}.</strong> {{ $optionText }}
                            @else
                                {{ $answer->answer }}
                            @endif
                        </div>

                        @if($question->type === 'multiple_choice' && $isCorrect === false)
                            <div class="answer-label">Jawaban Benar:</div>
                            <div class="answer-content correct-answer">
                                @php
                                    $correctLetter = chr(65 + array_search($question->correct_answer, array_keys($question->formatted_options)));
                                    $correctText = $question->formatted_options[$question->correct_answer] ?? $question->correct_answer;
                                @endphp
                                <strong>{{ $correctLetter }}.</strong> {{ $correctText }}
                            </div>
                        @endif

                        @if($answer->teacher_feedback)
                            <div class="answer-label">Feedback Guru:</div>
                            <div class="answer-content teacher-feedback">
                                {{ $answer->teacher_feedback }}
                            </div>
                        @endif

                        <div class="points-earned {{ $pointsEarned == $maxPoints ? '' : ($pointsEarned > 0 ? 'partial' : 'zero') }}">
                            {{ $pointsEarned }}/{{ $maxPoints }} poin
                        </div>
                    @else
                        <div class="answer-content student-answer">
                            <em>Tidak dijawab</em>
                        </div>
                        <div class="points-earned zero">0/{{ $maxPoints }} poin</div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- Action Buttons -->
    <div class="action-section">
        <div class="action-buttons">
            <a href="{{ route('student.daily-tests.index') }}" class="btn btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Ulangan
            </a>
            
            <button onclick="window.print()" class="btn btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                </svg>
                Cetak Hasil
            </button>
        </div>
    </div>
</div>

<script>
// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate sections
    const sections = document.querySelectorAll('.result-header, .stat-card, .review-section, .action-section');
    sections.forEach((section, index) => {
        section.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection