@extends('layouts.guru-piket')

@section('title', 'Dashboard Guru Piket')

@push('styles')
<style>
    .stats-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1.5rem;
        color: #374151;
        transition: all 0.2s ease;
    }

    .stats-card.pending {
        background: #fef3c7;
        border-color: #f59e0b;
    }

    .stats-card.confirmed {
        background: #d1fae5;
        border-color: #10b981;
    }

    .stats-card.total {
        background: #dbeafe;
        border-color: #3b82f6;
    }

    .stats-card.teachers {
        background: #fce7f3;
        border-color: #ec4899;
    }

    .activity-card {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }

    .dark .activity-card {
        background: #1f2937;
        border: 1px solid #374151;
    }

    .activity-item {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .dark .activity-item {
        border-bottom-color: #374151;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .quick-action-btn {
        background: #3b82f6;
        color: white;
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s ease;
        border: none;
        cursor: pointer;
    }

    .quick-action-btn:hover {
        background: #2563eb;
        color: white;
        text-decoration: none;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }
</style>
@endpush

@section('content')
<div class="space-y-8" style="padding: 0;">
    <!-- Welcome Header -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Selamat Datang, {{ auth()->user()->name }}!
                </h1>
                <p class="text-gray-600">
                    Dashboard Guru Piket - Kelola dan pantau absensi sekolah dengan mudah
                </p>
                <div class="mt-4 flex items-center text-gray-500">
                    <i class="fas fa-calendar-alt mr-2"></i>
                    <span>{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                    <span class="mx-3">•</span>
                    <i class="fas fa-clock mr-2"></i>
                    <span id="current-time">{{ \Carbon\Carbon::now()->format('H:i:s') }}</span>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-3xl text-gray-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="stats-card pending">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-amber-800 text-sm font-medium">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold mt-2 text-amber-900">{{ $statistics['pending'] ?? 0 }}</p>
                    <p class="text-amber-700 text-xs mt-1">Submission hari ini</p>
                </div>
                <div class="w-12 h-12 bg-amber-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-clock text-amber-600"></i>
                </div>
            </div>
        </div>

        <div class="stats-card confirmed">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-800 text-sm font-medium">Dikonfirmasi</p>
                    <p class="text-2xl font-bold mt-2 text-green-900">{{ $statistics['confirmed_today'] ?? 0 }}</p>
                    <p class="text-green-700 text-xs mt-1">Hari ini</p>
                </div>
                <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="stats-card total">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-800 text-sm font-medium">Total Submission</p>
                    <p class="text-2xl font-bold mt-2 text-blue-900">{{ $statistics['total_today'] ?? 0 }}</p>
                    <p class="text-blue-700 text-xs mt-1">Hari ini</p>
                </div>
                <div class="w-12 h-12 bg-blue-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-file-alt text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="stats-card teachers">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-pink-800 text-sm font-medium">Guru Aktif</p>
                    <p class="text-2xl font-bold mt-2 text-pink-900">{{ $statistics['teachers_submitted'] ?? 0 }}</p>
                    <p class="text-pink-700 text-xs mt-1">Mengirim hari ini</p>
                </div>
                <div class="w-12 h-12 bg-pink-200 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-pink-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activities -->
        <div class="lg:col-span-2">
            <div class="activity-card">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                            <i class="fas fa-history mr-2 text-blue-600"></i>
                            Aktivitas Terbaru
                        </h2>
                        <a href="{{ route('guru-piket.attendance.submissions') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Semua →
                        </a>
                    </div>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @forelse($recentActivities ?? [] as $activity)
                    <div class="activity-item">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-check text-blue-600 dark:text-blue-400"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $activity->teacher->name ?? 'Guru' }}
                                    </p>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $activity->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Mengirim absensi {{ $activity->class->name ?? 'Kelas' }} - {{ $activity->subject }}
                                </p>
                                <div class="mt-1 flex items-center space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                        @if($activity->status === 'pending') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400
                                        @elseif($activity->status === 'confirmed') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400
                                        @else bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400 @endif">
                                        {{ $activity->status_text }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $activity->present_count }}/{{ $activity->total_students }} hadir
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-inbox text-2xl text-gray-400 dark:text-gray-500"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum Ada Aktivitas</h3>
                        <p class="text-gray-600 dark:text-gray-400">Aktivitas submission akan muncul di sini</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions & Summary -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="activity-card">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        Aksi Cepat
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('guru-piket.attendance.submissions') }}" class="quick-action-btn">
                        <i class="fas fa-clipboard-check mr-3"></i>
                        <span>Kelola Submission</span>
                    </a>
                    
                    <button onclick="refreshDashboard()" class="quick-action-btn w-full" style="background: #10b981;">
                        <i class="fas fa-sync-alt mr-3"></i>
                        <span>Refresh Data</span>
                    </button>

                    <a href="{{ route('guru-piket.attendance.submissions', ['status' => 'pending']) }}" class="quick-action-btn w-full" style="background: #f59e0b;">
                        <i class="fas fa-exclamation-circle mr-3"></i>
                        <span>Lihat Pending</span>
                    </a>
                </div>
            </div>

            <!-- Today's Summary -->
            <div class="activity-card">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-chart-pie mr-2 text-green-500"></i>
                        Ringkasan Hari Ini
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Submission</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $statistics['total_today'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Menunggu Review</span>
                            <span class="font-semibold text-amber-600">{{ $statistics['pending'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Sudah Dikonfirmasi</span>
                            <span class="font-semibold text-green-600">{{ $statistics['confirmed_today'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Tingkat Konfirmasi</span>
                            <span class="font-semibold text-blue-600">
                                @if(($statistics['total_today'] ?? 0) > 0)
                                    {{ round((($statistics['confirmed_today'] ?? 0) / ($statistics['total_today'] ?? 1)) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mt-6">
                        <div class="flex items-center justify-between text-sm mb-2">
                            <span class="text-gray-600 dark:text-gray-400">Progress Konfirmasi</span>
                            <span class="font-medium text-gray-900 dark:text-white">
                                @if(($statistics['total_today'] ?? 0) > 0)
                                    {{ round((($statistics['confirmed_today'] ?? 0) / ($statistics['total_today'] ?? 1)) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full transition-all duration-500"
                                 style="width: @if(($statistics['total_today'] ?? 0) > 0){{ round((($statistics['confirmed_today'] ?? 0) / ($statistics['total_today'] ?? 1)) * 100, 1) }}%@else 0% @endif"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="activity-card">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <i class="fas fa-server mr-2 text-purple-500"></i>
                        Status Sistem
                    </h2>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Server Status</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                Online
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Database</span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                <i class="fas fa-circle text-xs mr-1"></i>
                                Connected
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Last Update</span>
                            <span class="text-xs text-gray-500" id="last-update">
                                {{ \Carbon\Carbon::now()->format('H:i:s') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Update current time
function updateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    document.getElementById('current-time').textContent = timeString;
    document.getElementById('last-update').textContent = timeString;
}

// Update time every second
setInterval(updateTime, 1000);

// Refresh dashboard data
function refreshDashboard() {
    // Show loading state
    const refreshBtn = event.target.closest('button');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-3"></i><span>Memuat...</span>';
    refreshBtn.disabled = true;
    
    // Simulate refresh (in real implementation, this would fetch new data)
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// Auto refresh every 5 minutes
setInterval(() => {
    console.log('Auto refreshing dashboard data...');
    // In real implementation, this would fetch new data via AJAX
}, 300000);

    // Initialize dashboard
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Dashboard Guru Piket loaded successfully');
    });
</script>
@endpush