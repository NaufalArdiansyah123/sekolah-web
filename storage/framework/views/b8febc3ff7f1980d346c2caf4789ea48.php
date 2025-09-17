<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-purple-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Quiz Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        <?php echo e($attempt->quiz->title); ?>

                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        <?php echo e($attempt->quiz->subject); ?> • <?php echo e($attempt->quiz->teacher->name ?? 'Unknown Teacher'); ?>

                    </p>
                </div>
                
                <!-- Timer -->
                <div class="text-center">
                    <div id="timer" class="text-3xl font-bold text-red-600 dark:text-red-400">
                        <span id="minutes"><?php echo e($attempt->remaining_time); ?></span>:<span id="seconds">00</span>
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Waktu Tersisa</div>
                </div>
            </div>
        </div>

        <!-- Quiz Form -->
        <form id="quizForm" action="<?php echo e(route('student.quizzes.submit', $attempt->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="space-y-6">
                <?php $__currentLoopData = $attempt->quiz->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <!-- Question Header -->
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Soal <?php echo e($index + 1); ?>

                            </h3>
                            <span class="bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200 text-sm px-2 py-1 rounded">
                                <?php echo e($question->points); ?> poin
                            </span>
                        </div>
                        
                        <!-- Question Text -->
                        <div class="mb-6">
                            <p class="text-gray-900 dark:text-white text-base leading-relaxed">
                                <?php echo nl2br(e($question->question)); ?>

                            </p>
                        </div>
                        
                        <!-- Answer Options -->
                        <div class="space-y-3">
                            <?php if($question->type === 'multiple_choice'): ?>
                                <?php $__currentLoopData = $question->formatted_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                        <input type="radio" 
                                               name="answers[<?php echo e($question->id); ?>]" 
                                               value="<?php echo e($key); ?>" 
                                               class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-3 text-gray-900 dark:text-white"><?php echo e($option); ?></span>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php elseif($question->type === 'true_false'): ?>
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                    <input type="radio" 
                                           name="answers[<?php echo e($question->id); ?>]" 
                                           value="true" 
                                           class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <span class="ml-3 text-gray-900 dark:text-white">Benar</span>
                                </label>
                                <label class="flex items-center p-3 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer transition-colors">
                                    <input type="radio" 
                                           name="answers[<?php echo e($question->id); ?>]" 
                                           value="false" 
                                           class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500 dark:focus:ring-purple-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <span class="ml-3 text-gray-900 dark:text-white">Salah</span>
                                </label>
                            <?php elseif($question->type === 'essay'): ?>
                                <textarea name="answers[<?php echo e($question->id); ?>]" 
                                          rows="4" 
                                          class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                          placeholder="Tulis jawaban Anda di sini..."></textarea>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Submit Button -->
            <div class="mt-8 text-center">
                <button type="submit" 
                        id="submitBtn"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-8 py-3 rounded-lg font-medium transition-colors">
                    Selesai & Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Auto Submit Modal -->
<div id="autoSubmitModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Waktu Habis!</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Waktu kuis telah habis. Jawaban Anda akan otomatis dikirim.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <button id="autoSubmitBtn" class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Timer functionality
    let timeLeft = <?php echo e($attempt->remaining_time); ?> * 60; // Convert to seconds
    const timerElement = document.getElementById('timer');
    const minutesElement = document.getElementById('minutes');
    const secondsElement = document.getElementById('seconds');
    const form = document.getElementById('quizForm');
    const autoSubmitModal = document.getElementById('autoSubmitModal');
    const autoSubmitBtn = document.getElementById('autoSubmitBtn');
    
    function updateTimer() {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        
        minutesElement.textContent = minutes.toString().padStart(2, '0');
        secondsElement.textContent = seconds.toString().padStart(2, '0');
        
        // Change color when time is running out
        if (timeLeft <= 300) { // 5 minutes
            timerElement.className = 'text-3xl font-bold text-red-600 dark:text-red-400';
        } else if (timeLeft <= 600) { // 10 minutes
            timerElement.className = 'text-3xl font-bold text-orange-600 dark:text-orange-400';
        }
        
        if (timeLeft <= 0) {
            // Time's up - auto submit
            autoSubmitModal.classList.remove('hidden');
            return;
        }
        
        timeLeft--;
    }
    
    // Update timer every second
    const timerInterval = setInterval(updateTimer, 1000);
    
    // Auto submit when time is up
    autoSubmitBtn.addEventListener('click', function() {
        form.submit();
    });
    
    // Prevent accidental page refresh
    window.addEventListener('beforeunload', function(e) {
        e.preventDefault();
        e.returnValue = '';
    });
    
    // Auto-save answers (optional)
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            // Save to localStorage for recovery
            localStorage.setItem('quiz_' + <?php echo e($attempt->id); ?> + '_' + this.name, this.value);
        });
    });
    
    // Restore saved answers
    inputs.forEach(input => {
        const saved = localStorage.getItem('quiz_' + <?php echo e($attempt->id); ?> + '_' + input.name);
        if (saved) {
            if (input.type === 'radio') {
                if (input.value === saved) {
                    input.checked = true;
                }
            } else {
                input.value = saved;
            }
        }
    });
    
    // Clear saved answers on submit
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem('quiz_' + <?php echo e($attempt->id); ?> + '_' + input.name);
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.student', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/student/quizzes/take.blade.php ENDPATH**/ ?>