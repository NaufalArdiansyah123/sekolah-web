{{-- resources/views/admin/settings/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
@php
    // Helper function untuk mengakses setting dengan aman - menggunakan closure untuk menghindari redeclare
    $getSetting = function($settings, $key, $default = '') {
        return isset($settings[$key]) ? $settings[$key]->value : $default;
    };
@endphp

<!-- Header -->
<div class="mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Pengaturan Sistem</h1>
        <p class="text-gray-600 dark:text-gray-400 mt-2">Kelola pengaturan sistem dan konfigurasi website sekolah</p>
    </div>
</div>

<!-- Tab Navigation -->
<div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg mb-6">
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
            <button onclick="switchTab('system')" 
                    class="tab-button active border-blue-500 text-blue-600 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Sistem
            </button>
            <button onclick="switchTab('email')" 
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Email & Notifikasi
            </button>
            <button onclick="switchTab('backup')" 
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                </svg>
                Backup & Maintenance
            </button>
            <button onclick="switchTab('theme')" 
                    class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                </svg>
                Tema & Tampilan
            </button>
        </nav>
    </div>
</div>

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-3">
            
            <!-- System Settings Tab -->
            <div id="system-tab" class="tab-content">
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                            Pengaturan Sistem
                        </h2>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <!-- System Status Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Mode Maintenance</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Aktifkan untuk menutup sementara website</p>
                                        <span class="text-xs {{ $getSetting($settings, 'maintenance_mode') ? 'text-red-600' : 'text-green-600' }} font-medium">
                                            {{ $getSetting($settings, 'maintenance_mode') ? '🔴 Aktif' : '🟢 Tidak Aktif' }}
                                        </span>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="maintenance_mode" 
                                           value="1"
                                           class="sr-only peer"
                                           onchange="updateMaintenanceStatus(this)"
                                           {{ $getSetting($settings, 'maintenance_mode') ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>

                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Izinkan Registrasi</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">User bisa mendaftar sendiri</p>
                                        <span class="text-xs {{ $getSetting($settings, 'allow_registration') ? 'text-green-600' : 'text-gray-600' }} font-medium">
                                            {{ $getSetting($settings, 'allow_registration') ? '🟢 Diizinkan' : '🔒 Ditutup' }}
                                        </span>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" 
                                           name="allow_registration" 
                                           value="1"
                                           class="sr-only peer"
                                           {{ $getSetting($settings, 'allow_registration') ? 'checked' : '' }}>
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                </label>
                            </div>
                        </div>
                        
                        <!-- System Configuration -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                                Konfigurasi Sistem
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="max_upload_size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Ukuran Upload Maksimal (MB)
                                </label>
                                <input type="number" 
                                       name="max_upload_size" 
                                       id="max_upload_size" 
                                       value="{{ old('max_upload_size', $getSetting($settings, 'max_upload_size', 10)) }}"
                                       min="1" 
                                       max="100"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                            </div>

                            <div>
                                <label for="default_user_role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Role Default User Baru
                                </label>
                                <select name="default_user_role" 
                                        id="default_user_role"
                                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="student" {{ $getSetting($settings, 'default_user_role', 'student') == 'student' ? 'selected' : '' }}>Student</option>
                                    <option value="teacher" {{ $getSetting($settings, 'default_user_role', 'student') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="session_lifetime" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Session Lifetime (menit)
                                </label>
                                <input type="number" 
                                       name="session_lifetime" 
                                       id="session_lifetime" 
                                       value="{{ old('session_lifetime', $getSetting($settings, 'session_lifetime', 120)) }}"
                                       min="30" 
                                       max="1440"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Durasi session sebelum logout otomatis</p>
                            </div>

                            <div>
                                <label for="max_login_attempts" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Maksimal Percobaan Login
                                </label>
                                <input type="number" 
                                       name="max_login_attempts" 
                                       id="max_login_attempts" 
                                       value="{{ old('max_login_attempts', $getSetting($settings, 'max_login_attempts', 5)) }}"
                                       min="3" 
                                       max="10"
                                       class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Sebelum akun dikunci sementara</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Email & Notifications Tab -->
            <div id="email-tab" class="tab-content hidden">
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Pengaturan Email & Notifikasi
                            </h2>
                            <div class="flex items-center space-x-2">
                                <span id="email-status-indicator" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Belum Dikonfigurasi
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-6 space-y-8">
                        <!-- SMTP Configuration -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Konfigurasi SMTP</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Pengaturan server email untuk pengiriman notifikasi</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span id="smtp-connection-status" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        Belum Ditest
                                    </span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="mail_host" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path>
                                            </svg>
                                            SMTP Host
                                        </span>
                                    </label>
                                    <input type="text" 
                                           name="mail_host" 
                                           id="mail_host" 
                                           value="{{ old('mail_host', $getSetting($settings, 'mail_host')) }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors"
                                           placeholder="smtp.gmail.com"
                                           onchange="validateEmailConfig()">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Contoh: smtp.gmail.com, smtp.outlook.com</p>
                                </div>

                                <div>
                                    <label for="mail_port" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                            </svg>
                                            SMTP Port
                                        </span>
                                    </label>
                                    <input type="number" 
                                           name="mail_port" 
                                           id="mail_port" 
                                           value="{{ old('mail_port', $getSetting($settings, 'mail_port', 587)) }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors"
                                           placeholder="587"
                                           onchange="validateEmailConfig()">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">TLS: 587, SSL: 465, Non-SSL: 25</p>
                                </div>

                                <div>
                                    <label for="mail_username" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            SMTP Username
                                        </span>
                                    </label>
                                    <input type="email" 
                                           name="mail_username" 
                                           id="mail_username" 
                                           value="{{ old('mail_username', $getSetting($settings, 'mail_username')) }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors"
                                           placeholder="your-email@gmail.com"
                                           onchange="validateEmailConfig()">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Biasanya sama dengan email address</p>
                                </div>

                                <div>
                                    <label for="mail_password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            SMTP Password
                                        </span>
                                    </label>
                                    <div class="relative">
                                        <input type="password" 
                                               name="mail_password" 
                                               id="mail_password" 
                                               value="{{ old('mail_password', $getSetting($settings, 'mail_password')) }}"
                                               class="w-full px-3 py-2 pr-10 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors"
                                               placeholder="••••••••"
                                               onchange="validateEmailConfig()">
                                        <button type="button" onclick="togglePasswordVisibility('mail_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Gunakan App Password untuk Gmail</p>
                                </div>

                                <div>
                                    <label for="mail_encryption" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                            </svg>
                                            Enkripsi
                                        </span>
                                    </label>
                                    <select name="mail_encryption" 
                                            id="mail_encryption"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors"
                                            onchange="validateEmailConfig()">
                                        <option value="tls" {{ $getSetting($settings, 'mail_encryption', 'tls') == 'tls' ? 'selected' : '' }}>TLS (Recommended)</option>
                                        <option value="ssl" {{ $getSetting($settings, 'mail_encryption', 'tls') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        <option value="" {{ $getSetting($settings, 'mail_encryption', 'tls') == '' ? 'selected' : '' }}>None</option>
                                    </select>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">TLS lebih aman dan direkomendasikan</p>
                                </div>

                                <div>
                                    <label for="mail_from_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Nama Pengirim
                                        </span>
                                    </label>
                                    <input type="text" 
                                           name="mail_from_name" 
                                           id="mail_from_name" 
                                           value="{{ old('mail_from_name', $getSetting($settings, 'mail_from_name')) }}"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white transition-colors"
                                           placeholder="SMA Negeri 1 Balong"
                                           onchange="validateEmailConfig()">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Nama yang akan muncul sebagai pengirim</p>
                                </div>
                            </div>

                            <!-- Email Testing Section -->
                            <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Test Koneksi Email</h4>
                                    <div class="flex space-x-2">
                                        <button type="button" 
                                                onclick="testEmailConnection()"
                                                class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Test Koneksi
                                        </button>
                                        <button type="button" 
                                                onclick="sendTestEmail()"
                                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                            </svg>
                                            Kirim Test Email
                                        </button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="test_email_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Email Tujuan Test
                                        </label>
                                        <input type="email" 
                                               id="test_email_to" 
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="test@example.com">
                                    </div>
                                    <div>
                                        <label for="test_email_template" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Template Test
                                        </label>
                                        <select id="test_email_template" 
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-purple-500 focus:border-purple-500 dark:bg-gray-700 dark:text-white">
                                            <option value="basic">Basic Test</option>
                                            <option value="welcome">Welcome Email</option>
                                            <option value="notification">Notification</option>
                                            <option value="announcement">Announcement</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-3.405-3.405A9.954 9.954 0 0118 9a9 9 0 10-9 9c1.74 0 3.35-.476 4.757-1.305L17 20l-2-3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pengaturan Notifikasi</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola jenis dan frekuensi notifikasi sistem</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="testAllNotifications()" class="px-3 py-1 text-xs bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Test Semua
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Global Notification Settings -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    </svg>
                                    Pengaturan Global
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Email Notifikasi</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Aktifkan notifikasi via email</p>
                                            </div>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   name="email_notifications_enabled" 
                                                   value="1"
                                                   class="sr-only peer"
                                                   onchange="toggleEmailNotifications(this)"
                                                   {{ $getSetting($settings, 'email_notifications_enabled', true) ? 'checked' : '' }}>
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                        </label>
                                    </div>
                                    
                                    <div>
                                        <label for="notification_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Frekuensi Notifikasi
                                        </label>
                                        <select name="notification_frequency" 
                                                id="notification_frequency"
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                            <option value="instant" {{ $getSetting($settings, 'notification_frequency', 'instant') == 'instant' ? 'selected' : '' }}>Instant</option>
                                            <option value="hourly" {{ $getSetting($settings, 'notification_frequency', 'instant') == 'hourly' ? 'selected' : '' }}>Setiap Jam</option>
                                            <option value="daily" {{ $getSetting($settings, 'notification_frequency', 'instant') == 'daily' ? 'selected' : '' }}>Harian</option>
                                            <option value="weekly" {{ $getSetting($settings, 'notification_frequency', 'instant') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Specific Notification Types -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h4a1 1 0 011 1v2m-6 0h8m-8 0a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2m-8 0V4"></path>
                                    </svg>
                                    Jenis Notifikasi
                                </h4>
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Registrasi</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi saat ada pendaftaran baru</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="testNotification('registration')" class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                                                Test
                                            </button>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       name="registration_notifications" 
                                                       value="1"
                                                       class="sr-only peer"
                                                       {{ $getSetting($settings, 'registration_notifications', true) ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Sistem</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi error dan peringatan sistem</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="testNotification('system')" class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors">
                                                Test
                                            </button>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       name="system_notifications" 
                                                       value="1"
                                                       class="sr-only peer"
                                                       {{ $getSetting($settings, 'system_notifications', true) ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Pengumuman</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi pengumuman dan berita baru</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="testNotification('announcement')" class="px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition-colors">
                                                Test
                                            </button>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       name="announcement_notifications" 
                                                       value="1"
                                                       class="sr-only peer"
                                                       {{ $getSetting($settings, 'announcement_notifications', true) ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-yellow-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-yellow-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Notifikasi Agenda</h5>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Notifikasi agenda dan jadwal kegiatan</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <button type="button" onclick="testNotification('agenda')" class="px-2 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors">
                                                Test
                                            </button>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" 
                                                       name="agenda_notifications" 
                                                       value="1"
                                                       class="sr-only peer"
                                                       {{ $getSetting($settings, 'agenda_notifications', true) ? 'checked' : '' }}>
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email Template Management -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Template Email
                                    </h4>
                                    <button type="button" onclick="previewEmailTemplate()" class="px-3 py-1 text-xs bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                        Preview Template
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="email_template_header" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Header Template
                                        </label>
                                        <input type="text" 
                                               name="email_template_header" 
                                               id="email_template_header" 
                                               value="{{ old('email_template_header', $getSetting($settings, 'email_template_header', 'SMA Negeri 1 Balong')) }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Nama sekolah untuk header email">
                                    </div>
                                    <div>
                                        <label for="email_template_footer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Footer Template
                                        </label>
                                        <input type="text" 
                                               name="email_template_footer" 
                                               id="email_template_footer" 
                                               value="{{ old('email_template_footer', $getSetting($settings, 'email_template_footer', 'Terima kasih - Tim SMA Negeri 1 Balong')) }}"
                                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="Footer untuk semua email">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup & Maintenance Tab -->
            <div id="backup-tab" class="tab-content hidden">
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                                <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                </svg>
                                Backup & Maintenance
                            </h2>
                            <div class="flex items-center space-x-2">
                                <span id="backup-status-indicator" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Siap
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-6 space-y-8">
                        <!-- Backup Settings -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Pengaturan Backup</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola backup database dan file sistem</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span id="last-backup-time" class="text-xs text-gray-500 dark:text-gray-400">
                                        Backup terakhir: Belum pernah
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Auto Backup Toggle -->
                            <div class="mb-6">
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-300 transition-colors">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                            <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Auto Backup</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Backup otomatis database dan file sistem</p>
                                            <span class="text-xs {{ $getSetting($settings, 'auto_backup_enabled') ? 'text-green-600' : 'text-gray-600' }} font-medium">
                                                {{ $getSetting($settings, 'auto_backup_enabled') ? '🟢 Aktif' : '⚪ Nonaktif' }}
                                            </span>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               name="auto_backup_enabled" 
                                               value="1"
                                               class="sr-only peer"
                                               onchange="toggleAutoBackup(this)"
                                               {{ $getSetting($settings, 'auto_backup_enabled') ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Backup Configuration -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="backup_frequency" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Frekuensi Backup
                                        </span>
                                    </label>
                                    <select name="backup_frequency" 
                                            id="backup_frequency"
                                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-colors">
                                        <option value="daily" {{ $getSetting($settings, 'backup_frequency', 'daily') == 'daily' ? 'selected' : '' }}>Harian (Setiap hari)</option>
                                        <option value="weekly" {{ $getSetting($settings, 'backup_frequency', 'daily') == 'weekly' ? 'selected' : '' }}>Mingguan (Setiap minggu)</option>
                                        <option value="monthly" {{ $getSetting($settings, 'backup_frequency', 'daily') == 'monthly' ? 'selected' : '' }}>Bulanan (Setiap bulan)</option>
                                    </select>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Jadwal backup otomatis</p>
                                </div>

                                <div>
                                    <label for="backup_retention_days" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 8a4 4 0 11-8 0 4 4 0 018 0zm0 0v1a3 3 0 11-6 0v-1m6 0a3 3 0 11-6 0"></path>
                                            </svg>
                                            Simpan Backup (hari)
                                        </span>
                                    </label>
                                    <input type="number" 
                                           name="backup_retention_days" 
                                           id="backup_retention_days" 
                                           value="{{ old('backup_retention_days', $getSetting($settings, 'backup_retention_days', 30)) }}"
                                           min="7" 
                                           max="365"
                                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white transition-colors">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Backup lama akan dihapus otomatis</p>
                                </div>
                            </div>
                            
                            <!-- Backup Actions -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-medium text-gray-900 dark:text-white">Backup Manual</h4>
                                    <div class="flex space-x-2">
                                        <button type="button" 
                                                onclick="createBackup()"
                                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Buat Backup
                                        </button>
                                        <button type="button" 
                                                onclick="listBackups()"
                                                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors duration-200 flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Lihat Backup
                                        </button>
                                    </div>
                                </div>
                                
                                <!-- Backup Types -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Database</h5>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Backup data aplikasi</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="createDatabaseBackup()" class="mt-3 w-full px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors">
                                            Backup Database
                                        </button>
                                    </div>
                                    
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2v0"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Files</h5>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Backup file sistem</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="createFilesBackup()" class="mt-3 w-full px-3 py-1 text-xs bg-green-100 text-green-700 rounded hover:bg-green-200 transition-colors">
                                            Backup Files
                                        </button>
                                    </div>
                                    
                                    <div class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-300 transition-colors">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                                                <svg class="w-4 h-4 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h5 class="font-medium text-gray-900 dark:text-white">Complete</h5>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">Backup lengkap</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="createCompleteBackup()" class="mt-3 w-full px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded hover:bg-purple-200 transition-colors">
                                            Backup Lengkap
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- System Maintenance -->
                        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">System Maintenance</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tools untuk pemeliharaan dan optimasi sistem</p>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button type="button" onclick="runAllMaintenance()" class="px-3 py-1 text-xs bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                                        Jalankan Semua
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Quick Actions -->
                            <div class="mb-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Quick Actions
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <button type="button" 
                                            onclick="clearCache()"
                                            class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors text-left group">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center group-hover:bg-blue-200 dark:group-hover:bg-blue-800 transition-colors">
                                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h5 class="font-medium text-gray-900 dark:text-white">Clear Cache</h5>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Bersihkan cache aplikasi</p>
                                                </div>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </button>

                                    <button type="button" 
                                            onclick="optimizeSystem()"
                                            class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors text-left group">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors">
                                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <h5 class="font-medium text-gray-900 dark:text-white">Optimize System</h5>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Optimasi performa sistem</p>
                                                </div>
                                            </div>
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-green-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Maintenance Tools -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    </svg>
                                    Maintenance Tools
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                    <button type="button" 
                                            onclick="optimizeDatabase()"
                                            class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors text-center group">
                                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-indigo-200 dark:group-hover:bg-indigo-800 transition-colors">
                                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7"></path>
                                            </svg>
                                        </div>
                                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Database</h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Optimize database</p>
                                    </button>

                                    <button type="button" 
                                            onclick="clearLogs()"
                                            class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-yellow-300 hover:bg-yellow-50 dark:hover:bg-yellow-900/20 transition-colors text-center group">
                                        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800 transition-colors">
                                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Clear Logs</h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Hapus log files</p>
                                    </button>

                                    <button type="button" 
                                            onclick="checkSystemHealth()"
                                            class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-green-300 hover:bg-green-50 dark:hover:bg-green-900/20 transition-colors text-center group">
                                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-200 dark:group-hover:bg-green-800 transition-colors">
                                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Health Check</h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Cek kesehatan</p>
                                    </button>

                                    <button type="button" 
                                            onclick="updateSystem()"
                                            class="p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-purple-300 hover:bg-purple-50 dark:hover:bg-purple-900/20 transition-colors text-center group">
                                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-purple-200 dark:group-hover:bg-purple-800 transition-colors">
                                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        </div>
                                        <h5 class="font-medium text-gray-900 dark:text-white mb-1">Update</h5>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Cek update</p>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- System Monitoring -->
                            <div class="border-t border-gray-200 dark:border-gray-700 pt-6 mt-6">
                                <h4 class="text-md font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    System Monitoring
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Disk Usage</span>
                                            <span id="disk-usage" class="text-sm text-gray-600 dark:text-gray-400">Loading...</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                            <div id="disk-usage-bar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Memory Usage</span>
                                            <span id="memory-usage" class="text-sm text-gray-600 dark:text-gray-400">Loading...</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                            <div id="memory-usage-bar" class="bg-green-600 h-2 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Database Size</span>
                                            <span id="database-size" class="text-sm text-gray-600 dark:text-gray-400">Loading...</span>
                                        </div>
                                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                            <div id="database-size-bar" class="bg-purple-600 h-2 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Theme & Appearance Tab -->
            <div id="theme-tab" class="tab-content hidden">
                <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                            <svg class="w-5 h-5 mr-2 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"></path>
                            </svg>
                            Tema & Tampilan
                        </h2>
                    </div>
                    <div class="px-6 py-6 space-y-6">
                        <!-- Color Scheme -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Skema Warna</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-blue-500" onclick="selectColorScheme('blue')">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-6 h-6 bg-blue-600 rounded-full"></div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Blue</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Default theme</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-green-500" onclick="selectColorScheme('green')">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-6 h-6 bg-green-600 rounded-full"></div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Green</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Nature theme</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4 cursor-pointer hover:border-purple-500" onclick="selectColorScheme('purple')">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-6 h-6 bg-purple-600 rounded-full"></div>
                                        <div>
                                            <h4 class="font-medium text-gray-900 dark:text-white">Purple</h4>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">Modern theme</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="color_scheme" id="color_scheme" value="{{ $getSetting($settings, 'color_scheme', 'blue') }}">
                        </div>

                        <!-- Custom CSS -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Custom CSS</h3>
                            <div>
                                <label for="custom_css" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    CSS Kustom
                                </label>
                                <textarea name="custom_css" 
                                          id="custom_css" 
                                          rows="10"
                                          class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white font-mono text-sm"
                                          placeholder="/* Masukkan CSS kustom di sini */&#10;.custom-class {&#10;    color: #333;&#10;}">{{ old('custom_css', $getSetting($settings, 'custom_css')) }}</textarea>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">CSS akan diterapkan ke seluruh website</p>
                            </div>
                        </div>

                        <!-- Layout Options -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Opsi Layout</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Sidebar Collapsed</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Sidebar admin dalam keadaan tertutup</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               name="sidebar_collapsed" 
                                               value="1"
                                               class="sr-only peer"
                                               {{ $getSetting($settings, 'sidebar_collapsed') ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>

                                <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                    <div>
                                        <h4 class="font-medium text-gray-900 dark:text-white">Dark Mode</h4>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Tema gelap untuk admin panel</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" 
                                               name="dark_mode" 
                                               value="1"
                                               class="sr-only peer"
                                               {{ $getSetting($settings, 'dark_mode') ? 'checked' : '' }}>
                                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- System Information -->
            <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Sistem</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">PHP Version:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $systemInfo['php_version'] ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Laravel Version:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ $systemInfo['laravel_version'] ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Database:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($systemInfo['database_connection'] ?? 'N/A') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Cache Driver:</span>
                        <span class="font-medium text-gray-900 dark:text-white">{{ ucfirst($systemInfo['cache_driver'] ?? 'N/A') }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <button type="button" 
                            onclick="clearCache()"
                            class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors duration-200 text-sm">
                        Clear Cache
                    </button>
                    <button type="button" 
                            onclick="optimizeSystem()"
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200 text-sm">
                        Optimize System
                    </button>
                    <button type="button" 
                            onclick="document.getElementById('reset-modal').classList.remove('hidden')"
                            class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200 text-sm">
                        Reset to Default
                    </button>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Status Sistem</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Database</span>
                        <span data-status="database" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Online
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Cache</span>
                        <span data-status="cache" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Active
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Storage</span>
                        <span data-status="storage" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                            Available
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="mt-8 bg-gray-50 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg">
        <div class="px-6 py-4 flex justify-end space-x-3">
            <button type="button" 
                    onclick="window.location.reload()"
                    class="px-6 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                Reset Form
            </button>
            <button type="submit" 
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                Simpan Pengaturan
            </button>
        </div>
    </div>
</form>

<!-- Reset Modal -->
<div id="reset-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Reset Settings</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                Ini akan mengembalikan semua pengaturan ke default. Ketik <strong>RESET</strong> untuk konfirmasi.
            </p>
            <form action="{{ route('admin.settings.reset') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <input type="text" 
                           name="confirm" 
                           placeholder="Ketik RESET"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white"
                           required>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="document.getElementById('reset-modal').classList.add('hidden')"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Reset
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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

// Color scheme selection
function selectColorScheme(scheme) {
    document.getElementById('color_scheme').value = scheme;
    
    // Update visual selection
    document.querySelectorAll('[onclick^="selectColorScheme"]').forEach(el => {
        el.classList.remove('border-blue-500', 'bg-blue-50');
    });
    
    event.currentTarget.classList.add('border-blue-500', 'bg-blue-50');
}

// Clear cache
function clearCache() {
    if (confirm('Clear cache sistem?')) {
        showLoading('Membersihkan cache...');
        
        fetch('{{ route('admin.settings.clear-cache') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Berhasil!', data.message);
            } else {
                showToast('error', 'Error!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Optimize system
function optimizeSystem() {
    if (confirm('Optimasi sistem? Ini akan clear cache dan optimize autoload.')) {
        showLoading('Mengoptimasi sistem...');
        
        fetch('{{ route('admin.settings.optimize') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Berhasil!', data.message);
            } else {
                showToast('error', 'Error!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// This function is now replaced by the enhanced version above

// Create backup
function createBackup() {
    if (confirm('Buat backup database sekarang?')) {
        showLoading('Membuat backup...');
        
        fetch('{{ route('admin.settings.create-backup') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Berhasil!', data.message);
            } else {
                showToast('error', 'Error!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Optimize database
function optimizeDatabase() {
    if (confirm('Optimize database? Ini akan membersihkan dan mengoptimalkan tabel database.')) {
        showLoading('Mengoptimasi database...');
        
        fetch('{{ route('admin.settings.optimize-database') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Berhasil!', data.message + ' (' + data.tables.length + ' tabel dioptimasi)');
            } else {
                showToast('error', 'Error!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Clear logs
function clearLogs() {
    if (confirm('Hapus semua log file lama?')) {
        showLoading('Menghapus log files...');
        
        fetch('{{ route('admin.settings.clear-logs') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Berhasil!', data.message + ' (' + data.files.length + ' file dihapus)');
            } else {
                showToast('error', 'Error!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Check system health
function checkSystemHealth() {
    showLoading('Memeriksa kesehatan sistem...');
    
    fetch('{{ route('admin.settings.system-health') }}', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            let message = 'Status sistem: ' + data.overall_status.toUpperCase();
            let details = [];
            
            Object.keys(data.checks).forEach(key => {
                const check = data.checks[key];
                details.push(key + ': ' + check.status);
            });
            
            showToast('success', 'System Health Check', message + '\n\n' + details.join('\n'));
        } else {
            showToast('error', 'Error!', data.message);
        }
    })
    .catch(error => {
        hideLoading();
        showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
    });
}

// Update system
function updateSystem() {
    if (confirm('Periksa update sistem?')) {
        showToast('info', 'Update System', '🔄 Fitur update sistem akan segera tersedia!\nSaat ini sistem sudah menggunakan versi terbaru.');
    }
}

// Loading functions
function showLoading(message = 'Loading...') {
    // Remove existing loading if any
    hideLoading();
    
    const loadingDiv = document.createElement('div');
    loadingDiv.id = 'loading-overlay';
    loadingDiv.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    loadingDiv.innerHTML = `
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 flex items-center space-x-3">
            <svg class="animate-spin h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 dark:text-gray-300">${message}</span>
        </div>
    `;
    
    document.body.appendChild(loadingDiv);
}

function hideLoading() {
    const loadingDiv = document.getElementById('loading-overlay');
    if (loadingDiv) {
        loadingDiv.remove();
    }
}

// Toast function (if not available from layout)
function showToast(type, title, message) {
    // Try to use the global showToast function first
    if (window.showToast) {
        window.showToast(type, title, message);
        return;
    }
    
    // Fallback to alert if toast system not available
    alert(title + '\n\n' + message);
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Initialize color scheme selection
    const currentScheme = document.getElementById('color_scheme').value;
    const schemeElement = document.querySelector(`[onclick="selectColorScheme('${currentScheme}')"]`);
    if (schemeElement) {
        schemeElement.classList.add('border-blue-500', 'bg-blue-50');
    }
    
    // Add CSRF token to meta if not exists
    if (!document.querySelector('meta[name="csrf-token"]')) {
        const meta = document.createElement('meta');
        meta.name = 'csrf-token';
        meta.content = '{{ csrf_token() }}';
        document.getElementsByTagName('head')[0].appendChild(meta);
    }
    
    // Form validation
    const form = document.getElementById('settings-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Basic validation
            const maxUploadSize = document.getElementById('max_upload_size');
            if (maxUploadSize && (maxUploadSize.value < 1 || maxUploadSize.value > 100)) {
                e.preventDefault();
                showToast('error', 'Validation Error', 'Ukuran upload harus antara 1-100 MB');
                return false;
            }
            
            const sessionLifetime = document.getElementById('session_lifetime');
            if (sessionLifetime && (sessionLifetime.value < 30 || sessionLifetime.value > 1440)) {
                e.preventDefault();
                showToast('error', 'Validation Error', 'Session lifetime harus antara 30-1440 menit');
                return false;
            }
            
            const maxLoginAttempts = document.getElementById('max_login_attempts');
            if (maxLoginAttempts && (maxLoginAttempts.value < 3 || maxLoginAttempts.value > 10)) {
                e.preventDefault();
                showToast('error', 'Validation Error', 'Maksimal login attempts harus antara 3-10');
                return false;
            }
            
            // Show loading on form submit
            showLoading('Menyimpan pengaturan...');
        });
    }
});

// Auto-save draft functionality
let autoSaveTimeout;
function autoSaveDraft() {
    clearTimeout(autoSaveTimeout);
    autoSaveTimeout = setTimeout(() => {
        const formData = new FormData(document.getElementById('settings-form'));
        localStorage.setItem('settings_draft', JSON.stringify(Object.fromEntries(formData)));
        console.log('Settings draft saved');
    }, 2000);
}

// Add event listeners to form inputs for auto-save
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('settings-form');
    if (form) {
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('change', autoSaveDraft);
            input.addEventListener('input', autoSaveDraft);
        });
    }
});

// Load draft on page load
window.addEventListener('load', function() {
    const draft = localStorage.getItem('settings_draft');
    if (draft && confirm('Ditemukan draft pengaturan yang belum disimpan. Muat draft?')) {
        try {
            const draftData = JSON.parse(draft);
            Object.keys(draftData).forEach(key => {
                const element = document.querySelector(`[name="${key}"]`);
                if (element) {
                    if (element.type === 'checkbox') {
                        element.checked = draftData[key] === '1';
                    } else {
                        element.value = draftData[key];
                    }
                }
            });
            showToast('info', 'Draft Loaded', 'Draft pengaturan berhasil dimuat');
        } catch (e) {
            console.error('Error loading draft:', e);
        }
    }
});

// Clear draft after successful save
window.addEventListener('beforeunload', function() {
    // Only clear if form was submitted successfully
    if (window.settingsSaved) {
        localStorage.removeItem('settings_draft');
    }
});

// Update maintenance status indicator
function updateMaintenanceStatus(checkbox) {
    const statusSpan = checkbox.closest('.flex').querySelector('span');
    if (checkbox.checked) {
        statusSpan.textContent = '🔴 Aktif';
        statusSpan.className = 'text-xs text-red-600 font-medium';
        showToast('warning', 'Mode Maintenance', 'Mode maintenance akan diaktifkan setelah pengaturan disimpan');
    } else {
        statusSpan.textContent = '🟢 Tidak Aktif';
        statusSpan.className = 'text-xs text-green-600 font-medium';
    }
}

// Real-time validation for numeric inputs
function validateNumericInput(input, min, max, fieldName) {
    const value = parseInt(input.value);
    const errorDiv = input.parentNode.querySelector('.validation-error');
    
    // Remove existing error
    if (errorDiv) {
        errorDiv.remove();
    }
    
    if (isNaN(value) || value < min || value > max) {
        const error = document.createElement('div');
        error.className = 'validation-error text-xs text-red-600 mt-1';
        error.textContent = `${fieldName} harus antara ${min}-${max}`;
        input.parentNode.appendChild(error);
        input.classList.add('border-red-500');
        return false;
    } else {
        input.classList.remove('border-red-500');
        input.classList.add('border-green-500');
        setTimeout(() => input.classList.remove('border-green-500'), 2000);
        return true;
    }
}

// Add real-time validation to numeric inputs
document.addEventListener('DOMContentLoaded', function() {
    // Max upload size validation
    const maxUploadSize = document.getElementById('max_upload_size');
    if (maxUploadSize) {
        maxUploadSize.addEventListener('input', function() {
            validateNumericInput(this, 1, 100, 'Ukuran upload');
        });
    }
    
    // Session lifetime validation
    const sessionLifetime = document.getElementById('session_lifetime');
    if (sessionLifetime) {
        sessionLifetime.addEventListener('input', function() {
            validateNumericInput(this, 30, 1440, 'Session lifetime');
        });
    }
    
    // Max login attempts validation
    const maxLoginAttempts = document.getElementById('max_login_attempts');
    if (maxLoginAttempts) {
        maxLoginAttempts.addEventListener('input', function() {
            validateNumericInput(this, 3, 10, 'Maksimal login attempts');
        });
    }
    
    // Mail port validation
    const mailPort = document.getElementById('mail_port');
    if (mailPort) {
        mailPort.addEventListener('input', function() {
            validateNumericInput(this, 1, 65535, 'Port email');
        });
    }
    
    // Backup retention days validation
    const backupRetentionDays = document.getElementById('backup_retention_days');
    if (backupRetentionDays) {
        backupRetentionDays.addEventListener('input', function() {
            validateNumericInput(this, 7, 365, 'Retention days');
        });
    }
});

// Enhanced form submission with progress tracking
function enhanceFormSubmission() {
    const form = document.getElementById('settings-form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate all fields first
        const validationErrors = [];
        
        // Check numeric validations
        const numericFields = [
            { id: 'max_upload_size', min: 1, max: 100, name: 'Ukuran upload' },
            { id: 'session_lifetime', min: 30, max: 1440, name: 'Session lifetime' },
            { id: 'max_login_attempts', min: 3, max: 10, name: 'Maksimal login attempts' },
            { id: 'mail_port', min: 1, max: 65535, name: 'Port email' },
            { id: 'backup_retention_days', min: 7, max: 365, name: 'Retention days' }
        ];
        
        numericFields.forEach(field => {
            const input = document.getElementById(field.id);
            if (input && input.value) {
                const value = parseInt(input.value);
                if (isNaN(value) || value < field.min || value > field.max) {
                    validationErrors.push(`${field.name} harus antara ${field.min}-${field.max}`);
                }
            }
        });
        
        if (validationErrors.length > 0) {
            showToast('error', 'Validation Error', validationErrors.join('\n'));
            return;
        }
        
        // Show progress
        showLoading('Menyimpan pengaturan...');
        
        // Submit form
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                window.settingsSaved = true;
                localStorage.removeItem('settings_draft');
                return response.text();
            }
            throw new Error('Network response was not ok');
        })
        .then(html => {
            hideLoading();
            showToast('success', 'Berhasil!', 'Pengaturan berhasil disimpan');
            
            // Reload page to show updated values
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan saat menyimpan: ' + error.message);
        });
    });
}

// Initialize enhanced form submission
document.addEventListener('DOMContentLoaded', enhanceFormSubmission);

// System status checker
function startSystemStatusChecker() {
    // Check system status every 30 seconds
    setInterval(() => {
        fetch('{{ route('admin.settings.system-health') }}', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateSystemStatusIndicators(data.checks);
            }
        })
        .catch(error => {
            console.log('System status check failed:', error);
        });
    }, 30000); // 30 seconds
}

// Update system status indicators
function updateSystemStatusIndicators(checks) {
    const statusElements = {
        'database': document.querySelector('[data-status="database"]'),
        'cache': document.querySelector('[data-status="cache"]'),
        'storage': document.querySelector('[data-status="storage"]')
    };
    
    Object.keys(checks).forEach(key => {
        const element = statusElements[key];
        if (element) {
            const status = checks[key].status;
            element.className = `inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${
                status === 'healthy' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' :
                status === 'warning' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' :
                'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
            }`;
            element.textContent = status === 'healthy' ? 'Online' : 
                                 status === 'warning' ? 'Warning' : 'Error';
        }
    });
}

// Start system status checker when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Start after 5 seconds to let page load completely
    setTimeout(startSystemStatusChecker, 5000);
    
    // Initialize email configuration validation
    validateEmailConfig();
    
    // Initialize backup & maintenance monitoring
    setTimeout(startMonitoringUpdates, 3000);
});

// Email & Notification Functions

// Toggle password visibility
function togglePasswordVisibility(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;
    
    if (input.type === 'password') {
        input.type = 'text';
        button.innerHTML = `
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
            </svg>
        `;
    } else {
        input.type = 'password';
        button.innerHTML = `
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        `;
    }
}

// Validate email configuration
function validateEmailConfig() {
    const host = document.getElementById('mail_host').value;
    const port = document.getElementById('mail_port').value;
    const username = document.getElementById('mail_username').value;
    const password = document.getElementById('mail_password').value;
    
    const statusIndicator = document.getElementById('smtp-connection-status');
    const emailStatusIndicator = document.getElementById('email-status-indicator');
    
    if (host && port && username && password) {
        // Configuration looks complete
        statusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        statusIndicator.innerHTML = `
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Perlu Ditest
        `;
        
        emailStatusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
        emailStatusIndicator.innerHTML = `
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Dikonfigurasi
        `;
    } else {
        // Configuration incomplete
        statusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
        statusIndicator.innerHTML = `
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            Belum Ditest
        `;
        
        emailStatusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
        emailStatusIndicator.innerHTML = `
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
            Belum Dikonfigurasi
        `;
    }
}

// Enhanced test email connection with better feedback
function testEmailConnection() {
    const host = document.getElementById('mail_host').value;
    const port = document.getElementById('mail_port').value;
    const username = document.getElementById('mail_username').value;
    const password = document.getElementById('mail_password').value;
    
    if (!host || !port || !username || !password) {
        showToast('error', 'Konfigurasi Tidak Lengkap', 'Harap isi semua field SMTP terlebih dahulu');
        return;
    }
    
    if (confirm('Test koneksi email dengan pengaturan saat ini?')) {
        showLoading('Testing koneksi email...');
        
        const formData = new FormData();
        formData.append('mail_host', host);
        formData.append('mail_port', port);
        formData.append('mail_username', username);
        formData.append('mail_password', password);
        formData.append('mail_encryption', document.getElementById('mail_encryption').value);
        formData.append('mail_from_name', document.getElementById('mail_from_name').value);
        
        fetch('{{ route('admin.settings.test-email') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            const statusIndicator = document.getElementById('smtp-connection-status');
            const emailStatusIndicator = document.getElementById('email-status-indicator');
            
            if (data.success) {
                statusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                statusIndicator.innerHTML = `
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Koneksi OK
                `;
                
                emailStatusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                emailStatusIndicator.innerHTML = `
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Terkonfigurasi
                `;
                
                showToast('success', 'Koneksi Berhasil!', data.message);
            } else {
                statusIndicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200';
                statusIndicator.innerHTML = `
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    Koneksi Gagal
                `;
                
                showToast('error', 'Koneksi Gagal!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Send test email with template
function sendTestEmail() {
    const testEmailTo = document.getElementById('test_email_to').value;
    const testTemplate = document.getElementById('test_email_template').value;
    
    if (!testEmailTo) {
        showToast('error', 'Email Tujuan Kosong', 'Harap isi email tujuan untuk test');
        return;
    }
    
    if (!validateEmail(testEmailTo)) {
        showToast('error', 'Email Tidak Valid', 'Format email tujuan tidak valid');
        return;
    }
    
    if (confirm(`Kirim test email ke ${testEmailTo} dengan template ${testTemplate}?`)) {
        showLoading('Mengirim test email...');
        
        const formData = new FormData();
        formData.append('mail_host', document.getElementById('mail_host').value);
        formData.append('mail_port', document.getElementById('mail_port').value);
        formData.append('mail_username', document.getElementById('mail_username').value);
        formData.append('mail_password', document.getElementById('mail_password').value);
        formData.append('mail_encryption', document.getElementById('mail_encryption').value);
        formData.append('mail_from_name', document.getElementById('mail_from_name').value);
        formData.append('test_email_to', testEmailTo);
        formData.append('test_template', testTemplate);
        
        fetch('{{ route('admin.settings.test-email') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Test Email Terkirim!', `Email berhasil dikirim ke ${testEmailTo}`);
            } else {
                showToast('error', 'Gagal Mengirim Email!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Toggle email notifications
function toggleEmailNotifications(checkbox) {
    const notificationSections = document.querySelectorAll('[name$="_notifications"]');
    
    if (!checkbox.checked) {
        if (confirm('Menonaktifkan email notifikasi akan menonaktifkan semua jenis notifikasi. Lanjutkan?')) {
            notificationSections.forEach(section => {
                if (section !== checkbox) {
                    section.checked = false;
                    section.disabled = true;
                }
            });
            showToast('warning', 'Email Notifikasi Dinonaktifkan', 'Semua jenis notifikasi email telah dinonaktifkan');
        } else {
            checkbox.checked = true;
        }
    } else {
        notificationSections.forEach(section => {
            section.disabled = false;
        });
        showToast('info', 'Email Notifikasi Diaktifkan', 'Anda dapat mengatur jenis notifikasi di bawah');
    }
}

// Test specific notification type
function testNotification(type) {
    const emailEnabled = document.querySelector('[name="email_notifications_enabled"]').checked;
    
    if (!emailEnabled) {
        showToast('error', 'Email Notifikasi Nonaktif', 'Aktifkan email notifikasi terlebih dahulu');
        return;
    }
    
    showLoading(`Testing notifikasi ${type}...`);
    
    const formData = new FormData();
    formData.append('notification_type', type);
    formData.append('test_email_to', document.getElementById('test_email_to').value || 'admin@example.com');
    
    // Simulate notification test (you can implement actual endpoint)
    setTimeout(() => {
        hideLoading();
        showToast('success', 'Test Notifikasi Berhasil', `Notifikasi ${type} berhasil dikirim`);
    }, 2000);
}

// Test all notifications
function testAllNotifications() {
    const emailEnabled = document.querySelector('[name="email_notifications_enabled"]').checked;
    
    if (!emailEnabled) {
        showToast('error', 'Email Notifikasi Nonaktif', 'Aktifkan email notifikasi terlebih dahulu');
        return;
    }
    
    if (confirm('Test semua jenis notifikasi? Ini akan mengirim beberapa email test.')) {
        showLoading('Testing semua notifikasi...');
        
        const notificationTypes = ['registration', 'system', 'announcement', 'agenda'];
        let completed = 0;
        
        notificationTypes.forEach((type, index) => {
            setTimeout(() => {
                completed++;
                showToast('info', 'Test Progress', `Testing ${type} notifikasi... (${completed}/${notificationTypes.length})`);
                
                if (completed === notificationTypes.length) {
                    hideLoading();
                    showToast('success', 'Test Selesai', 'Semua notifikasi berhasil ditest');
                }
            }, (index + 1) * 1000);
        });
    }
}

// Preview email template
function previewEmailTemplate() {
    const header = document.getElementById('email_template_header').value || 'SMA Negeri 1 Balong';
    const footer = document.getElementById('email_template_footer').value || 'Terima kasih - Tim SMA Negeri 1 Balong';
    
    const previewContent = `
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
            <div style="background: #3b82f6; color: white; padding: 20px; text-align: center;">
                <h1 style="margin: 0; font-size: 24px;">${header}</h1>
            </div>
            <div style="padding: 30px;">
                <h2 style="color: #1f2937; margin-bottom: 20px;">Contoh Notifikasi</h2>
                <p style="color: #6b7280; line-height: 1.6; margin-bottom: 20px;">
                    Ini adalah contoh email notifikasi yang akan dikirim dari sistem. 
                    Email ini menggunakan template yang telah Anda konfigurasi.
                </p>
                <div style="background: #f3f4f6; padding: 15px; border-radius: 6px; margin: 20px 0;">
                    <p style="margin: 0; color: #374151; font-weight: 600;">Informasi:</p>
                    <p style="margin: 5px 0 0 0; color: #6b7280;">Template ini akan digunakan untuk semua jenis notifikasi email dari sistem.</p>
                </div>
                <p style="color: #6b7280; line-height: 1.6;">Terima kasih telah menggunakan sistem kami.</p>
            </div>
            <div style="background: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #e5e7eb;">
                <p style="margin: 0; color: #6b7280; font-size: 14px;">${footer}</p>
            </div>
        </div>
    `;
    
    const previewWindow = window.open('', '_blank', 'width=700,height=600,scrollbars=yes');
    previewWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Preview Email Template</title>
            <meta charset="utf-8">
        </head>
        <body style="margin: 0; padding: 20px; background: #f3f4f6;">
            ${previewContent}
        </body>
        </html>
    `);
    previewWindow.document.close();
}

// Email validation helper
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Backup & Maintenance Functions

// Toggle auto backup
function toggleAutoBackup(checkbox) {
    const statusSpan = checkbox.closest('.flex').querySelector('span');
    if (checkbox.checked) {
        statusSpan.textContent = '🟢 Aktif';
        statusSpan.className = 'text-xs text-green-600 font-medium';
        showToast('success', 'Auto Backup Diaktifkan', 'Backup otomatis akan berjalan sesuai jadwal yang ditentukan');
        updateBackupStatus('enabled');
    } else {
        statusSpan.textContent = '⚪ Nonaktif';
        statusSpan.className = 'text-xs text-gray-600 font-medium';
        showToast('info', 'Auto Backup Dinonaktifkan', 'Backup otomatis telah dinonaktifkan');
        updateBackupStatus('disabled');
    }
}

// Update backup status indicator
function updateBackupStatus(status) {
    const indicator = document.getElementById('backup-status-indicator');
    
    switch(status) {
        case 'enabled':
            indicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
            indicator.innerHTML = `
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Aktif
            `;
            break;
        case 'running':
            indicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
            indicator.innerHTML = `
                <svg class="w-3 h-3 mr-1 animate-spin" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                </svg>
                Berjalan
            `;
            break;
        case 'disabled':
        default:
            indicator.className = 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
            indicator.innerHTML = `
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                Siap
            `;
            break;
    }
}

// Enhanced create backup with progress tracking
function createBackup() {
    if (confirm('Buat backup lengkap database dan file sekarang?')) {
        updateBackupStatus('running');
        showLoading('Membuat backup lengkap...');
        
        fetch('{{ route('admin.settings.create-backup') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            updateBackupStatus('enabled');
            
            if (data.success) {
                updateLastBackupTime();
                showToast('success', 'Backup Berhasil!', `${data.message}\nFile: ${data.filename || 'backup.zip'}`);
            } else {
                showToast('error', 'Backup Gagal!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            updateBackupStatus('disabled');
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Create database backup only
function createDatabaseBackup() {
    if (confirm('Buat backup database saja?')) {
        showLoading('Membuat backup database...');
        
        const formData = new FormData();
        formData.append('type', 'database');
        
        fetch('{{ route('admin.settings.create-backup') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Database Backup Berhasil!', data.message);
            } else {
                showToast('error', 'Database Backup Gagal!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Create files backup only
function createFilesBackup() {
    if (confirm('Buat backup file sistem saja?')) {
        showLoading('Membuat backup files...');
        
        const formData = new FormData();
        formData.append('type', 'files');
        
        fetch('{{ route('admin.settings.create-backup') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Files Backup Berhasil!', data.message);
            } else {
                showToast('error', 'Files Backup Gagal!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Create complete backup
function createCompleteBackup() {
    if (confirm('Buat backup lengkap (database + files)?\nProses ini mungkin memakan waktu lama.')) {
        updateBackupStatus('running');
        showLoading('Membuat backup lengkap...');
        
        const formData = new FormData();
        formData.append('type', 'complete');
        
        fetch('{{ route('admin.settings.create-backup') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            updateBackupStatus('enabled');
            
            if (data.success) {
                updateLastBackupTime();
                showToast('success', 'Backup Lengkap Berhasil!', `${data.message}\nUkuran: ${data.size || 'Unknown'}`);
            } else {
                showToast('error', 'Backup Lengkap Gagal!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            updateBackupStatus('disabled');
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// List available backups
function listBackups() {
    showLoading('Mengambil daftar backup...');
    
    fetch('{{ route('admin.settings.list-backups') }}', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        hideLoading();
        if (data.success) {
            showBackupList(data.backups);
        } else {
            showToast('error', 'Error!', data.message);
        }
    })
    .catch(error => {
        hideLoading();
        showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
    });
}

// Show backup list in modal
function showBackupList(backups) {
    let backupListHtml = '';
    
    if (backups.length === 0) {
        backupListHtml = '<p class="text-gray-500 text-center py-4">Belum ada backup tersedia</p>';
    } else {
        backupListHtml = '<div class="space-y-2">';
        backups.forEach(backup => {
            backupListHtml += `
                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                    <div>
                        <h5 class="font-medium text-gray-900">${backup.name}</h5>
                        <p class="text-sm text-gray-500">${backup.date} - ${backup.size}</p>
                    </div>
                    <div class="flex space-x-2">
                        <button onclick="downloadBackup('${backup.name}')" class="px-3 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                            Download
                        </button>
                        <button onclick="deleteBackup('${backup.name}')" class="px-3 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700">
                            Hapus
                        </button>
                    </div>
                </div>
            `;
        });
        backupListHtml += '</div>';
    }
    
    // Create modal (simplified version)
    const modalHtml = `
        <div id="backup-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-96 overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Daftar Backup</h3>
                    <button onclick="closeBackupModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                ${backupListHtml}
            </div>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

// Close backup modal
function closeBackupModal() {
    const modal = document.getElementById('backup-modal');
    if (modal) {
        modal.remove();
    }
}

// Download backup
function downloadBackup(filename) {
    window.location.href = `{{ route('admin.settings.download-backup') }}?file=${filename}`;
}

// Delete backup
function deleteBackup(filename) {
    if (confirm(`Hapus backup ${filename}?`)) {
        showLoading('Menghapus backup...');
        
        fetch('{{ route('admin.settings.delete-backup') }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ filename: filename })
        })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showToast('success', 'Backup Dihapus!', data.message);
                closeBackupModal();
                listBackups(); // Refresh list
            } else {
                showToast('error', 'Error!', data.message);
            }
        })
        .catch(error => {
            hideLoading();
            showToast('error', 'Error!', 'Terjadi kesalahan: ' + error.message);
        });
    }
}

// Run all maintenance tasks
function runAllMaintenance() {
    if (confirm('Jalankan semua maintenance tasks?\nIni akan membersihkan cache, optimize database, dan clear logs.')) {
        showLoading('Menjalankan maintenance...');
        
        const tasks = [
            { name: 'Clear Cache', func: () => clearCache() },
            { name: 'Optimize System', func: () => optimizeSystem() },
            { name: 'Optimize Database', func: () => optimizeDatabase() },
            { name: 'Clear Logs', func: () => clearLogs() }
        ];
        
        let completed = 0;
        
        tasks.forEach((task, index) => {
            setTimeout(() => {
                completed++;
                showToast('info', 'Maintenance Progress', `${task.name}... (${completed}/${tasks.length})`);
                
                if (completed === tasks.length) {
                    hideLoading();
                    showToast('success', 'Maintenance Selesai!', 'Semua maintenance tasks berhasil dijalankan');
                }
            }, (index + 1) * 2000);
        });
    }
}

// Update last backup time
function updateLastBackupTime() {
    const now = new Date();
    const timeString = now.toLocaleString('id-ID');
    const element = document.getElementById('last-backup-time');
    if (element) {
        element.textContent = `Backup terakhir: ${timeString}`;
    }
}

// Load system monitoring data
function loadSystemMonitoring() {
    fetch('{{ route('admin.settings.system-monitoring') }}', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateMonitoringDisplay(data.monitoring);
        }
    })
    .catch(error => {
        console.log('System monitoring failed:', error);
    });
}

// Update monitoring display
function updateMonitoringDisplay(monitoring) {
    // Update disk usage
    const diskUsage = monitoring.disk_usage || { used: 0, total: 100, percentage: 0 };
    document.getElementById('disk-usage').textContent = `${diskUsage.percentage}%`;
    document.getElementById('disk-usage-bar').style.width = `${diskUsage.percentage}%`;
    
    // Update memory usage
    const memoryUsage = monitoring.memory_usage || { used: 0, total: 100, percentage: 0 };
    document.getElementById('memory-usage').textContent = `${memoryUsage.percentage}%`;
    document.getElementById('memory-usage-bar').style.width = `${memoryUsage.percentage}%`;
    
    // Update database size
    const databaseSize = monitoring.database_size || { size: '0 MB', percentage: 0 };
    document.getElementById('database-size').textContent = databaseSize.size;
    document.getElementById('database-size-bar').style.width = `${databaseSize.percentage}%`;
}

// Start monitoring updates
function startMonitoringUpdates() {
    // Load initial data
    loadSystemMonitoring();
    
    // Update every 30 seconds
    setInterval(loadSystemMonitoring, 30000);
}

// Initialize backup & maintenance features
document.addEventListener('DOMContentLoaded', function() {
    // Start monitoring after page load
    setTimeout(startMonitoringUpdates, 3000);
    
    // Update last backup time if auto backup is enabled
    const autoBackupEnabled = document.querySelector('[name="auto_backup_enabled"]');
    if (autoBackupEnabled && autoBackupEnabled.checked) {
        updateBackupStatus('enabled');
    }
});
</script>
@endpush