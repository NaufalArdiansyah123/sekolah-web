@extends('layouts.student')

@section('title', 'Detail Ulangan Harian')

@section('content')
<style>
    /* Student Daily Test Detail Styles with Dark Mode Support */
    .test-detail-container {
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
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
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

    /* Test Info Card */
    .test-info-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .test-info-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
        border-radius: 16px 16px 0 0;
    }

    .test-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .test-title-section h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
        transition: color 0.3s ease;
    }

    .test-subject {
        display: inline-block;
        background: #3b82f6;
        color: white;
        padding: 0.375rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .test-status-section {
        text-align: right;
    }

    .status-badge {
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .status-badge.available {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .status-badge.completed {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.2);
    }

    .status-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.expired {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .test-score {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin-top: 0.5rem;
    }

    .test-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 2rem;
        font-size: 1rem;
    }

    /* Test Meta Grid */
    .test-meta-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .meta-item {
        background: var(--bg-secondary);
        padding: 1.25rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        text-align: center;
    }

    .meta-item:hover {
        background: var(--bg-tertiary);
        transform: translateY(-2px);
    }

    .meta-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: #3b82f6;
    }

    .dark .meta-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    .meta-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .meta-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Instructions Section */
    .instructions-section {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
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
        color: #3b82f6;
    }

    .instructions-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .instructions-list li {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .instructions-list li:hover {
        background: var(--bg-tertiary);
    }

    .instruction-number {
        background: #3b82f6;
        color: white;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.75rem;
        flex-shrink: 0;
    }

    .instruction-text {
        color: var(--text-primary);
        line-height: 1.6;
        transition: color 0.3s ease;
    }

    /* Action Buttons */
    .action-section {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
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

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* Timer Display */
    .timer-display {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        font-size: 1.125rem;
        font-weight: 600;
        text-align: center;
        margin-bottom: 1.5rem;
        display: none;
    }

    .timer-display.active {
        display: block;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
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
        .test-detail-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .test-info-card,
        .instructions-section,
        .action-section {
            padding: 1.5rem;
        }

        .test-header {
            flex-direction: column;
            text-align: center;
        }

        .test-status-section {
            text-align: center;
        }

        .test-meta-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn {
            justify-content: center;
        }
    }

    /* Animation */
    .test-info-card,
    .instructions-section,
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

<div class="test-detail-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Detail Ulangan Harian
            </h1>
            <p class="page-subtitle">
                Informasi lengkap tentang ulangan harian yang akan atau sudah dikerjakan
            </p>
            <a href="{{ route('student.daily-tests.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Test Info Card -->
    <div class="test-info-card">
        <div class="test-header">
            <div class="test-title-section">
                <h1>{{ $test->title }}</h1>
                <span class="test-subject">{{ ucfirst(str_replace('_', ' ', $test->subject)) }}</span>
            </div>
            
            <div class="test-status-section">
                @php
                    $userAttempt = $test->attempts->where('user_id', auth()->id())->first();
                    $status = 'available';
                    $score = null;
                    
                    if ($userAttempt) {
                        if ($userAttempt->completed_at) {
                            $status = 'completed';
                            $score = $userAttempt->score;
                        } else {
                            $status = 'pending';
                        }
                    } elseif ($test->scheduled_at && $test->scheduled_at->addMinutes($test->duration)->isPast()) {
                        $status = 'expired';
                    }
                @endphp
                
                <div class="status-badge {{ $status }}">
                    @if($status == 'available')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Tersedia
                    @elseif($status == 'completed')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Selesai
                    @elseif($status == 'pending')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Sedang Dikerjakan
                    @elseif($status == 'expired')
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Berakhir
                    @endif
                </div>
                
                @if($score !== null)
                    <div class="test-score">{{ number_format($score, 1) }}</div>
                @endif
            </div>
        </div>
        
        @if($test->description)
            <div class="test-description">
                {{ $test->description }}
            </div>
        @endif
        
        <!-- Test Meta Information -->
        <div class="test-meta-grid">
            <div class="meta-item">
                <div class="meta-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="meta-value">{{ $test->duration }} menit</div>
                <div class="meta-label">Durasi</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="meta-value">{{ $test->questions_count ?? 0 }}</div>
                <div class="meta-label">Jumlah Soal</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 13a2 2 0 002 2h6a2 2 0 002-2L16 7"/>
                    </svg>
                </div>
                <div class="meta-value">Kelas {{ $test->class }}</div>
                <div class="meta-label">Target Kelas</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 13a2 2 0 002 2h6a2 2 0 002-2L16 7"/>
                    </svg>
                </div>
                <div class="meta-value">{{ $test->scheduled_at ? $test->scheduled_at->format('d/m/Y H:i') : 'Belum dijadwalkan' }}</div>
                <div class="meta-label">Jadwal</div>
            </div>
        </div>
    </div>

    <!-- Instructions Section -->
    <div class="instructions-section">
        <h3 class="section-title">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Petunjuk Pengerjaan
        </h3>
        
        <ul class="instructions-list">
            <li>
                <div class="instruction-number">1</div>
                <div class="instruction-text">
                    Pastikan koneksi internet Anda stabil sebelum memulai ulangan.
                </div>
            </li>
            <li>
                <div class="instruction-number">2</div>
                <div class="instruction-text">
                    Waktu pengerjaan adalah <strong>{{ $test->duration }} menit</strong> dan akan berjalan otomatis setelah Anda memulai.
                </div>
            </li>
            <li>
                <div class="instruction-number">3</div>
                <div class="instruction-text">
                    Jawab semua soal dengan teliti. Anda dapat mengubah jawaban sebelum waktu habis.
                </div>
            </li>
            <li>
                <div class="instruction-number">4</div>
                <div class="instruction-text">
                    Jangan menutup browser atau refresh halaman selama mengerjakan ulangan.
                </div>
            </li>
            <li>
                <div class="instruction-number">5</div>
                <div class="instruction-text">
                    Klik "Selesai" untuk mengumpulkan jawaban atau jawaban akan otomatis terkumpul saat waktu habis.
                </div>
            </li>
            <li>
                <div class="instruction-number">6</div>
                <div class="instruction-text">
                    Setelah mengumpulkan, Anda dapat melihat hasil dan pembahasan (jika tersedia).
                </div>
            </li>
        </ul>
    </div>

    <!-- Timer Display (for ongoing test) -->
    @if($status == 'pending')
        <div class="timer-display active" id="timerDisplay">
            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Sisa Waktu: <span id="timeRemaining">{{ $test->duration }}:00</span>
        </div>
    @endif

    <!-- Action Section -->
    <div class="action-section">
        <div class="action-buttons">
            @if($status == 'available')
                <a href="{{ route('student.daily-tests.start', $test->id) }}" class="btn btn-primary" onclick="return confirmStart()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mulai Ulangan
                </a>
            @elseif($status == 'pending')
                <a href="{{ route('student.daily-tests.continue', $userAttempt->id) }}" class="btn btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Lanjutkan Ulangan
                </a>
            @elseif($status == 'completed')
                <a href="{{ route('student.daily-tests.result', $userAttempt->id) }}" class="btn btn-success">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Lihat Hasil & Pembahasan
                </a>
            @else
                <button class="btn btn-secondary" disabled>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Ulangan Tidak Tersedia
                </button>
            @endif
            
            <a href="{{ route('student.daily-tests.index') }}" class="btn btn-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>

<script>
// Confirm before starting test
function confirmStart() {
    return confirm('Apakah Anda yakin ingin memulai ulangan? Waktu akan berjalan otomatis setelah Anda memulai.');
}

// Timer functionality for ongoing tests
@if($status == 'pending' && $userAttempt)
    let timeRemaining = {{ $test->duration * 60 - (now()->diffInSeconds($userAttempt->started_at)) }};
    
    function updateTimer() {
        if (timeRemaining <= 0) {
            // Time's up, redirect to submit
            window.location.href = "{{ route('student.daily-tests.submit', $userAttempt->id) }}";
            return;
        }
        
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        
        document.getElementById('timeRemaining').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        
        timeRemaining--;
    }
    
    // Update timer every second
    setInterval(updateTimer, 1000);
    updateTimer(); // Initial call
@endif

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate sections
    const sections = document.querySelectorAll('.test-info-card, .instructions-section, .action-section');
    sections.forEach((section, index) => {
        section.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection