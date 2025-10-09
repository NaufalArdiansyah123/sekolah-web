@extends('layouts.teacher')

@section('content')
<div class="min-h-screen" style="background: var(--bg-primary, #ffffff);">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2" style="color: var(--text-primary, #111827);">
                        📝 Buat Tugas Baru
                    </h1>
                    <p style="color: var(--text-secondary, #6b7280);">
                        Buat tugas baru untuk siswa Anda
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

        <!-- Form -->
        <div class="rounded-xl shadow-sm border overflow-hidden" style="background: var(--bg-secondary, #ffffff); border-color: var(--border-color, #e5e7eb);">
            <form action="{{ route('teacher.assignments.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="p-6 border-b" style="border-color: var(--border-color, #e5e7eb);">
                    <h2 class="text-xl font-semibold" style="color: var(--text-primary, #111827);">Informasi Tugas</h2>
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
                               value="{{ old('title') }}"
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
                                   value="{{ old('subject') }}"
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
                                    <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
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
                                <option value="homework" {{ old('type') == 'homework' ? 'selected' : '' }}>Pekerjaan Rumah</option>
                                <option value="project" {{ old('type') == 'project' ? 'selected' : '' }}>Proyek</option>
                                <option value="essay" {{ old('type') == 'essay' ? 'selected' : '' }}>Esai</option>
                                <option value="quiz" {{ old('type') == 'quiz' ? 'selected' : '' }}>Kuis</option>
                                <option value="presentation" {{ old('type') == 'presentation' ? 'selected' : '' }}>Presentasi</option>
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
                                  required>{{ old('description') }}</textarea>
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
                                  placeholder="Berikan instruksi khusus jika diperlukan...">{{ old('instructions') }}</textarea>
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
                                   value="{{ old('due_date') }}"
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
                                   value="{{ old('max_score', 100) }}"
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

                    <!-- File Attachment -->
                    <div>
                        <label for="attachment" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                            File Lampiran (Opsional)
                        </label>
                        <input type="file" 
                               name="attachment" 
                               id="attachment" 
                               class="w-full rounded-lg border px-3 py-2" 
                               style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                               accept=".pdf,.doc,.docx,.txt,.jpg,.jpeg,.png">
                        <p class="mt-1 text-sm" style="color: var(--text-secondary, #6b7280);">
                            Format yang didukung: PDF, DOC, DOCX, TXT, JPG, JPEG, PNG. Maksimal 10MB.
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
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft (Belum Dipublikasi)</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published (Langsung Terbit)</option>
                        </select>
                        <p class="mt-1 text-sm" style="color: var(--text-secondary, #6b7280);">
                            Draft: Tugas disimpan tapi belum terlihat siswa. Published: Tugas langsung terlihat siswa.
                        </p>
                        @error('status')
                            <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <!-- Footer -->
                <div class="px-6 py-4 border-t" style="background: var(--bg-tertiary, #f9fafb); border-color: var(--border-color, #e5e7eb);">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('teacher.assignments.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Batal
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            Simpan Tugas
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set minimum date to current date
document.addEventListener('DOMContentLoaded', function() {
    const dueDateInput = document.getElementById('due_date');
    const now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    dueDateInput.min = now.toISOString().slice(0, 16);
});
</script>
@endsection