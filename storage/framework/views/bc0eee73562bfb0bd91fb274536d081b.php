<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 dark:from-purple-600 dark:to-indigo-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Nilai Akademik 📊</h1>
                <p class="text-purple-100 dark:text-purple-200">Lihat semua nilai dari tugas dan kuis yang telah dikerjakan</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-purple-200 dark:text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter and Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <!-- Semester Filter -->
                <form method="GET" class="flex space-x-2">
                    <select name="semester" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                        <option value="1" <?php echo e(request('semester', $currentSemester) == 1 ? 'selected' : ''); ?>>Semester 1</option>
                        <option value="2" <?php echo e(request('semester', $currentSemester) == 2 ? 'selected' : ''); ?>>Semester 2</option>
                    </select>
                    
                    <select name="year" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                        <?php for($year = now()->year; $year >= now()->year - 3; $year--): ?>
                            <option value="<?php echo e($year); ?>" <?php echo e(request('year', $currentYear) == $year ? 'selected' : ''); ?>><?php echo e($year); ?></option>
                        <?php endfor; ?>
                    </select>
                </form>
            </div>

            <div class="flex space-x-3">
                <a href="<?php echo e(route('student.grades.report')); ?>?semester=<?php echo e($currentSemester); ?>&year=<?php echo e($currentYear); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Rapor
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Nilai</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['total_grades']); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rata-rata</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($stats['average_score'], 1)); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/50">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Nilai Tertinggi</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['highest_score'] ?? 0); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Mata Pelajaran</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e($stats['subjects_count']); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Averages -->
    <?php if($subjectAverages->count() > 0): ?>
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Rata-rata per Mata Pelajaran</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <?php $__currentLoopData = $subjectAverages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 hover:bg-gray-100 dark:hover:bg-gray-600 transition-colors duration-200">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-medium text-gray-900 dark:text-white"><?php echo e($subject); ?></h4>
                                <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($data['count']); ?> nilai</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-2xl font-bold text-gray-900 dark:text-white"><?php echo e(number_format($data['average'], 1)); ?></div>
                                <div class="text-right">
                                    <?php
                                        $grade = '';
                                        if ($data['average'] >= 90) $grade = 'A';
                                        elseif ($data['average'] >= 80) $grade = 'B';
                                        elseif ($data['average'] >= 70) $grade = 'C';
                                        elseif ($data['average'] >= 60) $grade = 'D';
                                        else $grade = 'E';
                                        
                                        $color = '';
                                        if ($data['average'] >= 90) $color = 'green';
                                        elseif ($data['average'] >= 80) $color = 'blue';
                                        elseif ($data['average'] >= 70) $color = 'yellow';
                                        elseif ($data['average'] >= 60) $color = 'orange';
                                        else $color = 'red';
                                    ?>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-<?php echo e($color); ?>-100 text-<?php echo e($color); ?>-800 dark:bg-<?php echo e($color); ?>-900 dark:text-<?php echo e($color); ?>-200">
                                        Grade <?php echo e($grade); ?>

                                    </span>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="<?php echo e(route('student.grades.subject', $subject)); ?>?semester=<?php echo e($currentSemester); ?>&year=<?php echo e($currentYear); ?>" 
                                   class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                    Lihat Detail →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Recent Grades -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nilai Terbaru</h3>
                <?php if($grades->count() > 10): ?>
                    <button onclick="showAllGrades()" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                        Lihat Semua
                    </button>
                <?php endif; ?>
            </div>
        </div>
        
        <?php if($recentGrades->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Mata Pelajaran
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tugas/Kuis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tipe
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Nilai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Grade
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700" id="grades-table">
                        <?php $__currentLoopData = $recentGrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($grade->subject); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white"><?php echo e($grade->assessment_name); ?></div>
                                    <?php if($grade->teacher): ?>
                                        <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($grade->teacher->name); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?php if($grade->type === 'assignment'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        <?php elseif($grade->type === 'quiz'): ?> bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                        <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 <?php endif; ?>">
                                        <?php if($grade->type === 'assignment'): ?> Tugas
                                        <?php elseif($grade->type === 'quiz'): ?> Kuis
                                        <?php else: ?> <?php echo e(ucfirst($grade->type)); ?> <?php endif; ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        <?php echo e($grade->score); ?>

                                        <?php if($grade->max_score): ?>
                                            / <?php echo e($grade->max_score); ?>

                                        <?php endif; ?>
                                    </div>
                                    <?php if($grade->max_score): ?>
                                        <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($grade->percentage); ?>%</div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        <?php if($grade->grade_color === 'green'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        <?php elseif($grade->grade_color === 'blue'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        <?php elseif($grade->grade_color === 'yellow'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                        <?php elseif($grade->grade_color === 'orange'): ?> bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                        <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 <?php endif; ?>">
                                        <?php echo e($grade->letter_grade); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                    <?php echo e($grade->created_at->format('d M Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="<?php echo e(route('student.grades.show', $grade->id)); ?>" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Hidden rows for "Show All" functionality -->
            <?php if($grades->count() > 10): ?>
                <div id="hidden-grades" class="hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <?php $__currentLoopData = $grades->skip(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($grade->subject); ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 dark:text-white"><?php echo e($grade->assessment_name); ?></div>
                                            <?php if($grade->teacher): ?>
                                                <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($grade->teacher->name); ?></div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                <?php if($grade->type === 'assignment'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                <?php elseif($grade->type === 'quiz'): ?> bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200
                                                <?php else: ?> bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200 <?php endif; ?>">
                                                <?php if($grade->type === 'assignment'): ?> Tugas
                                                <?php elseif($grade->type === 'quiz'): ?> Kuis
                                                <?php else: ?> <?php echo e(ucfirst($grade->type)); ?> <?php endif; ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                <?php echo e($grade->score); ?>

                                                <?php if($grade->max_score): ?>
                                                    / <?php echo e($grade->max_score); ?>

                                                <?php endif; ?>
                                            </div>
                                            <?php if($grade->max_score): ?>
                                                <div class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($grade->percentage); ?>%</div>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                <?php if($grade->grade_color === 'green'): ?> bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                                <?php elseif($grade->grade_color === 'blue'): ?> bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                                <?php elseif($grade->grade_color === 'yellow'): ?> bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200
                                                <?php elseif($grade->grade_color === 'orange'): ?> bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200
                                                <?php else: ?> bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 <?php endif; ?>">
                                                <?php echo e($grade->letter_grade); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            <?php echo e($grade->created_at->format('d M Y')); ?>

                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="<?php echo e(route('student.grades.show', $grade->id)); ?>" 
                                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada nilai</h3>
                <p class="text-gray-500 dark:text-gray-400">Nilai akan muncul setelah tugas atau kuis dinilai oleh guru</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function showAllGrades() {
    const hiddenGrades = document.getElementById('hidden-grades');
    const gradesTable = document.getElementById('grades-table');
    
    if (hiddenGrades && gradesTable) {
        // Move hidden grades to main table
        const hiddenRows = hiddenGrades.querySelectorAll('tr');
        hiddenRows.forEach(row => {
            gradesTable.appendChild(row);
        });
        
        // Hide the "Show All" button
        event.target.style.display = 'none';
        
        // Remove hidden container
        hiddenGrades.remove();
    }
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/grades/index.blade.php ENDPATH**/ ?>