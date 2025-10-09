@extends('layouts.admin')

@section('title', 'Create Contact')

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

    /* Base Styles */
    .create-contact-page {
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

    /* Buttons */
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .create-contact-page {
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

    /* Loading State */
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
<div class="create-contact-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create Contact
            </h1>
            <p class="page-subtitle">Add new contact information for school communication channels</p>
            <a href="{{ route('admin.contacts.index') }}" class="btn-back">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Contact Information
            </h2>
        </div>

        <form action="{{ route('admin.contacts.store') }}" method="POST" id="contactForm" enctype="multipart/form-data">
            @csrf
            
            <div class="form-body">
                <div class="form-row">
                    <!-- Left Column - Main Content -->
                    <div class="form-section">

                        <!-- Basic Information -->
                        <div class="form-group">
                            <label for="title" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Contact Title
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-input @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" 
                                   required
                                   placeholder="Example: Main Office, Secretariat, etc.">
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
                            <label for="description" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Description
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      class="form-input form-textarea @error('description') is-invalid @enderror" 
                                      placeholder="Brief description about this contact...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Contact Details -->
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
                                      class="form-input @error('address') is-invalid @enderror" 
                                      rows="2"
                                      placeholder="Complete address...">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="phone" class="form-label">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    Phone Number
                                </label>
                                <input type="text" 
                                       name="phone" 
                                       id="phone" 
                                       class="form-input @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone') }}" 
                                       placeholder="Example: (0352) 123-4567">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
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
                                       placeholder="Example: info@school.sch.id">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="website" class="form-label">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9m0 9c-5 0-9-4-9-9s4-9 9-9"/>
                                    </svg>
                                    Website
                                </label>
                                <input type="url" 
                                       name="website" 
                                       id="website" 
                                       class="form-input @error('website') is-invalid @enderror" 
                                       value="{{ old('website') }}" 
                                       placeholder="https://www.school.sch.id">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="office_hours" class="form-label">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Office Hours
                                </label>
                                <input type="text" 
                                       name="office_hours" 
                                       id="office_hours" 
                                       class="form-input @error('office_hours') is-invalid @enderror" 
                                       value="{{ old('office_hours') }}" 
                                       placeholder="Example: Monday-Friday 07:00-16:00">
                                @error('office_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Social Media Section -->
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="facebook" class="form-label">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                    Facebook
                                </label>
                                <input type="url" 
                                       name="facebook" 
                                       id="facebook" 
                                       class="form-input @error('facebook') is-invalid @enderror" 
                                       value="{{ old('facebook') }}" 
                                       placeholder="https://facebook.com/username">
                                @error('facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="instagram" class="form-label">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C4.198 14.895 3.708 13.744 3.708 12.447s.49-2.448 1.418-3.323c.875-.807 2.026-1.297 3.323-1.297s2.448.49 3.323 1.297c.928.875 1.418 2.026 1.418 3.323s-.49 2.448-1.418 3.244c-.875.807-2.026 1.297-3.323 1.297zm7.83-9.781c-.315 0-.612-.123-.833-.344-.221-.221-.344-.518-.344-.833 0-.315.123-.612.344-.833.221-.221.518-.344.833-.344.315 0 .612.123.833.344.221.221.344.518.344.833 0 .315-.123.612-.344.833-.221.221-.518.344-.833.344zm0 0"/>
                                    </svg>
                                    Instagram
                                </label>
                                <input type="url" 
                                       name="instagram" 
                                       id="instagram" 
                                       class="form-input @error('instagram') is-invalid @enderror" 
                                       value="{{ old('instagram') }}" 
                                       placeholder="https://instagram.com/username">
                                @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="whatsapp" class="form-label">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                    </svg>
                                    WhatsApp
                                </label>
                                <input type="text" 
                                       name="whatsapp" 
                                       id="whatsapp" 
                                       class="form-input @error('whatsapp') is-invalid @enderror" 
                                       value="{{ old('whatsapp') }}" 
                                       placeholder="https://wa.me/628123456789">
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="youtube" class="form-label">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                    YouTube
                                </label>
                                <input type="url" 
                                       name="youtube" 
                                       id="youtube" 
                                       class="form-input @error('youtube') is-invalid @enderror" 
                                       value="{{ old('youtube') }}" 
                                       placeholder="https://youtube.com/channel/...">
                                @error('youtube')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Map Embed -->
                        <div class="form-group">
                            <label for="map_embed" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                Google Maps Embed
                            </label>
                            <textarea name="map_embed" 
                                      id="map_embed" 
                                      class="form-input @error('map_embed') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Paste Google Maps embed code or iframe URL here...">{{ old('map_embed') }}</textarea>
                            @error('map_embed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                How to get: Open Google Maps → Search location → Click "Share" → Select "Embed a map" → Copy HTML code
                            </div>
                        </div>

                        <!-- Hero Image Section -->
                        @if(\Schema::hasColumn('contacts', 'hero_image'))
                        <div class="form-group">
                            <label for="hero_image" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Hero Background Image
                            </label>
                            <input type="file" 
                                   name="hero_image" 
                                   id="hero_image" 
                                   class="form-input @error('hero_image') is-invalid @enderror" 
                                   accept="image/*"
                                   onchange="previewHeroImage(this)">
                            @error('hero_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Upload an image for the contact page hero section. Recommended size: 1920x600px. Max file size: 2MB.
                            </div>
                            
                            <!-- Image Preview -->
                            <div id="heroImagePreview" style="margin-top: 1rem; display: none;">
                                <img id="heroImagePreviewImg" src="" alt="Hero Image Preview" style="max-width: 100%; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid var(--border-color);">
                                <button type="button" onclick="removeHeroImagePreview()" style="margin-top: 0.5rem; background: #ef4444; color: white; border: none; padding: 0.25rem 0.5rem; border-radius: 4px; font-size: 0.75rem; cursor: pointer;">
                                    Remove Image
                                </button>
                            </div>
                        </div>
                        @endif

                        <!-- Quick Contact Cards Section -->
                        @if(true)
                        <div style="border-top: 2px solid var(--border-color); padding-top: 2rem; margin-top: 2rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                                <div>
                                    <h3 style="color: var(--text-primary); font-size: 1.25rem; font-weight: 600; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        Quick Contact Cards
                                    </h3>
                                    <p style="color: var(--text-secondary); margin: 0.5rem 0 0 0; font-size: 0.875rem;">Configure quick contact cards that appear at the bottom of the contact page (max 10 cards).</p>
                                </div>
                                <button type="button" id="addCardBtn" onclick="console.log('Button clicked!'); addQuickCard();" style="background: linear-gradient(135deg, var(--accent-color), var(--accent-hover)); color: white; border: none; border-radius: 8px; padding: 0.75rem 1rem; font-size: 0.875rem; font-weight: 600; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Card
                                </button>
                            </div>
                            
                            <div id="quickCardsContainer">
                                <!-- Cards will be dynamically generated -->
                            </div>
                            
                            <!-- Card Template (hidden) -->
                            <div id="cardTemplate" style="display: none;">
                                <div class="quick-card-item" style="background: var(--bg-secondary); padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid var(--border-color); position: relative;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                        <h4 style="color: var(--text-primary); font-size: 1rem; font-weight: 600; margin: 0;">Card <span class="card-number">1</span></h4>
                                        <button type="button" class="remove-card-btn" onclick="removeQuickCard(this)" style="background: #ef4444; color: white; border: none; border-radius: 6px; padding: 0.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s ease;">
                                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1rem; margin-bottom: 1rem;">
                                        <div class="form-group">
                                            <label class="form-label">Icon</label>
                                            <div style="position: relative;">
                                                <input type="hidden" class="card-icon-input" name="" value="">
                                                <div class="icon-selector" style="border: 2px solid var(--border-color); border-radius: 8px; padding: 0.75rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; background: var(--bg-primary); transition: all 0.3s ease;">
                                                    <i class="card-icon-preview" style="font-size: 1.2rem; color: var(--accent-color);"></i>
                                                    <span class="card-icon-text" style="color: var(--text-primary);"></span>
                                                    <svg style="margin-left: auto; width: 1rem; height: 1rem; color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Judul</label>
                                            <input type="text" class="form-input card-title-input" name="" placeholder="Card title">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Deskripsi</label>
                                        <textarea class="form-input card-description-input" name="" rows="2" placeholder="Card description..."></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-help" style="margin-top: 1rem;">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                You can add up to 10 quick contact cards. Click "Add Card" to create new cards and use the trash icon to remove unwanted cards.
                            </div>
                        </div>
                        @else
                        <div style="border-top: 2px solid var(--border-color); padding-top: 2rem; margin-top: 2rem;">
                            <div style="background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 8px; padding: 1rem; margin-bottom: 1rem;">
                                <h4 style="color: #856404; margin: 0 0 0.5rem 0; font-size: 0.875rem; font-weight: 600;">⚠️ Database Update Required</h4>
                                <p style="color: #856404; margin: 0; font-size: 0.875rem;">Quick Contact Cards feature requires database migration. Please run: <code style="background: #f8f9fa; padding: 0.25rem 0.5rem; border-radius: 4px;">php artisan migrate</code></p>
                            </div>
                        </div>
                        @endif
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
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label for="is_active" style="margin: 0; font-weight: normal;">
                                    Activate this contact
                                </label>
                            </div>
                            <div class="form-help">Active contacts will be displayed on the public website</div>
                        </div>

                        <!-- Quick Cards Preview -->
                        <div style="background: var(--bg-secondary); padding: 1.5rem; border-radius: 12px; border: 1px solid var(--border-color);">
                            <h4 style="color: var(--text-primary); font-size: 1rem; font-weight: 600; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Preview
                            </h4>
                            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">This is how the quick contact cards will appear on the public website.</p>
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;" id="cardsPreview">
                                <!-- Preview cards will be generated by JavaScript -->
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sort_order" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                Display Order
                            </label>
                            <input type="number" 
                                   name="sort_order" 
                                   id="sort_order" 
                                   class="form-input @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', 0) }}" 
                                   min="0"
                                   placeholder="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-help">Lower numbers appear first in the list</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.contacts.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Create Contact
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Icon Picker Modal -->
<div id="iconPickerModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; width: 90%; max-width: 800px; max-height: 80vh; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <div style="padding: 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; color: var(--text-primary); font-size: 1.25rem; font-weight: 600;">Choose an Icon</h3>
            <button onclick="closeIconPicker()" style="background: none; border: none; font-size: 1.5rem; color: var(--text-secondary); cursor: pointer; padding: 0.25rem;">&times;</button>
        </div>
        <div style="padding: 1rem; max-height: 60vh; overflow-y: auto;">
            <div style="margin-bottom: 1rem;">
                <input type="text" id="iconSearch" placeholder="Search icons..." style="width: 100%; padding: 0.75rem; border: 2px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem;" onkeyup="filterIcons()">
            </div>
            <div id="iconGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 0.5rem;">
                <!-- Icons will be populated by JavaScript -->
            </div>
        </div>
    </div>
</div>

<script>
// Global variables
let cardCounter = 0;
const maxCards = 10;
const defaultCards = [
    { icon: 'fas fa-user-graduate', title: 'Penerimaan Siswa', description: 'Informasi lengkap tentang penerimaan siswa baru, syarat pendaftaran, dan jadwal seleksi.' },
    { icon: 'fas fa-book', title: 'Program Akademik', description: 'Kurikulum, ekstrakurikuler, dan berbagai program unggulan yang tersedia di sekolah kami.' },
    { icon: 'fas fa-users', title: 'Kerjasama', description: 'Peluang kerjasama dengan institusi lain, program magang, dan kemitraan strategis.' }
];

// Quick Cards Preview Function (Global)
function updateCardsPreview() {
    const previewContainer = document.getElementById('cardsPreview');
    if (!previewContainer) return;
    
    let previewHTML = '';
    const cards = document.querySelectorAll('#quickCardsContainer > div');
    
    cards.forEach((card, index) => {
        const iconInput = card.querySelector('.card-icon-input');
        const titleInput = card.querySelector('.card-title-input');
        const descriptionInput = card.querySelector('.card-description-input');
        
        const icon = iconInput?.value || 'fas fa-info-circle';
        const title = titleInput?.value || `Card ${index + 1}`;
        const description = descriptionInput?.value || 'No description provided.';
        
        previewHTML += `
            <div style="background: white; padding: 1rem; border-radius: 8px; text-align: center; border: 1px solid var(--border-color); box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #3498db, #2980b9); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.75rem; font-size: 1rem;">
                    <i class="${icon}"></i>
                </div>
                <h5 style="color: var(--text-primary); font-weight: 600; margin-bottom: 0.5rem; font-size: 0.875rem;">${title}</h5>
                <p style="color: var(--text-secondary); font-size: 0.75rem; line-height: 1.4; margin: 0;">${description.substring(0, 80)}${description.length > 80 ? '...' : ''}</p>
            </div>
        `;
    });
    
    previewContainer.innerHTML = previewHTML;
}

// Dynamic Quick Cards Management Functions
function initializeQuickCards() {
    console.log('Initializing quick cards...');
    // Add default cards
    defaultCards.forEach(cardData => {
        addQuickCard(cardData);
    });
    updateAddButtonState();
}

function addQuickCard(cardData = null) {
    console.log('Adding quick card...', cardData);
    
    if (cardCounter >= maxCards) {
        alert(`Maximum ${maxCards} cards allowed.`);
        return;
    }
    
    cardCounter++;
    const container = document.getElementById('quickCardsContainer');
    const template = document.getElementById('cardTemplate');
    
    if (!container || !template) {
        console.error('Container or template not found');
        return;
    }
    
    const cardElement = template.cloneNode(true);
    
    // Remove template ID and show the card
    cardElement.id = `quick-card-${cardCounter}`;
    cardElement.style.display = 'block';
    
    // Update card number
    cardElement.querySelector('.card-number').textContent = cardCounter;
    
    // Set up form field names and IDs
    const iconInput = cardElement.querySelector('.card-icon-input');
    const titleInput = cardElement.querySelector('.card-title-input');
    const descriptionInput = cardElement.querySelector('.card-description-input');
    const iconSelector = cardElement.querySelector('.icon-selector');
    const iconPreview = cardElement.querySelector('.card-icon-preview');
    const iconText = cardElement.querySelector('.card-icon-text');
    
    iconInput.name = `quick_card_${cardCounter}_icon`;
    iconInput.id = `quick_card_${cardCounter}_icon`;
    titleInput.name = `quick_card_${cardCounter}_title`;
    titleInput.id = `quick_card_${cardCounter}_title`;
    descriptionInput.name = `quick_card_${cardCounter}_description`;
    descriptionInput.id = `quick_card_${cardCounter}_description`;
    
    // Set default values if provided
    if (cardData) {
        iconInput.value = cardData.icon;
        titleInput.value = cardData.title;
        descriptionInput.value = cardData.description;
        iconPreview.className = cardData.icon;
        iconText.textContent = cardData.icon;
    } else {
        iconInput.value = 'fas fa-info-circle';
        iconPreview.className = 'fas fa-info-circle';
        iconText.textContent = 'fas fa-info-circle';
    }
    
    // Set up icon selector click event
    iconSelector.onclick = () => openIconPicker(iconInput.id);
    
    // Add event listeners for preview updates
    titleInput.addEventListener('input', updateCardsPreview);
    descriptionInput.addEventListener('input', updateCardsPreview);
    
    // Add hover effects
    iconSelector.addEventListener('mouseenter', function() {
        this.style.borderColor = 'var(--accent-color)';
        this.style.backgroundColor = 'rgba(139, 92, 246, 0.05)';
    });
    iconSelector.addEventListener('mouseleave', function() {
        this.style.borderColor = 'var(--border-color)';
        this.style.backgroundColor = 'var(--bg-primary)';
    });
    
    container.appendChild(cardElement);
    updateAddButtonState();
    updateCardsPreview();
    
    console.log('Card added successfully');
}

function removeQuickCard(button) {
    if (cardCounter <= 1) {
        alert('At least one card is required.');
        return;
    }
    
    const cardElement = button.closest('.quick-card-item').parentElement;
    cardElement.remove();
    cardCounter--;
    
    // Renumber remaining cards
    renumberCards();
    updateAddButtonState();
    updateCardsPreview();
}

function renumberCards() {
    const cards = document.querySelectorAll('#quickCardsContainer > div');
    cardCounter = 0;
    
    cards.forEach((card, index) => {
        cardCounter++;
        const cardNumber = cardCounter;
        
        // Update card number display
        card.querySelector('.card-number').textContent = cardNumber;
        
        // Update form field names and IDs
        const iconInput = card.querySelector('.card-icon-input');
        const titleInput = card.querySelector('.card-title-input');
        const descriptionInput = card.querySelector('.card-description-input');
        
        iconInput.name = `quick_card_${cardNumber}_icon`;
        iconInput.id = `quick_card_${cardNumber}_icon`;
        titleInput.name = `quick_card_${cardNumber}_title`;
        titleInput.id = `quick_card_${cardNumber}_title`;
        descriptionInput.name = `quick_card_${cardNumber}_description`;
        descriptionInput.id = `quick_card_${cardNumber}_description`;
        
        // Update icon selector click event
        const iconSelector = card.querySelector('.icon-selector');
        iconSelector.onclick = () => openIconPicker(iconInput.id);
    });
}

function updateAddButtonState() {
    const addBtn = document.getElementById('addCardBtn');
    if (!addBtn) return;
    
    if (cardCounter >= maxCards) {
        addBtn.disabled = true;
        addBtn.style.opacity = '0.5';
        addBtn.style.cursor = 'not-allowed';
    } else {
        addBtn.disabled = false;
        addBtn.style.opacity = '1';
        addBtn.style.cursor = 'pointer';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing...');
    
    // Check if elements exist
    const addBtn = document.getElementById('addCardBtn');
    const container = document.getElementById('quickCardsContainer');
    const template = document.getElementById('cardTemplate');
    
    console.log('Add button:', addBtn);
    console.log('Container:', container);
    console.log('Template:', template);
    
    // Form submission
    const form = document.getElementById('contactForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
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
                Create Contact
            `;
            form.classList.remove('loading');
            
            // Show error message
            alert('Please fill in all required fields.');
        }
    });
    
    // Test function availability
    console.log('addQuickCard function:', typeof addQuickCard);
    console.log('initializeQuickCards function:', typeof initializeQuickCards);
    
    // Add direct event listener to button as backup
    if (addBtn) {
        addBtn.addEventListener('click', function() {
            console.log('Button clicked via event listener!');
            addQuickCard();
        });
    }
    
    // Initialize quick cards
    initializeQuickCards();
    
    // Initial preview update
    updateCardsPreview();
});

// Hero Image Preview Functions
function previewHeroImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            document.getElementById('heroImagePreviewImg').src = e.target.result;
            document.getElementById('heroImagePreview').style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeHeroImagePreview() {
    document.getElementById('hero_image').value = '';
    document.getElementById('heroImagePreview').style.display = 'none';
    document.getElementById('heroImagePreviewImg').src = '';
}



// Icon Picker Functionality
let currentIconField = null;

const popularIcons = [
    'fas fa-user-graduate', 'fas fa-book', 'fas fa-users', 'fas fa-home', 'fas fa-phone',
    'fas fa-envelope', 'fas fa-map-marker-alt', 'fas fa-clock', 'fas fa-calendar',
    'fas fa-star', 'fas fa-heart', 'fas fa-thumbs-up', 'fas fa-check', 'fas fa-info-circle',
    'fas fa-exclamation-triangle', 'fas fa-question-circle', 'fas fa-cog', 'fas fa-search',
    'fas fa-plus', 'fas fa-minus', 'fas fa-edit', 'fas fa-trash', 'fas fa-download',
    'fas fa-upload', 'fas fa-share', 'fas fa-print', 'fas fa-save', 'fas fa-copy',
    'fas fa-cut', 'fas fa-paste', 'fas fa-undo', 'fas fa-redo', 'fas fa-bold',
    'fas fa-italic', 'fas fa-underline', 'fas fa-align-left', 'fas fa-align-center',
    'fas fa-align-right', 'fas fa-list', 'fas fa-link', 'fas fa-image', 'fas fa-video',
    'fas fa-music', 'fas fa-file', 'fas fa-folder', 'fas fa-archive', 'fas fa-database',
    'fas fa-server', 'fas fa-cloud', 'fas fa-wifi', 'fas fa-signal', 'fas fa-battery-full',
    'fas fa-plug', 'fas fa-lightbulb', 'fas fa-fire', 'fas fa-snowflake', 'fas fa-sun',
    'fas fa-moon', 'fas fa-umbrella', 'fas fa-tree', 'fas fa-leaf', 'fas fa-flower',
    'fas fa-car', 'fas fa-bus', 'fas fa-train', 'fas fa-plane', 'fas fa-ship',
    'fas fa-bicycle', 'fas fa-motorcycle', 'fas fa-truck', 'fas fa-taxi', 'fas fa-rocket',
    'fas fa-globe', 'fas fa-flag', 'fas fa-trophy', 'fas fa-medal', 'fas fa-award',
    'fas fa-gift', 'fas fa-birthday-cake', 'fas fa-coffee', 'fas fa-pizza-slice',
    'fas fa-hamburger', 'fas fa-apple-alt', 'fas fa-wine-glass', 'fas fa-beer',
    'fas fa-shopping-cart', 'fas fa-credit-card', 'fas fa-money-bill', 'fas fa-coins',
    'fas fa-chart-bar', 'fas fa-chart-pie', 'fas fa-chart-line', 'fas fa-calculator',
    'fas fa-briefcase', 'fas fa-building', 'fas fa-hospital', 'fas fa-school',
    'fas fa-university', 'fas fa-church', 'fas fa-store', 'fas fa-warehouse',
    'fas fa-tools', 'fas fa-wrench', 'fas fa-hammer', 'fas fa-screwdriver',
    'fas fa-paint-brush', 'fas fa-palette', 'fas fa-camera', 'fas fa-microphone',
    'fas fa-headphones', 'fas fa-gamepad', 'fas fa-puzzle-piece', 'fas fa-dice',
    'fas fa-chess', 'fas fa-football-ball', 'fas fa-basketball-ball', 'fas fa-baseball-ball',
    'fas fa-volleyball-ball', 'fas fa-table-tennis', 'fas fa-running', 'fas fa-walking',
    'fas fa-swimming-pool', 'fas fa-dumbbell', 'fas fa-weight', 'fas fa-heartbeat',
    'fas fa-stethoscope', 'fas fa-pills', 'fas fa-syringe', 'fas fa-thermometer',
    'fas fa-band-aid', 'fas fa-glasses', 'fas fa-eye', 'fas fa-eye-slash',
    'fas fa-lock', 'fas fa-unlock', 'fas fa-key', 'fas fa-shield-alt', 'fas fa-fingerprint'
];

function openIconPicker(fieldId) {
    currentIconField = fieldId;
    const modal = document.getElementById('iconPickerModal');
    modal.style.display = 'flex';
    populateIcons();
    document.body.style.overflow = 'hidden';
}

function closeIconPicker() {
    const modal = document.getElementById('iconPickerModal');
    modal.style.display = 'none';
    currentIconField = null;
    document.body.style.overflow = 'auto';
}

function populateIcons() {
    const iconGrid = document.getElementById('iconGrid');
    iconGrid.innerHTML = '';
    
    popularIcons.forEach(iconClass => {
        const iconButton = document.createElement('div');
        iconButton.style.cssText = `
            padding: 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.5rem;
        `;
        
        iconButton.innerHTML = `
            <i class="${iconClass}" style="font-size: 1.5rem; color: var(--accent-color);"></i>
            <span style="font-size: 0.75rem; color: var(--text-secondary); word-break: break-all;">${iconClass.replace('fas fa-', '')}</span>
        `;
        
        iconButton.addEventListener('click', () => selectIcon(iconClass));
        iconButton.addEventListener('mouseenter', () => {
            iconButton.style.borderColor = 'var(--accent-color)';
            iconButton.style.backgroundColor = 'rgba(139, 92, 246, 0.05)';
        });
        iconButton.addEventListener('mouseleave', () => {
            iconButton.style.borderColor = '#e2e8f0';
            iconButton.style.backgroundColor = 'white';
        });
        
        iconGrid.appendChild(iconButton);
    });
}

function filterIcons() {
    const searchTerm = document.getElementById('iconSearch').value.toLowerCase();
    const iconButtons = document.querySelectorAll('#iconGrid > div');
    
    iconButtons.forEach(button => {
        const iconText = button.querySelector('span').textContent.toLowerCase();
        if (iconText.includes(searchTerm)) {
            button.style.display = 'flex';
        } else {
            button.style.display = 'none';
        }
    });
}

function selectIcon(iconClass) {
    if (!currentIconField) return;
    
    // Update hidden input
    document.getElementById(currentIconField).value = iconClass;
    
    // Update preview
    const previewIcon = document.getElementById(currentIconField + '_preview');
    const previewText = document.getElementById(currentIconField + '_text');
    
    if (previewIcon) {
        previewIcon.className = iconClass;
    }
    if (previewText) {
        previewText.textContent = iconClass;
    }
    
    // Update cards preview
    updateCardsPreview();
    
    // Close modal
    closeIconPicker();
}

// Close modal when clicking outside
document.getElementById('iconPickerModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeIconPicker();
    }
});

// Add hover effects to icon selectors
document.addEventListener('DOMContentLoaded', function() {
    const iconSelectors = document.querySelectorAll('.icon-selector');
    iconSelectors.forEach(selector => {
        selector.addEventListener('mouseenter', function() {
            this.style.borderColor = 'var(--accent-color)';
            this.style.backgroundColor = 'rgba(139, 92, 246, 0.05)';
        });
        selector.addEventListener('mouseleave', function() {
            this.style.borderColor = 'var(--border-color)';
            this.style.backgroundColor = 'var(--bg-primary)';
        });
    });
});
</script>
@endsection