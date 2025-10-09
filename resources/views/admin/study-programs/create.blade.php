@extends('layouts.admin')

@section('title', 'Tambah Program Keahlian')

@push('styles')
<style>
    /* CSS Variables for Dark Mode */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
        --success-color: #10b981;
        --warning-color: #f59e0b;
        --danger-color: #ef4444;
    }

    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-tertiary: #94a3b8;
        --border-color: #334155;
        --shadow-color: rgba(0, 0, 0, 0.3);
    }

    /* Base Styles */
    .create-program-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(16, 185, 129, 0.2);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: rgba(255, 255, 255, 0.1);
        transform: rotate(-15deg);
    }

    .header-content {
        position: relative;
        z-index: 2;
        text-align: center;
        width: 100%;
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 1.5rem;
    }

    .btn-back {
        background: white;
        color: #059669;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-back:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #059669;
        text-decoration: none;
    }

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        animation: slideUp 0.5s ease-out;
    }

    .form-header {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .form-header h2 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }

    .form-body {
        padding: 2rem;
        background: var(--bg-primary);
        transition: all 0.3s ease;
    }

    /* Form Groups */
    .form-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-bottom: 0;
    }

    .form-section {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .form-label .required {
        color: #ef4444;
        font-size: 0.75rem;
    }

    .form-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
    }

    .form-input:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .form-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        outline: none;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Error Messages */
    .invalid-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Help Text */
    .form-help {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    /* Form Actions */
    .form-actions {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--bg-secondary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary:hover {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Alerts */
    .alert {
        border-radius: 12px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert-info {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    /* Dynamic Form Sections */
    .dynamic-section {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dynamic-section:hover {
        border-color: #10b981;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }

    .dynamic-header {
        background: var(--bg-tertiary);
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dynamic-body {
        padding: 1.5rem;
        background: var(--bg-primary);
    }

    .btn-add {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-remove {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.375rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-remove:hover {
        transform: scale(1.05);
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    /* Subject/Specialization Items */
    .subject-item, .specialization-item {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
    }

    .subject-item:hover, .specialization-item:hover {
        border-color: #10b981;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.1);
    }

    .subject-item-header, .specialization-item-header {
        background: var(--bg-tertiary);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .subject-item-body, .specialization-item-body {
        padding: 1rem;
        background: var(--bg-primary);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .create-program-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .form-actions > * {
            width: 100%;
            justify-content: center;
        }
    }

    /* Animation */
    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="create-program-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Program Keahlian
            </h1>
            <p class="page-subtitle">Buat program keahlian SMK dengan informasi lengkap dan terstruktur</p>
            <a href="{{ route('admin.study-programs.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Help Guide -->
    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Mohon perbaiki kesalahan berikut:</strong>
                <ul style="margin: 0.5rem 0 0 1rem; list-style: disc;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Form Container -->
    <div class="form-container">
        <div class="form-header">
            <h2>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                </svg>
                Detail Program Keahlian
            </h2>
        </div>

        <form action="{{ route('admin.study-programs.store') }}" method="POST" id="studyProgramForm" enctype="multipart/form-data">
            @csrf
            
            <div class="form-body">
                <div class="form-row">
                    <!-- Left Column - Main Content -->
                    <div class="form-section">
                        <!-- Basic Information -->
                        <div class="form-group">
                            <label for="program_name" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                </svg>
                                Nama Program Keahlian
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="program_name" 
                                   id="program_name" 
                                   class="form-input @error('program_name') is-invalid @enderror" 
                                   value="{{ old('program_name') }}" 
                                   required
                                   placeholder="Contoh: Teknik Komputer dan Jaringan">
                            @error('program_name')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="program_code" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Kode Program
                            </label>
                            <input type="text" 
                                   name="program_code" 
                                   id="program_code" 
                                   class="form-input @error('program_code') is-invalid @enderror" 
                                   value="{{ old('program_code') }}" 
                                   placeholder="Contoh: TKJ, RPL, MM, TKR">
                            @error('program_code')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Deskripsi Program
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-input form-textarea @error('description') is-invalid @enderror" 
                                      placeholder="Deskripsi singkat tentang program keahlian ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="vision" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Visi Program
                            </label>
                            <textarea name="vision" 
                                      id="vision" 
                                      class="form-input form-textarea @error('vision') is-invalid @enderror" 
                                      placeholder="Visi program keahlian...">{{ old('vision') }}</textarea>
                            @error('vision')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mission" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4a2 2 0 002 2h2a2 2 0 002-2v-4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m0 0V3a2 2 0 00-2-2H9a2 2 0 00-2 2v2z"/>
                                </svg>
                                Misi Program
                            </label>
                            <textarea name="mission" 
                                      id="mission" 
                                      class="form-input form-textarea @error('mission') is-invalid @enderror" 
                                      placeholder="Misi program keahlian...">{{ old('mission') }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="career_prospects" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                                </svg>
                                Prospek Karir
                            </label>
                            <textarea name="career_prospects" 
                                      id="career_prospects" 
                                      class="form-input form-textarea @error('career_prospects') is-invalid @enderror" 
                                      placeholder="Peluang karir untuk lulusan program ini...">{{ old('career_prospects') }}</textarea>
                            @error('career_prospects')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="admission_requirements" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                Syarat Masuk
                            </label>
                            <textarea name="admission_requirements" 
                                      id="admission_requirements" 
                                      class="form-input form-textarea @error('admission_requirements') is-invalid @enderror" 
                                      placeholder="Syarat untuk masuk program ini...">{{ old('admission_requirements') }}</textarea>
                            @error('admission_requirements')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mata Pelajaran Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Mata Pelajaran Produktif
                                </h6>
                                <button type="button" class="btn-add" onclick="addSubject()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Mata Pelajaran
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="subjects-container">
                                    <!-- Subjects will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="core_subjects_json" class="form-label">Data Mata Pelajaran (JSON)</label>
                                    <textarea class="form-input @error('core_subjects_json') is-invalid @enderror" 
                                              id="core_subjects_json" name="core_subjects_json" rows="4" readonly
                                              placeholder='Data mata pelajaran akan muncul di sini secara otomatis'>{{ old('core_subjects_json', '[]') }}</textarea>
                                    <div class="form-help">Field ini akan terisi otomatis berdasarkan mata pelajaran yang ditambahkan di atas.</div>
                                    @error('core_subjects_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Kompetensi Keahlian Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    Kompetensi Keahlian
                                </h6>
                                <button type="button" class="btn-add" onclick="addSpecialization()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Kompetensi
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="specializations-container">
                                    <!-- Specializations will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="specializations_json" class="form-label">Data Kompetensi (JSON)</label>
                                    <textarea class="form-input @error('specializations_json') is-invalid @enderror" 
                                              id="specializations_json" name="specializations_json" rows="4" readonly
                                              placeholder='Data kompetensi akan muncul di sini secara otomatis'>{{ old('specializations_json', '[]') }}</textarea>
                                    <div class="form-help">Field ini akan terisi otomatis berdasarkan kompetensi yang ditambahkan di atas.</div>
                                    @error('specializations_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Fasilitas Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                    </svg>
                                    Fasilitas Program
                                </h6>
                                <button type="button" class="btn-add" onclick="addFacility()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Fasilitas
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="facilities-container">
                                    <!-- Facilities will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="facilities_json" class="form-label">Data Fasilitas (JSON)</label>
                                    <textarea class="form-input @error('facilities_json') is-invalid @enderror" 
                                              id="facilities_json" name="facilities_json" rows="4" readonly
                                              placeholder='Data fasilitas akan muncul di sini secara otomatis'>{{ old('facilities_json', '[]') }}</textarea>
                                    <div class="form-help">Field ini akan terisi otomatis berdasarkan fasilitas yang ditambahkan di atas.</div>
                                    @error('facilities_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div class="form-section">
                        <!-- Academic Details -->
                        <div class="form-group">
                            <label for="degree_level" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                Jenjang Pendidikan
                                <span class="required">*</span>
                            </label>
                            <select class="form-input @error('degree_level') is-invalid @enderror" 
                                    id="degree_level" name="degree_level" required>
                                <option value="">Pilih Jenjang</option>
                                <option value="SMK" {{ old('degree_level') === 'SMK' ? 'selected' : '' }}>SMK (Sekolah Menengah Kejuruan)</option>
                            </select>
                            @error('degree_level')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="faculty" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                </svg>
                                Bidang Keahlian
                            </label>
                            <select class="form-input @error('faculty') is-invalid @enderror" 
                                    id="faculty" name="faculty">
                                <option value="">Pilih Bidang Keahlian</option>
                                <option value="Teknologi Informasi dan Komunikasi" {{ old('faculty') === 'Teknologi Informasi dan Komunikasi' ? 'selected' : '' }}>Teknologi Informasi dan Komunikasi</option>
                                <option value="Teknik Mesin" {{ old('faculty') === 'Teknik Mesin' ? 'selected' : '' }}>Teknik Mesin</option>
                                <option value="Teknik Elektro" {{ old('faculty') === 'Teknik Elektro' ? 'selected' : '' }}>Teknik Elektro</option>
                                <option value="Teknik Otomotif" {{ old('faculty') === 'Teknik Otomotif' ? 'selected' : '' }}>Teknik Otomotif</option>
                                <option value="Teknik Bangunan" {{ old('faculty') === 'Teknik Bangunan' ? 'selected' : '' }}>Teknik Bangunan</option>
                                <option value="Bisnis dan Manajemen" {{ old('faculty') === 'Bisnis dan Manajemen' ? 'selected' : '' }}>Bisnis dan Manajemen</option>
                                <option value="Pariwisata" {{ old('faculty') === 'Pariwisata' ? 'selected' : '' }}>Pariwisata</option>
                                <option value="Seni dan Industri Kreatif" {{ old('faculty') === 'Seni dan Industri Kreatif' ? 'selected' : '' }}>Seni dan Industri Kreatif</option>
                                <option value="Agribisnis dan Agroteknologi" {{ old('faculty') === 'Agribisnis dan Agroteknologi' ? 'selected' : '' }}>Agribisnis dan Agroteknologi</option>
                                <option value="Kesehatan dan Pekerjaan Sosial" {{ old('faculty') === 'Kesehatan dan Pekerjaan Sosial' ? 'selected' : '' }}>Kesehatan dan Pekerjaan Sosial</option>
                            </select>
                            @error('faculty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="duration_years" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Lama Pendidikan (Tahun)
                            </label>
                            <select class="form-input @error('duration_years') is-invalid @enderror" 
                                    id="duration_years" name="duration_years">
                                <option value="">Pilih Lama Pendidikan</option>
                                <option value="3" {{ old('duration_years') == '3' ? 'selected' : '' }}>3 Tahun</option>
                                <option value="4" {{ old('duration_years') == '4' ? 'selected' : '' }}>4 Tahun</option>
                            </select>
                            @error('duration_years')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>









                        <!-- Settings -->
                        <div class="form-group">
                            <label class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pengaturan
                            </label>
                            <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-top: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                    <label for="is_active" style="margin: 0; font-weight: normal;">
                                        Aktifkan program ini
                                    </label>
                                </div>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                    <label for="is_featured" style="margin: 0; font-weight: normal;">
                                        Jadikan program unggulan
                                    </label>
                                </div>
                            </div>
                            <div class="form-help">Program aktif akan ditampilkan di halaman publik. Program unggulan akan disorot.</div>
                        </div>

                        <!-- Media Upload -->
                        <div class="form-group">
                            <label for="program_image" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Gambar Program
                            </label>
                            <input type="file" class="form-input @error('program_image') is-invalid @enderror" 
                                   id="program_image" name="program_image" accept="image/*">
                            <div class="form-help">JPG, PNG, GIF. Maksimal 5MB.</div>
                            @error('program_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="brochure_file" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Brosur Program
                            </label>
                            <input type="file" class="form-input @error('brochure_file') is-invalid @enderror" 
                                   id="brochure_file" name="brochure_file" accept=".pdf,.doc,.docx">
                            <div class="form-help">PDF, DOC, DOCX. Maksimal 10MB.</div>
                            @error('brochure_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.study-programs.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Program Keahlian
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Global variables for management
let subjectsData = [];
let subjectCounter = 0;
let specializationsData = [];
let specializationCounter = 0;
let facilitiesData = [];
let facilityCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize from old data if exists
    const oldSubjectsJson = document.getElementById('core_subjects_json').value;
    if (oldSubjectsJson && oldSubjectsJson !== '[]') {
        try {
            subjectsData = JSON.parse(oldSubjectsJson);
            subjectsData.forEach(subject => {
                addSubjectToDOM(subject);
            });
        } catch (e) {
            console.error('Error parsing subjects JSON:', e);
        }
    }

    const oldSpecializationsJson = document.getElementById('specializations_json').value;
    if (oldSpecializationsJson && oldSpecializationsJson !== '[]') {
        try {
            specializationsData = JSON.parse(oldSpecializationsJson);
            specializationsData.forEach(specialization => {
                addSpecializationToDOM(specialization);
            });
        } catch (e) {
            console.error('Error parsing specializations JSON:', e);
        }
    }

    const oldFacilitiesJson = document.getElementById('facilities_json').value;
    if (oldFacilitiesJson && oldFacilitiesJson !== '[]') {
        try {
            facilitiesData = JSON.parse(oldFacilitiesJson);
            facilitiesData.forEach(facility => {
                addFacilityToDOM(facility);
            });
        } catch (e) {
            console.error('Error parsing facilities JSON:', e);
        }
    }

    // Form submission
    const form = document.getElementById('studyProgramForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Update JSON fields before submission
        updateSubjectsJSON();
        updateSpecializationsJSON();
        updateFacilitiesJSON();
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="spinner"></div>
            Menyimpan...
        `;
        
        // Add loading class to form
        form.classList.add('loading');
    });

    // Form validation enhancement
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        field.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });

        field.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Prevent form submission if there are validation errors
    form.addEventListener('submit', function(e) {
        let hasErrors = false;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                hasErrors = true;
            }
        });

        if (hasErrors) {
            e.preventDefault();
            submitBtn.disabled = false;
            submitBtn.innerHTML = `
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Program Keahlian
            `;
            form.classList.remove('loading');
            
            // Show error message
            alert('Mohon lengkapi semua field yang wajib diisi.');
        }
    });
});

// Subjects Management Functions
function addSubject() {
    const subject = {
        id: ++subjectCounter,
        name: '',
        code: '',
        hours: '',
        semester: '',
        description: ''
    };
    
    subjectsData.push(subject);
    addSubjectToDOM(subject);
    updateSubjectsJSON();
}

function addSubjectToDOM(subject) {
    const container = document.getElementById('subjects-container');
    const subjectDiv = document.createElement('div');
    subjectDiv.className = 'subject-item';
    subjectDiv.setAttribute('data-subject-id', subject.id || ++subjectCounter);
    
    subjectDiv.innerHTML = `
        <div class="subject-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Mata Pelajaran #${subject.id || subjectCounter}</h6>
            <button type="button" class="btn-remove" onclick="removeSubject(${subject.id || subjectCounter})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="subject-item-body">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label">Nama Mata Pelajaran</label>
                    <input type="text" class="form-input" value="${subject.name || ''}" 
                           onchange="updateSubjectData(${subject.id || subjectCounter}, 'name', this.value)" 
                           placeholder="Contoh: Pemrograman Dasar">
                </div>
                <div class="form-group">
                    <label class="form-label">Kode Mapel</label>
                    <input type="text" class="form-input" value="${subject.code || ''}" 
                           onchange="updateSubjectData(${subject.id || subjectCounter}, 'code', this.value)" 
                           placeholder="Contoh: PD01">
                </div>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label">Jam Pelajaran/Minggu</label>
                    <input type="number" class="form-input" value="${subject.hours || ''}" 
                           onchange="updateSubjectData(${subject.id || subjectCounter}, 'hours', this.value)" 
                           placeholder="4" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Semester</label>
                    <select class="form-input" onchange="updateSubjectData(${subject.id || subjectCounter}, 'semester', this.value)">
                        <option value="">Pilih Semester</option>
                        <option value="1" ${subject.semester == '1' ? 'selected' : ''}>Semester 1</option>
                        <option value="2" ${subject.semester == '2' ? 'selected' : ''}>Semester 2</option>
                        <option value="3" ${subject.semester == '3' ? 'selected' : ''}>Semester 3</option>
                        <option value="4" ${subject.semester == '4' ? 'selected' : ''}>Semester 4</option>
                        <option value="5" ${subject.semester == '5' ? 'selected' : ''}>Semester 5</option>
                        <option value="6" ${subject.semester == '6' ? 'selected' : ''}>Semester 6</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateSubjectData(${subject.id || subjectCounter}, 'description', this.value)" 
                          placeholder="Deskripsi singkat mata pelajaran...">${subject.description || ''}</textarea>
            </div>
        </div>
    `;
    
    container.appendChild(subjectDiv);
}

function removeSubject(subjectId) {
    subjectsData = subjectsData.filter(subject => subject.id !== subjectId);
    const subjectDiv = document.querySelector(`[data-subject-id="${subjectId}"]`);
    if (subjectDiv) {
        subjectDiv.remove();
    }
    updateSubjectsJSON();
}

function updateSubjectData(subjectId, field, value) {
    const subject = subjectsData.find(s => s.id === subjectId);
    if (subject) {
        subject[field] = value;
        updateSubjectsJSON();
    }
}

function updateSubjectsJSON() {
    const jsonTextarea = document.getElementById('core_subjects_json');
    jsonTextarea.value = JSON.stringify(subjectsData, null, 2);
}

// Specializations Management Functions
function addSpecialization() {
    const specialization = {
        id: ++specializationCounter,
        name: '',
        description: '',
        requirements: ''
    };
    
    specializationsData.push(specialization);
    addSpecializationToDOM(specialization);
    updateSpecializationsJSON();
}

function addSpecializationToDOM(specialization) {
    const container = document.getElementById('specializations-container');
    const specializationDiv = document.createElement('div');
    specializationDiv.className = 'specialization-item';
    specializationDiv.setAttribute('data-specialization-id', specialization.id || ++specializationCounter);
    
    specializationDiv.innerHTML = `
        <div class="specialization-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Kompetensi #${specialization.id || specializationCounter}</h6>
            <button type="button" class="btn-remove" onclick="removeSpecialization(${specialization.id || specializationCounter})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="specialization-item-body">
            <div class="form-group">
                <label class="form-label">Nama Kompetensi</label>
                <input type="text" class="form-input" value="${specialization.name || ''}" 
                       onchange="updateSpecializationData(${specialization.id || specializationCounter}, 'name', this.value)" 
                       placeholder="Contoh: Administrasi Sistem Jaringan">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateSpecializationData(${specialization.id || specializationCounter}, 'description', this.value)" 
                          placeholder="Deskripsi singkat kompetensi...">${specialization.description || ''}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Persyaratan</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateSpecializationData(${specialization.id || specializationCounter}, 'requirements', this.value)" 
                          placeholder="Persyaratan atau prasyarat...">${specialization.requirements || ''}</textarea>
            </div>
        </div>
    `;
    
    container.appendChild(specializationDiv);
}

function removeSpecialization(specializationId) {
    specializationsData = specializationsData.filter(specialization => specialization.id !== specializationId);
    const specializationDiv = document.querySelector(`[data-specialization-id="${specializationId}"]`);
    if (specializationDiv) {
        specializationDiv.remove();
    }
    updateSpecializationsJSON();
}

function updateSpecializationData(specializationId, field, value) {
    const specialization = specializationsData.find(s => s.id === specializationId);
    if (specialization) {
        specialization[field] = value;
        updateSpecializationsJSON();
    }
}

function updateSpecializationsJSON() {
    const jsonTextarea = document.getElementById('specializations_json');
    jsonTextarea.value = JSON.stringify(specializationsData, null, 2);
}

// Facilities Management Functions
function addFacility() {
    const facility = {
        id: ++facilityCounter,
        name: '',
        description: '',
        icon: 'fas fa-building',
        color: 'primary'
    };
    
    facilitiesData.push(facility);
    addFacilityToDOM(facility);
    updateFacilitiesJSON();
}

function addFacilityToDOM(facility) {
    const container = document.getElementById('facilities-container');
    const facilityDiv = document.createElement('div');
    facilityDiv.className = 'dynamic-section';
    facilityDiv.setAttribute('data-facility-id', facility.id || ++facilityCounter);
    
    facilityDiv.innerHTML = `
        <div class="dynamic-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Fasilitas #${facility.id || facilityCounter}</h6>
            <button type="button" class="btn-remove" onclick="removeFacility(${facility.id || facilityCounter})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="dynamic-body">
            <div class="form-group">
                <label class="form-label">Nama Fasilitas</label>
                <input type="text" class="form-input" value="${facility.name || ''}" 
                       onchange="updateFacilityData(${facility.id || facilityCounter}, 'name', this.value)" 
                       placeholder="Contoh: Lab Komputer, Bengkel, dll.">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateFacilityData(${facility.id || facilityCounter}, 'description', this.value)" 
                          placeholder="Deskripsi singkat fasilitas...">${facility.description || ''}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Ikon</label>
                    <select class="form-input" onchange="updateFacilityData(${facility.id || facilityCounter}, 'icon', this.value)">
                        <option value="fas fa-building" ${(facility.icon || 'fas fa-building') === 'fas fa-building' ? 'selected' : ''}>Gedung</option>
                        <option value="fas fa-book" ${facility.icon === 'fas fa-book' ? 'selected' : ''}>Perpustakaan</option>
                        <option value="fas fa-microscope" ${facility.icon === 'fas fa-microscope' ? 'selected' : ''}>Laboratorium</option>
                        <option value="fas fa-desktop" ${facility.icon === 'fas fa-desktop' ? 'selected' : ''}>Lab Komputer</option>
                        <option value="fas fa-wifi" ${facility.icon === 'fas fa-wifi' ? 'selected' : ''}>Internet</option>
                        <option value="fas fa-video" ${facility.icon === 'fas fa-video' ? 'selected' : ''}>Multimedia</option>
                        <option value="fas fa-tools" ${facility.icon === 'fas fa-tools' ? 'selected' : ''}>Bengkel</option>
                        <option value="fas fa-chalkboard-teacher" ${facility.icon === 'fas fa-chalkboard-teacher' ? 'selected' : ''}>Ruang Kelas</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Warna</label>
                    <select class="form-input" onchange="updateFacilityData(${facility.id || facilityCounter}, 'color', this.value)">
                        <option value="primary" ${(facility.color || 'primary') === 'primary' ? 'selected' : ''}>Biru</option>
                        <option value="success" ${facility.color === 'success' ? 'selected' : ''}>Hijau</option>
                        <option value="warning" ${facility.color === 'warning' ? 'selected' : ''}>Kuning</option>
                        <option value="danger" ${facility.color === 'danger' ? 'selected' : ''}>Merah</option>
                        <option value="info" ${facility.color === 'info' ? 'selected' : ''}>Cyan</option>
                        <option value="purple" ${facility.color === 'purple' ? 'selected' : ''}>Ungu</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(facilityDiv);
}

function removeFacility(facilityId) {
    facilitiesData = facilitiesData.filter(facility => facility.id !== facilityId);
    const facilityDiv = document.querySelector(`[data-facility-id="${facilityId}"]`);
    if (facilityDiv) {
        facilityDiv.remove();
    }
    updateFacilitiesJSON();
}

function updateFacilityData(facilityId, field, value) {
    const facility = facilitiesData.find(f => f.id === facilityId);
    if (facility) {
        facility[field] = value;
        updateFacilitiesJSON();
    }
}

function updateFacilitiesJSON() {
    const jsonTextarea = document.getElementById('facilities_json');
    jsonTextarea.value = JSON.stringify(facilitiesData, null, 2);
}
</script>
@endsection"