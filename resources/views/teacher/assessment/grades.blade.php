@extends('layouts.teacher')

@section('title', 'Assessment Grades')

@section('content')
<div class="grades-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Assessment Grades
            </h1>
            <p class="page-subtitle">View and manage all grades from your assessments</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon bg-blue-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['total_grades'] }}</div>
                <div class="stat-title">Total Grades</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-green-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ number_format($stats['average_grade'], 1) }}</div>
                <div class="stat-title">Average Grade</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-yellow-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['highest_grade'] }}</div>
                <div class="stat-title">Highest Grade</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon bg-red-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/>
                </svg>
            </div>
            <div class="stat-content">
                <div class="stat-value">{{ $stats['lowest_grade'] }}</div>
                <div class="stat-title">Lowest Grade</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" class="filters-form">
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
                <a href="{{ route('teacher.assessment.grades') }}" class="btn btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Grades Table -->
    <div class="grades-table-container">
        @if($grades->count() > 0)
            <div class="table-responsive">
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Assignment</th>
                            <th>Subject</th>
                            <th>Class</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>
                                    <div class="student-info">
                                        <div class="student-name">{{ $grade->student->name ?? 'N/A' }}</div>
                                        <div class="student-nis">{{ $grade->student->nis ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="assignment-info">
                                        <div class="assignment-title">{{ $grade->assignment->title }}</div>
                                        <div class="assignment-type">{{ ucfirst(str_replace('_', ' ', $grade->assignment->type ?? 'assignment')) }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="subject-badge">{{ $grade->assignment->subject ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <span class="class-badge">{{ $grade->assignment->class ?? 'N/A' }}</span>
                                </td>
                                <td>
                                    <div class="grade-display">
                                        <span class="grade-value {{ $grade->grade >= 80 ? 'excellent' : ($grade->grade >= 70 ? 'good' : ($grade->grade >= 60 ? 'fair' : 'poor')) }}">
                                            {{ $grade->grade }}
                                        </span>
                                        <span class="grade-max">/{{ $grade->assignment->max_score ?? 100 }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($grade->grade >= 75)
                                        <span class="status-badge passed">Passed</span>
                                    @else
                                        <span class="status-badge failed">Failed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="date-info">
                                        <div class="date">{{ $grade->created_at->format('M d, Y') }}</div>
                                        <div class="time">{{ $grade->created_at->format('H:i') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('teacher.assignments.show', $grade->assignment->id) }}" class="btn btn-sm btn-outline" title="View Assignment">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $grades->appends(request()->query())->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Grades Found</h3>
                <p class="empty-text">No grades match your current filters, or you haven't graded any assessments yet.</p>
                <div class="empty-actions">
                    <a href="{{ route('teacher.assessment.index') }}" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        View Assessments
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
/* Assessment Grades Styles with Dark Mode Support */
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

.grades-container {
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

.grades-table-container {
    background: var(--bg-primary);
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.table-responsive {
    overflow-x: auto;
}

.grades-table {
    width: 100%;
    border-collapse: collapse;
}

.grades-table th {
    background: var(--bg-secondary);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--text-primary);
    border-bottom: 1px solid var(--border-color);
    font-size: 0.875rem;
}

.grades-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: top;
}

.grades-table tr:hover {
    background: var(--bg-secondary);
}

.student-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.student-name {
    font-weight: 600;
    color: var(--text-primary);
}

.student-nis {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.assignment-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.assignment-title {
    font-weight: 500;
    color: var(--text-primary);
}

.assignment-type {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-transform: capitalize;
}

.subject-badge, .class-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
}

.grade-display {
    display: flex;
    align-items: baseline;
    gap: 0.25rem;
}

.grade-value {
    font-size: 1.25rem;
    font-weight: 700;
}

.grade-value.excellent {
    color: #059669;
}

.grade-value.good {
    color: #3b82f6;
}

.grade-value.fair {
    color: #f59e0b;
}

.grade-value.poor {
    color: #dc2626;
}

.grade-max {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-badge.passed {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.status-badge.failed {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

.date-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.date {
    font-weight: 500;
    color: var(--text-primary);
    font-size: 0.875rem;
}

.time {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
}

.pagination-container {
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
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
    .grades-container {
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
    
    .grades-table th,
    .grades-table td {
        padding: 0.75rem 0.5rem;
        font-size: 0.75rem;
    }
    
    .empty-actions {
        flex-direction: column;
        align-items: center;
    }
}
</style>
@endsection