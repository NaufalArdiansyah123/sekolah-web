<?php $__env->startSection('title', $pageTitle); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 dark:from-blue-600 dark:to-blue-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">🆕 Materi Terbaru</h1>
                <p class="text-blue-100 dark:text-blue-200">Materi pembelajaran yang baru saja ditambahkan oleh guru</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-blue-200 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex items-center space-x-4">
        <a href="<?php echo e(route('student.materials.index')); ?>" 
           class="flex items-center text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Semua Materi
        </a>
    </div>

    <!-- Recent Materials Grid -->
    <?php if($materials->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-all duration-200 hover:scale-105 relative">
                    <!-- New Badge -->
                    <?php if($material->created_at->diffInDays(now()) <= 3): ?>
                        <div class="absolute -top-2 -right-2 px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded-full z-10 animate-pulse">
                            NEW
                        </div>
                    <?php endif; ?>

                    <div class="p-6">
                        <!-- Material Type Icon -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="text-3xl"><?php echo e($material->type_icon); ?></div>
                            <div class="flex items-center space-x-2">
                                <span class="px-2 py-1 text-xs font-medium rounded-full 
                                    <?php echo e($material->type == 'document' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : ''); ?>

                                    <?php echo e($material->type == 'video' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : ''); ?>

                                    <?php echo e($material->type == 'presentation' ? 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200' : ''); ?>

                                    <?php echo e($material->type == 'exercise' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : ''); ?>

                                    <?php echo e($material->type == 'audio' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200' : ''); ?>">
                                    <?php echo e(ucfirst($material->type)); ?>

                                </span>
                                <!-- Time indicator -->
                                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                    <?php echo e($material->created_at->diffForHumans()); ?>

                                </span>
                            </div>
                        </div>

                        <!-- Material Info -->
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2">
                            <?php echo e($material->title); ?>

                        </h3>
                        
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 line-clamp-2">
                            <?php echo e($material->description); ?>

                        </p>

                        <!-- Subject and Class -->
                        <div class="flex items-center space-x-2 mb-3">
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 rounded-full">
                                <?php echo e($material->subject); ?>

                            </span>
                            <span class="px-2 py-1 text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200 rounded-full">
                                <?php echo e($material->class); ?>

                            </span>
                        </div>

                        <!-- Teacher and Stats -->
                        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-4">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php echo e($material->teacher->name ?? 'Unknown'); ?>

                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <?php echo e($material->downloads); ?>

                                </span>
                                <span><?php echo e($material->formatted_file_size); ?></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('student.materials.show', $material->id)); ?>" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors duration-200">
                                Lihat Detail
                            </a>
                            <a href="<?php echo e(route('student.materials.download', $material->id)); ?>" 
                               class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded-lg font-medium transition-colors duration-200"
                               title="Download <?php echo e($material->title); ?>">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                        </div>

                        <!-- Upload Date with Time -->
                        <div class="mt-3 flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                            <span><?php echo e($material->created_at->format('d M Y, H:i')); ?></span>
                            <?php if($material->created_at->diffInHours(now()) <= 24): ?>
                                <span class="flex items-center text-blue-500 dark:text-blue-400">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Baru
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Info Section -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-2">Tentang Materi Terbaru</h3>
                    <p class="text-blue-800 dark:text-blue-200 text-sm leading-relaxed">
                        Halaman ini menampilkan materi pembelajaran yang baru saja ditambahkan oleh guru. 
                        Pastikan untuk selalu mengecek halaman ini secara berkala agar tidak ketinggalan 
                        materi pembelajaran terbaru yang mungkin penting untuk studi Anda.
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Hari Ini</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php echo e($materials->where('created_at', '>=', now()->startOfDay())->count()); ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Minggu Ini</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php echo e($materials->where('created_at', '>=', now()->startOfWeek())->count()); ?>

                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Bulan Ini</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">
                            <?php echo e($materials->where('created_at', '>=', now()->startOfMonth())->count()); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada materi terbaru</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Materi baru akan muncul di sini ketika guru menambahkan materi pembelajaran.
            </p>
            <div class="mt-6">
                <a href="<?php echo e(route('student.materials.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Lihat Semua Materi
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/materials/recent.blade.php ENDPATH**/ ?>