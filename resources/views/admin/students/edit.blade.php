@extends('layouts.admin')

@section('title', 'Edit Siswa - ' . $student->name)

@push('styles')
<style>
    :root {
        --primary-color: #6366f1;
        --primary-dark: #4f46e5;
        --secondary-color: #8b5cf6;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
        --info-color: #3b82f6;
        --light-bg: #f8fafc;
        --white: #ffffff;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
        --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);
    }

    .dark {
        --light-bg: #1f2937;
        --white: #374151;
        --gray-50: #374151;
        --gray-100: #4b5563;
        --gray-200: #6b7280;
        --gray-300: #9ca3af;
        --gray-400: #d1d5db;
        --gray-500: #e5e7eb;
        --gray-600: #f3f4f6;
        --gray-700: #f9fafb;
        --gray-800: #ffffff;
        --gray-900: #ffffff;
    }

    .page-container {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .edit-container {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        margin: 0 auto;
        max-width: 1200px;
    }

    .edit-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .edit-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .edit-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .edit-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }

    .header-actions {
        position: relative;
        z-index: 3;
        margin-top: 1.5rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .btn-header {
        background: rgba(255, 255, 255, 0.2);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-header:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
        color: white;
        transform: translateY(-2px);
    }

    .edit-body {
        padding: 2rem;
    }

    .form-section {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--shadow);
        border-left: 4px solid var(--primary-color);
        transition: all 0.3s ease;
    }

    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-800);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
    }

    .required {
        color: var(--danger-color);
        margin-left: 0.25rem;
    }

    .form-control, .form-select {
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--white);
        color: var(--gray-800);
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        outline: none;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger-color);
        background: #fef2f2;
    }

    .form-control.is-valid, .form-select.is-valid {
        border-color: var(--success-color);
        background: #f0fdf4;
    }

    .dark .form-control.is-invalid,
    .dark .form-select.is-invalid {
        background: #7f1d1d;
        color: #fecaca;
    }

    .dark .form-control.is-valid,
    .dark .form-select.is-valid {
        background: #14532d;
        color: #bbf7d0;
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    .form-text {
        color: var(--gray-500);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .current-photo {
        background: var(--gray-50);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--gray-200);
    }

    .current-photo img {
        border-radius: 12px;
        box-shadow: var(--shadow);
        transition: transform 0.3s ease;
    }

    .current-photo img:hover {
        transform: scale(1.05);
    }

    .photo-upload-area {
        border: 2px dashed var(--gray-300);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        background: var(--gray-50);
        cursor: pointer;
        color: var(--gray-600);
    }

    .photo-upload-area:hover {
        border-color: var(--primary-color);
        background: #f0f9ff;
        color: var(--primary-color);
    }

    .photo-upload-area.dragover {
        border-color: var(--primary-color);
        background: #eff6ff;
        transform: scale(1.02);
    }

    .qr-status-card {
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .dark .qr-status-card {
        background: #1e3a8a;
        border-color: #3730a3;
    }

    .validation-wrapper {
        position: relative;
    }

    .validation-icon {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        z-index: 5;
    }

    .validation-message {
        font-size: 0.75rem;
        margin-top: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .validation-message.success {
        color: #166534;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
    }

    .validation-message.error {
        color: #991b1b;
        background: #fef2f2;
        border: 1px solid #fecaca;
    }

    .validation-message.loading {
        color: #1d4ed8;
        background: #dbeafe;
        border: 1px solid #bfdbfe;
    }

    .form-actions {
        background: var(--gray-50);
        padding: 2rem;
        border-top: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn-form {
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-primary-form {
        background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
        color: white;
        box-shadow: var(--shadow);
    }

    .btn-primary-form:hover {
        background: linear-gradient(135deg, var(--primary-dark), var(--secondary-color));
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    .btn-secondary-form {
        background: var(--gray-100);
        color: var(--gray-700);
        border: 2px solid var(--gray-200);
    }

    .btn-secondary-form:hover {
        background: var(--gray-200);
        color: var(--gray-800);
        transform: translateY(-2px);
    }

    .btn-danger-form {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
        color: white;
    }

    .btn-danger-form:hover {
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
        transform: translateY(-2px);
    }

    .floating-actions {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        z-index: 1000;
    }

    .floating-btn {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        border: none;
        color: white;
        font-size: 1.25rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: var(--shadow-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
    }

    .floating-btn:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-xl);
        color: white;
    }

    .floating-btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    }

    .floating-btn-success {
        background: linear-gradient(135deg, var(--success-color), #059669);
    }

    .floating-btn-danger {
        background: linear-gradient(135deg, var(--danger-color), #dc2626);
    }

    .alert-custom {
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        box-shadow: var(--shadow);
    }

    .alert-danger-custom {
        background: #fef2f2;
        color: #991b1b;
        border-left: 4px solid var(--danger-color);
    }

    .alert-success-custom {
        background: #f0fdf4;
        color: #166534;
        border-left: 4px solid var(--success-color);
    }

    .alert-info-custom {
        background: #eff6ff;
        color: #1e40af;
        border-left: 4px solid var(--info-color);
    }

    .dark .alert-danger-custom {
        background: #7f1d1d;
        color: #fecaca;
    }

    .dark .alert-success-custom {
        background: #14532d;
        color: #bbf7d0;
    }

    .dark .alert-info-custom {
        background: #1e3a8a;
        color: #bfdbfe;
    }

    @media (max-width: 768px) {
        .page-container {
            padding: 1rem;
        }

        .edit-header {
            padding: 1.5rem;
            text-align: center;
        }

        .edit-title {
            font-size: 2rem;
        }

        .header-actions {
            justify-content: center;
        }

        .edit-body {
            padding: 1rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .floating-actions {
            display: none;
        }
    }

    .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }

    .fade-in:nth-child(1) { animation-delay: 0.1s; }
    .fade-in:nth-child(2) { animation-delay: 0.2s; }
    .fade-in:nth-child(3) { animation-delay: 0.3s; }
    .fade-in:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="edit-container">
        <!-- Edit Header -->
        <div class="edit-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="edit-title">
                        <i class="fas fa-user-edit me-3"></i>Edit Siswa
                    </h1>
                    <p class="edit-subtitle">
                        Perbarui informasi data siswa: <strong>{{ $student->name }}</strong>
                    </p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.students.index') }}" class="btn-header">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('admin.students.show', $student) }}" class="btn-header">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>

        <div class="edit-body">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert-custom alert-danger-custom">
                    <i class="fas fa-exclamation-triangle"></i>
                    <div>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.students.update', $student) }}" enctype="multipart/form-data" id="editForm">
                @csrf
                @method('PUT')
                
                <!-- Personal Information Section -->
                <div class="form-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        Data Pribadi
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">
                                    Nama Lengkap <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $student->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nis" class="form-label">
                                    NIS <span class="required">*</span>
                                </label>
                                <div class="validation-wrapper">
                                    <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                                           id="nis" name="nis" value="{{ old('nis', $student->nis) }}" 
                                           placeholder="Contoh: 2024100001" 
                                           pattern="[0-9]+" 
                                           minlength="6" 
                                           maxlength="20" 
                                           required>
                                    <div class="validation-icon" id="nisValidationIcon" style="display: none;"></div>
                                </div>
                                <div id="nisValidationMessage" class="validation-message" style="display: none;"></div>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">NIS harus unik dan hanya berisi angka (6-20 digit)</small>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nisn" class="form-label">NISN</label>
                                <div class="validation-wrapper">
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                                           id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}" 
                                           placeholder="10 digit angka" 
                                           pattern="[0-9]{10}" 
                                           minlength="10" 
                                           maxlength="10">
                                    <div class="validation-icon" id="nisnValidationIcon" style="display: none;"></div>
                                </div>
                                <div id="nisnValidationMessage" class="validation-message" style="display: none;"></div>
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">NISN harus 10 digit angka (opsional)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $student->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="class_id" class="form-label">
                                    Kelas <span class="required">*</span>
                                </label>
                                <select class="form-select @error('class_id') is-invalid @enderror" id="class_id" name="class_id" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach($classOptions as $grade => $classes)
                                        <optgroup label="Kelas {{ $grade }}">
                                            @foreach($classes as $class)
                                                <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }} - {{ $class->program }}
                                                </option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">
                                    Tanggal Lahir <span class="required">*</span>
                                </label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" name="birth_date" value="{{ old('birth_date', $student->birth_date->format('Y-m-d')) }}" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_place" class="form-label">
                                    Tempat Lahir <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" 
                                       id="birth_place" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}" required>
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">
                                    Jenis Kelamin <span class="required">*</span>
                                </label>
                                <div class="d-flex gap-3 mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                                               {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="male">
                                            <i class="fas fa-mars me-1"></i>Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" 
                                               {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="female">
                                            <i class="fas fa-venus me-1"></i>Perempuan
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="religion" class="form-label">
                                    Agama <span class="required">*</span>
                                </label>
                                <select class="form-select @error('religion') is-invalid @enderror" id="religion" name="religion" required>
                                    <option value="">Pilih Agama</option>
                                    @foreach(config('school.student.religions', ['Islam' => 'Islam', 'Kristen' => 'Kristen', 'Katolik' => 'Katolik', 'Hindu' => 'Hindu', 'Buddha' => 'Buddha', 'Konghucu' => 'Konghucu']) as $value => $label)
                                        <option value="{{ $value }}" {{ old('religion', $student->religion) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('religion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="status" class="form-label">
                                    Status <span class="required">*</span>
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Lulus</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" 
                                  placeholder="Masukkan alamat lengkap...">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Parent Information Section -->
                <div class="form-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        Data Orang Tua/Wali
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_name" class="form-label">
                                    Nama Orang Tua/Wali <span class="required">*</span>
                                </label>
                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                       id="parent_name" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" required>
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_phone" class="form-label">Telepon Orang Tua/Wali</label>
                                <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                                       id="parent_phone" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}">
                                @error('parent_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo Section -->
                <div class="form-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        Foto Siswa
                    </h3>
                    
                    @if($student->photo)
                        <div class="current-photo" id="currentPhotoSection">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Foto Saat Ini:</h6>
                                <button type="button" class="btn btn-sm btn-danger-form" onclick="deletePhoto({{ $student->id }})" title="Hapus Foto">
                                    <i class="fas fa-trash"></i> Hapus Foto
                                </button>
                            </div>
                            <div class="text-center">
                                <img src="{{ $student->photo_url }}" alt="Current photo" class="img-thumbnail" style="max-width: 200px;" id="currentPhoto">
                            </div>
                        </div>
                    @endif
                    
                    <div class="photo-upload-area" onclick="document.getElementById('photo').click()">
                        <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                        <h5>Klik untuk upload foto baru atau drag & drop</h5>
                        <p>Format: JPG, PNG, GIF. Maksimal 2MB</p>
                        <input type="file" class="d-none @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                    </div>
                    
                    <div id="photoPreview" class="text-center mt-3" style="display: none;">
                        <img id="previewImage" src="" alt="Preview" style="max-width: 200px; border-radius: 12px; box-shadow: var(--shadow);">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removePhoto()">
                            <i class="fas fa-trash"></i> Hapus Foto Baru
                        </button>
                    </div>
                    
                    <small class="form-text">Kosongkan jika tidak ingin mengubah foto.</small>
                    @error('photo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- QR Code Section -->
                <div class="form-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        QR Code Absensi
                    </h3>
                    
                    <div class="qr-status-card">
                        @if($student->qrAttendance)
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center text-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span class="fw-bold">QR Code Sudah Ada</span>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.students.show', $student) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Lihat QR
                                    </a>
                                    <a href="{{ route('admin.qr-attendance.index', ['search' => $student->nis]) }}" 
                                       class="btn btn-sm btn-outline-secondary" target="_blank">
                                        <i class="fas fa-cog"></i> Kelola QR
                                    </a>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">
                                QR Code dibuat pada: {{ $student->qrAttendance->created_at->format('d F Y H:i') }}
                            </small>
                        @else
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center text-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <span class="fw-bold">QR Code Belum Ada</span>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="auto_generate_qr" name="auto_generate_qr" value="1">
                                    <label class="form-check-label" for="auto_generate_qr">
                                        Buat QR Code baru
                                    </label>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">
                                Centang opsi di atas untuk membuat QR Code baru saat menyimpan data.
                            </small>
                        @endif
                    </div>
                    
                    @if($student->qrAttendance)
                        <div class="alert-custom alert-info-custom">
                            <i class="fas fa-info-circle"></i>
                            <small>
                                <strong>QR Code sudah tersedia.</strong> Anda dapat mengelola QR Code (regenerate, download, dll) 
                                melalui halaman <a href="{{ route('admin.qr-attendance.index') }}" target="_blank" class="alert-link">Manajemen QR Attendance</a>.
                            </small>
                        </div>
                    @else
                        <div class="alert-custom alert-info-custom">
                            <i class="fas fa-info-circle"></i>
                            <small>
                                <strong>QR Code belum dibuat.</strong> Siswa ini belum memiliki QR Code untuk absensi. 
                                Centang opsi di atas untuk membuat QR Code baru, atau buat manual di halaman 
                                <a href="{{ route('admin.qr-attendance.index') }}" target="_blank" class="alert-link">Manajemen QR Attendance</a>.
                            </small>
                        </div>
                    @endif
                </div>
            </form>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.students.index') }}" class="btn-form btn-secondary-form">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
                <a href="{{ route('admin.students.show', $student) }}" class="btn-form btn-secondary-form">
                    <i class="fas fa-eye"></i>Lihat Detail
                </a>
            </div>
            
            <button type="submit" form="editForm" class="btn-form btn-primary-form">
                <i class="fas fa-save"></i>Update Data Siswa
            </button>
        </div>
    </div>
</div>

<!-- Floating Action Buttons -->
<div class="floating-actions">
    <button type="submit" form="editForm" class="floating-btn floating-btn-success" title="Simpan Perubahan">
        <i class="fas fa-save"></i>
    </button>
    <a href="{{ route('admin.students.show', $student) }}" class="floating-btn floating-btn-primary" title="Lihat Detail">
        <i class="fas fa-eye"></i>
    </a>
    @if($student->photo)
        <button type="button" onclick="deletePhoto({{ $student->id }})" class="floating-btn floating-btn-danger" title="Hapus Foto">
            <i class="fas fa-trash"></i>
        </button>
    @endif
</div>
@endsection

@push('scripts')
<script>
// Photo upload handling
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImage').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});

// Remove new photo
function removePhoto() {
    document.getElementById('photo').value = '';
    document.getElementById('photoPreview').style.display = 'none';
}

// Drag and drop functionality
const uploadArea = document.querySelector('.photo-upload-area');

uploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('dragover');
});

uploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
});

uploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('photo').files = files;
        document.getElementById('photo').dispatchEvent(new Event('change'));
    }
});

