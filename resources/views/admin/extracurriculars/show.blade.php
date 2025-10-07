@extends('layouts.admin')

@section('title', 'Detail Ekstrakurikuler - ' . $extracurricular->name)

@section('content')
<style>
    .extracurricular-container {
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
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: white;
        text-decoration: none;
    }

    .btn-primary {
        background: white;
        color: #3b82f6;
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

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #3b82f6;
        text-decoration: none;
    }

    /* Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    /* Main Content */
    .main-content {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .content-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        animation: slideUp 0.5s ease-out;
    }

    .card-header {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }

    .card-body {
        padding: 2rem;
    }

    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-item {
        background: var(--bg-secondary);
        padding: 1.5rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .info-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .info-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #dbeafe, #bfdbfe);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: #3b82f6;
    }

    .dark .info-icon {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
    }

    /* Description */
    .description-content {
        line-height: 1.7;
        color: var(--text-primary);
        font-size: 1rem;
        transition: color 0.3s ease;
    }

    /* Sidebar */
    .sidebar {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    /* Image Card */
    .image-card {
        text-align: center;
    }

    .extracurricular-image {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .extracurricular-image:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .no-image {
        width: 100%;
        height: 250px;
        background: var(--bg-secondary);
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: var(--text-tertiary);
        transition: all 0.3s ease;
    }

    .no-image-icon {
        width: 48px;
        height: 48px;
        margin-bottom: 1rem;
    }

    .no-image-text {
        font-weight: 500;
        color: var(--text-secondary);
    }

    /* Status Badge */
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge.active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.inactive {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .dark .status-badge.inactive {
        color: #9ca3af;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .stat-item {
        background: var(--bg-secondary);
        padding: 1.25rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        text-align: center;
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 500;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.3s ease;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-edit {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-delete {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        box-shadow: 0 2px 8px rgba(220, 38, 38, 0.3);
    }

    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-outline {
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-outline:hover {
        background: var(--bg-secondary);
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-2px);
        text-decoration: none;
    }

    /* Enhanced Members Section */
    .members-list {
        max-height: 500px;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--border-color) transparent;
    }

    .members-list::-webkit-scrollbar {
        width: 6px;
    }

    .members-list::-webkit-scrollbar-track {
        background: var(--bg-secondary);
        border-radius: 3px;
    }

    .members-list::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 3px;
    }

    .member-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1.25rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
    }

    .member-item:last-child {
        border-bottom: none;
    }

    .member-item:hover {
        background: var(--bg-secondary);
        transform: translateX(5px);
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    .member-number {
        width: 24px;
        height: 24px;
        background: linear-gradient(135deg, #6b7280, #4b5563);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
        flex-shrink: 0;
    }

    .member-avatar {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .member-info {
        flex: 1;
        min-width: 0;
    }

    .member-name {
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
        transition: color 0.3s ease;
    }

    .member-details {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        margin-bottom: 0.5rem;
    }

    .member-class,
    .member-join-date {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .member-reason {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        font-size: 0.8rem;
        color: var(--text-tertiary);
        font-style: italic;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background: var(--bg-secondary);
        border-radius: 8px;
        border-left: 3px solid #3b82f6;
    }

    .member-status-badge {
        flex-shrink: 0;
    }

    .status-active {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    /* Members Summary */
    .members-summary {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid var(--border-color);
    }

    .summary-stats {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: var(--bg-secondary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .summary-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .summary-value {
        font-weight: 700;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .class-badge {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 0.25rem;
    }

    /* Responsive Members */
    @media (max-width: 768px) {
        .member-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .member-details {
            flex-direction: column;
        }

        .summary-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    /* CSS Variables for consistent theming */
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
    @media (max-width: 1024px) {
        .content-grid {
            grid-template-columns: 1fr;
        }

        .sidebar {
            order: -1;
        }
    }

    @media (max-width: 768px) {
        .extracurricular-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
        }

        .header-actions {
            flex-direction: column;
            align-items: center;
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

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    /* Enhanced Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
        background: var(--bg-secondary);
        border-radius: 12px;
        border: 2px dashed var(--border-color);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 1.5rem;
        color: var(--text-tertiary);
        opacity: 0.6;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .empty-message {
        color: var(--text-secondary);
        line-height: 1.6;
        font-size: 0.95rem;
    }
</style>

<div class="extracurricular-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Detail Ekstrakurikuler
            </h1>
            <p class="page-subtitle">{{ $extracurricular->name }}</p>
            <div class="header-actions">
                <a href="{{ route('admin.extracurriculars.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit Ekstrakurikuler
                </a>
            </div>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Main Content -->
        <div class="main-content">
            <!-- Basic Information -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Informasi Dasar
                    </h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                            </div>
                            <div class="info-label">Nama Ekstrakurikuler</div>
                            <div class="info-value">{{ $extracurricular->name }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div class="info-label">Pembina/Pelatih</div>
                            <div class="info-value">{{ $extracurricular->coach }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="info-label">Jadwal Kegiatan</div>
                            <div class="info-value">{{ $extracurricular->jadwal ?? 'Belum ditentukan' }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <span class="status-badge {{ $extracurricular->status == 'active' ? 'active' : 'inactive' }}>
                                    <span class="status-indicator"></span>
                                    {{ ucfirst($extracurricular->status) }}
                                </span>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="info-label">Dibuat Pada</div>
                            <div class="info-value">{{ $extracurricular->created_at->locale('id')->isoFormat('D MMMM Y') }}</div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="info-label">Terakhir Diupdate</div>
                            <div class="info-value">{{ $extracurricular->updated_at->locale('id')->diffForHumans() }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Deskripsi
                    </h2>
                </div>
                <div class="card-body">
                    <div class="description-content">
                        {{ $extracurricular->description }}
                    </div>
                </div>
            </div>

            <!-- Members Section -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Anggota Aktif 
                        <span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; margin-left: 0.5rem;">
                            {{ $extracurricular->registrations->where('status', 'approved')->count() }} Orang
                        </span>
                    </h2>
                </div>
                <div class="card-body">
                    {{-- Debug: Check if registrations are loaded --}}
                    @if(config('app.debug'))
                        <div class="alert alert-info" style="margin-bottom: 1rem; font-size: 0.8rem;">
                            <strong>Debug Info:</strong><br>
                            Total registrations: {{ $extracurricular->registrations->count() }}<br>
                            Approved registrations: {{ $extracurricular->registrations->where('status', 'approved')->count() }}<br>
                            Pending registrations: {{ $extracurricular->registrations->where('status', 'pending')->count() }}<br>
                            @if($extracurricular->registrations->count() > 0)
                                First registration: {{ $extracurricular->registrations->first()->student_name ?? 'No name' }}<br>
                                All registrations: 
                                @foreach($extracurricular->registrations as $reg)
                                    {{ $reg->student_name }} ({{ $reg->status }}), 
                                @endforeach
                            @else
                                <strong style="color: red;">No registrations found!</strong>
                            @endif
                        </div>
                    @endif
                    
                    @if($extracurricular->registrations->where('status', 'approved')->count() > 0)
                        <div class="members-list">
                            @foreach($extracurricular->registrations->where('status', 'approved')->sortBy('student_name') as $index => $registration)
                            <div class="member-item enhanced-member">
                                <div class="member-number">
                                    {{ $index + 1 }}
                                </div>
                                <div class="member-avatar">
                                    {{ strtoupper(substr($registration->student_name, 0, 2)) }}
                                </div>
                                <div class="member-info">
                                    <div class="member-name">{{ $registration->student_name }}</div>
                                    <div class="member-details">
                                        <span class="member-class">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            Kelas {{ $registration->student_class }} {{ $registration->student_major }}
                                        </span>
                                        <span class="member-join-date">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            Bergabung {{ $registration->created_at->locale('id')->isoFormat('D MMM Y') }}
                                        </span>
                                    </div>
                                    @if($registration->reason)
                                        <div class="member-reason">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            "{{ Str::limit($registration->reason, 100) }}"
                                        </div>
                                    @endif
                                </div>
                                <div class="member-status-badge">
                                    <span class="status-active">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Aktif
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Summary Section -->
                        <div class="members-summary">
                            <div class="summary-stats">
                                <div class="summary-item">
                                    <span class="summary-label">Total Anggota Aktif:</span>
                                    <span class="summary-value">{{ $extracurricular->registrations->where('status', 'approved')->count() }} orang</span>
                                </div>
                                @php
                                    $classCounts = $extracurricular->registrations->where('status', 'approved')->groupBy(function($item) {
                                        return $item->student_class . ' ' . $item->student_major;
                                    })->map->count();
                                @endphp
                                @if($classCounts->count() > 0)
                                    <div class="summary-item">
                                        <span class="summary-label">Distribusi Kelas:</span>
                                        <span class="summary-value">
                                            @foreach($classCounts as $kelas => $count)
                                                <span class="class-badge">{{ $kelas }}: {{ $count }}</span>{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 515.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <div class="empty-title">Belum Ada Anggota Aktif</div>
                            <div class="empty-message">
                                Ekstrakurikuler ini belum memiliki anggota yang terdaftar dan disetujui.
                                @if($extracurricular->registrations->where('status', 'pending')->count() > 0)
                                    <br>Ada {{ $extracurricular->registrations->where('status', 'pending')->count() }} pendaftar yang menunggu persetujuan.
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Image -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        Gambar
                    </h2>
                </div>
                <div class="card-body image-card">
                    @if($extracurricular->gambar)
                        <img src="{{ asset('storage/' . $extracurricular->gambar) }}" 
                             alt="{{ $extracurricular->name }}" 
                             class="extracurricular-image"
                             onclick="openImageModal(this.src)">
                    @else
                        <div class="no-image">
                            <svg class="no-image-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <div class="no-image-text">Tidak ada gambar</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistics -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        Statistik
                    </h2>
                </div>
                <div class="card-body">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">{{ $extracurricular->registrations->where('status', 'approved')->count() }}</div>
                            <div class="stat-label">Anggota Aktif</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $extracurricular->registrations->where('status', 'pending')->count() }}</div>
                            <div class="stat-label">Pendaftar Baru</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $extracurricular->registrations->count() }}</div>
                            <div class="stat-label">Total Registrasi</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">{{ $extracurricular->registrations->where('status', 'rejected')->count() }}</div>
                            <div class="stat-label">Ditolak</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100-4m0 4v2m0-6V4"/>
                        </svg>
                        Aksi
                    </h2>
                </div>
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}" class="btn btn-edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </a>
                        
                        
                        <form action="{{ route('admin.extracurriculars.destroy', $extracurricular->id) }}" 
                              method="POST" 
                              class="delete-form"
                              style="width: 100%;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete" style="width: 100%;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin menghapus ekstrakurikuler ini? Tindakan ini tidak dapat dibatalkan.')) {
                e.preventDefault();
            }
        });
    });

    // Auto-hide alerts
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });

    console.log('✅ Extracurricular show page initialized');
});

// Image modal function
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    if (modal && modalImage) {
        modalImage.src = imageSrc;
        
        // Use Bootstrap modal if available
        if (typeof bootstrap !== 'undefined') {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
            $('#imageModal').modal('show');
        } else {
            // Fallback
            modal.style.display = 'block';
            modal.classList.add('show');
        }
    }
}

// Show registrations function (if needed)
function showRegistrations(extracurricularId) {
    // This function can be implemented to show pending registrations
    // Similar to the index page functionality
    window.location.href = `/admin/extracurriculars/${extracurricularId}/registrations`;
}
</script>

@endsection