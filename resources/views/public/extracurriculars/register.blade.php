@extends('layouts.public')

@section('title', 'Daftar ' . $extracurricular->name . ' - Ekstrakurikuler - SMK Negeri 1 Balong')

@section('content')
<style>
    :root {
        --primary-color: #1a202c;
        --secondary-color: #3182ce;
        --accent-color: #4299e1;
        --light-gray: #f7fafc;
        --dark-gray: #718096;
        --glass-bg: rgba(26, 32, 44, 0.95);
        --gradient-primary: linear-gradient(135deg, #1a202c, #3182ce);
        --gradient-light: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
    }
    
    body {
        font-family: 'Poppins', sans-serif;
        color: #333;
        line-height: 1.6;
    }
    
    /* Enhanced Hero Section */
    .registration-hero {
        background: linear-gradient(
            135deg, 
            rgba(26, 32, 44, 0.8) 0%, 
            rgba(49, 130, 206, 0.7) 50%, 
            rgba(26, 32, 44, 0.8) 100%
        ),
        url('https://images.unsplash.com/photo-1434030216411-0b793f4b4173?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') center/cover no-repeat;
        color: white;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }

    .registration-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 50%, rgba(49, 130, 206, 0.3) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(66, 153, 225, 0.3) 0%, transparent 50%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }

    .hero-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .breadcrumb {
        justify-content: center;
        margin-bottom: 2rem;
        opacity: 0.9;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .breadcrumb a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .breadcrumb-separator {
        margin: 0 0.5rem;
        opacity: 0.6;
    }

    /* Enhanced Animation Styles */
    .fade-in-up {
        opacity: 0;
        transform: translateY(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-left {
        opacity: 0;
        transform: translateX(-40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .fade-in-right {
        opacity: 0;
        transform: translateX(40px);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .scale-in {
        opacity: 0;
        transform: scale(0.8);
        transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    /* Animation Active States */
    .fade-in-up.animate,
    .fade-in-left.animate,
    .fade-in-right.animate {
        opacity: 1;
        transform: translate(0, 0);
    }
    
    .scale-in.animate {
        opacity: 1;
        transform: scale(1);
    }

    /* Enhanced Registration Section */
    .registration-section {
        padding: 80px 0;
        background: var(--light-gray);
    }

    .registration-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Enhanced Form */
    .registration-form {
        background: white;
        border-radius: 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .registration-form:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
        display: block;
        font-size: 0.9rem;
    }

    .form-label.required::after {
        content: ' *';
        color: #dc3545;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: white;
        color: var(--primary-color);
    }

    .form-input:focus {
        border-color: var(--secondary-color);
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
        outline: none;
    }

    .form-input.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .form-textarea {
        min-height: 100px;
        resize: vertical;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 0.25rem;
        display: block;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 2px solid #e5e7eb;
    }

    .btn-submit {
        flex: 1;
        background: var(--gradient-primary);
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(49, 130, 206, 0.3);
        font-size: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #2d3748, #2b6cb0);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(49, 130, 206, 0.4);
    }

    .btn-submit:disabled {
        background: #6b7280;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-back {
        background: #6b7280;
        color: white;
        padding: 1rem 2rem;
        border: none;
        border-radius: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        font-size: 1rem;
    }

    .btn-back:hover {
        background: #4b5563;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Enhanced Info Sidebar */
    .info-sidebar {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        border: 1px solid rgba(255,255,255,0.8);
        backdrop-filter: blur(10px);
        height: fit-content;
        position: sticky;
        top: 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .info-sidebar:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    }

    .extracurricular-info {
        text-align: center;
        margin-bottom: 2rem;
    }

    .extracurricular-image {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        object-fit: cover;
        margin: 0 auto 1rem;
        border: 4px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .extracurricular-image:hover {
        transform: scale(1.05);
        border-color: var(--secondary-color);
    }

    .extracurricular-image-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 20px;
        background: var(--gradient-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-weight: 600;
        font-size: 2.5rem;
        border: 4px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .extracurricular-image-placeholder:hover {
        transform: scale(1.05);
        border-color: var(--secondary-color);
    }

    .extracurricular-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .extracurricular-coach {
        color: var(--secondary-color);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .info-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }

    .info-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        padding: 0.75rem;
        background: var(--light-gray);
        border-radius: 12px;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .info-item:hover {
        background: rgba(49, 130, 206, 0.05);
        transform: translateX(4px);
        border-color: rgba(49, 130, 206, 0.2);
    }

    .info-icon {
        width: 20px;
        height: 20px;
        color: var(--secondary-color);
        flex-shrink: 0;
    }

    .info-text {
        color: var(--dark-gray);
        font-size: 0.9rem;
        font-weight: 500;
    }

    .requirements-list {
        list-style: none;
        padding: 0;
    }

    .requirements-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        padding: 0.5rem;
        background: rgba(49, 130, 206, 0.05);
        border-radius: 8px;
        border: 1px solid rgba(49, 130, 206, 0.1);
    }

    .requirements-list li::before {
        content: '✓';
        color: var(--secondary-color);
        font-weight: 600;
        flex-shrink: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .registration-hero {
            padding: 60px 0;
        }

        .hero-title {
            font-size: 2rem;
        }

        .registration-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .info-sidebar {
            position: static;
            order: 1;
        }

        .registration-form {
            order: 2;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .registration-form,
        .info-sidebar {
            padding: 1.5rem;
        }
    }

    @media (max-width: 576px) {
        .hero-title {
            font-size: 1.5rem;
        }
        
        .registration-section {
            padding: 60px 0;
        }
    }

    /* Loading state */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid rgba(255,255,255,.3);
        border-radius: 50%;
        border-top-color: #fff;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>

<!-- Enhanced Hero Section -->
<section class="registration-hero">
    <div class="container">
        <div class="hero-content">
            <!-- Breadcrumb -->
            <nav class="breadcrumb fade-in-up">
                <a href="{{ route('home') }}">Beranda</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('public.extracurriculars.index') }}">Ekstrakurikuler</a>
                <span class="breadcrumb-separator">/</span>
                <a href="{{ route('public.extracurriculars.show', $extracurricular) }}">{{ $extracurricular->name }}</a>
                <span class="breadcrumb-separator">/</span>
                <span>Pendaftaran</span>
            </nav>

            <h1 class="hero-title fade-in-up">Daftar {{ $extracurricular->name }}</h1>
            <p class="hero-subtitle fade-in-up" style="animation-delay: 0.2s;">
                Lengkapi formulir di bawah ini untuk mendaftar ekstrakurikuler
            </p>
        </div>
    </div>
</section>

<!-- Enhanced Registration Section -->
<section class="registration-section">
    <div class="container">
        <div class="registration-container">
            <!-- Enhanced Registration Form -->
            <div class="registration-form fade-in-left">
                <h2 class="form-title">
                    <i class="fas fa-user-plus"></i>
                    Formulir Pendaftaran
                </h2>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('public.extracurriculars.store-registration', $extracurricular) }}" 
                      method="POST" 
                      id="registrationForm">
                    @csrf

                    <!-- Data Siswa -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-user"></i>
                            Data Siswa
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Nama Lengkap</label>
                                <input type="text" 
                                       name="student_name" 
                                       class="form-input @error('student_name') is-invalid @enderror" 
                                       value="{{ old('student_name') }}" 
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('student_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">NIS</label>
                                <input type="text" 
                                       name="student_nis" 
                                       class="form-input @error('student_nis') is-invalid @enderror" 
                                       value="{{ old('student_nis') }}" 
                                       placeholder="Nomor Induk Siswa"
                                       required>
                                @error('student_nis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Kelas</label>
                                <select name="student_class" 
                                        class="form-input @error('student_class') is-invalid @enderror" 
                                        required>
                                    <option value="">Pilih Kelas</option>
                                    @if(isset($activeClasses))
                                        @foreach($activeClasses as $level => $classes)
                                            <optgroup label="Kelas {{ $level }}">
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->name }}" {{ old('student_class') == $class->name ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @else
                                        <!-- Fallback options if no active classes found -->
                                        <option value="10 TKJ 1" {{ old('student_class') == '10 TKJ 1' ? 'selected' : '' }}>10 TKJ 1</option>
                                        <option value="10 TKJ 2" {{ old('student_class') == '10 TKJ 2' ? 'selected' : '' }}>10 TKJ 2</option>
                                        <option value="10 RPL 1" {{ old('student_class') == '10 RPL 1' ? 'selected' : '' }}>10 RPL 1</option>
                                        <option value="10 RPL 2" {{ old('student_class') == '10 RPL 2' ? 'selected' : '' }}>10 RPL 2</option>
                                        <option value="10 DKV 1" {{ old('student_class') == '10 DKV 1' ? 'selected' : '' }}>10 DKV 1</option>
                                    @endif
                                </select>
                                @error('student_class')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Jurusan/Program Keahlian</label>
                                <select name="student_major" 
                                        class="form-input @error('student_major') is-invalid @enderror" 
                                        required>
                                    <option value="">Pilih Jurusan/Program Keahlian</option>
                                    @if(isset($activePrograms))
                                        @foreach($activePrograms as $program)
                                            <option value="{{ $program }}" {{ old('student_major') == $program ? 'selected' : '' }}>
                                                @switch($program)
                                                    @case('TKJ')
                                                        TKJ (Teknik Komputer dan Jaringan)
                                                        @break
                                                    @case('RPL')
                                                        RPL (Rekayasa Perangkat Lunak)
                                                        @break
                                                    @case('DKV')
                                                        DKV (Desain Komunikasi Visual)
                                                        @break
                                                    @default
                                                        {{ $program }}
                                                @endswitch
                                            </option>
                                        @endforeach
                                    @else
                                        <!-- Fallback options if no active programs found -->
                                        <option value="TKJ" {{ old('student_major') == 'TKJ' ? 'selected' : '' }}>TKJ (Teknik Komputer dan Jaringan)</option>
                                        <option value="RPL" {{ old('student_major') == 'RPL' ? 'selected' : '' }}>RPL (Rekayasa Perangkat Lunak)</option>
                                        <option value="DKV" {{ old('student_major') == 'DKV' ? 'selected' : '' }}>DKV (Desain Komunikasi Visual)</option>
                                    @endif
                                </select>
                                @error('student_major')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Email</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-input @error('email') is-invalid @enderror" 
                                       value="{{ old('email') }}" 
                                       placeholder="alamat@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Nomor Telepon</label>
                                <input type="tel" 
                                       name="phone" 
                                       class="form-input @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" 
                                       placeholder="08xxxxxxxxxx"
                                       required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-users"></i>
                            Data Orang Tua/Wali
                        </h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label required">Nama Orang Tua/Wali</label>
                                <input type="text" 
                                       name="parent_name" 
                                       class="form-input @error('parent_name') is-invalid @enderror" 
                                       value="{{ old('parent_name') }}" 
                                       placeholder="Nama lengkap orang tua/wali"
                                       required>
                                @error('parent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label required">Nomor Telepon Orang Tua</label>
                                <input type="tel" 
                                       name="parent_phone" 
                                       class="form-input @error('parent_phone') is-invalid @enderror" 
                                       value="{{ old('parent_phone') }}" 
                                       placeholder="08xxxxxxxxxx"
                                       required>
                                @error('parent_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label required">Alamat Lengkap</label>
                            <textarea name="address" 
                                      class="form-input form-textarea @error('address') is-invalid @enderror" 
                                      placeholder="Masukkan alamat lengkap"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Motivasi -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <i class="fas fa-heart"></i>
                            Motivasi & Pengalaman
                        </h3>

                        <div class="form-group">
                            <label class="form-label required">Alasan Bergabung</label>
                            <textarea name="reason" 
                                      class="form-input form-textarea @error('reason') is-invalid @enderror" 
                                      placeholder="Jelaskan alasan Anda ingin bergabung dengan ekstrakurikuler ini"
                                      required>{{ old('reason') }}</textarea>
                            @error('reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Pengalaman Terkait (Opsional)</label>
                            <textarea name="experience" 
                                      class="form-input form-textarea @error('experience') is-invalid @enderror" 
                                      placeholder="Ceritakan pengalaman Anda yang berkaitan dengan ekstrakurikuler ini (jika ada)">{{ old('experience') }}</textarea>
                            @error('experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('public.extracurriculars.show', $extracurricular) }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fas fa-paper-plane"></i>
                            Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>

            <!-- Enhanced Info Sidebar -->
            <div class="info-sidebar fade-in-right">
                <div class="extracurricular-info">
                    @if($extracurricular->image)
                        <img src="{{ asset('storage/' . $extracurricular->image) }}" 
                             alt="{{ $extracurricular->name }}" 
                             class="extracurricular-image">
                    @else
                        <div class="extracurricular-image-placeholder">
                            <i class="fas fa-users"></i>
                        </div>
                    @endif
                    <h3 class="extracurricular-name">{{ $extracurricular->name }}</h3>
                    <p class="extracurricular-coach">
                        <i class="fas fa-user-tie me-2"></i>
                        {{ $extracurricular->coach }}
                    </p>
                </div>

                <!-- Informasi Penting -->
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-info-circle"></i>
                        Informasi Penting
                    </h3>
                    
                    @if($extracurricular->schedule)
                        <div class="info-item">
                            <i class="fas fa-clock info-icon"></i>
                            <div class="info-text">
                                <strong>Jadwal:</strong><br>
                                {{ $extracurricular->schedule }}
                            </div>
                        </div>
                    @endif

                    <div class="info-item">
                        <i class="fas fa-users info-icon"></i>
                        <div class="info-text">
                            <strong>Total Pendaftar:</strong><br>
                            {{ $extracurricular->registration_count }} siswa
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-check-circle info-icon"></i>
                        <div class="info-text">
                            <strong>Status:</strong><br>
                            {{ $extracurricular->status === 'active' ? 'Menerima Pendaftaran' : 'Tutup' }}
                        </div>
                    </div>
                </div>

                <!-- Persyaratan -->
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-list-check"></i>
                        Persyaratan
                    </h3>
                    <ul class="requirements-list">
                        <li>Siswa aktif SMK Negeri 1 Balong</li>
                        <li>Mengisi formulir pendaftaran dengan lengkap</li>
                        <li>Mendapat persetujuan orang tua/wali</li>
                        <li>Berkomitmen mengikuti kegiatan secara rutin</li>
                        <li>Tidak sedang dalam masa sanksi sekolah</li>
                        <li>Memiliki nilai akademik yang memadai</li>
                        <li>Tidak bertentangan dengan jadwal praktik kerja industri (PKL)</li>
                    </ul>
                </div>

                <!-- Proses Selanjutnya -->
                <div class="info-section">
                    <h3 class="info-title">
                        <i class="fas fa-route"></i>
                        Proses Selanjutnya
                    </h3>
                    <ul class="requirements-list">
                        <li>Pendaftaran akan diverifikasi oleh admin</li>
                        <li>Hasil seleksi akan diumumkan dalam 3-5 hari kerja</li>
                        <li>Pemberitahuan akan dikirim melalui email</li>
                        <li>Siswa yang diterima akan dihubungi untuk orientasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    // Observe all animated elements
    const animatedElements = document.querySelectorAll('.fade-in-up, .fade-in-left, .fade-in-right, .scale-in');
    animatedElements.forEach(element => {
        observer.observe(element);
    });

    // Enhanced form validation and submission
    const form = document.getElementById('registrationForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        // Add loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<div class="spinner"></div> Mengirim...';
        
        // Add form loading class
        form.classList.add('loading');
    });

    // Enhanced form interactions
    const formInputs = document.querySelectorAll('.form-input');
    formInputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
            this.style.boxShadow = '0 0 0 3px rgba(49, 130, 206, 0.1)';
        });
        
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });

        // Real-time validation feedback
        input.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.style.borderColor = '#10b981';
            } else {
                this.style.borderColor = '#e5e7eb';
            }
        });
    });

    // Dynamic major selection based on SMK class
    const classSelect = document.querySelector('select[name="student_class"]');
    const majorSelect = document.querySelector('select[name="student_major"]');
    
    if (classSelect && majorSelect) {
        classSelect.addEventListener('change', function() {
            const selectedClass = this.value;
            
            if (!selectedClass) {
                majorSelect.value = '';
                return;
            }
            
            // Extract program from class name (e.g., "10 TKJ 1" -> "TKJ")
            const classParts = selectedClass.split(' ');
            const classProgram = classParts.length > 1 ? classParts[1] : '';
            
            // Auto-select the corresponding major if it exists
            const majorOptions = majorSelect.querySelectorAll('option');
            let programFound = false;
            
            majorOptions.forEach(option => {
                if (option.value === classProgram) {
                    option.selected = true;
                    programFound = true;
                }
            });
            
            // If no matching program found, reset selection
            if (!programFound) {
                majorSelect.value = '';
            }
        });
        
        // Trigger change event on page load if class is already selected
        if (classSelect.value) {
            classSelect.dispatchEvent(new Event('change'));
        }
    }

    // Phone number formatting
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.startsWith('0')) {
                value = value;
            } else if (value.startsWith('62')) {
                value = '0' + value.substring(2);
            }
            this.value = value;
        });
    });

    // Enhanced info item hover effects
    const infoItems = document.querySelectorAll('.info-item');
    infoItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(8px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0) scale(1)';
        });
    });

    console.log('Enhanced registration form loaded successfully!');
});
</script>
@endsection