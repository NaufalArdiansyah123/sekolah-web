<?php $__env->startSection('title', 'SuperAdmin Dashboard'); ?>
<?php $__env->startSection('page-title', 'SuperAdmin Dashboard'); ?>
<?php $__env->startSection('page-description', 'Kontrol penuh sistem sekolah dengan akses ke semua fitur'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- System Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 dark:bg-blue-900/20 p-3 rounded-xl">
                    <i class="fas fa-users text-blue-600 dark:text-blue-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($system_overview['total_users'] ?? 0); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400">Total Users</p>
                    <div class="flex items-center mt-1">
                        <span class="text-green-500 text-sm">
                            <i class="fas fa-check-circle mr-1"></i><?php echo e($system_overview['active_users'] ?? 0); ?> Active
                        </span>
                        <?php if(($system_overview['pending_users'] ?? 0) > 0): ?>
                            <span class="text-yellow-500 text-sm ml-2">
                                <i class="fas fa-clock mr-1"></i><?php echo e($system_overview['pending_users']); ?> Pending
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Students -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="bg-green-100 dark:bg-green-900/20 p-3 rounded-xl">
                    <i class="fas fa-user-graduate text-green-600 dark:text-green-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($system_overview['total_students'] ?? 0); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400">Total Students</p>
                    <p class="text-green-500 text-sm mt-1">
                        <i class="fas fa-arrow-up mr-1"></i>Active Learning
                    </p>
                </div>
            </div>
        </div>

        <!-- Teachers -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 dark:bg-purple-900/20 p-3 rounded-xl">
                    <i class="fas fa-chalkboard-teacher text-purple-600 dark:text-purple-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($system_overview['total_teachers'] ?? 0); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400">Total Teachers</p>
                    <p class="text-purple-500 text-sm mt-1">
                        <i class="fas fa-graduation-cap mr-1"></i>Teaching Staff
                    </p>
                </div>
            </div>
        </div>

        <!-- Security Status -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex items-center">
                <div class="bg-red-100 dark:bg-red-900/20 p-3 rounded-xl">
                    <i class="fas fa-shield-alt text-red-600 dark:text-red-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white"><?php echo e($security_overview['total_violations'] ?? 0); ?></h3>
                    <p class="text-gray-600 dark:text-gray-400">Security Violations</p>
                    <?php if(($security_overview['pending_violations'] ?? 0) > 0): ?>
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-triangle mr-1"></i><?php echo e($security_overview['pending_violations']); ?> Pending
                        </p>
                    <?php else: ?>
                        <p class="text-green-500 text-sm mt-1">
                            <i class="fas fa-check mr-1"></i>All Clear
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
            <i class="fas fa-bolt mr-3 text-yellow-500"></i>Quick Actions
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php $__currentLoopData = $quick_actions ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $action): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($action['url']); ?>" 
                   class="flex items-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-<?php echo e($action['color']); ?>-50 dark:hover:bg-<?php echo e($action['color']); ?>-900/20 transition-all duration-200 group border border-transparent hover:border-<?php echo e($action['color']); ?>-200 dark:hover:border-<?php echo e($action['color']); ?>-800">
                    <div class="bg-<?php echo e($action['color']); ?>-100 dark:bg-<?php echo e($action['color']); ?>-900/20 p-3 rounded-lg group-hover:bg-<?php echo e($action['color']); ?>-200 dark:group-hover:bg-<?php echo e($action['color']); ?>-900/40 transition-colors duration-200">
                        <i class="<?php echo e($action['icon']); ?> text-<?php echo e($action['color']); ?>-600 dark:text-<?php echo e($action['color']); ?>-400 text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-<?php echo e($action['color']); ?>-700 dark:group-hover:text-<?php echo e($action['color']); ?>-300"><?php echo e($action['title']); ?></h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400"><?php echo e($action['description']); ?></p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Statistics -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-chart-pie mr-3 text-blue-500"></i>User Statistics by Role
            </h2>
            <div class="space-y-4">
                <?php $__currentLoopData = $user_statistics['by_role'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <?php
                                $roleColors = [
                                    'superadmin' => 'red',
                                    'admin' => 'blue',
                                    'teacher' => 'green',
                                    'student' => 'purple'
                                ];
                                $color = $roleColors[$role->role_name] ?? 'gray';
                            ?>
                            <div class="w-4 h-4 bg-<?php echo e($color); ?>-500 rounded-full mr-3"></div>
                            <span class="text-gray-700 dark:text-gray-300 capitalize"><?php echo e($role->role_name); ?></span>
                        </div>
                        <span class="font-semibold text-gray-900 dark:text-white"><?php echo e($role->count); ?></span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        <!-- System Health -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-heartbeat mr-3 text-green-500"></i>System Health
            </h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Database</span>
                    <span class="px-3 py-1 rounded-full text-sm <?php echo e(($system_health['database_connection'] ?? '') === 'Connected' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'); ?>">
                        <?php echo e($system_health['database_connection'] ?? 'Unknown'); ?>

                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Cache</span>
                    <span class="px-3 py-1 rounded-full text-sm <?php echo e(($system_health['cache_status'] ?? '') === 'Working' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'); ?>">
                        <?php echo e($system_health['cache_status'] ?? 'Unknown'); ?>

                    </span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 dark:text-gray-300">PHP Version</span>
                    <span class="text-gray-900 dark:text-white font-mono text-sm"><?php echo e($system_health['php_version'] ?? 'Unknown'); ?></span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-gray-700 dark:text-gray-300">Laravel Version</span>
                    <span class="text-gray-900 dark:text-white font-mono text-sm"><?php echo e($system_health['laravel_version'] ?? 'Unknown'); ?></span>
                </div>
                <?php if(isset($system_health['storage_usage'])): ?>
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-gray-700 dark:text-gray-300">Storage Usage</span>
                            <span class="text-gray-900 dark:text-white text-sm"><?php echo e($system_health['storage_usage']['percentage']); ?>%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: <?php echo e($system_health['storage_usage']['percentage']); ?>%"></div>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            <?php echo e($system_health['storage_usage']['used']); ?> / <?php echo e($system_health['storage_usage']['total']); ?>

                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
            <i class="fas fa-clock mr-3 text-indigo-500"></i>Recent Activities
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Registrations -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Registrations</h3>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $user_statistics['recent_registrations'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-semibold"><?php echo e(substr($user->name, 0, 1)); ?></span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($user->name); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($user->email); ?></p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($user->created_at->diffForHumans()); ?></p>
                                <span class="px-2 py-1 text-xs rounded-full <?php echo e($user->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200'); ?>">
                                    <?php echo e(ucfirst($user->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-500 dark:text-gray-400 text-center py-4">No recent registrations</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Security Violations -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Recent Security Violations</h3>
                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $security_overview['recent_violations'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $violation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="flex items-center justify-between p-3 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-triangle text-white text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">QR Code Violation</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <?php echo e($violation->violatorStudent->name ?? 'Unknown'); ?> → <?php echo e($violation->qrOwnerStudent->name ?? 'Unknown'); ?>

                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($violation->violation_time->diffForHumans()); ?></p>
                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    <?php echo e(ucfirst($violation->status)); ?>

                                </span>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-4">
                            <i class="fas fa-shield-alt text-green-500 text-2xl mb-2"></i>
                            <p class="text-green-600 dark:text-green-400">No security violations</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">System is secure</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Role & Permission Matrix -->
    <?php if(isset($role_statistics['role_permission_matrix']) && !empty($role_statistics['role_permission_matrix'])): ?>
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 p-6">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6 flex items-center">
                <i class="fas fa-table mr-3 text-purple-500"></i>Role & Permission Matrix
            </h2>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-3 px-4 font-semibold text-gray-900 dark:text-white">Permission</th>
                            <?php $__currentLoopData = array_keys($role_statistics['role_permission_matrix']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th class="text-center py-3 px-4 font-semibold text-gray-900 dark:text-white capitalize"><?php echo e($role); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $allPermissions = [];
                            foreach($role_statistics['role_permission_matrix'] as $rolePerms) {
                                $allPermissions = array_merge($allPermissions, array_keys($rolePerms));
                            }
                            $allPermissions = array_unique($allPermissions);
                        ?>
                        <?php $__currentLoopData = array_slice($allPermissions, 0, 10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-100 dark:border-gray-600">
                                <td class="py-2 px-4 text-sm text-gray-700 dark:text-gray-300"><?php echo e($permission); ?></td>
                                <?php $__currentLoopData = array_keys($role_statistics['role_permission_matrix']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="py-2 px-4 text-center">
                                        <?php if($role_statistics['role_permission_matrix'][$role][$permission] ?? false): ?>
                                            <i class="fas fa-check text-green-500"></i>
                                        <?php else: ?>
                                            <i class="fas fa-times text-red-500"></i>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php if(count($allPermissions) > 10): ?>
                    <div class="mt-4 text-center">
                        <a href="<?php echo e(route('superadmin.roles.matrix')); ?>" class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                            View Full Matrix (<?php echo e(count($allPermissions)); ?> permissions)
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-refresh dashboard every 5 minutes
    setInterval(function() {
        if (document.visibilityState === 'visible') {
            window.location.reload();
        }
    }, 300000);

    // Real-time notifications (placeholder)
    function checkNotifications() {
        // This would connect to a real-time notification system
        console.log('Checking for new notifications...');
    }

    // Check notifications every 30 seconds
    setInterval(checkNotifications, 30000);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.superadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/superadmin/dashboard.blade.php ENDPATH**/ ?>