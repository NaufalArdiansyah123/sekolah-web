@extends('layouts.admin')

@section('title', 'Sejarah Sekolah Management')

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
        --accent-color: #8b5cf6;
        --accent-hover: #7c3aed;
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
    .history-page {
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
        justify-content: space-between;
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

    .stat-icon.purple { background: var(--accent-color); }
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
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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
    .history-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.4;
    }

    .history-preview {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .has-sections {
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

    .badge-active { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .badge-inactive { background: rgba(107, 114, 128, 0.1); color: #6b7280; }

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
        background: rgba(139, 92, 246, 0.1);
        color: var(--accent-hover);
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    .btn-edit {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .btn-activate {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .btn-deactivate {
        background: rgba(107, 114, 128, 0.1);
        color: #6b7280;
        border: 1px solid rgba(107, 114, 128, 0.2);
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

    .alert-warning {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
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
        .history-page {
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

<div class="history-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-top">
            <div>
                <h1 class="page-title">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Sejarah Sekolah
                </h1>
                <p class="page-subtitle">Kelola sejarah, timeline, dan pencapaian sekolah</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.history.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Sejarah Baru
                </a>
                @if($activeHistory)
                    <a href="{{ route('about.sejarah') }}" target="_blank" class="btn btn-success">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Lihat Publik
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon purple">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $histories->total() }}</h3>
            <p class="stat-label">Total Sejarah</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon green">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $histories->where('is_active', true)->count() }}</h3>
            <p class="stat-label">Aktif</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon yellow">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $histories->where('is_active', false)->count() }}</h3>
            <p class="stat-label">Tidak Aktif</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon red">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <h3 class="stat-value">{{ $histories->where('updated_at', '>=', now()->subDays(7))->count() }}</h3>
            <p class="stat-label">Diperbarui Minggu Ini</p>
        </div>
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

    <!-- Active History Info -->
    @if($activeHistory)
        <div class="alert alert-success">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <div>
                <strong>Sejarah Aktif:</strong> {{ $activeHistory->title }}
                <br><small>Terakhir diperbarui: {{ $activeHistory->updated_at->format('d M Y H:i') }}</small>
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <strong>Tidak ada sejarah aktif!</strong> Silakan buat sejarah baru atau aktifkan yang sudah ada.
        </div>
    @endif

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.history.index') }}">
            <div class="filters-grid">
                <div class="form-group">
                    <label class="form-label">Pencarian</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari sejarah..." class="form-input">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-input">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.history.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Content -->
    <div class="content-section">
        @if($histories->count() > 0)
            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 5%">#</th>
                            <th style="width: 35%">Judul & Konten</th>
                            <th style="width: 15%">Bagian</th>
                            <th style="width: 10%">Status</th>
                            <th style="width: 15%">Terakhir Diperbarui</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $index => $history)
                        <tr>
                            <td>{{ $histories->firstItem() + $index }}</td>
                            <td>
                                <div class="history-title">{{ Str::limit($history->title, 40) }}</div>
                                @if($history->content)
                                    <div class="history-preview">{{ Str::limit(strip_tags($history->content), 80) }}</div>
                                @endif
                                @if($history->hero_image)
                                    <div class="has-sections">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        Ada gambar hero
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    @if($history->timeline_events && count($history->timeline_events) > 0)
                                        <small class="badge" style="background: rgba(139, 92, 246, 0.1); color: #7c3aed;">
                                            {{ count($history->timeline_events) }} Timeline
                                        </small>
                                    @endif
                                    @if($history->milestones && count($history->milestones) > 0)
                                        <small class="badge" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                            {{ count($history->milestones) }} Tonggak
                                        </small>
                                    @endif
                                    @if($history->achievements && count($history->achievements) > 0)
                                        <small class="badge" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                                            {{ count($history->achievements) }} Prestasi
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <span class="badge badge-{{ $history->is_active ? 'active' : 'inactive' }}">
                                    {{ $history->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="date-display">
                                    {{ $history->updated_at->format('d M Y') }}
                                </div>
                                <div class="time-display">
                                    {{ $history->updated_at->format('H:i') }}
                                </div>
                            </td>
                            <td class="actions-cell">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.history.show', $history) }}" class="btn btn-sm btn-view" title="Lihat">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.history.edit', $history) }}" class="btn btn-sm btn-edit" title="Edit">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </a>
                                    @if(!$history->is_active)
                                        <button type="button" class="btn btn-sm btn-activate" onclick="activateHistory({{ $history->id }})" title="Aktifkan">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-deactivate" onclick="deactivateHistory({{ $history->id }})" title="Nonaktifkan">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    @endif
                                    <button type="button" class="btn btn-sm btn-delete" onclick="deleteHistory({{ $history->id }}, '{{ $history->title }}')" title="Hapus">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

            @if($histories->hasPages())
                <div class="pagination-wrapper">
                    {{ $histories->appends(request()->query())->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="empty-title">Tidak Ada Sejarah Ditemukan</h3>
                <p class="empty-message">
                    @if(request()->hasAny(['search', 'status']))
                        Tidak ada sejarah yang sesuai dengan filter saat ini. Coba sesuaikan kriteria pencarian.
                    @else
                        Mulai membuat sejarah sekolah untuk mendokumentasikan perjalanan institusi.
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'status']))
                    <a href="{{ route('admin.history.create') }}" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Buat Sejarah Pertama
                    </a>
                @else
                    <a href="{{ route('admin.history.index') }}" class="btn btn-secondary">Hapus Filter</a>
                @endif
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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

function activateHistory(id) {
    if (confirm('Aktifkan sejarah ini? Sejarah yang sedang aktif akan dinonaktifkan.')) {
        const button = event.target.closest('button');
        const originalHtml = button.innerHTML;
        button.innerHTML = '<span class="spinner"></span>';
        button.disabled = true;
        
        fetch(`/admin/history/${id}/activate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotificationFromResponse(data);
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Gagal mengaktifkan sejarah');
                button.innerHTML = originalHtml;
                button.disabled = false;
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
            button.innerHTML = originalHtml;
            button.disabled = false;
        });
    }
}

function deactivateHistory(id) {
    if (confirm('Nonaktifkan sejarah ini?')) {
        const button = event.target.closest('button');
        const originalHtml = button.innerHTML;
        button.innerHTML = '<span class="spinner"></span>';
        button.disabled = true;
        
        fetch(`/admin/history/${id}/deactivate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotificationFromResponse(data);
                setTimeout(() => location.reload(), 1500);
            } else {
                alert('Gagal menonaktifkan sejarah');
                button.innerHTML = originalHtml;
                button.disabled = false;
            }
        })
        .catch(error => {
            alert('Terjadi kesalahan');
            button.innerHTML = originalHtml;
            button.disabled = false;
        });
    }
}

function deleteHistory(id, title) {
    if (confirm(`Apakah Anda yakin ingin menghapus "${title}"? Tindakan ini tidak dapat dibatalkan.`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/history/${id}`;
        
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
</script>
@endsection