@extends('layouts.teacher')

@section('title', 'Grades & Report Cards')

@section('content')
<style>
    .grades-container {
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

    .stat-item {
        background: var(--bg-primary);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px var(--shadow-color);
    }

    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #6ee7b7, #10b981);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .dark .stat-icon {
        background: linear-gradient(135deg, #059669, #10b981);
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        transition: color 0.3s ease;
    }

    .stat-title {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
        transition: color 0.3s ease;
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
        transition: all 0.3s ease;
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
        transition: color 0.3s ease;
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

    .btn-reset {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-reset:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-1px);
    }

    /* Grades Table */
    .grades-section {
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

    .grades-table {
        width: 100%;
        border-collapse: collapse;
    }

    .grades-table th,
    .grades-table td {
        padding: 1rem 1.5rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .grades-table th {
        background: var(--bg-secondary);
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .grades-table td {
        color: var(--text-secondary);
        transition: all 0.3s ease;
    }

    .grades-table tr:hover td {
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

    .grade-cell {
        text-align: center;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .grade-excellent {
        color: #059669;
        background: rgba(5, 150, 105, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }

    .grade-good {
        color: #10b981;
        background: rgba(16, 185, 129, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }

    .grade-average {
        color: #f59e0b;
        background: rgba(245, 158, 11, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }

    .grade-below {
        color: #ef4444;
        background: rgba(239, 68, 68, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }

    .letter-grade {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .letter-grade.grade-a {
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        border: 2px solid rgba(5, 150, 105, 0.2);
    }

    .letter-grade.grade-b {
        background: rgba(16, 185, 129, 0.1);
        color: #10b981;
        border: 2px solid rgba(16, 185, 129, 0.2);
    }

    .letter-grade.grade-c {
        background: rgba(245, 158, 11, 0.1);
        color: #f59e0b;
        border: 2px solid rgba(245, 158, 11, 0.2);
    }

    .letter-grade.grade-d {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        border: 2px solid rgba(239, 68, 68, 0.2);
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
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
    .btn-edit { background: #f59e0b; }
    .btn-report { background: #3b82f6; }

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
        .grades-container {
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

        .grades-table {
            font-size: 0.875rem;
        }

        .grades-table th,
        .grades-table td {
            padding: 0.75rem 1rem;
        }

        .student-info {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    .stat-item {
        animation: slideUp 0.5s ease-out;
    }

    .stat-item:nth-child(2) {
        animation-delay: 0.1s;
    }

    .stat-item:nth-child(3) {
        animation-delay: 0.2s;
    }

    .stat-item:nth-child(4) {
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

<div class="grades-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    Grades & Report Cards
                </h1>
                <p class="page-subtitle">Manage student grades and generate report cards</p>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Grades
                </button>
                <button class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Generate Reports
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="stats-container">
        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $grades->count() }}</div>
            <div class="stat-title">Total Students</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="stat-value">{{ number_format($grades->avg('final_grade'), 1) }}</div>
            <div class="stat-title">Class Average</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="stat-value">{{ number_format($grades->max('final_grade'), 1) }}</div>
            <div class="stat-title">Highest Grade</div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <svg class="w-6 h-6" style="color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="stat-value">{{ $grades->where('letter_grade', 'A')->count() + $grades->where('letter_grade', 'A+')->count() }}</div>
            <div class="stat-title">A Grades</div>
        </div>
    </div>

    <!-- Filters -->
    <div class="filters-container">
        <form method="GET" action="{{ route('teacher.assessment.grades') }}">
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
                    <label class="filter-label">Subject</label>
                    <select name="subject" class="filter-input">
                        <option value="">All Subjects</option>
                        <option value="Matematika" {{ request('subject') == 'Matematika' ? 'selected' : '' }}>Matematika</option>
                        <option value="Fisika" {{ request('subject') == 'Fisika' ? 'selected' : '' }}>Fisika</option>
                        <option value="Kimia" {{ request('subject') == 'Kimia' ? 'selected' : '' }}>Kimia</option>
                        <option value="Biologi" {{ request('subject') == 'Biologi' ? 'selected' : '' }}>Biologi</option>
                        <option value="Bahasa Indonesia" {{ request('subject') == 'Bahasa Indonesia' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="Bahasa Inggris" {{ request('subject') == 'Bahasa Inggris' ? 'selected' : '' }}>Bahasa Inggris</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="submit" class="btn-filter">Filter</button>
                        <a href="{{ route('teacher.assessment.grades') }}" class="btn-reset">Reset</a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Grades Table -->
    <div class="grades-section">
        <!-- Section Header -->
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Student Grades Overview
            </h2>
            <p class="section-subtitle">Comprehensive view of student performance across all assessments</p>
        </div>

        @if($grades->count() > 0)
            <div style="overflow-x: auto;">
                <table class="grades-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Quiz Avg</th>
                            <th>Assignment Avg</th>
                            <th>Exam Avg</th>
                            <th>Final Grade</th>
                            <th>Letter Grade</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($grades as $grade)
                        <tr>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($grade->student_name, 0, 2)) }}
                                    </div>
                                    <div class="student-details">
                                        <div class="student-name">{{ $grade->student_name }}</div>
                                        <div class="student-id">ID: {{ $grade->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 500; color: var(--text-primary);">{{ $grade->class }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 500; color: var(--text-primary);">{{ $grade->subject }}</span>
                            </td>
                            <td>
                                <div class="grade-cell">
                                    <span class="@if($grade->quiz_avg >= 85) grade-excellent @elseif($grade->quiz_avg >= 75) grade-good @elseif($grade->quiz_avg >= 65) grade-average @else grade-below @endif">
                                        {{ number_format($grade->quiz_avg, 1) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="grade-cell">
                                    <span class="@if($grade->assignment_avg >= 85) grade-excellent @elseif($grade->assignment_avg >= 75) grade-good @elseif($grade->assignment_avg >= 65) grade-average @else grade-below @endif">
                                        {{ number_format($grade->assignment_avg, 1) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="grade-cell">
                                    <span class="@if($grade->exam_avg >= 85) grade-excellent @elseif($grade->exam_avg >= 75) grade-good @elseif($grade->exam_avg >= 65) grade-average @else grade-below @endif">
                                        {{ number_format($grade->exam_avg, 1) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="grade-cell">
                                    <span style="font-size: 1rem; font-weight: 700; color: var(--text-primary);">
                                        {{ number_format($grade->final_grade, 1) }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="grade-cell">
                                    <span class="letter-grade grade-{{ strtolower(substr($grade->letter_grade, 0, 1)) }}">
                                        {{ $grade->letter_grade }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <button class="action-btn btn-view" title="View Details">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                    <button class="action-btn btn-edit" title="Edit Grades">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </button>
                                    <button class="action-btn btn-report" title="Generate Report">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="empty-title">No Grades Found</h3>
                <p class="empty-description">
                    @if(request()->hasAny(['search', 'class', 'subject']))
                        No grades match your current filters. Try adjusting your search criteria.
                    @else
                        No grades have been recorded yet. Start by creating assessments and recording student scores.
                    @endif
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
            alert('View student grade details functionality would be implemented here');
        });
    });

    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            alert('Edit student grades functionality would be implemented here');
        });
    });

    document.querySelectorAll('.btn-report').forEach(button => {
        button.addEventListener('click', function() {
            alert('Generate individual report functionality would be implemented here');
        });
    });

    // Export and Generate Reports handlers
    document.querySelector('.btn-secondary').addEventListener('click', function() {
        alert('Export grades to Excel/PDF functionality would be implemented here');
    });

    document.querySelector('.btn-primary').addEventListener('click', function() {
        alert('Generate comprehensive reports functionality would be implemented here');
    });

    // Card hover effects
    const statItems = document.querySelectorAll('.stat-item');
    statItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
@endsection