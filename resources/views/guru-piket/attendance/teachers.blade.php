@extends('layouts.guru-piket')

@section('title', 'Absensi Guru')

@push('styles')
<style>
    .teacher-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .dark .teacher-card {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .teacher-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    
    .status-hadir {
        background: #10b981;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
    }
    
    .status-terlambat {
        background: #f59e0b;
        box-shadow: 0 0 8px rgba(245, 158, 11, 0.5);
    }
    
    .status-izin {
        background: #3b82f6;
        box-shadow: 0 0 8px rgba(59, 130, 246, 0.5);
    }
    
    .status-alpha {
        background: #ef4444;
        box-shadow: 0 0 8px rgba(239, 68, 68, 0.5);
    }
    
    .status-belum {
        background: #6b7280;
        box-shadow: 0 0 8px rgba(107, 114, 128, 0.5);
    }
    
    .schedule-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .dark .schedule-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .time-badge {
        background: #1f2937;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .dark .time-badge {
        background: white;
        color: #1f2937;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Absensi Guru</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Monitor kehadiran dan jadwal mengajar guru</p>
            </div>
            <div class="flex items-center space-x-3">
                <div class="bg-blue-100 dark:bg-blue-900/20 px-3 py-1 rounded-full">
                    <span class="text-blue-800 dark:text-blue-200 text-sm font-medium">{{ date('d M Y') }}</span>
                </div>
                <button class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-gray-800 dark:bg-white">
                    <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Guru</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">45</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Hadir</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">42</p>
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
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">1</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-blue-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Izin</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">2</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-red-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Alpha</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Teachers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Teacher Card 1 -->
        <div class="teacher-card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 font-medium">DR</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Dr. Rahman, M.Pd</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Matematika</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="status-indicator status-hadir"></span>
                    <span class="text-sm font-medium text-green-600 dark:text-green-400">Hadir</span>
                </div>
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Waktu Masuk:</span>
                    <span class="font-medium text-gray-900 dark:text-white">06:45</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Jam Mengajar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">6 Jam</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Jadwal Hari Ini:</h4>
                <div class="space-y-2">
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 1</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Matematika</p>
                            </div>
                            <span class="time-badge">07:00-08:30</span>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 2</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Matematika</p>
                            </div>
                            <span class="time-badge">08:30-10:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Card 2 -->
        <div class="teacher-card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 font-medium">SA</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Sari Andini, S.Pd</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Bahasa Indonesia</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="status-indicator status-terlambat"></span>
                    <span class="text-sm font-medium text-yellow-600 dark:text-yellow-400">Terlambat</span>
                </div>
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Waktu Masuk:</span>
                    <span class="font-medium text-gray-900 dark:text-white">07:15</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Jam Mengajar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">5 Jam</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Jadwal Hari Ini:</h4>
                <div class="space-y-2">
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 1</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Bahasa Indonesia</p>
                            </div>
                            <span class="time-badge">08:30-10:00</span>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 2</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Bahasa Indonesia</p>
                            </div>
                            <span class="time-badge">10:15-11:45</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Card 3 -->
        <div class="teacher-card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 font-medium">BP</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Budi Prasetyo, S.Si</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Fisika</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="status-indicator status-izin"></span>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Izin</span>
                </div>
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Keterangan:</span>
                    <span class="font-medium text-gray-900 dark:text-white">Sakit</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Jam Mengajar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">4 Jam</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Jadwal Hari Ini:</h4>
                <div class="space-y-2">
                    <div class="schedule-item opacity-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 1</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Fisika (Diganti)</p>
                            </div>
                            <span class="time-badge">10:15-11:45</span>
                        </div>
                    </div>
                    <div class="schedule-item opacity-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 2</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Fisika (Diganti)</p>
                            </div>
                            <span class="time-badge">13:00-14:30</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Card 4 -->
        <div class="teacher-card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 font-medium">LM</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Lisa Maharani, S.Pd</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Bahasa Inggris</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="status-indicator status-hadir"></span>
                    <span class="text-sm font-medium text-green-600 dark:text-green-400">Hadir</span>
                </div>
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Waktu Masuk:</span>
                    <span class="font-medium text-gray-900 dark:text-white">06:50</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Jam Mengajar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">5 Jam</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Jadwal Hari Ini:</h4>
                <div class="space-y-2">
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 1</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Bahasa Inggris</p>
                            </div>
                            <span class="time-badge">11:45-13:00</span>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 1</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Bahasa Inggris</p>
                            </div>
                            <span class="time-badge">14:30-16:00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Card 5 -->
        <div class="teacher-card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 font-medium">AS</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Ahmad Syahrul, S.Pd</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Sejarah</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="status-indicator status-hadir"></span>
                    <span class="text-sm font-medium text-green-600 dark:text-green-400">Hadir</span>
                </div>
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Waktu Masuk:</span>
                    <span class="font-medium text-gray-900 dark:text-white">06:55</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Jam Mengajar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">4 Jam</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Jadwal Hari Ini:</h4>
                <div class="space-y-2">
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 1</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Sejarah</p>
                            </div>
                            <span class="time-badge">07:00-08:30</span>
                        </div>
                    </div>
                    <div class="schedule-item">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 2</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Sejarah</p>
                            </div>
                            <span class="time-badge">13:00-14:30</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Card 6 -->
        <div class="teacher-card p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3">
                        <span class="text-gray-600 font-medium">NF</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">Nur Fadilah, S.Pd</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Biologi</p>
                    </div>
                </div>
                <div class="flex items-center">
                    <span class="status-indicator status-izin"></span>
                    <span class="text-sm font-medium text-blue-600 dark:text-blue-400">Izin</span>
                </div>
            </div>
            
            <div class="space-y-2 mb-4">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Keterangan:</span>
                    <span class="font-medium text-gray-900 dark:text-white">Dinas Luar</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Jam Mengajar:</span>
                    <span class="font-medium text-gray-900 dark:text-white">3 Jam</span>
                </div>
            </div>
            
            <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Jadwal Hari Ini:</h4>
                <div class="space-y-2">
                    <div class="schedule-item opacity-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 2</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Biologi (Diganti)</p>
                            </div>
                            <span class="time-badge">10:15-11:45</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection