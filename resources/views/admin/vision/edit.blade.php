@extends('layouts.admin')

@section('title', 'Edit Vision & Mission - ' . $vision->title)

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
    .edit-vision-page {
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
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.1);
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

    /* Dynamic Form Sections */
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

    .alert-info {
        background: rgba(139, 92, 246, 0.1);
        color: var(--accent-hover);
        border: 1px solid rgba(139, 92, 246, 0.2);
    }

    /* Current Image Display */
    .current-image {
        width: 100%;
        max-width: 200px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        border: 1px solid var(--border-color);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .edit-vision-page {
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
<div class="edit-vision-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Edit Vision & Mission
            </h1>
            <p class="page-subtitle">Update comprehensive vision, mission, and strategic goals for your institution</p>
            <a href="{{ route('admin.vision.index') }}" class="btn-back">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Vision & Mission Details
            </h2>
        </div>

        <form action="{{ route('admin.vision.update', $vision) }}" method="POST" id="visionForm" enctype="multipart/form-data">
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
                                Page Title
                                <span class="required">*</span>
                            </label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-input @error('title') is-invalid @enderror" 
                                   value="{{ old('title', $vision->title) }}" 
                                   required
                                   placeholder="Enter page title...">
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
                            <label for="vision_text" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                School Vision
                                <span class="required">*</span>
                            </label>
                            <textarea name="vision_text" 
                                      id="vision_text" 
                                      class="form-input form-textarea @error('vision_text') is-invalid @enderror" 
                                      required
                                      placeholder="Enter school vision statement...">{{ old('vision_text', $vision->vision_text) }}</textarea>
                            @error('vision_text')
                                <div class="invalid-feedback">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Mission Items Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v4a2 2 0 002 2h2a2 2 0 002-2v-4m0 0h2a2 2 0 002-2V7a2 2 0 00-2-2h-2m0 0V3a2 2 0 00-2-2H9a2 2 0 00-2 2v2z"/>
                                    </svg>
                                    School Mission
                                </h6>
                                <button type="button" class="btn-add" onclick="addMissionItem()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Mission
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="mission-container">
                                    <!-- Mission items will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="mission_items_json" class="form-label">Mission Data (JSON)</label>
                                    <textarea class="form-input @error('mission_items_json') is-invalid @enderror" 
                                              id="mission_items_json" name="mission_items_json" rows="4" readonly
                                              placeholder='Mission data will appear here automatically'>{{ old('mission_items_json', json_encode($vision->mission_items ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the missions you add above.</div>
                                    @error('mission_items_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Goals Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                    </svg>
                                    Strategic Goals
                                </h6>
                                <button type="button" class="btn-add" onclick="addGoal()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Goal
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="goals-container">
                                    <!-- Goals will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="goals_json" class="form-label">Goals Data (JSON)</label>
                                    <textarea class="form-input @error('goals_json') is-invalid @enderror" 
                                              id="goals_json" name="goals_json" rows="4" readonly
                                              placeholder='Goals data will appear here automatically'>{{ old('goals_json', json_encode($vision->goals ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the goals you add above.</div>
                                    @error('goals_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Values Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                    School Values
                                </h6>
                                <button type="button" class="btn-add" onclick="addValue()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Value
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="values-container">
                                    <!-- Values will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="values_json" class="form-label">Values Data (JSON)</label>
                                    <textarea class="form-input @error('values_json') is-invalid @enderror" 
                                              id="values_json" name="values_json" rows="4" readonly
                                              placeholder='Values data will appear here automatically'>{{ old('values_json', json_encode($vision->values ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the values you add above.</div>
                                    @error('values_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Focus Areas Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                    Strategic Focus Areas
                                </h6>
                                <button type="button" class="btn-add" onclick="addFocusArea()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Focus Area
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="focus-areas-container">
                                    <!-- Focus areas will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="focus_areas_json" class="form-label">Focus Areas Data (JSON)</label>
                                    <textarea class="form-input @error('focus_areas_json') is-invalid @enderror" 
                                              id="focus_areas_json" name="focus_areas_json" rows="4" readonly
                                              placeholder='Focus areas data will appear here automatically'>{{ old('focus_areas_json', json_encode($vision->focus_areas ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the focus areas you add above.</div>
                                    @error('focus_areas_json')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Roadmap Section -->
                        <div class="dynamic-section">
                            <div class="dynamic-header">
                                <h6 style="margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                    </svg>
                                    Development Roadmap 2025-2030
                                </h6>
                                <button type="button" class="btn-add" onclick="addRoadmapPhase()">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Add Phase
                                </button>
                            </div>
                            <div class="dynamic-body">
                                <div id="roadmap-container">
                                    <!-- Roadmap phases will be added here dynamically -->
                                </div>
                                <div class="form-group" style="margin-top: 1rem;">
                                    <label for="roadmap_phases_json" class="form-label">Roadmap Data (JSON)</label>
                                    <textarea class="form-input @error('roadmap_phases_json') is-invalid @enderror" 
                                              id="roadmap_phases_json" name="roadmap_phases_json" rows="4" readonly
                                              placeholder='Roadmap data will appear here automatically'>{{ old('roadmap_phases_json', json_encode($vision->roadmap_phases ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                                    <div class="form-help">This field will be filled automatically based on the roadmap phases you add above.</div>
                                    @error('roadmap_phases_json')
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
                                <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', $vision->is_active) ? 'checked' : '' }}>
                                <label for="is_active" style="margin: 0; font-weight: normal;">
                                    Activate this vision & mission
                                </label>
                            </div>
                            <div class="form-help">The active vision & mission will be displayed on the public page</div>
                        </div>

                        <!-- Hero Section -->
                        <div class="form-group">
                            <label for="hero_title" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                </svg>
                                Hero Title
                            </label>
                            <input type="text" 
                                   name="hero_title" 
                                   id="hero_title" 
                                   class="form-input @error('hero_title') is-invalid @enderror" 
                                   value="{{ old('hero_title', $vision->hero_title) }}" 
                                   placeholder="Title for hero section...">
                            @error('hero_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="hero_subtitle" class="form-label">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Hero Subtitle
                            </label>
                            <textarea name="hero_subtitle" 
                                      id="hero_subtitle" 
                                      class="form-input @error('hero_subtitle') is-invalid @enderror" 
                                      rows="3"
                                      placeholder="Description for hero section...">{{ old('hero_subtitle', $vision->hero_subtitle) }}</textarea>
                            @error('hero_subtitle')
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
                            @if($vision->hero_image)
                                <img src="{{ asset($vision->hero_image) }}" alt="Current Hero Image" class="current-image">
                                <div class="form-help">Current image (will be replaced if you upload a new one)</div>
                            @endif
                            <input type="file" class="form-input @error('hero_image') is-invalid @enderror" 
                                   id="hero_image" name="hero_image" accept="image/*">
                            <div class="form-help">JPG, PNG, GIF. Max 10MB. Leave empty to keep current image.</div>
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
                                   value="{{ old('meta_title', $vision->meta_title) }}" 
                                   placeholder="Title for SEO...">
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
                                      placeholder="Description for SEO...">{{ old('meta_description', $vision->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('admin.vision.index') }}" class="btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Vision & Mission
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Global variables for management
let missionData = [];
let missionCounter = 0;
let goalsData = [];
let goalsCounter = 0;
let valuesData = [];
let valuesCounter = 0;
let focusAreasData = [];
let focusAreasCounter = 0;
let roadmapData = [];
let roadmapCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize data from existing vision
    initializeExistingData();

    // Form submission
    const form = document.getElementById('visionForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Update JSON fields before submission
        updateMissionJSON();
        updateGoalsJSON();
        updateValuesJSON();
        updateFocusAreasJSON();
        updateRoadmapJSON();
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <div class="spinner"></div>
            Updating...
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
                Update Vision & Mission
            `;
            form.classList.remove('loading');
            
            // Show error message
            alert('Please fill in all required fields.');
        }
    });
});

function initializeExistingData() {
    // Initialize mission items from existing data
    const existingMissions = @json($vision->mission_items ?? []);
    if (existingMissions && existingMissions.length > 0) {
        missionData = existingMissions.map((mission, index) => ({
            id: index + 1,
            title: mission.title || '',
            description: mission.description || '',
            icon: mission.icon || 'fas fa-bullseye'
        }));
        missionCounter = missionData.length;
        missionData.forEach(mission => {
            addMissionToDOM(mission);
        });
    }

    // Initialize goals from existing data
    const existingGoals = @json($vision->goals ?? []);
    if (existingGoals && existingGoals.length > 0) {
        goalsData = existingGoals.map((goal, index) => ({
            id: index + 1,
            title: goal.title || '',
            description: goal.description || '',
            icon: goal.icon || 'fas fa-bullseye',
            color: goal.color || 'primary'
        }));
        goalsCounter = goalsData.length;
        goalsData.forEach(goal => {
            addGoalToDOM(goal);
        });
    }

    // Initialize values from existing data
    const existingValues = @json($vision->values ?? []);
    if (existingValues && existingValues.length > 0) {
        valuesData = existingValues.map((value, index) => ({
            id: index + 1,
            title: value.title || '',
            description: value.description || '',
            icon: value.icon || 'fas fa-star',
            color: value.color || 'primary'
        }));
        valuesCounter = valuesData.length;
        valuesData.forEach(value => {
            addValueToDOM(value);
        });
    }

    // Initialize focus areas from existing data
    const existingFocusAreas = @json($vision->focus_areas ?? []);
    if (existingFocusAreas && existingFocusAreas.length > 0) {
        focusAreasData = existingFocusAreas.map((area, index) => ({
            id: index + 1,
            title: area.title || '',
            description: area.description || '',
            items: area.items || [],
            icon: area.icon || 'fas fa-bullseye',
            color: area.color || 'primary'
        }));
        focusAreasCounter = focusAreasData.length;
        focusAreasData.forEach(area => {
            addFocusAreaToDOM(area);
        });
    }

    // Initialize roadmap from existing data
    const existingRoadmap = @json($vision->roadmap_phases ?? []);
    if (existingRoadmap && existingRoadmap.length > 0) {
        roadmapData = existingRoadmap.map((phase, index) => ({
            id: index + 1,
            year: phase.year || '',
            title: phase.title || '',
            description: phase.description || '',
            target: phase.target || '',
            color: phase.color || 'primary',
            status: phase.status || 'planned'
        }));
        roadmapCounter = roadmapData.length;
        roadmapData.forEach(phase => {
            addRoadmapPhaseToDOM(phase);
        });
    }

    // Update JSON fields
    updateMissionJSON();
    updateGoalsJSON();
    updateValuesJSON();
    updateFocusAreasJSON();
    updateRoadmapJSON();
}

// Mission Management Functions
function addMissionItem() {
    const mission = {
        id: ++missionCounter,
        title: '',
        description: '',
        icon: 'fas fa-bullseye'
    };
    
    missionData.push(mission);
    addMissionToDOM(mission);
    updateMissionJSON();
}

function addMissionToDOM(mission) {
    const container = document.getElementById('mission-container');
    const missionDiv = document.createElement('div');
    missionDiv.className = 'dynamic-item';
    missionDiv.setAttribute('data-mission-id', mission.id);
    
    missionDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Mission #${mission.id}</h6>
            <button type="button" class="btn-remove" onclick="removeMission(${mission.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-item-body">
            <div class="form-group">
                <label class="form-label">Mission Title</label>
                <input type="text" class="form-input" value="${mission.title || ''}" 
                       onchange="updateMissionData(${mission.id}, 'title', this.value)" 
                       placeholder="Example: Provide quality education">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateMissionData(${mission.id}, 'description', this.value)" 
                          placeholder="Detailed mission description...">${mission.description || ''}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Icon</label>
                <select class="form-input" onchange="updateMissionData(${mission.id}, 'icon', this.value)">
                    <option value="fas fa-bullseye" ${(mission.icon || 'fas fa-bullseye') === 'fas fa-bullseye' ? 'selected' : ''}>Target</option>
                    <option value="fas fa-graduation-cap" ${mission.icon === 'fas fa-graduation-cap' ? 'selected' : ''}>Pendidikan</option>
                    <option value="fas fa-users" ${mission.icon === 'fas fa-users' ? 'selected' : ''}>Community</option>
                    <option value="fas fa-star" ${mission.icon === 'fas fa-star' ? 'selected' : ''}>Excellence</option>
                    <option value="fas fa-heart" ${mission.icon === 'fas fa-heart' ? 'selected' : ''}>Character</option>
                    <option value="fas fa-globe" ${mission.icon === 'fas fa-globe' ? 'selected' : ''}>Global</option>
                </select>
            </div>
        </div>
    `;
    
    container.appendChild(missionDiv);
}

function removeMission(missionId) {
    missionData = missionData.filter(mission => mission.id !== missionId);
    const missionDiv = document.querySelector(`[data-mission-id="${missionId}"]`);
    if (missionDiv) {
        missionDiv.remove();
    }
    updateMissionJSON();
}

function updateMissionData(missionId, field, value) {
    const mission = missionData.find(m => m.id === missionId);
    if (mission) {
        mission[field] = value;
        updateMissionJSON();
    }
}

function updateMissionJSON() {
    const jsonTextarea = document.getElementById('mission_items_json');
    jsonTextarea.value = JSON.stringify(missionData, null, 2);
}

// Goals Management Functions
function addGoal() {
    const goal = {
        id: ++goalsCounter,
        title: '',
        description: '',
        icon: 'fas fa-bullseye',
        color: 'primary'
    };
    
    goalsData.push(goal);
    addGoalToDOM(goal);
    updateGoalsJSON();
}

function addGoalToDOM(goal) {
    const container = document.getElementById('goals-container');
    const goalDiv = document.createElement('div');
    goalDiv.className = 'dynamic-item';
    goalDiv.setAttribute('data-goal-id', goal.id);
    
    goalDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Goal #${goal.id}</h6>
            <button type="button" class="btn-remove" onclick="removeGoal(${goal.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-item-body">
            <div class="form-group">
                <label class="form-label">Goal Title</label>
                <input type="text" class="form-input" value="${goal.title || ''}" 
                       onchange="updateGoalData(${goal.id}, 'title', this.value)" 
                       placeholder="Example: Academic Quality">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateGoalData(${goal.id}, 'description', this.value)" 
                          placeholder="Detailed goal description...">${goal.description || ''}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Icon</label>
                    <select class="form-input" onchange="updateGoalData(${goal.id}, 'icon', this.value)">
                        <option value="fas fa-bullseye" ${(goal.icon || 'fas fa-bullseye') === 'fas fa-bullseye' ? 'selected' : ''}>Target</option>
                        <option value="fas fa-graduation-cap" ${goal.icon === 'fas fa-graduation-cap' ? 'selected' : ''}>Academic</option>
                        <option value="fas fa-users" ${goal.icon === 'fas fa-users' ? 'selected' : ''}>Character</option>
                        <option value="fas fa-leaf" ${goal.icon === 'fas fa-leaf' ? 'selected' : ''}>Environment</option>
                        <option value="fas fa-globe" ${goal.icon === 'fas fa-globe' ? 'selected' : ''}>Global</option>
                        <option value="fas fa-medal" ${goal.icon === 'fas fa-medal' ? 'selected' : ''}>Achievement</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select class="form-input" onchange="updateGoalData(${goal.id}, 'color', this.value)">
                        <option value="primary" ${(goal.color || 'primary') === 'primary' ? 'selected' : ''}>Blue</option>
                        <option value="success" ${goal.color === 'success' ? 'selected' : ''}>Green</option>
                        <option value="warning" ${goal.color === 'warning' ? 'selected' : ''}>Yellow</option>
                        <option value="danger" ${goal.color === 'danger' ? 'selected' : ''}>Red</option>
                        <option value="info" ${goal.color === 'info' ? 'selected' : ''}>Cyan</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(goalDiv);
}

function removeGoal(goalId) {
    goalsData = goalsData.filter(goal => goal.id !== goalId);
    const goalDiv = document.querySelector(`[data-goal-id="${goalId}"]`);
    if (goalDiv) {
        goalDiv.remove();
    }
    updateGoalsJSON();
}

function updateGoalData(goalId, field, value) {
    const goal = goalsData.find(g => g.id === goalId);
    if (goal) {
        goal[field] = value;
        updateGoalsJSON();
    }
}

function updateGoalsJSON() {
    const jsonTextarea = document.getElementById('goals_json');
    jsonTextarea.value = JSON.stringify(goalsData, null, 2);
}

// Values Management Functions
function addValue() {
    const value = {
        id: ++valuesCounter,
        title: '',
        description: '',
        icon: 'fas fa-star',
        color: 'primary'
    };
    
    valuesData.push(value);
    addValueToDOM(value);
    updateValuesJSON();
}

function addValueToDOM(value) {
    const container = document.getElementById('values-container');
    const valueDiv = document.createElement('div');
    valueDiv.className = 'dynamic-item';
    valueDiv.setAttribute('data-value-id', value.id);
    
    valueDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Value #${value.id}</h6>
            <button type="button" class="btn-remove" onclick="removeValue(${value.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-item-body">
            <div class="form-group">
                <label class="form-label">Value Name</label>
                <input type="text" class="form-input" value="${value.title || ''}" 
                       onchange="updateValueData(${value.id}, 'title', this.value)" 
                       placeholder="Example: Integrity">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateValueData(${value.id}, 'description', this.value)" 
                          placeholder="Detailed value description...">${value.description || ''}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Icon</label>
                    <select class="form-input" onchange="updateValueData(${value.id}, 'icon', this.value)">
                        <option value="fas fa-star" ${(value.icon || 'fas fa-star') === 'fas fa-star' ? 'selected' : ''}>Star</option>
                        <option value="fas fa-heart" ${value.icon === 'fas fa-heart' ? 'selected' : ''}>Heart</option>
                        <option value="fas fa-lightbulb" ${value.icon === 'fas fa-lightbulb' ? 'selected' : ''}>Innovation</option>
                        <option value="fas fa-leaf" ${value.icon === 'fas fa-leaf' ? 'selected' : ''}>Environment</option>
                        <option value="fas fa-handshake" ${value.icon === 'fas fa-handshake' ? 'selected' : ''}>Cooperation</option>
                        <option value="fas fa-balance-scale" ${value.icon === 'fas fa-balance-scale' ? 'selected' : ''}>Justice</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select class="form-input" onchange="updateValueData(${value.id}, 'color', this.value)">
                        <option value="primary" ${(value.color || 'primary') === 'primary' ? 'selected' : ''}>Blue</option>
                        <option value="success" ${value.color === 'success' ? 'selected' : ''}>Green</option>
                        <option value="warning" ${value.color === 'warning' ? 'selected' : ''}>Yellow</option>
                        <option value="danger" ${value.color === 'danger' ? 'selected' : ''}>Red</option>
                        <option value="info" ${value.color === 'info' ? 'selected' : ''}>Cyan</option>
                    </select>
                </div>
            </div>
        </div>
    `;
    
    container.appendChild(valueDiv);
}

function removeValue(valueId) {
    valuesData = valuesData.filter(value => value.id !== valueId);
    const valueDiv = document.querySelector(`[data-value-id="${valueId}"]`);
    if (valueDiv) {
        valueDiv.remove();
    }
    updateValuesJSON();
}

function updateValueData(valueId, field, value) {
    const valueItem = valuesData.find(v => v.id === valueId);
    if (valueItem) {
        valueItem[field] = value;
        updateValuesJSON();
    }
}

function updateValuesJSON() {
    const jsonTextarea = document.getElementById('values_json');
    jsonTextarea.value = JSON.stringify(valuesData, null, 2);
}

// Focus Areas Management Functions
function addFocusArea() {
    const focusArea = {
        id: ++focusAreasCounter,
        title: '',
        description: '',
        items: [],
        icon: 'fas fa-bullseye',
        color: 'primary'
    };
    
    focusAreasData.push(focusArea);
    addFocusAreaToDOM(focusArea);
    updateFocusAreasJSON();
}

function addFocusAreaToDOM(focusArea) {
    const container = document.getElementById('focus-areas-container');
    const focusAreaDiv = document.createElement('div');
    focusAreaDiv.className = 'dynamic-item';
    focusAreaDiv.setAttribute('data-focus-area-id', focusArea.id);
    
    const itemsHtml = (focusArea.items || []).map((item, index) => 
        `<div class="focus-area-item" style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
            <input type="text" class="form-input" value="${item}" 
                   onchange="updateFocusAreaItem(${focusArea.id}, ${index}, this.value)" 
                   placeholder="Focus area item..." style="flex: 1;">
            <button type="button" class="btn-remove" style="padding: 0.375rem; font-size: 0.75rem;" 
                    onclick="removeFocusAreaItem(${focusArea.id}, ${index})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>`
    ).join('');
    
    focusAreaDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Focus Area #${focusArea.id}</h6>
            <button type="button" class="btn-remove" onclick="removeFocusArea(${focusArea.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-item-body">
            <div class="form-group">
                <label class="form-label">Focus Area Title</label>
                <input type="text" class="form-input" value="${focusArea.title || ''}" 
                       onchange="updateFocusAreaData(${focusArea.id}, 'title', this.value)" 
                       placeholder="Example: Learning Quality Improvement">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateFocusAreaData(${focusArea.id}, 'description', this.value)" 
                          placeholder="Detailed focus area description...">${focusArea.description || ''}</textarea>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Icon</label>
                    <select class="form-input" onchange="updateFocusAreaData(${focusArea.id}, 'icon', this.value)">
                        <option value="fas fa-bullseye" ${(focusArea.icon || 'fas fa-bullseye') === 'fas fa-bullseye' ? 'selected' : ''}>Target</option>
                        <option value="fas fa-brain" ${focusArea.icon === 'fas fa-brain' ? 'selected' : ''}>Learning</option>
                        <option value="fas fa-seedling" ${focusArea.icon === 'fas fa-seedling' ? 'selected' : ''}>Character</option>
                        <option value="fas fa-medal" ${focusArea.icon === 'fas fa-medal' ? 'selected' : ''}>Achievement</option>
                        <option value="fas fa-globe" ${focusArea.icon === 'fas fa-globe' ? 'selected' : ''}>Global</option>
                        <option value="fas fa-users" ${focusArea.icon === 'fas fa-users' ? 'selected' : ''}>Community</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select class="form-input" onchange="updateFocusAreaData(${focusArea.id}, 'color', this.value)">
                        <option value="primary" ${(focusArea.color || 'primary') === 'primary' ? 'selected' : ''}>Blue</option>
                        <option value="success" ${focusArea.color === 'success' ? 'selected' : ''}>Green</option>
                        <option value="warning" ${focusArea.color === 'warning' ? 'selected' : ''}>Yellow</option>
                        <option value="danger" ${focusArea.color === 'danger' ? 'selected' : ''}>Red</option>
                        <option value="info" ${focusArea.color === 'info' ? 'selected' : ''}>Cyan</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Focus Area Items</label>
                <div id="focus-area-items-${focusArea.id}">
                    ${itemsHtml}
                </div>
                <button type="button" class="btn-add" style="margin-top: 0.5rem; padding: 0.5rem 1rem; font-size: 0.75rem;" 
                        onclick="addFocusAreaItem(${focusArea.id})">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Item
                </button>
            </div>
        </div>
    `;
    
    container.appendChild(focusAreaDiv);
}

function removeFocusArea(focusAreaId) {
    focusAreasData = focusAreasData.filter(area => area.id !== focusAreaId);
    const focusAreaDiv = document.querySelector(`[data-focus-area-id="${focusAreaId}"]`);
    if (focusAreaDiv) {
        focusAreaDiv.remove();
    }
    updateFocusAreasJSON();
}

function updateFocusAreaData(focusAreaId, field, value) {
    const focusArea = focusAreasData.find(a => a.id === focusAreaId);
    if (focusArea) {
        focusArea[field] = value;
        updateFocusAreasJSON();
    }
}

function addFocusAreaItem(focusAreaId) {
    const focusArea = focusAreasData.find(a => a.id === focusAreaId);
    if (focusArea) {
        if (!focusArea.items) focusArea.items = [];
        focusArea.items.push('');
        
        // Refresh the DOM
        const focusAreaDiv = document.querySelector(`[data-focus-area-id="${focusAreaId}"]`);
        if (focusAreaDiv) {
            focusAreaDiv.remove();
            addFocusAreaToDOM(focusArea);
        }
        updateFocusAreasJSON();
    }
}

function removeFocusAreaItem(focusAreaId, itemIndex) {
    const focusArea = focusAreasData.find(a => a.id === focusAreaId);
    if (focusArea && focusArea.items) {
        focusArea.items.splice(itemIndex, 1);
        
        // Refresh the DOM
        const focusAreaDiv = document.querySelector(`[data-focus-area-id="${focusAreaId}"]`);
        if (focusAreaDiv) {
            focusAreaDiv.remove();
            addFocusAreaToDOM(focusArea);
        }
        updateFocusAreasJSON();
    }
}

function updateFocusAreaItem(focusAreaId, itemIndex, value) {
    const focusArea = focusAreasData.find(a => a.id === focusAreaId);
    if (focusArea && focusArea.items && focusArea.items[itemIndex] !== undefined) {
        focusArea.items[itemIndex] = value;
        updateFocusAreasJSON();
    }
}

function updateFocusAreasJSON() {
    const jsonTextarea = document.getElementById('focus_areas_json');
    jsonTextarea.value = JSON.stringify(focusAreasData, null, 2);
}

// Roadmap Management Functions
function addRoadmapPhase() {
    const phase = {
        id: ++roadmapCounter,
        year: '',
        title: '',
        description: '',
        target: '',
        color: 'primary',
        status: 'planned'
    };
    
    roadmapData.push(phase);
    addRoadmapPhaseToDOM(phase);
    updateRoadmapJSON();
}

function addRoadmapPhaseToDOM(phase) {
    const container = document.getElementById('roadmap-container');
    const phaseDiv = document.createElement('div');
    phaseDiv.className = 'dynamic-item';
    phaseDiv.setAttribute('data-roadmap-id', phase.id);
    
    phaseDiv.innerHTML = `
        <div class="dynamic-item-header">
            <h6 style="margin: 0; font-size: 0.875rem;">Phase #${phase.id}</h6>
            <button type="button" class="btn-remove" onclick="removeRoadmapPhase(${phase.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-item-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                <div class="form-group">
                    <label class="form-label">Year</label>
                    <input type="text" class="form-input" value="${phase.year || ''}" 
                           onchange="updateRoadmapData(${phase.id}, 'year', this.value)" 
                           placeholder="Example: 2025 or 2025-2026">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select class="form-input" onchange="updateRoadmapData(${phase.id}, 'status', this.value)">
                        <option value="planned" ${(phase.status || 'planned') === 'planned' ? 'selected' : ''}>Planned</option>
                        <option value="in_progress" ${phase.status === 'in_progress' ? 'selected' : ''}>Sedang Berlangsung</option>
                        <option value="completed" ${phase.status === 'completed' ? 'selected' : ''}>Selesai</option>
                        <option value="delayed" ${phase.status === 'delayed' ? 'selected' : ''}>Delayed</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Phase Title</label>
                <input type="text" class="form-input" value="${phase.title || ''}" 
                       onchange="updateRoadmapData(${phase.id}, 'title', this.value)" 
                       placeholder="Example: Consolidation Phase">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-input" rows="3" 
                          onchange="updateRoadmapData(${phase.id}, 'description', this.value)" 
                          placeholder="Detailed phase description...">${phase.description || ''}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Target/Achievement</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateRoadmapData(${phase.id}, 'target', this.value)" 
                          placeholder="Target to achieve in this phase...">${phase.target || ''}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Timeline Color</label>
                <select class="form-input" onchange="updateRoadmapData(${phase.id}, 'color', this.value)">
                    <option value="primary" ${(phase.color || 'primary') === 'primary' ? 'selected' : ''}>Blue</option>
                    <option value="success" ${phase.color === 'success' ? 'selected' : ''}>Green</option>
                    <option value="warning" ${phase.color === 'warning' ? 'selected' : ''}>Yellow</option>
                    <option value="danger" ${phase.color === 'danger' ? 'selected' : ''}>Red</option>
                    <option value="info" ${phase.color === 'info' ? 'selected' : ''}>Cyan</option>
                    <option value="secondary" ${phase.color === 'secondary' ? 'selected' : ''}>Gray</option>
                </select>
            </div>
        </div>
    `;
    
    container.appendChild(phaseDiv);
}

function removeRoadmapPhase(phaseId) {
    roadmapData = roadmapData.filter(phase => phase.id !== phaseId);
    const phaseDiv = document.querySelector(`[data-roadmap-id="${phaseId}"]`);
    if (phaseDiv) {
        phaseDiv.remove();
    }
    updateRoadmapJSON();
}

function updateRoadmapData(phaseId, field, value) {
    const phase = roadmapData.find(p => p.id === phaseId);
    if (phase) {
        phase[field] = value;
        updateRoadmapJSON();
    }
}

function updateRoadmapJSON() {
    const jsonTextarea = document.getElementById('roadmap_phases_json');
    jsonTextarea.value = JSON.stringify(roadmapData, null, 2);
}
</script>
@endsection