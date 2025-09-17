@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="create-user-page">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Tambah User Baru</h1>
            <p class="mb-0 text-muted">Buat akun pengguna baru untuk sistem</p>
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
                        <i class="fas fa-user-plus me-2"></i>Informasi User
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}" 
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
                                           value="{{ old('email') }}" 
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
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control @error('password') is-invalid @enderror" 
                                               id="password" 
                                               name="password" 
                                               required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Minimal 8 karakter</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="password" 
                                               class="form-control" 
                                               id="password_confirmation" 
                                               name="password_confirmation" 
                                               required>
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
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
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
                                <i class="fas fa-save me-2"></i>Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Role Information -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>Informasi Role
                    </h5>
                </div>
                <div class="card-body">
                    <div class="role-info">
                        <div class="role-item mb-3" data-role="super_admin">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-danger me-2">Super Admin</span>
                                <i class="fas fa-crown text-warning"></i>
                            </div>
                            <p class="small text-muted mb-0">
                                Akses penuh ke seluruh sistem, dapat mengelola semua data dan pengguna.
                            </p>
                        </div>

                        <div class="role-item mb-3" data-role="admin">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-warning me-2">Admin</span>
                                <i class="fas fa-user-shield text-primary"></i>
                            </div>
                            <p class="small text-muted mb-0">
                                Dapat mengelola konten, media, dan data akademik. Tidak dapat mengelola user.
                            </p>
                        </div>

                        <div class="role-item mb-3" data-role="teacher">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-info me-2">Teacher</span>
                                <i class="fas fa-chalkboard-teacher text-success"></i>
                            </div>
                            <p class="small text-muted mb-0">
                                Dapat mengelola konten pembelajaran dan data siswa yang diampu.
                            </p>
                        </div>

                        <div class="role-item mb-3" data-role="student">
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge bg-success me-2">Student</span>
                                <i class="fas fa-user-graduate text-info"></i>
                            </div>
                            <p class="small text-muted mb-0">
                                Dapat mengakses materi pembelajaran dan mendaftar ekstrakurikuler.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Password Guidelines -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Panduan Password
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <small>Minimal 8 karakter</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <small>Kombinasi huruf dan angka</small>
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check text-success me-2"></i>
                            <small>Hindari informasi pribadi</small>
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check text-success me-2"></i>
                            <small>Gunakan karakter khusus untuk keamanan extra</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .create-user-page .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .create-user-page .card-header {
        background-color: #f8fafc;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .create-user-page .form-label {
        font-weight: 600;
        color: #374151;
    }
    
    .create-user-page .role-item {
        padding: 1rem;
        border-radius: 0.5rem;
        background-color: #f8fafc;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .create-user-page .role-item:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .create-user-page .role-item.active {
        background-color: #dbeafe;
        border-color: #3b82f6;
    }
    
    .create-user-page .input-group .btn {
        border-left: none;
    }
    
    .create-user-page .form-control:focus + .btn {
        border-color: #86b7fe;
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
    
    // Highlight selected role
    $('#role').change(function() {
        const selectedRole = $(this).val();
        
        $('.role-item').removeClass('active');
        if (selectedRole) {
            $(`.role-item[data-role="${selectedRole}"]`).addClass('active');
        }
    });
    
    // Password strength indicator
    $('#password').on('input', function() {
        const password = $(this).val();
        const strength = checkPasswordStrength(password);
        
        // You can add visual feedback here
    });
    
    // Form validation
    $('#createUserForm').submit(function(e) {
        const password = $('#password').val();
        const passwordConfirm = $('#password_confirmation').val();
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            showToast('error', 'Error!', 'Password dan konfirmasi password tidak sama');
            return false;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            showToast('error', 'Error!', 'Password minimal 8 karakter');
            return false;
        }
    });
});

function checkPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}
</script>
@endpush
@endsection