<!DOCTYPE html>
<html lang="id" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Siswa - {{ config('app.name', 'SMA Negeri 1') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<style>
    :root {
        --primary-color: #059669;
        --primary-dark: #047857;
        --secondary-color: #10b981;
        --accent-color: #34d399;
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-tertiary: #9ca3af;
        --border-color: #e5e7eb;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --success-color: #10b981;
        --error-color: #ef4444;
        --warning-color: #f59e0b;
    }

    .dark {
        --bg-primary: #1f2937;
        --bg-secondary: #111827;
        --bg-tertiary: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #d1d5db;
        --text-tertiary: #9ca3af;
        --border-color: #374151;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    body {
        background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
        min-height: 100vh;
        font-family: 'Figtree', sans-serif;
    }

    .register-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 1rem;
    }

    .register-card {
        background: var(--bg-primary);
        border-radius: 24px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        width: 100%;
        max-width: 900px;
        overflow: hidden;
        position: relative;
    }

    .register-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #059669, #10b981, #34d399);
    }

    .register-header {
        text-align: center;
        padding: 3rem 2rem 2rem;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.05), rgba(16, 185, 129, 0.05));
        border-bottom: 1px solid var(--border-color);
    }

    .register-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 10px 25px rgba(5, 150, 105, 0.3);
    }

    .register-title {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .register-subtitle {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.6;
    }

    .register-form {
        padding: 2rem;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-section {
        background: var(--bg-secondary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-icon {
        width: 20px;
        height: 20px;
        color: var(--primary-color);
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .form-input:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .form-input.error {
        border-color: var(--error-color);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-input.success {
        border-color: var(--success-color);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .form-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
        min-height: 100px;
    }

    .form-textarea:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .error-message {
        color: var(--error-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .success-message {
        color: var(--success-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .register-button {
        width: 100%;
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        position: relative;
        overflow: hidden;
    }

    .register-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .register-button:hover::before {
        left: 100%;
    }

    .register-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
    }

    .register-button:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .login-link {
        text-align: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
    }

    .login-link a {
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .login-link a:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .back-link {
        position: absolute;
        top: 2rem;
        left: 2rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.1);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        backdrop-filter: blur(10px);
    }

    .back-link:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        transform: translateX(-5px);
    }

    .required {
        color: var(--error-color);
    }

    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    .validation-icon {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
    }

    .input-wrapper {
        position: relative;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .register-container {
            padding: 1rem;
        }

        .register-card {
            border-radius: 16px;
        }

        .register-header {
            padding: 2rem 1rem 1.5rem;
        }

        .register-title {
            font-size: 1.5rem;
        }

        .register-form {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-section {
            padding: 1rem;
        }

        .back-link {
            position: relative;
            top: auto;
            left: auto;
            margin-bottom: 1rem;
            display: inline-flex;
            background: rgba(255, 255, 255, 0.9);
            color: var(--primary-color);
        }
    }

    /* Animation */
    .register-card {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<body>
    <div class="register-container">
        <!-- Back to Home Link -->
        <a href="{{ route('home') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Beranda
        </a>

        <div class="register-card">
            <!-- Header -->
            <div class="register-header">
                <div class="register-logo">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="register-title">Daftar Siswa Baru</h1>
                <p class="register-subtitle">
                    Bergabunglah dengan SMA Negeri 1 dan mulai perjalanan pendidikan yang luar biasa. 
                    Isi formulir di bawah ini dengan lengkap dan benar.
                </p>
            </div>

            <!-- Registration Form -->
            <form method="POST" action="{{ route('student.register') }}" class="register-form" x-data="registrationForm()">
                @csrf

                <div class="form-grid">
                    <!-- Personal Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Informasi Pribadi
                        </h3>

                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap <span class="required">*</span></label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   class="form-input @error('name') error @enderror"
                                   placeholder="Masukkan nama lengkap"
                                   x-model="form.name"
                                   :readonly="studentDataFound"
                                   required>
                            @error('name')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="nis" class="form-label">NIS (Nomor Induk Siswa) <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       id="nis" 
                                       name="nis" 
                                       value="{{ old('nis') }}" 
                                       class="form-input @error('nis') error @enderror"
                                       placeholder="Masukkan NIS"
                                       x-model="form.nis"
                                       @input="checkNisAndData()"
                                       required>
                                <div x-show="nisChecking" class="validation-icon">
                                    <div class="loading"></div>
                                </div>
                                <div x-show="nisStatus === 'available' && !studentDataFound" class="validation-icon">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div x-show="studentDataFound" class="validation-icon">
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div x-show="nisStatus === 'taken'" class="validation-icon">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div x-show="nisMessage" x-text="nisMessage" :class="{
                                'success-message': nisStatus === 'available' && !studentDataFound,
                                'error-message': nisStatus === 'taken',
                                'text-blue-600': studentDataFound
                            }"></div>
                            <div x-show="studentDataFound" class="success-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                Data siswa ditemukan! Form akan diisi otomatis.
                            </div>
                            @error('nis')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email <span class="required">*</span></label>
                            <div class="input-wrapper">
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       class="form-input @error('email') error @enderror"
                                       placeholder="contoh@email.com"
                                       x-model="form.email"
                                       @input="!studentDataFound && checkEmail()"
                                       :readonly="studentDataFound"
                                       required>
                                <div x-show="emailChecking && !studentDataFound" class="validation-icon">
                                    <div class="loading"></div>
                                </div>
                                <div x-show="emailStatus === 'available' && !studentDataFound" class="validation-icon">
                                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div x-show="emailStatus === 'taken' && !studentDataFound" class="validation-icon">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </div>
                            <div x-show="emailMessage && !studentDataFound" x-text="emailMessage" :class="emailStatus === 'available' ? 'success-message' : 'error-message'"></div>
                            @error('email')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="tel" 
                                   id="phone" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   class="form-input @error('phone') error @enderror"
                                   placeholder="08xxxxxxxxxx"
                                   x-model="form.phone"
                                   :readonly="studentDataFound">
                            @error('phone')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birth_place" class="form-label">Tempat Lahir <span class="required">*</span></label>
                            <input type="text" 
                                   id="birth_place" 
                                   name="birth_place" 
                                   value="{{ old('birth_place') }}" 
                                   class="form-input @error('birth_place') error @enderror"
                                   placeholder="Kota tempat lahir"
                                   x-model="form.birth_place"
                                   :readonly="studentDataFound"
                                   required>
                            @error('birth_place')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="birth_date" class="form-label">Tanggal Lahir <span class="required">*</span></label>
                            <input type="date" 
                                   id="birth_date" 
                                   name="birth_date" 
                                   value="{{ old('birth_date') }}" 
                                   class="form-input @error('birth_date') error @enderror"
                                   x-model="form.birth_date"
                                   :readonly="studentDataFound"
                                   required>
                            @error('birth_date')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender" class="form-label">Jenis Kelamin <span class="required">*</span></label>
                            <select id="gender" 
                                    name="gender" 
                                    class="form-select @error('gender') error @enderror"
                                    x-model="form.gender"
                                    :style="studentDataFound ? 'pointer-events: none; background-color: #f3f4f6;' : ''"
                                    required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <!-- Hidden input to ensure value is submitted when auto-filled -->
                            <input x-show="studentDataFound" type="hidden" name="gender" :value="form.gender">
                            @error('gender')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="religion" class="form-label">Agama <span class="required">*</span></label>
                            <select id="religion" 
                                    name="religion" 
                                    class="form-select @error('religion') error @enderror"
                                    x-model="form.religion"
                                    :style="studentDataFound ? 'pointer-events: none; background-color: #f3f4f6;' : ''"
                                    required>
                                <option value="">Pilih Agama</option>
                                <option value="Islam" {{ old('religion') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen" {{ old('religion') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value="Katolik" {{ old('religion') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ old('religion') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ old('religion') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ old('religion') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                            <!-- Hidden input to ensure value is submitted when auto-filled -->
                            <input x-show="studentDataFound" type="hidden" name="religion" :value="form.religion">
                            @error('religion')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">Alamat Lengkap <span class="required">*</span></label>
                            <textarea id="address" 
                                      name="address" 
                                      class="form-textarea @error('address') error @enderror"
                                      placeholder="Masukkan alamat lengkap"
                                      x-model="form.address"
                                      :readonly="studentDataFound"
                                      required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- Academic Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Informasi Akademik
                        </h3>

                        <div class="form-group">
                            <label for="class" class="form-label">Kelas yang Dituju <span class="required">*</span></label>
                            <select id="class" 
                                    name="class" 
                                    class="form-select @error('class') error @enderror"
                                    x-model="form.class"
                                    :style="studentDataFound ? 'pointer-events: none; background-color: #f3f4f6;' : ''"
                                    required>
                                <option value="">Pilih Kelas</option>
                                <option value="10 TKJ 1" {{ old('class') == '10 TKJ 1' ? 'selected' : '' }}>Kelas 10 TKJ 1 - Teknik Komputer dan Jaringan</option>
                                <option value="10 TKJ 2" {{ old('class') == '10 TKJ 2' ? 'selected' : '' }}>Kelas 10 TKJ 2 - Teknik Komputer dan Jaringan</option>
                                <option value="10 RPL 1" {{ old('class') == '10 RPL 1' ? 'selected' : '' }}>Kelas 10 RPL 1 - Rekayasa Perangkat Lunak</option>
                                <option value="10 RPL 2" {{ old('class') == '10 RPL 2' ? 'selected' : '' }}>Kelas 10 RPL 2 - Rekayasa Perangkat Lunak</option>
                                <option value="10 DKV 1" {{ old('class') == '10 DKV 1' ? 'selected' : '' }}>Kelas 10 DKV 1 - Desain Komunikasi Visual</option>
                            </select>
                            <!-- Hidden input to ensure value is submitted when auto-filled -->
                            <input x-show="studentDataFound" type="hidden" name="class" :value="form.class">
                            @error('class')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Parent Information -->
                        <h3 class="section-title" style="margin-top: 2rem;">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Informasi Orang Tua/Wali
                        </h3>

                        <div class="form-group">
                            <label for="parent_name" class="form-label">Nama Orang Tua/Wali <span class="required">*</span></label>
                            <input type="text" 
                                   id="parent_name" 
                                   name="parent_name" 
                                   value="{{ old('parent_name') }}" 
                                   class="form-input @error('parent_name') error @enderror"
                                   placeholder="Nama lengkap orang tua/wali"
                                   x-model="form.parent_name"
                                   :readonly="studentDataFound"
                                   required>
                            @error('parent_name')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="parent_phone" class="form-label">Nomor Telepon Orang Tua/Wali <span class="required">*</span></label>
                            <input type="tel" 
                                   id="parent_phone" 
                                   name="parent_phone" 
                                   value="{{ old('parent_phone') }}" 
                                   class="form-input @error('parent_phone') error @enderror"
                                   placeholder="08xxxxxxxxxx"
                                   x-model="form.parent_phone"
                                   :readonly="studentDataFound"
                                   required>
                            @error('parent_phone')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="parent_email" class="form-label">Email Orang Tua/Wali</label>
                            <input type="email" 
                                   id="parent_email" 
                                   name="parent_email" 
                                   value="{{ old('parent_email') }}" 
                                   class="form-input @error('parent_email') error @enderror"
                                   placeholder="email@orangtua.com">
                            @error('parent_email')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Password Section -->
                        <h3 class="section-title" style="margin-top: 2rem;">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Keamanan Akun
                        </h3>

                        <div class="form-group">
                            <label for="password" class="form-label">Password <span class="required">*</span></label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="form-input @error('password') error @enderror"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            @error('password')
                                <div class="error-message">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="required">*</span></label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="form-input"
                                   placeholder="Ulangi password"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="register-button"
                        :disabled="isSubmitting"
                        x-text="isSubmitting ? 'Mendaftar...' : 'Daftar Sekarang'">
                </button>

                <!-- Login Link -->
                <div class="login-link">
                    <p>Sudah memiliki akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function registrationForm() {
            return {
                form: {
                    nis: '',
                    name: '',
                    email: '',
                    phone: '',
                    address: '',
                    class: '',
                    birth_date: '',
                    birth_place: '',
                    gender: '',
                    religion: '',
                    parent_name: '',
                    parent_phone: ''
                },
                nisStatus: '',
                nisMessage: '',
                nisChecking: false,
                emailStatus: '',
                emailMessage: '',
                emailChecking: false,
                isSubmitting: false,
                studentDataFound: false,

                async checkNisAndData() {
                    if (this.form.nis.length < 3) {
                        this.nisStatus = '';
                        this.nisMessage = '';
                        this.studentDataFound = false;
                        return;
                    }

                    this.nisChecking = true;
                    
                    try {
                        // First check NIS availability
                        const nisResponse = await fetch(`{{ route('student.check-nis') }}?nis=${this.form.nis}`);
                        const nisData = await nisResponse.json();
                        
                        this.nisStatus = nisData.available ? 'available' : 'taken';
                        this.nisMessage = nisData.message;
                        
                        // If NIS is available, check for student data
                        if (nisData.available) {
                            const dataResponse = await fetch(`{{ route('student.check-data') }}?nis=${this.form.nis}`);
                            const dataResult = await dataResponse.json();
                            
                            if (dataResult.exists && !dataResult.hasAccount && dataResult.data) {
                                this.studentDataFound = true;
                                this.fillFormWithStudentData(dataResult.data);
                            } else {
                                this.studentDataFound = false;
                                this.clearFormData();
                            }
                        } else {
                            this.studentDataFound = false;
                        }
                    } catch (error) {
                        console.error('Error checking NIS:', error);
                    } finally {
                        this.nisChecking = false;
                    }
                },

                fillFormWithStudentData(data) {
                    // Fill form fields with student data
                    this.form.name = data.name || '';
                    this.form.email = data.email || '';
                    this.form.phone = data.phone || '';
                    this.form.address = data.address || '';
                    this.form.class = data.class || '';
                    this.form.birth_date = data.birth_date || '';
                    this.form.birth_place = data.birth_place || '';
                    this.form.gender = data.gender || '';
                    this.form.religion = data.religion || '';
                    this.form.parent_name = data.parent_name || '';
                    this.form.parent_phone = data.parent_phone || '';
                    
                    // Use setTimeout to ensure DOM is ready and Alpine.js has processed the data
                    setTimeout(() => {
                        // Update actual form inputs
                        document.getElementById('name').value = this.form.name;
                        document.getElementById('email').value = this.form.email;
                        document.getElementById('phone').value = this.form.phone;
                        document.getElementById('address').value = this.form.address;
                        document.getElementById('birth_date').value = this.form.birth_date;
                        document.getElementById('birth_place').value = this.form.birth_place;
                        document.getElementById('parent_name').value = this.form.parent_name;
                        document.getElementById('parent_phone').value = this.form.parent_phone;
                        
                        // For select elements, we need to set both the value and trigger change event
                        const classSelect = document.getElementById('class');
                        const genderSelect = document.getElementById('gender');
                        const religionSelect = document.getElementById('religion');
                        
                        if (classSelect && this.form.class) {
                            classSelect.value = this.form.class;
                            // Force update the Alpine.js model
                            this.form.class = this.form.class;
                            // Trigger change event to ensure Alpine.js detects the change
                            classSelect.dispatchEvent(new Event('change', { bubbles: true }));
                            classSelect.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                        
                        if (genderSelect && this.form.gender) {
                            genderSelect.value = this.form.gender;
                            // Force update the Alpine.js model
                            this.form.gender = this.form.gender;
                            // Trigger change event to ensure Alpine.js detects the change
                            genderSelect.dispatchEvent(new Event('change', { bubbles: true }));
                            genderSelect.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                        
                        if (religionSelect && this.form.religion) {
                            religionSelect.value = this.form.religion;
                            // Force update the Alpine.js model
                            this.form.religion = this.form.religion;
                            // Trigger change event to ensure Alpine.js detects the change
                            religionSelect.dispatchEvent(new Event('change', { bubbles: true }));
                            religionSelect.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                        
                        // Update textarea
                        const addressTextarea = document.getElementById('address');
                        if (addressTextarea) {
                            addressTextarea.value = this.form.address;
                        }
                        
                        // Force Alpine.js to re-evaluate the form state
                        this.$nextTick(() => {
                            // Trigger a manual update to ensure all bindings are correct
                            this.form = { ...this.form };
                        });
                    }, 100);
                },

                clearFormData() {
                    // Clear form fields except NIS
                    const fieldsToKeep = ['nis'];
                    Object.keys(this.form).forEach(key => {
                        if (!fieldsToKeep.includes(key)) {
                            this.form[key] = '';
                        }
                    });
                    
                    // Also clear the actual form elements
                    setTimeout(() => {
                        const formElements = [
                            'name', 'email', 'phone', 'address', 'birth_date', 
                            'birth_place', 'parent_name', 'parent_phone'
                        ];
                        
                        formElements.forEach(elementId => {
                            const element = document.getElementById(elementId);
                            if (element) {
                                element.value = '';
                            }
                        });
                        
                        // Clear select elements
                        const classSelect = document.getElementById('class');
                        const genderSelect = document.getElementById('gender');
                        const religionSelect = document.getElementById('religion');
                        
                        if (classSelect) {
                            classSelect.value = '';
                            classSelect.dispatchEvent(new Event('change'));
                        }
                        
                        if (genderSelect) {
                            genderSelect.value = '';
                            genderSelect.dispatchEvent(new Event('change'));
                        }
                        
                        if (religionSelect) {
                            religionSelect.value = '';
                            religionSelect.dispatchEvent(new Event('change'));
                        }
                    }, 50);
                },

                async checkEmail() {
                    if (this.form.email.length < 3) {
                        this.emailStatus = '';
                        this.emailMessage = '';
                        return;
                    }

                    this.emailChecking = true;
                    
                    try {
                        const response = await fetch(`{{ route('student.check-email') }}?email=${this.form.email}`);
                        const data = await response.json();
                        
                        this.emailStatus = data.available ? 'available' : 'taken';
                        this.emailMessage = data.message;
                    } catch (error) {
                        console.error('Error checking email:', error);
                    } finally {
                        this.emailChecking = false;
                    }
                },
                
                // Initialize form and add submit handler
                init() {
                    // Add form submit handler to ensure all values are synced
                    const form = this.$el.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', (e) => {
                            // Sync Alpine.js model values to DOM elements before submit
                            this.syncFormValues();
                            
                            // Debug: Log form values before submit
                            console.log('Form submission - Alpine.js model:', this.form);
                            console.log('Form submission - DOM values:', {
                                class: document.getElementById('class')?.value,
                                gender: document.getElementById('gender')?.value,
                                religion: document.getElementById('religion')?.value
                            });
                        });
                    }
                },
                
                syncFormValues() {
                    // Ensure all form values are synced from Alpine.js model to DOM
                    const elements = {
                        'class': this.form.class,
                        'gender': this.form.gender,
                        'religion': this.form.religion,
                        'name': this.form.name,
                        'email': this.form.email,
                        'phone': this.form.phone,
                        'birth_date': this.form.birth_date,
                        'birth_place': this.form.birth_place,
                        'address': this.form.address,
                        'parent_name': this.form.parent_name,
                        'parent_phone': this.form.parent_phone
                    };
                    
                    Object.keys(elements).forEach(id => {
                        const element = document.getElementById(id);
                        if (element && elements[id] !== undefined && elements[id] !== null) {
                            element.value = elements[id];
                        }
                    });
                }
            }
        }
    </script>
</body>
</html>