@extends('layouts.teacher')

@section('title', 'Assignments Management')

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
    .stat-icon.draft { background: linear-gradient(135deg, #6b7280, #9ca3af); }
    .stat-icon.overdue { background: linear-gradient(135deg, #ef4444, #f87171); }

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

    /* Assignments Grid */
    .assignments-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .assignment-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .assignment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .assignment-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .assignment-header {
        display: flex;
        align-items: flex-start;
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
        flex-shrink: 0;
        font-size: 1.25rem;
    }

    .icon-homework { background: linear-gradient(135deg, #10b981, #34d399); }
    .icon-project { background: linear-gradient(135deg, #8b5cf6, #a78bfa); }
    .icon-essay { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .icon-quiz { background: linear-gradient(135deg, #ef4444, #f87171); }
    .icon-presentation { background: linear-gradient(135deg, #06b6d4, #67e8f9); }

    .assignment-info {
        flex: 1;
        min-width: 0;
    }

    .assignment-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .assignment-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .assignment-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .assignment-details {
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

    .assignment-progress {
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

    .assignment-status {
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

    .status-draft {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .status-overdue {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .assignment-actions {
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

    /* Due Date Warning */
    .due-date-warning {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem;
        background: rgba(245, 158, 11, 0.1);
        border: 1px solid rgba(245, 158, 11, 0.2);
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.75rem;
        color: #d97706;
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

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .assignments-grid {
            grid-template-columns: 1fr;
        }

        .assignment-details {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .assignment-card {
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

<div class="assignments-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Assignments & Tasks
                </h1>
                <p class="page-subtitle">Create and manage assignments, projects, and tasks for your students</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="bulkGrade()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Bulk Grade
                </button>
                <a href="{{ route('teacher.learning.assignments.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Assignment
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
            <div class="stat-value">{{ $assignments->where('status', 'active')->count() }}</div>
            <div class="stat-title">Active Assignments</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon completed">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assignments->where('status', 'completed')->count() }}</div>
            <div class="stat-title">Completed</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon draft">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assignments->where('status', 'draft')->count() }}</div>
            <div class="stat-title">Drafts</div>
        </div>

        <div class="stat-card">
            <div class="stat-icon overdue">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $assignments->where('due_date', '<', now())->where('status', 'active')->count() }}</div>
            <div class="stat-title">Overdue</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="{{ route('teacher.learning.assignments.index') }}">
            <div class="filters-row">
                <div class="filter-group">
                    <label class="filter-label">Search Assignments</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search by title or description..." 
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
                    <label class="filter-label">Status</label>
                    <select name="status" class="filter-input">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Type</label>
                    <select name="type" class="filter-input">
                        <option value="">All Types</option>
                        <option value="homework" {{ request('type') == 'homework' ? 'selected' : '' }}>Homework</option>
                        <option value="project" {{ request('type') == 'project' ? 'selected' : '' }}>Project</option>
                        <option value="essay" {{ request('type') == 'essay' ? 'selected' : '' }}>Essay</option>
                        <option value="quiz" {{ request('type') == 'quiz' ? 'selected' : '' }}>Quiz</option>
                        <option value="presentation" {{ request('type') == 'presentation' ? 'selected' : '' }}>Presentation</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button type="submit" class="btn-filter">Filter</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Assignments Grid -->
    @if($assignments->count() > 0)
        <div class="assignments-grid">
            @foreach($assignments as $assignment)
                @php
                    $progressPercentage = $assignment->progress_percentage;
                    $isOverdue = $assignment->is_overdue;
                    $daysUntilDue = $assignment->days_until_due;
                @endphp
                <div class="assignment-card">
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
                        <div class="assignment-info">
                            <div class="assignment-title">{{ $assignment->title }}</div>
                            <div class="assignment-meta">
                                <span>{{ $assignment->subject }}</span>
                                <span>•</span>
                                <span>{{ $assignment->class }}</span>
                                <span>•</span>
                                <span>{{ $assignment->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="assignment-description">
                        {{ $assignment->description }}
                    </div>

                    @if($isOverdue)
                    <div class="due-date-warning">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                        </svg>
                        Overdue by {{ abs($daysUntilDue) }} day{{ abs($daysUntilDue) != 1 ? 's' : '' }}
                    </div>
                    @elseif($daysUntilDue <= 3 && $assignment->status == 'active')
                    <div class="due-date-warning">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Due in {{ $daysUntilDue }} day{{ $daysUntilDue != 1 ? 's' : '' }}
                    </div>
                    @endif

                    <div class="assignment-details">
                        <div class="detail-item">
                            <div class="detail-label">Due Date</div>
                            <div class="detail-value">{{ $assignment->due_date->format('d M Y') }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Max Score</div>
                            <div class="detail-value">{{ $assignment->max_score }} points</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Type</div>
                            <div class="detail-value">{{ ucfirst($assignment->type) }}</div>
                        </div>
                        <div class="detail-item">
                            <div class="detail-label">Students</div>
                            <div class="detail-value">{{ $assignment->total_students }} students</div>
                        </div>
                    </div>

                    <div class="assignment-progress">
                        <div class="progress-header">
                            <span class="progress-label">Submissions</span>
                            <span class="progress-value">{{ $assignment->submissions_count }}/{{ $assignment->total_students }} ({{ $progressPercentage }}%)</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>

                    <div class="assignment-status status-{{ $isOverdue ? 'overdue' : $assignment->status }}">
                        {{ $assignment->status_badge }}
                    </div>

                    <div class="assignment-actions">
                        <a href="{{ route('teacher.learning.assignments.show', $assignment->id) }}" class="action-btn btn-view" title="View Assignment">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </a>
                        <a href="{{ route('teacher.learning.assignments.edit', $assignment->id) }}" class="action-btn btn-edit" title="Edit Assignment">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </a>
                        <button class="action-btn btn-delete" title="Delete Assignment" onclick="deleteAssignment({{ $assignment->id }})">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
            </div>
            <h3 class="empty-title">No Assignments Found</h3>
            <p class="empty-description">
                @if(request()->hasAny(['search', 'subject', 'class', 'status', 'type']))
                    No assignments match your current filters. Try adjusting your search criteria.
                @else
                    No assignments have been created yet. Start by creating your first assignment.
                @endif
            </p>
            @if(!request()->hasAny(['search', 'subject', 'class', 'status', 'type']))
            <a href="{{ route('teacher.learning.assignments.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                Create First Assignment
            </a>
            @endif
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bulk grade functionality
    window.bulkGrade = function() {
        alert('Bulk grade functionality would be implemented here');
    };

    // Delete assignment functionality
    window.deleteAssignment = function(assignmentId) {
        if (confirm('Are you sure you want to delete this assignment? This action cannot be undone.\n\nThis will also delete all submissions and cannot be recovered.')) {
            // Create a form to submit DELETE request
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/teacher/learning/assignments/${assignmentId}`;
            form.style.display = 'none';
            
            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            if (csrfToken) {
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken.getAttribute('content');
                form.appendChild(csrfInput);
            }
            
            // Add method override for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            // Submit the form
            document.body.appendChild(form);
            form.submit();
        }
    };

    // Card hover effects
    const assignmentCards = document.querySelectorAll('.assignment-card');
    assignmentCards.forEach(card => {
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