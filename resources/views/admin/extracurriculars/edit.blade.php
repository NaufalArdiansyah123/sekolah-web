@extends('layouts.admin')

@section('title', 'Edit Ekstrakurikuler - ' . $extracurricular->name)

@section('content')
<style>
    .extracurricular-container {
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
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
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

    .header-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: white;
        text-decoration: none;
    }

    .btn-info {
        background: rgba(6, 182, 212, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(6, 182, 212, 0.3);
        backdrop-filter: blur(10px);
    }

    .btn-info:hover {
        background: rgba(6, 182, 212, 0.3);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: white;
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
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        transition: color 0.3s ease;
    }

    .form-body {
        padding: 2rem;
    }

    /* Form Groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group.required .form-label::after {
        content: ' *';
        color: #dc2626;
        font-weight: bold;
    }

    .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        transition: color 0.3s ease;
    }

    .form-control {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--border-color);
        border-radius: 12px;
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: 0.875rem;
        transition: all 0.3s ease;
        resize: vertical;
    }

    .form-control:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        background: var(--bg-primary);
    }

    .form-control::placeholder {
        color: var(--text-tertiary);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        appearance: none;
    }

    .form-text {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    /* File Upload */
    .file-upload-container {
        position: relative;
        border: 2px dashed var(--border-color);
        border-radius: 12px;
        padding: 2rem;
        text-align: center;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .file-upload-container:hover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.05);
    }

    .file-upload-container.dragover {
        border-color: #3b82f6;
        background: rgba(59, 130, 246, 0.1);
        transform: scale(1.02);
    }

    .file-upload-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-upload-content {
        pointer-events: none;
    }

    .file-upload-icon {
        width: 48px;
        height: 48px;
        margin: 0 auto 1rem;
        color: var(--text-tertiary);
        transition: color 0.3s ease;
    }

    .file-upload-container:hover .file-upload-icon {
        color: #3b82f6;
    }

    .file-upload-text {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .file-upload-subtext {
        font-size: 0.875rem;
        color: var(--text-secondary);
        transition: color 0.3s ease;
    }

    /* Current Image */
    .current-image-container {
        margin-bottom: 1rem;
        text-align: center;
    }

    .current-image {
        max-width: 200px;
        max-height: 200px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .current-image:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .current-image-label {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        transition: color 0.3s ease;
    }

    .remove-image-btn {
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 0.5rem;
    }

    .remove-image-btn:hover {
        background: #b91c1c;
        transform: scale(1.05);
    }

    .file-preview {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--bg-primary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
        display: none;
    }

    .file-preview.show {
        display: block;
    }

    .file-preview-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .file-preview-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .file-preview-info {
        flex: 1;
    }

    .file-preview-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .file-preview-size {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .file-preview-remove {
        background: #dc2626;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-preview-remove:hover {
        background: #b91c1c;
        transform: scale(1.05);
    }

    /* Form Actions */
    .form-actions {
        background: var(--bg-tertiary);
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .btn {
        padding: 0.875rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 0.875rem;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-outline {
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-outline:hover {
        background: var(--bg-secondary);
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-2px);
        text-decoration: none;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
        color: white;
        text-decoration: none;
    }

    /* Validation Styles */
    .is-invalid {
        border-color: #dc2626 !important;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
    }

    .invalid-feedback {
        display: block;
        font-size: 0.75rem;
        color: #dc2626;
        margin-top: 0.25rem;
        font-weight: 500;
    }

    .is-valid {
        border-color: #059669 !important;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1) !important;
    }

    .valid-feedback {
        display: block;
        font-size: 0.75rem;
        color: #059669;
        margin-top: 0.25rem;
        font-weight: 500;
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

    .alert-success {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    /* Character Counter */
    .char-counter {
        font-size: 0.75rem;
        color: var(--text-tertiary);
        text-align: right;
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    .char-counter.warning {
        color: #f59e0b;
    }

    .char-counter.danger {
        color: #dc2626;
    }

    /* Form Grid */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    /* Floating Labels */
    .floating-label {
        position: relative;
    }

    .floating-label .form-control {
        padding-top: 1.25rem;
        padding-bottom: 0.5rem;
    }

    .floating-label .form-label {
        position: absolute;
        top: 0.875rem;
        left: 1rem;
        transition: all 0.3s ease;
        pointer-events: none;
        background: var(--bg-primary);
        padding: 0 0.25rem;
        margin: 0;
        text-transform: none;
        letter-spacing: normal;
        font-weight: 400;
    }

    .floating-label .form-control:focus + .form-label,
    .floating-label .form-control:not(:placeholder-shown) + .form-label {
        top: -0.5rem;
        font-size: 0.75rem;
        color: #3b82f6;
        font-weight: 600;
    }

    /* CSS Variables for consistent theming */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --text-tertiary: #9ca3af;
        --border-color: #e5e7eb;
        --shadow-color: rgba(0, 0, 0, 0.05);
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .extracurricular-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .btn {
            justify-content: center;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            flex-direction: column;
            align-items: center;
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

    @keyframes spin {
        from {
            transform: rotate(0deg);
        }
        to {
            transform: rotate(360deg);
        }
    }
</style>

<div class="extracurricular-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit Ekstrakurikuler
            </h1>
            <p class="page-subtitle">{{ $extracurricular->name }}</p>
            <div class="header-actions">
                <a href="{{ route('admin.extracurriculars.index') }}" class="btn-secondary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
                <a href="{{ route('admin.extracurriculars.show', $extracurricular->id) }}" class="btn-info">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Lihat Detail
                </a>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Terdapat kesalahan pada form:</strong>
                <ul style="margin: 0.5rem 0 0 1rem; padding: 0;">
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
            <h2 class="form-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Edit Informasi Ekstrakurikuler
            </h2>
        </div>

        <form action="{{ route('admin.extracurriculars.update', $extracurricular->id) }}" method="POST" enctype="multipart/form-data" id="extracurricularForm">
            @csrf
            @method('PUT')
            
            <div class="form-body">
                <!-- Basic Information -->
                <div class="form-grid">
                    <!-- Name -->
                    <div class="form-group required floating-label">
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $extracurricular->name) }}" 
                               placeholder=" "
                               maxlength="100"
                               required>
                        <label for="name" class="form-label">Nama Ekstrakurikuler</label>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter" id="nameCounter">{{ strlen($extracurricular->name) }}/100</div>
                    </div>

                    <!-- Coach -->
                    <div class="form-group required floating-label">
                        <input type="text" 
                               class="form-control @error('coach') is-invalid @enderror" 
                               id="coach" 
                               name="coach" 
                               value="{{ old('coach', $extracurricular->coach) }}" 
                               placeholder=" "
                               maxlength="100"
                               required>
                        <label for="coach" class="form-label">Pembina/Pelatih</label>
                        @error('coach')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter" id="coachCounter">{{ strlen($extracurricular->coach) }}/100</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group required">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="4" 
                              placeholder="Jelaskan tentang ekstrakurikuler ini, tujuan, kegiatan yang dilakukan, dll."
                              maxlength="500"
                              required>{{ old('description', $extracurricular->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="char-counter" id="descriptionCounter">{{ strlen($extracurricular->description) }}/500</div>
                </div>

                <!-- Schedule and Status -->
                <div class="form-grid">
                    <!-- Schedule -->
                    <div class="form-group floating-label">
                        <input type="text" 
                               class="form-control @error('jadwal') is-invalid @enderror" 
                               id="jadwal" 
                               name="jadwal" 
                               value="{{ old('jadwal', $extracurricular->jadwal) }}" 
                               placeholder=" "
                               maxlength="100">
                        <label for="jadwal" class="form-label">Jadwal Kegiatan</label>
                        <div class="form-text">Contoh: Setiap Senin & Rabu, 15:00-17:00</div>
                        @error('jadwal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="char-counter" id="jadwalCounter">{{ strlen($extracurricular->jadwal ?? '') }}/100</div>
                    </div>

                    <!-- Status -->
                    <div class="form-group required">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control form-select @error('status') is-invalid @enderror" 
                                id="status" 
                                name="status" 
                                required>
                            <option value="">Pilih Status</option>
                            <option value="aktif" {{ old('status', $extracurricular->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak_aktif" {{ old('status', $extracurricular->status) == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="form-group">
                    <label for="gambar" class="form-label">Gambar Ekstrakurikuler</label>
                    
                    <!-- Current Image -->
                    @if($extracurricular->gambar)
                        <div class="current-image-container" id="currentImageContainer">
                            <div class="current-image-label">Gambar Saat Ini:</div>
                            <img src="{{ asset('storage/' . $extracurricular->gambar) }}" 
                                 alt="{{ $extracurricular->name }}" 
                                 class="current-image"
                                 onclick="openImageModal(this.src)">
                            <br>
                            <button type="button" class="remove-image-btn" onclick="removeCurrentImage()">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Gambar
                            </button>
                            <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                        </div>
                    @endif
                    
                    <!-- Upload New Image -->
                    <div class="file-upload-container" id="fileUploadContainer">
                        <input type="file" 
                               class="file-upload-input @error('gambar') is-invalid @enderror" 
                               id="gambar" 
                               name="gambar" 
                               accept="image/*">
                        <div class="file-upload-content">
                            <svg class="file-upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <div class="file-upload-text">
                                {{ $extracurricular->gambar ? 'Klik untuk mengganti gambar' : 'Klik untuk upload atau drag & drop' }}
                            </div>
                            <div class="file-upload-subtext">PNG, JPG, JPEG hingga 2MB</div>
                        </div>
                    </div>
                    <div class="file-preview" id="filePreview">
                        <div class="file-preview-content">
                            <img class="file-preview-image" id="previewImage" src="" alt="Preview">
                            <div class="file-preview-info">
                                <div class="file-preview-name" id="previewName"></div>
                                <div class="file-preview-size" id="previewSize"></div>
                            </div>
                            <button type="button" class="file-preview-remove" id="removeFile">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Upload gambar baru untuk mengganti gambar yang ada (opsional)</div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.extracurriculars.show', $extracurricular->id) }}" class="btn btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                
                <div style="display: flex; gap: 1rem;">
                    <button type="button" class="btn btn-warning" id="resetForm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Reset ke Asli
                    </button>
                    
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Ekstrakurikuler
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="background: var(--bg-primary); border: 1px solid var(--border-color);">
            <div class="modal-header" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" style="color: var(--text-primary);">{{ $extracurricular->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" style="color: var(--text-primary);"></button>
            </div>
            <div class="modal-body text-center" style="background: var(--bg-primary);">
                <img id="modalImage" src="" alt="{{ $extracurricular->name }}" style="max-width: 100%; height: auto; border-radius: 8px;">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counters
    const counters = [
        { input: 'name', counter: 'nameCounter', max: 100 },
        { input: 'coach', counter: 'coachCounter', max: 100 },
        { input: 'description', counter: 'descriptionCounter', max: 500 },
        { input: 'jadwal', counter: 'jadwalCounter', max: 100 }
    ];

    counters.forEach(item => {
        const input = document.getElementById(item.input);
        const counter = document.getElementById(item.counter);
        
        if (input && counter) {
            function updateCounter() {
                const length = input.value.length;
                counter.textContent = `${length}/${item.max}`;
                
                // Update counter color based on usage
                counter.classList.remove('warning', 'danger');
                if (length > item.max * 0.8) {
                    counter.classList.add('warning');
                }
                if (length > item.max * 0.95) {
                    counter.classList.add('danger');
                }
            }
            
            input.addEventListener('input', updateCounter);
            updateCounter(); // Initial count
        }
    });

    // File upload handling
    const fileInput = document.getElementById('gambar');
    const fileUploadContainer = document.getElementById('fileUploadContainer');
    const filePreview = document.getElementById('filePreview');
    const previewImage = document.getElementById('previewImage');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');
    const removeFileBtn = document.getElementById('removeFile');

    // Drag and drop functionality
    fileUploadContainer.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileUploadContainer.classList.add('dragover');
    });

    fileUploadContainer.addEventListener('dragleave', function(e) {
        e.preventDefault();
        fileUploadContainer.classList.remove('dragover');
    });

    fileUploadContainer.addEventListener('drop', function(e) {
        e.preventDefault();
        fileUploadContainer.classList.remove('dragover');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            handleFileSelect(files[0]);
        }
    });

    // File input change
    fileInput.addEventListener('change', function(e) {
        if (e.target.files.length > 0) {
            handleFileSelect(e.target.files[0]);
        }
    });

    // Remove file
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        filePreview.classList.remove('show');
        fileUploadContainer.style.display = 'block';
    });

    function handleFileSelect(file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file (PNG, JPG, JPEG)');
            return;
        }

        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('File size must be less than 2MB');
            return;
        }

        // Show preview
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = formatFileSize(file.size);
            
            filePreview.classList.add('show');
            fileUploadContainer.style.display = 'none';
        };
        reader.readAsDataURL(file);

        // Set the file to input (for drag & drop)
        const dt = new DataTransfer();
        dt.items.add(file);
        fileInput.files = dt.files;
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Form validation
    const form = document.getElementById('extracurricularForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Add loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Menyimpan...
        `;
    });

    // Reset form to original values
    const resetBtn = document.getElementById('resetForm');
    const originalValues = {
        name: '{{ $extracurricular->name }}',
        coach: '{{ $extracurricular->coach }}',
        description: '{{ $extracurricular->description }}',
        jadwal: '{{ $extracurricular->jadwal ?? '' }}',
        status: '{{ $extracurricular->status }}'
    };

    resetBtn.addEventListener('click', function() {
        if (confirm('Apakah Anda yakin ingin mereset form ke nilai asli? Semua perubahan akan hilang.')) {
            // Reset form fields to original values
            document.getElementById('name').value = originalValues.name;
            document.getElementById('coach').value = originalValues.coach;
            document.getElementById('description').value = originalValues.description;
            document.getElementById('jadwal').value = originalValues.jadwal;
            document.getElementById('status').value = originalValues.status;
            
            // Reset file input
            fileInput.value = '';
            filePreview.classList.remove('show');
            fileUploadContainer.style.display = 'block';
            
            // Reset remove image flag
            const removeImageInput = document.getElementById('removeImageInput');
            if (removeImageInput) {
                removeImageInput.value = '0';
            }
            
            // Show current image if exists
            const currentImageContainer = document.getElementById('currentImageContainer');
            if (currentImageContainer) {
                currentImageContainer.style.display = 'block';
            }
            
            // Reset character counters
            counters.forEach(item => {
                const counter = document.getElementById(item.counter);
                const input = document.getElementById(item.input);
                if (counter && input) {
                    const length = input.value.length;
                    counter.textContent = `${length}/${item.max}`;
                    counter.classList.remove('warning', 'danger');
                    if (length > item.max * 0.8) {
                        counter.classList.add('warning');
                    }
                    if (length > item.max * 0.95) {
                        counter.classList.add('danger');
                    }
                }
            });
            
            // Remove validation classes
            document.querySelectorAll('.is-invalid, .is-valid').forEach(el => {
                el.classList.remove('is-invalid', 'is-valid');
            });
        }
    });

    // Real-time validation
    const requiredFields = ['name', 'coach', 'description', 'status'];
    
    requiredFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.addEventListener('blur', function() {
                validateField(field);
            });
            
            field.addEventListener('input', function() {
                if (field.classList.contains('is-invalid')) {
                    validateField(field);
                }
            });
        }
    });

    function validateField(field) {
        const value = field.value.trim();
        const isValid = value.length > 0;
        
        field.classList.remove('is-invalid', 'is-valid');
        
        if (field.hasAttribute('required')) {
            if (isValid) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid');
            }
        }
        
        return isValid;
    }

    // Auto-hide alerts
    document.querySelectorAll('.alert').forEach(function(alert) {
        setTimeout(function() {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                alert.style.display = 'none';
            }, 300);
        }, 5000);
    });

    // Add CSS for animations
    if (!document.querySelector('#edit-animations')) {
        const style = document.createElement('style');
        style.id = 'edit-animations';
        style.textContent = `
            .animate-spin {
                animation: spin 1s linear infinite;
            }
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }

    console.log('✅ Extracurricular edit form initialized');
});

// Remove current image function
function removeCurrentImage() {
    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
        const currentImageContainer = document.getElementById('currentImageContainer');
        const removeImageInput = document.getElementById('removeImageInput');
        
        if (currentImageContainer) {
            currentImageContainer.style.display = 'none';
        }
        
        if (removeImageInput) {
            removeImageInput.value = '1';
        }
    }
}

// Image modal function
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    if (modal && modalImage) {
        modalImage.src = imageSrc;
        
        // Use Bootstrap modal if available
        if (typeof bootstrap !== 'undefined') {
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        } else if (typeof $ !== 'undefined' && typeof $.fn.modal !== 'undefined') {
            $('#imageModal').modal('show');
        } else {
            // Fallback
            modal.style.display = 'block';
            modal.classList.add('show');
        }
    }
}
</script>

@endsection