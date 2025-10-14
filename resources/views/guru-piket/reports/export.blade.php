@extends('layouts.guru-piket')

@section('title', 'Export Data')

@push('styles')
<style>
    .export-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .dark .export-card {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .export-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .export-option {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .dark .export-option {
        background: #374151;
        border-color: #4b5563;
    }
    
    .export-option:hover {
        background: #f3f4f6;
        border-color: #d1d5db;
        transform: translateY(-1px);
    }
    
    .dark .export-option:hover {
        background: #4b5563;
        border-color: #6b7280;
    }
    
    .export-option.selected {
        background: #dbeafe;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .dark .export-option.selected {
        background: #1e3a8a;
        border-color: #60a5fa;
        box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
    }
    
    .format-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .format-pdf {
        background: #fee2e2;
        color: #dc2626;
    }
    
    .dark .format-pdf {
        background: #7f1d1d;
        color: #fca5a5;
    }
    
    .format-excel {
        background: #dcfce7;
        color: #16a34a;
    }
    
    .dark .format-excel {
        background: #14532d;
        color: #86efac;
    }
    
    .format-csv {
        background: #dbeafe;
        color: #2563eb;
    }
    
    .dark .format-csv {
        background: #1e3a8a;
        color: #93c5fd;
    }
    
    .progress-bar {
        background: #e5e7eb;
        border-radius: 9999px;
        height: 8px;
        overflow: hidden;
    }
    
    .dark .progress-bar {
        background: #4b5563;
    }
    
    .progress-fill {
        height: 100%;
        background: #3b82f6;
        border-radius: 9999px;
        transition: width 0.3s ease;
    }
    
    .export-history-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .dark .export-history-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .export-history-item:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
    }
    
    .dark .export-history-item:hover {
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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Export Data</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Export data absensi dalam berbagai format</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-blue-100 dark:bg-blue-900/20 px-3 py-1 rounded-full">
                    <span class="text-blue-800 dark:text-blue-200 text-sm font-medium">Data Terkini</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Export Configuration -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Data Selection -->
            <div class="export-card p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Pilih Data yang Akan Diekspor</h2>
                
                <div class="space-y-4">
                    <!-- Data Type -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Jenis Data</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <label class="export-option selected">
                                <input type="radio" name="data_type" value="students" class="sr-only" checked>
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Absensi Siswa</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Data kehadiran siswa</div>
                                    </div>
                                </div>
                            </label>
                            
                            <label class="export-option">
                                <input type="radio" name="data_type" value="teachers" class="sr-only">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Absensi Guru</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Data kehadiran guru</div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Mulai</label>
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ date('Y-m-01') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal Selesai</label>
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ date('Y-m-d') }}">
                        </div>
                    </div>

                    <!-- Class Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter Kelas</label>
                        <select class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Semua Kelas</option>
                            <option value="XII IPA 1">XII IPA 1</option>
                            <option value="XII IPA 2">XII IPA 2</option>
                            <option value="XII IPS 1">XII IPS 1</option>
                            <option value="XII IPS 2">XII IPS 2</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Filter Status</label>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Hadir</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Terlambat</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Izin</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Sakit</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" checked>
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Alpha</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Format Selection -->
            <div class="export-card p-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Pilih Format Export</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <label class="export-option selected">
                        <input type="radio" name="format" value="pdf" class="sr-only" checked>
                        <div class="text-center">
                            <div class="format-icon format-pdf mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="font-medium text-gray-900 dark:text-white">PDF</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Format laporan siap cetak</div>
                        </div>
                    </label>
                    
                    <label class="export-option">
                        <input type="radio" name="format" value="excel" class="sr-only">
                        <div class="text-center">
                            <div class="format-icon format-excel mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="font-medium text-gray-900 dark:text-white">Excel</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Spreadsheet untuk analisis</div>
                        </div>
                    </label>
                    
                    <label class="export-option">
                        <input type="radio" name="format" value="csv" class="sr-only">
                        <div class="text-center">
                            <div class="format-icon format-csv mx-auto">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                            </div>
                            <div class="font-medium text-gray-900 dark:text-white">CSV</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Data mentah untuk import</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Export Button -->
            <div class="export-card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Siap untuk Export</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Data akan diproses dan diunduh otomatis</p>
                    </div>
                    <button id="exportBtn" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-3 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors font-medium">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Data
                    </button>
                </div>
                
                <!-- Progress Bar (Hidden by default) -->
                <div id="exportProgress" class="mt-4 hidden">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Memproses data...</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400" id="progressText">0%</span>
                    </div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="progressFill" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export History & Info -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="export-card p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Data</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Siswa</span>
                        <span class="font-medium text-gray-900 dark:text-white">450</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Guru</span>
                        <span class="font-medium text-gray-900 dark:text-white">45</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Hari Efektif Bulan Ini</span>
                        <span class="font-medium text-gray-900 dark:text-white">22</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Total Record</span>
                        <span class="font-medium text-gray-900 dark:text-white">9,900</span>
                    </div>
                </div>
            </div>

            <!-- Export History -->
            <div class="export-card p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Riwayat Export</h2>
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    <div class="export-history-item">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Laporan Bulanan November</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">PDF • 2.3 MB</div>
                                </div>
                            </div>
                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">28 Nov 2024, 14:30</div>
                    </div>

                    <div class="export-history-item">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Data Absensi Siswa</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Excel • 1.8 MB</div>
                                </div>
                            </div>
                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">27 Nov 2024, 09:15</div>
                    </div>

                    <div class="export-history-item">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">Raw Data Backup</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">CSV • 856 KB</div>
                                </div>
                            </div>
                            <button class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">25 Nov 2024, 16:45</div>
                    </div>
                </div>
            </div>

            <!-- Export Tips -->
            <div class="export-card p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tips Export</h2>
                <div class="space-y-3 text-sm text-gray-600 dark:text-gray-400">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Gunakan format PDF untuk laporan resmi dan presentasi</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Format Excel cocok untuk analisis dan perhitungan lebih lanjut</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>CSV ideal untuk backup data dan import ke sistem lain</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>File export akan tersimpan dalam riwayat selama 30 hari</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle export option selection
    const exportOptions = document.querySelectorAll('.export-option');
    exportOptions.forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                
                // Remove selected class from all options in the same group
                const groupName = radio.name;
                document.querySelectorAll(`input[name="${groupName}"]`).forEach(r => {
                    r.closest('.export-option').classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
            }
        });
    });

    // Handle export button
    const exportBtn = document.getElementById('exportBtn');
    const exportProgress = document.getElementById('exportProgress');
    const progressFill = document.getElementById('progressFill');
    const progressText = document.getElementById('progressText');

    exportBtn.addEventListener('click', function() {
        // Show progress
        exportProgress.classList.remove('hidden');
        exportBtn.disabled = true;
        exportBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>Memproses...';

        // Simulate progress
        let progress = 0;
        const interval = setInterval(() => {
            progress += Math.random() * 15;
            if (progress > 100) progress = 100;
            
            progressFill.style.width = progress + '%';
            progressText.textContent = Math.round(progress) + '%';
            
            if (progress >= 100) {
                clearInterval(interval);
                
                setTimeout(() => {
                    // Reset UI
                    exportProgress.classList.add('hidden');
                    exportBtn.disabled = false;
                    exportBtn.innerHTML = '<svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>Export Data';
                    progressFill.style.width = '0%';
                    progressText.textContent = '0%';
                    
                    // Show success message
                    alert('Export berhasil! File akan diunduh secara otomatis.');
                }, 1000);
            }
        }, 200);
    });
});
</script>
@endpush