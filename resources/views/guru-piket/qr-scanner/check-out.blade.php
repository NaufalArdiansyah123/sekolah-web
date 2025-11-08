@extends('layouts.guru-piket')

@section('title', 'QR Scanner - Absensi Pulang')

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

        .mode-indicator {
            background: #dc3545;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            width: fit-content;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
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
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            box-shadow: 0 2px 4px rgba(220, 53, 69, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(220, 53, 69, 0.4);
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
                <h2 class="scanner-title">QR Scanner Absensi Pulang</h2>

                <!-- Mode Indicator -->
                <div class="mode-indicator">
                    <i class="fas fa-sign-out-alt"></i>
                    Mode Absensi Pulang
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
                    <span id="instruction-text">Arahkan kamera ke QR code guru untuk memindai absensi pulang. Pastikan QR
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
                <h4 class="manual-title">Input Manual Absensi Pulang</h4>

                <div class="form-group">
                    <label class="form-label" for="manual-teacher">Pilih Guru</label>
                    <select id="manual-teacher" class="select">
                        <option value="">Memuat data guru...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="manual-notes">Catatan (Opsional)</label>
                    <textarea id="manual-notes" class="textarea" rows="3"
                        placeholder="Contoh: Guru tidak membawa QR code, pulang lebih awal, dll."></textarea>
                </div>

                <div class="manual-controls">
                    <button id="btn-manual-load" class="btn btn-secondary">
                        <i class="fas fa-sync"></i>
                        Muat Ulang Data
                    </button>
                    <button id="btn-manual-submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        <span id="manual-submit-text">Simpan Absensi Pulang</span>
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

        // State variables
        let html5QrCode = null;
        let currentCameraId = null;
        let camerasLoaded = false;
        // Toast notification system
        let lastTime = 0;
        let lastText = '';
        let isScanning = false;
        let currentMode = 'check-out'; // Fixed to check-out mode
        function showToast(message, type = 'info') {
            const modal = document.getElementById('notification-modal');
            const modalTitle = document.getElementById('modal-title');
            const modalIcon = document.getElementById('modal-icon');
            const modalMessage = document.getElementById('modal-message');
            const modalOkBtn = document.getElementById('modal-ok-btn');

            // Set modal content based on type
            modalTitle.textContent = 'Notifikasi';
            modalMessage.textContent = message;

            // Reset modal classes
            modal.className = 'modal';

            // Set icon and color based on type
            let iconClass = 'fas fa-info-circle';
            switch (type) {
                case 'success':
                    modal.classList.add('modal-success');
                    iconClass = 'fas fa-check-circle';
                    break;
                case 'error':
                    modal.classList.add('modal-error');
                    iconClass = 'fas fa-exclamation-triangle';
                    break;
                case 'warning':
                    modal.classList.add('modal-warning');
                    iconClass = 'fas fa-exclamation-circle';
                    break;
                case 'info':
                default:
                    modal.classList.add('modal-info');
                    iconClass = 'fas fa-info-circle';
                    break;
            }

            modalIcon.innerHTML = `<i class="${iconClass}"></i>`;

            // Show modal
            modal.style.display = 'block';

            // Focus on OK button
            modalOkBtn.focus();

            // Close modal when clicking OK or close button
            const closeModal = () => {
                modal.style.display = 'none';
            };

            modalOkBtn.onclick = closeModal;
            document.querySelector('.modal-close').onclick = closeModal;

            // Close modal when clicking outside
            window.onclick = function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            };

            // Close modal on Escape key
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    closeModal();
                }
            });
        }

        // Load available cameras
        async function loadCameras() {
            try {
                cameraSelect.innerHTML = '<option value="">Memuat kamera...</option>';

                // Check if camera access is supported
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    cameraSelect.innerHTML = '<option value="">Kamera tidak didukung browser ini</option>';
                    showToast('Browser ini tidak mendukung akses kamera');
                    return;
                }

                const devices = await Html5Qrcode.getCameras();

                if (devices.length === 0) {
                    cameraSelect.innerHTML = '<option value="">Tidak ada kamera ditemukan</option>';
                    showToast('Tidak ada kamera yang tersedia');
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
                showToast('Akses kamera ditolak. Pastikan memberikan izin kamera.');
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
                showToast('Gagal memulai scanner: ' + error.message);
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
                showToast(`Format QR Code tidak valid. Ditemukan: "${decodedText}". Pastikan menggunakan QR Code guru yang benar.`);
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

            // Check if browser supports camera
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showToast('Browser ini tidak mendukung akses kamera. Gunakan browser modern seperti Chrome, Firefox, atau Edge.');
            }
        }

        // Handle scan errors
        function onScanError(errorMessage) {
            console.warn('QR Scan error:', errorMessage);
        }

        // Process scan data
        async function processScan(qrCode) {
            try {
                const endpoint = '/guru-piket/qr-scanner/scan-check-out';
                const modeText = 'pulang';

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
                    showToast(`Absensi ${modeText} berhasil`);

                    // Refresh attendance list
                    loadTodayAttendance();

                } else {
                    scanResult.textContent = `Gagal: ${data.message}`;
                    scanResult.className = 'status-message status-error';
                    showToast(`Absensi ${modeText} gagal: ` + data.message);
                }

            } catch (error) {
                console.error('Error processing scan:', error);
                scanResult.textContent = 'Error: ' + error.message;
                scanResult.className = 'status-message status-error';
                showToast('Terjadi kesalahan');
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

                const mode = 'check-out';
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

            if (!teacherId) {
                showToast('Pilih guru terlebih dahulu');
                return;
            }

            try {
                const endpoint = '/guru-piket/qr-scanner/manual-check-out';
                const modeText = 'pulang';

                const requestData = {
                    teacher_id: teacherId,
                    notes: notes
                };

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
                    showToast(`Absensi manual ${modeText} berhasil`);

                    // Reset form
                    manualTeacher.value = '';
                    manualNotes.value = '';

                    // Refresh data
                    loadTodayAttendance();
                    loadTeachers();

                } else {
                    showToast(`Absensi manual ${modeText} gagal: ` + data.message);
                }

            } catch (error) {
                console.error('Error submitting manual entry:', error);
                showToast('Terjadi kesalahan');
            }
        }

        // Event listeners
        btnStartScan.addEventListener('click', startScanner);
        btnStopScan.addEventListener('click', stopScanner);
        cameraSelect.addEventListener('change', function () {
            currentCameraId = this.value;
        });

        // Manual entry
        btnManualLoad.addEventListener('click', loadTeachers);
        btnManualSubmit.addEventListener('click', submitManualEntry);

        // Initialize
        initializePage();
    });
</script>