@extends('layouts.admin')

@section('title', 'Edit School Profile')

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

    /* Dynamic Facility Sections */
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
                        Edit School Profile
                    </h1>
                    <p class="page-subtitle">Update profile information for {{ $schoolProfile->school_name }}</p>
                </div>
                <div>
                    <a href="{{ route('admin.school-profile.index') }}" class="back-button">
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

    <form action="{{ route('admin.school-profile.update', $schoolProfile) }}" method="POST" enctype="multipart/form-data" id="schoolProfileForm">
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
                                <label for="school_name" class="form-label">School Name <span class="required">*</span></label>
                                <input type="text" class="form-input @error('school_name') is-invalid @enderror" 
                                       id="school_name" name="school_name" value="{{ old('school_name', $schoolProfile->school_name) }}" required>
                                @error('school_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="school_motto" class="form-label">School Motto</label>
                                <input type="text" class="form-input @error('school_motto') is-invalid @enderror" 
                                       id="school_motto" name="school_motto" value="{{ old('school_motto', $schoolProfile->school_motto) }}" 
                                       placeholder="Excellence in Education">
                                @error('school_motto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="about_description" class="form-label">About Description</label>
                            <textarea class="form-input @error('about_description') is-invalid @enderror" 
                                      id="about_description" name="about_description" rows="4" 
                                      placeholder="Brief description about the school...">{{ old('about_description', $schoolProfile->about_description) }}</textarea>
                            @error('about_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="established_year" class="form-label">Established Year</label>
                                <input type="number" class="form-input @error('established_year') is-invalid @enderror" 
                                       id="established_year" name="established_year" value="{{ old('established_year', $schoolProfile->established_year) }}" 
                                       min="1900" max="{{ date('Y') }}">
                                @error('established_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="accreditation" class="form-label">Accreditation</label>
                                <select class="form-input @error('accreditation') is-invalid @enderror" 
                                        id="accreditation" name="accreditation">
                                    <option value="">Select Accreditation</option>
                                    <option value="A" {{ old('accreditation', $schoolProfile->accreditation) === 'A' ? 'selected' : '' }}>A (Excellent)</option>
                                    <option value="B" {{ old('accreditation', $schoolProfile->accreditation) === 'B' ? 'selected' : '' }}>B (Good)</option>
                                    <option value="C" {{ old('accreditation', $schoolProfile->accreditation) === 'C' ? 'selected' : '' }}>C (Fair)</option>
                                </select>
                                @error('accreditation')
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
                                      placeholder="School vision...">{{ old('vision', $schoolProfile->vision) }}</textarea>
                            @error('vision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mission" class="form-label">Mission</label>
                            <textarea class="form-input @error('mission') is-invalid @enderror" 
                                      id="mission" name="mission" rows="4" 
                                      placeholder="School mission...">{{ old('mission', $schoolProfile->mission) }}</textarea>
                            @error('mission')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="history" class="form-label">Brief History</label>
                            <textarea class="form-input @error('history') is-invalid @enderror" 
                                      id="history" name="history" rows="4" 
                                      placeholder="Brief history of the school...">{{ old('history', $schoolProfile->history) }}</textarea>
                            @error('history')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Leadership -->
               

                <!-- Contact Information -->
                <div class="form-section">
                    <div class="section-header">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Contact Information
                    </div>
                    <div class="section-body">
                        <div class="form-group">
                            <label for="address" class="form-label">Alamat</label>
                            <textarea class="form-input @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" 
                                      placeholder="School address...">{{ old('address', $schoolProfile->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="phone" class="form-label">Telepon</label>
                                <input type="text" class="form-input @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $schoolProfile->phone) }}" 
                                       placeholder="(021) 1234567">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-input @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $schoolProfile->email) }}" 
                                       placeholder="info@school.edu">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="website" class="form-label">Website</label>
                            <input type="url" class="form-input @error('website') is-invalid @enderror" 
                                   id="website" name="website" value="{{ old('website', $schoolProfile->website) }}" 
                                   placeholder="https://www.school.edu">
                            @error('website')
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
                        School Facilities
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
                                      placeholder='Facilities data will appear here automatically'>{{ old('facilities_json', json_encode($schoolProfile->facilities ?? [], JSON_PRETTY_PRINT)) }}</textarea>
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
                    <div class="sidebar-header">Pengaturan</div>
                    <div class="sidebar-body">
                        <div class="checkbox-group">
                            <input type="checkbox" class="checkbox-input" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $schoolProfile->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="checkbox-label">
                                <strong>Activate this profile</strong><br>
                                <small>The active profile will be displayed on the public page</small>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Current Images -->
                @if($schoolProfile->school_logo)
                    <div class="sidebar-section">
                        <div class="sidebar-header">Current Logo</div>
                        <div class="sidebar-body">
                            <div class="image-preview">
                                <img src="{{ asset($schoolProfile->school_logo) }}" alt="Current Logo">
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Media Upload -->
                <div class="sidebar-section">
                    <div class="sidebar-header">Media Upload</div>
                    <div class="sidebar-body">
                        

                       

                        

                        @if($schoolProfile->hero_image)
                            <div class="image-preview">
                                <label class="form-label">Current Hero Image:</label>
                                <img src="{{ asset($schoolProfile->hero_image) }}" alt="Current Hero Image">
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="hero_image" class="form-label">Hero Image {{ $schoolProfile->hero_image ? '(Replace)' : '' }}</label>
                            <input type="file" class="form-input @error('hero_image') is-invalid @enderror" 
                                   id="hero_image" name="hero_image" accept="image/*">
                            <div class="form-help">Main image for profile page. Max 10MB.</div>
                            @error('hero_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="sidebar-section">
                    <div class="sidebar-header">Statistics</div>
                    <div class="sidebar-body">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="student_count" class="form-label">Siswa</label>
                                <input type="number" class="form-input @error('student_count') is-invalid @enderror" 
                                       id="student_count" name="student_count" value="{{ old('student_count', $schoolProfile->student_count ?? 0) }}" min="0">
                                @error('student_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="teacher_count" class="form-label">Guru</label>
                                <input type="number" class="form-input @error('teacher_count') is-invalid @enderror" 
                                       id="teacher_count" name="teacher_count" value="{{ old('teacher_count', $schoolProfile->teacher_count ?? 0) }}" min="0">
                                @error('teacher_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="staff_count" class="form-label">Staf</label>
                                <input type="number" class="form-input @error('staff_count') is-invalid @enderror" 
                                       id="staff_count" name="staff_count" value="{{ old('staff_count', $schoolProfile->staff_count ?? 0) }}" min="0">
                                @error('staff_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="industry_partnerships" class="form-label">Partnerships</label>
                                <input type="number" class="form-input @error('industry_partnerships') is-invalid @enderror" 
                                       id="industry_partnerships" name="industry_partnerships" value="{{ old('industry_partnerships', $schoolProfile->industry_partnerships ?? 0) }}" min="0">
                                @error('industry_partnerships')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
                            Update Profile
                        </button>
                        <a href="{{ route('admin.school-profile.index') }}" class="btn btn-secondary btn-block" style="margin-top: 0.5rem;">
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
// Global variables for facilities management
let facilitiesData = [];
let facilityCounter = 0;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize facilities from existing data
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
    const form = document.getElementById('schoolProfileForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Update facilities JSON before submission
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
                Update Profile
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
                       placeholder="Library, Laboratory, etc.">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi</label>
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
                        <option value="fas fa-dumbbell" ${facility.icon === 'fas fa-dumbbell' ? 'selected' : ''}>Gym</option>
                        <option value="fas fa-music" ${facility.icon === 'fas fa-music' ? 'selected' : ''}>Music Room</option>
                        <option value="fas fa-desktop" ${facility.icon === 'fas fa-desktop' ? 'selected' : ''}>Computer Lab</option>
                        <option value="fas fa-utensils" ${facility.icon === 'fas fa-utensils' ? 'selected' : ''}>Cafeteria</option>
                        <option value="fas fa-car" ${facility.icon === 'fas fa-car' ? 'selected' : ''}>Parking</option>
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
</script>
@endsection