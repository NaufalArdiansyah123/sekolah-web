@extends('layouts.teacher')

@push('scripts')
<script src="{{ asset('js/assignment-realtime.js') }}"></script>
@endpush

@section('content')
<div class="teacher-page">
<div class="min-h-screen" style="background: var(--bg-primary, #ffffff);">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary, #111827);">
                        📝 Pengumpulan Tugas
                    </h1>
                    <p style="color: var(--text-secondary, #6b7280);">
                        {{ $assignment->title }} • {{ $assignment->subject }}
                    </p>
                </div>
                
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('teacher.assignments.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Kembali ke Daftar Tugas
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress Overview -->
        <div class="rounded-xl shadow-sm border p-6 mb-8" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold" style="color: var(--text-primary, #111827);">Progress Penilaian</h2>
                <span class="text-2xl font-bold" style="color: #2563eb;">{{ $stats['progress_percentage'] }}%</span>
            </div>
            
            <!-- Progress Bar -->
            <div class="w-full rounded-full h-4 mb-4" style="background: var(--bg-tertiary, #e5e7eb);">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-4 rounded-full transition-all duration-500 ease-out" 
                     style="width: {{ $stats['progress_percentage'] }}%"></div>
            </div>
            
            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold" style="color: var(--text-primary, #111827);">{{ $stats['total_submissions'] }}</div>
                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Total Pengumpulan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold" style="color: #059669;">{{ $stats['graded'] }}</div>
                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Sudah Dinilai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold" style="color: #dc2626;">{{ $stats['ungraded'] }}</div>
                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Belum Dinilai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold" style="color: #7c3aed;">{{ round($stats['average_score'], 1) }}</div>
                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Rata-rata Nilai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold" style="color: #2563eb;">{{ $assignment->max_score }}</div>
                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">Nilai Maksimal</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-xl shadow-sm border p-6 mb-8" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">Status Penilaian</label>
                    <select name="grading_status" class="w-full rounded-lg border px-3 py-2" style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Semua Status</option>
                        <option value="graded" {{ $currentFilters['grading_status'] == 'graded' ? 'selected' : '' }}>Sudah Dinilai</option>
                        <option value="ungraded" {{ $currentFilters['grading_status'] == 'ungraded' ? 'selected' : '' }}>Belum Dinilai</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Submissions List -->
        <div class="rounded-xl shadow-sm border overflow-hidden" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold" style="color: var(--text-primary, #111827);">Daftar Pengumpulan</h2>
                    @if($stats['ungraded'] > 0)
                        <button onclick="openBulkGradeModal()" 
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Nilai Massal
                        </button>
                    @endif
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead style="background: var(--bg-tertiary, #f9fafb);">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Waktu Pengumpulan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Nilai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider" style="color: var(--text-secondary, #6b7280);">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                        @forelse($submissions as $submission)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <img class="h-10 w-10 rounded-full" 
                                                 src="{{ $submission->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($submission->student->name).'&color=7C3AED&background=EDE9FE' }}" 
                                                 alt="{{ $submission->student->name }}">
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                                                {{ $submission->student->name }}
                                            </div>
                                            <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                                {{ $submission->student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm" style="color: var(--text-primary, #111827);">
                                        {{ $submission->submitted_at->format('d M Y') }}
                                    </div>
                                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                        {{ $submission->submitted_at->format('H:i') }}
                                        @if($submission->submitted_at > $assignment->due_date)
                                            <span style="color: #dc2626;">(Terlambat)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($submission->graded_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(16, 185, 129, 0.1); color: #059669;">
                                            Sudah Dinilai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background: rgba(245, 158, 11, 0.1); color: #d97706;">
                                            Belum Dinilai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($submission->score !== null)
                                        <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">
                                            {{ $submission->score }}/{{ $assignment->max_score }}
                                        </div>
                                        <div class="text-sm" style="color: var(--text-secondary, #6b7280);">
                                            ({{ round(($submission->score / $assignment->max_score) * 100, 1) }}%)
                                        </div>
                                    @else
                                        <span style="color: var(--text-tertiary, #9ca3af);">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('teacher.assignments.grade', [$assignment->id, $submission->id]) }}" 
                                       class="mr-3" style="color: #2563eb;"
                                       onmouseover="this.style.color='#1d4ed8'"
                                       onmouseout="this.style.color='#2563eb'">
                                        {{ $submission->graded_at ? 'Edit Nilai' : 'Beri Nilai' }}
                                    </a>
                                    @if($submission->file_path)
                                        <a href="{{ Storage::url($submission->file_path) }}" 
                                           target="_blank"
                                           style="color: #059669;"
                                           onmouseover="this.style.color='#047857'"
                                           onmouseout="this.style.color='#059669'">
                                            Download
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div style="color: var(--text-secondary, #6b7280);">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Belum ada pengumpulan</p>
                                        <p class="text-sm">Siswa belum mengumpulkan tugas ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($submissions->hasPages())
                <div class="px-6 py-4 border-t" style="border-color: var(--border-color, #e5e7eb);">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Grade Modal -->
<div id="bulkGradeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium" style="color: var(--text-primary, #111827);">Penilaian Massal</h3>
                <button onclick="closeBulkGradeModal()" style="color: var(--text-tertiary, #9ca3af);"
                        onmouseover="this.style.color='var(--text-secondary, #6b7280)'"
                        onmouseout="this.style.color='var(--text-tertiary, #9ca3af)'">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="bulkGradeForm" action="{{ route('teacher.assignments.bulk-grade', $assignment->id) }}" method="POST">
                @csrf
                <div class="max-h-96 overflow-y-auto">
                    <table class="w-full">
                        <thead class="sticky top-0" style="background: var(--bg-tertiary, #f9fafb);">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase" style="color: var(--text-secondary, #6b7280);">Siswa</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase" style="color: var(--text-secondary, #6b7280);">Nilai</th>
                                <th class="px-4 py-2 text-left text-xs font-medium uppercase" style="color: var(--text-secondary, #6b7280);">Feedback</th>
                            </tr>
                        </thead>
                        <tbody id="bulkGradeTableBody">
                            <!-- Will be populated by JavaScript -->
                        </tbody>
                    </table>
                </div>
                
                <div class="flex justify-end mt-4 space-x-3">
                    <button type="button" onclick="closeBulkGradeModal()" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Simpan Semua Nilai
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openBulkGradeModal() {
    // Get ungraded submissions
    const ungradedSubmissions = @json($submissions->where('graded_at', null)->values());
    const maxScore = {{ $assignment->max_score }};
    
    const tableBody = document.getElementById('bulkGradeTableBody');
    tableBody.innerHTML = '';
    
    ungradedSubmissions.forEach((submission, index) => {
        const row = `
            <tr class="border-b" style="border-color: var(--border-color, #e5e7eb);">
                <td class="px-4 py-2">
                    <input type="hidden" name="submissions[${index}][id]" value="${submission.id}">
                    <div class="text-sm font-medium" style="color: var(--text-primary, #111827);">${submission.student.name}</div>
                    <div class="text-sm" style="color: var(--text-secondary, #6b7280);">${submission.student.email}</div>
                </td>
                <td class="px-4 py-2">
                    <input type="number" 
                           name="submissions[${index}][score]" 
                           min="0" 
                           max="${maxScore}" 
                           step="0.1"
                           class="w-20 rounded border px-2 py-1" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="0-${maxScore}">
                </td>
                <td class="px-4 py-2">
                    <textarea name="submissions[${index}][feedback]" 
                              rows="2" 
                              class="w-full rounded border px-2 py-1" 
                              style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                              placeholder="Feedback untuk siswa..."></textarea>
                </td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
    
    document.getElementById('bulkGradeModal').classList.remove('hidden');
}

function closeBulkGradeModal() {
    document.getElementById('bulkGradeModal').classList.add('hidden');
}

// Auto-refresh progress every 30 seconds
setInterval(function() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Update progress bar and stats
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newProgressBar = doc.querySelector('.bg-gradient-to-r');
        const currentProgressBar = document.querySelector('.bg-gradient-to-r');
        
        if (newProgressBar && currentProgressBar) {
            currentProgressBar.style.width = newProgressBar.style.width;
        }
    })
    .catch(error => console.log('Auto-refresh error:', error));
}, 30000);
</script>
</div>
@endsection