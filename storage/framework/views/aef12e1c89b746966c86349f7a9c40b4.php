<?php $__env->startSection('title', 'Log Absensi QR Code'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-6 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-list text-white text-xl"></i>
                </div>
                Log Absensi QR Code
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Monitor dan analisis log absensi siswa secara real-time</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?php echo e(route('admin.qr-attendance.index')); ?>" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            <button type="button" onclick="exportLogs()" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-download mr-2"></i>Export CSV
            </button>
        </div>
    </div>

    <!-- Real-time Status -->
    <?php if(request('date', date('Y-m-d')) == date('Y-m-d')): ?>
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6 mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-blue-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-broadcast-tower text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100">Live Monitoring</h3>
                    <p class="text-blue-700 dark:text-blue-300">Data diperbarui otomatis setiap 30 detik</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse mr-2"></div>
                    <span class="bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 px-4 py-2 rounded-full text-sm font-medium">Real-time</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-filter mr-2"></i>Filter Log Absensi
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('admin.qr-attendance.logs')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                        <input type="date" name="date" id="date" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                               value="<?php echo e(request('date', date('Y-m-d'))); ?>">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua Status</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($status)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                        <select name="class" id="class" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua Kelas</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>" <?php echo e(request('class') == $class->id ? 'selected' : ''); ?>>
                                    <?php echo e($class->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">&nbsp;</label>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="<?php echo e(route('admin.qr-attendance.logs')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Statistics -->
    <?php if($logs->count() > 0): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Hadir -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Hadir</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($logs->where('status', 'hadir')->count()); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-check text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-user-check text-emerald-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Siswa tepat waktu</span>
                </div>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Terlambat</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($logs->where('status', 'terlambat')->count()); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Datang terlambat</span>
                </div>
            </div>
        </div>

        <!-- Izin/Sakit -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Izin/Sakit</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($logs->whereIn('status', ['izin', 'sakit'])->count()); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-user-clock text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Ada keterangan</span>
                </div>
            </div>
        </div>

        <!-- Alpha -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-red-500 to-red-600 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-red-100 text-sm font-medium">Alpha</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($logs->where('status', 'alpha')->count()); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-times text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-user-times text-red-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Tanpa keterangan</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Attendance Logs Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-table mr-2"></i>Log Absensi - <?php echo e(\Carbon\Carbon::parse(request('date', date('Y-m-d')))->format('d/m/Y')); ?>

            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu Scan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">QR Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($log->scan_time->format('H:i:s')); ?></div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($log->attendance_date->format('d/m/Y')); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if($log->student->photo_url): ?>
                                            <img src="<?php echo e($log->student->photo_url); ?>" alt="<?php echo e($log->student->name); ?>" 
                                                 class="w-10 h-10 rounded-full border-2 border-gray-200 dark:border-gray-600">
                                        <?php else: ?>
                                            <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                                <?php echo e($log->student->initials); ?>

                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($log->student->name); ?></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($log->student->nis); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        <?php if($log->student->class_id && $log->student->class): ?>
                                            <?php echo e($log->student->class->name); ?>

                                        <?php else: ?>
                                            Kelas Belum Ditentukan
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                        $badgeColor = match($log->status) {
                                            'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                            'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        };
                                    ?>
                                    <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($badgeColor); ?>">
                                        <?php echo e($log->status_text); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($log->location ?? '-'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 px-2 py-1 rounded">
                                        <?php echo e(Str::limit($log->qr_code, 20)); ?>

                                    </code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    <?php echo e($log->notes ?? '-'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-calendar-times text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada log absensi</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm">untuk filter yang dipilih</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($logs->hasPages()): ?>
                <div class="mt-6 flex justify-center">
                    <?php echo e($logs->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function exportLogs() {
    // Get current filters from URL
    const params = new URLSearchParams(window.location.search);
    // Remove export parameter since we're using dedicated route
    params.delete('export');
    
    // Show loading notification
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Exporting...',
            text: 'Sedang menyiapkan file CSV',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    }
    
    // Create download link
    const downloadUrl = '<?php echo e(route("admin.qr-attendance.logs.export")); ?>?' + params.toString();
    
    // Create temporary link and trigger download
    const link = document.createElement('a');
    link.href = downloadUrl;
    
    // Generate filename based on current filters
    let filename = 'log-absensi-qr';
    const date = params.get('date') || new Date().toISOString().split('T')[0];
    filename += '-' + date;
    
    const classFilter = params.get('class');
    if (classFilter) {
        filename += '-kelas-' + classFilter.toLowerCase().replace(/\s+/g, '-');
    }
    
    const statusFilter = params.get('status');
    if (statusFilter) {
        filename += '-' + statusFilter;
    }
    
    filename += '.csv';
    link.download = filename;
    
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Close loading and show success message
    setTimeout(() => {
        if (typeof Swal !== 'undefined') {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Export Berhasil!',
                text: 'File CSV log absensi QR telah didownload',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            // Fallback for when SweetAlert is not available
            alert('File CSV log absensi QR berhasil didownload!');
        }
    }, 1000);
}

// Auto refresh every 30 seconds if viewing today's logs
<?php if(request('date', date('Y-m-d')) == date('Y-m-d')): ?>
    let refreshInterval;
    
    function startAutoRefresh() {
        refreshInterval = setInterval(function() {
            if (!document.hidden) {
                // Add subtle loading indicator
                const refreshIndicator = document.createElement('div');
                refreshIndicator.className = 'fixed top-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg shadow-lg z-50 flex items-center';
                refreshIndicator.innerHTML = '<i class="fas fa-sync-alt animate-spin mr-2"></i>Refreshing...';
                document.body.appendChild(refreshIndicator);
                
                setTimeout(() => {
                    location.reload();
                }, 1000);
            }
        }, 30000);
    }
    
    function stopAutoRefresh() {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    }
    
    // Start auto refresh
    startAutoRefresh();
    
    // Stop auto refresh when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            startAutoRefresh();
        }
    });
    
    // Show auto refresh indicator
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔄 Auto refresh enabled for today\'s logs');
    });
<?php endif; ?>

// Add real-time timestamp update
function updateTimestamp() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    
    // Update any timestamp elements if they exist
    const timestampElements = document.querySelectorAll('.live-timestamp');
    timestampElements.forEach(element => {
        element.textContent = timeString;
    });
}

// Update timestamp every second
setInterval(updateTimestamp, 1000);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/qr-attendance/logs.blade.php ENDPATH**/ ?>