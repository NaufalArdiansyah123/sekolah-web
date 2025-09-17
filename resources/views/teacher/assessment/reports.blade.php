@extends('layouts.teacher')

@section('title', 'Reports & Analytics')

@section('content')
<style>
    .reports-container {
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

    /* Overview Statistics */
    .overview-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-bottom: 1rem;
    }

    .stat-icon.assessments { background: linear-gradient(135deg, #059669, #10b981); }
    .stat-icon.participants { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
    .stat-icon.average { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .stat-icon.completed { background: linear-gradient(135deg, #10b981, #059669); }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 500;
    }

    .stat-change {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .stat-change.positive {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .stat-change.negative {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
    }

    /* Charts Section */
    .charts-section {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .chart-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 30px var(--shadow-color);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .chart-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-period {
        font-size: 0.75rem;
        color: var(--text-secondary);
        background: var(--bg-secondary);
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
    }

    .chart-content {
        height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--bg-secondary);
        border-radius: 12px;
        position: relative;
    }

    .chart-placeholder {
        text-align: center;
        color: var(--text-secondary);
    }

    .chart-placeholder svg {
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Subject Performance */
    .subject-performance {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .subject-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .subject-item {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.25rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
    }

    .subject-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
    }

    .subject-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .subject-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 1rem;
    }

    .subject-badge {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .subject-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .subject-stat {
        text-align: center;
    }

    .subject-stat-value {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .subject-stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Monthly Trends */
    .monthly-trends {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        margin-bottom: 2rem;
    }

    .trend-chart {
        height: 200px;
        background: var(--bg-secondary);
        border-radius: 12px;
        display: flex;
        align-items: end;
        justify-content: space-around;
        padding: 1rem;
        gap: 0.5rem;
    }

    .trend-bar {
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 4px 4px 0 0;
        min-width: 40px;
        position: relative;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .trend-bar:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }

    .trend-bar::after {
        content: attr(data-value);
        position: absolute;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .trend-bar:hover::after {
        opacity: 1;
    }

    .trend-labels {
        display: flex;
        justify-content: space-around;
        margin-top: 1rem;
        padding: 0 1rem;
    }

    .trend-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-align: center;
    }

    /* Export Options */
    .export-options {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
    }

    .export-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .export-item {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .export-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px var(--shadow-color);
        border-color: #059669;
    }

    .export-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #059669, #10b981);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
    }

    .export-title {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .export-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
        line-height: 1.4;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .reports-container {
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

        .overview-stats {
            grid-template-columns: repeat(2, 1fr);
        }

        .charts-section {
            grid-template-columns: 1fr;
        }

        .subject-grid {
            grid-template-columns: 1fr;
        }

        .export-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .overview-stats {
            grid-template-columns: 1fr;
        }

        .export-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .stat-card {
        animation: slideUp 0.5s ease-out;
    }

    .stat-card:nth-child(2) {
        animation-delay: 0.1s;
    }

    .stat-card:nth-child(3) {
        animation-delay: 0.2s;
    }

    .stat-card:nth-child(4) {
        animation-delay: 0.3s;
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

<div class="reports-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Reports & Analytics
                </h1>
                <p class="page-subtitle">Comprehensive insights into student performance and assessment trends</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Data
                </button>
                <button class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- Overview Statistics -->
    <div class="overview-stats">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon assessments">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <div class="stat-change positive">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    +12%
                </div>
            </div>
            <div class="stat-value">{{ $reportData['total_assessments'] }}</div>
            <div class="stat-label">Total Assessments</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon completed">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-change positive">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    +8%
                </div>
            </div>
            <div class="stat-value">{{ $reportData['completed_assessments'] }}</div>
            <div class="stat-label">Completed Assessments</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon participants">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <div class="stat-change positive">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    +15%
                </div>
            </div>
            <div class="stat-value">{{ $reportData['total_participants'] }}</div>
            <div class="stat-label">Total Participants</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon average">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="stat-change positive">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    +3.2%
                </div>
            </div>
            <div class="stat-value">{{ number_format($reportData['average_score'], 1) }}</div>
            <div class="stat-label">Average Score</div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-section">
        <!-- Performance Trends -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                    Performance Trends
                </h3>
                <span class="chart-period">Last 6 Months</span>
            </div>
            <div class="chart-content">
                <div class="chart-placeholder">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <p>Interactive chart showing performance trends over time</p>
                </div>
            </div>
        </div>

        <!-- Grade Distribution -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/>
                    </svg>
                    Grade Distribution
                </h3>
                <span class="chart-period">Current Semester</span>
            </div>
            <div class="chart-content">
                <div class="chart-placeholder">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/>
                    </svg>
                    <p>Pie chart showing distribution of grades (A, B, C, D)</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Performance -->
    <div class="subject-performance">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                Subject Performance Analysis
            </h2>
        </div>

        <div class="subject-grid">
            @foreach($reportData['subjects'] as $subject => $data)
            <div class="subject-item">
                <div class="subject-header">
                    <div class="subject-name">{{ $subject }}</div>
                    <div class="subject-badge">{{ $data['assessments'] }} Assessments</div>
                </div>
                <div class="subject-stats">
                    <div class="subject-stat">
                        <div class="subject-stat-value">{{ number_format($data['avg_score'], 1) }}</div>
                        <div class="subject-stat-label">Average Score</div>
                    </div>
                    <div class="subject-stat">
                        <div class="subject-stat-value">{{ $data['assessments'] }}</div>
                        <div class="subject-stat-label">Total Tests</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Monthly Trends -->
    <div class="monthly-trends">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Monthly Performance Trends
            </h2>
        </div>

        <div class="trend-chart">
            @foreach($reportData['monthly_stats'] as $month => $score)
            <div class="trend-bar" 
                 style="height: {{ ($score / 100) * 150 }}px;" 
                 data-value="{{ $score }}">
            </div>
            @endforeach
        </div>

        <div class="trend-labels">
            @foreach($reportData['monthly_stats'] as $month => $score)
            <div class="trend-label">{{ $month }}</div>
            @endforeach
        </div>
    </div>

    <!-- Export Options -->
    <div class="export-options">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export & Download Reports
            </h2>
        </div>

        <div class="export-grid">
            <div class="export-item" onclick="exportReport('pdf')">
                <div class="export-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="export-title">PDF Report</div>
                <div class="export-description">Comprehensive assessment report in PDF format</div>
            </div>

            <div class="export-item" onclick="exportReport('excel')">
                <div class="export-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10V9a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="export-title">Excel Spreadsheet</div>
                <div class="export-description">Detailed data in Excel format for analysis</div>
            </div>

            <div class="export-item" onclick="exportReport('csv')">
                <div class="export-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                    </svg>
                </div>
                <div class="export-title">CSV Data</div>
                <div class="export-description">Raw data in CSV format for custom analysis</div>
            </div>

            <div class="export-item" onclick="exportReport('summary')">
                <div class="export-icon">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <div class="export-title">Summary Report</div>
                <div class="export-description">Executive summary with key insights</div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Export functionality
    window.exportReport = function(type) {
        const messages = {
            'pdf': 'Generating PDF report...',
            'excel': 'Exporting to Excel...',
            'csv': 'Preparing CSV data...',
            'summary': 'Creating summary report...'
        };
        
        alert(messages[type] + ' This functionality would be implemented to generate and download the report.');
    };

    // Header action buttons
    document.querySelector('.btn-secondary').addEventListener('click', function() {
        alert('Export data functionality would be implemented here');
    });

    document.querySelector('.btn-primary').addEventListener('click', function() {
        alert('Generate comprehensive report functionality would be implemented here');
    });

    // Card hover effects
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    const chartCards = document.querySelectorAll('.chart-card');
    chartCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.01)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Trend bar interactions
    const trendBars = document.querySelectorAll('.trend-bar');
    trendBars.forEach(bar => {
        bar.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 4px 12px rgba(5, 150, 105, 0.3)';
        });
        
        bar.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
});
</script>
@endsection