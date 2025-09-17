<?php
// resources/views/components/alerts.blade.php - Enhanced with Upload Error Handling
?>

<?php if(session('success')): ?>
    <div class="mb-4 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-200 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline"><?php echo e(session('success')); ?></span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-green-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-4 bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-200 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Error!</strong>
        <span class="block sm:inline"><?php echo e(session('error')); ?></span>
        
        <?php if(session('upload_error_details')): ?>
            <div class="mt-3 p-3 bg-red-50 dark:bg-red-800 border border-red-200 dark:border-red-700 rounded">
                <h4 class="font-semibold text-sm mb-2">Upload Configuration:</h4>
                <ul class="text-xs space-y-1">
                    <li><strong>Max POST Size:</strong> <?php echo e(session('upload_error_details.max_post_size')); ?> (<?php echo e(session('upload_error_details.max_post_size_mb')); ?>MB)</li>
                    <li><strong>Max Upload Size:</strong> <?php echo e(session('upload_error_details.max_upload_size')); ?> (<?php echo e(session('upload_error_details.max_upload_size_mb')); ?>MB)</li>
                </ul>
                <div class="mt-2">
                    <a href="<?php echo e(route('admin.videos.troubleshoot')); ?>" class="text-red-600 dark:text-red-400 underline text-xs">
                        → Troubleshoot Upload Issues
                    </a>
                </div>
            </div>
        <?php endif; ?>
        
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
<?php endif; ?>

<?php if(session('warning')): ?>
    <div class="mb-4 bg-yellow-100 dark:bg-yellow-900 border border-yellow-400 dark:border-yellow-600 text-yellow-700 dark:text-yellow-200 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Warning!</strong>
        <span class="block sm:inline"><?php echo e(session('warning')); ?></span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-yellow-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="mb-4 bg-blue-100 dark:bg-blue-900 border border-blue-400 dark:border-blue-600 text-blue-700 dark:text-blue-200 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Info!</strong>
        <span class="block sm:inline"><?php echo e(session('info')); ?></span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-blue-500 cursor-pointer" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" onclick="this.parentElement.parentElement.style.display='none'">
                <path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/>
            </svg>
        </span>
    </div>
<?php endif; ?>

<!-- PostTooLargeException Special Alert -->
<?php if(request()->header('Content-Length') && request()->header('Content-Length') > (int)ini_get('post_max_size') * 1024 * 1024): ?>
    <div class="mb-4 bg-orange-100 dark:bg-orange-900 border border-orange-400 dark:border-orange-600 text-orange-700 dark:text-orange-200 px-4 py-3 rounded relative" role="alert">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-orange-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium">Upload Size Warning</h3>
                <div class="mt-2 text-sm">
                    <p>File yang akan diupload mungkin terlalu besar untuk konfigurasi server saat ini.</p>
                    <div class="mt-2">
                        <strong>Current Limits:</strong>
                        <ul class="list-disc list-inside mt-1 text-xs">
                            <li>POST Max Size: <?php echo e(ini_get('post_max_size')); ?></li>
                            <li>Upload Max Filesize: <?php echo e(ini_get('upload_max_filesize')); ?></li>
                            <li>Max Execution Time: <?php echo e(ini_get('max_execution_time')); ?>s</li>
                        </ul>
                    </div>
                    <div class="mt-3">
                        <a href="<?php echo e(route('admin.videos.troubleshoot')); ?>" 
                           class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded text-orange-700 bg-orange-100 hover:bg-orange-200 dark:text-orange-200 dark:bg-orange-800 dark:hover:bg-orange-700">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Troubleshoot
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/components/alerts.blade.php ENDPATH**/ ?>