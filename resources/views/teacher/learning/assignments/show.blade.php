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
                        📝 Detail Tugas
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ $assignment->title }} • {{ $assignment->subject }}
                    </p>
                </div>
                
                <div class="mt-6 lg:mt-0 flex space-x-3">
                    <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Lihat Pengumpulan
                    </a>
                    <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" 
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Edit Tugas
                    </a>
                    <a href="{{ route('teacher.assignments.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Assignment Details -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-8">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between mb-4">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                                {{ $assignment->title }}
                            </h2>
                            <span class="bg-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-100 text-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-800 dark:bg-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-900 dark:text-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-200 px-3 py-1 rounded-full text-sm font-medium">
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $assignment->subject }}
                            </div>
                            
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                {{ $assignment->class ?? 'Semua Kelas' }}
                            </div>
                            
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                {{ ucfirst($assignment->type) }}
                            </div>
                            
                            <div class="flex items-center {{ $assignment->due_date < now() ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $assignment->due_date->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Deskripsi Tugas</h3>
                        <div class="prose dark:prose-invert max-w-none mb-6">
                            {!! nl2br(e($assignment->description)) !!}
                        </div>
                        
                        @if($assignment->instructions)
                            <div class="mb-6">
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Instruksi</h4>
                                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                    <div class="prose dark:prose-invert max-w-none text-sm">
                                        {!! nl2br(e($assignment->instructions)) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if($assignment->attachment_path)
                            <div>
                                <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">File Lampiran</h4>
                                <a href="{{ Storage::url($assignment->attachment_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $assignment->attachment_name ?? 'Download File' }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Submission Overview -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Ringkasan Pengumpulan</h2>
                            <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}" 
                               class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <!-- Progress Overview -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress Pengumpulan</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $submissionStats['submitted'] }}/{{ $submissionStats['total_students'] }} siswa
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-blue-500 to-green-500 h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ $submissionStats['submission_percentage'] }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mt-1">
                                <span>{{ $submissionStats['submission_percentage'] }}% terkumpul</span>
                                <span>{{ $submissionStats['pending'] }} belum mengumpulkan</span>
                            </div>
                        </div>

                        <!-- Grading Progress -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Progress Penilaian</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $submissionStats['graded'] }}/{{ $submissionStats['submitted'] }} dinilai
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                                <div class="bg-gradient-to-r from-purple-500 to-pink-500 h-3 rounded-full transition-all duration-500" 
                                     style="width: {{ $submissionStats['grading_percentage'] }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mt-1">
                                <span>{{ $submissionStats['grading_percentage'] }}% dinilai</span>
                                <span>{{ $submissionStats['ungraded'] }} belum dinilai</span>
                            </div>
                        </div>

                        <!-- Statistics Grid -->
                        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $submissionStats['submitted'] }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Terkumpul</div>
                            </div>
                            <div class="text-center p-4 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $submissionStats['graded'] }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Dinilai</div>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $submissionStats['ungraded'] }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Belum Dinilai</div>
                            </div>
                            <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                                <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ round($submissionStats['average_score'], 1) }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Rata-rata</div>
                            </div>
                        </div>

                        <!-- Recent Submissions -->
                        @if($recentSubmissions->count() > 0)
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Pengumpulan Terbaru</h3>
                                <div class="space-y-3">
                                    @foreach($recentSubmissions as $submission)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex items-center">
                                                <img class="h-8 w-8 rounded-full" 
                                                     src="{{ $submission->student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($submission->student->name).'&color=7C3AED&background=EDE9FE' }}" 
                                                     alt="{{ $submission->student->name }}">
                                                <div class="ml-3">
                                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                                        {{ $submission->student->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                                        {{ $submission->submitted_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @if($submission->graded_at)
                                                    <span class="text-xs bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 px-2 py-1 rounded">
                                                        {{ $submission->score }}/{{ $assignment->max_score }}
                                                    </span>
                                                @else
                                                    <span class="text-xs bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200 px-2 py-1 rounded">
                                                        Belum dinilai
                                                    </span>
                                                @endif
                                                <a href="{{ route('teacher.assignments.grade', [$assignment->id, $submission->id]) }}" 
                                                   class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                                    {{ $submission->graded_at ? 'Edit' : 'Nilai' }}
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Assignment Info -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Tugas</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Nilai Maksimal:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->max_score }} poin</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Siswa:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $submissionStats['total_students'] }} siswa</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Dibuat pada:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->created_at->format('d M Y') }}</div>
                        </div>
                        
                        <div>
                            <span class="text-sm text-gray-600 dark:text-gray-400">Deadline:</span>
                            <div class="font-medium text-gray-900 dark:text-white">{{ $assignment->due_date->format('d M Y, H:i') }}</div>
                        </div>
                        
                        @if($assignment->due_date < now())
                            <div class="p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
                                <div class="text-sm text-red-800 dark:text-red-200 font-medium">
                                    Deadline terlewat {{ $assignment->due_date->diffForHumans() }}
                                </div>
                            </div>
                        @else
                            <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                <div class="text-sm text-blue-800 dark:text-blue-200 font-medium">
                                    Deadline {{ $assignment->due_date->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors block">
                            Kelola Pengumpulan
                        </a>
                        
                        <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" 
                           class="w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors block">
                            Edit Tugas
                        </a>
                        
                        @if($submissionStats['ungraded'] > 0)
                            <button onclick="window.location.href='{{ route('teacher.assignments.submissions', $assignment->id) }}?grading_status=ungraded'" 
                                    class="w-full bg-purple-600 hover:bg-purple-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors">
                                Nilai Tugas ({{ $submissionStats['ungraded'] }})
                            </button>
                        @endif
                        
                        <button onclick="confirmDelete()" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded-lg font-medium transition-colors">
                            Hapus Tugas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900">
                <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">Hapus Tugas</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Apakah Anda yakin ingin menghapus tugas ini? Semua data pengumpulan dan nilai akan ikut terhapus. Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="items-center px-4 py-3">
                <form action="{{ route('teacher.assignments.destroy', $assignment->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300 mr-2">
                        Ya, Hapus
                    </button>
                </form>
                <button onclick="closeDeleteModal()" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Auto-refresh statistics every 30 seconds
setInterval(function() {
    fetch(window.location.href, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        // Update statistics
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        
        // Update progress bars
        const newSubmissionProgress = doc.querySelector('.bg-gradient-to-r.from-blue-500');
        const currentSubmissionProgress = document.querySelector('.bg-gradient-to-r.from-blue-500');
        
        if (newSubmissionProgress && currentSubmissionProgress) {
            currentSubmissionProgress.style.width = newSubmissionProgress.style.width;
        }
        
        const newGradingProgress = doc.querySelector('.bg-gradient-to-r.from-purple-500');
        const currentGradingProgress = document.querySelector('.bg-gradient-to-r.from-purple-500');
        
        if (newGradingProgress && currentGradingProgress) {
            currentGradingProgress.style.width = newGradingProgress.style.width;
        }
    })
    .catch(error => console.log('Auto-refresh error:', error));
}, 30000);
</script>
@endsection