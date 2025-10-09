@extends('layouts.admin')

@section('title', 'Edit Sejarah Sekolah - ' . $history->title)

@push('styles')
<style>
    /* Menggunakan CSS yang sama dengan create.blade.php */
    :root {
        --bg-primary: #ffffff;
        --bg-secondary: #f8fafc;
        --bg-tertiary: #f1f5f9;
        --text-primary: #1e293b;
        --text-secondary: #64748b;
        --text-tertiary: #94a3b8;
        --border-color: #e2e8f0;
        --shadow-color: rgba(0, 0, 0, 0.1);
        --accent-color: #8b5cf6;
        --accent-hover: #7c3aed;
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

    .edit-history-page {
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
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(139, 92, 246, 0.2);
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
        color: var(--accent-color);
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
        color: var(--accent-color);
        text-decoration: none;
    }

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
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
        outline: none;
    }

    .form-input.is-invalid {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .invalid-feedback {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .form-help {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
        transition: color 0.3s ease;
    }

    .dynamic-section {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dynamic-section:hover {
        border-color: var(--accent-color);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
    }

    .dynamic-header {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
        color: white;
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

    .dynamic-item {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
    }

    .dynamic-item:hover {
        border-color: var(--accent-color);
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);
    }

    .dynamic-item-header {
        background: var(--bg-tertiary);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dynamic-item-body {
        padding: 1rem;
        background: var(--bg-primary);
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 500;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: all 0.15s ease;
    }

    .btn-add {
        background: linear-gradient(135deg, var(--success-color), #059669);
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

    .btn-primary {
        background: linear-gradient(135deg, var(--accent-color), var(--accent-hover));
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
        box-shadow: 0 6px 20px rgba(139, 92, 246, 0.3);
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

    .form-actions {
        background: var(--bg-tertiary);
        padding: 1.5rem 2rem;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }

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

    .current-image {
        width: 100%;
        max-width: 200px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        border: 1px solid var(--border-color);
    }

    @media (max-width: 768px) {
        .edit-history-page {
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

    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="edit-history-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit Sejarah Sekolah
            </h1>
            <p class="page-subtitle">Perbarui dokumentasi sejarah, timeline, dan pencapaian sekolah</p>
            <a href="{{ route('admin.history.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Silakan perbaiki kesalahan berikut:</strong>
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Detail Sejarah Sekolah
            </h2>
        </div>

        <form action="{{ route('admin.history.update', $history) }}" method="POST" id="historyForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-body">
                <div class="form-row">
                    <!-- Left Column - Main Content -->
                    <div class="form-section">
                        <div class="form-group">
                            <label for="title" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Judul Halaman
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-input @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $history->title) }}" 
                                   required
                                   placeholder="Masukkan judul halaman...">
                            @error('title')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Konten Sejarah
                                <span class="required">*</span>
                            </label>
                            <textarea name="content" 
                                      id="content" 
                                      class="form-input form-textarea @error('content') is-invalid @enderror" 
                                      required
                                      rows="8"
                                      placeholder="Masukkan konten sejarah sekolah...">{{ old('content', $history->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Timeline Events Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Timeline Peristiwa
                                </h6>
                                <button type="button" class="btn-add" onclick="addTimelineEvent()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Peristiwa
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="timeline-container">
                                    <!-- Timeline events will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="timeline_events_json" class="form-label">Data Timeline (JSON)</label>
                                    <textarea class="form-input @error('timeline_events_json') is-invalid @enderror" 
                                              id="timeline_events_json" name="timeline_events_json" rows="4" readonly
                                              placeholder='Data timeline akan muncul di sini secara otomatis'>{{ old('timeline_events_json', json_encode($history->timeline_events ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">Field ini akan diisi otomatis berdasarkan timeline yang Anda tambahkan di atas.</div>
                                    @error('timeline_events_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Milestones Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    Tonggak Sejarah
                                </h6>
                                <button type="button" class="btn-add" onclick="addMilestone()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Tonggak
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="milestones-container">
                                    <!-- Milestones will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="milestones_json" class="form-label">Data Tonggak (JSON)</label>
                                    <textarea class="form-input @error('milestones_json') is-invalid @enderror" 
                                              id="milestones_json" name="milestones_json" rows="4" readonly
                                              placeholder='Data tonggak akan muncul di sini secara otomatis'>{{ old('milestones_json', json_encode($history->milestones ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">Field ini akan diisi otomatis berdasarkan tonggak yang Anda tambahkan di atas.</div>
                                    @error('milestones_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Achievements Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    Prestasi Bersejarah
                                </h6>
                                <button type="button" class="btn-add" onclick="addAchievement()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Tambah Prestasi
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="achievements-container">
                                    <!-- Achievements will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="achievements_json" class="form-label">Data Prestasi (JSON)</label>
                                    <textarea class="form-input @error('achievements_json') is-invalid @enderror" 
                                              id="achievements_json" name="achievements_json" rows="4" readonly
                                              placeholder='Data prestasi akan muncul di sini secara otomatis'>{{ old('achievements_json', json_encode($history->achievements ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">Field ini akan diisi otomatis berdasarkan prestasi yang Anda tambahkan di atas.</div>
                                    @error('achievements_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div class="form-section">
                        <!-- Settings -->
                        <div class="form-group">
                            <label class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Pengaturan
                            </label>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $history->is_active) ? 'checked' : '' }}>
                                <label for="is_active" style="margin: 0; font-weight: normal;">
                                    Aktifkan sejarah ini
                                </label>
                            </div>
                            <div class="form-help">Sejarah yang aktif akan ditampilkan di halaman publik</div>
                        </div>

                        <!-- Hero Section -->
                        <div class="form-group">
                            <label for="hero_title" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Judul Hero
                            </label>
                            <input type="text" 
                                   name="hero_title" 
                                   id="hero_title" 
                                   class="form-input @error('hero_title') is-invalid @enderror" 
                                   value="{{ old('hero_title', $history->hero_title) }}" 
                                   placeholder="Judul untuk bagian hero...">
                            @error('hero_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hero_subtitle" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Subjudul Hero
                            </label>
                            <textarea name="hero_subtitle" 
                                      id="hero_subtitle" 
                                      class="form-input @error('hero_subtitle') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Deskripsi untuk bagian hero...">{{ old('hero_subtitle', $history->hero_subtitle) }}</textarea>
                            @error('hero_subtitle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hero_image" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Gambar Hero
                            </label>
                            @if($history->hero_image)
                                <img src="{{ asset($history->hero_image) }}" alt="Current Hero Image" class="current-image">
                                <div class="form-help">Gambar saat ini (akan diganti jika Anda upload gambar baru)</div>
                            @endif
                            <input type="file" class="form-input @error('hero_image') is-invalid @enderror" 
                                   id="hero_image" name="hero_image" accept="image/*">
                            <div class="form-help">JPG, PNG, GIF. Maksimal 10MB. Kosongkan untuk mempertahankan gambar saat ini.</div>
                            @error('hero_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- SEO -->
                        <div class="form-group">
                            <label for="meta_title" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Meta Title (SEO)
                            </label>
                            <input type="text" 
                                   name="meta_title" 
                                   id="meta_title" 
                                   class="form-input @error('meta_title') is-invalid @enderror" 
                                   value="{{ old('meta_title', $history->meta_title) }}" 
                                   placeholder="Judul untuk SEO...">
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Meta Description (SEO)
                            </label>
                            <textarea name="meta_description" 
                                      id="meta_description" 
                                      class="form-input @error('meta_description') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Deskripsi untuk SEO...">{{ old('meta_description', $history->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.history.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Perbarui Sejarah Sekolah
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Global variables for management
let timelineData = [];
let timelineCounter = 0;
let milestonesData = [];
let milestonesCounter = 0;
let achievementsData = [];
let achievementsCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize data from existing history
    initializeExistingData();

    // Form submission
    const form = document.getElementById('historyForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Update JSON fields before submission
        updateTimelineJSON();
        updateMilestonesJSON();
        updateAchievementsJSON();
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="spinner"></div>
            Memperbarui...
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
                Perbarui Sejarah Sekolah
            `;
            form.classList.remove('loading');
            
            // Show error message
            alert('Silakan isi semua field yang wajib diisi.');
        }
    });
});

function initializeExistingData() {
    // Initialize timeline from existing data
    const existingTimeline = @json($history->timeline_events ?? []);
    if (existingTimeline && existingTimeline.length > 0) {
        timelineData = existingTimeline.map((event, index) => ({
            id: index + 1,
            year: event.year || '',
            title: event.title || '',
            description: event.description || '',
            type: event.type || 'milestone',
            icon: event.icon || 'fas fa-calendar-alt',
            color: event.color || 'primary'
        }));
        timelineCounter = timelineData.length;
        timelineData.forEach(event => {
            addTimelineEventToDOM(event);
        });
    }

    // Initialize milestones from existing data
    const existingMilestones = @json($history->milestones ?? []);
    if (existingMilestones && existingMilestones.length > 0) {
        milestonesData = existingMilestones.map((milestone, index) => ({
            id: index + 1,
            year: milestone.year || '',
            title: milestone.title || '',
            description: milestone.description || '',
            image: milestone.image || '',
            icon: milestone.icon || 'fas fa-star',
            color: milestone.color || 'primary'
        }));
        milestonesCounter = milestonesData.length;
        milestonesData.forEach(milestone => {
            addMilestoneToDOM(milestone);
        });
    }

    // Initialize achievements from existing data
    const existingAchievements = @json($history->achievements ?? []);
    if (existingAchievements && existingAchievements.length > 0) {
        achievementsData = existingAchievements.map((achievement, index) => ({
            id: index + 1,
            year: achievement.year || '',
            title: achievement.title || '',
            description: achievement.description || '',
            level: achievement.level || 'Sekolah',
            category: achievement.category || 'Umum',
            icon: achievement.icon || 'fas fa-award',
            color: achievement.color || 'primary'
        }));
        achievementsCounter = achievementsData.length;
        achievementsData.forEach(achievement => {
            addAchievementToDOM(achievement);
        });
    }

    // Update JSON fields
    updateTimelineJSON();
    updateMilestonesJSON();
    updateAchievementsJSON();
}

// Menggunakan fungsi yang sama dengan create.blade.php
// Timeline Management Functions
function addTimelineEvent() {
    const event = {
        id: ++timelineCounter,
        year: '',
        title: '',
        description: '',
        type: 'milestone',
        icon: 'fas fa-calendar-alt',
        color: 'primary'
    };
    
    timelineData.push(event);
    addTimelineEventToDOM(event);
    updateTimelineJSON();
}

function addTimelineEventToDOM(event) {
    const container = document.getElementById('timeline-container');
    const eventDiv = document.createElement('div');
    eventDiv.className = 'dynamic-item';
    eventDiv.setAttribute('data-timeline-id', event.id);
    
    eventDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Peristiwa #${event.id}</h6>
            <button type="button" class="btn-remove" onclick="removeTimelineEvent(${event.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="dynamic-item-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="text" class="form-input" value="${event.year || ''}" 
                           onchange="updateTimelineData(${event.id}, 'year', this.value)" 
                           placeholder="Contoh: 1985">
                </div>
                <div class="form-group">
                    <label class="form-label">Jenis</label>
                    <select class="form-input" onchange="updateTimelineData(${event.id}, 'type', this.value)">
                        <option value="founding" ${(event.type || 'milestone') === 'founding' ? 'selected' : ''}>Pendirian</option>
                        <option value="milestone" ${(event.type || 'milestone') === 'milestone' ? 'selected' : ''}>Tonggak</option>
                        <option value="achievement" ${event.type === 'achievement' ? 'selected' : ''}>Prestasi</option>
                        <option value="expansion" ${event.type === 'expansion' ? 'selected' : ''}>Ekspansi</option>
                        <option value="renovation" ${event.type === 'renovation' ? 'selected' : ''}>Renovasi</option>
                        <option value="accreditation" ${event.type === 'accreditation' ? 'selected' : ''}>Akreditasi</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Judul Peristiwa</label>
                <input type="text" class="form-input" value="${event.title || ''}" 
                       onchange="updateTimelineData(${event.id}, 'title', this.value)" 
                       placeholder="Contoh: Pendirian Sekolah">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateTimelineData(${event.id}, 'description', this.value)" 
                          placeholder="Deskripsi detail peristiwa...">${event.description || ''}</textarea>
            </div>
        </div>
    `;
    
    container.appendChild(eventDiv);
}

function removeTimelineEvent(eventId) {
    timelineData = timelineData.filter(event => event.id !== eventId);
    const eventDiv = document.querySelector(`[data-timeline-id="${eventId}"]`);
    if (eventDiv) {
        eventDiv.remove();
    }
    updateTimelineJSON();
}

function updateTimelineData(eventId, field, value) {
    const event = timelineData.find(e => e.id === eventId);
    if (event) {
        event[field] = value;
        updateTimelineJSON();
    }
}

function updateTimelineJSON() {
    const jsonTextarea = document.getElementById('timeline_events_json');
    jsonTextarea.value = JSON.stringify(timelineData, null, 2);
}

// Milestones Management Functions
function addMilestone() {
    const milestone = {
        id: ++milestonesCounter,
        year: '',
        title: '',
        description: '',
        image: '',
        icon: 'fas fa-star',
        color: 'primary'
    };
    
    milestonesData.push(milestone);
    addMilestoneToDOM(milestone);
    updateMilestonesJSON();
}

function addMilestoneToDOM(milestone) {
    const container = document.getElementById('milestones-container');
    const milestoneDiv = document.createElement('div');
    milestoneDiv.className = 'dynamic-item';
    milestoneDiv.setAttribute('data-milestone-id', milestone.id);
    
    milestoneDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Tonggak #${milestone.id}</h6>
            <button type="button" class="btn-remove" onclick="removeMilestone(${milestone.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="dynamic-item-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="text" class="form-input" value="${milestone.year || ''}" 
                           onchange="updateMilestoneData(${milestone.id}, 'year', this.value)" 
                           placeholder="Contoh: 1990">
                </div>
                <div class="form-group">
                    <label class="form-label">Warna</label>
                    <select class="form-input" onchange="updateMilestoneData(${milestone.id}, 'color', this.value)">
                        <option value="primary" ${(milestone.color || 'primary') === 'primary' ? 'selected' : ''}>Biru</option>
                        <option value="success" ${milestone.color === 'success' ? 'selected' : ''}>Hijau</option>
                        <option value="warning" ${milestone.color === 'warning' ? 'selected' : ''}>Kuning</option>
                        <option value="danger" ${milestone.color === 'danger' ? 'selected' : ''}>Merah</option>
                        <option value="info" ${milestone.color === 'info' ? 'selected' : ''}>Cyan</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Judul Tonggak</label>
                <input type="text" class="form-input" value="${milestone.title || ''}" 
                       onchange="updateMilestoneData(${milestone.id}, 'title', this.value)" 
                       placeholder="Contoh: Akreditasi A">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateMilestoneData(${milestone.id}, 'description', this.value)" 
                          placeholder="Deskripsi detail tonggak...">${milestone.description || ''}</textarea>
            </div>
        </div>
    `;
    
    container.appendChild(milestoneDiv);
}

function removeMilestone(milestoneId) {
    milestonesData = milestonesData.filter(milestone => milestone.id !== milestoneId);
    const milestoneDiv = document.querySelector(`[data-milestone-id="${milestoneId}"]`);
    if (milestoneDiv) {
        milestoneDiv.remove();
    }
    updateMilestonesJSON();
}

function updateMilestoneData(milestoneId, field, value) {
    const milestone = milestonesData.find(m => m.id === milestoneId);
    if (milestone) {
        milestone[field] = value;
        updateMilestonesJSON();
    }
}

function updateMilestonesJSON() {
    const jsonTextarea = document.getElementById('milestones_json');
    jsonTextarea.value = JSON.stringify(milestonesData, null, 2);
}

// Achievements Management Functions
function addAchievement() {
    const achievement = {
        id: ++achievementsCounter,
        year: '',
        title: '',
        description: '',
        level: 'Sekolah',
        category: 'Umum',
        icon: 'fas fa-award',
        color: 'primary'
    };
    
    achievementsData.push(achievement);
    addAchievementToDOM(achievement);
    updateAchievementsJSON();
}

function addAchievementToDOM(achievement) {
    const container = document.getElementById('achievements-container');
    const achievementDiv = document.createElement('div');
    achievementDiv.className = 'dynamic-item';
    achievementDiv.setAttribute('data-achievement-id', achievement.id);
    
    achievementDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Prestasi #${achievement.id}</h6>
            <button type="button" class="btn-remove" onclick="removeAchievement(${achievement.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Hapus
            </button>
        </div>
        <div class="dynamic-item-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Tahun</label>
                    <input type="text" class="form-input" value="${achievement.year || ''}" 
                           onchange="updateAchievementData(${achievement.id}, 'year', this.value)" 
                           placeholder="Contoh: 2020">
                </div>
                <div class="form-group">
                    <label class="form-label">Tingkat</label>
                    <select class="form-input" onchange="updateAchievementData(${achievement.id}, 'level', this.value)">
                        <option value="Sekolah" ${(achievement.level || 'Sekolah') === 'Sekolah' ? 'selected' : ''}>Sekolah</option>
                        <option value="Kota" ${achievement.level === 'Kota' ? 'selected' : ''}>Kota</option>
                        <option value="Provinsi" ${achievement.level === 'Provinsi' ? 'selected' : ''}>Provinsi</option>
                        <option value="Nasional" ${achievement.level === 'Nasional' ? 'selected' : ''}>Nasional</option>
                        <option value="Internasional" ${achievement.level === 'Internasional' ? 'selected' : ''}>Internasional</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select class="form-input" onchange="updateAchievementData(${achievement.id}, 'category', this.value)">
                    <option value="Umum" ${(achievement.category || 'Umum') === 'Umum' ? 'selected' : ''}>Umum</option>
                    <option value="Akademik" ${achievement.category === 'Akademik' ? 'selected' : ''}>Akademik</option>
                    <option value="Olahraga" ${achievement.category === 'Olahraga' ? 'selected' : ''}>Olahraga</option>
                    <option value="Seni" ${achievement.category === 'Seni' ? 'selected' : ''}>Seni</option>
                    <option value="Lingkungan" ${achievement.category === 'Lingkungan' ? 'selected' : ''}>Lingkungan</option>
                    <option value="Teknologi" ${achievement.category === 'Teknologi' ? 'selected' : ''}>Teknologi</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Judul Prestasi</label>
                <input type="text" class="form-input" value="${achievement.title || ''}" 
                       onchange="updateAchievementData(${achievement.id}, 'title', this.value)" 
                       placeholder="Contoh: Juara 1 Olimpiade Matematika">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateAchievementData(${achievement.id}, 'description', this.value)" 
                          placeholder="Deskripsi detail prestasi...">${achievement.description || ''}</textarea>
            </div>
        </div>
    `;
    
    container.appendChild(achievementDiv);
}

function removeAchievement(achievementId) {
    achievementsData = achievementsData.filter(achievement => achievement.id !== achievementId);
    const achievementDiv = document.querySelector(`[data-achievement-id="${achievementId}"]`);
    if (achievementDiv) {
        achievementDiv.remove();
    }
    updateAchievementsJSON();
}

function updateAchievementData(achievementId, field, value) {
    const achievement = achievementsData.find(a => a.id === achievementId);
    if (achievement) {
        achievement[field] = value;
        updateAchievementsJSON();
    }
}

function updateAchievementsJSON() {
    const jsonTextarea = document.getElementById('achievements_json');
    jsonTextarea.value = JSON.stringify(achievementsData, null, 2);
}
</script>
@endsection