@extends('layouts.teacher')

@section('title', 'QR Scanner')

@push('meta')
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="user-id" content="{{ auth()->id() }}">
@endpush

@section('content')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 rounded-lg bg-gradient-to-r from-emerald-500 to-teal-600 text-white shadow">
                        <i class="fas fa-qrcode"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">QR Scanner Absensi</h1>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">Scan QR siswa untuk mencatat kehadiran</p>
                    </div>
                </div>
                <span id="camera-status"
                    class="inline-flex items-center gap-1 text-xs px-2.5 py-1 ronded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                    Kamera idle
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Scanner Card -->
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="p-5">
                    <div id="scanner-placeholder"
                        class="mx-auto max-w-md bg-gray-50 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center">
                        <i class="fas fa-camera text-5xl text-gray-400 dark:text-gray-500 mb-2"></i>
                        <p class="text-gray-600 dark:text-gray-400">Tekan "Mulai" untuk mengaktifkan kamera</p>
                    </div>
                    <div id="qr-reader" class="hidden"></div>

                    <!-- Controls -->
                    <div class="flex flex-wrap items-center justify-center gap-3 mt-6">
                        <button id="start-scanner" type="button"
                            class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-lg text-sm shadow">
                            <i class="fas fa-play mr-2"></i>Mulai
                        </button>
                        <button id="stop-scanner" type="button"
                            class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg text-sm shadow hidden">
                            <i class="fas fa-stop mr-2"></i>Stop
                        </button>
                        <button id="toggle-manual" type="button"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm shadow">
                            <i class="fas fa-keyboard mr-2"></i>Input Manual
                        </button>
                    </div>

                    <!-- Manual Input -->
                    <div id="manual-wrap" class="mt-4 hidden">
                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <div class="flex gap-2">
                                <input id="manual-qr" type="text"
                                    class="flex-1 px-3 py-2 rounded-md border border-blue-300 dark:border-blue-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan kode QR (NIS atau token)">
                                <button id="manual-submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm">
                                    Kirim
                                </button>
                            </div>
                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-2">Gunakan input manual jika izin kamera
                                ditolak atau kamera bermasalah.</p>
                        </div>
                    </div>
                    <div class="mt-5 text-center text-xs text-gray-500 dark:text-gray-400">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700">
                            <i class="fas fa-lightbulb text-amber-500"></i>
                            Tips: Pastikan pencahayaan cukup, jarak kamera 15–25cm dari QR, dan QR code terlihat jelas.
                        </span>
                    </div>
                </div>
            </div>

            <!-- Side info -->
            <div class="space-y-4">
                <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 text-sm">Ringkasan</h3>
                    <div class="grid grid-cols-3 gap-2 text-center">
                        <div class="p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20">
                            <div id="stat-success" class="text-lg font-bold text-emerald-600">0</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Berhasil</div>
                        </div>
                        <div class="p-3 rounded-lg bg-yellow-50 dark:bg-yellow-900/20">
                            <div id="stat-manual" class="text-lg font-bold text-yellow-600">0</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Manual</div>
                        </div>
                        <div class="p-3 rounded-lg bg-red-50 dark:bg-red-900/20">
                            <div id="stat-error" class="text-lg font-bold text-red-600">0</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">Gagal</div>
                        </div>
                    </div>
                </div>

                <div id="last-result"
                    class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 hidden">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 text-sm">Hasil terakhir</h3>
                    <div id="result-box" class="text-gray-900 dark:text-white text-sm"></div>
                </div>

                <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 text-sm">Tautan Cepat</h3>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('teacher.attendance.index') }}"
                            class="px-3 py-1.5 rounded-md text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 hover:bg-gray-200 dark:hover:bg-gray-600">Kelola
                            Absensi</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Notifikasi Scan -->
        <div id="scan-modal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4">
            <div
                class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-sm w-full border border-gray-200 dark:border-gray-700 overflow-hidden">
                <!-- Header -->
                <div id="modal-header" class="px-6 py-4 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
                    <h2 id="modal-title" class="text-lg font-bold">Scan Berhasil</h2>
                </div>
                <!-- Body -->
                <div class="px-6 py-4">
                    <div id="modal-content" class="text-sm text-gray-900 dark:text-white space-y-2"></div>
                </div>
                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                    <button onclick="closeScanModal()"
                        class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors font-medium">
                        Tutup
                    </button>
                    <button id="modal-action-btn" onclick="closeScanModal()"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors font-medium hidden">
                        Lanjut Scan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>
    <script>
        let scannerInstance = null;
        let isRunning = false;
        let scannedQRCodes = []; // Track scanned QR codes untuk deteksi duplikasi

        // Get current user ID dari meta tag
        function getCurrentUserId() {
            const userMeta = document.querySelector('meta[name="user-id"]');
            return userMeta ? userMeta.getAttribute('content') : 'unknown';
        }

        // Load session data dari server
        async function loadSessionData() {
            try {
                console.log('📥 Loading session data from server...');
                const response = await fetch('/teacher/attendance/session/data');
                const data = await response.json();

                console.log('📦 Received data:', data);

                scannedQRCodes = data.qrCodes || [];

                // Restore counters
                if (data.stats) {
                    document.getElementById('stat-success').textContent = data.stats.success || '0';
                    document.getElementById('stat-manual').textContent = data.stats.manual || '0';
                    document.getElementById('stat-error').textContent = data.stats.error || '0';
                    console.log('✅ Counters restored:', data.stats);
                }

                // Restore last result
                if (data.lastResult) {
                    document.getElementById('last-result').classList.remove('hidden');
                    document.getElementById('result-box').innerHTML = data.lastResult;
                    console.log('✅ Last result restored');
                } else {
                    document.getElementById('last-result').classList.add('hidden');
                    document.getElementById('result-box').innerHTML = '';
                }
            } catch (e) {
                console.error('❌ Failed to load session data:', e);
            }
        }

        // Save session data ke server
        async function saveSessionData() {
            try {
                const data = {
                    qrCodes: scannedQRCodes,
                    stats: {
                        success: parseInt(document.getElementById('stat-success').textContent || '0', 10),
                        manual: parseInt(document.getElementById('stat-manual').textContent || '0', 10),
                        error: parseInt(document.getElementById('stat-error').textContent || '0', 10)
                    },
                    lastResult: document.getElementById('result-box').innerHTML
                };

                console.log('💾 Saving session data:', data);

                const response = await fetch('/teacher/attendance/session/update', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();
                console.log('✅ Session data saved:', result);
            } catch (e) {
                console.error('❌ Failed to save session data:', e);
            }
        }

        // Clear session data
        async function clearSessionData() {
            try {
                await fetch('/teacher/attendance/session/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                });

                scannedQRCodes = [];
                document.getElementById('stat-success').textContent = '0';
                document.getElementById('stat-manual').textContent = '0';
                document.getElementById('stat-error').textContent = '0';
                document.getElementById('last-result').classList.add('hidden');
                document.getElementById('result-box').innerHTML = '';
                document.getElementById('manual-qr').value = '';
            } catch (e) {
                console.warn('Failed to clear session data:', e);
            }
        }

        // Load data saat halaman dimuat
        window.addEventListener('DOMContentLoaded', function () {
            loadSessionData();
        });

        // Reload data setiap 5 detik untuk deteksi perubahan user
        setInterval(loadSessionData, 5000);

        // Juga check saat tab menjadi visible (user switch tab)
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                console.log('Tab became visible, reloading session data...');
                loadSessionData();
            }
        });

        // Check saat window focus kembali
        window.addEventListener('focus', function () {
            console.log('Window focused, reloading session data...');
            loadSessionData();
        });

        function setCameraStatus(state) {
            const el = document.getElementById('camera-status');
            if (!el) return;
            const dot = el.querySelector('span');
            if (!dot) return;
            // reset
            dot.className = 'w-1.5 h-1.5 rounded-full';
            el.className = 'inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-200';

            if (state === 'active') {
                dot.classList.add('bg-emerald-500');
                el.childNodes[1].nodeValue = ' Kamera aktif';
                el.classList.add('bg-emerald-50', 'text-emerald-700');
            } else if (state === 'request') {
                dot.classList.add('bg-amber-500');
                el.childNodes[1].nodeValue = ' Meminta izin kamera...';
                el.classList.add('bg-amber-50', 'text-amber-700');
            } else if (state === 'error') {
                dot.classList.add('bg-red-500');
                el.childNodes[1].nodeValue = ' Kamera gagal';
                el.classList.add('bg-red-50', 'text-red-700');
            } else {
                dot.classList.add('bg-gray-400');
                el.childNodes[1].nodeValue = ' Kamera idle';
            }
        }

        function inc(id) {
            const el = document.getElementById(id);
            if (!el) return;
            const v = parseInt(el.textContent || '0', 10) || 0;
            el.textContent = String(v + 1);
        }
        function incrementSuccess() { inc('stat-success'); saveSessionData(); }
        function incrementManual() { inc('stat-manual'); saveSessionData(); }
        function incrementError() { inc('stat-error'); saveSessionData(); }

        function setButtons(state) {
            const startBtn = document.getElementById('start-scanner');
            const stopBtn = document.getElementById('stop-scanner');
            if (state === 'start') {
                startBtn.classList.add('hidden');
                stopBtn.classList.remove('hidden');
            } else {
                stopBtn.classList.add('hidden');
                startBtn.classList.remove('hidden');
            }
        }

        function showScanModal(title, content, isSuccess, showActionBtn = false) {
            const modal = document.getElementById('scan-modal');
            const header = document.getElementById('modal-header');
            const titleEl = document.getElementById('modal-title');
            const contentEl = document.getElementById('modal-content');
            const actionBtn = document.getElementById('modal-action-btn');

            // Set header color
            header.className = 'px-6 py-4 text-white';
            if (isSuccess) {
                header.classList.add('bg-gradient-to-r', 'from-emerald-500', 'to-teal-600');
            } else {
                header.classList.add('bg-gradient-to-r', 'from-red-500', 'to-rose-600');
            }

            titleEl.textContent = title;
            contentEl.innerHTML = content;

            if (showActionBtn) {
                actionBtn.classList.remove('hidden');
            } else {
                actionBtn.classList.add('hidden');
            }

            modal.classList.remove('hidden');
        }

        function closeScanModal() {
            const modal = document.getElementById('scan-modal');
            modal.classList.add('hidden');
        }

        async function startScanner() {
            if (isRunning) return;
            const containerId = 'qr-reader';
            const placeholderId = 'scanner-placeholder';

            // Sembunyikan placeholder, tampilkan scanner
            document.getElementById(placeholderId).classList.add('hidden');
            document.getElementById(containerId).classList.remove('hidden');
            document.getElementById(containerId).innerHTML = '<div class="py-8 text-center text-emerald-600"><span class="animate-spin inline-block w-8 h-8 border-2 border-emerald-600 border-t-transparent rounded-full"></span><p class="mt-3">Mengaktifkan kamera...</p></div>';
            setCameraStatus('request');

            try {
                const config = {
                    fps: 30,
                    qrbox: { width: 400, height: 400 },
                    rememberLastUsedCamera: true,
                    videoConstraints: {
                        facingMode: 'environment',
                        width: { ideal: 1920, min: 1280 },
                        height: { ideal: 1080, min: 720 },
                        frameRate: { ideal: 30, min: 15 }
                    },
                    supportedScanTypes: ["qr_code"],
                    experimentalFeatures: {
                        useBarCodeDetectorIfSupported: true
                    },
                    aspectRatio: 1.0,
                    showTorchButtonIfSupported: true,
                    showZoomSliderIfSupported: true,
                    defaultZoomValueIfSupported: 2
                };
                scannerInstance = new Html5QrcodeScanner(containerId, config, false);
                scannerInstance.render(onScanSuccess, onScanFailure);
                setCameraStatus('active');
                isRunning = true;
                setButtons('start');
            } catch (e) {
                document.getElementById(containerId).innerHTML = '<div class="py-8 text-center text-red-600">Tidak dapat mengaktifkan kamera</div>';
                setCameraStatus('error');
                isRunning = false;
                setButtons('stop');
            }
        }

        function stopScanner() {
            try {
                if (scannerInstance) {
                    scannerInstance.clear().catch(() => { });
                    scannerInstance = null;
                }
            } catch (_) { }
            isRunning = false;

            // Sembunyikan scanner, tampilkan placeholder
            document.getElementById('qr-reader').classList.add('hidden');
            document.getElementById('scanner-placeholder').classList.remove('hidden');

            setCameraStatus('idle');
            setButtons('stop');
        }

        function onScanSuccess(decodedText) {
            stopScanner();
            submitAttendance(decodedText, false);
        }

        function onScanFailure(_) {
            // ignore continuous scan errors
        }

        // Fungsi untuk deteksi perubahan user
        function checkUserChange() {
            // Fungsi ini dipanggil sebelum submit untuk memastikan user masih sama
            // Data akan di-reload dari server setiap 5 detik, jadi tidak perlu logika khusus di sini
            console.log('Checking user change...');
        }

        async function submitAttendance(qrCode, isManual = false) {
            // Check user change sebelum submit
            checkUserChange();

            const resultBox = document.getElementById('result-box');
            const lastWrap = document.getElementById('last-result');
            lastWrap.classList.remove('hidden');
            resultBox.innerHTML = '<div class="text-emerald-700 dark:text-emerald-400">Memproses...</div>';

            // Cek duplikasi QR code
            if (scannedQRCodes.includes(qrCode)) {
                showScanModal(
                    '⚠️ QR Code Duplikasi',
                    `<div class="space-y-2">
                                                    <p>QR code ini sudah pernah ${isManual ? 'di-input manual' : 'di-scan'} dalam sesi ini.</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">Setiap siswa hanya bisa absen sekali per hari.</p>
                                                    </div>`,
                    false,
                    true
                );
                resultBox.innerHTML = ``;
                incrementError();
                return;
            }

            try {
                const resp = await fetch('{{ route('teacher.attendance.scan-qr') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ qr_code: qrCode, location: 'Teacher QR Scanner' })
                });

                if (!resp.ok) throw new Error('HTTP ' + resp.status);
                const data = await resp.json();

                if (data.success) {
                    // Tambah ke list scanned QR codes
                    scannedQRCodes.push(qrCode);

                    resultBox.innerHTML = `
                                                        <div class="text-sm">
                                                            <div class="font-semibold text-emerald-700 dark:text-emerald-400">Berhasil</div>
                                                            <div class="mt-1">${data.attendance.student_name} — NIS: ${data.attendance.nis}</div>
                                                            <div class="mt-1">Kelas: ${data.attendance.class} • Status: <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 text-xs">${data.attendance.status}</span></div>
                                                            <div class="mt-1 text-gray-600 dark:text-gray-400">${data.attendance.attendance_date} ${data.attendance.scan_time}</div>
                                                        </div>
                                                    `;
                    saveSessionData();

                    showScanModal(
                        '✓ Scan Berhasil',
                        `<div class="space-y-2">
                                                            <p class="font-semibold">${data.attendance.student_name}</p>
                                                            <p class="text-xs">NIS: ${data.attendance.nis}</p>
                                                            <p class="text-xs">Kelas: ${data.attendance.class}</p>
                                                            <p class="text-xs">Status: <span class="px-2 py-0.5 rounded bg-emerald-100 text-emerald-800">${data.attendance.status}</span></p>
                                                        </div>`,
                        true,
                        true
                    );
                    incrementSuccess();
                } else {
                    resultBox.innerHTML = `<div class="text-red-600">${data.message || 'Gagal memproses absensi'}</div>`;

                    showScanModal(
                        '✗ Scan Gagal',
                        `<div class="space-y-2">
                                                            <p>${data.message || 'Gagal memproses absensi'}</p>
                                                        </div>`,
                        false,
                        true
                    );
                    incrementError();
                }
            } catch (e) {
                resultBox.innerHTML = `<div class="text-red-600">Terjadi kesalahan: ${e.message}</div>`;

                showScanModal(
                    '✗ Terjadi Kesalahan',
                    `<div class="space-y-2">
                                                        <p>${e.message}</p>
                                                        <p class="text-xs text-gray-600 dark:text-gray-400">Silakan coba lagi.</p>
                                                    </div>`,
                    false,
                    true
                );
                incrementError();
            }
        }

        function toggleManual() {
            const wrap = document.getElementById('manual-wrap');
            wrap.classList.toggle('hidden');
        }

        async function submitManual() {
            // Check user change sebelum submit manual
            checkUserChange();

            const val = document.getElementById('manual-qr').value.trim();
            if (!val) return;
            incrementManual();
            submitAttendance(val, true);
        }

        // bindings

        document.getElementById('start-scanner').addEventListener('click', startScanner);

        document.getElementById('stop-scanner').addEventListener('click', stopScanner);

        document.getElementById('toggle-manual').addEventListener('click', toggleManual);

        document.getElementById('manual-submit').addEventListener('click', submitManual);
    </script>
@endpush