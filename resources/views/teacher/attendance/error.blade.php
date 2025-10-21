@extends('layouts.teacher')

@section('title', 'Error - QR Scanner')

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
            Maaf, terjadi kesalahan saat memuat halaman QR Scanner
        </p>
    </div>

    <!-- Error Details -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="bg-red-50 dark:bg-red-900/20 px-6 py-4 border-b border-red-200 dark:border-red-800">
                <h2 class="text-xl font-semibold text-red-900 dark:text-red-100 flex items-center">
                    <i class="fas fa-bug mr-3"></i>Detail Error
                </h2>
            </div>
            <div class="p-6">
                @if(isset($error_type))
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Jenis Error:</h3>
                        <p class="text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                            {{ ucfirst(str_replace('_', ' ', $error_type)) }}
                        </p>
                    </div>
                @endif

                @if(isset($error_message))
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Pesan Error:</h3>
                        <p class="text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-lg">
                            {{ $error_message }}
                        </p>
                    </div>
                @endif

                <!-- Common Solutions -->
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Solusi yang Dapat Dicoba:</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">1</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Refresh halaman dan coba lagi</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">2</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Pastikan koneksi internet stabil</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">3</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Logout dan login kembali</p>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 dark:bg-blue-900/20 rounded-full flex items-center justify-center mr-3 mt-0.5">
                                <span class="text-blue-600 dark:text-blue-400 text-sm font-semibold">4</span>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300">Hubungi administrator jika masalah berlanjut</p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="location.reload()" 
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-sync-alt mr-2"></i>Refresh Halaman
                    </button>
                    <a href="{{ route('teacher.attendance.index') }}" 
                       class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-list mr-2"></i>Kelola Absensi Manual
                    </a>
                    <a href="{{ route('teacher.dashboard') }}" 
                       class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg transition-colors duration-200 flex items-center justify-center">
                        <i class="fas fa-home mr-2"></i>Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Debug Information (only for development) -->
        @if(config('app.debug') && isset($debug_info))
            <div class="mt-6 bg-gray-100 dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="bg-gray-200 dark:bg-gray-700 px-6 py-4 border-b border-gray-300 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                        <i class="fas fa-code mr-3"></i>Debug Information
                        <span class="ml-2 text-xs bg-yellow-100 dark:bg-yellow-900/20 text-yellow-800 dark:text-yellow-200 px-2 py-1 rounded">Development Only</span>
                    </h3>
                </div>
                <div class="p-6">
                    <pre class="text-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-900 p-4 rounded-lg overflow-x-auto">{{ json_encode($debug_info, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        @endif

        <!-- Alternative Access Methods -->
        <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 p-6">
            <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-4 flex items-center">
                <i class="fas fa-lightbulb mr-3"></i>Metode Alternatif
            </h3>
            <p class="text-blue-800 dark:text-blue-200 mb-4">
                Jika QR Scanner tidak dapat diakses, Anda masih dapat mengelola absensi dengan cara berikut:
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('teacher.attendance.index') }}" 
                   class="bg-white dark:bg-gray-800 border border-blue-200 dark:border-blue-700 rounded-lg p-4 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="bg-blue-100 dark:bg-blue-900/20 rounded-lg p-3 mr-4">
                            <i class="fas fa-edit text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Absensi Manual</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Input absensi secara manual</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('teacher.attendance.monthly-report') }}" 
                   class="bg-white dark:bg-gray-800 border border-blue-200 dark:border-blue-700 rounded-lg p-4 hover:bg-blue-50 dark:hover:bg-blue-900/10 transition-colors duration-200">
                    <div class="flex items-center">
                        <div class="bg-green-100 dark:bg-green-900/20 rounded-lg p-3 mr-4">
                            <i class="fas fa-chart-bar text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900 dark:text-white">Laporan Absensi</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Lihat laporan bulanan</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Auto refresh after 30 seconds if user doesn't take action
setTimeout(function() {
    if (confirm('Halaman akan di-refresh otomatis. Apakah Anda ingin melanjutkan?')) {
        location.reload();
    }
}, 30000);

// Log error for debugging
console.error('Teacher QR Scanner Error:', {
    error_type: '{{ $error_type ?? "unknown" }}',
    error_message: '{{ $error_message ?? "No message" }}',
    timestamp: new Date().toISOString(),
    user_agent: navigator.userAgent,
    url: window.location.href
});
</script>
@endpush