@extends('layouts.student')

@section('title', 'QR Code Absensi Saya')

@push('meta')
    <!-- Cache Busting Meta Tags -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <meta name="student-id" content="{{ $student->id }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <meta name="cache-buster" content="{{ time() }}">
@endpush

@section('content')
    <div class="container mx-auto px-6 py-8">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-3 rounded-xl mr-4">
                        <i class="fas fa-qrcode text-white text-xl"></i>
                    </div>
                    QR Code Absensi Saya
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">Tunjukkan QR Code ini kepada guru untuk absensi</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('student.attendance.history') }}"
                    class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-all duration-200 flex items-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                    <i class="fas fa-history mr-2"></i>Riwayat Lengkap
                </a>
            </div>
        </div>

        <!-- System Update Notice -->
        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-2xl shadow-xl p-6 mb-8">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-3xl mr-4"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold mb-2">📱 Sistem Absensi Terbaru</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <h4 class="font-semibold mb-2">✨ Perubahan Sistem:</h4>
                            <ul class="space-y-1">
                                <li>• Guru yang akan melakukan scan QR Code</li>
                                <li>• Siswa hanya perlu menunjukkan QR Code</li>
                                <li>• Proses absensi lebih terkontrol</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-semibold mb-2">📋 Cara Absensi:</h4>
                            <ul class="space-y-1">
                                <li>• Tunjukkan QR Code di bawah kepada guru</li>
                                <li>• Guru akan scan dengan perangkat mereka</li>
                                <li>• Absensi otomatis tercatat di sistem</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- PKL QR Code Section -->
            @if($pklRegistration && $pklRegistration->qr_image_url)
                <div class="lg:col-span-3">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                        <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                            <h2 class="text-xl font-semibold text-white flex items-center">
                                <i class="fas fa-building mr-3"></i>QR Code PKL - {{ $pklRegistration->tempatPkl->nama_tempat }}
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="text-center">
                                <!-- PKL QR Code Display -->
                                <div class="bg-white p-8 rounded-2xl shadow-lg inline-block mb-6 border-4 border-green-100">
                                    <img src="{{ $pklRegistration->qr_image_url }}" alt="QR Code PKL {{ $student->name }}"
                                        class="w-64 h-64 mx-auto">
                                </div>

                                <!-- PKL Info -->
                                <div
                                    class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6 mb-6">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $student->name }}</h3>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Tempat PKL:</span>
                                            <span
                                                class="font-semibold text-gray-900 dark:text-white">{{ $pklRegistration->tempatPkl->nama_tempat }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Alamat:</span>
                                            <span
                                                class="font-semibold text-gray-900 dark:text-white">{{ $pklRegistration->tempatPkl->alamat }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Kota:</span>
                                            <span
                                                class="font-semibold text-gray-900 dark:text-white">{{ $pklRegistration->tempatPkl->kota ?? 'Tidak ditentukan' }}</span>
                                        </div>
                                    </div>
                                    @if($pklRegistration->tanggal_mulai && $pklRegistration->tanggal_selesai)
                                        <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-600">
                                            <div class="grid grid-cols-2 gap-4 text-sm">
                                                <div>
                                                    <span class="text-gray-600 dark:text-gray-400">Tanggal Mulai:</span>
                                                    <span
                                                        class="font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($pklRegistration->tanggal_mulai)->format('d M Y') }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-600 dark:text-gray-400">Tanggal Selesai:</span>
                                                    <span
                                                        class="font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($pklRegistration->tanggal_selesai)->format('d M Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- PKL QR Code Actions -->
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <button onclick="showPklQrCodeModal()"
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-expand mr-2"></i>Perbesar QR Code PKL
                                    </button>
                                    <a href="{{ $pklRegistration->qr_image_url }}" target="_blank"
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-external-link-alt mr-2"></i>Lihat QR Code
                                    </a>
                                    <button onclick="copyPklQrCode('{{ $pklRegistration->qr_code }}')"
                                        class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-copy mr-2"></i>Salin Kode PKL
                                    </button>
                                </div>

                                <!-- PKL Instructions -->
                                <div
                                    class="mt-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle text-green-600 dark:text-green-400 text-xl mr-3 mt-1"></i>
                                        <div class="text-left">
                                            <h4 class="font-semibold text-green-900 dark:text-green-100 mb-2">Petunjuk
                                                Penggunaan QR Code PKL:</h4>
                                            <ul class="text-sm text-green-800 dark:text-green-200 space-y-1">
                                                <li>• Tunjukkan QR Code ini kepada pembimbing lapangan di tempat PKL</li>
                                                <li>• Pastikan QR Code terlihat jelas dan tidak buram</li>
                                                <li>• QR Code ini khusus untuk absensi PKL Anda</li>
                                                <li>• Simpan atau download QR Code untuk kemudahan akses</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- QR Code Display Section -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4">
                        <h2 class="text-xl font-semibold text-white flex items-center">
                            <i class="fas fa-qrcode mr-3"></i>QR Code Absensi Anda
                        </h2>
                    </div>
                    <div class="p-6">
                        @if($qrAttendance && $qrAttendance->qr_image_url)
                            <div class="text-center">
                                <!-- QR Code Display -->
                                <div class="bg-white p-8 rounded-2xl shadow-lg inline-block mb-6 border-4 border-blue-100">
                                    <img src="{{ $qrAttendance->qr_image_url }}" alt="QR Code {{ $student->name }}"
                                        class="w-64 h-64 mx-auto">
                                </div>

                                <!-- Student Info -->
                                <div
                                    class="bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-xl p-6 mb-6">
                                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $student->name }}</h3>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">NIS:</span>
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $student->nis }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600 dark:text-gray-400">Kelas:</span>
                                            <span class="font-semibold text-gray-900 dark:text-white">
                                                {{ $student->class ? $student->class->name : 'Belum Ditentukan' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- QR Code Actions -->
                                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                    <button onclick="showQrCodeModal()"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-expand mr-2"></i>Perbesar QR Code
                                    </button>
                                    <a href="{{ route('student.attendance.download-qr') }}"
                                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-download mr-2"></i>Download QR Code
                                    </a>
                                    <button onclick="copyQrCode('{{ $qrAttendance->qr_code }}')"
                                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl transition-all duration-200 flex items-center justify-center shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                        <i class="fas fa-copy mr-2"></i>Salin Kode
                                    </button>
                                </div>

                                <!-- Instructions -->
                                <div
                                    class="mt-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4">
                                    <div class="flex items-start">
                                        <i class="fas fa-lightbulb text-yellow-600 dark:text-yellow-400 text-xl mr-3 mt-1"></i>
                                        <div class="text-left">
                                            <h4 class="font-semibold text-yellow-900 dark:text-yellow-100 mb-2">Petunjuk
                                                Penggunaan:</h4>
                                            <ul class="text-sm text-yellow-800 dark:text-yellow-200 space-y-1">
                                                <li>• Tunjukkan QR Code ini kepada guru saat absensi</li>
                                                <li>• Pastikan QR Code terlihat jelas dan tidak buram</li>
                                                <li>• Jangan berbagi QR Code dengan siswa lain</li>
                                                <li>• Simpan atau download QR Code untuk kemudahan akses</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- No QR Code Available -->
                            <div class="text-center py-8">
                                <div
                                    class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl p-8">
                                    <i class="fas fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
                                    <h3 class="text-xl font-bold text-red-900 dark:text-red-100 mb-2">QR Code Belum Tersedia
                                    </h3>
                                    <p class="text-red-700 dark:text-red-300 mb-4">
                                        QR Code absensi Anda belum dibuat oleh administrator.
                                    </p>
                                    <div
                                        class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-2">Langkah Selanjutnya:
                                        </h4>
                                        <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1">
                                            <li>• Hubungi guru atau administrator sekolah</li>
                                            <li>• Minta untuk dibuatkan QR Code absensi</li>
                                            <li>• QR Code akan muncul di halaman ini setelah dibuat</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Today's Attendance Status -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Status Absensi Hari Ini</h3>
                    </div>
                    <div class="p-6">
                        @if($todayAttendance)
                            <div class="text-center">
                                @php
                                    $iconColor = match ($todayAttendance->status) {
                                        'hadir' => 'text-emerald-500',
                                        'terlambat' => 'text-yellow-500',
                                        'izin' => 'text-blue-500',
                                        'sakit' => 'text-purple-500',
                                        default => 'text-red-500'
                                    };
                                    $badgeColor = match ($todayAttendance->status) {
                                        'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                        'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                        'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                        'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                        default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                    };
                                @endphp
                                <i class="fas fa-check-circle text-4xl {{ $iconColor }} mb-3"></i>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Sudah Absen</h4>
                                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                                    {{ $todayAttendance->status_text }}
                                </span>
                                <div class="mt-4 space-y-2 text-sm text-gray-600 dark:text-gray-400">
                                    <p><i class="fas fa-clock mr-2"></i>{{ $todayAttendance->scan_time->format('H:i:s') }}</p>
                                    <p><i class="fas fa-map-marker-alt mr-2"></i>{{ $todayAttendance->location ?? 'Sekolah' }}
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="text-center">
                                <i class="fas fa-clock text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-2">Belum Absen</h4>
                                <p class="text-gray-600 dark:text-gray-400 text-sm">
                                    Tunjukkan QR Code Anda kepada guru untuk melakukan absensi
                                </p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Monthly Statistics -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-pink-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Statistik Bulan Ini</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                <div class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">
                                    {{ $monthlyStats['hadir'] ?? 0 }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Hadir</div>
                            </div>
                            <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl">
                                <div class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $monthlyStats['terlambat'] ?? 0 }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Terlambat</div>
                            </div>
                            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                    {{ ($monthlyStats['izin'] ?? 0) + ($monthlyStats['sakit'] ?? 0) }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Izin/Sakit</div>
                            </div>
                            <div class="text-center p-4 bg-red-50 dark:bg-red-900/20 rounded-xl">
                                <div class="text-2xl font-bold text-red-600 dark:text-red-400">
                                    {{ $monthlyStats['alpha'] ?? 0 }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Alpha</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Attendance -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-blue-600 px-6 py-4">
                        <h3 class="text-lg font-semibold text-white">Absensi Terakhir</h3>
                    </div>
                    <div class="p-6">
                        @forelse($recentAttendance->take(5) as $attendance)
                            <div
                                class="flex justify-between items-center py-3 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                <div>
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $attendance->attendance_date->format('d/m/Y') }}
                                    </div>
                                    @php
                                        $badgeColor = match ($attendance->status) {
                                            'hadir' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200',
                                            'terlambat' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'izin' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'sakit' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            default => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200'
                                        };
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded-full {{ $badgeColor }}">
                                        {{ $attendance->status_text }}
                                    </span>
                                </div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">
                                    {{ $attendance->scan_time->format('H:i') }}
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-calendar-times text-4xl text-gray-400 dark:text-gray-500 mb-3"></i>
                                <p class="text-gray-500 dark:text-gray-400">Belum ada data absensi</p>
                            </div>
                        @endforelse

                        @if($recentAttendance->count() > 5)
                            <div class="mt-4 text-center">
                                <a href="{{ route('student.attendance.history') }}"
                                    class="text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300 text-sm font-medium">
                                    Lihat Semua Riwayat →
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div id="qrCodeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
        onclick="closeQrModal()">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4"
            onclick="event.stopPropagation()">
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-white">QR Code Absensi</h3>
                    <button onclick="closeQrModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 text-center">
                @if($qrAttendance && $qrAttendance->qr_image_url)
                    <img src="{{ $qrAttendance->qr_image_url }}" alt="QR Code {{ $student->name }}"
                        class="w-80 h-80 mx-auto mb-4 rounded-lg">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $student->name }}</h4>
                    <p class="text-gray-600 dark:text-gray-400">NIS: {{ $student->nis }} | Kelas:
                        {{ $student->class ? $student->class->name : 'Belum Ditentukan' }}
                    </p>
                @endif
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closeQrModal()"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Tutup
                </button>
                <a href="{{ route('student.attendance.download-qr') }}"
                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                    <i class="fas fa-download mr-2"></i>Download
                </a>
            </div>
        </div>
    </div>

    <!-- PKL QR Code Modal -->
    <div id="pklQrCodeModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
        onclick="closePklQrModal()">
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl max-w-md w-full mx-4"
            onclick="event.stopPropagation()">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4 rounded-t-2xl">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-semibold text-white">QR Code PKL</h3>
                    <button onclick="closePklQrModal()" class="text-white hover:text-gray-200 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 text-center">
                @if($pklRegistration && $pklRegistration->qr_image_url)
                    <img src="{{ $pklRegistration->qr_image_url }}" alt="QR Code PKL {{ $student->name }}"
                        class="w-80 h-80 mx-auto mb-4 rounded-lg">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $student->name }}</h4>
                    <p class="text-gray-600 dark:text-gray-400 mb-2">{{ $pklRegistration->tempatPkl->nama_tempat }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pklRegistration->tempatPkl->alamat }}</p>
                @endif
            </div>
            <div class="px-6 pb-6 flex gap-3">
                <button onclick="closePklQrModal()"
                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    Tutup
                </button>
                <a href="{{ $pklRegistration->qr_image_url ?? '#' }}" target="_blank"
                    class="flex-1 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-center">
                    <i class="fas fa-external-link-alt mr-2"></i>Lihat
                </a>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Show QR Code Modal
        function showQrCodeModal() {
            document.getElementById('qrCodeModal').classList.remove('hidden');
            document.getElementById('qrCodeModal').classList.add('flex');
        }

        // Close QR Code Modal
        function closeQrModal() {
            document.getElementById('qrCodeModal').classList.add('hidden');
            document.getElementById('qrCodeModal').classList.remove('flex');
        }

        // Show PKL QR Code Modal
        function showPklQrCodeModal() {
            document.getElementById('pklQrCodeModal').classList.remove('hidden');
            document.getElementById('pklQrCodeModal').classList.add('flex');
        }

        // Close PKL QR Code Modal
        function closePklQrModal() {
            document.getElementById('pklQrCodeModal').classList.add('hidden');
            document.getElementById('pklQrCodeModal').classList.remove('flex');
        }

        // Copy QR Code to clipboard
        function copyQrCode(qrCode) {
            if (navigator.clipboard && window.isSecureContext) {
                // Use modern clipboard API
                navigator.clipboard.writeText(qrCode).then(() => {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kode QR berhasil disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }).catch(err => {
                    console.error('Failed to copy QR code:', err);
                    fallbackCopyQrCode(qrCode);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyQrCode(qrCode);
            }
        }

        // Copy PKL QR Code to clipboard
        function copyPklQrCode(qrCode) {
            if (navigator.clipboard && window.isSecureContext) {
                // Use modern clipboard API
                navigator.clipboard.writeText(qrCode).then(() => {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kode QR PKL berhasil disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }).catch(err => {
                    console.error('Failed to copy PKL QR code:', err);
                    fallbackCopyPklQrCode(qrCode);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyPklQrCode(qrCode);
            }
        }

        // Fallback copy method for older browsers
        function fallbackCopyQrCode(qrCode) {
            try {
                // Create temporary textarea
                const textArea = document.createElement('textarea');
                textArea.value = qrCode;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                // Try to copy
                const successful = document.execCommand('copy');
                document.body.removeChild(textArea);

                if (successful) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kode QR berhasil disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    throw new Error('Copy command failed');
                }
            } catch (err) {
                console.error('Fallback copy failed:', err);
                // Show manual copy dialog
                Swal.fire({
                    icon: 'info',
                    title: 'Salin Manual',
                    html: `
                    <p class="mb-3">Silakan salin kode QR berikut secara manual:</p>
                    <div class="bg-gray-100 border rounded p-3 text-left">
                        <code class="text-sm break-all">${qrCode}</code>
                    </div>
                `,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3b82f6'
                });
            }
        }

        // Fallback copy method for PKL QR code in older browsers
        function fallbackCopyPklQrCode(qrCode) {
            try {
                // Create temporary textarea
                const textArea = document.createElement('textarea');
                textArea.value = qrCode;
                textArea.style.position = 'fixed';
                textArea.style.left = '-999999px';
                textArea.style.top = '-999999px';
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();

                // Try to copy
                const successful = document.execCommand('copy');
                document.body.removeChild(textArea);

                if (successful) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Kode QR PKL berhasil disalin ke clipboard',
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    throw new Error('Copy command failed');
                }
            } catch (err) {
                console.error('Fallback PKL copy failed:', err);
                // Show manual copy dialog
                Swal.fire({
                    icon: 'info',
                    title: 'Salin Manual Kode PKL',
                    html: `
                    <p class="mb-3">Silakan salin kode QR PKL berikut secara manual:</p>
                    <div class="bg-gray-100 border rounded p-3 text-left">
                        <code class="text-sm break-all">${qrCode}</code>
                    </div>
                `,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#10b981'
                });
            }
        }

        // Auto-refresh page every 5 minutes to check for attendance updates
        setInterval(function () {
            // Only refresh if no modal is open
            if (!document.getElementById('qrCodeModal').classList.contains('flex')) {
                location.reload();
            }
        }, 300000); // 5 minutes

        // Show success message if redirected from old scanner
        if (window.location.search.includes('from=scanner')) {
            Swal.fire({
                icon: 'info',
                title: 'Sistem Absensi Diperbarui!',
                html: `
                            <div class="text-left">
                                <p class="mb-3">Sistem absensi telah diperbarui:</p>
                                <ul class="text-sm space-y-1 mb-3">
                                    <li>• Guru yang akan melakukan scan QR Code</li>
                                    <li>• Siswa hanya perlu menunjukkan QR Code</li>
                                    <li>• Proses absensi lebih terkontrol</li>
                                </ul>
                                <p class="text-blue-600 font-semibold">Tunjukkan QR Code di bawah kepada guru untuk absensi!</p>
                            </div>
                        `,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#3b82f6'
            });
        }
    </script>
@endpush