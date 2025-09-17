@extends('layouts.admin')

@section('title', 'Manajemen Ekstrakurikuler')

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
    }

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

    /* System Status Alert */
    .system-status-alert {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .system-status-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .status-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex: 1;
    }

    .status-text {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .status-instructions {
        font-size: 0.875rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .test-buttons {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-test {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-test-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-test-secondary:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    .btn-test-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-test-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .btn-test-info {
        background: #06b6d4;
        color: white;
    }

    .btn-test-info:hover {
        background: #0891b2;
        transform: translateY(-1px);
    }

    .btn-test-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-test-warning:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    /* Table */
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
        transition: color 0.3s ease;
    }

    .table-actions {
        display: flex;
        gap: 0.5rem;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
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
        transition: all 0.3s ease;
    }

    .table tbody td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background: var(--bg-secondary);
        transform: scale(1.001);
    }

    .extracurricular-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .extracurricular-description {
        color: var(--text-secondary);
        font-size: 0.8rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .badge-active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .badge-inactive {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .dark .badge-inactive {
        color: #9ca3af;
    }

    .stats-badge {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-right: 0.25rem;
    }

    /* Enhanced Action Dropdown */
    .action-dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 10px;
        padding: 0.625rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        position: relative;
        overflow: hidden;
    }

    .dropdown-toggle::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(29, 78, 216, 0.05));
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .dropdown-toggle:hover {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
        border-color: #3b82f6;
    }

    .dropdown-toggle:hover::before {
        opacity: 1;
    }

    .dropdown-toggle:active {
        transform: translateY(0) scale(1.02);
    }

    .dropdown-toggle.active {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    }

    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border: 0;
    }

    .dropdown-menu {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15), 0 8px 25px var(--shadow-color);
        overflow: hidden;
        position: absolute;
        left: 0;
        top: calc(100% + 8px);
        min-width: 220px;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-10px) scale(0.95);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        display: none;
    }

    .dropdown-menu.show {
        display: block;
        opacity: 1;
        visibility: visible;
        transform: translateY(0) scale(1);
    }

    .dropdown-menu::before {
        content: '';
        position: absolute;
        top: -8px;
        left: 12px;
        width: 16px;
        height: 16px;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-bottom: none;
        border-right: none;
        transform: rotate(45deg);
        z-index: -1;
    }

    .dropdown-item {
        padding: 0.875rem 1.25rem;
        color: var(--text-primary);
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .dropdown-item::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 3px;
        background: transparent;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.08), rgba(59, 130, 246, 0.02));
        color: #3b82f6;
        text-decoration: none;
        transform: translateX(4px);
    }

    .dropdown-item:hover::before {
        background: #3b82f6;
    }

    .dropdown-item svg {
        transition: all 0.3s ease;
        flex-shrink: 0;
    }

    .dropdown-item:hover svg {
        transform: scale(1.1);
        color: #3b82f6;
    }

    .dropdown-item.text-danger {
        color: #dc2626;
    }

    .dropdown-item.text-danger:hover {
        background: linear-gradient(90deg, rgba(220, 38, 38, 0.08), rgba(220, 38, 38, 0.02));
        color: #dc2626;
        transform: translateX(4px);
    }

    .dropdown-item.text-danger:hover::before {
        background: #dc2626;
    }

    .dropdown-item.text-danger:hover svg {
        color: #dc2626;
    }

    .dropdown-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
        margin: 0.5rem 0;
        border: none;
    }

    /* Action Button Styles */
    .action-view {
        color: #059669;
    }

    .action-view:hover {
        background: linear-gradient(90deg, rgba(5, 150, 105, 0.08), rgba(5, 150, 105, 0.02)) !important;
        color: #059669 !important;
    }

    .action-view:hover::before {
        background: #059669 !important;
    }

    .action-edit {
        color: #f59e0b;
    }

    .action-edit:hover {
        background: linear-gradient(90deg, rgba(245, 158, 11, 0.08), rgba(245, 158, 11, 0.02)) !important;
        color: #f59e0b !important;
    }

    .action-edit:hover::before {
        background: #f59e0b !important;
    }

    .action-members {
        color: #8b5cf6;
    }

    .action-members:hover {
        background: linear-gradient(90deg, rgba(139, 92, 246, 0.08), rgba(139, 92, 246, 0.02)) !important;
        color: #8b5cf6 !important;
    }

    .action-members:hover::before {
        background: #8b5cf6 !important;
    }

    .action-registrations {
        color: #06b6d4;
    }

    .action-registrations:hover {
        background: linear-gradient(90deg, rgba(6, 182, 212, 0.08), rgba(6, 182, 212, 0.02)) !important;
        color: #06b6d4 !important;
    }

    .action-registrations:hover::before {
        background: #06b6d4 !important;
    }

    /* Enhanced Table Cell for Actions */
    .table tbody td:last-child {
        position: relative;
        padding: 1rem 1.5rem;
    }

    /* Prevent dropdown from being cut off and ensure proper stacking */
    .table-container {
        overflow: visible;
        position: relative;
        z-index: 1;
    }

    .table {
        overflow: visible;
        position: relative;
    }
    
    .table tbody {
        position: relative;
        z-index: 1;
    }
    
    .table tbody tr {
        position: relative;
    }
    
    /* Ensure dropdown doesn't get clipped by table boundaries */
    .table tbody td:last-child {
        overflow: visible;
    }
    
    /* Enhanced dropdown z-index management for proper layering */
    .action-dropdown {
        position: relative;
        z-index: 1;
    }
    
    .dropdown-menu {
        position: absolute;
        z-index: 1000;
    }
    
    /* Dynamic z-index for active dropdowns - ensure they're always on top */
    .dropdown-menu.show {
        z-index: 9999 !important;
        position: absolute !important;
    }
    
    /* Ensure active dropdown container is above everything */
    .action-dropdown:has(.dropdown-menu.show) {
        z-index: 9998 !important;
    }
    
    /* Ensure proper table row stacking */
    .table tbody tr {
        position: relative;
        z-index: 1;
    }
    
    /* When a row has an active dropdown, increase its z-index */
    .table tbody tr:has(.dropdown-menu.show) {
        z-index: 9997 !important;
        position: relative !important;
    }
    
    /* Fallback for browsers that don't support :has() */
    .table tbody tr.dropdown-active {
        z-index: 9997 !important;
        position: relative !important;
    }
    
    /* Ensure the action cell has proper positioning */
    .table tbody tr.dropdown-active td:last-child {
        z-index: 9998 !important;
        position: relative !important;
    }
    
    /* Ensure dropdown container doesn't interfere */
    .table tbody tr:hover {
        z-index: 2;
    }
    
    /* Auto-adjust dropdown position if near edge */
    .dropdown-menu.dropdown-menu-end {
        left: auto;
        right: 0;
    }
    
    .dropdown-menu.dropdown-menu-end::before {
        left: auto;
        right: 12px;
    }

    /* Mobile Responsive Dropdown */
    @media (max-width: 768px) {
        .dropdown-menu {
            left: -50px;
            min-width: 200px;
        }
        
        .dropdown-menu::before {
            left: 62px;
        }
    }

    /* Dark mode enhancements */
    .dark .dropdown-menu {
        background: var(--bg-primary);
        border-color: var(--border-color);
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4), 0 8px 25px var(--shadow-color);
    }

    .dark .dropdown-menu::before {
        background: var(--bg-primary);
        border-color: var(--border-color);
    }

    .dark .dropdown-toggle {
        background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
    }

    .dark .dropdown-toggle:hover {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
        background: var(--bg-primary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
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
        transition: all 0.3s ease;
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .empty-message {
        margin-bottom: 2rem;
        line-height: 1.6;
        color: var(--text-secondary);
        transition: color 0.3s ease;
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

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .dark .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #fbbf24;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        padding: 2rem;
        background: var(--bg-primary);
        border-top: 1px solid var(--border-color);
        transition: all 0.3s ease;
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

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .system-status-content {
            flex-direction: column;
            align-items: stretch;
        }

        .test-buttons {
            justify-content: center;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            min-width: 800px;
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .table-actions {
            justify-content: center;
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

<div class="extracurricular-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Extracurricular Management
            </h1>
            <p class="page-subtitle">Manage extracurricular activities and student registrations</p>
            <a href="{{ route('admin.extracurriculars.create') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add Extracurricular
            </a>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $extracurriculars->total() }}</div>
            <div class="stat-title">Total Extracurriculars</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $activeExtracurriculars }}</div>
            <div class="stat-title">Active Programs</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $totalMembers }}</div>
            <div class="stat-title">Total Members</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $pendingRegistrations }}</div>
            <div class="stat-title">Pending Registrations</div>
        </div>
    </div>

    <!-- System Status Alert -->
    <div class="system-status-alert">
        <div class="system-status-content">
            <div class="status-info">
                <svg class="w-6 h-6" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <div class="status-text">
                        <strong>System Status:</strong> 
                        <span id="systemStatus">Checking...</span>
                    </div>
                    <div class="status-instructions" id="systemInstructions">
                        Click "Test Connection" for basic test, "Test DB" for database, "Test System" for full test
                    </div>
                </div>
            </div>
            <div class="test-buttons">
                <button class="btn-test btn-test-secondary" onclick="testBasicConnection()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                    </svg>
                    Test Connection
                </button>
                <button class="btn-test btn-test-primary" onclick="testDatabase()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                    Test DB
                </button>
                <button class="btn-test btn-test-info" onclick="testConnection()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Test System
                </button>
                @if($pendingRegistrations > 0)
                <button class="btn-test btn-test-warning" onclick="showPendingRegistrations()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    View {{ $pendingRegistrations }} Registrations
                </button>
                @endif
            </div>
        </div>
    </div>
    
    @if($pendingRegistrations > 0)
    <div class="alert alert-warning" role="alert">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
        </svg>
        <div class="flex-grow-1">
            <strong>Attention!</strong> There are {{ $pendingRegistrations }} registrations waiting for approval.
        </div>
        <button class="btn-test btn-test-warning" onclick="showPendingRegistrations()">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
            View Registrations
        </button>
    </div>
    @endif

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

    <!-- Extracurriculars Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">Extracurricular List</h3>
            <div class="table-actions">
                <button class="btn-test btn-test-secondary" onclick="exportData()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export
                </button>
                <button class="btn-test btn-test-info" onclick="refreshData()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        @if($extracurriculars->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 5%">Id</th>
                        <th style="width: 30%">Ekstrakurikuler</th>
                        <th style="width: 20%">Pembina/Pelatih</th>
                        <th style="width: 10%">Status</th>
                        <th style="width: 15%">Anggota</th>
                        <th style="width: 15%">Jadwal</th>
                        <th style="width: 5%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($extracurriculars as $index => $extracurricular)
                    <tr>
                        <td>{{ $extracurriculars->firstItem() + $index }}</td>
                        <td>
                            <div class="extracurricular-title">{{ $extracurricular->name }}</div>
                            <div class="extracurricular-description">{{ Str::limit($extracurricular->description, 80) }}</div>
                            @if($extracurricular->gambar)
                                <small style="color: #3b82f6; font-size: 0.75rem;">
                                    <svg class="w-3 h-3" style="display: inline;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Has image
                                </small>
                            @endif
                        </td>
                        <td>{{ $extracurricular->coach }}</td>
                        <td>
                            <span class="badge badge-{{ $extracurricular->status == 'aktif' ? 'active' : 'inactive' }}">
                                {{ ucfirst($extracurricular->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="stats-badge">{{ $extracurricular->registrations->where('status', 'approved')->count() }}</span>
                            members
                            @php
                                $pendingCount = $extracurricular->registrations->where('status', 'pending')->count();
                            @endphp
                            @if($pendingCount > 0)
                                <span class="stats-badge" style="background: linear-gradient(135deg, #f59e0b, #d97706);">{{ $pendingCount }}</span>
                                pending
                            @endif
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                {{ $extracurricular->jadwal ?? 'Not scheduled' }}
                            </div>
                        </td>
                        <td>
                            <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                {{ $extracurricular->created_at->format('M d, Y') }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--text-tertiary);">
                                {{ $extracurricular->created_at->format('H:i') }}
                            </div>
                        </td>
                        <td>
                            <!-- Enhanced Action Dropdown -->
                            <div class="action-dropdown">
                                <button type="button" 
                                        class="dropdown-toggle" 
                                        onclick="toggleDropdown({{ $extracurricular->id }})"
                                        title="Actions">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                    </svg>
                                    <span class="sr-only">Actions</span>
                                </button>
                                
                                <div class="dropdown-menu" id="dropdown-{{ $extracurricular->id }}">
                                    <!-- View Action -->
                                    <a class="dropdown-item action-view" 
                                       href="{{ route('admin.extracurriculars.show', $extracurricular->id) }}"
                                       title="View Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>View Details</span>
                                    </a>
                                    
                                    <!-- Edit Action -->
                                    <a class="dropdown-item action-edit" 
                                       href="{{ route('admin.extracurriculars.edit', $extracurricular->id) }}"
                                       title="Edit Extracurricular">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                        <span>Edit</span>
                                    </a>
                                    
                                    <!-- View Members Action -->
                                    <button class="dropdown-item action-members" 
                                            onclick="showMembers({{ $extracurricular->id }})"
                                            title="View Members">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        <span>View Members ({{ $extracurricular->registrations->where('status', 'approved')->count() }})</span>
                                    </button>
                                    
                                    <!-- View Registrations Action (if pending exists) -->
                                    @if($extracurricular->registrations->where('status', 'pending')->count() > 0)
                                    <button class="dropdown-item action-registrations" 
                                            onclick="showRegistrations({{ $extracurricular->id }})"
                                            title="View Pending Registrations">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>Pending Registrations ({{ $extracurricular->registrations->where('status', 'pending')->count() }})</span>
                                    </button>
                                    @endif
                                    
                                    <!-- Divider -->
                                    <hr class="dropdown-divider">
                                    
                                    <!-- Delete Action -->
                                    <form action="{{ route('admin.extracurriculars.destroy', $extracurricular->id) }}" 
                                          method="POST" 
                                          class="delete-form"
                                          style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="dropdown-item text-danger"
                                                title="Delete Extracurricular"
                                                onclick="return confirm('Are you sure you want to delete this extracurricular? This action cannot be undone.')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            <span>Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            @if($extracurriculars->hasPages())
                <div class="pagination-container">
                    {{ $extracurriculars->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Extracurriculars Found</h3>
                <p class="empty-message">
                    Start creating extracurricular activities to engage students in various programs and activities.
                </p>
                <a href="{{ route('admin.extracurriculars.create') }}" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create First Extracurricular
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Pending Registrations Modal -->
<div class="modal fade" id="pendingRegistrationsModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
            <div class="modal-header" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" style="color: var(--text-primary);"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: var(--text-primary);"></button>
            </div>
            <div class="modal-body" style="background: var(--bg-primary);" id="pendingRegistrationsContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Members Modal -->
<div class="modal fade" id="membersModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
            <div class="modal-header" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" style="color: var(--text-primary);"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: var(--text-primary);"></button>
            </div>
            <div class="modal-body" style="background: var(--bg-primary);" id="membersContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
// Ensure jQuery is loaded
(function() {
    if (typeof jQuery === 'undefined') {
        console.error('⚠ jQuery is not loaded! Loading from CDN...');
        
        // Load jQuery dynamically
        const script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
        script.onload = function() {
            console.log('✅ jQuery loaded dynamically');
            window.$ = window.jQuery = jQuery;
            initializeExtracurricularFunctions();
        };
        document.head.appendChild(script);
    } else {
        console.log('✅ jQuery already loaded');
        window.$ = window.jQuery = jQuery;
        // Initialize immediately if jQuery is available
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeExtracurricularFunctions);
        } else {
            initializeExtracurricularFunctions();
        }
    }
})();

// Debug function
function debugLog(message, data = null) {
    console.log('[EXTRACURRICULAR DEBUG]', message, data);
}

// Get correct base URL for current environment
function getBaseUrl() {
    const currentUrl = window.location.href;
    debugLog('Current URL:', currentUrl);
    
    // If we're on Laravel dev server (port 8000)
    if (currentUrl.includes(':8000')) {
        return '';
    }
    
    // If we're on XAMPP with public folder
    if (currentUrl.includes('/public/')) {
        return '';
    }
    
    // If we're on XAMPP without public folder in URL
    if (currentUrl.includes('/sekolah-web/') && !currentUrl.includes('/public/')) {
        return '/public';
    }
    
    return '';
}

function showPendingRegistrations() {
    debugLog('showPendingRegistrations called');
    
    // Check if modal exists
    const modal = document.getElementById('pendingRegistrationsModal');
    if (!modal) {
        debugLog('ERROR: Modal not found');
        alert('Error: Modal tidak ditemukan');
        return;
    }
    
    debugLog('Opening modal and loading content');
    
    // Try jQuery first, fallback to vanilla JS
    if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
        debugLog('Using jQuery for modal');
        // Show modal with jQuery
        $('#pendingRegistrationsModal').modal('show');
        
        // Show loading
        $('#pendingRegistrationsContent').html(`
            <div class="text-center py-4">
                <svg class="w-8 h-8 animate-spin mx-auto" fill="none" viewBox="0 0 24 24" style="color: var(--text-secondary);">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <br><br>
                <span style="color: var(--text-secondary);">Loading registrations...</span>
            </div>
        `);
    } else {
        debugLog('Using vanilla JS for modal (jQuery not available)');
        // Fallback to vanilla JS
        if (typeof bootstrap !== 'undefined') {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else {
            // Last resort - just show the modal
            modal.style.display = 'block';
            modal.classList.add('show');
            document.body.classList.add('modal-open');
        }
        
        // Show loading with vanilla JS
        const content = document.getElementById('pendingRegistrationsContent');
        content.innerHTML = `
            <div class="text-center py-4">
                <svg class="w-8 h-8 animate-spin mx-auto" fill="none" viewBox="0 0 24 24" style="color: var(--text-secondary);">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <br><br>
                <span style="color: var(--text-secondary);">Loading registrations...</span>
            </div>
        `;
    }
    
    // Make AJAX request - use dynamic URL (test first, then real route)
    const url = window.PENDING_REGISTRATIONS_URL || '/admin/test-pending-registrations';
    debugLog('Fetching from URL:', url, '(test mode:', !window.PENDING_REGISTRATIONS_URL, ')');
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8'
        }
    })
    .then(response => {
        debugLog('Response received:', {
            status: response.status,
            statusText: response.statusText,
            ok: response.ok
        });
        
        if (!response.ok) {
            if (response.status === 401) {
                throw new Error('Authentication required. Please login as admin.');
            }
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.text();
    })
    .then(html => {
        debugLog('HTML content received, length:', html.length);
        
        // Update content with jQuery or vanilla JS
        if (typeof $ !== 'undefined') {
            $('#pendingRegistrationsContent').html(html);
        } else {
            document.getElementById('pendingRegistrationsContent').innerHTML = html;
        }
    })
    .catch(error => {
        debugLog('ERROR occurred:', error);
        
        let errorHtml;
        
        if (error.message.includes('Authentication required') || error.message.includes('login')) {
            errorHtml = `
                <div class="alert alert-warning">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>
                        <h6><strong>Authentication Required</strong></h6>
                        <p><strong>Error:</strong> ${error.message}</p>
                        <p>You need to login as admin to access this data.</p>
                        <div class="mt-3">
                            <button class="btn-test btn-test-primary" onclick="window.location.href='/login'">Login</button>
                            <button class="btn-test btn-test-secondary" onclick="showPendingRegistrations()">Retry</button>
                        </div>
                    </div>
                </div>
            `;
        } else {
            errorHtml = `
                <div class="alert alert-danger">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h6>Error loading data</h6>
                        <p><strong>Error:</strong> ${error.message}</p>
                        <p><strong>URL:</strong> ${url}</p>
                        <button class="btn-test btn-test-secondary" onclick="showPendingRegistrations()">Retry</button>
                    </div>
                </div>
            `;
        }
        
        // Update content with jQuery or vanilla JS
        if (typeof $ !== 'undefined') {
            $('#pendingRegistrationsContent').html(errorHtml);
        } else {
            document.getElementById('pendingRegistrationsContent').innerHTML = errorHtml;
        }
    });
}

function showRegistrations(extracurricularId) {
    debugLog('showRegistrations called with ID:', extracurricularId);
    
    $('#pendingRegistrationsModal').modal('show');
    $('#pendingRegistrationsContent').html(`
        <div class="text-center py-4">
            <svg class="w-8 h-8 animate-spin mx-auto" fill="none" viewBox="0 0 24 24" style="color: var(--text-secondary);">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <br><br>
            <span style="color: var(--text-secondary);">Loading registrations...</span>
        </div>
    `);
    
    const url = `/admin/extracurriculars/${extracurricularId}/registrations`;
    debugLog('Fetching registrations from URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        debugLog('Registrations response:', {
            status: response.status,
            ok: response.ok
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.text();
    })
    .then(html => {
        debugLog('Registrations HTML received, length:', html.length);
        $('#pendingRegistrationsContent').html(html);
    })
    .catch(error => {
        debugLog('ERROR in showRegistrations:', error);
        $('#pendingRegistrationsContent').html(`
            <div class="alert alert-danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h6>Error loading registrations</h6>
                    <p><strong>Error:</strong> ${error.message}</p>
                    <p><strong>URL:</strong> ${url}</p>
                    <button class="btn-test btn-test-secondary" onclick="showRegistrations(${extracurricularId})">Retry</button>
                </div>
            </div>
        `);
    });
}

function showMembers(extracurricularId) {
    debugLog('showMembers called with ID:', extracurricularId);
    
    $('#membersModal').modal('show');
    $('#membersContent').html(`
        <div class="text-center py-4">
            <svg class="w-8 h-8 animate-spin mx-auto" fill="none" viewBox="0 0 24 24" style="color: var(--text-secondary);">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <br><br>
            <span style="color: var(--text-secondary);">Loading members...</span>
        </div>
    `);
    
    const url = `/admin/extracurriculars/${extracurricularId}/members`;
    debugLog('Fetching members from URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        debugLog('Members response:', {
            status: response.status,
            ok: response.ok
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.text();
    })
    .then(html => {
        debugLog('Members HTML received, length:', html.length);
        $('#membersContent').html(html);
    })
    .catch(error => {
        debugLog('ERROR in showMembers:', error);
        $('#membersContent').html(`
            <div class="alert alert-danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h6>Error loading members</h6>
                    <p><strong>Error:</strong> ${error.message}</p>
                    <p><strong>URL:</strong> ${url}</p>
                    <button class="btn-test btn-test-secondary" onclick="showMembers(${extracurricularId})">Retry</button>
                </div>
            </div>
        `);
    });
}

// Function to show registration detail
function showRegistrationDetail(registrationId) {
    debugLog('showRegistrationDetail called with ID:', registrationId);
    
    // Create or get detail modal
    let detailModal = document.getElementById('registrationDetailModal');
    if (!detailModal) {
        // Create modal if it doesn't exist
        const modalHtml = `
            <div class="modal fade" id="registrationDetailModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
                        <div class="modal-header" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
                            <h5 class="modal-title" style="color: var(--text-primary);">Registration Detail</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: var(--text-primary);"></button>
                        </div>
                        <div class="modal-body" style="background: var(--bg-primary);" id="registrationDetailContent">
                            <!-- Content will be loaded via AJAX -->
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        detailModal = document.getElementById('registrationDetailModal');
    }
    
    $('#registrationDetailModal').modal('show');
    $('#registrationDetailContent').html(`
        <div class="text-center py-4">
            <svg class="w-8 h-8 animate-spin mx-auto" fill="none" viewBox="0 0 24 24" style="color: var(--text-secondary);">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <br><br>
            <span style="color: var(--text-secondary);">Loading detail...</span>
        </div>
    `);
    
    const url = `/admin/extracurriculars/registration/${registrationId}`;
    debugLog('Fetching detail from URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        debugLog('Detail response:', {
            status: response.status,
            ok: response.ok
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.text();
    })
    .then(html => {
        debugLog('Detail HTML received, length:', html.length);
        $('#registrationDetailContent').html(html);
    })
    .catch(error => {
        debugLog('ERROR in showRegistrationDetail:', error);
        $('#registrationDetailContent').html(`
            <div class="alert alert-danger">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h6>Error loading detail</h6>
                    <p><strong>Error:</strong> ${error.message}</p>
                    <p><strong>URL:</strong> ${url}</p>
                    <button class="btn-test btn-test-secondary" onclick="showRegistrationDetail(${registrationId})">Retry</button>
                </div>
            </div>
        `);
    });
}

function approveRegistration(registrationId) {
    debugLog('approveRegistration called with ID:', registrationId);
    
    if (confirm('Are you sure you want to approve this registration?')) {
        const url = `/admin/extracurriculars/registration/${registrationId}/approve`;
        debugLog('Approving registration at URL:', url);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            debugLog('Approve response:', {
                status: response.status,
                ok: response.ok
            });
            return response.json();
        })
        .then(data => {
            debugLog('Approve data received:', data);
            if (data.success) {
                alert('Registration approved successfully!');
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            debugLog('ERROR in approveRegistration:', error);
            alert('Error: ' + error.message);
        });
    }
}

function rejectRegistration(registrationId) {
    const notes = prompt('Rejection reason (optional):');
    if (notes !== null) {
        fetch(`/admin/extracurriculars/registration/${registrationId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ notes: notes })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
        });
    }
}

function exportData() {
    // Implementation for data export
    window.location.href = '/admin/extracurriculars/export';
}

function refreshData() {
    // Refresh the current page
    location.reload();
}

// Simple connection test
function testBasicConnection() {
    debugLog('Testing basic connection only...');
    
    const baseUrl = getBaseUrl();
    const url = baseUrl + '/debug/connection';
    debugLog('Testing connection at:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        debugLog('Basic connection response:', {
            status: response.status,
            ok: response.ok,
            url: response.url
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        debugLog('✔ Connection successful:', data);
        
        if (data.auth_status === 'not_authenticated') {
            alert(`⚠️ Connection successful but not authenticated!\nStatus: ${data.status}\nAuth: ${data.auth_status}\nLaravel: ${data.server_info.laravel_version}\nPlease login first.`);
        } else {
            alert(`✅ Connection successful!\nStatus: ${data.status}\nUser: ${data.user}\nAuth: ${data.auth_status}\nLaravel: ${data.server_info.laravel_version}`);
        }
    })
    .catch(error => {
        debugLog('⚠ Connection failed:', error);
        
        if (error.message.includes('401') || error.message.includes('Unauthenticated')) {
            alert(`⚠ Authentication Error!\nYou need to login as admin.\nError: ${error.message}`);
        } else {
            alert(`⚠ Connection failed: ${error.message}`);
        }
    });
}

// Test database connection
function testDatabase() {
    debugLog('Testing database connection...');
    
    const baseUrl = getBaseUrl();
    const url = baseUrl + '/debug/database';
    debugLog('Testing database at:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        debugLog('Database test response:', {
            status: response.status,
            ok: response.ok
        });
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        debugLog('✔ Database test successful:', data);
        
        if (data.status === 'OK') {
            alert(`✅ Database successful!\nUsers: ${data.data.users_count}\nRoles: ${data.data.roles_count}`);
        } else {
            alert(`⚠ Database error: ${data.message}`);
        }
    })
    .catch(error => {
        debugLog('⚠ Database test failed:', error);
        alert(`⚠ Database failed: ${error.message}`);
    });
}

// Test function to check if everything is working
function testConnection() {
    debugLog('Testing full system connection...');
    
    // Test 1: Check if jQuery is loaded
    if (typeof $ === 'undefined') {
        alert('⚠ jQuery not available');
        return;
    }
    debugLog('✔ jQuery loaded');
    
    // Test 2: Check if Bootstrap modal is available
    if (typeof $.fn.modal === 'undefined') {
        alert('⚠ Bootstrap modal not available');
        return;
    }
    debugLog('✔ Bootstrap modal available');
    
    // Test 3: Check if CSRF token exists
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('⚠ CSRF token not found');
        return;
    }
    debugLog('✔ CSRF token found:', csrfToken.getAttribute('content'));
    
    // Test 4: Check if modal elements exist
    const pendingModal = document.getElementById('pendingRegistrationsModal');
    const membersModal = document.getElementById('membersModal');
    
    if (!pendingModal) {
        alert('⚠ Pending registrations modal not found');
        return;
    }
    debugLog('✔ Pending registrations modal found');
    
    if (!membersModal) {
        alert('⚠ Members modal not found');
        return;
    }
    debugLog('✔ Members modal found');
    
    // Test 5: Test basic connection first
    debugLog('Testing basic connection...');
    fetch('/debug/connection', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        debugLog('Connection test response:', {
            status: response.status,
            ok: response.ok
        });
        
        if (!response.ok) {
            throw new Error(`Connection test failed: HTTP ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        debugLog('✔ Basic connection OK:', data);
        
        // Check authentication status
        if (data.auth_status === 'not_authenticated') {
            throw new Error('User not authenticated. Please login as admin first.');
        }
        
        // Test 6: Test pending registrations route
        debugLog('Testing pending registrations route...');
        return fetch('/admin/test-pending-registrations', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'text/html'
            }
        });
    })
    .then(response => {
        debugLog('Pending registrations test response:', {
            status: response.status,
            ok: response.ok,
            contentType: response.headers.get('content-type')
        });
        
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error(`Pending registrations test failed: HTTP ${response.status}\n${text}`);
            });
        }
        
        return response.text();
    })
    .then(html => {
        debugLog('✔ Pending registrations test OK, HTML length:', html.length);
        alert('✅ All tests successful! System ready to use.');
        
        // If test successful, update the URL to use the real route
        debugLog('Updating to use real route for future requests');
        // This will be used by showPendingRegistrations function
        window.PENDING_REGISTRATIONS_URL = '/admin/extracurriculars/pending-registrations';
    })
    .catch(error => {
        debugLog('⚠ Test error:', error);
        
        if (error.message.includes('not authenticated') || error.message.includes('Unauthenticated')) {
            const shouldRedirect = confirm('⚠ Authentication Error!\n\nYou need to login as admin first.\n\nClick OK to redirect to login page.');
            if (shouldRedirect) {
                window.location.href = '/login';
            }
        } else {
            alert('⚠ Test error: ' + error.message);
        }
        
        // Show detailed error info
        console.error('Detailed error:', error);
    });
}

// Initialize all extracurricular functions
function initializeExtracurricularFunctions() {
    debugLog('Initializing extracurricular functions...');
    
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this extracurricular? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });
    
    // Enhanced dropdown event listeners with better isolation
    document.addEventListener('click', closeDropdownsOnOutsideClick, true); // Use capture phase
    document.addEventListener('keydown', closeDropdownsOnEscape);
    
    // Add click event listeners to all dropdown toggles to prevent event bubbling
    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent event bubbling
            event.preventDefault(); // Prevent default behavior
        });
    });
    
    // Add click event listeners to dropdown menus to prevent closing when clicking inside
    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        menu.addEventListener('click', function(event) {
            // Only stop propagation if clicking on dropdown items, not the menu itself
            if (event.target.closest('.dropdown-item')) {
                // Let dropdown items handle their own clicks
                return;
            }
            event.stopPropagation();
        });
    });
    
    // Add keyboard navigation for dropdowns
    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                const id = this.onclick.toString().match(/toggleDropdown\((\d+)\)/)[1];
                toggleDropdown(parseInt(id));
            }
        });
    });
    
    // Add focus management for accessibility
    document.querySelectorAll('.dropdown-item').forEach(function(item) {
        item.addEventListener('keydown', function(event) {
            const dropdown = this.closest('.dropdown-menu');
            const items = Array.from(dropdown.querySelectorAll('.dropdown-item'));
            const currentIndex = items.indexOf(this);
            
            switch(event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    const nextIndex = (currentIndex + 1) % items.length;
                    items[nextIndex].focus();
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    const prevIndex = currentIndex === 0 ? items.length - 1 : currentIndex - 1;
                    items[prevIndex].focus();
                    break;
                case 'Escape':
                    event.preventDefault();
                    dropdown.classList.remove('show');
                    dropdown.previousElementSibling.classList.remove('active');
                    dropdown.previousElementSibling.focus();
                    break;
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });

    // Add CSS for animations
    if (!document.querySelector('#extracurricular-animations')) {
        const style = document.createElement('style');
        style.id = 'extracurricular-animations';
        style.textContent = `
            .animate-spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            .mx-auto {
                margin-left: auto;
                margin-right: auto;
            }
            .text-center {
                text-align: center;
            }
            .py-4 {
                padding-top: 1rem;
                padding-bottom: 1rem;
            }
            .mt-3 {
                margin-top: 0.75rem;
            }
            
            /* Enhanced dropdown animations */
            .dropdown-item {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            .dropdown-toggle {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            /* Focus styles for accessibility */
            .dropdown-toggle:focus {
                outline: 2px solid #3b82f6;
                outline-offset: 2px;
            }
            
            .dropdown-item:focus {
                outline: 2px solid #3b82f6;
                outline-offset: -2px;
                background: linear-gradient(90deg, rgba(59, 130, 246, 0.1), rgba(59, 130, 246, 0.05)) !important;
            }
            
            /* Force dropdown to be above everything */
            .dropdown-menu.show {
                z-index: 9999 !important;
                position: absolute !important;
            }
            
            /* Ensure dropdown is never hidden */
            .table-container,
            .table,
            .table tbody,
            .table tbody tr,
            .table tbody td {
                overflow: visible !important;
            }
        `;
        document.head.appendChild(style);
    }
    
    debugLog('✔ Extracurricular functions initialized');
    
    // Add window resize listener to adjust dropdown positions
    window.addEventListener('resize', function() {
        // Close all dropdowns on resize to prevent positioning issues
        document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
            menu.classList.remove('show');
        });
        document.querySelectorAll('.dropdown-toggle.active').forEach(function(toggle) {
            toggle.classList.remove('active');
        });
    });
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    debugLog('DOM loaded, initializing...');
    initializeExtracurricularFunctions();
});

// Enhanced Dropdown functions with proper isolation
function toggleDropdown(id) {
    console.log('🔽 toggleDropdown called for ID:', id);
    
    const dropdown = document.getElementById('dropdown-' + id);
    if (!dropdown) {
        console.error('❌ Dropdown not found for ID:', id);
        return;
    }
    
    const toggle = dropdown.previousElementSibling;
    if (!toggle) {
        console.error('❌ Toggle button not found for dropdown:', id);
        return;
    }
    
    const isShown = dropdown.classList.contains('show');
    console.log('📊 Dropdown', id, 'current state:', isShown ? 'OPEN' : 'CLOSED');
    
    // ALWAYS close ALL other dropdowns first to prevent conflicts
    const otherOpenDropdowns = document.querySelectorAll('.dropdown-menu.show');
    console.log('🔒 Found', otherOpenDropdowns.length, 'open dropdowns to close');
    
    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        if (menu !== dropdown && menu.classList.contains('show')) {
            const menuId = menu.id.replace('dropdown-', '');
            console.log('🔒 Closing dropdown:', menuId);
            menu.classList.remove('show');
            
            // No need to reset positioning - using CSS classes
            
            // Remove dropdown-active class from the row
            const menuRow = menu.closest('tr');
            if (menuRow) {
                menuRow.classList.remove('dropdown-active');
            }
            
            // Also remove active state from their toggles
            const menuToggle = menu.previousElementSibling;
            if (menuToggle) {
                menuToggle.classList.remove('active');
            }
        }
    });
    
    // Remove active state from all other toggles
    document.querySelectorAll('.dropdown-toggle').forEach(function(btn) {
        if (btn !== toggle && btn.classList.contains('active')) {
            btn.classList.remove('active');
        }
    });
    
    // Toggle current dropdown with enhanced animation
    if (!isShown) {
        console.log('🚀 Opening dropdown:', id);
        
        // Auto-adjust position if near viewport edge
        adjustDropdownPosition(dropdown, toggle);
        
        // Add a small delay to ensure other dropdowns are closed
        setTimeout(() => {
            dropdown.classList.add('show');
            toggle.classList.add('active');
            
            // Add dropdown-active class to the current row for z-index management
            const currentRow = dropdown.closest('tr');
            if (currentRow) {
                currentRow.classList.add('dropdown-active');
            }
            
            // Debug dropdown position
            const dropdownRect = dropdown.getBoundingClientRect();
            const toggleRect = toggle.getBoundingClientRect();
            console.log('✅ Dropdown', id, 'opened successfully at:', {
                dropdown: { top: dropdownRect.top, left: dropdownRect.left, bottom: dropdownRect.bottom },
                toggle: { top: toggleRect.top, left: toggleRect.left, bottom: toggleRect.bottom },
                visible: dropdownRect.top > 0 && dropdownRect.left > 0
            });
            
            // Add staggered animation to dropdown items
            const items = dropdown.querySelectorAll('.dropdown-item');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateX(-10px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateX(0)';
                }, index * 50);
            });
            
            // Focus first item for accessibility
            setTimeout(() => {
                const firstItem = dropdown.querySelector('.dropdown-item');
                if (firstItem) {
                    firstItem.focus();
                }
            }, 100);
        }, 50);
    } else {
        console.log('🔒 Closing dropdown:', id);
        dropdown.classList.remove('show');
        toggle.classList.remove('active');
        
        // No need to reset positioning - using CSS classes
        
        // Remove dropdown-active class from the row
        const currentRow = dropdown.closest('tr');
        if (currentRow) {
            currentRow.classList.remove('dropdown-active');
        }
        
        console.log('✅ Dropdown', id, 'closed successfully');
    }
    
    console.log('🏁 toggleDropdown completed for ID:', id);
}

// Auto-adjust dropdown position (simplified - back to absolute positioning)
function adjustDropdownPosition(dropdown, toggle) {
    // Reset position classes and inline styles
    dropdown.classList.remove('dropdown-menu-end');
    dropdown.style.position = '';
    dropdown.style.top = '';
    dropdown.style.left = '';
    dropdown.style.right = '';
    
    // Get viewport and element dimensions
    const rect = toggle.getBoundingClientRect();
    const dropdownWidth = 220; // min-width from CSS
    const viewportWidth = window.innerWidth;
    const scrollbarWidth = 20; // approximate scrollbar width
    
    // Check if dropdown would overflow on the left (since we default to left now)
    if (rect.left + dropdownWidth > viewportWidth - scrollbarWidth) {
        dropdown.classList.add('dropdown-menu-end');
    }
    
    // For very small screens, prefer right alignment if more space
    if (viewportWidth < 768) {
        const leftSpace = rect.left;
        const rightSpace = viewportWidth - rect.right;
        
        if (rightSpace > leftSpace && rightSpace > dropdownWidth) {
            dropdown.classList.add('dropdown-menu-end');
        }
    }
    
    console.log('📍 Dropdown positioning completed for toggle at:', {
        left: rect.left,
        right: rect.right,
        width: rect.width,
        dropdownClass: dropdown.classList.contains('dropdown-menu-end') ? 'right-aligned' : 'left-aligned'
    });
}

// Close dropdown when clicking outside with better isolation
function closeDropdownsOnOutsideClick(event) {
    // Check if click is outside any dropdown
    if (!event.target.closest('.action-dropdown')) {
        // Close all open dropdowns
        const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
        const activeToggles = document.querySelectorAll('.dropdown-toggle.active');
        const activeRows = document.querySelectorAll('.table tbody tr.dropdown-active');
        
        openDropdowns.forEach(function(menu) {
            menu.classList.remove('show');
            // No need to reset positioning - using CSS classes
        });
        
        activeToggles.forEach(function(toggle) {
            toggle.classList.remove('active');
        });
        
        activeRows.forEach(function(row) {
            row.classList.remove('dropdown-active');
        });
    }
}

// Close dropdown on escape key
function closeDropdownsOnEscape(event) {
    if (event.key === 'Escape') {
        document.querySelectorAll('.dropdown-menu.show').forEach(function(menu) {
            menu.classList.remove('show');
            // No need to reset positioning - using CSS classes
        });
        document.querySelectorAll('.dropdown-toggle.active').forEach(function(toggle) {
            toggle.classList.remove('active');
        });
        document.querySelectorAll('.table tbody tr.dropdown-active').forEach(function(row) {
            row.classList.remove('dropdown-active');
        });
    }
}

// Basic system checks
function runBasicChecks() {
    debugLog('Running basic system checks...');
    
    // Check dark mode
    const isDarkMode = document.documentElement.classList.contains('dark') || 
                      document.body.classList.contains('dark') ||
                      window.matchMedia('(prefers-color-scheme: dark)').matches;
    
    debugLog('Dark mode detected:', isDarkMode);
    
    if (isDarkMode) {
        document.documentElement.classList.add('dark');
    }
    
    // Update system status
    const statusElement = document.getElementById('systemStatus');
    if (statusElement) {
        statusElement.textContent = 'Ready';
        statusElement.style.color = '#059669';
    }
    
    debugLog('✔ Basic checks completed');
}

// Run basic checks immediately
runBasicChecks();
</script>

@endsection