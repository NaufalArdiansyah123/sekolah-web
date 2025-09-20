@extends('layouts.student')

@section('title', 'Ulangan Harian')

@section('content')
<style>
    /* Student Daily Tests Styles with Dark Mode Support */
    .daily-tests-container {
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

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-item {
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

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 14px 14px 0 0;
    }

    .stat-item.available::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-item.completed::before { background: linear-gradient(90deg, #059669, #10b981); }
    .stat-item.pending::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-item.average::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .stat-item:hover {
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
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .stat-title {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    /* Filter Section */
    .filter-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 1rem 1.5rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: var(--bg-primary);
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .filter-tab::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(59, 130, 246, 0.1), transparent);
        transition: left 0.5s;
    }

    .filter-tab:hover::before {
        left: 100%;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        background: rgba(59, 130, 246, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
        text-decoration: none;
    }

    .dark .filter-tab.active,
    .dark .filter-tab:hover {
        background: rgba(59, 130, 246, 0.2);
        color: #60a5fa;
        border-color: #60a5fa;
    }

    .filter-tab .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        background: var(--bg-secondary);
        color: var(--text-secondary);
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .filter-tab.active .badge {
        background: #3b82f6;
        color: white;
    }

    .dark .filter-tab.active .badge {
        background: #60a5fa;
        color: #1e293b;
    }

    /* Test Cards */
    .tests-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .test-card {
        background: var(--bg-primary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 12px var(--shadow-color);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .test-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .test-card-header {
        padding: 1.5rem;
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
        position: relative;
    }

    .test-card-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6, #1d4ed8);
    }

    .test-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 0.5rem 0;
        transition: color 0.3s ease;
    }

    .test-subject {
        display: inline-block;
        background: #3b82f6;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .test-card-body {
        padding: 1.5rem;
    }

    .test-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .meta-item svg {
        color: #3b82f6;
    }

    .test-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .test-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
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
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    .test-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-test {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--bg-secondary);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--text-tertiary);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-message {
        margin-bottom: 2rem;
        line-height: 1.6;
        color: var(--text-secondary);
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
        .daily-tests-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .filter-tabs {
            flex-direction: column;
        }

        .tests-grid {
            grid-template-columns: 1fr;
        }

        .test-meta {
            grid-template-columns: 1fr;
        }

        .test-actions {
            flex-direction: column;
        }
    }

    /* Animation */
    .test-card {
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

<div class="daily-tests-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Ulangan Harian
            </h1>
            <p class="page-subtitle">
                Kerjakan ulangan harian yang telah diberikan oleh guru - {{ $dailyTests->count() ?? 0 }} ulangan tersedia
            </p>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item available">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['available'] ?? 0 }}</div>
            <div class="stat-title">Ulangan Tersedia</div>
        </div>

        <div class="stat-item completed">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
            <div class="stat-title">Sudah Dikerjakan</div>
        </div>

        <div class="stat-item pending">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
            <div class="stat-title">Belum Dikerjakan</div>
        </div>

        <div class="stat-item average">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="stat-value">{{ number_format($stats['average'] ?? 0, 1) }}</div>
            <div class="stat-title">Rata-rata Nilai</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="{{ route('student.daily-tests.index') }}" 
               class="filter-tab {{ !request('status') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Semua 
                <span class="badge">{{ $dailyTests->count() ?? 0 }}</span>
            </a>
            <a href="{{ route('student.daily-tests.index', ['status' => 'available']) }}" 
               class="filter-tab {{ request('status') == 'available' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Tersedia
                <span class="badge">{{ $stats['available'] ?? 0 }}</span>
            </a>
            <a href="{{ route('student.daily-tests.index', ['status' => 'completed']) }}" 
               class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Selesai
                <span class="badge">{{ $stats['completed'] ?? 0 }}</span>
            </a>
            <a href="{{ route('student.daily-tests.index', ['status' => 'pending']) }}" 
               class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Belum Dikerjakan
                <span class="badge">{{ $stats['pending'] ?? 0 }}</span>
            </a>
        </div>
    </div>

    <!-- Daily Tests Grid -->
    @if($dailyTests->count() > 0)
        <div class="tests-grid">
            @foreach($dailyTests as $test)
                <div class="test-card">
                    <div class="test-card-header">
                        <h3 class="test-title">{{ $test->title }}</h3>
                        <span class="test-subject">{{ ucfirst(str_replace('_', ' ', $test->subject)) }}</span>
                    </div>
                    
                    <div class="test-card-body">
                        <div class="test-meta">
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $test->duration }} menit</span>
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $test->questions_count ?? 0 }} soal</span>
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 13a2 2 0 002 2h6a2 2 0 002-2L16 7"/>
                                </svg>
                                <span>Kelas {{ $test->class }}</span>
                            </div>
                            <div class="meta-item">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0h6m-6 0l-2 13a2 2 0 002 2h6a2 2 0 002-2L16 7"/>
                                </svg>
                                <span>{{ $test->scheduled_at ? $test->scheduled_at->format('d/m/Y') : 'Belum dijadwalkan' }}</span>
                            </div>
                        </div>
                        
                        @if($test->description)
                            <div class="test-description">
                                {{ Str::limit($test->description, 120) }}
                            </div>
                        @endif
                        
                        <div class="test-status">
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
                            
                            <span class="status-badge {{ $status }}">
                                @if($status == 'available')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Tersedia
                                @elseif($status == 'completed')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Selesai
                                @elseif($status == 'pending')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Sedang Dikerjakan
                                @elseif($status == 'expired')
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Berakhir
                                @endif
                            </span>
                            
                            @if($score !== null)
                                <div class="test-score">{{ number_format($score, 1) }}</div>
                            @endif
                        </div>
                        
                        <div class="test-actions">
                            @if($status == 'available')
                                <a href="{{ route('student.daily-tests.start', $test->id) }}" class="btn-test btn-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Mulai Ulangan
                                </a>
                            @elseif($status == 'pending')
                                <a href="{{ route('student.daily-tests.continue', $userAttempt->id) }}" class="btn-test btn-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1.01M15 10h1.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Lanjutkan
                                </a>
                            @elseif($status == 'completed')
                                <a href="{{ route('student.daily-tests.result', $userAttempt->id) }}" class="btn-test btn-success">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    Lihat Hasil
                                </a>
                            @else
                                <button class="btn-test btn-secondary" disabled>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                    Tidak Tersedia
                                </button>
                            @endif
                            
                            <a href="{{ route('student.daily-tests.show', $test->id) }}" class="btn-test btn-secondary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="empty-title">Belum Ada Ulangan Harian</h3>
            <p class="empty-message">
                @if(request('status'))
                    Tidak ada ulangan dengan status yang dipilih.
                @else
                    Belum ada ulangan harian yang tersedia saat ini. Silakan cek kembali nanti.
                @endif
            </p>
            @if(request('status'))
                <a href="{{ route('student.daily-tests.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Lihat Semua
                </a>
            @endif
        </div>
    @endif
</div>

<script>
// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
    const statCards = document.querySelectorAll('.stat-item');
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animate test cards
    const testCards = document.querySelectorAll('.test-card');
    testCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection