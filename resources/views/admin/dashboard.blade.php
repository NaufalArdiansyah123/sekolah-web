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

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
                <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-400 rounded-lg flex items-center justify-center bg-opacity-25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-blue-100 truncate">Total Siswa</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-semibold">1,247</p>
                                    <span class="ml-2 text-sm font-medium bg-blue-400 bg-opacity-25 px-2 py-1 rounded-full">+2.5%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-500 to-green-600 text-white overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-400 rounded-lg flex items-center justify-center bg-opacity-25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-green-100 truncate">Total Guru</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-semibold">67</p>
                                    <span class="ml-2 text-sm font-medium bg-green-400 bg-opacity-25 px-2 py-1 rounded-full">+1.2%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-amber-400 rounded-lg flex items-center justify-center bg-opacity-25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-amber-100 truncate">Total Kelas</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-semibold">36</p>
                                    <span class="ml-2 text-sm font-medium bg-amber-400 bg-opacity-25 px-2 py-1 rounded-full">+5.7%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white overflow-hidden rounded-xl shadow-lg transition-transform duration-300 hover:scale-105">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-purple-400 rounded-lg flex items-center justify-center bg-opacity-25">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-purple-100 truncate">Total Posts</p>
                                <div class="flex items-baseline">
                                    <p class="text-2xl font-semibold">156</p>
                                    <span class="ml-2 text-sm font-medium bg-purple-400 bg-opacity-25 px-2 py-1 rounded-full">+12.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Activity Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Student Distribution Chart -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Distribusi Siswa per Kelas</h3>
                    </div>
                    <div class="p-6">
                        <canvas id="studentChart" height="300"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Aktivitas Terbaru</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold">JD</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">John Doe</p>
                                    <p class="text-sm text-gray-500">Menambahkan pengumuman baru</p>
                                    <p class="text-xs text-gray-400 mt-1">2 menit lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                        <span class="text-green-600 font-semibold">JS</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Jane Smith</p>
                                    <p class="text-sm text-gray-500">Mengupload materi Matematika</p>
                                    <p class="text-xs text-gray-400 mt-1">15 menit lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                        <span class="text-purple-600 font-semibold">A</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Admin</p>
                                    <p class="text-sm text-gray-500">Memperbarui data siswa</p>
                                    <p class="text-xs text-gray-400 mt-1">1 jam lalu</p>
                                </div>
                            </div>

                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                                        <span class="text-amber-600 font-semibold">RS</span>
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">Robert Smith</p>
                                    <p class="text-sm text-gray-500">Mengirim pesan kepada orang tua</p>
                                    <p class="text-xs text-gray-400 mt-1">3 jam lalu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Upcoming Events -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Acara Mendatang</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Ujian Tengah Semester</p>
                                    <p class="text-sm text-gray-500">15 Okt 2023 - 20 Okt 2023</p>
                                </div>
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">Academic</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Seminar Pendidikan</p>
                                    <p class="text-sm text-gray-500">25 Okt 2023, 09:00 WIB</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Event</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-amber-50 rounded-lg">
                                <div>
                                    <p class="font-medium text-gray-800">Rapat Orang Tua</p>
                                    <p class="text-sm text-gray-500">5 Nov 2023, 13:00 WIB</p>
                                </div>
                                <span class="px-3 py-1 bg-amber-100 text-amber-800 text-xs font-medium rounded-full">Meeting</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-semibold text-gray-800">Aksi Cepat</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <a href="#" class="p-4 bg-blue-50 rounded-lg text-center transition-colors duration-300 hover:bg-blue-100">
                                <div class="mx-auto w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Tambah Siswa</p>
                            </a>
                            <a href="#" class="p-4 bg-green-50 rounded-lg text-center transition-colors duration-300 hover:bg-green-100">
                                <div class="mx-auto w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Buat Laporan</p>
                            </a>
                            <a href="#" class="p-4 bg-amber-50 rounded-lg text-center transition-colors duration-300 hover:bg-amber-100">
                                <div class="mx-auto w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Pengumuman</p>
                            </a>
                            <a href="#" class="p-4 bg-purple-50 rounded-lg text-center transition-colors duration-300 hover:bg-purple-100">
                                <div class="mx-auto w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mb-2">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-700">Pengaturan</p>
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
            // Student Distribution Chart
            const studentCtx = document.getElementById('studentChart').getContext('2d');
            const studentChart = new Chart(studentCtx, {
                type: 'bar',
                data: {
                    labels: ['Kelas 10', 'Kelas 11', 'Kelas 12'],
                    datasets: [{
                        label: 'Jumlah Siswa',
                        data: [450, 420, 377],
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: [
                            'rgb(54, 162, 235)',
                            'rgb(75, 192, 192)',
                            'rgb(255, 159, 64)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-admin-layout>