{{-- resources/views/student/dashboard.blade.php --}}
@extends('layouts.student')

@section('title', $pageTitle)

@section('content')
<div class="space-y-6">
    
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-emerald-100 dark:text-emerald-200">Akses materi pembelajaran dan download file yang Anda butuhkan</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-emerald-200 dark:text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14v6.5"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


        <!-- Attendance Percentage -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kehadiran</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['attendance_percentage'] }}%</p>
                </div>
            </div>
        </div>

        <!-- Total Notifications -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-indigo-100 dark:bg-indigo-900/50">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h6v-6H4v6zM16 3h5v5h-5V3zM4 3h6v6H4V3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Notifikasi</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_notifications'] ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Completion -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-teal-100 dark:bg-teal-900/50">
                    <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Profil Lengkap</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['profile_completion'] ?? 85 }}%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Quick Access to Materials -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Akses Cepat</h3>
            <div class="space-y-3">

                
                <a href="{{ route('student.attendance.index') }}" 
                   class="flex items-center p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-purple-700 dark:text-purple-300 font-medium">Absensi</span>
                </a>
                

            </div>
        </div>

        <!-- Attendance Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan Kehadiran</h3>
                <a href="{{ route('student.attendance.index') }}" class="text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 text-sm font-medium transition-colors duration-200">
                    Lihat Detail
                </a>
            </div>
            
            <div class="text-center py-8">
                <div class="p-4 rounded-lg bg-purple-100 dark:bg-purple-900/50 inline-block mb-4">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ $stats['attendance_percentage'] }}%</p>
                <p class="text-gray-500 dark:text-gray-400">Tingkat Kehadiran Anda</p>
            </div>
        </div>

        <!-- Grades Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Ringkasan Nilai</h3>
                <a href="{{ route('student.grades.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
            
            <div class="text-center py-8">
                <div class="p-4 rounded-lg bg-blue-100 dark:bg-blue-900/50 inline-block mb-4">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Lihat nilai terbaru Anda</p>
                <p class="text-gray-500 dark:text-gray-400">Pantau perkembangan akademik</p>
            </div>
        </div>

        <!-- Profile Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Profil Saya</h3>
                <a href="{{ route('student.profile') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium transition-colors duration-200">
                    Edit Profil
                </a>
            </div>
            
            <div class="text-center py-8">
                <div class="p-4 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 inline-block mb-4">
                    <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ auth()->user()->name }}</p>
                <p class="text-gray-500 dark:text-gray-400">Kelola informasi profil Anda</p>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6 border border-blue-200 dark:border-blue-800">
        <div class="flex items-start">
            <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50 mr-4">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Cara Menggunakan Dashboard</h3>
                <ul class="text-blue-800 dark:text-blue-200 space-y-1 text-sm">
                    <li>• Gunakan menu "Absensi" untuk melihat riwayat kehadiran Anda</li>
                    <li>• Klik "Nilai" untuk melihat perkembangan akademik</li>
                    <li>• Periksa notifikasi secara berkala untuk informasi terbaru</li>
                    <li>• Lengkapi profil Anda untuk mendapatkan layanan yang optimal</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection