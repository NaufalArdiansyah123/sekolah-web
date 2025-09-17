@extends('layouts.teacher')

@push('scripts')
<script src="{{ asset('js/assignment-realtime.js') }}"></script>
@endpush

@section('content')
<div class="teacher-page">
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        📝 Pengumpulan Tugas
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Progress Penilaian</h2>
                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['progress_percentage'] }}%</span>
            </div>
            
            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4 mb-4">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 h-4 rounded-full transition-all duration-500 ease-out" 
                     style="width: {{ $stats['progress_percentage'] }}%"></div>
            </div>
            
            <!-- Statistics Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['total_submissions'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Total Pengumpulan</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['graded'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Sudah Dinilai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['ungraded'] }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Belum Dinilai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ round($stats['average_score'], 1) }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Nilai</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $assignment->max_score }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Nilai Maksimal</div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status Penilaian</label>
                    <select name="grading_status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Daftar Pengumpulan</h2>
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
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Siswa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Waktu Pengumpulan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Nilai
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
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
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                {{ $submission->student->name }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $submission->student->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ $submission->submitted_at->format('d M Y') }}
                                    </div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $submission->submitted_at->format('H:i') }}
                                        @if($submission->submitted_at > $assignment->due_date)
                                            <span class="text-red-500">(Terlambat)</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($submission->graded_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                            Sudah Dinilai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                            Belum Dinilai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($submission->score !== null)
                                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $submission->score }}/{{ $assignment->max_score }}
                                        </div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            ({{ round(($submission->score / $assignment->max_score) * 100, 1) }}%)
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('teacher.assignments.grade', [$assignment->id, $submission->id]) }}" 
                                       class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                        {{ $submission->graded_at ? 'Edit Nilai' : 'Beri Nilai' }}
                                    </a>
                                    @if($submission->file_path)
                                        <a href="{{ Storage::url($submission->file_path) }}" 
                                           target="_blank"
                                           class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300">
                                            Download
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-gray-500 dark:text-gray-400">
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
                <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                    {{ $submissions->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Grade Modal -->
<div id="bulkGradeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 max-w-4xl shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Penilaian Massal</h3>
                <button onclick="closeBulkGradeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <form id="bulkGradeForm" action="{{ route('teacher.assignments.bulk-grade', $assignment->id) }}" method="POST">
                @csrf
                <div class="max-h-96 overflow-y-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Siswa</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nilai</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Feedback</th>
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
            <tr class="border-b border-gray-200 dark:border-gray-700">
                <td class="px-4 py-2">
                    <input type="hidden" name="submissions[${index}][id]" value="${submission.id}">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">${submission.student.name}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">${submission.student.email}</div>
                </td>
                <td class="px-4 py-2">
                    <input type="number" 
                           name="submissions[${index}][score]" 
                           min="0" 
                           max="${maxScore}" 
                           step="0.1"
                           class="w-20 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
                           placeholder="0-${maxScore}">
                </td>
                <td class="px-4 py-2">
                    <textarea name="submissions[${index}][feedback]" 
                              rows="2" 
                              class="w-full rounded border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"
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