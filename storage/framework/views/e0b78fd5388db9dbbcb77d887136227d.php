<?php $__env->startSection('title', 'Manajemen Absensi QR Code'); ?>

<?php $__env->startSection('content'); ?>

<style>
/* Force proper background colors for QR attendance page */
body {
    background-color: #f8fafc !important;
}

body.dark {
    background-color: #111827 !important;
}

.main-content {
    background-color: #f8fafc !important;
}

.dark .main-content {
    background-color: #111827 !important;
}

.content-card {
    background-color: #ffffff !important;
}

.dark .content-card {
    background-color: #1f2937 !important;
}
</style>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-qrcode text-white text-xl"></i>
                </div>
                Manajemen Absensi QR Code
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola QR Code dan monitor absensi siswa secara real-time</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button type="button" onclick="generateBulkQr()" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-plus mr-2"></i>Generate QR Massal
            </button>
            <a href="<?php echo e(route('admin.qr-attendance.logs')); ?>" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-list mr-2"></i>Log Absensi
            </a>
            <a href="<?php echo e(route('admin.qr-attendance.statistics')); ?>" 
               class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-chart-bar mr-2"></i>Statistik
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Siswa -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Siswa</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($stats['total_students']); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-users text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Seluruh siswa terdaftar</span>
                </div>
            </div>
        </div>

        <!-- Siswa dengan QR Code -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-100 text-sm font-medium">Siswa dengan QR</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($stats['students_with_qr']); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-qrcode text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-check-circle text-emerald-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">QR Code sudah dibuat</span>
                </div>
            </div>
        </div>

        <!-- Absensi Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Absensi Hari Ini</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($stats['today_attendance']); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-calendar-check text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-clock text-purple-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Total yang sudah absen</span>
                </div>
            </div>
        </div>

        <!-- Hadir Hari Ini -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden transform hover:scale-105 transition-transform duration-200">
            <div class="bg-gradient-to-r from-yellow-500 to-orange-500 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-medium">Hadir Hari Ini</p>
                        <p class="text-white text-2xl font-bold"><?php echo e($stats['present_today']); ?></p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-xl">
                        <i class="fas fa-user-check text-white text-xl"></i>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <div class="flex items-center text-sm">
                    <i class="fas fa-thumbs-up text-yellow-500 mr-2"></i>
                    <span class="text-gray-600 dark:text-gray-400">Status hadir & terlambat</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 mb-8 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-filter mr-2"></i>Filter Data Siswa
            </h3>
        </div>
        <div class="p-6">
            <form method="GET" action="<?php echo e(route('admin.qr-attendance.index')); ?>">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kelas</label>
                        <select name="class" id="class" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            <option value="">Semua Kelas</option>
                            <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($class->id); ?>" <?php echo e(request('class') == $class->id ? 'selected' : ''); ?>>
                                    <?php echo e($class->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cari Siswa</label>
                        <input type="text" name="search" id="search" 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                               placeholder="Nama, NIS, atau NISN" value="<?php echo e(request('search')); ?>">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">&nbsp;</label>
                        <div class="flex space-x-2">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-search mr-2"></i>Cari
                            </button>
                            <a href="<?php echo e(route('admin.qr-attendance.index')); ?>" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors duration-200 flex items-center">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Students Table -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-600 px-6 py-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h3 class="text-lg font-semibold text-white mb-4 sm:mb-0 flex items-center">
                    <i class="fas fa-table mr-2"></i>Data Siswa
                </h3>
                <div class="flex items-center bg-white/20 rounded-lg px-3 py-2">
                    <input type="checkbox" id="selectAll" class="rounded border-white/30 text-teal-600 focus:ring-teal-500 bg-white/20">
                    <label for="selectAll" class="ml-2 text-sm text-white font-medium">Pilih Semua</label>
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <input type="checkbox" id="selectAllHeader" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Siswa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">NIS</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Kelas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">QR Code</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Absensi Hari Ini</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" class="student-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="<?php echo e($student->id); ?>">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if($student->photo_url): ?>
                                            <img src="<?php echo e($student->photo_url); ?>" alt="<?php echo e($student->name); ?>" 
                                                 class="w-12 h-12 rounded-full border-2 border-gray-200 dark:border-gray-600">
                                        <?php else: ?>
                                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                <?php echo e($student->initials); ?>

                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($student->name); ?></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($student->email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo e($student->nis); ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                        <?php if($student->class_id && $student->class): ?>
                                            <?php echo e($student->class->name); ?>

                                        <?php else: ?>
                                            Kelas Belum Ditentukan
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($student->qrAttendance): ?>
                                        <div class="flex items-center">
                                            <div class="flex items-center">
                                                <i class="fas fa-qrcode text-emerald-500 mr-2"></i>
                                                <span class="text-emerald-600 dark:text-emerald-400 text-sm font-medium">Ada</span>
                                            </div>
                                            <button type="button" onclick="viewQrCode(<?php echo e($student->id); ?>)" 
                                                    class="ml-3 bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-600 dark:text-blue-400 p-2 rounded-lg transition-colors duration-200">
                                                <i class="fas fa-eye text-sm"></i>
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-times text-red-500 mr-2"></i>
                                            <span class="text-red-600 dark:text-red-400 text-sm font-medium">Belum Ada</span>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($student->attendanceLogs->isNotEmpty()): ?>
                                        <?php $todayLog = $student->attendanceLogs->first(); ?>
                                        <?php
                                            $badgeColor = match($todayLog->status) {
                                                'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                                'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                                'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                                default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                            };
                                        ?>
                                        <span class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($badgeColor); ?>">
                                            <?php echo e($todayLog->status_text); ?>

                                        </span>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 mt-1"><?php echo e($todayLog->scan_time->format('H:i')); ?></div>
                                    <?php else: ?>
                                        <span class="text-gray-500 dark:text-gray-400 text-sm">Belum Absen</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex space-x-2">
                                        <?php if($student->qrAttendance): ?>
                                            <button type="button" onclick="regenerateQr(<?php echo e($student->id); ?>)" 
                                                    class="bg-yellow-100 hover:bg-yellow-200 dark:bg-yellow-900 dark:hover:bg-yellow-800 text-yellow-600 dark:text-yellow-400 p-2 rounded-lg transition-colors duration-200" 
                                                    title="Generate Ulang QR">
                                                <i class="fas fa-redo text-sm"></i>
                                            </button>
                                            <a href="<?php echo e(route('admin.qr-attendance.download', $student)); ?>" 
                                               class="bg-emerald-100 hover:bg-emerald-200 dark:bg-emerald-900 dark:hover:bg-emerald-800 text-emerald-600 dark:text-emerald-400 p-2 rounded-lg transition-colors duration-200" 
                                               title="Download QR">
                                                <i class="fas fa-download text-sm"></i>
                                            </a>
                                        <?php else: ?>
                                            <button type="button" onclick="generateQr(<?php echo e($student->id); ?>)" 
                                                    class="bg-blue-100 hover:bg-blue-200 dark:bg-blue-900 dark:hover:bg-blue-800 text-blue-600 dark:text-blue-400 p-2 rounded-lg transition-colors duration-200" 
                                                    title="Generate QR">
                                                <i class="fas fa-qrcode text-sm"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users text-4xl text-gray-400 dark:text-gray-500 mb-4"></i>
                                        <p class="text-gray-500 dark:text-gray-400 text-lg">Tidak ada data siswa</p>
                                        <p class="text-gray-400 dark:text-gray-500 text-sm">Coba ubah filter pencarian</p>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if($students->hasPages()): ?>
                <div class="mt-6 flex justify-center">
                    <?php echo e($students->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

<!-- QR Code Modal -->
<div id="qrCodeModal" class="fixed inset-0 bg-black bg-opacity-50 dark:bg-black dark:bg-opacity-70 hidden items-center justify-center z-50" onclick="closeModal('qrCodeModal')">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4 border border-gray-200 dark:border-gray-700" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4 rounded-t-2xl">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold text-white">QR Code Siswa</h3>
                <button onclick="closeModal('qrCodeModal')" class="text-white hover:text-gray-200 transition-colors p-1 rounded-lg hover:bg-white/10">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <div class="p-6">
            <div id="qrCodeContent" class="text-center">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 dark:border-blue-400 mx-auto"></div>
                <p class="text-gray-600 dark:text-gray-400 mt-3">Loading...</p>
            </div>
        </div>
        <div class="px-6 pb-6 flex gap-3">
            <button onclick="closeModal('qrCodeModal')" class="flex-1 bg-gray-600 hover:bg-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition-colors">
                Tutup
            </button>
            <button type="button" id="downloadQrBtn" class="flex-1 bg-blue-600 hover:bg-blue-700 dark:bg-blue-700 dark:hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i>Download
            </button>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Check if SweetAlert2 is loaded
if (typeof Swal === 'undefined') {
    console.error('SweetAlert2 not loaded, loading fallback...');
    
    // Load SweetAlert2 dynamically if not loaded
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    script.onload = function() {
        console.log('SweetAlert2 loaded successfully');
    };
    script.onerror = function() {
        console.error('Failed to load SweetAlert2, using native confirm dialogs');
        // Create fallback Swal object
        window.Swal = {
            fire: function(options) {
                if (typeof options === 'string') {
                    alert(options);
                    return Promise.resolve({ isConfirmed: true });
                }
                
                if (options.showCancelButton) {
                    const result = confirm(options.title + '\n' + (options.text || ''));
                    return Promise.resolve({ isConfirmed: result });
                } else {
                    alert(options.title + '\n' + (options.text || ''));
                    return Promise.resolve({ isConfirmed: true });
                }
            },
            showLoading: function() {
                console.log('Loading...');
            },
            close: function() {
                console.log('Dialog closed');
            }
        };
    };
    document.head.appendChild(script);
}

// Select all functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

document.getElementById('selectAllHeader').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});

// Generate QR Code for single student
function generateQr(studentId) {
    // Check if SweetAlert2 is available
    if (typeof Swal === 'undefined') {
        if (confirm('Generate QR Code untuk siswa ini?')) {
            generateQrWithoutSwal(studentId);
        }
        return;
    }
    
    Swal.fire({
        title: 'Generate QR Code',
        text: 'Generate QR Code untuk siswa ini?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Generate!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Generating...',
                text: 'Sedang membuat QR Code',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/qr-attendance/generate/${studentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

// Regenerate QR Code
function regenerateQr(studentId) {
    // Check if SweetAlert2 is available
    if (typeof Swal === 'undefined') {
        regenerateQrWithoutSwal(studentId);
        return;
    }
    
    Swal.fire({
        title: 'Generate Ulang QR Code',
        text: 'Generate ulang QR Code untuk siswa ini? QR Code lama akan tidak berlaku.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f59e0b',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Generate Ulang!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Regenerating...',
                text: 'Sedang membuat ulang QR Code',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(`/admin/qr-attendance/regenerate/${studentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

// Generate bulk QR codes
function generateBulkQr() {
    const selectedStudents = Array.from(document.querySelectorAll('.student-checkbox:checked'))
                                  .map(checkbox => checkbox.value);
    
    if (selectedStudents.length === 0) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan!',
                text: 'Pilih minimal satu siswa',
                confirmButtonColor: '#f59e0b'
            });
        } else {
            alert('Peringatan! Pilih minimal satu siswa');
        }
        return;
    }
    
    // Check if SweetAlert2 is available
    if (typeof Swal === 'undefined') {
        if (confirm(`Generate QR Code untuk ${selectedStudents.length} siswa yang dipilih?`)) {
            generateBulkQrWithoutSwal(selectedStudents);
        }
        return;
    }
    
    Swal.fire({
        title: 'Generate QR Code Massal',
        text: `Generate QR Code untuk ${selectedStudents.length} siswa yang dipilih?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Ya, Generate!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Generating...',
                text: `Sedang membuat QR Code untuk ${selectedStudents.length} siswa`,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch('/admin/qr-attendance/generate-bulk', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    student_ids: selectedStudents
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        confirmButtonColor: '#10b981'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message,
                        confirmButtonColor: '#ef4444'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan sistem',
                    confirmButtonColor: '#ef4444'
                });
            });
        }
    });
}

// View QR Code
function viewQrCode(studentId) {
    document.getElementById('qrCodeModal').classList.remove('hidden');
    document.getElementById('qrCodeModal').classList.add('flex');
    
    // Reset content
    document.getElementById('qrCodeContent').innerHTML = `
        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
        <p class="text-gray-600 dark:text-gray-400 mt-3">Loading...</p>
    `;
    
    // Fetch QR code data
    fetch(`/admin/qr-attendance/view/${studentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('qrCodeContent').innerHTML = `
                    <div class="text-center">
                        <img src="${data.qr_image_url}" alt="QR Code" class="max-w-xs mx-auto mb-4 rounded-lg shadow-lg">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">${data.student.name}</h4>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">NIS: ${data.student.nis} | Kelas: ${data.student.class}</p>
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <p class="text-sm text-blue-700 dark:text-blue-300">
                                <i class="fas fa-info-circle mr-1"></i>
                                QR Code untuk absensi siswa
                            </p>
                        </div>
                    </div>
                `;
                
                // Update download button
                document.getElementById('downloadQrBtn').onclick = () => {
                    window.open(data.download_url, '_blank');
                };
            } else {
                document.getElementById('qrCodeContent').innerHTML = `
                    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                        <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 mr-2"></i>
                        <span class="text-red-800 dark:text-red-200">${data.message}</span>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('qrCodeContent').innerHTML = `
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                    <i class="fas fa-times text-red-600 dark:text-red-400 mr-2"></i>
                    <span class="text-red-800 dark:text-red-200">Terjadi kesalahan saat memuat QR Code</span>
                </div>
            `;
        });
}

// Generate QR without SweetAlert (fallback)
function generateQrWithoutSwal(studentId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page.');
        return;
    }
    
    console.log('Generating QR for student:', studentId);
    
    fetch(`/admin/qr-attendance/generate/${studentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    })
    .then(response => {
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            alert('Berhasil! ' + data.message);
            location.reload();
        } else {
            alert('Error! ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        let errorMessage = 'Terjadi kesalahan sistem';
        
        if (error.message.includes('404')) {
            errorMessage = 'Route tidak ditemukan. Periksa konfigurasi route.';
        } else if (error.message.includes('403')) {
            errorMessage = 'Akses ditolak. Periksa permission.';
        } else if (error.message.includes('419')) {
            errorMessage = 'CSRF token expired. Refresh halaman dan coba lagi.';
        } else if (error.message.includes('500')) {
            errorMessage = 'Server error. Periksa log Laravel.';
        }
        
        alert('Error! ' + errorMessage + '\n\nDebug: ' + error.message);
    });
}

// Generate bulk QR without SweetAlert (fallback)
function generateBulkQrWithoutSwal(selectedStudents) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page.');
        return;
    }
    
    console.log('Generating bulk QR for students:', selectedStudents);
    
    fetch('/admin/qr-attendance/generate-bulk', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
        body: JSON.stringify({
            student_ids: selectedStudents
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP ${response.status}: ${response.statusText}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            alert('Berhasil! ' + data.message);
            location.reload();
        } else {
            alert('Error! ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error! Terjadi kesalahan sistem: ' + error.message);
    });
}

// Regenerate QR without SweetAlert (fallback)
function regenerateQrWithoutSwal(studentId) {
    if (!confirm('Generate ulang QR Code untuk siswa ini? QR Code lama akan tidak berlaku.')) {
        return;
    }
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (!csrfToken) {
        alert('CSRF token not found. Please refresh the page.');
        return;
    }
    
    fetch(`/admin/qr-attendance/regenerate/${studentId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Berhasil! ' + data.message);
            location.reload();
        } else {
            alert('Error! ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error! Terjadi kesalahan sistem');
    });
}

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.getElementById(modalId).classList.remove('flex');
}


function testSweetAlert() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'SweetAlert Test',
            text: 'SweetAlert2 is working!',
            icon: 'success'
        });
    } else {
        alert('SweetAlert2 is not loaded');
    }
}

// Log SweetAlert status on page load
document.addEventListener('DOMContentLoaded', function() {
    console.log('Page loaded. SweetAlert2 status:', typeof Swal !== 'undefined' ? 'Loaded' : 'Not loaded');
    
    if (typeof Swal === 'undefined') {
        console.warn('⚠️ SweetAlert2 not available. Using fallback dialogs.');
        
        // Show warning to user
        const warningDiv = document.createElement('div');
        warningDiv.style.cssText = `
            position: fixed;
            top: 10px;
            right: 10px;
            background: #ffc107;
            color: #212529;
            padding: 10px 15px;
            border-radius: 5px;
            z-index: 9999;
            font-size: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 300px;
        `;
        warningDiv.innerHTML = '⚠️ Using fallback dialogs (SweetAlert2 not loaded)';
        document.body.appendChild(warningDiv);
        
        setTimeout(() => {
            if (document.body.contains(warningDiv)) {
                document.body.removeChild(warningDiv);
            }
        }, 5000);
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/qr-attendance/index.blade.php ENDPATH**/ ?>