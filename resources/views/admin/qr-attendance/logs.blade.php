@extends('layouts.admin')

@section('title', 'Log Absensi Siswa')

@section('content')
    <style>
        /* Modern Table Styling */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
            --accent-color: #3b82f6;
            --success-color: #10b981;
            --warning-color: #f59e0b;
        }

        .dark {
            --bg-primary: #1e293b;
            --bg-secondary: #0f172a;
            --bg-tertiary: #334155;
            --text-primary: #f1f5f9;
            --text-secondary: #94a3b8;
            --border-color: #334155;
        }

        .attendance-container {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 2rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .stat-content h3 {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0 0 0.25rem 0;
            font-weight: 500;
        }

        .stat-content p {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .filter-card {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .filter-form {
            display: grid;
            grid-template-columns: 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-primary);
            color: var(--text-primary);
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-color);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .btn {
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--accent-color);
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-success {
            background: var(--success-color);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .class-section {
            margin-bottom: 2rem;
        }

        .class-header {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px 12px 0 0;
            padding: 1.25rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .class-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .class-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: var(--text-primary);
        }

        .class-details h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.25rem 0;
        }

        .class-details p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .class-stats {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .stat-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .stat-badge.confirmed {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .stat-badge.pending {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .attendance-table {
            width: 100%;
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-top: none;
            border-radius: 0 0 12px 12px;
            overflow: hidden;
        }

        .attendance-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .attendance-table thead {
            background: var(--bg-tertiary);
        }

        .attendance-table th {
            padding: 1rem 1.5rem;
            text-align: left;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .attendance-table tbody tr {
            border-top: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .attendance-table tbody tr:hover {
            background: var(--bg-tertiary);
        }

        .attendance-table td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .student-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .student-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--border-color);
        }

        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--bg-tertiary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--text-primary);
            border: 2px solid var(--border-color);
        }

        .student-details {
            display: flex;
            flex-direction: column;
        }

        .student-name {
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.125rem;
        }

        .student-nis {
            font-size: 0.8125rem;
            color: var(--text-secondary);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .status-badge.hadir {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success-color);
        }

        .status-badge.terlambat {
            background: rgba(245, 158, 11, 0.1);
            color: var(--warning-color);
        }

        .status-badge.izin {
            background: rgba(59, 130, 246, 0.1);
            color: var(--accent-color);
        }

        .status-badge.sakit {
            background: rgba(139, 92, 246, 0.1);
            color: #8b5cf6;
        }

        .status-badge.alpha {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        .time-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            background: var(--bg-tertiary);
            color: var(--text-secondary);
            font-size: 0.8125rem;
            font-weight: 500;
        }

        .confirmation-status {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            font-size: 0.8125rem;
        }

        .confirmation-status.confirmed {
            color: var(--success-color);
        }

        .confirmation-status.unconfirmed {
            color: var(--warning-color);
        }

        .doc-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.375rem 0.75rem;
            border-radius: 6px;
            background: var(--accent-color);
            color: white;
            font-size: 0.8125rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .doc-link:hover {
            background: #2563eb;
        }

        .notes-section {
            margin-top: 0.5rem;
            padding: 0.75rem;
            background: var(--bg-tertiary);
            border-radius: 6px;
            font-size: 0.8125rem;
            color: var(--text-secondary);
            display: flex;
            gap: 0.5rem;
        }

        .empty-state {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state i {
            font-size: 4rem;
            color: var(--text-secondary);
            opacity: 0.5;
            margin-bottom: 1rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: var(--text-secondary);
            margin-bottom: 1.5rem;
        }

        @media (max-width: 1024px) {
            .filter-form {
                grid-template-columns: 1fr;
            }

            .attendance-table {
                overflow-x: auto;
            }

            .class-stats {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }
        }

        @media (max-width: 768px) {
            .attendance-container {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .class-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        /* Smooth animations */
        .class-section {
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Document Modal Styles */
        #documentModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            animation: fadeIn 0.3s ease;
        }

        #documentModal.show {
            display: flex;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .modal-content {
            background: var(--bg-primary);
            border-radius: 16px;
            width: 95vw;
            height: 95vh;
            max-width: 1400px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: slideUp 0.3s ease;
        }

        .modal-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-secondary);
        }

        .modal-header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(59, 130, 246, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-color);
            font-size: 1.25rem;
        }

        .modal-title-wrapper h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.25rem 0;
        }

        .modal-title-wrapper p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .modal-actions {
            display: flex;
            gap: 0.75rem;
            align-items: center;
        }

        .modal-btn {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1.125rem;
        }

        .modal-btn-download {
            background: var(--accent-color);
            color: white;
        }

        .modal-btn-download:hover {
            background: #2563eb;
            transform: translateY(-2px);
        }

        .modal-btn-fullscreen {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .modal-btn-fullscreen:hover {
            background: var(--border-color);
        }

        .modal-close {
            background: var(--bg-tertiary);
            color: var(--text-secondary);
        }

        .modal-close:hover {
            background: #ef4444;
            color: white;
        }

        .modal-body {
            flex: 1;
            overflow: hidden;
            position: relative;
            background: var(--bg-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-body iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: white;
        }

        .modal-loading {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            z-index: 1;
        }

        .modal-loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid var(--border-color);
            border-top-color: var(--accent-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .modal-loading-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .modal-footer {
            padding: 1rem 2rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--bg-secondary);
        }

        .modal-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .modal-info i {
            color: var(--accent-color);
        }

        /* Fullscreen mode */
        #documentModal.fullscreen .modal-content {
            width: 100vw;
            height: 100vh;
            max-width: none;
            border-radius: 0;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .modal-content {
                width: 100vw;
                height: 100vh;
                border-radius: 0;
            }

            .modal-header {
                padding: 1rem;
            }

            .modal-header-content {
                gap: 0.75rem;
            }

            .modal-icon {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .modal-title-wrapper h3 {
                font-size: 1rem;
            }

            .modal-title-wrapper p {
                font-size: 0.8125rem;
            }

            .modal-btn {
                width: 36px;
                height: 36px;
                font-size: 1rem;
            }

            .modal-footer {
                padding: 0.75rem 1rem;
            }

            .modal-info {
                font-size: 0.8125rem;
            }
        }

        /* Print styles for modal */
        @media print {
            #documentModal {
                position: static;
                background: white;
            }

            .modal-header,
            .modal-footer,
            .modal-actions {
                display: none !important;
            }

            .modal-content {
                box-shadow: none;
                border-radius: 0;
            }

            .modal-body {
                height: auto;
            }
        }
    </style>

    <div class="attendance-container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--text-primary); margin: 0 0 0.5rem 0;">
                Log Absensi Siswa
            </h1>
            <p style="color: var(--text-secondary); margin: 0;">
                Kelola dan pantau log absensi siswa per kelas
            </p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: var(--success-color);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h3>Dikonfirmasi</h3>
                    <p>{{ $totalConfirmed }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: var(--warning-color);">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-content">
                    <h3>Belum Dikonfirmasi</h3>
                    <p>{{ $totalUnconfirmed }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: var(--accent-color);">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Hadir</h3>
                    <p>{{ $totalPresent }}</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(139, 92, 246, 0.1); color: #8b5cf6;">
                    <i class="fas fa-school"></i>
                </div>
                <div class="stat-content">
                    <h3>Total Kelas</h3>
                    <p>{{ $attendanceByClass->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="filter-card">
            <form method="GET" action="{{ route('admin.qr-attendance.logs') }}" class="filter-form">
                <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" id="date" name="date" value="{{ $date }}" class="form-control">
                </div>

                <div class="form-group">
                    <label for="class_id">Kelas</label>
                    <select id="class_id" name="class_id" class="form-control">
                        <option value="">Semua Kelas</option>
                        @foreach($filterClasses as $class)
                            <option value="{{ $class->id }}" {{ $classId == $class->id ? 'selected' : '' }}>
                                {{ $class->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="display: flex; gap: 0.75rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Filter
                    </button>
                    <a href="{{ route('admin.qr-attendance.logs', ['export' => 'csv'] + request()->query()) }}"
                        class="btn btn-success">
                        <i class="fas fa-download"></i>
                        Export
                    </a>
                </div>
            </form>
        </div>

        <!-- Class Tables -->
        @if($attendanceByClass->count() > 0)
            @foreach($attendanceByClass as $classData)
                <div class="class-section">
                    <!-- Class Header -->
                    <div class="class-header">
                        <div class="class-info">
                            <div class="class-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="class-details">
                                <h3>{{ $classData['class']->name }}</h3>
                                <p>{{ $classData['total_count'] }} siswa terdaftar</p>
                            </div>
                        </div>

                    </div>

                    <!-- Attendance Table -->
                    <div class="attendance-table">
                        <table>
                            <thead>
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th style="width: 35%;">Siswa</th>
                                    <th style="width: 15%;">Status</th>
                                    <th style="width: 15%;">Waktu Scan</th>
                                    <th style="width: 30%;">Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp

                                {{-- Unconfirmed Students First --}}
                                @foreach($classData['unconfirmed_students'] as $student)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>
                                            <div class="student-info">
                                                @if($student->photo_url)
                                                    <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" class="student-avatar">
                                                @else
                                                    <div class="avatar-placeholder">
                                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                                    </div>
                                                @endif
                                                <div class="student-details">
                                                    <span class="student-name">{{ $student->name }}</span>
                                                    <span class="student-nis">{{ $student->nis }}</span>
                                                </div>
                                            </div>
                                            @if($student->notes)
                                                <div class="notes-section">
                                                    <i class="fas fa-sticky-note"></i>
                                                    <span>{{ $student->notes }}</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match ($student->status) {
                                                    'hadir' => 'hadir',
                                                    'terlambat' => 'terlambat',
                                                    'izin' => 'izin',
                                                    'sakit' => 'sakit',
                                                    default => 'alpha'
                                                };
                                                $statusIcon = match ($student->status) {
                                                    'hadir' => 'check',
                                                    'terlambat' => 'clock',
                                                    'izin' => 'info-circle',
                                                    'sakit' => 'medkit',
                                                    default => 'times'
                                                };
                                                $statusText = match ($student->status) {
                                                    'hadir' => 'Hadir',
                                                    'terlambat' => 'Terlambat',
                                                    'izin' => 'Izin',
                                                    'sakit' => 'Sakit',
                                                    default => 'Alpha'
                                                };
                                            @endphp
                                            <span class="status-badge {{ $statusClass }}">
                                                <i class="fas fa-{{ $statusIcon }}"></i>
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($student->scan_time)
                                                <span class="time-badge">
                                                    <i class="fas fa-clock"></i>
                                                    {{ \Carbon\Carbon::parse($student->scan_time)->format('H:i') }}
                                                </span>
                                            @else
                                                <span style="color: var(--text-secondary);">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(($student->status === 'izin' || $student->status === 'sakit') && !empty($student->document_path))
                                                <button type="button" class="doc-link" style="border: none;"
                                                    onclick="viewDocument({{ $student->log_id }}, '{{ $student->status }}', '{{ addslashes($student->name) }}')">
                                                    <i class="fas fa-file-alt"></i>
                                                    Lihat
                                                </button>
                                            @else
                                                <span style="color: var(--text-secondary);">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>Tidak ada data absensi</h3>
                <p>Tidak ada data absensi untuk tanggal {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                <a href="{{ route('admin.qr-attendance.logs', ['date' => date('Y-m-d')]) }}" class="btn btn-primary">
                    <i class="fas fa-calendar-day"></i>
                    Lihat Data Hari Ini
                </a>
            </div>
        @endif
    </div>

    <!-- Document Modal -->
    <div id="documentModal">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="modal-title-wrapper">
                        <h3 id="modal-title">Dokumen</h3>
                        <p id="modal-subtitle">Preview dokumen surat</p>
                    </div>
                </div>
                <div class="modal-actions">
                    <button class="modal-btn modal-btn-download" id="downloadBtn" title="Download">
                        <i class="fas fa-download"></i>
                    </button>
                    <button class="modal-btn modal-btn-fullscreen" id="fullscreenBtn" title="Fullscreen">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button class="modal-btn modal-close" onclick="closeDocumentModal()" title="Tutup">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <div class="modal-loading" id="modalLoading">
                    <div class="modal-loading-spinner"></div>
                    <span class="modal-loading-text">Memuat dokumen...</span>
                </div>
                <iframe id="documentFrame"></iframe>
            </div>
            <div class="modal-footer">
                <div class="modal-info">
                    <i class="fas fa-info-circle"></i>
                    <span>Tekan ESC untuk menutup • Klik di luar untuk menutup</span>
                </div>
                <div class="modal-info">
                    <i class="fas fa-file-pdf"></i>
                    <span id="documentSize">-</span>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        /**
         * View document in modal
         */
        window.viewDocument = async function (logId, status, studentName) {
            try {
                const modal = document.getElementById('documentModal');
                const modalTitle = document.getElementById('modal-title');
                const modalSubtitle = document.getElementById('modal-subtitle');
                const documentFrame = document.getElementById('documentFrame');
                const downloadBtn = document.getElementById('downloadBtn');
                const modalLoading = document.getElementById('modalLoading');

                // Update modal title
                const statusText = status === 'izin' ? 'Izin' : 'Sakit';
                modalTitle.textContent = `Surat ${statusText} - ${studentName}`;
                modalSubtitle.textContent = `Dokumen surat ${statusText.toLowerCase()} siswa`;

                // Show loading
                modalLoading.style.display = 'flex';
                documentFrame.style.opacity = '0';

                // Show modal
                modal.classList.add('show');
                document.body.style.overflow = 'hidden';

                // Set download button
                downloadBtn.onclick = function () {
                    downloadDocument(logId, status, studentName);
                };

                // Load document
                documentFrame.src = `/admin/qr-attendance/document/${logId}`;

                // Handle load complete
                documentFrame.onload = function () {
                    modalLoading.style.display = 'none';
                    documentFrame.style.opacity = '1';
                    documentFrame.style.transition = 'opacity 0.3s ease';
                };

                // Handle load error
                documentFrame.onerror = function () {
                    closeDocumentModal();
                    showNotification('Gagal memuat dokumen', 'error');
                };

            } catch (error) {
                console.error('Error:', error);
                closeDocumentModal();
                showNotification('Terjadi kesalahan saat mengambil dokumen', 'error');
            }
        }

        /**
         * Close document modal
         */
        window.closeDocumentModal = function () {
            const modal = document.getElementById('documentModal');
            const documentFrame = document.getElementById('documentFrame');
            const modalLoading = document.getElementById('modalLoading');

            modal.classList.remove('show');
            modal.classList.remove('fullscreen');
            document.body.style.overflow = '';

            // Reset after animation
            setTimeout(() => {
                documentFrame.src = '';
                modalLoading.style.display = 'flex';
                documentFrame.style.opacity = '0';
            }, 300);
        }

        /**
         * Download document
         */
        function downloadDocument(logId, status, studentName) {
            showNotification('Mengunduh dokumen...', 'info');

            const link = document.createElement('a');
            link.href = `/admin/qr-attendance/document/${logId}/download`;
            link.download = `surat-${status}-${studentName.replace(/\s+/g, '-').toLowerCase()}.pdf`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            setTimeout(() => {
                showNotification('Dokumen berhasil diunduh!', 'success');
            }, 1000);
        }

        /**
         * Toggle fullscreen mode
         */
        function toggleFullscreen() {
            const modal = document.getElementById('documentModal');
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            const icon = fullscreenBtn.querySelector('i');

            if (modal.classList.contains('fullscreen')) {
                modal.classList.remove('fullscreen');
                icon.className = 'fas fa-expand';
                fullscreenBtn.title = 'Fullscreen';
            } else {
                modal.classList.add('fullscreen');
                icon.className = 'fas fa-compress';
                fullscreenBtn.title = 'Exit Fullscreen';
            }
        }

        /**
         * Close modal when clicking outside
         */
        window.addEventListener('click', function (event) {
            const modal = document.getElementById('documentModal');
            if (event.target === modal) {
                closeDocumentModal();
            }
        });

        /**
         * Show notification
         */
        function showNotification(message, type = 'success') {
            const colors = {
                success: '#10b981',
                error: '#ef4444',
                info: '#3b82f6'
            };

            const icons = {
                success: 'fa-check-circle',
                error: 'fa-exclamation-circle',
                info: 'fa-info-circle'
            };

            const toast = document.createElement('div');
            toast.style.cssText = `
                            position: fixed;
                            bottom: 1.5rem;
                            right: 1.5rem;
                            background: white;
                            color: #1e293b;
                            padding: 1rem 1.5rem;
                            border-radius: 8px;
                            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
                            z-index: 1001;
                            display: flex;
                            align-items: center;
                            gap: 0.75rem;
                            border-left: 4px solid ${colors[type]};
                            opacity: 0;
                            transform: translateY(20px);
                            transition: all 0.3s ease;
                        `;

            toast.innerHTML = `
                            <i class="fas ${icons[type]}" style="color: ${colors[type]}; font-size: 1.25rem;"></i>
                            <span style="font-weight: 500;">${message}</span>
                        `;

            document.body.appendChild(toast);

            // Fade in
            setTimeout(() => {
                toast.style.opacity = '1';
                toast.style.transform = 'translateY(0)';
            }, 10);

            // Fade out and remove
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        /**
         * Export functionality
         */
        function exportData() {
            showNotification('Menyiapkan file CSV...', 'info');
            // The export is handled by the href link
            setTimeout(() => {
                showNotification('File CSV berhasil didownload!', 'success');
            }, 1500);
        }

        /**
         * Initialize on page load
         */
        document.addEventListener('DOMContentLoaded', function () {
            console.log('Attendance logs page loaded');

            // Add animation to tables on scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, {
                threshold: 0.1
            });

            document.querySelectorAll('.class-section').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'all 0.5s ease';
                observer.observe(section);
            });

            // Keyboard shortcuts
            document.addEventListener('keydown', function (e) {
                // ESC to close modal
                if (e.key === 'Escape') {
                    closeDocumentModal();
                }

                // F11 to toggle fullscreen (when modal is open)
                if (e.key === 'F11') {
                    const modal = document.getElementById('documentModal');
                    if (modal.classList.contains('show')) {
                        e.preventDefault();
                        toggleFullscreen();
                    }
                }
            });

            // Setup fullscreen button
            const fullscreenBtn = document.getElementById('fullscreenBtn');
            if (fullscreenBtn) {
                fullscreenBtn.addEventListener('click', toggleFullscreen);
            }
        });

        /**
         * Auto refresh for today's data
         */
        @if($date == date('Y-m-d'))
            let refreshInterval;

            function startAutoRefresh() {
                refreshInterval = setInterval(function () {
                    if (!document.hidden) {
                        const refreshBadge = document.createElement('div');
                        refreshBadge.style.cssText = `
                                                    position: fixed;
                                                    top: 1.5rem;
                                                    right: 1.5rem;
                                                    background: var(--accent-color);
                                                    color: white;
                                                    padding: 0.75rem 1.25rem;
                                                    border-radius: 8px;
                                                    font-size: 0.875rem;
                                                    font-weight: 500;
                                                    z-index: 1001;
                                                    display: flex;
                                                    align-items: center;
                                                    gap: 0.5rem;
                                                `;
                        refreshBadge.innerHTML = '<i class="fas fa-sync-alt fa-spin"></i> Memperbarui data...';
                        document.body.appendChild(refreshBadge);

                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                }, 30000); // Refresh every 30 seconds
            }

            function stopAutoRefresh() {
                if (refreshInterval) {
                    clearInterval(refreshInterval);
                }
            }

            startAutoRefresh();

            document.addEventListener('visibilitychange', function () {
                if (document.hidden) {
                    stopAutoRefresh();
                } else {
                    startAutoRefresh();
                }
            });
        @endif

            /**
             * Print functionality
             */
            function printAttendance() {
                window.print();
            }

        // Print styles
        const printStyles = document.createElement('style');
        printStyles.textContent = `
                        @media print {
                            .filter-card,
                            .btn,
                            .doc-link {
                                display: none !important;
                            }
                            .class-section {
                                page-break-inside: avoid;
                                margin-bottom: 2rem;
                            }
                            .attendance-table table {
                                page-break-inside: auto;
                            }
                            .attendance-table tr {
                                page-break-inside: avoid;
                                page-break-after: auto;
                            }
                            body {
                                background: white !important;
                            }
                            .attendance-container {
                                background: white !important;
                            }
                        }
                    `;
        document.head.appendChild(printStyles);

        /**
         * Responsive table handling
         */
        function handleResponsiveTable() {
            const tables = document.querySelectorAll('.attendance-table');

            tables.forEach(table => {
                if (window.innerWidth < 768) {
                    table.style.overflowX = 'auto';
                } else {
                    table.style.overflowX = 'visible';
                }
            });
        }

        window.addEventListener('resize', handleResponsiveTable);
        handleResponsiveTable();
    </script>
@endpush