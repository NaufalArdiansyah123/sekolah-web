@extends('layouts.teacher')

@section('title', 'Monthly Attendance Report')

@section('content')
<style>
    .report-container {
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

    .report-table {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .table th,
    .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
    }

    .table th {
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

    .table td {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 0.875rem;
        flex-shrink: 0;
    }

    .student-details {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.125rem;
    }

    .student-nis {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .attendance-percentage {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        min-width: 60px;
    }

    .percentage-excellent {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .percentage-good {
        background: rgba(34, 197, 94, 0.1);
        color: #16a34a;
        border: 1px solid rgba(34, 197, 94, 0.2);
    }

    .percentage-fair {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .percentage-poor {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .days-count {
        font-weight: 600;
        color: var(--text-primary);
    }

    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background: var(--bg-primary);
        padding: 1.5rem;
        border-radius: 14px;
        border: 1px solid var(--border-color);
        box-shadow: 0 2px 12px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
    }

    .summary-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
        color: white;
    }

    .summary-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
    }

    .summary-title {
        color: var(--text-secondary);
        font-size: 0.85rem;
        font-weight: 500;
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
        background: #10b981;
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .btn-primary:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
        text-decoration: none;
    }

    .btn-secondary {
        background: var(--bg-tertiary);
        color: var(--text-primary);
        border: 1px solid var(--border-color);
    }

    .btn-secondary:hover {
        background: var(--border-color);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .actions-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .actions-group {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .report-container {
            padding: 1rem;
        }

        .summary-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .actions-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .actions-group {
            justify-content: center;
        }

        .table th,
        .table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .student-info {
            gap: 0.5rem;
        }

        .student-avatar {
            width: 32px;
            height: 32px;
            font-size: 0.75rem;
        }
    }

    @media (max-width: 576px) {
        .summary-cards {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="report-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1 class="page-title">
                <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Monthly Attendance Report
            </h1>
            <p class="page-subtitle">Comprehensive attendance analysis for {{ \Carbon\Carbon::parse($month)->format('F Y') }} - Class {{ $class }}</p>
            <div style="display: flex; gap: 1rem; margin-top: 1rem; font-size: 0.875rem;">
                <span>📅 {{ \Carbon\Carbon::parse($month)->format('F Y') }}</span>
                <span>🏫 Class {{ $class }}</span>
                <span>👥 {{ count($monthlyData) }} Students</span>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <div class="summary-icon" style="background: linear-gradient(135deg, #10b981, #34d399);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div class="summary-value">{{ count($monthlyData) }}</div>
            <div class="summary-title">Total Students</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon" style="background: linear-gradient(135deg, #3b82f6, #60a5fa);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="summary-value">{{ $monthlyData[0]->total_days ?? 22 }}</div>
            <div class="summary-title">School Days</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon" style="background: linear-gradient(135deg, #059669, #10b981);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div class="summary-value">{{ number_format(collect($monthlyData)->avg('attendance_percentage'), 1) }}%</div>
            <div class="summary-title">Class Average</div>
        </div>

        <div class="summary-card">
            <div class="summary-icon" style="background: linear-gradient(135deg, #f59e0b, #fbbf24);">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <div class="summary-value">{{ collect($monthlyData)->where('attendance_percentage', '>=', 95)->count() }}</div>
            <div class="summary-title">Perfect Attendance</div>
        </div>
    </div>

    <!-- Report Table -->
    <div class="report-table">
        <div class="actions-bar">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Detailed Attendance Report
            </h2>
            <div class="actions-group">
                <button class="btn btn-secondary" onclick="printReport()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Print Report
                </button>
                <button class="btn btn-secondary" onclick="exportExcel()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </button>
                <a href="{{ route('teacher.attendance.index') }}" class="btn btn-primary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Attendance
                </a>
            </div>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Siswa</th>
                    <th>Total Days</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Sick</th>
                    <th>Permission</th>
                    <th>Attendance %</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyData as $data)
                <tr>
                    <td>
                        <div class="student-info">
                            <div class="student-avatar">
                                {{ strtoupper(substr($data->student->name, 0, 2)) }}
                            </div>
                            <div class="student-details">
                                <div class="student-name">{{ $data->student->name }}</div>
                                <div class="student-nis">NIS: {{ $data->student->nis }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="days-count">{{ $data->total_days }}</span>
                    </td>
                    <td>
                        <span class="days-count" style="color: #059669;">{{ $data->present_days }}</span>
                    </td>
                    <td>
                        <span class="days-count" style="color: #dc2626;">{{ $data->absent_days }}</span>
                    </td>
                    <td>
                        <span class="days-count" style="color: #d97706;">{{ $data->sick_days }}</span>
                    </td>
                    <td>
                        <span class="days-count" style="color: #2563eb;">{{ $data->permission_days }}</span>
                    </td>
                    <td>
                        <span class="attendance-percentage 
                            @if($data->attendance_percentage >= 95) percentage-excellent
                            @elseif($data->attendance_percentage >= 85) percentage-good
                            @elseif($data->attendance_percentage >= 75) percentage-fair
                            @else percentage-poor
                            @endif">
                            {{ $data->attendance_percentage }}%
                        </span>
                    </td>
                    <td>
                        @if($data->attendance_percentage >= 95)
                            <span style="color: #059669; font-weight: 600;">Excellent</span>
                        @elseif($data->attendance_percentage >= 85)
                            <span style="color: #16a34a; font-weight: 600;">Good</span>
                        @elseif($data->attendance_percentage >= 75)
                            <span style="color: #d97706; font-weight: 600;">Fair</span>
                        @else
                            <span style="color: #dc2626; font-weight: 600;">Needs Attention</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Print report functionality
    window.printReport = function() {
        window.print();
    };

    // Export to Excel functionality
    window.exportExcel = function() {
        alert('Export to Excel functionality would be implemented here');
    };

    // Add print styles
    const printStyles = `
        @media print {
            .actions-bar {
                display: none !important;
            }
            .page-header {
                background: #059669 !important;
                -webkit-print-color-adjust: exact;
            }
            .summary-card {
                break-inside: avoid;
            }
            .table {
                font-size: 12px;
            }
            .table th,
            .table td {
                padding: 0.5rem;
            }
        }
    `;

    const style = document.createElement('style');
    style.textContent = printStyles;
    document.head.appendChild(style);
});
</script>
@endsection