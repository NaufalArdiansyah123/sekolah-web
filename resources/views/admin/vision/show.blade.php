@extends('layouts.admin')

@section('title', 'View Vision & Mission - ' . $vision->title)

@push('styles')
<style>
    /* CSS Variables for Dark Mode */
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

    /* Base Styles */
    .show-vision-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        padding: 2rem;
        border-radius: 16px;
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
        flex: 1;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions {
        position: relative;
        z-index: 2;
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
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: var(--accent-color);
        text-decoration: none;
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.9);
        color: white;
    }

    .btn-edit:hover {
        background: #d97706;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-public {
        background: rgba(16, 185, 129, 0.9);
        color: white;
    }

    .btn-public:hover {
        background: #059669;
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Content Cards */
    .content-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        animation: slideUp 0.5s ease-out;
    }

    .content-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .card-header {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .card-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }

    .card-body {
        padding: 2rem;
        background: var(--bg-primary);
        transition: all 0.3s ease;
    }

    /* Vision Text */
    .vision-text {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary);
        margin-bottom: 2rem;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border-left: 4px solid var(--accent-color);
    }

    /* Dynamic Sections */
    .dynamic-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .items-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1rem;
    }

    .item-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
        border-color: var(--accent-color);
    }

    .item-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .item-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }

    .item-icon.primary { background: var(--accent-color); }
    .item-icon.success { background: var(--success-color); }
    .item-icon.warning { background: var(--warning-color); }
    .item-icon.danger { background: var(--danger-color); }
    .item-icon.info { background: #06b6d4; }

    .item-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .item-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .item-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .item-list li {
        padding: 0.5rem 0;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .item-list li:last-child {
        border-bottom: none;
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 1rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: var(--border-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        transform: translateX(0.5rem);
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -2.5rem;
        top: 1.5rem;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        background: var(--accent-color);
        border: 3px solid var(--bg-primary);
    }

    .timeline-year {
        background: var(--accent-color);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.5rem;
    }

    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .timeline-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 0.5rem;
    }

    .timeline-target {
        background: var(--bg-tertiary);
        padding: 0.75rem;
        border-radius: 8px;
        border-left: 3px solid var(--success-color);
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: capitalize;
        margin-top: 0.5rem;
    }

    .status-badge.planned { background: rgba(107, 114, 128, 0.1); color: #6b7280; }
    .status-badge.in_progress { background: rgba(59, 130, 246, 0.1); color: #2563eb; }
    .status-badge.completed { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .status-badge.delayed { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

    /* Sidebar */
    .sidebar-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 500;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .info-value {
        font-weight: 600;
        color: var(--text-primary);
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: capitalize;
    }

    .badge-active { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-inactive { background: rgba(107, 114, 128, 0.1); color: #6b7280; }

    .hero-image {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .show-vision-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .items-grid {
            grid-template-columns: 1fr;
        }

        .timeline {
            padding-left: 1.5rem;
        }

        .timeline::before {
            left: 0.75rem;
        }

        .timeline-item::before {
            left: -2rem;
        }
    }

    /* Animation */
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
@endpush

@section('content')
<div class="show-vision-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">{{ $vision->title }}</h1>
            <p class="page-subtitle">Vision & Mission Details</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.vision.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
            <a href="{{ route('admin.vision.edit', $vision) }}" class="btn btn-edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit
            </a>
            @if($vision->is_active)
                <a href="{{ route('about.vision') }}" target="_blank" class="btn btn-public">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View Public
                </a>
            @endif
        </div>
    </div>

    <div class="content-grid">
        <!-- Main Content -->
        <div>
            <!-- Vision Statement -->
            <div class="content-card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Vision Statement
                    </h2>
                </div>
                <div class="card-body">
                    <div class="vision-text">
                        {{ $vision->vision_text }}
                    </div>
                </div>
            </div>

            <!-- Mission Items -->
            @if($vision->mission_items && count($vision->mission_items) > 0)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4a2 2 0 002 2h2a2 2 0 002-2v-4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m0 0V3a2 2 0 00-2-2H9a2 2 0 00-2 2v2z"/>
                            </svg>
                            Mission Statements
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="items-grid">
                            @foreach($vision->mission_items as $mission)
                                <div class="item-card">
                                    <div class="item-header">
                                        <div class="item-icon primary">
                                            <i class="{{ $mission['icon'] ?? 'fas fa-bullseye' }}"></i>
                                        </div>
                                        <h4 class="item-title">{{ $mission['title'] }}</h4>
                                    </div>
                                    <div class="item-description">
                                        {{ $mission['description'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Goals -->
            @if($vision->goals && count($vision->goals) > 0)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                            Strategic Goals
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="items-grid">
                            @foreach($vision->goals as $goal)
                                <div class="item-card">
                                    <div class="item-header">
                                        <div class="item-icon {{ $goal['color'] ?? 'primary' }}">
                                            <i class="{{ $goal['icon'] ?? 'fas fa-bullseye' }}"></i>
                                        </div>
                                        <h4 class="item-title">{{ $goal['title'] }}</h4>
                                    </div>
                                    <div class="item-description">
                                        {{ $goal['description'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Values -->
            @if($vision->values && count($vision->values) > 0)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            School Values
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="items-grid">
                            @foreach($vision->values as $value)
                                <div class="item-card">
                                    <div class="item-header">
                                        <div class="item-icon {{ $value['color'] ?? 'primary' }}">
                                            <i class="{{ $value['icon'] ?? 'fas fa-star' }}"></i>
                                        </div>
                                        <h4 class="item-title">{{ $value['title'] }}</h4>
                                    </div>
                                    <div class="item-description">
                                        {{ $value['description'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Focus Areas -->
            @if($vision->focus_areas && count($vision->focus_areas) > 0)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            Strategic Focus Areas
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="items-grid">
                            @foreach($vision->focus_areas as $area)
                                <div class="item-card">
                                    <div class="item-header">
                                        <div class="item-icon {{ $area['color'] ?? 'primary' }}">
                                            <i class="{{ $area['icon'] ?? 'fas fa-bullseye' }}"></i>
                                        </div>
                                        <h4 class="item-title">{{ $area['title'] }}</h4>
                                    </div>
                                    <div class="item-description">
                                        {{ $area['description'] }}
                                    </div>
                                    @if(isset($area['items']) && count($area['items']) > 0)
                                        <ul class="item-list">
                                            @foreach($area['items'] as $item)
                                                <li>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                    {{ $item }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Roadmap -->
            @if($vision->roadmap_phases && count($vision->roadmap_phases) > 0)
                <div class="content-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                            </svg>
                            Development Roadmap 2025-2030
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            @foreach($vision->roadmap_phases as $phase)
                                <div class="timeline-item">
                                    <div class="timeline-year">{{ $phase['year'] ?? 'TBD' }}</div>
                                    <div class="timeline-title">{{ $phase['title'] }}</div>
                                    <div class="timeline-description">{{ $phase['description'] }}</div>
                                    @if(isset($phase['target']) && $phase['target'])
                                        <div class="timeline-target">
                                            <strong>Target:</strong> {{ $phase['target'] }}
                                        </div>
                                    @endif
                                    <div class="status-badge {{ $phase['status'] ?? 'planned' }}">
                                        {{ ucfirst(str_replace('_', ' ', $phase['status'] ?? 'planned')) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Information -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h2>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Information
                    </h2>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <span class="info-label">Status</span>
                        <span class="badge badge-{{ $vision->is_active ? 'active' : 'inactive' }}">
                            {{ $vision->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Created</span>
                        <span class="info-value">{{ $vision->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Last Updated</span>
                        <span class="info-value">{{ $vision->updated_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Mission Items</span>
                        <span class="info-value">{{ $vision->mission_items ? count($vision->mission_items) : 0 }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Goals</span>
                        <span class="info-value">{{ $vision->goals ? count($vision->goals) : 0 }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Values</span>
                        <span class="info-value">{{ $vision->values ? count($vision->values) : 0 }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Focus Areas</span>
                        <span class="info-value">{{ $vision->focus_areas ? count($vision->focus_areas) : 0 }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Roadmap Phases</span>
                        <span class="info-value">{{ $vision->roadmap_phases ? count($vision->roadmap_phases) : 0 }}</span>
                    </div>
                </div>
            </div>

            <!-- Hero Image -->
            @if($vision->hero_image)
                <div class="sidebar-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Hero Image
                        </h2>
                    </div>
                    <div class="card-body">
                        <img src="{{ asset($vision->hero_image) }}" alt="Hero Image" class="hero-image">
                    </div>
                </div>
            @endif

            <!-- SEO Information -->
            @if($vision->meta_title || $vision->meta_description)
                <div class="sidebar-card">
                    <div class="card-header">
                        <h2>
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            SEO Information
                        </h2>
                    </div>
                    <div class="card-body">
                        @if($vision->meta_title)
                            <div class="info-item">
                                <span class="info-label">Meta Title</span>
                                <span class="info-value">{{ $vision->meta_title }}</span>
                            </div>
                        @endif
                        @if($vision->meta_description)
                            <div class="info-item">
                                <span class="info-label">Meta Description</span>
                                <span class="info-value">{{ Str::limit($vision->meta_description, 100) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection