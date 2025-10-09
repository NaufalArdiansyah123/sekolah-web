@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<style>
    .user-show-container {
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
        background: linear-gradient(135deg, #059669, #047857);
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
        gap: 1rem;
    }

    .btn-header {
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
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-header.primary {
        background: white;
        color: #059669;
    }

    .btn-header.primary:hover {
        background: rgba(255, 255, 255, 0.9);
        color: #059669;
    }

    /* Profile Card */
    .profile-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
        text-align: center;
        position: sticky;
        top: 2rem;
    }

    .user-avatar-xl {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        object-fit: cover;
        border: 4px solid var(--border-color);
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .user-avatar-xl:hover {
        transform: scale(1.05);
        border-color: #059669;
    }

    .user-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .user-email {
        color: var(--text-secondary);
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    .role-badges {
        margin-bottom: 1.5rem;
    }

    .role-badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0.25rem;
        display: inline-block;
    }

    .role-super-admin { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .role-admin { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .role-teacher { background: rgba(59, 130, 246, 0.1); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.2); }
    .role-student { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .role-none { background: rgba(107, 114, 128, 0.1); color: #6b7280; border: 1px solid rgba(107, 114, 128, 0.2); }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1.5rem;
        display: inline-block;
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

    /* Quick Actions */
    .quick-actions {
        display: grid;
        gap: 0.75rem;
    }

    .quick-action-btn {
        padding: 0.75rem;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        border: 1px solid var(--border-color);
        background: var(--bg-secondary);
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        justify-content: center;
    }

    .quick-action-btn:hover {
        background: var(--bg-tertiary);
        transform: translateY(-2px);
        text-decoration: none;
        color: var(--text-primary);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .quick-action-warning {
        border-color: #f59e0b;
        color: #d97706;
    }

    .quick-action-warning:hover {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .quick-action-success {
        border-color: #059669;
        color: #059669;
    }

    .quick-action-success:hover {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .quick-action-secondary {
        border-color: #6b7280;
        color: #6b7280;
    }

    .quick-action-secondary:hover {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
    }

    /* Info Container */
    .info-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .info-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
    }

    .info-item {
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: var(--bg-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .info-label {
        font-weight: 600;
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .info-value {
        color: var(--text-primary);
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .info-meta {
        color: var(--text-tertiary);
        font-size: 0.8rem;
    }

    /* Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1.5rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .stat-item:hover {
        background: var(--bg-primary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px var(--shadow-color);
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Permissions */
    .permissions-container {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .permission-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .permission-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-primary);
        color: var(--text-secondary);
    }

    .permission-list {
        display: grid;
        gap: 0.75rem;
    }

    .permission-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem;
        background: var(--bg-primary);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
    }

    .permission-item:hover {
        background: var(--bg-tertiary);
    }

    .permission-allowed {
        color: #059669;
    }

    .permission-denied {
        color: #dc2626;
    }

    /* Timeline */
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
        background: var(--border-color);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        background: var(--bg-primary);
        transform: translateX(4px);
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 1.25rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 3px solid var(--bg-primary);
        box-shadow: 0 0 0 2px var(--border-color);
    }

    .timeline-marker.success { background: #059669; }
    .timeline-marker.info { background: #3b82f6; }
    .timeline-marker.warning { background: #f59e0b; }

    .timeline-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .timeline-time {
        color: var(--text-secondary);
        font-size: 0.8rem;
    }

    /* Alert Styles */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
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
        .user-show-container {
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

        .header-actions {
            flex-direction: column;
            width: 100%;
        }

        .info-grid {
            grid-template-columns: 1fr;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* Animation */
    .info-container {
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

<div class="user-show-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                User Details
            </h1>
            <p class="page-subtitle">Complete information for: {{ $user->name }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn-header primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn-header">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to Users
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- User Profile -->
            <div class="profile-container">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                     alt="{{ $user->name }}" 
                     class="user-avatar-xl">
                
                <div class="user-name">{{ $user->name }}</div>
                <div class="user-email">{{ $user->email }}</div>
                
                <div class="role-badges">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <span class="role-badge role-{{ str_replace('_', '-', $role->name) }}">
                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                            </span>
                        @endforeach
                    @else
                        <span class="role-badge role-none">No Role</span>
                    @endif
                </div>
                
                <div class="status-badge {{ $user->email_verified_at ? 'status-active' : 'status-inactive' }}">
                    {{ $user->email_verified_at ? 'Active Account' : 'Inactive Account' }}
                </div>
                
                <div class="quick-actions">
                    <button class="quick-action-btn quick-action-warning reset-password-btn" 
                            data-user-id="{{ $user->id }}"
                            data-user-name="{{ $user->name }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Reset Password
                    </button>
                    
                    @if($user->id !== auth()->id())
                        <button class="quick-action-btn {{ $user->email_verified_at ? 'quick-action-secondary' : 'quick-action-success' }} toggle-status-btn"
                                data-user-id="{{ $user->id }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                @if($user->email_verified_at)
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18 12M6 6l12 12"/>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                @endif
                            </svg>
                            {{ $user->email_verified_at ? 'Deactivate User' : 'Activate User' }}
                        </button>
                    @endif
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="info-container">
                <div class="info-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Account Statistics
                </div>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->created_at->diffInDays() }}</div>
                        <div class="stat-label">Days Joined</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">{{ $user->updated_at->diffInHours() }}h</div>
                        <div class="stat-label">Last Update</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- User Information -->
            <div class="info-container">
                <div class="info-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    User Information
                </div>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nama Lengkap</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Alamat Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Account Status</div>
                        <div class="info-value">
                            <span class="status-badge {{ $user->email_verified_at ? 'status-active' : 'status-inactive' }}">
                                {{ $user->email_verified_at ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">User Role</div>
                        <div class="info-value">
                            @if($user->roles->count() > 0)
                                @foreach($user->roles as $role)
                                    <span class="role-badge role-{{ str_replace('_', '-', $role->name) }}">
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </span>
                                @endforeach
                            @else
                                <span class="role-badge role-none">No Role Assigned</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Joined Date</div>
                        <div class="info-value">{{ $user->created_at->format('M d, Y') }}</div>
                        <div class="info-meta">{{ $user->created_at->format('H:i') }} • {{ $user->created_at->diffForHumans() }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Terakhir Diperbarui</div>
                        <div class="info-value">{{ $user->updated_at->format('M d, Y') }}</div>
                        <div class="info-meta">{{ $user->updated_at->format('H:i') }} • {{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Role Permissions -->
            <div class="info-container">
                <div class="info-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Role Permissions & Access
                </div>
                
                @if($user->roles->count() > 0)
                    @foreach($user->roles as $role)
                        <div class="permissions-container">
                            <div class="permission-header">
                                <div class="permission-icon">
                                    @if($role->name === 'super_admin')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                        </svg>
                                    @elseif($role->name === 'admin')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                        </svg>
                                    @elseif($role->name === 'teacher')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <span class="role-badge role-{{ str_replace('_', '-', $role->name) }}">
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </span>
                                </div>
                            </div>
                            
                            @if($role->name === 'super_admin')
                                <div class="alert alert-danger">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                                    </svg>
                                    <div>
                                        <strong>Super Administrator</strong> has unrestricted access to the entire system with all permissions enabled.
                                    </div>
                                </div>
                            @else
                                <div class="permission-list">
                                    @if($role->name === 'admin')
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Manage content and posts
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Manage media and files
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Manage academic data
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-denied" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Manage system users
                                        </div>
                                    @elseif($role->name === 'teacher')
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Manage learning content
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Manage supervised student data
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Access academic features
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-denied" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Manage overall system
                                        </div>
                                    @else
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Access learning materials
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Register for extracurricular activities
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-allowed" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            View announcements and agenda
                                        </div>
                                        <div class="permission-item">
                                            <svg class="w-4 h-4 permission-denied" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                            Manage system content
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        <div>
                            This user has no assigned role. Please edit the user to assign an appropriate role.
                        </div>
                    </div>
                @endif
            </div>

            <!-- Activity Timeline -->
            <div class="info-container">
                <div class="info-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Activity Timeline
                </div>
                
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker success"></div>
                        <div class="timeline-title">Account Created</div>
                        <div class="timeline-time">{{ $user->created_at->format('M d, Y \a\t H:i') }}</div>
                    </div>
                    
                    @if($user->updated_at != $user->created_at)
                        <div class="timeline-item">
                            <div class="timeline-marker info"></div>
                            <div class="timeline-title">Terakhir Diperbarui</div>
                            <div class="timeline-time">{{ $user->updated_at->format('M d, Y \a\t H:i') }}</div>
                        </div>
                    @endif
                    
                    @if($user->email_verified_at)
                        <div class="timeline-item">
                            <div class="timeline-marker info"></div>
                            <div class="timeline-title">Email Verified</div>
                            <div class="timeline-time">{{ $user->email_verified_at->format('M d, Y \a\t H:i') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>




<script>
// Ensure jQuery is loaded
(function() {
    if (typeof jQuery === 'undefined') {
        console.error('⚠ jQuery is not loaded! Loading from CDN...');
        
        const script = document.createElement('script');
        script.src = 'https://code.jquery.com/jquery-3.6.0.min.js';
        script.onload = function() {
            console.log('✅ jQuery loaded dynamically');
            window.$ = window.jQuery = jQuery;
            initializeShowUserFunctions();
        };
        document.head.appendChild(script);
    } else {
        console.log('✅ jQuery already loaded');
        window.$ = window.jQuery = jQuery;
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeShowUserFunctions);
        } else {
            initializeShowUserFunctions();
        }
    }
})();

function initializeShowUserFunctions() {
    console.log('Initializing show user functions...');
    
    // Reset password
    let currentUserId = null;
    
    $('.reset-password-btn').click(function() {
        currentUserId = $(this).data('user-id');
        const userName = $(this).data('user-name');
        
        $('#resetUserName').text(userName);
        $('#resetPasswordModal').modal('show');
    });
    
    $('#confirmResetPassword').click(function() {
        if (!currentUserId) return;
        
        $.ajax({
            url: `/admin/users/${currentUserId}/reset-password`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#resetPasswordModal').modal('hide');
                    alert('Password reset successfully!');
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                alert('Error: ' + (response.message || 'An error occurred'));
            }
        });
    });
    
    // Toggle status
    $('.toggle-status-btn').click(function() {
        const userId = $(this).data('user-id');
        const button = $(this);
        
        if (confirm('Are you sure you want to change this user\'s status?')) {
            $.ajax({
                url: `/admin/users/${userId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('User status updated successfully!');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert('Error: ' + (response.message || 'An error occurred'));
                }
            });
        }
    });
}
</script>
@endsection