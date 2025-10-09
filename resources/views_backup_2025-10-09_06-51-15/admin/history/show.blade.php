@extends('layouts.admin')

@section('title', 'Detail Sejarah - ' . $history->title)

@push('styles')
<style>
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --accent-color: #8b5cf6;
        --accent-hover: #7c3aed;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-tertiary: #94a3b8;
        --border-color: #334155;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    .show-history-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2);
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-info h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .header-info p {
        opacity: 0.9;
        margin: 0;
        font-size: 1.1rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.15s ease;
    }

    .btn-back {
        background: white;
        color: var(--accent-color);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: var(--accent-color);
        text-decoration: none;
    }

    .btn-edit {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
    }

    .btn-edit:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-public {
        background: var(--success-color);
        color: white;
        border: none;
    }

    .btn-public:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
    }

    .main-content {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .card {
        background: var(--bg-primary);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        overflow: hidden;
        box-shadow: 0 2px 8px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .card:hover {
        box-shadow: 0 4px 16px var(--shadow-color);
    }

    .card-header {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    .hero-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 1rem;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-inactive {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .info-item {
        background: var(--bg-secondary);
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .info-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .content-text {
        line-height: 1.7;
        color: var(--text-primary);
        white-space: pre-wrap;
    }

    .timeline-item {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        border-color: var(--accent-color);
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);
    }

    .timeline-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
    }

    .timeline-icon.primary { background: var(--accent-color); }
    .timeline-icon.success { background: var(--success-color); }
    .timeline-icon.warning { background: var(--warning-color); }
    .timeline-icon.danger { background: var(--danger-color); }
    .timeline-icon.info { background: #06b6d4; }

    .timeline-content h4 {
        margin: 0 0 0.25rem 0;
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .timeline-year {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .timeline-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .milestone-item {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .milestone-item:hover {
        border-color: var(--accent-color);
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);
    }

    .milestone-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .milestone-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .milestone-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .milestone-year {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-left: auto;
    }

    .milestone-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .achievement-item {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .achievement-item:hover {
        border-color: var(--accent-color);
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);
    }

    .achievement-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .achievement-icon {
        width: 2rem;
        height: 2rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .achievement-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        flex: 1;
    }

    .achievement-badges {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .achievement-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .achievement-badge.level {
        background: rgba(139, 92, 246, 0.1);
        color: var(--accent-hover);
    }

    .achievement-badge.category {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .achievement-year {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-left: 0.5rem;
    }

    .achievement-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.5;
    }

    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 3rem;
        height: 3rem;
        background: var(--bg-secondary);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--text-tertiary);
    }

    .empty-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-message {
        font-size: 0.875rem;
        line-height: 1.5;
    }

    @media (max-width: 768px) {
        .show-history-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .header-info h1 {
            font-size: 1.5rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .timeline-item {
            flex-direction: column;
            gap: 0.75rem;
        }

        .timeline-icon {
            align-self: flex-start;
        }
    }
</style>
@endpush

@section('content')
<div class="show-history-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1>
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $history->title }}
                </h1>
                <p>Detail lengkap sejarah sekolah dan dokumentasi perjalanan institusi</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.history.index') }}" class="btn btn-back">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.history.edit', $history) }}" class="btn btn-edit">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit
                </a>
                @if($history->is_active)
                    <a href="{{ route('about.sejarah') }}" target="_blank" class="btn btn-public">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Publik
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Content Section -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Konten Sejarah
                    </h2>
                </div>
                <div class="card-body">
                    <div class="content-text">{{ $history->content }}</div>
                </div>
            </div>

            <!-- Timeline Events -->
            @if($history->timeline_events && count($history->timeline_events) > 0)
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Timeline Peristiwa ({{ count($history->timeline_events) }})
                        </h2>
                    </div>
                    <div class="card-body">
                        @foreach($history->timeline_events_formatted as $event)
                            <div class="timeline-item">
                                <div class="timeline-icon {{ $event['color'] }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div class="timeline-content">
                                    <div class="timeline-year">{{ $event['year'] }}</div>
                                    <h4>{{ $event['title'] }}</h4>
                                    @if($event['description'])
                                        <div class="timeline-description">{{ $event['description'] }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Milestones -->
            @if($history->milestones && count($history->milestones) > 0)
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Tonggak Sejarah ({{ count($history->milestones) }})
                        </h2>
                    </div>
                    <div class="card-body">
                        @foreach($history->milestones_formatted as $milestone)
                            <div class="milestone-item">
                                <div class="milestone-header">
                                    <div class="milestone-icon {{ $milestone['color'] }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                        </svg>
                                    </div>
                                    <h4 class="milestone-title">{{ $milestone['title'] }}</h4>
                                    <span class="milestone-year">{{ $milestone['year'] }}</span>
                                </div>
                                @if($milestone['description'])
                                    <div class="milestone-description">{{ $milestone['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Achievements -->
            @if($history->achievements && count($history->achievements) > 0)
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            Prestasi Bersejarah ({{ count($history->achievements) }})
                        </h2>
                    </div>
                    <div class="card-body">
                        @foreach($history->achievements_formatted as $achievement)
                            <div class="achievement-item">
                                <div class="achievement-header">
                                    <div class="achievement-icon {{ $achievement['color'] }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                        </svg>
                                    </div>
                                    <h4 class="achievement-title">{{ $achievement['title'] }}</h4>
                                    <div class="achievement-badges">
                                        <span class="achievement-badge level">{{ $achievement['level'] }}</span>
                                        <span class="achievement-badge category">{{ $achievement['category'] }}</span>
                                        <span class="achievement-year">{{ $achievement['year'] }}</span>
                                    </div>
                                </div>
                                @if($achievement['description'])
                                    <div class="achievement-description">{{ $achievement['description'] }}</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Status & Info -->
            <div class="card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi
                    </h2>
                </div>
                <div class="card-body">
                    <div class="status-badge {{ $history->is_active ? 'status-active' : 'status-inactive' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @if($history->is_active)
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            @else
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            @endif
                        </svg>
                        {{ $history->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </div>

                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Timeline</div>
                            <div class="info-value">{{ count($history->timeline_events ?? []) }} Peristiwa</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Tonggak</div>
                            <div class="info-value">{{ count($history->milestones ?? []) }} Item</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Prestasi</div>
                            <div class="info-value">{{ count($history->achievements ?? []) }} Item</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Dibuat</div>
                            <div class="info-value">{{ $history->created_at->format('d M Y') }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Diperbarui</div>
                            <div class="info-value">{{ $history->updated_at->format('d M Y') }}</div>
                        </div>
                        @if($history->creator)
                            <div class="info-item">
                                <div class="info-label">Dibuat Oleh</div>
                                <div class="info-value">{{ $history->creator->name }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            @if($history->hero_image)
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Gambar Hero
                        </h2>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset($history->hero_image) }}" alt="Hero Image" class="hero-image">
                    </div>
                </div>
            @endif

            <!-- Hero Content -->
            @if($history->hero_title || $history->hero_subtitle)
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            Konten Hero
                        </h2>
                    </div>
                    <div class="card-body">
                        @if($history->hero_title)
                            <div class="info-item">
                                <div class="info-label">Judul</div>
                                <div class="info-value">{{ $history->hero_title }}</div>
                            </div>
                        @endif
                        @if($history->hero_subtitle)
                            <div class="info-item" style="margin-top: 1rem;">
                                <div class="info-label">Subjudul</div>
                                <div class="info-value">{{ $history->hero_subtitle }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- SEO Info -->
            @if($history->meta_title || $history->meta_description)
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            SEO
                        </h2>
                    </div>
                    <div class="card-body">
                        @if($history->meta_title)
                            <div class="info-item">
                                <div class="info-label">Meta Title</div>
                                <div class="info-value">{{ $history->meta_title }}</div>
                            </div>
                        @endif
                        @if($history->meta_description)
                            <div class="info-item" style="margin-top: 1rem;">
                                <div class="info-label">Meta Description</div>
                                <div class="info-value">{{ $history->meta_description }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection