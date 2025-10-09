@extends('layouts.admin')

@section('title', 'School Profile Details')

@section('content')
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
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
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
    .profile-detail-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(59, 130, 246, 0.2);
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
        animation: float 8s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: rotate(-15deg) translateY(0px); }
        50% { transform: rotate(-15deg) translateY(-20px); }
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

    .header-info {
        flex: 1;
    }

    .page-title {
        font-size: 2.25rem;
        font-weight: 800;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1.125rem;
        opacity: 0.9;
        margin: 0 0 1rem 0;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.2);
        border-color: rgba(16, 185, 129, 0.3);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
        flex-wrap: wrap;
    }

    /* Buttons */
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

    .btn-primary {
        background: var(--accent-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-success {
        background: var(--success-color);
        color: white;
    }

    .btn-success:hover {
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
    }

    /* Cards */
    .detail-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .card-header {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Info Items */
    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-item:hover {
        background: var(--bg-secondary);
        margin: 0 -1.5rem;
        padding: 1rem 1.5rem;
        border-radius: 8px;
    }

    .info-icon {
        width: 2.5rem;
        height: 2.5rem;
        background: var(--accent-color);
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .info-content {
        flex: 1;
    }

    .info-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .info-value {
        color: var(--text-secondary);
        line-height: 1.5;
        margin: 0;
    }

    /* Image Display */
    .image-display {
        text-align: center;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .image-display img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .image-label {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-top: 0.5rem;
    }

    /* Statistics Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-item {
        background: var(--bg-secondary);
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        border: 1px solid var(--border-color);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--accent-color);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Facilities Grid */
    .facilities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .facility-item {
        background: var(--bg-secondary);
        padding: 1rem;
        border-radius: 12px;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .facility-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .facility-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.75rem;
        color: white;
        font-size: 1.25rem;
    }

    .facility-icon.primary { background: var(--accent-color); }
    .facility-icon.success { background: var(--success-color); }
    .facility-icon.warning { background: var(--warning-color); }
    .facility-icon.danger { background: var(--danger-color); }
    .facility-icon.info { background: #06b6d4; }
    .facility-icon.purple { background: #8b5cf6; }

    .facility-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
    }

    .facility-description {
        color: var(--text-secondary);
        font-size: 0.75rem;
        line-height: 1.4;
    }

    /* Badges */
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
    .badge-a { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-b { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .badge-c { background: rgba(239, 68, 68, 0.1); color: #dc2626; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 3rem;
        height: 3rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--text-tertiary);
    }

    .empty-message {
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .profile-detail-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .content-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .facilities-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            width: 100%;
            justify-content: flex-start;
        }
    }

    /* Animations */
    .detail-card {
        animation: slideUp 0.5s ease-out;
    }

    .detail-card:nth-child(1) { animation-delay: 0.1s; }
    .detail-card:nth-child(2) { animation-delay: 0.2s; }
    .detail-card:nth-child(3) { animation-delay: 0.3s; }
    .detail-card:nth-child(4) { animation-delay: 0.4s; }

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

<div class="profile-detail-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                    </svg>
                    {{ $schoolProfile->school_name }}
                </h1>
                <p class="page-subtitle">{{ $schoolProfile->school_motto ?? 'School Profile Details' }}</p>
                <div class="status-badge {{ $schoolProfile->is_active ? 'active' : '' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($schoolProfile->is_active)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        @endif
                    </svg>
                    {{ $schoolProfile->is_active ? 'Active Profile' : 'Inactive Profile' }}
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.school-profile.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to List
                </a>
                <a href="{{ route('admin.school-profile.edit', $schoolProfile) }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Profile
                </a>
                @if($schoolProfile->is_active)
                    <a href="{{ route('about.profile') }}" target="_blank" class="btn btn-success">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        View Public
                    </a>
                @endif
            </div>
        </div>
    </div>

    <div class="content-grid">
        <!-- Main Content -->
        <div>
            <!-- Basic Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Basic Information
                    </h2>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">School Name</div>
                            <p class="info-value">{{ $schoolProfile->school_name }}</p>
                        </div>
                    </div>

                    @if($schoolProfile->school_motto)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">School Motto</div>
                            <p class="info-value">{{ $schoolProfile->school_motto }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->about_description)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">About Description</div>
                            <p class="info-value">{{ $schoolProfile->about_description }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->established_year)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Established Year</div>
                            <p class="info-value">{{ $schoolProfile->established_year }} ({{ date('Y') - $schoolProfile->established_year }} years ago)</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->accreditation)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Accreditation</div>
                            <p class="info-value">
                                <span class="badge badge-{{ strtolower($schoolProfile->accreditation) }}">
                                    {{ $schoolProfile->accreditation }} 
                                    ({{ $schoolProfile->accreditation === 'A' ? 'Excellent' : ($schoolProfile->accreditation === 'B' ? 'Good' : 'Fair') }})
                                </span>
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Vision & Mission -->
            @if($schoolProfile->vision || $schoolProfile->mission || $schoolProfile->history)
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Vision, Mission & History
                    </h2>
                </div>
                <div class="card-body">
                    @if($schoolProfile->vision)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Vision</div>
                            <p class="info-value">{{ $schoolProfile->vision }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->mission)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4a2 2 0 002 2h2a2 2 0 002-2v-4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m0 0V3a2 2 0 00-2-2H9a2 2 0 00-2 2v2z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Mission</div>
                            <p class="info-value">{{ $schoolProfile->mission }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->history)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">History</div>
                            <p class="info-value">{{ $schoolProfile->history }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Contact Information -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact Information
                    </h2>
                </div>
                <div class="card-body">
                    @if($schoolProfile->address)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Alamat</div>
                            <p class="info-value">{{ $schoolProfile->address }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->phone)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Telepon</div>
                            <p class="info-value">{{ $schoolProfile->phone }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->email)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Email</div>
                            <p class="info-value">{{ $schoolProfile->email }}</p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->website)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Website</div>
                            <p class="info-value">
                                <a href="{{ $schoolProfile->website }}" target="_blank" style="color: var(--accent-color); text-decoration: none;">
                                    {{ $schoolProfile->website }}
                                </a>
                            </p>
                        </div>
                    </div>
                    @endif

                    @if($schoolProfile->principal_name)
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Kepala Sekolah</div>
                            <p class="info-value">{{ $schoolProfile->principal_name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Facilities -->
            @if($schoolProfile->facilities && count($schoolProfile->facilities) > 0)
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                        </svg>
                        School Facilities ({{ count($schoolProfile->facilities) }})
                    </h2>
                </div>
                <div class="card-body">
                    <div class="facilities-grid">
                        @foreach($schoolProfile->facilities as $facility)
                        <div class="facility-item">
                            <div class="facility-icon {{ $facility['color'] ?? 'primary' }}">
                                <i class="{{ $facility['icon'] ?? 'fas fa-building' }}"></i>
                            </div>
                            <div class="facility-name">{{ $facility['name'] ?? 'Unnamed Facility' }}</div>
                            @if(isset($facility['description']) && $facility['description'])
                            <div class="facility-description">{{ $facility['description'] }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Statistics -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Statistics
                    </h2>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($schoolProfile->student_count ?? 0) }}</div>
                            <div class="stat-label">Siswa</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($schoolProfile->teacher_count ?? 0) }}</div>
                            <div class="stat-label">Guru</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($schoolProfile->staff_count ?? 0) }}</div>
                            <div class="stat-label">Staf</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ number_format($schoolProfile->industry_partnerships ?? 0) }}</div>
                            <div class="stat-label">Partnerships</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images -->
            @if($schoolProfile->school_logo)
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        School Logo
                    </h2>
                </div>
                <div class="card-body">
                    <div class="image-display">
                        <img src="{{ asset($schoolProfile->school_logo) }}" alt="School Logo">
                        <div class="image-label">School Logo</div>
                    </div>
                </div>
            </div>
            @endif

            @if($schoolProfile->principal_photo)
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Principal Photo
                    </h2>
                </div>
                <div class="card-body">
                    <div class="image-display">
                        <img src="{{ asset($schoolProfile->principal_photo) }}" alt="Principal Photo">
                        <div class="image-label">{{ $schoolProfile->principal_name ?? 'Principal' }}</div>
                    </div>
                </div>
            </div>
            @endif

            @if($schoolProfile->hero_image)
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Hero Image
                    </h2>
                </div>
                <div class="card-body">
                    <div class="image-display">
                        <img src="{{ asset($schoolProfile->hero_image) }}" alt="Hero Image">
                        <div class="image-label">Hero Image</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Profile Status -->
            <div class="detail-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Profile Information
                    </h2>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Created</div>
                            <p class="info-value">{{ $schoolProfile->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Terakhir Diperbarui</div>
                            <p class="info-value">{{ $schoolProfile->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($schoolProfile->is_active)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                @endif
                            </svg>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Status</div>
                            <p class="info-value">
                                <span class="badge badge-{{ $schoolProfile->is_active ? 'active' : 'inactive' }}">
                                    {{ $schoolProfile->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth animations to cards
    const cards = document.querySelectorAll('.detail-card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });

    // Add hover effects to info items
    const infoItems = document.querySelectorAll('.info-item');
    infoItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(5px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endsection