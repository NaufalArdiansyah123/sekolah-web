@extends('layouts.admin')

@section('title', 'Tambah Siswa')

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

    .form-container {
        background: var(--white);
        border-radius: 24px;
        box-shadow: var(--shadow-xl);
        overflow: hidden;
        margin: 0 auto;
        max-width: 1200px;
    }

    .form-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .form-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }

    .form-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }

    .form-subtitle {
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

    .form-body {
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

    .photo-preview {
        max-width: 200px;
        max-height: 200px;
        border-radius: 16px;
        box-shadow: var(--shadow-lg);
        margin: 1rem auto;
    }

    .user-account-card {
        background: #eff6ff;
        border: 2px solid #bfdbfe;
        border-radius: 16px;
        padding: 1.5rem;
        margin-top: 1rem;
    }

    .dark .user-account-card {
        background: #1e3a8a;
        border-color: #3730a3;
    }

    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .custom-checkbox {
        width: 20px;
        height: 20px;
        border: 2px solid var(--primary-color);
        border-radius: 4px;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-checkbox input {
        opacity: 0;
        position: absolute;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .custom-checkbox input:checked + .checkmark {
        background: var(--primary-color);
        border-color: var(--primary-color);
    }

    .custom-checkbox input:checked + .checkmark::after {
        content: '✓';
        color: white;
        font-size: 12px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
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

    .btn-outline-form {
        background: transparent;
        border: 2px solid var(--gray-300);
        color: var(--gray-600);
    }

    .btn-outline-form:hover {
        background: var(--gray-100);
        color: var(--gray-700);
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

    .floating-btn-secondary {
        background: linear-gradient(135deg, var(--gray-500), var(--gray-600));
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

    @media (max-width: 768px) {
        .page-container {
            padding: 1rem;
        }

        .form-header {
            padding: 1.5rem;
            text-align: center;
        }

        .form-title {
            font-size: 2rem;
        }

        .header-actions {
            justify-content: center;
            flex-wrap: wrap;
        }

        .form-body {
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
    <div class="form-container">
        <!-- Form Header -->
        <div class="form-header">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h1 class="form-title">
                        <i class="fas fa-user-plus me-3"></i>Tambah Siswa Baru
                    </h1>
                    <p class="form-subtitle">
                        Lengkapi formulir di bawah untuk menambahkan data siswa baru
                    </p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.students.index') }}" class="btn-header">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="form-body">
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

            <form method="POST" action="{{ route('admin.students.store') }}" enctype="multipart/form-data" id="studentForm">
                @csrf
                
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
                                       id="name" name="name" value="{{ old('name') }}" required>
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
                                           id="nis" name="nis" value="{{ old('nis') }}" 
                                           placeholder="Contoh: 2024100001" 
                                           pattern="[0-9]+" 
                                           minlength="6" 
                                           maxlength="20" 
                                           required>
                                    <div class="validation-icon" id="nisValidationIcon" style="display: none;"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" 
                                            id="generateNisBtn" 
                                            style="position: absolute; right: 5px; top: 5px; z-index: 10; font-size: 0.7rem; padding: 0.25rem 0.5rem;"
                                            title="Generate NIS otomatis">
                                        <i class="fas fa-magic"></i>
                                    </button>
                                </div>
                                <div id="nisValidationMessage" class="validation-message" style="display: none;"></div>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text">Format: Tahun(4) + Kelas(2) + Urutan(3). Contoh: 2024100001</small>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nisn" class="form-label">NISN</label>
                                <div class="validation-wrapper">
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                                           id="nisn" name="nisn" value="{{ old('nisn') }}" 
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
                                       id="email" name="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}">
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
                                                <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                       id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
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
                                       id="birth_place" name="birth_place" value="{{ old('birth_place') }}" required>
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
                                               {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="male">
                                            <i class="fas fa-mars me-1"></i>Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" 
                                               {{ old('gender') == 'female' ? 'checked' : '' }} required>
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
                                        <option value="{{ $value }}" {{ old('religion') == $value ? 'selected' : '' }}>{{ $label }}</option>
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
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                    <option value="graduated" {{ old('status') == 'graduated' ? 'selected' : '' }}>Lulus</option>
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
                                  placeholder="Masukkan alamat lengkap...">{{ old('address') }}</textarea>
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
                                       id="parent_name" name="parent_name" value="{{ old('parent_name') }}" required>
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_phone" class="form-label">Telepon Orang Tua/Wali</label>
                                <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                                       id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}">
                                @error('parent_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Photo Upload Section -->
                <div class="form-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-camera"></i>
                        </div>
                        Foto Siswa
                    </h3>
                    
                    <div class="photo-upload-area" onclick="document.getElementById('photo').click()">
                        <i class="fas fa-cloud-upload-alt fa-3x mb-3"></i>
                        <h5>Klik untuk upload foto atau drag & drop</h5>
                        <p>Format: JPG, PNG, GIF. Maksimal 2MB</p>
                        <input type="file" class="d-none @error('photo') is-invalid @enderror" 
                               id="photo" name="photo" accept="image/*">
                    </div>
                    
                    <div id="photoPreview" class="text-center" style="display: none;">
                        <img id="previewImage" src="" alt="Preview" class="photo-preview">
                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removePhoto()">
                            <i class="fas fa-trash"></i> Hapus Foto
                        </button>
                    </div>
                    
                    @error('photo')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- QR Code & User Account Section -->
                <div class="form-section fade-in">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        QR Code Absensi & Akun Pengguna (Opsional)
                    </h3>
                    
                    <!-- QR Code Auto-Generate Option -->
                    <div class="checkbox-wrapper mb-3">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="auto_generate_qr" name="auto_generate_qr" value="1" checked>
                            <div class="checkmark"></div>
                        </div>
                        <label for="auto_generate_qr" class="form-label mb-0">
                            <i class="fas fa-qrcode text-primary me-2"></i>
                            Otomatis buat QR Code absensi untuk siswa ini
                        </label>
                    </div>
                    
                    <div class="alert-custom alert-info-custom mb-3">
                        <i class="fas fa-info-circle"></i>
                        <small>
                            <strong>QR Code Absensi:</strong> Jika dicentang, sistem akan otomatis membuat QR Code untuk absensi siswa. 
                            QR Code dapat digunakan untuk scan absensi harian dan dapat di-download dari halaman manajemen QR.
                        </small>
                    </div>
                    
                    <hr class="my-4">
                    
                    <!-- User Account Option -->
                    <div class="checkbox-wrapper">
                        <div class="custom-checkbox">
                            <input type="checkbox" id="create_user_account" name="create_user_account" value="1">
                            <div class="checkmark"></div>
                        </div>
                        <label for="create_user_account" class="form-label mb-0">
                            <i class="fas fa-key text-warning me-2"></i>
                            Buat akun pengguna untuk siswa ini
                        </label>
                    </div>
                    
                    <div id="userAccountFields" style="display: none;">
                        <div class="user-account-card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">
                                            Password <span class="required">*</span>
                                        </label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                               id="password" name="password" minlength="8">
                                        <small class="form-text">Minimal 8 karakter</small>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">
                                            Konfirmasi Password <span class="required">*</span>
                                        </label>
                                        <input type="password" class="form-control" 
                                               id="password_confirmation" name="password_confirmation" minlength="8">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert-custom alert-info-custom">
                                <i class="fas fa-info-circle"></i>
                                <small>
                                    Jika akun pengguna dibuat, siswa dapat login menggunakan email dan password yang diberikan.
                                    Email harus diisi jika ingin membuat akun pengguna.
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.students.index') }}" class="btn-form btn-outline-form">
                    <i class="fas fa-arrow-left"></i>Kembali
                </a>
                <button type="button" class="btn-form btn-secondary-form" onclick="resetForm()">
                    <i class="fas fa-undo"></i>Reset
                </button>
            </div>
            
            <button type="submit" form="studentForm" class="btn-form btn-primary-form">
                <i class="fas fa-save"></i>Simpan Data Siswa
            </button>
        </div>
    </div>
</div>

<!-- Floating Action Buttons -->
<div class="floating-actions">
    <button type="submit" form="studentForm" class="floating-btn floating-btn-success" title="Simpan Data Siswa">
        <i class="fas fa-save"></i>
    </button>
    <a href="{{ route('admin.students.index') }}" class="floating-btn floating-btn-primary" title="Kembali ke Daftar">
        <i class="fas fa-list"></i>
    </a>
    <button type="button" onclick="resetForm()" class="floating-btn floating-btn-secondary" title="Reset Form">
        <i class="fas fa-undo"></i>
    </button>
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

// Remove photo
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

// User account toggle
document.getElementById('create_user_account').addEventListener('change', function() {
    const userAccountFields = document.getElementById('userAccountFields');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const passwordConfirmField = document.getElementById('password_confirmation');
    
    if (this.checked) {
        userAccountFields.style.display = 'block';
        emailField.required = true;
        passwordField.required = true;
        passwordConfirmField.required = true;
        
        // Add visual indicator that email is required
        const emailLabel = document.querySelector('label[for="email"]');
        if (emailLabel && !emailLabel.querySelector('.required')) {
            emailLabel.innerHTML += ' <span class="required">*</span>';
        }
        
        showNotification('Email wajib diisi untuk membuat akun pengguna!', 'info');
    } else {
        userAccountFields.style.display = 'none';
        emailField.required = false;
        passwordField.required = false;
        passwordConfirmField.required = false;
        passwordField.value = '';
        passwordConfirmField.value = '';
        
        // Remove required indicator from email
        const emailLabel = document.querySelector('label[for="email"]');
        const requiredSpan = emailLabel?.querySelector('.required');
        if (requiredSpan) {
            requiredSpan.remove();
        }
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
        validateNis(nis);
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
        validateNisn(nisn);
    }, 500);
});

// Generate NIS button
document.getElementById('generateNisBtn').addEventListener('click', function() {
    const classSelect = document.getElementById('class_id');
    const selectedClass = classSelect.value;
    
    if (!selectedClass) {
        alert('Pilih kelas terlebih dahulu untuk generate NIS.');
        classSelect.focus();
        return;
    }
    
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner spinner"></i>';
    
    fetch(`{{ route('admin.students.generate-nis') }}?class_id=${selectedClass}`)
        .then(response => response.json())
        .then(data => {
            if (data.suggested_nis) {
                nisInput.value = data.suggested_nis;
                validateNis(data.suggested_nis);
                showNotification('NIS berhasil di-generate!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Gagal generate NIS', 'error');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = '<i class="fas fa-magic"></i>';
        });
});

function validateNis(nis) {
    fetch(`{{ route('admin.students.check-nis') }}?nis=${nis}`)
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

function validateNisn(nisn) {
    fetch(`{{ route('admin.students.check-nisn') }}?nisn=${nisn}`)
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

// Form validation
document.getElementById('studentForm').addEventListener('submit', function(e) {
    const createUserAccount = document.getElementById('create_user_account').checked;
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const passwordConfirm = document.getElementById('password_confirmation').value;
    
    if (createUserAccount) {
        if (!email) {
            e.preventDefault();
            showNotification('Email harus diisi jika ingin membuat akun pengguna!', 'error');
            document.getElementById('email').focus();
            document.getElementById('email').classList.add('is-invalid');
            return;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            showNotification('Format email tidak valid!', 'error');
            document.getElementById('email').focus();
            document.getElementById('email').classList.add('is-invalid');
            return;
        }
        
        if (!password) {
            e.preventDefault();
            showNotification('Password harus diisi jika ingin membuat akun pengguna!', 'error');
            document.getElementById('password').focus();
            document.getElementById('password').classList.add('is-invalid');
            return;
        }
        
        if (password.length < 8) {
            e.preventDefault();
            showNotification('Password minimal 8 karakter!', 'error');
            document.getElementById('password').focus();
            document.getElementById('password').classList.add('is-invalid');
            return;
        }
        
        if (password !== passwordConfirm) {
            e.preventDefault();
            showNotification('Konfirmasi password tidak sesuai!', 'error');
            document.getElementById('password_confirmation').focus();
            document.getElementById('password_confirmation').classList.add('is-invalid');
            return;
        }
    }
    
    showNotification('Menyimpan data siswa...', 'info');
});

// Reset form
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
        document.getElementById('studentForm').reset();
        document.getElementById('photoPreview').style.display = 'none';
        document.getElementById('userAccountFields').style.display = 'none';
        document.getElementById('create_user_account').checked = false;
        
        showNotification('Form berhasil direset!', 'success');
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

// Password confirmation validation
document.getElementById('password_confirmation').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const passwordConfirm = this.value;
    
    if (passwordConfirm && password !== passwordConfirm) {
        this.classList.add('is-invalid');
    } else if (passwordConfirm && password === passwordConfirm) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-invalid', 'is-valid');
    }
});

// Password strength validation
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const passwordConfirm = document.getElementById('password_confirmation').value;
    
    if (password.length > 0 && password.length < 8) {
        this.classList.add('is-invalid');
    } else if (password.length >= 8) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-invalid', 'is-valid');
    }
    
    if (passwordConfirm) {
        document.getElementById('password_confirmation').dispatchEvent(new Event('input'));
    }
});

// Auto-generate NIS based on class
document.getElementById('class_id').addEventListener('change', function() {
    const nisField = document.getElementById('nis');
    if (!nisField.value && this.value) {
        document.getElementById('generateNisBtn').click();
    }
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
</script>
@endpush