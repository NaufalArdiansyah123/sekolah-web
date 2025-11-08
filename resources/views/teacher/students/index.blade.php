@extends('layouts.teacher')

@section('title', 'Student Data Management')

@section('content')
    <style>
        .students-container {
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

        /* Table Styles */
        .table-container {
            background: var(--bg-primary);
            border-radius: 14px;
            border: 1px solid var(--border-color);
            box-shadow: 0 2px 12px var(--shadow-color);
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: linear-gradient(135deg, #059669, #10b981);
            color: white;
        }

        .data-table th {
            padding: 1rem;
            font-weight: 600;
            text-align: left;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .data-table tbody tr {
            border-top: 1px solid var(--border-color);
            transition: background-color 0.3s ease;
        }

        .data-table tbody tr:hover {
            background: var(--bg-secondary);
        }

        .data-table td {
            padding: 1rem;
            font-size: 0.875rem;
            color: var(--text-primary);
        }

        .student-cell {
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
            font-weight: 600;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .student-info-cell {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .student-name {
            font-weight: 600;
            color: var(--text-primary);
        }

        .student-nis {
            font-size: 0.75rem;
            color: var(--text-secondary);
        }

        .student-class-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            background: rgba(5, 150, 105, 0.1);
            color: #059669;
            padding: 0.375rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            width: fit-content;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: #059669;
        }

        .status-inactive {
            background: rgba(107, 114, 128, 0.1);
            color: #374151;
        }

        .status-graduated {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
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
            margin-bottom: 1.5rem;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .students-container {
                padding: 1rem;
            }

            .header-content {
                flex-direction: column;
                gap: 1rem;
            }

            .filters-row {
                grid-template-columns: 1fr;
            }

            .data-table {
                font-size: 0.75rem;
            }

            .data-table th,
            .data-table td {
                padding: 0.75rem 0.5rem;
            }

            .student-cell {
                gap: 0.5rem;
            }

            .student-avatar {
                width: 32px;
                height: 32px;
                font-size: 0.75rem;
            }
        }

        /* Animation */
        .data-table tbody tr {
            animation: slideIn 0.4s ease-out;
        }

        .data-table tbody tr:nth-child(1) {
            animation-delay: 0.05s;
        }

        .data-table tbody tr:nth-child(2) {
            animation-delay: 0.1s;
        }

        .data-table tbody tr:nth-child(3) {
            animation-delay: 0.15s;
        }

        .data-table tbody tr:nth-child(4) {
            animation-delay: 0.2s;
        }

        .data-table tbody tr:nth-child(5) {
            animation-delay: 0.25s;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-10px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
    </style>

    <div class="students-container">
        <!-- Page Header -->
        <div class="page-header">
            <div class="header-content">
                <div class="header-info">
                    <h1 class="page-title">
                        <svg class="w-8 h-8" style="display: inline; margin-right: 0.5rem;" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        Data Siswa
                    </h1>
                    <p class="page-subtitle">Daftar lengkap siswa berdasarkan kelas</p>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters-container">
            <form method="GET" action="{{ route('teacher.students.index') }}">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Filter Berdasarkan Kelas</label>
                        <select name="class" class="filter-input" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            @php
                                $classes = App\Models\Classes::pluck('name')->unique();
                            @endphp
                            @foreach($classes as $className)
                                <option value="{{ $className }}" {{ request('class') == $className ? 'selected' : '' }}>
                                    {{ $className }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group" style="margin-top: 1.5rem;">
                        <a href="{{ route('teacher.students.index') }}" class="btn-reset">Reset Filter</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Students Table -->
        @if($students->count() > 0)
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th style="width: 25%;">Nama Siswa</th>
                            <th style="width: 15%;">NIS</th>
                            <th style="width: 15%;">Kelas</th>
                            <th style="width: 15%;">Jenis Kelamin</th>
                            <th style="width: 15%;">Email</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 12%;">PKL Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $index => $student)
                            <tr>
                                <td>{{ $loop->iteration + ($students->currentPage() - 1) * $students->perPage() }}</td>
                                <td>
                                    <div class="student-cell">
                                        <div class="student-avatar">
                                            {{ strtoupper(substr($student->name, 0, 2)) }}
                                        </div>
                                        <div class="student-info-cell">
                                            <div class="student-name">{{ $student->name }}</div>
                                            <div class="student-nis">{{ $student->birth_place }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $student->nis }}</td>
                                <td>
                                    <div class="student-class-badge">
                                        {{ $student->class ? $student->class->name : 'No Class' }}
                                    </div>
                                </td>
                                <td>{{ $student->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                <td>{{ $student->email }}</td>
                                <td>
                                    <span class="status-badge status-{{ $student->status }}">
                                        @if($student->status == 'active')
                                            Aktif
                                        @elseif($student->status == 'inactive')
                                            Tidak Aktif
                                        @else
                                            Lulus
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if($student->pkl_status === 'sedang_pkl')
                                        <span style="display: inline-flex; align-items: center; gap: 0.25rem; background-color: #3b82f6; color: white; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-briefcase"></i> Sedang PKL
                                        </span>
                                    @elseif($student->pkl_status === 'selesai_pkl')
                                        <span style="display: inline-flex; align-items: center; gap: 0.25rem; background-color: #10b981; color: white; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-check-circle"></i> Selesai PKL
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; gap: 0.25rem; background-color: #6b7280; color: white; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            <i class="fas fa-minus"></i> Tidak PKL
                                        </span>
                                    @endif
                                </td>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="pagination-container">
                {{ $students->appends(request()->query())->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <div class="empty-icon">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                    </svg>
                </div>
                <h3 class="empty-title">Tidak Ada Data Siswa</h3>
                <p class="empty-description">
                    @if(request()->has('class'))
                        Tidak ada siswa di kelas yang dipilih. Coba pilih kelas lain atau reset filter.
                    @else
                        Belum ada siswa yang terdaftar.
                    @endif
                </p>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add animation effects to table rows on load
            const rows = document.querySelectorAll('.data-table tbody tr');
            rows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.animation = `slideIn ${0.4 + (index * 0.05)}s ease-out`;
                }, index * 50);
            });
        });
    </script>
@endsection