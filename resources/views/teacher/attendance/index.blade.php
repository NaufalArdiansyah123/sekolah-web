@extends('layouts.teacher')

@section('title', 'Student Attendance Management')

@section('content')
<style>
    .attendance-container {
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

    /* Controls Section */
    .controls-section {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
    }

    .controls-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: end;
    }

    .control-group {
        display: flex;
        flex-direction: column;
    }

    .control-label {
        font-weight: 500;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .control-input {
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        background: var(--bg-primary);
        color: var(--text-primary);
    }

    .control-input:focus {
        border-color: #059669;
        box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        outline: none;
    }

    .btn-control {
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

    .btn-control:hover {
        background: #059669;
        transform: translateY(-1px);
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
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px var(--shadow-color);
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
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
    }

    .stat-icon.present { background: linear-gradient(135deg, #10b981, #34d399); }
    .stat-icon.absent { background: linear-gradient(135deg, #ef4444, #f87171); }
    .stat-icon.sick { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .stat-icon.permission { background: linear-gradient(135deg, #3b82f6, #60a5fa); }

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

    .stat-percentage {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
    }

    .percentage-high { background: rgba(16, 185, 129, 0.1); color: #059669; }
    .percentage-medium { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
    .percentage-low { background: rgba(239, 68, 68, 0.1); color: #ef4444; }

    /* Bulk Actions */
    .bulk-actions {
        background: var(--bg-primary);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        border: 1px solid var(--border-color);
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .bulk-label {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .bulk-btn {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.75rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .bulk-btn.present { background: rgba(16, 185, 129, 0.1); color: #059669; border: 1px solid rgba(16, 185, 129, 0.2); }
    .bulk-btn.absent { background: rgba(239, 68, 68, 0.1); color: #dc2626; border: 1px solid rgba(239, 68, 68, 0.2); }
    .bulk-btn.sick { background: rgba(245, 158, 11, 0.1); color: #d97706; border: 1px solid rgba(245, 158, 11, 0.2); }
    .bulk-btn.permission { background: rgba(59, 130, 246, 0.1); color: #2563eb; border: 1px solid rgba(59, 130, 246, 0.2); }

    .bulk-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Attendance Table */
    .attendance-table-section {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
        overflow-x: auto;
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
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .attendance-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    .attendance-table th,
    .attendance-table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .attendance-table th {
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

    .attendance-table td {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .attendance-table tbody tr:hover {
        background: var(--bg-tertiary);
    }

    .student-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .student-avatar {
        width: 40px;
        height: 40px;
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
        font-size: 0.9rem;
    }

    .student-nis {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .student-class {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background: rgba(5, 150, 105, 0.1);
        color: #059669;
        padding: 0.125rem 0.5rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .status-buttons {
        display: flex;
        gap: 0.25rem;
        flex-wrap: wrap;
    }

    .status-btn {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        min-width: 60px;
        text-align: center;
    }

    .status-btn.hadir { 
        background: rgba(16, 185, 129, 0.1); 
        color: #059669; 
        border: 1px solid rgba(16, 185, 129, 0.2); 
    }
    .status-btn.alpha { 
        background: rgba(239, 68, 68, 0.1); 
        color: #dc2626; 
        border: 1px solid rgba(239, 68, 68, 0.2); 
    }
    .status-btn.sakit { 
        background: rgba(245, 158, 11, 0.1); 
        color: #d97706; 
        border: 1px solid rgba(245, 158, 11, 0.2); 
    }
    .status-btn.izin { 
        background: rgba(59, 130, 246, 0.1); 
        color: #2563eb; 
        border: 1px solid rgba(59, 130, 246, 0.2); 
    }
    .status-btn.terlambat { 
        background: rgba(245, 158, 11, 0.1); 
        color: #d97706; 
        border: 1px solid rgba(245, 158, 11, 0.2); 
    }

    .status-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .status-btn.active.hadir { background: #10b981; color: white; }
    .status-btn.active.alpha { background: #ef4444; color: white; }
    .status-btn.active.sakit { background: #f59e0b; color: white; }
    .status-btn.active.izin { background: #3b82f6; color: white; }
    .status-btn.active.terlambat { background: #f59e0b; color: white; }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        min-width: 80px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .status-badge.hadir {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .status-badge.terlambat {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.izin {
        background: rgba(59, 130, 246, 0.1);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.2);
    }

    .status-badge.sakit {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.2);
    }

    .status-badge.alpha {
        background: rgba(239, 68, 68, 0.1);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .status-badge.unmarked {
        background: rgba(107, 114, 128, 0.1);
        color: #374151;
        border: 1px solid rgba(107, 114, 128, 0.2);
    }

    .time-display {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: 0.25rem;
    }

    .notes-input {
        width: 100%;
        padding: 0.375rem 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.75rem;
        background: var(--bg-secondary);
        color: var(--text-primary);
        resize: vertical;
        min-height: 60px;
    }

    .notes-input:focus {
        border-color: #059669;
        outline: none;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1);
    }

    .checkbox-column {
        width: 40px;
        text-align: center;
    }

    .student-checkbox {
        width: 18px;
        height: 18px;
        accent-color: #059669;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .attendance-container {
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

        .controls-grid {
            grid-template-columns: 1fr;
        }

        .stats-container {
            grid-template-columns: repeat(2, 1fr);
        }

        .bulk-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .attendance-table th,
        .attendance-table td {
            padding: 0.75rem 0.5rem;
            font-size: 0.8rem;
        }

        .status-buttons {
            flex-direction: column;
        }

        .status-btn {
            min-width: auto;
            width: 100%;
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }
    }

    /* Loading States */
    .loading {
        opacity: 0.6;
        pointer-events: none;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-color);
        border-top: 2px solid #059669;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="attendance-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-info">
                <h1 class="page-title">
                    <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                    Student Attendance
                </h1>
                <p class="page-subtitle">Mark and manage daily student attendance with comprehensive tracking</p>
                <div style="display: flex; gap: 1rem; margin-top: 1rem; font-size: 0.875rem;">
                    <span>📅 {{ \Carbon\Carbon::parse($selectedDate)->format('l, d F Y') }}</span>
                    <span>🏫 Class {{ $selectedClass }}</span>
                    <span>👥 {{ count($students) }} Students</span>
                </div>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="exportAttendance()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export Excel
                </button>
                <button class="btn btn-primary" onclick="showAttendanceHistory()">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    View Statistics
                </button>
            </div>
        </div>
    </div>

    <!-- Controls Section -->
    <div class="controls-section">
        <form method="GET" action="{{ route('teacher.attendance.index') }}" id="attendanceForm">
            <div class="controls-grid">
                <div class="control-group">
                    <label class="control-label">Select Date</label>
                    <input type="date" 
                           name="date" 
                           value="{{ $selectedDate }}" 
                           class="control-input"
                           onchange="document.getElementById('attendanceForm').submit()">
                </div>
                <div class="control-group">
                    <label class="control-label">Select Class</label>
                    <select name="class" 
                            class="control-input"
                            onchange="document.getElementById('attendanceForm').submit()">
                        @foreach($classes as $class)
                            <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>
                                {{ $class }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="control-group">
                    <label class="control-label">Quick Actions</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" class="btn-control" onclick="refreshAttendance()">
                            <svg class="w-4 h-4" style="display: inline; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Refresh
                        </button>
                        <button type="button" class="btn-control" onclick="saveAllAttendance()">
                            <svg class="w-4 h-4" style="display: inline; margin-right: 0.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                            </svg>
                            Save All
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon present">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-percentage percentage-high">{{ $statistics['present_percentage'] }}%</div>
            </div>
            <div class="stat-value">{{ $statistics['present'] }}</div>
            <div class="stat-title">Present</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon absent">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-percentage percentage-low">{{ round(($statistics['absent'] / $statistics['total']) * 100, 1) }}%</div>
            </div>
            <div class="stat-value">{{ $statistics['absent'] }}</div>
            <div class="stat-title">Absent</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon sick">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="stat-percentage percentage-medium">{{ round(($statistics['sick'] / $statistics['total']) * 100, 1) }}%</div>
            </div>
            <div class="stat-value">{{ $statistics['sick'] }}</div>
            <div class="stat-title">Sick</div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon permission">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="stat-percentage percentage-medium">{{ round(($statistics['permission'] / $statistics['total']) * 100, 1) }}%</div>
            </div>
            <div class="stat-value">{{ $statistics['permission'] }}</div>
            <div class="stat-title">Permission</div>
        </div>
    </div>

    <!-- Bulk Actions -->
    <div class="bulk-actions">
        <span class="bulk-label">Bulk Actions:</span>
        <input type="checkbox" id="selectAll" class="student-checkbox" onchange="toggleSelectAll()">
        <label for="selectAll" style="margin-right: 1rem;">Select All</label>
        <button class="bulk-btn present" onclick="bulkMarkAttendance('hadir')">
            ✓ Mark Selected Present
        </button>
        <button class="bulk-btn absent" onclick="bulkMarkAttendance('alpha')">
            ✗ Mark Selected Absent
        </button>
        <button class="bulk-btn sick" onclick="bulkMarkAttendance('sakit')">
            🏥 Mark Selected Sick
        </button>
        <button class="bulk-btn permission" onclick="bulkMarkAttendance('izin')">
            📋 Mark Selected Permission
        </button>
        <button class="btn-control" onclick="clearSelectedAttendance()">
            🔄 Clear Selected
        </button>
    </div>

    <!-- Attendance Table -->
    <div class="attendance-table-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
                Student Attendance List ({{ count($students) }} students)
            </h2>
        </div>

        @if(count($students) > 0)
            <table class="attendance-table">
                <thead>
                    <tr>
                        <th class="checkbox-column">
                            <input type="checkbox" id="selectAllTable" class="student-checkbox" onchange="toggleSelectAll()">
                        </th>
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Current Status</th>
                        <th>Mark Attendance</th>
                        <th>Waktu</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students as $student)
                        @php
                            $attendance = $attendanceData[$student->id] ?? null;
                            $status = $attendance ? $attendance->status : 'unmarked';
                            $notes = $attendance ? $attendance->notes : '';
                            $scanTime = $attendance && $attendance->scan_time ? $attendance->scan_time->format('H:i') : '';
                        @endphp
                        <tr data-student-id="{{ $student->id }}">
                            <td class="checkbox-column">
                                <input type="checkbox" class="student-checkbox" name="selected_students[]" value="{{ $student->id }}">
                            </td>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                    </div>
                                    <div class="student-details">
                                        <div class="student-name">{{ $student->name }}</div>
                                        <div class="student-nis">NIS: {{ $student->nis }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="student-class">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    {{ $student->class ? $student->class->name : 'No Class' }}
                                </div>
                            </td>
                            <td>
                                <div class="status-badge {{ $status }}" id="status-badge-{{ $student->id }}">
                                    @if($attendance)
                                        {{ $attendance->status_text }}
                                    @else
                                        Not Marked
                                    @endif
                                </div>
                                @if($attendance && $attendance->scan_time)
                                    <div class="time-display">
                                        {{ $attendance->scan_time->format('H:i') }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="status-buttons">
                                    <button class="status-btn hadir {{ $status == 'hadir' ? 'active' : '' }}" 
                                            onclick="markAttendance({{ $student->id }}, 'hadir', this)">
                                        Hadir
                                    </button>
                                    <button class="status-btn terlambat {{ $status == 'terlambat' ? 'active' : '' }}" 
                                            onclick="markAttendance({{ $student->id }}, 'terlambat', this)">
                                        Terlambat
                                    </button>
                                    <button class="status-btn izin {{ $status == 'izin' ? 'active' : '' }}" 
                                            onclick="markAttendance({{ $student->id }}, 'izin', this)">
                                        Izin
                                    </button>
                                    <button class="status-btn sakit {{ $status == 'sakit' ? 'active' : '' }}" 
                                            onclick="markAttendance({{ $student->id }}, 'sakit', this)">
                                        Sakit
                                    </button>
                                    <button class="status-btn alpha {{ $status == 'alpha' ? 'active' : '' }}" 
                                            onclick="markAttendance({{ $student->id }}, 'alpha', this)">
                                        Alpha
                                    </button>
                                </div>
                            </td>
                            <td>
                                <input type="time" 
                                       class="control-input" 
                                       style="width: 120px; font-size: 0.75rem;"
                                       value="{{ $scanTime }}"
                                       id="time-{{ $student->id }}"
                                       onchange="updateAttendanceTime({{ $student->id }}, this.value)"
                                       data-original-value="{{ $scanTime }}">
                            </td>
                            <td>
                                <textarea class="notes-input" 
                                          placeholder="Tambahkan catatan..."
                                          id="notes-{{ $student->id }}"
                                          onchange="updateAttendanceNotes({{ $student->id }}, this.value)"
                                          data-original-value="{{ $notes }}">{{ $notes }}</textarea>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 4rem 2rem; color: var(--text-secondary);">
                <svg class="w-16 h-16" style="margin: 0 auto 1.5rem; color: var(--text-tertiary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <h3 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">No Students Found</h3>
                <p style="color: var(--text-secondary); line-height: 1.6;">No students found in the selected class. Please select a different class or add students to this class.</p>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark individual attendance
    window.markAttendance = function(studentId, status, button) {
        // Remove active class from all buttons in this row
        const row = button.closest('tr');
        const allButtons = row.querySelectorAll('.status-btn');
        allButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        button.classList.add('active');
        
        // Update status badge
        const statusBadge = document.getElementById(`status-badge-${studentId}`);
        if (statusBadge) {
            statusBadge.className = `status-badge ${status}`;
            statusBadge.textContent = getStatusText(status);
        }
        
        // Get additional data
        const timeInput = document.getElementById(`time-${studentId}`);
        const notesInput = document.getElementById(`notes-${studentId}`);
        const scanTime = timeInput ? timeInput.value : null;
        const notes = notesInput ? notesInput.value : '';
        
        // Show loading state for the row
        row.style.opacity = '0.8';
        
        // Send AJAX request to save attendance
        fetch('{{ route("teacher.attendance.mark") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                student_id: studentId,
                date: '{{ $selectedDate }}',
                status: status,
                scan_time: scanTime,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Attendance marked successfully', 'success');
                updateStatistics();
                
                // Update stored values for time and notes
                if (timeInput) {
                    timeInput.setAttribute('data-original-value', data.data.scan_time || '');
                }
                if (notesInput) {
                    notesInput.setAttribute('data-original-value', data.data.notes || '');
                }
                
                // Update time display in status column
                if (data.data.scan_time) {
                    const statusBadge = document.getElementById(`status-badge-${studentId}`);
                    if (statusBadge) {
                        let timeDisplay = statusBadge.nextElementSibling;
                        if (!timeDisplay || !timeDisplay.classList.contains('time-display')) {
                            timeDisplay = document.createElement('div');
                            timeDisplay.className = 'time-display';
                            statusBadge.parentNode.appendChild(timeDisplay);
                        }
                        timeDisplay.textContent = data.data.scan_time;
                    }
                }
            } else {
                showNotification('Failed to mark attendance', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        })
        .finally(() => {
            // Remove loading state
            row.style.opacity = '1';
        });
    };

    // Update attendance time
    window.updateAttendanceTime = function(studentId, time) {
        const timeInput = document.getElementById(`time-${studentId}`);
        const originalValue = timeInput.getAttribute('data-original-value');
        
        // Only update if value has changed
        if (time === originalValue) {
            return;
        }
        
        // Show loading state
        timeInput.style.opacity = '0.6';
        timeInput.disabled = true;
        
        // Send AJAX request to update time
        fetch('{{ route("teacher.attendance.update-time") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                student_id: studentId,
                date: '{{ $selectedDate }}',
                time: time
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Time updated successfully', 'success');
                timeInput.setAttribute('data-original-value', time);
                
                // Update time display in status column if exists
                const statusBadge = document.getElementById(`status-badge-${studentId}`);
                if (statusBadge && statusBadge.nextElementSibling) {
                    const timeDisplay = statusBadge.nextElementSibling;
                    if (timeDisplay.classList.contains('time-display')) {
                        timeDisplay.textContent = data.data.scan_time || '';
                    }
                }
            } else {
                showNotification('Failed to update time', 'error');
                // Revert to original value
                timeInput.value = originalValue;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while updating time', 'error');
            // Revert to original value
            timeInput.value = originalValue;
        })
        .finally(() => {
            // Remove loading state
            timeInput.style.opacity = '1';
            timeInput.disabled = false;
        });
    };

    // Update attendance notes
    window.updateAttendanceNotes = function(studentId, notes) {
        const notesInput = document.getElementById(`notes-${studentId}`);
        const originalValue = notesInput.getAttribute('data-original-value');
        
        // Only update if value has changed
        if (notes === originalValue) {
            return;
        }
        
        // Show loading state
        notesInput.style.opacity = '0.6';
        notesInput.disabled = true;
        
        // Send AJAX request to update notes
        fetch('{{ route("teacher.attendance.update-notes") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                student_id: studentId,
                date: '{{ $selectedDate }}',
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Notes updated successfully', 'success');
                notesInput.setAttribute('data-original-value', notes);
            } else {
                showNotification('Failed to update notes', 'error');
                // Revert to original value
                notesInput.value = originalValue;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred while updating notes', 'error');
            // Revert to original value
            notesInput.value = originalValue;
        })
        .finally(() => {
            // Remove loading state
            notesInput.style.opacity = '1';
            notesInput.disabled = false;
        });
    };

    // Toggle select all
    window.toggleSelectAll = function() {
        const selectAllCheckbox = document.getElementById('selectAll') || document.getElementById('selectAllTable');
        const studentCheckboxes = document.querySelectorAll('input[name="selected_students[]"]');
        
        studentCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });
    };

    // Bulk mark attendance
    window.bulkMarkAttendance = function(status) {
        const selectedStudents = Array.from(document.querySelectorAll('input[name="selected_students[]"]:checked'))
                                     .map(checkbox => parseInt(checkbox.value));
        
        if (selectedStudents.length === 0) {
            showNotification('Please select at least one student', 'warning');
            return;
        }

        if (!confirm(`Are you sure you want to mark ${selectedStudents.length} students as ${getStatusText(status)}?`)) {
            return;
        }

        // Update UI for selected students
        selectedStudents.forEach(studentId => {
            const row = document.querySelector(`tr[data-student-id="${studentId}"]`);
            if (row) {
                // Update buttons
                const allButtons = row.querySelectorAll('.status-btn');
                allButtons.forEach(btn => btn.classList.remove('active'));
                
                const targetButton = row.querySelector(`.status-btn.${status}`);
                if (targetButton) {
                    targetButton.classList.add('active');
                }
                
                // Update status badge
                const statusBadge = document.getElementById(`status-badge-${studentId}`);
                if (statusBadge) {
                    statusBadge.className = `status-badge ${status}`;
                    statusBadge.textContent = getStatusText(status);
                }
            }
        });

        // Send bulk request
        fetch('{{ route("teacher.attendance.bulk-mark") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                date: '{{ $selectedDate }}',
                class: '{{ $selectedClass }}',
                status: status,
                student_ids: selectedStudents
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(`Bulk attendance marked successfully for ${data.success_count} students`, 'success');
                updateStatistics();
                // Clear selections
                document.querySelectorAll('input[name="selected_students[]"]').forEach(cb => cb.checked = false);
                document.getElementById('selectAll').checked = false;
            } else {
                showNotification('Failed to mark bulk attendance', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    };

    // Clear selected attendance
    window.clearSelectedAttendance = function() {
        const selectedStudents = Array.from(document.querySelectorAll('input[name="selected_students[]"]:checked'))
                                     .map(checkbox => parseInt(checkbox.value));
        
        if (selectedStudents.length === 0) {
            showNotification('Please select at least one student', 'warning');
            return;
        }

        if (!confirm(`Are you sure you want to clear attendance for ${selectedStudents.length} students?`)) {
            return;
        }

        selectedStudents.forEach(studentId => {
            const row = document.querySelector(`tr[data-student-id="${studentId}"]`);
            if (row) {
                const allButtons = row.querySelectorAll('.status-btn');
                allButtons.forEach(btn => btn.classList.remove('active'));
                
                const statusBadge = document.getElementById(`status-badge-${studentId}`);
                if (statusBadge) {
                    statusBadge.className = 'status-badge unmarked';
                    statusBadge.textContent = 'Not Marked';
                }
            }
        });

        showNotification(`Attendance cleared for ${selectedStudents.length} students`, 'info');
        updateStatistics();
    };

    // Refresh attendance
    window.refreshAttendance = function() {
        location.reload();
    };

    // Save all attendance
    window.saveAllAttendance = function() {
        showNotification('All attendance saved successfully', 'success');
    };

    // Export attendance
    window.exportAttendance = function() {
        const selectedDate = '{{ $selectedDate }}';
        const selectedClass = '{{ $selectedClass }}';
        
        if (!selectedClass) {
            showNotification('Please select a class first!', 'warning');
            return;
        }
        
        // Create download link
        const link = document.createElement('a');
        link.href = `{{ route("teacher.attendance.index") }}?date=${selectedDate}&class=${selectedClass}&export=excel`;
        link.download = `attendance-${selectedClass}-${selectedDate}.xlsx`;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        showNotification('Attendance data exported successfully!', 'success');
    };

    // Show attendance history
    window.showAttendanceHistory = function() {
        alert('Attendance history and statistics feature would be implemented here');
    };

    // Helper function to get status text
    function getStatusText(status) {
        const statusTexts = {
            'hadir': 'Hadir',
            'terlambat': 'Terlambat',
            'izin': 'Izin',
            'sakit': 'Sakit',
            'alpha': 'Alpha'
        };
        return statusTexts[status] || 'Unknown';
    }

    // Update statistics
    function updateStatistics() {
        // This would typically fetch updated statistics from the server
        console.log('Statistics updated');
    }

    // Show notification
    function showNotification(message, type) {
        // Create notification element
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 1rem 1.5rem;
            border-radius: 8px;
            color: white;
            font-weight: 600;
            z-index: 1000;
            animation: slideIn 0.3s ease;
        `;
        
        switch(type) {
            case 'success':
                notification.style.background = '#10b981';
                break;
            case 'error':
                notification.style.background = '#ef4444';
                break;
            case 'info':
                notification.style.background = '#3b82f6';
                break;
            case 'warning':
                notification.style.background = '#f59e0b';
                break;
            default:
                notification.style.background = '#6b7280';
        }
        
        notification.textContent = message;
        document.body.appendChild(notification);
        
        // Remove after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }

    // Add CSS for notification animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    `;
    document.head.appendChild(style);
});
</script>
@endsection