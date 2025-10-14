@extends('layouts.guru-piket')

@section('title', 'Laporan Bulanan')

@push('styles')
<style>
    .monthly-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    
    .dark .monthly-card {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .trend-up {
        color: #10b981;
    }
    
    .trend-down {
        color: #ef4444;
    }
    
    .trend-neutral {
        color: #6b7280;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: #e5e7eb;
        border-radius: 0.5rem;
        overflow: hidden;
    }
    
    .dark .calendar-grid {
        background: #4b5563;
    }
    
    .calendar-day {
        background: white;
        padding: 0.75rem;
        text-align: center;
        min-height: 60px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        position: relative;
    }
    
    .dark .calendar-day {
        background: #1f2937;
    }
    
    .calendar-day.other-month {
        background: #f9fafb;
        color: #9ca3af;
    }
    
    .dark .calendar-day.other-month {
        background: #374151;
        color: #6b7280;
    }
    
    .calendar-day.today {
        background: #3b82f6;
        color: white;
    }
    
    .attendance-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-top: 2px;
    }
    
    .attendance-high {
        background: #10b981;
    }
    
    .attendance-medium {
        background: #f59e0b;
    }
    
    .attendance-low {
        background: #ef4444;
    }
    
    .metric-card {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .dark .metric-card {
        background: #374151;
        border-color: #4b5563;
    }
    
    .metric-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Laporan Bulanan</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Analisis kehadiran siswa dan guru per bulan</p>
            </div>
            <div class="flex items-center space-x-3">
                <select class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="2024-01">Januari 2024</option>
                    <option value="2024-02">Februari 2024</option>
                    <option value="2024-03">Maret 2024</option>
                    <option value="2024-04">April 2024</option>
                    <option value="2024-05">Mei 2024</option>
                    <option value="2024-06">Juni 2024</option>
                    <option value="2024-07">Juli 2024</option>
                    <option value="2024-08">Agustus 2024</option>
                    <option value="2024-09">September 2024</option>
                    <option value="2024-10">Oktober 2024</option>
                    <option value="2024-11" selected>November 2024</option>
                    <option value="2024-12">Desember 2024</option>
                </select>
                <button class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Laporan
                </button>
            </div>
        </div>
    </div>

    <!-- Monthly Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="metric-card">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-gray-800 dark:bg-white">
                    <svg class="w-8 h-8 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">22</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Hari Efektif</p>
            <div class="flex items-center justify-center mt-2">
                <svg class="w-4 h-4 trend-up mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                </svg>
                <span class="text-xs trend-up">+2 dari bulan lalu</span>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-green-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">91.2%</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Kehadiran</p>
            <div class="flex items-center justify-center mt-2">
                <svg class="w-4 h-4 trend-up mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                </svg>
                <span class="text-xs trend-up">+2.1% dari bulan lalu</span>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-yellow-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">5.8%</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Terlambat</p>
            <div class="flex items-center justify-center mt-2">
                <svg class="w-4 h-4 trend-down mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                </svg>
                <span class="text-xs trend-down">-0.5% dari bulan lalu</span>
            </div>
        </div>

        <div class="metric-card">
            <div class="flex items-center justify-center mb-3">
                <div class="p-3 rounded-xl bg-red-500">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white">3.0%</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Tidak Hadir</p>
            <div class="flex items-center justify-center mt-2">
                <svg class="w-4 h-4 trend-down mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                </svg>
                <span class="text-xs trend-down">-1.6% dari bulan lalu</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Calendar View -->
        <div class="monthly-card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Kalender Kehadiran</h2>
                <div class="flex items-center space-x-4 text-xs">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                        <span class="text-gray-600 dark:text-gray-400">>90%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                        <span class="text-gray-600 dark:text-gray-400">80-90%</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                        <span class="text-gray-600 dark:text-gray-400"><80%</span>
                    </div>
                </div>
            </div>
            
            <!-- Calendar Header -->
            <div class="calendar-grid mb-1">
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Min</div>
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Sen</div>
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Sel</div>
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Rab</div>
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Kam</div>
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Jum</div>
                <div class="calendar-day font-semibold text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-700">Sab</div>
            </div>
            
            <!-- Calendar Body -->
            <div class="calendar-grid">
                <!-- Week 1 -->
                <div class="calendar-day other-month">29</div>
                <div class="calendar-day other-month">30</div>
                <div class="calendar-day other-month">31</div>
                <div class="calendar-day">
                    <span>1</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>2</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>3</span>
                    <div class="attendance-indicator attendance-medium"></div>
                </div>
                <div class="calendar-day">
                    <span>4</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                
                <!-- Week 2 -->
                <div class="calendar-day">
                    <span>5</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>6</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>7</span>
                    <div class="attendance-indicator attendance-medium"></div>
                </div>
                <div class="calendar-day">
                    <span>8</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>9</span>
                    <div class="attendance-indicator attendance-low"></div>
                </div>
                <div class="calendar-day">
                    <span>10</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>11</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                
                <!-- Week 3 -->
                <div class="calendar-day">
                    <span>12</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>13</span>
                    <div class="attendance-indicator attendance-medium"></div>
                </div>
                <div class="calendar-day">
                    <span>14</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>15</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>16</span>
                    <div class="attendance-indicator attendance-medium"></div>
                </div>
                <div class="calendar-day">
                    <span>17</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>18</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                
                <!-- Week 4 -->
                <div class="calendar-day">
                    <span>19</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>20</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>21</span>
                    <div class="attendance-indicator attendance-medium"></div>
                </div>
                <div class="calendar-day">
                    <span>22</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>23</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>24</span>
                    <div class="attendance-indicator attendance-medium"></div>
                </div>
                <div class="calendar-day">
                    <span>25</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                
                <!-- Week 5 -->
                <div class="calendar-day">
                    <span>26</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>27</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day today">
                    <span>28</span>
                    <div class="attendance-indicator attendance-high"></div>
                </div>
                <div class="calendar-day">
                    <span>29</span>
                </div>
                <div class="calendar-day">
                    <span>30</span>
                </div>
                <div class="calendar-day other-month">1</div>
                <div class="calendar-day other-month">2</div>
            </div>
        </div>

        <!-- Monthly Trends -->
        <div class="monthly-card p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Tren Bulanan</h2>
            <div class="space-y-6">
                <!-- Attendance Trend -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Kehadiran</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">91.2%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: 91.2%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span>Target: 90%</span>
                        <span class="text-green-600 dark:text-green-400">+1.2% dari target</span>
                    </div>
                </div>

                <!-- Punctuality Trend -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Ketepatan Waktu</span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">94.2%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                        <div class="bg-blue-500 h-2 rounded-full" style="width: 94.2%"></div>
                    </div>
                    <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mt-1">
                        <span>Target: 95%</span>
                        <span class="text-yellow-600 dark:text-yellow-400">-0.8% dari target</span>
                    </div>
                </div>

                <!-- Weekly Comparison -->
                <div>
                    <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Perbandingan Mingguan</h3>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Minggu 1</span>
                            <div class="flex items-center">
                                <div class="w-20 h-1.5 bg-gray-200 dark:bg-gray-600 rounded-full mr-2">
                                    <div class="h-full bg-green-500 rounded-full" style="width: 89%"></div>
                                </div>
                                <span class="text-xs text-gray-900 dark:text-white">89%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Minggu 2</span>
                            <div class="flex items-center">
                                <div class="w-20 h-1.5 bg-gray-200 dark:bg-gray-600 rounded-full mr-2">
                                    <div class="h-full bg-green-500 rounded-full" style="width: 92%"></div>
                                </div>
                                <span class="text-xs text-gray-900 dark:text-white">92%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Minggu 3</span>
                            <div class="flex items-center">
                                <div class="w-20 h-1.5 bg-gray-200 dark:bg-gray-600 rounded-full mr-2">
                                    <div class="h-full bg-green-500 rounded-full" style="width: 93%"></div>
                                </div>
                                <span class="text-xs text-gray-900 dark:text-white">93%</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-600 dark:text-gray-400">Minggu 4</span>
                            <div class="flex items-center">
                                <div class="w-20 h-1.5 bg-gray-200 dark:bg-gray-600 rounded-full mr-2">
                                    <div class="h-full bg-green-500 rounded-full" style="width: 91%"></div>
                                </div>
                                <span class="text-xs text-gray-900 dark:text-white">91%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Performance -->
    <div class="monthly-card">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Performa Kelas Bulanan</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Rata-rata Kehadiran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hari Terbaik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hari Terburuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tren</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ranking</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 1</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">36 siswa</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">93.2%</div>
                            <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mt-1">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 93.2%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">100% (15 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">83% (9 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 trend-up mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                                </svg>
                                <span class="text-sm trend-up">+2.1%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                #1
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPA 2</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">35 siswa</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">91.8%</div>
                            <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mt-1">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 91.8%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">97% (22 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">80% (13 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 trend-up mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 17l9.2-9.2M17 17V7H7"></path>
                                </svg>
                                <span class="text-sm trend-up">+1.5%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                #2
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 1</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">34 siswa</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">89.5%</div>
                            <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mt-1">
                                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 89.5%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">94% (18 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">76% (21 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 trend-neutral mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                                <span class="text-sm trend-neutral">0.2%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                #3
                            </span>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">XII IPS 2</div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">33 siswa</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">87.3%</div>
                            <div class="w-16 bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 mt-1">
                                <div class="bg-yellow-500 h-1.5 rounded-full" style="width: 87.3%"></div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">91% (26 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">73% (16 Nov)</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 trend-down mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 7l-9.2 9.2M7 7v10h10"></path>
                                </svg>
                                <span class="text-sm trend-down">-1.2%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                                #4
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection