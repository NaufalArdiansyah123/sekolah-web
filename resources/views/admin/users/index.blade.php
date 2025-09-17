@extends('layouts.admin')

@section('title', 'Management User')

@section('content')
<div class="user-management-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Management User</h1>
            <p class="mb-0 text-muted">Kelola akun pengguna sistem</p>
        </div>
        <div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah User
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Cari User</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Nama atau email..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="">Semua Role</option>
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
                        <option value="">Semua Status</option>
                        <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Aktif</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-users me-2"></i>Daftar User
                <span class="badge bg-primary ms-2">{{ $users->total() }}</span>
            </h5>
        </div>
        <div class="card-body p-0">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Avatar</th>
                                <th width="25%">Nama & Email</th>
                                <th width="15%">Role</th>
                                <th width="15%">Status</th>
                                <th width="15%">Bergabung</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                                                 alt="{{ $user->name }}" 
                                                 class="rounded-circle me-2" 
                                                 width="40" height="40">
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                            <small class="text-muted">{{ $user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-{{ $role->name === 'super_admin' ? 'danger' : ($role->name === 'admin' ? 'warning' : ($role->name === 'teacher' ? 'info' : 'success')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-secondary">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input status-toggle" 
                                                   type="checkbox" 
                                                   data-user-id="{{ $user->id }}"
                                                   {{ $user->email_verified_at ? 'checked' : '' }}
                                                   {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                            <label class="form-check-label">
                                                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'secondary' }}">
                                                    {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                                                </span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $user->created_at->format('d M Y') }}<br>
                                            {{ $user->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                    type="button" data-bs-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.users.show', $user) }}">
                                                        <i class="fas fa-eye me-2"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.users.edit', $user) }}">
                                                        <i class="fas fa-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <button class="dropdown-item reset-password-btn" 
                                                            data-user-id="{{ $user->id }}"
                                                            data-user-name="{{ $user->name }}">
                                                        <i class="fas fa-key me-2"></i>Reset Password
                                                    </button>
                                                </li>
                                                @if($user->id !== auth()->id())
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="{{ route('admin.users.destroy', $user) }}" 
                                                              method="POST" 
                                                              class="d-inline delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-trash me-2"></i>Hapus
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} user
                        </div>
                        {{ $users->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">Tidak ada user ditemukan</h4>
                    <p class="text-muted">
                        @if(request()->hasAny(['search', 'role', 'status']))
                            Tidak ada user yang sesuai dengan filter yang dipilih.
                        @else
                            Belum ada user yang terdaftar dalam sistem.
                        @endif
                    </p>
                    @if(request()->hasAny(['search', 'role', 'status']))
                        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                    @else
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah User Pertama
                        </a>
                    @endif
                </div>
            @endif
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
    .user-management-page .table th {
        border-top: none;
        font-weight: 600;
        color: #374151;
        background-color: #f8fafc;
    }
    
    .user-management-page .table td {
        vertical-align: middle;
        border-color: #e5e7eb;
    }
    
    .user-management-page .badge {
        font-size: 0.75rem;
        padding: 0.375rem 0.75rem;
    }
    
    .user-management-page .form-switch .form-check-input {
        width: 2.5rem;
        height: 1.25rem;
    }
    
    .user-management-page .dropdown-toggle::after {
        display: none;
    }
    
    .user-management-page .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .user-management-page .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Status toggle
    $('.status-toggle').change(function() {
        const userId = $(this).data('user-id');
        const isChecked = $(this).is(':checked');
        const toggle = $(this);
        const badge = toggle.siblings('label').find('.badge');
        
        $.ajax({
            url: `/admin/users/${userId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    if (response.status === 'active') {
                        badge.removeClass('bg-secondary').addClass('bg-success').text('Aktif');
                    } else {
                        badge.removeClass('bg-success').addClass('bg-secondary').text('Tidak Aktif');
                    }
                    showToast('success', 'Berhasil!', response.message);
                } else {
                    // Revert toggle
                    toggle.prop('checked', !isChecked);
                    showToast('error', 'Error!', response.message);
                }
            },
            error: function(xhr) {
                // Revert toggle
                toggle.prop('checked', !isChecked);
                const response = xhr.responseJSON;
                showToast('error', 'Error!', response.message || 'Terjadi kesalahan');
            }
        });
    });
    
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
    
    // Delete confirmation
    $('.delete-form').submit(function(e) {
        e.preventDefault();
        
        if (confirm('Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.')) {
            this.submit();
        }
    });
});
</script>
@endpush
@endsection