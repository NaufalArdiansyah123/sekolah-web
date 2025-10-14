@extends('layouts.guru-piket')

@section('title', 'Laporan Harian')

@push('styles')
<style>
    .report-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    
    .dark .report-card {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .chart-container {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .dark .chart-container {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .summary-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .dark .summary-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .summary-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .class-row {
        transition: all 0.2s ease;
    }
    
    .class-row:hover {
        background: #f9fafb;
    }
    
    .dark .class-row:hover {
        background: #374151;
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
        border-radius: 9999px;
        transition: width 0.3s ease;
    }
    
    .progress-green {
        background: #10b981;
    }
    
    .progress-yellow {
        background: #f59e0b;
    }
    
    .progress-red {
        background: #ef4444;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Harian</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Ringkasan kehadiran siswa dan guru hari ini</p>
            </div>
            <div class="flex items-center space-x-3">
                <input type="date" value="{{ date('Y-m-d') }}" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                <button class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </button>
                <button class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Export Excel
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="summary-item">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-gray-800 dark:bg-white">
                    <svg class="w-8 h-8 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">450</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Total Siswa</p>
            <div class="mt-2">
                <div class="progress-bar">
                    <div class="progress-fill progress-green" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <div class="summary-item">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-green-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">398</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Siswa Hadir</p>
            <div class="mt-2">
                <div class="progress-bar">
                    <div class="progress-fill progress-green" style="width: 88%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">88.4%</p>
            </div>
        </div>

        <div class="summary-item">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-yellow-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">28</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Terlambat</p>
            <div class="mt-2">
                <div class="progress-bar">
                    <div class="progress-fill progress-yellow" style="width: 6%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">6.2%</p>
            </div>
        </div>

        <div class="summary-item">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-red-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">24</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Tidak Hadir</p>
            <div class="mt-2">
                <div class="progress-bar">
                    <div class="progress-fill progress-red" style="width: 5%"></div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">5.3%</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Attendance Chart -->
        <div class="report-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Grafik Kehadiran</h2>
                <select class="px-3 py-1 border border-gray-300 dark:border-gray-600 rounded-lg text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option>7 Hari Terakhir</option>
                    <option>30 Hari Terakhir</option>
                    <option>3 Bulan Terakhir</option>
                </select>
            </div>
            <div class="chart-container">
                <div class="text-center">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Grafik kehadiran akan ditampilkan di sini</p>
                </div>
            </div>
        </div>

        <!-- Time Distribution -->
        <div class="report-card p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Distribusi Waktu Kedatangan</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-green-500 rounded mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">06:30 - 07:00</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 h-2 bg-gray-200 dark:bg-gray-600 rounded-full mr-3">
                            <div class="h-full bg-green-500 rounded-full" style="width: 75%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">298</span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-yellow-500 rounded mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">07:00 - 07:15</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 h-2 bg-gray-200 dark:bg-gray-600 rounded-full mr-3">
                            <div class="h-full bg-yellow-500 rounded-full" style="width: 25%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">100</span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-orange-500 rounded mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">07:15 - 07:30</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 h-2 bg-gray-200 dark:bg-gray-600 rounded-full mr-3">
                            <div class="h-full bg-orange-500 rounded-full" style="width: 15%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">28</span>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-4 h-4 bg-red-500 rounded mr-3"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">Setelah 07:30</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-32 h-2 bg-gray-200 dark:bg-gray-600 rounded-full mr-3">
                            <div class="h-full bg-red-500 rounded-full" style="width: 5%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">24</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Attendance Report -->
    <div class="report-card">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Laporan Kehadiran Per Kelas</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hadir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terlambat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Izin/Sakit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alpha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Persentase</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr class="class-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 1</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Wali Kelas: Dr. Rahman, M.Pd</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">36</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                32
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                2
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                1
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                1
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mr-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 89%"></div>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">89%</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="class-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 2</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Wali Kelas: Lisa Maharani, S.Pd</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">35</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                31
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                3
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                1
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                0
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mr-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 89%"></div>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">89%</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="class-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 1</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Wali Kelas: Ahmad Syahrul, S.Pd</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">34</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                29
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                3
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                2
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                0
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mr-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">85%</span>
                            </div>
                        </td>
                    </tr>

                    <tr class="class-row">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 2</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Wali Kelas: Sari Andini, S.Pd</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">33</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                28
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                2
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                2
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                1
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-2 mr-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                                <span class="text-sm text-gray-900 dark:text-white">85%</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Teacher Attendance Summary -->
    <div class="report-card p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Ringkasan Kehadiran Guru</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">45</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Guru</div>
            </div>
            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                <div class="text-2xl font-bold text-green-600 dark:text-green-400">42</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Hadir (93%)</div>
            </div>
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">2</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Izin (4%)</div>
            </div>
            <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">1</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Terlambat (2%)</div>
            </div>
        </div>
    </div>
</div>
@endsection