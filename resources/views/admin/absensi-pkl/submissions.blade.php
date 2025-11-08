@extends('layouts.admin')

@section('title', 'PKL Attendance Management')

@push('styles')
    <style>
        :root {
            --primary: #2563eb;
            --primary-light: #dbeafe;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-900: #111827;
            --radius: 0.5rem;
        }

        .card {
            background: white;
            border-radius: var(--radius);
            border: 1px solid var(--gray-200);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
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
            background: #1d4ed8;
        }

        .btn-secondary {
            background: var(--gray-500);
            color: white;
        }

        .btn-secondary:hover {
            background: var(--gray-600);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-item {
            background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
            color: white;
            padding: 1.5rem;
            border-radius: var(--radius);
            text-align: center;
        }

        .stat-number {
            display: block;
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            display: block;
            font-size: 0.875rem;
            opacity: 0.9;
        }

        /* Filter Section */
        .filter-section {
            margin-bottom: 1.5rem;
        }

        .filter-controls {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: flex-end;
        }

        .filter-input,
        .filter-select {
            flex: 1;
            min-width: 150px;
            padding: 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            font-size: 0.875rem;
        }

        /* Modals */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            align-items: center;
            justify-content: center;
        }

        .modal.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: var(--radius);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            padding: 2rem;
            position: relative;
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .modal-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.5rem;
            color: var(--gray-500);
        }

        .modal-close:hover {
            color: var(--gray-900);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .pagination-info {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .pagination-links {
            display: flex;
            gap: 0.5rem;
            align-items: center;
        }

        .pagination-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--gray-300);
            border-radius: var(--radius);
            cursor: pointer;
            text-decoration: none;
            color: var(--primary);
            transition: all 0.15s ease;
        }

        .pagination-link:hover {
            background: var(--gray-100);
        }

        .pagination-link.active {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
        }

        .empty-icon {
            font-size: 3rem;
            color: var(--gray-400);
            margin-bottom: 1rem;
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
    </style>
@endpush

@section('content')
    <div style="padding: 1.5rem;">
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <h1 style="font-size: 1.875rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">
                <i class="fas fa-check-circle" style="margin-right: 0.5rem; color: var(--primary);"></i>
                PKL Attendance Management
            </h1>
            <p style="color: var(--gray-600);">Kelola absensi dan aktivitas siswa PKL</p>

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
            <div style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
                <form method="GET" action="{{ route('admin.pkl-attendance.submissions-pkl') }}" class="filter-controls"
                    style="display: flex; gap: 1rem; flex: 1; align-items: center; flex-wrap: wrap;">
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Search by student name, email, or company..." class="filter-input"
                        style="flex: 1; min-width: 200px;">

                    <input type="date" name="date_from" value="{{ $dateFrom }}" class="filter-select">

                    <input type="date" name="date_to" value="{{ $dateTo }}" class="filter-select">

                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>Filter
                    </button>

                    <a href="{{ route('admin.pkl-attendance.submissions-pkl') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i>Clear
                    </a>
                </form>

                <form method="POST" action="{{ route('admin.pkl-attendance.export') }}" style="display: inline-block;">
                    @csrf
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="date_from" value="{{ $dateFrom }}">
                    <input type="hidden" name="date_to" value="{{ $dateTo }}">
                    <button type="submit" class="btn btn-primary"
                        style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                        <i class="fas fa-download"></i>Export Excel
                    </button>
                </form>
            </div>
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
                                    $log = $registration->pklAttendanceLogs->first();
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
                                                Not Checked In
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $log ? ($log->ip_address ?? '-') : '-' }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            @if($log)
                                                <button onclick="openDetailModal({{ $log->id }})" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-eye"></i>View
                                                </button>
                                            @else
                                                <span style="color: var(--gray-400); font-size: 0.875rem;">
                                                    <i class="fas fa-minus"></i> No action
                                                </span>
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
                    <a href="{{ route('admin.pkl-attendance.submissions-pkl') }}" class="btn btn-primary"
                        style="margin-top: 1rem;">
                        <i class="fas fa-refresh"></i> Reset Filters
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal" style="display: none;">
        <div class="modal-content">
            <button onclick="closeDetailModal()" class="modal-close" title="Close">
                <i class="fas fa-times"></i>
            </button>
            <div class="modal-header">
                <i class="fas fa-info-circle" style="color: var(--primary);"></i>
                Attendance Details
            </div>
            <div id="modalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Open Detail Modal
        function openDetailModal(logId) {
            console.log('Opening detail modal for log ID:', logId);
            const url = `{{ route('admin.pkl-attendance.show-detail', ':id') }}`.replace(':id', logId);
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
                                                                                                <i class="fas fa-list"></i> Activity Log
                                                                                            </h4>
                                                                                            ${logActivityHtml}
                                                                                        </div>
                                                                                    `;
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    document.getElementById('modalBody').innerHTML = `
                                                                                        <div style="color: var(--gray-600); text-align: center; padding: 2rem;">
                                                                                            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: var(--danger); margin-bottom: 1rem;"></i>
                                                                                            <p>Failed to load details.</p>
                                                                                            <p style="font-size: 0.875rem; color: var(--gray-500); margin-top: 1rem;">Error: ${error.message}</p>
                                                                                        </div>
                                                                                    `;
                });
        }

        // Close Detail Modal
        function closeDetailModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function (event) {
            const detailModal = document.getElementById('detailModal');

            if (event.target === detailModal) {
                closeDetailModal();
            }
        });
    </script>
@endpush