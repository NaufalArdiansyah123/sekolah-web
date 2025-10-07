@extends('layouts.admin')

@section('title', 'Edit Study Program')

@section('content')
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
    .edit-page {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
    }

    /* Header Section */
    .page-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        border-radius: 12px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(30%, -30%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translate(30%, -30%) rotate(0deg); }
        50% { transform: translate(35%, -25%) rotate(180deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 700;
        margin: 0 0 0.5rem 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin: 0;
    }

    .back-button {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .back-button:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Form Sections */
    .form-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
        animation: slideUp 0.5s ease-out;
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

    .section-header {
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        color: white;
        padding: 1rem 1.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-body {
        padding: 1.5rem;
    }

    /* Form Elements */
    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .required {
        color: var(--danger-color);
    }

    .form-input {
        width: 100%;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.75rem;
        font-size: 0.875rem;
        background: var(--bg-primary);
        color: var(--text-primary);
        transition: border-color 0.15s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: var(--accent-color);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-input.is-invalid {
        border-color: var(--danger-color);
    }

    .invalid-feedback {
        color: var(--danger-color);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .form-help {
        color: var(--text-secondary);
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    /* Grid Layout */
    .form-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 1.5rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
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
        background: var(--accent-color);
        color: white;
    }

    .btn-primary:hover {
        background: var(--accent-hover);
        color: white;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
    }

    .btn-block {
        width: 100%;
        justify-content: center;
    }

    /* Sidebar */
    .sidebar-section {
        background: var(--bg-primary);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        margin-bottom: 1rem;
        overflow: hidden;
        box-shadow: 0 1px 3px var(--shadow-color);
    }

    .sidebar-header {
        background: var(--bg-tertiary);
        padding: 0.75rem 1rem;
        font-weight: 600;
        font-size: 0.875rem;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-body {
        padding: 1rem;
    }

    /* Checkbox */
    .checkbox-group {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .checkbox-input {
        margin-top: 0.125rem;
    }

    .checkbox-label {
        font-size: 0.875rem;
        color: var(--text-primary);
        line-height: 1.4;
    }

    /* Image Preview */
    .image-preview {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
        background: var(--bg-secondary);
    }

    .image-preview img {
        max-width: 100%;
        max-height: 150px;
        border-radius: 6px;
        box-shadow: 0 2px 8px var(--shadow-color);
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-danger {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .alert ul {
        margin: 0;
        padding-left: 1rem;
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

    /* Dynamic Sections */
    .dynamic-section {
        border: 1px solid var(--border-color);
        border-radius: 8px;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.3s ease;
        background: var(--bg-primary);
    }

    .dynamic-section:hover {
        border-color: var(--accent-color);
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.1);
    }

    .dynamic-header {
        background: var(--bg-tertiary);
        padding: 0.75rem 1rem;
        border-bottom: 1px solid var(--border-color);
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .dynamic-body {
        padding: 1rem;
        background: var(--bg-primary);
    }

    .btn-add {
        background: linear-gradient(135deg, #10b981, #059669);
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

    .btn-add:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-remove {
        background: linear-gradient(135deg, #ef4444, #dc2626);
        color: white;
        border: none;
        border-radius: 4px;
        padding: 0.25rem 0.5rem;
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
        box-shadow: 0 2px 6px rgba(239, 68, 68, 0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .edit-page {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .section-body {
            padding: 1rem;
        }
    }
</style>

<div class="edit-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h1 class="page-title">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                        Edit Study Program
                    </h1>
                    <p class="page-subtitle">Update program information for {{ $studyProgram->program_name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.study-programs.index') }}" class="back-button">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if($errors->any())
        <div class="alert alert-danger">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>There were errors with your submission:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.study-programs.update', $studyProgram) }}" method="POST" enctype="multipart/form-data" id="studyProgramForm">
        @csrf
        @method('PUT')
        
        <div class="form-grid">
            <!-- Main Content -->
            <div>
                <!-- Basic Information -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Basic Information
                    </div>
                    <div class="section-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="program_name" class="form-label">Program Name <span class="required">*</span></label>
                                <input type="text" class="form-input @error('program_name') is-invalid @enderror" 
                                       id="program_name" name="program_name" value="{{ old('program_name', $studyProgram->program_name) }}" required>
                                @error('program_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="program_code" class="form-label">Program Code</label>
                                <input type="text" class="form-input @error('program_code') is-invalid @enderror" 
                                       id="program_code" name="program_code" value="{{ old('program_code', $studyProgram->program_code) }}" 
                                       placeholder="e.g., TI, SI, MI">
                                @error('program_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Program Description</label>
                            <textarea class="form-input @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Brief description about the program...">{{ old('description', $studyProgram->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="degree_level" class="form-label">Degree Level <span class="required">*</span></label>
                                <select class="form-input @error('degree_level') is-invalid @enderror" 
                                        id="degree_level" name="degree_level" required>
                                    <option value="">Select Degree Level</option>
                                    <option value="D3" {{ old('degree_level', $studyProgram->degree_level) === 'D3' ? 'selected' : '' }}>D3 (Diploma)</option>
                                    <option value="S1" {{ old('degree_level', $studyProgram->degree_level) === 'S1' ? 'selected' : '' }}>S1 (Bachelor)</option>
                                    <option value="S2" {{ old('degree_level', $studyProgram->degree_level) === 'S2' ? 'selected' : '' }}>S2 (Master)</option>
                                    <option value="S3" {{ old('degree_level', $studyProgram->degree_level) === 'S3' ? 'selected' : '' }}>S3 (Doctoral)</option>
                                </select>
                                @error('degree_level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="faculty" class="form-label">Faculty/Department</label>
                                <input type="text" class="form-input @error('faculty') is-invalid @enderror" 
                                       id="faculty" name="faculty" value="{{ old('faculty', $studyProgram->faculty) }}" 
                                       placeholder="Faculty of Engineering">
                                @error('faculty')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Vision & Mission -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Vision & Mission
                    </div>
                    <div class="section-body">
                        <div class="form-group">
                            <label for="vision" class="form-label">Vision</label>
                            <textarea class="form-input @error('vision') is-invalid @enderror" 
                                      id="vision" name="vision" rows="3" 
                                      placeholder="Program vision...">{{ old('vision', $studyProgram->vision) }}</textarea>
                            @error('vision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mission" class="form-label">Mission</label>
                            <textarea class="form-input @error('mission') is-invalid @enderror" 
                                      id="mission" name="mission" rows="4" 
                                      placeholder="Program mission...">{{ old('mission', $studyProgram->mission) }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Career & Admission -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2V6"/>
                        </svg>
                        Career & Admission
                    </div>
                    <div class="section-body">
                        <div class="form-group">
                            <label for="career_prospects" class="form-label">Career Prospects</label>
                            <textarea class="form-input @error('career_prospects') is-invalid @enderror" 
                                      id="career_prospects" name="career_prospects" rows="4" 
                                      placeholder="Career opportunities for graduates...">{{ old('career_prospects', $studyProgram->career_prospects) }}</textarea>
                            @error('career_prospects')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="admission_requirements" class="form-label">Admission Requirements</label>
                            <textarea class="form-input @error('admission_requirements') is-invalid @enderror" 
                                      id="admission_requirements" name="admission_requirements" rows="4" 
                                      placeholder="Requirements for admission...">{{ old('admission_requirements', $studyProgram->admission_requirements) }}</textarea>
                            @error('admission_requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Core Subjects Section -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        Core Subjects
                        <button type="button" class="btn btn-primary" onclick="addSubject()" style="margin-left: auto; padding: 0.5rem 1rem; font-size: 0.75rem;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Subject
                        </button>
                    </div>
                    <div class="section-body">
                        <div id="subjects-container">
                            <!-- Subjects will be added here dynamically -->
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label for="core_subjects_json" class="form-label">Core Subjects Data (JSON)</label>
                            <textarea class="form-input @error('core_subjects_json') is-invalid @enderror" 
                                      id="core_subjects_json" name="core_subjects_json" rows="4" readonly
                                      placeholder='Subjects data will appear here automatically'>{{ old('core_subjects_json', json_encode($studyProgram->core_subjects ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                            <div class="form-help">This field will be filled automatically based on the subjects you add above.</div>
                            @error('core_subjects_json')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Specializations Section -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Specializations
                        <button type="button" class="btn btn-primary" onclick="addSpecialization()" style="margin-left: auto; padding: 0.5rem 1rem; font-size: 0.75rem;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Specialization
                        </button>
                    </div>
                    <div class="section-body">
                        <div id="specializations-container">
                            <!-- Specializations will be added here dynamically -->
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label for="specializations_json" class="form-label">Specializations Data (JSON)</label>
                            <textarea class="form-input @error('specializations_json') is-invalid @enderror" 
                                      id="specializations_json" name="specializations_json" rows="4" readonly
                                      placeholder='Specializations data will appear here automatically'>{{ old('specializations_json', json_encode($studyProgram->specializations ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                            <div class="form-help">This field will be filled automatically based on the specializations you add above.</div>
                            @error('specializations_json')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Facilities Section -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H9m0 0H5m0 0h2M7 7h3m3 0h3M7 11h3m3 0h3m-6 4h3"/>
                        </svg>
                        Program Facilities
                        <button type="button" class="btn btn-primary" onclick="addFacility()" style="margin-left: auto; padding: 0.5rem 1rem; font-size: 0.75rem;">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Add Facility
                        </button>
                    </div>
                    <div class="section-body">
                        <div id="facilities-container">
                            <!-- Facilities will be added here dynamically -->
                        </div>
                        <div class="form-group" style="margin-top: 1rem;">
                            <label for="facilities_json" class="form-label">Facilities Data (JSON)</label>
                            <textarea class="form-input @error('facilities_json') is-invalid @enderror" 
                                      id="facilities_json" name="facilities_json" rows="4" readonly
                                      placeholder='Facilities data will appear here automatically'>{{ old('facilities_json', json_encode($studyProgram->facilities ?? [], JSON_PRETTY_PRINT)) }}</textarea>
                            <div class="form-help">This field will be filled automatically based on the facilities you add above.</div>
                            @error('facilities_json')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Settings -->
                <div class="sidebar-section">
                    <div class="sidebar-header">Settings</div>
                    <div class="sidebar-body">
                        <div class="checkbox-group" style="margin-bottom: 1rem;">
                            <input type="checkbox" class="checkbox-input" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $studyProgram->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="checkbox-label">
                                <strong>Activate this program</strong><br>
                                <small>Active programs will be displayed on the public page</small>
                            </label>
                        </div>
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input" id="is_featured" name="is_featured" value="1" 
                                   {{ old('is_featured', $studyProgram->is_featured) ? 'checked' : '' }}>
                            <label for="is_featured" class="checkbox-label">
                                <strong>Feature this program</strong><br>
                                <small>Featured programs will be highlighted</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Academic Details -->
                <div class="sidebar-section">
                    <div class="sidebar-header">Academic Details</div>
                    <div class="sidebar-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="duration_years" class="form-label">Duration (Years)</label>
                                <input type="number" class="form-input @error('duration_years') is-invalid @enderror" 
                                       id="duration_years" name="duration_years" value="{{ old('duration_years', $studyProgram->duration_years) }}" 
                                       min="1" max="10">
                                @error('duration_years')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="total_credits" class="form-label">Total Credits</label>
                                <input type="number" class="form-input @error('total_credits') is-invalid @enderror" 
                                       id="total_credits" name="total_credits" value="{{ old('total_credits', $studyProgram->total_credits) }}" 
                                       min="1">
                                @error('total_credits')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="degree_title" class="form-label">Degree Title</label>
                            <input type="text" class="form-input @error('degree_title') is-invalid @enderror" 
                                   id="degree_title" name="degree_title" value="{{ old('degree_title', $studyProgram->degree_title) }}" 
                                   placeholder="S.Kom, S.T, S.E">
                            @error('degree_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="accreditation" class="form-label">Accreditation</label>
                            <select class="form-input @error('accreditation') is-invalid @enderror" 
                                    id="accreditation" name="accreditation">
                                <option value="">Select Accreditation</option>
                                <option value="A" {{ old('accreditation', $studyProgram->accreditation) === 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                <option value="B" {{ old('accreditation', $studyProgram->accreditation) === 'B' ? 'selected' : '' }}>B (Good)</option>
                                <option value="C" {{ old('accreditation', $studyProgram->accreditation) === 'C' ? 'selected' : '' }}>C (Fair)</option>
                            </select>
                            @error('accreditation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Admission & Costs -->
                <div class="sidebar-section">
                    <div class="sidebar-header">Admission & Costs</div>
                    <div class="sidebar-body">
                        <div class="form-group">
                            <label for="capacity" class="form-label">Student Capacity</label>
                            <input type="number" class="form-input @error('capacity') is-invalid @enderror" 
                                   id="capacity" name="capacity" value="{{ old('capacity', $studyProgram->capacity) }}" 
                                   min="1">
                            @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tuition_fee" class="form-label">Tuition Fee (per semester)</label>
                            <input type="number" class="form-input @error('tuition_fee') is-invalid @enderror" 
                                   id="tuition_fee" name="tuition_fee" value="{{ old('tuition_fee', $studyProgram->tuition_fee) }}" 
                                   min="0">
                            @error('tuition_fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Current Images -->
                @if($studyProgram->program_image)
                    <div class="sidebar-section">
                        <div class="sidebar-header">Current Program Image</div>
                        <div class="sidebar-body">
                            <div class="image-preview">
                                <img src="{{ asset($studyProgram->program_image) }}" alt="Current Program Image">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Media Upload -->
                <div class="sidebar-section">
                    <div class="sidebar-header">Media Upload</div>
                    <div class="sidebar-body">
                        <div class="form-group">
                            <label for="program_image" class="form-label">Program Image {{ $studyProgram->program_image ? '(Replace)' : '' }}</label>
                            <input type="file" class="form-input @error('program_image') is-invalid @enderror" 
                                   id="program_image" name="program_image" accept="image/*">
                            <div class="form-help">JPG, PNG, GIF. Max 5MB.</div>
                            @error('program_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="brochure_file" class="form-label">Program Brochure {{ $studyProgram->brochure_file ? '(Replace)' : '' }}</label>
                            <input type="file" class="form-input @error('brochure_file') is-invalid @enderror" 
                                   id="brochure_file" name="brochure_file" accept=".pdf,.doc,.docx">
                            <div class="form-help">PDF, DOC, DOCX. Max 10MB.</div>
                            @error('brochure_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="sidebar-section">
                    <div class="sidebar-body">
                        <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Program
                        </button>
                        <a href="{{ route('admin.study-programs.index') }}" class="btn btn-secondary btn-block" style="margin-top: 0.5rem;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
    // Initialize from existing data
    const subjectsJsonTextarea = document.getElementById('core_subjects_json');
    if (subjectsJsonTextarea.value && subjectsJsonTextarea.value !== '[]') {
        try {
            subjectsData = JSON.parse(subjectsJsonTextarea.value);
            subjectsData.forEach((subject, index) => {
                subject.id = subject.id || (index + 1);
                subjectCounter = Math.max(subjectCounter, subject.id);
                addSubjectToDOM(subject);
            });
        } catch (e) {
            console.error('Error parsing existing subjects JSON:', e);
            subjectsData = [];
        }
    }

    const specializationsJsonTextarea = document.getElementById('specializations_json');
    if (specializationsJsonTextarea.value && specializationsJsonTextarea.value !== '[]') {
        try {
            specializationsData = JSON.parse(specializationsJsonTextarea.value);
            specializationsData.forEach((specialization, index) => {
                specialization.id = specialization.id || (index + 1);
                specializationCounter = Math.max(specializationCounter, specialization.id);
                addSpecializationToDOM(specialization);
            });
        } catch (e) {
            console.error('Error parsing existing specializations JSON:', e);
            specializationsData = [];
        }
    }

    const facilitiesJsonTextarea = document.getElementById('facilities_json');
    if (facilitiesJsonTextarea.value && facilitiesJsonTextarea.value !== '[]') {
        try {
            facilitiesData = JSON.parse(facilitiesJsonTextarea.value);
            facilitiesData.forEach((facility, index) => {
                facility.id = facility.id || (index + 1);
                facilityCounter = Math.max(facilityCounter, facility.id);
                addFacilityToDOM(facility);
            });
        } catch (e) {
            console.error('Error parsing existing facilities JSON:', e);
            facilitiesData = [];
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
                Update Program
            `;
            form.classList.remove('loading');
            
            // Show error message
            alert('Please fill in all required fields.');
        }
    });
});

// Subjects Management Functions
function addSubject() {
    const subject = {
        id: ++subjectCounter,
        name: '',
        code: '',
        credits: '',
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
    subjectDiv.className = 'dynamic-section';
    subjectDiv.setAttribute('data-subject-id', subject.id);
    
    subjectDiv.innerHTML = `
        <div class="dynamic-header">
            <span>Subject #${subject.id}</span>
            <button type="button" class="btn-remove" onclick="removeSubject(${subject.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-body">
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Subject Name</label>
                    <input type="text" class="form-input" value="${subject.name || ''}" 
                           onchange="updateSubjectData(${subject.id}, 'name', this.value)" 
                           placeholder="Programming Fundamentals">
                </div>
                <div class="form-group">
                    <label class="form-label">Subject Code</label>
                    <input type="text" class="form-input" value="${subject.code || ''}" 
                           onchange="updateSubjectData(${subject.id}, 'code', this.value)" 
                           placeholder="CS101">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Credits</label>
                    <input type="number" class="form-input" value="${subject.credits || ''}" 
                           onchange="updateSubjectData(${subject.id}, 'credits', this.value)" 
                           placeholder="3" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Semester</label>
                    <input type="number" class="form-input" value="${subject.semester || ''}" 
                           onchange="updateSubjectData(${subject.id}, 'semester', this.value)" 
                           placeholder="1" min="1">
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateSubjectData(${subject.id}, 'description', this.value)" 
                          placeholder="Brief description of the subject...">${subject.description || ''}</textarea>
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
    specializationDiv.className = 'dynamic-section';
    specializationDiv.setAttribute('data-specialization-id', specialization.id);
    
    specializationDiv.innerHTML = `
        <div class="dynamic-header">
            <span>Specialization #${specialization.id}</span>
            <button type="button" class="btn-remove" onclick="removeSpecialization(${specialization.id})">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1-1H8a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Remove
            </button>
        </div>
        <div class="dynamic-body">
            <div class="form-group">
                <label class="form-label">Specialization Name</label>
                <input type="text" class="form-input" value="${specialization.name || ''}" 
                       onchange="updateSpecializationData(${specialization.id}, 'name', this.value)" 
                       placeholder="Web Development, Mobile Development, etc.">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateSpecializationData(${specialization.id}, 'description', this.value)" 
                          placeholder="Brief description of the specialization...">${specialization.description || ''}</textarea>
            </div>
            <div class="form-group">
                <label class="form-label">Requirements</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateSpecializationData(${specialization.id}, 'requirements', this.value)" 
                          placeholder="Prerequisites or requirements...">${specialization.requirements || ''}</textarea>
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
    facilityDiv.setAttribute('data-facility-id', facility.id);
    
    facilityDiv.innerHTML = `
        <div class="dynamic-header">
            <span>Facility #${facility.id}</span>
            <button type="button" class="btn-remove" onclick="removeFacility(${facility.id})">
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
                       onchange="updateFacilityData(${facility.id}, 'name', this.value)" 
                       placeholder="Computer Lab, Library, etc.">
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <textarea class="form-input" rows="2" 
                          onchange="updateFacilityData(${facility.id}, 'description', this.value)" 
                          placeholder="Brief description of the facility...">${facility.description || ''}</textarea>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Icon Class</label>
                    <select class="form-input" onchange="updateFacilityData(${facility.id}, 'icon', this.value)">
                        <option value="fas fa-building" ${(facility.icon || 'fas fa-building') === 'fas fa-building' ? 'selected' : ''}>Building</option>
                        <option value="fas fa-book" ${facility.icon === 'fas fa-book' ? 'selected' : ''}>Library</option>
                        <option value="fas fa-microscope" ${facility.icon === 'fas fa-microscope' ? 'selected' : ''}>Laboratory</option>
                        <option value="fas fa-desktop" ${facility.icon === 'fas fa-desktop' ? 'selected' : ''}>Computer Lab</option>
                        <option value="fas fa-wifi" ${facility.icon === 'fas fa-wifi' ? 'selected' : ''}>Internet</option>
                        <option value="fas fa-video" ${facility.icon === 'fas fa-video' ? 'selected' : ''}>Multimedia</option>
                        <option value="fas fa-tools" ${facility.icon === 'fas fa-tools' ? 'selected' : ''}>Workshop</option>
                        <option value="fas fa-chalkboard-teacher" ${facility.icon === 'fas fa-chalkboard-teacher' ? 'selected' : ''}>Classroom</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Color</label>
                    <select class="form-input" onchange="updateFacilityData(${facility.id}, 'color', this.value)">
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
@endsection