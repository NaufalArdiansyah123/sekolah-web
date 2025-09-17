@extends('layouts.admin')

@section('title', 'Pendaftaran Siswa')

@push('styles')
<style>
    /* Enhanced Student Registration Styles */
    .registration-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        margin: 0;
        padding: 0;
    }

    .registration-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .content-wrapper {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    .dark .content-wrapper {
        background: rgba(30, 41, 59, 0.98);
    }

    .header-section {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dark .header-section {
        background: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .header-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .header-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-title i {
        background: rgba(255, 255, 255, 0.2);
        padding: 0.75rem;
        border-radius: 16px;
        font-size: 1.5rem;
    }

    .header-subtitle {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 1.1rem;
        font-weight: 400;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
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
    }

    .main-content-inner {
        padding: 2rem;
        max-width: 1400px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        padding: 1.5rem;
        border-radius: 16px;
        text-align: center;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
    }

    .dark .stat-card {
        background: #374151;
        border-color: #4b5563;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 16px 16px 0 0;
    }

    .stat-card.total::before { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
    .stat-card.pending::before { background: linear-gradient(90deg, #f59e0b, #d97706); }
    .stat-card.approved::before { background: linear-gradient(90deg, #10b981, #059669); }
    .stat-card.rejected::before { background: linear-gradient(90deg, #ef4444, #dc2626); }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .dark .stat-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: #1f2937;
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .dark .stat-number {
        color: #f9fafb;
    }

    .stat-label {
        color: #6b7280;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
    }

    .dark .stat-label {
        color: #d1d5db;
    }

    .filter-section {
        background: #f8fafc;
        padding: 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .dark .filter-section {
        background: #4b5563;
        border-color: #4b5563;
    }

    .filter-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 1rem 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        color: #6b7280;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        position: relative;
        overflow: hidden;
    }

    .dark .filter-tab {
        border-color: #4b5563;
        background: #374151;
        color: #d1d5db;
    }

    .filter-tab::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        transition: left 0.5s;
    }

    .filter-tab:hover::before {
        left: 100%;
    }

    .filter-tab.active,
    .filter-tab:hover {
        border-color: #4f46e5;
        color: #4f46e5;
        background: #f0f9ff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, 0.15);
    }

    .dark .filter-tab.active,
    .dark .filter-tab:hover {
        background: rgba(79, 70, 229, 0.2);
        color: #60a5fa;
        border-color: #60a5fa;
    }

    .filter-tab .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        background: #e5e7eb;
        color: #6b7280;
        font-weight: 700;
        transition: all 0.3s ease;
    }

    .dark .filter-tab .badge {
        background: #4b5563;
        color: #d1d5db;
    }

    .filter-tab.active .badge {
        background: #4f46e5;
        color: white;
    }

    .dark .filter-tab.active .badge {
        background: #60a5fa;
        color: #1e293b;
    }

    .registration-table {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
    }

    .dark .registration-table {
        background: #374151;
        border-color: #4b5563;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .table {
        margin: 0;
    }

    .table th {
        background: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
        font-weight: 600;
        color: #374151;
        padding: 1rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .dark .table th {
        background: #4b5563;
        border-color: #6b7280;
        color: #f9fafb;
    }

    .table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        vertical-align: middle;
    }

    .dark .table td {
        border-color: #4b5563;
        color: #f9fafb;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-badge.pending {
        background: #fef3c7;
        color: #92400e;
    }

    .dark .status-badge.pending {
        background: rgba(245, 158, 11, 0.2);
        color: #fbbf24;
    }

    .status-badge.active {
        background: #dcfce7;
        color: #166534;
    }

    .dark .status-badge.active {
        background: rgba(34, 197, 94, 0.2);
        color: #4ade80;
    }

    .status-badge.rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    .dark .status-badge.rejected {
        background: rgba(239, 68, 68, 0.2);
        color: #f87171;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .btn-action {
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.875rem;
    }

    .btn-approve {
        background: #dcfce7;
        color: #166534;
    }

    .btn-approve:hover {
        background: #10b981;
        color: white;
        transform: scale(1.1);
    }

    .btn-reject {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-reject:hover {
        background: #dc2626;
        color: white;
        transform: scale(1.1);
    }

    .btn-view {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-view:hover {
        background: #3b82f6;
        color: white;
        transform: scale(1.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-section {
            padding: 1.5rem 1rem;
        }

        .header-content {
            flex-direction: column;
            text-align: center;
            gap: 1.5rem;
        }

        .header-title {
            font-size: 2rem;
        }

        .header-actions {
            justify-content: center;
        }

        .main-content-inner {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .filter-tabs {
            flex-direction: column;
        }

        .filter-tab {
            justify-content: center;
        }

        .registration-table {
            overflow-x: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="registration-container">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <div>
                    <h1 class="header-title">
                        <i class="fas fa-user-graduate"></i>
                        Pendaftaran Siswa
                    </h1>
                    <p class="header-subtitle">
                        Kelola dan konfirmasi pendaftaran siswa baru - {{ $stats['total'] }} total, {{ $stats['pending'] }} menunggu konfirmasi
                    </p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.student-registrations.export', request()->query()) }}" class="btn-header">
                        <i class="fas fa-download"></i>
                        Export Data
                    </a>
                    <button class="btn-header" onclick="bulkApprove()">
                        <i class="fas fa-check-double"></i>
                        Setujui Terpilih
                    </button>
                </div>
            </div>
        </div>

        <div class="main-content-inner">
            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card total">
                    <div class="stat-number">{{ $stats['total'] }}</div>
                    <div class="stat-label">Total Pendaftaran</div>
                </div>
                <div class="stat-card pending">
                    <div class="stat-number">{{ $stats['pending'] }}</div>
                    <div class="stat-label">Menunggu Konfirmasi</div>
                </div>
                <div class="stat-card approved">
                    <div class="stat-number">{{ $stats['approved'] }}</div>
                    <div class="stat-label">Disetujui</div>
                </div>
                <div class="stat-card rejected">
                    <div class="stat-number">{{ $stats['rejected'] }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section">
                <!-- Filter Tabs -->
                <div class="filter-tabs">
                    <a href="{{ route('admin.student-registrations.index') }}" 
                       class="filter-tab {{ !request('status') ? 'active' : '' }}">
                        <i class="fas fa-list"></i>
                        Semua 
                        <span class="badge">{{ $stats['total'] }}</span>
                    </a>
                    <a href="{{ route('admin.student-registrations.index', ['status' => 'pending']) }}" 
                       class="filter-tab {{ request('status') == 'pending' ? 'active' : '' }}">
                        <i class="fas fa-clock"></i>
                        Menunggu Konfirmasi
                        <span class="badge">{{ $stats['pending'] }}</span>
                    </a>
                    <a href="{{ route('admin.student-registrations.index', ['status' => 'active']) }}" 
                       class="filter-tab {{ request('status') == 'active' ? 'active' : '' }}">
                        <i class="fas fa-check"></i>
                        Disetujui
                        <span class="badge">{{ $stats['approved'] }}</span>
                    </a>
                    <a href="{{ route('admin.student-registrations.index', ['status' => 'rejected']) }}" 
                       class="filter-tab {{ request('status') == 'rejected' ? 'active' : '' }}">
                        <i class="fas fa-times"></i>
                        Ditolak
                        <span class="badge">{{ $stats['rejected'] }}</span>
                    </a>
                </div>
                
                <!-- Search Form -->
                <form method="GET" action="{{ route('admin.student-registrations.index') }}" class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan nama, email, NIS, atau kelas..." value="{{ request('search') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-1"></i>Cari
                        </button>
                    </div>
                </form>
            </div>

            <!-- Registrations Table -->
            <div class="registration-table">
                @if($registrations->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th>Siswa</th>
                                    <th>Kontak</th>
                                    <th>Kelas</th>
                                    <th>Orang Tua</th>
                                    <th>Status</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($registrations as $registration)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="registration-checkbox" value="{{ $registration->id }}">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $registration->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($registration->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                                     alt="{{ $registration->name }}" 
                                                     class="rounded-circle me-3" 
                                                     style="width: 40px; height: 40px;">
                                                <div>
                                                    <div class="fw-bold">{{ $registration->name }}</div>
                                                    @if(isset($registration->nis))
                                                    <small class="text-muted">NIS: {{ $registration->nis }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>{{ $registration->email }}</div>
                                            @if($registration->phone)
                                                <small class="text-muted">{{ $registration->phone }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($registration->class))
                                            <span class="badge bg-primary">{{ $registration->class }}</span>
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($registration->parent_name))
                                            <div>{{ $registration->parent_name }}</div>
                                            @if(isset($registration->parent_phone))
                                            <small class="text-muted">{{ $registration->parent_phone }}</small>
                                            @endif
                                            @else
                                            <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge {{ $registration->status }}">
                                                @if($registration->status == 'pending')
                                                    <i class="fas fa-clock me-1"></i>Menunggu
                                                @elseif($registration->status == 'active')
                                                    <i class="fas fa-check me-1"></i>Disetujui
                                                @elseif($registration->status == 'rejected')
                                                    <i class="fas fa-times me-1"></i>Ditolak
                                                @endif
                                            </span>
                                        </td>
                                        <td>
                                            <div>{{ $registration->created_at->format('d/m/Y') }}</div>
                                            <small class="text-muted">{{ $registration->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn-action btn-view" 
                                                        onclick="viewRegistration({{ $registration->id }})"
                                                        title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                                @if($registration->status == 'pending')
                                                    <button class="btn-action btn-approve" 
                                                            onclick="approveRegistration({{ $registration->id }})"
                                                            title="Setujui">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button class="btn-action btn-reject" 
                                                            onclick="rejectRegistration({{ $registration->id }})"
                                                            title="Tolak">
                                                        <i class="fas fa-times"></i>
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
                    <div class="d-flex justify-content-center mt-4">
                        {{ $registrations->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-user-graduate text-muted mb-3" style="font-size: 4rem;"></i>
                        <h4 class="text-muted">Belum Ada Pendaftaran</h4>
                        <p class="text-muted">Pendaftaran siswa akan muncul di sini ketika ada yang mendaftar.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="rejectionForm">
                    <div class="mb-3">
                        <label for="rejectionReason" class="form-label">Alasan Penolakan</label>
                        <textarea class="form-control" id="rejectionReason" name="rejection_reason" rows="4" required 
                                  placeholder="Masukkan alasan penolakan pendaftaran..."></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="submitRejection()">Tolak Pendaftaran</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pendaftaran Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentRegistrationId = null;

// Toggle select all checkboxes
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.registration-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

// Get selected registration IDs
function getSelectedIds() {
    const checkboxes = document.querySelectorAll('.registration-checkbox:checked');
    return Array.from(checkboxes).map(cb => cb.value);
}

// View registration detail
function viewRegistration(id) {
    fetch(`/admin/student-registrations/${id}`)
        .then(response => response.text())
        .then(html => {
            document.getElementById('detailContent').innerHTML = html;
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail pendaftaran');
        });
}

// Approve registration
function approveRegistration(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pendaftaran ini?')) return;
    
    fetch(`/admin/student-registrations/${id}/approve`, {
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
        showToast('error', 'Terjadi kesalahan saat memproses permintaan');
    });
}

// Reject registration
function rejectRegistration(id) {
    currentRegistrationId = id;
    document.getElementById('rejectionReason').value = '';
    new bootstrap.Modal(document.getElementById('rejectionModal')).show();
}

// Submit rejection
function submitRejection() {
    const reason = document.getElementById('rejectionReason').value.trim();
    
    if (!reason) {
        alert('Alasan penolakan harus diisi');
        return;
    }
    
    fetch(`/admin/student-registrations/${currentRegistrationId}/reject`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            rejection_reason: reason
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showToast('success', data.message);
            bootstrap.Modal.getInstance(document.getElementById('rejectionModal')).hide();
            setTimeout(() => location.reload(), 1500);
        } else {
            showToast('error', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('error', 'Terjadi kesalahan saat memproses permintaan');
    });
}

// Bulk approve
function bulkApprove() {
    const selectedIds = getSelectedIds();
    
    if (selectedIds.length === 0) {
        alert('Pilih minimal satu pendaftaran untuk disetujui');
        return;
    }
    
    if (!confirm(`Apakah Anda yakin ingin menyetujui ${selectedIds.length} pendaftaran yang dipilih?`)) return;
    
    fetch('/admin/student-registrations/bulk-action', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            action: 'approve',
            ids: selectedIds
        })
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
        showToast('error', 'Terjadi kesalahan saat memproses permintaan');
    });
}

// Show toast notification
function showToast(type, message) {
    const toast = document.createElement('div');
    toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; animation: slideInRight 0.3s ease-out;';
    toast.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
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
    const statCards = document.querySelectorAll('.stat-card');
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
@endpush