@extends('layouts.student')

@section('title', 'Riwayat PKL')

@push('meta')
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
        <div class="max-w-7xl mx-auto">

            @if(isset($error))
                <!-- Error State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
                    <div class="w-20 h-20 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-exclamation-triangle text-3xl text-red-600 dark:text-red-400"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Akses Ditolak</h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">{{ $error }}</p>
                    <a href="{{ route('student.dashboard') }}"
                        class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                        <i class="fas fa-home"></i>
                        Kembali ke Dashboard
                    </a>
                </div>
            @else
                <!-- Header -->
                <div class="mb-6">
                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Riwayat PKL</h1>
                            <p class="text-gray-600 dark:text-gray-400">Daftar lengkap absensi PKL Anda</p>
                        </div>
                        @if($pklRegistration)
                            <div class="bg-blue-100 dark:bg-blue-900/20 rounded-lg px-4 py-3">
                                <p class="text-sm text-blue-800 dark:text-blue-200">
                                    <i class="fas fa-building mr-2"></i>
                                    <strong>{{ $pklRegistration->tempatPkl->nama_tempat ?? 'N/A' }}</strong>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Table Section -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                    <!-- Table Responsive -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="bg-gray-50 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <i class="fas fa-calendar mr-2"></i>Tanggal
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Jam Masuk
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Jam Pulang
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <i class="fas fa-tasks mr-2"></i>Status
                                    </th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <i class="fas fa-clipboard-list mr-2"></i>Aktivitas
                                    </th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-900 dark:text-white uppercase tracking-wider">
                                        <i class="fas fa-cog mr-2"></i>Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($attendanceLogs as $log)
                                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <!-- Tanggal -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-calendar text-blue-600 dark:text-blue-400"></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $log->scan_date?->format('d M Y') ?? '-' }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $log->scan_date?->format('l') ?? '-' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Jam Masuk -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                @if($log->scan_time)
                                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $log->scan_time->format('H:i:s') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $log->scan_time->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-500 dark:text-gray-400">-</span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Jam Pulang -->
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                @if($log->check_out_time)
                                                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                                        <i class="fas fa-sign-out-alt text-orange-600 dark:text-orange-400"></i>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 dark:text-white">
                                                            {{ $log->check_out_time->format('H:i:s') }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                                            {{ $log->check_out_time->diffForHumans() }}
                                                        </p>
                                                    </div>
                                                @else
                                                    <span class="px-3 py-1 bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200 text-xs font-medium rounded-full">
                                                        <i class="fas fa-clock mr-1"></i>Belum Pulang
                                                    </span>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="px-6 py-4">
                                            @php
                                                $statusClass = match($log->status) {
                                                    'present' => 'bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-200',
                                                    'absent' => 'bg-red-100 dark:bg-red-900/20 text-red-800 dark:text-red-200',
                                                    'late' => 'bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200',
                                                    'incomplete' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-200',
                                                    default => 'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200'
                                                };
                                                $statusLabel = match($log->status) {
                                                    'present' => 'Hadir',
                                                    'absent' => 'Absen',
                                                    'late' => 'Terlambat',
                                                    'incomplete' => 'Belum Lengkap',
                                                    default => ucfirst($log->status ?? 'Unknown')
                                                };
                                            @endphp
                                            <span class="px-3 py-1 {{ $statusClass }} text-xs font-medium rounded-full">
                                                {{ $statusLabel }}
                                            </span>
                                        </td>

                                        <!-- Aktivitas -->
                                        <td class="px-6 py-4">
                                            @if($log->log_activity)
                                                <div class="max-w-xs">
                                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2" title="{{ $log->log_activity }}">
                                                        {{ Str::limit($log->log_activity, 50, '...') }}
                                                    </p>
                                                </div>
                                            @else
                                                <span class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada</span>
                                            @endif
                                        </td>

                                        <!-- Aksi -->
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('student.qr-scanner.log-activity') }}"
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-blue-100 dark:bg-blue-900/20 hover:bg-blue-200 dark:hover:bg-blue-900/40 text-blue-700 dark:text-blue-300 rounded-lg transition text-xs font-medium"
                                                    title="Lihat/Edit Aktivitas">
                                                    <i class="fas fa-edit"></i>
                                                    <span class="hidden sm:inline">Aktivitas</span>
                                                </a>

                                                <button
                                                    class="inline-flex items-center gap-1 px-3 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition text-xs font-medium detail-btn"
                                                    data-scan-time="{{ $log->scan_time?->format('H:i:s') }}"
                                                    data-check-out-time="{{ $log->check_out_time?->format('H:i:s') }}"
                                                    data-qr-code="{{ $log->qr_code }}"
                                                    data-status="{{ $log->status }}"
                                                    title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                    <span class="hidden sm:inline">Detail</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                                    <i class="fas fa-inbox text-4xl text-gray-400 dark:text-gray-600"></i>
                                                </div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">Belum Ada Data</h3>
                                                <p class="text-gray-600 dark:text-gray-400">Anda belum memiliki riwayat absensi PKL.</p>
                                                <a href="{{ route('student.qr-scanner.index') }}"
                                                    class="mt-4 inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                                                    <i class="fas fa-qrcode"></i>
                                                    Mulai Absen
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($attendanceLogs->hasPages())
                        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Menampilkan <span class="font-semibold">{{ $attendanceLogs->firstItem() }}</span> hingga
                                    <span class="font-semibold">{{ $attendanceLogs->lastItem() }}</span> dari
                                    <span class="font-semibold">{{ $attendanceLogs->total() }}</span> data
                                </p>
                                <div>
                                    {{ $attendanceLogs->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detail-modal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Absensi</h2>
                <button id="close-detail-modal" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <div class="space-y-4">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">JAM MASUK</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white" id="detail-scan-time">-</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">JAM PULANG</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white" id="detail-check-out-time">-</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">STATUS</p>
                    <p class="text-lg font-bold text-gray-900 dark:text-white" id="detail-status">-</p>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-xs text-gray-500 dark:text-gray-400 font-semibold mb-1">QR CODE</p>
                    <p class="text-sm font-mono text-gray-900 dark:text-white break-all" id="detail-qr-code">-</p>
                </div>
            </div>

            <button id="close-modal-btn"
                class="w-full mt-6 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                Tutup
            </button>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const detailModal = document.getElementById('detail-modal');
            const closeDetailModal = document.getElementById('close-detail-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const detailBtns = document.querySelectorAll('.detail-btn');

            detailBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const scanTime = this.dataset.scanTime || '-';
                    const checkOutTime = this.dataset.checkOutTime || '-';
                    const qrCode = this.dataset.qrCode || '-';
                    const status = this.dataset.status || '-';

                    document.getElementById('detail-scan-time').textContent = scanTime;
                    document.getElementById('detail-check-out-time').textContent = checkOutTime;
                    document.getElementById('detail-qr-code').textContent = qrCode;
                    document.getElementById('detail-status').textContent = status.toUpperCase();

                    detailModal.classList.remove('hidden');
                });
            });

            closeDetailModal.addEventListener('click', () => {
                detailModal.classList.add('hidden');
            });

            closeModalBtn.addEventListener('click', () => {
                detailModal.classList.add('hidden');
            });

            // Close modal when clicking outside
            detailModal.addEventListener('click', function (e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
@endpush