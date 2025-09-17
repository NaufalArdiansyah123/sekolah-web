@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="edit-user-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
            <p class="mb-0 text-muted">Edit informasi pengguna: {{ $user->name }}</p>
        </div>
        <div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Main Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2"></i>Informasi User
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}" 
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                            <select class="form-select @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" 
                                            {{ old('role', $user->roles->first()?->name) == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $role->name)) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Info -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Akun
                    </h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&color=7F9CF5&background=EBF4FF' }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle mb-3" 
                         width="80" height="80">
                    
                    <h6 class="mb-1">{{ $user->name }}</h6>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h6 class="mb-0">{{ $user->created_at->format('d M Y') }}</h6>
                                <small class="text-muted">Bergabung</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="mb-0">
                                <span class="badge bg-{{ $user->email_verified_at ? 'success' : 'secondary' }}">
                                    {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </h6>
                            <small class="text-muted">Status</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Role -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Role Saat Ini
                    </h5>
                </div>
                <div class="card-body">
                    @if($user->roles->count() > 0)
                        @foreach($user->roles as $role)
                            <div class="d-flex align-items-center mb-2">
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
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted mb-0">Tidak ada role yang ditetapkan</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-warning btn-sm reset-password-btn" 
                                data-user-id="{{ $user->id }}"
                                data-user-name="{{ $user->name }}">
                            <i class="fas fa-key me-2"></i>Reset Password
                        </button>
                        
                        @if($user->id !== auth()->id())
                            <button class="btn btn-outline-{{ $user->email_verified_at ? 'secondary' : 'success' }} btn-sm toggle-status-btn"
                                    data-user-id="{{ $user->id }}">
                                <i class="fas fa-{{ $user->email_verified_at ? 'ban' : 'check' }} me-2"></i>
                                {{ $user->email_verified_at ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        @endif
                        
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-2"></i>Lihat Detail
                        </a>
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
    .edit-user-page .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .edit-user-page .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .edit-user-page .form-label {
        font-weight: 600;
        color: #374151;
    }
    
    .edit-user-page .input-group .btn {
        border-left: none;
    }
    
    .edit-user-page .form-control:focus + .btn {
        border-color: #86b7fe;
    }
    
    .edit-user-page .border-end {
        border-right: 1px solid #e5e7eb !important;
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Toggle password visibility
    $('#togglePassword').click(function() {
        const passwordField = $('#password');
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    $('#togglePasswordConfirm').click(function() {
        const passwordField = $('#password_confirmation');
        const icon = $(this).find('i');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
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
    
    // Form validation
    $('#editUserForm').submit(function(e) {
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirmation').val();
        
        if (password && password !== passwordConfirm) {
            e.preventDefault();
            showToast('error', 'Error!', 'Password dan konfirmasi password tidak sama');
            return false;
        }
        
        if (password && password.length < 8) {
            e.preventDefault();
            showToast('error', 'Error!', 'Password minimal 8 karakter');
            return false;
        }
    });
});
</script>
@endpush
@endsection