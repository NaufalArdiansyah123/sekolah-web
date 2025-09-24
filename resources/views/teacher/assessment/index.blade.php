@extends('layouts.teacher')

@section('title', 'Assessment Management')

@section('content')
<div class="assessment-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                Assessment Management
            </h1>
            <p class="page-subtitle">Manage and track all your assessments, assignments, quizzes, and daily tests</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_assessments'] }}</div>
                <div class="stat-title">Total Assessments</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['pending_grading'] }}</div>
                <div class="stat-title">Pending Grading</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['graded_submissions'] }}</div>
                <div class="stat-title">Graded Submissions</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-purple-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_submissions'] }}</div>
                <div class="stat-title">Total Submissions</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label for="type" class="filter-label">Assessment Type</label>
                <select name="type" id="type" class="filter-select">
                    <option value="all" {{ $type == 'all' ? 'selected' : '' }}>All Types</option>
                    <option value="assignments" {{ $type == 'assignments' ? 'selected' : '' }}>Assignments</option>
                    <option value="quizzes" {{ $type == 'quizzes' ? 'selected' : '' }}>Quizzes</option>
                    <option value="daily_tests" {{ $type == 'daily_tests' ? 'selected' : '' }}>Daily Tests</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="subject" class="filter-label">Subject</label>
                <select name="subject" id="subject" class="filter-select">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subjectOption)
                        <option value="{{ $subjectOption }}" {{ $subject == $subjectOption ? 'selected' : '' }}>
                            {{ $subjectOption }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-group">
                <label for="class" class="filter-label">Class</label>
                <select name="class" id="class" class="filter-select">
                    <option value="">All Classes</option>
                    @foreach($classes as $classOption)
                        <option value="{{ $classOption }}" {{ $class == $classOption ? 'selected' : '' }}>
                            {{ $classOption }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"/>
                    </svg>
                    Filter
                </button>
                <a href="{{ route('teacher.assessment.index') }}" class="btn btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Assessments List -->
    <div class="assessments-container">
        @if($assessments->count() > 0)
            <div class="assessments-grid">
                @foreach($assessments as $assessment)
                    <div class="assessment-card">
                        <div class="assessment-header">
                            <div class="assessment-type">
                                @if($assessment->type == 'assignment')
                                    <span class="type-badge assignment">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Assignment
                                    </span>
                                @elseif($assessment->type == 'quiz')
                                    <span class="type-badge quiz">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Quiz
                                    </span>
                                @else
                                    <span class="type-badge daily-test">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Daily Test
                                    </span>
                                @endif
                            </div>
                            <div class="assessment-status">
                                @if($assessment->submissions_count > $assessment->graded_count)
                                    <span class="status-badge pending">Pending Grading</span>
                                @else
                                    <span class="status-badge completed">All Graded</span>
                                @endif
                            </div>
                        </div>

                        <div class="assessment-content">
                            <h3 class="assessment-title">{{ $assessment->title }}</h3>
                            <div class="assessment-meta">
                                <div class="meta-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    {{ $assessment->subject ?? 'N/A' }}
                                </div>
                                <div class="meta-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                    </svg>
                                    {{ $assessment->class ?? 'N/A' }}
                                </div>
                                <div class="meta-item">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $assessment->created_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="assessment-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $assessment->submissions_count }}</div>
                                <div class="stat-label">Submissions</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $assessment->graded_count }}</div>
                                <div class="stat-label">Graded</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $assessment->submissions_count - $assessment->graded_count }}</div>
                                <div class="stat-label">Pending</div>
                            </div>
                        </div>

                        <div class="assessment-actions">
                            @if($assessment->type == 'assignment')
                                <a href="{{ route('teacher.assignments.show', $assessment->id) }}" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('teacher.assignments.submissions', $assessment->id) }}" class="btn btn-outline btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    Grade
                                </a>
                            @elseif($assessment->type == 'quiz')
                                <a href="{{ route('teacher.quizzes.show', $assessment->id) }}" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('teacher.quizzes.attempts', $assessment->id) }}" class="btn btn-outline btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    Attempts
                                </a>
                            @else
                                <a href="{{ route('teacher.daily-tests.show', $assessment->id) }}" class="btn btn-primary btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View
                                </a>
                                <a href="{{ route('teacher.daily-tests.attempts', $assessment->id) }}" class="btn btn-outline btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                    </svg>
                                    Attempts
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Assessments Found</h3>
                <p class="empty-text">You haven't created any assessments yet, or no assessments match your current filters.</p>
                <div class="empty-actions">
                    <a href="{{ route('teacher.assignments.create') }}" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Assignment
                    </a>
                    <a href="{{ route('teacher.quizzes.create') }}" class="btn btn-outline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Create Quiz
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Assessment Management Styles with Dark Mode Support */
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-tertiary: #f1f5f9;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --text-tertiary: #9ca3af;
    --border-color: #e5e7eb;
    --shadow-color: rgba(0, 0, 0, 0.05);
}

.dark {
    --bg-primary: #1f2937;
    --bg-secondary: #111827;
    --bg-tertiary: #374151;
    --text-primary: #f9fafb;
    --text-secondary: #d1d5db;
    --text-tertiary: #9ca3af;
    --border-color: #374151;
    --shadow-color: rgba(0, 0, 0, 0.3);
}

.assessment-container {
    padding: 1.5rem;
    background: var(--bg-secondary);
    min-height: 100vh;
    transition: all 0.3s ease;
}

.page-header {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    margin-bottom: 2rem;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.2);
}

.header-content {
    text-align: center;
}

.page-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
}

.page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: var(--bg-primary);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    display: flex;
    align-items: center;
    gap: 1rem;
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-title {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.filters-container {
    background: var(--bg-primary);
    padding: 1.5rem;
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
}

.filters-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-label {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-primary);
}

.filter-select {
    padding: 0.75rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    background: var(--bg-primary);
    color: var(--text-primary);
    font-size: 0.875rem;
    transition: all 0.3s ease;
}

.filter-select:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.filter-actions {
    display: flex;
    gap: 0.75rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
}

.btn-primary {
    background: #3b82f6;
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
    color: white;
    text-decoration: none;
}

.btn-outline {
    background: transparent;
    color: var(--text-primary);
    border: 1px solid var(--border-color);
}

.btn-outline:hover {
    background: var(--bg-secondary);
    border-color: #3b82f6;
    color: #3b82f6;
    text-decoration: none;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.75rem;
}

.assessments-container {
    background: var(--bg-primary);
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.assessments-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
}

.assessment-card {
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.assessment-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px var(--shadow-color);
    background: var(--bg-primary);
}

.assessment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.375rem;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.type-badge.assignment {
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
}

.type-badge.quiz {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.type-badge.daily-test {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: #d97706;
}

.status-badge.completed {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.assessment-content {
    margin-bottom: 1rem;
}

.assessment-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.assessment-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.assessment-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
    padding: 1rem;
    background: var(--bg-primary);
    border-radius: 8px;
    border: 1px solid var(--border-color);
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.assessment-actions {
    display: flex;
    gap: 0.75rem;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    color: var(--text-tertiary);
    margin-bottom: 1.5rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 1rem;
}

.empty-text {
    color: var(--text-secondary);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.empty-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

@media (max-width: 768px) {
    .assessment-container {
        padding: 1rem;
    }
    
    .page-title {
        font-size: 1.5rem;
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .filters-form {
        grid-template-columns: 1fr;
    }
    
    .filter-actions {
        justify-content: center;
    }
    
    .assessments-grid {
        grid-template-columns: 1fr;
        padding: 1rem;
    }
    
    .assessment-stats {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }
    
    .assessment-actions {
        flex-direction: column;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection