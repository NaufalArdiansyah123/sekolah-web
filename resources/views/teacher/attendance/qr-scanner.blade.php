@extends('layouts.teacher')

@section('title', 'QR Scanner Absensi Siswa')

@push('meta')
<!-- Cache Busting Meta Tags -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="teacher-id" content="{{ auth()->id() }}">
<meta name="cache-buster" content="{{ time() }}">
@endpush

@section('content')
<div class="container mx-auto px-6 py-8">
    
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <div class="bg-gradient-to-r from-emerald-500 to-blue-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-qrcode text-white text-xl"></i>
                </div>
                QR Scanner Absensi Siswa
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Scan QR Code siswa untuk mencatat absensi</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('teacher.attendance.index') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-list mr-2"></i>Kelola Absensi
            </a>
            <a href="{{ route('teacher.attendance.monthly-report') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-chart-bar mr-2"></i>Laporan
            </a>
        </div>
    </div>

    <!-- Teacher Instructions -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-2xl shadow-xl p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class="fas fa-chalkboard-teacher text-3xl mr-4"></i>
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-bold mb-2">👨‍🏫 Panduan untuk Guru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <h4 class="font-semibold mb-2">📱 Cara Menggunakan Scanner:</h4>
                        <ul class="space-y-1">
                            <li>• Klik "Mulai Scanner" untuk mengaktifkan kamera</li>
                            <li>• Minta siswa menunjukkan QR Code mereka</li>
                            <li>• Arahkan kamera ke QR Code siswa</li>
                            <li>• Absensi otomatis tercatat setelah scan berhasil</li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">⚠️ Penting Diperhatikan:</h4>
                        <ul class="space-y-1">
                            <li>• Pastikan QR Code siswa terlihat jelas</li>
                            <li>• Setiap siswa hanya bisa absen sekali per hari</li>
                            <li>• Sistem akan mendeteksi duplikasi otomatis</li>
                            <li>• Gunakan "Input Manual" jika kamera bermasalah</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- QR Scanner Section -->
        <div class="lg:col-span-3">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-camera mr-3"></i>Scanner QR Code Siswa
                    </h2>
                </div>
                <div class="p-6">
                    <!-- Scanner Container -->
                    <div class="text-center">
                        <div class="mb-6">
                            <div id="qr-reader" class="mx-auto max-w-md bg-gray-50 dark:bg-gray-700 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-2xl p-8 transition-all duration-300">
                                <div class="text-center">
                                    <i class="fas fa-qrcode text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                    <p class="text-gray-600 dark:text-gray-400">Klik "Mulai Scanner" untuk memulai</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Scanner Controls -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-center mb-6">
                            <button type="button" id="start-scanner" 
                                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-play mr-2"></i>Mulai Scanner
                            </button>
                            <button type="button" id="stop-scanner" style="display: none;"
                                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-stop mr-2"></i>Stop Scanner
                            </button>
                            <button type="button" id="manual-input" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-keyboard mr-2"></i>Input Manual
                            </button>
                        </div>
                        
                        <!-- Manual Input Form -->
                        <div id="manual-input-form" class="hidden">
                            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-xl p-6 mb-6">
                                <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4">Input QR Code Manual</h4>
                                <div class="flex gap-3">
                                    <input type="text" id="manual-qr-input" 
                                           class="flex-1 px-4 py-3 border border-blue-300 dark:border-blue-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="Masukkan kode QR siswa atau scan dengan aplikasi lain">
                                    <button onclick="processManualInput()" 
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center">
                                        <i class="fas fa-check mr-2"></i>Submit
                                    </button>
                                </div>
                                <p class="text-sm text-blue-700 dark:text-blue-300 mt-3">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Jika kamera tidak berfungsi, Anda dapat memasukkan kode QR secara manual.
                                </p>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="space-y-4">
                            <!-- Usage Instructions -->
                            <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl p-6">
                                <div class="flex items-start">
                                    <i class="fas fa-lightbulb text-emerald-600 dark:text-emerald-400 text-xl mr-3 mt-1"></i>
                                    <div class="text-left">
                                        <h4 class="font-semibold text-emerald-900 dark:text-emerald-100 mb-2">Petunjuk Penggunaan:</h4>
                                        <ul class="text-sm text-emerald-800 dark:text-emerald-200 space-y-1">
                                            <li>• Klik "Mulai Scanner" untuk mengaktifkan kamera</li>
                                            <li>• Minta siswa menunjukkan QR Code absensi mereka</li>
                                            <li>• Arahkan kamera ke QR Code hingga terdeteksi</li>
                                            <li>• Scanner akan otomatis membaca dan mencatat absensi</li>
                                            <li>• Gunakan "Input Manual" jika kamera bermasalah</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Today's Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Statistik Hari Ini</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $todayStats['hadir'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Hadir</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $todayStats['terlambat'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Terlambat</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ ($todayStats['izin'] ?? 0) + ($todayStats['sakit'] ?? 0) }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Izin/Sakit</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $todayStats['alpha'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Alpha</div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="text-center">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">{{ $todayStats['total_scanned'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Total Siswa Absen</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('teacher.attendance.index') }}" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-list mr-2"></i>Kelola Absensi Manual
                    </a>
                    <a href="{{ route('teacher.attendance.monthly-report') }}" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-chart-bar mr-2"></i>Laporan Bulanan
                    </a>
                    <a href="{{ route('teacher.attendance.export') }}" 
                       class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-download mr-2"></i>Export Data
                    </a>
                    <button onclick="showSubmitToGuruPiketModal()" 
                            class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim ke Guru Piket
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Recent Scans Section - Full Width -->
    <div class="mt-8">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                <h3 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-history mr-3"></i>Scan Terakhir Hari Ini
                </h3>
            </div>
            <div class="p-6">
                <div id="recent-scans" class="space-y-3">
                    <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                        <i class="fas fa-qrcode text-6xl mb-4"></i>
                        <h4 class="text-lg font-semibold mb-2">Belum Ada Scan Hari Ini</h4>
                        <p class="text-sm">Scan QR Code siswa akan muncul di sini secara real-time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Submit to Guru Piket Modal -->
<div id="submitToGuruPiketModal" class="fixed inset-0 z-50 hidden" onclick="closeSubmitModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md p-6 border border-gray-200 dark:border-gray-700" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">Kirim Absensi ke Guru Piket</h2>
                <button onclick="closeSubmitModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <form id="submitToGuruPiketForm" onsubmit="submitToGuruPiket(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Absensi</label>
                        <input type="date" id="submissionDate" name="date" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                        <select id="submissionClass" name="class_name" 
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" required>
                            <option value="">Pilih Kelas</option>
                            @if(isset($classes))
                                @foreach($classes as $class)
                                    <option value="{{ $class }}">{{ $class }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mata Pelajaran</label>
                        <input type="text" id="submissionSubject" name="subject" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                               placeholder="Contoh: Matematika" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Waktu Sesi</label>
                        <input type="text" id="submissionTime" name="session_time" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                               placeholder="Contoh: 07:00-08:30" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Catatan (Opsional)</label>
                        <textarea id="submissionNotes" name="notes" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" 
                                  placeholder="Catatan tambahan untuk guru piket..."></textarea>
                    </div>
                </div>
                
                <div class="flex space-x-3 mt-6">
                    <button type="button" onclick="closeSubmitModal()" 
                            class="flex-1 bg-gray-300 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-4 py-2 rounded-lg hover:bg-gray-400 dark:hover:bg-gray-500 transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>

<script>
let html5QrcodeScanner = null;
let html5QrCode = null;
let isScanning = false;
let currentCameraId = null;
let recentScans = @json($recentScans ?? []);

// Check secure context and permissions
function checkEnvironment() {
    if (!window.isSecureContext) {
        showCameraError('Camera requires HTTPS connection. Please use secure URL.');
        return false;
    }
    
    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
        showCameraError('Camera API not supported in this browser.');
        return false;
    }
    
    return true;
}

// Request camera permission explicitly
async function requestCameraPermission() {
    try {
        console.log('📷 Requesting camera permission...');
        const stream = await navigator.mediaDevices.getUserMedia({ 
            video: { 
                facingMode: "environment",
                width: { ideal: 640 },
                height: { ideal: 480 }
            } 
        });
        
        stream.getTracks().forEach(track => track.stop());
        console.log('✅ Camera permission granted');
        return true;
    } catch (error) {
        console.error('❌ Camera permission denied:', error);
        
        let errorMessage = 'Camera permission denied.';
        if (error.name === 'NotAllowedError') {
            errorMessage = 'Camera access denied. Please allow camera permission and refresh the page.';
        } else if (error.name === 'NotFoundError') {
            errorMessage = 'No camera found on this device.';
        } else if (error.name === 'NotSupportedError') {
            errorMessage = 'Camera not supported in this browser.';
        } else if (error.name === 'NotReadableError') {
            errorMessage = 'Camera is being used by another application.';
        }
        
        showCameraError(errorMessage);
        return false;
    }
}

// Get mobile-optimized configuration
function getMobileOptimizedConfig() {
    const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    
    if (isMobile) {
        return {
            fps: 5,
            qrbox: { width: 200, height: 200 },
            aspectRatio: 1.0,
            rememberLastUsedCamera: true,
            disableFlip: false,
            videoConstraints: {
                facingMode: "environment",
                width: { ideal: 640, max: 1280 },
                height: { ideal: 480, max: 720 }
            }
        };
    }
    
    return {
        fps: 10,
        qrbox: { width: 250, height: 250 },
        aspectRatio: 1.0,
        rememberLastUsedCamera: true,
        disableFlip: false,
        videoConstraints: {
            facingMode: "environment"
        }
    };
}

// Initialize QR Scanner
async function initQrScanner() {
    if (typeof Html5QrcodeScanner === 'undefined') {
        console.error('Html5QrcodeScanner not loaded');
        showCameraError('QR Scanner library not loaded. Please refresh the page.');
        return false;
    }
    
    if (!checkEnvironment()) {
        return false;
    }
    
    const hasPermission = await requestCameraPermission();
    if (!hasPermission) {
        return false;
    }
    
    cleanupScanner();
    
    const qrReaderElement = document.getElementById('qr-reader');
    if (qrReaderElement) {
        qrReaderElement.innerHTML = `
            <div class="text-center p-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                <p class="text-emerald-600 dark:text-emerald-400">Initializing scanner...</p>
            </div>
        `;
    }
    
    try {
        const config = getMobileOptimizedConfig();
        console.log('🔧 Scanner config:', config);
        
        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader",
            config,
            false
        );
        
        console.log('✅ QR Scanner initialized');
        return true;
    } catch (error) {
        console.error('Failed to create Html5QrcodeScanner:', error);
        showCameraError('Failed to initialize scanner: ' + error.message);
        return false;
    }
}

// Clean up scanner
function cleanupScanner() {
    try {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(err => console.log('Clear scanner error:', err));
            html5QrcodeScanner = null;
        }
        if (html5QrCode) {
            html5QrCode.stop().catch(err => console.log('Stop QR code error:', err));
            html5QrCode = null;
        }
    } catch (error) {
        console.log('Cleanup error:', error);
    }
    
    isScanning = false;
    currentCameraId = null;
}

// Show camera error
function showCameraError(message) {
    document.getElementById('qr-reader').innerHTML = `
        <div class="text-center p-8">
            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                <h4 class="text-lg font-semibold text-red-900 dark:text-red-100 mb-2">Camera Error</h4>
                <p class="text-red-700 dark:text-red-300 mb-4">${message}</p>
                <div class="flex gap-3 justify-center">
                    <button onclick="retryCamera()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Try Again
                    </button>
                    <button onclick="useAlternativeMethod()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        Alternative Method
                    </button>
                </div>
            </div>
        </div>
    `;
}

// Retry camera
function retryCamera() {
    navigator.mediaDevices.getUserMedia({ video: true })
        .then(stream => {
            stream.getTracks().forEach(track => track.stop());
            initQrScanner();
        })
        .catch(err => {
            console.error('Camera permission denied:', err);
            useAlternativeMethod();
        });
}

