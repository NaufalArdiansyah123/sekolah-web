@extends('layouts.teacher')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
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
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tugas</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_assignments'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 dark:bg-green-900 rounded-lg">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Tugas Aktif</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-yellow-100 dark:bg-yellow-900 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Draft</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['draft'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 dark:bg-purple-900 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Pengumpulan</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $stats['total_submissions'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-8">
            <form method="GET" class="flex flex-col lg:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mata Pelajaran</label>
                    <select name="subject" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="">Semua Mata Pelajaran</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject }}" {{ $currentFilters['subject'] == $subject ? 'selected' : '' }}>
                                {{ $subject }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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
                    $totalStudents = \App\Models\User::role('student')->count();
                    $totalSubmissions = $assignment->submissions->count();
                    $gradedSubmissions = $assignment->submissions->where('graded_at', '!=', null)->count();
                    $submissionPercentage = $totalStudents > 0 ? round(($totalSubmissions / $totalStudents) * 100, 1) : 0;
                    $gradingPercentage = $totalSubmissions > 0 ? round(($gradedSubmissions / $totalSubmissions) * 100, 1) : 0;
                @endphp
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-lg transition-shadow">
                    <!-- Header -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white line-clamp-2">
                                {{ $assignment->title }}
                            </h3>
                            <span class="bg-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-100 text-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-800 dark:bg-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-900 dark:text-{{ $assignment->status === 'published' || $assignment->status === 'active' ? 'green' : ($assignment->status === 'draft' ? 'yellow' : 'red') }}-200 text-xs px-2 py-1 rounded-full">
                                {{ ucfirst($assignment->status) }}
                            </span>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-3 mb-4">
                            {{ Str::limit($assignment->description, 120) }}
                        </p>
                        
                        <div class="space-y-2">
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $assignment->subject }}
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                {{ $assignment->class ?? 'Semua Kelas' }}
                            </div>
                            
                            <div class="flex items-center text-sm {{ $assignment->due_date < now() ? 'text-red-600 dark:text-red-400' : 'text-gray-600 dark:text-gray-400' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $assignment->due_date->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Section -->
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <!-- Submission Progress -->
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Pengumpulan</span>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $totalSubmissions }}/{{ $totalStudents }}</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full transition-all duration-300" style="width: {{ $submissionPercentage }}%"></div>
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $submissionPercentage }}% siswa mengumpulkan</div>
                        </div>

                        <!-- Grading Progress -->
                        @if($totalSubmissions > 0)
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Penilaian</span>
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $gradedSubmissions }}/{{ $totalSubmissions }}</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full transition-all duration-300" style="width: {{ $gradingPercentage }}%"></div>
                                </div>
                                <div class="text-xs text-gray-600 dark:text-gray-400 mt-1">{{ $gradingPercentage }}% sudah dinilai</div>
                            </div>
                        @endif

                        <!-- Quick Stats -->
                        <div class="grid grid-cols-3 gap-2 text-center">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-2">
                                <div class="text-lg font-bold text-blue-600 dark:text-blue-400">{{ $totalSubmissions }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Terkumpul</div>
                            </div>
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-2">
                                <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $gradedSubmissions }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Dinilai</div>
                            </div>
                            <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-2">
                                <div class="text-lg font-bold text-yellow-600 dark:text-yellow-400">{{ $totalSubmissions - $gradedSubmissions }}</div>
                                <div class="text-xs text-gray-600 dark:text-gray-400">Pending</div>
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
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Belum ada tugas</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mulai dengan membuat tugas pertama Anda.</p>
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