<?php
// resources/views/layouts/student/sidebar.blade.php - Student Sidebar
?>
<style>
    /* Enhanced Sidebar Styles for Student */
    .student-sidebar-nav {
        background: linear-gradient(180deg, var(--bg-primary) 0%, var(--bg-secondary) 100%);
        border-right: 1px solid var(--border-color);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        display: flex;
        flex-direction: column;
    }
    
    .dark .student-sidebar-nav {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    }
    
    /* Glassmorphism effect */
    .student-sidebar-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 20% 20%, rgba(16, 185, 129, 0.05) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(52, 211, 153, 0.05) 0%, transparent 50%);
        z-index: 1;
        pointer-events: none;
    }
    
    .dark .student-sidebar-nav::before {
        background: 
            radial-gradient(circle at 20% 20%, rgba(52, 211, 153, 0.1) 0%, transparent 50%),
            radial-gradient(circle at 80% 80%, rgba(16, 185, 129, 0.1) 0%, transparent 50%);
    }
    
    .student-sidebar-content {
        position: relative;
        z-index: 2;
    }
    
    /* Enhanced Logo Section */
    .student-sidebar-logo {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 1.5rem 1rem;
        transition: all 0.3s ease;
    }
    
    .dark .student-sidebar-logo {
        background: rgba(0, 0, 0, 0.2);
    }
    
    .student-logo-container {
        display: flex;
        align-items: center;
        padding: 0.75rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
    }
    
    .student-logo-container::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .student-logo-container:hover::before {
        opacity: 1;
    }
    
    .student-logo-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
        background: rgba(16, 185, 129, 0.1);
    }
    
    .student-logo-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #10b981, #34d399);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }
    
    .student-logo-container:hover .student-logo-icon {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .student-logo-text {
        font-weight: 700;
        font-size: 1.2rem;
        background: linear-gradient(135deg, var(--text-primary), var(--accent-color));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        letter-spacing: 0.5px;
    }
    
    .student-logo-subtitle {
        font-size: 0.75rem;
        color: var(--text-secondary);
        font-weight: 500;
        margin-top: 2px;
    }
    
    /* Enhanced Navigation Items */
    .student-nav-section {
        padding: 1.5rem 1rem;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: var(--border-color) transparent;
    }
    
    .student-nav-section::-webkit-scrollbar {
        width: 6px;
    }
    
    .student-nav-section::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .student-nav-section::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 3px;
    }
    
    .student-sidebar-nav-item {
        color: var(--text-secondary);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        margin-bottom: 0.5rem;
        border-radius: 12px;
        font-weight: 500;
    }
    
    .student-sidebar-nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
        transition: left 0.5s ease;
    }
    
    .student-sidebar-nav-item:hover::before {
        left: 100%;
    }
    
    .student-sidebar-nav-item:hover {
        color: var(--text-primary);
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(52, 211, 153, 0.05));
        transform: translateX(5px);
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.1);
    }
    
    .student-sidebar-nav-item.active {
        color: #10b981;
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(52, 211, 153, 0.1));
        border-left: 4px solid #10b981;
        font-weight: 600;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
    }
    
    .dark .student-sidebar-nav-item.active {
        box-shadow: 0 4px 15px rgba(52, 211, 153, 0.3);
    }
    
    .student-nav-icon {
        width: 20px;
        height: 20px;
        margin-right: 12px;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    .student-sidebar-nav-item:hover .student-nav-icon {
        transform: scale(1.1);
        color: var(--accent-color);
    }
    
    /* Section Dividers */
    .student-nav-section-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, var(--border-color), transparent);
        margin: 1.5rem 0;
        position: relative;
    }
    
    .student-nav-section-divider::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        width: 6px;
        height: 6px;
        background: var(--accent-color);
        border-radius: 50%;
        opacity: 0.6;
    }
    
    .student-nav-section-title {
        color: var(--text-secondary);
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 1rem;
        padding: 0 1rem;
        position: relative;
        display: flex;
        align-items: center;
    }
    
    .student-nav-section-title::before {
        content: '';
        width: 4px;
        height: 4px;
        background: var(--accent-color);
        border-radius: 50%;
        margin-right: 8px;
    }
    
    /* Enhanced User Section */
    .student-user-section {
        padding: 1rem;
        border-top: 1px solid var(--border-color);
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }
    
    .dark .student-user-section {
        background: rgba(0, 0, 0, 0.2);
    }
    
    .student-user-card {
        display: flex;
        align-items: center;
        padding: 1rem;
        border-radius: 16px;
        background: rgba(255, 255, 255, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        text-decoration: none !important;
        color: inherit;
    }
    
    .student-user-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.1) 0%, transparent 70%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .student-user-card:hover::before {
        opacity: 1;
    }
    
    .student-user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
        background: rgba(16, 185, 129, 0.1);
        text-decoration: none !important;
        color: inherit;
    }
    
    .student-user-avatar {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        margin-right: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .student-user-card:hover .student-user-avatar {
        transform: scale(1.05);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }
    
    .student-user-info {
        flex: 1;
        min-width: 0;
    }
    
    .student-user-name {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .student-user-role {
        color: var(--text-secondary);
        font-size: 0.75rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .student-user-status {
        width: 8px;
        height: 8px;
        background: #10b981;
        border-radius: 50%;
        margin-left: 8px;
        animation: pulse 2s infinite;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.5);
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.7; transform: scale(1.1); }
    }
    
    /* Mobile Close Button */
    .student-mobile-close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 40px;
        height: 40px;
        border-radius: 10px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid var(--border-color);
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-secondary);
        z-index: 10;
        backdrop-filter: blur(10px);
    }
    
    .student-mobile-close-btn:hover {
        background: rgba(239, 68, 68, 0.1);
        color: #ef4444;
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .student-sidebar-logo {
            padding-right: 4rem; /* Space for close button */
        }
        
        .student-nav-section {
            padding-bottom: 2rem;
            max-height: calc(100vh - 200px);
            overflow-y: auto;
        }
        
        .student-mobile-close-btn {
            display: flex; /* Show only on mobile */
        }
    }
    
    /* Desktop Design */
    @media (min-width: 769px) {
        .student-mobile-close-btn {
            display: none !important;
        }
    }
    
    /* Dark mode improvements */
    .dark .student-sidebar-nav {
        background: linear-gradient(180deg, var(--bg-primary-dark) 0%, var(--bg-secondary-dark) 100%);
        border-right: 1px solid var(--border-dark);
    }
    
    .dark .student-sidebar-logo {
        background: rgba(31, 41, 55, 0.9);
        border-bottom: 1px solid var(--border-dark);
    }
    
    .dark .student-logo-container {
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(75, 85, 99, 0.3);
    }
    
    .dark .student-logo-container:hover {
        background: rgba(52, 211, 153, 0.1);
        border-color: rgba(52, 211, 153, 0.3);
    }
    
    .dark .student-user-section {
        background: rgba(31, 41, 55, 0.8);
        border-top: 1px solid var(--border-dark);
    }
    
    .dark .student-user-card {
        background: rgba(55, 65, 81, 0.3);
        border: 1px solid rgba(75, 85, 99, 0.3);
    }
    
    .dark .student-user-card:hover {
        background: rgba(52, 211, 153, 0.1);
        border-color: rgba(52, 211, 153, 0.3);
    }
    
    .dark .student-sidebar-nav-item:hover {
        background: linear-gradient(135deg, rgba(52, 211, 153, 0.15), rgba(16, 185, 129, 0.1));
        color: var(--text-primary-dark);
    }
    
    .dark .student-sidebar-nav-item.active {
        color: #34d399;
        background: linear-gradient(135deg, rgba(52, 211, 153, 0.2), rgba(16, 185, 129, 0.15));
        border-left: 4px solid #34d399;
    }
    
    /* Smooth transitions for theme switching */
    .student-sidebar-nav,
    .student-sidebar-logo,
    .student-logo-container,
    .student-user-section,
    .student-user-card,
    .student-sidebar-nav-item {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<!-- Enhanced Student Sidebar -->
<div class="student-sidebar-nav w-full h-full flex flex-col student-sidebar-content">
    
    <!-- Enhanced Logo Section -->
    <div class="student-sidebar-logo">
        <div class="student-logo-container">
            <div class="student-logo-icon">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z M12 14v6.5"></path>
                </svg>
            </div>
            <div class="flex-1">
                <div class="student-logo-text">Student Panel</div>
                <div class="student-logo-subtitle">SMA Negeri 1</div>
            </div>
        </div>
        
        <!-- Mobile Close Button -->
        <button @click="sidebarOpen = false" class="student-mobile-close-btn">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Enhanced Navigation -->
    <div class="student-nav-section flex-1">
        <!-- Dashboard -->
        <a href="{{ route('student.dashboard') }}" 
           class="student-sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('student.dashboard') ? 'active' : '' }}"
           @click="isMobile && (sidebarOpen = false)">
            <svg class="student-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>





        <!-- Section Divider -->
        <div class="student-nav-section-divider"></div>
        <div class="student-nav-section-title">
            <span>Academic Records</span>
        </div>

        <!-- QR Code Saya -->
        <a href="{{ route('student.attendance.index') }}" 
           class="student-sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('student.attendance.index') || request()->routeIs('student.attendance.qr-display') ? 'active' : '' }}"
           @click="isMobile && (sidebarOpen = false)">
            <svg class="student-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h2M4 4h5m0 0v5m0 0h5m0 0v5m0 0H9m0 0v5" />
            </svg>
            <span>QR Code Saya</span>
            @php
                $todayAttendance = auth()->user()->student && auth()->user()->student->attendanceLogs ? 
                                 auth()->user()->student->attendanceLogs()->whereDate('attendance_date', today())->first() : null;
            @endphp
            @if($todayAttendance)
                @php
                    $statusColor = match($todayAttendance->status) {
                        'hadir' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                        'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                        'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                        'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                        default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                    };
                @endphp
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                    ✓
                </span>
            @else
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                    !
                </span>
            @endif
        </a>
        
        <!-- Riwayat Absensi -->
        <a href="{{ route('student.attendance.history') }}" 
           class="student-sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('student.attendance.history') ? 'active' : '' }}"
           @click="isMobile && (sidebarOpen = false)">
            <svg class="student-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span>Riwayat Absensi</span>
            @php
                $student = auth()->user()->student ?? \App\Models\Student::where('user_id', auth()->id())->first();
                $monthlyCount = $student ? \App\Models\AttendanceLog::where('student_id', $student->id)
                    ->whereMonth('attendance_date', date('m'))
                    ->whereYear('attendance_date', date('Y'))
                    ->count() : 0;
            @endphp
            @if($monthlyCount > 0)
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $monthlyCount }}
                </span>
            @endif
        </a>

        <!-- Nilai Akademik -->
        <a href="{{ route('student.grades.index') }}" 
           class="student-sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('student.grades.index') || request()->routeIs('student.grades.show') || request()->routeIs('student.grades.subject') ? 'active' : '' }}"
           @click="isMobile && (sidebarOpen = false)">
            <svg class="student-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            <span>Nilai Akademik</span>
        </a>

        <!-- Section Divider -->
        <div class="student-nav-section-divider"></div>
        <div class="student-nav-section-title">
            <span>Account Settings</span>
        </div>

        <!-- Profil Siswa -->
        <a href="{{ route('student.profile') }}" 
           class="student-sidebar-nav-item group flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('student.profile') ? 'active' : '' }}"
           @click="isMobile && (sidebarOpen = false)">
            <svg class="student-nav-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
            <span>Profil Saya</span>
            @php
                $user = auth()->user();
                $profileCompletion = 0;
                if ($user->name) $profileCompletion += 25;
                if ($user->email) $profileCompletion += 25;
                if ($user->student && $user->student->phone) $profileCompletion += 25;
                if ($user->avatar) $profileCompletion += 25;
            @endphp
            @if($profileCompletion < 100)
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                    {{ $profileCompletion }}%
                </span>
            @else
                <span class="ml-auto inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                    ✓
                </span>
            @endif
        </a>


    </div>

    <!-- Enhanced User Section -->
    <div class="student-user-section">
        <a href="{{ route('student.profile') }}" class="student-user-card block text-decoration-none">
            <img class="student-user-avatar" 
                 src="{{ auth()->user()->avatar_url }}" 
                 alt="{{ auth()->user()->name }}"
                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=10B981&background=D1FAE5&size=44'">
            <div class="student-user-info">
                <div class="student-user-name">{{ auth()->user()->name }}</div>
                <div class="student-user-role">Siswa</div>
            </div>
            <div class="student-user-status"></div>
        </a>
    </div>
</div>