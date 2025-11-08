@extends('layouts.admin')

@section('title', 'Jadwal Guru')

@section('content')
<style>
/* Minimal Monochrome Styling */
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f7f7f7;
    --bg-tertiary: #efefef;
    --text-primary: #111111;
    --text-secondary: #555555;
    --border-color: #dddddd;
    --accent-color: #222222;
}

.qr-container {
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    min-height: 100vh;
    padding: 1.5rem;
}

.qr-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    color: var(--text-primary);
}

.qr-header {
    background-color: var(--bg-tertiary);
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.stat-card {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    border-radius: 0.5rem;
    padding: 1rem;
}

.stat-icon {
    background-color: var(--bg-tertiary);
    padding: 0.75rem;
    border-radius: 0.5rem;
}

.btn-primary {
    background-color: var(--accent-color);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid var(--accent-color);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-primary:hover {
    filter: brightness(1.1);
    color: white;
    text-decoration: none;
}

.btn-secondary {
    background-color: var(--bg-tertiary);
    color: var(--text-primary);
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid var(--border-color);
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    display: inline-block;
}

.btn-secondary:hover {
    background-color: var(--border-color);
    color: var(--text-primary);
    text-decoration: none;
}

.form-input {
    background-color: var(--bg-primary);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 0.5rem 0.75rem;
    border-radius: 0.375rem;
    width: 100%;
}

.form-input:focus {
    outline: none;
    border-color: #999;
}

.table-row:hover {
    background-color: var(--bg-tertiary);
}

.status-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 500;
    border: 1px solid var(--border-color);
}
</style>

<div class="qr-container">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary)">
                    Jadwal Guru
                </h1>
                <p class="text-sm mt-1" style="color: var(--text-secondary)">
                    Kelola jadwal mengajar guru
                </p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.teacher-schedules.create') }}" class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>Tambah Jadwal
                </a>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Total Guru</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $teachers->count() }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Total Jadwal</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $schedules->total() }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Jadwal Aktif</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $schedules->where('is_active', true)->count() }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-check-circle" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium" style="color: var(--text-secondary)">Total Kelas</p>
                        <p class="text-xl font-bold mt-1" style="color: var(--text-primary)">{{ $classes->count() }}</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-school" style="color: var(--text-secondary)"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="qr-card mb-6">
        <div class="qr-header">
            <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                <i class="fas fa-filter mr-2"></i>Filter Data Jadwal
            </h3>
        </div>
        <div class="p-4">
            <form method="GET" action="{{ route('admin.teacher-schedules.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Guru</label>
                        <select name="teacher_id" class="form-input">
                            <option value="">Semua Guru</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                    {{ $teacher->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Kelas</label>
                        <select name="class_id" class="form-input">
                            <option value="">Semua Kelas</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-2" style="color: var(--text-secondary)">Hari</label>
                        <select name="day_of_week" class="form-input">
                            <option value="">Semua Hari</option>
                            <option value="monday" {{ request('day_of_week') == 'monday' ? 'selected' : '' }}>Senin</option>
                            <option value="tuesday" {{ request('day_of_week') == 'tuesday' ? 'selected' : '' }}>Selasa</option>
                            <option value="wednesday" {{ request('day_of_week') == 'wednesday' ? 'selected' : '' }}>Rabu</option>
                            <option value="thursday" {{ request('day_of_week') == 'thursday' ? 'selected' : '' }}>Kamis</option>
                            <option value="friday" {{ request('day_of_week') == 'friday' ? 'selected' : '' }}>Jumat</option>
                            <option value="saturday" {{ request('day_of_week') == 'saturday' ? 'selected' : '' }}>Sabtu</option>
                            <option value="sunday" {{ request('day_of_week') == 'sunday' ? 'selected' : '' }}>Minggu</option>
                        </select>
                    </div>
                    <div class="flex items-end gap-2">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                        <a href="{{ route('admin.teacher-schedules.index') }}" class="btn-secondary">
                            <i class="fas fa-undo mr-2"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Schedules Table -->
    <div class="qr-card">
        <div class="qr-header">
            <h3 class="text-sm font-semibold" style="color: var(--text-primary)">
                <i class="fas fa-table mr-2"></i>Data Jadwal Guru
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr style="border-bottom: 1px solid var(--border-color)">
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">GURU</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">KELAS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">MATA PELAJARAN</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">HARI</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">WAKTU</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">RUANGAN</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">TAHUN AKADEMIK</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">STATUS</th>
                        <th class="px-4 py-3 text-left text-xs font-medium" style="color: var(--text-secondary)">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr class="table-row" style="border-bottom: 1px solid var(--border-color)">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-xs font-bold" style="background-color: var(--accent-color)">
                                        {{ substr($schedule->teacher->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium" style="color: var(--text-primary)">{{ $schedule->teacher->name }}</div>
                                        <div class="text-xs" style="color: var(--text-secondary)">{{ $schedule->teacher->nip }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $schedule->class->name }}</td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $schedule->subject->name }}</td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $schedule->day_name }}</td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $schedule->time_range }}</td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $schedule->room ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm" style="color: var(--text-primary)">{{ $schedule->academicYear->year }}</td>
                            <td class="px-4 py-3">
                                <span class="status-badge" style="background-color: {{ $schedule->is_active ? 'var(--bg-tertiary)' : '#fee2e2' }}; color: {{ $schedule->is_active ? 'var(--text-primary)' : '#dc2626' }}">
                                    {{ $schedule->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.teacher-schedules.show', $schedule) }}" class="btn-secondary !py-1 !px-2" title="Lihat">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.teacher-schedules.edit', $schedule) }}" class="btn-secondary !py-1 !px-2" title="Edit">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.teacher-schedules.destroy', $schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary !py-1 !px-2" title="Hapus" style="background-color: #fee2e2; color: #dc2626;">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.teacher-schedules.toggle-status', $schedule) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn-secondary !py-1 !px-2" title="{{ $schedule->is_active ? 'Nonaktifkan' : 'Aktifkan' }}">
                                            <i class="fas fa-{{ $schedule->is_active ? 'times' : 'check' }} text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center">
                                <i class="fas fa-calendar-times text-3xl mb-3" style="color: var(--text-secondary); opacity: 0.5"></i>
                                <p class="text-sm" style="color: var(--text-secondary)">Tidak ada data jadwal guru</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="p-4 border-t" style="border-color: var(--border-color)">
                {{ $schedules->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filter functionality
    $('select[name="teacher_id"], select[name="class_id"], select[name="day_of_week"]').change(function() {
        const params = new URLSearchParams(window.location.search);

        // Update or remove parameters
        const teacherId = $('select[name="teacher_id"]').val();
        const classId = $('select[name="class_id"]').val();
        const day = $('select[name="day_of_week"]').val();

        if (teacherId) params.set('teacher_id', teacherId); else params.delete('teacher_id');
        if (classId) params.set('class_id', classId); else params.delete('class_id');
        if (day) params.set('day_of_week', day); else params.delete('day_of_week');

        // Reset page
        params.delete('page');

        // Redirect with new filters
        window.location.href = '?' + params.toString();
    });
});
</script>
@endsection
