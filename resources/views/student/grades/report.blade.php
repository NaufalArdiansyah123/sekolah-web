@extends('layouts.student')

@section('content')
<div class="space-y-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 rounded-xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold mb-2">Rapor Akademik 📋</h1>
                <p class="text-green-100 dark:text-green-200">Semester {{ $overallStats['semester'] }} - Tahun Ajaran {{ $overallStats['year'] }}</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-green-200 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-4">
                <!-- Semester Filter -->
                <form method="GET" class="flex space-x-2">
                    <select name="semester" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                        <option value="1" {{ request('semester', $overallStats['semester']) == 1 ? 'selected' : '' }}>Semester 1</option>
                        <option value="2" {{ request('semester', $overallStats['semester']) == 2 ? 'selected' : '' }}>Semester 2</option>
                    </select>
                    
                    <select name="year" class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white" onchange="this.form.submit()">
                        @for($year = now()->year; $year >= now()->year - 3; $year--)
                            <option value="{{ $year }}" {{ request('year', $overallStats['year']) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </form>
            </div>

            <div class="flex space-x-3">
                <a href="{{ route('student.grades.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Lihat Nilai
                </a>
                
                <button onclick="window.print()" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Cetak Rapor
                </button>
            </div>
        </div>
    </div>

    <!-- Student Information -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Siswa</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center">
                    <img class="h-20 w-20 rounded-full" 
                         src="{{ $student->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($student->name).'&color=059669&background=D1FAE5' }}" 
                         alt="{{ $student->name }}">
                    <div class="ml-6">
                        <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $student->name }}</h4>
                        <p class="text-gray-600 dark:text-gray-400">{{ $student->email }}</p>
                        @if($student->student_id)
                            <p class="text-sm text-gray-500 dark:text-gray-400">NIS: {{ $student->student_id }}</p>
                        @endif
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Semester</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $overallStats['semester'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tahun Ajaran</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $overallStats['year'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah Mata Pelajaran</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $overallStats['total_subjects'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Penilaian</label>
                        <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $overallStats['total_assessments'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Statistics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-blue-100 dark:bg-blue-900/50">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Rata-rata Keseluruhan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($overallStats['overall_average'], 1) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-green-100 dark:bg-green-900/50">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Mata Pelajaran</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $overallStats['total_subjects'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-purple-100 dark:bg-purple-900/50">
                    <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Penilaian</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $overallStats['total_assessments'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center">
                <div class="p-3 rounded-lg bg-yellow-100 dark:bg-yellow-900/50">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Grade Keseluruhan</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white">
                        @php
                            $overallGrade = '';
                            if ($overallStats['overall_average'] >= 90) $overallGrade = 'A';
                            elseif ($overallStats['overall_average'] >= 80) $overallGrade = 'B';
                            elseif ($overallStats['overall_average'] >= 70) $overallGrade = 'C';
                            elseif ($overallStats['overall_average'] >= 60) $overallGrade = 'D';
                            else $overallGrade = 'E';
                        @endphp
                        {{ $overallGrade }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Subject Grades Table -->
    @if(!empty($subjectGrades))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Nilai per Mata Pelajaran</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Mata Pelajaran
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tugas
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Kuis
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Ujian
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Total Penilaian
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Rata-rata
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Grade
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($subjectGrades as $subject => $data)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $data['assignments']->count() }}</div>
                                    @if($data['assignments']->count() > 0)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Avg: {{ number_format($data['assignments']->avg('score'), 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $data['quizzes']->count() }}</div>
                                    @if($data['quizzes']->count() > 0)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Avg: {{ number_format($data['quizzes']->avg('score'), 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $data['exams']->count() }}</div>
                                    @if($data['exams']->count() > 0)
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            Avg: {{ number_format($data['exams']->avg('score'), 1) }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $data['count'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ number_format($data['average'], 1) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $grade = '';
                                        $color = '';
                                        if ($data['average'] >= 90) {
                                            $grade = 'A';
                                            $color = 'green';
                                        } elseif ($data['average'] >= 80) {
                                            $grade = 'B';
                                            $color = 'blue';
                                        } elseif ($data['average'] >= 70) {
                                            $grade = 'C';
                                            $color = 'yellow';
                                        } elseif ($data['average'] >= 60) {
                                            $grade = 'D';
                                            $color = 'orange';
                                        } else {
                                            $grade = 'E';
                                            $color = 'red';
                                        }
                                    @endphp
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $color }}-100 text-{{ $color }}-800 dark:bg-{{ $color }}-900 dark:text-{{ $color }}-200">
                                        {{ $grade }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Belum ada data rapor</h3>
                <p class="text-gray-500 dark:text-gray-400">Rapor akan tersedia setelah ada nilai dari tugas atau kuis</p>
            </div>
        </div>
    @endif

    <!-- Performance Analysis -->
    @if(!empty($subjectGrades))
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Analisis Performa</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Best Subjects -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Mata Pelajaran Terbaik</h4>
                        <div class="space-y-2">
                            @php
                                $bestSubjects = collect($subjectGrades)->sortByDesc('average')->take(3);
                            @endphp
                            @foreach($bestSubjects as $subject => $data)
                                <div class="flex items-center justify-between p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject }}</span>
                                    <span class="text-sm font-bold text-green-600 dark:text-green-400">{{ number_format($data['average'], 1) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Subjects Need Improvement -->
                    <div>
                        <h4 class="text-md font-semibold text-gray-900 dark:text-white mb-3">Perlu Peningkatan</h4>
                        <div class="space-y-2">
                            @php
                                $needImprovement = collect($subjectGrades)->sortBy('average')->take(3);
                            @endphp
                            @foreach($needImprovement as $subject => $data)
                                <div class="flex items-center justify-between p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $subject }}</span>
                                    <span class="text-sm font-bold text-orange-600 dark:text-orange-400">{{ number_format($data['average'], 1) }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
<style>
@media print {
    .no-print {
        display: none !important;
    }
    
    body {
        background: white !important;
    }
    
    .bg-gradient-to-r {
        background: #059669 !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endpush
@endsection