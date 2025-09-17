@extends('layouts.teacher')

@section('title', 'Assignment Details')

@section('content')
<style>
    .assignment-detail-container {
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

    .header-meta {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
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

    /* Assignment Info Cards */
    .info-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-content {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-active {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-overdue {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-draft {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .progress-section {
        margin-top: 1rem;
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

    .progress-percentage {
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

    /* Submissions Section */
    .submissions-section {
        background: var(--bg-primary);
        border-radius: 16px;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        overflow: hidden;
    }

    .section-header {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-secondary);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-subtitle {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    /* Filters */
    .filters-container {
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
        background: var(--bg-secondary);
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

    /* Submissions Table */
    .submissions-table {
        width: 100%;
        border-collapse: collapse;
    }

    .submissions-table th,
    .submissions-table td {
        padding: 1rem 2rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .submissions-table th {
        background: var(--bg-secondary);
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .submissions-table td {
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }

    .submissions-table tr:hover td {
        background: var(--bg-secondary);
        color: var(--text-primary);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .student-details {
        flex: 1;
    }

    .student-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .student-id {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .submission-status {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-submitted {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-graded {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-late {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .score-display {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .score-pending {
        color: var(--text-secondary);
        font-style: italic;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        transition: all 0.3s ease;
        cursor: pointer;
        text-decoration: none;
        border: none;
        font-size: 0.75rem;
    }

    .btn-view { background: #059669; }
    .btn-grade { background: #f59e0b; }
    .btn-download { background: #3b82f6; }

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
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .assignment-detail-container {
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

        .info-cards {
            grid-template-columns: 1fr;
        }

        .filters-row {
            grid-template-columns: 1fr;
        }

        .submissions-table {
            font-size: 0.875rem;
        }

        .submissions-table th,
        .submissions-table td {
            padding: 0.75rem 1rem;
        }
    }

    /* Animation */
    .info-card {
        animation: slideUp 0.5s ease-out;
    }

    .info-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .info-card:nth-child(3) {
        animation-delay: 0.2s;
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

<div class="assignment-detail-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">{{ $assignment->title }}</h1>
                <p class="page-subtitle">{{ $assignment->subject }} • {{ $assignment->class }}</p>
                <div class="header-meta">
                    <div class="meta-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Due: {{ $assignment->due_date->format('M d, Y H:i') }}
                    </div>
                    <div class="meta-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        {{ $assignment->submissions_count }}/{{ $assignment->total_students }} submitted
                    </div>
                    <div class="meta-item">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Max Score: {{ $assignment->max_score }}
                    </div>
                </div>
            </div>
            <div class="header-actions">
                <a href="{{ route('teacher.learning.assignments.edit', $assignment->id) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('teacher.learning.assignments.index') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Assignments
                </a>
            </div>
        </div>
    </div>

    <!-- Assignment Info Cards -->
    <div class="info-cards">
        <!-- Assignment Details -->
        <div class="info-card">
            <h3 class="card-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Assignment Details
            </h3>
            <div class="card-content">
                <p><strong>Description:</strong> {{ $assignment->description }}</p>
                <p><strong>Instructions:</strong> {{ $assignment->instructions }}</p>
                <p><strong>Created:</strong> {{ $assignment->created_at->format('M d, Y') }}</p>
                <div style="margin-top: 1rem;">
                    <span class="status-badge status-{{ $assignment->status }}">
                        @if($assignment->status == 'active')
                            🟢 Active
                        @elseif($assignment->status == 'overdue')
                            🔴 Overdue
                        @else
                            ⚫ Draft
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Submission Progress -->
        <div class="info-card">
            <h3 class="card-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Submission Progress
            </h3>
            <div class="card-content">
                <div class="progress-section">
                    <div class="progress-header">
                        <span class="progress-label">Students Submitted</span>
                        <span class="progress-percentage">{{ $assignment->progress_percentage }}%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: {{ $assignment->progress_percentage }}%"></div>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; font-size: 0.875rem;">
                    <div>
                        <strong>Submitted:</strong> {{ $assignment->submissions_count }}
                    </div>
                    <div>
                        <strong>Pending:</strong> {{ $assignment->total_students - $assignment->submissions_count }}
                    </div>
                    <div>
                        <strong>Total Students:</strong> {{ $assignment->total_students }}
                    </div>
                    <div>
                        <strong>Graded:</strong> {{ $submissions->where('status', 'graded')->count() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="info-card">
            <h3 class="card-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                </svg>
                Quick Statistics
            </h3>
            <div class="card-content">
                @php
                    $gradedSubmissions = $submissions->where('status', 'graded');
                    $averageScore = $gradedSubmissions->count() > 0 ? $gradedSubmissions->avg('score') : 0;
                    $highestScore = $gradedSubmissions->count() > 0 ? $gradedSubmissions->max('score') : 0;
                    $lowestScore = $gradedSubmissions->count() > 0 ? $gradedSubmissions->min('score') : 0;
                @endphp
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; font-size: 0.875rem;">
                    <div>
                        <strong>Average Score:</strong><br>
                        <span style="font-size: 1.25rem; color: #059669; font-weight: 600;">
                            {{ $gradedSubmissions->count() > 0 ? number_format($averageScore, 1) : 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <strong>Highest Score:</strong><br>
                        <span style="font-size: 1.25rem; color: #10b981; font-weight: 600;">
                            {{ $gradedSubmissions->count() > 0 ? $highestScore : 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <strong>Lowest Score:</strong><br>
                        <span style="font-size: 1.25rem; color: #f59e0b; font-weight: 600;">
                            {{ $gradedSubmissions->count() > 0 ? $lowestScore : 'N/A' }}
                        </span>
                    </div>
                    <div>
                        <strong>Completion Rate:</strong><br>
                        <span style="font-size: 1.25rem; color: #3b82f6; font-weight: 600;">
                            {{ $assignment->progress_percentage }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Submissions Section -->
    <div class="submissions-section">
        <!-- Section Header -->
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Student Submissions
            </h2>
            <p class="section-subtitle">Track and manage student assignment submissions</p>
        </div>

        <!-- Filters -->
        <div class="filters-container">
            <form method="GET" action="{{ route('teacher.learning.assignments.show', $assignment->id) }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Search Student</label>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by name or ID..." 
                               class="filter-input">
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-input">
                            <option value="">All Status</option>
                            <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>📝 Submitted</option>
                            <option value="graded" {{ request('status') == 'graded' ? 'selected' : '' }}>✅ Graded</option>
                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>⏰ Late</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">Sort By</label>
                        <select name="sort" class="filter-input">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Student Name</option>
                            <option value="submitted_at" {{ request('sort') == 'submitted_at' ? 'selected' : '' }}>Submission Date</option>
                            <option value="score" {{ request('sort') == 'score' ? 'selected' : '' }}>Score</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label class="filter-label">&nbsp;</label>
                        <button type="submit" class="btn-filter">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Submissions Table -->
        @if($submissions->count() > 0)
            <table class="submissions-table">
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Submitted At</th>
                        <th>Status</th>
                        <th>Score</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                    <tr>
                        <td>
                            <div class="student-info">
                                <div class="student-avatar">
                                    {{ strtoupper(substr($submission->student_name, 0, 2)) }}
                                </div>
                                <div class="student-details">
                                    <div class="student-name">{{ $submission->student_name }}</div>
                                    <div class="student-id">ID: {{ $submission->student_nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div style="font-weight: 500;">{{ $submission->submitted_at->format('M d, Y') }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-tertiary);">{{ $submission->submitted_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td>
                            <span class="submission-status status-{{ $submission->status }}">
                                @if($submission->status == 'submitted')
                                    📝 Submitted
                                @elseif($submission->status == 'graded')
                                    ✅ Graded
                                @else
                                    ⏰ Late
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($submission->score !== null)
                                <span class="score-display">{{ $submission->score }}/{{ $assignment->max_score }}</span>
                            @else
                                <span class="score-display score-pending">Not graded</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="action-btn btn-view" title="View Submission">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                @if($submission->status !== 'graded')
                                <button class="action-btn btn-grade" title="Grade Submission">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                @endif
                                <button class="action-btn btn-download" title="Download Submission">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Submissions Yet</h3>
                <p class="empty-description">
                    No students have submitted their assignments yet. Students can submit their work until the due date.
                </p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Action button handlers
    document.querySelectorAll('.btn-view').forEach(button => {
        button.addEventListener('click', function() {
            // Handle view submission
            alert('View submission functionality would be implemented here');
        });
    });

    document.querySelectorAll('.btn-grade').forEach(button => {
        button.addEventListener('click', function() {
            // Handle grade submission
            alert('Grade submission functionality would be implemented here');
        });
    });

    document.querySelectorAll('.btn-download').forEach(button => {
        button.addEventListener('click', function() {
            // Handle download submission
            alert('Download submission functionality would be implemented here');
        });
    });

    // Card hover effects
    const infoCards = document.querySelectorAll('.info-card');
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection