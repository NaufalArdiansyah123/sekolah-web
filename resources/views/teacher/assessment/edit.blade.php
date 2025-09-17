@extends('layouts.teacher')

@section('title', 'Edit Assessment')

@push('styles')
<style>
    /* Enhanced Assessment Edit Styles */
    .assessment-edit-container {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        margin: 0;
        padding: 0;
    }

    .assessment-edit-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    .content-wrapper {
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(20px);
        margin: 0;
        padding: 0;
        width: 100%;
        overflow: hidden;
        position: relative;
        z-index: 1;
        transition: all 0.3s ease;
        min-height: 100vh;
    }

    .dark .content-wrapper {
        background: rgba(30, 41, 59, 0.98);
    }

    .header-section {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
        padding: 2rem;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .dark .header-section {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    .header-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .header-section::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -10%;
        width: 150px;
        height: 150px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        animation: float 8s ease-in-out infinite reverse;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .header-content {
        position: relative;
        z-index: 2;
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 2rem;
    }

    .header-info {
        flex: 1;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 0.5rem;
        line-height: 1.2;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .main-content {
        padding: 3rem 2rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .form-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .dark .form-container {
        background: #374151;
        border-color: #4b5563;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    }

    .form-header {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        padding: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .dark .form-header {
        background: linear-gradient(135deg, #4b5563 0%, #6b7280 100%);
        border-color: #6b7280;
    }

    .form-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .dark .form-title {
        color: #f9fafb;
    }

    .form-description {
        color: #6b7280;
        margin: 0;
        line-height: 1.6;
    }

    .dark .form-description {
        color: #d1d5db;
    }

    .form-body {
        padding: 2rem;
    }

    .form-section {
        margin-bottom: 3rem;
        padding: 2rem;
        background: #f8fafc;
        border-radius: 16px;
        border-left: 4px solid #f59e0b;
        transition: all 0.3s ease;
    }

    .dark .form-section {
        background: #4b5563;
        border-color: #d97706;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dark .section-title {
        color: #f9fafb;
    }

    .section-description {
        color: #6b7280;
        margin-bottom: 2rem;
        font-size: 0.875rem;
    }

    .dark .section-description {
        color: #d1d5db;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .dark .form-label {
        color: #f9fafb;
    }

    .required {
        color: #ef4444;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: white;
        color: #374151;
    }

    .dark .form-input, .dark .form-select, .dark .form-textarea {
        background: #6b7280;
        border-color: #9ca3af;
        color: #f9fafb;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #f59e0b;
        box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
        transform: translateY(-1px);
    }

    .form-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .input-helper {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }

    .dark .input-helper {
        color: #d1d5db;
    }

    /* Questions Section */
    .questions-section {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: 2px solid #e5e7eb;
        margin-top: 2rem;
    }

    .dark .questions-section {
        background: #4b5563;
        border-color: #6b7280;
    }

    .question-item {
        background: #f8fafc;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
        position: relative;
    }

    .dark .question-item {
        background: #6b7280;
        border-color: #9ca3af;
    }

    .question-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .question-number {
        background: #f59e0b;
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .question-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-remove {
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 8px;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-remove:hover {
        background: #dc2626;
        transform: scale(1.1);
    }

    .options-container {
        margin-top: 1rem;
    }

    .option-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .option-radio {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .option-radio.selected {
        border-color: #f59e0b;
        background: #f59e0b;
        position: relative;
    }

    .option-radio.selected::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 8px;
        height: 8px;
        background: white;
        border-radius: 50%;
    }

    .option-input {
        flex: 1;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 0.875rem;
    }

    .btn-add-option {
        background: #d97706;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add-option:hover {
        background: #b45309;
    }

    .btn-add-question {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 2rem auto;
        font-size: 1rem;
    }

    .btn-add-question:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    }

    /* Form Actions */
    .form-actions {
        padding: 2rem;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .dark .form-actions {
        background: #4b5563;
        border-color: #6b7280;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-secondary:hover {
        background: #4b5563;
        color: white;
        text-decoration: none;
        transform: translateY(-2px);
    }

    .btn-primary {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
    }

    .btn-draft {
        background: #374151;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-draft:hover {
        background: #1f2937;
        transform: translateY(-2px);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            text-align: center;
        }

        .page-title {
            font-size: 2rem;
        }

        .main-content {
            padding: 2rem 1rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .form-section {
            padding: 1.5rem;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
            gap: 1rem;
        }

        .form-actions > div {
            width: 100%;
            display: flex;
            justify-content: center;
        }
    }

    /* Animation */
    .form-container {
        animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<div class="assessment-edit-container">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="header-section">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">
                        <i class="fas fa-edit"></i>
                        Edit Assessment
                    </h1>
                    <p class="page-subtitle">Update assessment details and questions</p>
                </div>
                <div class="header-actions">
                    <a href="{{ route('teacher.assessment.index') }}" class="btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Back to Assessments
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">
                        <i class="fas fa-clipboard-list"></i>
                        Assessment Details
                    </h2>
                    <p class="form-description">
                        Update the assessment information and modify questions as needed.
                    </p>
                </div>

                <form action="{{ route('teacher.assessment.update', $assessment->id) }}" method="POST" id="assessmentForm" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    
                    <div class="form-body">
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-info-circle"></i>
                                Basic Information
                            </h3>
                            <p class="section-description">
                                Update the fundamental details about your assessment
                            </p>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-heading"></i>
                                        Assessment Title <span class="required">*</span>
                                    </label>
                                    <input type="text" name="title" class="form-input" 
                                           placeholder="e.g., Ujian Tengah Semester - Matematika" 
                                           value="{{ old('title', $assessment->title) }}" required>
                                    <div class="input-helper">Give your assessment a clear and descriptive title</div>
                                    @error('title')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-book"></i>
                                        Subject <span class="required">*</span>
                                    </label>
                                    <select name="subject" class="form-select" required>
                                        <option value="">Select Subject</option>
                                        <option value="Matematika" {{ old('subject', $assessment->subject) == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                                        <option value="Fisika" {{ old('subject', $assessment->subject) == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                                        <option value="Biologi" {{ old('subject', $assessment->subject) == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                                        <option value="Kimia" {{ old('subject', $assessment->subject) == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                                        <option value="Bahasa Indonesia" {{ old('subject', $assessment->subject) == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                                        <option value="Bahasa Inggris" {{ old('subject', $assessment->subject) == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                                        <option value="Sejarah" {{ old('subject', $assessment->subject) == 'Sejarah' ? 'selected' : '' }}>Sejarah</option>
                                        <option value="Geografi" {{ old('subject', $assessment->subject) == 'Geografi' ? 'selected' : '' }}>Geografi</option>
                                    </select>
                                    @error('subject')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-users"></i>
                                        Class <span class="required">*</span>
                                    </label>
                                    <select name="class" class="form-select" required>
                                        <option value="">Select Class</option>
                                        <option value="VII A" {{ old('class', $assessment->class) == 'VII A' ? 'selected' : '' }}>VII A</option>
                                        <option value="VII B" {{ old('class', $assessment->class) == 'VII B' ? 'selected' : '' }}>VII B</option>
                                        <option value="VII C" {{ old('class', $assessment->class) == 'VII C' ? 'selected' : '' }}>VII C</option>
                                        <option value="VIII A" {{ old('class', $assessment->class) == 'VIII A' ? 'selected' : '' }}>VIII A</option>
                                        <option value="VIII B" {{ old('class', $assessment->class) == 'VIII B' ? 'selected' : '' }}>VIII B</option>
                                        <option value="VIII C" {{ old('class', $assessment->class) == 'VIII C' ? 'selected' : '' }}>VIII C</option>
                                        <option value="IX A" {{ old('class', $assessment->class) == 'IX A' ? 'selected' : '' }}>IX A</option>
                                        <option value="IX B" {{ old('class', $assessment->class) == 'IX B' ? 'selected' : '' }}>IX B</option>
                                        <option value="IX C" {{ old('class', $assessment->class) == 'IX C' ? 'selected' : '' }}>IX C</option>
                                    </select>
                                    @error('class')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-clipboard-check"></i>
                                        Assessment Type <span class="required">*</span>
                                    </label>
                                    <select name="type" class="form-select" required>
                                        <option value="">Select Type</option>
                                        <option value="exam" {{ old('type', $assessment->type) == 'exam' ? 'selected' : '' }}>📋 Exam</option>
                                        <option value="quiz" {{ old('type', $assessment->type) == 'quiz' ? 'selected' : '' }}>❓ Quiz</option>
                                        <option value="test" {{ old('type', $assessment->type) == 'test' ? 'selected' : '' }}>📝 Test</option>
                                        <option value="practical" {{ old('type', $assessment->type) == 'practical' ? 'selected' : '' }}>🔬 Practical</option>
                                        <option value="assignment" {{ old('type', $assessment->type) == 'assignment' ? 'selected' : '' }}>📚 Assignment</option>
                                    </select>
                                    @error('type')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Schedule & Configuration Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-calendar-alt"></i>
                                Schedule & Configuration
                            </h3>
                            <p class="section-description">
                                Update the timing and scoring parameters for your assessment
                            </p>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-calendar"></i>
                                        Assessment Date <span class="required">*</span>
                                    </label>
                                    <input type="datetime-local" name="date" class="form-input" 
                                           value="{{ old('date', $assessment->date->format('Y-m-d\TH:i')) }}" required>
                                    <div class="input-helper">When will this assessment take place?</div>
                                    @error('date')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-clock"></i>
                                        Duration (minutes) <span class="required">*</span>
                                    </label>
                                    <input type="number" name="duration" class="form-input" 
                                           placeholder="e.g., 90" min="5" max="300"
                                           value="{{ old('duration', $assessment->duration) }}" required>
                                    <div class="input-helper">How long will students have to complete this?</div>
                                    @error('duration')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-star"></i>
                                        Maximum Score <span class="required">*</span>
                                    </label>
                                    <input type="number" name="max_score" class="form-input" 
                                           placeholder="e.g., 100" min="1" max="1000"
                                           value="{{ old('max_score', $assessment->max_score) }}" required>
                                    <div class="input-helper">Total points available for this assessment</div>
                                    @error('max_score')
                                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-eye"></i>
                                        Status
                                    </label>
                                    <select name="status" class="form-select">
                                        <option value="draft" {{ old('status', $assessment->status) == 'draft' ? 'selected' : '' }}>📝 Draft</option>
                                        <option value="scheduled" {{ old('status', $assessment->status) == 'scheduled' ? 'selected' : '' }}>📅 Scheduled</option>
                                        <option value="active" {{ old('status', $assessment->status) == 'active' ? 'selected' : '' }}>🟢 Active</option>
                                        <option value="completed" {{ old('status', $assessment->status) == 'completed' ? 'selected' : '' }}>✅ Completed</option>
                                    </select>
                                    <div class="input-helper">Current status of this assessment</div>
                                </div>
                            </div>
                        </div>

                        <!-- Description & Instructions Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fas fa-align-left"></i>
                                Description & Instructions
                            </h3>
                            <p class="section-description">
                                Update detailed information and instructions for students
                            </p>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-file-alt"></i>
                                    Description
                                </label>
                                <textarea name="description" class="form-textarea" rows="4"
                                          placeholder="Describe what this assessment covers and its objectives...">{{ old('description', $assessment->description) }}</textarea>
                                <div class="input-helper">Brief description of the assessment content and objectives</div>
                                @error('description')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-list-ol"></i>
                                    Instructions for Students
                                </label>
                                <textarea name="instructions" class="form-textarea" rows="4"
                                          placeholder="Enter specific instructions for students (e.g., 'Read each question carefully', 'Show your work', etc.)...">{{ old('instructions', $assessment->instructions) }}</textarea>
                                <div class="input-helper">Clear instructions that students should follow during the assessment</div>
                                @error('instructions')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Questions Section -->
                        <div class="questions-section">
                            <h3 class="section-title">
                                <i class="fas fa-question-circle"></i>
                                Questions
                            </h3>
                            <p class="section-description">
                                Update questions for your assessment. You can modify existing questions or add new ones.
                            </p>

                            <div id="questionsContainer">
                                @foreach($assessment->questions as $index => $question)
                                    <div class="question-item" id="question-{{ $index + 1 }}">
                                        <div class="question-header">
                                            <div class="question-number">{{ $index + 1 }}</div>
                                            <div class="question-actions">
                                                <button type="button" class="btn-remove" onclick="removeQuestion({{ $index + 1 }})">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        
                                        <div class="form-grid">
                                            <div class="form-group" style="grid-column: 1 / -1;">
                                                <label class="form-label">Question Text <span class="required">*</span></label>
                                                <textarea name="questions[{{ $index + 1 }}][question]" class="form-textarea" rows="3" 
                                                          placeholder="Enter your question here..." required>{{ $question->question }}</textarea>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Question Type <span class="required">*</span></label>
                                                <select name="questions[{{ $index + 1 }}][type]" class="form-select" onchange="handleQuestionTypeChange({{ $index + 1 }}, this.value)" required>
                                                    <option value="">Select Type</option>
                                                    <option value="multiple_choice" {{ $question->type == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                                                    <option value="essay" {{ $question->type == 'essay' ? 'selected' : '' }}>Essay</option>
                                                    <option value="short_answer" {{ $question->type == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
                                                    <option value="true_false" {{ $question->type == 'true_false' ? 'selected' : '' }}>True/False</option>
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label">Points <span class="required">*</span></label>
                                                <input type="number" name="questions[{{ $index + 1 }}][points]" class="form-input" 
                                                       placeholder="e.g., 5" min="1" max="100" value="{{ $question->points }}" required>
                                            </div>
                                        </div>
                                        
                                        <div id="options-container-{{ $index + 1 }}" class="options-container">
                                            @if($question->type == 'multiple_choice' && $question->options)
                                                <h4 style="margin-bottom: 1rem; color: #374151; font-weight: 600;">Answer Options</h4>
                                                <div id="options-list-{{ $index + 1 }}">
                                                    @foreach($question->options as $optionIndex => $option)
                                                        <div class="option-item">
                                                            <div class="option-radio {{ $question->correct_answer == $optionIndex ? 'selected' : '' }}" onclick="selectCorrectAnswer({{ $index + 1 }}, {{ $optionIndex }})"></div>
                                                            <input type="text" name="questions[{{ $index + 1 }}][options][]" class="option-input" value="{{ $option }}" required>
                                                        </div>
                                                    @endforeach
                                                    <input type="hidden" name="questions[{{ $index + 1 }}][correct_answer]" value="{{ $question->correct_answer }}">
                                                </div>
                                                <button type="button" class="btn-add-option" onclick="addOption({{ $index + 1 }})">
                                                    <i class="fas fa-plus"></i> Add Option
                                                </button>
                                                <div class="input-helper" style="margin-top: 0.5rem;">Click the circle next to the correct answer</div>
                                            @elseif($question->type == 'true_false')
                                                <h4 style="margin-bottom: 1rem; color: #374151; font-weight: 600;">Correct Answer</h4>
                                                <div class="option-item">
                                                    <div class="option-radio {{ $question->correct_answer == 'true' ? 'selected' : '' }}" onclick="selectTrueFalse({{ $index + 1 }}, 'true')"></div>
                                                    <span style="padding: 0.5rem 0.75rem;">True</span>
                                                </div>
                                                <div class="option-item">
                                                    <div class="option-radio {{ $question->correct_answer == 'false' ? 'selected' : '' }}" onclick="selectTrueFalse({{ $index + 1 }}, 'false')"></div>
                                                    <span style="padding: 0.5rem 0.75rem;">False</span>
                                                </div>
                                                <input type="hidden" name="questions[{{ $index + 1 }}][correct_answer]" value="{{ $question->correct_answer }}">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <button type="button" class="btn-add-question" onclick="addQuestion()">
                                <i class="fas fa-plus"></i>
                                Add Question
                            </button>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('teacher.assessment.index') }}" class="btn-secondary">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        
                        <div style="display: flex; gap: 1rem;">
                            <button type="button" class="btn-draft" onclick="saveDraft()">
                                <i class="fas fa-save"></i>
                                Save as Draft
                            </button>
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-check"></i>
                                Update Assessment
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let questionCount = {{ $assessment->questions->count() }};

function addQuestion() {
    questionCount++;
    const questionsContainer = document.getElementById('questionsContainer');
    
    const questionHtml = `
        <div class="question-item" id="question-${questionCount}">
            <div class="question-header">
                <div class="question-number">${questionCount}</div>
                <div class="question-actions">
                    <button type="button" class="btn-remove" onclick="removeQuestion(${questionCount})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label class="form-label">Question Text <span class="required">*</span></label>
                    <textarea name="questions[${questionCount}][question]" class="form-textarea" rows="3" 
                              placeholder="Enter your question here..." required></textarea>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Question Type <span class="required">*</span></label>
                    <select name="questions[${questionCount}][type]" class="form-select" onchange="handleQuestionTypeChange(${questionCount}, this.value)" required>
                        <option value="">Select Type</option>
                        <option value="multiple_choice">Multiple Choice</option>
                        <option value="essay">Essay</option>
                        <option value="short_answer">Short Answer</option>
                        <option value="true_false">True/False</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label class="form-label">Points <span class="required">*</span></label>
                    <input type="number" name="questions[${questionCount}][points]" class="form-input" 
                           placeholder="e.g., 5" min="1" max="100" required>
                </div>
            </div>
            
            <div id="options-container-${questionCount}" class="options-container" style="display: none;">
                <!-- Options will be added here for multiple choice questions -->
            </div>
        </div>
    `;
    
    questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
}

function removeQuestion(questionId) {
    if (confirm('Are you sure you want to remove this question?')) {
        document.getElementById(`question-${questionId}`).remove();
        updateQuestionNumbers();
    }
}

function updateQuestionNumbers() {
    const questions = document.querySelectorAll('.question-item');
    questions.forEach((question, index) => {
        const numberElement = question.querySelector('.question-number');
        if (numberElement) {
            numberElement.textContent = index + 1;
        }
    });
}

function handleQuestionTypeChange(questionId, type) {
    const optionsContainer = document.getElementById(`options-container-${questionId}`);
    
    if (type === 'multiple_choice') {
        optionsContainer.style.display = 'block';
        optionsContainer.innerHTML = `
            <h4 style="margin-bottom: 1rem; color: #374151; font-weight: 600;">Answer Options</h4>
            <div id="options-list-${questionId}">
                <div class="option-item">
                    <div class="option-radio" onclick="selectCorrectAnswer(${questionId}, 0)"></div>
                    <input type="text" name="questions[${questionId}][options][]" class="option-input" placeholder="Option A" required>
                    <input type="hidden" name="questions[${questionId}][correct_answer]" value="">
                </div>
                <div class="option-item">
                    <div class="option-radio" onclick="selectCorrectAnswer(${questionId}, 1)"></div>
                    <input type="text" name="questions[${questionId}][options][]" class="option-input" placeholder="Option B" required>
                </div>
            </div>
            <button type="button" class="btn-add-option" onclick="addOption(${questionId})">
                <i class="fas fa-plus"></i> Add Option
            </button>
            <div class="input-helper" style="margin-top: 0.5rem;">Click the circle next to the correct answer</div>
        `;
    } else if (type === 'true_false') {
        optionsContainer.style.display = 'block';
        optionsContainer.innerHTML = `
            <h4 style="margin-bottom: 1rem; color: #374151; font-weight: 600;">Correct Answer</h4>
            <div class="option-item">
                <div class="option-radio" onclick="selectTrueFalse(${questionId}, 'true')"></div>
                <span style="padding: 0.5rem 0.75rem;">True</span>
            </div>
            <div class="option-item">
                <div class="option-radio" onclick="selectTrueFalse(${questionId}, 'false')"></div>
                <span style="padding: 0.5rem 0.75rem;">False</span>
            </div>
            <input type="hidden" name="questions[${questionId}][correct_answer]" value="">
        `;
    } else {
        optionsContainer.style.display = 'none';
        optionsContainer.innerHTML = '';
    }
}

function addOption(questionId) {
    const optionsList = document.getElementById(`options-list-${questionId}`);
    const optionCount = optionsList.children.length;
    const optionLetter = String.fromCharCode(65 + optionCount); // A, B, C, D, etc.
    
    const optionHtml = `
        <div class="option-item">
            <div class="option-radio" onclick="selectCorrectAnswer(${questionId}, ${optionCount})"></div>
            <input type="text" name="questions[${questionId}][options][]" class="option-input" placeholder="Option ${optionLetter}" required>
        </div>
    `;
    
    optionsList.insertAdjacentHTML('beforeend', optionHtml);
}

function selectCorrectAnswer(questionId, optionIndex) {
    // Remove selected class from all options
    const question = document.getElementById(`question-${questionId}`);
    const radios = question.querySelectorAll('.option-radio');
    radios.forEach(radio => radio.classList.remove('selected'));
    
    // Add selected class to clicked option
    radios[optionIndex].classList.add('selected');
    
    // Set the correct answer value
    const correctAnswerInput = question.querySelector('input[name$="[correct_answer]"]');
    correctAnswerInput.value = optionIndex.toString();
}

function selectTrueFalse(questionId, value) {
    // Remove selected class from all options
    const question = document.getElementById(`question-${questionId}`);
    const radios = question.querySelectorAll('.option-radio');
    radios.forEach(radio => radio.classList.remove('selected'));
    
    // Add selected class to clicked option
    if (value === 'true') {
        radios[0].classList.add('selected');
    } else {
        radios[1].classList.add('selected');
    }
    
    // Set the correct answer value
    const correctAnswerInput = question.querySelector('input[name$="[correct_answer]"]');
    correctAnswerInput.value = value;
}

function saveDraft() {
    // Set status to draft
    const statusSelect = document.querySelector('select[name="status"]');
    statusSelect.value = 'draft';
    
    // Submit the form
    document.getElementById('assessmentForm').submit();
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.getElementById('assessmentForm');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        form.classList.add('was-validated');
    });
});
</script>
@endpush