// Use alternative method
function useAlternativeMethod() {
    document.getElementById('qr-reader').innerHTML = `
        <div class="text-center p-8">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Alternative QR Scanner</h4>
            <div id="alternative-qr-reader" class="max-w-sm mx-auto"></div>
        </div>
    `;
    
    initAlternativeScanner();
}

// Alternative scanner
function initAlternativeScanner() {
    if (typeof Html5Qrcode === 'undefined') {
        showCameraError('QR Scanner library not loaded properly');
        return;
    }
    
    Html5Qrcode.getCameras().then(devices => {
        if (devices && devices.length) {
            let selectedCamera = devices[0];
            for (let device of devices) {
                if (device.label && device.label.toLowerCase().includes('back')) {
                    selectedCamera = device;
                    break;
                }
            }
            
            currentCameraId = selectedCamera.id;
            html5QrCode = new Html5Qrcode("alternative-qr-reader");
            
            const config = {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
                disableFlip: false
            };
            
            html5QrCode.start(currentCameraId, config, onScanSuccess, onScanFailure)
                .then(() => {
                    console.log('✅ Alternative scanner started successfully');
                    isScanning = true;
                    document.getElementById('start-scanner').style.display = 'none';
                    document.getElementById('stop-scanner').style.display = 'inline-flex';
                })
                .catch(err => {
                    console.error('Failed to start alternative scanner:', err);
                    showCameraError('Failed to start camera: ' + err.message);
                });
        } else {
            showCameraError('No cameras found on this device');
        }
    }).catch(err => {
        console.error('Error getting cameras:', err);
        showCameraError('Camera access denied or not available');
    });
}

// Start QR Scanner
document.getElementById('start-scanner').addEventListener('click', function() {
    if (!isScanning) {
        console.log('📷 Starting QR Scanner...');
        
        this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Starting...';
        this.disabled = true;
        
        try {
            const initialized = initQrScanner();
            
            if (!initialized) {
                this.innerHTML = '<i class="fas fa-play mr-2"></i>Mulai Scanner';
                this.disabled = false;
                return;
            }
            
            try {
                html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                
                isScanning = true;
                document.getElementById('start-scanner').style.display = 'none';
                document.getElementById('stop-scanner').style.display = 'inline-flex';
                
                console.log('✅ QR Scanner started successfully');
            } catch (renderError) {
                console.error('Failed to render scanner:', renderError);
                
                this.innerHTML = '<i class="fas fa-play mr-2"></i>Mulai Scanner';
                this.disabled = false;
                
                setTimeout(() => {
                    console.log('🔄 Trying alternative scanner method...');
                    useAlternativeMethod();
                }, 1000);
            }
        } catch (error) {
            console.error('Failed to initialize scanner:', error);
            
            this.innerHTML = '<i class="fas fa-play mr-2"></i>Mulai Scanner';
            this.disabled = false;
            
            showCameraError('Failed to initialize camera. Please check permissions.');
        }
    }
});

// Stop QR Scanner
document.getElementById('stop-scanner').addEventListener('click', function() {
    if (isScanning) {
        cleanupScanner();
        
        document.getElementById('start-scanner').style.display = 'inline-flex';
        document.getElementById('stop-scanner').style.display = 'none';
        
        const qrReaderElement = document.getElementById('qr-reader');
        if (qrReaderElement) {
            qrReaderElement.innerHTML = `
                <div class="text-center p-8">
                    <i class="fas fa-qrcode text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
                    <p class="text-gray-600 dark:text-gray-400">Scanner stopped</p>
                </div>
            `;
        }
    }
});

// QR Code scan success callback
function onScanSuccess(decodedText, decodedResult) {
    console.log('QR Code detected:', decodedText);
    
    cleanupScanner();
    
    document.getElementById('start-scanner').style.display = 'inline-flex';
    document.getElementById('stop-scanner').style.display = 'none';
    
    const qrReaderElement = document.getElementById('qr-reader');
    if (qrReaderElement) {
        qrReaderElement.innerHTML = `
            <div class="text-center p-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-emerald-600 mx-auto mb-4"></div>
                <p class="text-emerald-600 dark:text-emerald-400">Processing QR Code...</p>
            </div>
        `;
    }
    
    processAttendance(decodedText);
}

