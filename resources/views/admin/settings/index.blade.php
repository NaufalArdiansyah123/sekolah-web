{{-- resources/views/admin/settings/index.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'System Settings')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">System Settings</h1>
            <p class="text-gray-600 mt-2">Kelola pengaturan sistem dan konfigurasi website</p>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- General Settings -->
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Pengaturan Umum</h2>
                </div>
                <div class="px-6 py-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Website
                            </label>
                            <input type="text" 
                                   name="site_name" 
                                   id="site_name" 
                                   value="{{ $settings['site_name']->value ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="site_email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email Website
                            </label>
                            <input type="email" 
                                   name="site_email" 
                                   id="site_email" 
                                   value="{{ $settings['site_email']->value ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div>
                        <label for="site_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Website
                        </label>
                        <textarea name="site_description" 
                                  id="site_description" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ $settings['site_description']->value ?? '' }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <input type="text" 
                                   name="site_phone" 
                                   id="site_phone" 
                                   value="{{ $settings['site_phone']->value ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label for="site_address" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat
                            </label>
                            <input type="text" 
                                   name="site_address" 
                                   id="site_address" 
                                   value="{{ $settings['site_address']->value ?? '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="site_logo" class="block text-sm font-medium text-gray-700 mb-2">
                                Logo Website
                            </label>
                            <input type="file" 
                                   name="site_logo" 
                                   id="site_logo" 
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @if(isset($settings['site_logo']) && $settings['site_logo']->value)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['site_logo']->value) }}" 
                                         alt="Current Logo" 
                                         class="h-12 w-auto">
                                </div>
                            @endif
                        </div>

                        <div>
                            <label for="site_favicon" class="block text-sm font-medium text-gray-700 mb-2">
                                Favicon
                            </label>
                            <input type="file" 
                                   name="site_favicon" 
                                   id="site_favicon" 
                                   accept="image/x-icon,image/png"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            @if(isset($settings['site_favicon']) && $settings['site_favicon']->value)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $settings['site_favicon']->value) }}" 
                                         alt="Current Favicon" 
                                         class="h-8 w-8">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 flex justify-end space-x-3">
                    <button type="button" 
                            onclick="window.location.reload()"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                        Reset
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        Simpan Pengaturan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- resources/views/admin/profile/index.blade.php --}}
@extends('layouts.admin.app')

@section('title', 'Profile')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Profile</h1>
            <p class="text-gray-600 mt-2">Kelola informasi akun Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Picture -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Foto Profile</h2>
                </div>
                <div class="px-6 py-6 text-center">
                    <div class="mb-4">
                        @if($user->avatar)
                            <img class="mx-auto h-32 w-32 rounded-full object-cover" 
                                 src="{{ asset('storage/' . $user->avatar) }}" 
                                 alt="{{ $user->name }}">
                        @else
                            <div class="mx-auto h-32 w-32 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-3xl font-bold text-blue-600">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    @if($user->roles->count() > 0)
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 mt-2">
                            {{ $user->roles->first()->name }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Profile Form -->
            <div class="lg:col-span-2">
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <!-- Basic Information -->
                    <div class="bg-white shadow rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Dasar</h2>
                        </div>
                        <div class="px-6 py-6 space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap
                                </label>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name', $user->name) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Email
                                </label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email', $user->email) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon
                                    </label>
                                    <input type="text" 
                                           name="phone" 
                                           id="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">
                                        Foto Profile
                                    </label>
                                    <input type="file" 
                                           name="avatar" 
                                           id="avatar" 
                                           accept="image/*"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>

                            <div>
                                <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat
                                </label>
                                <textarea name="address" 
                                          id="address" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div>
                                <label for="bio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bio
                                </label>
                                <textarea name="bio" 
                                          id="bio" 
                                          rows="4"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Ceritakan sedikit tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Change Password -->
                    <div class="bg-white shadow rounded-lg mb-6">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Ubah Password</h2>
                            <p class="text-sm text-gray-600 mt-1">Kosongkan jika tidak ingin mengubah password</p>
                        </div>
                        <div class="px-6 py-6 space-y-6">
                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Password Saat Ini
                                </label>
                                <input type="password" 
                                       name="current_password" 
                                       id="current_password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('current_password') border-red-500 @enderror">
                                @error('current_password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                        Password Baru
                                    </label>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror">
                                    @error('password')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                        Konfirmasi Password Baru
                                    </label>
                                    <input type="password" 
                                           name="password_confirmation" 
                                           id="password_confirmation" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 flex justify-end space-x-3">
                            <button type="button" 
                                    onclick="window.location.reload()"
                                    class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                Reset
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection