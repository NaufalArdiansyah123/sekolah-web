<?php $__env->startSection('title', $pageTitle); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-emerald-500 to-teal-600 dark:from-emerald-600 dark:to-teal-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Selamat Datang, <?php echo e(auth()->user()->name); ?>! 👋</h1>
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
        <!-- Total Materials -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Materi</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['total_materials']); ?></p>
                </div>
            </div>
        </div>

        <!-- Recent Materials -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-emerald-100 dark:bg-emerald-900/50">
                    <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Materi Terbaru</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['recent_materials']); ?></p>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kategori</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['categories']); ?></p>
                </div>
            </div>
        </div>

        <!-- Total Downloads -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-orange-100 dark:bg-orange-900/50">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Download</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($stats['total_downloads'])); ?></p>
                </div>
            </div>
        </div>

        <!-- Pending Assignments -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-red-100 dark:bg-red-900/50">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tugas Pending</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['pending_assignments']); ?></p>
                </div>
            </div>
        </div>

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
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['attendance_percentage']); ?>%</p>
                </div>
            </div>
        </div>

        <!-- Available Quizzes -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-indigo-100 dark:bg-indigo-900/50">
                    <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kuis Tersedia</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['available_quizzes']); ?></p>
                </div>
            </div>
        </div>

        <!-- Completed Quizzes -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-teal-100 dark:bg-teal-900/50">
                    <svg class="w-6 h-6 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Kuis Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['completed_quizzes']); ?></p>
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
                <a href="<?php echo e(route('student.materials.index')); ?>" 
                   class="flex items-center p-3 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 hover:bg-emerald-100 dark:hover:bg-emerald-900/30 transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <span class="text-emerald-700 dark:text-emerald-300 font-medium">Semua Materi</span>
                </a>
                
                <a href="<?php echo e(route('student.assignments.index')); ?>" 
                   class="flex items-center p-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="text-blue-700 dark:text-blue-300 font-medium">Tugas Saya</span>
                </a>
                
                <a href="<?php echo e(route('student.attendance.index')); ?>" 
                   class="flex items-center p-3 rounded-lg bg-purple-50 dark:bg-purple-900/20 hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-purple-700 dark:text-purple-300 font-medium">Absensi</span>
                </a>
                
                <a href="<?php echo e(route('student.quizzes.index')); ?>" 
                   class="flex items-center p-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 transition-all duration-200 hover:scale-105">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="text-indigo-700 dark:text-indigo-300 font-medium">Kuis & Ujian</span>
                </a>
            </div>
        </div>

        <!-- Recent Materials -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Materi Terbaru</h3>
                <a href="<?php echo e(route('student.materials.index')); ?>" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 text-sm font-medium transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
            
            <?php if($recentMaterials->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $recentMaterials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105">
                            <div class="p-2 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 mr-3">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate"><?php echo e($material->title); ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($material->subject); ?> • <?php echo e($material->formatted_file_size); ?></p>
                            </div>
                            <a href="<?php echo e(route('student.materials.show', $material->id)); ?>" 
                               class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada materi tersedia</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Assignments -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Tugas Terbaru</h3>
                <a href="<?php echo e(route('student.assignments.index')); ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 text-sm font-medium transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
            
            <?php if($recentAssignments->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $recentAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105">
                            <div class="p-2 rounded-lg bg-blue-100 dark:bg-blue-900/50 mr-3">
                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate"><?php echo e($assignment->title); ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Deadline: <?php echo e($assignment->formatted_due_date); ?> 
                                    <?php if($assignment->days_left >= 0): ?>
                                        <span class="text-orange-600 dark:text-orange-400">(<?php echo e($assignment->days_left); ?> hari lagi)</span>
                                    <?php else: ?>
                                        <span class="text-red-600 dark:text-red-400">(Terlambat)</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <a href="<?php echo e(route('student.assignments.show', $assignment->id)); ?>" 
                               class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada tugas baru</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Quizzes -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow duration-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Kuis Tersedia</h3>
                <a href="<?php echo e(route('student.quizzes.index')); ?>" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 text-sm font-medium transition-colors duration-200">
                    Lihat Semua
                </a>
            </div>
            
            <?php if($recentQuizzes->count() > 0): ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $recentQuizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-200 hover:scale-105">
                            <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 mr-3">
                                <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-white truncate"><?php echo e($quiz->title); ?></p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo e($quiz->subject); ?> • Berakhir: <?php echo e($quiz->formatted_end_time); ?>

                                    <?php if($quiz->hours_left > 0): ?>
                                        <span class="text-orange-600 dark:text-orange-400">(<?php echo e($quiz->hours_left); ?> jam lagi)</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <a href="<?php echo e(route('student.quizzes.show', $quiz->id)); ?>" 
                               class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors duration-200">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Tidak ada kuis tersedia</p>
                </div>
            <?php endif; ?>
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
                    <li>• Gunakan menu "Materi Pembelajaran" untuk melihat semua materi yang tersedia</li>
                    <li>• Klik "Download Materi" untuk mengunduh file yang Anda butuhkan</li>
                    <li>• Gunakan fitur pencarian untuk menemukan materi tertentu</li>
                    <li>• Filter berdasarkan kategori untuk mempermudah pencarian</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/dashboard.blade.php ENDPATH**/ ?>