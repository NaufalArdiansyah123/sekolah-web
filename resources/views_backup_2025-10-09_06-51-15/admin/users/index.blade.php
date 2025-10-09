@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<style>
    .user-container {
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

    .filter-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-control, .form-select {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
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
        position: relative;
        z-index: 1;
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

    .table-actions {
        display: flex;
        gap: 0.5rem;
    }

    .table-wrapper {
        overflow-x: auto;
        width: 100%;
        max-width: 100%;
        position: relative;
        z-index: 1;
    }

    .table {
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        min-width: 800px;
        position: relative;
        z-index: 1;
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
        position: relative;
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
        position: relative;
        z-index: 1;
    }

    /* User Avatar */
    .user-avatar {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        object-fit: cover;
        border: 2px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .user-avatar:hover {
        transform: scale(1.1);
        border-color: #3b82f6;
    }

    /* User Info */
    .user-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .user-email {
        color: var(--text-secondary);
        font-size: 0.8rem;
    }

    /* Role Badges */
    .role-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-right: 0.25rem;
        margin-bottom: 0.25rem;
        display: inline-block;
    }

    .role-super-admin {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .role-admin {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .role-teacher {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .role-student {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .role-none {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    /* Status Toggle */
    .status-container {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .status-toggle {
        width: 2.5rem !important;
        height: 1.25rem !important;
        cursor: pointer;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.05em;
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

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.375rem;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
    }

    .action-btn {
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
        -webkit-backdrop-filter: blur(10px);
    }

    .action-btn::before {
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

    .action-btn:hover::before {
        opacity: 1;
        transform: scale(1);
    }

    .action-btn:hover {
        transform: translateY(-2px) scale(1.05);
        text-decoration: none;
    }

    .action-btn:active {
        transform: translateY(0) scale(0.98);
        transition: all 0.1s ease;
    }

    .action-btn svg {
        position: relative;
        z-index: 2;
        filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.1));
        transition: all 0.3s ease;
    }

    .action-btn:hover svg {
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.2));
    }

    /* View Button - Cyan with glow */
    .action-btn-view {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 50%, #0e7490 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(6, 182, 212, 0.25);
    }

    .action-btn-view:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(6, 182, 212, 0.35), 
                    0 0 15px rgba(6, 182, 212, 0.25);
    }

    /* Edit Button - Blue with modern gradient */
    .action-btn-edit {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 50%, #1e40af 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(59, 130, 246, 0.25);
    }

    .action-btn-edit:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 50%, #1e3a8a 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.35), 
                    0 0 15px rgba(59, 130, 246, 0.25);
    }

    /* Reset Password Button - Orange with warmth */
    .action-btn-reset {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 50%, #b45309 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(245, 158, 11, 0.25);
    }

    .action-btn-reset:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 50%, #92400e 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35), 
                    0 0 15px rgba(245, 158, 11, 0.25);
    }

    /* Delete Button - Red with danger vibes */
    .action-btn-delete {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #b91c1c 100%);
        color: white;
        box-shadow: 0 3px 12px rgba(239, 68, 68, 0.25);
    }

    .action-btn-delete:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 50%, #991b1b 100%);
        color: white;
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35), 
                    0 0 15px rgba(239, 68, 68, 0.25);
    }

    /* Custom Tooltip */
    .action-btn {
        position: relative;
    }

    .action-btn[title]:hover::after {
        content: attr(title);
        position: absolute;
        left: 50%;
        bottom: calc(100% + 8px);
        transform: translateX(-50%);
        background: rgba(15, 23, 42, 0.95);
        color: white;
        padding: 0.5rem 0.75rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
        z-index: 10000;
        opacity: 0;
        animation: tooltipFadeIn 0.3s ease-out 0.3s forwards;
        pointer-events: none;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }

    .action-btn[title]:hover::before {
        content: '';
        position: absolute;
        left: 50%;
        bottom: calc(100% + 2px);
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 5px solid transparent;
        border-right: 5px solid transparent;
        border-top: 5px solid rgba(15, 23, 42, 0.95);
        z-index: 10001;
        opacity: 0;
        animation: tooltipFadeIn 0.3s ease-out 0.3s forwards;
    }

    @keyframes tooltipFadeIn {
        from {
            opacity: 0;
            transform: translateX(-50%) translateY(-5px);
        }
        to {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
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

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--bg-primary);
        border-top: 1px solid var(--border-color);
    }

    /* Button Styles */
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
        text-decoration: none;
    }

    .btn-test-primary {
        background: #3b82f6;
        color: white;
    }

    .btn-test-primary:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
        text-decoration: none;
    }

    .btn-test-info {
        background: #06b6d4;
        color: white;
    }

    .btn-test-info:hover {
        background: #0891b2;
        transform: translateY(-1px);
        text-decoration: none;
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
        .user-container {
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

        .action-btn {
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

<div class="user-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                User Management
            </h1>
            <p class="page-subtitle">Manage user accounts and roles in the system</p>
            <a href="{{ route('admin.users.create') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add New User
            </a>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $users->total() ?? 0 }}</div>
            <div class="stat-title">Total Users</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $users->where('email_verified_at', '!=', null)->count() ?? 0 }}</div>
            <div class="stat-title">Active Users</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </div>
            <div class="stat-value">{{ $roles->count() ?? 0 }}</div>
            <div class="stat-title">Available Roles</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #1d4ed8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $users->where('created_at', '>=', now()->subDays(30))->count() ?? 0 }}</div>
            <div class="stat-title">New This Month</div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-container">
        <div class="filter-title">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
            </svg>
            Filter Users
        </div>
        <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Search Users</label>
                <input type="text" name="search" class="form-control" 
                       placeholder="Nama atau email..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Peran</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Aktif</option>
                    <option value="unverified" {{ request('status') == 'unverified' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn-test btn-test-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Search
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn-test btn-test-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                User List
                <span class="role-badge role-student">{{ $users->total() ?? 0 }}</span>
            </h3>
            <div class="table-actions">
                <button class="btn-test btn-test-secondary" onclick="exportData()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </button>
                <button class="btn-test btn-test-info" onclick="refreshData()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>

        @if($users->count() > 0)
            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 5%; min-width: 40px;">ID</th>
                            <th style="width: 10%; min-width: 80px;">Avatar</th>
                            <th style="width: 25%; min-width: 200px;">User Info</th>
                            <th style="width: 20%; min-width: 150px;">Roles</th>
                            <th style="width: 15%; min-width: 120px;">Status</th>
                            <th style="width: 15%; min-width: 120px;">Joined</th>
                            <th style="width: 10%; min-width: 80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $index }}</td>
                            <td>
                                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                     alt="{{ $user->name }}" 
                                     class="user-avatar">
                            </td>
                            <td>
                                <div class="user-name">{{ $user->name }}</div>
                                <div class="user-email">{{ $user->email }}</div>
                            </td>
                            <td>
                                @if($user->roles->count() > 0)
                                    @foreach($user->roles as $role)
                                        <span class="role-badge role-{{ str_replace('_', '-', $role->name) }}">
                                            {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="role-badge role-none">No Role</span>
                                @endif
                            </td>
                            <td>
                                <div class="status-container">
                                    <input class="form-check-input status-toggle" 
                                           type="checkbox" 
                                           data-user-id="{{ $user->id }}"
                                           {{ $user->email_verified_at ? 'checked' : '' }}
                                           {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <span class="status-badge {{ $user->email_verified_at ? 'status-active' : 'status-inactive' }}">
                                        {{ $user->email_verified_at ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.8rem; color: var(--text-secondary);">
                                    {{ $user->created_at->format('M d, Y') }}
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-tertiary);">
                                    {{ $user->created_at->diffForHumans() }}
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <!-- View Button -->
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="action-btn action-btn-view" 
                                       title="View User Details">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Edit Button -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="action-btn action-btn-edit" 
                                       title="Edit User">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>
                                    
                                    <!-- Reset Password Button -->
                                    <a href="{{ route('admin.users.reset-password', $user->id) }}" 
                                       class="action-btn action-btn-reset" 
                                       title="Reset Password">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($users->hasPages())
                <div class="pagination-container">
                    <div style="color: var(--text-secondary);">
                        Showing {{ $users->firstItem() }}-{{ $users->lastItem() }} of {{ $users->total() }} users
                    </div>
                    {{ $users->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Users Found</h3>
                <p class="empty-message">
                    @if(request()->hasAny(['search', 'role', 'status']))
                        No users match the selected filters.
                    @else
                        Start by creating user accounts to manage system access.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'role', 'status']))
                    <a href="{{ route('admin.users.index') }}" class="btn-test btn-test-secondary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset Filters
                    </a>
                @else
                    <a href="{{ route('admin.users.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create First User
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>



<script>
// Ensure jQuery is loaded
(function() {
    if (typeof jQuery === 'undefined') {
        console.error('⚠️ jQuery is not loaded! Loading from CDN...');
        
        const script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
        script.onload = function() {
            console.log('✅ jQuery loaded dynamically');
            window.$ = window.jQuery = jQuery;
            initializeUserFunctions();
        };
        document.head.appendChild(script);
    } else {
        console.log('✅ jQuery already loaded');
        window.$ = window.jQuery = jQuery;
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeUserFunctions);
        } else {
            initializeUserFunctions();
        }
    }
})();

function initializeUserFunctions() {
    console.log('Initializing user management functions...');
    
    // Status toggle
    $('.status-toggle').off('change').on('change', function() {
        const userId = $(this).data('user-id');
        const isChecked = $(this).is(':checked');
        const toggle = $(this);
        const badge = toggle.siblings('.status-badge');
        
        $.ajax({
            url: `/admin/users/${userId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    if (response.status === 'active') {
                        badge.removeClass('status-inactive').addClass('status-active').text('Active');
                    } else {
                        badge.removeClass('status-active').addClass('status-inactive').text('Inactive');
                    }
                    showToast('success', 'Success!', response.message);
                } else {
                    toggle.prop('checked', !isChecked);
                    showToast('error', 'Error!', response.message);
                }
            },
            error: function(xhr) {
                toggle.prop('checked', !isChecked);
                const response = xhr.responseJSON;
                showToast('error', 'Error!', response?.message || 'An error occurred');
            }
        });
    });
    
    // Reset password
    let currentUserId = null;
    
    $('.reset-password-btn').off('click').on('click', function() {
        currentUserId = $(this).data('user-id');
        const userName = $(this).data('user-name');
        
        $('#resetUserName').text(userName);
        
        // Check if Bootstrap modal is available
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = new bootstrap.Modal(document.getElementById('resetPasswordModal'));
            modal.show();
        } else if (typeof $ !== 'undefined' && $.fn.modal) {
            $('#resetPasswordModal').modal('show');
        } else {
            // Fallback confirmation
            if (confirm(`Are you sure you want to reset the password for ${userName}?`)) {
                performPasswordReset();
            }
        }
    });
    
    $('#confirmResetPassword').off('click').on('click', function() {
        performPasswordReset();
    });
    
    function performPasswordReset() {
        if (!currentUserId) return;
        
        $.ajax({
            url: `/admin/users/${currentUserId}/reset-password`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    // Hide modal
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal')).hide();
                    } else if (typeof $ !== 'undefined' && $.fn.modal) {
                        $('#resetPasswordModal').modal('hide');
                    }
                    showToast('success', 'Success!', response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showToast('error', 'Error!', response?.message || 'An error occurred');
            }
        });
    }
    
    // Delete confirmation
    $('.delete-form').off('submit').on('submit', function(e) {
        e.preventDefault();
        
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            this.submit();
        }
    });
}

// Toggle dropdown function - NOT NEEDED ANYMORE
// function toggleDropdown(id) { ... } - REMOVED

// Close dropdowns when clicking outside - NOT NEEDED ANYMORE
// document.addEventListener('click', function(event) { ... }); - REMOVED

// Prevent dropdown from closing when clicking inside - NOT NEEDED ANYMORE
// document.addEventListener('click', function(event) { ... }); - REMOVED

// Export and refresh functions
// Export and refresh functions
function exportData() {
    // Get current filters
    const params = new URLSearchParams(window.location.search);
    params.append('export', 'excel');
    
    // Create download link
    const link = document.createElement('a');
    link.href = `{{ route('admin.users.index') }}?${params.toString()}`;
    link.download = `data-pengguna-${new Date().toISOString().split('T')[0]}.xlsx`;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('Data pengguna berhasil diekspor!', 'success');
}

function refreshData() {
    location.reload();
}

// Toast notification function
function showToast(type, title, message) {
    // Try different toast libraries in order of preference
    if (typeof toastr !== 'undefined') {
        toastr[type](message, title);
    } else if (typeof Swal !== 'undefined') {
        Swal.fire({
            icon: type === 'success' ? 'success' : 'error',
            title: title,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    } else {
        // Simple alert fallback
        alert(`${title}: ${message}`);
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', function() {
        // Re-run initialization if needed
        if (typeof jQuery !== 'undefined') {
            initializeUserFunctions();
        }
    });
}
</script>
@endsection