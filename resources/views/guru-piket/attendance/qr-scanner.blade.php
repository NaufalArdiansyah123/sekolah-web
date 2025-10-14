@extends('layouts.guru-piket')

@section('title', 'QR Scanner Absensi')

@push('styles')
<style>
    .qr-scanner-container {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    
    .dark .qr-scanner-container {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .scanner-preview {
        width: 100%;
        max-width: 400px;
        height: 300px;
        border-radius: 0.75rem;
        border: 2px solid #e5e7eb;
        background: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .dark .scanner-preview {
        background: #374151;
        border-color: #4b5563;
    }
    
    .scan-result {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-top: 1rem;
    }
    
    .dark .scan-result {
        background: #064e3b;
        border-color: #065f46;
    }
    
    .recent-scans {
        max-height: 400px;
        overflow-y: auto;
    }
    
    .scan-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
        transition: all 0.2s ease;
    }
    
    .dark .scan-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .scan-item:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
    }
    
    .dark .scan-item:hover {
        background: #4b5563;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">QR Scanner Absensi</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Scan QR code siswa untuk mencatat kehadiran</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-green-100 dark:bg-green-900/20 px-3 py-1 rounded-full">
                    <span class="text-green-800 dark:text-green-200 text-sm font-medium">Scanner Aktif</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- QR Scanner Section -->
        <div class="qr-scanner-container p-6">
            <div class="text-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Scanner QR Code</h2>
                
                <!-- Scanner Preview -->
                <div class="scanner-preview mx-auto mb-4">
                    <div class="text-center">
                        <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5"></path>
                        </svg>
                        <p class="text-gray-500 dark:text-gray-400">Kamera akan muncul di sini</p>
                        <p class="text-sm text-gray-400 dark:text-gray-500 mt-2">Arahkan QR code siswa ke kamera</p>
                    </div>
                </div>
                
                <!-- Scanner Controls -->
                <div class="flex justify-center space-x-3">
                    <button id="startScanner" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m2-10v.01M12 17v.01"></path>
                        </svg>
                        Mulai Scanner
                    </button>
                    <button id="stopScanner" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-6 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l6 6m0-6l-6 6"></path>
                        </svg>
                        Stop Scanner
                    </button>
                </div>
                
                <!-- Scan Result -->
                <div id="scanResult" class="scan-result hidden">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-green-800 dark:text-green-200 font-medium">Berhasil scan QR code!</span>
                    </div>
                    <p class="text-green-700 dark:text-green-300 text-sm mt-1" id="scanResultText"></p>
                </div>
            </div>
        </div>

        <!-- Recent Scans Section -->
        <div class="qr-scanner-container p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Scan Terakhir Hari Ini</h2>
                <span class="bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 px-3 py-1 rounded-full text-sm">
                    {{ date('d M Y') }}
                </span>
            </div>
            
            <div class="recent-scans">
                <!-- Sample Recent Scans -->
                <div class="scan-item">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Ahmad Fauzi</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">XII IPA 1 • NIS: 2021001</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full text-xs font-medium">
                                Hadir
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">07:15</p>
                        </div>
                    </div>
                </div>

                <div class="scan-item">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Siti Nurhaliza</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">XII IPA 2 • NIS: 2021002</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-2 py-1 rounded-full text-xs font-medium">
                                Terlambat
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">07:25</p>
                        </div>
                    </div>
                </div>

                <div class="scan-item">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Budi Santoso</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">XII IPS 1 • NIS: 2021003</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded-full text-xs font-medium">
                                Hadir
                            </span>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">07:10</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                <a href="{{ route('guru-piket.attendance.students') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm flex items-center">
                    <span>Lihat semua absensi siswa</span>
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-gray-800 dark:bg-white">
                    <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Scan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">156</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Hadir</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">142</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-yellow-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Terlambat</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">14</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-gray-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rata-rata per Jam</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">22</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startBtn = document.getElementById('startScanner');
    const stopBtn = document.getElementById('stopScanner');
    const scanResult = document.getElementById('scanResult');
    const scanResultText = document.getElementById('scanResultText');
    
    let isScanning = false;
    
    startBtn.addEventListener('click', function() {
        if (!isScanning) {
            isScanning = true;
            startBtn.disabled = true;
            startBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Memulai...';
            
            // Simulate scanner initialization
            setTimeout(() => {
                startBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 9l6 6m0-6l-6 6"></path></svg>Scanner Aktif';
                startBtn.classList.remove('bg-gray-900', 'dark:bg-white');
                startBtn.classList.add('bg-green-600', 'dark:bg-green-500');
                stopBtn.disabled = false;
            }, 2000);
        }
    });
    
    stopBtn.addEventListener('click', function() {
        if (isScanning) {
            isScanning = false;
            startBtn.disabled = false;
            stopBtn.disabled = true;
            startBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h8m2-10v.01M12 17v.01"></path></svg>Mulai Scanner';
            startBtn.classList.remove('bg-green-600', 'dark:bg-green-500');
            startBtn.classList.add('bg-gray-900', 'dark:bg-white');
            scanResult.classList.add('hidden');
        }
    });
    
    // Simulate QR code detection
    setInterval(() => {
        if (isScanning && Math.random() > 0.95) {
            const students = [
                { name: 'Ahmad Fauzi', nis: '2021001', class: 'XII IPA 1' },
                { name: 'Siti Nurhaliza', nis: '2021002', class: 'XII IPA 2' },
                { name: 'Budi Santoso', nis: '2021003', class: 'XII IPS 1' }
            ];
            
            const student = students[Math.floor(Math.random() * students.length)];
            scanResultText.textContent = `${student.name} (${student.nis}) - ${student.class}`;
            scanResult.classList.remove('hidden');
            
            setTimeout(() => {
                scanResult.classList.add('hidden');
            }, 3000);
        }
    }, 1000);
});
</script>
@endpush