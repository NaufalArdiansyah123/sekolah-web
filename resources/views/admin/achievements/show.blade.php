@extends('layouts.admin')

@section('title', 'Detail Prestasi')
@section('page-title', 'Detail Prestasi')

@section('content')
<style>
    /* Enhanced Dark Mode Compatible Detail Styles */
    :root {
        /* Light Mode Colors */
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --border-hover: #cbd5e1;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --shadow-hover: rgba(0, 0, 0, 0.15);
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
        --success-color: #10b981;
        --success-hover: #059669;
        --warning-color: #f59e0b;
        --warning-hover: #d97706;
        --danger-color: #ef4444;
        --danger-hover: #dc2626;
        --info-color: #06b6d4;
        --info-hover: #0891b2;
    }

    /* Dark Mode Colors */
    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #334155;
        --border-hover: #475569;
        --shadow-color: rgba(0, 0, 0, 0.3);
        --shadow-hover: rgba(0, 0, 0, 0.4);
        --accent-color: #3b82f6;
        --accent-hover: #60a5fa;
        --success-color: #10b981;
        --success-hover: #34d399;
        --warning-color: #f59e0b;
        --warning-hover: #fbbf24;
        --danger-color: #ef4444;
        --danger-hover: #f87171;
        --info-color: #06b6d4;
        --info-hover: #22d3ee;
    }

    /* Base Layout */
    .detail-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: background-color 0.3s ease;
    }

    /* Enhanced Header */
    .detail-header {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .detail-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), var(--info-color));
    }

    .detail-header:hover {
        box-shadow: 0 10px 15px -3px var(--shadow-hover);
        transform: translateY(-1px);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .header-info {
        flex: 1;
    }

    .detail-title {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0 0 1rem 0;
        line-height: 1.2;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .detail-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: var(--bg-secondary);
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-secondary);
    }

    .meta-icon {
        width: 1rem;
        height: 1rem;
        color: var(--accent-color);
    }

    .detail-badges {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .detail-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .badge-featured {
        background: linear-gradient(135deg, #fbbf24, #f59e0b);
        color: white;
        box-shadow: 0 4px 14px rgba(251, 191, 36, 0.3);
    }

    .badge-active {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    }

    .badge-inactive {
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        box-shadow: 0 4px 14px rgba(107, 114, 128, 0.3);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* Enhanced Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        align-items: start;
    }

    .main-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .sidebar-content {
        position: sticky;
        top: 2rem;
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    /* Enhanced Content Cards */
    .content-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .content-card:hover {
        box-shadow: 0 10px 15px -3px var(--shadow-hover);
        transform: translateY(-2px);
    }

    .card-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-secondary);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body {
        padding: 2rem;
    }

    /* Enhanced Image Display */
    .achievement-image {
        width: 100%;
        border-radius: 12px;
        box-shadow: 0 8px 25px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .achievement-image:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 35px var(--shadow-hover);
    }

    .image-placeholder {
        width: 100%;
        height: 300px;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 4rem;
    }

    /* Enhanced Description */
    .description-content {
        font-size: 1.125rem;
        line-height: 1.8;
        color: var(--text-primary);
    }

    .description-content p {
        margin-bottom: 1.5rem;
    }

    .description-content p:last-child {
        margin-bottom: 0;
    }

    /* Enhanced Details Grid */
    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
    }

    .detail-item:hover {
        background: var(--bg-tertiary);
        transform: translateY(-2px);
    }

    .detail-item-icon {
        width: 3rem;
        height: 3rem;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
    }

    .detail-item-label {
        font-size: 0.75rem;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.5rem;
        font-weight: 600;
    }

    .detail-item-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
    }

    /* Enhanced Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--accent-hover), var(--accent-color));
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(59, 130, 246, 0.4);
    }

    .btn-warning {
        background: linear-gradient(135deg, var(--warning-color), var(--warning-hover));
        color: white;
        box-shadow: 0 4px 14px 0 rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        background: linear-gradient(135deg, var(--warning-hover), var(--warning-color));
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(245, 158, 11, 0.4);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success-color), var(--success-hover));
        color: white;
        box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, var(--success-hover), var(--success-color));
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(16, 185, 129, 0.4);
    }

    .btn-danger {
        background: linear-gradient(135deg, var(--danger-color), var(--danger-hover));
        color: white;
        box-shadow: 0 4px 14px 0 rgba(239, 68, 68, 0.3);
    }

    .btn-danger:hover {
        background: linear-gradient(135deg, var(--danger-hover), var(--danger-color));
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(239, 68, 68, 0.4);
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-hover);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
        border-color: var(--border-hover);
    }

    /* Enhanced Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    /* Enhanced Timeline */
    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(180deg, var(--accent-color), var(--info-color));
    }

    .timeline-item {
        position: relative;
        margin-bottom: 2rem;
        padding-left: 2rem;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -0.5rem;
        top: 0.5rem;
        width: 1rem;
        height: 1rem;
        background: var(--accent-color);
        border-radius: 50%;
        border: 3px solid var(--bg-primary);
        box-shadow: 0 0 0 3px var(--accent-color);
    }

    .timeline-content {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
    }

    .timeline-title {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .timeline-text {
        color: var(--text-secondary);
        margin: 0;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .sidebar-content {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .detail-page {
            padding: 1rem;
        }

        .detail-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .detail-title {
            font-size: 2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }
    }

    /* Dark mode specific adjustments */
    .dark .content-card {
        background: var(--bg-tertiary);
    }

    .dark .card-header {
        background: var(--bg-secondary);
    }

    .dark .detail-item {
        background: var(--bg-tertiary);
    }

    .dark .timeline-content {
        background: var(--bg-tertiary);
    }

    /* Accessibility improvements */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Focus states for accessibility */
    .btn:focus {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .content-card,
        .btn {
            border-width: 2px;
        }
    }
</style>

<div class="detail-page">
    <!-- Enhanced Header -->
    <div class="detail-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="detail-title">{{ $achievement->title }}</h1>
                
                <div class="detail-meta">
                    <div class="meta-item">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        {{ $achievement->category_formatted }}
                    </div>
                    <div class="meta-item">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                        {{ $achievement->level_formatted }}
                    </div>
                    <div class="meta-item">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m-6 2h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        </svg>
                        {{ $achievement->year }}
                    </div>
                    @if($achievement->achievement_date)
                    <div class="meta-item">
                        <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 12v-2m-6 2h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                        </svg>
                        {{ $achievement->achievement_date->format('d M Y') }}
                    </div>
                    @endif
                </div>
                
                <div class="detail-badges">
                    @if($achievement->is_featured)
                        <span class="detail-badge badge-featured">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Unggulan
                        </span>
                    @endif
                    <span class="detail-badge {{ $achievement->is_active ? 'badge-active' : 'badge-inactive' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        {{ $achievement->is_active ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
            
            <div class="header-actions">
                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-warning">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('public.achievements.show', $achievement) }}" target="_blank" class="btn btn-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Public
                </a>
                <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Content Grid -->
    <div class="content-grid">
        <div class="main-content">
            <!-- Image Card -->
            @if($achievement->image)
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Gambar Prestasi
                    </h3>
                </div>
                <div class="card-body">
                    <img src="{{ asset($achievement->image) }}" alt="{{ $achievement->title }}" class="achievement-image">
                </div>
            </div>
            @endif

            <!-- Description Card -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Deskripsi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="description-content">
                        {!! nl2br(e($achievement->description)) !!}
                    </div>
                </div>
            </div>

            <!-- Additional Information Card -->
            @if($achievement->additional_info)
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Tambahan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="description-content">
                        {!! nl2br(e($achievement->additional_info)) !!}
                    </div>
                </div>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4"/>
                        </svg>
                        Aksi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <button type="button" class="btn btn-success" onclick="toggleStatus({{ $achievement->id }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                            </svg>
                            Toggle Status
                        </button>
                        <button type="button" class="btn btn-danger" onclick="deleteAchievement({{ $achievement->id }}, '{{ $achievement->title }}')">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Prestasi
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="sidebar-content">
            <!-- Details Card -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Detail Prestasi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="details-grid">
                        @if($achievement->organizer)
                        <div class="detail-item">
                            <div class="detail-item-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div class="detail-item-label">Penyelenggara</div>
                            <div class="detail-item-value">{{ $achievement->organizer }}</div>
                        </div>
                        @endif

                        @if($achievement->participant)
                        <div class="detail-item">
                            <div class="detail-item-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="detail-item-label">Peserta</div>
                            <div class="detail-item-value">{{ $achievement->participant }}</div>
                        </div>
                        @endif

                        @if($achievement->position)
                        <div class="detail-item">
                            <div class="detail-item-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                            <div class="detail-item-label">Posisi</div>
                            <div class="detail-item-value">{{ $achievement->position_formatted }}</div>
                        </div>
                        @endif

                        <div class="detail-item">
                            <div class="detail-item-icon">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </div>
                            <div class="detail-item-label">Urutan</div>
                            <div class="detail-item-value">{{ $achievement->sort_order ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SEO Information -->
            @if($achievement->meta_title || $achievement->meta_description)
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        SEO Information
                    </h3>
                </div>
                <div class="card-body">
                    @if($achievement->meta_title)
                    <div class="mb-3">
                        <div class="detail-item-label">Meta Title</div>
                        <div class="detail-item-value">{{ $achievement->meta_title }}</div>
                    </div>
                    @endif
                    
                    @if($achievement->meta_description)
                    <div>
                        <div class="detail-item-label">Meta Description</div>
                        <div class="detail-item-value">{{ $achievement->meta_description }}</div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Timeline -->
            <div class="content-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Prestasi Dibuat</div>
                                <div class="timeline-text">{{ $achievement->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @if($achievement->updated_at != $achievement->created_at)
                        <div class="timeline-item">
                            <div class="timeline-content">
                                <div class="timeline-title">Terakhir Diperbarui</div>
                                <div class="timeline-text">{{ $achievement->updated_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Enhanced JavaScript functionality
function toggleStatus(id) {
    if (confirm('Ubah status prestasi ini?')) {
        fetch(`/admin/achievements/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification('Status prestasi berhasil diubah!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Gagal mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengubah status', 'error');
        });
    }
}

function deleteAchievement(id, title) {
    if (confirm(`Apakah Anda yakin ingin menghapus "${title}"? Tindakan ini tidak dapat dibatalkan.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/achievements/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        ${type === 'success' ? 'background: linear-gradient(135deg, #10b981, #059669);' : 
          type === 'error' ? 'background: linear-gradient(135deg, #ef4444, #dc2626);' : 
          'background: linear-gradient(135deg, #3b82f6, #2563eb);'}
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove notification
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 3000);
}

// Enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // E for edit
        if (e.key === 'e' || e.key === 'E') {
            const editBtn = document.querySelector('a[href*="edit"]');
            if (editBtn) editBtn.click();
        }
        
        // Escape to go back
        if (e.key === 'Escape') {
            const backBtn = document.querySelector('a[href*="index"]');
            if (backBtn) window.location.href = backBtn.href;
        }
    });
    
    // Enhanced image interactions
    const achievementImage = document.querySelector('.achievement-image');
    if (achievementImage) {
        achievementImage.addEventListener('click', function() {
            // Create modal for full-size image
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                cursor: pointer;
            `;
            
            const img = document.createElement('img');
            img.src = this.src;
            img.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                border-radius: 12px;
                box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            `;
            
            modal.appendChild(img);
            document.body.appendChild(modal);
            
            modal.addEventListener('click', function() {
                document.body.removeChild(modal);
            });
        });
    }
});

// Dark mode detection and handling
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark');
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (e.matches) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
</script>
@endsection