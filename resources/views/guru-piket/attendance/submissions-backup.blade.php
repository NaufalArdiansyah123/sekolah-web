@extends('layouts.admin')

@section('title', 'Kelola Submission Absensi')

<!-- Add CSRF token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('styles')
<style>
    /* Modern Minimalist Design System */
    :root {
        --primary: #3b82f6;
        --primary-light: #dbeafe;
        --success: #10b981;
        --warning: #f59e0b;
        --danger: #ef4444;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --radius: 8px;
        --radius-lg: 12px;
        --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }

    /* Base Layout */
    .container-modern {
        max-width: 1200px;
        margin: 0 auto;
        padding: 1rem;
    }

    @media (min-width: 768px) {
        .container-modern {
            padding: 1.5rem;
        }
    }

    /* Modern Cards */
    .card {
        background: white;
        border-radius: var(--radius-lg);
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow);
        transition: box-shadow 0.2s ease;
    }

    .card:hover {
        box-shadow: var(--shadow-md);
    }

    .dark .card {
        background: var(--gray-800);
        border-color: var(--gray-700);
    }

    /* Header Section */
    .header-section {
        background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
        border-radius: var(--radius-lg);
        padding: 2rem;
        color: white;
        margin-bottom: 2rem;
    }

    .header-title {
        font-size: 1.875rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .header-subtitle {
        opacity: 0.9;
        font-size: 1rem;
        margin-bottom: 1.5rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 1.5rem;
        margin-top: 1.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: var(--radius);
        backdrop-filter: blur(10px);
    }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        display: block;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }

    /* Filter Section */
    .filter-section {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        align-items: center;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .filter-btn {
        padding: 0.5rem 1rem;
        border-radius: var(--radius);
        border: 1px solid var(--gray-300);
        background: white;
        color: var(--gray-600);
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
    }

    .filter-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .dark .filter-btn {
        background: var(--gray-700);
        border-color: var(--gray-600);
        color: var(--gray-300);
    }

    .filter-controls {
        margin-left: auto;
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    @media (max-width: 768px) {
        .filter-controls {
            margin-left: 0;
            width: 100%;
            justify-content: stretch;
        }
    }

    /* Submission Items */
    .submissions-container {
        padding: 1.5rem;
    }

    .submission-item {
        background: white;
        border: 1px solid var(--gray-200);
        border-radius: var(--radius);
        padding: 1rem;
        margin-bottom: 0.75rem;
        cursor: pointer;
        transition: all 0.15s ease;
        position: relative;
    }

    .submission-item:hover {
        border-color: var(--gray-300);
        box-shadow: var(--shadow);
    }

    .dark .submission-item {
        background: var(--gray-800);
        border-color: var(--gray-700);
    }

    .dark .submission-item:hover {
        border-color: var(--gray-600);
    }

    /* Status Indicators */
    .submission-item.pending {
        border-left: 3px solid var(--warning);
    }

    .submission-item.confirmed {
        border-left: 3px solid var(--success);
    }

    .submission-item.rejected {
        border-left: 3px solid var(--danger);
    }

    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }

    .status-confirmed {
        background: #d1fae5;
        color: #065f46;
    }

    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Responsive Grid */
    .submission-content {
        display: grid;
        grid-template-columns: auto 1fr auto;
        gap: 1rem;
        align-items: center;
    }

    @media (max-width: 640px) {
        .submission-content {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }
        
        .submission-meta {
            order: -1;
        }
    }

    .teacher-avatar {
        width: 3rem;
        height: 3rem;
        background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
        border-radius: var(--radius);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
    }

    .submission-info h3 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
    }

    .dark .submission-info h3 {
        color: white;
    }

    .submission-details {
        font-size: 0.875rem;
        color: var(--gray-600);
        margin-bottom: 0.5rem;
    }

    .dark .submission-details {
        color: var(--gray-400);
    }

    .submission-meta-items {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.75rem;
        color: var(--gray-500);
    }

    .dark .submission-meta-items {
        color: var(--gray-400);
    }

    .submission-stats {
        text-align: right;
    }

    @media (max-width: 640px) {
        .submission-stats {
            text-align: left;
        }
    }

    .attendance-percentage {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .dark .attendance-percentage {
        color: white;
    }

    .attendance-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-top: 0.25rem;
    }

    .dark .attendance-label {
        color: var(--gray-400);
    }

    /* Modal Styles */
    .modal-overlay {
        background: rgba(0, 0, 0, 0.5);
        /* Remove backdrop-filter to prevent blur */
    }

    .modal-content {
        background: white;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        max-height: 90vh;
        overflow-y: auto;
        width: 100%;
        max-width: 24rem;
        margin: 1rem;
        /* Ensure no blur effects */
        backdrop-filter: none;
        filter: none;
        -webkit-backdrop-filter: none;
        -webkit-filter: none;
    }

    .dark .modal-content {
        background: var(--gray-800);
        /* Ensure no blur effects in dark mode */
        backdrop-filter: none;
        filter: none;
        -webkit-backdrop-filter: none;
        -webkit-filter: none;
    }

    @media (min-width: 768px) {
        .modal-content {
            max-width: 48rem;
        }
    }

    /* Action Buttons */
    .btn {
        padding: 0.5rem 1rem;
        border-radius: var(--radius);
        font-weight: 500;
        font-size: 0.875rem;
        border: none;
        cursor: pointer;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: #2563eb;
    }

    .btn-success {
        background: var(--success);
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-danger {
        background: var(--danger);
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    .btn-secondary {
        background: var(--gray-500);
        color: white;
    }

    .btn-secondary:hover {
        background: var(--gray-600);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        width: 4rem;
        height: 4rem;
        background: var(--gray-100);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--gray-400);
        font-size: 1.5rem;
    }

    .dark .empty-icon {
        background: var(--gray-700);
        color: var(--gray-500);
    }

    .empty-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .dark .empty-title {
        color: white;
    }

    .empty-description {
        color: var(--gray-600);
        margin-bottom: 1.5rem;
    }

    .dark .empty-description {
        color: var(--gray-400);
    }

    /* Utilities */
    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Debug buttons - minimal style */
    .debug-controls {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .debug-btn {
        padding: 0.375rem 0.75rem;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: var(--radius);
        color: white;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .debug-btn:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    @media (max-width: 768px) {
        .debug-controls {
            display: none;
        }
    }
    
    /* Remove any blur effects from all modal elements */
    #submissionModal,
    #submissionModal *,
    .modal-overlay,
    .modal-content {
        backdrop-filter: none !important;
        filter: none !important;
        -webkit-backdrop-filter: none !important;
        -webkit-filter: none !important;
    }
    
    /* Ensure modal content is crisp and clear */
    .modal-content {
        transform: none;
        will-change: auto;
        backface-visibility: visible;
    }
    
    /* Fix any potential blur from transforms */
    .modal-content,
    .modal-content * {
        transform: translateZ(0);
        -webkit-transform: translateZ(0);
    }
</style>
@endpush

@section('content')
<div class="container-modern">
    <!-- Error Alert -->
    @if(isset($error))
    <div class="card" style="border-color: var(--danger); background: #fef2f2; margin-bottom: 1.5rem;">
        <div style="padding: 1rem; display: flex; align-items: center; gap: 0.75rem;">
            <i class="fas fa-exclamation-triangle" style="color: var(--danger); font-size: 1.25rem;"></i>
            <div>
                <h3 style="font-weight: 600; color: #991b1b; margin-bottom: 0.25rem;">Terjadi Kesalahan</h3>
                <p style="color: #b91c1c; margin: 0;">{{ $error }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Header Section -->
    <div class="header-section">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
            <div style="flex: 1; min-width: 300px;">
                <h1 class="header-title">
                    <i class="fas fa-clipboard-check" style="margin-right: 0.75rem;"></i>
                    Kelola Submission Absensi
                </h1>
                <p class="header-subtitle">
                    Review, edit, dan konfirmasi submission absensi dari guru
                </p>
                
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['pending'] ?? 0 }}</span>
                        <span class="stat-label">Menunggu</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['confirmed_today'] ?? 0 }}</span>
                        <span class="stat-label">Dikonfirmasi</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ $statistics['total_today'] ?? 0 }}</span>
                        <span class="stat-label">Total Hari Ini</span>
                    </div>
                </div>
            </div>
            
            <div class="debug-controls">
                <button onclick="testRoute()" class="debug-btn">
                    <i class="fas fa-bug"></i> Test
                </button>
                <button onclick="debugRoutes()" class="debug-btn">
                    <i class="fas fa-list"></i> Routes
                </button>
                <button onclick="removeBlurEffects()" class="debug-btn">
                    <i class="fas fa-eye"></i> Fix Blur
                </button>
                <button onclick="refreshSubmissions()" class="debug-btn">
                    <i class="fas fa-sync-alt"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card filter-section">
        <div class="filter-buttons">
            <button onclick="filterSubmissions('all')" class="filter-btn active" data-filter="all">
                <i class="fas fa-list"></i>Semua
            </button>
            <button onclick="filterSubmissions('pending')" class="filter-btn" data-filter="pending">
                <i class="fas fa-clock"></i>Menunggu
            </button>
            <button onclick="filterSubmissions('confirmed')" class="filter-btn" data-filter="confirmed">
                <i class="fas fa-check-circle"></i>Dikonfirmasi
            </button>
            <button onclick="filterSubmissions('rejected')" class="filter-btn" data-filter="rejected">
                <i class="fas fa-times-circle"></i>Ditolak
            </button>
        </div>
        
        <div class="filter-controls">
            <input type="date" id="filterDate" 
                   style="padding: 0.5rem; border: 1px solid var(--gray-300); border-radius: var(--radius); font-size: 0.875rem;" 
                   value="{{ date('Y-m-d') }}">
            <button onclick="applyDateFilter()" class="btn btn-primary">
                <i class="fas fa-filter"></i>Filter
            </button>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="card">
        <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin: 0;">
                Daftar Submission
            </h2>
            <div style="font-size: 0.875rem; color: var(--gray-600);">
                <span id="submission-count">{{ isset($submissions) ? $submissions->count() : 0 }}</span> submission ditemukan
            </div>
        </div>
        
        <div class="submissions-container">
            <div id="submissionsList">
                @if(isset($submissions) && $submissions->count() > 0)
                    @foreach($submissions as $submission)
                    <div class="submission-item {{ strtolower($submission->status) }} fade-in" 
                         onclick="viewSubmissionDetail({{ $submission->id }})"
                         style="animation-delay: {{ $loop->index * 50 }}ms;">
                        <div class="submission-content">
                            <div class="teacher-avatar">
                                {{ substr($submission->teacher->name ?? 'G', 0, 1) }}
                            </div>
                            
                            <div class="submission-info">
                                <h3>{{ $submission->teacher->name ?? 'Guru' }}</h3>
                                <div class="submission-details">
                                    {{ $submission->class->name ?? 'Kelas' }} • {{ $submission->subject }}
                                </div>
                                <div class="submission-meta-items">
                                    <span>
                                        <i class="fas fa-clock"></i>
                                        {{ $submission->session_time }}
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-users"></i>
                                        {{ $submission->present_count }}/{{ $submission->total_students }} hadir
                                    </span>
                                </div>
                            </div>
                            
                            <div class="submission-stats">
                                <span class="status-badge status-{{ strtolower($submission->status) }}">
                                    {{ $submission->status_text }}
                                </span>
                                <div style="margin-top: 0.5rem; font-size: 0.75rem; color: var(--gray-500);">
                                    {{ $submission->submitted_at->diffForHumans() }}
                                </div>
                                <div style="margin-top: 0.5rem;">
                                    <div class="attendance-percentage">
                                        {{ $submission->attendance_percentage }}%
                                    </div>
                                    <div class="attendance-label">Kehadiran</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Submission</h3>
                    <p class="empty-description">Submission absensi dari guru akan muncul di sini</p>
                    <button onclick="refreshSubmissions()" class="btn btn-primary">
                        <i class="fas fa-sync-alt"></i>Refresh
                    </button>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Submission Detail Modal -->
<div id="submissionModal" class="fixed inset-0 z-50 hidden" style="backdrop-filter: none; filter: none;">
    <div class="modal-overlay fixed inset-0" onclick="closeSubmissionModal()" style="backdrop-filter: none;"></div>
    <div class="flex items-center justify-center min-h-screen p-4" style="backdrop-filter: none; filter: none;">
        <div class="modal-content" style="backdrop-filter: none; filter: none;">
            <div style="padding: 1.5rem; border-bottom: 1px solid var(--gray-200); display: flex; justify-content: space-between; align-items: center;">
                <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin: 0;">
                    <i class="fas fa-clipboard-check" style="color: var(--primary); margin-right: 0.5rem;"></i>
                    Detail Submission Absensi
                </h2>
                <button onclick="closeSubmissionModal()" 
                        style="padding: 0.5rem; color: var(--gray-400); background: none; border: none; border-radius: var(--radius); cursor: pointer; transition: all 0.15s ease;"
                        onmouseover="this.style.background='var(--gray-100)'"
                        onmouseout="this.style.background='none'">
                    <i class="fas fa-times" style="font-size: 1.125rem;"></i>
                </button>
            </div>
            
            <div id="submissionDetailContent" style="padding: 1.5rem; backdrop-filter: none; filter: none;">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Copy all the existing JavaScript functions here
// (keeping the same functionality but with modern styling)
let currentFilter = 'all';
let currentSubmissionData = null;

// Test route function
function testRoute() {
    const testUrl = '/guru-piket/attendance/submissions/test-route';
    console.log('🧪 Testing route accessibility:', testUrl);
    
    return fetch(testUrl, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('🧪 Test route response status:', response.status);
        if (response.ok) {
            return response.json();
        }
        throw new Error(`Test route failed: ${response.status}`);
    })
    .then(data => {
        console.log('✅ Test route success:', data);
        return data;
    })
    .catch(error => {
        console.error('💥 Test route error:', error);
        throw error;
    });
}

// Debug route information
function debugRouteInfo() {
    console.log('🔍 Route Debug Info:');
    console.log('- Current URL:', window.location.href);
    console.log('- Base URL:', window.location.origin);
    console.log('- Path:', window.location.pathname);
    console.log('- CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 'NOT FOUND');
    
    try {
        const routeBase = '{{ url("/guru-piket/attendance/submissions") }}';
        console.log('- Laravel URL helper:', routeBase);
    } catch (error) {
        console.warn('- Laravel URL helper failed:', error);
    }
    
    debugRoutes();
}

// Debug all routes
function debugRoutes() {
    const debugUrl = '/guru-piket/attendance/submissions/debug-routes';
    console.log('🔍 Fetching route list from:', debugUrl);
    
    fetch(debugUrl, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        console.log('📋 Registered Routes:', data);
        if (data.success && data.routes) {
            console.table(data.routes);
        }
    })
    .catch(error => {
        console.error('💥 Error fetching routes:', error);
    });
}

// Filter submissions
function filterSubmissions(status) {
    currentFilter = status;
    
    // Update filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    document.querySelector(`[data-filter="${status}"]`).classList.add('active');
    
    // Filter submission items
    const items = document.querySelectorAll('.submission-item');
    let visibleCount = 0;
    
    items.forEach(item => {
        if (status === 'all' || item.classList.contains(status)) {
            item.style.display = 'block';
            visibleCount++;
        } else {
            item.style.display = 'none';
        }
    });
    
    // Update count
    document.getElementById('submission-count').textContent = visibleCount;
}

// Apply date filter
function applyDateFilter() {
    const date = document.getElementById('filterDate').value;
    if (!date) return;
    
    window.location.href = `{{ route('guru-piket.attendance.submissions') }}?date=${date}&status=${currentFilter}`;
}

// Refresh submissions
function refreshSubmissions() {
    const refreshBtn = event.target.closest('button');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memuat...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// View submission detail
function viewSubmissionDetail(submissionId) {
    console.log('🔍 Loading submission detail for ID:', submissionId);
    
    showSubmissionModal({
        id: submissionId,
        loading: true
    });
    
    fetchSubmissionDetail(submissionId);
}

// Fetch submission detail function
function fetchSubmissionDetail(submissionId) {
    const baseUrl = '{{ url("/guru-piket/attendance/submissions") }}';
    const url = `${baseUrl}/${submissionId}/detail`;
    
    console.log('📡 Final URL:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showSubmissionModal(data.submission);
        } else {
            alert('❌ Gagal memuat detail submission: ' + (data.message || 'Unknown error'));
            closeSubmissionModal();
        }
    })
    .catch(error => {
        console.error('💥 Error loading submission detail:', error);
        alert('⚠️ Terjadi kesalahan saat memuat detail: ' + error.message);
        closeSubmissionModal();
    });
}

// Show submission modal
function showSubmissionModal(submission) {
    const modal = document.getElementById('submissionModal');
    const content = document.getElementById('submissionDetailContent');
    
    // Remove any blur effects that might be applied
    modal.style.backdropFilter = 'none';
    modal.style.filter = 'none';
    modal.style.webkitBackdropFilter = 'none';
    modal.style.webkitFilter = 'none';
    
    if (submission.loading) {
        content.innerHTML = `
            <div style="text-align: center; padding: 3rem; backdrop-filter: none; filter: none;">
                <div style="width: 3rem; height: 3rem; border: 3px solid var(--gray-200); border-top: 3px solid var(--primary); border-radius: 50%; animation: spin 1s linear infinite; margin: 0 auto 1rem;"></div>
                <p style="color: var(--gray-600);">Memuat detail submission...</p>
            </div>
        `;
    } else {
        currentSubmissionData = JSON.parse(JSON.stringify(submission));
        content.innerHTML = createSubmissionDetailHtml(submission);
    }
    
    modal.classList.remove('hidden');
    
    // Ensure modal content is crisp after showing
    setTimeout(() => {
        removeBlurEffects();
    }, 10);
    
    // Also remove blur effects immediately
    removeBlurEffects();
}

// Close submission modal
function closeSubmissionModal() {
    document.getElementById('submissionModal').classList.add('hidden');
    currentSubmissionData = null;
}

// Remove blur effects from all elements
function removeBlurEffects() {
    const modal = document.getElementById('submissionModal');
    if (!modal) return;
    
    // Get all elements in modal
    const allElements = modal.querySelectorAll('*');
    
    // Remove blur from modal itself
    modal.style.backdropFilter = 'none';
    modal.style.filter = 'none';
    modal.style.webkitBackdropFilter = 'none';
    modal.style.webkitFilter = 'none';
    
    // Remove blur from all child elements
    allElements.forEach(element => {
        element.style.backdropFilter = 'none';
        element.style.filter = 'none';
        element.style.webkitBackdropFilter = 'none';
        element.style.webkitFilter = 'none';
    });
    
    console.log('✅ Removed blur effects from', allElements.length + 1, 'elements');
}

// Create submission detail HTML (simplified version)
function createSubmissionDetailHtml(submission) {
    const attendanceData = submission.attendance_data || [];
    const statusClass = submission.status.toLowerCase();
    const canEdit = submission.status === 'pending';
    
    return `
        <div style="space-y: 1.5rem;">
            <div style="background: var(--gray-50); border-radius: var(--radius); padding: 1.5rem; margin-bottom: 1.5rem;">
                <h3 style="font-weight: 600; margin-bottom: 1rem;">Informasi Submission</h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Guru</div>
                        <div style="font-weight: 600;">${submission.teacher.name}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Mata Pelajaran</div>
                        <div style="font-weight: 600;">${submission.subject}</div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">Status</div>
                        <span class="status-badge status-${statusClass}">${submission.status_text}</span>
                    </div>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900);">${submission.total_students}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">Total Siswa</div>
                </div>
                <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">${submission.present_count}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">Hadir</div>
                </div>
                <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">${submission.late_count}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">Terlambat</div>
                </div>
                <div style="text-align: center; padding: 1rem; background: white; border-radius: var(--radius); border: 1px solid var(--gray-200);">
                    <div style="font-size: 1.5rem; font-weight: 700; color: var(--danger);">${submission.absent_count}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">Tidak Hadir</div>
                </div>
            </div>
            
            ${submission.status === 'pending' ? `
                <div style="display: flex; gap: 0.75rem; justify-content: flex-end; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                    <button onclick="confirmSubmission(${submission.id}, 'confirm')" class="btn btn-success">
                        <i class="fas fa-check"></i>Konfirmasi
                    </button>
                    <button onclick="confirmSubmission(${submission.id}, 'reject')" class="btn btn-danger">
                        <i class="fas fa-times"></i>Tolak
                    </button>
                </div>
            ` : ''}
        </div>
    `;
}

// Confirm submission
function confirmSubmission(submissionId, action) {
    const isConfirm = action === 'confirm';
    const title = isConfirm ? '✅ Konfirmasi Submission' : '❌ Tolak Submission';
    const message = isConfirm ? 
        'Dengan mengkonfirmasi, submission akan diselesaikan dan tidak dapat diedit lagi.' :
        'Submission akan dikembalikan ke guru untuk diperbaiki.';
    
    if (!confirm(`${title}\n\n${message}\n\nLanjutkan?`)) {
        return;
    }
    
    const notes = prompt(isConfirm ? 
        '📝 Catatan konfirmasi (opsional):' : 
        '📝 Alasan penolakan (wajib):'
    );
    
    if (!isConfirm && !notes) {
        alert('❌ Alasan penolakan harus diisi');
        return;
    }
    
    const baseUrl = '{{ url("/guru-piket/attendance/submissions") }}';
    const confirmUrl = `${baseUrl}/${submissionId}/confirm`;
    
    fetch(confirmUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            action: action,
            notes: notes
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const actionText = isConfirm ? 'dikonfirmasi' : 'ditolak';
            alert(`✅ Submission berhasil ${actionText}!`);
            closeSubmissionModal();
            refreshSubmissions();
        } else {
            alert('❌ Gagal memproses: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('💥 Error confirming submission:', error);
        alert('⚠️ Terjadi kesalahan saat memproses: ' + error.message);
    });
}

// Add spin animation for loading
const style = document.createElement('style');
style.textContent = `
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Modern submissions page loaded');
});

// Get status badge for student
function getStatusBadge(status) {
    const badges = {
        'hadir': { class: 'status-confirmed', text: 'Hadir' },
        'terlambat': { class: 'status-pending', text: 'Terlambat' },
        'izin': { class: 'bg-blue-100 text-blue-800', text: 'Izin' },
        'sakit': { class: 'bg-purple-100 text-purple-800', text: 'Sakit' },
        'alpha': { class: 'status-rejected', text: 'Alpha' }
    };
    
    return badges[status] || { class: 'bg-gray-100 text-gray-800', text: status };
}
</script>
@endpush