@extends('layouts.guru-piket')

@section('title', 'QR Scanner - Absensi Guru')

@push('styles')
    <style>
        body {
            background: #f8f9fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .scanner-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .scanner-left {
            flex: 1;
            min-width: 0;
        }

        .scanner-right {
            flex: 1;
            min-width: 0;
        }

        .scanner-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333;
        }

        .mode-toggle {
            display: flex;
            background: #f8f9fa;
            border-radius: 8px;
            padding: 4px;
            margin-bottom: 20px;
            width: fit-content;
        }

        .mode-btn {
            flex: 1;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            background: transparent;
            color: #6c757d;
        }

        .mode-btn.active {
            background: white;
            color: #007bff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .mode-btn.check-in.active {
            color: #28a745;
        }

        .mode-btn.check-out.active {
            color: #dc3545;
        }

        .camera-container {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #reader {
            width: 100%;
            height: 400px;
            background: #f8f9fa;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            overflow: hidden;
            position: relative;
        }

        .controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3, #004085);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #545b62);
            color: white;
            box-shadow: 0 2px 4px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #545b62, #495057);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(108, 117, 125, 0.4);
        }

        .select {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            background: white;
            flex: 1;
            min-width: 200px;
        }

        .results-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            margin-top: 20px;
        }

        .results-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .status-message {
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
        }

        .status-success {
            background: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .status-error {
            background: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        .attendance-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
            border-radius: 4px;
        }

        .attendance-item {
            padding: 18px;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s ease;
        }

        .attendance-item:hover {
            background-color: #f8f9fa;
        }

        .attendance-item:last-child {
            border-bottom: none;
        }

        .attendance-info h4 {
            margin: 0 0 5px 0;
            color: #333;
        }

        .attendance-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .attendance-status {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-present {
            background: #d4edda;
            color: #155724;
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #6c757d;
        }

        .manual-section {
            margin-top: 25px;
            padding-top: 20px;
            border-top: 2px solid #e9ecef;
            border-radius: 8px;
            background: linear-gradient(135deg, #f8f9fa, #ffffff);
        }

        .manual-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        .textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            resize: vertical;
            font-family: inherit;
        }

        .manual-controls {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            .scanner-section {
                flex-direction: column;
                gap: 15px;
            }

            .controls {
                flex-direction: column;
            }

            .manual-controls {
                flex-direction: column;
            }

            .btn {
                justify-content: center;
            }
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 0;
            border: 1px solid #888;
            width: 90%;
            max-width: 500px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
            border-radius: 8px 8px 0 0;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e9ecef;
            border-radius: 0 0 8px 8px;
            text-align: right;
        }

        .modal-title {
            margin: 0;
            font-size: 18px;
            font-weight: 600;
        }

        .modal-close {
            float: right;
            font-size: 28px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
            line-height: 1;
        }

        .modal-close:hover {
            color: #000;
        }

        .btn-modal {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }

        .btn-primary-modal {
            background-color: #007bff;
            color: white;
        }

        .btn-primary-modal:hover {
            background-color: #0056b3;
        }

        .modal-icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .modal-success .modal-icon {
            color: #28a745;
        }

        .modal-error .modal-icon {
            color: #dc3545;
        }

        .modal-warning .modal-icon {
            color: #ffc107;
        }

        .modal-info .modal-icon {
            color: #17a2b8;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <!-- Scanner Section -->
        <div class="scanner-section">
            <div class="scanner-left">
                <h2 class="scanner-title">QR Scanner Absensi Guru</h2>

                <!-- Mode Toggle -->
                <div class="mode-toggle">
                    <button id="mode-check-in" class="mode-btn check-in active">
                        <i class="fas fa-sign-in-alt"></i>
                        Absensi Masuk
                    </button>
                </div>

                <div class="camera-container">
                    <div id="reader">
                        <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 10px;"></i>
                        <div>Kamera belum aktif</div>
                    </div>
                </div>

                <div class="controls" style="position: relative; z-index: 10;">
                    <button id="btn-start-scan" class="btn btn-primary">
                        <i class="fas fa-play"></i>
                        Mulai Scan
                    </button>
                    <button id="btn-stop-scan" class="btn btn-secondary" disabled>
                        <i class="fas fa-stop"></i>
                        Berhenti
                    </button>
                    <select id="camera-select" class="select">
                        <option value="">Memuat kamera...</option>
                    </select>
                </div>
            </div>

            <div class="scanner-right">
                <div class="status-message" id="scan-instruction">
                    <i class="fas fa-info-circle"></i>
                    <span id="instruction-text">Arahkan kamera ke QR code guru untuk memindai absensi masuk. Pastikan QR
                        code terlihat jelas dalam frame.</span>
                </div>

                <div class="status-message" id="scan-result">
                    Belum ada aktivitas pemindaian
                </div>
            </div>
        </div>

        <!-- Results Section -->
        <div class="results-section">
            <h3 class="results-title">Hasil & Riwayat</h3>

            <div class="attendance-list" id="today-attendance">
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 10px;"></i>
                    <p>Belum ada data absensi hari ini</p>
                </div>
            </div>

            <!-- Manual Entry Section -->
            <div class="manual-section">
                <h4 class="manual-title" id="manual-title">Input Manual Absensi Masuk</h4>

                <div class="form-group">
                    <label class="form-label" for="manual-teacher">Pilih Guru</label>
                    <select id="manual-teacher" class="select">
                        <option value="">Memuat data guru...</option>
                    </select>
                </div>

                <div class="form-group" id="status-group">
                    <label class="form-label" for="manual-status">Status Absensi</label>
                    <select id="manual-status" class="select">
                        <option value="hadir">Hadir</option>
                        <option value="terlambat">Terlambat</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="manual-notes">Catatan (Opsional)</label>
                    <textarea id="manual-notes" class="textarea" rows="3"
                        placeholder="Contoh: Guru tidak membawa QR code, sakit, dll."></textarea>
                </div>

                <div class="manual-controls">
                    <button id="btn-manual-load" class="btn btn-secondary">
                        <i class="fas fa-sync"></i>
                        Muat Ulang Data
                    </button>
                    <button id="btn-manual-submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <span id="manual-submit-text">Simpan Absensi Masuk</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for notifications -->
    <div id="notification-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title">Notifikasi</h5>
                <span class="modal-close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="modal-icon" id="modal-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <p id="modal-message">Pesan notifikasi</p>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-modal btn-primary-modal" id="modal-ok-btn">OK</button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
<script>
    // Fallback for older browsers
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        console.warn('Camera access not supported in this browser');
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // DOM Elements
        const btnStartScan = document.getElementById('btn-start-scan');
        const btnStopScan = document.getElementById('btn-stop-scan');
        const cameraSelect = document.getElementById('camera-select');
        const scanResult = document.getElementById('scan-result');
        const todayAttendance = document.getElementById('today-attendance');

        const manualTeacher = document.getElementById('manual-teacher');
        const manualNotes = document.getElementById('manual-notes');
        const btnManualLoad = document.getElementById('btn-manual-load');
        const btnManualSubmit = document.getElementById('btn-manual-submit');

        // Mode toggle elements
        const modeCheckIn = document.getElementById('mode-check-in');

        // Additional elements for mode switching
        const instructionText = document.getElementById('instruction-text');
        const manualTitle = document.getElementById('manual-title');
        const manualSubmitText = document.getElementById('manual-submit-text');



        // State variables
        let html5QrCode = null;
        let currentCameraId = null;
        let camerasLoaded = false;
        // Toast notification system
        let lastTime = 0;
        let lastText = '';
        let isScanning = false;
        let currentMode = 'check-in'; // 'check-in' or 'check-out'

        // Modal notification system
        function showModal(message, type = 'info', title = 'Notifikasi') {
            const modal = document.getElementById('notification-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalIcon = document.getElementById('modal-icon');
            const modalMessage = document.getElementById('modal-message');
            const modalContent = modal.querySelector('.modal-content');

            // Set title
            modalTitle.textContent = title;

            // Set message
            modalMessage.textContent = message;

            // Set icon and modal class based on type
            modalContent.className = 'modal-content'; // Reset classes
            modalContent.classList.add(`modal-${type}`);

            let iconClass = 'fas fa-info-circle';
            switch (type) {
                case 'success':
                    iconClass = 'fas fa-check-circle';
                    break;
                case 'error':
                    iconClass = 'fas fa-exclamation-triangle';
                    break;
                case 'warning':
                    iconClass = 'fas fa-exclamation-circle';
                    break;
            }

            modalIcon.innerHTML = `<i class="${iconClass}"></i>`;

            // Show modal
            modal.style.display = 'block';
        }

        // Close modal functions
        function closeModal() {
            const modal = document.getElementById('notification-modal');
            modal.style.display = 'none';
        }

        // Initialize modal event listeners
        function initializeModal() {
            const modalCloseBtn = document.querySelector('.modal-close');
            const modalOkBtn = document.getElementById('modal-ok-btn');
            const modal = document.getElementById('notification-modal');

            if (modalCloseBtn) {
                modalCloseBtn.addEventListener('click', closeModal);
            }

            if (modalOkBtn) {
                modalOkBtn.addEventListener('click', closeModal);
            }

            // Close modal when clicking outside
            if (modal) {
                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        closeModal();
                    }
                });
            }
        }

        // Load available cameras
        async function loadCameras() {
            try {
                cameraSelect.innerHTML = '<option value="">Memuat kamera...</option>';

                // Check if camera access is supported
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    cameraSelect.innerHTML = '<option value="">Kamera tidak didukung browser ini</option>';
                    showModal('Browser ini tidak mendukung akses kamera. Gunakan browser modern seperti Chrome, Firefox, atau Edge.', 'warning', 'Browser Tidak Didukung');
                    return;
                }

                const devices = await Html5Qrcode.getCameras();

                if (devices.length === 0) {
                    cameraSelect.innerHTML = '<option value="">Tidak ada kamera ditemukan</option>';
                    showModal('Tidak ada kamera yang tersedia. Pastikan kamera terhubung dan memberikan izin akses.', 'warning', 'Kamera Tidak Ditemukan');
                    return;
                }

                cameraSelect.innerHTML = '<option value="">Pilih kamera</option>';

                devices.forEach((device, index) => {
                    const option = document.createElement('option');
                    option.value = device.id;
                    option.textContent = device.label || `Kamera ${index + 1}`;
                    cameraSelect.appendChild(option);
                });

                // Auto-select first camera
                if (devices.length > 0) {
                    currentCameraId = devices[0].id;
                    cameraSelect.value = currentCameraId;
                }

                camerasLoaded = true;

            } catch (error) {
                console.error('Error loading cameras:', error);
                cameraSelect.innerHTML = '<option value="">Error memuat kamera</option>';
                showToast('Gagal memuat kamera: ' + error.message);
            }
        }

        // Start QR scanner
        async function startScanner() {
            if (!camerasLoaded) {
                // Load cameras first if not loaded
                await loadCameras();
            }

            if (!currentCameraId) {
                showToast('Pilih kamera terlebih dahulu');
                return;
            }

            // Check camera permissions
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                stream.getTracks().forEach(track => track.stop()); // Stop the test stream
            } catch (error) {
                console.error('Camera permission denied:', error);
                showModal('Akses kamera ditolak. Pastikan memberikan izin kamera di browser Anda.', 'error', 'Izin Kamera Ditolak');
                return;
            }

            try {
                if (html5QrCode) {
                    await stopScanner();
                }

                html5QrCode = new Html5Qrcode('reader');
                isScanning = true;

                await html5QrCode.start(
                    { deviceId: { exact: currentCameraId } },
                    {
                        fps: 10,
                        qrbox: { width: 300, height: 300 }
                    },
                    onScanSuccess,
                    onScanError
                );

                btnStartScan.disabled = true;
                btnStopScan.disabled = false;

            } catch (error) {
                console.error('Error starting scanner:', error);
                isScanning = false;
                showModal('Gagal memulai scanner: ' + error.message, 'error', 'Error Scanner');
            }
        }

        // Stop QR scanner
        async function stopScanner() {
            try {
                if (html5QrCode) {
                    await html5QrCode.stop();
                    await html5QrCode.clear();
                    html5QrCode = null;
                }

                isScanning = false;
                btnStartScan.disabled = false;
                btnStopScan.disabled = true;

            } catch (error) {
                console.error('Error stopping scanner:', error);
            }
        }

        // Handle successful scan
        function onScanSuccess(decodedText, decodedResult) {
            const now = Date.now();

            // Debug: Log what was scanned
            console.log('QR Code scanned:', decodedText);
            console.log('QR Code length:', decodedText.length);
            console.log('Starts with QR_TEACHER_:', decodedText.startsWith('QR_TEACHER_'));

            // Prevent duplicate scans within 3 seconds
            if (decodedText === lastText && now - lastTime < 3000) {
                return;
            }

            lastText = decodedText;
            lastTime = now;

            // Validate QR code format before sending to server
            // Check if it's JSON format (new format) or old QR_TEACHER_ format
            let isValidFormat = false;
            let qrCodeToSend = decodedText;

            try {
                const parsedData = JSON.parse(decodedText);
                if (parsedData.type === 'teacher' && parsedData.id && parsedData.name) {
                    isValidFormat = true;
                    // Convert to expected format for backend
                    qrCodeToSend = `QR_TEACHER_${parsedData.id}_${Date.now()}_${Math.random().toString(36).substr(2, 9)}`;
                }
            } catch (e) {
                // Not JSON, check if it's old format
                if (decodedText.startsWith('QR_TEACHER_')) {
                    isValidFormat = true;
                }
            }

            if (!isValidFormat) {
                scanResult.textContent = `Format QR Code tidak valid. Ditemukan: "${decodedText}". QR Code harus berupa JSON dengan type "teacher" atau dimulai dengan "QR_TEACHER_".`;
                scanResult.className = 'status-message status-error';
                showModal(`Format QR Code tidak valid. Pastikan menggunakan QR Code guru yang benar.`, 'error', 'Format QR Code Tidak Valid');
                console.error('Invalid QR format detected:', decodedText);
                return;
            }

            scanResult.textContent = `QR Code terdeteksi: ${decodedText}`;
            scanResult.className = 'status-message';

            // Send scan data to server
            processScan(decodedText);
        }

        // Initialize on page load - do not start camera automatically
        function initializePage() {
            cameraSelect.innerHTML = '<option value="">Klik Mulai Scan untuk memuat kamera</option>';
            loadTodayAttendance();
            loadTeachers();
            // Set initial mode display - show status dropdown for check-in mode
            switchMode('check-in');

            // Check if browser supports camera
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showModal('Browser ini tidak mendukung akses kamera. Gunakan browser modern seperti Chrome, Firefox, atau Edge.', 'warning', 'Browser Tidak Didukung');
            }
        }

        // Handle scan errors
        function onScanError(errorMessage) {
            console.warn('QR Scan error:', errorMessage);
        }

        // Process scan data
        async function processScan(qrCode) {
            try {
                const endpoint = currentMode === 'check-out' ? '/guru-piket/qr-scanner/scan-check-out' : '/guru-piket/qr-scanner/scan';
                const modeText = currentMode === 'check-out' ? 'pulang' : 'masuk';

                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        qr_code: qrCode,
                        location: 'Sekolah'
                    })
                });

                const data = await response.json();

                if (data.success) {
                    scanResult.textContent = `Berhasil absensi ${modeText}: ${data.teacher.name}`;
                    scanResult.className = 'status-message status-success';
                    showModal(`Absensi ${modeText} berhasil untuk ${data.teacher.name}`, 'success', 'Berhasil');

                    // Refresh attendance list
                    loadTodayAttendance();

                } else {
                    scanResult.textContent = `Gagal: ${data.message}`;
                    scanResult.className = 'status-message status-error';
                    showModal(`Absensi ${modeText} gagal: ${data.message}`, 'error', 'Gagal');
                }

            } catch (error) {
                console.error('Error processing scan:', error);
                scanResult.textContent = 'Error: ' + error.message;
                scanResult.className = 'status-message status-error';
                showModal('Terjadi kesalahan saat memproses absensi', 'error', 'Error');
            }
        }

        // Load today's attendance
        async function loadTodayAttendance() {
            try {
                const response = await fetch('/guru-piket/qr-scanner/today-attendance');
                const data = await response.json();

                if (data.success) {
                    updateAttendanceList(data.attendances);
                }
            } catch (error) {
                console.error('Error loading attendance:', error);
            }
        }

        // Update attendance list in UI
        function updateAttendanceList(attendances) {
            const container = document.getElementById('today-attendance');

            if (attendances.length === 0) {
                container.innerHTML = `
                <div class="empty-state">
                    <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 10px;"></i>
                    <p>Belum ada data absensi hari ini</p>
                </div>
            `;
                return;
            }

            container.innerHTML = attendances.map(attendance => {
                const checkInTime = attendance.scan_time;
                const checkOutTime = attendance.check_out_time;
                const hasCheckOut = checkOutTime !== null && checkOutTime !== '';

                return `
                <div class="attendance-item">
                    <div class="attendance-info">
                        <h4>${attendance.teacher_name}</h4>
                        <p>NIP: ${attendance.teacher_nip} • ${attendance.teacher_position} • Masuk: ${checkInTime}${hasCheckOut ? ` • Pulang: ${checkOutTime}` : ''}</p>
                    </div>
                    <div class="attendance-status status-present">
                        ${attendance.status}${hasCheckOut ? ' ✓' : ''}
                    </div>
                </div>
            `;
            }).join('');
        }

        // Load teachers for manual entry
        async function loadTeachers() {
            try {
                manualTeacher.innerHTML = '<option value="">Memuat data guru...</option>';

                const mode = currentMode === 'check-out' ? 'check-out' : 'manual';
                const response = await fetch(`/guru-piket/qr-scanner/teachers?mode=${mode}`);
                const data = await response.json();

                if (data.success) {
                    manualTeacher.innerHTML = '<option value="">Pilih Guru</option>';

                    data.teachers.forEach(teacher => {
                        const option = document.createElement('option');
                        option.value = teacher.id;
                        option.textContent = `${teacher.name} (${teacher.position}) - ${teacher.nip}`;
                        manualTeacher.appendChild(option);
                    });
                } else {
                    manualTeacher.innerHTML = '<option value="">Gagal memuat data</option>';
                }
            } catch (error) {
                console.error('Error loading teachers:', error);
                manualTeacher.innerHTML = '<option value="">Error memuat data</option>';
            }
        }

        // Handle manual entry submission
        async function submitManualEntry() {
            const teacherId = manualTeacher.value;
            const notes = manualNotes.value.trim();
            const status = currentMode === 'check-in' ? document.getElementById('manual-status').value : null;

            if (!teacherId) {
                showModal('Pilih guru terlebih dahulu', 'warning', 'Pilih Guru');
                return;
            }

            try {
                const endpoint = currentMode === 'check-out' ? '/guru-piket/qr-scanner/manual-check-out' : '/guru-piket/qr-scanner/manual-entry';
                const modeText = currentMode === 'check-out' ? 'pulang' : 'masuk';

                const requestData = {
                    teacher_id: teacherId,
                    notes: notes
                };

                // Only add status for check-in mode
                if (currentMode === 'check-in') {
                    requestData.status = status;
                }

                const response = await fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(requestData)
                });

                const data = await response.json();

                if (data.success) {
                    showModal(`Absensi manual ${modeText} berhasil untuk ${data.teacher.name}`, 'success', 'Berhasil');

                    // Reset form
                    manualTeacher.value = '';
                    manualNotes.value = '';
                    if (currentMode === 'check-in') {
                        document.getElementById('manual-status').value = 'hadir'; // Reset to default
                    } else {
                        // For check-out mode, no status to reset
                    }

                    // Refresh data
                    loadTodayAttendance();
                    loadTeachers();

                } else {
                    showModal(`Absensi manual ${modeText} gagal: ${data.message}`, 'error', 'Gagal');
                }

            } catch (error) {
                console.error('Error submitting manual entry:', error);
                showModal('Terjadi kesalahan saat menyimpan absensi manual', 'error', 'Error');
            }
        }

        // Mode toggle functions
        function switchMode(mode) {
            currentMode = mode;

            // Update button states
            modeCheckIn.classList.toggle('active', mode === 'check-in');

            // Update instruction text
            if (mode === 'check-in') {
                instructionText.textContent = 'Arahkan kamera ke QR code guru untuk memindai absensi masuk. Pastikan QR code terlihat jelas dalam frame.';
                manualTitle.textContent = 'Input Manual Absensi Masuk';
                manualSubmitText.textContent = 'Simpan Absensi Masuk';
                // Show status dropdown for check-in
                document.getElementById('status-group').style.display = 'block';
            }

            // Reset scan result
            scanResult.textContent = 'Belum ada aktivitas pemindaian';
            scanResult.className = 'status-message';

            // Reload teachers for current mode
            loadTeachers();
        }

        // Event listeners
        btnStartScan.addEventListener('click', startScanner);
        btnStopScan.addEventListener('click', stopScanner);
        cameraSelect.addEventListener('change', function () {
            currentCameraId = this.value;
        });

        // Mode toggle listeners
        modeCheckIn.addEventListener('click', () => switchMode('check-in'));

        // Manual entry
        btnManualLoad.addEventListener('click', loadTeachers);
        btnManualSubmit.addEventListener('click', submitManualEntry);

        // Initialize
        initializePage();
        initializeModal();
    });
</script>