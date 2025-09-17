<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        🧪 Kuis & Ujian
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Ikuti kuis dan ujian dari guru Anda
                    </p>
                </div>
                
                <!-- Quick Stats -->
                <div class="mt-6 lg:mt-0 grid grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400"><?php echo e($stats['total_quizzes'] ?? 0); ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Kuis</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400"><?php echo e($stats['completed'] ?? 0); ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Selesai</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400"><?php echo e($stats['available'] ?? 0); ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Tersedia</div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700">
                        <div class="text-2xl font-bold text-orange-600 dark:text-orange-400"><?php echo e($stats['upcoming'] ?? 0); ?></div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Akan Datang</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mata Pelajaran</label>
                    <select name="subject" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Mata Pelajaran</option>
                        <?php $__currentLoopData = $subjects ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($subject); ?>" <?php echo e(request('subject') == $subject ? 'selected' : ''); ?>>
                                <?php echo e($subject); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Status</option>
                        <option value="available" <?php echo e(request('status') == 'available' ? 'selected' : ''); ?>>Tersedia</option>
                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Sudah Selesai</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Quizzes Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $quizzes ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $attempt = $quiz->attempts->first();
                    $isActive = $quiz->start_time <= now() && $quiz->end_time >= now();
                    $isUpcoming = $quiz->start_time > now();
                    $isEnded = $quiz->end_time < now();
                ?>
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2">
                                <?php echo e($quiz->title); ?>

                            </h3>
                            <?php if($attempt && $attempt->status === 'completed'): ?>
                                <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs px-2 py-1 rounded-full">
                                    Selesai
                                </span>
                            <?php elseif($isActive): ?>
                                <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 text-xs px-2 py-1 rounded-full">
                                    Aktif
                                </span>
                            <?php elseif($isUpcoming): ?>
                                <span class="bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200 text-xs px-2 py-1 rounded-full">
                                    Akan Datang
                                </span>
                            <?php else: ?>
                                <span class="bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 text-xs px-2 py-1 rounded-full">
                                    Berakhir
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-4">
                            <?php echo e(Str::limit($quiz->description, 120)); ?>

                        </p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <?php echo e($quiz->subject); ?>

                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <?php echo e($quiz->teacher->name ?? 'Unknown Teacher'); ?>

                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Durasi: <?php echo e($quiz->duration_minutes); ?> menit
                            </div>
                            
                            <div class="flex items-center text-sm <?php echo e($isEnded ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400'); ?>">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-6 0h6m-6 0a1 1 0 00-1 1v10a1 1 0 001 1h6a1 1 0 001-1V8a1 1 0 00-1-1"></path>
                                </svg>
                                <?php if($isUpcoming): ?>
                                    Mulai: <?php echo e($quiz->start_time->format('d M Y, H:i')); ?>

                                <?php else: ?>
                                    Berakhir: <?php echo e($quiz->end_time->format('d M Y, H:i')); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="p-6">
                        <?php if($attempt && $attempt->status === 'completed'): ?>
                            <div class="space-y-2">
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Nilai: <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($attempt->score ?? 0); ?>%</span>
                                </div>
                                <a href="<?php echo e(route('student.quizzes.result', $attempt->id)); ?>" 
                                   class="w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors inline-block">
                                    Lihat Hasil
                                </a>
                            </div>
                        <?php else: ?>
                            <a href="<?php echo e(route('student.quizzes.show', $quiz->id)); ?>" 
                               class="w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors inline-block">
                                Lihat Detail
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada kuis</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Belum ada kuis yang tersedia saat ini.</p>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if(isset($quizzes) && $quizzes->hasPages()): ?>
            <div class="mt-8">
                <?php echo e($quizzes->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/quizzes/index.blade.php ENDPATH**/ ?>