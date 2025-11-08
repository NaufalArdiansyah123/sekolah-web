@extends('layouts.student')

@section('title', 'PKL QR Scanner - Masuk')

@push('meta')
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
@endpush

@section('content')
    <div
        class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900 py-8 px-4">
        <div class="max-w-6xl mx-auto">

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
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">PKL QR Scanner - Masuk</h1>
                            <p class="text-gray-600 dark:text-gray-400">Scan QR Code untuk mencatat waktu masuk PKL Anda</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <div id="camera-status"
                                class="flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <div class="w-2 h-2 rounded-full bg-gray-400"></div>
                                <span class="text-sm text-gray-700 dark:text-gray-300">Kamera: Idle</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <!-- Scanner Section -->
                    <div class="lg:col-span-2">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                            <!-- Scanner Container -->
                            <div class="relative">
                                <!-- Placeholder -->
                                <div id="scanner-placeholder" class="p-12 text-center bg-gray-50 dark:bg-gray-900">
                                    <div
                                        class="w-24 h-24 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-qrcode text-4xl text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Siap untuk Scan Masuk</h3>
                                    <p class="text-gray-600 dark:text-gray-400 mb-6">Klik tombol "Mulai Scan" untuk mengaktifkan
                                        kamera</p>
                                </div>

                                <!-- Scanner -->
                                <div id="qr-reader" class="hidden bg-black"></div>
                            </div>

                            <!-- Controls -->
                            <div class="p-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-center gap-3 mb-4">
                                    <button id="start-scanner"
                                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                                        @if(isset($todayScan)) disabled @endif>
                                        <i class="fas fa-play"></i>
                                        <span>Mulai Scan</span>
                                    </button>
                                    <button id="stop-scanner"
                                        class="hidden items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl">
                                        <i class="fas fa-stop"></i>
                                        <span>Stop</span>
                                    </button>
                                    <button id="manual-input-btn"
                                        class="flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl">
                                        <i class="fas fa-keyboard"></i>
                                        <span>Input Manual</span>
                                    </button>
                                </div>

                                <!-- Manual Input Modal -->
                                <div id="manual-input-modal"
                                    class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
                                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
                                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Input Manual QR Code
                                        </h2>
                                        <form id="manual-input-form">
                                            <div class="mb-4">
                                                <label for="qr-code-input"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">QR
                                                    Code</label>
                                                <input type="text" id="qr-code-input" name="qr_code"
                                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                                    required>
                                            </div>
                                            <div class="flex justify-end gap-4">
                                                <button type="button" id="cancel-manual-input"
                                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300">Batal</button>
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-4">
                        <!-- Instructions -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Petunjuk Scan Masuk</h3>
                            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <p><i class="fas fa-camera mr-2"></i>Pastikan kamera Anda berfungsi dengan baik.</p>
                                <p><i class="fas fa-qrcode mr-2"></i>Posisikan QR code di dalam area scan.</p>
                                <p><i class="fas fa-clock mr-2"></i>Scan akan mencatat waktu masuk Anda secara otomatis.</p>
                            </div>
                        </div>

                        <!-- Tips -->
                        <div
                            class="bg-amber-50 dark:bg-amber-900/20 border-2 border-amber-200 dark:border-amber-800 rounded-2xl p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-lightbulb text-amber-500"></i>
                                <h3 class="font-bold text-gray-900 dark:text-white">Tips Scan</h3>
                            </div>
                            <ul class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                    <span>Pastikan pencahayaan cukup</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                    <span>Jarak kamera 15-25 cm dari QR</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <i class="fas fa-check-circle text-amber-500 mt-0.5"></i>
                                    <span>Gunakan koneksi internet stabil</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>

    <!-- Response Modal -->
    <div id="response-modal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
        <div
            class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all">
            <div id="response-header"></div>
            <div id="response-content" class="p-6"></div>
            <div class="p-6 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700">
                <button onclick="closeResponseModal()" id="response-button"
                    class="w-full py-3 rounded-lg font-medium transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if(!isset($error))
        <script src="https://unpkg.com/html5-qrcode"></script>
        <script>
            let scannerInstance = null;
            let isScanning = false;


            function updateCameraStatus(status, message) {
                const statusEl = document.getElementById('camera-status');
                const dot = statusEl.querySelector('.w-2');
                const text = statusEl.querySelector('span');

                dot.className = 'w-2 h-2 rounded-full ';
                statusEl.className = 'flex items-center gap-2 px-4 py-2 rounded-lg ';

                switch (status) {
                    case 'active':
                        dot.classList.add('bg-green-500', 'animate-pulse');
                        statusEl.classList.add('bg-green-100', 'dark:bg-green-900/20');
                        text.textContent = 'Kamera: ' + (message || 'Aktif');
                        text.className = 'text-sm text-green-700 dark:text-green-300';
                        break;
                    case 'error':
                        dot.classList.add('bg-red-500');
                        statusEl.classList.add('bg-red-100', 'dark:bg-red-900/20');
                        text.textContent = 'Kamera: ' + (message || 'Error');
                        text.className = 'text-sm text-red-700 dark:text-red-300';
                        break;
                    case 'loading':
                        dot.classList.add('bg-yellow-500', 'animate-pulse');
                        statusEl.classList.add('bg-yellow-100', 'dark:bg-yellow-900/20');
                        text.textContent = 'Kamera: ' + (message || 'Loading...');
                        text.className = 'text-sm text-yellow-700 dark:text-yellow-300';
                        break;
                    default:
                        dot.classList.add('bg-gray-400');
                        statusEl.classList.add('bg-gray-100', 'dark:bg-gray-700');
                        text.textContent = 'Kamera: Idle';
                        text.className = 'text-sm text-gray-700 dark:text-gray-300';
                }
            }

            // Start QR Scanner
            async function startScanner() {
                console.debug('startScanner called, isScanning=', isScanning);
                if (isScanning) return;

                updateCameraStatus('loading', 'Memulai...');

                // Hide placeholder, show scanner
                document.getElementById('scanner-placeholder').classList.add('hidden');
                document.getElementById('qr-reader').classList.remove('hidden');

                try {
                    scannerInstance = new Html5Qrcode("qr-reader");

                    await scannerInstance.start(
                        { facingMode: "environment" },
                        {
                            fps: 10,
                            qrbox: { width: 250, height: 250 }
                        },
                        (decodedText) => onScanSuccess(decodedText),
                        (error) => { } // Ignore scan errors
                    );

                    isScanning = true;
                    updateCameraStatus('active');

                    // Toggle buttons
                    document.getElementById('start-scanner').classList.add('hidden');
                    const stopBtn = document.getElementById('stop-scanner');
                    stopBtn.classList.remove('hidden');
                    stopBtn.classList.add('flex');

                } catch (error) {
                    console.error('Camera error:', error);
                    updateCameraStatus('error', error.message);
                    showError('Tidak dapat mengaktifkan kamera', error.message);
                    stopScanner();
                }
            }

            // Stop QR Scanner
            async function stopScanner() {
                if (scannerInstance && isScanning) {
                    try {
                        await scannerInstance.stop();
                        await scannerInstance.clear();
                        scannerInstance = null;
                    } catch (error) {
                        console.error('Error stopping scanner:', error);
                    }
                }

                isScanning = false;
                updateCameraStatus('idle');

                // Show placeholder, hide scanner
                document.getElementById('qr-reader').classList.add('hidden');
                document.getElementById('scanner-placeholder').classList.remove('hidden');

                // Toggle buttons
                const stopBtn = document.getElementById('stop-scanner');
                stopBtn.classList.add('hidden');
                stopBtn.classList.remove('flex');
                document.getElementById('start-scanner').classList.remove('hidden');
            }

            // Handle successful scan
            async function onScanSuccess(qrCode) {
                await stopScanner();
                await submitScan(qrCode);
            }

            // Submit scan to server
            async function submitScan(qrCode) {
                try {
                    const response = await fetch('{{ route("student.qr-scanner.scan") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            qr_code: qrCode
                        })
                    });

                    const data = await response.json();

                    if (data.success) {
                        // Close any existing modal first
                        document.getElementById('response-modal').classList.add('hidden');

                        showResponseModal(true, data.message, data.data);
                        document.getElementById('response-modal').dataset.reload = 'true';
                        // Disable scan button
                        document.getElementById('start-scanner').disabled = true;
                        document.getElementById('manual-input-btn').disabled = true;
                    } else {
                        // Close any existing modal first
                        document.getElementById('response-modal').classList.add('hidden');

                        showResponseModal(false, 'Scan Gagal', data.message);
                    }

                } catch (error) {
                    console.error('Submit error:', error);
                    // Close any existing modal first
                    document.getElementById('response-modal').classList.add('hidden');

                    showResponseModal(false, 'Terjadi Kesalahan', 'Tidak dapat mengirim data. Periksa koneksi internet Anda.');
                }
            }

            // Show modal with response
            function showResponseModal(success, message, data = null) {
                console.debug('showResponseModal called', { success, message });
                // Close any existing modals first
                hideManualInputModal();

                const modal = document.getElementById('response-modal');
                const header = document.getElementById('response-header');
                const content = document.getElementById('response-content');
                const button = document.getElementById('response-button');

                // Update header based on response type
                if (success) {
                    header.innerHTML = `
                                                                                                                                <div class="bg-gradient-to-r from-green-500 to-emerald-600 p-6 text-white text-center">
                                                                                                                                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-3">
                                                                                                                                        <i class="fas fa-check text-3xl"></i>
                                                                                                                                    </div>
                                                                                                                                    <h2 class="text-2xl font-bold">Scan Berhasil!</h2>
                                                                                                                                </div>
                                                                                                                            `;
                    button.className = 'w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-medium transition';
                } else {
                    header.innerHTML = `
                                                                                                                                <div class="bg-gradient-to-r from-red-500 to-rose-600 p-6 text-white text-center">
                                                                                                                                    <div class="w-16 h-16 bg-white/20 backdrop-blur rounded-full flex items-center justify-center mx-auto mb-3">
                                                                                                                                        <i class="fas fa-exclamation-triangle text-3xl"></i>
                                                                                                                                    </div>
                                                                                                                                    <h2 class="text-2xl font-bold">Scan Gagal</h2>
                                                                                                                                </div>
                                                                                                                            `;
                    button.className = 'w-full bg-gray-600 hover:bg-gray-700 text-white py-3 rounded-lg font-medium transition';
                }

                // Update content based on response type
                if (success && data) {
                    content.innerHTML = `
                                                                                                                                <div class="space-y-4">
                                                                                                                                    <p class="text-gray-900 dark:text-white font-medium">${message}</p>
                                                                                                                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 space-y-2 text-sm">
                                                                                                                                        <div class="flex justify-between">
                                                                                                                                            <span class="text-gray-600 dark:text-gray-400">Waktu Scan:</span>
                                                                                                                                            <span class="font-medium text-gray-900 dark:text-white">${data.scan_time}</span>
                                                                                                                                        </div>
                                                                                                                                        <div class="flex justify-between">
                                                                                                                                            <span class="text-gray-600 dark:text-gray-400">Tanggal:</span>
                                                                                                                                            <span class="font-medium text-gray-900 dark:text-white">${data.scan_date}</span>
                                                                                                                                        </div>
                                                                                                                                        <div class="flex justify-between">
                                                                                                                                            <span class="text-gray-600 dark:text-gray-400">Tempat PKL:</span>
                                                                                                                                            <span class="font-medium text-gray-900 dark:text-white">${data.tempat_pkl}</span>
                                                                                                                                        </div>


                                                                                                                                    </div>
                                                                                                                                    <div class="flex items-center gap-2 p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                                                                                                                        <i class="fas fa-check-circle text-green-600 dark:text-green-400"></i>
                                                                                                                                        <span class="text-sm text-green-700 dark:text-green-300">Kehadiran Anda telah tercatat!</span>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            `;
                } else {
                    content.innerHTML = `
                                                                                                                                <div class="space-y-4">
                                                                                                                                    <p class="text-gray-900 dark:text-white font-medium">${message}</p>
                                                                                                                                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                                                                                                                                        <p class="text-sm text-red-700 dark:text-red-300">${data || 'Terjadi kesalahan saat memproses permintaan Anda.'}</p>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            `;
                }

                modal.classList.remove('hidden');
            }

            function closeResponseModal() {
                const modal = document.getElementById('response-modal');
                modal.classList.add('hidden');
                if (modal.dataset.reload === 'true') {
                    location.reload();
                }
            }

            // Override native alert to use our response modal to avoid duplicate native alerts
            try {
                window.alert = function (message) {
                    // Close any existing response modal first
                    const existing = document.getElementById('response-modal');
                    if (existing) existing.classList.add('hidden');
                    try {
                        showResponseModal(false, message);
                    } catch (e) {
                        // fallback to console if modal not ready
                        console.log('Alert:', message);
                    }
                };
            } catch (e) {
                // ignore if unable to override
            }

            // Handle manual input modal
            function showManualInputModal() {
                document.getElementById('manual-input-modal').classList.remove('hidden');
            }

            function hideManualInputModal() {
                document.getElementById('manual-input-modal').classList.add('hidden');
                document.getElementById('qr-code-input').value = '';
            }

            // Submit manual QR code
            async function submitManualQR(event) {
                event.preventDefault();
                const input = document.getElementById('qr-code-input');
                const qrCode = input.value.trim();

                if (!qrCode) {
                    showResponseModal(false, 'Input Kosong', 'Masukkan kode QR terlebih dahulu.');
                    return;
                }

                await submitScan(qrCode);
            }

            // Event Listeners
            document.addEventListener('DOMContentLoaded', function () {
                // Start scanner button
                document.getElementById('start-scanner').addEventListener('click', startScanner);

                // Stop scanner button
                document.getElementById('stop-scanner').addEventListener('click', stopScanner);

                // Manual input modal
                document.getElementById('manual-input-btn').addEventListener('click', showManualInputModal);
                document.getElementById('cancel-manual-input').addEventListener('click', hideManualInputModal);
                document.getElementById('manual-input-form').addEventListener('submit', submitManualQR);

                // Close modal on escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        hideManualInputModal();
                    }
                });

                // Close modal on escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        closeResponseModal();
                    }
                });
            });

            // Cleanup on page unload
            window.addEventListener('beforeunload', function () {
                stopScanner();
            });
        </script>
    @endif
@endpush