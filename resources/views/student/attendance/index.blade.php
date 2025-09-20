@extends('layouts.student')

@section('title', 'QR Scanner Absensi')

@push('meta')
<!-- Cache Busting Meta Tags -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="student-id" content="{{ $student->id }}">
<meta name="user-id" content="{{ auth()->id() }}">
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
                QR Scanner Absensi
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Scan QR Code untuk melakukan absensi harian</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" onclick="showMyQrCode()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-qrcode mr-2"></i>QR Code Saya
            </button>
            <a href="{{ route('student.attendance.history') }}" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-history mr-2"></i>Riwayat Absensi
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- QR Scanner Section -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-blue-600 px-6 py-4">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-camera mr-3"></i>Scanner QR Code
                    </h2>
                </div>
                <div class="p-6">
                    @if($todayAttendance)
                        <!-- Already attended today -->
                        <div class="text-center py-8">
                            <div class="bg-gradient-to-r from-emerald-100 to-blue-100 dark:from-emerald-900/30 dark:to-blue-900/30 rounded-2xl p-8 border border-emerald-200 dark:border-emerald-700">
                                <div class="mb-6">
                                    @php
                                        $iconColor = match($todayAttendance->status) {
                                            'hadir' => 'text-emerald-500',
                                            'terlambat' => 'text-yellow-500',
                                            'izin' => 'text-blue-500',
                                            'sakit' => 'text-purple-500',
                                            default => 'text-red-500'
                                        };
                                    @endphp
                                    <i class="fas fa-check-circle text-6xl {{ $iconColor }} mb-4"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                                    Absensi Hari Ini Sudah Tercatat
                                </h3>
                                <div class="space-y-3">
                                    <div class="flex items-center justify-center space-x-2">
                                        <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                        @php
                                            $badgeColor = match($todayAttendance->status) {
                                                'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                                'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                            };
                                        @endphp
                                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                                            {{ $todayAttendance->status_text }}
                                        </span>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-clock mr-2"></i>
                                        Waktu: {{ $todayAttendance->scan_time->format('H:i:s') }}
                                    </p>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        Lokasi: {{ $todayAttendance->location ?? 'Sekolah' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- QR Scanner Interface -->
                        <div class="text-center">
                            <!-- Scanner Container -->
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
                                               placeholder="Masukkan kode QR atau scan dengan aplikasi lain">
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
                            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-xl p-6">
                                <div class="flex items-start">
                                    <i class="fas fa-lightbulb text-amber-600 dark:text-amber-400 text-xl mr-3 mt-1"></i>
                                    <div class="text-left">
                                        <h4 class="font-semibold text-amber-900 dark:text-amber-100 mb-2">Petunjuk Penggunaan:</h4>
                                        <ul class="text-sm text-amber-800 dark:text-amber-200 space-y-1">
                                            <li>• Klik "Mulai Scanner" untuk mengaktifkan kamera</li>
                                            <li>• Arahkan kamera ke QR Code absensi</li>
                                            <li>• Pastikan QR Code terlihat jelas dalam frame</li>
                                            <li>• Scanner akan otomatis membaca QR Code</li>
                                            <li>• Gunakan "Input Manual" jika kamera bermasalah</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Student Info Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Informasi Siswa</h3>
                </div>
                <div class="p-6 text-center">
                    @if($student->photo_url)
                        <img src="{{ $student->photo_url }}" alt="{{ $student->name }}" 
                             class="w-20 h-20 rounded-full mx-auto mb-4 border-4 border-purple-200 dark:border-purple-700">
                    @else
                        <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-4">
                            {{ $student->initials }}
                        </div>
                    @endif
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $student->name }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-2">NIS: {{ $student->nis }}</p>
                    <span class="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 px-3 py-1 rounded-full text-sm font-medium">
                        {{ $student->class }}
                    </span>
                </div>
            </div>

            <!-- Monthly Statistics -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Statistik Bulan Ini</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $monthlyStats['hadir'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Hadir</div>
                        </div>
                        <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $monthlyStats['terlambat'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Terlambat</div>
                        </div>
                        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ ($monthlyStats['izin'] ?? 0) + ($monthlyStats['sakit'] ?? 0) }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Izin/Sakit</div>
                        </div>
                        <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-xl">
                            <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $monthlyStats['alpha'] ?? 0 }}</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Alpha</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Attendance -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white">Absensi Terakhir</h3>
                </div>
                <div class="p-6">
                    @forelse($recentAttendance->take(5) as $attendance)
                        <div class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                            <div>
                                <div class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $attendance->attendance_date->format('d/m/Y') }}
                                </div>
                                @php
                                    $badgeColor = match($attendance->status) {
                                        'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                        'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                        default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                    };
                                @endphp
                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                                    {{ $attendance->status_text }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $attendance->scan_time->format('H:i') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada data absensi</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- My QR Code Modal -->
<div id="myQrCodeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeModal('myQrCodeModal')">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white">QR Code Absensi Saya</h3>
                <button onclick="closeModal('myQrCodeModal')" class="text-white hover:text-gray-200 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div id="myQrCodeContent" class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                <p class="text-gray-600 dark:text-gray-400 mt-3">Loading...</p>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="closeModal('myQrCodeModal')" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                Tutup
            </button>
            <a href="{{ route('student.attendance.download-qr') }}" id="downloadMyQrBtn" 
               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                <i class="fas fa-download mr-2"></i>Download
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<!-- QR Code Scanner Library -->
<script src="https://unpkg.com/html5-qrcode@2.3.4/html5-qrcode.min.js"></script>

<script>
// Ngrok compatibility fixes
(function() {
    // Check if we're using ngrok and force HTTPS
    if (location.hostname.includes('ngrok.io') && location.protocol !== 'https:') {
        console.log('🔄 Redirecting to HTTPS for ngrok compatibility...');
        location.replace('https:' + window.location.href.substring(window.location.protocol.length));
        return;
    }
    
    // Check secure context
    if (!window.isSecureContext) {
        console.warn('⚠️ Not in secure context. Camera may not work properly.');
    }
    
    console.log('🌐 Environment check:', {
        protocol: location.protocol,
        hostname: location.hostname,
        isSecureContext: window.isSecureContext,
        isNgrok: location.hostname.includes('ngrok.io')
    });
})();
let html5QrcodeScanner = null;
let html5QrCode = null;
let isScanning = false;
let currentCameraId = null;

// Check secure context and permissions
function checkEnvironment() {
    // Check secure context (required for camera access)
    if (!window.isSecureContext) {
        showCameraError('Camera requires HTTPS connection. Please use secure URL.');
        return false;
    }
    
    // Check if getUserMedia is available
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
        
        // Stop the stream immediately (we just wanted to check permission)
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
    const isNgrok = location.hostname.includes('ngrok.io');
    
    console.log('📱 Device info:', { isMobile, isNgrok });
    
    if (isMobile || isNgrok) {
        return {
            fps: 5, // Lower FPS for better performance
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

// Initialize QR Scanner with improved configuration
async function initQrScanner() {
    if (typeof Html5QrcodeScanner === 'undefined') {
        console.error('Html5QrcodeScanner not loaded');
        showCameraError('QR Scanner library not loaded. Please refresh the page.');
        return false;
    }
    
    // Check environment first
    if (!checkEnvironment()) {
        return false;
    }
    
    // Request camera permission
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

// Clean up scanner properly
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

// Show camera error with retry option
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

// Retry camera initialization
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

// Use alternative scanning method
function useAlternativeMethod() {
    document.getElementById('qr-reader').innerHTML = `
        <div class="text-center p-8">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Alternative QR Scanner</h4>
            <div id="alternative-qr-reader" class="max-w-sm mx-auto"></div>
        </div>
    `;
    
    initAlternativeScanner();
}

// Alternative scanner using Html5Qrcode directly
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

// Process attendance with improved error handling
function processAttendance(qrCode) {
    Swal.fire({
        title: 'Memproses Absensi...',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    // Create abort controller for timeout
    const controller = new AbortController();
    const timeoutId = setTimeout(() => {
        controller.abort();
        console.log('⏰ Request timeout after 15 seconds');
    }, 15000); // 15 second timeout for ngrok
    
    fetch('{{ route("student.attendance.scan") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            qr_code: qrCode,
            location: 'Sekolah'
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
            Swal.fire({
                icon: 'success',
                title: 'Absensi Berhasil!',
                html: `
                    <div class="text-center">
                        <h5 class="text-lg font-semibold mb-2">${data.attendance.student_name}</h5>
                        <p class="text-gray-600 mb-3">NIS: ${data.attendance.nis} | Kelas: ${data.attendance.class}</p>
                        <div class="bg-emerald-50 rounded-lg p-4 mb-3">
                            <p class="mb-2">Status: <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full text-sm font-medium">${data.attendance.status}</span></p>
                            <p class="mb-2">Waktu: ${data.attendance.scan_time}</p>
                            <p class="mb-0">Tanggal: ${data.attendance.attendance_date}</p>
                        </div>
                    </div>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#10b981'
            }).then(() => {
                location.reload();
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
        } else if (error.message.includes('CORS')) {
            errorTitle = 'CORS Error';
            errorMessage = 'Masalah konfigurasi server. Silakan hubungi administrator.';
        } else if (error.message.includes('HTTP')) {
            errorTitle = 'Server Error';
            errorMessage = `Server error: ${error.message}`;
        }
        
        Swal.fire({
            icon: 'error',
            title: errorTitle,
            html: `
                <p>${errorMessage}</p>
                <br>
                <small class="text-gray-500">
                    <strong>Troubleshooting:</strong><br>
                    1. Periksa koneksi internet<br>
                    2. Pastikan menggunakan HTTPS<br>
                    3. Coba refresh halaman<br>
                    4. Gunakan input manual jika masih error
                </small>
            `,
            confirmButtonText: 'OK',
            confirmButtonColor: '#ef4444'
        });
    });
}

// Show My QR Code
function showMyQrCode() {
    document.getElementById('myQrCodeModal').classList.remove('hidden');
    document.getElementById('myQrCodeModal').classList.add('flex');
    
    fetch('{{ route("student.attendance.my-qr") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('myQrCodeContent').innerHTML = `
                    <div class="text-center">
                        <img src="${data.qr_image_url}" alt="My QR Code" class="max-w-xs mx-auto mb-4 rounded-lg shadow-lg">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">${data.student.name}</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">NIS: ${data.student.nis} | Kelas: ${data.student.class}</p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                <i class="fas fa-info-circle mr-1"></i>
                                Gunakan QR Code ini untuk absensi harian
                            </p>
                        </div>
                    </div>
                `;
            } else {
                document.getElementById('myQrCodeContent').innerHTML = `
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                        <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400 mr-2"></i>
                        <span class="text-yellow-800 dark:text-yellow-200">${data.message}</span>
                    </div>
                `;
                document.getElementById('downloadMyQrBtn').style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('myQrCodeContent').innerHTML = `
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <i class="fas fa-times text-red-600 dark:text-red-400 mr-2"></i>
                    <span class="text-red-800 dark:text-red-200">Terjadi kesalahan saat memuat QR Code</span>
                </div>
            `;
        });
}

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
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

// Cleanup when page visibility changes (mobile)
document.addEventListener('visibilitychange', function() {
    if (document.hidden && isScanning) {
        cleanupScanner();
        document.getElementById('start-scanner').style.display = 'inline-flex';
        document.getElementById('stop-scanner').style.display = 'none';
    }
});

// Clear any existing data and check user context
function clearUserData() {
    // Get current user info from meta tags
    const currentStudentId = document.querySelector('meta[name="student-id"]')?.content;
    const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
    const cacheBuster = document.querySelector('meta[name="cache-buster"]')?.content;
    
    console.log('🔄 Clearing user data for student:', currentStudentId, 'user:', currentUserId);
    
    // Clear any stored data that might be from previous user
    if (typeof(Storage) !== "undefined") {
        // Clear localStorage items that might contain user-specific data
        const keysToRemove = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && (key.includes('attendance') || key.includes('qr') || key.includes('student'))) {
                keysToRemove.push(key);
            }
        }
        keysToRemove.forEach(key => localStorage.removeItem(key));
        
        // Clear sessionStorage
        sessionStorage.clear();
    }
    
    // Clear any existing intervals
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
    
    // Reset scanner state
    cleanupScanner();
    
    // Store current user info for validation
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem('current_student_id', currentStudentId);
        localStorage.setItem('current_user_id', currentUserId);
        localStorage.setItem('page_load_time', cacheBuster);
    }
}

// Validate user context
function validateUserContext() {
    const currentStudentId = document.querySelector('meta[name="student-id"]')?.content;
    const storedStudentId = localStorage.getItem('current_student_id');
    
    if (storedStudentId && storedStudentId !== currentStudentId) {
        console.log('🚨 User context changed! Clearing data and reloading...');
        clearUserData();
        location.reload();
        return false;
    }
    
    return true;
}

// Check library loading on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('📚 Initializing QR Scanner page...');
    
    // Clear user data first
    clearUserData();
    
    // Validate user context
    if (!validateUserContext()) {
        return;
    }
    
    console.log('📚 Checking QR Scanner library...');
    
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

// Validate user context periodically
setInterval(validateUserContext, 5000); // Check every 5 seconds
</script>
@endpush