<?php $__env->startSection('title', 'System Settings'); ?>

<?php $__env->startSection('content'); ?>
    <div class="settings-page">
        <!-- Hero Header -->
        <div class="hero-header">
            <div class="hero-content">
                <div class="hero-icon">
                    <div class="icon-wrapper">
                        <i class="fas fa-cogs"></i>
                    </div>
                </div>
                <div class="hero-text">
                    <h1 class="hero-title">System Settings</h1>
                    <p class="hero-subtitle">Configure and customize your school management system with advanced controls
                    </p>
                    <div class="hero-breadcrumb">
                        <span class="breadcrumb-item">
                            <i class="fas fa-home"></i>
                            <a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a>
                        </span>
                        <span class="breadcrumb-separator">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="breadcrumb-item active">Settings</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Alert Messages -->
        <?php if(session('success')): ?>
            <div class="alert-container">
                <div class="alert alert-success">
                    <div class="alert-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">Success!</h4>
                        <p class="alert-message"><?php echo e(session('success')); ?></p>
                    </div>
                    <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <script>
                console.log('Success message displayed:', '<?php echo e(session('success')); ?>');
            </script>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert-container">
                <div class="alert alert-error">
                    <div class="alert-icon">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <div class="alert-content">
                        <h4 class="alert-title">Error!</h4>
                        <p class="alert-message"><?php echo e(session('error')); ?></p>
                    </div>
                    <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <script>
                console.log('Error message displayed:', '<?php echo e(session('error')); ?>');
            </script>
        <?php endif; ?>

        <!-- Debug Session Data -->
        <script>
            console.log('Page loaded - Session data check:', {
                'has_success': <?php echo e(session()->has('success') ? 'true' : 'false'); ?>,
                'has_error': <?php echo e(session()->has('error') ? 'true' : 'false'); ?>,
                'success_message': '<?php echo e(session('success')); ?>',
                'error_message': '<?php echo e(session('error')); ?>'
            });
        </script>

        <!-- Main Settings Container -->
        <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data" id="settingsForm">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="settings-container">
                <!-- Enhanced Tab Navigation -->
                <div class="tab-navigation">
                    <div class="nav-background"></div>
                    <div class="nav-content">
                        <div class="nav-tabs">
                            <button type="button" class="nav-tab active" data-tab="school">
                                <div class="tab-icon-wrapper">
                                    <div class="tab-icon">
                                        <i class="fas fa-school"></i>
                                    </div>
                                </div>
                                <div class="tab-text">
                                    <span class="tab-title">School</span>
                                    <span class="tab-description">Logo & Identity</span>
                                </div>
                            </button>

                            <button type="button" class="nav-tab" data-tab="academic">
                                <div class="tab-icon-wrapper">
                                    <div class="tab-icon">
                                        <i class="fas fa-graduation-cap"></i>
                                    </div>
                                </div>
                                <div class="tab-text">
                                    <span class="tab-title">Academic</span>
                                    <span class="tab-description">Year & Schedule Settings</span>
                                </div>
                            </button>

                            <button type="button" class="nav-tab" data-tab="system">
                                <div class="tab-icon-wrapper">
                                    <div class="tab-icon">
                                        <i class="fas fa-cog"></i>
                                    </div>
                                </div>
                                <div class="tab-text">
                                    <span class="tab-title">System</span>
                                    <span class="tab-description">Security & Performance</span>
                                </div>
                            </button>



                            <button type="button" class="nav-tab" data-tab="backup">
                                <div class="tab-icon-wrapper">
                                    <div class="tab-icon">
                                        <i class="fas fa-database"></i>
                                    </div>
                                </div>
                                <div class="tab-text">
                                    <span class="tab-title">Backup</span>
                                    <span class="tab-description">Data & Maintenance</span>
                                </div>
                            </button>
                        </div>
                        <div class="nav-slider"></div>
                    </div>
                </div>

                <!-- Tab Content Panels -->
                <div class="tab-content">
                    <!-- School Settings Panel -->
                    <div class="tab-panel active" id="school-panel">
                        <div class="panel-header">
                            <div class="header-icon">
                                <i class="fas fa-school"></i>
                            </div>
                            <div class="header-content">
                                <h2 class="panel-title">School Settings</h2>
                                <p class="panel-subtitle">Configure school identity, logo, and basic information</p>
                            </div>
                        </div>

                        <div class="panel-content">
                            <div class="settings-grid">
                                <!-- School Identity Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-id-card"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>School Identity</h3>
                                            <p>Configure school name and subtitle</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="text"
                                                    class="form-control <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="school_name" name="school_name"
                                                    value="<?php echo e(old('school_name', $settings['school_name']->value ?? 'SMA Negeri 1')); ?>"
                                                    placeholder=" ">
                                                <label for="school_name" class="form-label">School Name</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="text"
                                                    class="form-control <?php $__errorArgs = ['school_subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="school_subtitle" name="school_subtitle"
                                                    value="<?php echo e(old('school_subtitle', $settings['school_subtitle']->value ?? 'Admin Panel')); ?>"
                                                    placeholder=" ">
                                                <label for="school_subtitle" class="form-label">School Subtitle</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['school_subtitle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>



                                <!-- School Logo Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-image"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>School Logo</h3>
                                            <p>Upload and manage school logo</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group">
                                            <!-- Debug Info -->
                                            <!-- Logo setting exists: <?php echo e(isset($settings['school_logo']) ? 'YES' : 'NO'); ?> -->
                                            <!-- Logo value: <?php echo e(isset($settings['school_logo']) ? ($settings['school_logo']->value ?? 'NULL') : 'NOT_SET'); ?> -->
                                            <!-- Asset URL: <?php echo e(isset($settings['school_logo']) && $settings['school_logo']->value ? asset('storage/' . $settings['school_logo']->value) : 'NO_URL'); ?> -->

                                            <div class="file-upload-container">
                                                <div class="file-upload-preview">
                                                    <?php if(isset($settings['school_logo']) && $settings['school_logo']->value && !str_contains($settings['school_logo']->value, 'tmp')): ?>
                                                        <?php
                                                            $logoPath = $settings['school_logo']->value;
                                                            $assetUrl = asset('storage/' . $logoPath);
                                                            $fileExists = file_exists(public_path('storage/' . $logoPath));
                                                        ?>
                                                        <!-- Debug: File exists = <?php echo e($fileExists ? 'YES' : 'NO'); ?> -->
                                                        <!-- Debug: Full URL = <?php echo e($assetUrl); ?> -->
                                                        <!-- Debug: Path valid = <?php echo e(!str_contains($logoPath, 'tmp') ? 'YES' : 'NO'); ?> -->

                                                        <?php if($fileExists): ?>
                                                            <img src="<?php echo e($assetUrl); ?>" alt="Current Logo" class="current-logo"
                                                                id="currentLogo"
                                                                onerror="console.error('Logo failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                            <div class="no-logo-placeholder" id="noLogoPlaceholder"
                                                                style="display: none;">
                                                                <i class="fas fa-school fa-3x"></i>
                                                                <p>Logo failed to load<br><small>Path: <?php echo e($logoPath); ?></small></p>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="no-logo-placeholder" id="noLogoPlaceholder">
                                                                <i class="fas fa-school fa-3x"></i>
                                                                <p>Logo file not found<br><small>Path: <?php echo e($logoPath); ?></small></p>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <div class="no-logo-placeholder" id="noLogoPlaceholder">
                                                            <i class="fas fa-school fa-3x"></i>
                                                            <p>No logo uploaded</p>
                                                            <?php if(isset($settings['school_logo']) && str_contains($settings['school_logo']->value, 'tmp')): ?>
                                                                <small style="color: #e74c3c;">Invalid logo path detected</small>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="file-upload-input">
                                                    <input type="file"
                                                        class="form-control-file <?php $__errorArgs = ['school_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        id="school_logo" name="school_logo" accept="image/*"
                                                        onchange="previewLogo(this)">
                                                    <label for="school_logo" class="file-upload-label">
                                                        <div class="file-upload-icon">
                                                            <i class="fas fa-cloud-upload-alt"></i>
                                                        </div>
                                                        <div class="file-upload-text">
                                                            <span class="file-upload-title">Choose Logo File</span>
                                                            <span class="file-upload-subtitle">PNG, JPG up to 2MB</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php $__errorArgs = ['school_logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="file-upload-container">
                                                <div class="file-upload-preview favicon-preview">
                                                    <?php if(isset($settings['school_favicon']) && $settings['school_favicon']->value): ?>
                                                        <img src="<?php echo e(asset('storage/' . $settings['school_favicon']->value)); ?>"
                                                            alt="Current Favicon" class="current-favicon" id="currentFavicon"
                                                            onerror="console.log('Favicon failed to load:', this.src); this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                        <div class="no-favicon-placeholder" id="noFaviconPlaceholder"
                                                            style="display: none;">
                                                            <i class="fas fa-star"></i>
                                                            <p>Favicon failed to load</p>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="no-favicon-placeholder" id="noFaviconPlaceholder">
                                                            <i class="fas fa-star"></i>
                                                            <p>No favicon</p>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="file-upload-input">
                                                    <input type="file"
                                                        class="form-control-file <?php $__errorArgs = ['school_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        id="school_favicon" name="school_favicon" accept="image/*"
                                                        onchange="previewFavicon(this)">
                                                    <label for="school_favicon" class="file-upload-label">
                                                        <div class="file-upload-icon">
                                                            <i class="fas fa-star"></i>
                                                        </div>
                                                        <div class="file-upload-text">
                                                            <span class="file-upload-title">Choose Favicon</span>
                                                            <span class="file-upload-subtitle">ICO, PNG 32x32px</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php $__errorArgs = ['school_favicon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Academic Settings Panel -->
                    <div class="tab-panel" id="academic-panel">
                        <div class="panel-header">
                            <div class="header-icon">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="header-content">
                                <h2 class="panel-title">Academic Settings</h2>
                                <p class="panel-subtitle">Configure academic year, semester, and attendance settings for
                                    your institution</p>
                            </div>
                        </div>

                        <div class="panel-content">
                            <div class="settings-grid">
                                <!-- Academic Year Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>Academic Year</h3>
                                            <p>Configure current academic period</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="text"
                                                    class="form-control <?php $__errorArgs = ['academic_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="academic_year" name="academic_year"
                                                    value="<?php echo e(old('academic_year', $settings['academic_year']->value ?? '2024/2025')); ?>"
                                                    placeholder=" ">
                                                <label for="academic_year" class="form-label">Academic Year</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['academic_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="select-container">
                                                <select class="form-select <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="semester"
                                                    name="semester">
                                                    <option value="1" <?php echo e(old('semester', $settings['semester']->value ?? '') == '1' ? 'selected' : ''); ?>>Semester 1 (Odd)</option>
                                                    <option value="2" <?php echo e(old('semester', $settings['semester']->value ?? '') == '2' ? 'selected' : ''); ?>>Semester 2 (Even)</option>
                                                </select>
                                                <label for="semester" class="form-label">Current Semester</label>
                                                <div class="select-arrow">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['semester'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="select-container">
                                                <select class="form-select <?php $__errorArgs = ['school_timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="school_timezone" name="school_timezone">
                                                    <option value="Asia/Jakarta" <?php echo e(old('school_timezone', $settings['school_timezone']->value ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : ''); ?>>Asia/Jakarta
                                                        (WIB)</option>
                                                    <option value="Asia/Makassar" <?php echo e(old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Makassar' ? 'selected' : ''); ?>>Asia/Makassar (WITA)</option>
                                                    <option value="Asia/Jayapura" <?php echo e(old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Jayapura' ? 'selected' : ''); ?>>Asia/Jayapura (WIT)</option>
                                                </select>
                                                <label for="school_timezone" class="form-label">Timezone</label>
                                                <div class="select-arrow">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['school_timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Settings Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>Attendance Settings</h3>
                                            <p>Configure attendance time windows and policies</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="time"
                                                    class="form-control <?php $__errorArgs = ['attendance_start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="attendance_start_time" name="attendance_start_time"
                                                    value="<?php echo e(old('attendance_start_time', $settings['attendance_start_time']->value ?? '07:00')); ?>">
                                                <label for="attendance_start_time" class="form-label">Attendance Start
                                                    Time</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['attendance_start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="time"
                                                    class="form-control <?php $__errorArgs = ['attendance_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="attendance_end_time" name="attendance_end_time"
                                                    value="<?php echo e(old('attendance_end_time', $settings['attendance_end_time']->value ?? '07:30')); ?>">
                                                <label for="attendance_end_time" class="form-label">Attendance End
                                                    Time</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['attendance_end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Settings Panel -->
                    <div class="tab-panel" id="system-panel">
                        <div class="panel-header">
                            <div class="header-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <div class="header-content">
                                <h2 class="panel-title">System Settings</h2>
                                <p class="panel-subtitle">Configure system security, performance limits, and operational
                                    controls</p>
                            </div>
                        </div>

                        <div class="panel-content">
                            <div class="settings-grid">
                                <!-- System Control Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>System Control</h3>
                                            <p>Manage system operational modes</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="toggle-group">
                                            <div class="toggle-item">
                                                <div class="toggle-info">
                                                    <h4 class="toggle-title">Maintenance Mode</h4>
                                                    <p class="toggle-description">Put the site in maintenance mode for
                                                        updates and repairs</p>
                                                </div>
                                                <div class="toggle-switch">
                                                    <input type="hidden" name="maintenance_mode" value="0">
                                                    <input type="checkbox" id="maintenance_mode" name="maintenance_mode"
                                                        value="1" <?php echo e(old('maintenance_mode', $settings['maintenance_mode']->value ?? '0') == '1' ? 'checked' : ''); ?>>
                                                    <label for="maintenance_mode" class="switch">
                                                        <span class="slider"></span>
                                                        <span class="switch-text on">ON</span>
                                                        <span class="switch-text off">OFF</span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="toggle-item">
                                                <div class="toggle-info">
                                                    <h4 class="toggle-title">Pendaftaran Akun Siswa</h4>
                                                    <p class="toggle-description">Izinkan siswa untuk mendaftar akun baru di
                                                        platform</p>
                                                </div>
                                                <div class="toggle-switch">
                                                    <input type="hidden" name="allow_registration" value="0">
                                                    <input type="checkbox" id="allow_registration" name="allow_registration"
                                                        value="1" <?php echo e(old('allow_registration', $settings['allow_registration']->value ?? '1') == '1' ? 'checked' : ''); ?>>
                                                    <label for="allow_registration" class="switch">
                                                        <span class="slider"></span>
                                                        <span class="switch-text on">ON</span>
                                                        <span class="switch-text off">OFF</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Security & Limits Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-user-shield"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>Security & Limits</h3>
                                            <p>Configure security and performance limits</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="number"
                                                    class="form-control <?php $__errorArgs = ['max_upload_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="max_upload_size" name="max_upload_size"
                                                    value="<?php echo e(old('max_upload_size', $settings['max_upload_size']->value ?? '10')); ?>"
                                                    min="1" max="100" placeholder=" ">
                                                <label for="max_upload_size" class="form-label">Max Upload Size (MB)</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['max_upload_size'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="number"
                                                    class="form-control <?php $__errorArgs = ['session_lifetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="session_lifetime" name="session_lifetime"
                                                    value="<?php echo e(old('session_lifetime', $settings['session_lifetime']->value ?? '120')); ?>"
                                                    min="30" max="1440" placeholder=" ">
                                                <label for="session_lifetime" class="form-label">Session Lifetime
                                                    (minutes)</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['session_lifetime'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="number"
                                                    class="form-control <?php $__errorArgs = ['max_login_attempts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="max_login_attempts" name="max_login_attempts"
                                                    value="<?php echo e(old('max_login_attempts', $settings['max_login_attempts']->value ?? '5')); ?>"
                                                    min="3" max="10" placeholder=" ">
                                                <label for="max_login_attempts" class="form-label">Max Login
                                                    Attempts</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['max_login_attempts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Backup & Maintenance Panel -->
                    <div class="tab-panel" id="backup-panel">
                        <div class="panel-header">
                            <div class="header-icon">
                                <i class="fas fa-database"></i>
                            </div>
                            <div class="header-content">
                                <h2 class="panel-title">Backup & Maintenance</h2>
                                <p class="panel-subtitle">Configure backup settings and access system maintenance tools</p>
                            </div>
                        </div>

                        <div class="panel-content">
                            <div class="settings-grid">
                                <!-- Backup Settings Card -->
                                <div class="setting-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-database"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>Backup Settings</h3>
                                            <p>Configure automatic backup preferences</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="toggle-group">
                                            <div class="toggle-item">
                                                <div class="toggle-info">
                                                    <h4 class="toggle-title">Auto Backup</h4>
                                                    <p class="toggle-description">Automatically create system backups on
                                                        schedule</p>
                                                </div>
                                                <div class="toggle-switch">
                                                    <input type="hidden" name="auto_backup_enabled" value="0">
                                                    <input type="checkbox" id="auto_backup_enabled"
                                                        name="auto_backup_enabled" value="1" <?php echo e(old('auto_backup_enabled', $settings['auto_backup_enabled']->value ?? '0') == '1' ? 'checked' : ''); ?>>
                                                    <label for="auto_backup_enabled" class="switch">
                                                        <span class="slider"></span>
                                                        <span class="switch-text on">ON</span>
                                                        <span class="switch-text off">OFF</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="select-container">
                                                <select class="form-select <?php $__errorArgs = ['backup_frequency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="backup_frequency" name="backup_frequency">
                                                    <option value="daily" <?php echo e(old('backup_frequency', $settings['backup_frequency']->value ?? 'daily') == 'daily' ? 'selected' : ''); ?>>Daily</option>
                                                    <option value="weekly" <?php echo e(old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'weekly' ? 'selected' : ''); ?>>Weekly</option>
                                                    <option value="monthly" <?php echo e(old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'monthly' ? 'selected' : ''); ?>>Monthly</option>
                                                </select>
                                                <label for="backup_frequency" class="form-label">Backup Frequency</label>
                                                <div class="select-arrow">
                                                    <i class="fas fa-chevron-down"></i>
                                                </div>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['backup_frequency'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group">
                                            <div class="input-container">
                                                <input type="number"
                                                    class="form-control <?php $__errorArgs = ['backup_retention_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    id="backup_retention_days" name="backup_retention_days"
                                                    value="<?php echo e(old('backup_retention_days', $settings['backup_retention_days']->value ?? '30')); ?>"
                                                    min="7" max="365" placeholder=" ">
                                                <label for="backup_retention_days" class="form-label">Retention Days</label>
                                                <div class="input-border"></div>
                                                <div class="input-focus"></div>
                                            </div>
                                            <?php $__errorArgs = ['backup_retention_days'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    <?php echo e($message); ?>

                                                </div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Actions Card -->
                                <div class="setting-card actions-card">
                                    <div class="card-header">
                                        <div class="card-icon">
                                            <i class="fas fa-tools"></i>
                                        </div>
                                        <div class="card-title">
                                            <h3>Quick Actions</h3>
                                            <p>System maintenance and utility tools</p>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="actions-grid">
                                            <button type="button" class="action-btn primary"
                                                onclick="window.open('<?php echo e(route('admin.backup.index')); ?>', '_blank')">
                                                <div class="action-icon">
                                                    <i class="fas fa-database"></i>
                                                </div>
                                                <div class="action-content">
                                                    <span class="action-title">Manage Backups</span>
                                                    <span class="action-subtitle">Create and manage system backups</span>
                                                </div>
                                                <div class="action-arrow">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </button>

                                            <button type="button" class="action-btn warning" onclick="clearCache()">
                                                <div class="action-icon">
                                                    <i class="fas fa-broom"></i>
                                                </div>
                                                <div class="action-content">
                                                    <span class="action-title">Clear Cache</span>
                                                    <span class="action-subtitle">Clear application cache files</span>
                                                </div>
                                                <div class="action-arrow">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </button>

                                            <button type="button" class="action-btn info" onclick="optimizeSystem()">
                                                <div class="action-icon">
                                                    <i class="fas fa-rocket"></i>
                                                </div>
                                                <div class="action-content">
                                                    <span class="action-title">Optimize System</span>
                                                    <span class="action-subtitle">Optimize system performance</span>
                                                </div>
                                                <div class="action-arrow">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </button>

                                            <button type="button" class="action-btn success" onclick="testEmail()">
                                                <div class="action-icon">
                                                    <i class="fas fa-envelope-open"></i>
                                                </div>
                                                <div class="action-content">
                                                    <span class="action-title">Test Email</span>
                                                    <span class="action-subtitle">Test email configuration</span>
                                                </div>
                                                <div class="action-arrow">
                                                    <i class="fas fa-arrow-right"></i>
                                                </div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Action Bar -->
                <div class="action-bar">
                    <div class="action-left">
                        <button type="button" class="btn btn-outline" onclick="resetForm()">
                            <i class="fas fa-undo"></i>
                            <span>Reset to Default</span>
                        </button>
                        <button type="button" class="btn btn-outline" onclick="previewChanges()">
                            <i class="fas fa-eye"></i>
                            <span>Preview Changes</span>
                        </button>
                    </div>
                    <div class="action-right">
                        <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-times"></i>
                            <span>Cancel</span>
                        </button>
                        <button type="submit" class="btn btn-primary" id="saveButton">
                            <i class="fas fa-save"></i>
                            <span>Save Settings</span>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Enhanced Test Email Modal -->
    <div class="modal-overlay" id="testEmailModal">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-envelope-open"></i>
                </div>
                <div class="modal-title">
                    <h3>Test Email Configuration</h3>
                    <p>Send a test email to verify your SMTP settings</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('testEmailModal')">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-container">
                        <input type="email" class="form-control" id="testEmailAddress" placeholder=" " required>
                        <label for="testEmailAddress" class="form-label">Email Address</label>
                        <div class="input-border"></div>
                        <div class="input-focus"></div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="select-container">
                        <select class="form-select" id="testEmailTemplate">
                            <option value="basic">Basic Test</option>
                            <option value="welcome">Welcome Message</option>
                            <option value="notification">Notification</option>
                            <option value="announcement">Announcement</option>
                        </select>
                        <label for="testEmailTemplate" class="form-label">Email Template</label>
                        <div class="select-arrow">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="input-border"></div>
                        <div class="input-focus"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('testEmailModal')">
                    <span>Cancel</span>
                </button>
                <button type="button" class="btn btn-primary" onclick="sendTestEmail()">
                    <i class="fas fa-paper-plane"></i>
                    <span>Send Test Email</span>
                </button>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        /* Settings Page Styles - Uses Layout CSS Variables */
        .settings-page {
            min-height: 100vh;
            position: relative;
            padding: 2rem;
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            transition: all 0.3s ease;
        }

        /* Hero Header */
        .hero-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            padding: 3rem;
            margin-bottom: 3rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .hero-content {
            display: flex;
            align-items: center;
            gap: 2rem;
            position: relative;
            z-index: 2;
            margin-bottom: 2rem;
        }

        .hero-icon .icon-wrapper {
            width: 80px;
            height: 80px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .hero-text {
            flex: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            margin: 0 0 0.5rem 0;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            margin: 0 0 1rem 0;
            opacity: 0.9;
            line-height: 1.6;
        }

        .hero-breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            opacity: 0.8;
        }

        .breadcrumb-item a {
            color: white;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            opacity: 1;
            font-weight: 500;
        }

        .breadcrumb-separator {
            opacity: 0.6;
            font-size: 0.75rem;
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            background: rgba(255, 255, 255, 0.1);
            padding: 1rem 1.5rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.15);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
        }

        .stat-content {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        /* Alert Messages */
        .alert-container {
            margin-bottom: 2rem;
        }

        .alert {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border-radius: 16px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            border: none;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
            color: #0369a1;
            border-left: 4px solid #4facfe;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(250, 112, 154, 0.1) 0%, rgba(254, 225, 64, 0.1) 100%);
            color: #dc2626;
            border-left: 4px solid #fa709a;
        }

        .alert-icon {
            font-size: 1.5rem;
        }

        .alert-content h4 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
            font-size: 1.125rem;
        }

        .alert-content p {
            margin: 0;
            opacity: 0.9;
        }

        .alert-close {
            background: none;
            border: none;
            color: currentColor;
            opacity: 0.7;
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            margin-left: auto;
        }

        .alert-close:hover {
            opacity: 1;
            background: rgba(0, 0, 0, 0.1);
        }

        /* Settings Container */
        .settings-container {
            background-color: var(--bg-primary);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px var(--shadow-color);
            overflow: hidden;
            border: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
        }

        /* Tab Navigation */
        .tab-navigation {
            position: relative;
            background-color: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .nav-background {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        }

        .nav-content {
            position: relative;
            z-index: 2;
        }

        .nav-tabs {
            display: flex;
            position: relative;
        }

        .nav-tab {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 2rem;
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            text-align: left;
        }

        .nav-tab:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-tab.active {
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
        }

        .tab-icon-wrapper {
            position: relative;
        }

        .tab-icon {
            width: 56px;
            height: 56px;
            background-color: var(--bg-primary);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 1px 3px var(--shadow-color);
            position: relative;
            z-index: 2;
        }

        .nav-tab.active .tab-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 10px 15px -3px var(--shadow-color);
        }

        .tab-text {
            flex: 1;
        }

        .tab-title {
            display: block;
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }

        .tab-description {
            display: block;
            font-size: 0.875rem;
            opacity: 0.7;
        }

        .nav-slider {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            width: 25%;
            transform: translateX(0);
        }

        /* Tab Content */
        .tab-content {
            position: relative;
        }

        .tab-panel {
            display: none;
            padding: 3rem;
        }

        .tab-panel.active {
            display: block;
        }

        .panel-header {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid var(--border-color);
            position: relative;
        }

        .panel-header::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100px;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .header-icon {
            width: 64px;
            height: 64px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            box-shadow: 0 10px 15px -3px var(--shadow-color);
        }

        .header-content {
            flex: 1;
        }

        .panel-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 0.5rem 0;
        }

        .panel-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin: 0;
            line-height: 1.6;
        }

        /* Settings Grid */
        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
        }

        /* Setting Cards */
        .setting-card {
            background-color: var(--bg-primary);
            border-radius: 20px;
            border: 1px solid var(--border-color);
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px var(--shadow-color);
            position: relative;
        }

        .setting-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transform: scaleX(0);
            transition: all 0.3s ease;
        }

        .setting-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 25px 50px -12px var(--shadow-color);
        }

        .setting-card:hover::before {
            transform: scaleX(1);
        }

        .card-header {
            background-color: var(--bg-secondary);
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .card-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 6px -1px var(--shadow-color);
        }

        .card-title h3 {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.25rem 0;
        }

        .card-title p {
            font-size: 0.875rem;
            color: var(--text-secondary);
            margin: 0;
        }

        .card-content {
            padding: 2rem;
        }

        /* File Upload Styles */
        .file-upload-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .file-upload-preview {
            width: 100%;
            min-height: 120px;
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-tertiary);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .file-upload-preview:hover {
            border-color: #667eea;
            background-color: var(--bg-secondary);
        }

        .current-logo,
        .current-favicon {
            max-width: 100%;
            max-height: 100px;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px var(--shadow-color);
        }

        .no-logo-placeholder,
        .no-favicon-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            padding: 2rem;
            text-align: center;
        }

        .no-logo-placeholder i,
        .no-favicon-placeholder i {
            font-size: 2rem;
            opacity: 0.5;
        }

        .no-logo-placeholder p,
        .no-favicon-placeholder p {
            margin: 0;
            font-size: 0.875rem;
            opacity: 0.7;
        }

        .file-upload-input {
            position: relative;
        }

        .form-control-file {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
            z-index: 2;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border: 2px dashed var(--border-color);
            border-radius: 16px;
            background-color: var(--bg-primary);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .file-upload-label:hover {
            border-color: #667eea;
            background-color: var(--bg-secondary);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px var(--shadow-color);
        }

        .file-upload-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .file-upload-text {
            flex: 1;
        }

        .file-upload-title {
            display: block;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .file-upload-subtitle {
            display: block;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Form Controls */
        .form-group {
            margin-bottom: 2rem;
            position: relative;
        }

        .input-container,
        .select-container {
            position: relative;
        }

        .form-control,
        .form-select {
            width: 100%;
            padding: 1rem;
            border: 2px solid var(--border-color);
            border-radius: 16px;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
            outline: none;
            appearance: none;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-control.error,
        .form-select.error {
            border-color: #fa709a;
            box-shadow: 0 0 0 4px rgba(250, 112, 154, 0.1);
        }

        .form-label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: var(--text-secondary);
            font-size: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            background-color: var(--bg-primary);
            padding: 0 0.5rem;
            z-index: 2;
        }

        .form-control:focus+.form-label,
        .form-control:not(:placeholder-shown)+.form-label,
        .form-select:focus+.form-label,
        .form-select:not([value=""])+.form-label {
            top: -0.5rem;
            left: 0.75rem;
            font-size: 0.875rem;
            color: #667eea;
            font-weight: 500;
        }

        .input-border {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--border-color);
            border-radius: 1px;
        }

        .input-focus {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.3s ease;
            border-radius: 1px;
        }

        .form-control:focus~.input-focus,
        .form-select:focus~.input-focus {
            width: 100%;
            left: 0;
        }

        .select-arrow {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-secondary);
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .form-select:focus~.select-arrow {
            color: #667eea;
            transform: translateY(-50%) rotate(180deg);
        }

        .error-message {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #fa709a;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        /* Toggle Switches */
        .toggle-group {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .toggle-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            background-color: var(--bg-tertiary);
            border-radius: 16px;
            border: 2px solid var(--border-color);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .toggle-item:hover {
            border-color: #667eea;
            background-color: var(--bg-primary);
            transform: translateY(-1px);
            box-shadow: 0 10px 15px -3px var(--shadow-color);
        }

        .toggle-info h4 {
            margin: 0 0 0.5rem 0;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 1.125rem;
        }

        .toggle-info p {
            margin: 0;
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .toggle-switch {
            position: relative;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 80px;
            height: 40px;
            cursor: pointer;
        }

        .slider {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: #ccc;
            border-radius: 40px;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 32px;
            width: 32px;
            left: 4px;
            bottom: 4px;
            background: white;
            border-radius: 50%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px var(--shadow-color);
        }

        input:checked+.switch .slider {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
        }

        input:checked+.switch .slider:before {
            transform: translateX(40px);
        }

        .switch-text {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .switch-text.on {
            left: 8px;
            color: white;
            opacity: 0;
        }

        .switch-text.off {
            right: 8px;
            color: var(--text-secondary);
            opacity: 1;
        }

        input:checked+.switch .switch-text.on {
            opacity: 1;
        }

        input:checked+.switch .switch-text.off {
            opacity: 0;
        }

        /* Action Buttons */
        .actions-card {
            grid-column: span 2;
        }

        .actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1.5rem;
            border: 2px solid transparent;
            border-radius: 16px;
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px var(--shadow-color);
        }

        .action-btn.primary {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .action-btn.warning {
            border-color: #43e97b;
            background: linear-gradient(135deg, rgba(67, 233, 123, 0.1) 0%, rgba(56, 249, 215, 0.1) 100%);
        }

        .action-btn.info {
            border-color: #a8edea;
            background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%);
        }

        .action-btn.success {
            border-color: #4facfe;
            background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
        }

        .action-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            background-color: var(--bg-primary);
            box-shadow: 0 1px 3px var(--shadow-color);
            transition: all 0.3s ease;
        }

        .action-btn.primary .action-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .action-btn.warning .action-icon {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .action-btn.info .action-icon {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: white;
        }

        .action-btn.success .action-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .action-btn:hover .action-icon {
            transform: scale(1.05);
        }

        .action-content {
            flex: 1;
        }

        .action-title {
            display: block;
            font-weight: 600;
            font-size: 1.125rem;
            margin-bottom: 0.25rem;
        }

        .action-subtitle {
            display: block;
            font-size: 0.875rem;
            color: var(--text-secondary);
            line-height: 1.4;
        }

        .action-arrow {
            font-size: 1.25rem;
            color: var(--text-secondary);
            transition: all 0.3s ease;
        }

        .action-btn:hover .action-arrow {
            color: #667eea;
            transform: translateX(3px);
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 2rem 3rem;
            background-color: var(--bg-secondary);
            border-top: 1px solid var(--border-color);
            position: relative;
        }

        .action-bar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            opacity: 0.3;
        }

        .action-left,
        .action-right {
            display: flex;
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border-radius: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .btn-secondary {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: var(--border-color);
        }

        .btn-secondary:hover {
            background-color: var(--bg-secondary);
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px var(--shadow-color);
        }

        .btn-outline {
            background: transparent;
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .btn-outline:hover {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
            border-color: #667eea;
        }

        /* Color Picker Styles */
        .color-picker-container {
            margin-bottom: 1.5rem;
        }

        .color-input-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .color-picker {
            width: 60px;
            height: 40px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            background: none;
            transition: all 0.3s ease;
        }

        .color-picker:hover {
            border-color: #667eea;
            transform: scale(1.05);
        }

        .color-text-input {
            flex: 1;
            padding: 0.75rem 1rem;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
            transition: all 0.3s ease;
        }

        .color-text-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .color-preview {
            width: 40px;
            height: 40px;
            border: 2px solid var(--border-color);
            border-radius: 8px;
            position: relative;
            overflow: hidden;
        }

        .color-preview::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, #ccc 25%, transparent 25%),
                linear-gradient(-45deg, #ccc 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #ccc 75%),
                linear-gradient(-45deg, transparent 75%, #ccc 75%);
            background-size: 8px 8px;
            background-position: 0 0, 0 4px, 4px -4px, -4px 0px;
        }

        .color-preview::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--preview-color, #ffffff);
        }

        .color-help {
            display: block;
            color: var(--text-secondary);
            font-size: 0.75rem;
            margin-top: 0.25rem;
            line-height: 1.4;
        }

        /* Navbar Preview Styles */
        .navbar-preview-container {
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .navbar-preview {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background-color: var(--navbar-bg, #ffffff);
            color: var(--navbar-text, #333333);
            border-radius: 12px;
            border: 2px solid var(--border-color);
            margin-top: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 600;
            font-size: 1.125rem;
            color: inherit;
        }

        .navbar-brand i {
            font-size: 1.5rem;
            color: var(--navbar-text, #333333);
        }

        .navbar-menu {
            display: flex;
            gap: 1.5rem;
        }

        .nav-link {
            color: var(--navbar-text, #333333);
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--navbar-hover, #007bff);
            background-color: rgba(0, 123, 255, 0.1);
            text-decoration: none;
        }

        /* Responsive navbar preview */
        @media (max-width: 768px) {
            .navbar-preview {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .navbar-menu {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
            }
        }

        /* Enhanced Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-backdrop {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }

        .modal-container {
            background-color: var(--bg-primary);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px var(--shadow-color);
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow: hidden;
            position: relative;
            z-index: 2;
            border: 1px solid var(--border-color);
        }

        .modal-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 2rem;
            border-bottom: 1px solid var(--border-color);
            background-color: var(--bg-secondary);
        }

        .modal-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .modal-title {
            flex: 1;
        }

        .modal-title h3 {
            margin: 0 0 0.25rem 0;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .modal-title p {
            margin: 0;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .modal-close:hover {
            background-color: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .modal-body {
            padding: 2rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 1rem;
            padding: 2rem;
            border-top: 1px solid var(--border-color);
            background-color: var(--bg-secondary);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }

            .actions-card {
                grid-column: span 1;
            }

            .actions-grid {
                grid-template-columns: 1fr;
            }

            .hero-stats {
                flex-direction: column;
                gap: 1rem;
            }

            .stat-item {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .settings-page {
                padding: 1rem;
            }

            .hero-header {
                padding: 2rem;
            }

            .hero-content {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .nav-tabs {
                flex-direction: column;
            }

            .nav-tab {
                padding: 1.5rem;
            }

            .tab-panel {
                padding: 2rem;
            }

            .panel-header {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .action-bar {
                flex-direction: column;
                gap: 1rem;
                padding: 2rem;
            }

            .action-left,
            .action-right {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 480px) {
            .hero-header {
                padding: 1.5rem;
            }

            .hero-title {
                font-size: 1.75rem;
            }

            .tab-panel {
                padding: 1rem;
            }

            .card-header,
            .card-content {
                padding: 1.5rem;
            }

            .btn {
                padding: 0.875rem 1.5rem;
                font-size: 0.875rem;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        // Tab navigation functionality
        document.addEventListener('DOMContentLoaded', function () {
            const tabs = document.querySelectorAll('.nav-tab');
            const panels = document.querySelectorAll('.tab-panel');
            const slider = document.querySelector('.nav-slider');

            // Check if logo was just updated and refresh if needed
            <?php if(session('logo_updated')): ?>
                console.log('Logo was updated, refreshing logo display...');
                setTimeout(function () {
                    // Force page reload to ensure fresh data
                    console.log('Reloading page to show updated logo...');
                    window.location.reload();
                }, 1000);
            <?php endif; ?>

        // Handle form submission with loading state
        const settingsForm = document.getElementById('settingsForm');
            const saveButton = document.getElementById('saveButton');

            if (settingsForm && saveButton) {
                settingsForm.addEventListener('submit', function (e) {
                    // Don't prevent submission - let it go through normally
                    console.log('Form submitted, saving settings...', {
                        'form_action': settingsForm.action,
                        'form_method': settingsForm.method,
                        'timestamp': new Date().toISOString()
                    });

                    // Show loading state but don't disable
                    const originalText = saveButton.querySelector('span').textContent;
                    const originalIcon = saveButton.querySelector('i').className;
                    saveButton.querySelector('span').textContent = 'Saving...';
                    saveButton.querySelector('i').className = 'fas fa-spinner fa-spin';

                    // Don't prevent form submission - let it proceed normally
                    // The server will handle the redirect and show success message
                });
            }

            function switchTab(targetTab) {
                // Remove active class from all tabs and panels
                tabs.forEach(tab => tab.classList.remove('active'));
                panels.forEach(panel => panel.classList.remove('active'));

                // Add active class to target tab
                targetTab.classList.add('active');

                // Show corresponding panel
                const targetPanel = document.getElementById(targetTab.dataset.tab + '-panel');
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }

                // Move slider
                const tabIndex = Array.from(tabs).indexOf(targetTab);
                const sliderWidth = 100 / tabs.length;
                slider.style.transform = `translateX(${tabIndex * 100}%)`;
                slider.style.width = `${sliderWidth}%`;
            }

            // Add click event listeners to tabs
            tabs.forEach(tab => {
                tab.addEventListener('click', () => switchTab(tab));
            });

            // Initialize slider position
            const activeTab = document.querySelector('.nav-tab.active');
            if (activeTab) {
                switchTab(activeTab);
            }
        });

        // Modal functions
        window.testEmail = function () {
            document.getElementById('testEmailModal').classList.add('active');
        };

        window.closeModal = function (modalId) {
            document.getElementById(modalId).classList.remove('active');
        };

        window.sendTestEmail = function () {
            const email = document.getElementById('testEmailAddress').value;
            const template = document.getElementById('testEmailTemplate').value;

            if (!email) {
                alert('Please enter an email address');
                return;
            }

            // Here you would make an AJAX call to send test email
            alert('Test email sent to: ' + email);
            closeModal('testEmailModal');
        };

        // Other utility functions
        window.clearCache = function () {
            if (confirm('Are you sure you want to clear the application cache?')) {
                // Make AJAX call to clear cache
                alert('Cache cleared successfully!');
            }
        };

        window.optimizeSystem = function () {
            if (confirm('Are you sure you want to optimize the system?')) {
                // Make AJAX call to optimize system
                alert('System optimization completed!');
            }
        };

        window.resetForm = function () {
            if (confirm('Are you sure you want to reset all settings to default values?')) {
                document.getElementById('settingsForm').reset();
            }
        };

        window.previewChanges = function () {
            alert('Preview functionality would show changes before saving.');
        };

        // Enhanced File preview functions
        window.previewLogo = function (input) {
            console.log('previewLogo called', input);

            if (input.files && input.files[0]) {
                const file = input.files[0];
                console.log('File selected:', {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    lastModified: file.lastModified
                });

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    input.value = ''; // Clear the input
                    return;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    input.value = ''; // Clear the input
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    console.log('File loaded successfully for preview');

                    const preview = document.querySelector('.file-upload-preview');
                    const placeholder = document.getElementById('noLogoPlaceholder');
                    let currentLogo = document.getElementById('currentLogo');

                    console.log('Preview elements:', { preview, placeholder, currentLogo });

                    // Hide placeholder
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }

                    // Update or create image
                    if (currentLogo) {
                        currentLogo.src = e.target.result;
                        currentLogo.style.display = 'block';
                        currentLogo.onerror = null; // Remove error handler for preview
                        console.log('Updated existing logo with preview');
                    } else {
                        // Create new image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'current-logo';
                        img.id = 'currentLogo';
                        img.alt = 'Logo Preview';
                        img.style.display = 'block';

                        // Clear preview and add new image
                        if (preview) {
                            preview.innerHTML = '';
                            preview.appendChild(img);
                            console.log('Created new logo element for preview');
                        }
                    }
                };

                reader.onerror = function (e) {
                    console.error('Error reading file:', e);
                    alert('Error reading file. Please try again.');
                    input.value = ''; // Clear the input
                };

                reader.readAsDataURL(file);
            } else {
                console.log('No file selected');
            }
        };

        window.previewFavicon = function (input) {
            console.log('previewFavicon called', input);

            if (input.files && input.files[0]) {
                const file = input.files[0];
                console.log('Favicon file selected:', {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    lastModified: file.lastModified
                });

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    alert('Please select an image file');
                    input.value = ''; // Clear the input
                    return;
                }

                // Validate file size (1MB)
                if (file.size > 1024 * 1024) {
                    alert('Favicon file size must be less than 1MB');
                    input.value = ''; // Clear the input
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    console.log('Favicon file loaded successfully for preview');

                    const preview = document.querySelector('.favicon-preview');
                    const placeholder = document.getElementById('noFaviconPlaceholder');
                    let currentFavicon = document.getElementById('currentFavicon');

                    console.log('Favicon preview elements:', { preview, placeholder, currentFavicon });

                    // Hide placeholder
                    if (placeholder) {
                        placeholder.style.display = 'none';
                    }

                    // Update or create image
                    if (currentFavicon) {
                        currentFavicon.src = e.target.result;
                        currentFavicon.style.display = 'block';
                        currentFavicon.onerror = null; // Remove error handler for preview
                        console.log('Updated existing favicon with preview');
                    } else {
                        // Create new image element
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'current-favicon';
                        img.id = 'currentFavicon';
                        img.alt = 'Favicon Preview';
                        img.style.display = 'block';

                        // Clear preview and add new image
                        if (preview) {
                            preview.innerHTML = '';
                            preview.appendChild(img);
                            console.log('Created new favicon element for preview');
                        }
                    }
                };

                reader.onerror = function (e) {
                    console.error('Error reading favicon file:', e);
                    alert('Error reading favicon file. Please try again.');
                    input.value = ''; // Clear the input
                };

                reader.readAsDataURL(file);
            } else {
                console.log('No favicon file selected');
            }
        };
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>