@extends('layouts.guru-piket')

@section('title', 'Kelola Submission Absensi')

<!-- Add CSRF token for AJAX requests -->
<meta name="csrf-token" content="{{ csrf_token() }}">

@push('styles')
<style>
    .submission-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .dark .submission-card {
        background: #1f2937;
        border: 1px solid #374151;
    }
    
    .submission-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .submission-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1rem;
        transition: all 0.2s ease;
        cursor: pointer;
        position: relative;
    }
    
    .dark .submission-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .submission-item:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .dark .submission-item:hover {
        background: #4b5563;
    }
    
    .submission-item.pending {
        border-left: 4px solid #f59e0b;
        background: linear-gradient(90deg, #fef3c7 0%, #f9fafb 10%);
    }
    
    .dark .submission-item.pending {
        background: linear-gradient(90deg, #78350f 0%, #374151 10%);
    }
    
    .submission-item.confirmed {
        border-left: 4px solid #10b981;
        background: linear-gradient(90deg, #dcfce7 0%, #f9fafb 10%);
    }
    
    .dark .submission-item.confirmed {
        background: linear-gradient(90deg, #14532d 0%, #374151 10%);
    }
    
    .submission-item.rejected {
        border-left: 4px solid #ef4444;
        background: linear-gradient(90deg, #fee2e2 0%, #f9fafb 10%);
    }
    
    .dark .submission-item.rejected {
        background: linear-gradient(90deg, #7f1d1d 0%, #374151 10%);
    }
    
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .status-pending {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
    }
    
    .status-confirmed {
        background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        color: white;
    }
    
    .status-rejected {
        background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
        color: white;
    }
    
    .modal-overlay {
        background: rgba(0, 0, 0, 0.6);
        /* Remove backdrop-filter to prevent blur */
    }
    
    .modal-content {
        background: white;
        border-radius: 1.5rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-height: 90vh;
        overflow-y: auto;
        /* Ensure no blur effects */
        backdrop-filter: none;
        filter: none;
    }
    
    .dark .modal-content {
        background: #1f2937;
        /* Ensure no blur effects in dark mode */
        backdrop-filter: none;
        filter: none;
    }
    
    /* Remove any blur effects from all modal elements */
    #submissionModal,
    #submissionModal *,
    .modal-overlay,
    .modal-content,
    #submissionDetailContent {
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
    
    .attendance-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
    }
    
    .dark .attendance-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .attendance-item:hover {
        background: #f1f5f9;
        transform: translateX(4px);
    }
    
    .dark .attendance-item:hover {
        background: #4b5563;
    }
    
    .filter-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        border: 2px solid #e5e7eb;
        background: white;
        color: #6b7280;
        font-weight: 500;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .filter-btn:hover {
        border-color: #3b82f6;
        color: #3b82f6;
        transform: translateY(-1px);
    }
    
    .filter-btn.active {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        border-color: #3b82f6;
        color: white;
    }
    
    .dark .filter-btn {
        background: #374151;
        border-color: #4b5563;
        color: #d1d5db;
    }
    
    .dark .filter-btn:hover {
        border-color: #60a5fa;
        color: #60a5fa;
    }
    
    .action-btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 600;
        transition: all 0.2s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
    }
    
    .btn-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }
    
    .btn-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }
</style>
@endpush

@section('content')
<div class="space-y-8">
    <!-- Error Alert -->
    @if(isset($error))
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-6">
        <div class="flex items-center">
            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl mr-3"></i>
            <div>
                <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Terjadi Kesalahan</h3>
                <p class="text-red-700 dark:text-red-300 mt-1">{{ $error }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">
                    <i class="fas fa-clipboard-check mr-3"></i>
                    Kelola Submission Absensi
                </h1>
                <p class="text-indigo-100 text-lg">
                    Review, edit, dan konfirmasi submission absensi dari guru
                </p>
                <div class="mt-4 flex items-center space-x-6 text-indigo-100">
                    <div class="flex items-center">
                        <i class="fas fa-clock mr-2"></i>
                        <span>{{ $statistics['pending'] ?? 0 }} Menunggu</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ $statistics['confirmed_today'] ?? 0 }} Dikonfirmasi</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-file-alt mr-2"></i>
                        <span>{{ $statistics['total_today'] ?? 0 }} Total</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block flex space-x-2">
                <button onclick="testRoute()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-2 rounded-lg transition-all duration-200 flex items-center text-xs">
                    <i class="fas fa-bug mr-1"></i>
                    Test
                </button>
                <button onclick="debugRoutes()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-2 rounded-lg transition-all duration-200 flex items-center text-xs">
                    <i class="fas fa-list mr-1"></i>
                    Routes
                </button>
                <button onclick="removeBlurEffects()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-2 rounded-lg transition-all duration-200 flex items-center text-xs">
                    <i class="fas fa-eye mr-1"></i>
                    Fix Blur
                </button>
                <button onclick="debugRouteInfo()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-3 py-2 rounded-lg transition-all duration-200 flex items-center text-xs">
                    <i class="fas fa-info mr-1"></i>
                    Debug
                </button>
                <button onclick="refreshSubmissions()" class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center text-sm">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="submission-card p-6">
        <div class="flex flex-wrap items-center gap-4">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Filter:</h3>
            <button onclick="filterSubmissions('all')" class="filter-btn active" data-filter="all">
                <i class="fas fa-list mr-2"></i>Semua
            </button>
            <button onclick="filterSubmissions('pending')" class="filter-btn" data-filter="pending">
                <i class="fas fa-clock mr-2"></i>Menunggu
            </button>
            <button onclick="filterSubmissions('confirmed')" class="filter-btn" data-filter="confirmed">
                <i class="fas fa-check-circle mr-2"></i>Dikonfirmasi
            </button>
            <button onclick="filterSubmissions('rejected')" class="filter-btn" data-filter="rejected">
                <i class="fas fa-times-circle mr-2"></i>Ditolak
            </button>
            <div class="ml-auto flex items-center space-x-3">
                <input type="date" id="filterDate" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ date('Y-m-d') }}">
                <button onclick="applyDateFilter()" class="action-btn btn-primary">
                    <i class="fas fa-filter mr-2"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="submission-card">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Daftar Submission
                </h2>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span id="submission-count">{{ isset($submissions) ? $submissions->count() : 0 }}</span> submission ditemukan
                </div>
            </div>
        </div>
        <div class="p-6">
            <div id="submissionsList">
                @if(isset($submissions) && $submissions->count() > 0)
                    @foreach($submissions as $submission)
                <div class="submission-item {{ strtolower($submission->status) }}" onclick="viewSubmissionDetail({{ $submission->id }})">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-xl flex items-center justify-center text-white">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $submission->teacher->name ?? 'Guru' }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $submission->class->name ?? 'Kelas' }} • {{ $submission->subject }}
                                </p>
                                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span>
                                        <i class="fas fa-clock mr-1"></i>
                                        {{ $submission->session_time }}
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-users mr-1"></i>
                                        {{ $submission->present_count }}/{{ $submission->total_students }} hadir
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="status-badge status-{{ strtolower($submission->status) }}">
                                {{ $submission->status_text }}
                            </span>
                            <div class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                {{ $submission->submitted_at->diffForHumans() }}
                            </div>
                            <div class="mt-1">
                                <div class="text-lg font-bold text-gray-900 dark:text-white">
                                    {{ $submission->attendance_percentage }}%
                                </div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Kehadiran</div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
                @else
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-3xl text-gray-400 dark:text-gray-500"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Belum Ada Submission</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">Submission absensi dari guru akan muncul di sini</p>
                    <button onclick="refreshSubmissions()" class="action-btn btn-primary">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh
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
        <div class="modal-content w-full max-w-5xl p-8 relative z-10" style="backdrop-filter: none; filter: none;">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    <i class="fas fa-clipboard-check mr-3 text-indigo-600"></i>
                    Detail Submission Absensi
                </h2>
                <button onclick="closeSubmissionModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <div id="submissionDetailContent" style="backdrop-filter: none; filter: none;">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
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
    
    // Try to get route info from Laravel
    try {
        const routeBase = '{{ url("/guru-piket/attendance/submissions") }}';
        console.log('- Laravel URL helper:', routeBase);
    } catch (error) {
        console.warn('- Laravel URL helper failed:', error);
    }
    
    // Get all registered routes
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
    
    // In real implementation, this would make an AJAX request
    window.location.href = `{{ route('guru-piket.attendance.submissions') }}?date=${date}&status=${currentFilter}`;
}

// Refresh submissions
function refreshSubmissions() {
    const refreshBtn = event.target.closest('button');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Memuat...';
    refreshBtn.disabled = true;
    
    setTimeout(() => {
        location.reload();
    }, 1000);
}

// View submission detail
function viewSubmissionDetail(submissionId) {
    console.log('🔍 Loading submission detail for ID:', submissionId);
    
    // Debug route info first
    debugRouteInfo();
    
    // Show loading
    showSubmissionModal({
        id: submissionId,
        loading: true
    });
    
    // Test route accessibility first
    console.log('🧪 Testing route accessibility before making actual request...');
    testRoute().then(() => {
        console.log('✅ Route test passed, proceeding with submission detail request');
        fetchSubmissionDetail(submissionId);
    }).catch(error => {
        console.error('💥 Route test failed, but trying submission detail anyway:', error);
        fetchSubmissionDetail(submissionId);
    });
}

// Fetch submission detail function
function fetchSubmissionDetail(submissionId) {
    // Build URL manually to avoid Laravel route helper issues
    const baseUrl = '{{ url("/guru-piket/attendance/submissions") }}';
    const url = `${baseUrl}/${submissionId}/detail`;
    
    console.log('📡 Base URL:', baseUrl);
    console.log('📡 Submission ID:', submissionId);
    console.log('📡 Final URL:', url);
    
    // Validate URL format
    if (url.includes('//detail') || !url.includes('/guru-piket/')) {
        console.error('❌ Invalid URL format detected:', url);
        alert('❌ Error: Invalid URL format. Please refresh the page and try again.');
        closeSubmissionModal();
        return;
    }
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        console.log('📥 Response status:', response.status);
        console.log('📥 Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('✅ Response data:', data);
        
        if (data.success) {
            showSubmissionModal(data.submission);
        } else {
            console.error('❌ API returned error:', data.message);
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
            <div class="text-center py-16" style="backdrop-filter: none; filter: none;">
                <div class="animate-spin rounded-full h-16 w-16 border-b-2 border-indigo-600 mx-auto mb-4"></div>
                <p class="text-gray-600 dark:text-gray-400">Memuat detail submission...</p>
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

// Create submission detail HTML
function createSubmissionDetailHtml(submission) {
    const attendanceData = submission.attendance_data || [];
    const statusClass = submission.status.toLowerCase();
    const canEdit = submission.status === 'pending';
    
    let attendanceHtml = '';
    attendanceData.forEach((student, index) => {
        const statusBadge = getStatusBadge(student.status);
        attendanceHtml += `
            <div class="attendance-item" id="student-${index}">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                ${student.student_name.charAt(0)}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">${student.student_name}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">NIS: ${student.nis}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        ${canEdit ? `
                            <select onchange="updateStudentStatus(${index}, this.value)" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                                <option value="hadir" ${student.status === 'hadir' ? 'selected' : ''}>Hadir</option>
                                <option value="terlambat" ${student.status === 'terlambat' ? 'selected' : ''}>Terlambat</option>
                                <option value="izin" ${student.status === 'izin' ? 'selected' : ''}>Izin</option>
                                <option value="sakit" ${student.status === 'sakit' ? 'selected' : ''}>Sakit</option>
                                <option value="alpha" ${student.status === 'alpha' ? 'selected' : ''}>Alpha</option>
                            </select>
                            <input type="time" onchange="updateStudentTime(${index}, this.value)" value="${student.scan_time || ''}" class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        ` : `
                            <span class="status-badge ${statusBadge.class}">${statusBadge.text}</span>
                            ${student.scan_time ? `<span class="text-sm text-gray-600 dark:text-gray-400">${student.scan_time}</span>` : ''}
                        `}
                    </div>
                </div>
                ${canEdit ? `
                    <div class="mt-3">
                        <input type="text" onchange="updateStudentNotes(${index}, this.value)" value="${student.notes || ''}" placeholder="Catatan..." class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    </div>
                ` : (student.notes ? `<p class="text-sm text-gray-600 dark:text-gray-400 mt-2">${student.notes}</p>` : '')}
            </div>
        `;
    });
    
    const actionButtons = submission.status === 'pending' ? `
        <div class="flex justify-between items-center pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex space-x-3">
                <button onclick="saveAttendanceChanges(${submission.id})" class="action-btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
                <button onclick="resetAttendanceData(${submission.id})" class="action-btn btn-secondary">
                    <i class="fas fa-undo mr-2"></i>Reset
                </button>
            </div>
            <div class="flex space-x-3">
                <button onclick="confirmSubmission(${submission.id}, 'confirm')" class="action-btn btn-success">
                    <i class="fas fa-check mr-2"></i>Konfirmasi
                </button>
                <button onclick="confirmSubmission(${submission.id}, 'reject')" class="action-btn btn-danger">
                    <i class="fas fa-times mr-2"></i>Tolak
                </button>
            </div>
        </div>
    ` : '';
    
    return `
        <div class="space-y-8">
            <!-- Submission Info -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-700 dark:to-gray-800 rounded-xl p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Informasi Guru</h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">${submission.teacher.name}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${submission.class ? submission.class.name : 'Kelas tidak ditemukan'}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Detail Pelajaran</h3>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">${submission.subject}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${submission.session_time}</p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-2">Status & Tanggal</h3>
                        <span class="status-badge status-${statusClass}">${submission.status_text}</span>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">${new Date(submission.submission_date).toLocaleDateString('id-ID')}</p>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="mt-6 grid grid-cols-4 gap-4">
                    <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-gray-900 dark:text-white">${submission.total_students}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Total Siswa</div>
                    </div>
                    <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-green-600">${submission.present_count}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Hadir</div>
                    </div>
                    <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-yellow-600">${submission.late_count}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Terlambat</div>
                    </div>
                    <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                        <div class="text-2xl font-bold text-red-600">${submission.absent_count}</div>
                        <div class="text-sm text-gray-600 dark:text-gray-400">Tidak Hadir</div>
                    </div>
                </div>
            </div>
            
            <!-- Attendance Details -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Detail Kehadiran Siswa
                    </h3>
                    ${canEdit ? `
                        <div class="bg-blue-50 dark:bg-blue-900/20 px-4 py-2 rounded-lg">
                            <span class="text-sm text-blue-700 dark:text-blue-300 font-medium">
                                <i class="fas fa-edit mr-1"></i>Mode Edit Aktif
                            </span>
                        </div>
                    ` : `
                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-2 rounded-lg">
                            <span class="text-sm text-gray-600 dark:text-gray-400 font-medium">
                                <i class="fas fa-lock mr-1"></i>Mode Lihat
                            </span>
                        </div>
                    `}
                </div>
                <div class="max-h-96 overflow-y-auto space-y-3">
                    ${attendanceHtml}
                </div>
            </div>
            
            <!-- Notes -->
            ${submission.notes ? `
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-yellow-800 dark:text-yellow-200 mb-3">
                        <i class="fas fa-sticky-note mr-2"></i>Catatan Guru
                    </h3>
                    <p class="text-yellow-700 dark:text-yellow-300">${submission.notes}</p>
                </div>
            ` : ''}
            
            <!-- Action Buttons -->
            ${actionButtons}
        </div>
    `;
}

// Get status badge
function getStatusBadge(status) {
    const badges = {
        'hadir': { class: 'status-confirmed', text: 'Hadir' },
        'terlambat': { class: 'status-pending', text: 'Terlambat' },
        'izin': { class: 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200', text: 'Izin' },
        'sakit': { class: 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200', text: 'Sakit' },
        'alpha': { class: 'status-rejected', text: 'Alpha' }
    };
    
    return badges[status] || { class: 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200', text: status };
}

// Update student status
function updateStudentStatus(studentIndex, newStatus) {
    if (currentSubmissionData && currentSubmissionData.attendance_data[studentIndex]) {
        currentSubmissionData.attendance_data[studentIndex].status = newStatus;
        updateAttendanceStatistics();
    }
}

// Update student time
function updateStudentTime(studentIndex, newTime) {
    if (currentSubmissionData && currentSubmissionData.attendance_data[studentIndex]) {
        currentSubmissionData.attendance_data[studentIndex].scan_time = newTime;
    }
}

// Update student notes
function updateStudentNotes(studentIndex, newNotes) {
    if (currentSubmissionData && currentSubmissionData.attendance_data[studentIndex]) {
        currentSubmissionData.attendance_data[studentIndex].notes = newNotes;
    }
}

// Update attendance statistics
function updateAttendanceStatistics() {
    if (!currentSubmissionData) return;
    
    const attendanceData = currentSubmissionData.attendance_data;
    let presentCount = 0;
    let lateCount = 0;
    let absentCount = 0;
    
    attendanceData.forEach(student => {
        switch(student.status) {
            case 'hadir':
                presentCount++;
                break;
            case 'terlambat':
                presentCount++;
                lateCount++;
                break;
            case 'alpha':
            case 'izin':
            case 'sakit':
                absentCount++;
                break;
        }
    });
    
    // Update the statistics display in the modal
    const statsContainer = document.querySelector('.modal-content .grid.grid-cols-4');
    if (statsContainer) {
        statsContainer.innerHTML = `
            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-gray-900 dark:text-white">${attendanceData.length}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Total Siswa</div>
            </div>
            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-green-600">${presentCount}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Hadir</div>
            </div>
            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-yellow-600">${lateCount}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Terlambat</div>
            </div>
            <div class="text-center p-4 bg-white dark:bg-gray-700 rounded-lg">
                <div class="text-2xl font-bold text-red-600">${absentCount}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">Tidak Hadir</div>
            </div>
        `;
    }
}

// Save attendance changes
function saveAttendanceChanges(submissionId) {
    if (!currentSubmissionData) {
        alert('❌ Tidak ada data untuk disimpan');
        return;
    }
    
    if (!confirm('💾 Simpan perubahan data absensi?\n\n✅ Perubahan akan disimpan dan statistik diperbarui.')) {
        return;
    }
    
    // Build URL manually like we did for detail and confirm
    const baseUrl = '{{ url("/guru-piket/attendance/submissions") }}';
    const updateUrl = `${baseUrl}/${submissionId}/update`;
    
    console.log('📡 Update URL:', updateUrl);
    
    fetch(updateUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            attendance_data: currentSubmissionData.attendance_data
        })
    })
    .then(response => {
        console.log('📥 Update response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('✅ Update response data:', data);
        
        if (data.success) {
            alert('✅ Perubahan berhasil disimpan!');
            viewSubmissionDetail(submissionId);
        } else {
            console.error('❌ Update API error:', data.message);
            alert('❌ Gagal menyimpan: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('💥 Error saving changes:', error);
        alert('⚠️ Terjadi kesalahan saat menyimpan: ' + error.message);
    });
}

// Reset attendance data
function resetAttendanceData(submissionId) {
    if (!confirm('🔄 Reset data ke kondisi awal?\n\n⚠️ Semua perubahan akan hilang.')) {
        return;
    }
    
    viewSubmissionDetail(submissionId);
    alert('✅ Data berhasil direset');
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
    
    // Build URL manually like we did for detail
    const baseUrl = '{{ url("/guru-piket/attendance/submissions") }}';
    const confirmUrl = `${baseUrl}/${submissionId}/confirm`;
    
    console.log('📡 Confirm URL:', confirmUrl);
    
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
        console.log('📥 Confirm response status:', response.status);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        return response.json();
    })
    .then(data => {
        console.log('✅ Confirm response data:', data);
        
        if (data.success) {
            const actionText = isConfirm ? 'dikonfirmasi' : 'ditolak';
            alert(`✅ Submission berhasil ${actionText}!`);
            closeSubmissionModal();
            refreshSubmissions();
        } else {
            console.error('❌ Confirm API error:', data.message);
            alert('❌ Gagal memproses: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(error => {
        console.error('💥 Error confirming submission:', error);
        alert('⚠️ Terjadi kesalahan saat memproses: ' + error.message);
    });
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    console.log('Submissions page loaded');
    
    // Add smooth animations
    const items = document.querySelectorAll('.submission-item');
    items.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            item.style.transition = 'all 0.5s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush