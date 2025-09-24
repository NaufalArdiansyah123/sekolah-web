@extends('layouts.student')

@section('title', 'Error - QR Scanner Absensi')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Error Header -->
    <div class="text-center mb-8">
        <div class="bg-red-100 dark:bg-red-900/20 rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-4xl text-red-600 dark:text-red-400"></i>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
            Terjadi Kesalahan
        </h1>
        <p class="text-gray-600 dark:text-gray-400">
            {{ $error_message }}
        </p>
    </div>

    <!-- Error Details -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
            <div class="bg-red-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-bug mr-3"></i>Detail Error
                </h2>
            </div>
            <div class="p-6">
                @if($error_type === 'student_not_found')
                    <div class="space-y-4">
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4">
                            <h3 class="font-semibold text-yellow-800 dark:text-yellow-200 mb-2">
                                <i class="fas fa-user-times mr-2"></i>Data Siswa Tidak Ditemukan
                            </h3>
                            <p class="text-yellow-700 dark:text-yellow-300 text-sm">
                                Akun Anda tidak terhubung dengan data siswa. Hal ini bisa terjadi karena:
                            </p>
                            <ul class="list-disc list-inside text-yellow-700 dark:text-yellow-300 text-sm mt-2 space-y-1">
                                <li>Akun belum disetup dengan benar oleh administrator</li>
                                <li>Data siswa belum dibuat atau terhubung dengan akun Anda</li>
                                <li>Terjadi masalah pada database</li>
                            </ul>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                <i class="fas fa-tools mr-2"></i>Langkah Penyelesaian
                            </h3>
                            <ol class="list-decimal list-inside text-blue-700 dark:text-blue-300 text-sm space-y-1">
                                <li>Hubungi administrator sekolah</li>
                                <li>Berikan informasi akun Anda (email: {{ auth()->user()->email }})</li>
                                <li>Minta administrator untuk menghubungkan akun dengan data siswa</li>
                                <li>Coba login ulang setelah masalah diperbaiki</li>
                            </ol>
                        </div>
                    </div>
                @elseif($error_type === 'system_error')
                    <div class="space-y-4">
                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4">
                            <h3 class="font-semibold text-red-800 dark:text-red-200 mb-2">
                                <i class="fas fa-server mr-2"></i>Kesalahan Sistem
                            </h3>
                            <p class="text-red-700 dark:text-red-300 text-sm">
                                Terjadi kesalahan pada sistem. Silakan coba beberapa langkah berikut:
                            </p>
                        </div>

                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200 mb-2">
                                <i class="fas fa-tools mr-2"></i>Langkah Penyelesaian
                            </h3>
                            <ol class="list-decimal list-inside text-blue-700 dark:text-blue-300 text-sm space-y-1">
                                <li>Refresh halaman ini</li>
                                <li>Logout dan login kembali</li>
                                <li>Bersihkan cache browser</li>
                                <li>Coba akses dari browser yang berbeda</li>
                                <li>Jika masih bermasalah, hubungi administrator</li>
                            </ol>
                        </div>
                    </div>
                @endif

                <!-- Debug Information (only show in development) -->
                @if(config('app.debug') && isset($debug_info))
                    <div class="mt-6 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">
                            <i class="fas fa-code mr-2"></i>Debug Information
                        </h3>
                        <pre class="text-xs text-gray-600 dark:text-gray-400 overflow-x-auto">{{ json_encode($debug_info, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="location.reload()" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-redo mr-2"></i>Refresh Halaman
            </button>
            
            <a href="{{ route('student.dashboard') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
            </a>
            
            <button onclick="logout()" 
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout & Login Ulang
            </button>
        </div>

        <!-- Contact Information -->
        <div class="mt-8 text-center">
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 border border-gray-200 dark:border-gray-700">
                <h3 class="font-semibold text-gray-800 dark:text-gray-200 mb-2">
                    <i class="fas fa-phone mr-2"></i>Butuh Bantuan?
                </h3>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3">
                    Jika masalah ini terus berlanjut, silakan hubungi administrator sekolah:
                </p>
                <div class="space-y-2 text-sm">
                    <div class="text-gray-700 dark:text-gray-300">
                        <i class="fas fa-envelope mr-2"></i>
                        Email: admin@sekolah.sch.id
                    </div>
                    <div class="text-gray-700 dark:text-gray-300">
                        <i class="fas fa-phone mr-2"></i>
                        Telepon: (021) 123-4567
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function logout() {
    if (confirm('Apakah Anda yakin ingin logout dan login ulang?')) {
        // Create a form to submit logout
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("logout") }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        form.appendChild(csrfToken);
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-refresh every 30 seconds if it's a system error
@if($error_type === 'system_error')
    let autoRefreshTimer = setTimeout(function() {
        if (confirm('Halaman akan di-refresh otomatis. Lanjutkan?')) {
            location.reload();
        }
    }, 30000);
    
    // Clear timer if user interacts with page
    document.addEventListener('click', function() {
        clearTimeout(autoRefreshTimer);
    });
@endif
</script>
@endsection