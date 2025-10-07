@extends('layouts.admin')

@section('title', 'Tambah Prestasi')
@section('page-title', 'Tambah Prestasi')

@section('content')
<style>
    /* Enhanced Dark Mode Compatible Form Styles */
    :root {
        /* Light Mode Colors */
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-muted: #94a3b8;
        --border-color: #e2e8f0;
        --border-hover: #cbd5e1;
        --border-focus: #3b82f6;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --shadow-hover: rgba(0, 0, 0, 0.15);
        --accent-color: #3b82f6;
        --accent-hover: #2563eb;
        --success-color: #10b981;
        --success-hover: #059669;
        --warning-color: #f59e0b;
        --warning-hover: #d97706;
        --danger-color: #ef4444;
        --danger-hover: #dc2626;
        --info-color: #06b6d4;
        --info-hover: #0891b2;
    }

    /* Dark Mode Colors */
    .dark {
        --bg-primary: #1e293b;
        --bg-secondary: #0f172a;
        --bg-tertiary: #334155;
        --text-primary: #f1f5f9;
        --text-secondary: #cbd5e1;
        --text-muted: #94a3b8;
        --border-color: #334155;
        --border-hover: #475569;
        --border-focus: #60a5fa;
        --shadow-color: rgba(0, 0, 0, 0.3);
        --shadow-hover: rgba(0, 0, 0, 0.4);
        --accent-color: #3b82f6;
        --accent-hover: #60a5fa;
        --success-color: #10b981;
        --success-hover: #34d399;
        --warning-color: #f59e0b;
        --warning-hover: #fbbf24;
        --danger-color: #ef4444;
        --danger-hover: #f87171;
        --info-color: #06b6d4;
        --info-hover: #22d3ee;
    }

    /* Base Layout */
    .create-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: background-color 0.3s ease;
    }

    /* Enhanced Form Container */
    .form-container {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 6px -1px var(--shadow-color);
        margin-bottom: 2rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), var(--info-color));
    }

    .form-container:hover {
        box-shadow: 0 10px 15px -3px var(--shadow-hover);
        transform: translateY(-1px);
    }

    /* Enhanced Form Header */
    .form-header {
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 1.5rem;
        margin-bottom: 2.5rem;
        position: relative;
    }

    .form-title {
        font-size: 2rem;
        font-weight: 800;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, var(--accent-color), var(--info-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .form-subtitle {
        color: var(--text-secondary);
        margin: 0;
        margin-top: 0.75rem;
        font-size: 1rem;
        font-weight: 500;
    }

    /* Enhanced Form Groups */
    .form-group {
        margin-bottom: 2rem;
        position: relative;
    }

    .form-label {
        display: block;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: relative;
    }

    .form-label.required::after {
        content: '*';
        color: var(--danger-color);
        margin-left: 0.25rem;
        font-weight: 900;
    }

    /* Enhanced Form Controls */
    .form-control {
        width: 100%;
        padding: 1rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        font-size: 0.875rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: inherit;
    }

    .form-control:hover {
        border-color: var(--border-hover);
        transform: translateY(-1px);
    }

    .form-control:focus {
        outline: none;
        border-color: var(--border-focus);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        transform: translateY(-2px);
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    /* Enhanced Select Styling */
    select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.75rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 3rem;
        appearance: none;
    }

    .dark select.form-control {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%9ca3af' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
    }

    /* Enhanced Textarea */
    textarea.form-control {
        resize: vertical;
        min-height: 120px;
        line-height: 1.6;
    }

    /* Enhanced File Input */
    input[type="file"].form-control {
        padding: 0.75rem;
        background: var(--bg-secondary);
        border-style: dashed;
        cursor: pointer;
        position: relative;
    }

    input[type="file"].form-control:hover {
        background: var(--bg-tertiary);
        border-color: var(--accent-color);
    }

    /* Enhanced Checkboxes */
    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .form-check:hover {
        background: var(--bg-tertiary);
        transform: translateY(-1px);
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        border: 2px solid var(--border-color);
        border-radius: 6px;
        background: var(--bg-primary);
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .form-check-input:checked {
        background: var(--accent-color);
        border-color: var(--accent-color);
    }

    .form-check-input:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-weight: 900;
        font-size: 0.875rem;
    }

    .form-check-label {
        font-weight: 600;
        color: var(--text-primary);
        cursor: pointer;
        user-select: none;
    }

    /* Enhanced Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }

    .btn:hover::before {
        left: 100%;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--accent-hover), var(--accent-color));
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(59, 130, 246, 0.4);
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-hover);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
        border-color: var(--border-hover);
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success-color), var(--success-hover));
        color: white;
        box-shadow: 0 4px 14px 0 rgba(16, 185, 129, 0.3);
    }

    .btn-success:hover {
        background: linear-gradient(135deg, var(--success-hover), var(--success-color));
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px 0 rgba(16, 185, 129, 0.4);
    }

    /* Enhanced Image Preview */
    .image-preview-container {
        margin-top: 1rem;
        text-align: center;
    }

    .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 12px;
        box-shadow: 0 8px 25px var(--shadow-color);
        display: none;
        transition: all 0.3s ease;
    }

    .image-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 12px 35px var(--shadow-hover);
    }

    /* Enhanced Form Actions */
    .form-actions {
        border-top: 2px solid var(--border-color);
        padding-top: 2rem;
        margin-top: 3rem;
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        align-items: center;
    }

    /* Enhanced Help Text */
    .form-help {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Enhanced Error States */
    .form-control.is-invalid {
        border-color: var(--danger-color);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .invalid-feedback::before {
        content: '⚠';
        font-size: 0.875rem;
    }

    /* Enhanced Success States */
    .form-control.is-valid {
        border-color: var(--success-color);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }

    .valid-feedback {
        color: var(--success-color);
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .valid-feedback::before {
        content: '✓';
        font-size: 0.875rem;
    }

    /* Enhanced Section Headers */
    .section-header {
        margin: 3rem 0 2rem 0;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-icon {
        width: 1.5rem;
        height: 1.5rem;
        color: var(--accent-color);
    }

    /* Enhanced Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
        align-items: start;
    }

    .form-main {
        min-width: 0; /* Prevent grid overflow */
    }

    .form-sidebar {
        position: sticky;
        top: 2rem;
    }

    /* Enhanced Card Styling for Sidebar */
    .sidebar-card {
        background: var(--bg-secondary);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
        transition: all 0.3s ease;
    }

    .sidebar-card:hover {
        box-shadow: 0 8px 25px var(--shadow-color);
        transform: translateY(-2px);
    }

    .sidebar-card-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0 0 1.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
        position: relative;
    }

    .loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid var(--accent-color);
        border-radius: 50%;
        border-top-color: transparent;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .form-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .form-sidebar {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .create-page {
            padding: 1rem;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column-reverse;
            align-items: stretch;
        }

        .btn {
            justify-content: center;
        }
    }

    /* Dark mode specific adjustments */
    .dark .form-control {
        background: var(--bg-secondary);
    }

    .dark input[type="file"].form-control {
        background: var(--bg-tertiary);
    }

    .dark .sidebar-card {
        background: var(--bg-tertiary);
    }

    /* Accessibility improvements */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* Focus states for accessibility */
    .btn:focus,
    .form-control:focus,
    .form-check-input:focus {
        outline: 2px solid var(--accent-color);
        outline-offset: 2px;
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .form-control,
        .btn {
            border-width: 2px;
        }
    }
</style>

<div class="create-page">
    <div class="form-container">
        <div class="form-header">
            <h1 class="form-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Tambah Prestasi Baru
            </h1>
            <p class="form-subtitle">Tambahkan prestasi baru untuk menampilkan pencapaian sekolah</p>
        </div>
        
        <form action="{{ route('admin.achievements.store') }}" method="POST" enctype="multipart/form-data" id="achievementForm">
            @csrf
            
            <div class="form-grid">
                <div class="form-main">
                    <!-- Basic Information Section -->
                    <div class="section-header">
                        <h3 class="section-title">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi Dasar
                        </h3>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="title">Judul Prestasi</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" 
                               placeholder="Masukkan judul prestasi..." required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Judul yang jelas dan deskriptif untuk prestasi
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label required" for="description">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" 
                                  placeholder="Jelaskan detail prestasi yang diraih..." required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Deskripsi lengkap tentang prestasi yang diraih
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required" for="category">Kategori</label>
                                <select class="form-control @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key => $value)
                                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required" for="level">Tingkat</label>
                                <select class="form-control @error('level') is-invalid @enderror" 
                                        id="level" name="level" required>
                                    <option value="">Pilih Tingkat</option>
                                    @foreach($levels as $key => $value)
                                        <option value="{{ $key }}" {{ old('level') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="year">Tahun</label>
                                <input type="number" class="form-control @error('year') is-invalid @enderror" 
                                       id="year" name="year" value="{{ old('year', date('Y')) }}" 
                                       min="1900" max="{{ date('Y') + 1 }}" placeholder="2024">
                                @error('year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="achievement_date">Tanggal Prestasi</label>
                                <input type="date" class="form-control @error('achievement_date') is-invalid @enderror" 
                                       id="achievement_date" name="achievement_date" value="{{ old('achievement_date') }}">
                                @error('achievement_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- Additional Information Section -->
                    <div class="section-header">
                        <h3 class="section-title">
                            <svg class="section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Informasi Tambahan
                        </h3>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="organizer">Penyelenggara</label>
                                <input type="text" class="form-control @error('organizer') is-invalid @enderror" 
                                       id="organizer" name="organizer" value="{{ old('organizer') }}"
                                       placeholder="Nama penyelenggara lomba/kompetisi">
                                @error('organizer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="participant">Peserta</label>
                                <input type="text" class="form-control @error('participant') is-invalid @enderror" 
                                       id="participant" name="participant" value="{{ old('participant') }}"
                                       placeholder="Nama peserta/tim">
                                @error('participant')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="position">Posisi/Peringkat</label>
                        <select class="form-control @error('position') is-invalid @enderror" 
                                id="position" name="position">
                            <option value="">Pilih Posisi</option>
                            @foreach($positions as $key => $value)
                                <option value="{{ $key }}" {{ old('position') == $key ? 'selected' : '' }}>
                                    {{ $value }}
                                </option>
                            @endforeach
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="additional_info">Informasi Tambahan</label>
                        <textarea class="form-control @error('additional_info') is-invalid @enderror" 
                                  id="additional_info" name="additional_info" rows="4"
                                  placeholder="Informasi tambahan tentang prestasi...">{{ old('additional_info') }}</textarea>
                        @error('additional_info')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-help">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Informasi tambahan yang relevan dengan prestasi
                        </div>
                    </div>
                </div>
                
                <div class="form-sidebar">
                    <!-- Image Upload Card -->
                    <div class="sidebar-card">
                        <h4 class="sidebar-card-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Gambar Prestasi
                        </h4>
                        
                        <div class="form-group">
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <div class="form-help">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Maksimal 5MB. Format: JPG, PNG, GIF, WebP
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="image-preview-container">
                            <img id="imagePreview" class="image-preview" alt="Preview">
                        </div>
                    </div>
                    
                    <!-- Settings Card -->
                    <div class="sidebar-card">
                        <h4 class="sidebar-card-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Pengaturan
                        </h4>
                        
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_featured" 
                                   name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">Prestasi Unggulan</label>
                        </div>
                        
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" 
                                   name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Status Aktif</label>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="sort_order">Urutan Tampil</label>
                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                   min="0" placeholder="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                Angka lebih kecil akan tampil lebih dulu
                            </div>
                        </div>
                    </div>
                    
                    <!-- SEO Card -->
                    <div class="sidebar-card">
                        <h4 class="sidebar-card-title">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            SEO & Meta
                        </h4>
                        
                        <div class="form-group">
                            <label class="form-label" for="meta_title">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                   id="meta_title" name="meta_title" value="{{ old('meta_title') }}"
                                   placeholder="Judul untuk SEO">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3"
                                      placeholder="Deskripsi untuk SEO">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Maksimal 160 karakter untuk hasil pencarian
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="form-actions">
                <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Prestasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Enhanced JavaScript with better functionality
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const container = preview.parentElement;
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 5MB.');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        // Validate file type
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.');
            input.value = '';
            preview.style.display = 'none';
            return;
        }
        
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            
            // Add success feedback
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        };
        
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        input.classList.remove('is-valid');
    }
}

// Enhanced form functionality
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('achievementForm');
    const submitBtn = document.getElementById('submitBtn');
    
    // Auto-fill year from achievement date
    document.getElementById('achievement_date').addEventListener('change', function() {
        const date = new Date(this.value);
        const year = date.getFullYear();
        const yearInput = document.getElementById('year');
        
        if (!yearInput.value && year && year >= 1900) {
            yearInput.value = year;
            showNotification('Tahun otomatis diisi dari tanggal prestasi', 'info');
        }
    });
    
    // Auto-generate meta title from title
    document.getElementById('title').addEventListener('input', function() {
        const metaTitleInput = document.getElementById('meta_title');
        if (!metaTitleInput.value) {
            metaTitleInput.value = this.value;
        }
    });
    
    // Auto-generate meta description from description
    document.getElementById('description').addEventListener('input', function() {
        const metaDescInput = document.getElementById('meta_description');
        if (!metaDescInput.value) {
            const truncated = this.value.substring(0, 160);
            metaDescInput.value = truncated;
        }
    });
    
    // Form validation
    form.addEventListener('submit', function(e) {
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            showNotification('Mohon lengkapi semua field yang wajib diisi', 'error');
            return;
        }
        
        // Show loading state
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
        submitBtn.disabled = true;
    });
    
    // Real-time validation
    const inputs = form.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S to save
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            form.submit();
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            const cancelBtn = document.querySelector('.btn-secondary');
            if (cancelBtn && confirm('Batalkan pembuatan prestasi? Data yang belum disimpan akan hilang.')) {
                window.location.href = cancelBtn.href;
            }
        }
    });
    
    // Auto-save draft (optional)
    let autoSaveTimer;
    const autoSaveInputs = form.querySelectorAll('input, textarea, select');
    
    autoSaveInputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                saveDraft();
            }, 5000); // Auto-save after 5 seconds of inactivity
        });
    });
    
    function saveDraft() {
        const formData = new FormData(form);
        const draftData = {};
        
        for (let [key, value] of formData.entries()) {
            if (key !== '_token' && value) {
                draftData[key] = value;
            }
        }
        
        localStorage.setItem('achievement_draft', JSON.stringify(draftData));
        showNotification('Draft otomatis disimpan', 'info', 2000);
    }
    
    // Load draft on page load
    function loadDraft() {
        const draft = localStorage.getItem('achievement_draft');
        if (draft) {
            try {
                const draftData = JSON.parse(draft);
                
                if (confirm('Ditemukan draft yang belum disimpan. Muat draft tersebut?')) {
                    Object.keys(draftData).forEach(key => {
                        const input = form.querySelector(`[name="${key}"]`);
                        if (input) {
                            if (input.type === 'checkbox') {
                                input.checked = draftData[key] === '1';
                            } else {
                                input.value = draftData[key];
                            }
                        }
                    });
                    showNotification('Draft berhasil dimuat', 'success');
                } else {
                    localStorage.removeItem('achievement_draft');
                }
            } catch (e) {
                localStorage.removeItem('achievement_draft');
            }
        }
    }
    
    // Load draft if exists
    loadDraft();
    
    // Clear draft on successful submit
    form.addEventListener('submit', function() {
        localStorage.removeItem('achievement_draft');
    });
});

function showNotification(message, type = 'info', duration = 3000) {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        border-radius: 12px;
        color: white;
        font-weight: 600;
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
        max-width: 300px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        ${type === 'success' ? 'background: linear-gradient(135deg, #10b981, #059669);' : 
          type === 'error' ? 'background: linear-gradient(135deg, #ef4444, #dc2626);' : 
          'background: linear-gradient(135deg, #3b82f6, #2563eb);'}
    `;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Trigger animation
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Remove notification
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, duration);
}

// Dark mode detection and handling
if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    document.documentElement.classList.add('dark');
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
    if (e.matches) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
});
</script>
@endsection