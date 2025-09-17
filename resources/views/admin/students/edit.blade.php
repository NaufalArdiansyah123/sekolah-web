@extends('layouts.admin')

@section('title', 'Edit Siswa')

@push('styles')
<style>
    /* Dark Mode Variables for Student Edit */
    :root {
        /* Light Mode Colors */
        --edit-bg-gradient-light: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --edit-card-bg-light: rgba(255, 255, 255, 0.95);
        --edit-header-gradient-light: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        --edit-form-bg-light: #ffffff;
        --edit-input-bg-light: #ffffff;
        --edit-text-primary-light: #1f2937;
        --edit-text-secondary-light: #6b7280;
        --edit-text-muted-light: #9ca3af;
        --edit-border-light: #e5e7eb;
        --edit-shadow-light: rgba(0, 0, 0, 0.1);
        --edit-shadow-hover-light: rgba(0, 0, 0, 0.15);
        --edit-focus-light: #4f46e5;
        
        /* Dark Mode Colors */
        --edit-bg-gradient-dark: linear-gradient(135deg, #1e293b 0%, #334155 100%);
        --edit-card-bg-dark: rgba(30, 41, 59, 0.95);
        --edit-header-gradient-dark: linear-gradient(135deg, #1e40af 0%, #3730a3 100%);
        --edit-form-bg-dark: #1f2937;
        --edit-input-bg-dark: #374151;
        --edit-text-primary-dark: #f8fafc;
        --edit-text-secondary-dark: #d1d5db;
        --edit-text-muted-dark: #9ca3af;
        --edit-border-dark: #4b5563;
        --edit-shadow-dark: rgba(0, 0, 0, 0.3);
        --edit-shadow-hover-dark: rgba(0, 0, 0, 0.4);
        --edit-focus-dark: #60a5fa;
        
        /* Current Theme (Default: Light) */
        --edit-bg-gradient: var(--edit-bg-gradient-light);
        --edit-card-bg: var(--edit-card-bg-light);
        --edit-header-gradient: var(--edit-header-gradient-light);
        --edit-form-bg: var(--edit-form-bg-light);
        --edit-input-bg: var(--edit-input-bg-light);
        --edit-text-primary: var(--edit-text-primary-light);
        --edit-text-secondary: var(--edit-text-secondary-light);
        --edit-text-muted: var(--edit-text-muted-light);
        --edit-border: var(--edit-border-light);
        --edit-shadow: var(--edit-shadow-light);
        --edit-shadow-hover: var(--edit-shadow-hover-light);
        --edit-focus: var(--edit-focus-light);
    }
    
    /* Dark mode overrides */
    .dark {
        --edit-bg-gradient: var(--edit-bg-gradient-dark);
        --edit-card-bg: var(--edit-card-bg-dark);
        --edit-header-gradient: var(--edit-header-gradient-dark);
        --edit-form-bg: var(--edit-form-bg-dark);
        --edit-input-bg: var(--edit-input-bg-dark);
        --edit-text-primary: var(--edit-text-primary-dark);
        --edit-text-secondary: var(--edit-text-secondary-dark);
        --edit-text-muted: var(--edit-text-muted-dark);
        --edit-border: var(--edit-border-dark);
        --edit-shadow: var(--edit-shadow-dark);
        --edit-shadow-hover: var(--edit-shadow-hover-dark);
        --edit-focus: var(--edit-focus-dark);
    }
    
    .student-edit-container {
        background: var(--edit-bg-gradient);
        min-height: 100vh;
        padding: 2rem 0;
        transition: background 0.3s ease;
    }
    
    .edit-wrapper {
        background: var(--edit-card-bg);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px var(--edit-shadow);
        margin: 0 auto;
        max-width: 1200px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .edit-header {
        background: var(--edit-header-gradient);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: background 0.3s ease;
    }
    
    .edit-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }
    
    .edit-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .edit-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
        position: relative;
        z-index: 2;
    }
    
    .action-buttons {
        position: relative;
        z-index: 3;
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }
    
    .btn-custom {
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: 2px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }
    
    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-theme {
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
    }
    
    .btn-theme:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        transform: translateY(-2px);
        border-color: rgba(255, 255, 255, 0.5);
    }
    
    .edit-body {
        background: var(--edit-form-bg);
        padding: 2rem;
        transition: background 0.3s ease;
    }
    
    .form-section {
        background: var(--edit-form-bg);
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 5px 15px var(--edit-shadow);
        border-left: 4px solid #4f46e5;
        transition: all 0.3s ease;
    }
    
    .form-section:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px var(--edit-shadow-hover);
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--edit-text-primary);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }
    
    .section-icon {
        width: 40px;
        height: 40px;
        background: var(--edit-header-gradient);
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        transition: background 0.3s ease;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        font-weight: 600;
        color: var(--edit-text-primary);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: color 0.3s ease;
    }
    
    .required {
        color: #ef4444;
        margin-left: 0.25rem;
    }
    
    .form-control {
        background: var(--edit-input-bg);
        border: 2px solid var(--edit-border);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: var(--edit-text-primary);
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .form-control:focus {
        border-color: var(--edit-focus);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
        background: var(--edit-input-bg);
        color: var(--edit-text-primary);
    }
    
    .form-control::placeholder {
        color: var(--edit-text-muted);
    }
    
    .form-select {
        background: var(--edit-input-bg);
        border: 2px solid var(--edit-border);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        color: var(--edit-text-primary);
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
    }
    
    .form-select:focus {
        border-color: var(--edit-focus);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    
    .form-check {
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--edit-border);
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .form-check-input:checked {
        background-color: var(--edit-focus);
        border-color: var(--edit-focus);
    }
    
    .form-check-label {
        color: var(--edit-text-primary);
        font-weight: 500;
        cursor: pointer;
        transition: color 0.3s ease;
    }
    
    .textarea {
        min-height: 100px;
        resize: vertical;
    }
    
    .file-input-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
    }
    
    .file-input {
        position: absolute;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }
    
    .file-input-label {
        display: block;
        background: var(--edit-input-bg);
        border: 2px dashed var(--edit-border);
        border-radius: 10px;
        padding: 2rem;
        text-align: center;
        color: var(--edit-text-secondary);
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .file-input-label:hover {
        border-color: var(--edit-focus);
        background: var(--edit-focus);
        color: white;
    }
    
    .current-photo {
        background: var(--edit-form-bg);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid var(--edit-border);
        transition: all 0.3s ease;
    }
    
    .current-photo img {
        border-radius: 10px;
        box-shadow: 0 5px 15px var(--edit-shadow);
        transition: transform 0.3s ease;
    }
    
    .current-photo img:hover {
        transform: scale(1.05);
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.75rem;
    }
    
    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
        background: linear-gradient(135deg, #dc2626, #b91c1c);
        color: white;
    }
    
    .photo-container {
        position: relative;
        display: inline-block;
    }
    
    .photo-loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 1rem;
        border-radius: 8px;
        display: none;
    }
    
    .photo-deleted {
        opacity: 0.5;
        filter: grayscale(100%);
        transition: all 0.3s ease;
    }
    
    .alert {
        border-radius: 10px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
        border: none;
        box-shadow: 0 5px 15px var(--edit-shadow);
    }
    
    .alert-danger {
        background: linear-gradient(135deg, #fee2e2, #fecaca);
        color: #991b1b;
    }
    
    .alert-success {
        background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        color: #166534;
    }
    
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        font-weight: 500;
    }
    
    .form-text {
        color: var(--edit-text-muted);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }
    
    .btn-primary {
        background: var(--edit-header-gradient);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(79, 70, 229, 0.3);
        background: var(--edit-header-gradient);
        color: white;
    }
    
    .btn-secondary {
        background: var(--edit-input-bg);
        border: 2px solid var(--edit-border);
        border-radius: 10px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        color: var(--edit-text-primary);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px var(--edit-shadow);
        color: var(--edit-text-primary);
        text-decoration: none;
    }
    
    .form-actions {
        background: var(--edit-form-bg);
        padding: 2rem;
        border-top: 1px solid var(--edit-border);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        transition: all 0.3s ease;
    }
    
    @media (max-width: 768px) {
        .edit-wrapper {
            margin: 0 1rem;
        }
        
        .edit-header {
            padding: 1.5rem;
            text-align: center;
        }
        
        .edit-header h1 {
            font-size: 2rem;
        }
        
        .action-buttons {
            justify-content: center;
            flex-wrap: wrap;
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
        
        .btn-primary,
        .btn-secondary {
            justify-content: center;
        }
    }
    
    /* Animation untuk loading */
    .form-section {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.6s ease forwards;
    }
    
    .form-section:nth-child(1) { animation-delay: 0.1s; }
    .form-section:nth-child(2) { animation-delay: 0.2s; }
    .form-section:nth-child(3) { animation-delay: 0.3s; }
    .form-section:nth-child(4) { animation-delay: 0.4s; }
    
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="student-edit-container" x-data="studentEdit()">
    <div class="edit-wrapper">
        <!-- Header Section -->
        <div class="edit-header">
            <h1><i class="fas fa-user-edit me-3"></i>Edit Siswa</h1>
            <p>Perbarui informasi data siswa: <strong>{{ $student->name }}</strong></p>
            
            <div class="action-buttons">
                <a href="{{ route('admin.students.index') }}" class="btn-custom btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
                <button @click="$dispatch('toggle-dark-mode')" class="btn-custom btn-theme" title="Toggle Dark/Light Mode">
                    <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
                    <span x-text="darkMode ? 'Light' : 'Dark'"></span>
                </button>
            </div>
        </div>

        <div class="edit-body">
            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Terdapat kesalahan pada form:</h6>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.students.update', $student) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Personal Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        Data Pribadi
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $student->name) }}" 
                                       placeholder="Masukkan nama lengkap siswa" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nis" class="form-label">NIS <span class="required">*</span></label>
                                <input type="text" class="form-control @error('nis') is-invalid @enderror" 
                                       id="nis" name="nis" value="{{ old('nis', $student->nis) }}" 
                                       placeholder="Nomor Induk Siswa" required>
                                @error('nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nisn" class="form-label">NISN</label>
                                <input type="text" class="form-control @error('nisn') is-invalid @enderror" 
                                       id="nisn" name="nisn" value="{{ old('nisn', $student->nisn) }}" 
                                       placeholder="Nomor Induk Siswa Nasional">
                                @error('nisn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_place" class="form-label">Tempat Lahir <span class="required">*</span></label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror" 
                                       id="birth_place" name="birth_place" value="{{ old('birth_place', $student->birth_place) }}" 
                                       placeholder="Kota tempat lahir" required>
                                @error('birth_place')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="birth_date" class="form-label">Tanggal Lahir <span class="required">*</span></label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                                       id="birth_date" name="birth_date" value="{{ old('birth_date', $student->birth_date->format('Y-m-d')) }}" required>
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="form-label">Jenis Kelamin <span class="required">*</span></label>
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="male" value="male" 
                                               {{ old('gender', $student->gender) == 'male' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="male">
                                            <i class="fas fa-mars me-1"></i> Laki-laki
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gender" id="female" value="female" 
                                               {{ old('gender', $student->gender) == 'female' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="female">
                                            <i class="fas fa-venus me-1"></i> Perempuan
                                        </label>
                                    </div>
                                </div>
                                @error('gender')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address" class="form-label">Alamat</label>
                        <textarea class="form-control textarea @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3" 
                                  placeholder="Alamat lengkap siswa">{{ old('address', $student->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        Informasi Kontak
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $student->email) }}" 
                                       placeholder="alamat@email.com">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $student->phone) }}" 
                                       placeholder="08xxxxxxxxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_name" class="form-label">Nama Orang Tua/Wali <span class="required">*</span></label>
                                <input type="text" class="form-control @error('parent_name') is-invalid @enderror" 
                                       id="parent_name" name="parent_name" value="{{ old('parent_name', $student->parent_name) }}" 
                                       placeholder="Nama lengkap orang tua/wali" required>
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="parent_phone" class="form-label">Telepon Orang Tua/Wali</label>
                                <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" 
                                       id="parent_phone" name="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}" 
                                       placeholder="08xxxxxxxxxx">
                                @error('parent_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Information Section -->
                <div class="form-section">
                    <h3 class="section-title">
                        <div class="section-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        Data Akademik
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="class" class="form-label">Kelas <span class="required">*</span></label>
                                <select class="form-control form-select @error('class') is-invalid @enderror" id="class" name="class" required>
                                    <option value="">Pilih Kelas</option>
                                    @foreach(['10 IPA 1', '10 IPA 2', '10 IPS 1', '10 IPS 2', '11 IPA 1', '11 IPA 2', '11 IPS 1', '11 IPS 2', '12 IPA 1', '12 IPA 2', '12 IPS 1', '12 IPS 2'] as $class)
                                        <option value="{{ $class }}" {{ old('class', $student->class) == $class ? 'selected' : '' }}>
                                            {{ $class }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status" class="form-label">Status <span class="required">*</span></label>
                                <select class="form-control form-select @error('status') is-invalid @enderror" id="status" name="status" required>
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
                </div>

                <!-- Photo Section -->
                <div class="form-section">
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
                                <button type="button" class="btn btn-danger btn-sm" onclick="deletePhoto({{ $student->id }})" title="Hapus Foto">
                                    <i class="fas fa-trash"></i> Hapus Foto
                                </button>
                            </div>
                            <div class="photo-container">
                                <img src="{{ $student->photo_url }}" alt="Current photo" class="img-thumbnail" style="max-width: 200px;" id="currentPhoto">
                            </div>
                        </div>
                    @endif
                    
                    <div class="form-group">
                        <label for="photo" class="form-label">Upload Foto Baru</label>
                        <div class="file-input-wrapper">
                            <input type="file" class="file-input @error('photo') is-invalid @enderror" 
                                   id="photo" name="photo" accept="image/*">
                            <label for="photo" class="file-input-label">
                                <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                <div>Klik untuk upload foto atau drag & drop</div>
                                <small>Format: JPG, PNG, GIF. Maksimal 1MB</small>
                            </label>
                        </div>
                        <div class="form-text">Kosongkan jika tidak ingin mengubah foto.</div>
                        @error('photo')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Data Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Listen for dark mode toggle
    document.addEventListener('alpine:init', () => {
        Alpine.data('studentEdit', () => ({
            darkMode: localStorage.getItem('darkMode') === 'true' || false,
            
            init() {
                // Listen for theme toggle from header button
                this.$watch('darkMode', (value) => {
                    localStorage.setItem('darkMode', value);
                    this.applyTheme();
                });
                
                // Listen for global theme changes
                window.addEventListener('theme-changed', (e) => {
                    this.darkMode = e.detail.darkMode;
                });
                
                // Listen for toggle dark mode dispatch
                this.$el.addEventListener('toggle-dark-mode', () => {
                    this.toggleDarkMode();
                });
                
                this.applyTheme();
            },
            
            toggleDarkMode() {
                this.darkMode = !this.darkMode;
                
                // Dispatch to parent admin app
                window.dispatchEvent(new CustomEvent('theme-changed', { 
                    detail: { darkMode: this.darkMode } 
                }));
            },
            
            applyTheme() {
                if (this.darkMode) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            }
        }));
    });
    
    // File input enhancement
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('photo');
        const fileLabel = document.querySelector('.file-input-label');
        
        if (fileInput && fileLabel) {
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileLabel.innerHTML = `
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                        <div>File dipilih: ${fileName}</div>
                        <small>Klik lagi untuk mengganti file</small>
                    `;
                }
            });
            
            // Drag and drop functionality
            fileLabel.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--edit-focus)';
                this.style.background = 'var(--edit-focus)';
                this.style.color = 'white';
            });
            
            fileLabel.addEventListener('dragleave', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--edit-border)';
                this.style.background = 'var(--edit-input-bg)';
                this.style.color = 'var(--edit-text-secondary)';
            });
            
            fileLabel.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = 'var(--edit-border)';
                this.style.background = 'var(--edit-input-bg)';
                this.style.color = 'var(--edit-text-secondary)';
                
                if (e.dataTransfer.files.length > 0) {
                    fileInput.files = e.dataTransfer.files;
                    const fileName = e.dataTransfer.files[0].name;
                    this.innerHTML = `
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                        <div>File dipilih: ${fileName}</div>
                        <small>Klik lagi untuk mengganti file</small>
                    `;
                }
            });
        }
        
        // Form validation enhancement
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    // Scroll to first invalid field
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                }
            });
        }
        
        // Smooth scroll to top when page loads
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Add loading animation to form sections
        const sections = document.querySelectorAll('.form-section');
        sections.forEach((section, index) => {
            section.style.animationDelay = `${index * 0.1}s`;
        });
    });
    
    // Delete photo function
    function deletePhoto(studentId) {
        // Konfirmasi penghapusan
        const confirmDelete = confirm(
            '⚠️ KONFIRMASI HAPUS FOTO ⚠️\n\n' +
            'Apakah Anda yakin ingin menghapus foto profil siswa ini?\n' +
            'Foto yang dihapus tidak dapat dikembalikan!\n\n' +
            'Klik OK untuk melanjutkan atau Cancel untuk membatalkan.'
        );
        
        if (!confirmDelete) {
            return;
        }
        
        // Show loading state
        const photoContainer = document.querySelector('.photo-container');
        const currentPhoto = document.getElementById('currentPhoto');
        const deleteButton = document.querySelector('button[onclick*="deletePhoto"]');
        
        if (photoContainer && currentPhoto && deleteButton) {
            // Disable button and show loading
            deleteButton.disabled = true;
            deleteButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus...';
            currentPhoto.classList.add('photo-deleted');
            
            // Add loading overlay
            const loadingOverlay = document.createElement('div');
            loadingOverlay.className = 'photo-loading';
            loadingOverlay.style.display = 'block';
            loadingOverlay.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghapus foto...';
            photoContainer.appendChild(loadingOverlay);
        }
        
        // Send AJAX request
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
                // Success - remove photo section
                const photoSection = document.getElementById('currentPhotoSection');
                if (photoSection) {
                    // Animate out
                    photoSection.style.transition = 'all 0.5s ease';
                    photoSection.style.opacity = '0';
                    photoSection.style.transform = 'translateY(-20px)';
                    
                    setTimeout(() => {
                        photoSection.remove();
                    }, 500);
                }
                
                // Show success message
                showNotification('success', 'Berhasil!', data.message);
                
            } else {
                // Error - restore button state
                if (deleteButton) {
                    deleteButton.disabled = false;
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i> Hapus Foto';
                }
                if (currentPhoto) {
                    currentPhoto.classList.remove('photo-deleted');
                }
                
                // Remove loading overlay
                const loadingOverlay = document.querySelector('.photo-loading');
                if (loadingOverlay) {
                    loadingOverlay.remove();
                }
                
                // Show error message
                showNotification('error', 'Gagal!', data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            
            // Restore button state
            if (deleteButton) {
                deleteButton.disabled = false;
                deleteButton.innerHTML = '<i class="fas fa-trash"></i> Hapus Foto';
            }
            if (currentPhoto) {
                currentPhoto.classList.remove('photo-deleted');
            }
            
            // Remove loading overlay
            const loadingOverlay = document.querySelector('.photo-loading');
            if (loadingOverlay) {
                loadingOverlay.remove();
            }
            
            // Show error message
            showNotification('error', 'Error!', 'Terjadi kesalahan saat menghapus foto. Silakan coba lagi.');
        });
    }
    
    // Notification function
    function showNotification(type, title, message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} notification-popup`;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                <div>
                    <strong>${title}</strong><br>
                    <small>${message}</small>
                </div>
                <button type="button" class="btn-close ms-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 300);
            }
        }, 5000);
    }
</script>
@endpush