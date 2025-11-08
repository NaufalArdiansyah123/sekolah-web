@extends('layouts.teacher')

@section('title', 'Student Attendance Management')

@section('content')
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #2563eb;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #06b6d4;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
        }

        body {
            background: #f8fafc;
            font-family: 'Inter', -apple-system, sans-serif;
        }

        .attendance-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Simple Header */
        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            margin: 0 0 0.5rem 0;
        }

        .page-subtitle {
            color: var(--gray-600);
            font-size: 0.95rem;
        }

        /* Compact Controls */
        .controls-wrapper {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .controls-row {
            display: flex;
            gap: 1rem;
            align-items: end;
            flex-wrap: wrap;
        }

        .control-item {
            flex: 1;
            min-width: 180px;
        }

        .control-item label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .control-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }

        .control-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn svg {
            width: 18px;
            height: 18px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: white;
            color: var(--gray-700);
            border: 1px solid var(--gray-300);
        }

        .btn-secondary:hover {
            background: var(--gray-50);
        }

        /* Minimal Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            padding: 1.25rem;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        /* Clean Bulk Actions */
        .bulk-bar {
            background: white;
            padding: 1rem 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .bulk-bar label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .bulk-btn {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            border: 1px solid var(--gray-300);
            background: white;
            color: var(--gray-700);
        }

        .bulk-btn:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        /* Modern Table */
        .table-wrapper {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .table-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .table-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            margin: 0;
        }

        .attendance-table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table th {
            background: var(--gray-50);
            padding: 0.875rem 1rem;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-700);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid var(--gray-200);
        }

        .attendance-table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-100);
            font-size: 0.875rem;
        }

        .attendance-table tr:hover td {
            background: var(--gray-50);
        }

        .attendance-table tr:last-child td {
            border-bottom: none;
        }

        /* Student Info - Simpler */
        .student-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .student-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: linear-gradient(135deg, var(--primary), var(--info));
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .student-name {
            font-weight: 500;
            color: var(--gray-900);
            font-size: 0.875rem;
        }

        .student-nis {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* Minimal Status Badge */
        .status-badge {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-badge.unmarked {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .status-badge.hadir {
            background: #d1fae5;
            color: #065f46;
        }

        .status-badge.terlambat {
            background: #fef3c7;
            color: #92400e;
        }

        .status-badge.izin {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-badge.sakit {
            background: #fed7aa;
            color: #9a3412;
        }

        .status-badge.alpha {
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-info {
            background-color: #3b82f6;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.2s;
        }

        .btn-info:hover {
            background-color: #2563eb;
            color: white;
        }

        .btn-info {
            background-color: var(--info);
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.2s;
            text-decoration: none;
        }

        .btn-info:hover {
            background-color: #0891b2;
        }

        .text-gray-400 {
            color: var(--gray-400);
        }

        /* Compact Status Buttons */
        .status-buttons {
            display: flex;
            gap: 0.375rem;
        }

        .status-btn {
            padding: 0.375rem 0.75rem;
            border: 1px solid var(--gray-300);
            background: white;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            color: var(--gray-700);
        }

        .status-btn:hover {
            background: var(--gray-50);
        }

        .status-btn.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        /* Simple Inputs */
        .notes-input {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            font-size: 0.8125rem;
            resize: vertical;
            min-height: 32px;
            transition: all 0.2s;
        }

        .notes-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        input[type="time"] {
            padding: 0.375rem 0.625rem;
            border: 1px solid var(--gray-200);
            border-radius: 6px;
            font-size: 0.8125rem;
            width: 100px;
            transition: all 0.2s;
        }

        input[type="time"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .time-display {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .student-checkbox {
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            margin: 0 auto 1rem;
            color: var(--gray-400);
        }

        .empty-state h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .attendance-container {
                padding: 1rem;
            }

            .controls-row {
                flex-direction: column;
            }

            .control-item {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .attendance-table {
                font-size: 0.8125rem;
            }

            .attendance-table th,
            .attendance-table td {
                padding: 0.75rem 0.5rem;
            }

            .status-buttons {
                flex-direction: column;
            }

            .status-btn {
                width: 100%;
            }
        }
    </style>

    <div class="attendance-container">
        <!-- Simple Header -->
        <div class="page-header">
            <h1 class="page-title">Student Attendance</h1>
            <p class="page-subtitle">{{ \Carbon\Carbon::parse($selectedDate)->format('l, d F Y') }} • Class
                {{ $selectedClass }} • {{ count($students) }} Students
            </p>
        </div>

        <!-- Compact Controls -->
        <div class="controls-wrapper">
            <form method="GET" action="{{ route('teacher.attendance.index') }}" id="attendanceForm">
                <div class="controls-row">
                    <div class="control-item">
                        <label>Date</label>
                        <input type="date" name="date" value="{{ $selectedDate }}" class="control-input"
                            onchange="document.getElementById('attendanceForm').submit()">
                    </div>
                    <div class="control-item">
                        <label>Class</label>
                        <select name="class" class="control-input"
                            onchange="document.getElementById('attendanceForm').submit()">
                            @foreach($classes as $class)
                                <option value="{{ $class }}" {{ $selectedClass == $class ? 'selected' : '' }}>
                                    {{ $class }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="control-item" style="flex: 0 0 auto;">
                        <button type="button" class="btn btn-secondary" onclick="refreshAttendance()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Refresh
                        </button>
                    </div>
                    <div class="control-item" style="flex: 0 0 auto;">
                        <button type="button" class="btn btn-primary" onclick="exportAttendance()">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Export
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Minimal Stats -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-value" style="color: var(--success);">{{ $statistics['present'] }}</div>
                <div class="stat-label">Present</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--danger);">{{ $statistics['absent'] }}</div>
                <div class="stat-label">Absent</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--warning);">{{ $statistics['sick'] }}</div>
                <div class="stat-label">Sick</div>
            </div>
            <div class="stat-card">
                <div class="stat-value" style="color: var(--info);">{{ $statistics['permission'] }}</div>
                <div class="stat-label">Permission</div>
            </div>
        </div>



        <!-- Modern Table -->
        <div class="table-wrapper">
            <div class="table-header">
                <h2 class="table-title">Student List ({{ count($students) }})</h2>
            </div>

            @if(count($students) > 0)
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Class</th>
                            <th>Status</th>
                            <th>Status Info</th>
                            <th>Time</th>
                            <th>Document</th>
                            <th>Notes</th>
                            <th>Actions</th>
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
                            <tr>
                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="student-name">{{ $student->name }}</div>
                                            <div class="student-nis">{{ $student->nis }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $student->class ? $student->class->name : 'No Class' }}</td>
                                <td>
                                    <div class="status-badge {{ $status }}">
                                        @if($attendance)
                                            {{ $attendance->status_text }}
                                        @else
                                            Not Marked
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($attendance && ($attendance->status === 'izin' || $attendance->status === 'sakit'))
                                        @if($attendance->document_path)
                                            <a href="{{ Storage::url($attendance->document_path) }}" target="_blank" class="btn btn-info"
                                                style="padding: 0.3rem 0.8rem; font-size: 0.8em;">
                                                <i class="fas fa-file-alt mr-1"></i>
                                                Lihat Surat
                                            </a>
                                        @else
                                            <span class="text-gray-400" style="font-size: 0.8em;">Belum ada surat</span>
                                        @endif
                                    @endif
                                    @if($attendance && $attendance->scan_time)
                                        <div class="time-display">
                                            {{ $attendance->scan_time->format('H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="time-display">
                                        {{ $scanTime ?: '-' }}
                                    </div>
                                </td>
                                <td>
                                    @if($attendance && $attendance->document_path)
                                        <a href="{{ Storage::url($attendance->document_path) }}" target="_blank" class="btn btn-info"
                                            style="padding: 0.3rem 0.8rem; font-size: 0.8em;">
                                            Lihat Surat
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round"
                                                style="display: inline-block; vertical-align: middle; margin-left: 4px;">
                                                <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                                                <polyline points="15 3 21 3 21 9"></polyline>
                                                <line x1="10" y1="14" x2="21" y2="3"></line>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-gray-400" style="font-size: 0.8em;">Belum ada surat</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="font-size: 0.875rem; color: var(--gray-700);">
                                        {{ $notes ?: '-' }}
                                    </div>
                                </td>
                                <td>
                                    <!-- Actions column - can be used for future actions like edit, delete, etc. -->
                                    <div style="font-size: 0.875rem; color: var(--gray-400);">
                                        -
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h3>No Students Found</h3>
                    <p>No students found in the selected class.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.refreshAttendance = function () { location.reload(); };

            window.exportAttendance = function () {
                const selectedDate = '{{ $selectedDate }}';
                const selectedClass = '{{ $selectedClass }}';
                if (!selectedClass) {
                    showNotification('Please select a class first!', 'warning');
                    return;
                }
                const link = document.createElement('a');
                link.href = `{{ route("teacher.attendance.index") }}?date=${selectedDate}&class=${selectedClass}&export=excel`;
                link.download = `attendance-${selectedClass}-${selectedDate}.xlsx`;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                showNotification('Attendance data exported successfully!', 'success');
            };

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.style.cssText = `
                                    position: fixed;
                                    top: 20px;
                                    right: 20px;
                                    padding: 1rem 1.5rem;
                                    border-radius: 10px;
                                    color: white;
                                    font-weight: 500;
                                    font-size: 0.875rem;
                                    z-index: 1000;
                                    animation: slideIn 0.3s ease;
                                    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                                `;
                switch (type) {
                    case 'success': notification.style.background = '#10b981'; break;
                    case 'error': notification.style.background = '#ef4444'; break;
                    case 'info': notification.style.background = '#3b82f6'; break;
                    case 'warning': notification.style.background = '#f59e0b'; break;
                    default: notification.style.background = '#6b7280';
                }
                notification.textContent = message;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            }

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