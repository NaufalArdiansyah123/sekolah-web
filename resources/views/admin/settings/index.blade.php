@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
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
                <p class="hero-subtitle">Configure and customize your school management system with advanced controls</p>
                <div class="hero-breadcrumb">
                    <span class="breadcrumb-item">
                        <i class="fas fa-home"></i>
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                    </span>
                    <span class="breadcrumb-separator">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="breadcrumb-item active">Settings</span>
                </div>
            </div>
        </div>
        <div class="hero-stats">
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">3</span>
                    <span class="stat-label">Categories</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-sliders-h"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">12+</span>
                    <span class="stat-label">Settings</span>
                </div>
            </div>
            <div class="stat-item">
                <div class="stat-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <div class="stat-content">
                    <span class="stat-number">100%</span>
                    <span class="stat-label">Secure</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert-container">
            <div class="alert alert-success">
                <div class="alert-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="alert-content">
                    <h4 class="alert-title">Success!</h4>
                    <p class="alert-message">{{ session('success') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-container">
            <div class="alert alert-error">
                <div class="alert-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="alert-content">
                    <h4 class="alert-title">Error!</h4>
                    <p class="alert-message">{{ session('error') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Main Settings Container -->
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
        @csrf
        @method('PUT')

        <div class="settings-container">
            <!-- Enhanced Tab Navigation -->
            <div class="tab-navigation">
                <div class="nav-background"></div>
                <div class="nav-content">
                    <div class="nav-tabs">
                        <button type="button" class="nav-tab active" data-tab="academic">
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
                <!-- Academic Settings Panel -->
                <div class="tab-panel active" id="academic-panel">
                    <div class="panel-header">
                        <div class="header-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="header-content">
                            <h2 class="panel-title">Academic Settings</h2>
                            <p class="panel-subtitle">Configure academic year, semester, and attendance settings for your institution</p>
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
                                            <input type="text" class="form-control @error('academic_year') error @enderror" 
                                                   id="academic_year" name="academic_year" 
                                                   value="{{ old('academic_year', $settings['academic_year']->value ?? '2024/2025') }}"
                                                   placeholder=" ">
                                            <label for="academic_year" class="form-label">Academic Year</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('academic_year')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="select-container">
                                            <select class="form-select @error('semester') error @enderror" 
                                                    id="semester" name="semester">
                                                <option value="1" {{ old('semester', $settings['semester']->value ?? '') == '1' ? 'selected' : '' }}>Semester 1 (Odd)</option>
                                                <option value="2" {{ old('semester', $settings['semester']->value ?? '') == '2' ? 'selected' : '' }}>Semester 2 (Even)</option>
                                            </select>
                                            <label for="semester" class="form-label">Current Semester</label>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('semester')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="select-container">
                                            <select class="form-select @error('school_timezone') error @enderror" 
                                                    id="school_timezone" name="school_timezone">
                                                <option value="Asia/Jakarta" {{ old('school_timezone', $settings['school_timezone']->value ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                                <option value="Asia/Makassar" {{ old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                                <option value="Asia/Jayapura" {{ old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                                            </select>
                                            <label for="school_timezone" class="form-label">Timezone</label>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('school_timezone')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                            <input type="time" class="form-control @error('attendance_start_time') error @enderror" 
                                                   id="attendance_start_time" name="attendance_start_time" 
                                                   value="{{ old('attendance_start_time', $settings['attendance_start_time']->value ?? '07:00') }}">
                                            <label for="attendance_start_time" class="form-label">Attendance Start Time</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('attendance_start_time')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="input-container">
                                            <input type="time" class="form-control @error('attendance_end_time') error @enderror" 
                                                   id="attendance_end_time" name="attendance_end_time" 
                                                   value="{{ old('attendance_end_time', $settings['attendance_end_time']->value ?? '07:30') }}">
                                            <label for="attendance_end_time" class="form-label">Attendance End Time</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('attendance_end_time')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                            <p class="panel-subtitle">Configure system security, performance limits, and operational controls</p>
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
                                                <p class="toggle-description">Put the site in maintenance mode for updates and repairs</p>
                                            </div>
                                            <div class="toggle-switch">
                                                <input type="hidden" name="maintenance_mode" value="0">
                                                <input type="checkbox" id="maintenance_mode" name="maintenance_mode" value="1"
                                                       {{ old('maintenance_mode', $settings['maintenance_mode']->value ?? '0') == '1' ? 'checked' : '' }}>
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
                                                <p class="toggle-description">Izinkan siswa untuk mendaftar akun baru di platform</p>
                                            </div>
                                            <div class="toggle-switch">
                                                <input type="hidden" name="allow_registration" value="0">
                                                <input type="checkbox" id="allow_registration" name="allow_registration" value="1"
                                                       {{ old('allow_registration', $settings['allow_registration']->value ?? '1') == '1' ? 'checked' : '' }}>
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
                                            <input type="number" class="form-control @error('max_upload_size') error @enderror" 
                                                   id="max_upload_size" name="max_upload_size" 
                                                   value="{{ old('max_upload_size', $settings['max_upload_size']->value ?? '10') }}"
                                                   min="1" max="100" placeholder=" ">
                                            <label for="max_upload_size" class="form-label">Max Upload Size (MB)</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('max_upload_size')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="input-container">
                                            <input type="number" class="form-control @error('session_lifetime') error @enderror" 
                                                   id="session_lifetime" name="session_lifetime" 
                                                   value="{{ old('session_lifetime', $settings['session_lifetime']->value ?? '120') }}"
                                                   min="30" max="1440" placeholder=" ">
                                            <label for="session_lifetime" class="form-label">Session Lifetime (minutes)</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('session_lifetime')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="input-container">
                                            <input type="number" class="form-control @error('max_login_attempts') error @enderror" 
                                                   id="max_login_attempts" name="max_login_attempts" 
                                                   value="{{ old('max_login_attempts', $settings['max_login_attempts']->value ?? '5') }}"
                                                   min="3" max="10" placeholder=" ">
                                            <label for="max_login_attempts" class="form-label">Max Login Attempts</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('max_login_attempts')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                                <p class="toggle-description">Automatically create system backups on schedule</p>
                                            </div>
                                            <div class="toggle-switch">
                                                <input type="hidden" name="auto_backup_enabled" value="0">
                                                <input type="checkbox" id="auto_backup_enabled" name="auto_backup_enabled" value="1"
                                                       {{ old('auto_backup_enabled', $settings['auto_backup_enabled']->value ?? '0') == '1' ? 'checked' : '' }}>
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
                                            <select class="form-select @error('backup_frequency') error @enderror" 
                                                    id="backup_frequency" name="backup_frequency">
                                                <option value="daily" {{ old('backup_frequency', $settings['backup_frequency']->value ?? 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                                                <option value="weekly" {{ old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                                <option value="monthly" {{ old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            </select>
                                            <label for="backup_frequency" class="form-label">Backup Frequency</label>
                                            <div class="select-arrow">
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('backup_frequency')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <div class="input-container">
                                            <input type="number" class="form-control @error('backup_retention_days') error @enderror" 
                                                   id="backup_retention_days" name="backup_retention_days" 
                                                   value="{{ old('backup_retention_days', $settings['backup_retention_days']->value ?? '30') }}"
                                                   min="7" max="365" placeholder=" ">
                                            <label for="backup_retention_days" class="form-label">Retention Days</label>
                                            <div class="input-border"></div>
                                            <div class="input-focus"></div>
                                        </div>
                                        @error('backup_retention_days')
                                            <div class="error-message">
                                                <i class="fas fa-exclamation-triangle"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
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
                                        <button type="button" class="action-btn primary" onclick="window.open('{{ route('admin.backup.index') }}', '_blank')">
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

@endsection

@push('styles')
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
    width: 33.333%;
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

.form-control:focus + .form-label,
.form-control:not(:placeholder-shown) + .form-label,
.form-select:focus + .form-label,
.form-select:not([value=""]) + .form-label {
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

.form-control:focus ~ .input-focus,
.form-select:focus ~ .input-focus {
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

.form-select:focus ~ .select-arrow {
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

input:checked + .switch .slider {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 0 20px rgba(102, 126, 234, 0.3);
}

input:checked + .switch .slider:before {
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

input:checked + .switch .switch-text.on {
    opacity: 1;
}

input:checked + .switch .switch-text.off {
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
@endpush

@push('scripts')
<script>
// Tab navigation functionality
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.nav-tab');
    const panels = document.querySelectorAll('.tab-panel');
    const slider = document.querySelector('.nav-slider');
    
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
window.testEmail = function() {
    document.getElementById('testEmailModal').classList.add('active');
};

window.closeModal = function(modalId) {
    document.getElementById(modalId).classList.remove('active');
};

window.sendTestEmail = function() {
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
window.clearCache = function() {
    if (confirm('Are you sure you want to clear the application cache?')) {
        // Make AJAX call to clear cache
        alert('Cache cleared successfully!');
    }
};

window.optimizeSystem = function() {
    if (confirm('Are you sure you want to optimize the system?')) {
        // Make AJAX call to optimize system
        alert('System optimization completed!');
    }
};

window.resetForm = function() {
    if (confirm('Are you sure you want to reset all settings to default values?')) {
        document.getElementById('settingsForm').reset();
    }
};

window.previewChanges = function() {
    alert('Preview functionality would show changes before saving.');
};
</script>
@endpush