@extends('layouts.admin')

@section('title', 'Log Absensi Guru')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="page-header mb-4">
        <div class="header-actions">
            <button type="button" class="btn-modern btn-primary" onclick="exportLogs()">
                <i class="fas fa-download"></i>
                <span>Export</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-modern btn-secondary">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
        <div class="header-content">
            <h1 class="page-title">Log Absensi Guru</h1>
            <p class="page-subtitle">Kelola dan pantau absensi guru secara realtime</p>
        </div>
        <div class="header-actions justify-end">
            <a href="{{ route('admin.qr-scanner') }}" class="btn-modern btn-success">
                <i class="fas fa-qrcode"></i>
                <span>QR Scanner</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-container mb-4">
        <div class="stat-card stat-primary">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Guru</span>
                <span class="stat-value">{{ $stats['total'] ?? 0 }}</span>
            </div>
        </div>
        <div class="stat-card stat-success">
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Hadir</span>
                <span class="stat-value">{{ $stats['hadir'] ?? 0 }}</span>
            </div>
        </div>
        <div class="stat-card stat-info">
            <div class="stat-icon">
                <i class="fas fa-file-alt"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Izin</span>
                <span class="stat-value">{{ $stats['izin'] ?? 0 }}</span>
            </div>
        </div>
        <div class="stat-card stat-warning">
            <div class="stat-icon">
                <i class="fas fa-user-injured"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Sakit</span>
                <span class="stat-value">{{ $stats['sakit'] ?? 0 }}</span>
            </div>
        </div>
        <div class="stat-card stat-danger">
            <div class="stat-icon">
                <i class="fas fa-user-times"></i>
            </div>
            <div class="stat-info">
                <span class="stat-label">Alpha</span>
                <span class="stat-value">{{ $stats['alpha'] ?? 0 }}</span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-modern mb-4">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-filter"></i>
                <span>Filter Log Absensi</span>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.logs') }}" id="filterForm">
                <div class="filter-container">
                    <div class="form-group">
                        <label class="form-label">Tanggal</label>
                        <div class="input-wrapper">
                            <i class="input-icon fas fa-calendar"></i>
                            <input type="date" class="form-input" id="date" name="date"
                                   value="{{ request('date', today()->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="input-wrapper">
                            <i class="input-icon fas fa-tag"></i>
                            <select class="form-input" id="status" name="status">
                                <option value="">Semua Status</option>
                                <option value="hadir" {{ request('status') == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="izin" {{ request('status') == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ request('status') == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ request('status') == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Guru</label>
                        <div class="input-wrapper">
                            <i class="input-icon fas fa-user"></i>
                            <select class="form-input" id="teacher" name="teacher">
                                <option value="">Semua Guru</option>
                                @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Cari</label>
                        <div class="input-wrapper">
                            <i class="input-icon fas fa-search"></i>
                            <input type="text" class="form-input" id="search" name="search"
                                   placeholder="Cari guru..." value="{{ request('search') }}">
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-modern btn-primary">
                        <i class="fas fa-search"></i>
                        <span>Terapkan Filter</span>
                    </button>
                    <a href="{{ route('admin.logs') }}" class="btn-modern btn-secondary">
                        <i class="fas fa-undo"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card-modern">
        <div class="card-header">
            <div class="card-title">
                <i class="fas fa-table"></i>
                <span>Data Log Absensi</span>
            </div>
            <span class="card-subtitle">Menampilkan {{ $logs->count() }} data absensi</span>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Guru</th>
                        <th>Tanggal</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $index => $log)
                    <tr>
                        <td><span class="text-muted">{{ $logs->firstItem() + $index }}</span></td>
                        <td>
                            <div class="user-info">
                                <div class="user-avatar">{{ substr($log->teacher->name, 0, 1) }}</div>
                                <span class="user-name">{{ $log->teacher->name }}</span>
                            </div>
                        </td>
                        <td><span class="text-muted">{{ $log->attendance_date->format('d/m/Y') }}</span></td>
                        <td>
                            <span class="badge badge-in">
                                <i class="fas fa-sign-in-alt"></i>
                                {{ $log->scan_time }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-out">
                                <i class="fas fa-sign-out-alt"></i>
                                {{ $log->check_out_time ? $log->check_out_time->format('H:i:s') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-duration">
                                <i class="fas fa-clock"></i>
                                {{ $log->duration }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'hadir' => ['class' => 'badge-success', 'icon' => 'fa-check-circle'],
                                    'izin' => ['class' => 'badge-info', 'icon' => 'fa-info-circle'],
                                    'sakit' => ['class' => 'badge-warning', 'icon' => 'fa-exclamation-circle'],
                                    'alpha' => ['class' => 'badge-danger', 'icon' => 'fa-times-circle'],
                                ];
                                $config = $statusConfig[$log->status] ?? ['class' => 'badge-secondary', 'icon' => 'fa-circle'];
                            @endphp
                            <span class="badge {{ $config['class'] }}">
                                <i class="fas {{ $config['icon'] }}"></i>
                                {{ ucfirst($log->status) }}
                            </span>
                        </td>
                        <td>
                            <span class="location-text">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $log->location ?? '-' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <p>Tidak ada data absensi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="card-footer">
            {{ $logs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function exportLogs() {
    const params = new URLSearchParams();

    const date = $('#date').val();
    const status = $('#status').val();
    const teacher = $('#teacher').val();
    const search = $('#search').val();

    if (date) params.append('date', date);
    if (status) params.append('status', status);
    if (teacher) params.append('teacher', teacher);
    if (search) params.append('search', search);

    const exportUrl = '{{ route("admin.logs.export") }}?' + params.toString();
    window.open(exportUrl, '_blank');
}

function showToast(message, type = 'success') {
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-times-circle',
        info: 'fa-info-circle'
    };

    const colors = {
        success: '#10b981',
        error: '#ef4444',
        info: '#3b82f6'
    };

    const toast = `
        <div class="toast-notification" style="border-left-color: ${colors[type]}">
            <i class="fas ${icons[type]}" style="color: ${colors[type]}"></i>
            <span>${message}</span>
        </div>
    `;

    const $toast = $(toast);
    $('body').append($toast);

    setTimeout(() => $toast.addClass('show'), 10);
    setTimeout(() => {
        $toast.removeClass('show');
        setTimeout(() => $toast.remove(), 300);
    }, 3000);
}
</script>
@endpush

@push('styles')
<style>
/* Color Variables */
:root {
    --primary: #4f46e5;
    --primary-dark: #4338ca;
    --success: #10b981;
    --success-dark: #059669;
    --info: #3b82f6;
    --info-dark: #2563eb;
    --warning: #f59e0b;
    --warning-dark: #d97706;
    --danger: #ef4444;
    --danger-dark: #dc2626;
    --dark: #1f2937;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --white: #ffffff;
}

/* Base Styles */
body {
    background: var(--gray-50);
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    color: var(--dark);
    line-height: 1.6;
}

/* Page Header */
.page-header {
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 2rem;
    align-items: center;
    padding-bottom: 1.5rem;
    border-bottom: 2px solid var(--gray-200);
}

.header-actions {
    display: flex;
    gap: 0.75rem;
}

.header-actions.justify-end {
    justify-content: flex-end;
}

.header-content {
    text-align: center;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0 0 0.25rem 0;
}

.page-subtitle {
    font-size: 0.9rem;
    color: var(--gray-500);
    margin: 0;
}

/* Modern Buttons */
.btn-modern {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.625rem 1.25rem;
    font-size: 0.9rem;
    font-weight: 500;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-modern i {
    font-size: 0.875rem;
}

.btn-primary {
    background: var(--primary);
    color: var(--white);
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-success {
    background: var(--success);
    color: var(--white);
}

.btn-success:hover {
    background: var(--success-dark);
    transform: translateY(-1px);
}

.btn-secondary {
    background: var(--gray-100);
    color: var(--gray-600);
}

.btn-secondary:hover {
    background: var(--gray-200);
    transform: translateY(-1px);
}

/* Stats Container */
.stats-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
}

.stat-card {
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-icon {
    width: 52px;
    height: 52px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: var(--white);
    flex-shrink: 0;
}

.stat-primary .stat-icon {
    background: var(--primary);
}

.stat-success .stat-icon {
    background: var(--success);
}

.stat-info .stat-icon {
    background: var(--info);
}

.stat-warning .stat-icon {
    background: var(--warning);
}

.stat-danger .stat-icon {
    background: var(--danger);
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.stat-label {
    font-size: 0.875rem;
    color: var(--gray-500);
    font-weight: 500;
}

.stat-value {
    font-size: 1.875rem;
    font-weight: 700;
    color: var(--dark);
    line-height: 1;
}

/* Modern Card */
.card-modern {
    background: var(--white);
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    padding: 1.25rem 1.5rem;
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
    font-weight: 600;
    color: var(--dark);
}

.card-title i {
    color: var(--primary);
}

.card-subtitle {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.card-body {
    padding: 1.5rem;
}

.card-footer {
    padding: 1rem 1.5rem;
    background: var(--gray-50);
    border-top: 1px solid var(--gray-200);
}

/* Form Elements */
.filter-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--dark);
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--gray-400);
    font-size: 0.875rem;
}

.form-input {
    width: 100%;
    padding: 0.625rem 1rem 0.625rem 2.5rem;
    border: 1.5px solid var(--gray-300);
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: var(--white);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
}

.form-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

/* Table */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table thead {
    background: var(--gray-50);
}

.data-table th {
    padding: 1rem 1.5rem;
    text-align: left;
    font-size: 0.8125rem;
    font-weight: 600;
    color: var(--gray-600);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-bottom: 1px solid var(--gray-200);
}

.data-table td {
    padding: 1rem 1.5rem;
    font-size: 0.9rem;
    border-bottom: 1px solid var(--gray-200);
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.15s ease;
}

.data-table tbody tr:hover {
    background: var(--gray-50);
}

/* User Info */
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: var(--primary);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-name {
    font-weight: 500;
    color: var(--dark);
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.8125rem;
    font-weight: 500;
}

.badge i {
    font-size: 0.75rem;
}

.badge-in {
    background: #dbeafe;
    color: #1e40af;
}

.badge-out {
    background: #fce7f3;
    color: #be185d;
}

.badge-duration {
    background: var(--gray-100);
    color: var(--gray-600);
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-danger {
    background: #fee2e2;
    color: #991b1b;
}

/* Location Text */
.location-text {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    font-size: 0.8125rem;
    color: var(--gray-500);
}

.location-text i {
    color: var(--gray-400);
}

/* Text Utilities */
.text-muted {
    color: var(--gray-500);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
}

.empty-state i {
    font-size: 3rem;
    color: var(--gray-300);
    margin-bottom: 1rem;
}

.empty-state p {
    color: var(--gray-500);
    margin: 0;
}

/* Toast Notification */
.toast-notification {
    position: fixed;
    bottom: 2rem;
    right: 2rem;
    background: var(--white);
    padding: 1rem 1.25rem;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    border-left: 4px solid;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    z-index: 9999;
    opacity: 0;
    transform: translateX(100%);
    transition: all 0.3s ease;
}

.toast-notification.show {
    opacity: 1;
    transform: translateX(0);
}

.toast-notification i {
    font-size: 1.125rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .page-header {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .header-content {
        text-align: left;
        order: -1;
    }

    .header-actions {
        justify-content: flex-start;
    }

    .stats-container {
        grid-template-columns: 1fr;
    }

    .filter-container {
        grid-template-columns: 1fr;
    }

    .data-table th,
    .data-table td {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }

    .toast-notification {
        bottom: 1rem;
        right: 1rem;
        left: 1rem;
    }
}

@media (max-width: 480px) {
    .page-title {
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 1.5rem;
    }

    .btn-modern span {
        display: none;
    }
}
</style>
@endpush
