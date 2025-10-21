@extends('layouts.admin')

@section('title', 'Log Absensi Siswa')

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

.dark {
    --bg-primary: #1e293b;
    --bg-secondary: #0f172a;
    --bg-tertiary: #334155;
    --text-primary: #f1f5f9;
    --text-secondary: #94a3b8;
    --border-color: #334155;
}

.attendance-log-container {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.attendance-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    transition: all 0.3s ease;
}

.class-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.class-card:hover { background-color: var(--bg-primary); }

.student-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.75rem;
    padding: 1rem;
    transition: all 0.2s ease;
}

.student-card:hover { background-color: var(--bg-tertiary); }

.student-card.confirmed { border-color: var(--border-color); background-color: var(--bg-primary); }
.student-card.unconfirmed { border-color: var(--border-color); background-color: var(--bg-primary); }

.attendance-form-input {
    background-color: var(--bg-primary);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.attendance-form-input:focus { border-color: #bbbbbb; box-shadow: none; outline: none; }

.status-badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
}

.confirmed-indicator { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .75rem; background: var(--bg-tertiary); color: var(--text-primary); border-radius:9999px; font-size:.8rem; font-weight:600; }
.confirmed-indicator i { opacity:.8; }

.class-header { background: var(--bg-tertiary); padding: 1rem; color: var(--text-primary); }

.class-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.class-stats {
    display: flex;
    gap: 1rem;
    margin-top: 0.5rem;
    font-size: 0.875rem;
}

.confirm-button { background: var(--bg-tertiary); color: var(--text-primary); border:1px solid var(--border-color); padding:.45rem .9rem; border-radius:6px; font-size:.875rem; font-weight:600; cursor:pointer; }
.confirm-button:hover { filter: brightness(0.97); }

.confirm-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    transform: none;
}

.bulk-confirm-section { background: var(--bg-tertiary); color: var(--text-primary); padding:.8rem; border-radius:8px; margin-bottom:1rem; border:1px solid var(--border-color); }

.bulk-confirm-section h4 {
    margin: 0 0 0.5rem 0;
    font-size: 1rem;
    font-weight: 600;
}

.bulk-confirm-section .btn {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
}

.bulk-confirm-section .btn:hover {
    background: rgba(255, 255, 255, 0.3);
}

.unconfirmed-indicator { display:inline-flex; align-items:center; gap:.5rem; padding:.35rem .75rem; background: var(--bg-tertiary); color: var(--text-primary); border-radius:9999px; font-size:.8rem; font-weight:600; }
.unconfirmed-indicator i { opacity:.8; }

.checkbox-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.checkbox-container input[type="checkbox"] {
    width: 1rem;
    height: 1rem;
    accent-color: var(--accent-color);
}

.checkbox-container label {
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
}

.confirmation-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.confirmation-modal.show {
    display: flex;
}

.modal-content {
    background: var(--bg-primary);
    color: var(--text-primary);
    border-radius: 0.75rem;
    padding: 2rem;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.modal-header h3 {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 600;
}

.modal-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: var(--text-secondary);
}

.modal-body {
    margin-bottom: 1.5rem;
}

