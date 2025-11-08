@extends('layouts.student')

@section('title', 'Riwayat Absensi')

@push('meta')
    <meta name="student-id" content="{{ $student->id }}">
    <meta name="user-id" content="{{ auth()->id() }}">
@endpush

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    Riwayat Absensi
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Pantau dan kelola riwayat kehadiran Anda</p>
            </div>
            <div class="flex space-x-3">
                <button type="button" onclick="refreshData()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
                <button type="button" onclick="exportData()"
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-download mr-2"></i>Export CSV
                </button>
            </div>
        </div>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="bg-emerald-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-check text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                            {{ $monthlyStats['hadir'] ?? 0 }}</h3>
                        <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Hadir</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="bg-yellow-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-clock text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                            {{ $monthlyStats['terlambat'] ?? 0 }}</h3>
                        <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">Terlambat</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-user-clock text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ ($monthlyStats['izin'] ?? 0) + ($monthlyStats['sakit'] ?? 0) }}</h3>
                        <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Izin/Sakit</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
                <div class="flex items-center">
                    <div class="bg-red-500 w-12 h-12 rounded-full flex items-center justify-center mr-4">
                        <i class="fas fa-times text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $monthlyStats['alpha'] ?? 0 }}</h3>
                        <p class="text-sm font-medium text-red-700 dark:text-red-300">Alpha</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Controls -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-filter mr-2"></i>Filter Data Absensi
                </h3>
            </div>
            <div class="p-6">
                <form method="GET" action="{{ route('student.attendance.history') }}" id="filter-form">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="month"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                            <select name="month" id="month"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="year"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                            <select name="year" id="year"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label for="status"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                            <select name="status" id="status"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white">
                                <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                                <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                <option value="terlambat" {{ $status == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>Izin</option>
                                <option value="sakit" {{ $status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                <option value="alpha" {{ $status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">&nbsp;</label>
                            <div class="flex space-x-2">
                                <button type="submit"
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-search mr-2"></i>Filter
                                </button>
                                <a href="{{ route('student.attendance.history') }}"
                                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <i class="fas fa-undo mr-2"></i>Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Records Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <h3 class="text-lg font-semibold text-white mb-4 sm:mb-0 flex items-center">
                        <i class="fas fa-table mr-2"></i>Data Riwayat Absensi
                    </h3>
                    <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm">
                        {{ $attendanceRecords->total() }} records
                    </span>
                </div>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Hari</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Waktu Scan</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Lokasi</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Dibuat</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse($attendanceRecords as $record)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $record->attendance_date->format('d/m/Y') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        @php
                                            $dayName = $record->attendance_date->format('l');
                                            $dayIndo = [
                                                'Monday' => 'Senin',
                                                'Tuesday' => 'Selasa',
                                                'Wednesday' => 'Rabu',
                                                'Thursday' => 'Kamis',
                                                'Friday' => 'Jumat',
                                                'Saturday' => 'Sabtu',
                                                'Sunday' => 'Minggu'
                                            ][$dayName] ?? $dayName;
                                        @endphp
                                        {{ $dayIndo }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badgeColor = match ($record->status) {
                                                'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                                'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                                            {{ $record->status_text }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $record->scan_time ? $record->scan_time->format('H:i:s') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                        {{ $record->location ?? 'Sekolah' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                        {{ $record->created_at->diffForHumans() }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                                        <div class="flex flex-col items-center">
                                            <i class="fas fa-calendar-times text-4xl mb-4 text-gray-300 dark:text-gray-600"></i>
                                            <p class="text-lg font-medium">Tidak ada data absensi</p>
                                            <p class="text-sm">Belum ada riwayat absensi untuk periode yang dipilih</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($attendanceRecords->hasPages())
                    <div class="mt-6 flex justify-center">
                        {{ $attendanceRecords->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Refresh data function
        function refreshData() {
            location.reload();
        }

        // Export data function
        function exportData() {
            const month = document.getElementById('month').value;
            const year = document.getElementById('year').value;

            window.open(`{{ route('student.attendance.export') }}?month=${month}&year=${year}`, '_blank');
        }

        // Apply filter function
        function applyFilter() {
            document.getElementById('filter-form').submit();
        }
    </script>
@endpush