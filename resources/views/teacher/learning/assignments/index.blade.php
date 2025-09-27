@extends('layouts.teacher')

@section('content')
<div class="min-h-screen" style="background: var(--bg-primary, #ffffff);">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        📝 Kelola Tugas
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Buat, kelola, dan nilai tugas untuk siswa Anda
                    </p>
                </div>
                
                <div class="mt-6 lg:mt-0">
                    <a href="{{ route('teacher.assignments.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Tugas Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg" style="background: rgba(59, 130, 246, 0.1);">
                        <svg class="w-6 h-6" style="color: var(--text-blue, #2563eb);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Tugas</p>
                        <p class="text-2xl font-semibold" style="color: var(--text-primary, #111827);">{{ $stats['total_assignments'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg" style="background: rgba(16, 185, 129, 0.1);">
                        <svg class="w-6 h-6" style="color: var(--text-green, #059669);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Tugas Aktif</p>
                        <p class="text-2xl font-semibold" style="color: var(--text-primary, #111827);">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg" style="background: rgba(245, 158, 11, 0.1);">
                        <svg class="w-6 h-6" style="color: var(--text-yellow, #d97706);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Draft</p>
                        <p class="text-2xl font-semibold" style="color: var(--text-primary, #111827);">{{ $stats['draft'] }}</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl p-6 shadow-sm border" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                <div class="flex items-center">
                    <div class="p-2 rounded-lg" style="background: rgba(139, 92, 246, 0.1);">
                        <svg class="w-6 h-6" style="color: var(--text-purple, #7c3aed);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium" style="color: var(--text-secondary, #6b7280);">Total Pengumpulan</p>
                        <p class="text-2xl font-semibold" style="color: var(--text-primary, #111827);">{{ $stats['total_submissions'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="rounded-xl shadow-sm border p-6 mb-8" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">Mata Pelajaran</label>
                    <select name="subject" class="w-full rounded-lg border" style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $currentFilters['subject'] == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">Status</label>
                    <select name="status" class="w-full rounded-lg border" style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Semua Status</option>
                        <option value="draft" {{ $currentFilters['status'] == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ $currentFilters['status'] == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="active" {{ $currentFilters['status'] == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ $currentFilters['status'] == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Assignments Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($assignments as $assignment)
                @php
                    // Get students from the specific class assigned to this assignment
                    $totalStudents = 0;
                    if ($assignment->class_id) {
                        $totalStudents = \App\Models\Student::where('class_id', $assignment->class_id)
                            ->where('status', 'active')
                            ->count();
                    } else {
                        // Fallback for assignments without class_id
                        $submittedStudentIds = $assignment->submissions->pluck('student_id')->unique();
                        $totalStudents = $submittedStudentIds->count();
                        if ($totalStudents === 0) {
                            $totalStudents = 0;
                        }
                    }
                    
                    $totalSubmissions = $assignment->submissions->count();
                    $gradedSubmissions = $assignment->submissions->where('graded_at', '!=', null)->count();
                    $submissionPercentage = $totalStudents > 0 ? round(($totalSubmissions / $totalStudents) * 100, 1) : 0;
                    $gradingPercentage = $totalSubmissions > 0 ? round(($gradedSubmissions / $totalSubmissions) * 100, 1) : 0;
                @endphp
                
                <div class="rounded-xl shadow-sm border overflow-hidden hover:shadow-lg transition-shadow" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
                    <!-- Header -->
                    <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-semibold line-clamp-2" style="color: var(--text-primary, #111827);">
                                {{ $assignment->title }}
                            </h3>
                            @php
                                $statusColor = $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red');
                                $statusBg = $statusColor === 'green' ? 'rgba(16, 185, 129, 0.1)' : ($statusColor === 'yellow' ? 'rgba(245, 158, 11, 0.1)' : 'rgba(239, 68, 68, 0.1)');
                                $statusText = $statusColor === 'green' ? '#059669' : ($statusColor === 'yellow' ? '#d97706' : '#dc2626');
                            @endphp
                            <span class="text-xs px-2 py-1 rounded-full" style="background: {{ $statusBg }}; color: {{ $statusText }};">
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                        
                        <p class="text-sm line-clamp-3 mb-4" style="color: var(--text-secondary, #6b7280);">
                            {{ Str::limit($assignment->description, 120) }}
                        </p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center text-sm" style="color: var(--text-secondary, #6b7280);">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $assignment->subject }}
                            </div>
                            
                            <div class="flex items-center text-sm" style="color: {{ $assignment->due_date < now() ? '#dc2626' : 'var(--text-secondary, #6b7280)' }};">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $assignment->due_date->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Section -->
                    <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                        <!-- Submission Progress -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium" style="color: var(--text-primary, #374151);">Pengumpulan</span>
                                <span class="text-sm" style="color: var(--text-secondary, #6b7280);">{{ $totalSubmissions }}/{{ $totalStudents }}</span>
                            </div>
                            <div class="w-full rounded-full h-2" style="background: var(--bg-tertiary, #e5e7eb);">
                                <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: {{ $submissionPercentage }}%"></div>
                            </div>
                            <div class="text-xs mt-1" style="color: var(--text-secondary, #6b7280);">{{ $submissionPercentage }}% siswa mengumpulkan</div>
                        </div>

                        <!-- Grading Progress -->
                        @if($totalSubmissions > 0)
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium" style="color: var(--text-primary, #374151);">Penilaian</span>
                                    <span class="text-sm" style="color: var(--text-secondary, #6b7280);">{{ $gradedSubmissions }}/{{ $totalSubmissions }}</span>
                                </div>
                                <div class="w-full rounded-full h-2" style="background: var(--bg-tertiary, #e5e7eb);">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: {{ $gradingPercentage }}%"></div>
                                </div>
                                <div class="text-xs mt-1" style="color: var(--text-secondary, #6b7280);">{{ $gradingPercentage }}% sudah dinilai</div>
                            </div>
                        @endif

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="rounded-lg p-2" style="background: rgba(59, 130, 246, 0.1);">
                                <div class="text-lg font-bold" style="color: #2563eb;">{{ $totalSubmissions }}</div>
                                <div class="text-xs" style="color: var(--text-secondary, #6b7280);">Terkumpul</div>
                            </div>
                            <div class="rounded-lg p-2" style="background: rgba(16, 185, 129, 0.1);">
                                <div class="text-lg font-bold" style="color: #059669;">{{ $gradedSubmissions }}</div>
                                <div class="text-xs" style="color: var(--text-secondary, #6b7280);">Dinilai</div>
                            </div>
                            <div class="rounded-lg p-2" style="background: rgba(245, 158, 11, 0.1);">
                                <div class="text-lg font-bold" style="color: #d97706;">{{ $totalSubmissions - $gradedSubmissions }}</div>
                                <div class="text-xs" style="color: var(--text-secondary, #6b7280);">Pending</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Footer -->
                    <div class="p-6">
                        <div class="flex space-x-2">
                            <a href="{{ route('teacher.assignments.show', $assignment->id) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                Detail
                            </a>
                            @if($totalSubmissions > 0)
                                <a href="{{ route('teacher.assignments.submissions', $assignment->id) }}" 
                                   class="flex-1 bg-green-600 hover:bg-green-700 text-white text-center py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                    Kelola ({{ $totalSubmissions }})
                                </a>
                            @endif
                            <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12" style="color: var(--text-tertiary, #9ca3af);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium" style="color: var(--text-primary, #111827);">Belum ada tugas</h3>
                        <p class="mt-1 text-sm" style="color: var(--text-secondary, #6b7280);">Mulai dengan membuat tugas pertama Anda.</p>
                        <div class="mt-6">
                            <a href="{{ route('teacher.assignments.create') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Buat Tugas Baru
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($assignments->hasPages())
            <div class="mt-8">
                {{ $assignments->links() }}
            </div>
        @endif
    </div>
</div>
@endsection