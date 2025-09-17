@extends('layouts.admin')

@section('title', 'Detail User')

@section('content')
<div class="show-user-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Detail User</h1>
            <p class="mb-0 text-muted">Informasi lengkap pengguna: {{ $user->name }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i>Edit User
            </a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle mb-3" 
                         width="120" height="120">
                    
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="mb-3">
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                <span class="badge bg-{{ $role->name === 'super_admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : ($role->name === 'teacher' ? 'info' : 'success')) }} me-1">
                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                </span>
                            @endforeach
                        @else
                            <span class="badge bg-secondary">No Role</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'secondary' }} fs-6">
                            {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-warning reset-password-btn" 
                                data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}">
                            <i class="fas fa-key me-2"></i>Reset Password
                        </button>
                        
                        @if($user->id !== auth()->id())
                            <button class="btn btn-outline-{{ $user->email_verified_at ? 'secondary' : 'success' }} toggle-status-btn"
                                    data-user-id="{{ $user->id }}">
                                <i class="fas fa-{{ $user->email_verified_at ? 'ban' : 'check' }} me-2"></i>
                                {{ $user->email_verified_at ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Statistics -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>Statistik Akun
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="mb-0 text-primary">{{ $user->created_at->diffInDays() }}</h5>
                                <small class="text-muted">Hari Bergabung</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="mb-0 text-success">{{ $user->updated_at->diffForHumans() }}</h5>
                            <small class="text-muted">Terakhir Update</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- User Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pengguna
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted">Nama Lengkap</label>
                                <p class="mb-0 fw-semibold">{{ $user->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="mb-0 fw-semibold">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted">Role</label>
                                <p class="mb-0">
                                    @if($user->roles->count() > 0)
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-{{ $role->name === 'super_admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : ($role->name === 'teacher' ? 'info' : 'success')) }} me-1">
                                                {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Tidak ada role</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted">Status Akun</label>
                                <p class="mb-0">
                                    <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'secondary' }}">
                                        {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted">Tanggal Bergabung</label>
                                <p class="mb-0 fw-semibold">{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item mb-3">
                                <label class="form-label text-muted">Terakhir Diupdate</label>
                                <p class="mb-0 fw-semibold">{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                                <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Permissions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Hak Akses & Permissions
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <div class="role-section mb-4">
                                <h6 class="d-flex align-items-center mb-3">
                                    <span class="badge bg-{{ $role->name === 'super_admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : ($role->name === 'teacher' ? 'info' : 'success')) }} me-2">
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </span>
                                    @if($role->name === 'super_admin')
                                        <i class="fas fa-crown text-warning"></i>
                                    @elseif($role->name === 'admin')
                                        <i class="fas fa-user-shield text-primary"></i>
                                    @elseif($role->name === 'teacher')
                                        <i class="fas fa-chalkboard-teacher text-success"></i>
                                    @else
                                        <i class="fas fa-user-graduate text-info"></i>
                                    @endif
                                </h6>
                                
                                <div class="permissions-list">
                                    @if($role->name === 'super_admin')
                                        <div class="alert alert-danger">
                                            <i class="fas fa-crown me-2"></i>
                                            <strong>Super Administrator</strong> memiliki akses penuh ke seluruh sistem tanpa batasan.
                                        </div>
                                    @elseif($role->name === 'admin')
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Mengelola konten dan postingan</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Mengelola media dan file</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Mengelola data akademik</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Mengelola pengguna sistem</li>
                                        </ul>
                                    @elseif($role->name === 'teacher')
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Mengelola konten pembelajaran</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Mengelola data siswa yang diampu</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Mengakses fitur akademik</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Mengelola sistem secara keseluruhan</li>
                                        </ul>
                                    @else
                                        <ul class="list-unstyled">
                                            <li><i class="fas fa-check text-success me-2"></i>Mengakses materi pembelajaran</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Mendaftar ekstrakurikuler</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Melihat pengumuman dan agenda</li>
                                            <li><i class="fas fa-times text-danger me-2"></i>Mengelola konten sistem</li>
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            User ini belum memiliki role yang ditetapkan. Silakan edit user untuk menetapkan role.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Activity Log (if needed) -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2"></i>Aktivitas Terakhir
                    </h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Akun dibuat</h6>
                                <p class="text-muted mb-0">{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                            </div>
                        </div>
                        
                        @if($user->updated_at != $user->created_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-info"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terakhir diupdate</h6>
                                    <p class="text-muted mb-0">{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($user->email_verified_at)
                            <div class="timeline-item">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Email diverifikasi</h6>
                                    <p class="text-muted mb-0">{{ $user->email_verified_at->format('d F Y, H:i') }} WIB</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin mereset password untuk user <strong id="resetUserName"></strong>?</p>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Password akan direset ke: <strong>password123</strong>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" id="confirmResetPassword">Reset Password</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .show-user-page .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .show-user-page .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .show-user-page .info-item .form-label {
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }
    
    .show-user-page .border-end {
        border-right: 1px solid #e5e7eb !important;
    }
    
    .show-user-page .timeline {
        position: relative;
        padding-left: 2rem;
    }
    
    .show-user-page .timeline::before {
        content: '';
        position: absolute;
        left: 0.75rem;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    
    .show-user-page .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .show-user-page .timeline-marker {
        position: absolute;
        left: -2rem;
        top: 0.25rem;
        width: 0.75rem;
        height: 0.75rem;
        border-radius: 50%;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #e5e7eb;
    }
    
    .show-user-page .timeline-content h6 {
        font-size: 0.875rem;
        font-weight: 600;
    }
    
    .show-user-page .timeline-content p {
        font-size: 0.8rem;
    }
    
    .show-user-page .role-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        background-color: #f8fafc;
    }
    
    .show-user-page .permissions-list ul {
        margin-bottom: 0;
    }
    
    .show-user-page .permissions-list li {
        padding: 0.25rem 0;
        font-size: 0.875rem;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
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
                    showToast('success', 'Berhasil!', response.message);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showToast('error', 'Error!', response.message || 'Terjadi kesalahan');
            }
        });
    });
    
    // Toggle status
    $('.toggle-status-btn').click(function() {
        const userId = $(this).data('user-id');
        const button = $(this);
        
        $.ajax({
            url: `/admin/users/${userId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showToast('success', 'Berhasil!', response.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                showToast('error', 'Error!', response.message || 'Terjadi kesalahan');
            }
        });
    });
});
</script>
@endpush
@endsection