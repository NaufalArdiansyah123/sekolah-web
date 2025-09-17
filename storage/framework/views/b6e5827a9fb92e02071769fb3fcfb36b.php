<?php $__env->startSection('title', $pageTitle); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-600 dark:from-purple-600 dark:to-purple-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">🔥 Materi Populer</h1>
                <p class="text-purple-100 dark:text-purple-200">Materi pembelajaran yang paling banyak didownload oleh siswa</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-purple-200 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="flex items-center space-x-4">
        <a href="<?php echo e(route('student.materials.index')); ?>" 
           class="flex items-center text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 transition-colors duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Semua Materi
        </a>
    </div>

    <!-- Popular Materials Grid -->
    <?php if($materials->count() > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-all duration-200 hover:scale-105 relative">
                    <!-- Popularity Rank -->
                    <div class="absolute -top-2 -left-2 w-8 h-8 bg-purple-600 text-white rounded-full flex items-center justify-center text-sm font-bold z-10">
                        <?php echo e($index + 1); ?>

                    </div>

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
                                <!-- Hot Badge for top 3 -->
                                <?php if($index < 3): ?>
                                    <span class="px-2 py-1 text-xs font-bold bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 rounded-full animate-pulse">
                                        HOT
                                    </span>
                                <?php endif; ?>
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
                            <span class="px-2 py-1 text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 rounded-full">
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
                                <span class="flex items-center font-semibold text-purple-600 dark:text-purple-400">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <?php echo e(number_format($material->downloads)); ?>

                                </span>
                                <span><?php echo e($material->formatted_file_size); ?></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2">
                            <a href="<?php echo e(route('student.materials.show', $material->id)); ?>" 
                               class="flex-1 bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors duration-200">
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

                        <!-- Upload Date -->
                        <div class="mt-3 text-xs text-gray-400 dark:text-gray-500">
                            Diupload <?php echo e($material->created_at->format('d M Y')); ?>

                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Info Section -->
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-xl p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-2">Tentang Materi Populer</h3>
                    <p class="text-purple-800 dark:text-purple-200 text-sm leading-relaxed">
                        Materi-materi ini dipilih berdasarkan jumlah download terbanyak dari seluruh siswa. 
                        Materi populer biasanya merupakan materi yang sangat berguna dan berkualitas tinggi 
                        yang telah terbukti membantu banyak siswa dalam pembelajaran.
                    </p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada materi populer</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                Materi akan muncul di sini setelah ada yang mendownload.
            </p>
            <div class="mt-6">
                <a href="<?php echo e(route('student.materials.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700">
                    Lihat Semua Materi
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/materials/popular.blade.php ENDPATH**/ ?>