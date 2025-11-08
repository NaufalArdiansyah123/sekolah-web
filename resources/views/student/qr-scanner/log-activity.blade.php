@extends('layouts.student')

@section('title', 'Log Aktivitas PKL')

@section('content')
    <div class="min-h-screen bg-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
        <div class="max-w-7xl mx-auto">

            @if(isset($error))
                <!-- Error State -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 text-center">
                    <div
                        class="w-20 h-20 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
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
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Log Aktivitas PKL</h1>
                            <p class="text-gray-600 dark:text-gray-400">Catat aktivitas harian PKL Anda</p>
                        </div>
                        <a href="{{ route('student.qr-scanner.index') }}"
                            class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-arrow-left"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                @if($pklRegistration)
                    <!-- PKL Info Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-building text-2xl text-blue-600 dark:text-blue-400"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $pklRegistration->tempatPkl->nama_tempat ?? 'N/A' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Periode: {{ \Carbon\Carbon::parse($pklRegistration->tanggal_mulai)->format('d M Y') }} -
                                    {{ \Carbon\Carbon::parse($pklRegistration->tanggal_selesai)->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Log Activity Table -->
                    @if($logs->count() > 0)
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                                No</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                                Tanggal</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                                Activity Log</th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $index => $log)
                                            <tr
                                                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-300 font-medium">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-900 dark:text-white font-medium">
                                                        {{ \Carbon\Carbon::parse($log->scan_date)->format('d M Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Masuk: {{ \Carbon\Carbon::parse($log->scan_time)->format('H:i') }}
                                                        @if($log->check_out_time)
                                                            | Pulang: {{ \Carbon\Carbon::parse($log->check_out_time)->format('H:i') }}
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 align-top">
                                                    <div id="log-content-{{ $log->id }}" class="{{ $log->log_activity ? '' : 'hidden' }}">
                                                        <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-normal break-words"
                                                            id="log-text-{{ $log->id }}">
                                                            {{ $log->log_activity ?? '-' }}
                                                        </p>
                                                    </div>
                                                    <div id="log-form-container-{{ $log->id }}"
                                                        class="{{ $log->log_activity ? 'hidden' : '' }}">
                                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic">Belum ada log aktivitas
                                                        </p>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 align-top whitespace-nowrap">
                                                    <!-- Action Buttons -->
                                                    <div id="log-actions-{{ $log->id }}"
                                                        class="{{ $log->log_activity && !request()->has('edit') ? '' : 'hidden' }}">
                                                        <button onclick="editLog({{ $log->id }})"
                                                            class="flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm transition">
                                                            <i class="fas fa-edit"></i>
                                                            Edit
                                                        </button>
                                                    </div>

                                                    <!-- Add Button (when no log yet) -->
                                                    <div id="log-add-btn-{{ $log->id }}" class="{{ !$log->log_activity ? '' : 'hidden' }}">
                                                        <button onclick="addLog({{ $log->id }})"
                                                            class="flex items-center gap-1 bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm transition">
                                                            <i class="fas fa-plus"></i>
                                                            Tambah
                                                        </button>
                                                    </div>

                                                    <!-- Edit Form (Hidden until clicked) -->
                                                    <form id="log-form-{{ $log->id }}" class="hidden"
                                                        onsubmit="saveLogActivity(event, {{ $log->id }})">
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $logs->links() }}
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-12 text-center">
                            <div
                                class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-clipboard-list text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Belum Ada Data Absensi</h3>
                            <p class="text-gray-600 dark:text-gray-400 mb-6">Silakan melakukan absensi terlebih dahulu untuk menambahkan
                                log aktivitas.</p>
                            <a href="{{ route('student.qr-scanner.index') }}"
                                class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition">
                                <i class="fas fa-qrcode"></i>
                                Scan Sekarang
                            </a>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    </div>

    <!-- Edit Log Activity Modal -->
    <div id="edit-log-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-2xl">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Edit Log Aktivitas</h2>

            <form id="edit-log-form" onsubmit="saveLogActivity(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Log Aktivitas</label>
                    <textarea id="edit-log-textarea" name="log_activity" rows="6"
                        style="text-align: left; vertical-align: top;"
                        class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white resize-none"
                        placeholder="Tulis aktivitas PKL Anda (minimal 10 karakter)..." required></textarea>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                        <span id="edit-char-count">0</span> / 2000 karakter
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                        Batal
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
            <p class="text-gray-700 dark:text-gray-300">Menyimpan...</p>
        </div>
    </div>

    <!-- Notification Modal -->
    <div id="notification-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
            <div class="text-center">
                <!-- Icon Container -->
                <div id="notification-icon-container"
                    class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i id="notification-icon" class="text-4xl"></i>
                </div>
                <!-- Title -->
                <h2 id="notification-title" class="text-2xl font-bold mb-2"></h2>
                <!-- Message -->
                <p id="notification-message" class="text-gray-600 dark:text-gray-400 mb-6"></p>
                <!-- Action Button -->
                <button id="notification-close-btn" class="w-full px-6 py-3 rounded-lg font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <style>
        #edit-log-textarea {
            text-align: left !important;
            vertical-align: top !important;
        }
    </style>

@endsection

@push('scripts')
    <script>
        function showNotification(type, title, message) {
            const modal = document.getElementById('notification-modal');
            const iconContainer = document.getElementById('notification-icon-container');
            const icon = document.getElementById('notification-icon');
            const titleElement = document.getElementById('notification-title');
            const messageElement = document.getElementById('notification-message');
            const closeBtn = document.getElementById('notification-close-btn');

            // Reset classes
            iconContainer.className = 'w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4';
            icon.className = 'text-4xl';
            closeBtn.className = 'w-full px-6 py-3 rounded-lg font-medium transition';

            if (type === 'success') {
                iconContainer.classList.add('bg-green-100', 'dark:bg-green-900/20');
                icon.classList.add('fas', 'fa-check-circle', 'text-green-600', 'dark:text-green-400');
                titleElement.className = 'text-2xl font-bold mb-2 text-green-600 dark:text-green-400';
                closeBtn.classList.add('bg-green-600', 'hover:bg-green-700', 'text-white');
            } else if (type === 'error') {
                iconContainer.classList.add('bg-red-100', 'dark:bg-red-900/20');
                icon.classList.add('fas', 'fa-times-circle', 'text-red-600', 'dark:text-red-400');
                titleElement.className = 'text-2xl font-bold mb-2 text-red-600 dark:text-red-400';
                closeBtn.classList.add('bg-red-600', 'hover:bg-red-700', 'text-white');
            } else if (type === 'warning') {
                iconContainer.classList.add('bg-yellow-100', 'dark:bg-yellow-900/20');
                icon.classList.add('fas', 'fa-exclamation-triangle', 'text-yellow-600', 'dark:text-yellow-400');
                titleElement.className = 'text-2xl font-bold mb-2 text-yellow-600 dark:text-yellow-400';
                closeBtn.classList.add('bg-yellow-600', 'hover:bg-yellow-700', 'text-white');
            }

            titleElement.textContent = title;
            messageElement.textContent = message;

            modal.classList.remove('hidden');
        }

        function closeNotification() {
            const modal = document.getElementById('notification-modal');
            modal.classList.add('hidden');
        }

        function addLog(logId) {
            document.getElementById('log-add-btn-' + logId).classList.add('hidden');
            openEditModal(logId, '');
        }

        function editLog(logId) {
            const logText = document.getElementById('log-text-' + logId).textContent;
            openEditModal(logId, logText);
        }

        function openEditModal(logId, content) {
            window.currentEditLogId = logId;
            const textarea = document.getElementById('edit-log-textarea');
            textarea.value = content;
            document.getElementById('edit-char-count').textContent = content.length;

            // Add character counter
            textarea.addEventListener('input', function () {
                document.getElementById('edit-char-count').textContent = this.value.length;
            });

            document.getElementById('edit-log-modal').classList.remove('hidden');
        }

        function closeEditModal() {
            const logId = window.currentEditLogId;

            // Jika belum ada log activity, tampilkan kembali tombol tambah
            const logContent = document.getElementById('log-content-' + logId);
            if (logContent && logContent.classList.contains('hidden')) {
                const addBtn = document.getElementById('log-add-btn-' + logId);
                if (addBtn) {
                    addBtn.classList.remove('hidden');
                }
            }

            document.getElementById('edit-log-modal').classList.add('hidden');
        }

        async function saveLogActivity(event) {
            event.preventDefault();

            const logId = window.currentEditLogId;
            const textarea = document.getElementById('edit-log-textarea');
            const logActivity = textarea.value.trim();

            if (logActivity.length < 10) {
                showNotification('warning', 'Terlalu Pendek', 'Log aktivitas minimal 10 karakter!');
                return;
            }

            if (logActivity.length > 2000) {
                showNotification('error', 'Terlalu Panjang', 'Log aktivitas maksimal 2000 karakter!');
                return;
            }

            // Show loading
            document.getElementById('loading-overlay').classList.remove('hidden');

            try {
                const response = await fetch(`/student/qr-scanner/log-activity/${logId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        log_activity: logActivity
                    })
                });

                const data = await response.json();

                // Hide loading
                document.getElementById('loading-overlay').classList.add('hidden');

                if (data.success) {
                    // Update the display
                    document.getElementById('log-text-' + logId).textContent = data.data.log_activity;
                    document.getElementById('log-content-' + logId).classList.remove('hidden');
                    document.getElementById('log-form-container-' + logId).classList.add('hidden');
                    document.getElementById('log-actions-' + logId).classList.remove('hidden');
                    document.getElementById('log-add-btn-' + logId).classList.add('hidden');

                    // Close modal
                    closeEditModal();

                    // Show success notification
                    showNotification('success', 'Berhasil!', data.message || 'Log aktivitas berhasil disimpan.');
                } else {
                    // Show error notification
                    showNotification('error', 'Gagal!', data.message || 'Gagal menyimpan log aktivitas.');
                }
            } catch (error) {
                console.error('Error:', error);
                // Hide loading
                document.getElementById('loading-overlay').classList.add('hidden');
                // Show error notification
                showNotification('error', 'Terjadi Kesalahan', 'Terjadi kesalahan saat menyimpan log aktivitas.');
            }
        }

        // Event listener for notification close button
        document.addEventListener('DOMContentLoaded', function () {
            const notificationCloseBtn = document.getElementById('notification-close-btn');
            const notificationModal = document.getElementById('notification-modal');
            const editLogModal = document.getElementById('edit-log-modal');

            if (notificationCloseBtn) {
                notificationCloseBtn.addEventListener('click', closeNotification);
            }

            // Close notification when clicking outside
            if (notificationModal) {
                notificationModal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeNotification();
                    }
                });
            }

            // Close edit modal when clicking outside
            if (editLogModal) {
                editLogModal.addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeEditModal();
                    }
                });
            }

            // Close modal on ESC key
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeEditModal();
                }
            });
        });
    </script>
@endpush