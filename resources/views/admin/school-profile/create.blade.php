@extends('layouts.admin')

@section('title', 'Create School Profile')

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
    .create-profile-page {
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

    .btn-back {
        background: white;
        color: #3b82f6;
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
        color: #3b82f6;
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
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
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
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
        box-shadow: 0 6px 20px rgba(59, 130, 246, 0.3);
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
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.2);
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
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
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

    /* History Timeline Styles */
    .history-timeline {
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        background: var(--bg-primary);
    }

    .history-timeline:hover {
        border-color: #3b82f6;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
    }

    .history-header {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-item {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        background: var(--bg-secondary);
        transition: all 0.3s ease;
    }

    .history-item:hover {
        border-color: #8b5cf6;
        box-shadow: 0 2px 8px rgba(139, 92, 246, 0.1);
    }

    .history-item-header {
        background: var(--bg-tertiary);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .history-item-body {
        padding: 1rem;
        background: var(--bg-primary);
    }

    .year-badge {
        background: linear-gradient(135deg, #8b5cf6, #7c3aed);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .create-profile-page {
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
<div class="create-profile-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create School Profile
            </h1>
            <p class="page-subtitle">Create comprehensive school profile with detailed information and historical timeline</p>
            <a href="{{ route('admin.school-profile.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
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
                <strong>Please fix the following errors:</strong>
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
                School Profile Details
            </h2>
        </div>

        <form action="{{ route('admin.school-profile.store') }}" method="POST" id="schoolProfileForm" enctype="multipart/form-data">
            @csrf
            
            <div class="form-body">
                <div class="form-row">
                    <!-- Left Column - Main Content -->
                    <div class="form-section">
                        <div class="form-group">
                            <label for="school_name" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                </svg>
                                School Name
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="school_name" 
                                   id="school_name" 
                                   class="form-input @error('school_name') is-invalid @enderror" 
                                   value="{{ old('school_name') }}" 
                                   required
                                   placeholder="Enter school name...">
                            @error('school_name')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="school_motto" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                School Motto
                            </label>
                            <input type="text" 
                                   name="school_motto" 
                                   id="school_motto" 
                                   class="form-input @error('school_motto') is-invalid @enderror" 
                                   value="{{ old('school_motto') }}" 
                                   placeholder="Excellence in Education">
                            @error('school_motto')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="about_description" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                About Description
                            </label>
                            <textarea name="about_description" 
                                      id="about_description" 
                                      class="form-input form-textarea @error('about_description') is-invalid @enderror" 
                                      placeholder="Brief description about the school...">{{ old('about_description') }}</textarea>
                            @error('about_description')
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
                                Vision
                            </label>
                            <textarea name="vision" 
                                      id="vision" 
                                      class="form-input form-textarea @error('vision') is-invalid @enderror" 
                                      placeholder="School vision statement...">{{ old('vision') }}</textarea>
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
                                Mission
                            </label>
                            <textarea name="mission" 
                                      id="mission" 
                                      class="form-input form-textarea @error('mission') is-invalid @enderror" 
                                      placeholder="School mission statement...">{{ old('mission') }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Historical Timeline Section -->
                        <div class="history-timeline">
                            <div class="history-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    School History Timeline
                                </h6>
                                <button type="button" class="btn-add" onclick="addHistoryYear()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Year
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="history-container">
                                    <!-- History years will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="history_json" class="form-label">History Data (JSON)</label>
                                    <textarea class="form-input @error('history_json') is-invalid @enderror" 
                                              id="history_json" name="history_json" rows="4" readonly
                                              placeholder='History data will appear here automatically'>{{ old('history_json', '[]') }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the history years you add above.</div>
                                    @error('history_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="principal_name" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Principal Name
                            </label>
                            <input type="text" 
                                   name="principal_name" 
                                   id="principal_name" 
                                   class="form-input @error('principal_name') is-invalid @enderror" 
                                   value="{{ old('principal_name') }}" 
                                   placeholder="Dr. John Doe, S.Pd, M.Pd">
                            @error('principal_name')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                Address
                            </label>
                            <textarea name="address" 
                                      id="address" 
                                      class="form-input form-textarea @error('address') is-invalid @enderror" 
                                      placeholder="School address...">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Phone
                            </label>
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   class="form-input @error('phone') is-invalid @enderror" 
                                   value="{{ old('phone') }}" 
                                   placeholder="(021) 1234567">
                            @error('phone')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email
                            </label>
                            <input type="email" 
                                   name="email" 
                                   id="email" 
                                   class="form-input @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" 
                                   placeholder="info@school.edu">
                            @error('email')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="website" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                Website
                            </label>
                            <input type="url" 
                                   name="website" 
                                   id="website" 
                                   class="form-input @error('website') is-invalid @enderror" 
                                   value="{{ old('website') }}" 
                                   placeholder="https://www.school.edu">
                            @error('website')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Facilities Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                                    </svg>
                                    School Facilities
                                </h6>
                                <button type="button" class="btn-add" onclick="addFacility()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Facility
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="facilities-container">
                                    <!-- Facilities will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="facilities_json" class="form-label">Facilities Data (JSON)</label>
                                    <textarea class="form-input @error('facilities_json') is-invalid @enderror" 
                                              id="facilities_json" name="facilities_json" rows="4" readonly
                                              placeholder='Facilities data will appear here automatically'>{{ old('facilities_json', '[]') }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the facilities you add above.</div>
                                    @error('facilities_json')
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
                                Settings
                            </label>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label for="is_active" style="margin: 0; font-weight: normal;">
                                    Activate this profile
                                </label>
                            </div>
                            <div class="form-help">The active profile will be displayed on the public page</div>
                        </div>

                        <!-- Media Upload -->
                        <div class="form-group">
                            <label for="principal_photo" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Principal Photo
                            </label>
                            <input type="file" class="form-input @error('principal_photo') is-invalid @enderror" 
                                   id="principal_photo" name="principal_photo" accept="image/*">
                            <div class="form-help">JPG, PNG, GIF. Max 5MB.</div>
                            @error('principal_photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hero_image" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Hero Image
                            </label>
                            <input type="file" class="form-input @error('hero_image') is-invalid @enderror" 
                                   id="hero_image" name="hero_image" accept="image/*">
                            <div class="form-help">Main image for profile page. Max 10MB.</div>
                            @error('hero_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Statistics -->
                        <div class="form-group">
                            <label class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                Statistics
                            </label>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-top: 0.5rem;">
                                <div>
                                    <label for="student_count" class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Siswa</label>
                                    <input type="number" class="form-input @error('student_count') is-invalid @enderror" 
                                           id="student_count" name="student_count" value="{{ old('student_count', 0) }}" min="0">
                                    @error('student_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="teacher_count" class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Guru</label>
                                    <input type="number" class="form-input @error('teacher_count') is-invalid @enderror" 
                                           id="teacher_count" name="teacher_count" value="{{ old('teacher_count', 0) }}" min="0">
                                    @error('teacher_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="staff_count" class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Staf</label>
                                    <input type="number" class="form-input @error('staff_count') is-invalid @enderror" 
                                           id="staff_count" name="staff_count" value="{{ old('staff_count', 0) }}" min="0">
                                    @error('staff_count')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div>
                                    <label for="industry_partnerships" class="form-label" style="font-size: 0.75rem; margin-bottom: 0.25rem;">Partnerships</label>
                                    <input type="number" class="form-input @error('industry_partnerships') is-invalid @enderror" 
                                           id="industry_partnerships" name="industry_partnerships" value="{{ old('industry_partnerships', 0) }}" min="0">
                                    @error('industry_partnerships')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="established_year" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Established Year
                            </label>
                            <input type="number" class="form-input @error('established_year') is-invalid @enderror" 
                                   id="established_year" name="established_year" value="{{ old('established_year') }}" 
                                   min="1900" max="{{ date('Y') }}" placeholder="{{ date('Y') }}">
                            @error('established_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="accreditation" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                Accreditation
                            </label>
                            <select class="form-input @error('accreditation') is-invalid @enderror" 
                                    id="accreditation" name="accreditation">
                                <option value="">Select Accreditation</option>
                                <option value="A" {{ old('accreditation') === 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                <option value="B" {{ old('accreditation') === 'B' ? 'selected' : '' }}>B (Good)</option>
                                <option value="C" {{ old('accreditation') === 'C' ? 'selected' : '' }}>C (Fair)</option>
                            </select>
                            @error('accreditation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.school-profile.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create School Profile
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Global variables for management
let facilitiesData = [];
let facilityCounter = 0;
let historyData = [];
let historyCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize facilities from old data if exists
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

    // Initialize history from old data if exists
    const oldHistoryJson = document.getElementById('history_json').value;
    if (oldHistoryJson && oldHistoryJson !== '[]') {
        try {
            historyData = JSON.parse(oldHistoryJson);
            historyData.forEach(history => {
                addHistoryToDOM(history);
            });
        } catch (e) {
            console.error('Error parsing history JSON:', e);
        }
    }

    // Form submission
    const form = document.getElementById('schoolProfileForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Update JSON fields before submission
        updateFacilitiesJSON();
        updateHistoryJSON();
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="spinner"></div>
            Creating...
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
                Create School Profile
            `;
            form.classList.remove('loading');
            
            // Show error message
            alert('Please fill in all required fields.');
        }
    });
});

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
            <h6 style="margin: 0; font-size: 0.875rem;">Facility #${facility.id || facilityCounter}</h6>
            <button type="button" class="btn-remove" onclick="removeFacility(${facility.id || facilityCounter})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-body">
            <div class="form-group">
                <label class="form-label">Facility Name</label>
                <input type="text" class="form-input" value="${facility.name || ''}" 
                       onchange="updateFacilityData(${facility.id || facilityCounter}, 'name', this.value)" 
                       placeholder="Library, Laboratory, etc.">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateFacilityData(${facility.id || facilityCounter}, 'description', this.value)" 
                          placeholder="Brief description of the facility...">${facility.description || ''}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Icon Class</label>
                    <select class="form-input" onchange="updateFacilityData(${facility.id || facilityCounter}, 'icon', this.value)">
                        <option value="fas fa-building" ${(facility.icon || 'fas fa-building') === 'fas fa-building' ? 'selected' : ''}>Building</option>
                        <option value="fas fa-book" ${facility.icon === 'fas fa-book' ? 'selected' : ''}>Library</option>
                        <option value="fas fa-microscope" ${facility.icon === 'fas fa-microscope' ? 'selected' : ''}>Laboratory</option>
                        <option value="fas fa-dumbbell" ${facility.icon === 'fas fa-dumbbell' ? 'selected' : ''}>Gym</option>
                        <option value="fas fa-music" ${facility.icon === 'fas fa-music' ? 'selected' : ''}>Music Room</option>
                        <option value="fas fa-desktop" ${facility.icon === 'fas fa-desktop' ? 'selected' : ''}>Computer Lab</option>
                        <option value="fas fa-utensils" ${facility.icon === 'fas fa-utensils' ? 'selected' : ''}>Cafeteria</option>
                        <option value="fas fa-car" ${facility.icon === 'fas fa-car' ? 'selected' : ''}>Parking</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select class="form-input" onchange="updateFacilityData(${facility.id || facilityCounter}, 'color', this.value)">
                        <option value="primary" ${(facility.color || 'primary') === 'primary' ? 'selected' : ''}>Blue</option>
                        <option value="success" ${facility.color === 'success' ? 'selected' : ''}>Green</option>
                        <option value="warning" ${facility.color === 'warning' ? 'selected' : ''}>Yellow</option>
                        <option value="danger" ${facility.color === 'danger' ? 'selected' : ''}>Red</option>
                        <option value="info" ${facility.color === 'info' ? 'selected' : ''}>Cyan</option>
                        <option value="purple" ${facility.color === 'purple' ? 'selected' : ''}>Purple</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(facilityDiv);
}

function removeFacility(facilityId) {
    // Remove from data array
    facilitiesData = facilitiesData.filter(facility => facility.id !== facilityId);
    
    // Remove from DOM
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

// History Management Functions
function addHistoryYear() {
    const history = {
        id: ++historyCounter,
        year: '',
        title: '',
        description: '',
        type: 'milestone'
    };
    
    historyData.push(history);
    addHistoryToDOM(history);
    updateHistoryJSON();
}

function addHistoryToDOM(history) {
    const container = document.getElementById('history-container');
    const historyDiv = document.createElement('div');
    historyDiv.className = 'history-item';
    historyDiv.setAttribute('data-history-id', history.id || ++historyCounter);
    
    historyDiv.innerHTML = `
        <div class="history-item-header">
            <div style="display: flex; align-items: center; gap: 0.5rem;">
                <span class="year-badge">${history.year || 'Year'}</span>
                <h6 style="margin: 0; font-size: 0.875rem;">Historical Event #${history.id || historyCounter}</h6>
            </div>
            <button type="button" class="btn-remove" onclick="removeHistory(${history.id || historyCounter})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="history-item-body">
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label">Year</label>
                    <input type="number" class="form-input" value="${history.year || ''}" 
                           min="1900" max="${new Date().getFullYear()}"
                           onchange="updateHistoryData(${history.id || historyCounter}, 'year', this.value); updateYearBadge(${history.id || historyCounter}, this.value)" 
                           placeholder="2024">
                </div>
                <div class="form-group">
                    <label class="form-label">Event Type</label>
                    <select class="form-input" onchange="updateHistoryData(${history.id || historyCounter}, 'type', this.value)">
                        <option value="milestone" ${(history.type || 'milestone') === 'milestone' ? 'selected' : ''}>Milestone</option>
                        <option value="achievement" ${history.type === 'achievement' ? 'selected' : ''}>Achievement</option>
                        <option value="expansion" ${history.type === 'expansion' ? 'selected' : ''}>Expansion</option>
                        <option value="recognition" ${history.type === 'recognition' ? 'selected' : ''}>Recognition</option>
                        <option value="innovation" ${history.type === 'innovation' ? 'selected' : ''}>Innovation</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Event Title</label>
                <input type="text" class="form-input" value="${history.title || ''}" 
                       onchange="updateHistoryData(${history.id || historyCounter}, 'title', this.value)" 
                       placeholder="School establishment, New building, etc.">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateHistoryData(${history.id || historyCounter}, 'description', this.value)" 
                          placeholder="Detailed description of the historical event...">${history.description || ''}</textarea>
            </div>
        </div>
    `;
    
    container.appendChild(historyDiv);
}

function removeHistory(historyId) {
    // Remove from data array
    historyData = historyData.filter(history => history.id !== historyId);
    
    // Remove from DOM
    const historyDiv = document.querySelector(`[data-history-id="${historyId}"]`);
    if (historyDiv) {
        historyDiv.remove();
    }
    
    updateHistoryJSON();
}

function updateHistoryData(historyId, field, value) {
    const history = historyData.find(h => h.id === historyId);
    if (history) {
        history[field] = value;
        updateHistoryJSON();
    }
}

function updateYearBadge(historyId, year) {
    const historyDiv = document.querySelector(`[data-history-id="${historyId}"]`);
    if (historyDiv) {
        const yearBadge = historyDiv.querySelector('.year-badge');
        if (yearBadge) {
            yearBadge.textContent = year || 'Year';
        }
    }
}

function updateHistoryJSON() {
    const jsonTextarea = document.getElementById('history_json');
    // Sort history by year before saving
    const sortedHistory = historyData.sort((a, b) => (a.year || 0) - (b.year || 0));
    jsonTextarea.value = JSON.stringify(sortedHistory, null, 2);
}
</script>
@endsection