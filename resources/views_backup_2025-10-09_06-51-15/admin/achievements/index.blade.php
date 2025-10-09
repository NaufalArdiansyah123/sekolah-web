@extends('layouts.admin')

@section('title', 'Prestasi Sekolah')
@section('page-title', 'Prestasi Sekolah')

@section('content')
<style>
    /* Enhanced Dark Mode Compatible Admin Styles */
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
    .achievement-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: background-color 0.3s ease;
    }

    /* Enhanced Header Section */
    .page-header {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .page-header:hover {
        box-shadow: 0 10px 15px -3px var(--shadow-hover);
        transform: translateY(-1px);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0;
        font-weight: 500;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    /* Enhanced Buttons with Dark Mode */
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

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-hover);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Enhanced Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
        background: linear-gradient(90deg, var(--accent-color), var(--info-color));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px var(--shadow-hover);
        border-color: var(--border-hover);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .stat-icon.blue { 
        background: linear-gradient(135deg, var(--accent-color), #60a5fa);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
    }
    .stat-icon.green { 
        background: linear-gradient(135deg, var(--success-color), #34d399);
        box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
    }
    .stat-icon.yellow { 
        background: linear-gradient(135deg, var(--warning-color), #fbbf24);
        box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);
    }
    .stat-icon.red { 
        background: linear-gradient(135deg, var(--danger-color), #f87171);
        box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--text-primary);
        margin: 0;
        line-height: 1;
        font-family: 'Inter', system-ui, sans-serif;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin: 0;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Enhanced Filters Section */
    .filters-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .filters-section:hover {
        box-shadow: 0 10px 15px -3px var(--shadow-hover);
    }

    .filters-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .filters-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .filters-icon {
        width: 2rem;
        height: 2rem;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        color: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        transform: translateY(-1px);
    }

    .form-input:hover {
        border-color: var(--border-hover);
    }

    /* Enhanced Content Section */
    .content-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .content-section:hover {
        box-shadow: 0 10px 15px -3px var(--shadow-hover);
    }

    /* Enhanced Achievement Grid */
    .achievements-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
        padding: 2rem;
    }

    .achievement-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        position: relative;
    }

    .achievement-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--accent-color), var(--info-color));
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .achievement-card:hover::before {
        transform: scaleX(1);
    }

    .achievement-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 50px -12px var(--shadow-hover);
        border-color: var(--border-hover);
    }

    .achievement-image {
        height: 220px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        overflow: hidden;
    }

    .achievement-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .achievement-card:hover .achievement-image img {
        transform: scale(1.1);
    }

    .achievement-image-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: white;
        font-size: 4rem;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
    }

    .achievement-badges {
        position: absolute;
        top: 1rem;
        left: 1rem;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .achievement-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
        letter-spacing: 0.5px;
    }

    .badge-featured {
        background: rgba(251, 191, 36, 0.9);
        color: white;
        box-shadow: 0 4px 14px rgba(251, 191, 36, 0.4);
    }

    .badge-active {
        background: rgba(16, 185, 129, 0.9);
        color: white;
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4);
    }

    .badge-inactive {
        background: rgba(107, 114, 128, 0.9);
        color: white;
        box-shadow: 0 4px 14px rgba(107, 114, 128, 0.4);
    }

    .achievement-content {
        padding: 2rem;
    }

    .achievement-title {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 1rem;
        color: var(--text-primary);
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .achievement-meta {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
        font-weight: 600;
    }

    .achievement-description {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .achievement-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Enhanced Action Buttons */
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-view {
        background: rgba(59, 130, 246, 0.1);
        color: var(--accent-color);
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .btn-view:hover {
        background: var(--accent-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(59, 130, 246, 0.3);
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-color);
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .btn-edit:hover {
        background: var(--warning-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
    }

    .btn-toggle {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-color);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .btn-toggle:hover {
        background: var(--success-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger-color);
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-delete:hover {
        background: var(--danger-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(239, 68, 68, 0.3);
    }

    /* Enhanced Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 5rem;
        height: 5rem;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
    }

    .empty-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .empty-message {
        margin-bottom: 2rem;
        line-height: 1.6;
        max-width: 500px;
        margin-left: auto;
        margin-right: auto;
    }

    /* Enhanced Pagination */
    .pagination-wrapper {
        padding: 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: center;
        background: var(--bg-secondary);
    }

    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--accent-color);
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .achievements-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .achievement-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .achievements-grid {
            grid-template-columns: 1fr;
            padding: 1.5rem;
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .achievement-actions {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .achievement-meta {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-sm {
            flex: 1;
            justify-content: center;
        }
    }

    /* Dark mode specific adjustments */
    .dark .achievement-card {
        background: var(--bg-tertiary);
    }

    .dark .form-input {
        background: var(--bg-secondary);
    }

    .dark .achievement-image-placeholder {
        background: linear-gradient(135deg, #374151, #4b5563);
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
    .btn:focus,
    .form-input:focus {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .achievement-card {
            border-width: 2px;
        }
        
        .btn {
            border-width: 2px;
        }
    }
</style>

<div class="achievement-page">
    <!-- Enhanced Page Header -->
    <div class="page-header">
        <div class="header-top">
            <div>
                <h1 class="page-title">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Prestasi Sekolah
                </h1>
                <p class="page-subtitle">Kelola prestasi dan penghargaan sekolah</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Prestasi
                </a>
                <a href="{{ route('public.achievements.index') }}" target="_blank" class="btn btn-success">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Public
                </a>
            </div>
        </div>
    </div>

    <!-- Enhanced Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $achievements->total() ?? 0 }}</h3>
            <p class="stat-label">Total Prestasi</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $statistics['active'] ?? 0 }}</h3>
            <p class="stat-label">Aktif</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon yellow">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $statistics['featured'] ?? 0 }}</h3>
            <p class="stat-label">Unggulan</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon red">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $statistics['recent'] ?? 0 }}</h3>
            <p class="stat-label">Bulan Ini</p>
        </div>
    </div>

    <!-- Enhanced Filters -->
    <div class="filters-section">
        <div class="filters-header">
            <div class="filters-icon">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                </svg>
            </div>
            <h3 class="filters-title">Filter Prestasi</h3>
        </div>
        
        <form method="GET" action="{{ route('admin.achievements.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari prestasi..." class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-input">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $value)
                            <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    <select name="level" class="form-input">
                        <option value="">Semua Tingkat</option>
                        @foreach($levels as $key => $value)
                            <option value="{{ $key }}" {{ request('level') == $key ? 'selected' : '' }}>{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <select name="year" class="form-input">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Unggulan</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.75rem;">
                        <button type="submit" class="btn btn-primary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Enhanced Content -->
    <div class="content-section">
        @if($achievements->count() > 0)
            <div class="achievements-grid">
                @foreach($achievements as $achievement)
                <div class="achievement-card">
                    <div class="achievement-image">
                        @if($achievement->image)
                            <img src="{{ asset($achievement->image) }}" alt="{{ $achievement->title }}" loading="lazy">
                        @else
                            <div class="achievement-image-placeholder">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="achievement-badges">
                            @if($achievement->is_featured)
                                <span class="achievement-badge badge-featured">Unggulan</span>
                            @endif
                            <span class="achievement-badge {{ $achievement->is_active ? 'badge-active' : 'badge-inactive' }}">
                                {{ $achievement->is_active ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="achievement-content">
                        <h3 class="achievement-title">{{ Str::limit($achievement->title, 60) }}</h3>
                        
                        <div class="achievement-meta">
                            <span><strong>{{ $achievement->level_formatted }}</strong></span>
                            <span>{{ $achievement->category_formatted }}</span>
                            <span>{{ $achievement->year }}</span>
                        </div>
                        
                        <p class="achievement-description">{{ Str::limit($achievement->description, 120) }}</p>
                        
                        <div class="achievement-actions">
                            <a href="{{ route('admin.achievements.show', $achievement) }}" class="btn btn-sm btn-view" title="Lihat">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Lihat
                            </a>
                            <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-sm btn-edit" title="Edit">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit
                            </a>
                            <button type="button" class="btn btn-sm btn-toggle" onclick="toggleStatus({{ $achievement->id }})" title="Toggle Status">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                </svg>
                                Toggle
                            </button>
                            <button type="button" class="btn btn-sm btn-delete" onclick="deleteAchievement({{ $achievement->id }}, '{{ $achievement->title }}')" title="Hapus">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            @if($achievements->hasPages())
                <div class="pagination-wrapper">
                    {{ $achievements->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h3 class="empty-title">Tidak Ada Prestasi Ditemukan</h3>
                <p class="empty-message">
                    @if(request()->hasAny(['search', 'category', 'level', 'year', 'status']))
                        Tidak ada prestasi yang sesuai dengan filter yang dipilih. Coba sesuaikan kriteria pencarian Anda.
                    @else
                        Mulai membuat prestasi untuk menampilkan pencapaian sekolah.
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'category', 'level', 'year', 'status']))
                    <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Prestasi Pertama
                    </a>
                @else
                    <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Hapus Filter
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
// Enhanced JavaScript with better error handling and loading states
function toggleStatus(id) {
    if (confirm('Ubah status prestasi ini?')) {
        const card = document.querySelector(`[data-achievement-id="${id}"]`);
        if (card) card.classList.add('loading');
        
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
                // Show success message
                showNotification('Status prestasi berhasil diubah!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                throw new Error(data.message || 'Gagal mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Terjadi kesalahan saat mengubah status', 'error');
        })
        .finally(() => {
            if (card) card.classList.remove('loading');
        });
    }
}

function deleteAchievement(id, title) {
    if (confirm(`Apakah Anda yakin ingin menghapus "${title}"? Tindakan ini tidak dapat dibatalkan.`)) {
        const card = document.querySelector(`[data-achievement-id="${id}"]`);
        if (card) card.classList.add('loading');
        
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
        border-radius: 8px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        ${type === 'success' ? 'background: #10b981;' : 'background: #ef4444;'}
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

// Enhanced form interactions
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit form on select change (optional)
    const selectFilters = document.querySelectorAll('select.form-input');
    selectFilters.forEach(select => {
        select.addEventListener('change', function() {
            // Uncomment to enable auto-submit
            // this.closest('form').submit();
        });
    });
    
    // Enhanced button loading states
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (this.href && !this.href.includes('#') && !this.target) {
                const originalContent = this.innerHTML;
                this.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
                
                setTimeout(() => {
                    this.innerHTML = originalContent;
                }, 3000);
            }
        });
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + N for new achievement
        if ((e.ctrlKey || e.metaKey) && e.key === 'n') {
            e.preventDefault();
            const newBtn = document.querySelector('a[href*="create"]');
            if (newBtn) newBtn.click();
        }
        
        // Escape to clear search
        if (e.key === 'Escape') {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.focus();
            }
        }
    });
    
    // Enhanced accessibility
    const cards = document.querySelectorAll('.achievement-card');
    cards.forEach((card, index) => {
        card.setAttribute('tabindex', '0');
        card.setAttribute('role', 'article');
        card.setAttribute('aria-label', `Prestasi ${index + 1}`);
        
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const viewBtn = this.querySelector('.btn-view');
                if (viewBtn) viewBtn.click();
            }
        });
    });
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