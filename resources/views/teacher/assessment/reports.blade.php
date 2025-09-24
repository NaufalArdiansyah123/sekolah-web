@extends('layouts.teacher')

@section('title', 'Assessment Reports')

@section('content')
<div class="reports-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 3l1.5 1.5L21 15"/>
                </svg>
                Assessment Reports
            </h1>
            <p class="page-subtitle">View comprehensive reports and analytics for your assessments</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <label for="period" class="filter-label">Period</label>
                <select name="period" id="period" class="filter-select">
                    <option value="week" {{ $period == 'week' ? 'selected' : '' }}>This Week</option>
                    <option value="month" {{ $period == 'month' ? 'selected' : '' }}>This Month</option>
                    <option value="semester" {{ $period == 'semester' ? 'selected' : '' }}>This Semester</option>
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
                    Generate Report
                </button>
                <a href="{{ route('teacher.assessment.reports') }}" class="btn btn-outline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Report Summary -->
    <div class="report-summary">
        <div class="summary-header">
            <h2 class="summary-title">
                Report Summary
                <span class="period-badge">{{ ucfirst($reportData['period']) }}</span>
            </h2>
            <div class="date-range">
                {{ $reportData['start_date']->format('M d, Y') }} - {{ $reportData['end_date']->format('M d, Y') }}
            </div>
        </div>

        <div class="summary-stats">
            <div class="stat-card">
                <div class="stat-icon bg-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $reportData['total_assessments'] }}</div>
                    <div class="stat-title">Total Assessments</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-green-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $reportData['assignments'] }}</div>
                    <div class="stat-title">Assignments</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-purple-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $reportData['quizzes'] }}</div>
                    <div class="stat-title">Quizzes</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon bg-orange-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $reportData['daily_tests'] }}</div>
                    <div class="stat-title">Daily Tests</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Breakdown -->
    <div class="breakdown-container">
        <div class="breakdown-card">
            <div class="card-header">
                <h3 class="card-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Assessment Distribution
                </h3>
            </div>
            <div class="card-content">
                <div class="chart-container">
                    <canvas id="assessmentChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>

        <div class="breakdown-card">
            <div class="card-header">
                <h3 class="card-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Assessment Trends
                </h3>
            </div>
            <div class="card-content">
                <div class="trend-item">
                    <div class="trend-label">Assignments Created</div>
                    <div class="trend-value">
                        <span class="value">{{ $reportData['assignments'] }}</span>
                        <span class="trend-indicator positive">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="trend-item">
                    <div class="trend-label">Quizzes Created</div>
                    <div class="trend-value">
                        <span class="value">{{ $reportData['quizzes'] }}</span>
                        <span class="trend-indicator positive">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="trend-item">
                    <div class="trend-label">Daily Tests Created</div>
                    <div class="trend-value">
                        <span class="value">{{ $reportData['daily_tests'] }}</span>
                        <span class="trend-indicator positive">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h3 class="actions-title">Quick Actions</h3>
        <div class="actions-grid">
            <a href="{{ route('teacher.assessment.index') }}" class="action-card">
                <div class="action-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <div class="action-content">
                    <div class="action-title">View All Assessments</div>
                    <div class="action-description">Manage your assignments, quizzes, and daily tests</div>
                </div>
            </a>

            <a href="{{ route('teacher.assessment.grades') }}" class="action-card">
                <div class="action-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="action-content">
                    <div class="action-title">View Grades</div>
                    <div class="action-description">Review all grades and student performance</div>
                </div>
            </a>

            <a href="{{ route('teacher.assignments.create') }}" class="action-card">
                <div class="action-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                </div>
                <div class="action-content">
                    <div class="action-title">Create Assignment</div>
                    <div class="action-description">Create a new assignment for your students</div>
                </div>
            </a>

            <a href="{{ route('teacher.quizzes.create') }}" class="action-card">
                <div class="action-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="action-content">
                    <div class="action-title">Create Quiz</div>
                    <div class="action-description">Create a new quiz for your students</div>
                </div>
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Assessment Distribution Chart
    const ctx = document.getElementById('assessmentChart').getContext('2d');
    const assessmentChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Assignments', 'Quizzes', 'Daily Tests'],
            datasets: [{
                data: [{{ $reportData['assignments'] }}, {{ $reportData['quizzes'] }}, {{ $reportData['daily_tests'] }}],
                backgroundColor: [
                    '#3b82f6',
                    '#10b981',
                    '#f59e0b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
});
</script>

<style>
/* Assessment Reports Styles with Dark Mode Support */
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

.reports-container {
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

.report-summary {
    background: var(--bg-primary);
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    margin-bottom: 2rem;
    overflow: hidden;
}

.summary-header {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.summary-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.period-badge {
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
    padding: 0.25rem 0.75rem;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.date-range {
    font-size: 0.875rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.summary-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    padding: 1.5rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border-radius: 8px;
    border: 1px solid var(--border-color);
    transition: all 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-color);
    background: var(--bg-primary);
}

.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.stat-title {
    font-size: 0.75rem;
    color: var(--text-secondary);
    font-weight: 500;
}

.breakdown-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.breakdown-card {
    background: var(--bg-primary);
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    overflow: hidden;
}

.card-header {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
}

.card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.card-content {
    padding: 1.5rem;
}

.chart-container {
    height: 200px;
    position: relative;
}

.trend-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.trend-item:last-child {
    border-bottom: none;
}

.trend-label {
    font-weight: 500;
    color: var(--text-primary);
}

.trend-value {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--text-primary);
}

.trend-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 24px;
    height: 24px;
    border-radius: 50%;
}

.trend-indicator.positive {
    background: rgba(16, 185, 129, 0.1);
    color: #059669;
}

.quick-actions {
    background: var(--bg-primary);
    border-radius: 12px;
    box-shadow: 0 2px 10px var(--shadow-color);
    border: 1px solid var(--border-color);
    padding: 1.5rem;
}

.actions-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 1.5rem 0;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}

.action-card {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: var(--bg-secondary);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.action-card:hover {
    background: var(--bg-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px var(--shadow-color);
    text-decoration: none;
}

.action-icon {
    width: 40px;
    height: 40px;
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-content {
    flex: 1;
}

.action-title {
    font-weight: 600;
    color: var(--text-primary);
    margin-bottom: 0.25rem;
}

.action-description {
    font-size: 0.875rem;
    color: var(--text-secondary);
}

@media (max-width: 768px) {
    .reports-container {
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
    
    .summary-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .breakdown-container {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection