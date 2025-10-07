<?php $__env->startSection('title', 'System Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="settings-page">
        <!-- Simple Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">System Settings</h1>
                <p class="page-subtitle">Configure your school management system</p>
            </div>
        </div>

        <!-- Main Settings Container -->
        <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data" id="settingsForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="settings-container">
                <!-- Simple Tab Navigation -->
                <div class="tab-navigation">
                    <div class="nav-tabs">
                        <button type="button" class="nav-tab active" data-tab="school">
                            <i class="fas fa-school"></i>
                            <span>School</span>
                        </button>
                        <button type="button" class="nav-tab" data-tab="academic">
                            <i class="fas fa-graduation-cap"></i>
                            <span>Academic</span>
                        </button>
                        <button type="button" class="nav-tab" data-tab="system">
                            <i class="fas fa-cog"></i>
                            <span>System</span>
                        </button>
                        <button type="button" class="nav-tab" data-tab="footer">
                            <i class="fas fa-globe"></i>
                            <span>Footer</span>
                        </button>
                        <button type="button" class="nav-tab" data-tab="backup">
                            <i class="fas fa-database"></i>
                            <span>Backup</span>
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- School Settings Panel -->
                    <div class="tab-panel active" id="school-panel">
                        <div class="panel-header">
                            <h2>School Settings</h2>
                            <p>Configure school identity and logo</p>
                        </div>

                        <div class="settings-grid">
                            <!-- School Identity -->
                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>School Identity</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="school_name">School Name</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="school_name" name="school_name"
                                            value="<?php echo e(old('school_name', $settings['school_name']->value ?? 'SMA Negeri 1')); ?>">
                                        <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="school_subtitle">School Subtitle</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['school_subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="school_subtitle" name="school_subtitle"
                                            value="<?php echo e(old('school_subtitle', $settings['school_subtitle']->value ?? 'Admin Panel')); ?>">
                                        <?php $__errorArgs = ['school_subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- School Logo -->
                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>School Logo</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label>Current Logo</label>
                                        <div class="file-preview">
                                            <?php if(isset($settings['school_logo']) && $settings['school_logo']->value): ?>
                                                <img src="<?php echo e(asset('storage/' . $settings['school_logo']->value)); ?>" 
                                                     alt="Current Logo" class="current-logo" id="currentLogo">
                                            <?php else: ?>
                                                <div class="no-logo" id="noLogo">
                                                    <i class="fas fa-school"></i>
                                                    <p>No logo uploaded</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <input type="file" class="form-control <?php $__errorArgs = ['school_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="school_logo" name="school_logo" accept="image/*" onchange="previewLogo(this)">
                                        <?php $__errorArgs = ['school_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label>Favicon</label>
                                        <div class="file-preview favicon-preview">
                                            <?php if(isset($settings['school_favicon']) && $settings['school_favicon']->value): ?>
                                                <img src="<?php echo e(asset('storage/' . $settings['school_favicon']->value)); ?>" 
                                                     alt="Current Favicon" class="current-favicon" id="currentFavicon">
                                            <?php else: ?>
                                                <div class="no-favicon" id="noFavicon">
                                                    <i class="fas fa-star"></i>
                                                    <p>No favicon</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <input type="file" class="form-control <?php $__errorArgs = ['school_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="school_favicon" name="school_favicon" accept="image/*" onchange="previewFavicon(this)">
                                        <?php $__errorArgs = ['school_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Settings Panel -->
                    <div class="tab-panel" id="academic-panel">
                        <div class="panel-header">
                            <h2>Academic Settings</h2>
                            <p>Configure academic year and attendance</p>
                        </div>

                        <div class="settings-grid">
                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Academic Year</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="academic_year">Academic Year</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['academic_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="academic_year" name="academic_year"
                                            value="<?php echo e(old('academic_year', $settings['academic_year']->value ?? '2024/2025')); ?>">
                                        <?php $__errorArgs = ['academic_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="semester">Current Semester</label>
                                        <select class="form-control <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="semester" name="semester">
                                            <option value="1" <?php echo e(old('semester', $settings['semester']->value ?? '') == '1' ? 'selected' : ''); ?>>Semester 1 (Odd)</option>
                                            <option value="2" <?php echo e(old('semester', $settings['semester']->value ?? '') == '2' ? 'selected' : ''); ?>>Semester 2 (Even)</option>
                                        </select>
                                        <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="school_timezone">Timezone</label>
                                        <select class="form-control <?php $__errorArgs = ['school_timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="school_timezone" name="school_timezone">
                                            <option value="Asia/Jakarta" <?php echo e(old('school_timezone', $settings['school_timezone']->value ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : ''); ?>>Asia/Jakarta (WIB)</option>
                                            <option value="Asia/Makassar" <?php echo e(old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Makassar' ? 'selected' : ''); ?>>Asia/Makassar (WITA)</option>
                                            <option value="Asia/Jayapura" <?php echo e(old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Jayapura' ? 'selected' : ''); ?>>Asia/Jayapura (WIT)</option>
                                        </select>
                                        <?php $__errorArgs = ['school_timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Attendance Settings</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="attendance_start_time">Attendance Start Time</label>
                                        <input type="time" class="form-control <?php $__errorArgs = ['attendance_start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="attendance_start_time" name="attendance_start_time"
                                            value="<?php echo e(old('attendance_start_time', $settings['attendance_start_time']->value ?? '07:00')); ?>">
                                        <?php $__errorArgs = ['attendance_start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="attendance_end_time">Attendance End Time</label>
                                        <input type="time" class="form-control <?php $__errorArgs = ['attendance_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="attendance_end_time" name="attendance_end_time"
                                            value="<?php echo e(old('attendance_end_time', $settings['attendance_end_time']->value ?? '07:30')); ?>">
                                        <?php $__errorArgs = ['attendance_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Settings Panel -->
                    <div class="tab-panel" id="system-panel">
                        <div class="panel-header">
                            <h2>System Settings</h2>
                            <p>Configure system security and limits</p>
                        </div>

                        <div class="settings-grid">
                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>System Control</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <div class="toggle-item">
                                            <label for="maintenance_mode">Maintenance Mode</label>
                                            <div class="toggle-switch">
                                                <input type="hidden" name="maintenance_mode" value="0">
                                                <input type="checkbox" id="maintenance_mode" name="maintenance_mode"
                                                    value="1" <?php echo e(old('maintenance_mode', $settings['maintenance_mode']->value ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label for="maintenance_mode" class="switch"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="toggle-item">
                                            <label for="allow_registration">Allow Student Registration</label>
                                            <div class="toggle-switch">
                                                <input type="hidden" name="allow_registration" value="0">
                                                <input type="checkbox" id="allow_registration" name="allow_registration"
                                                    value="1" <?php echo e(old('allow_registration', $settings['allow_registration']->value ?? '1') == '1' ? 'checked' : ''); ?>>
                                                <label for="allow_registration" class="switch"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Security & Limits</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="max_upload_size">Max Upload Size (MB)</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['max_upload_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="max_upload_size" name="max_upload_size"
                                            value="<?php echo e(old('max_upload_size', $settings['max_upload_size']->value ?? '10')); ?>"
                                            min="1" max="100">
                                        <?php $__errorArgs = ['max_upload_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="session_lifetime">Session Lifetime (minutes)</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['session_lifetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="session_lifetime" name="session_lifetime"
                                            value="<?php echo e(old('session_lifetime', $settings['session_lifetime']->value ?? '120')); ?>"
                                            min="30" max="1440">
                                        <?php $__errorArgs = ['session_lifetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="max_login_attempts">Max Login Attempts</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['max_login_attempts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="max_login_attempts" name="max_login_attempts"
                                            value="<?php echo e(old('max_login_attempts', $settings['max_login_attempts']->value ?? '5')); ?>"
                                            min="3" max="10">
                                        <?php $__errorArgs = ['max_login_attempts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Settings Panel -->
                    <div class="tab-panel" id="footer-panel">
                        <div class="panel-header">
                            <h2>Footer Settings</h2>
                            <p>Configure footer content and social media</p>
                        </div>

                        <div class="settings-grid">
                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Footer Content</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="footer_description">Footer Description</label>
                                        <textarea class="form-control <?php $__errorArgs = ['footer_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_description" name="footer_description" rows="4"><?php echo e(old('footer_description', $settings['footer_description']->value ?? 'Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.')); ?></textarea>
                                        <?php $__errorArgs = ['footer_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Social Media Links</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="footer_facebook">Facebook URL</label>
                                        <input type="url" class="form-control <?php $__errorArgs = ['footer_facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_facebook" name="footer_facebook"
                                            value="<?php echo e(old('footer_facebook', $settings['footer_facebook']->value ?? '')); ?>">
                                        <?php $__errorArgs = ['footer_facebook'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_instagram">Instagram URL</label>
                                        <input type="url" class="form-control <?php $__errorArgs = ['footer_instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_instagram" name="footer_instagram"
                                            value="<?php echo e(old('footer_instagram', $settings['footer_instagram']->value ?? '')); ?>">
                                        <?php $__errorArgs = ['footer_instagram'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_youtube">YouTube URL</label>
                                        <input type="url" class="form-control <?php $__errorArgs = ['footer_youtube'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_youtube" name="footer_youtube"
                                            value="<?php echo e(old('footer_youtube', $settings['footer_youtube']->value ?? '')); ?>">
                                        <?php $__errorArgs = ['footer_youtube'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_twitter">Twitter URL</label>
                                        <input type="url" class="form-control <?php $__errorArgs = ['footer_twitter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_twitter" name="footer_twitter"
                                            value="<?php echo e(old('footer_twitter', $settings['footer_twitter']->value ?? '')); ?>">
                                        <?php $__errorArgs = ['footer_twitter'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Contact Information</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="footer_address">Address</label>
                                        <textarea class="form-control <?php $__errorArgs = ['footer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_address" name="footer_address" rows="3"><?php echo e(old('footer_address', $settings['footer_address']->value ?? 'Jl. Pendidikan No. 123, Ponorogo, Jawa Timur 63411')); ?></textarea>
                                        <?php $__errorArgs = ['footer_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_phone">Phone Number</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['footer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_phone" name="footer_phone"
                                            value="<?php echo e(old('footer_phone', $settings['footer_phone']->value ?? '(0352) 123-4567')); ?>">
                                        <?php $__errorArgs = ['footer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_email">Email Address</label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['footer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="footer_email" name="footer_email"
                                            value="<?php echo e(old('footer_email', $settings['footer_email']->value ?? 'info@smkpgri2ponorogo.sch.id')); ?>">
                                        <?php $__errorArgs = ['footer_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Backup Settings Panel -->
                    <div class="tab-panel" id="backup-panel">
                        <div class="panel-header">
                            <h2>Backup & Maintenance</h2>
                            <p>Configure backup settings and system tools</p>
                        </div>

                        <div class="settings-grid">
                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Backup Settings</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <div class="toggle-item">
                                            <label for="auto_backup_enabled">Auto Backup</label>
                                            <div class="toggle-switch">
                                                <input type="hidden" name="auto_backup_enabled" value="0">
                                                <input type="checkbox" id="auto_backup_enabled" name="auto_backup_enabled"
                                                    value="1" <?php echo e(old('auto_backup_enabled', $settings['auto_backup_enabled']->value ?? '0') == '1' ? 'checked' : ''); ?>>
                                                <label for="auto_backup_enabled" class="switch"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="backup_frequency">Backup Frequency</label>
                                        <select class="form-control <?php $__errorArgs = ['backup_frequency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="backup_frequency" name="backup_frequency">
                                            <option value="daily" <?php echo e(old('backup_frequency', $settings['backup_frequency']->value ?? 'daily') == 'daily' ? 'selected' : ''); ?>>Daily</option>
                                            <option value="weekly" <?php echo e(old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'weekly' ? 'selected' : ''); ?>>Weekly</option>
                                            <option value="monthly" <?php echo e(old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                                        </select>
                                        <?php $__errorArgs = ['backup_frequency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div class="form-group">
                                        <label for="backup_retention_days">Retention Days</label>
                                        <input type="number" class="form-control <?php $__errorArgs = ['backup_retention_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="backup_retention_days" name="backup_retention_days"
                                            value="<?php echo e(old('backup_retention_days', $settings['backup_retention_days']->value ?? '30')); ?>"
                                            min="7" max="365">
                                        <?php $__errorArgs = ['backup_retention_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="error-message"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Quick Actions</h3>
                                </div>
                                <div class="card-content">
                                    <div class="action-buttons">
                                        <button type="button" class="action-btn" onclick="window.open('<?php echo e(route('admin.backup.index')); ?>', '_blank')">
                                            <i class="fas fa-database"></i>
                                            Manage Backups
                                        </button>
                                        <button type="button" class="action-btn" onclick="clearCache()">
                                            <i class="fas fa-broom"></i>
                                            Clear Cache
                                        </button>
                                        <button type="button" class="action-btn" onclick="testEmail()">
                                            <i class="fas fa-envelope"></i>
                                            Test Email
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="action-bar">
                    <div class="action-buttons">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </button>
                        <button type="submit" class="btn btn-primary" id="saveButton">
                            <i class="fas fa-save"></i>
                            Save Settings
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Simple Alert Modal -->
    <div class="modal-overlay" id="alertModal">
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-icon" id="alertModalIcon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="modal-content">
                    <h3 id="alertModalTitle">Success!</h3>
                    <p id="alertModalMessage">Settings have been saved successfully.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="closeModal()">OK</button>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div class="modal-overlay" id="loadingModal">
        <div class="modal-container loading-modal">
            <div class="loading-content">
                <div class="spinner"></div>
                <h3>Saving Settings...</h3>
                <p>Please wait...</p>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Simple Settings Page Styles */
        .settings-page {
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Simple Header */
        .page-header {
            background: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #2d3748;
        }

        .page-subtitle {
            font-size: 16px;
            color: #718096;
            margin: 0;
        }

        /* Settings Container */
        .settings-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Simple Tab Navigation */
        .tab-navigation {
            border-bottom: 1px solid #e2e8f0;
            background: #f7fafc;
        }

        .nav-tabs {
            display: flex;
            padding: 0 20px;
        }

        .nav-tab {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 15px 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: #718096;
            font-weight: 500;
            border-bottom: 3px solid transparent;
        }

        .nav-tab:hover {
            color: #4299e1;
            background: rgba(66, 153, 225, 0.1);
        }

        .nav-tab.active {
            color: #4299e1;
            border-bottom-color: #4299e1;
            background: white;
        }

        .nav-tab i {
            font-size: 16px;
        }

        /* Tab Content */
        .tab-content {
            padding: 30px;
        }

        .tab-panel {
            display: none;
        }

        .tab-panel.active {
            display: block;
        }

        .panel-header {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .panel-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #2d3748;
        }

        .panel-header p {
            font-size: 16px;
            color: #718096;
            margin: 0;
        }

        /* Settings Grid */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        /* Setting Cards */
        .setting-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background: #f7fafc;
            padding: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #2d3748;
        }

        .card-content {
            padding: 20px;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-weight: 500;
            margin-bottom: 8px;
            color: #4a5568;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-size: 14px;
            background: white;
            color: #2d3748;
        }

        .form-control:focus {
            outline: none;
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        .form-control.error {
            border-color: #e53e3e;
        }

        .error-message {
            color: #e53e3e;
            font-size: 12px;
            margin-top: 4px;
        }

        /* File Preview */
        .file-preview {
            margin-bottom: 15px;
            padding: 20px;
            border: 2px dashed #e2e8f0;
            border-radius: 6px;
            text-align: center;
            background: #f7fafc;
        }

        .current-logo {
            max-width: 100px;
            max-height: 100px;
            border-radius: 6px;
        }

        .current-favicon {
            max-width: 32px;
            max-height: 32px;
        }

        .no-logo, .no-favicon {
            color: #a0aec0;
        }

        .no-logo i, .no-favicon i {
            font-size: 32px;
            margin-bottom: 8px;
        }

        /* Toggle Switches */
        .toggle-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-switch {
            position: relative;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
            cursor: pointer;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch:before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e0;
            border-radius: 24px;
            transition: 0.3s;
        }

        .switch:after {
            content: "";
            position: absolute;
            top: 2px;
            left: 2px;
            width: 20px;
            height: 20px;
            background-color: white;
            border-radius: 50%;
            transition: 0.3s;
        }

        input:checked + .switch:before {
            background-color: #4299e1;
        }

        input:checked + .switch:after {
            transform: translateX(26px);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 16px;
            background: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            color: #4a5568;
        }

        .action-btn:hover {
            background: #edf2f7;
            border-color: #cbd5e0;
        }

        /* Action Bar */
        .action-bar {
            padding: 20px 30px;
            background: #f7fafc;
            border-top: 1px solid #e2e8f0;
        }

        .action-bar .action-buttons {
            justify-content: flex-end;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 6px;
            font-weight: 500;
            font-size: 14px;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: #4299e1;
            color: white;
            border-color: #4299e1;
        }

        .btn-primary:hover {
            background: #3182ce;
            border-color: #3182ce;
        }

        .btn-secondary {
            background: #edf2f7;
            color: #4a5568;
            border-color: #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* Simple Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
            overflow: hidden;
        }

        .modal-header {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
        }

        .modal-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }

        .modal-icon.success {
            background: #48bb78;
        }

        .modal-icon.error {
            background: #e53e3e;
        }

        .modal-content {
            flex: 1;
        }

        .modal-content h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #2d3748;
        }

        .modal-content p {
            font-size: 14px;
            color: #718096;
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            color: #a0aec0;
            cursor: pointer;
            padding: 4px;
        }

        .modal-close:hover {
            color: #718096;
        }

        .modal-footer {
            padding: 0 20px 20px;
            text-align: right;
        }

        /* Loading Modal */
        .loading-modal {
            text-align: center;
        }

        .loading-content {
            padding: 30px;
        }

        .spinner {
            width: 32px;
            height: 32px;
            border: 3px solid #e2e8f0;
            border-top: 3px solid #4299e1;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-content h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: #2d3748;
        }

        .loading-content p {
            font-size: 14px;
            color: #718096;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .settings-page {
                padding: 10px;
            }

            .nav-tabs {
                flex-wrap: wrap;
                padding: 0 10px;
            }

            .nav-tab {
                padding: 12px 15px;
            }

            .nav-tab span {
                display: none;
            }

            .tab-content {
                padding: 20px;
            }

            .settings-grid {
                grid-template-columns: 1fr;
            }

            .action-bar .action-buttons {
                justify-content: center;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Simple Modal Functions
        function showModal(type, title, message) {
            const modal = document.getElementById('alertModal');
            const icon = document.getElementById('alertModalIcon');
            const titleEl = document.getElementById('alertModalTitle');
            const messageEl = document.getElementById('alertModalMessage');
            
            if (!modal || !icon || !titleEl || !messageEl) {
                alert(title + '\n' + message);
                return;
            }
            
            titleEl.textContent = title;
            messageEl.textContent = message;
            
            // Set icon
            icon.className = 'modal-icon ' + type;
            const iconEl = icon.querySelector('i');
            if (iconEl) {
                iconEl.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
            }
            
            modal.classList.add('show');
            
            // Auto close success messages
            if (type === 'success') {
                setTimeout(() => {
                    closeModal();
                }, 5000);
            }
        }

        function closeModal() {
            const modals = document.querySelectorAll('.modal-overlay');
            modals.forEach(modal => modal.classList.remove('show'));
        }

        function showLoading() {
            const modal = document.getElementById('loadingModal');
            if (modal) {
                modal.classList.add('show');
            }
        }

        function hideLoading() {
            const modal = document.getElementById('loadingModal');
            if (modal) {
                modal.classList.remove('show');
            }
        }

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Tab Navigation
            const tabs = document.querySelectorAll('.nav-tab');
            const panels = document.querySelectorAll('.tab-panel');

            tabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const targetTab = this.dataset.tab;
                    
                    tabs.forEach(t => t.classList.remove('active'));
                    panels.forEach(p => p.classList.remove('active'));
                    
                    this.classList.add('active');
                    document.getElementById(targetTab + '-panel').classList.add('active');
                });
            });

            // Form submission
            const form = document.getElementById('settingsForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    showLoading();
                    
                    // Store submission flag with timestamp
                    sessionStorage.setItem('formSubmitted', 'true');
                    sessionStorage.setItem('formSubmittedTime', Date.now().toString());
                });
            }

            // Check for form submission return with timestamp validation
            const formSubmitted = sessionStorage.getItem('formSubmitted');
            const formSubmittedTime = sessionStorage.getItem('formSubmittedTime');
            const currentTime = Date.now();
            
            // Only check for messages if form was submitted within last 10 seconds
            if (formSubmitted === 'true' && formSubmittedTime && (currentTime - parseInt(formSubmittedTime)) < 10000) {
                sessionStorage.removeItem('formSubmitted');
                sessionStorage.removeItem('formSubmittedTime');
                hideLoading();
                
                // Wait for session to be available
                setTimeout(checkMessages, 500);
            } else {
                // Normal page load or old form submission - clear flags and skip alternative message check
                sessionStorage.removeItem('formSubmitted');
                sessionStorage.removeItem('formSubmittedTime');
                setTimeout(checkMessagesNormal, 100);
            }
        });

        // Enhanced session message detection (FORM SUBMISSION ONLY)
        function checkMessages() {
            const sessionData = {
                success: <?php echo json_encode(session('success'), 15, 512) ?>,
                error: <?php echo json_encode(session('error'), 15, 512) ?>,
                settings_success_message: <?php echo json_encode(session('settings_success_message'), 15, 512) ?>,
                settings_error_message: <?php echo json_encode(session('settings_error_message'), 15, 512) ?>,
                has_success: <?php echo json_encode(session()->has('success'), 15, 512) ?>,
                has_error: <?php echo json_encode(session()->has('error'), 15, 512) ?>,
                has_settings_success: <?php echo json_encode(session()->has('settings_success_message'), 15, 512) ?>,
                has_settings_error: <?php echo json_encode(session()->has('settings_error_message'), 15, 512) ?>
            };
            
            // Check for alternative success message (NEW METHOD - PRIORITY 1)
            if (sessionData.settings_success_message) {
                showModal('success', 'Settings Updated!', sessionData.settings_success_message);
                
                // Clear the message after displaying (simulate flash behavior)
                fetch('/admin/settings/clear-message', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).catch(err => console.log('Clear message error:', err));
                
                return;
            }
            
            // Check for alternative error message (NEW METHOD - PRIORITY 2)
            if (sessionData.settings_error_message) {
                showModal('error', 'Settings Error!', sessionData.settings_error_message);
                
                // Clear the message after displaying
                fetch('/admin/settings/clear-message', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    }
                }).catch(err => console.log('Clear message error:', err));
                
                return;
            }
            
            // Continue with standard message checking
            checkMessagesNormal();
        }
        
        // Normal page load message detection (EXCLUDES ALTERNATIVE MESSAGES)
        function checkMessagesNormal() {
            const sessionData = {
                success: <?php echo json_encode(session('success'), 15, 512) ?>,
                error: <?php echo json_encode(session('error'), 15, 512) ?>,
                has_success: <?php echo json_encode(session()->has('success'), 15, 512) ?>,
                has_error: <?php echo json_encode(session()->has('error'), 15, 512) ?>
            };
            
            // Check for success message
            if (sessionData.success) {
                showModal('success', 'Success!', sessionData.success);
                return;
            }

            // Check for error message
            if (sessionData.error) {
                showModal('error', 'Error!', sessionData.error);
                return;
            }

            // Check for validation errors
            <?php if($errors->any() && old()): ?>
                const errors = <?php echo json_encode($errors->all(), 15, 512) ?>;
                showModal('error', 'Validation Error!', errors.join('\n'));
                return;
            <?php endif; ?>
        }

        // File Preview Functions
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('currentLogo');
                    const noLogo = document.getElementById('noLogo');
                    
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    if (noLogo) {
                        noLogo.style.display = 'none';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function previewFavicon(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('currentFavicon');
                    const noFavicon = document.getElementById('noFavicon');
                    
                    if (preview) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                    }
                    if (noFavicon) {
                        noFavicon.style.display = 'none';
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Utility Functions
        function clearCache() {
            showModal('success', 'Cache Cleared', 'Application cache has been cleared successfully.');
        }

        function testEmail() {
            showModal('success', 'Test Email', 'Test email functionality will be implemented soon.');
        }

        // Modal Event Handlers
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal();
            }
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>