// NIS Validation
let nisTimeout;
const nisInput = document.getElementById('nis');
const nisIcon = document.getElementById('nisValidationIcon');
const nisMessage = document.getElementById('nisValidationMessage');

nisInput.addEventListener('input', function() {
    clearTimeout(nisTimeout);
    const nis = this.value.trim();
    
    if (nis.length === 0) {
        hideValidation('nis');
        return;
    }
    
    showValidation('nis', 'loading', 'Memeriksa NIS...', '<i class="fas fa-spinner spinner"></i>');
    
    nisTimeout = setTimeout(() => {
        validateNis(nis, {{ $student->id }});
    }, 500);
});

// NISN Validation
let nisnTimeout;
const nisnInput = document.getElementById('nisn');
const nisnIcon = document.getElementById('nisnValidationIcon');
const nisnMessage = document.getElementById('nisnValidationMessage');

nisnInput.addEventListener('input', function() {
    clearTimeout(nisnTimeout);
    const nisn = this.value.trim();
    
    if (nisn.length === 0) {
        hideValidation('nisn');
        return;
    }
    
    showValidation('nisn', 'loading', 'Memeriksa NISN...', '<i class="fas fa-spinner spinner"></i>');
    
    nisnTimeout = setTimeout(() => {
        validateNisn(nisn, {{ $student->id }});
    }, 500);
});

