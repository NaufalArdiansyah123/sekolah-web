@extends('layouts.teacher')

@section('title', 'Assessment & Grading Management')

@section('content')
<style>
    .assessment-container {
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

    .btn-primary {
        background: white;
        color: #059669;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #059669;
        text-decoration: none;
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

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
    }

    .stat-icon.active { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.completed { background: linear-gradient(135deg, #3b82f6, #60a5fa); }
    .stat-icon.scheduled { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .stat-icon.total { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .stat-title {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Filters */
    .filters-container {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .filters-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .filter-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .filter-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .btn-filter {
        background: #10b981;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-filter:hover {
        background: #059669;
        transform: translateY(-1px);
    }

    /* Assessments Grid */
    .assessments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .assessment-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .assessment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .assessment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .assessment-header {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .assessment-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        flex-shrink: 0;
        font-size: 1.25rem;
    }

    .icon-exam { background: linear-gradient(135deg, #ef4444, #f87171); }
    .icon-quiz { background: linear-gradient(135deg, #10b981, #34d399); }
    .icon-test { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .icon-practical { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }

    .assessment-info {
        flex: 1;
        min-width: 0;
    }

    .assessment-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .assessment-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .assessment-details {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.75rem;
        margin-bottom: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.7rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.875rem;
        color: var(--text-primary);
        font-weight: 500;
    }

    .assessment-progress {
        margin-bottom: 1rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }

    .progress-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: var(--text-primary);
    }

    .progress-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #059669;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: var(--bg-tertiary);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .assessment-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 1rem;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-completed {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .status-scheduled {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .assessment-actions {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        border: none;
        font-size: 0.875rem;
    }

    .btn-view { background: #059669; }
    .btn-edit { background: #f59e0b; }
    .btn-delete { background: #ef4444; }

    .action-btn:hover {
        transform: scale(1.1);
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--text-secondary);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--bg-secondary);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--text-tertiary);
    }

    .empty-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: var(--text-primary);
    }

    .empty-description {
        color: var(--text-secondary);
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .assessment-container {
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

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .assessments-grid {
            grid-template-columns: 1fr;
        }

        .assessment-details {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .assessment-card {
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
</style>

<div class="assessment-container">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success" style="margin: 1rem 2rem; padding: 1rem; background: #d1fae5; border: 1px solid #10b981; border-radius: 8px; color: #065f46;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error" style="margin: 1rem 2rem; padding: 1rem; background: #fee2e2; border: 1px solid #ef4444; border-radius: 8px; color: #991b1b;">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Assessment & Grading
                </h1>
                <p class="page-subtitle">Create and manage exams, quizzes, and assessments for your students</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('teacher.assessment.reports') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    View Reports
                </a>
                <a href="{{ route('teacher.assessment.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Assessment
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon active">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assessments->where('status', 'active')->count() }}</div>
            <div class="stat-title">Active Assessments</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon completed">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assessments->where('status', 'completed')->count() }}</div>
            <div class="stat-title">Completed</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon scheduled">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assessments->where('status', 'scheduled')->count() }}</div>
            <div class="stat-title">Scheduled</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon total">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assessments->count() }}</div>
            <div class="stat-title">Total Assessments</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="{{ route('teacher.assessment.index') }}">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Search Assessments</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search by title..." 
                           class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Subject</label>
                    <select name="subject" class="filter-input">
                        <option value="">All Subjects</option>
                        <option value="Matematika" {{ request('subject') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Fisika" {{ request('subject') == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                        <option value="Biologi" {{ request('subject') == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                        <option value="Bahasa Indonesia" {{ request('subject') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Class</label>
                    <select name="class" class="filter-input">
                        <option value="">All Classes</option>
                        <option value="VII A" {{ request('class') == 'VII A' ? 'selected' : '' }}>VII A</option>
                        <option value="VII B" {{ request('class') == 'VII B' ? 'selected' : '' }}>VII B</option>
                        <option value="VIII A" {{ request('class') == 'VIII A' ? 'selected' : '' }}>VIII A</option>
                        <option value="VIII B" {{ request('class') == 'VIII B' ? 'selected' : '' }}>VIII B</option>
                        <option value="IX A" {{ request('class') == 'IX A' ? 'selected' : '' }}>IX A</option>
                        <option value="IX B" {{ request('class') == 'IX B' ? 'selected' : '' }}>IX B</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Type</label>
                    <select name="type" class="filter-input">
                        <option value="">All Types</option>
                        <option value="exam" {{ request('type') == 'exam' ? 'selected' : '' }}>Exam</option>
                        <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="test" {{ request('type') == 'test' ? 'selected' : '' }}>Test</option>
                        <option value="practical" {{ request('type') == 'practical' ? 'selected' : '' }}>Practical</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button type="submit" class="btn-filter">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Assessments Grid -->
    @if($assessments->count() > 0)
        <div class="assessments-grid">
            @foreach($assessments as $assessment)
                @php
                    $progressPercentage = $assessment->participants > 0 ? round(($assessment->completed / $assessment->participants) * 100) : 0;
                @endphp
                <div class="assessment-card">
                    <div class="assessment-header">
                        <div class="assessment-icon icon-{{ $assessment->type }}">
                            {{ $assessment->type_icon }}
                        </div>
                        <div class="assessment-info">
                            <div class="assessment-title">{{ $assessment->title }}</div>
                            <div class="assessment-meta">
                                <span>{{ $assessment->subject }}</span>
                                <span>•</span>
                                <span>{{ $assessment->class }}</span>
                                <span>•</span>
                                <span>{{ $assessment->date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="assessment-details">
                        <div class="detail-item">
                            <div class="detail-label">Duration</div>
                            <div class="detail-value">{{ $assessment->duration }} minutes</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Questions</div>
                            <div class="detail-value">{{ $assessment->total_questions }} questions</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Max Score</div>
                            <div class="detail-value">{{ $assessment->max_score }} points</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Participants</div>
                            <div class="detail-value">{{ $assessment->participants }} students</div>
                        </div>
                    </div>

                    <div class="assessment-progress">
                        <div class="progress-header">
                            <span class="progress-label">Completion</span>
                            <span class="progress-value">{{ $assessment->completed }}/{{ $assessment->participants }} ({{ $progressPercentage }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>

                    <div class="assessment-status {{ $assessment->status_badge_class }}">
                        @if($assessment->status == 'active')
                            🟢 Active
                        @elseif($assessment->status == 'completed')
                            ✅ Completed
                        @elseif($assessment->status == 'scheduled')
                            📅 Scheduled
                        @elseif($assessment->status == 'draft')
                            📝 Draft
                        @endif
                    </div>

                    <div class="assessment-actions">
                        <a href="{{ route('teacher.assessment.show', $assessment->id) }}" class="action-btn btn-view" title="View Assessment">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('teacher.assessment.edit', $assessment->id) }}" class="action-btn btn-edit" title="Edit Assessment">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button class="action-btn btn-delete" title="Delete Assessment" onclick="deleteAssessment({{ $assessment->id }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        @if($assessments->hasPages())
            <div class="pagination-container" style="margin-top: 2rem; display: flex; justify-content: center;">
                {{ $assessments->appends(request()->query())->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <h3 class="empty-title">No Assessments Found</h3>
            <p class="empty-description">
                @if(request()->hasAny(['search', 'subject', 'class', 'type', 'status']))
                    No assessments match your current filters. Try adjusting your search criteria.
                @else
                    No assessments have been created yet. Start by creating your first assessment.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'subject', 'class', 'type', 'status']))
            <a href="{{ route('teacher.assessment.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create First Assessment
            </a>
            @endif
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete assessment functionality
    window.deleteAssessment = function(assessmentId) {
        if (confirm('Are you sure you want to delete this assessment? This action cannot be undone.')) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/teacher/assessment/${assessmentId}`;
            form.style.display = 'none';
            
            // Add CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Add method override
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    };

    // Card hover effects
    const assessmentCards = document.querySelectorAll('.assessment-card');
    assessmentCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection