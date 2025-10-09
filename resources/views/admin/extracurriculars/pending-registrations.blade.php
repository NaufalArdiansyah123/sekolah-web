@extends('layouts.admin')

@section('title', 'Pendaftaran Ekstrakurikuler')

@section('content')
<style>
    .registrations-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header-info h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .header-info p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-header {
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
        cursor: pointer;
    }

    .btn-header:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #3b82f6;
        text-decoration: none;
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent-color);
    }

    .stat-card.pending::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-card.approved::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-card.rejected::before { background: linear-gradient(90deg, #ef4444, #dc2626); }
    .stat-card.total::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .stat-icon.pending { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.approved { background: linear-gradient(135deg, #10b981, #059669); }
    .stat-icon.rejected { background: linear-gradient(135deg, #ef4444, #dc2626); }
    .stat-icon.total { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* Filters */
    .filters-section {
        background: var(--bg-primary);
        padding: 1.5rem;
        border-radius: 16px;
        border: 1px solid var(--border-color);
        margin-bottom: 2rem;
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .filters-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .filter-input {
        padding: 0.75rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-secondary);
        color: var(--text-primary);
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .btn-filter {
        background: #3b82f6;
        color: white;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    /* Table */
    .table-container {
        background: var(--bg-primary);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .table-header {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
    }

    .bulk-actions {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-bulk {
        padding: 0.5rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-bulk:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-bulk.approve:hover {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    .btn-bulk.reject:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .registrations-table {
        width: 100%;
        border-collapse: collapse;
    }

    .registrations-table th {
        background: var(--bg-tertiary);
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .registrations-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        vertical-align: middle;
    }

    .registrations-table tr:hover {
        background: var(--bg-secondary);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .student-details h6 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        color: var(--text-primary);
    }

    .student-details small {
        color: var(--text-secondary);
        font-size: 0.75rem;
    }

    .extracurricular-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .extracurricular-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge.pending {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.approved {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.rejected {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
        justify-content: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        background: var(--bg-primary);
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .action-btn.view:hover {
        background: #06b6d4;
        color: white;
        border-color: #06b6d4;
    }

    .action-btn.approve:hover {
        background: #10b981;
        color: white;
        border-color: #10b981;
    }

    .action-btn.reject:hover {
        background: #ef4444;
        color: white;
        border-color: #ef4444;
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

    /* Responsive */
    @media (max-width: 768px) {
        .registrations-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-grid {
            grid-template-columns: 1fr;
        }

        .table-header {
            flex-direction: column;
            gap: 1rem;
        }

        .bulk-actions {
            justify-content: center;
        }
    }
</style>

<div class="registrations-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1>
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Pendaftaran Ekstrakurikuler
                </h1>
                <p>Kelola dan proses pendaftaran siswa untuk kegiatan ekstrakurikuler</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('admin.extracurriculars.index') }}" class="btn-header">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Ekstrakurikuler
                </a>
                <button class="btn-header" onclick="exportRegistrations()">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Data
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="stats-grid">
        <div class="stat-card pending">
            <div class="stat-header">
                <div class="stat-icon pending">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $pendingRegistrations }}</div>
            <div class="stat-label">Menunggu Persetujuan</div>
        </div>

        <div class="stat-card approved">
            <div class="stat-header">
                <div class="stat-icon approved">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $approvedRegistrations }}</div>
            <div class="stat-label">Disetujui</div>
        </div>

        <div class="stat-card rejected">
            <div class="stat-header">
                <div class="stat-icon rejected">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $rejectedRegistrations }}</div>
            <div class="stat-label">Ditolak</div>
        </div>

        <div class="stat-card total">
            <div class="stat-header">
                <div class="stat-icon total">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
            <div class="stat-value">{{ $totalRegistrations }}</div>
            <div class="stat-label">Total Pendaftaran</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-section">
        <form method="GET" action="{{ route('admin.extracurriculars.registrations.page') }}">
            <div class="filters-grid">
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="pending" {{ request('status', 'pending') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Ekstrakurikuler</label>
                    <select name="extracurricular_id" class="filter-input">
                        <option value="">Semua Ekstrakurikuler</option>
                        @foreach($extracurriculars as $extracurricular)
                            <option value="{{ $extracurricular->id }}" {{ request('extracurricular_id') == $extracurricular->id ? 'selected' : '' }}>
                                {{ $extracurricular->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label class="filter-label">Kelas</label>
                    <input type="text" name="student_class" class="filter-input" placeholder="Cari kelas..." value="{{ request('student_class') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">Pencarian</label>
                    <input type="text" name="search" class="filter-input" placeholder="Nama, NIS, atau Email..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button type="submit" class="btn-filter">
                        <svg class="w-4 h-4" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- Registrations Table -->
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">
                Daftar Pendaftaran 
                @if(request('status') && request('status') !== 'all')
                    - {{ ucfirst(request('status')) }}
                @endif
                ({{ $registrations->total() }})
            </h3>
            @if($registrations->where('status', 'pending')->count() > 0)
                <div class="bulk-actions">
                    <button class="btn-bulk approve" onclick="bulkApprove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Setujui Terpilih
                    </button>
                    <button class="btn-bulk reject" onclick="bulkReject()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Terpilih
                    </button>
                </div>
            @endif
        </div>

        @if($registrations->count() > 0)
            <div class="table-wrapper">
                <table class="registrations-table">
                    <thead>
                        <tr>
                            @if($registrations->where('status', 'pending')->count() > 0)
                                <th width="50">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                </th>
                            @endif
                            <th>Siswa</th>
                            <th>Ekstrakurikuler</th>
                            <th>Kelas</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            <tr>
                                @if($registrations->where('status', 'pending')->count() > 0)
                                    <td>
                                        @if($registration->status === 'pending')
                                            <input type="checkbox" class="registration-checkbox" value="{{ $registration->id }}">
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            {{ strtoupper(substr($registration->student_name, 0, 2)) }}
                                        </div>
                                        <div class="student-details">
                                            <h6>{{ $registration->student_name }}</h6>
                                            <small>NIS: {{ $registration->student_nis }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="extracurricular-info">
                                        <div class="extracurricular-icon">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $registration->extracurricular->name }}</div>
                                            <small style="color: var(--text-secondary);">{{ $registration->extracurricular->coach }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="badge bg-primary">{{ $registration->student_class }}</span>
                                        <br>
                                        <span class="badge bg-secondary mt-1">{{ $registration->student_major }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 0.875rem;">
                                        <div>{{ Str::limit($registration->email, 20) }}</div>
                                        <div style="color: var(--text-secondary);">{{ $registration->phone }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge {{ $registration->status }}">
                                        {{ ucfirst($registration->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="font-size: 0.875rem;">
                                        <div>{{ $registration->created_at->format('d M Y') }}</div>
                                        <div style="color: var(--text-secondary);">{{ $registration->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="action-btn view" onclick="viewRegistration({{ $registration->id }})" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </button>
                                        @if($registration->status === 'pending')
                                            <button class="action-btn approve" onclick="approveRegistration({{ $registration->id }})" title="Setujui">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                            <button class="action-btn reject" onclick="rejectRegistration({{ $registration->id }})" title="Tolak">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($registrations->hasPages())
                <div style="padding: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: center;">
                    {{ $registrations->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h3 style="color: var(--text-primary); margin-bottom: 0.5rem;">Tidak Ada Pendaftaran</h3>
                <p>Belum ada pendaftaran ekstrakurikuler yang sesuai dengan filter yang dipilih.</p>
            </div>
        @endif
    </div>
</div>

<!-- Registration Detail Modal -->
<div class="modal fade" id="registrationDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
            <div class="modal-header" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" style="color: var(--text-primary);">Detail Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="registrationDetailContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Select All Functionality
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.registration-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

// Get Selected Registration IDs
function getSelectedRegistrations() {
    const checkboxes = document.querySelectorAll('.registration-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// View Registration Detail
function viewRegistration(registrationId) {
    const modal = new bootstrap.Modal(document.getElementById('registrationDetailModal'));
    const content = document.getElementById('registrationDetailContent');
    
    // Show loading
    content.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Memuat...</span>
            </div>
            <p class="mt-2">Memuat detail pendaftaran...</p>
        </div>
    `;
    
    modal.show();
    
    // Fetch registration detail
    fetch(`/admin/extracurriculars/registration/${registrationId}/detail`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        return response.text();
    })
    .then(html => {
        content.innerHTML = html;
    })
    .catch(error => {
        console.error('Error loading registration detail:', error);
        content.innerHTML = `
            <div class="alert alert-danger">
                <h6>Error Loading Detail</h6>
                <p>Failed to load registration detail: ${error.message}</p>
                <button class="btn btn-secondary" onclick="viewRegistration(${registrationId})">Retry</button>
            </div>
        `;
    });
}

// Approve Single Registration
function approveRegistration(registrationId) {
    if (confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')) {
        fetch(`/admin/extracurriculars/registration/${registrationId}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error approving registration:', error);
            showAlert('error', 'Gagal menyetujui pendaftaran: ' + error.message);
        });
    }
}

// Reject Single Registration
function rejectRegistration(registrationId) {
    const reason = prompt('Alasan penolakan (opsional):');
    if (reason !== null) {
        fetch(`/admin/extracurriculars/registration/${registrationId}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ notes: reason })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error rejecting registration:', error);
            showAlert('error', 'Gagal menolak pendaftaran: ' + error.message);
        });
    }
}

// Bulk Approve
function bulkApprove() {
    const selectedIds = getSelectedRegistrations();
    
    if (selectedIds.length === 0) {
        showAlert('warning', 'Pilih minimal satu pendaftaran untuk disetujui.');
        return;
    }
    
    if (confirm(`Apakah Anda yakin ingin menyetujui ${selectedIds.length} pendaftaran yang dipilih?`)) {
        fetch('/admin/extracurriculars-registrations/bulk-approve', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ registration_ids: selectedIds })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                setTimeout(() => location.reload(), 1000);
            } else {
                showAlert('error', data.message);
            }
        })
        .catch(error => {
            console.error('Error bulk approving:', error);
            showAlert('error', 'Gagal menyetujui pendaftaran: ' + error.message);
        });
    }
}

// Bulk Reject
function bulkReject() {
    const selectedIds = getSelectedRegistrations();
    
    if (selectedIds.length === 0) {
        showAlert('warning', 'Pilih minimal satu pendaftaran untuk ditolak.');
        return;
    }
    
    const reason = prompt('Alasan penolakan (opsional):');
    if (reason !== null) {
        if (confirm(`Apakah Anda yakin ingin menolak ${selectedIds.length} pendaftaran yang dipilih?`)) {
            fetch('/admin/extracurriculars-registrations/bulk-reject', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ 
                    registration_ids: selectedIds,
                    notes: reason 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showAlert('error', data.message);
                }
            })
            .catch(error => {
                console.error('Error bulk rejecting:', error);
                showAlert('error', 'Gagal menolak pendaftaran: ' + error.message);
            });
        }
    }
}

// Export Registrations
function exportRegistrations() {
    showAlert('info', 'Fitur export akan segera tersedia!');
}

// Show Alert
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 
                     type === 'error' ? 'alert-danger' : 
                     type === 'warning' ? 'alert-warning' : 'alert-info';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert alert at the top of the container
    const container = document.querySelector('.registrations-container');
    const firstChild = container.firstElementChild;
    firstChild.insertAdjacentHTML('afterend', alertHtml);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        const alert = container.querySelector('.alert');
        if (alert) {
            alert.remove();
        }
    }, 5000);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Pendaftaran Ekstrakurikuler page loaded');
    
    // Add any initialization code here
});
</script>
@endsection