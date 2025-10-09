@extends('layouts.admin')

@section('title', 'Teacher Management')

@section('content')
<style>
    .teacher-container {
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
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
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
        color: #10b981;
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
        color: #10b981;
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
        background: linear-gradient(135deg, #d1fae5, #a7f3d0);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #10b981, #059669);
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

    /* Filters */
    .filters-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .filter-title {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        transition: color 0.3s ease;
    }

    .filter-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .filter-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .btn-filter {
        background: #3b82f6;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #2563eb;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Teacher Grid */
    .teacher-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .teacher-card {
        background: var(--bg-primary);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 20px var(--shadow-color);
        border: 1px solid var(--border-color);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .teacher-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .card-header {
        padding: 1.5rem;
        text-align: center;
        background: linear-gradient(135deg, var(--bg-secondary), var(--bg-tertiary));
        position: relative;
    }

    .teacher-photo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .photo-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-weight: 600;
        font-size: 1.5rem;
        border: 4px solid white;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .teacher-name {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .teacher-position {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
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
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .teacher-info {
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    .info-icon {
        width: 16px;
        height: 16px;
        color: #10b981;
    }

    .subject-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .subject-tag {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: auto;
        padding-top: 1rem;
        border-top: 1px solid var(--border-color);
    }

    .action-btn {
        flex: 1;
        padding: 0.5rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.25rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-edit {
        background: rgba(59, 130, 246, 0.1);
        color: #3b82f6;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .btn-edit:hover {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-delete:hover {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        transform: translateY(-1px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--bg-primary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        grid-column: 1 / -1;
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
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
        transition: color 0.3s ease;
    }

    .empty-description {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.6;
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

    .alert-dismissible .btn-close {
        background: none;
        border: none;
        font-size: 1.2rem;
        opacity: 0.6;
        cursor: pointer;
        color: inherit;
    }

    .alert-dismissible .btn-close:hover {
        opacity: 1;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .teacher-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .teacher-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .teacher-card {
        animation: slideUp 0.5s ease-out;
    }

    .teacher-card:nth-child(2n) {
        animation-delay: 0.1s;
    }

    .teacher-card:nth-child(3n) {
        animation-delay: 0.2s;
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

<div class="teacher-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
                Teacher & Staff Management
            </h1>
            <p class="page-subtitle">Manage teachers and staff members efficiently</p>
            <a href="{{ route('admin.teachers.create') }}" class="btn-primary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Add New Teacher
            </a>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $teachers->total() }}</div>
            <div class="stat-title">Total Teachers</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $teachers->where('status', 'active')->count() }}</div>
            <div class="stat-title">Active Teachers</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"/>
                </svg>
            </div>
            <div class="stat-value">{{ $teachers->where('status', 'inactive')->count() }}</div>
            <div class="stat-title">Inactive Teachers</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: #059669;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
            <div class="stat-value">{{ $teachers->pluck('subject')->unique()->count() }}</div>
            <div class="stat-title">Subjects Taught</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <h2 class="filter-title">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
            </svg>
            Filter & Search
        </h2>
        <form method="GET" action="{{ route('admin.teachers.index') }}">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Cari</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Cari nama, NIP, atau mata pelajaran..." 
                           class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Mata Pelajaran</label>
                    <select name="subject" class="filter-input">
                        <option value="">All Subjects</option>
                        @foreach($teachers->pluck('subject')->unique()->sort() as $subject)
                            <option value="{{ $subject }}" {{ request('subject') == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn-filter">
                            <svg class="w-4 h-4" style="display: inline; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Filter
                        </button>
                        <a href="{{ route('admin.teachers.index') }}" class="btn-reset">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
            <button type="button" class="btn-close" onclick="this.parentElement.style.display='none'">&times;</button>
        </div>
    @endif

    <!-- Teacher Grid -->
    <div class="teacher-grid">
        @if($teachers->count() > 0)
            @foreach($teachers as $teacher)
            <div class="teacher-card">
                <div class="card-header">
                    @if($teacher->photo)
                        <img src="{{ asset('storage/' . $teacher->photo) }}" 
                             alt="{{ $teacher->name }}" 
                             class="teacher-photo">
                    @else
                        <div class="photo-placeholder">
                            {{ $teacher->initials }}
                        </div>
                    @endif
                    <h3 class="teacher-name">{{ $teacher->name }}</h3>
                    <p class="teacher-position">{{ $teacher->position }}</p>
                    <span class="status-badge status-{{ $teacher->status }}">
                        {{ ucfirst($teacher->status) }}
                    </span>
                </div>
                
                <div class="card-body">
                    <div class="teacher-info">
                        @if($teacher->nip)
                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V4a2 2 0 114 0v2m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                </svg>
                                NIP: {{ $teacher->nip }}
                            </div>
                        @endif
                        
                        <div class="info-item">
                            <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ $teacher->email }}
                        </div>
                        
                        @if($teacher->phone)
                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $teacher->phone }}
                            </div>
                        @endif

                        @if($teacher->education)
                            <div class="info-item">
                                <svg class="info-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                </svg>
                                {{ $teacher->education }}
                            </div>
                        @endif
                    </div>

                    <div class="subject-tags">
                        @foreach(explode(',', $teacher->subject) as $subject)
                            <span class="subject-tag">{{ trim($subject) }}</span>
                        @endforeach
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="action-btn btn-edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit
                        </a>
                        <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" style="flex: 1;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete" style="width: 100%;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Teachers Found</h3>
                <p class="empty-description">
                    @if(request()->hasAny(['search', 'status', 'subject']))
                        No teachers match your current filters. Try adjusting your search criteria.
                    @else
                        Start building your teaching staff by adding your first teacher.
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'status', 'subject']))
                    <a href="{{ route('admin.teachers.create') }}" class="btn-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add First Teacher
                    </a>
                @else
                    <a href="{{ route('admin.teachers.index') }}" class="btn-reset">
                        Clear Filters
                    </a>
                @endif
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($teachers->hasPages())
        <div class="pagination-container">
            {{ $teachers->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this teacher? This action cannot be undone.')) {
                e.preventDefault();
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

    // Card hover effects
    const teacherCards = document.querySelectorAll('.teacher-card');
    teacherCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection