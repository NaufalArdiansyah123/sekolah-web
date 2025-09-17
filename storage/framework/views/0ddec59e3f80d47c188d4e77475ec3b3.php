<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        📝 Buat Tugas Baru
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Buat tugas baru untuk siswa Anda
                    </p>
                </div>
                
                <div class="mt-6 lg:mt-0">
                    <a href="<?php echo e(route('teacher.assignments.index')); ?>" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Kembali ke Daftar Tugas
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <form action="<?php echo e(route('teacher.assignments.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Informasi Tugas</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="<?php echo e(old('title')); ?>"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                               placeholder="Masukkan judul tugas..."
                               required>
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Subject and Class -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="subject" 
                                   id="subject" 
                                   value="<?php echo e(old('subject')); ?>"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                   placeholder="Contoh: Matematika"
                                   required>
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="class" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="class" 
                                   id="class" 
                                   value="<?php echo e(old('class')); ?>"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                   placeholder="Contoh: X IPA 1"
                                   required>
                            <?php $__errorArgs = ['class'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tipe Tugas <span class="text-red-500">*</span>
                            </label>
                            <select name="type" 
                                    id="type" 
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                    required>
                                <option value="">Pilih Tipe</option>
                                <option value="homework" <?php echo e(old('type') == 'homework' ? 'selected' : ''); ?>>Pekerjaan Rumah</option>
                                <option value="project" <?php echo e(old('type') == 'project' ? 'selected' : ''); ?>>Proyek</option>
                                <option value="essay" <?php echo e(old('type') == 'essay' ? 'selected' : ''); ?>>Esai</option>
                                <option value="quiz" <?php echo e(old('type') == 'quiz' ? 'selected' : ''); ?>>Kuis</option>
                                <option value="presentation" <?php echo e(old('type') == 'presentation' ? 'selected' : ''); ?>>Presentasi</option>
                            </select>
                            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi Tugas <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                  placeholder="Jelaskan tugas yang akan diberikan..."
                                  required><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Instruksi Khusus (Opsional)
                        </label>
                        <textarea name="instructions" 
                                  id="instructions" 
                                  rows="3" 
                                  class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                  placeholder="Berikan instruksi khusus jika diperlukan..."><?php echo e(old('instructions')); ?></textarea>
                        <?php $__errorArgs = ['instructions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Due Date and Max Score -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Batas Waktu <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" 
                                   name="due_date" 
                                   id="due_date" 
                                   value="<?php echo e(old('due_date')); ?>"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                   required>
                            <?php $__errorArgs = ['due_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div>
                            <label for="max_score" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nilai Maksimal <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="max_score" 
                                   id="max_score" 
                                   value="<?php echo e(old('max_score', 100)); ?>"
                                   min="1" 
                                   max="1000"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                                   required>
                            <?php $__errorArgs = ['max_score'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <!-- File Attachment -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            File Lampiran (Opsional)
                        </label>
                        <input type="file" 
                               name="attachment" 
                               id="attachment" 
                               class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                               accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Format yang didukung: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG. Maksimal 10MB.
                        </p>
                        <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status Publikasi
                        </label>
                        <select name="status" 
                                id="status" 
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                            <option value="draft" <?php echo e(old('status', 'draft') == 'draft' ? 'selected' : ''); ?>>Draft (Belum Dipublikasi)</option>
                            <option value="published" <?php echo e(old('status') == 'published' ? 'selected' : ''); ?>>Published (Langsung Terbit)</option>
                        </select>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            Draft: Tugas disimpan tapi belum terlihat siswa. Published: Tugas langsung terlihat siswa.
                        </p>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600">
                    <div class="flex justify-end space-x-3">
                        <a href="<?php echo e(route('teacher.assignments.index')); ?>" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Simpan Tugas
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set minimum date to current date
document.addEventListener('DOMContentLoaded', function() {
    const dueDateInput = document.getElementById('due_date');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    dueDateInput.min = now.toISOString().slice(0, 16);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.teacher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/teacher/learning/assignments/create.blade.php ENDPATH**/ ?>