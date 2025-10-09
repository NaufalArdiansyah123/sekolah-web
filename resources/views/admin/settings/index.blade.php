@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
    <div class="settings-page">
        <!-- Simple Header -->
        <div class="page-header">
            <div class="header-content">
                <h1 class="page-title">System Settings</h1>
                <p class="page-subtitle">Configure your school management system</p>
            </div>
        </div>

        <!-- Main Settings Container -->
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settingsForm">
            @csrf
            @method('PUT')

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
                                        <input type="text" class="form-control @error('school_name') error @enderror"
                                            id="school_name" name="school_name"
                                            value="{{ old('school_name', $settings['school_name']->value ?? 'SMA Negeri 1') }}">
                                        @error('school_name')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="school_subtitle">School Subtitle</label>
                                        <input type="text" class="form-control @error('school_subtitle') error @enderror"
                                            id="school_subtitle" name="school_subtitle"
                                            value="{{ old('school_subtitle', $settings['school_subtitle']->value ?? 'Admin Panel') }}">
                                        @error('school_subtitle')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                            @if(isset($settings['school_logo']) && $settings['school_logo']->value)
                                                <img src="{{ asset('storage/' . $settings['school_logo']->value) }}" 
                                                     alt="Current Logo" class="current-logo" id="currentLogo">
                                            @else
                                                <div class="no-logo" id="noLogo">
                                                    <i class="fas fa-school"></i>
                                                    <p>No logo uploaded</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" class="form-control @error('school_logo') error @enderror"
                                            id="school_logo" name="school_logo" accept="image/*" onchange="previewLogo(this)">
                                        @error('school_logo')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label>Favicon</label>
                                        <div class="file-preview favicon-preview">
                                            @if(isset($settings['school_favicon']) && $settings['school_favicon']->value)
                                                <img src="{{ asset('storage/' . $settings['school_favicon']->value) }}" 
                                                     alt="Current Favicon" class="current-favicon" id="currentFavicon">
                                            @else
                                                <div class="no-favicon" id="noFavicon">
                                                    <i class="fas fa-star"></i>
                                                    <p>No favicon</p>
                                                </div>
                                            @endif
                                        </div>
                                        <input type="file" class="form-control @error('school_favicon') error @enderror"
                                            id="school_favicon" name="school_favicon" accept="image/*" onchange="previewFavicon(this)">
                                        @error('school_favicon')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                    <h3>Tahun Akademik</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="academic_year">Tahun Akademik</label>
                                        <input type="text" class="form-control @error('academic_year') error @enderror"
                                            id="academic_year" name="academic_year"
                                            value="{{ old('academic_year', $settings['academic_year']->value ?? '2024/2025') }}">
                                        @error('academic_year')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="semester">Current Semester</label>
                                        <select class="form-control @error('semester') error @enderror" id="semester" name="semester">
                                            <option value="1" {{ old('semester', $settings['semester']->value ?? '') == '1' ? 'selected' : '' }}>Semester 1 (Odd)</option>
                                            <option value="2" {{ old('semester', $settings['semester']->value ?? '') == '2' ? 'selected' : '' }}>Semester 2 (Even)</option>
                                        </select>
                                        @error('semester')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="school_timezone">Timezone</label>
                                        <select class="form-control @error('school_timezone') error @enderror" id="school_timezone" name="school_timezone">
                                            <option value="Asia/Jakarta" {{ old('school_timezone', $settings['school_timezone']->value ?? 'Asia/Jakarta') == 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                            <option value="Asia/Makassar" {{ old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                            <option value="Asia/Jayapura" {{ old('school_timezone', $settings['school_timezone']->value ?? '') == 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                                        </select>
                                        @error('school_timezone')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                        <input type="time" class="form-control @error('attendance_start_time') error @enderror"
                                            id="attendance_start_time" name="attendance_start_time"
                                            value="{{ old('attendance_start_time', $settings['attendance_start_time']->value ?? '07:00') }}">
                                        @error('attendance_start_time')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="attendance_end_time">Attendance End Time</label>
                                        <input type="time" class="form-control @error('attendance_end_time') error @enderror"
                                            id="attendance_end_time" name="attendance_end_time"
                                            value="{{ old('attendance_end_time', $settings['attendance_end_time']->value ?? '07:30') }}">
                                        @error('attendance_end_time')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                                    value="1" {{ old('maintenance_mode', $settings['maintenance_mode']->value ?? '0') == '1' ? 'checked' : '' }}>
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
                                                    value="1" {{ old('allow_registration', $settings['allow_registration']->value ?? '1') == '1' ? 'checked' : '' }}>
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
                                        <input type="number" class="form-control @error('max_upload_size') error @enderror"
                                            id="max_upload_size" name="max_upload_size"
                                            value="{{ old('max_upload_size', $settings['max_upload_size']->value ?? '10') }}"
                                            min="1" max="100">
                                        @error('max_upload_size')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="session_lifetime">Session Lifetime (minutes)</label>
                                        <input type="number" class="form-control @error('session_lifetime') error @enderror"
                                            id="session_lifetime" name="session_lifetime"
                                            value="{{ old('session_lifetime', $settings['session_lifetime']->value ?? '120') }}"
                                            min="30" max="1440">
                                        @error('session_lifetime')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="max_login_attempts">Max Login Attempts</label>
                                        <input type="number" class="form-control @error('max_login_attempts') error @enderror"
                                            id="max_login_attempts" name="max_login_attempts"
                                            value="{{ old('max_login_attempts', $settings['max_login_attempts']->value ?? '5') }}"
                                            min="3" max="10">
                                        @error('max_login_attempts')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                        <textarea class="form-control @error('footer_description') error @enderror"
                                            id="footer_description" name="footer_description" rows="4">{{ old('footer_description', $settings['footer_description']->value ?? 'Excellence in Education - Membentuk generasi yang berkarakter dan berprestasi untuk masa depan Indonesia yang gemilang.') }}</textarea>
                                        @error('footer_description')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                        <input type="url" class="form-control @error('footer_facebook') error @enderror"
                                            id="footer_facebook" name="footer_facebook"
                                            value="{{ old('footer_facebook', $settings['footer_facebook']->value ?? '') }}">
                                        @error('footer_facebook')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_instagram">Instagram URL</label>
                                        <input type="url" class="form-control @error('footer_instagram') error @enderror"
                                            id="footer_instagram" name="footer_instagram"
                                            value="{{ old('footer_instagram', $settings['footer_instagram']->value ?? '') }}">
                                        @error('footer_instagram')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_youtube">YouTube URL</label>
                                        <input type="url" class="form-control @error('footer_youtube') error @enderror"
                                            id="footer_youtube" name="footer_youtube"
                                            value="{{ old('footer_youtube', $settings['footer_youtube']->value ?? '') }}">
                                        @error('footer_youtube')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_twitter">Twitter URL</label>
                                        <input type="url" class="form-control @error('footer_twitter') error @enderror"
                                            id="footer_twitter" name="footer_twitter"
                                            value="{{ old('footer_twitter', $settings['footer_twitter']->value ?? '') }}">
                                        @error('footer_twitter')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Contact Information</h3>
                                </div>
                                <div class="card-content">
                                    <div class="form-group">
                                        <label for="footer_address">Alamat</label>
                                        <textarea class="form-control @error('footer_address') error @enderror"
                                            id="footer_address" name="footer_address" rows="3">{{ old('footer_address', $settings['footer_address']->value ?? 'Jl. Pendidikan No. 123, Ponorogo, Jawa Timur 63411') }}</textarea>
                                        @error('footer_address')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_phone">Nomor Telepon</label>
                                        <input type="text" class="form-control @error('footer_phone') error @enderror"
                                            id="footer_phone" name="footer_phone"
                                            value="{{ old('footer_phone', $settings['footer_phone']->value ?? '(0352) 123-4567') }}">
                                        @error('footer_phone')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="footer_email">Alamat Email</label>
                                        <input type="email" class="form-control @error('footer_email') error @enderror"
                                            id="footer_email" name="footer_email"
                                            value="{{ old('footer_email', $settings['footer_email']->value ?? 'info@smkpgri2ponorogo.sch.id') }}">
                                        @error('footer_email')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
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
                                                    value="1" {{ old('auto_backup_enabled', $settings['auto_backup_enabled']->value ?? '0') == '1' ? 'checked' : '' }}>
                                                <label for="auto_backup_enabled" class="switch"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="backup_frequency">Backup Frequency</label>
                                        <select class="form-control @error('backup_frequency') error @enderror" id="backup_frequency" name="backup_frequency">
                                            <option value="daily" {{ old('backup_frequency', $settings['backup_frequency']->value ?? 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="weekly" {{ old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="monthly" {{ old('backup_frequency', $settings['backup_frequency']->value ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                        </select>
                                        @error('backup_frequency')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="backup_retention_days">Retention Days</label>
                                        <input type="number" class="form-control @error('backup_retention_days') error @enderror"
                                            id="backup_retention_days" name="backup_retention_days"
                                            value="{{ old('backup_retention_days', $settings['backup_retention_days']->value ?? '30') }}"
                                            min="7" max="365">
                                        @error('backup_retention_days')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="setting-card">
                                <div class="card-header">
                                    <h3>Quick Actions</h3>
                                </div>
                                <div class="card-content">
                                    <div class="action-buttons">
                                        <button type="button" class="action-btn" onclick="window.open('{{ route('admin.backup.index') }}', '_blank')">
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
                        <!-- <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                            <i class="fas fa-arrow-left"></i>
                            Back
                        </button> -->
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
                    <h3 id="alertModalTitle">Berhasil!</h3>
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
                <p>Mohon tunggu...</p>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        /* CSS Variables for Dark Mode Support */
        :root {
            /* Light Mode Colors */
            --color-bg-primary: #f8f9fa;
            --color-bg-secondary: #ffffff;
            --color-bg-tertiary: #f7fafc;
            --color-text-primary: #2d3748;
            --color-text-secondary: #4a5568;
            --color-text-muted: #718096;
            --color-border: #e2e8f0;
            --color-border-light: #edf2f7;
            --color-shadow: rgba(0, 0, 0, 0.1);
            --color-shadow-modal: rgba(0, 0, 0, 0.2);
            --color-overlay: rgba(0, 0, 0, 0.5);
            
            /* Button Colors */
            --color-primary: #4299e1;
            --color-primary-hover: #3182ce;
            --color-secondary: #edf2f7;
            --color-secondary-hover: #e2e8f0;
            --color-success: #48bb78;
            --color-error: #e53e3e;
            
            /* Form Colors */
            --color-input-bg: #ffffff;
            --color-input-border: #e2e8f0;
            --color-input-focus: #4299e1;
            --color-input-error: #e53e3e;
            
            /* Toggle Colors */
            --color-toggle-bg: #cbd5e0;
            --color-toggle-active: #4299e1;
            --color-toggle-thumb: #ffffff;
            
            /* File Preview Colors */
            --color-file-preview-bg: #f7fafc;
            --color-file-preview-border: #e2e8f0;
            --color-file-preview-text: #a0aec0;
        }

        /* Dark Mode Colors - Applied via .dark class */
        .dark {
            --color-bg-primary: #1a202c;
            --color-bg-secondary: #2d3748;
            --color-bg-tertiary: #4a5568;
            --color-text-primary: #f7fafc;
            --color-text-secondary: #e2e8f0;
            --color-text-muted: #a0aec0;
            --color-border: #4a5568;
            --color-border-light: #718096;
            --color-shadow: rgba(0, 0, 0, 0.3);
            --color-shadow-modal: rgba(0, 0, 0, 0.5);
            --color-overlay: rgba(0, 0, 0, 0.7);
            
            --color-secondary: #4a5568;
            --color-secondary-hover: #718096;
            
            --color-input-bg: #2d3748;
            --color-input-border: #4a5568;
            --color-toggle-bg: #4a5568;
            --color-toggle-thumb: #e2e8f0;
            
            --color-file-preview-bg: #2d3748;
            --color-file-preview-border: #4a5568;
            --color-file-preview-text: #718096;
        }

        /* Smooth transitions for color changes */
        * {
            transition: background-color 0.3s ease, border-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
        }

        /* Settings Page Styles with Dark Mode Support */
        .settings-page {
            padding: 20px;
            background-color: var(--color-bg-primary);
            min-height: 100vh;
        }

        /* Header */
        .page-header {
            background: var(--color-bg-secondary);
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px var(--color-shadow);
        }

        .page-title {
            font-size: 28px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: var(--color-text-primary);
        }

        .page-subtitle {
            font-size: 16px;
            color: var(--color-text-muted);
            margin: 0;
        }

        /* Settings Container */
        .settings-container {
            background: var(--color-bg-secondary);
            border-radius: 8px;
            box-shadow: 0 2px 4px var(--color-shadow);
            overflow: hidden;
        }

        /* Tab Navigation */
        .tab-navigation {
            border-bottom: 1px solid var(--color-border);
            background: var(--color-bg-tertiary);
        }

        .nav-tabs {
            display: flex;
            padding: 0 20px;
            overflow-x: auto;
        }

        .nav-tab {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 15px 20px;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--color-text-muted);
            font-weight: 500;
            border-bottom: 3px solid transparent;
            white-space: nowrap;
        }

        .nav-tab:hover {
            color: var(--color-primary);
            background: rgba(66, 153, 225, 0.1);
        }

        .nav-tab.active {
            color: var(--color-primary);
            border-bottom-color: var(--color-primary);
            background: var(--color-bg-secondary);
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
            border-bottom: 1px solid var(--color-border);
        }

        .panel-header h2 {
            font-size: 24px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: var(--color-text-primary);
        }

        .panel-header p {
            font-size: 16px;
            color: var(--color-text-muted);
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
            border: 1px solid var(--color-border);
            border-radius: 8px;
            overflow: hidden;
        }

        .card-header {
            background: var(--color-bg-tertiary);
            padding: 20px;
            border-bottom: 1px solid var(--color-border);
        }

        .card-header h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: var(--color-text-primary);
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
            color: var(--color-text-secondary);
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--color-input-border);
            border-radius: 6px;
            font-size: 14px;
            background: var(--color-input-bg);
            color: var(--color-text-primary);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--color-input-focus);
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
        }

        .form-control.error {
            border-color: var(--color-input-error);
        }

        .error-message {
            color: var(--color-error);
            font-size: 12px;
            margin-top: 4px;
        }

        /* File Preview */
        .file-preview {
            margin-bottom: 15px;
            padding: 20px;
            border: 2px dashed var(--color-file-preview-border);
            border-radius: 6px;
            text-align: center;
            background: var(--color-file-preview-bg);
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
            color: var(--color-file-preview-text);
        }

        .no-logo i, .no-favicon i {
            font-size: 32px;
            margin-bottom: 8px;
        }

        /* Toggle Switches */
        .toggle-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 15px;
        }

        .toggle-item label {
            flex: 1;
            margin-bottom: 0;
        }

        .toggle-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 600;
            color: var(--color-text-primary);
        }

        .toggle-description {
            display: block;
            font-size: 12px;
            font-weight: 400;
            color: var(--color-text-muted);
            margin-top: 4px;
        }

        .dark-mode-icon {
            color: var(--color-primary);
        }

        .toggle-switch {
            position: relative;
            flex-shrink: 0;
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
            background-color: var(--color-toggle-bg);
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
            background-color: var(--color-toggle-thumb);
            border-radius: 50%;
            transition: 0.3s;
        }

        input:checked + .switch:before {
            background-color: var(--color-toggle-active);
        }

        input:checked + .switch:after {
            transform: translateX(26px);
        }

        /* Dark Mode Switch Special Styling */
        .dark-mode-switch:before {
            background: linear-gradient(45deg, #cbd5e0, #e2e8f0);
        }

        input:checked + .dark-mode-switch:before {
            background: linear-gradient(45deg, #4299e1, #3182ce);
        }

        /* Theme Preview */
        .theme-preview {
            margin-top: 15px;
            padding: 20px;
            border: 1px solid var(--color-border);
            border-radius: 8px;
            background: var(--color-bg-tertiary);
        }

        .preview-card {
            background: var(--color-bg-secondary);
            border: 1px solid var(--color-border);
            border-radius: 6px;
            overflow: hidden;
        }

        .preview-header {
            padding: 15px;
            background: var(--color-bg-tertiary);
            border-bottom: 1px solid var(--color-border);
        }

        .preview-title {
            font-weight: 600;
            color: var(--color-text-primary);
            margin-bottom: 4px;
        }

        .preview-subtitle {
            font-size: 12px;
            color: var(--color-text-muted);
        }

        .preview-content {
            padding: 15px;
        }

        .preview-input {
            margin-bottom: 15px;
        }

        .preview-input label {
            font-size: 12px;
            margin-bottom: 5px;
        }

        .preview-input input {
            padding: 8px;
            font-size: 12px;
        }

        .preview-buttons {
            display: flex;
            gap: 8px;
        }

        .preview-btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .preview-btn.primary {
            background: var(--color-primary);
            color: white;
        }

        .preview-btn.secondary {
            background: var(--color-secondary);
            color: var(--color-text-secondary);
            border-color: var(--color-border);
        }

        /* Theme Status */
        .theme-status {
            padding: 15px;
            border: 1px solid var(--color-border);
            border-radius: 6px;
            background: var(--color-bg-tertiary);
        }

        .status-indicator {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .status-indicator i {
            color: var(--color-primary);
        }

        .status-indicator span {
            font-weight: 600;
            color: var(--color-text-primary);
        }

        .status-description {
            font-size: 12px;
            color: var(--color-text-muted);
            line-height: 1.4;
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
            background: var(--color-bg-tertiary);
            border: 1px solid var(--color-border);
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            color: var(--color-text-secondary);
        }

        .action-btn:hover {
            background: var(--color-secondary-hover);
            border-color: var(--color-border-light);
        }

        /* Action Bar */
        .action-bar {
            padding: 20px 30px;
            background: var(--color-bg-tertiary);
            border-top: 1px solid var(--color-border);
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
            background: var(--color-primary);
            color: white;
            border-color: var(--color-primary);
        }

        .btn-primary:hover {
            background: var(--color-primary-hover);
            border-color: var(--color-primary-hover);
        }

        .btn-secondary {
            background: var(--color-secondary);
            color: var(--color-text-secondary);
            border-color: var(--color-border);
        }

        .btn-secondary:hover {
            background: var(--color-secondary-hover);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--color-overlay);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-container {
            background: var(--color-bg-secondary);
            border-radius: 8px;
            box-shadow: 0 10px 25px var(--color-shadow-modal);
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
            background: var(--color-success);
        }

        .modal-icon.error {
            background: var(--color-error);
        }

        .modal-content {
            flex: 1;
        }

        .modal-content h3 {
            font-size: 18px;
            font-weight: 600;
            margin: 0 0 8px 0;
            color: var(--color-text-primary);
        }

        .modal-content p {
            font-size: 14px;
            color: var(--color-text-muted);
            margin: 0;
        }

        .modal-close {
            background: none;
            border: none;
            color: var(--color-text-muted);
            cursor: pointer;
            padding: 4px;
        }

        .modal-close:hover {
            color: var(--color-text-secondary);
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
            border: 3px solid var(--color-border);
            border-top: 3px solid var(--color-primary);
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
            color: var(--color-text-primary);
        }

        .loading-content p {
            font-size: 14px;
            color: var(--color-text-muted);
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

            .toggle-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .toggle-switch {
                align-self: flex-end;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Dark Mode Toggle Functions
        function toggleDarkMode() {
            const body = document.body;
            const toggle = document.getElementById('dark_mode_toggle');
            const themeStatus = document.getElementById('themeStatus');
            const themeDescription = document.getElementById('themeDescription');
            
            if (toggle.checked) {
                // Enable dark mode
                body.classList.add('dark');
                localStorage.setItem('darkMode', 'enabled');
                
                // Update status
                themeStatus.innerHTML = '<i class="fas fa-moon"></i><span>Dark Mode Active</span>';
                themeDescription.textContent = 'The interface is currently using the dark theme with dark backgrounds and light text for better viewing in low light conditions.';
                
                console.log('Dark mode enabled');
            } else {
                // Disable dark mode
                body.classList.remove('dark');
                localStorage.setItem('darkMode', 'disabled');
                
                // Update status
                themeStatus.innerHTML = '<i class="fas fa-sun"></i><span>Light Mode Active</span>';
                themeDescription.textContent = 'The interface is currently using the light theme with bright backgrounds and dark text.';
                
                console.log('Dark mode disabled');
            }
        }

        function resetTheme() {
            const body = document.body;
            const toggle = document.getElementById('dark_mode_toggle');
            const themeStatus = document.getElementById('themeStatus');
            const themeDescription = document.getElementById('themeDescription');
            
            // Remove dark mode and clear localStorage
            body.classList.remove('dark');
            localStorage.removeItem('darkMode');
            toggle.checked = false;
            
            // Update status
            themeStatus.innerHTML = '<i class="fas fa-sun"></i><span>Light Mode Active</span>';
            themeDescription.textContent = 'The interface is currently using the light theme with bright backgrounds and dark text.';
            
            showModal('success', 'Theme Reset', 'Theme has been reset to system default (Light Mode).');
        }

        // Initialize dark mode on page load
        function initializeDarkMode() {
            const darkMode = localStorage.getItem('darkMode');
            const toggle = document.getElementById('dark_mode_toggle');
            const body = document.body;
            
            if (darkMode === 'enabled') {
                body.classList.add('dark');
                toggle.checked = true;
                
                // Update status
                const themeStatus = document.getElementById('themeStatus');
                const themeDescription = document.getElementById('themeDescription');
                if (themeStatus && themeDescription) {
                    themeStatus.innerHTML = '<i class="fas fa-moon"></i><span>Dark Mode Active</span>';
                    themeDescription.textContent = 'The interface is currently using the dark theme with dark backgrounds and light text for better viewing in low light conditions.';
                }
            }
        }

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
            // Initialize dark mode
            initializeDarkMode();
            
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
                success: @json(session('success')),
                error: @json(session('error')),
                settings_success_message: @json(session('settings_success_message')),
                settings_error_message: @json(session('settings_error_message')),
                has_success: @json(session()->has('success')),
                has_error: @json(session()->has('error')),
                has_settings_success: @json(session()->has('settings_success_message')),
                has_settings_error: @json(session()->has('settings_error_message'))
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
                success: @json(session('success')),
                error: @json(session('error')),
                has_success: @json(session()->has('success')),
                has_error: @json(session()->has('error'))
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
            @if($errors->any() && old())
                const errors = @json($errors->all());
                showModal('error', 'Validation Error!', errors.join('\n'));
                return;
            @endif
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
@endpush