// QR Code scan failure callback
function onScanFailure(error) {
    if (error.includes('No MultiFormat Readers')) {
        return;
    }
    console.log(`QR Code scan error: ${error}`);
}

// Process attendance
function processAttendance(qrCode) {
    Swal.fire({
        title: 'Memproses Absensi...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    const controller = new AbortController();
    const timeoutId = setTimeout(() => {
        controller.abort();
        console.log('⏰ Request timeout after 15 seconds');
    }, 15000);
    
    fetch('{{ route("teacher.attendance.scan-qr") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            qr_code: qrCode,
            location: 'Scanned by Teacher'
        }),
        signal: controller.signal
    })
    .then(response => {
        clearTimeout(timeoutId);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        Swal.close();
        
        if (data.success) {
            // Add to recent scans
            addToRecentScans(data.attendance);
            
            Swal.fire({
                icon: 'success',
                title: 'Absensi Berhasil Dicatat!',
                html: `
                    <div class="text-center">
                        <h5 class="text-lg font-semibold mb-2">${data.attendance.student_name}</h5>
                        <p class="text-gray-600 mb-3">NIS: ${data.attendance.nis} | Kelas: ${data.attendance.class}</p>
                        <div class="bg-emerald-50 rounded-lg p-4 mb-3">
                            <p class="mb-2">Status: <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">${data.attendance.status}</span></p>
                            <p class="mb-2">Waktu: ${data.attendance.scan_time}</p>
                            <p class="mb-0">Tanggal: ${data.attendance.attendance_date}</p>
                            <p class="text-sm text-gray-600 mt-2">${data.attendance.scanned_by}</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#10b981'
            }).then(() => {
                // Reset scanner for next scan
                document.getElementById('qr-reader').innerHTML = `
                    <div class="text-center p-8">
                        <i class="fas fa-qrcode text-6xl text-gray-400 dark:text-gray-500 mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400">Siap untuk scan berikutnya</p>
                    </div>
                `;
            });
        } else {
            if (data.existing_attendance) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Siswa Sudah Absen',
                    html: `
                        <div class="text-center">
                            <h5 class="text-lg font-semibold mb-2">${data.existing_attendance.student_name}</h5>
                            <p class="text-gray-600 mb-3">NIS: ${data.existing_attendance.nis} | Kelas: ${data.existing_attendance.class}</p>
                            <div class="bg-yellow-50 rounded-lg p-4 mb-3">
                                <p class="mb-2">Status: <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">${data.existing_attendance.status}</span></p>
                                <p class="mb-0">Waktu Absen: ${data.existing_attendance.scan_time}</p>
                            </div>
                            <p class="text-sm text-gray-600">${data.message}</p>
                        </div>
                    `,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#f59e0b'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Absensi Gagal',
                    text: data.message,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#ef4444'
                });
            }
        }
    })
    .catch(error => {
        clearTimeout(timeoutId);
        Swal.close();
        
        console.error('❌ Network error:', error);
        
        let errorMessage = 'Terjadi kesalahan sistem';
        let errorTitle = 'Error';
        
        if (error.name === 'AbortError') {
            errorTitle = 'Timeout';
            errorMessage = 'Request timeout. Koneksi terlalu lambat. Silakan coba lagi.';
        } else if (error.message.includes('Failed to fetch')) {
            errorTitle = 'Connection Error';
            errorMessage = 'Gagal terhubung ke server. Periksa koneksi internet Anda.';
        }
        
        Swal.fire({
            icon: 'error',
            title: errorTitle,
            text: errorMessage,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
    });
}

// Add to recent scans
function addToRecentScans(attendance) {
    recentScans.unshift(attendance);
    if (recentScans.length > 5) {
        recentScans.pop();
    }
    
    updateRecentScansDisplay();
}

// Update recent scans display
function updateRecentScansDisplay() {
    const container = document.getElementById('recent-scans');
    
    if (recentScans.length === 0) {
        container.innerHTML = `
            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                <i class="fas fa-qrcode text-6xl mb-4"></i>
                <h4 class="text-lg font-semibold mb-2">Belum Ada Scan Hari Ini</h4>
                <p class="text-sm">Scan QR Code siswa akan muncul di sini secara real-time</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
            ${recentScans.map(scan => `
                <div class="bg-gradient-to-br from-white to-gray-50 dark:from-gray-700 dark:to-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-600 shadow-sm hover:shadow-md transition-all duration-200">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">${scan.student_name}</h4>
                            <p class="text-xs text-gray-600 dark:text-gray-400">NIS: ${scan.nis}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                                <i class="fas fa-graduation-cap mr-1"></i>${scan.class || 'Kelas tidak ditemukan'}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <span class="px-2 py-1 text-xs font-medium rounded-full ${scan.badge_color}">${scan.status}</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span class="flex items-center">
                            <i class="fas fa-clock mr-1"></i>${scan.scan_time}
                        </span>
                        <span class="flex items-center">
                            <i class="fas fa-user-check mr-1"></i>Guru
                        </span>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

// Manual input toggle
document.getElementById('manual-input').addEventListener('click', function() {
    const form = document.getElementById('manual-input-form');
    if (form.classList.contains('hidden')) {
        form.classList.remove('hidden');
        document.getElementById('manual-qr-input').focus();
    } else {
        form.classList.add('hidden');
    }
});

// Process manual input
function processManualInput() {
    const qrCode = document.getElementById('manual-qr-input').value.trim();
    
    if (!qrCode) {
        Swal.fire({
            icon: 'warning',
            title: 'Input Kosong',
            text: 'Silakan masukkan kode QR terlebih dahulu',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f59e0b'
        });
        return;
    }
    
    document.getElementById('manual-input-form').classList.add('hidden');
    document.getElementById('manual-qr-input').value = '';
    
    processAttendance(qrCode);
}

// Allow Enter key in manual input
document.getElementById('manual-qr-input').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        processManualInput();
    }
});

// Cleanup when page is unloaded
window.addEventListener('beforeunload', function() {
    cleanupScanner();
});

// Cleanup when page visibility changes
document.addEventListener('visibilitychange', function() {
    if (document.hidden && isScanning) {
        cleanupScanner();
        document.getElementById('start-scanner').style.display = 'inline-flex';
        document.getElementById('stop-scanner').style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📚 Initializing Teacher QR Scanner page...');
    
    // Load recent scans from server data
    console.log('📊 Loading recent scans:', recentScans.length, 'items');
    updateRecentScansDisplay();
    
    if (typeof Html5QrcodeScanner === 'undefined' || typeof Html5Qrcode === 'undefined') {
        console.error('❌ QR Scanner library not loaded');
        
        const qrReaderElement = document.getElementById('qr-reader');
        if (qrReaderElement) {
            qrReaderElement.innerHTML = `
                <div class="text-center p-8">
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
                        <i class="fas fa-exclamation-triangle text-4xl text-red-500 mb-4"></i>
                        <h4 class="text-lg font-semibold text-red-900 dark:text-red-100 mb-2">Library Loading Error</h4>
                        <p class="text-red-700 dark:text-red-300 mb-4">QR Scanner library failed to load. Please refresh the page.</p>
                        <button onclick="location.reload()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            Refresh Page
                        </button>
                    </div>
                </div>
            `;
        }
        
        const startButton = document.getElementById('start-scanner');
        if (startButton) {
            startButton.disabled = true;
            startButton.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Library Error';
        }
    } else {
        console.log('✅ QR Scanner library loaded successfully');
    }
});

// Submit to Guru Piket functions
function showSubmitToGuruPiketModal() {
    console.log('Opening submit modal...');
    const modal = document.getElementById('submitToGuruPiketModal');
    if (modal) {
        modal.classList.remove('hidden');
        // Focus on first input
        setTimeout(() => {
            const firstInput = modal.querySelector('input, select');
            if (firstInput) {
                firstInput.focus();
            }
        }, 100);
    } else {
        console.error('Modal element not found');
    }
}

function closeSubmitModal() {
    console.log('Closing submit modal...');
    const modal = document.getElementById('submitToGuruPiketModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

function submitToGuruPiket(event) {
    event.preventDefault();
    
    console.log('Submitting to guru piket...');
    
    const formData = new FormData(event.target);
    const data = {
        date: formData.get('date'),
        class_name: formData.get('class_name'),
        subject: formData.get('subject'),
        session_time: formData.get('session_time'),
        notes: formData.get('notes')
    };
    
    console.log('Form data:', data);
    
    // Validate required fields
    if (!data.date || !data.class_name || !data.subject || !data.session_time) {
        Swal.fire({
            icon: 'warning',
            title: 'Data Tidak Lengkap',
            text: 'Mohon lengkapi semua field yang wajib diisi',
            confirmButtonText: 'OK',
            confirmButtonColor: '#f59e0b'
        });
        return;
    }
    
    // Show loading
    Swal.fire({
        title: 'Mengirim Absensi...',
        text: 'Sedang memproses data absensi untuk dikirim ke guru piket',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    const submitUrl = '{{ route("teacher.attendance.submit-to-guru-piket") }}';
    console.log('Submit URL:', submitUrl);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        console.error('CSRF token not found!');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'CSRF token tidak ditemukan. Silakan refresh halaman.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
        return;
    }
    
    console.log('CSRF Token:', csrfToken.getAttribute('content'));
    
    fetch(submitUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            // Try to get error details from response
            return response.text().then(text => {
                console.error('Error response body:', text);
                let errorMessage = `HTTP ${response.status}: ${response.statusText}`;
                try {
                    const errorData = JSON.parse(text);
                    if (errorData.message) {
                        errorMessage = errorData.message;
                    }
                } catch (e) {
                    console.log('Could not parse error response as JSON');
                }
                throw new Error(errorMessage);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        Swal.close();
        
        if (data.success) {
            closeSubmitModal();
            
            Swal.fire({
                icon: 'success',
                title: 'Absensi Berhasil Dikirim!',
                html: `
                    <div class="text-center">
                        <div class="bg-green-50 rounded-lg p-4 mb-4">
                            <h5 class="text-lg font-semibold mb-2">${data.submission.class_name} - ${data.submission.subject}</h5>
                            <p class="text-gray-600 mb-2">Tanggal: ${data.submission.date}</p>
                            <p class="text-gray-600 mb-2">Total Siswa: ${data.submission.total_students}</p>
                            <p class="text-gray-600 mb-2">Hadir: ${data.submission.present_count} (${data.submission.attendance_percentage}%)</p>
                            <p class="text-gray-600 mb-2">Guru Piket: ${data.submission.guru_piket}</p>
                            <p class="text-sm text-green-700 mt-3">
                                <i class="fas fa-info-circle mr-1"></i>
                                Status: ${data.submission.status}
                            </p>
                        </div>
                        <p class="text-sm text-gray-600">Absensi telah dikirim ke guru piket untuk dikonfirmasi</p>
                    </div>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#10b981'
            });
            
            // Reset form
            document.getElementById('submitToGuruPiketForm').reset();
            document.getElementById('submissionDate').value = '{{ date("Y-m-d") }}';
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mengirim Absensi',
                text: data.message || 'Terjadi kesalahan saat mengirim absensi',
                confirmButtonText: 'OK',
                confirmButtonColor: '#ef4444'
            });
        }
    })
    .catch(error => {
        Swal.close();
        console.error('Error submitting to guru piket:', error);
        
        let errorMessage = 'Gagal mengirim absensi ke guru piket. Silakan coba lagi.';
        if (error.message.includes('Failed to fetch')) {
            errorMessage = 'Koneksi ke server gagal. Periksa koneksi internet Anda.';
        } else if (error.message.includes('HTTP')) {
            errorMessage = 'Server error: ' + error.message;
        }
        
        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: errorMessage,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
    });
}
</script>
@endpush