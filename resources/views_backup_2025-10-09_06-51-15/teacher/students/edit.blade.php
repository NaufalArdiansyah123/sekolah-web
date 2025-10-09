@extends('layouts.teacher')

@section('title', 'Edit Student')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-sm border p-6 mb-6" style="border-color: var(--border-color, #e5e7eb);">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color: var(--text-primary, #111827);">Edit Student</h1>
                <p class="mt-1" style="color: var(--text-secondary, #6b7280);">Update student information</p>
            </div>
            <a href="{{ route('teacher.students.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Students
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border p-6" style="border-color: var(--border-color, #e5e7eb);">
        <form action="{{ route('teacher.students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- NIS -->
                <div>
                    <label for="nis" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        NIS <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nis" id="nis" value="{{ old('nis', $student->nis) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan NIS">
                    @error('nis')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $student->name) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Class -->
                <div>
                    <label for="class_id" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Class <span class="text-red-500">*</span>
                    </label>
                    <select name="class_id" id="class_id" required
                            class="w-full rounded-lg border px-3 py-2" 
                            style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Select Class</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                                {{ $class->level }} {{ $class->name }} @if($class->program) - {{ $class->program }} @endif
                            </option>
                        @endforeach
                    </select>
                    @error('class_id')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label for="gender" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Gender <span class="text-red-500">*</span>
                    </label>
                    <select name="gender" id="gender" required
                            class="w-full rounded-lg border px-3 py-2" 
                            style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Select Gender</option>
                        <option value="L" {{ old('gender', $student->gender) == 'L' ? 'selected' : '' }}>Male</option>
                        <option value="P" {{ old('gender', $student->gender) == 'P' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Date -->
                <div>
                    <label for="birth_date" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Birth Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $student->birth_date ? $student->birth_date->format('Y-m-d') : '') }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                    @error('birth_date')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Birth Place -->
                <div>
                    <label for="birth_place" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Birth Place <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place', $student->birth_place) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan tempat lahir">
                    @error('birth_place')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $student->email) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan alamat email">
                    @error('email')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Phone <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $student->phone) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan nomor telepon">
                    @error('phone')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Religion -->
                <div>
                    <label for="religion" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Religion <span class="text-red-500">*</span>
                    </label>
                    <select name="religion" id="religion" required
                            class="w-full rounded-lg border px-3 py-2" 
                            style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                        <option value="">Select Religion</option>
                        @foreach($religions as $religion)
                            <option value="{{ $religion }}" {{ old('religion', $student->religion) == $religion ? 'selected' : '' }}>
                                {{ $religion }}
                            </option>
                        @endforeach
                    </select>
                    @error('religion')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Name -->
                <div>
                    <label for="parent_name" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Parent Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="parent_name" id="parent_name" value="{{ old('parent_name', $student->parent_name) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan nama orang tua">
                    @error('parent_name')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parent Phone -->
                <div>
                    <label for="parent_phone" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Parent Phone <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="parent_phone" id="parent_phone" value="{{ old('parent_phone', $student->parent_phone) }}" required
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                           placeholder="Masukkan nomor telepon orang tua">
                    @error('parent_phone')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Address <span class="text-red-500">*</span>
                    </label>
                    <textarea name="address" id="address" rows="3" required
                              class="w-full rounded-lg border px-3 py-2" 
                              style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);"
                              placeholder="Masukkan alamat lengkap">{{ old('address', $student->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Current Photo -->
                @if($student->photo)
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        Current Photo
                    </label>
                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Student Photo" class="w-32 h-32 object-cover rounded-lg">
                </div>
                @endif

                <!-- Photo -->
                <div class="md:col-span-2">
                    <label for="photo" class="block text-sm font-medium mb-2" style="color: var(--text-primary, #374151);">
                        {{ $student->photo ? 'Update Photo' : 'Photo' }}
                    </label>
                    <input type="file" name="photo" id="photo" accept="image/*"
                           class="w-full rounded-lg border px-3 py-2" 
                           style="border-color: var(--border-color, #d1d5db); background: var(--bg-primary, #ffffff); color: var(--text-primary, #111827);">
                    <p class="mt-1 text-xs" style="color: var(--text-secondary, #6b7280);">
                        Optional. Max file size: 2MB. Supported formats: JPG, PNG, JPEG
                    </p>
                    @error('photo')
                        <p class="mt-1 text-sm" style="color: #dc2626;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <a href="{{ route('teacher.students.index') }}" 
                   class="px-6 py-2 border rounded-lg transition-colors duration-200" 
                   style="border-color: var(--border-color, #d1d5db); color: var(--text-primary, #374151);"
                   onmouseover="this.style.background='var(--bg-tertiary, #f9fafb)'"
                   onmouseout="this.style.background='transparent'">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors duration-200">
                    Update Student
                </button>
            </div>
        </form>
    </div>
</div>
@endsection