@extends('layouts.teacher')

@section('content')
<div class="min-h-screen" style="background: var(--bg-primary, #ffffff);">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary, #111827);">
                        📝 Edit Tugas
                    </h1>
                    <p style="color: var(--text-secondary, #6b7280);">
                        Edit tugas: {{ $assignment->title }}
                    </p>
                </div>
                
                <div class="mt-6 lg:mt-0 flex space-x-3">
                    <a href="{{ route('teacher.assignments.show', $assignment->id) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Lihat Detail
                    </a>
                    <a href="{{ route('teacher.assignments.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="rounded-xl shadow-sm border overflow-hidden" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <form action="{{ route('teacher.assignments.update', $assignment->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                    <h2 class="text-xl font-semibold" style="color: var(--text-primary, #111827);">Edit Informasi Tugas</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Judul Tugas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $assignment->title) }}"
                               class="w-full rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               placeholder="Masukkan judul tugas..."
                               required>
                        @error('title')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Subject, Class, and Type -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="subject" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Mata Pelajaran <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="subject" 
                                   id="subject" 
                                   value="{{ old('subject', $assignment->subject) }}"
                                   class="w-full rounded-lg border px-3 py-2" 
                                   style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                   placeholder="Contoh: Matematika"
                                   required>
                            @error('subject')
                                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="class_id" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Kelas <span class="text-red-500">*</span>
                            </label>
                            <select name="class_id" 
                                    id="class_id" 
                                    class="w-full rounded-lg border px-3 py-2" 
                                    style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                    required>
                                <option value="">Pilih Kelas</option>
                                @foreach($classes as $class)
                                    <option value="{{ $class->id }}" {{ old('class_id', $assignment->class_id) == $class->id ? 'selected' : '' }}>
                                        {{ $class->name }} ({{ $class->level }} {{ $class->program }})
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1 text-sm" style="color: var(--text-secondary, #6b7280);">
                                Tugas hanya akan terlihat oleh siswa di kelas yang dipilih
                            </p>
                            @error('class_id')
                                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="type" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Tipe Tugas <span class="text-red-500">*</span>
                            </label>
                            <select name="type" 
                                    id="type" 
                                    class="w-full rounded-lg border px-3 py-2" 
                                    style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                    required>
                                <option value="">Pilih Tipe</option>
                                <option value="homework" {{ old('type', $assignment->type) == 'homework' ? 'selected' : '' }}>Pekerjaan Rumah</option>
                                <option value="project" {{ old('type', $assignment->type) == 'project' ? 'selected' : '' }}>Proyek</option>
                                <option value="essay" {{ old('type', $assignment->type) == 'essay' ? 'selected' : '' }}>Esai</option>
                                <option value="quiz" {{ old('type', $assignment->type) == 'quiz' ? 'selected' : '' }}>Kuis</option>
                                <option value="presentation" {{ old('type', $assignment->type) == 'presentation' ? 'selected' : '' }}>Presentasi</option>
                            </select>
                            @error('type')
                                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Deskripsi Tugas <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="w-full rounded-lg border px-3 py-2" 
                                  style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                  placeholder="Jelaskan tugas yang akan diberikan..."
                                  required>{{ old('description', $assignment->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instructions -->
                    <div>
                        <label for="instructions" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Instruksi Khusus (Opsional)
                        </label>
                        <textarea name="instructions" 
                                  id="instructions" 
                                  rows="3" 
                                  class="w-full rounded-lg border px-3 py-2" 
                                  style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                  placeholder="Berikan instruksi khusus jika diperlukan...">{{ old('instructions', $assignment->instructions) }}</textarea>
                        @error('instructions')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Due Date and Max Score -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="due_date" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Batas Waktu <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" 
                                   name="due_date" 
                                   id="due_date" 
                                   value="{{ old('due_date', $assignment->due_date->format('Y-m-d\TH:i')) }}"
                                   class="w-full rounded-lg border px-3 py-2" 
                                   style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                   required>
                            @error('due_date')
                                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="max_score" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                                Nilai Maksimal <span class="text-red-500">*</span>
                            </label>
                            <input type="number" 
                                   name="max_score" 
                                   id="max_score" 
                                   value="{{ old('max_score', $assignment->max_score) }}"
                                   min="1" 
                                   max="1000"
                                   class="w-full rounded-lg border px-3 py-2" 
                                   style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                                   required>
                            @error('max_score')
                                <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Current Attachment -->
                    @if($assignment->attachment_path)
                        <div class="border rounded-lg p-4" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.2);">
                            <h4 class="text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">File Lampiran Saat Ini:</h4>
                            <div class="flex items-center justify-between">
                                <a href="{{ Storage::url($assignment->attachment_path) }}" 
                                   target="_blank"
                                   class="inline-flex items-center" style="color: #2563eb;"
                                   onmouseover="this.style.color='#1d4ed8'"
                                   onmouseout="this.style.color='#2563eb'">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    {{ $assignment->attachment_name ?? 'Download File' }}
                                </a>
                                <span class="text-xs" style="color: var(--text-secondary, #6b7280);">
                                    Upload file baru untuk mengganti
                                </span>
                            </div>
                        </div>
                    @endif

                    <!-- File Attachment -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            {{ $assignment->attachment_path ? 'Ganti File Lampiran (Opsional)' : 'File Lampiran (Opsional)' }}
                        </label>
                        <input type="file" 
                               name="attachment" 
                               id="attachment" 
                               class="w-full rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                        <p class="mt-1 text-sm" style="color: var(--text-secondary, #6b7280);">
                            Format yang didukung: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG. Maksimal 10MB.
                            {{ $assignment->attachment_path ? 'File baru akan mengganti file lama.' : '' }}
                        </p>
                        @error('attachment')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            Status Publikasi
                        </label>
                        <select name="status" 
                                id="status" 
                                class="w-full rounded-lg border px-3 py-2" 
                                style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                            <option value="draft" {{ old('status', $assignment->status) == 'draft' ? 'selected' : '' }}>Draft (Belum Dipublikasi)</option>
                            <option value="published" {{ old('status', $assignment->status) == 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                            <option value="active" {{ old('status', $assignment->status) == 'active' ? 'selected' : '' }}>Active (Aktif)</option>
                            <option value="completed" {{ old('status', $assignment->status) == 'completed' ? 'selected' : '' }}>Completed (Selesai)</option>
                        </select>
                        <p class="mt-1 text-sm" style="color: var(--text-secondary, #6b7280);">
                            Draft: Belum terlihat siswa. Published/Active: Terlihat siswa. Completed: Tugas selesai.
                        </p>
                        @error('status')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Warning for submissions -->
                    @if($assignment->submissions->count() > 0)
                        <div class="border rounded-lg p-4" style="background: rgba(245, 158, 11, 0.1); border-color: rgba(245, 158, 11, 0.2);">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5" style="color: #d97706;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-medium" style="color: #92400e;">Perhatian!</h4>
                                    <p class="text-sm mt-1" style="color: #b45309;">
                                        Tugas ini sudah memiliki {{ $assignment->submissions->count() }} pengumpulan. 
                                        Perubahan pada deadline atau nilai maksimal dapat mempengaruhi penilaian yang sudah ada.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-4 border-t" style="background: var(--bg-tertiary, #f9fafb); border-color: var(--border-color, #e5e7eb);">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('teacher.assignments.show', $assignment->id) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Update Tugas
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection