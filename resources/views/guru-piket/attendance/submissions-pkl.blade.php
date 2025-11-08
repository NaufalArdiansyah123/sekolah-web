@extends('layouts.guru-piket')

@section('title', 'PKL Attendance Submissions')

@push('styles')
    <style>
        /* Modern Minimalist Design System */
        :root {
            --primary: #3b82f6;
            --primary-light: #dbeafe;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            --radius: 8px;
            --radius-lg: 12px;
            --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Base Layout */
        .container-modern {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0;
        }

        /* Modern Cards */
        .card {
            background: white;
            border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            box-shadow: var(--shadow);
            transition: box-shadow 0.2s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        /* Header Section */
        .header-section {
            background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
            border-radius: var(--radius-lg);
            padding: 2rem;
            color: white;
            margin-bottom: 2rem;
        }

        .header-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .header-subtitle {
            opacity: 0.9;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: var(--radius);
            backdrop-filter: blur(10px);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-top: 0.25rem;
        }

        /* Filter Section */
        .filter-section {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .filter-controls {
            display: flex;
            gap: 0.75rem;
            align-items: center;
            flex-wrap: wrap;
            flex: 1;
        }

        .filter-select {
            padding: 0.5rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.875rem;
            background: white;
            color: var(--gray-700);
            min-width: 200px;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        .filter-input {
            padding: 0.5rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.875rem;
            background: white;
            color: var(--gray-700);
            min-width: 200px;
        }

        .filter-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        @media (max-width: 768px) {
            .filter-controls {
                width: 100%;
            }

            .filter-select,
            .filter-input {
                flex: 1;
                min-width: 0;
            }
        }

        /* Table Styles */
        .attendance-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: var(--radius);
            overflow: hidden;
        }

        .attendance-table th {
            background: var(--gray-50);
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--gray-900);
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.875rem;
        }

        .attendance-table td {
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.875rem;
            color: var(--gray-700);
        }

        .attendance-table tr:hover {
            background: var(--gray-50);
        }

        .student-avatar {
            width: 2.5rem;
            height: 2.5rem;
            background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
            border-radius: var(--radius);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .student-name {
            font-weight: 600;
            color: var(--gray-900);
        }

        .student-nis {
            color: var(--gray-600);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        .company-name {
            font-weight: 500;
            color: var(--gray-800);
        }

        .company-location {
            color: var(--gray-600);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* Status Badge */
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 2px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
            background: transparent;
            border: none;
        }

        .status-success {
            background: transparent;
            color: #065f46;
        }

        .status-warning {
            background: transparent;
            color: #92400e;
        }

        .status-info {
            background: transparent;
            color: #1e40af;
        }

        .status-secondary {
            background: transparent;
            color: #4b5563;
            border-color: #4b5563;
        }

        /* Time display styling */
        .time-check-in {
            color: #059669;
            font-weight: 600;
        }

        .time-check-out {
            color: #dc2626;
            font-weight: 600;
        }

        .time-icon {
            font-size: 0.75rem;
            margin-left: 0.25rem;
        }

        /* Action Buttons */
        .btn {
            padding: 0.5rem 1rem;
            border-radius: var(--radius);
            font-weight: 500;
            font-size: 0.875rem;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: #2563eb;
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-success:hover {
            background: #059669;
        }

        .btn-secondary {
            background: var(--gray-500);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--gray-600);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: var(--gray-500);
        }

        .empty-icon {
            width: 4rem;
            height: 4rem;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.5rem;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: between;
            align-items: center;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: var(--radius);
            margin-top: 1rem;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .pagination-links {
            display: flex;
            gap: 0.5rem;
        }

        .pagination-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            background: white;
            color: var(--gray-700);
            text-decoration: none;
            font-size: 0.875rem;
            transition: all 0.15s ease;
        }

        .pagination-link:hover {
            background: var(--gray-50);
        }

        .pagination-link.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        @media (max-width: 640px) {
            .attendance-table {
                font-size: 0.8125rem;
            }

            .attendance-table td,
            .attendance-table th {
                padding: 0.5rem;
            }

            .pagination-container {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Add CSRF token for AJAX requests -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-modern">
        <!-- Header Section -->
        <div class="header-section">
            <h1 class="header-title">
                <i class="fas fa-building"></i>
                PKL Attendance Submissions
            </h1>
            <p class="header-subtitle">
                Monitor and manage PKL attendance submissions from students
            </p>

            <div class="stats-grid">
                <div class="stat-item">
                    <span class="stat-number">{{ $pklRegistrations->total() }}</span>
                    <span class="stat-label">Total PKL Students</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $pklRegistrations->count() }}</span>
                    <span class="stat-label">Current Page</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ $pklRegistrations->lastPage() }}</span>
                    <span class="stat-label">Total Pages</span>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card filter-section">
            <form method="GET" action="{{ route('guru-piket.attendance.submissions-pkl') }}" class="filter-controls">
                <input type="text" name="search" value="{{ $search }}"
                    placeholder="Search by student name, email, or company..." class="filter-input">

                <input type="date" name="date_from" value="{{ $dateFrom }}" class="filter-select">

                <input type="date" name="date_to" value="{{ $dateTo }}" class="filter-select">

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>Filter
                </button>

                <a href="{{ route('guru-piket.attendance.submissions-pkl') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i>Clear
                </a>
            </form>
        </div>

        <!-- Attendance Table -->
        <div class="card">
            @if($pklRegistrations->count() > 0)
                <div style="overflow-x: auto;">
                    <table class="attendance-table">
                        <thead>
                            <tr>
                                <th style="width: 60px;">No</th>
                                <th style="width: 80px;">Avatar</th>
                                <th>Student</th>
                                <th>Company</th>
                                <th style="width: 120px;">Scan Date</th>
                                <th style="width: 100px;">Scan Masuk</th>
                                <th style="width: 100px;">Scan Pulang</th>
                                <th style="width: 120px;">Status</th>
                                <th style="width: 120px;">IP Address</th>
                                <th style="width: 120px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pklRegistrations as $index => $registration)
                                @php
                                    $user = $registration->student;
                                    $log = $registration->pklAttendanceLogs->first(); // Get first attendance log for the filtered date
                                @endphp
                                <tr>
                                    <td style="text-align: center; font-weight: 600;">
                                        {{ $pklRegistrations->firstItem() + $index }}
                                    </td>
                                    <td>
                                        <div class="student-avatar">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="student-name">{{ $user->name }}</div>
                                        <div class="student-nis">NIS: {{ $user->student ? $user->student->nis : 'N/A' }}</div>
                                        <div class="student-nis">{{ $user->email }}</div>
                                    </td>
                                    <td>
                                        <div class="company-name">
                                            {{ $registration->tempatPkl->nama_tempat ?? 'N/A' }}
                                        </div>
                                        <div class="company-location">
                                            {{ $registration->tempatPkl->kota ?? '' }}
                                            @if($registration->tempatPkl->alamat)
                                                - {{ Str::limit($registration->tempatPkl->alamat, 30) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td>{{ $log ? ($log->scan_date ? \Carbon\Carbon::parse($log->scan_date)->format('d/m/Y') : '-') : '-' }}
                                    </td>
                                    <td>
                                        @if($log && $log->scan_time)
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span
                                                    class="time-check-in">{{ \Carbon\Carbon::parse($log->scan_time)->format('H:i') }}</span>
                                                <i class="fas fa-sign-in-alt time-icon" style="color: #059669;" title="Check-in"></i>
                                            </div>
                                        @else
                                            <span class="status-badge status-secondary">
                                                <i class="fas fa-minus"></i>
                                                -
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log && $log->check_out_time)
                                            @php
                                                $checkIn = \Carbon\Carbon::parse($log->scan_time);
                                                $checkOut = \Carbon\Carbon::parse($log->check_out_time);
                                                $duration = $checkIn->diff($checkOut);
                                                $hours = $duration->h;
                                                $minutes = $duration->i;
                                                $durationText = '';
                                                if ($hours > 0)
                                                    $durationText .= $hours . 'j ';
                                                if ($minutes > 0)
                                                    $durationText .= $minutes . 'm';
                                            @endphp
                                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                <span class="time-check-out"
                                                    title="Durasi: {{ $durationText }}">{{ $checkOut->format('H:i') }}</span>
                                                <i class="fas fa-sign-out-alt time-icon" style="color: #dc2626;"
                                                    title="Check-out ({{ $durationText }})"></i>
                                            </div>
                                        @elseif($log)
                                            <span class="status-badge status-secondary">
                                                <i class="fas fa-minus"></i>
                                                Belum Pulang
                                            </span>
                                        @else
                                            <span class="status-badge status-secondary">
                                                <i class="fas fa-minus"></i>
                                                -
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($log)
                                            <div class="status-container" data-log-id="{{ $log->id }}">
                                                <span
                                                    class="status-badge status-{{ $log->status === 'hadir' ? 'success' : (($log->status === 'sakit' || $log->status === 'izin') ? 'warning' : 'info') }}">
                                                    <i
                                                        class="fas fa-{{ $log->status === 'hadir' ? 'check' : ($log->status === 'sakit' ? 'medkit' : ($log->status === 'izin' ? 'briefcase' : 'times')) }}"></i>
                                                    {{ $log->getStatusTextAttribute() }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="status-badge status-secondary">
                                                <i class="fas fa-minus"></i>
                                                Belum Absensi
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $log ? ($log->ip_address ?? '-') : '-' }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button
                                                onclick="openEditModal('{{ $log ? $log->id : 'new' }}', '{{ $registration->id }}')"
                                                class="btn btn-secondary btn-sm" title="Edit Status">
                                                <i class="fas fa-edit"></i>Edit
                                            </button>

                                            @if($log)
                                                <br><br>
                                                <button onclick="openDetailModal({{ $log->id }})" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>View
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <div class="pagination-info">
                        Showing {{ $pklRegistrations->firstItem() }} to {{ $pklRegistrations->lastItem() }}
                        of {{ $pklRegistrations->total() }} entries
                    </div>
                    <div class="pagination-links">
                        @if($pklRegistrations->hasPages())
                            {{-- Previous Page Link --}}
                            @if ($pklRegistrations->onFirstPage())
                                <span class="pagination-link" style="opacity: 0.5; cursor: not-allowed;">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </span>
                            @else
                                <a href="{{ $pklRegistrations->previousPageUrl() }}" class="pagination-link">
                                    <i class="fas fa-chevron-left"></i> Previous
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($pklRegistrations->getUrlRange(1, $pklRegistrations->lastPage()) as $page => $url)
                                @if ($page == $pklRegistrations->currentPage())
                                    <span class="pagination-link active">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="pagination-link">{{ $page }}</a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($pklRegistrations->hasMorePages())
                                <a href="{{ $pklRegistrations->nextPageUrl() }}" class="pagination-link">
                                    Next <i class="fas fa-chevron-right"></i>
                                </a>
                            @else
                                <span class="pagination-link" style="opacity: 0.5; cursor: not-allowed;">
                                    Next <i class="fas fa-chevron-right"></i>
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3 style="font-weight: 600; margin-bottom: 0.5rem;">No PKL Students</h3>
                    <p style="color: var(--gray-600);">No PKL students found for the selected filters</p>
                    <a href="{{ route('guru-piket.attendance.submissions-pkl') }}" class="btn btn-primary"
                        style="margin-top: 1rem;">
                        <i class="fas fa-refresh"></i> Reset Filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Status Modal -->
    <div id="editModal" class="modal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div class="modal-content"
            style="background: white; border-radius: var(--radius-lg); padding: 2rem; max-width: 500px; width: 90%;">
            <div class="modal-header"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200); padding-bottom: 1rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    <i class="fas fa-edit"></i> Edit Attendance Status
                </h3>
                <button onclick="closeEditModal()"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--gray-400); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="editModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
        <div class="modal-content"
            style="background: white; border-radius: var(--radius-lg); padding: 2rem; max-width: 700px; width: 90%; max-height: 80vh; overflow-y: auto;">
            <div class="modal-header"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200); padding-bottom: 1rem;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    <i class="fas fa-user-circle"></i> Student Details
                </h3>
                <button onclick="closeDetailModal()"
                    style="background: none; border: none; font-size: 1.5rem; color: var(--gray-400); cursor: pointer;">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Open Edit Modal
        function openEditModal(logId, registrationId = null) {
            document.getElementById('editModalBody').innerHTML = `
                                                                        <div style="text-align: center; padding: 2rem;">
                                                                            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary);"></i>
                                                                            <p style="margin-top: 1rem; color: var(--gray-600);">Loading form...</p>
                                                                        </div>
                                                                    `;
            document.getElementById('editModal').style.display = 'flex';

            // Jika logId adalah 'new', berarti siswa belum absen
            if (logId === 'new') {
                showNewAttendanceForm(registrationId);
                return;
            }

            fetch(`/guru-piket/attendance/submissions-pkl/${logId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Data loaded:', data);
                    const statusOptions = [
                        { value: 'hadir', label: 'Hadir', icon: 'check', color: '#10b981' },
                        { value: 'sakit', label: 'Sakit', icon: 'medkit', color: '#f59e0b' },
                        { value: 'izin', label: 'Izin', icon: 'briefcase', color: '#f59e0b' },
                        { value: 'alpha', label: 'Alpha', icon: 'times', color: '#ef4444' }
                    ];

                    let optionsHtml = statusOptions.map(opt => `
                                                                                <option value="${opt.value}" ${data.status === opt.value ? 'selected' : ''}>${opt.label}</option>
                                                                            `).join('');

                    document.getElementById('editModalBody').innerHTML = `
                                                                                <form id="editForm" onsubmit="submitEditForm(event, ${logId})">
                                                                                    <div style="margin-bottom: 1.5rem;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            Student Name
                                                                                        </label>
                                                                                        <input type="text" value="${data.student_name}" disabled style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); background: var(--gray-100);">
                                                                                    </div>

                                                                                    <div style="margin-bottom: 1.5rem;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            Current Status
                                                                                        </label>
                                                                                        <div style="display: flex; align-items: center; gap: 1rem;">
                                                                                            <span class="status-badge status-${data.status === 'hadir' ? 'success' : (data.status === 'sakit' ? 'warning' : (data.status === 'izin' ? 'warning' : 'info'))}" style="padding: 0.5rem 1rem; border-radius: 4px; font-weight: 600;">
                                                                                                <i class="fas fa-${data.status === 'hadir' ? 'check' : (data.status === 'sakit' ? 'medkit' : (data.status === 'izin' ? 'briefcase' : 'times'))}"></i>
                                                                                                ${data.status_text}
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div style="margin-bottom: 1.5rem;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            New Status
                                                                                        </label>
                                                                                        <select name="status" onchange="toggleSickNoteField(this.value)" style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem;">
                                                                                            ${optionsHtml}
                                                                                        </select>
                                                                                    </div>

                                                                                    <div style="margin-bottom: 1.5rem;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            Scan Masuk (H:i)
                                                                                        </label>
                                                                                        <input type="time" name="scan_time" disabled value="${data.scan_time}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); background: var(--gray-100);">
                                                                                    </div>

                                                                                    <div style="margin-bottom: 1.5rem;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            Scan Pulang (Optional)
                                                                                        </label>
                                                                                        <input type="time" name="check_out_time" value="${data.check_out_time}" style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem;">
                                                                                    </div>

                                                                                    <div style="margin-bottom: 1.5rem;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            Log Activity / Catatan
                                                                                        </label>
                                                                                        <textarea name="log_activity" placeholder="Masukkan catatan atau aktivitas siswa..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem; min-height: 100px; resize: vertical;">${data.log_activity || ''}</textarea>
                                                                                    </div>

                                                                                    <div id="sickNoteField" style="margin-bottom: 1.5rem; display: none;">
                                                                                        <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                                            <i class="fas fa-file-medical" style="color: var(--danger); margin-right: 0.5rem;"></i> Upload Surat Sakit (PDF/JPG/PNG)
                                                                                        </label>
                                                                                        <input type="file" name="sick_note" accept=".pdf,.jpg,.jpeg,.png" style="width: 100%; padding: 0.75rem; border: 2px dashed var(--gray-300); border-radius: var(--radius); background: var(--gray-50);">
                                                                                        <p style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">Max 5MB. Format: PDF, JPG, PNG</p>
                                                                                    </div>

                                                                                    <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                                                                        <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">
                                                                                            <i class="fas fa-save"></i> Save Changes
                                                                                        </button>
                                                                                        <button type="button" onclick="closeEditModal()" class="btn btn-secondary" style="flex: 1; justify-content: center;">
                                                                                            <i class="fas fa-times"></i> Cancel
                                                                                        </button>
                                                                                    </div>
                                                                                </form>
                                                                            `;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('editModalBody').innerHTML = `
                                                                                <div style="color: var(--gray-600); text-align: center; padding: 2rem;">
                                                                                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                                                                    <p>Failed to load form.</p>
                                                                                    <p style="font-size: 0.875rem; color: var(--gray-500); margin-top: 1rem;">Error: ${error.message}</p>
                                                                                </div>
                                                                            `;
                });
        }

        // Submit Edit Form
        function submitEditForm(event, logId) {
            event.preventDefault();
            const form = document.getElementById('editForm');
            const formData = new FormData(form);

            fetch(`{{ route('guru-piket.attendance.submissions-pkl.update', ':id') }}`.replace(':id', logId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData  // Send FormData directly (handles file upload)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeEditModal();
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to update attendance');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Network error occurred: ' + error.message);
                });
        }

        // Toggle sick note field visibility
        function toggleSickNoteField(status) {
            const sickNoteField = document.getElementById('sickNoteField');
            if (status === 'sakit') {
                sickNoteField.style.display = 'block';
            } else {
                sickNoteField.style.display = 'none';
            }
        }

        // Show New Attendance Form (for students who haven't checked in yet)
        function showNewAttendanceForm(registrationId) {
            fetch(`/guru-piket/attendance/submissions-pkl/registration/${registrationId}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const statusOptions = [
                        { value: 'hadir', label: 'Hadir', icon: 'check', color: '#10b981' },
                        { value: 'sakit', label: 'Sakit', icon: 'medkit', color: '#f59e0b' },
                        { value: 'izin', label: 'Izin', icon: 'briefcase', color: '#f59e0b' },
                        { value: 'alpha', label: 'Alpha', icon: 'times', color: '#ef4444' }
                    ];

                    let optionsHtml = statusOptions.map(opt => `
                                                        <option value="${opt.value}">${opt.label}</option>
                                                    `).join('');

                    document.getElementById('editModalBody').innerHTML = `
                                                        <form id="editForm" onsubmit="submitNewAttendanceForm(event, ${registrationId})">
                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    Student Name
                                                                </label>
                                                                <input type="text" value="${data.student_name}" disabled style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); background: var(--gray-100);">
                                                            </div>

                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    Company
                                                                </label>
                                                                <input type="text" value="${data.company_name}" disabled style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); background: var(--gray-100);">
                                                            </div>

                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    Current Status
                                                                </label>
                                                                <div style="display: flex; align-items: center; gap: 1rem;">
                                                                    <span class="status-badge status-secondary" style="padding: 0.5rem 1rem; border-radius: 4px; font-weight: 600;">
                                                                        <i class="fas fa-minus"></i>
                                                                        Not Checked In
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    New Status
                                                                </label>
                                                                <select name="status" onchange="toggleSickNoteField(this.value)" required style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem;">
                                                                    <option value="">-- Select Status --</option>
                                                                    ${optionsHtml}
                                                                </select>
                                                            </div>

                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    Scan Masuk (H:i)
                                                                </label>
                                                                <input type="time" name="scan_time" style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem;">
                                                            </div>

                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    Scan Pulang (Optional)
                                                                </label>
                                                                <input type="time" name="check_out_time" style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem;">
                                                            </div>

                                                            <div style="margin-bottom: 1.5rem;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    Log Activity / Catatan
                                                                </label>
                                                                <textarea name="log_activity" placeholder="Masukkan catatan atau aktivitas siswa..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.95rem; min-height: 100px; resize: vertical;"></textarea>
                                                            </div>

                                                            <div id="sickNoteField" style="margin-bottom: 1.5rem; display: none;">
                                                                <label style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: var(--gray-700);">
                                                                    <i class="fas fa-file-medical" style="color: var(--danger); margin-right: 0.5rem;"></i> Upload Surat Sakit (PDF/JPG/PNG)
                                                                </label>
                                                                <input type="file" name="sick_note" accept=".pdf,.jpg,.jpeg,.png" style="width: 100%; padding: 0.75rem; border: 2px dashed var(--gray-300); border-radius: var(--radius); background: var(--gray-50);">
                                                                <p style="font-size: 0.75rem; color: var(--gray-600); margin-top: 0.5rem;">Max 5MB. Format: PDF, JPG, PNG</p>
                                                            </div>

                                                            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                                                                <button type="submit" class="btn btn-primary" style="flex: 1; justify-content: center;">
                                                                    <i class="fas fa-save"></i> Save Changes
                                                                </button>
                                                                <button type="button" onclick="closeEditModal()" class="btn btn-secondary" style="flex: 1; justify-content: center;">
                                                                    <i class="fas fa-times"></i> Cancel
                                                                </button>
                                                            </div>
                                                        </form>
                                                    `;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('editModalBody').innerHTML = `
                                                        <div style="color: var(--gray-600); text-align: center; padding: 2rem;">
                                                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                                            <p>Failed to load form.</p>
                                                            <p style="font-size: 0.875rem; color: var(--gray-500); margin-top: 1rem;">Error: ${error.message}</p>
                                                        </div>
                                                    `;
                });
        }

        // Submit New Attendance Form
        function submitNewAttendanceForm(event, registrationId) {
            event.preventDefault();
            const form = document.getElementById('editForm');
            const formData = new FormData(form);
            const status = formData.get('status');

            if (!status) {
                alert('Please select a status');
                return;
            }

            fetch(`/guru-piket/attendance/submissions-pkl/registration/${registrationId}/create`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData  // Send FormData directly (handles file upload)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        closeEditModal();
                        location.reload();
                    } else {
                        alert(data.message || 'Failed to create attendance');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Network error occurred: ' + error.message);
                });
        }

        // Close Edit Modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        // Open Detail Modal
        function openDetailModal(logId) {
            console.log('Opening detail modal for log ID:', logId);
            const url = `/guru-piket/attendance/submissions-pkl/${logId}/detail`;
            console.log('Fetching URL:', url);

            document.getElementById('modalBody').innerHTML = `
                                                                        <div style="text-align: center; padding: 2rem;">
                                                                            <i class="fas fa-spinner fa-spin" style="font-size: 2rem; color: var(--primary);"></i>
                                                                            <p style="margin-top: 1rem; color: var(--gray-600);">Loading details...</p>
                                                                        </div>
                                                                    `;
            document.getElementById('detailModal').style.display = 'flex';

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Detail data loaded:', data);
                    const student = data.student;
                    const pkl = data.pkl;
                    const log = data.log;

                    let logActivityHtml = log.log_activity ? `
                                                                                <div style="background: #f8fafc; padding: 1rem; border-radius: var(--radius); border-left: 4px solid var(--primary);">
                                                                                    <p style="margin: 0; color: var(--gray-700); line-height: 1.6;">${log.log_activity}</p>
                                                                                </div>
                                                                            ` : `
                                                                                <div style="background: #f8fafc; padding: 1rem; border-radius: var(--radius); text-align: center; color: var(--gray-500);">
                                                                                    <i class="fas fa-info-circle" style="margin-right: 0.5rem;"></i>
                                                                                    No activity log recorded yet
                                                                                </div>
                                                                            `;

                    document.getElementById('modalBody').innerHTML = `
                                                                                <!-- Student Information -->
                                                                                <div style="background: linear-gradient(135deg, var(--primary-light) 0%, #e0e7ff 100%); padding: 1.5rem; border-radius: var(--radius); margin-bottom: 1.5rem;">
                                                                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                                                                        <div style="width: 60px; height: 60px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                                                                                            ${student.name.charAt(0).toUpperCase()}
                                                                                        </div>
                                                                                        <div>
                                                                                            <h4 style="margin: 0; font-size: 1.125rem; font-weight: 700; color: var(--gray-900);">${student.name}</h4>
                                                                                            <p style="margin: 0.25rem 0 0 0; color: var(--gray-600);">NIS: <strong>${student.nis}</strong></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Personal Information -->
                                                                                <div style="margin-bottom: 1.5rem;">
                                                                                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--gray-900);">
                                                                                        <i class="fas fa-id-card"></i> Personal Information
                                                                                    </h4>
                                                                                    <div style="background: var(--gray-50); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                                                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Email</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${student.email}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Class</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${student.class || 'N/A'}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Major</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${student.major || 'N/A'}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Phone</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${student.phone || 'N/A'}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- PKL Information -->
                                                                                <div style="margin-bottom: 1.5rem;">
                                                                                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--gray-900);">
                                                                                        <i class="fas fa-building"></i> PKL Information
                                                                                    </h4>
                                                                                    <div style="background: var(--gray-50); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                                                                        <div style="margin-bottom: 1rem;">
                                                                                            <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Company Name</p>
                                                                                            <p style="margin: 0.5rem 0 0 0; color: var(--gray-900); font-weight: 600;">${pkl.company_name}</p>
                                                                                        </div>
                                                                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Start Date</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${pkl.start_date}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">End Date</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${pkl.end_date}</p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div>
                                                                                            <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Address</p>
                                                                                            <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${pkl.address}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Attendance Information -->
                                                                                <div style="margin-bottom: 1.5rem;">
                                                                                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--gray-900);">
                                                                                        <i class="fas fa-clock"></i> Attendance Information
                                                                                    </h4>
                                                                                    <div style="background: var(--gray-50); padding: 1rem; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                                                                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Scan Date</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900); font-weight: 600;">${log.scan_date}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Scan Time</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900); font-weight: 600;">${log.scan_time}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Check-Out Time</p>
                                                                                                <p style="margin: 0.5rem 0 0 0; color: var(--gray-900);">${log.check_out_time || '-'}</p>
                                                                                            </div>
                                                                                            <div>
                                                                                                <p style="margin: 0; font-size: 0.875rem; color: var(--gray-600); font-weight: 500;">Status</p>
                                                                                                <p style="margin: 0.5rem 0 0 0;">
                                                                                                    <span class="status-badge status-${log.status === 'hadir' ? 'success' : (log.status === 'sakit' ? 'warning' : (log.status === 'izin' ? 'warning' : 'info'))}" style="padding: 0.25rem 0.75rem; border-radius: 4px; font-weight: 600; font-size: 0.875rem;">
                                                                                                        ${log.status_text}
                                                                                                    </span>
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <!-- Activity Log -->
                                                                                <div>
                                                                                    <h4 style="font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: var(--gray-900);">
                                                                                        <i class="fas fa-list"></i> Daily Activity Log
                                                                                    </h4>
                                                                                    ${logActivityHtml}
                                                                                </div>

                                                                                <div style="margin-top: 1.5rem;">
                                                                                    <button type="button" onclick="closeDetailModal()" class="btn btn-primary" style="width: 100%; justify-content: center;">
                                                                                        <i class="fas fa-times"></i> Close
                                                                                    </button>
                                                                                </div>
                                                                            `;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('modalBody').innerHTML = `
                                                                                <div style="color: var(--gray-600); text-align: center; padding: 2rem;">
                                                                                    <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                                                                    <p>Failed to load student details.</p>
                                                                                    <p style="font-size: 0.875rem; color: var(--gray-500); margin-top: 1rem;">Error: ${error.message}</p>
                                                                                </div>
                                                                            `;
                });
        }

        // Close Detail Modal
        function closeDetailModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        // Close modals when clicking outside
        document.getElementById('editModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeEditModal();
            }
        });

        document.getElementById('detailModal')?.addEventListener('click', function (e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });

        // Close with ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeEditModal();
                closeDetailModal();
            }
        });

        // Initialize page
        document.addEventListener('DOMContentLoaded', function () {
            console.log('PKL Attendance submissions page loaded');
        });
    </script>
@endpush