function validateNis(nis, studentId) {
    fetch(`{{ route('admin.students.check-nis') }}?nis=${nis}&student_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                showValidation('nis', 'success', data.message, '<i class="fas fa-check-circle"></i>');
                nisInput.classList.remove('is-invalid');
                nisInput.classList.add('is-valid');
            } else {
                showValidation('nis', 'error', data.message, '<i class="fas fa-times-circle"></i>');
                nisInput.classList.remove('is-valid');
                nisInput.classList.add('is-invalid');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showValidation('nis', 'error', 'Gagal memeriksa NIS', '<i class="fas fa-exclamation-triangle"></i>');
        });
}

function validateNisn(nisn, studentId) {
    fetch(`{{ route('admin.students.check-nisn') }}?nisn=${nisn}&student_id=${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.available) {
                showValidation('nisn', 'success', data.message, '<i class="fas fa-check-circle"></i>');
                nisnInput.classList.remove('is-invalid');
                nisnInput.classList.add('is-valid');
            } else {
                showValidation('nisn', 'error', data.message, '<i class="fas fa-times-circle"></i>');
                nisnInput.classList.remove('is-valid');
                nisnInput.classList.add('is-invalid');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showValidation('nisn', 'error', 'Gagal memeriksa NISN', '<i class="fas fa-exclamation-triangle"></i>');
        });
}

function showValidation(field, type, message, icon) {
    const iconElement = document.getElementById(field + 'ValidationIcon');
    const messageElement = document.getElementById(field + 'ValidationMessage');
    
    iconElement.innerHTML = icon;
    iconElement.className = `validation-icon ${type}`;
    iconElement.style.display = 'block';
    
    messageElement.innerHTML = `${icon} ${message}`;
    messageElement.className = `validation-message ${type}`;
    messageElement.style.display = 'block';
}

function hideValidation(field) {
    const iconElement = document.getElementById(field + 'ValidationIcon');
    const messageElement = document.getElementById(field + 'ValidationMessage');
    const inputElement = document.getElementById(field);
    
    iconElement.style.display = 'none';
    messageElement.style.display = 'none';
    inputElement.classList.remove('is-valid', 'is-invalid');
}

// Delete photo function
function deletePhoto(studentId) {
    if (confirm('Apakah Anda yakin ingin menghapus foto profil siswa ini? Foto yang dihapus tidak dapat dikembalikan!')) {
        const currentPhoto = document.getElementById('currentPhoto');
        const deleteButton = document.querySelector('button[onclick*="deletePhoto"]');
        
        if (deleteButton) {
            deleteButton.disabled = true;
            deleteButton.innerHTML = '<i class="fas fa-spinner spinner"></i> Menghapus...';
        }
        
        if (currentPhoto) {
            currentPhoto.style.opacity = '0.5';
            currentPhoto.style.filter = 'grayscale(100%)';
        }
        
        fetch(`/admin/students/${studentId}/photo`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const photoSection = document.getElementById('currentPhotoSection');
                if (photoSection) {
                    photoSection.style.transition = 'all 0.5s ease';
                    photoSection.style.opacity = '0';
                    photoSection.style.transform = 'translateY(-20px)';
                    
                    setTimeout(() => {
                        photoSection.remove();
                    }, 500);
                }
                
                showNotification('Foto berhasil dihapus!', 'success');
            } else {
                if (deleteButton) {
                    deleteButton.disabled = false;
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i> Hapus Foto';
                }
                if (currentPhoto) {
                    currentPhoto.style.opacity = '1';
                    currentPhoto.style.filter = 'none';
                }
                
                showNotification(data.message || 'Gagal menghapus foto', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            if (deleteButton) {
                deleteButton.disabled = false;
                deleteButton.innerHTML = '<i class="fas fa-trash"></i> Hapus Foto';
            }
            if (currentPhoto) {
                currentPhoto.style.opacity = '1';
                currentPhoto.style.filter = 'none';
            }
            
            showNotification('Terjadi kesalahan saat menghapus foto', 'error');
        });
    }
}

// Show notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    const alertClass = type === 'error' ? 'danger' : type;
    notification.className = `alert alert-${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 10000; min-width: 300px; max-width: 400px;';
    
    const iconClass = type === 'success' ? 'check-circle' : 
                     type === 'error' ? 'exclamation-triangle' : 
                     type === 'warning' ? 'exclamation-circle' : 'info-circle';
    
    notification.innerHTML = `
        <i class="fas fa-${iconClass} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(notification);
    
    const timeout = type === 'error' ? 5000 : 3000;
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, timeout);
}

// Form validation
document.getElementById('editForm').addEventListener('submit', function(e) {
    showNotification('Menyimpan perubahan data siswa...', 'info');
});

// Real-time validation
document.querySelectorAll('input, select, textarea').forEach(field => {
    field.addEventListener('blur', function() {
        if (this.hasAttribute('required') && !this.value.trim()) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    });
    
    field.addEventListener('input', function() {
        if (this.classList.contains('is-invalid') && this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });
});

// Smooth scroll to top when page loads
document.addEventListener('DOMContentLoaded', function() {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>
@endpush