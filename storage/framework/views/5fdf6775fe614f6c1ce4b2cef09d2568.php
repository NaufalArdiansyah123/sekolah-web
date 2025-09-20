<?php $__env->startSection('title', 'Statistik Absensi QR Code'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <div class="bg-gradient-to-r from-purple-500 to-pink-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-chart-bar text-white text-xl"></i>
                </div>
                Statistik Absensi QR Code
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Analisis mendalam data absensi siswa dengan visualisasi interaktif</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?php echo e(route('admin.qr-attendance.index')); ?>" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button type="button" onclick="exportStatistics()" 
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-download mr-2"></i>Export PDF
            </button>
        </div>
    </div>

    <!-- Filter Controls -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-sliders-h mr-2"></i>Filter Periode Statistik
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('admin.qr-attendance.statistics')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="month" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bulan</label>
                        <select name="month" id="month" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                            <?php for($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo e($i); ?>" <?php echo e($month == $i ? 'selected' : ''); ?>>
                                    <?php echo e(DateTime::createFromFormat('!m', $i)->format('F')); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div>
                        <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tahun</label>
                        <select name="year" id="year" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                            <?php for($y = date('Y'); $y >= date('Y') - 3; $y--): ?>
                                <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>>
                                    <?php echo e($y); ?>

                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">&nbsp;</label>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-search mr-2"></i>Update Statistik
                            </button>
                            <a href="<?php echo e(route('admin.qr-attendance.statistics')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Monthly Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Hadir -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Total Hadir</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($monthlyStats['hadir'] ?? 0); ?></p>
                        <p class="text-emerald-200 text-xs mt-1">Siswa tepat waktu</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl">
                        <i class="fas fa-check text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Persentase</span>
                    <?php
                        $totalAttendance = collect($monthlyStats)->sum();
                        $hadirPercentage = $totalAttendance > 0 ? (($monthlyStats['hadir'] ?? 0) / $totalAttendance) * 100 : 0;
                    ?>
                    <span class="text-sm font-semibold text-emerald-600 dark:text-emerald-400"><?php echo e(number_format($hadirPercentage, 1)); ?>%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                    <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: <?php echo e($hadirPercentage); ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Total Terlambat -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Total Terlambat</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($monthlyStats['terlambat'] ?? 0); ?></p>
                        <p class="text-yellow-200 text-xs mt-1">Datang terlambat</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Persentase</span>
                    <?php
                        $terlambatPercentage = $totalAttendance > 0 ? (($monthlyStats['terlambat'] ?? 0) / $totalAttendance) * 100 : 0;
                    ?>
                    <span class="text-sm font-semibold text-yellow-600 dark:text-yellow-400"><?php echo e(number_format($terlambatPercentage, 1)); ?>%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                    <div class="bg-yellow-500 h-2 rounded-full transition-all duration-500" style="width: <?php echo e($terlambatPercentage); ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Izin & Sakit -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Izin & Sakit</p>
                        <p class="text-white text-3xl font-bold"><?php echo e(($monthlyStats['izin'] ?? 0) + ($monthlyStats['sakit'] ?? 0)); ?></p>
                        <p class="text-blue-200 text-xs mt-1">Ada keterangan</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl">
                        <i class="fas fa-user-clock text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Persentase</span>
                    <?php
                        $izinSakitPercentage = $totalAttendance > 0 ? ((($monthlyStats['izin'] ?? 0) + ($monthlyStats['sakit'] ?? 0)) / $totalAttendance) * 100 : 0;
                    ?>
                    <span class="text-sm font-semibold text-blue-600 dark:text-blue-400"><?php echo e(number_format($izinSakitPercentage, 1)); ?>%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                    <div class="bg-blue-500 h-2 rounded-full transition-all duration-500" style="width: <?php echo e($izinSakitPercentage); ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Total Alpha -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Total Alpha</p>
                        <p class="text-white text-3xl font-bold"><?php echo e($monthlyStats['alpha'] ?? 0); ?></p>
                        <p class="text-red-200 text-xs mt-1">Tanpa keterangan</p>
                    </div>
                    <div class="bg-white/20 p-4 rounded-xl">
                        <i class="fas fa-times text-white text-2xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Persentase</span>
                    <?php
                        $alphaPercentage = $totalAttendance > 0 ? (($monthlyStats['alpha'] ?? 0) / $totalAttendance) * 100 : 0;
                    ?>
                    <span class="text-sm font-semibold text-red-600 dark:text-red-400"><?php echo e(number_format($alphaPercentage, 1)); ?>%</span>
                </div>
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mt-2">
                    <div class="bg-red-500 h-2 rounded-full transition-all duration-500" style="width: <?php echo e($alphaPercentage); ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <!-- Daily Attendance Chart -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-chart-line mr-2"></i>Grafik Absensi Harian
                </h3>
            </div>
            <div class="p-6">
                <div class="relative h-80">
                    <canvas id="dailyAttendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Status Distribution Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                <h3 class="text-lg font-semibold text-white flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>Distribusi Status
                </h3>
            </div>
            <div class="p-6">
                <div class="relative h-80">
                    <canvas id="statusDistributionChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Class Statistics -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-school mr-2"></i>Statistik Per Kelas
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hadir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terlambat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Izin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sakit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alpha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tingkat Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $classStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $totalAttendanceClass = collect($stats)->sum('count');
                                $presentCount = $stats->where('status', 'hadir')->first()->count ?? 0;
                                $lateCount = $stats->where('status', 'terlambat')->first()->count ?? 0;
                                $izinCount = $stats->where('status', 'izin')->first()->count ?? 0;
                                $sakitCount = $stats->where('status', 'sakit')->first()->count ?? 0;
                                $alphaCount = $stats->where('status', 'alpha')->first()->count ?? 0;
                                
                                $attendanceRate = $totalAttendanceClass > 0 ? (($presentCount + $lateCount) / $totalAttendanceClass) * 100 : 0;
                            ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($class); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo e($totalAttendanceClass); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                                        <?php echo e($presentCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        <?php echo e($lateCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        <?php echo e($izinCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                        <?php echo e($sakitCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <?php echo e($alphaCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: <?php echo e($attendanceRate); ?>%"></div>
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e(number_format($attendanceRate, 1)); ?>%</span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-chart-bar text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada data statistik</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm">untuk periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Daily Breakdown -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-emerald-500 to-teal-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>Rincian Harian
            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hari</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Hadir</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Terlambat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Izin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Sakit</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Alpha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $dailyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $dayName = \Carbon\Carbon::parse($date)->format('l');
                                $dayNameIndo = [
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa', 
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu',
                                    'Sunday' => 'Minggu'
                                ][$dayName] ?? $dayName;
                                
                                $dailyTotal = $stats->sum('count');
                                $hadirCount = $stats->where('status', 'hadir')->first()->count ?? 0;
                                $terlambatCount = $stats->where('status', 'terlambat')->first()->count ?? 0;
                                $izinCount = $stats->where('status', 'izin')->first()->count ?? 0;
                                $sakitCount = $stats->where('status', 'sakit')->first()->count ?? 0;
                                $alphaCount = $stats->where('status', 'alpha')->first()->count ?? 0;
                            ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                    <?php echo e(\Carbon\Carbon::parse($date)->format('d/m/Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo e($dayNameIndo); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                                        <?php echo e($hadirCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                        <?php echo e($terlambatCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        <?php echo e($izinCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200">
                                        <?php echo e($sakitCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                        <?php echo e($alphaCount); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 dark:text-white"><?php echo e($dailyTotal); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada data absensi</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm">untuk periode ini</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Chart.js configuration for dark mode compatibility
Chart.defaults.color = document.documentElement.classList.contains('dark') ? '#e5e7eb' : '#374151';
Chart.defaults.borderColor = document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb';

// Daily Attendance Chart
const dailyCtx = document.getElementById('dailyAttendanceChart').getContext('2d');
const dailyChart = new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: [
            <?php $__currentLoopData = $dailyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                '<?php echo e(\Carbon\Carbon::parse($date)->format('d/m')); ?>',
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        ],
        datasets: [{
            label: 'Hadir',
            data: [
                <?php $__currentLoopData = $dailyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($stats->where('status', 'hadir')->first()->count ?? 0); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#10b981',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }, {
            label: 'Terlambat',
            data: [
                <?php $__currentLoopData = $dailyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($stats->where('status', 'terlambat')->first()->count ?? 0); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            borderColor: '#f59e0b',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#f59e0b',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }, {
            label: 'Alpha',
            data: [
                <?php $__currentLoopData = $dailyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $stats): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo e($stats->where('status', 'alpha')->first()->count ?? 0); ?>,
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            borderColor: '#ef4444',
            backgroundColor: 'rgba(239, 68, 68, 0.1)',
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#ef4444',
            pointBorderColor: '#ffffff',
            pointBorderWidth: 2,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            intersect: false,
            mode: 'index'
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 20,
                    font: {
                        size: 12,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                borderColor: '#374151',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: true,
                usePointStyle: true
            }
        },
        scales: {
            x: {
                grid: {
                    color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                },
                ticks: {
                    font: {
                        size: 11
                    }
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: document.documentElement.classList.contains('dark') ? '#374151' : '#e5e7eb'
                },
                ticks: {
                    font: {
                        size: 11
                    }
                }
            }
        }
    }
});

// Status Distribution Chart
const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpha'],
        datasets: [{
            data: [
                <?php echo e($monthlyStats['hadir'] ?? 0); ?>,
                <?php echo e($monthlyStats['terlambat'] ?? 0); ?>,
                <?php echo e($monthlyStats['izin'] ?? 0); ?>,
                <?php echo e($monthlyStats['sakit'] ?? 0); ?>,
                <?php echo e($monthlyStats['alpha'] ?? 0); ?>

            ],
            backgroundColor: [
                '#10b981',
                '#f59e0b',
                '#3b82f6',
                '#6b7280',
                '#ef4444'
            ],
            hoverBackgroundColor: [
                '#059669',
                '#d97706',
                '#2563eb',
                '#4b5563',
                '#dc2626'
            ],
            borderWidth: 3,
            borderColor: document.documentElement.classList.contains('dark') ? '#1f2937' : '#ffffff',
            hoverBorderWidth: 4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '60%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: {
                        size: 11,
                        weight: 'bold'
                    }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                titleColor: '#ffffff',
                bodyColor: '#ffffff',
                borderColor: '#374151',
                borderWidth: 1,
                cornerRadius: 8,
                displayColors: true,
                usePointStyle: true,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = total > 0 ? ((context.parsed / total) * 100).toFixed(1) : 0;
                        return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// Export statistics function
function exportStatistics() {
    const month = document.getElementById('month').value;
    const year = document.getElementById('year').value;
    
    Swal.fire({
        title: 'Export Statistik',
        text: 'Pilih format export yang diinginkan',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#8b5cf6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-file-pdf mr-2"></i>Export PDF',
        cancelButtonText: 'Batal',
        showDenyButton: true,
        denyButtonText: '<i class="fas fa-file-excel mr-2"></i>Export Excel',
        denyButtonColor: '#10b981'
    }).then((result) => {
        if (result.isConfirmed) {
            // Export PDF
            Swal.fire({
                title: 'Exporting PDF...',
                text: 'Sedang menyiapkan file PDF',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            window.open(`<?php echo e(route('admin.qr-attendance.statistics')); ?>?month=${month}&year=${year}&export=pdf`, '_blank');
            
            setTimeout(() => {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Export Berhasil!',
                    text: 'File PDF telah dibuka di tab baru',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, 1500);
        } else if (result.isDenied) {
            // Export Excel
            Swal.fire({
                title: 'Exporting Excel...',
                text: 'Sedang menyiapkan file Excel',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            window.open(`<?php echo e(route('admin.qr-attendance.statistics')); ?>?month=${month}&year=${year}&export=excel`, '_blank');
            
            setTimeout(() => {
                Swal.close();
                Swal.fire({
                    icon: 'success',
                    title: 'Export Berhasil!',
                    text: 'File Excel telah didownload',
                    timer: 2000,
                    showConfirmButton: false
                });
            }, 1500);
        }
    });
}

// Update charts when theme changes
function updateChartsForTheme() {
    const isDark = document.documentElement.classList.contains('dark');
    
    Chart.defaults.color = isDark ? '#e5e7eb' : '#374151';
    Chart.defaults.borderColor = isDark ? '#374151' : '#e5e7eb';
    
    // Update daily chart
    dailyChart.options.scales.x.grid.color = isDark ? '#374151' : '#e5e7eb';
    dailyChart.options.scales.y.grid.color = isDark ? '#374151' : '#e5e7eb';
    dailyChart.data.datasets.forEach(dataset => {
        dataset.pointBorderColor = '#ffffff';
    });
    dailyChart.update();
    
    // Update status chart
    statusChart.data.datasets[0].borderColor = isDark ? '#1f2937' : '#ffffff';
    statusChart.update();
}

// Listen for theme changes
window.addEventListener('theme-changed', updateChartsForTheme);

// Initialize charts with correct theme
document.addEventListener('DOMContentLoaded', function() {
    updateChartsForTheme();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/qr-attendance/statistics.blade.php ENDPATH**/ ?>