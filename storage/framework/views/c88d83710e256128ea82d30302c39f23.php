<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($quiz->title); ?></h1>
                        <?php if($quiz->status === 'published'): ?>
                            <span class="bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-3 py-1 rounded-full text-sm font-medium">
                                Published
                            </span>
                        <?php else: ?>
                            <span class="bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 px-3 py-1 rounded-full text-sm font-medium">
                                Draft
                            </span>
                        <?php endif; ?>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400"><?php echo e($quiz->subject); ?></p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Kuis
                    </a>
                    
                    <?php if($quiz->status === 'draft'): ?>
                        <form action="<?php echo e(route('teacher.quizzes.publish', $quiz->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin mempublikasi kuis ini?')">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Publikasi
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="<?php echo e(route('teacher.quizzes.unpublish', $quiz->id)); ?>" method="POST" class="inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" 
                                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin meng-unpublish kuis ini?')">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Unpublish
                            </button>
                        </form>
                    <?php endif; ?>
                    
                    <form action="<?php echo e(route('teacher.quizzes.destroy', $quiz->id)); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kuis ini? Tindakan ini tidak dapat dibatalkan.')">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Soal</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($quiz->questions->count()); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Percobaan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($attemptStats['total_attempts']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($attemptStats['completed_attempts']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/50">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rata-rata Nilai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($attemptStats['average_score'], 1)); ?>%</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quiz Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Quiz Information -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Kuis</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi</label>
                            <p class="mt-1 text-gray-900 dark:text-white"><?php echo e($quiz->description ?: 'Tidak ada deskripsi'); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Mata Pelajaran</label>
                            <p class="mt-1 text-gray-900 dark:text-white"><?php echo e($quiz->subject); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Mulai</label>
                            <p class="mt-1 text-gray-900 dark:text-white"><?php echo e($quiz->start_time->format('d M Y, H:i')); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Berakhir</label>
                            <p class="mt-1 text-gray-900 dark:text-white"><?php echo e($quiz->end_time->format('d M Y, H:i')); ?></p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Durasi</label>
                            <p class="mt-1 text-gray-900 dark:text-white"><?php echo e($quiz->duration_minutes); ?> menit</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Maksimal Percobaan</label>
                            <p class="mt-1 text-gray-900 dark:text-white"><?php echo e($quiz->max_attempts); ?> kali</p>
                        </div>
                    </div>
                    
                    <?php if($quiz->instructions): ?>
                        <div class="mt-6">
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Instruksi</label>
                            <div class="mt-1 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                <p class="text-gray-900 dark:text-white"><?php echo e($quiz->instructions); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Questions List -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Soal (<?php echo e($quiz->questions->count()); ?>)</h3>
                </div>
                <div class="p-6">
                    <?php if($quiz->questions->count() > 0): ?>
                        <div class="space-y-6">
                            <?php $__currentLoopData = $quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-3">
                                        <h4 class="font-medium text-gray-900 dark:text-white">
                                            Soal <?php echo e($index + 1); ?>

                                            <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">(<?php echo e($question->points); ?> poin)</span>
                                        </h4>
                                        <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 px-2 py-1 rounded text-xs font-medium">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $question->type))); ?>

                                        </span>
                                    </div>
                                    
                                    <p class="text-gray-700 dark:text-gray-300 mb-3"><?php echo e($question->question); ?></p>
                                    
                                    <?php if($question->type === 'multiple_choice' && $question->options): ?>
                                        <div class="space-y-2">
                                            <?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center">
                                                    <span class="w-6 h-6 rounded-full border-2 <?php echo e($question->correct_answer === $key ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300'); ?> flex items-center justify-center text-sm font-medium mr-3">
                                                        <?php echo e($key); ?>

                                                    </span>
                                                    <span class="text-gray-700 dark:text-gray-300 <?php echo e($question->correct_answer === $key ? 'font-medium text-green-700 dark:text-green-400' : ''); ?>">
                                                        <?php echo e($option); ?>

                                                    </span>
                                                    <?php if($question->correct_answer === $key): ?>
                                                        <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    <?php endif; ?>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    <?php elseif($question->type === 'true_false'): ?>
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <span class="w-6 h-6 rounded-full border-2 <?php echo e($question->correct_answer === 'true' ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300'); ?> flex items-center justify-center text-sm font-medium mr-3">
                                                    T
                                                </span>
                                                <span class="text-gray-700 dark:text-gray-300 <?php echo e($question->correct_answer === 'true' ? 'font-medium text-green-700 dark:text-green-400' : ''); ?>">
                                                    Benar
                                                </span>
                                                <?php if($question->correct_answer === 'true'): ?>
                                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="w-6 h-6 rounded-full border-2 <?php echo e($question->correct_answer === 'false' ? 'bg-green-100 border-green-500 text-green-700' : 'border-gray-300'); ?> flex items-center justify-center text-sm font-medium mr-3">
                                                    F
                                                </span>
                                                <span class="text-gray-700 dark:text-gray-300 <?php echo e($question->correct_answer === 'false' ? 'font-medium text-green-700 dark:text-green-400' : ''); ?>">
                                                    Salah
                                                </span>
                                                <?php if($question->correct_answer === 'false'): ?>
                                                    <svg class="w-4 h-4 text-green-500 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php elseif($question->type === 'essay'): ?>
                                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                                            <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Soal essay - Perlu penilaian manual
                                            </p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Belum ada soal ditambahkan</p>
                            <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" 
                               class="mt-2 text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Tambah Soal
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi Cepat</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="<?php echo e(route('teacher.quizzes.attempts', $quiz->id)); ?>" 
                       class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Lihat Hasil Siswa
                    </a>
                    
                    <a href="<?php echo e(route('teacher.quizzes.edit', $quiz->id)); ?>" 
                       class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Kuis
                    </a>
                    
                    <a href="<?php echo e(route('teacher.quizzes.create')); ?>" 
                       class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Kuis Baru
                    </a>
                </div>
            </div>

            <!-- Quiz Settings -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengaturan</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Tampilkan Hasil</span>
                        <span class="text-sm font-medium <?php echo e($quiz->show_results ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e($quiz->show_results ? 'Ya' : 'Tidak'); ?>

                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Acak Soal</span>
                        <span class="text-sm font-medium <?php echo e($quiz->randomize_questions ? 'text-green-600' : 'text-red-600'); ?>">
                            <?php echo e($quiz->randomize_questions ? 'Ya' : 'Tidak'); ?>

                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Dibuat</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            <?php echo e($quiz->created_at->format('d M Y')); ?>

                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Terakhir Diubah</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            <?php echo e($quiz->updated_at->format('d M Y')); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teacher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/teacher/quizzes/show.blade.php ENDPATH**/ ?>