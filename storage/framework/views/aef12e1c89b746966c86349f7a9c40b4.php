<?php $__env->startSection('title', 'Log Absensi QR Code'); ?>

<?php $__env->startSection('content'); ?>
<style>
/* Optimized Dark Mode Styling for QR Attendance Logs */

/* Main container styling */
.attendance-log-container {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    transition: all 0.3s ease;
}

/* Card and container backgrounds */
.attendance-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    transition: all 0.3s ease;
}

/* Table styling */
.attendance-table {
    background-color: var(--bg-primary);
    color: var(--text-primary);
}

.attendance-table thead {
    background-color: var(--bg-tertiary);
}

.attendance-table tbody tr {
    background-color: var(--bg-primary);
    transition: background-color 0.2s ease;
}

.attendance-table tbody tr:hover {
    background-color: var(--bg-tertiary);
}

.attendance-table th,
.attendance-table td {
    border-color: var(--border-color);
    color: var(--text-primary);
}

/* Form elements */
.attendance-form-input {
    background-color: var(--bg-primary);
    border-color: var(--border-color);
    color: var(--text-primary);
}

.attendance-form-input:focus {
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Button styling */
.btn-secondary-custom {
    background-color: var(--bg-tertiary);
    color: var(--text-primary);
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.btn-secondary-custom:hover {
    background-color: var(--bg-secondary);
    transform: translateY(-1px);
}

/* Pagination styling */
.pagination-wrapper nav {
    color: var(--text-primary);
}

.pagination-wrapper nav span,
.pagination-wrapper nav a {
    color: var(--text-primary);
    background-color: var(--bg-primary);
    border-color: var(--border-color);
}

.pagination-wrapper nav a:hover {
    background-color: var(--bg-tertiary);
    color: var(--text-primary);
}

.pagination-wrapper nav span[aria-current="page"] {
    background-color: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
}

/* Status badges - keep their colors but ensure readability */
.status-badge {
    font-weight: 500;
    font-size: 0.75rem;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
}

/* Empty state styling */
.empty-state {
    color: var(--text-secondary);
    text-align: center;
    padding: 3rem 1rem;
}

/* Responsive improvements */
@media (max-width: 768px) {
    .attendance-log-container {
        padding: 1rem;
    }
    
    .attendance-table {
        font-size: 0.875rem;
    }
}

/* Smooth transitions for all elements */
.attendance-log-container *,
.attendance-card,
.attendance-table,
.attendance-form-input,
.btn-secondary-custom {
    transition: color 0.3s ease, background-color 0.3s ease, border-color 0.3s ease;
}

/* Enhanced shadows for dark mode */
.dark .shadow-xl {
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
}

.dark .shadow-lg {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -2px rgba(0, 0, 0, 0.1);
}

/* Ensure proper contrast for icons */
.icon-primary {
    color: var(--text-primary);
}

.icon-secondary {
    color: var(--text-secondary);
}

/* Calendar icon styling */
.icon-calendar {
    color: var(--text-primary);
    transition: color 0.3s ease, transform 0.2s ease;
}

.icon-calendar:hover {
    color: var(--accent-color);
    transform: scale(1.1);
}

/* Filter section calendar icon specific styling */
.filter-calendar-icon {
    color: var(--text-primary);
    transition: all 0.3s ease;
    opacity: 0.8;
}

.filter-calendar-icon:hover {
    color: var(--accent-color);
    opacity: 1;
    transform: scale(1.05);
}

/* Calendar icon animation when date input is focused */
.attendance-form-input:focus + .filter-calendar-icon,
input[type="date"]:focus ~ label .filter-calendar-icon {
    color: var(--accent-color);
    opacity: 1;
    animation: pulse-calendar 1s ease-in-out;
}

@keyframes pulse-calendar {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Enhanced empty state calendar icon */
.empty-state .icon-secondary {
    opacity: 0.6;
    transition: opacity 0.3s ease;
}

.empty-state:hover .icon-secondary {
    opacity: 0.8;
}
</style>
<div class="container mx-auto px-6 py-8 attendance-log-container">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold flex items-center" style="color: var(--text-primary);">
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-list text-white text-xl"></i>
                </div>
                Log Absensi QR Code
            </h1>
            <p class="mt-2" style="color: var(--text-secondary);">Monitor dan analisis log absensi siswa secara real-time</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="<?php echo e(route('admin.qr-attendance.index')); ?>" 
               class="btn-secondary-custom px-4 py-2 rounded-lg flex items-center shadow-lg hover:shadow-xl">
                <i class="fas fa-arrow-left mr-2 icon-primary"></i>Kembali
            </a>
            <button type="button" onclick="exportLogs()" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-download mr-2"></i>Export CSV
            </button>
        </div>
    </div>

    <!-- Real-time Status -->
    <?php if(request('date', date('Y-m-d')) == date('Y-m-d')): ?>
    <div class="live-monitoring-card attendance-card rounded-2xl p-6 mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <div class="bg-blue-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-broadcast-tower text-white text-lg"></i>
                </div>
                <div>
                    <h3 class="text-lg font-semibold" style="color: var(--text-primary);">Live Monitoring</h3>
                    <p class="text-sm" style="color: var(--text-secondary);">Data diperbarui otomatis setiap 30 detik</p>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse mr-2"></div>
                    <span class="status-badge bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 px-4 py-2 rounded-full text-sm font-medium">Real-time</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filters -->
    <div class="attendance-card rounded-2xl shadow-xl mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-filter mr-2"></i>Filter Log Absensi
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('admin.qr-attendance.logs')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="date" class="block text-sm font-medium mb-2 flex items-center" style="color: var(--text-primary);">
                            <i class="fas fa-calendar-alt mr-2 filter-calendar-icon"></i>Tanggal
                        </label>
                        <input type="date" name="date" id="date" 
                               class="attendance-form-input w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-purple-500"
                               value="<?php echo e(request('date', date('Y-m-d'))); ?>">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Status</label>
                        <select name="status" id="status" class="attendance-form-input w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">Semua Status</option>
                            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($status); ?>" <?php echo e(request('status') == $status ? 'selected' : ''); ?>>
                                    <?php echo e(ucfirst($status)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="class" class="block text-sm font-medium mb-2" style="color: var(--text-primary);">Kelas</label>
                        <select name="class" id="class" class="attendance-form-input w-full px-3 py-2 rounded-lg focus:ring-2 focus:ring-purple-500">
                            <option value="">Semua Kelas</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>" <?php echo e(request('class') == $class->id ? 'selected' : ''); ?>>
                                    <?php echo e($class->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2" style="color: var(--text-primary);">&nbsp;</label>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-search mr-2"></i>Filter
                            </button>
                            <a href="<?php echo e(route('admin.qr-attendance.logs')); ?>" class="btn-secondary-custom px-4 py-2 rounded-lg flex items-center">
                                <i class="fas fa-undo mr-2 icon-primary"></i>Reset
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
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
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
                    <span style="color: var(--text-secondary);">Siswa tepat waktu</span>
                </div>
            </div>
        </div>

        <!-- Terlambat -->
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
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
                    <span style="color: var(--text-secondary);">Datang terlambat</span>
                </div>
            </div>
        </div>

        <!-- Izin/Sakit -->
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
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
                    <span style="color: var(--text-secondary);">Ada keterangan</span>
                </div>
            </div>
        </div>

        <!-- Alpha -->
        <div class="attendance-card rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-200">
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
                    <span style="color: var(--text-secondary);">Tanpa keterangan</span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Attendance Logs Table -->
    <div class="attendance-card rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-calendar-alt mr-2"></i>Log Absensi - <?php echo e(\Carbon\Carbon::parse(request('date', date('Y-m-d')))->format('d/m/Y')); ?>

            </h3>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="attendance-table min-w-full divide-y">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Waktu Scan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Lokasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">QR Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary);">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium" style="color: var(--text-primary);"><?php echo e($log->scan_time->format('H:i:s')); ?></div>
                                    <div class="text-sm" style="color: var(--text-secondary);"><?php echo e($log->attendance_date->format('d/m/Y')); ?></div>
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
                                            <div class="text-sm font-medium" style="color: var(--text-primary);"><?php echo e($log->student->name); ?></div>
                                            <div class="text-sm" style="color: var(--text-secondary);"><?php echo e($log->student->nis); ?></div>
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
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-secondary);">
                                    <?php echo e($log->location ?? '-'); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <code class="text-xs px-2 py-1 rounded" style="background: var(--bg-tertiary); color: var(--text-primary);">
                                        <?php echo e(Str::limit($log->qr_code, 20)); ?>

                                    </code>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm" style="color: var(--text-secondary);">
                                    <?php echo e($log->notes ?? '-'); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12">
                                    <div class="empty-state">
                                        <i class="fas fa-calendar-times text-4xl mb-4 icon-secondary"></i>
                                        <p class="text-lg">Tidak ada log absensi</p>
                                        <p class="text-sm">untuk filter yang dipilih</p>
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
                    <div class="pagination-wrapper" style="color: var(--text-primary);">
                        <?php echo e($logs->appends(request()->query())->links()); ?>

                    </div>
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
    params.set('export', 'excel');
    
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
    const downloadUrl = '<?php echo e(route("admin.qr-attendance.logs")); ?>?' + params.toString();
    
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