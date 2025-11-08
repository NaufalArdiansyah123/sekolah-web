@extends('layouts.student')

@section('title', 'PKL QR Scanner - Pulang')

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
                            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">PKL QR Scanner - Pulang</h1>
                            <p class="text-gray-600 dark:text-gray-400">Scan QR Code untuk mencatat waktu pulang PKL Anda</p>
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
                        <!-- Warning Alert -->
                        <div
                            class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0">
                                    <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 text-xl"></i>
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-semibold text-yellow-800 dark:text-yellow-200 mb-1">
                                        Perhatian!
                                    </h4>
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                        Pastikan Anda sudah mengisi <strong>Log Aktivitas</strong> hari ini sebelum melakukan
                                        absen pulang.
                                        <a href="{{ route('student.qr-scanner.log-activity') }}"
                                            class="underline font-medium hover:text-yellow-900 dark:hover:text-yellow-100">
                                            Isi Log Aktivitas →
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl overflow-hidden">
                            <!-- Scanner Container -->
                            <div class="relative">
                                <!-- Placeholder -->
                                <div id="scanner-placeholder" class="p-12 text-center bg-gray-50 dark:bg-gray-900">
                                    <div
                                        class="w-24 h-24 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <i class="fas fa-qrcode text-4xl text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Siap untuk Scan Pulang</h3>
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
                                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                                        <i class="fas fa-play"></i>
                                        <span>Mulai Scan</span>
                                    </button>
                                    <button id="stop-scanner"
                                        class="hidden flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl">
                                        <i class="fas fa-stop"></i>
                                        <span>Stop</span>
                                    </button>
                                    <button id="manual-input-btn"
                                        class="flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-xl transition shadow-lg hover:shadow-xl">
                                        <i class="fas fa-keyboard"></i>
                                        <span>Input Manual</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Manual Input Modal -->
                    <div id="manual-input-modal"
                        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Input Manual QR Code</h2>
                            <form id="manual-input-form">
                                <div class="mb-4">
                                    <label for="qr-code-input"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">QR Code</label>
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

                    <!-- Result Modal -->
                    <div id="result-modal"
                        class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 w-full max-w-md">
                            <div class="text-center">
                                <!-- Icon Container -->
                                <div id="result-icon-container"
                                    class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i id="result-icon" class="text-4xl"></i>
                                </div>
                                <!-- Title -->
                                <h2 id="result-title" class="text-2xl font-bold mb-2"></h2>
                                <!-- Message -->
                                <p id="result-message" class="text-gray-600 dark:text-gray-400 mb-6"></p>
                                <!-- Additional Info (optional) -->
                                <div id="result-info" class="hidden bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 mb-6">
                                    <p class="text-sm text-blue-800 dark:text-blue-200"></p>
                                </div>
                                <!-- Action Button -->
                                <button id="result-close-btn" class="w-full px-6 py-3 rounded-lg font-medium transition">
                                    Tutup
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Sidebar -->
                    <div class="space-y-4">
                        <!-- Instructions -->
                        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-6">
                            <h3 class="font-bold text-gray-900 dark:text-white mb-4">Petunjuk Scan Pulang</h3>
                            <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3 mb-3">
                                    <p class="text-red-700 dark:text-red-300 font-semibold">
                                        <i class="fas fa-exclamation-circle mr-2"></i>Wajib Diisi!
                                    </p>
                                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">
                                        Log aktivitas harus diisi sebelum absen pulang.
                                    </p>
                                </div>
                                <p><i class="fas fa-clipboard-check mr-2 text-green-600"></i>Isi log aktivitas hari ini terlebih
                                    dahulu.</p>
                                <p><i class="fas fa-camera mr-2"></i>Pastikan kamera Anda berfungsi dengan baik.</p>
                                <p><i class="fas fa-qrcode mr-2"></i>Posisikan QR code di dalam area scan.</p>
                                <p><i class="fas fa-clock mr-2"></i>Scan akan mencatat waktu pulang Anda secara otomatis.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrReader = new Html5Qrcode("qr-reader");
            const startScannerBtn = document.getElementById('start-scanner');
            const stopScannerBtn = document.getElementById('stop-scanner');
            const scannerPlaceholder = document.getElementById('scanner-placeholder');
            const qrReaderContainer = document.getElementById('qr-reader');

            const onScanSuccess = (decodedText, decodedResult) => {
                // handle the scanned code as you like, for example:
                console.log(`Code matched = ${decodedText}`, decodedResult);
                stopScanner();
                sendQrCode(decodedText);
            };

            const onScanFailure = (error) => {
                // handle scan failure, usually better to ignore and keep scanning.
                // for example:
                // console.warn(`Code scan error = ${error}`);
            };

            let scannerInstance = null;

            async function startScanner() {
                scannerPlaceholder.classList.add('hidden');
                qrReaderContainer.classList.remove('hidden');
                startScannerBtn.classList.add('hidden');
                stopScannerBtn.classList.remove('hidden');
                stopScannerBtn.classList.add('flex');

                try {
                    scannerInstance = await qrReader.start(
                        { facingMode: "environment" },
                        { fps: 10, qrbox: { width: 250, height: 250 } },
                        onScanSuccess,
                        onScanFailure
                    );
                } catch (err) {
                    console.error("Unable to start scanning", err);
                    showResultModal(
                        'error',
                        'Gagal Membuka Kamera',
                        'Tidak dapat memulai kamera. Pastikan Anda telah memberikan izin akses kamera.'
                    );
                    resetScannerUI();
                }
            }

            async function stopScanner() {
                try {
                    // Stop the scanner
                    await qrReader.stop();
                    await qrReader.clear();

                    // Get all video elements and stop their streams
                    const videoElements = document.querySelectorAll('video');
                    videoElements.forEach(video => {
                        const stream = video.srcObject;
                        if (stream) {
                            // Stop all tracks in the stream
                            stream.getTracks().forEach(track => {
                                track.stop();
                            });
                            video.srcObject = null;
                        }
                    });

                    scannerInstance = null;
                    resetScannerUI();
                } catch (err) {
                    console.error("Unable to stop scanning", err);
                    resetScannerUI();
                }
            }

            function resetScannerUI() {
                scannerPlaceholder.classList.remove('hidden');
                qrReaderContainer.classList.add('hidden');
                startScannerBtn.classList.remove('hidden');
                stopScannerBtn.classList.add('hidden');
                stopScannerBtn.classList.remove('flex');
            }

            function showResultModal(type, title, message, additionalInfo = null) {
                const modal = document.getElementById('result-modal');
                const iconContainer = document.getElementById('result-icon-container');
                const icon = document.getElementById('result-icon');
                const titleElement = document.getElementById('result-title');
                const messageElement = document.getElementById('result-message');
                const infoElement = document.getElementById('result-info');
                const closeBtn = document.getElementById('result-close-btn');

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

                if (additionalInfo) {
                    infoElement.classList.remove('hidden');
                    infoElement.querySelector('p').textContent = additionalInfo;
                } else {
                    infoElement.classList.add('hidden');
                }

                modal.classList.remove('hidden');
            }

            function sendQrCode(qrCode) {
                console.log('Sending QR Code:', qrCode);
                console.log('URL:', '{{ route("student.qr-scanner.pulang.store") }}');
                console.log('CSRF Token:', '{{ csrf_token() }}');

                // Show loading
                const loadingOverlay = document.createElement('div');
                loadingOverlay.id = 'loading-overlay';
                loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loadingOverlay.innerHTML = `
                                            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 text-center">
                                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                                                <p class="text-gray-700 dark:text-gray-300">Memproses absensi...</p>
                                            </div>
                                        `;
                document.body.appendChild(loadingOverlay);

                fetch('{{ route("student.qr-scanner.pulang.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        qr_code: qrCode
                    })
                })
                    .then(async response => {
                        console.log('Response status:', response.status);
                        console.log('Response headers:', response.headers);

                        const contentType = response.headers.get('content-type');
                        console.log('Content-Type:', contentType);

                        // Get response text first
                        const text = await response.text();
                        console.log('Response text:', text);

                        // Remove loading overlay
                        const overlay = document.getElementById('loading-overlay');
                        if (overlay) overlay.remove();

                        // Try to parse as JSON
                        let data;
                        try {
                            data = JSON.parse(text);
                        } catch (e) {
                            console.error('JSON Parse Error:', e);
                            console.error('Response was:', text);
                            throw new Error('Server mengembalikan response yang tidak valid. Silakan cek console untuk detail.');
                        }

                        if (!response.ok) {
                            throw { type: 'error', data: data };
                        }
                        return { type: 'success', data: data };
                    })
                    .then(result => {
                        if (result.type === 'success' && result.data.success) {
                            const additionalInfo = result.data.data && result.data.data.check_out_time
                                ? `Waktu Pulang: ${result.data.data.check_out_time}`
                                : null;

                            showResultModal(
                                'success',
                                'Berhasil!',
                                result.data.success,
                                additionalInfo
                            );

                            // Redirect ke riwayat setelah 2 detik
                            setTimeout(() => {
                                window.location.href = '{{ route("student.qr-scanner.history") }}';
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        // Remove loading overlay if still exists
                        const overlay = document.getElementById('loading-overlay');
                        if (overlay) overlay.remove();

                        if (error.type === 'error' && error.data) {
                            // Error dari server
                            const errorMessage = error.data.error || error.data.message || 'Terjadi kesalahan';

                            // Check if there's a redirect URL (for log activity requirement)
                            if (error.data.redirect) {
                                showResultModal(
                                    'warning',
                                    'Log Aktivitas Belum Diisi',
                                    errorMessage
                                );

                                // Redirect to log activity page after showing modal
                                setTimeout(() => {
                                    window.location.href = error.data.redirect;
                                }, 2500);
                            } else {
                                showResultModal(
                                    'error',
                                    'Gagal!',
                                    errorMessage
                                );
                            }
                        } else {
                            // Error lainnya
                            showResultModal(
                                'error',
                                'Terjadi Kesalahan',
                                error.message || 'Terjadi kesalahan saat mengirim data.'
                            );
                        }
                    });
            }

            const manualInputBtn = document.getElementById('manual-input-btn');
            const manualInputModal = document.getElementById('manual-input-modal');
            const cancelManualInputBtn = document.getElementById('cancel-manual-input');
            const manualInputForm = document.getElementById('manual-input-form');
            const resultModal = document.getElementById('result-modal');
            const resultCloseBtn = document.getElementById('result-close-btn');

            manualInputBtn.addEventListener('click', () => {
                manualInputModal.classList.remove('hidden');
            });

            cancelManualInputBtn.addEventListener('click', () => {
                manualInputModal.classList.add('hidden');
            });

            manualInputForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const qrCode = document.getElementById('qr-code-input').value;
                sendQrCode(qrCode);
                manualInputModal.classList.add('hidden');
            });

            resultCloseBtn.addEventListener('click', () => {
                resultModal.classList.add('hidden');
                // Restart scanner for next attempt if still open
                if (!scannerPlaceholder.classList.contains('hidden')) {
                    // Scanner is still running, keep it going
                }
            });

            startScannerBtn.addEventListener('click', startScanner);
            stopScannerBtn.addEventListener('click', stopScanner);
        });
    </script>
@endpush