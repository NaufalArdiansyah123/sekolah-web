<?php $__env->startSection('title', 'Riwayat Absensi'); ?>

<?php $__env->startPush('meta'); ?>
<!-- Cache Busting Meta Tags -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<meta name="student-id" content="<?php echo e($student->id); ?>">
<meta name="user-id" content="<?php echo e(auth()->id()); ?>">
<meta name="cache-buster" content="<?php echo e(time()); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-indigo-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-history text-white text-xl"></i>
                </div>
                Riwayat Absensi
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Pantau dan kelola riwayat kehadiran Anda secara real-time</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" onclick="refreshData()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sync-alt mr-2"></i>Refresh
            </button>
            <button type="button" onclick="exportData()" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-download mr-2"></i>Export CSV
            </button>
        </div>
    </div>

    <!-- Real-time Status -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6 mb-8 shadow-lg" id="realtime-status">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-blue-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-broadcast-tower text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Status Real-time</h3>
                    <p class="text-blue-700 dark:text-blue-300">Data terakhir diperbarui: <span id="last-updated" class="font-semibold"><?php echo e(now()->format('d/m/Y H:i:s')); ?></span></p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse mr-2"></div>
                    <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 px-4 py-2 rounded-full text-sm font-medium" id="status-indicator">Real-time</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Today's Status -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 h-full overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-calendar-day mr-2"></i>Status Hari Ini
                    </h3>
                </div>
                <div class="p-6 text-center" id="today-status">
                    <?php if($todayAttendance): ?>
                        <div class="mb-4">
                            <?php
                                $iconColor = match($todayAttendance->status) {
                                    'hadir' => 'text-emerald-500',
                                    'terlambat' => 'text-yellow-500',
                                    'izin' => 'text-blue-500',
                                    'sakit' => 'text-purple-500',
                                    default => 'text-red-500'
                                };
                                $textColor = match($todayAttendance->status) {
                                    'hadir' => 'text-emerald-600',
                                    'terlambat' => 'text-yellow-600',
                                    'izin' => 'text-blue-600',
                                    'sakit' => 'text-purple-600',
                                    default => 'text-red-600'
                                };
                            ?>
                            <i class="fas fa-check-circle text-6xl <?php echo e($iconColor); ?>"></i>
                        </div>
                        <h4 class="font-bold <?php echo e($textColor); ?> mb-2"><?php echo e($todayAttendance->status_text); ?></h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-1">Waktu: <?php echo e($todayAttendance->scan_time->format('H:i:s')); ?></p>
                        <p class="text-gray-600 dark:text-gray-400">Lokasi: <?php echo e($todayAttendance->location ?? 'Sekolah'); ?></p>
                    <?php else: ?>
                        <div class="mb-4">
                            <i class="fas fa-clock text-6xl text-yellow-500"></i>
                        </div>
                        <h4 class="font-bold text-yellow-600 mb-2">Belum Absen</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Anda belum melakukan absensi hari ini</p>
                        <a href="<?php echo e(route('student.attendance.qr-scanner')); ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 inline-flex items-center">
                            <i class="fas fa-qrcode mr-2"></i>Scan QR Code
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 h-full overflow-hidden">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                    <h3 class="text-lg font-semibold text-white flex items-center">
                        <i class="fas fa-chart-bar mr-2"></i>Statistik Bulan Ini
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-6 bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900/20 dark:to-emerald-800/20 rounded-xl border border-emerald-200 dark:border-emerald-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="bg-emerald-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-check text-white text-lg"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-emerald-600 dark:text-emerald-400 mb-1" id="stat-hadir"><?php echo e($monthlyStats['hadir'] ?? 0); ?></h3>
                            <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">Hadir</p>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl border border-yellow-200 dark:border-yellow-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="bg-yellow-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-clock text-white text-lg"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-yellow-600 dark:text-yellow-400 mb-1" id="stat-terlambat"><?php echo e($monthlyStats['terlambat'] ?? 0); ?></h3>
                            <p class="text-sm font-medium text-yellow-700 dark:text-yellow-300">Terlambat</p>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl border border-blue-200 dark:border-blue-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-user-clock text-white text-lg"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-blue-600 dark:text-blue-400 mb-1" id="stat-izin"><?php echo e(($monthlyStats['izin'] ?? 0) + ($monthlyStats['sakit'] ?? 0)); ?></h3>
                            <p class="text-sm font-medium text-blue-700 dark:text-blue-300">Izin/Sakit</p>
                        </div>
                        <div class="text-center p-6 bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl border border-red-200 dark:border-red-700 transform hover:scale-105 transition-transform duration-200">
                            <div class="bg-red-500 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fas fa-times text-white text-lg"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-red-600 dark:text-red-400 mb-1" id="stat-alpha"><?php echo e($monthlyStats['alpha'] ?? 0); ?></h3>
                            <p class="text-sm font-medium text-red-700 dark:text-red-300">Alpha</p>
                        </div>
                    </div>
                    
                    <!-- Attendance Percentage -->
                    <div class="bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 rounded-xl p-6 border border-indigo-200 dark:border-indigo-700">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="bg-indigo-500 w-10 h-10 rounded-full flex items-center justify-center mr-3">
                                    <i class="fas fa-percentage text-white"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-indigo-900 dark:text-indigo-100">Tingkat Kehadiran</h4>
                                    <p class="text-sm text-indigo-700 dark:text-indigo-300">Persentase kehadiran bulan ini</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400" id="attendance-percentage"><?php echo e(number_format($attendancePercentage, 1)); ?>%</div>
                            </div>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-blue-500 h-4 rounded-full transition-all duration-500 ease-out" 
                                 style="width: <?php echo e($attendancePercentage); ?>%" 
                                 id="attendance-progress">
                            </div>
                        </div>
                        <div class="flex justify-between text-xs text-indigo-600 dark:text-indigo-400 mt-2">
                            <span>0%</span>
                            <span>50%</span>
                            <span>100%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-filter mr-2"></i>Filter Data Absensi
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('student.attendance.history')); ?>" id="filter-form">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                        <select name="month" id="month" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white" onchange="applyFilter()">
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($month == $i ? 'selected' : ''); ?>>
                                    <?php echo e(DateTime::createFromFormat('!m', $i)->format('F')); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                        <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white" onchange="applyFilter()">
                            <?php for($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-700 dark:text-white" onchange="applyFilter()">
                            <option value="all" <?php echo e($status == 'all' ? 'selected' : ''); ?>>Semua Status</option>
                            <option value="hadir" <?php echo e($status == 'hadir' ? 'selected' : ''); ?>>Hadir</option>
                            <option value="terlambat" <?php echo e($status == 'terlambat' ? 'selected' : ''); ?>>Terlambat</option>
                            <option value="izin" <?php echo e($status == 'izin' ? 'selected' : ''); ?>>Izin</option>
                            <option value="sakit" <?php echo e($status == 'sakit' ? 'selected' : ''); ?>>Sakit</option>
                            <option value="alpha" <?php echo e($status == 'alpha' ? 'selected' : ''); ?>>Alpha</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">&nbsp;</label>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="<?php echo e(route('student.attendance.history')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-white mb-4 sm:mb-0 flex items-center">
                    <i class="fas fa-table mr-2"></i>Data Absensi
                </h3>
                <div class="flex items-center space-x-4">
                    <label class="flex items-center bg-white/20 rounded-lg px-3 py-2">
                        <input type="checkbox" id="auto-refresh" checked class="rounded border-white/30 text-teal-600 focus:ring-teal-500 bg-white/20">
                        <span class="ml-2 text-sm text-white font-medium">Auto Refresh (30s)</span>
                    </label>
                    <span class="bg-white/20 text-white px-4 py-2 rounded-full text-sm font-medium backdrop-blur-sm" id="record-count"><?php echo e($attendanceRecords->total()); ?> records</span>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto" id="attendance-table">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu Scan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="attendance-tbody">
                        <?php $__empty_1 = true; $__currentLoopData = $attendanceRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo e($record->attendance_date->format('d/m/Y')); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <?php
                                        $dayName = $record->attendance_date->format('l');
                                        $dayIndo = [
                                            'Monday' => 'Senin',
                                            'Tuesday' => 'Selasa',
                                            'Wednesday' => 'Rabu',
                                            'Thursday' => 'Kamis',
                                            'Friday' => 'Jumat',
                                            'Saturday' => 'Sabtu',
                                            'Sunday' => 'Minggu'
                                        ][$dayName] ?? $dayName;
                                    ?>
                                    <?php echo e($dayIndo); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $badgeColor = match($record->status) {
                                            'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                            'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        };
                                    ?>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($badgeColor); ?>">
                                        <?php echo e($record->status_text); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo e($record->scan_time->format('H:i:s')); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo e($record->location ?? 'Sekolah'); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"><?php echo e($record->created_at->diffForHumans()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data absensi untuk periode ini</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($attendanceRecords->hasPages()): ?>
                <div class="mt-6 flex justify-center">
                    <?php echo e($attendanceRecords->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let autoRefreshInterval;
let isRefreshing = false;

// Clear any existing data and check user context
function clearUserData() {
    // Get current user info from meta tags
    const currentStudentId = document.querySelector('meta[name="student-id"]')?.content;
    const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
    const cacheBuster = document.querySelector('meta[name="cache-buster"]')?.content;
    
    console.log('🔄 Clearing attendance history data for student:', currentStudentId, 'user:', currentUserId);
    
    // Clear any stored data that might be from previous user
    if (typeof(Storage) !== "undefined") {
        // Clear localStorage items that might contain user-specific data
        const keysToRemove = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (key && (key.includes('attendance') || key.includes('history') || key.includes('student'))) {
                keysToRemove.push(key);
            }
        }
        keysToRemove.forEach(key => localStorage.removeItem(key));
        
        // Clear sessionStorage
        sessionStorage.clear();
    }
    
    // Clear any existing intervals
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
    }
    
    // Reset refresh state
    isRefreshing = false;
    
    // Store current user info for validation
    if (typeof(Storage) !== "undefined") {
        localStorage.setItem('current_student_id', currentStudentId);
        localStorage.setItem('current_user_id', currentUserId);
        localStorage.setItem('page_load_time', cacheBuster);
    }
}

// Validate user context
function validateUserContext() {
    const currentStudentId = document.querySelector('meta[name="student-id"]')?.content;
    const storedStudentId = localStorage.getItem('current_student_id');
    
    if (storedStudentId && storedStudentId !== currentStudentId) {
        console.log('🚨 User context changed! Clearing data and reloading...');
        clearUserData();
        location.reload();
        return false;
    }
    
    return true;
}

// Initialize auto refresh
document.addEventListener('DOMContentLoaded', function() {
    console.log('📊 Initializing Attendance History page...');
    
    // Clear user data first
    clearUserData();
    
    // Validate user context
    if (!validateUserContext()) {
        return;
    }
    
    // Start auto refresh
    startAutoRefresh();
    
    // Handle auto refresh toggle
    document.getElementById('auto-refresh').addEventListener('change', function() {
        if (this.checked) {
            startAutoRefresh();
        } else {
            stopAutoRefresh();
        }
    });
});

// Validate user context periodically
setInterval(validateUserContext, 5000); // Check every 5 seconds

// Start auto refresh
function startAutoRefresh() {
    stopAutoRefresh(); // Clear existing interval
    
    autoRefreshInterval = setInterval(function() {
        if (!isRefreshing) {
            refreshData(true); // Silent refresh
        }
    }, 30000); // 30 seconds
    
    console.log('✅ Auto refresh started (30s interval)');
}

// Stop auto refresh
function stopAutoRefresh() {
    if (autoRefreshInterval) {
        clearInterval(autoRefreshInterval);
        autoRefreshInterval = null;
        console.log('⏹️ Auto refresh stopped');
    }
}

// Refresh data
function refreshData(silent = false) {
    if (isRefreshing) return;
    
    isRefreshing = true;
    
    if (!silent) {
        // Show loading indicator
        document.getElementById('status-indicator').textContent = 'Refreshing...';
        document.getElementById('status-indicator').className = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-3 py-1 rounded-full text-sm font-medium';
    }
    
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    fetch(`<?php echo e(route('student.attendance.realtime-data')); ?>?month=${month}&year=${year}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateUI(data.data);
                
                if (!silent) {
                    showToast('success', 'Data Diperbarui', 'Data absensi berhasil diperbarui');
                }
            } else {
                if (!silent) {
                    showToast('error', 'Error', data.message || 'Gagal memperbarui data');
                }
            }
        })
        .catch(error => {
            console.error('Error refreshing data:', error);
            if (!silent) {
                showToast('error', 'Error', 'Terjadi kesalahan saat memperbarui data');
            }
        })
        .finally(() => {
            isRefreshing = false;
            
            // Update status indicator
            document.getElementById('status-indicator').textContent = 'Real-time';
            document.getElementById('status-indicator').className = 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 px-3 py-1 rounded-full text-sm font-medium';
        });
}

// Update UI with new data
function updateUI(data) {
    // Update last updated time
    document.getElementById('last-updated').textContent = data.last_updated;
    
    // Update today's status
    updateTodayStatus(data.today_attendance);
    
    // Update monthly statistics
    updateMonthlyStats(data.monthly_stats, data.attendance_percentage);
    
    // Update latest records in table
    updateAttendanceTable(data.latest_records);
}

// Update today's status
function updateTodayStatus(todayAttendance) {
    const todayStatusElement = document.getElementById('today-status');
    
    if (todayAttendance) {
        const iconColorMap = {
            'hadir': 'text-emerald-500',
            'terlambat': 'text-yellow-500',
            'izin': 'text-blue-500',
            'sakit': 'text-purple-500'
        };
        const textColorMap = {
            'hadir': 'text-emerald-600',
            'terlambat': 'text-yellow-600',
            'izin': 'text-blue-600',
            'sakit': 'text-purple-600'
        };
        
        const iconColor = iconColorMap[todayAttendance.status] || 'text-red-500';
        const textColor = textColorMap[todayAttendance.status] || 'text-red-600';
        
        todayStatusElement.innerHTML = `
            <div class="mb-4">
                <i class="fas fa-check-circle text-6xl ${iconColor}"></i>
            </div>
            <h4 class="font-bold ${textColor} mb-2">${todayAttendance.status_text}</h4>
            <p class="text-gray-600 dark:text-gray-400 mb-1">Waktu: ${todayAttendance.scan_time}</p>
            <p class="text-gray-600 dark:text-gray-400">Lokasi: ${todayAttendance.location || 'Sekolah'}</p>
        `;
    } else {
        todayStatusElement.innerHTML = `
            <div class="mb-4">
                <i class="fas fa-clock text-6xl text-yellow-500"></i>
            </div>
            <h4 class="font-bold text-yellow-600 mb-2">Belum Absen</h4>
            <p class="text-gray-600 dark:text-gray-400 mb-4">Anda belum melakukan absensi hari ini</p>
            <a href="<?php echo e(route('student.attendance.qr-scanner')); ?>" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 inline-flex items-center">
                <i class="fas fa-qrcode mr-2"></i>Scan QR Code
            </a>
        `;
    }
}

// Update monthly statistics
function updateMonthlyStats(stats, percentage) {
    document.getElementById('stat-hadir').textContent = stats.hadir || 0;
    document.getElementById('stat-terlambat').textContent = stats.terlambat || 0;
    document.getElementById('stat-izin').textContent = (stats.izin || 0) + (stats.sakit || 0);
    document.getElementById('stat-alpha').textContent = stats.alpha || 0;
    
    // Update attendance percentage
    document.getElementById('attendance-percentage').textContent = percentage + '%';
    document.getElementById('attendance-progress').style.width = percentage + '%';
}

// Update attendance table with latest records
function updateAttendanceTable(records) {
    const tbody = document.getElementById('attendance-tbody');
    
    if (records.length === 0) {
        tbody.innerHTML = '<tr><td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">Tidak ada data absensi untuk periode ini</td></tr>';
        return;
    }
    
    let html = '';
    records.forEach(record => {
        const badgeColorMap = {
            'hadir': 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
            'terlambat': 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'izin': 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'sakit': 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200'
        };
        const badgeColor = badgeColorMap[record.status] || 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
        
        html += `
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${record.date}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${record.day_indo}</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs font-medium rounded-full ${badgeColor}">${record.status_text}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${record.scan_time}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${record.location || 'Sekolah'}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">${record.created_at}</td>
            </tr>
        `;
    });
    
    tbody.innerHTML = html;
}

// Apply filter
function applyFilter() {
    document.getElementById('filter-form').submit();
}

// Export data
function exportData() {
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    window.open(`<?php echo e(route('student.attendance.export')); ?>?month=${month}&year=${year}`, '_blank');
}

// Show toast notification
function showToast(type, title, message) {
    // Use SweetAlert for notifications
    const icon = type === 'success' ? 'success' : 'error';
    
    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
}

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    stopAutoRefresh();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/attendance/history.blade.php ENDPATH**/ ?>