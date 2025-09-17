@extends('layouts.teacher')

@section('title', 'Edit Assignment')

@section('content')
<style>
    .assignments-container {
        background: var(--bg-secondary);
        min-height: 100vh;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .page-header {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        padding: 2rem;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(5, 150, 105, 0.2);
        position: relative;
        overflow: hidden;
        margin-bottom: 2rem;
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
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 2rem;
    }

    .header-info {
        flex: 1;
    }

    .page-title {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .page-subtitle {
        font-size: 1rem;
        opacity: 0.9;
        margin-bottom: 1rem;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        opacity: 0.8;
    }

    .breadcrumb a {
        color: white;
        text-decoration: none;
        transition: opacity 0.3s ease;
    }

    .breadcrumb a:hover {
        opacity: 1;
        text-decoration: underline;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
    }

    .btn-secondary {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Assignment Info Card */
    .assignment-info-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .assignment-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .assignment-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
    }

    .icon-homework { background: linear-gradient(135deg, #10b981, #34d399); }
    .icon-project { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .icon-essay { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .icon-quiz { background: linear-gradient(135deg, #ef4444, #f87171); }
    .icon-presentation { background: linear-gradient(135deg, #06b6d4, #67e8f9); }

    .assignment-details {
        flex: 1;
    }

    .assignment-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .assignment-meta {
        display: flex;
        gap: 1rem;
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: 1rem;
    }

    .assignment-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: var(--bg-secondary);
        border-radius: 8px;
    }

    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Form Container */
    .form-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 2px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label.required::after {
        content: '*';
        color: #ef4444;
        font-weight: 700;
    }

    .form-input {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        resize: vertical;
    }

    .form-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
        transform: translateY(-1px);
    }

    .form-input::placeholder {
        color: var(--text-tertiary);
    }

    .form-select {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
        cursor: pointer;
    }

    .form-select:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    /* Assignment Type Selection */
    .type-selection {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
    }

    .type-option {
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem 1rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--bg-primary);
    }

    .type-option:hover {
        border-color: #059669;
        transform: translateY(-2px);
    }

    .type-option.selected {
        border-color: #059669;
        background: rgba(5, 150, 105, 0.1);
    }

    .type-icon {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
    }

    .type-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .type-description {
        font-size: 0.75rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }

    .type-input {
        display: none;
    }

    /* Current Attachments */
    .current-attachments {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        margin-bottom: 1rem;
    }

    .attachment-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        background: var(--bg-primary);
        border-radius: 8px;
        margin-bottom: 0.5rem;
    }

    .attachment-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .attachment-details {
        flex: 1;
    }

    .attachment-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .attachment-size {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .attachment-actions {
        display: flex;
        gap: 0.5rem;
    }

    .attachment-btn {
        padding: 0.5rem;
        border-radius: 6px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        color: white;
    }

    .btn-view { background: #059669; }
    .btn-remove { background: #ef4444; }

    .attachment-btn:hover {
        transform: scale(1.1);
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        padding-top: 2rem;
        border-top: 1px solid var(--border-color);
        margin-top: 2rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #059669, #10b981);
        color: white;
        border: none;
        box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-outline {
        background: transparent;
        color: var(--text-primary);
        border: 2px solid var(--border-color);
    }

    .btn-outline:hover {
        background: var(--bg-secondary);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .assignments-container {
            padding: 1rem;
        }

        .header-content {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
        }

        .form-container {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .type-selection {
            grid-template-columns: repeat(2, 1fr);
        }

        .form-actions {
            flex-direction: column;
        }

        .assignment-header {
            flex-direction: column;
            text-align: center;
        }

        .assignment-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .type-selection {
            grid-template-columns: 1fr;
        }

        .assignment-stats {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .form-container {
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

    /* Validation Styles */
    .form-input.error {
        border-color: #ef4444;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .error-message {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .success-message {
        color: #059669;
        font-size: 0.75rem;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }
</style>

<div class="assignments-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <div class="breadcrumb">
                    <a href="{{ route('teacher.dashboard') }}">Dashboard</a>
                    <span>/</span>
                    <a href="{{ route('teacher.learning.assignments.index') }}">Assignments</a>
                    <span>/</span>
                    <span>Edit Assignment</span>
                </div>
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Assignment
                </h1>
                <p class="page-subtitle">Update and modify assignment details and settings</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('teacher.learning.assignments.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Assignments
                </a>
            </div>
        </div>
    </div>

    <!-- Assignment Info Card -->
    <div class="assignment-info-card">
        <div class="assignment-header">
            <div class="assignment-icon icon-{{ $assignment->type }}">
                @if($assignment->type == 'homework')
                    📝
                @elseif($assignment->type == 'project')
                    🎯
                @elseif($assignment->type == 'essay')
                    📄
                @elseif($assignment->type == 'quiz')
                    ❓
                @elseif($assignment->type == 'presentation')
                    📊
                @endif
            </div>
            <div class="assignment-details">
                <div class="assignment-title">{{ $assignment->title }}</div>
                <div class="assignment-meta">
                    <span>{{ $assignment->subject }}</span>
                    <span>•</span>
                    <span>{{ $assignment->class }}</span>
                    <span>•</span>
                    <span>Created {{ \Carbon\Carbon::parse($assignment->created_at)->format('d M Y') }}</span>
                    <span>•</span>
                    <span>Due {{ \Carbon\Carbon::parse($assignment->due_date)->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>
        
        <div class="assignment-stats">
            <div class="stat-item">
                <div class="stat-value">{{ $assignment->submissions }}</div>
                <div class="stat-label">Submissions</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $assignment->total_students }}</div>
                <div class="stat-label">Total Students</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $assignment->max_score }}</div>
                <div class="stat-label">Max Score</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ ucfirst($assignment->status) }}</div>
                <div class="stat-label">Status</div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <form action="{{ route('teacher.learning.assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data" id="assignmentForm">
        @csrf
        @method('PUT')
        
        <div class="form-container">
            <!-- Basic Information Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Assignment Information
                </h2>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label required">Assignment Title</label>
                        <input type="text" 
                               name="title" 
                               class="form-input" 
                               placeholder="Enter assignment title..."
                               value="{{ old('title', $assignment->title) }}"
                               required>
                        @error('title')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Subject</label>
                        <select name="subject" class="form-select" required>
                            <option value="">Select Subject</option>
                            <option value="Matematika" {{ old('subject', $assignment->subject) == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                            <option value="Fisika" {{ old('subject', $assignment->subject) == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                            <option value="Biologi" {{ old('subject', $assignment->subject) == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                            <option value="Kimia" {{ old('subject', $assignment->subject) == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                            <option value="Bahasa Indonesia" {{ old('subject', $assignment->subject) == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                            <option value="Bahasa Inggris" {{ old('subject', $assignment->subject) == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                            <option value="Sejarah" {{ old('subject', $assignment->subject) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                            <option value="Geografi" {{ old('subject', $assignment->subject) == 'Geografi' ? 'selected' : '' }}>Geografi</option>
                            <option value="Ekonomi" {{ old('subject', $assignment->subject) == 'Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                            <option value="Sosiologi" {{ old('subject', $assignment->subject) == 'Sosiologi' ? 'selected' : '' }}>Sosiologi</option>
                        </select>
                        @error('subject')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Class</label>
                        <select name="class" class="form-select" required>
                            <option value="">Select Class</option>
                            <option value="X IPA 1" {{ old('class', $assignment->class) == 'X IPA 1' ? 'selected' : '' }}>X IPA 1</option>
                            <option value="X IPA 2" {{ old('class', $assignment->class) == 'X IPA 2' ? 'selected' : '' }}>X IPA 2</option>
                            <option value="X IPS 1" {{ old('class', $assignment->class) == 'X IPS 1' ? 'selected' : '' }}>X IPS 1</option>
                            <option value="X IPS 2" {{ old('class', $assignment->class) == 'X IPS 2' ? 'selected' : '' }}>X IPS 2</option>
                            <option value="XI IPA 1" {{ old('class', $assignment->class) == 'XI IPA 1' ? 'selected' : '' }}>XI IPA 1</option>
                            <option value="XI IPA 2" {{ old('class', $assignment->class) == 'XI IPA 2' ? 'selected' : '' }}>XI IPA 2</option>
                            <option value="XI IPS 1" {{ old('class', $assignment->class) == 'XI IPS 1' ? 'selected' : '' }}>XI IPS 1</option>
                            <option value="XI IPS 2" {{ old('class', $assignment->class) == 'XI IPS 2' ? 'selected' : '' }}>XI IPS 2</option>
                            <option value="XII IPA 1" {{ old('class', $assignment->class) == 'XII IPA 1' ? 'selected' : '' }}>XII IPA 1</option>
                            <option value="XII IPA 2" {{ old('class', $assignment->class) == 'XII IPA 2' ? 'selected' : '' }}>XII IPA 2</option>
                            <option value="XII IPS 1" {{ old('class', $assignment->class) == 'XII IPS 1' ? 'selected' : '' }}>XII IPS 1</option>
                            <option value="XII IPS 2" {{ old('class', $assignment->class) == 'XII IPS 2' ? 'selected' : '' }}>XII IPS 2</option>
                        </select>
                        @error('class')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Max Score</label>
                        <input type="number" 
                               name="max_score" 
                               class="form-input" 
                               placeholder="Enter maximum score..."
                               value="{{ old('max_score', $assignment->max_score) }}"
                               min="1"
                               max="1000"
                               required>
                        @error('max_score')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Due Date</label>
                        <input type="datetime-local" 
                               name="due_date" 
                               class="form-input" 
                               value="{{ old('due_date', \Carbon\Carbon::parse($assignment->due_date)->format('Y-m-d\TH:i')) }}"
                               required>
                        @error('due_date')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label required">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ old('status', $assignment->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="active" {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="completed" {{ old('status', $assignment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                        @error('status')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label required">Description</label>
                        <textarea name="description" 
                                  class="form-input form-textarea" 
                                  placeholder="Enter assignment description..."
                                  rows="4"
                                  required>{{ old('description', $assignment->description) }}</textarea>
                        @error('description')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label">Instructions</label>
                        <textarea name="instructions" 
                                  class="form-input form-textarea" 
                                  placeholder="Enter detailed instructions for students..."
                                  rows="6">{{ old('instructions', $assignment->instructions) }}</textarea>
                        @error('instructions')
                            <div class="error-message">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Assignment Type Section -->
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17v4a2 2 0 002 2h4M13 13h4a2 2 0 012 2v4a2 2 0 01-2 2h-4m-6-4a2 2 0 01-2-2V7a2 2 0 012-2h4a2 2 0 012 2v4a2 2 0 01-2 2h-4z"/>
                    </svg>
                    Assignment Type
                </h2>
                
                <div class="type-selection">
                    <label class="type-option" for="type-homework">
                        <input type="radio" name="type" value="homework" class="type-input" id="type-homework" {{ old('type', $assignment->type) == 'homework' ? 'checked' : '' }}>
                        <div class="type-icon">📝</div>
                        <div class="type-label">Homework</div>
                        <div class="type-description">Regular assignments for practice</div>
                    </label>
                    
                    <label class="type-option" for="type-project">
                        <input type="radio" name="type" value="project" class="type-input" id="type-project" {{ old('type', $assignment->type) == 'project' ? 'checked' : '' }}>
                        <div class="type-icon">🎯</div>
                        <div class="type-label">Project</div>
                        <div class="type-description">Long-term research projects</div>
                    </label>
                    
                    <label class="type-option" for="type-essay">
                        <input type="radio" name="type" value="essay" class="type-input" id="type-essay" {{ old('type', $assignment->type) == 'essay' ? 'checked' : '' }}>
                        <div class="type-icon">📄</div>
                        <div class="type-label">Essay</div>
                        <div class="type-description">Written essays and reports</div>
                    </label>
                    
                    <label class="type-option" for="type-quiz">
                        <input type="radio" name="type" value="quiz" class="type-input" id="type-quiz" {{ old('type', $assignment->type) == 'quiz' ? 'checked' : '' }}>
                        <div class="type-icon">❓</div>
                        <div class="type-label">Quiz</div>
                        <div class="type-description">Quick assessments and tests</div>
                    </label>
                    
                    <label class="type-option" for="type-presentation">
                        <input type="radio" name="type" value="presentation" class="type-input" id="type-presentation" {{ old('type', $assignment->type) == 'presentation' ? 'checked' : '' }}>
                        <div class="type-icon">📊</div>
                        <div class="type-label">Presentation</div>
                        <div class="type-description">Oral presentations and demos</div>
                    </label>
                </div>
                @error('type')
                    <div class="error-message">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Current Attachments Section -->
            @if(isset($assignment->attachments) && count($assignment->attachments) > 0)
            <div class="form-section">
                <h2 class="section-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                    </svg>
                    Current Attachments
                </h2>
                
                <div class="current-attachments">
                    @foreach($assignment->attachments as $attachment)
                    <div class="attachment-item">
                        <div class="attachment-icon">📎</div>
                        <div class="attachment-details">
                            <div class="attachment-name">{{ $attachment->name }}</div>
                            <div class="attachment-size">{{ $attachment->size }}</div>
                        </div>
                        <div class="attachment-actions">
                            <button type="button" class="attachment-btn btn-view" title="View Attachment">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                            <button type="button" class="attachment-btn btn-remove" title="Remove Attachment">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('teacher.learning.assignments.index') }}" class="btn btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary" id="submitBtn">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    Update Assignment
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Assignment type selection
    const typeOptions = document.querySelectorAll('.type-option');
    const typeInputs = document.querySelectorAll('.type-input');
    
    typeInputs.forEach(input => {
        input.addEventListener('change', function() {
            typeOptions.forEach(option => option.classList.remove('selected'));
            if (this.checked) {
                this.closest('.type-option').classList.add('selected');
            }
        });
    });
    
    // Set initial selection
    const checkedInput = document.querySelector('.type-input:checked');
    if (checkedInput) {
        checkedInput.closest('.type-option').classList.add('selected');
    }

    // Form validation
    const form = document.getElementById('assignmentForm');
    const submitBtn = document.getElementById('submitBtn');
    
    form.addEventListener('submit', function(e) {
        let isValid = true;
        const requiredFields = form.querySelectorAll('[required]');
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('error');
                isValid = false;
            } else {
                field.classList.remove('error');
            }
        });
        
        // Check if assignment type is selected
        const typeSelected = document.querySelector('.type-input:checked');
        if (!typeSelected) {
            alert('Please select an assignment type.');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Updating...
        `;
    });

    // Real-time validation
    const inputs = form.querySelectorAll('.form-input, .form-select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('error');
            } else {
                this.classList.remove('error');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error') && this.value.trim()) {
                this.classList.remove('error');
            }
        });
    });
});
</script>
@endsection