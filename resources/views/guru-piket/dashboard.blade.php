@extends('layouts.guru-piket')

@section('title', $pageTitle)

@push('styles')
<style>
    .dashboard-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .stat-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.8));
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-2px) scale(1.02);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }
    
    .dark .stat-card {
        background: linear-gradient(135deg, rgba(31, 41, 55, 0.9), rgba(31, 41, 55, 0.8));
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .floating-animation {
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .pulse-animation {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .glass-effect {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .dark .glass-effect {
        background: rgba(31, 41, 55, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>
@endpush

@section('content')
<div class="space-y-8">
    
    <!-- Enhanced Welcome Section -->
    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-3xl p-8 text-gray-900 dark:text-white shadow-2xl border border-gray-200 dark:border-gray-700">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, white 2px, transparent 2px), radial-gradient(circle at 75% 75%, white 2px, transparent 2px); background-size: 50px 50px;"></div>
        </div>
        
        <!-- Floating Elements -->
        <div class="absolute top-4 right-4 floating-animation">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
        
        <div class="relative z-10">
            <div class="flex items-center mb-4">
                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mr-4">
                    <svg class="w-8 h-8 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-gray-600 dark:text-gray-400 text-lg">Kelola absensi siswa dan guru dengan mudah dan efisien</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Hari Ini</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $todayAttendance['total_scanned'] }} Absen</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Terlambat</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $todayAttendance['terlambat'] }} Siswa</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-4 border border-gray-200 dark:border-gray-600">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Alpha</p>
                            <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $todayAttendance['alpha'] }} Siswa</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Students -->
        <div class="stat-card rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="p-3 rounded-xl bg-gray-800 dark:bg-white shadow-lg">
                            <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Siswa</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCounts['total_students'] }}</p>
                </div>
                <div class="text-gray-300 dark:text-gray-600 opacity-20">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Teachers -->
        <div class="stat-card rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="p-3 rounded-xl bg-gray-800 dark:bg-white shadow-lg">
                            <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Guru</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCounts['total_teachers'] }}</p>
                </div>
                <div class="text-gray-300 dark:text-gray-600 opacity-20">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Classes -->
        <div class="stat-card rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="p-3 rounded-xl bg-gray-800 dark:bg-white shadow-lg">
                            <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Total Kelas</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCounts['total_classes'] }}</p>
                </div>
                <div class="text-gray-300 dark:text-gray-600 opacity-20">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Active Sessions -->
        <div class="stat-card rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center mb-2">
                        <div class="p-3 rounded-xl bg-gray-800 dark:bg-white shadow-lg pulse-animation">
                            <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Sesi Aktif</p>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalCounts['active_sessions'] }}</p>
                </div>
                <div class="text-gray-300 dark:text-gray-600 opacity-20">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Today's Attendance Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Attendance Statistics -->
        <div class="dashboard-card rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    Statistik Absensi Hari Ini
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Ringkasan kehadiran siswa hari ini</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-800">
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="text-center p-4 bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-2xl border border-green-200 dark:border-green-700">
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1">{{ $todayAttendance['hadir'] }}</div>
                        <div class="text-sm font-medium text-green-700 dark:text-green-300">Hadir</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-2xl border border-yellow-200 dark:border-yellow-700">
                        <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-1">{{ $todayAttendance['terlambat'] }}</div>
                        <div class="text-sm font-medium text-yellow-700 dark:text-yellow-300">Terlambat</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-2xl border border-blue-200 dark:border-blue-700">
                        <div class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1">{{ $todayAttendance['izin'] + $todayAttendance['sakit'] }}</div>
                        <div class="text-sm font-medium text-blue-700 dark:text-blue-300">Izin/Sakit</div>
                    </div>
                    <div class="text-center p-4 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-2xl border border-red-200 dark:border-red-700">
                        <div class="text-3xl font-bold text-red-600 dark:text-red-400 mb-1">{{ $todayAttendance['alpha'] }}</div>
                        <div class="text-sm font-medium text-red-700 dark:text-red-300">Alpha</div>
                    </div>
                </div>
                
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-600 rounded-2xl p-4 text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $todayAttendance['total_scanned'] }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-300">Total Siswa Absen</div>
                </div>
            </div>
        </div>

        <!-- Enhanced Quick Actions -->
        <div class="dashboard-card rounded-3xl shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white flex items-center">
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    Aksi Cepat
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Akses fitur utama dengan cepat</p>
            </div>
            <div class="p-6 bg-white dark:bg-gray-800 space-y-4">
                <a href="{{ route('guru-piket.attendance.qr-scanner') }}" 
                   class="group w-full bg-gray-900 dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-100 text-white dark:text-gray-900 px-6 py-4 rounded-2xl transition-all duration-300 flex items-center justify-between shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white dark:bg-gray-900 bg-opacity-20 dark:bg-opacity-20 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-white dark:text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-lg">QR Scanner Absensi</div>
                            <div class="text-gray-300 dark:text-gray-600 text-sm">Scan QR code siswa</div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <a href="{{ route('guru-piket.attendance.students') }}" 
                   class="group w-full bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-6 py-4 rounded-2xl transition-all duration-300 flex items-center justify-between shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-lg">Kelola Absensi Siswa</div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm">Manajemen absensi manual</div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <a href="{{ route('guru-piket.attendance.teachers') }}" 
                   class="group w-full bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-6 py-4 rounded-2xl transition-all duration-300 flex items-center justify-between shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-lg">Kelola Absensi Guru</div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm">Monitor kehadiran guru</div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                
                <a href="{{ route('guru-piket.reports.daily') }}" 
                   class="group w-full bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-6 py-4 rounded-2xl transition-all duration-300 flex items-center justify-between shadow-lg hover:shadow-2xl transform hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 dark:bg-gray-800 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="font-semibold text-lg">Laporan Harian</div>
                            <div class="text-gray-600 dark:text-gray-400 text-sm">Lihat laporan kehadiran</div>
                        </div>
                    </div>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Class Attendance Summary -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                Ringkasan Absensi Per Kelas
            </h3>
        </div>
        <div class="p-6">
            @if(count($classAttendanceSummary) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($classAttendanceSummary as $class)
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $class['class_name'] }}</h4>
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($class['attendance_rate'] >= 90) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($class['attendance_rate'] >= 75) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ $class['attendance_rate'] }}%
                                </span>
                            </div>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Total Siswa:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">{{ $class['total_students'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Hadir:</span>
                                    <span class="font-medium text-green-600 dark:text-green-400">{{ $class['total_present'] }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tidak Hadir:</span>
                                    <span class="font-medium text-red-600 dark:text-red-400">{{ $class['total_absent'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <p>Belum ada data absensi kelas hari ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Aktivitas Absensi Terbaru
            </h3>
        </div>
        <div class="p-6">
            @if(count($recentActivities) > 0)
                <div class="space-y-4">
                    @foreach($recentActivities as $activity)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 rounded-lg 
                                    @if($activity['status'] == 'hadir') bg-green-100 dark:bg-green-900/50
                                    @elseif($activity['status'] == 'terlambat') bg-yellow-100 dark:bg-yellow-900/50
                                    @elseif($activity['status'] == 'izin' || $activity['status'] == 'sakit') bg-blue-100 dark:bg-blue-900/50
                                    @else bg-red-100 dark:bg-red-900/50
                                    @endif">
                                    <svg class="w-4 h-4 
                                        @if($activity['status'] == 'hadir') text-green-600 dark:text-green-400
                                        @elseif($activity['status'] == 'terlambat') text-yellow-600 dark:text-yellow-400
                                        @elseif($activity['status'] == 'izin' || $activity['status'] == 'sakit') text-blue-600 dark:text-blue-400
                                        @else text-red-600 dark:text-red-400
                                        @endif" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $activity['student_name'] }}</p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $activity['class_name'] }} • NIS: {{ $activity['student_nis'] }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    @if($activity['status'] == 'hadir') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                    @elseif($activity['status'] == 'terlambat') bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                    @elseif($activity['status'] == 'izin' || $activity['status'] == 'sakit') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                    @else bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                    @endif">
                                    {{ ucfirst($activity['status']) }}
                                </span>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ $activity['scan_time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Belum ada aktivitas absensi hari ini</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Help Section -->
    <div class="bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/20 dark:to-orange-900/20 rounded-xl p-6 border border-amber-200 dark:border-amber-800">
        <div class="flex items-start">
            <div class="p-3 rounded-lg bg-amber-100 dark:bg-amber-900/50 mr-4">
                <svg class="w-6 h-6 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-amber-900 dark:text-amber-100 mb-2">Panduan Guru Piket</h3>
                <ul class="text-amber-800 dark:text-amber-200 space-y-1 text-sm">
                    <li>• Gunakan QR Scanner untuk mencatat absensi siswa secara cepat</li>
                    <li>• Monitor absensi guru dan pastikan semua hadir tepat waktu</li>
                    <li>• Periksa laporan harian untuk memantau tingkat kehadiran</li>
                    <li>• Export data absensi untuk keperluan administrasi</li>
                    <li>• Hubungi admin jika ada masalah teknis dengan sistem</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection