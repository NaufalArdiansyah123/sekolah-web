<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Nilai</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1"><?php echo e($grade->subject); ?> • <?php echo e($grade->assessment_name); ?></p>
            </div>
            <a href="<?php echo e(route('student.grades.index')); ?>" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Nilai
            </a>
        </div>
    </div>

    <!-- Grade Information -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Grade Info -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Nilai</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Mata Pelajaran</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->subject); ?></p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Penilaian</label>
                        <p class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium 
                                <?php if($grade->type === 'assignment'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                <?php elseif($grade->type === 'quiz'): ?> bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                <?php elseif($grade->type === 'exam'): ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200
                                <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 <?php endif; ?>">
                                <?php if($grade->type === 'assignment'): ?> Tugas
                                <?php elseif($grade->type === 'quiz'): ?> Kuis
                                <?php elseif($grade->type === 'exam'): ?> Ujian
                                <?php else: ?> <?php echo e(ucfirst($grade->type)); ?> <?php endif; ?>
                            </span>
                        </p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Tugas/Kuis</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->assessment_name); ?></p>
                    </div>
                    
                    <?php if($grade->teacher): ?>
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Guru</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->teacher->name); ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tanggal Penilaian</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->created_at->format('d M Y, H:i')); ?></p>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Semester</label>
                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">Semester <?php echo e($grade->semester); ?> - <?php echo e($grade->year); ?></p>
                    </div>
                </div>
                
                <?php if($grade->notes): ?>
                    <div class="mt-6">
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Catatan Guru</label>
                        <div class="mt-2 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                            <p class="text-gray-900 dark:text-white"><?php echo e($grade->notes); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Score Card -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nilai</h3>
            </div>
            <div class="p-6">
                <div class="text-center">
                    <!-- Score Display -->
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                            <?php echo e($grade->score); ?>

                            <?php if($grade->max_score): ?>
                                <span class="text-2xl text-gray-500 dark:text-gray-400">/ <?php echo e($grade->max_score); ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if($grade->max_score): ?>
                            <div class="text-lg text-gray-600 dark:text-gray-400"><?php echo e($grade->percentage); ?>%</div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Grade Badge -->
                    <div class="mb-6">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-lg font-bold 
                            <?php if($grade->grade_color === 'green'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                            <?php elseif($grade->grade_color === 'blue'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                            <?php elseif($grade->grade_color === 'yellow'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                            <?php elseif($grade->grade_color === 'orange'): ?> bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                            <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 <?php endif; ?>">
                            Grade <?php echo e($grade->letter_grade); ?>

                        </span>
                    </div>
                    
                    <!-- Progress Bar -->
                    <?php if($grade->max_score): ?>
                        <div class="mb-4">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                <span>Progress</span>
                                <span><?php echo e($grade->percentage); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 dark:bg-gray-700">
                                <div class="h-3 rounded-full 
                                    <?php if($grade->grade_color === 'green'): ?> bg-green-600
                                    <?php elseif($grade->grade_color === 'blue'): ?> bg-blue-600
                                    <?php elseif($grade->grade_color === 'yellow'): ?> bg-yellow-600
                                    <?php elseif($grade->grade_color === 'orange'): ?> bg-orange-600
                                    <?php else: ?> bg-red-600 <?php endif; ?>" 
                                    style="width: <?php echo e($grade->percentage); ?>%"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Performance Indicator -->
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <?php if($grade->percentage >= 90): ?>
                            <span class="text-green-600 dark:text-green-400 font-medium">Sangat Baik</span>
                        <?php elseif($grade->percentage >= 80): ?>
                            <span class="text-blue-600 dark:text-blue-400 font-medium">Baik</span>
                        <?php elseif($grade->percentage >= 70): ?>
                            <span class="text-yellow-600 dark:text-yellow-400 font-medium">Cukup</span>
                        <?php elseif($grade->percentage >= 60): ?>
                            <span class="text-orange-600 dark:text-orange-400 font-medium">Kurang</span>
                        <?php else: ?>
                            <span class="text-red-600 dark:text-red-400 font-medium">Perlu Perbaikan</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Assignment/Quiz Info -->
    <?php if($grade->assignment || $grade->quiz): ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    <?php if($grade->assignment): ?> Informasi Tugas <?php else: ?> Informasi Kuis <?php endif; ?>
                </h3>
            </div>
            <div class="p-6">
                <?php if($grade->assignment): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Judul Tugas</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->assignment->title); ?></p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deadline</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                <?php echo e($grade->assignment->due_date ? $grade->assignment->due_date->format('d M Y, H:i') : 'Tidak ada deadline'); ?>

                            </p>
                        </div>
                        
                        <?php if($grade->assignment->description): ?>
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi Tugas</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white"><?php echo e($grade->assignment->description); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="md:col-span-2">
                            <a href="<?php echo e(route('student.assignments.show', $grade->assignment->id)); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail Tugas
                            </a>
                        </div>
                    </div>
                <?php elseif($grade->quiz): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Judul Kuis</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->quiz->title); ?></p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Durasi</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->quiz->duration_minutes); ?> menit</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah Soal</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($grade->quiz->questions->count()); ?> soal</p>
                        </div>
                        
                        <div>
                            <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Waktu Kuis</label>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                <?php echo e($grade->quiz->start_time->format('d M Y, H:i')); ?> - <?php echo e($grade->quiz->end_time->format('d M Y, H:i')); ?>

                            </p>
                        </div>
                        
                        <?php if($grade->quiz->description): ?>
                            <div class="md:col-span-2">
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Deskripsi Kuis</label>
                                <div class="mt-2 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <p class="text-gray-900 dark:text-white"><?php echo e($grade->quiz->description); ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <div class="md:col-span-2">
                            <a href="<?php echo e(route('student.quizzes.show', $grade->quiz->id)); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail Kuis
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Aksi Lainnya</h3>
                <p class="text-gray-600 dark:text-gray-400">Lihat nilai lainnya atau rapor lengkap</p>
            </div>
            
            <div class="flex space-x-3">
                <a href="<?php echo e(route('student.grades.subject', $grade->subject)); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    Nilai <?php echo e($grade->subject); ?>

                </a>
                
                <a href="<?php echo e(route('student.grades.report')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Rapor
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/grades/show.blade.php ENDPATH**/ ?>