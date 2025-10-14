@extends('layouts.guru-piket')

@section('title', 'Profil Saya')

@push('styles')
<style>
    .profile-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
    }
    
    .dark .profile-card {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .profile-header {
        background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
        border-radius: 1rem 1rem 0 0;
        padding: 2rem;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    
    .dark .profile-header {
        background: linear-gradient(135deg, #f9fafb 0%, #e5e7eb 100%);
    }
    
    .profile-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 4px solid white;
        margin: 0 auto 1rem;
        position: relative;
        z-index: 2;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }
    
    .dark .profile-avatar {
        border-color: #1f2937;
    }
    
    .profile-name {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 2;
    }
    
    .dark .profile-name {
        color: #1f2937;
    }
    
    .profile-role {
        color: rgba(255, 255, 255, 0.8);
        font-size: 1rem;
        position: relative;
        z-index: 2;
    }
    
    .dark .profile-role {
        color: #6b7280;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }
    
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }
    
    .dark .form-label {
        color: #d1d5db;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: white;
        color: #374151;
        transition: all 0.3s ease;
    }
    
    .dark .form-input {
        background: #374151;
        border-color: #4b5563;
        color: #f9fafb;
    }
    
    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .dark .stat-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }
    
    .activity-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .dark .activity-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .activity-item:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
    }
    
    .dark .activity-item:hover {
        background: #4b5563;
    }
    
    .tab-button {
        padding: 0.75rem 1.5rem;
        border: none;
        background: transparent;
        color: #6b7280;
        font-weight: 500;
        border-bottom: 2px solid transparent;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .tab-button.active {
        color: #1f2937;
        border-bottom-color: #1f2937;
    }
    
    .dark .tab-button.active {
        color: #f9fafb;
        border-bottom-color: #f9fafb;
    }
    
    .tab-content {
        display: none;
        padding: 2rem 0;
    }
    
    .tab-content.active {
        display: block;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Profile Header -->
    <div class="profile-card">
        <div class="profile-header">
            <img class="profile-avatar" 
                 src="{{ auth()->user()->avatar_url }}" 
                 alt="{{ auth()->user()->name }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=f59e0b&background=fef3c7&size=120'">
            <h1 class="profile-name">{{ auth()->user()->name }}</h1>
            <p class="profile-role">Guru Piket • SMA Negeri 1</p>
        </div>
        
        <!-- Stats -->
        <div class="p-6">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-icon bg-gray-800 dark:bg-white">
                        <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">156</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Hari Bertugas</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon bg-green-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">2,847</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Siswa Dipantau</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon bg-blue-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5"></path>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">1,234</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">QR Code Discan</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-icon bg-purple-500">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">89</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Laporan Dibuat</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Tabs -->
    <div class="profile-card">
        <div class="border-b border-gray-200 dark:border-gray-700">
            <nav class="flex space-x-8 px-6">
                <button class="tab-button active" data-tab="personal">Informasi Personal</button>
                <button class="tab-button" data-tab="security">Keamanan</button>
                <button class="tab-button" data-tab="activity">Aktivitas Terakhir</button>
            </nav>
        </div>

        <!-- Personal Information Tab -->
        <div class="tab-content active" id="personal">
            <div class="px-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Informasi Personal</h2>
                
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-input" value="{{ auth()->user()->name }}" placeholder="Masukkan nama lengkap">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" value="{{ auth()->user()->email }}" placeholder="Masukkan email">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">NIP</label>
                            <input type="text" class="form-input" value="198501012010011001" placeholder="Masukkan NIP">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" class="form-input" value="+62 812-3456-7890" placeholder="Masukkan nomor telepon">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-input" value="1985-01-01">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Jenis Kelamin</label>
                            <select class="form-input">
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-input" rows="3" placeholder="Masukkan alamat lengkap">Jl. Pendidikan No. 123, Kecamatan Sukamaju, Kota Bandung, Jawa Barat 40123</textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Bio</label>
                        <textarea class="form-input" rows="4" placeholder="Ceritakan tentang diri Anda">Guru Piket berpengalaman dengan dedikasi tinggi dalam memantau kedisiplinan siswa dan mendukung proses pembelajaran yang kondusif di SMA Negeri 1.</textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-6 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Security Tab -->
        <div class="tab-content" id="security">
            <div class="px-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Pengaturan Keamanan</h2>
                
                <div class="space-y-6">
                    <!-- Change Password -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Ubah Password</h3>
                        <form class="space-y-4">
                            <div class="form-group">
                                <label class="form-label">Password Saat Ini</label>
                                <input type="password" class="form-input" placeholder="Masukkan password saat ini">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Password Baru</label>
                                <input type="password" class="form-input" placeholder="Masukkan password baru">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" class="form-input" placeholder="Konfirmasi password baru">
                            </div>
                            
                            <button type="submit" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-6 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                                Update Password
                            </button>
                        </form>
                    </div>
                    
                    <!-- Two Factor Authentication -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Autentikasi Dua Faktor</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Tambahkan lapisan keamanan ekstra untuk akun Anda</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Login Sessions -->
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Sesi Login Aktif</h3>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-600 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Chrome di Windows</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">192.168.1.100 • Sesi saat ini</div>
                                    </div>
                                </div>
                                <span class="text-green-600 dark:text-green-400 text-sm font-medium">Aktif</span>
                            </div>
                            
                            <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-600 rounded-lg">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 dark:text-white">Safari di iPhone</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">192.168.1.105 • 2 hari yang lalu</div>
                                    </div>
                                </div>
                                <button class="text-red-600 dark:text-red-400 text-sm font-medium hover:text-red-800 dark:hover:text-red-300">
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Tab -->
        <div class="tab-content" id="activity">
            <div class="px-6">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Aktivitas Terakhir</h2>
                
                <div class="space-y-4">
                    <div class="activity-item">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Scan QR Code Siswa</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Ahmad Fauzi (XII IPA 1) berhasil diabsen</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">2 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Export Laporan Harian</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Laporan tanggal 28 November 2024 (PDF)</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">15 menit yang lalu</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Update Status Absensi</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Mengubah status Dewi Permata dari Alpha ke Izin</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">1 jam yang lalu</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Login ke Sistem</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Memulai shift piket hari ini</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">3 jam yang lalu</span>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white">Peringatan Keterlambatan</div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">5 siswa terlambat masuk kelas pagi ini</div>
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">Kemarin</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 text-center">
                    <button class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                        Lihat semua aktivitas
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tab switching
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetTab = this.getAttribute('data-tab');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            document.getElementById(targetTab).classList.add('active');
        });
    });
});
</script>
@endpush