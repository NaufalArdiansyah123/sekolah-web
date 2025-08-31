<?php
// resources/views/admin/dashboard.blade.php
?>
<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $pageTitle }}
            </h2>
            <div class="text-sm text-gray-500">
                {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </div>
        </div>
    </x-slot>

    <style>
        :root {
            --primary-color: #1a202c;
            --secondary-color: #3182ce;
            --accent-color: #4299e1;
            --light-gray: #f7fafc;
            --dark-gray: #718096;
            --glass-bg: rgba(26, 32, 44, 0.95);
            --gradient-primary: linear-gradient(135deg, #1a202c, #3182ce);
            --gradient-light: linear-gradient(135deg, rgba(49, 130, 206, 0.1), rgba(66, 153, 225, 0.05));
        }

        /* Enhanced Stats Cards */
        .stats-card-enhanced {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.8);
            position: relative;
            height: 100%;
        }
        
        .stats-card-enhanced::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3b82f6, #10b981, #f59e0b, #8b5cf6);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .stats-card-enhanced:hover::before {
            transform: scaleX(1);
        }
        
        .stats-card-enhanced:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 60px rgba(0,0,0,0.15);
        }
        
        .stats-icon-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .stats-icon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            padding: 20px;
            border-radius: 16px;
            background: var(--gradient-light);
            display: inline-block;
        }
        
        .stats-card-enhanced:hover .stats-icon {
            transform: scale(1.15) rotate(5deg);
        }
        
        .stats-number {
            font-family: 'Arial', monospace;
            font-weight: 900 !important;
            letter-spacing: -2px;
            line-height: 1;
            transition: all 0.3s ease;
            font-size: 2.5rem !important;
        }
        
        .stats-label {
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            color: var(--dark-gray);
        }
        
        .stats-percentage {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 20px;
            font-weight: 600;
            margin-top: 10px;
            display: inline-block;
        }

        /* Enhanced Chart Cards */
        .chart-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.8);
        }
        
        .chart-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }
        
        .chart-card .card-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            background: linear-gradient(135deg, rgba(49, 130, 206, 0.02), rgba(66, 153, 225, 0.01));
        }

        /* Enhanced Activity Cards */
        .activity-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.8);
        }
        
        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0,0,0,0.12);
        }
        
        .activity-item {
            padding: 1rem;
            border-radius: 12px;
            background: rgba(249, 250, 251, 0.5);
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.02);
        }
        
        .activity-item:hover {
            background: rgba(249, 250, 251, 0.8);
            transform: translateX(5px);
        }
        
        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.9rem;
            margin-right: 1rem;
            position: relative;
            overflow: hidden;
        }
        
        .user-avatar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.3) 50%, transparent 70%);
            transform: translateX(-100%);
            transition: transform 0.6s ease;
        }
        
        .activity-item:hover .user-avatar::before {
            transform: translateX(100%);
        }

        /* Enhanced Quick Actions */
        .quick-action-btn {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid rgba(0,0,0,0.05);
            text-decoration: none;
            color: inherit;
            display: block;
            position: relative;
            overflow: hidden;
        }
        
        .quick-action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }
        
        .quick-action-btn:hover::before {
            left: 100%;
        }
        
        .quick-action-btn:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 40px rgba(0,0,0,0.1);
            border-color: rgba(0,0,0,0.1);
            color: inherit;
            text-decoration: none;
        }
        
        .quick-action-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.5rem;
            color: white;
            transition: all 0.3s ease;
        }
        
        .quick-action-btn:hover .quick-action-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Enhanced Events/Upcoming Section */
        .event-item {
            background: rgba(249, 250, 251, 0.7);
            border-radius: 12px;
            padding: 1.2rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
            position: relative;
        }
        
        .event-item:hover {
            background: rgba(249, 250, 251, 1);
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }
        
        .event-academic { border-left-color: #3b82f6; }
        .event-general { border-left-color: #10b981; }
        .event-meeting { border-left-color: #f59e0b; }
        
        .event-tag {
            font-size: 0.7rem;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Counter Animation */
        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .stats-number.counting {
            animation: countUp 0.6s ease-out;
        }

        /* Fade in animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }
        
        .fade-in-up:nth-child(2) { animation-delay: 0.1s; }
        .fade-in-up:nth-child(3) { animation-delay: 0.2s; }
        .fade-in-up:nth-child(4) { animation-delay: 0.3s; }
        .fade-in-up:nth-child(5) { animation-delay: 0.4s; }
        
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .stats-card-enhanced {
                margin-bottom: 1.5rem;
            }
            
            .quick-action-btn {
                margin-bottom: 1rem;
            }
        }
    </style>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Enhanced Stats Cards with Animation -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Siswa -->
                <div class="stats-card-enhanced fade-in-up">
                    <div class="p-6 text-center">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-gradient-to-r from-blue-500 to-blue-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="stats-number text-blue-600 mb-2" data-target="1247">0</h2>
                        <p class="stats-label mb-3">TOTAL SISWA</p>
                        <span class="stats-percentage bg-blue-100 text-blue-800">+2.5%</span>
                    </div>
                </div>

                <!-- Total Guru -->
                <div class="stats-card-enhanced fade-in-up">
                    <div class="p-6 text-center">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-gradient-to-r from-green-500 to-green-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="stats-number text-green-600 mb-2" data-target="67">0</h2>
                        <p class="stats-label mb-3">TOTAL GURU</p>
                        <span class="stats-percentage bg-green-100 text-green-800">+1.2%</span>
                    </div>
                </div>

                <!-- Total Kelas -->
                <div class="stats-card-enhanced fade-in-up">
                    <div class="p-6 text-center">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-gradient-to-r from-amber-500 to-amber-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="stats-number text-amber-600 mb-2" data-target="36">0</h2>
                        <p class="stats-label mb-3">TOTAL KELAS</p>
                        <span class="stats-percentage bg-amber-100 text-amber-800">+5.7%</span>
                    </div>
                </div>

                <!-- Total Posts -->
                <div class="stats-card-enhanced fade-in-up">
                    <div class="p-6 text-center">
                        <div class="stats-icon-wrapper">
                            <div class="stats-icon bg-gradient-to-r from-purple-500 to-purple-600">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                        </div>
                        <h2 class="stats-number text-purple-600 mb-2" data-target="156">0</h2>
                        <p class="stats-label mb-3">TOTAL POSTS</p>
                        <span class="stats-percentage bg-purple-100 text-purple-800">+12.3%</span>
                    </div>
                </div>
            </div>

            <!-- Charts & Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Student Distribution Chart -->
                <div class="lg:col-span-2 chart-card">
                    <div class="card-header">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-chart-bar text-blue-500 mr-3"></i>Distribusi Siswa per Kelas
                        </h3>
                        <p class="text-gray-600 text-sm">Analisis sebaran siswa berdasarkan tingkat kelas</p>
                    </div>
                    <div class="p-6">
                        <canvas id="studentChart" height="280"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="activity-card">
                    <div class="card-header">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-clock text-green-500 mr-3"></i>Aktivitas Terbaru
                        </h3>
                        <p class="text-gray-600 text-sm">Update terkini dari sistem</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="activity-item">
                                <div class="flex items-start">
                                    <div class="user-avatar bg-blue-100 text-blue-600">
                                        JD
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">John Doe</p>
                                        <p class="text-gray-600 text-sm">Menambahkan pengumuman baru</p>
                                        <p class="text-gray-400 text-xs mt-1">2 menit lalu</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="activity-item">
                                <div class="flex items-start">
                                    <div class="user-avatar bg-green-100 text-green-600">
                                        JS
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">Jane Smith</p>
                                        <p class="text-gray-600 text-sm">Mengupload materi Matematika</p>
                                        <p class="text-gray-400 text-xs mt-1">15 menit lalu</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="activity-item">
                                <div class="flex items-start">
                                    <div class="user-avatar bg-purple-100 text-purple-600">
                                        A
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">Admin</p>
                                        <p class="text-gray-600 text-sm">Memperbarui data siswa</p>
                                        <p class="text-gray-400 text-xs mt-1">1 jam lalu</p>
                                    </div>
                                </div>
                            </div>

                            <div class="activity-item">
                                <div class="flex items-start">
                                    <div class="user-avatar bg-amber-100 text-amber-600">
                                        RS
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-900 text-sm">Robert Smith</p>
                                        <p class="text-gray-600 text-sm">Mengirim pesan kepada orang tua</p>
                                        <p class="text-gray-400 text-xs mt-1">3 jam lalu</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="#" class="w-full text-center py-3 px-4 bg-gray-50 text-gray-700 rounded-lg hover:bg-gray-100 transition-colors duration-300 text-sm font-medium">
                                <i class="fas fa-eye mr-2"></i>Lihat Semua Aktivitas
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Additional Info Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Upcoming Events -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-calendar-alt text-indigo-500 mr-3"></i>Acara Mendatang
                        </h3>
                        <p class="text-gray-600 text-sm">Jadwal kegiatan dan acara penting</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="event-item event-academic">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800 mb-1">Ujian Tengah Semester</p>
                                        <p class="text-sm text-gray-600">15 Okt 2023 - 20 Okt 2023</p>
                                    </div>
                                    <span class="event-tag bg-blue-100 text-blue-800">Academic</span>
                                </div>
                            </div>
                            
                            <div class="event-item event-general">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800 mb-1">Seminar Pendidikan</p>
                                        <p class="text-sm text-gray-600">25 Okt 2023, 09:00 WIB</p>
                                    </div>
                                    <span class="event-tag bg-green-100 text-green-800">Event</span>
                                </div>
                            </div>
                            
                            <div class="event-item event-meeting">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-800 mb-1">Rapat Orang Tua</p>
                                        <p class="text-sm text-gray-600">5 Nov 2023, 13:00 WIB</p>
                                    </div>
                                    <span class="event-tag bg-amber-100 text-amber-800">Meeting</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="#" class="w-full text-center py-3 px-4 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition-colors duration-300 text-sm font-medium">
                                <i class="fas fa-calendar-plus mr-2"></i>Kelola Acara
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Quick Actions -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-bolt text-yellow-500 mr-3"></i>Aksi Cepat
                        </h3>
                        <p class="text-gray-600 text-sm">Shortcut untuk tugas administrasi umum</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="quick-action-btn">
                                <div class="quick-action-icon bg-gradient-to-r from-blue-500 to-blue-600">
                                    <i class="fas fa-user-plus"></i>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">Tambah Siswa</p>
                            </a>
                            
                            <a href="#" class="quick-action-btn">
                                <div class="quick-action-icon bg-gradient-to-r from-green-500 to-green-600">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">Buat Laporan</p>
                            </a>
                            
                            <a href="#" class="quick-action-btn">
                                <div class="quick-action-icon bg-gradient-to-r from-amber-500 to-amber-600">
                                    <i class="fas fa-bell"></i>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">Pengumuman</p>
                            </a>
                            
                            <a href="#" class="quick-action-btn">
                                <div class="quick-action-icon bg-gradient-to-r from-purple-500 to-purple-600">
                                    <i class="fas fa-cog"></i>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">Pengaturan</p>
                            </a>
                        </div>
                        
                        <!-- Additional Quick Actions -->
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <div class="grid grid-cols-1 gap-3">
                                <a href="#" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-chart-line text-white text-sm"></i>
                                        </div>
                                        <span class="font-medium text-gray-700">Analytics</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                </a>
                                
                                <a href="#" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-envelope text-white text-sm"></i>
                                        </div>
                                        <span class="font-medium text-gray-700">Kirim Pesan</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                </a>
                                
                                <a href="#" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-300">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-database text-white text-sm"></i>
                                        </div>
                                        <span class="font-medium text-gray-700">Backup Data</span>
                                    </div>
                                    <i class="fas fa-arrow-right text-gray-400"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Dashboard Sections -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- System Performance -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-server text-red-500 mr-3"></i>Performa Sistem
                        </h3>
                        <p class="text-gray-600 text-sm">Status kesehatan dan performa aplikasi</p>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg border border-green-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Server Status</p>
                                        <p class="text-sm text-gray-600">Online - 99.9% Uptime</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">AKTIF</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-database text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Database</p>
                                        <p class="text-sm text-gray-600">Response Time: 45ms</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">OPTIMAL</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-4 bg-amber-50 rounded-lg border border-amber-200">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-hdd text-white"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Storage</p>
                                        <p class="text-sm text-gray-600">Used: 64% (3.2GB/5GB)</p>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">NORMAL</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Users & Analytics -->
                <div class="chart-card">
                    <div class="card-header">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            <i class="fas fa-users-cog text-blue-500 mr-3"></i>Manajemen Pengguna
                        </h3>
                        <p class="text-gray-600 text-sm">Overview pengguna dan aktivitas login</p>
                    </div>
                    <div class="p-6">
                        <!-- User Stats Mini Cards -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600 mb-1" data-target="45">0</div>
                                <div class="text-xs text-blue-700 font-medium">Online Hari Ini</div>
                            </div>
                            <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-green-600 mb-1" data-target="128">0</div>
                                <div class="text-xs text-green-700 font-medium">Login Minggu Ini</div>
                            </div>
                        </div>
                        
                        <!-- Recent Login Activity -->
                        <div class="space-y-3">
                            <h5 class="font-semibold text-gray-800 text-sm mb-3">Login Terbaru:</h5>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-semibold">AD</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Admin User</p>
                                    <p class="text-xs text-gray-500">5 menit lalu</p>
                                </div>
                                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-semibold">GU</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Guru User</p>
                                    <p class="text-xs text-gray-500">12 menit lalu</p>
                                </div>
                                <span class="w-2 h-2 bg-green-400 rounded-full"></span>
                            </div>
                            
                            <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3">
                                    <span class="text-white text-xs font-semibold">ST</span>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-800">Siswa User</p>
                                    <p class="text-xs text-gray-500">25 menit lalu</p>
                                </div>
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <a href="#" class="w-full text-center py-3 px-4 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors duration-300 text-sm font-medium">
                                <i class="fas fa-users mr-2"></i>Kelola Pengguna
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Counter Animation Function
            function animateCounter(element, target, duration = 2000) {
                const start = 0;
                const increment = target / (duration / 16);
                let current = start;
                
                element.classList.add('counting');
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    
                    // Format number with comma separator for thousands
                    const displayValue = Math.floor(current).toLocaleString();
                    element.textContent = displayValue;
                }, 16);
            }
            
            // Intersection Observer for stats counter animation
            const statsObserverOptions = {
                threshold: 0.3,
                rootMargin: '0px 0px -50px 0px'
            };
            
            const statsObserver = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const statsNumbers = document.querySelectorAll('.stats-number');
                        
                        statsNumbers.forEach((numberElement, index) => {
                            const target = parseInt(numberElement.dataset.target);
                            
                            // Stagger the animation start times
                            setTimeout(() => {
                                animateCounter(numberElement, target, 1500);
                            }, index * 150);
                        });
                        
                        // Only animate once
                        statsObserver.disconnect();
                    }
                });
            }, statsObserverOptions);
            
            // Start observing stats cards
            const firstStatsCard = document.querySelector('.stats-card-enhanced');
            if (firstStatsCard) {
                statsObserver.observe(firstStatsCard);
            }

            // Student Distribution Chart with Enhanced Styling
            const studentCtx = document.getElementById('studentChart').getContext('2d');
            const studentChart = new Chart(studentCtx, {
                type: 'bar',
                data: {
                    labels: ['Kelas 10', 'Kelas 11', 'Kelas 12'],
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: [450, 420, 377],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)',
                            'rgba(16, 185, 129, 0.8)',
                            'rgba(245, 158, 11, 0.8)'
                        ],
                        borderColor: [
                            'rgb(59, 130, 246)',
                            'rgb(16, 185, 129)',
                            'rgb(245, 158, 11)'
                        ],
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label;
                                },
                                label: function(context) {
                                    return `Siswa: ${context.parsed.y} orang`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    weight: '600'
                                },
                                color: '#6b7280'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            },
                            ticks: {
                                font: {
                                    weight: '500'
                                },
                                color: '#6b7280'
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            });
            
            // Enhanced hover effects for activity items
            const activityItems = document.querySelectorAll('.activity-item');
            activityItems.forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateX(8px) scale(1.02)';
                    this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.1)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateX(0) scale(1)';
                    this.style.boxShadow = 'none';
                });
            });
            
            // Enhanced quick action button effects
            const quickActionBtns = document.querySelectorAll('.quick-action-btn');
            quickActionBtns.forEach(btn => {
                btn.addEventListener('click', function(e) {
                    // Create ripple effect
                    const ripple = document.createElement('div');
                    const rect = this.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;
                    
                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(59, 130, 246, 0.3);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                        z-index: 1;
                    `;
                    
                    this.appendChild(ripple);
                    
                    setTimeout(() => {
                        ripple.remove();
                    }, 600);
                });
            });
            
            // Add ripple animation CSS
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
            
            // Smooth animations for page load
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationDelay = entry.target.dataset.delay || '0s';
                        entry.target.classList.add('fade-in-up');
                        observer.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            });
            
            // Observe elements for animation
            document.querySelectorAll('.chart-card, .activity-card').forEach((el, index) => {
                el.dataset.delay = (index * 0.1) + 's';
                observer.observe(el);
            });
            
            // Real-time clock update
            function updateClock() {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit'
                });
                
                // You can add a live clock element if needed
                // document.getElementById('live-clock').textContent = timeString;
            }
            
            // Update clock every second
            setInterval(updateClock, 1000);
            updateClock(); // Initial call
            
            // Add loading states to links
            document.querySelectorAll('a[href]:not([href="#"])').forEach(link => {
                link.addEventListener('click', function() {
                    const icon = this.querySelector('i');
                    if (icon && !icon.classList.contains('fa-spinner')) {
                        const originalClass = icon.className;
                        icon.className = 'fas fa-spinner fa-spin';
                        
                        // Reset after 2 seconds (in case page doesn't navigate)
                        setTimeout(() => {
                            icon.className = originalClass;
                        }, 2000);
                    }
                });
            });
            
            // Enhanced chart responsiveness
            window.addEventListener('resize', function() {
                if (studentChart) {
                    studentChart.resize();
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>