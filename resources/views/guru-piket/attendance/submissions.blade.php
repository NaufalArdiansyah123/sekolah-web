@extends('layouts.guru-piket')

@section('title', 'Konfirmasi Absensi Guru')

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
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .dark .submission-item {
        background: #374151;
        border-color: #4b5563;
    }
    
    .submission-item:hover {
        background: #f3f4f6;
        transform: translateY(-1px);
    }
    
    .dark .submission-item:hover {
        background: #4b5563;
    }
    
    .submission-item.pending {
        border-left: 4px solid #f59e0b;
    }
    
    .submission-item.confirmed {
        border-left: 4px solid #10b981;
    }
    
    .submission-item.rejected {
        border-left: 4px solid #ef4444;
    }
    
    .status-badge {
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    
    .dark .status-pending {
        background: #78350f;
        color: #fde68a;
    }
    
    .status-confirmed {
        background: #dcfce7;
        color: #166534;
    }
    
    .dark .status-confirmed {
        background: #14532d;
        color: #bbf7d0;
    }
    
    .status-rejected {
        background: #fee2e2;
        color: #991b1b;
    }
    
    .dark .status-rejected {
        background: #7f1d1d;
        color: #fecaca;
    }
    
    .modal-overlay {
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
    
    .modal-content {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        max-height: 90vh;
        overflow-y: auto;
    }
    
    .dark .modal-content {
        background: #1f2937;
    }
    
    .attendance-detail-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .dark .attendance-detail-item {
        background: #374151;
        border-color: #4b5563;
    }
</style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Konfirmasi Absensi Guru</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Review dan konfirmasi absensi yang dikirim oleh guru</p>
            </div>
            <div class="flex items-center space-x-3">
                @if($pendingCount > 0)
                <div class="bg-yellow-100 dark:bg-yellow-900/20 px-3 py-1 rounded-full">
                    <span class="text-yellow-800 dark:text-yellow-200 text-sm font-medium">{{ $pendingCount }} Menunggu</span>
                </div>
                @endif
                <button onclick="refreshSubmissions()" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-yellow-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Menunggu Konfirmasi</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Dikonfirmasi Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['confirmed_today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-gray-800 dark:bg-white">
                    <svg class="w-6 h-6 text-white dark:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['total_today'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-blue-500">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Guru Mengirim</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $statistics['teachers_submitted'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="submission-card p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tanggal</label>
                <input type="date" id="filterDate" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white" value="{{ date('Y-m-d') }}">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select id="filterStatus" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-gray-500 focus:border-transparent bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="">Semua Status</option>
                    <option value="pending">Menunggu Konfirmasi</option>
                    <option value="confirmed">Dikonfirmasi</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
            <div class="flex items-end">
                <button onclick="applyFilters()" class="w-full bg-gray-900 dark:bg-white text-white dark:text-gray-900 px-4 py-2 rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z"></path>
                    </svg>
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Submissions List -->
    <div class="submission-card">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Submission Absensi</h2>
        </div>
        <div class="p-6">
            <div id="submissionsList">
                @forelse($todaySubmissions as $submission)
                <div class="submission-item {{ strtolower($submission->status) }}" onclick="viewSubmissionDetail({{ $submission->id }})">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $submission->teacher->name }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $submission->class->name ?? 'Kelas tidak ditemukan' }} • {{ $submission->subject }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500">{{ $submission->formatted_session_time }} • {{ \Carbon\Carbon::parse($submission->submission_date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="status-badge status-{{ strtolower($submission->status) }}">
                                {{ $submission->status_text }}
                            </span>
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $submission->present_count }}/{{ $submission->total_students }} hadir ({{ $submission->attendance_percentage }}%)
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                {{ $submission->submitted_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">Belum ada submission absensi hari ini</p>
                </div>
                @endforelse
            </div>
            
            <!-- Load More Button -->
            <div class="mt-6 text-center">
                <button onclick="loadMoreSubmissions()" class="bg-white dark:bg-gray-900 text-gray-900 dark:text-white border border-gray-300 dark:border-gray-600 px-6 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                    Muat Lebih Banyak
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Submission Detail Modal -->
<div id="submissionModal" class="fixed inset-0 z-50 hidden">
    <div class="modal-overlay fixed inset-0" onclick="closeSubmissionModal()"></div>
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="modal-content w-full max-w-4xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Submission Absensi</h2>
                <button onclick="closeSubmissionModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div id="submissionDetailContent">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let isLoading = false;

function applyFilters() {
    currentPage = 1;
    loadSubmissions(true);
}

function refreshSubmissions() {
    currentPage = 1;
    loadSubmissions(true);
}

function loadMoreSubmissions() {
    currentPage++;
    loadSubmissions(false);
}

function loadSubmissions(replace = false) {
    if (isLoading) return;
    
    isLoading = true;
    const date = document.getElementById('filterDate').value;
    const status = document.getElementById('filterStatus').value;
    
    const params = new URLSearchParams({
        page: currentPage,
        date: date,
        status: status
    });
    
    fetch(`{{ route('guru-piket.attendance.submissions.api') }}?${params}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const submissionsList = document.getElementById('submissionsList');
                
                if (replace) {
                    submissionsList.innerHTML = '';
                }
                
                if (data.submissions.length === 0 && replace) {
                    submissionsList.innerHTML = `
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-gray-500 dark:text-gray-400">Tidak ada submission ditemukan</p>
                        </div>
                    `;
                } else {
                    data.submissions.forEach(submission => {
                        const submissionHtml = createSubmissionHtml(submission);
                        submissionsList.insertAdjacentHTML('beforeend', submissionHtml);
                    });
                }
            }
        })
        .catch(error => {
            console.error('Error loading submissions:', error);
        })
        .finally(() => {
            isLoading = false;
        });
}

function createSubmissionHtml(submission) {
    const statusClass = submission.status.toLowerCase();
    const submittedAt = new Date(submission.submitted_at).toLocaleString('id-ID');
    
    return `
        <div class="submission-item ${statusClass}" onclick="viewSubmissionDetail(${submission.id})">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mr-4">
                        <svg class="w-6 h-6 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 dark:text-white">${submission.teacher.name}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">${submission.class ? submission.class.name : 'Kelas tidak ditemukan'} • ${submission.subject}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-500">${submission.session_time} • ${new Date(submission.submission_date).toLocaleDateString('id-ID')}</p>
                    </div>
                </div>
                <div class="text-right">
                    <span class="status-badge status-${statusClass}">
                        ${submission.status_text}
                    </span>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                        ${submission.present_count}/${submission.total_students} hadir (${submission.attendance_percentage}%)
                    </div>
                    <div class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        ${submittedAt}
                    </div>
                </div>
            </div>
        </div>
    `;
}

function viewSubmissionDetail(submissionId) {
    fetch(`{{ route('guru-piket.attendance.submissions.detail', '') }}/${submissionId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSubmissionModal(data.submission);
            }
        })
        .catch(error => {
            console.error('Error loading submission detail:', error);
        });
}

function showSubmissionModal(submission) {
    const modal = document.getElementById('submissionModal');
    const content = document.getElementById('submissionDetailContent');
    
    content.innerHTML = createSubmissionDetailHtml(submission);
    modal.classList.remove('hidden');
}

function closeSubmissionModal() {
    document.getElementById('submissionModal').classList.add('hidden');
}

function createSubmissionDetailHtml(submission) {
    const attendanceData = submission.attendance_data || [];
    const statusClass = submission.status.toLowerCase();
    
    let attendanceHtml = '';
    attendanceData.forEach(student => {
        const statusBadge = getStatusBadge(student.status);
        attendanceHtml += `
            <div class="attendance-detail-item">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">${student.student_name}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">NIS: ${student.nis}</p>
                    </div>
                    <div class="text-right">
                        <span class="status-badge ${statusBadge.class}">${statusBadge.text}</span>
                        ${student.scan_time ? `<p class="text-xs text-gray-500 dark:text-gray-500 mt-1">${student.scan_time}</p>` : ''}
                    </div>
                </div>
                ${student.notes ? `<p class="text-sm text-gray-600 dark:text-gray-400 mt-2">${student.notes}</p>` : ''}
            </div>
        `;
    });
    
    const actionButtons = submission.status === 'pending' ? `
        <div class="flex space-x-3">
            <button onclick="confirmSubmission(${submission.id}, 'confirm')" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Konfirmasi
            </button>
            <button onclick="confirmSubmission(${submission.id}, 'reject')" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition-colors">
                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                Tolak
            </button>
        </div>
    ` : '';
    
    return `
        <div class="space-y-6">
            <!-- Submission Info -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Guru</p>
                        <p class="font-semibold text-gray-900 dark:text-white">${submission.teacher.name}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Kelas</p>
                        <p class="font-semibold text-gray-900 dark:text-white">${submission.class ? submission.class.name : 'Kelas tidak ditemukan'}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Mata Pelajaran</p>
                        <p class="font-semibold text-gray-900 dark:text-white">${submission.subject}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Waktu Sesi</p>
                        <p class="font-semibold text-gray-900 dark:text-white">${submission.session_time}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tanggal</p>
                        <p class="font-semibold text-gray-900 dark:text-white">${new Date(submission.submission_date).toLocaleDateString('id-ID')}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                        <span class="status-badge status-${statusClass}">${submission.status_text}</span>
                    </div>
                </div>
                
                <!-- Statistics -->
                <div class="mt-4 grid grid-cols-4 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">${submission.total_students}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Total Siswa</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-green-600">${submission.present_count}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Hadir</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-yellow-600">${submission.late_count}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Terlambat</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-red-600">${submission.absent_count}</p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Tidak Hadir</p>
                    </div>
                </div>
            </div>
            
            <!-- Attendance Details -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Detail Kehadiran Siswa</h3>
                <div class="max-h-60 overflow-y-auto">
                    ${attendanceHtml}
                </div>
            </div>
            
            <!-- Notes -->
            ${submission.notes ? `
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Catatan</h3>
                    <p class="text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">${submission.notes}</p>
                </div>
            ` : ''}
            
            <!-- Action Buttons -->
            <div class="flex justify-end">
                ${actionButtons}
            </div>
        </div>
    `;
}

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

function confirmSubmission(submissionId, action) {
    const notes = prompt(action === 'confirm' ? 'Catatan konfirmasi (opsional):' : 'Alasan penolakan:');
    
    if (action === 'reject' && !notes) {
        alert('Alasan penolakan harus diisi');
        return;
    }
    
    fetch(`{{ route('guru-piket.attendance.submissions.confirm', '') }}/${submissionId}`, {
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
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeSubmissionModal();
            refreshSubmissions();
        } else {
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error confirming submission:', error);
        alert('Terjadi kesalahan saat memproses konfirmasi');
    });
}

// Load initial data
document.addEventListener('DOMContentLoaded', function() {
    loadSubmissions(true);
});
</script>
@endpush