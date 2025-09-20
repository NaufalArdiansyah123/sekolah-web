@extends('layouts.teacher')

@section('title', 'Ulangan Harian')

@section('content')
<style>
    /* Daily Tests Management Styles with Dark Mode Support */
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

    .header-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-header {
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

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
        text-decoration: none;
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

    .stat-item.total::before { background: linear-gradient(90deg, #059669, #10b981); }
    .stat-item.published::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-item.draft::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-item.completed::before { background: linear-gradient(90deg, #8b5cf6, #7c3aed); }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #059669, #10b981);
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
        background: linear-gradient(90deg, transparent, rgba(5, 150, 105, 0.1), transparent);
        transition: left 0.5s;
    }

    .filter-tab:hover::before {
        left: 100%;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: #059669;
        color: #059669;
        background: rgba(5, 150, 105, 0.05);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(5, 150, 105, 0.15);
        text-decoration: none;
    }

    .dark .filter-tab.active,
    .dark .filter-tab:hover {
        background: rgba(5, 150, 105, 0.2);
        color: #34d399;
        border-color: #34d399;
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
        background: #059669;
        color: white;
    }

    .dark .filter-tab.active .badge {
        background: #34d399;
        color: #1e293b;
    }

    /* Form Controls */
    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #059669;
        box-shadow: 0 0 0 0.2rem rgba(5, 150, 105, 0.25);
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    /* Table Container */
    .table-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--bg-tertiary);
        border-bottom: 1px solid var(--border-color);
    }

    .table-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-wrapper {
        overflow-x: auto;
        width: 100%;
        max-width: 100%;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        min-width: 800px;
    }

    .table thead th {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        font-weight: 600;
        padding: 1rem;
        border: none;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: var(--bg-secondary);
        transform: scale(1.001);
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .status-badge.published {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        border: 1px solid rgba(5, 150, 105, 0.2);
    }

    .status-badge.draft {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.completed {
        background: rgba(139, 92, 246, 0.1);
        color: #7c3aed;
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.375rem;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .btn-action {
        position: relative;
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        overflow: visible;
        backdrop-filter: blur(10px);
    }

    .btn-action::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 8px;
        opacity: 0;
        transition: all 0.3s ease;
        transform: scale(0.8);
    }

    .btn-action:hover::before {
        opacity: 1;
        transform: scale(1);
    }

    .btn-action:hover {
        transform: translateY(-2px) scale(1.05);
        text-decoration: none;
    }

    .btn-action:active {
        transform: translateY(0) scale(0.98);
        transition: all 0.1s ease;
    }

    .btn-action svg {
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
        transition: all 0.3s ease;
    }

    .btn-action:hover svg {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* View Button */
    .btn-view {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(6, 182, 212, 0.25);
    }

    .btn-view:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.35);
    }

    /* Edit Button */
    .btn-edit {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(59, 130, 246, 0.25);
    }

    .btn-edit:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 50%, #1e3a8a 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35);
    }

    /* Publish Button */
    .btn-publish {
        background: linear-gradient(135deg, #059669 0%, #047857 50%, #065f46 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(5, 150, 105, 0.25);
    }

    .btn-publish:hover {
        background: linear-gradient(135deg, #047857 0%, #065f46 50%, #064e3b 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
    }

    /* Delete Button */
    .btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
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

    /* Button Styles */
    .btn-primary {
        background: #059669;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #047857;
        transform: translateY(-1px);
        text-decoration: none;
        color: white;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
        text-decoration: none;
        color: var(--text-primary);
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

        .table-container {
            margin: 0 -1rem;
            border-radius: 0;
        }

        .table {
            min-width: 900px;
        }

        .table thead th,
        .table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }

        .btn-action {
            min-width: 28px;
            height: 28px;
        }
    }

    /* Animation */
    .table-container {
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
                Kelola dan buat ulangan harian untuk siswa - {{ $dailyTests->total() ?? 0 }} total ulangan
            </p>
            <div class="header-actions">
                <a href="{{ route('teacher.daily-tests.create') }}" class="btn-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Ulangan Baru
                </a>
                <a href="{{ route('teacher.daily-tests.analytics') }}" class="btn-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Analitik
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item total">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
            <div class="stat-title">Total Ulangan</div>
        </div>

        <div class="stat-item published">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['published'] ?? 0 }}</div>
            <div class="stat-title">Dipublikasi</div>
        </div>

        <div class="stat-item draft">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['draft'] ?? 0 }}</div>
            <div class="stat-title">Draft</div>
        </div>

        <div class="stat-item completed">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #7c3aed;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
            <div class="stat-title">Selesai</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <a href="{{ route('teacher.daily-tests.index') }}" 
               class="filter-tab {{ !request('status') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                Semua 
                <span class="badge">{{ $stats['total'] ?? 0 }}</span>
            </a>
            <a href="{{ route('teacher.daily-tests.index', ['status' => 'published']) }}" 
               class="filter-tab {{ request('status') == 'published' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Dipublikasi
                <span class="badge">{{ $stats['published'] ?? 0 }}</span>
            </a>
            <a href="{{ route('teacher.daily-tests.index', ['status' => 'draft']) }}" 
               class="filter-tab {{ request('status') == 'draft' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Draft
                <span class="badge">{{ $stats['draft'] ?? 0 }}</span>
            </a>
            <a href="{{ route('teacher.daily-tests.index', ['status' => 'completed']) }}" 
               class="filter-tab {{ request('status') == 'completed' ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Selesai
                <span class="badge">{{ $stats['completed'] ?? 0 }}</span>
            </a>
        </div>
        
        <!-- Search Form -->
        <form method="GET" action="{{ route('teacher.daily-tests.index') }}" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" 
                       placeholder="Cari ulangan..." 
                       value="{{ request('search') }}">
                <input type="hidden" name="status" value="{{ request('status') }}">
            </div>
            <div class="col-md-3">
                <select name="subject" class="form-select">
                    <option value="">Semua Mata Pelajaran</option>
                    <option value="matematika" {{ request('subject') == 'matematika' ? 'selected' : '' }}>Matematika</option>
                    <option value="bahasa_indonesia" {{ request('subject') == 'bahasa_indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                    <option value="bahasa_inggris" {{ request('subject') == 'bahasa_inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                    <option value="ipa" {{ request('subject') == 'ipa' ? 'selected' : '' }}>IPA</option>
                    <option value="ips" {{ request('subject') == 'ips' ? 'selected' : '' }}>IPS</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="class" class="form-select">
                    <option value="">Semua Kelas</option>
                    <option value="7" {{ request('class') == '7' ? 'selected' : '' }}>Kelas 7</option>
                    <option value="8" {{ request('class') == '8' ? 'selected' : '' }}>Kelas 8</option>
                    <option value="9" {{ request('class') == '9' ? 'selected' : '' }}>Kelas 9</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn-primary w-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cari
                </button>
            </div>
        </form>
    </div>

    <!-- Daily Tests Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Daftar Ulangan Harian
                <span class="badge" style="background: #059669; color: white; padding: 0.25rem 0.5rem; border-radius: 6px; font-size: 0.75rem; margin-left: 0.5rem;">{{ $dailyTests->total() ?? 0 }}</span>
            </h3>
        </div>

        @if($dailyTests->count() > 0)
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Judul Ulangan</th>
                            <th style="width: 15%;">Mata Pelajaran</th>
                            <th style="width: 10%;">Kelas</th>
                            <th style="width: 10%;">Durasi</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 15%;">Tanggal</th>
                            <th style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dailyTests as $index => $test)
                            <tr>
                                <td>{{ $dailyTests->firstItem() + $index }}</td>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);">{{ $test->title }}</div>
                                    <small style="color: var(--text-secondary);">{{ Str::limit($test->description, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge" style="background: #3b82f6; color: white; padding: 0.375rem 0.75rem; border-radius: 8px; font-size: 0.75rem;">
                                        {{ ucfirst(str_replace('_', ' ', $test->subject)) }}
                                    </span>
                                </td>
                                <td>
                                    <span style="color: var(--text-primary); font-weight: 500;">Kelas {{ $test->class }}</span>
                                </td>
                                <td>
                                    <span style="color: var(--text-secondary);">{{ $test->duration }} menit</span>
                                </td>
                                <td>
                                    <span class="status-badge {{ $test->status }}">
                                        @if($test->status == 'published')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                            Dipublikasi
                                        @elseif($test->status == 'draft')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Draft
                                        @elseif($test->status == 'completed')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Selesai
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.8rem; color: var(--text-primary);">{{ $test->scheduled_at ? $test->scheduled_at->format('d/m/Y') : '-' }}</div>
                                    <small style="color: var(--text-secondary);">{{ $test->scheduled_at ? $test->scheduled_at->format('H:i') : 'Belum dijadwalkan' }}</small>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('teacher.daily-tests.show', $test->id) }}" 
                                           class="btn-action btn-view" 
                                           title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        
                                        <a href="{{ route('teacher.daily-tests.edit', $test->id) }}" 
                                           class="btn-action btn-edit" 
                                           title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                        
                                        @if($test->status == 'draft')
                                            <button onclick="publishTest({{ $test->id }})" 
                                                    class="btn-action btn-publish" 
                                                    title="Publikasikan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                </svg>
                                            </button>
                                        @endif
                                        
                                        <button onclick="deleteTest({{ $test->id }})" 
                                                class="btn-action btn-delete" 
                                                title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($dailyTests->hasPages())
                <div class="d-flex justify-content-between align-items-center p-3" style="border-top: 1px solid var(--border-color);">
                    <div style="color: var(--text-secondary);">
                        Showing {{ $dailyTests->firstItem() }}-{{ $dailyTests->lastItem() }} of {{ $dailyTests->total() }} tests
                    </div>
                    {{ $dailyTests->appends(request()->query())->links() }}
                </div>
            @endif
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
                    @if(request()->hasAny(['search', 'status', 'subject', 'class']))
                        Tidak ada ulangan yang sesuai dengan filter yang dipilih.
                    @else
                        Mulai buat ulangan harian pertama Anda untuk siswa.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'status', 'subject', 'class']))
                    <a href="{{ route('teacher.daily-tests.index') }}" class="btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filter
                    </a>
                @else
                    <a href="{{ route('teacher.daily-tests.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Ulangan Pertama
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
// Publish test function
function publishTest(id) {
    if (!confirm('Apakah Anda yakin ingin mempublikasikan ulangan ini? Siswa akan dapat melihat dan mengerjakan ulangan.')) return;
    
    fetch(`/teacher/daily-tests/${id}/publish`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Terjadi kesalahan saat mempublikasikan ulangan');
    });
}

// Delete test function
function deleteTest(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus ulangan ini? Tindakan ini tidak dapat dibatalkan.')) return;
    
    fetch(`/teacher/daily-tests/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Terjadi kesalahan saat menghapus ulangan');
    });
}

// Show toast notification
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; animation: slideInRight 0.3s ease-out;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <svg class="w-4 h-4 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'}"/>
            </svg>
            <span>${message}</span>
            <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
        </div>
    `;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.remove();
        }
    }, 5000);
}

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
});
</script>
@endsection