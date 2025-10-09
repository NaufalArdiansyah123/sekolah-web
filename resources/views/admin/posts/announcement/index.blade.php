@extends('layouts.admin')

@section('title', 'Announcement Management')

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
    .announcement-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Header Section */
    .page-header {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .header-top {
        display: flex;
        justify-content: between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        align-items: center;
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
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .stat-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .stat-icon.blue { background: var(--accent-color); }
    .stat-icon.green { background: var(--success-color); }
    .stat-icon.yellow { background: var(--warning-color); }
    .stat-icon.red { background: var(--danger-color); }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin: 0;
    }

    /* Filters */
    .filters-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-input {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.75rem;
        font-size: 0.875rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: border-color 0.15s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Content Section */
    .content-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    /* Table */
    .table-wrapper {
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        font-weight: 600;
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        font-size: 0.875rem;
        white-space: nowrap;
    }

    .data-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: top;
    }

    .data-table tbody tr:hover {
        background: var(--bg-secondary);
    }

    /* Content Cells */
    .announcement-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .announcement-excerpt {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .has-image {
        color: var(--warning-color);
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        margin-top: 0.25rem;
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

    .badge-akademik { background: rgba(59, 130, 246, 0.1); color: #1d4ed8; }
    .badge-kegiatan { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-administrasi { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .badge-umum { background: rgba(107, 114, 128, 0.1); color: #374151; }

    .badge-urgent { background: rgba(239, 68, 68, 0.1); color: #dc2626; }
    .badge-high { background: rgba(245, 158, 11, 0.1); color: #d97706; }
    .badge-normal { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-low { background: rgba(107, 114, 128, 0.1); color: #6b7280; }

    .badge-published { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-draft { background: rgba(107, 114, 128, 0.1); color: #6b7280; }
    .badge-archived { background: rgba(75, 85, 99, 0.1); color: #374151; }

    .views-count {
        background: var(--accent-color);
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Date Display */
    .date-display {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    .time-display {
        font-size: 0.75rem;
        color: var(--text-tertiary);
    }

    /* Actions */
    .actions-cell {
        white-space: nowrap;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-sm {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        border-radius: 6px;
    }

    .btn-view {
        background: rgba(59, 130, 246, 0.1);
        color: #1d4ed8;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px var(--shadow-color);
    }

    /* Dropdown */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        padding: 0.5rem;
        border-radius: 6px;
        cursor: pointer;
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        right: 0;
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 4px 12px var(--shadow-color);
        min-width: 150px;
        z-index: 1000;
        display: none;
        margin-top: 0.25rem;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1rem;
        color: var(--text-primary);
        text-decoration: none;
        font-size: 0.875rem;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .dropdown-item:hover {
        background: var(--bg-secondary);
        color: var(--text-primary);
    }

    .dropdown-item.danger {
        color: var(--danger-color);
    }

    .dropdown-divider {
        height: 1px;
        background: var(--border-color);
        margin: 0.25rem 0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 4rem;
        height: 4rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: var(--text-tertiary);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-message {
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
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

    .alert-close {
        background: none;
        border: none;
        font-size: 1.25rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.7;
        margin-left: auto;
    }

    .alert-close:hover {
        opacity: 1;
    }

    /* Pagination */
    .pagination-wrapper {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: center;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .announcement-page {
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

        .page-title {
            font-size: 1.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .data-table {
            min-width: 800px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 0.25rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons .btn-sm {
            font-size: 0.7rem;
            padding: 0.375rem 0.5rem;
        }
    }

    /* Loading State */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="announcement-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-top">
            <div>
                <h1 class="page-title">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                    Announcements
                </h1>
                <p class="page-subtitle">Manage school announcements and notifications</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    New Announcement
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon blue">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $announcements->total() }}</h3>
            <p class="stat-label">Total Announcements</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $announcements->where('status', 'published')->count() }}</h3>
            <p class="stat-label">Dipublikasikan</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon yellow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $announcements->where('status', 'draft')->count() }}</h3>
            <p class="stat-label">Drafts</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon red">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $announcements->sum('views') ?? 0 }}</h3>
            <p class="stat-label">Total Views</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.announcements.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">Cari</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman..." class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="category" class="form-input">
                        <option value="">All Categories</option>
                        <option value="akademik" {{ request('category') == 'akademik' ? 'selected' : '' }}>Academic</option>
                        <option value="kegiatan" {{ request('category') == 'kegiatan' ? 'selected' : '' }}>Activities</option>
                        <option value="administrasi" {{ request('category') == 'administrasi' ? 'selected' : '' }}>Administration</option>
                        <option value="umum" {{ request('category') == 'umum' ? 'selected' : '' }}>General</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Dipublikasikan</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draf</option>
                        <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Priority</label>
                    <select name="priority" class="form-input">
                        <option value="">All Priorities</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
            <button type="button" class="alert-close" onclick="this.parentElement.remove()">&times;</button>
        </div>
    @endif

    <!-- Content -->
    <div class="content-section">
        @if($announcements->count() > 0)
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 35%">Title & Content</th>
                            <th style="width: 12%">Kategori</th>
                            <th style="width: 10%">Priority</th>
                            <th style="width: 12%">Author</th>
                            <th style="width: 8%">Status</th>
                            <th style="width: 8%">Views</th>
                            <th style="width: 10%">Tanggal</th>
                            <th style="width: 10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($announcements as $index => $announcement)
                        <tr>
                            <td>{{ $announcements->firstItem() + $index }}</td>
                            <td>
                                <div class="announcement-title">{{ Str::limit($announcement->judul, 50) }}</div>
                                <div class="announcement-excerpt">{{ Str::limit(strip_tags($announcement->isi), 80) }}</div>
                                @if($announcement->gambar)
                                    <div class="has-image">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Has image
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ $announcement->kategori }}">
                                    {{ ucfirst($announcement->kategori) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $announcement->prioritas }}">
                                    {{ ucfirst($announcement->prioritas) }}
                                </span>
                            </td>
                            <td>{{ $announcement->penulis }}</td>
                            <td>
                                <span class="badge badge-{{ $announcement->status }}">
                                    {{ ucfirst($announcement->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="views-count">{{ $announcement->views ?? 0 }}</span>
                            </td>
                            <td>
                                <div class="date-display">
                                    {{ $announcement->tanggal_publikasi ? $announcement->tanggal_publikasi->format('M d, Y') : $announcement->created_at->format('M d, Y') }}
                                </div>
                                <div class="time-display">
                                    {{ $announcement->tanggal_publikasi ? $announcement->tanggal_publikasi->format('H:i') : $announcement->created_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.announcements.show', $announcement->id) }}" class="btn btn-sm btn-view" title="View">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.announcements.edit', $announcement->id) }}" class="btn btn-sm btn-edit" title="Edit">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle" onclick="toggleDropdown({{ $announcement->id }})" title="More">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                                            </svg>
                                        </button>
                                        <div class="dropdown-menu" id="dropdown-{{ $announcement->id }}">
                                            <button class="dropdown-item toggle-status" data-id="{{ $announcement->id }}" data-status="{{ $announcement->status }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                                                </svg>
                                                {{ $announcement->status === 'published' ? 'Set Draft' : 'Publish' }}
                                            </button>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('admin.announcements.destroy', $announcement->id) }}" method="POST" class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item danger">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($announcements->hasPages())
                <div class="pagination-wrapper">
                    {{ $announcements->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Announcements Found</h3>
                <p class="empty-message">
                    @if(request()->hasAny(['search', 'category', 'status', 'priority']))
                        No announcements match your current filters. Try adjusting your search criteria.
                    @else
                        Start creating announcements to keep your school community informed.
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'category', 'status', 'priority']))
                    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create First Announcement
                    </a>
                @else
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-secondary">Clear Filters</a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm('Are you sure you want to delete this announcement?')) {
                e.preventDefault();
            }
        });
    });

    // Toggle status
    document.querySelectorAll('.toggle-status').forEach(function(button) {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const currentStatus = this.dataset.status;
            const newStatus = currentStatus === 'published' ? 'draft' : 'published';
            
            if (confirm(`Change status to ${newStatus}?`)) {
                const originalText = this.innerHTML;
                this.innerHTML = '<span class="spinner"></span> Updating...';
                this.disabled = true;

                fetch(`/admin/announcements/${id}/toggle-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to update status');
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    alert('An error occurred');
                    this.innerHTML = originalText;
                    this.disabled = false;
                });
            }
        });
    });

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });

    // Auto-hide alerts
    setTimeout(function() {
        document.querySelectorAll('.alert').forEach(function(alert) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.remove();
            }, 300);
        });
    }, 5000);
});

function toggleDropdown(id) {
    const dropdown = document.getElementById('dropdown-' + id);
    const isShown = dropdown.classList.contains('show');
    
    // Close all dropdowns
    document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
        menu.classList.remove('show');
    });
    
    // Toggle current dropdown
    if (!isShown) {
        dropdown.classList.add('show');
    }
}
</script>
@endsection