.modal-footer {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.btn-secondary {
    background: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-secondary:hover {
    background: var(--border-color);
}

.btn-primary {
    background: var(--accent-color);
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: #2563eb;
}

.btn-success {
    background: #10b981;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-success:hover {
    background: #059669;
}

.btn-danger {
    background: #ef4444;
    color: white;
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-danger:hover {
    background: #dc2626;
}

.toast {
    position: fixed;
    top: 1rem;
    right: 1rem;
    background: var(--bg-primary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    padding: 1rem;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    z-index: 1001;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    max-width: 400px;
}

.toast.show {
    transform: translateX(0);
}

.toast.success {
    border-color: #10b981;
}

.toast.error {
    border-color: #ef4444;
}

.toast .toast-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.toast .toast-header strong {
    font-weight: 600;
}

.toast .toast-body {
    font-size: 0.875rem;
}

.loading-spinner {
    display: inline-block;
    width: 1rem;
    height: 1rem;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

@media (max-width: 768px) {
    .attendance-log-container {
        padding: 1rem;
    }
}
</style>

<div class="attendance-log-container min-h-screen p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Log Absensi Siswa
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    Kelola dan konfirmasi log absensi siswa per kelas
                </p>
            </div>

            <!-- Statistics Cards -->
            <div class="flex flex-wrap gap-4">
                <div class="attendance-card rounded-lg p-4 border">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-check-circle text-gray-800"></i>
                        </div>
                        <div>
                            <p class="text-sm" style="color: var(--text-secondary)">Dikonfirmasi</p>
                            <p class="text-xl font-semibold" style="color: var(--text-primary)">{{ $totalConfirmed }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-clock text-gray-800"></i>
                        </div>
                        <div>
                            <p class="text-sm" style="color: var(--text-secondary)">Belum Dikonfirmasi</p>
                            <p class="text-xl font-semibold" style="color: var(--text-primary)">{{ $totalUnconfirmed }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gray-200 rounded-lg">
                            <i class="fas fa-users text-gray-800"></i>
                        </div>
                        <div>
                            <p class="text-sm" style="color: var(--text-secondary)">Total Hadir</p>
                            <p class="text-xl font-semibold" style="color: var(--text-primary)">{{ $totalPresent }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="attendance-card rounded-lg p-6 border">
            <form method="GET" action="{{ route('admin.qr-attendance.logs') }}" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Tanggal
                    </label>
                    <input type="date" id="date" name="date" value="{{ $date }}"
                           class="attendance-form-input w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Cari Kelas
                    </label>
                    <input type="text" id="search" name="search" value="{{ $search }}" placeholder="Nama kelas..."
                           class="attendance-form-input w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>

                    <a href="{{ route('admin.qr-attendance.logs', ['export' => 'csv'] + request()->query()) }}"
                       class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                        <i class="fas fa-download mr-2"></i>Export
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Confirmation Section -->
    @if($totalUnconfirmed > 0)
    <div class="bulk-confirm-section mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h4 class="flex items-center gap-2">
                    <i class="fas fa-tasks"></i>
                    Konfirmasi Massal
                </h4>
                <p class="text-sm opacity-90 mb-0">
                    Pilih beberapa log absensi untuk dikonfirmasi sekaligus
                </p>
            </div>
            <div class="flex gap-2">
                <button id="selectAllBtn" class="btn btn-secondary">
                    <i class="fas fa-check-square mr-2"></i>Pilih Semua
                </button>
                <button id="bulkConfirmBtn" class="btn btn-success" disabled>
                    <i class="fas fa-check-double mr-2"></i>Konfirmasi Terpilih
                </button>
            </div>
        </div>
    </div>
    @endif

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Total Kelas -->
        <div class="attendance-card rounded-lg overflow-hidden border">
            <div class="p-4 border-b" style="border-color: var(--border-color)">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm" style="color: var(--text-secondary)">Total Kelas</p>
                        <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $attendanceByClass->count() }}</p>
                    </div>
                    <div class="p-2 bg-gray-200 rounded">
                        <i class="fas fa-school text-gray-800 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Siswa Hadir -->
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="p-4 border-b" style="border-color: var(--border-color)">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm" style="color: var(--text-secondary)">Total Hadir</p>
                        <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $totalPresent }}</p>
                    </div>
                    <div class="p-2 bg-gray-200 rounded">
                        <i class="fas fa-user-check text-gray-800 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Terkonfirmasi -->
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="p-4 border-b" style="border-color: var(--border-color)">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm" style="color: var(--text-secondary)">Terkonfirmasi</p>
                        <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $totalConfirmed }}</p>
                    </div>
                    <div class="p-2 bg-gray-200 rounded">
                        <i class="fas fa-check-double text-gray-800 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Konfirmasi -->
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="p-4 border-b" style="border-color: var(--border-color)">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm" style="color: var(--text-secondary)">Menunggu Konfirmasi</p>
                        <p class="text-2xl font-bold" style="color: var(--text-primary)">{{ $totalUnconfirmed }}</p>
                    </div>
                    <div class="p-2 bg-gray-200 rounded">
                        <i class="fas fa-clock text-gray-800 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Cards Grid -->
    @if($attendanceByClass->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($attendanceByClass as $classData)
                <div class="class-card">
                    <!-- Class Header -->
                    <div class="class-header">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="p-3 bg-gray-200 rounded-xl mr-3">
                                    <i class="fas fa-users text-gray-800 text-xl"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold">{{ $classData['class']->name }}</h3>
                                    <p class="text-sm" style="color: var(--text-secondary)">
                                        {{ $classData['confirmed_count'] }} Terkonfirmasi • {{ $classData['unconfirmed_count'] }} Menunggu
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($classData['unconfirmed_count'] > 0)
                                    <div class="unconfirmed-indicator">
                                        <i class="fas fa-clock"></i>
                                        Pending
                                    </div>
                                @else
                                    <div class="confirmed-indicator">
                                        <i class="fas fa-check-circle"></i>
                                        Verified
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="progress-bar" style="height: 6px; background: var(--bg-tertiary); border-radius: 9999px; overflow: hidden;">
                            <div class="progress-fill" style="height: 100%; background: #bbb; width: {{ $classData['total_count'] > 0 ? round(($classData['confirmed_count'] / $classData['total_count']) * 100) : 0 }}%"></div>
                        </div>
                        <p class="text-xs mt-2" style="color: var(--text-secondary)">
                            {{ $classData['confirmed_count'] }}/{{ $classData['total_count'] }} siswa terkonfirmasi
                        </p>
                    </div>

                    <!-- Students List -->
                    <div class="p-6 space-y-3 max-h-96 overflow-y-auto">
                        <!-- Unconfirmed Students First -->
                        @if($classData['unconfirmed_students']->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold mb-3 flex items-center gap-2" style="color: var(--text-secondary);">
                                    <i class="fas fa-clock text-gray-700"></i>
                                    Menunggu Konfirmasi ({{ $classData['unconfirmed_students']->count() }})
                                </h4>
                                @foreach($classData['unconfirmed_students'] as $student)
                                    <div class="student-card unconfirmed" data-log-id="{{ $student->log_id }}">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <!-- Checkbox for bulk selection -->
                                                <input type="checkbox" class="attendance-checkbox mr-3" value="{{ $student->log_id }}">

                                                <!-- Student Avatar -->
                                                @if($student->photo_url)
                                                    <img src="{{ $student->photo_url }}" alt="{{ $student->name }}"
                                                         class="w-12 h-12 rounded-full border-2 border-yellow-200 dark:border-yellow-600 mr-3">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                                    </div>
                                                @endif

                                                <!-- Student Info -->
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <h4 class="font-semibold" style="color: var(--text-primary);">{{ $student->name }}</h4>
                                                        <i class="fas fa-clock text-yellow-500 text-sm"></i>
                                                    </div>
                                                    <div class="flex items-center gap-3 mt-1">
                                                        <p class="text-sm" style="color: var(--text-secondary);">{{ $student->nis }}</p>
                                                        @if($student->scan_time)
                                                            <span class="text-xs px-2 py-1 bg-gray-200 rounded" style="color: var(--text-secondary);">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ \Carbon\Carbon::parse($student->scan_time)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- Status Badge -->
                                                    <div class="mt-2">
                                                        @php
                                                            $statusConfig = match($student->status) {
                                                                'hadir' => ['class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200', 'icon' => 'check', 'text' => 'Hadir'],
                                                                'terlambat' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'icon' => 'clock', 'text' => 'Terlambat'],
                                                                'izin' => ['class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', 'icon' => 'info-circle', 'text' => 'Izin'],
                                                                'sakit' => ['class' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', 'icon' => 'medkit', 'text' => 'Sakit'],
                                                                default => ['class' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200', 'icon' => 'minus', 'text' => 'Alpha']
                                                            };
                                                        @endphp
                                                        <span class="status-badge {{ $statusConfig['class'] }}">
                                                            <i class="fas fa-{{ $statusConfig['icon'] }} mr-1"></i>
                                                            {{ $statusConfig['text'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Buttons -->
                                            <div class="ml-4 flex gap-2">
                                                <button class="confirm-button confirm-single-btn"
                                                        data-log-id="{{ $student->log_id }}"
                                                        data-student-name="{{ $student->name }}">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Notes if any -->
                                        @if($student->notes)
                                            <div class="mt-3 pt-3 border-t" style="border-color: var(--border-color);">
                                                <p class="text-sm flex items-start gap-2" style="color: var(--text-secondary);">
                                                    <i class="fas fa-sticky-note mt-0.5 flex-shrink-0"></i>
                                                    <span>{{ $student->notes }}</span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Confirmed Students -->
                        @if($classData['confirmed_students']->count() > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold mb-3 flex items-center gap-2" style="color: var(--text-secondary);">
                                    <i class="fas fa-check-circle text-emerald-500"></i>
                                    Sudah Dikonfirmasi ({{ $classData['confirmed_students']->count() }})
                                </h4>
                                @foreach($classData['confirmed_students'] as $student)
                                    <div class="student-card confirmed">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center flex-1">
                                                <!-- Student Avatar -->
                                                @if($student->photo_url)
                                                    <img src="{{ $student->photo_url }}" alt="{{ $student->name }}"
                                                         class="w-12 h-12 rounded-full border-2 border-emerald-200 dark:border-emerald-600 mr-3">
                                                @else
                                                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold text-sm mr-3">
                                                        {{ strtoupper(substr($student->name, 0, 2)) }}
                                                    </div>
                                                @endif

                                                <!-- Student Info -->
                                                <div class="flex-1">
                                                    <div class="flex items-center gap-2">
                                                        <h4 class="font-semibold" style="color: var(--text-primary);">{{ $student->name }}</h4>
                                                        <i class="fas fa-check-circle text-gray-700 text-sm"></i>
                                                    </div>
                                                    <div class="flex items-center gap-3 mt-1">
                                                        <p class="text-sm" style="color: var(--text-secondary);">{{ $student->nis }}</p>
                                                        @if($student->scan_time)
                                                            <span class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded" style="color: var(--text-secondary);">
                                                                <i class="fas fa-clock mr-1"></i>
                                                                {{ \Carbon\Carbon::parse($student->scan_time)->format('H:i') }}
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <!-- Status Badge -->
                                                    <div class="mt-2">
                                                        @php
                                                            $statusConfig = match($student->status) {
                                                                'hadir' => ['class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200', 'icon' => 'check', 'text' => 'Hadir'],
                                                                'terlambat' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200', 'icon' => 'clock', 'text' => 'Terlambat'],
                                                                'izin' => ['class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', 'icon' => 'info-circle', 'text' => 'Izin'],
                                                                'sakit' => ['class' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', 'icon' => 'medkit', 'text' => 'Sakit'],
                                                                default => ['class' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200', 'icon' => 'minus', 'text' => 'Alpha']
                                                            };
                                                        @endphp
                                                        <span class="status-badge {{ $statusConfig['class'] }}">
                                                            <i class="fas fa-{{ $statusConfig['icon'] }} mr-1"></i>
                                                            {{ $statusConfig['text'] }}
                                                        </span>
                                                    </div>

                                                    <!-- Confirmed By Info -->
                                                    @if($student->confirmedBy)
                                                        <div class="mt-2 flex items-center gap-2">
                                                            @if($student->confirmedBy->photo_url)
                                                                <img src="{{ $student->confirmedBy->photo_url }}" alt="{{ $student->confirmedBy->name }}"
                                                                     class="w-6 h-6 rounded-full border border-purple-300">
                                                            @else
                                                                <div class="w-6 h-6 rounded-full bg-gradient-to-r from-purple-500 to-pink-500 flex items-center justify-center text-white text-xs font-bold">
                                                                    {{ strtoupper(substr($student->confirmedBy->name, 0, 1)) }}
                                                                </div>
                                                            @endif
                                                            <span class="text-xs" style="color: var(--text-secondary);">
                                                                Dikonfirmasi oleh {{ $student->confirmedBy->name }}
                                                                @if($student->confirmed_at)
                                                                    • {{ \Carbon\Carbon::parse($student->confirmed_at)->format('H:i') }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Status Icon -->
                                            <div class="ml-4">
                                                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                                                    <i class="fas fa-shield-check text-gray-700"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Notes if any -->
                                        @if($student->notes)
                                            <div class="mt-3 pt-3 border-t" style="border-color: var(--border-color);">
                                                <p class="text-sm flex items-start gap-2" style="color: var(--text-secondary);">
                                                    <i class="fas fa-sticky-note mt-0.5 flex-shrink-0"></i>
                                                    <span>{{ $student->notes }}</span>
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Class Footer Info -->
                    <div class="p-4 border-t" style="border-color: var(--border-color); background-color: var(--bg-secondary);">
                        <div class="text-center py-2">
                            @if($classData['unconfirmed_count'] > 0)
                                <i class="fas fa-clock text-gray-700 text-2xl mb-2"></i>
                                <p class="text-sm font-semibold" style="color: var(--text-primary);">
                                    {{ $classData['unconfirmed_count'] }} siswa menunggu konfirmasi
                                </p>
                                <p class="text-xs mt-1" style="color: var(--text-secondary);">
                                    Klik tombol konfirmasi untuk memverifikasi data
                                </p>
                            @else
                                <i class="fas fa-shield-check text-gray-700 text-2xl mb-2"></i>
                                <p class="text-sm font-semibold" style="color: var(--text-primary);">
                                    Semua data absensi kelas ini telah diverifikasi
                                </p>
                                <p class="text-xs mt-1" style="color: var(--text-secondary);">
                                    Data resmi dan dapat digunakan untuk laporan
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="attendance-card rounded-2xl shadow-xl p-12">
            <div class="empty-state">
                <i class="fas fa-calendar-times text-6xl mb-4" style="color: var(--text-secondary); opacity: 0.5;"></i>
                <p class="text-xl font-semibold" style="color: var(--text-primary);">Tidak ada data absensi terkonfirmasi</p>
                <p class="text-sm mt-2" style="color: var(--text-secondary);">untuk tanggal {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                <div class="mt-4">
                    <a href="{{ route('admin.qr-attendance.logs', ['date' => date('Y-m-d')]) }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-all">
                        <i class="fas fa-calendar-day mr-2"></i>
                        Lihat Data Hari Ini
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
/**
 * Export confirmed attendance data to CSV
 */
function exportConfirmed() {
    const params = new URLSearchParams(window.location.search);
    params.set('export', 'csv');

    // Show loading notification
    showNotification('Menyiapkan file CSV...', 'info');

    const downloadUrl = '{{ route("admin.qr-attendance.logs") }}?' + params.toString();
    const link = document.createElement('a');
    link.href = downloadUrl;

    let filename = 'log-absensi-qr-dikonfirmasi';
    const date = params.get('date') || new Date().toISOString().split('T')[0];
    filename += '-' + date + '.csv';
    link.download = filename;

    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

    setTimeout(() => {
        showNotification('File CSV berhasil didownload!', 'success');
    }, 1000);
}

/**
 * Show notification
 */
function showNotification(message, type = 'success') {
    const bgColor = type === 'success' ? 'bg-emerald-600' : type === 'info' ? 'bg-blue-600' : 'bg-red-600';
    const icon = type === 'success' ? 'fa-check-circle' : type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle';

    const toast = document.createElement('div');
    toast.className = `fixed bottom-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-2 transition-all`;
    toast.style.opacity = '0';
    toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    // Fade in
    setTimeout(() => {
        toast.style.opacity = '1';
    }, 10);

    // Fade out and remove
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, 3000);
}

/**
 * Confirm single attendance log
 */
function confirmSingleAttendance(logId, studentName) {
    if (!confirm(`Apakah Anda yakin ingin mengkonfirmasi absensi ${studentName}?`)) {
        return;
    }

    const button = document.querySelector(`[data-log-id="${logId}"] .confirm-single-btn`);
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    fetch(`{{ route('admin.qr-attendance.logs.confirm', '') }}/${logId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            notes: ''
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Gagal mengkonfirmasi absensi', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengkonfirmasi absensi', 'error');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

/**
 * Bulk confirm selected attendance logs
 */
function bulkConfirmAttendance() {
    const selectedCheckboxes = document.querySelectorAll('.attendance-checkbox:checked');
    if (selectedCheckboxes.length === 0) {
        showNotification('Pilih setidaknya satu log absensi untuk dikonfirmasi', 'error');
        return;
    }

    const logIds = Array.from(selectedCheckboxes).map(cb => cb.value);
    const studentNames = Array.from(selectedCheckboxes).map(cb => {
        const card = cb.closest('.student-card');
        return card.querySelector('h4').textContent.trim();
    });

    if (!confirm(`Apakah Anda yakin ingin mengkonfirmasi ${logIds.length} log absensi?\n\n${studentNames.join('\n')}`)) {
        return;
    }

    const button = document.getElementById('bulkConfirmBtn');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengkonfirmasi...';
    button.disabled = true;

    fetch('{{ route('admin.qr-attendance.logs.bulk-confirm') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            log_ids: logIds,
            notes: ''
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showNotification(data.message || 'Gagal mengkonfirmasi absensi', 'error');
            button.innerHTML = originalText;
            button.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Terjadi kesalahan saat mengkonfirmasi absensi', 'error');
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

/**
 * Select/Deselect all checkboxes
 */
function toggleSelectAll() {
    const selectAllBtn = document.getElementById('selectAllBtn');
    const checkboxes = document.querySelectorAll('.attendance-checkbox');
    const bulkConfirmBtn = document.getElementById('bulkConfirmBtn');

    const allChecked = Array.from(checkboxes).every(cb => cb.checked);

    if (allChecked) {
        // Deselect all
        checkboxes.forEach(cb => cb.checked = false);
        selectAllBtn.innerHTML = '<i class="fas fa-check-square mr-2"></i>Pilih Semua';
        bulkConfirmBtn.disabled = true;
    } else {
        // Select all
        checkboxes.forEach(cb => cb.checked = true);
        selectAllBtn.innerHTML = '<i class="fas fa-square mr-2"></i>Batal Pilih';
        bulkConfirmBtn.disabled = false;
    }
}

/**
 * Update bulk confirm button state based on selections
 */
function updateBulkConfirmButton() {
    const checkboxes = document.querySelectorAll('.attendance-checkbox');
    const bulkConfirmBtn = document.getElementById('bulkConfirmBtn');
    const selectAllBtn = document.getElementById('selectAllBtn');

    const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;

    bulkConfirmBtn.disabled = checkedCount === 0;

    if (checkedCount > 0) {
        bulkConfirmBtn.innerHTML = `<i class="fas fa-check-double mr-2"></i>Konfirmasi ${checkedCount} Terpilih`;
    } else {
        bulkConfirmBtn.innerHTML = '<i class="fas fa-check-double mr-2"></i>Konfirmasi Terpilih';
    }

    // Update select all button text
    const allChecked = Array.from(checkboxes).every(cb => cb.checked);
    const noneChecked = Array.from(checkboxes).every(cb => !cb.checked);

    if (allChecked) {
        selectAllBtn.innerHTML = '<i class="fas fa-square mr-2"></i>Batal Pilih';
    } else if (noneChecked) {
        selectAllBtn.innerHTML = '<i class="fas fa-check-square mr-2"></i>Pilih Semua';
    } else {
        selectAllBtn.innerHTML = '<i class="fas fa-minus-square mr-2"></i>Batal Pilih';
    }
}

/**
 * Auto refresh every 30 seconds if viewing today's logs
 */
@if($date == date('Y-m-d'))
    let refreshInterval;

    function startAutoRefresh() {
        refreshInterval = setInterval(function() {
            if (!document.hidden) {
                const refreshIndicator = document.createElement('div');
                refreshIndicator.className = 'fixed top-4 right-4 bg-emerald-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                refreshIndicator.innerHTML = '<i class="fas fa-sync-alt animate-spin mr-2"></i>Memperbarui...';
                document.body.appendChild(refreshIndicator);

                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }, 30000);
    }

    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    }

    startAutoRefresh();

    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            startAutoRefresh();
        }
    });
@endif

/**
 * Smooth scroll behavior and animations
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Attendance logs page loaded');

    // Add smooth hover animations to student cards
    const studentCards = document.querySelectorAll('.student-card');
    studentCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.boxShadow = '0 10px 15px -3px rgba(0, 0, 0, 0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.boxShadow = '';
        });
    });

    // Handle single confirmation buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.confirm-single-btn')) {
            e.preventDefault();
            const button = e.target.closest('.confirm-single-btn');
            const logId = button.getAttribute('data-log-id');
            const studentName = button.getAttribute('data-student-name');
            confirmSingleAttendance(logId, studentName);
        }
    });

    // Handle bulk confirmation
    const bulkConfirmBtn = document.getElementById('bulkConfirmBtn');
    if (bulkConfirmBtn) {
        bulkConfirmBtn.addEventListener('click', bulkConfirmAttendance);
    }

    // Handle select all button
    const selectAllBtn = document.getElementById('selectAllBtn');
    if (selectAllBtn) {
        selectAllBtn.addEventListener('click', toggleSelectAll);
    }

    // Handle checkbox changes
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('attendance-checkbox')) {
            updateBulkConfirmButton();
        }
    });

    // Initialize bulk confirm button state
    updateBulkConfirmButton();

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + R to reload
        if ((e.ctrlKey || e.metaKey) && e.key === 'r') {
            e.preventDefault();
            location.reload();
        }

        // Ctrl/Cmd + E to export
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            exportConfirmed();
        }
    });

    // Add fade-in animation on load
    const classCards = document.querySelectorAll('.class-card');
    classCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

/**
 * Custom scrollbar for student lists
 */
const style = document.createElement('style');
style.textContent = `
    .class-card .p-6::-webkit-scrollbar {
        width: 8px;
    }
    .class-card .p-6::-webkit-scrollbar-track {
        background: var(--bg-tertiary);
        border-radius: 10px;
    }
    .class-card .p-6::-webkit-scrollbar-thumb {
        background: var(--accent-color);
        border-radius: 10px;
    }
    .class-card .p-6::-webkit-scrollbar-thumb:hover {
        background: #3b82f6;
    }

    @media print {
        .flex.flex-wrap.gap-3,
        button[onclick*="export"] {
            display: none !important;
        }
        .class-card {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }
        .student-card {
            page-break-inside: avoid;
        }
    }
`;
document.head.appendChild(style);

/**
 * Print functionality
 */
function printAttendance() {
    window.print();
}
</script>
@endpush
