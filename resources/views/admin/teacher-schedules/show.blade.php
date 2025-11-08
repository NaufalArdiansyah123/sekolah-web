@extends('layouts.admin')

@section('title', 'Detail Jadwal Guru')

@section('content')
    <style>
        /* Minimal Monochrome Styling */
        :root {
            --bg-primary: #ffffff;
            --bg-secondary: #f7f7f7;
            --bg-tertiary: #efefef;
            --text-primary: #111111;
            --text-secondary: #555555;
            --border-color: #dddddd;
            --accent-color: #222222;
        }

        .qr-container {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            min-height: 100vh;
            padding: 1.5rem;
        }

        .qr-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            color: var(--text-primary);
        }

        .qr-header {
            background-color: var(--bg-tertiary);
            padding: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .btn-primary {
            background-color: var(--accent-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--accent-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary:hover {
            filter: brightness(1.1);
            color: white;
            text-decoration: none;
        }

        .btn-secondary {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid var(--border-color);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-secondary:hover {
            background-color: var(--border-color);
            color: var(--text-primary);
            text-decoration: none;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #f59e0b;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-warning:hover {
            background-color: #d97706;
            color: white;
            text-decoration: none;
        }

        .btn-danger {
            background-color: #dc2626;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #dc2626;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-danger:hover {
            background-color: #b91c1c;
            color: white;
            text-decoration: none;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #10b981;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .btn-success:hover {
            background-color: #059669;
            color: white;
            text-decoration: none;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid var(--border-color);
        }

        .detail-card {
            background-color: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .detail-header {
            background-color: var(--accent-color);
            color: white;
            padding: 1rem;
            font-weight: 600;
        }

        .detail-body {
            padding: 1.5rem;
        }

        .detail-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: var(--text-primary);
            min-width: 140px;
        }

        .detail-value {
            color: var(--text-secondary);
            flex: 1;
        }
    </style>

    <div class="qr-container">
        <!-- Page Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                        Detail Jadwal Guru
                    </h1>
                    <p class="text-sm mt-1" style="color: var(--text-secondary)">
                        Informasi lengkap jadwal mengajar guru
                    </p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.teacher-schedules.edit', $teacherSchedule) }}" class="btn-warning">
                        <i class="fas fa-edit mr-2"></i>Edit
                    </a>
                    <a href="{{ route('admin.teacher-schedules.index') }}" class="btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <!-- Detail Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Teacher Information -->
            <div class="detail-card">
                <div class="detail-header">
                    <i class="fas fa-user-tie mr-2"></i>Informasi Guru
                </div>
                <div class="detail-body">
                    <div class="detail-row">
                        <div class="detail-label">Nama:</div>
                        <div class="detail-value">{{ $teacherSchedule->teacher->name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">NIP:</div>
                        <div class="detail-value">{{ $teacherSchedule->teacher->nip }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email:</div>
                        <div class="detail-value">{{ $teacherSchedule->teacher->email }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Telepon:</div>
                        <div class="detail-value">{{ $teacherSchedule->teacher->phone ?? '-' }}</div>
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="detail-card">
                <div class="detail-header">
                    <i class="fas fa-calendar-check mr-2"></i>Informasi Jadwal
                </div>
                <div class="detail-body">
                    <div class="detail-row">
                        <div class="detail-label">Kelas:</div>
                        <div class="detail-value">{{ $teacherSchedule->class->name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Mata Pelajaran:</div>
                        <div class="detail-value">{{ $teacherSchedule->subject->name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Hari:</div>
                        <div class="detail-value">{{ $teacherSchedule->day_name }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Waktu:</div>
                        <div class="detail-value">{{ $teacherSchedule->time_range }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Ruangan:</div>
                        <div class="detail-value">{{ $teacherSchedule->room ?? '-' }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Tahun Akademik:</div>
                        <div class="detail-value">{{ $teacherSchedule->academicYear->year }}</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status:</div>
                        <div class="detail-value">
                            <span class="status-badge"
                                style="background-color: {{ $teacherSchedule->is_active ? 'var(--bg-tertiary)' : '#fee2e2' }}; color: {{ $teacherSchedule->is_active ? 'var(--text-primary)' : '#dc2626' }}">
                                {{ $teacherSchedule->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notes Section -->
        @if($teacherSchedule->notes)
            <div class="detail-card mb-6">
                <div class="detail-header">
                    <i class="fas fa-sticky-note mr-2"></i>Catatan
                </div>
                <div class="detail-body">
                    <p class="mb-0" style="color: var(--text-secondary)">{{ $teacherSchedule->notes }}</p>
                </div>
            </div>
        @endif

        <!-- Additional Information -->
        <div class="detail-card mb-6">
            <div class="detail-header">
                <i class="fas fa-info-circle mr-2"></i>Informasi Tambahan
            </div>
            <div class="detail-body">
                <div class="detail-row">
                    <div class="detail-label">Dibuat:</div>
                    <div class="detail-value">{{ $teacherSchedule->created_at->format('d M Y H:i') }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Terakhir Diupdate:</div>
                    <div class="detail-value">{{ $teacherSchedule->updated_at->format('d M Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between items-center">
            <div class="flex gap-2">
                <a href="{{ route('admin.teacher-schedules.edit', $teacherSchedule) }}" class="btn-warning">
                    <i class="fas fa-edit mr-2"></i>Edit Jadwal
                </a>
                <form action="{{ route('admin.teacher-schedules.toggle-status', $teacherSchedule) }}" method="POST"
                    class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn-{{ $teacherSchedule->is_active ? 'secondary' : 'success' }}">
                        <i class="fas fa-{{ $teacherSchedule->is_active ? 'times' : 'check' }} mr-2"></i>
                        {{ $teacherSchedule->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <form action="{{ route('admin.teacher-schedules.destroy', $teacherSchedule) }}" method="POST" class="inline"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        <i class="fas fa-trash mr-2"></i>Hapus
                    </button>
                </form>
            </div>
            <a href="{{ route('admin.teacher-schedules.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>

@endsection