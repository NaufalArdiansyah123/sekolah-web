<?php $__env->startSection('title', 'Pengaturan Sistem'); ?>

<?php $__env->startSection('content'); ?>
<?php
    // Helper function untuk mengakses setting dengan aman
    $getSetting = function($settings, $key, $default = '') {
        return isset($settings[$key]) ? $settings[$key]->value : $default;
    };
?>

<div class="container mx-auto px-6 py-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl mr-4">
                    <i class="fas fa-cog text-white text-xl"></i>
                </div>
                Pengaturan Sistem
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola pengaturan sekolah dan konfigurasi sistem</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" onclick="exportSettings()" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-download mr-2"></i>Export Settings
            </button>
            <button type="button" onclick="resetToDefault()" 
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-undo mr-2"></i>Reset Default
            </button>
        </div>
    </div>

    <?php if(isset($error)): ?>
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                <span class="text-red-700 dark:text-red-300"><?php echo e($error); ?></span>
            </div>
        </div>
    <?php endif; ?>

    <!-- Tab Navigation -->
    <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-xl mb-6 overflow-hidden">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6" aria-label="Tabs">
                <button onclick="switchTab('school')" 
                        class="tab-button active border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <i class="fas fa-school mr-2"></i>Informasi Sekolah
                </button>
                <button onclick="switchTab('academic')" 
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>Akademik
                </button>
                <button onclick="switchTab('system')" 
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <i class="fas fa-cogs mr-2"></i>Sistem
                </button>
                <button onclick="switchTab('email')" 
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <i class="fas fa-envelope mr-2"></i>Email & Notifikasi
                </button>
                <button onclick="switchTab('backup')" 
                        class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center">
                    <i class="fas fa-database mr-2"></i>Backup & Maintenance
                </button>
            </nav>
        </div>
    </div>

    <form action="<?php echo e(route('admin.settings.update')); ?>" method="POST" enctype="multipart/form-data" id="settings-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        
        <!-- Hidden inputs for boolean fields -->
        <!-- These ensure that unchecked checkboxes send 0 values -->
        <input type="hidden" name="maintenance_mode" value="0">
        <input type="hidden" name="allow_registration" value="0">
        <input type="hidden" name="email_notifications_enabled" value="0">
        <input type="hidden" name="registration_notifications" value="0">
        <input type="hidden" name="system_notifications" value="0">
        <input type="hidden" name="announcement_notifications" value="0">
        <input type="hidden" name="agenda_notifications" value="0">
        <input type="hidden" name="auto_backup_enabled" value="0">
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-3">
                
                <!-- School Information Tab -->
                <div id="school-tab" class="tab-content">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-school mr-3"></i>Informasi Sekolah
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- School Logo -->
                            <div class="flex items-center space-x-6 p-6 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <div class="flex-shrink-0">
                                    <div class="w-24 h-24 bg-gray-200 dark:bg-gray-600 rounded-xl flex items-center justify-center overflow-hidden">
                                        <?php if($getSetting($settings, 'school_logo')): ?>
                                            <img src="<?php echo e(asset('storage/' . $getSetting($settings, 'school_logo'))); ?>" 
                                                 alt="Logo Sekolah" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <i class="fas fa-school text-3xl text-gray-400"></i>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Logo Sekolah
                                    </label>
                                    <input type="file" name="school_logo" accept="image/*"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, SVG. Maksimal 2MB</p>
                                </div>
                            </div>

                            <!-- Basic School Information -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="school_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-school mr-2 text-blue-500"></i>
                                            Nama Sekolah *
                                        </span>
                                    </label>
                                    <input type="text" name="school_name" id="school_name" required
                                           value="<?php echo e(old('school_name', $getSetting($settings, 'school_name', 'SMA Negeri 1 Balong'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div>
                                    <label for="school_npsn" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-id-card mr-2 text-green-500"></i>
                                            NPSN
                                        </span>
                                    </label>
                                    <input type="text" name="school_npsn" id="school_npsn"
                                           value="<?php echo e(old('school_npsn', $getSetting($settings, 'school_npsn'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div class="md:col-span-2">
                                    <label for="school_address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                                            Alamat Sekolah
                                        </span>
                                    </label>
                                    <textarea name="school_address" id="school_address" rows="3"
                                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"><?php echo e(old('school_address', $getSetting($settings, 'school_address'))); ?></textarea>
                                </div>

                                <div>
                                    <label for="school_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-phone mr-2 text-purple-500"></i>
                                            Nomor Telepon
                                        </span>
                                    </label>
                                    <input type="tel" name="school_phone" id="school_phone"
                                           value="<?php echo e(old('school_phone', $getSetting($settings, 'school_phone'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div>
                                    <label for="school_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-envelope mr-2 text-indigo-500"></i>
                                            Email Sekolah
                                        </span>
                                    </label>
                                    <input type="email" name="school_email" id="school_email"
                                           value="<?php echo e(old('school_email', $getSetting($settings, 'school_email'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div>
                                    <label for="school_website" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-globe mr-2 text-teal-500"></i>
                                            Website Sekolah
                                        </span>
                                    </label>
                                    <input type="url" name="school_website" id="school_website"
                                           value="<?php echo e(old('school_website', $getSetting($settings, 'school_website'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div>
                                    <label for="principal_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-user-tie mr-2 text-yellow-500"></i>
                                            Nama Kepala Sekolah
                                        </span>
                                    </label>
                                    <input type="text" name="principal_name" id="principal_name"
                                           value="<?php echo e(old('principal_name', $getSetting($settings, 'principal_name'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                </div>

                                <div>
                                    <label for="school_accreditation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-award mr-2 text-orange-500"></i>
                                            Akreditasi
                                        </span>
                                    </label>
                                    <select name="school_accreditation" id="school_accreditation"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="">Pilih Akreditasi</option>
                                        <option value="A" <?php echo e($getSetting($settings, 'school_accreditation') == 'A' ? 'selected' : ''); ?>>A (Sangat Baik)</option>
                                        <option value="B" <?php echo e($getSetting($settings, 'school_accreditation') == 'B' ? 'selected' : ''); ?>>B (Baik)</option>
                                        <option value="C" <?php echo e($getSetting($settings, 'school_accreditation') == 'C' ? 'selected' : ''); ?>>C (Cukup)</option>
                                        <option value="Belum" <?php echo e($getSetting($settings, 'school_accreditation') == 'Belum' ? 'selected' : ''); ?>>Belum Terakreditasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Academic Settings Tab -->
                <div id="academic-tab" class="tab-content hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-teal-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-graduation-cap mr-3"></i>Pengaturan Akademik
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- Academic Year & Semester -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="academic_year" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                            Tahun Ajaran
                                        </span>
                                    </label>
                                    <input type="text" name="academic_year" id="academic_year"
                                           value="<?php echo e(old('academic_year', $getSetting($settings, 'academic_year', '2024/2025'))); ?>"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="2024/2025">
                                </div>

                                <div>
                                    <label for="semester" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-list-ol mr-2 text-green-500"></i>
                                            Semester Aktif
                                        </span>
                                    </label>
                                    <select name="semester" id="semester"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="1" <?php echo e($getSetting($settings, 'semester', '1') == '1' ? 'selected' : ''); ?>>Semester 1 (Ganjil)</option>
                                        <option value="2" <?php echo e($getSetting($settings, 'semester', '1') == '2' ? 'selected' : ''); ?>>Semester 2 (Genap)</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="school_timezone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <i class="fas fa-clock mr-2 text-purple-500"></i>
                                            Zona Waktu
                                        </span>
                                    </label>
                                    <select name="school_timezone" id="school_timezone"
                                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                        <option value="Asia/Jakarta" <?php echo e($getSetting($settings, 'school_timezone', 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : ''); ?>>WIB (Asia/Jakarta)</option>
                                        <option value="Asia/Makassar" <?php echo e($getSetting($settings, 'school_timezone') == 'Asia/Makassar' ? 'selected' : ''); ?>>WITA (Asia/Makassar)</option>
                                        <option value="Asia/Jayapura" <?php echo e($getSetting($settings, 'school_timezone') == 'Asia/Jayapura' ? 'selected' : ''); ?>>WIT (Asia/Jayapura)</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Attendance Settings -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-user-check mr-2 text-indigo-500"></i>
                                    Pengaturan Absensi
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div>
                                        <label for="attendance_start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Jam Mulai Absensi
                                        </label>
                                        <input type="time" name="attendance_start_time" id="attendance_start_time"
                                               value="<?php echo e(old('attendance_start_time', $getSetting($settings, 'attendance_start_time', '07:00'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="attendance_end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Jam Berakhir Absensi
                                        </label>
                                        <input type="time" name="attendance_end_time" id="attendance_end_time"
                                               value="<?php echo e(old('attendance_end_time', $getSetting($settings, 'attendance_end_time', '07:30'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="late_tolerance_minutes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Toleransi Terlambat (menit)
                                        </label>
                                        <input type="number" name="late_tolerance_minutes" id="late_tolerance_minutes"
                                               value="<?php echo e(old('late_tolerance_minutes', $getSetting($settings, 'late_tolerance_minutes', '15'))); ?>"
                                               min="0" max="60"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Settings Tab -->
                <div id="system-tab" class="tab-content hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-cogs mr-3"></i>Pengaturan Sistem
                            </h2>
                        </div>
                        <div class="p-6 space-y-6">
                            <!-- System Status Cards -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-purple-300 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-tools text-red-600 dark:text-red-400"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Mode Maintenance</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Tutup sementara website untuk maintenance</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer"
                                               <?php echo e($getSetting($settings, 'maintenance_mode') ? 'checked' : ''); ?>>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-purple-300 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-user-plus text-green-600 dark:text-green-400"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Izinkan Registrasi</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">User bisa mendaftar sendiri</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="allow_registration" value="1" class="sr-only peer"
                                               <?php echo e($getSetting($settings, 'allow_registration', '1') ? 'checked' : ''); ?>>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- System Configuration -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-sliders-h mr-2 text-blue-500"></i>
                                    Konfigurasi Sistem
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="max_upload_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Ukuran Upload Maksimal (MB)
                                        </label>
                                        <input type="number" name="max_upload_size" id="max_upload_size"
                                               value="<?php echo e(old('max_upload_size', $getSetting($settings, 'max_upload_size', '10'))); ?>"
                                               min="1" max="100"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="session_lifetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Session Lifetime (menit)
                                        </label>
                                        <input type="number" name="session_lifetime" id="session_lifetime"
                                               value="<?php echo e(old('session_lifetime', $getSetting($settings, 'session_lifetime', '120'))); ?>"
                                               min="30" max="1440"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="max_login_attempts" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Maksimal Percobaan Login
                                        </label>
                                        <input type="number" name="max_login_attempts" id="max_login_attempts"
                                               value="<?php echo e(old('max_login_attempts', $getSetting($settings, 'max_login_attempts', '5'))); ?>"
                                               min="3" max="10"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email & Notifications Tab -->
                <div id="email-tab" class="tab-content hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-envelope mr-3"></i>Email & Notifikasi
                            </h2>
                        </div>
                        <div class="p-6 space-y-8">
                            <!-- SMTP Configuration -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-server mr-2 text-purple-500"></i>
                                    Konfigurasi SMTP
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="mail_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            SMTP Host
                                        </label>
                                        <input type="text" name="mail_host" id="mail_host"
                                               value="<?php echo e(old('mail_host', $getSetting($settings, 'mail_host'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="smtp.gmail.com">
                                    </div>

                                    <div>
                                        <label for="mail_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            SMTP Port
                                        </label>
                                        <input type="number" name="mail_port" id="mail_port"
                                               value="<?php echo e(old('mail_port', $getSetting($settings, 'mail_port', '587'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="mail_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            SMTP Username
                                        </label>
                                        <input type="email" name="mail_username" id="mail_username"
                                               value="<?php echo e(old('mail_username', $getSetting($settings, 'mail_username'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="mail_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            SMTP Password
                                        </label>
                                        <input type="password" name="mail_password" id="mail_password"
                                               value="<?php echo e(old('mail_password', $getSetting($settings, 'mail_password'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                    </div>

                                    <div>
                                        <label for="mail_encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Enkripsi
                                        </label>
                                        <select name="mail_encryption" id="mail_encryption"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                            <option value="tls" <?php echo e($getSetting($settings, 'mail_encryption', 'tls') == 'tls' ? 'selected' : ''); ?>>TLS</option>
                                            <option value="ssl" <?php echo e($getSetting($settings, 'mail_encryption') == 'ssl' ? 'selected' : ''); ?>>SSL</option>
                                            <option value="" <?php echo e($getSetting($settings, 'mail_encryption') == '' ? 'selected' : ''); ?>>None</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Nama Pengirim
                                        </label>
                                        <input type="text" name="mail_from_name" id="mail_from_name"
                                               value="<?php echo e(old('mail_from_name', $getSetting($settings, 'mail_from_name'))); ?>"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>

                                <!-- Test Email -->
                                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-md font-medium text-gray-900 dark:text-white">Test Email</h4>
                                        <button type="button" onclick="testEmail()" 
                                                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                                            <i class="fas fa-paper-plane mr-2"></i>Kirim Test Email
                                        </button>
                                    </div>
                                    <input type="email" id="test_email_to" placeholder="Email tujuan test"
                                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                </div>
                            </div>

                            <!-- Notification Settings -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-bell mr-2 text-yellow-500"></i>
                                    Pengaturan Notifikasi
                                </h3>
                                
                                <!-- Global Notification Toggle -->
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg mb-6">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Email Notifikasi</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Aktifkan notifikasi via email</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="email_notifications_enabled" value="1" class="sr-only peer"
                                               <?php echo e($getSetting($settings, 'email_notifications_enabled', '1') ? 'checked' : ''); ?>>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                                    </label>
                                </div>

                                <!-- Notification Types -->
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div>
                                            <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Registrasi</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi saat ada pendaftaran baru</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="registration_notifications" value="1" class="sr-only peer"
                                                   <?php echo e($getSetting($settings, 'registration_notifications', '1') ? 'checked' : ''); ?>>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div>
                                            <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Sistem</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi error dan peringatan sistem</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="system_notifications" value="1" class="sr-only peer"
                                                   <?php echo e($getSetting($settings, 'system_notifications', '1') ? 'checked' : ''); ?>>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div>
                                            <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Pengumuman</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi pengumuman dan berita baru</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="announcement_notifications" value="1" class="sr-only peer"
                                                   <?php echo e($getSetting($settings, 'announcement_notifications', '1') ? 'checked' : ''); ?>>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                        <div>
                                            <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Agenda</h5>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi agenda dan jadwal kegiatan</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="agenda_notifications" value="1" class="sr-only peer"
                                                   <?php echo e($getSetting($settings, 'agenda_notifications', '1') ? 'checked' : ''); ?>>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Backup & Maintenance Tab -->
                <div id="backup-tab" class="tab-content hidden">
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-database mr-3"></i>Backup & Maintenance
                            </h2>
                        </div>
                        <div class="p-6 space-y-8">
                            <!-- Auto Backup Settings -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-sync-alt mr-2 text-blue-500"></i>
                                    Backup Otomatis
                                </h3>
                                
                                <!-- Auto Backup Toggle -->
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg mb-6">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Aktifkan Backup Otomatis</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Backup database dan file secara otomatis</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="auto_backup_enabled" value="1" class="sr-only peer"
                                               <?php echo e($getSetting($settings, 'auto_backup_enabled') ? 'checked' : ''); ?>>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="backup_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Frekuensi Backup
                                        </label>
                                        <select name="backup_frequency" id="backup_frequency"
                                                class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                            <option value="daily" <?php echo e($getSetting($settings, 'backup_frequency', 'daily') == 'daily' ? 'selected' : ''); ?>>Harian</option>
                                            <option value="weekly" <?php echo e($getSetting($settings, 'backup_frequency') == 'weekly' ? 'selected' : ''); ?>>Mingguan</option>
                                            <option value="monthly" <?php echo e($getSetting($settings, 'backup_frequency') == 'monthly' ? 'selected' : ''); ?>>Bulanan</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="backup_retention_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Simpan Backup (hari)
                                        </label>
                                        <input type="number" name="backup_retention_days" id="backup_retention_days"
                                               value="<?php echo e(old('backup_retention_days', $getSetting($settings, 'backup_retention_days', '30'))); ?>"
                                               min="7" max="365"
                                               class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    </div>
                                </div>
                            </div>

                            <!-- Manual Backup Actions -->
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-xl p-6">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <i class="fas fa-tools mr-2 text-orange-500"></i>
                                    Maintenance Tools
                                </h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <button type="button" onclick="createBackup()" 
                                            class="p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors flex flex-col items-center">
                                        <i class="fas fa-download text-2xl mb-2"></i>
                                        <span class="font-medium">Buat Backup</span>
                                        <span class="text-xs opacity-75">Database & Files</span>
                                    </button>

                                    <button type="button" onclick="clearCache()" 
                                            class="p-4 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex flex-col items-center">
                                        <i class="fas fa-broom text-2xl mb-2"></i>
                                        <span class="font-medium">Clear Cache</span>
                                        <span class="text-xs opacity-75">Bersihkan Cache</span>
                                    </button>

                                    <button type="button" onclick="optimizeSystem()" 
                                            class="p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors flex flex-col items-center">
                                        <i class="fas fa-rocket text-2xl mb-2"></i>
                                        <span class="font-medium">Optimize</span>
                                        <span class="text-xs opacity-75">Optimasi Sistem</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- System Information -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>Informasi Sistem
                        </h3>
                    </div>
                    <div class="p-6">
                        <?php if(!empty($systemInfo)): ?>
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">PHP Version:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($systemInfo['php_version'] ?? 'Unknown'); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Laravel:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($systemInfo['laravel_version'] ?? 'Unknown'); ?></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Environment:</span>
                                    <span class="text-sm font-medium <?php echo e($systemInfo['environment'] == 'production' ? 'text-green-600' : 'text-yellow-600'); ?>">
                                        <?php echo e(ucfirst($systemInfo['environment'] ?? 'Unknown')); ?>

                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">Storage Used:</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white"><?php echo e($systemInfo['storage_used'] ?? 0); ?> MB</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Informasi sistem tidak tersedia</p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-history mr-2"></i>Aktivitas Terbaru
                        </h3>
                    </div>
                    <div class="p-6">
                        <?php if(!empty($recentActivities)): ?>
                            <div class="space-y-3">
                                <?php $__currentLoopData = array_slice($recentActivities, 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex items-start space-x-3">
                                        <div class="w-8 h-8 bg-<?php echo e($activity['color']); ?>-100 dark:bg-<?php echo e($activity['color']); ?>-900 rounded-lg flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-<?php echo e($activity['icon']); ?> text-<?php echo e($activity['color']); ?>-600 dark:text-<?php echo e($activity['color']); ?>-400 text-sm"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm text-gray-900 dark:text-white"><?php echo e($activity['message']); ?></p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400"><?php echo e($activity['timestamp']->diffForHumans()); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php else: ?>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada aktivitas terbaru</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-8 flex justify-end">
            <button type="submit" 
                    class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-save mr-2"></i>Simpan Pengaturan
            </button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Tab switching functionality
function switchTab(tabName) {
    // Hide all tab contents
    document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.add('hidden');
    });
    
    // Remove active class from all tab buttons
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active', 'border-blue-500', 'text-blue-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Show selected tab content
    document.getElementById(tabName + '-tab').classList.remove('hidden');
    
    // Add active class to selected tab button
    event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
    event.target.classList.remove('border-transparent', 'text-gray-500');
}

// Test email functionality
function testEmail() {
    const email = document.getElementById('test_email_to').value;
    if (!email) {
        alert('Masukkan email tujuan terlebih dahulu');
        return;
    }
    
    fetch('<?php echo e(route("admin.settings.test-email")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            email: email,
            template: 'basic'
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat mengirim email test');
    });
}

// Backup functionality
function createBackup() {
    if (!confirm('Buat backup database sekarang?')) return;
    
    fetch('<?php echo e(route("admin.settings.create-backup")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat membuat backup');
    });
}

// Clear cache functionality
function clearCache() {
    if (!confirm('Bersihkan cache sistem?')) return;
    
    fetch('<?php echo e(route("admin.settings.clear-cache")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat membersihkan cache');
    });
}

// Optimize system functionality
function optimizeSystem() {
    if (!confirm('Optimasi sistem sekarang?')) return;
    
    fetch('<?php echo e(route("admin.settings.optimize")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat mengoptimasi sistem');
    });
}

// Reset to default functionality
function resetToDefault() {
    if (!confirm('Reset semua pengaturan ke default? Tindakan ini tidak dapat dibatalkan!')) return;
    
    fetch('<?php echo e(route("admin.settings.reset")); ?>', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ ' + data.message);
            location.reload();
        } else {
            alert('❌ ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('❌ Terjadi kesalahan saat reset pengaturan');
    });
}

// Export settings functionality
function exportSettings() {
    window.location.href = '<?php echo e(route("admin.settings")); ?>?export=json';
}

// Form validation
document.getElementById('settings-form').addEventListener('submit', function(e) {
    const schoolName = document.getElementById('school_name').value;
    if (!schoolName.trim()) {
        e.preventDefault();
        alert('Nama sekolah harus diisi!');
        document.getElementById('school_name').focus();
        return false;
    }
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\sekolah-web\resources\views/admin/settings/index.blade.php ENDPATH**/ ?>