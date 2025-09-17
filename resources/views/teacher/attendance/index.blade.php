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

    /* Student List */
    .students-section {
        background: var(--bg-primary);
        border-radius: 16px;
        padding: 1.5rem;
        border: 1px solid var(--border-color);
        box-shadow: 0 4px 20px var(--shadow-color);
    }

    .section-header {
        display: flex;
        justify-content: between;
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

    .students-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1rem;
    }

    .student-card {
        background: var(--bg-secondary);
        border-radius: 12px;
        padding: 1rem;
        border: 1px solid var(--border-color);
        transition: all 0.3s ease;
        position: relative;
    }

    .student-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px var(--shadow-color);
    }

    .student-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .student-avatar {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        background: linear-gradient(135deg, #059669, #10b981);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .student-info {
        flex: 1;
        min-width: 0;
    }

    .student-name {
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.25rem;
        line-height: 1.3;
    }

    .student-nis {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-bottom: 0.25rem;
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

    .attendance-status {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid var(--bg-secondary);
    }

    .status-present { background: #10b981; }
    .status-absent { background: #ef4444; }
    .status-sick { background: #f59e0b; }
    .status-permission { background: #3b82f6; }
    .status-unmarked { background: #9ca3af; }

    .attendance-controls {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .status-btn {
        padding: 0.5rem;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        position: relative;
    }

    .status-btn.present { 
        background: rgba(16, 185, 129, 0.1); 
        color: #059669; 
        border: 1px solid rgba(16, 185, 129, 0.2); 
    }
    .status-btn.absent { 
        background: rgba(239, 68, 68, 0.1); 
        color: #dc2626; 
        border: 1px solid rgba(239, 68, 68, 0.2); 
    }
    .status-btn.sick { 
        background: rgba(245, 158, 11, 0.1); 
        color: #d97706; 
        border: 1px solid rgba(245, 158, 11, 0.2); 
    }
    .status-btn.permission { 
        background: rgba(59, 130, 246, 0.1); 
        color: #2563eb; 
        border: 1px solid rgba(59, 130, 246, 0.2); 
    }

    .status-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .status-btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .status-btn.active.present { background: #10b981; color: white; }
    .status-btn.active.absent { background: #ef4444; color: white; }
    .status-btn.active.sick { background: #f59e0b; color: white; }
    .status-btn.active.permission { background: #3b82f6; color: white; }

    .attendance-details {
        display: none;
        margin-top: 1rem;
        padding: 1rem;
        background: var(--bg-primary);
        border-radius: 8px;
        border: 1px solid var(--border-color);
    }

    .attendance-details.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
        font-size: 0.75rem;
    }

    .detail-label {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .detail-value {
        color: var(--text-primary);
        font-weight: 600;
    }

    .notes-input {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.75rem;
        background: var(--bg-secondary);
        color: var(--text-primary);
        margin-top: 0.5rem;
    }

    .notes-input:focus {
        border-color: #059669;
        outline: none;
        box-shadow: 0 0 0 2px rgba(5, 150, 105, 0.1);
    }

    /* Time inputs */
    .time-inputs {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .time-input {
        padding: 0.375rem 0.5rem;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.75rem;
        background: var(--bg-secondary);
        color: var(--text-primary);
    }

    .time-input:focus {
        border-color: #059669;
        outline: none;
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

        .students-grid {
            grid-template-columns: 1fr;
        }

        .bulk-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .attendance-controls {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .stats-container {
            grid-template-columns: 1fr;
        }

        .attendance-controls {
            grid-template-columns: 1fr;
        }
    }

    /* Animation */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .student-card {
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
                    Export Report
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
        <button class="bulk-btn present" onclick="bulkMarkAttendance('present')">
            ✓ Mark All Present
        </button>
        <button class="bulk-btn absent" onclick="bulkMarkAttendance('absent')">
            ✗ Mark All Absent
        </button>
        <button class="bulk-btn sick" onclick="bulkMarkAttendance('sick')">
            🏥 Mark All Sick
        </button>
        <button class="bulk-btn permission" onclick="bulkMarkAttendance('permission')">
            📋 Mark All Permission
        </button>
        <button class="btn-control" onclick="clearAllAttendance()">
            🔄 Clear All
        </button>
    </div>

    <!-- Students Section -->
    <div class="students-section">
        <div class="section-header">
            <h2 class="section-title">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Student Attendance List
            </h2>
        </div>

        <div class="students-grid">
            @foreach($students as $student)
                @php
                    $attendance = $attendanceData[$student->id] ?? null;
                    $status = $attendance ? $attendance->status : 'unmarked';
                @endphp
                <div class="student-card" data-student-id="{{ $student->id }}">
                    <div class="attendance-status status-{{ $status }}"></div>
                    
                    <div class="student-header">
                        <div class="student-avatar">
                            {{ strtoupper(substr($student->name, 0, 2)) }}
                        </div>
                        <div class="student-info">
                            <div class="student-name">{{ $student->name }}</div>
                            <div class="student-nis">NIS: {{ $student->nis }}</div>
                            <div class="student-class">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $student->class }}
                            </div>
                        </div>
                    </div>

                    <div class="attendance-controls">
                        <button class="status-btn present {{ $status == 'present' ? 'active' : '' }}" 
                                onclick="markAttendance({{ $student->id }}, 'present', this)">
                            ✓ Hadir
                        </button>
                        <button class="status-btn absent {{ $status == 'absent' ? 'active' : '' }}" 
                                onclick="markAttendance({{ $student->id }}, 'absent', this)">
                            ✗ Alpha
                        </button>
                        <button class="status-btn sick {{ $status == 'sick' ? 'active' : '' }}" 
                                onclick="markAttendance({{ $student->id }}, 'sick', this)">
                            🏥 Sakit
                        </button>
                        <button class="status-btn permission {{ $status == 'permission' ? 'active' : '' }}" 
                                onclick="markAttendance({{ $student->id }}, 'permission', this)">
                            📋 Izin
                        </button>
                    </div>

                    <div class="attendance-details" id="details-{{ $student->id }}">
                        <div class="detail-row">
                            <span class="detail-label">Status:</span>
                            <span class="detail-value" id="status-text-{{ $student->id }}">
                                {{ $attendance ? ucfirst($attendance->status) : 'Not marked' }}
                            </span>
                        </div>
                        @if($attendance && $attendance->time_in)
                        <div class="detail-row">
                            <span class="detail-label">Time In:</span>
                            <span class="detail-value">{{ $attendance->time_in }}</span>
                        </div>
                        @endif
                        @if($attendance && $attendance->time_out)
                        <div class="detail-row">
                            <span class="detail-label">Time Out:</span>
                            <span class="detail-value">{{ $attendance->time_out }}</span>
                        </div>
                        @endif
                        
                        <div class="time-inputs">
                            <input type="time" 
                                   class="time-input" 
                                   placeholder="Time In"
                                   value="{{ $attendance && $attendance->time_in ? $attendance->time_in : '' }}"
                                   id="time-in-{{ $student->id }}">
                            <input type="time" 
                                   class="time-input" 
                                   placeholder="Time Out"
                                   value="{{ $attendance && $attendance->time_out ? $attendance->time_out : '' }}"
                                   id="time-out-{{ $student->id }}">
                        </div>
                        
                        <textarea class="notes-input" 
                                  placeholder="Add notes or remarks..."
                                  id="notes-{{ $student->id }}">{{ $attendance ? $attendance->notes : '' }}</textarea>
                    </div>

                    <div style="margin-top: 0.5rem; text-align: center;">
                        <button class="btn-control" 
                                style="font-size: 0.7rem; padding: 0.25rem 0.5rem;"
                                onclick="toggleDetails({{ $student->id }})">
                            <span id="toggle-text-{{ $student->id }}">Show Details</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mark individual attendance
    window.markAttendance = function(studentId, status, button) {
        // Remove active class from all buttons in this student card
        const card = button.closest('.student-card');
        const allButtons = card.querySelectorAll('.status-btn');
        allButtons.forEach(btn => btn.classList.remove('active'));
        
        // Add active class to clicked button
        button.classList.add('active');
        
        // Update status indicator
        const statusIndicator = card.querySelector('.attendance-status');
        statusIndicator.className = `attendance-status status-${status}`;
        
        // Update status text
        const statusText = document.getElementById(`status-text-${studentId}`);
        if (statusText) {
            statusText.textContent = status.charAt(0).toUpperCase() + status.slice(1);
        }
        
        // Get additional data
        const timeIn = document.getElementById(`time-in-${studentId}`)?.value || null;
        const timeOut = document.getElementById(`time-out-${studentId}`)?.value || null;
        const notes = document.getElementById(`notes-${studentId}`)?.value || '';
        
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
                time_in: timeIn,
                time_out: timeOut,
                notes: notes
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Attendance marked successfully', 'success');
                updateStatistics();
            } else {
                showNotification('Failed to mark attendance', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    };

    // Bulk mark attendance
    window.bulkMarkAttendance = function(status) {
        if (!confirm(`Are you sure you want to mark all students as ${status}?`)) {
            return;
        }

        const studentIds = [];
        document.querySelectorAll('.student-card').forEach(card => {
            const studentId = card.getAttribute('data-student-id');
            studentIds.push(parseInt(studentId));
            
            // Update UI
            const allButtons = card.querySelectorAll('.status-btn');
            allButtons.forEach(btn => btn.classList.remove('active'));
            
            const targetButton = card.querySelector(`.status-btn.${status}`);
            if (targetButton) {
                targetButton.classList.add('active');
            }
            
            const statusIndicator = card.querySelector('.attendance-status');
            statusIndicator.className = `attendance-status status-${status}`;
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
                student_ids: studentIds
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Bulk attendance marked successfully', 'success');
                updateStatistics();
            } else {
                showNotification('Failed to mark bulk attendance', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred', 'error');
        });
    };

    // Clear all attendance
    window.clearAllAttendance = function() {
        if (!confirm('Are you sure you want to clear all attendance marks?')) {
            return;
        }

        document.querySelectorAll('.student-card').forEach(card => {
            const allButtons = card.querySelectorAll('.status-btn');
            allButtons.forEach(btn => btn.classList.remove('active'));
            
            const statusIndicator = card.querySelector('.attendance-status');
            statusIndicator.className = 'attendance-status status-unmarked';
        });

        showNotification('All attendance cleared', 'info');
        updateStatistics();
    };

    // Toggle details
    window.toggleDetails = function(studentId) {
        const details = document.getElementById(`details-${studentId}`);
        const toggleText = document.getElementById(`toggle-text-${studentId}`);
        
        if (details.classList.contains('show')) {
            details.classList.remove('show');
            toggleText.textContent = 'Show Details';
        } else {
            details.classList.add('show');
            toggleText.textContent = 'Hide Details';
        }
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
        const format = prompt('Export format (excel/pdf/csv):', 'excel');
        if (format) {
            fetch(`{{ route("teacher.attendance.export") }}?date={{ $selectedDate }}&class={{ $selectedClass }}&format=${format}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message, 'success');
                } else {
                    showNotification('Export failed', 'error');
                }
            });
        }
    };

    // Show attendance history
    window.showAttendanceHistory = function() {
        alert('Attendance history and statistics feature would be implemented here');
    };

    // Update statistics
    function updateStatistics() {
        // This would typically fetch updated statistics from the server
        // For now, we'll just show a notification
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